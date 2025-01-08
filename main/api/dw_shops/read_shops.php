<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT * FROM dw_shops";
$stmt = $conn->prepare($query);
$stmt->execute();

$shops = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($shops);
?>
