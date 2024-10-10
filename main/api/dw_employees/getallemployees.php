<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT * FROM dw_employees where status='1' order by id desc ";
$stmt = $conn->prepare($query);
$stmt->execute();

$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($employees);
?>
