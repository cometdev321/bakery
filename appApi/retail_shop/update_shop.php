<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Add DELETE here
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../db.php'; // Your database connection file

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$name = $data->name;
$address = $data->address;
$mobile_no = $data->mobile_no;
$debt_amount = $data->debt_amount;
$owner_name = $data->owner_name;

$query = "UPDATE retail_shops SET name = ?, address = ?, mobile_no = ?, debt_amount = ?, owner_name = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$name, $address, $mobile_no, $debt_amount, $owner_name, $id]);

echo json_encode(["success" => true, "message" => "Shop updated successfully"]);
?>
