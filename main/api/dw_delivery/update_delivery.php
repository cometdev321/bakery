<?php
// Include your database connection file
include('../db.php');

// Get the raw POST data
$data = file_get_contents("php://input");

// Decode the JSON data into a PHP object
$data = json_decode($data);

// Check if decoding was successful
if (json_last_error() === JSON_ERROR_NONE) {
    // Check if the deliveryId is set in the request body
    if (isset($data->deliveryId)) {
        $deliveryId = $data->deliveryId;

        // Prepare the SQL statement to update the delivery status
        $sql = "UPDATE deliveries SET status = 0 WHERE id = :deliveryId";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the delivery_id parameter using bindParam
        $stmt->bindParam(':deliveryId', $deliveryId, PDO::PARAM_INT);

        $stmt->execute();

        $sql = "UPDATE delivery_product_updates SET delivery_status = 0 WHERE delivery_id = :deliveryId";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the delivery_id parameter using bindParam
        $stmt->bindParam(':deliveryId', $deliveryId, PDO::PARAM_INT);




        // Execute the statement
        if ($stmt->execute()) {
            // Check if rows were affected
            if ($stmt->rowCount() > 0) {
                // Success
                echo json_encode(['success' => true]);
            } else {
                // No rows updated (perhaps the status was already 0 or invalid delivery ID)
                echo json_encode(['success' => false, 'message' => 'No delivery found or status already updated']);
            }
        } else {
            // Query failed
            echo json_encode(['success' => false, 'message' => 'Error executing query']);
        }
    } else {
        // No delivery_id provided in the request body
        echo json_encode(['success' => false, 'message' => 'Delivery ID is required']);
    }
} else {
    // JSON decoding failed
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data received']);
}

// Close the database connection
$conn = null;
?>
