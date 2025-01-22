<?php
// assign_product.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$response = ["message" => ""];

try {
    // Get the raw POST data
    $rawInput = file_get_contents("php://input");

    // Log the raw input for debugging
    error_log("Raw POST input: " . $rawInput);

    // Decode the JSON input
    $data = json_decode($rawInput, true);

    // Check for JSON decoding errors
    if ($data === null) {
        $jsonError = json_last_error_msg();
        error_log("JSON decode error: " . $jsonError);

        http_response_code(400);
        echo json_encode(["message" => "Invalid JSON format: " . $jsonError]);
        exit;
    }

    // Validate required fields
    if (!isset($data['line_man_id']) || !isset($data['products']) || !is_array($data['products'])) {
        http_response_code(400);
        echo json_encode(["message" => "Missing or invalid fields: 'line_man_id' or 'products'"]);
        exit;
    }

    // Extract line_man_id and products
    $lineManId = $data['line_man_id'];
    $products = $data['products'];

    // Validate line man ID
    $query = "SELECT id FROM line_men WHERE id = :lineManId AND status = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':lineManId', $lineManId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["message" => "Line man not found or inactive."]);
        exit;
    }

    // Insert into deliveries table
    $query = "INSERT INTO deliveries (line_man_id, delivered_at) VALUES (:lineManId, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':lineManId', $lineManId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(["message" => "Failed to create delivery record."]);
        exit;
    }

    // Fetch the newly created delivery ID
    $deliveryId = $conn->lastInsertId();

    // Process each product
    // Process each product
    foreach ($products as $product) {
        // Validate product structure
        if (!isset($product['id']) || !isset($product['quantity'])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid product data. Each product must have 'id' and 'quantity'."]);
            exit;
        }

        $productId = $product['id'];
        $quantity = $product['quantity'];

        // Check product and stock availability
        $query = "SELECT stock FROM products WHERE id = :productId AND status = 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(["message" => "Product not found or inactive."]);
            exit;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['stock'] < $quantity) {
            http_response_code(400);
            echo json_encode(["message" => "Insufficient stock for product ID: $productId."]);
            exit;
        }

        // Insert into delivery_products table
        $query = "INSERT INTO delivery_products (delivery_id, product_id, quantity) VALUES (:deliveryId, :productId, :quantity)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':deliveryId', $deliveryId, PDO::PARAM_INT);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(["message" => "Failed to assign product ID: $productId."]);
            exit;
        }

        // Update stock in products table
        $query = "UPDATE products SET stock = stock - :quantity WHERE id = :productId";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(["message" => "Failed to update stock for product ID: $productId."]);
            exit;
        }

        // Insert into delivery_product_updates to track the delivery modification
        $query = "INSERT INTO delivery_product_updates (delivery_id, product_id, original_quantity, updated_quantity, line_man_id, delivery_status)
                VALUES (:deliveryId, :productId, :originalQuantity, :updatedQuantity, :lineManId, :deliveryStatus)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':deliveryId', $deliveryId, PDO::PARAM_INT);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':originalQuantity', $quantity, PDO::PARAM_INT);  // Assuming the assigned quantity is the original quantity
        $stmt->bindValue(':updatedQuantity', $quantity, PDO::PARAM_INT);    // Initially, the updated quantity is the same as original
        $stmt->bindValue(':lineManId', $lineManId, PDO::PARAM_INT);
        $stmt->bindValue(':deliveryStatus', 'delivered', PDO::PARAM_STR); // Default status as 'delivered'

        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(["message" => "Failed to insert delivery product update for product ID: $productId."]);
            exit;
        }
    }


    $response["message"] = "Assignment successful.";
    http_response_code(200);
} catch (Exception $e) {
    http_response_code(500);
    $response["message"] = "An error occurred: " . $e->getMessage();
}

// Output the final response
echo json_encode($response);
