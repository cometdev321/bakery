<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM dw_vehicles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

if($vehicle) {
    echo json_encode($vehicle);
} else {
    echo json_encode(["message" => "Vehicle not found."]);
}
?>
