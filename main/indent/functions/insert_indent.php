<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

// Retrieve the JSON data
$inputData = json_decode(file_get_contents("php://input"), true);

// Check if data is properly received
if (isset($inputData['data']) && is_array($inputData['data'])) {
    foreach ($inputData['data'] as $row) {
        $productId = $row['productId'];
        $new_order_qty = $row['new_order_qty'];

        // Insert query
        $sql = "INSERT INTO tblindent (productId, new_order_qty, userID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $productId, $new_order_qty, $session);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement after each iteration
        $stmt->close();
    }
} else {
    echo "Invalid data format received";
}

// Close the connection
$conn->close();
?>
