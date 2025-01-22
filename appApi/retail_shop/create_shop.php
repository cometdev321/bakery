<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../db.php'; // Your database connection file

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$address = $data->address;
$mobile_no = $data->mobile_no;
$debt_amount = $data->debt_amount;
$owner_name = $data->owner_name;

$query = "INSERT INTO retail_shops (name, address, mobile_no, debt_amount, owner_name) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$name, $address, $mobile_no, $debt_amount, $owner_name]);

echo json_encode(["success" => true, "message" => "Shop added successfully"]);
?>

