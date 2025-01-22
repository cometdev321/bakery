<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../db.php'; // Your database connection file

$query = "SELECT * FROM retail_shops";
$stmt = $pdo->query($query);
$shops = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["success" => true, "shops" => $shops]);
?>
