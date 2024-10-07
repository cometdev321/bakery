<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT * FROM dw_routes";
$stmt = $conn->prepare($query);
$stmt->execute();

$routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($routes);
?>
