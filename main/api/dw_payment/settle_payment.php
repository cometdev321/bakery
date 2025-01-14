<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Database connection
include('../db.php'); // Replace with your database connection file

// Read the raw POST data
$data = file_get_contents("php://input");

// Decode the JSON data into a PHP object
$data = json_decode($data);

// Check for JSON decode errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'message' => 'JSON decode error: ' . json_last_error_msg()
    ]);
    exit;
}

// Check if required fields are present
if (empty($data->trip_id) || empty($data->amount)) {
    echo json_encode(['success' => false, 'message' => 'Required parameters (trip_id, amount) are missing.']);
    exit;
}

// Assign values from JSON data
$trip_id = $data->trip_id;
$amount = $data->amount;

// Validate parameters
if (!is_numeric($trip_id) || !is_numeric($amount)) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters. Trip ID and amount should be numeric.']);
    exit;
}

// Use NOW() directly in the SQL query for current timestamp
try {
    // Insert payment record into the database
    $query = "INSERT INTO payment_records (delivery_id, amount_paid, payment_date) VALUES (:trip_id, :amount, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':trip_id', $trip_id, PDO::PARAM_INT);
    $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Payment settled successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to settle payment. Error: ' . $e->getMessage()]);
}

$conn = null; // Close the connection
?>
