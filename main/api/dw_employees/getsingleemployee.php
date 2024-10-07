<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM dw_employees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if($employee) {
    echo json_encode($employee);
} else {
    echo json_encode(["message" => "Employee not found."]);
}
?>
