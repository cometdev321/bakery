<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';  // Assuming this includes the DB connection

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get the raw POST data (JSON)
$input = json_decode(file_get_contents('php://input'), true);
error_log("Raw input input: " . print_r($input, true));  // Log input for debugging

// Ensure that input contains the necessary fields
$deliveryId = isset($input['delivery_id']) ? $input['delivery_id'] : null;
$lineManId = isset($input['line_man_id']) ? $input['line_man_id'] : null;
$products = isset($input['products']) ? $input['products'] : null;

// Check for missing fields
if (empty($deliveryId) || empty($lineManId) || empty($products)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

try {
    // Begin transaction to ensure atomic operations
    $conn->beginTransaction();

    // Update the delivery details
    $updateDelivery = "UPDATE deliveries SET line_man_id = :lineManId WHERE id = :deliveryId";
    $stmt = $conn->prepare($updateDelivery);
    
    if ($stmt === false) {
        throw new Exception('Failed to prepare the query.');
    }

    $stmt->bindParam(':lineManId', $lineManId, PDO::PARAM_INT);
    $stmt->bindParam(':deliveryId', $deliveryId, PDO::PARAM_INT);
    if ($stmt->execute() === false) {
        throw new Exception('Failed to execute the update.');
    }

    // Delete old products associated with the delivery
    $deleteProducts = "DELETE FROM delivery_products WHERE delivery_id = :deliveryId";
    $stmt = $conn->prepare($deleteProducts);
    
    if ($stmt === false) {
        throw new Exception('Failed to prepare delete query.');
    }

    $stmt->bindParam(':deliveryId', $deliveryId, PDO::PARAM_INT);
    if ($stmt->execute() === false) {
        throw new Exception('Failed to execute the delete.');
    }

    // Insert updated products into the delivery_products table
    $insertProduct = "INSERT INTO delivery_products (delivery_id, product_id, quantity) VALUES (:deliveryId, :productId, :quantity)";
    $stmt = $conn->prepare($insertProduct);
    
    if ($stmt === false) {
        throw new Exception('Failed to prepare insert query.');
    }

    foreach ($products as $product) {
        $stmt->bindParam(':deliveryId', $deliveryId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $product['id'], PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $product['quantity'], PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            throw new Exception('Failed to insert product data.');
        }
    }

    // Commit the transaction if all operations were successful
    $conn->commit();

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Delivery updated successfully.']);

} catch (Exception $e) {
    // Rollback the transaction if there was an error
    $conn->rollback();

    // Return failure response with error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
