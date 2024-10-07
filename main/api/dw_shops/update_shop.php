<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->name) && !empty($data->address) && !empty($data->route_id)) {
    $query = "UPDATE dw_shops SET name = :name, address = :address, route_id = :route_id WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":address", $data->address);
    $stmt->bindParam(":route_id", $data->route_id);

    if($stmt->execute()) {
        echo json_encode(["message" => "Shop updated successfully."]);
    } else {
        echo json_encode(["message" => "Shop update failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
