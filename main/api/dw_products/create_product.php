<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->price) && !empty($data->stock)) {
    $query = "INSERT INTO products (name, price, hsn, stock, created_at) VALUES (:name, :price, :hsn, :stock, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":price", $data->price);
    $stmt->bindParam(":hsn", $data->hsn);
    $stmt->bindParam(":stock", $data->stock);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product created successfully."]);
    } else {
        echo json_encode(["message" => "Product creation failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
