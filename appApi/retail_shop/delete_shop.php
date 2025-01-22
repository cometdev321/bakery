<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../db.php'; // Your database connection file

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$query = "DELETE FROM retail_shops WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

echo json_encode(["success" => true, "message" => "Shop deleted successfully"]);
?>
