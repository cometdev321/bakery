<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Allow these HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'); // Allow specific headers

// Handle preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // If it's an OPTIONS request, just return immediately
}

require_once '../db.php'; // Include your database connection

$rawInput = file_get_contents("php://input");
error_log("Raw input: $rawInput");

$data = json_decode($rawInput);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
    exit;
}

$name = $data->name ?? null;
$address = $data->address ?? null;
$mobile_no = $data->mobile_no ?? null;
$debt_amount = $data->debt_amount ?? null;
$owner_name = $data->owner_name ?? null;

// Validate required fields
if (!$name || !$address || !$mobile_no || !$debt_amount || !$owner_name) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

try {
    $query = "INSERT INTO retail_shops (name, address, mobile_no, debt_amount, owner_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $address, $mobile_no, $debt_amount, $owner_name]);

    echo json_encode(["success" => true, "message" => "Shop added successfully"]);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Database error"]);
}
?>
