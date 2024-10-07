<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT * FROM dw_vehicles";
$stmt = $conn->prepare($query);
$stmt->execute();

$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($vehicles);
?>
