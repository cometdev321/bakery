<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM dw_shops WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$shop = $stmt->fetch(PDO::FETCH_ASSOC);

if($shop) {
    echo json_encode($shop);
} else {
    echo json_encode(["message" => "Shop not found."]);
}
?>
