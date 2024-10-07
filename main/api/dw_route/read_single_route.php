<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM dw_routes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$route = $stmt->fetch(PDO::FETCH_ASSOC);

if($route) {
    echo json_encode($route);
} else {
    echo json_encode(["message" => "Route not found."]);
}
?>
