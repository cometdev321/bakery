<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->number_plate) && !empty($data->driver_id) && !empty($data->helper_id)) {
    $query = "INSERT INTO dw_vehicles SET name=:name, number_plate=:number_plate, driver_id=:driver_id, helper_id=:helper_id, status=1";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":number_plate", $data->number_plate);
    $stmt->bindParam(":driver_id", $data->driver_id);
    $stmt->bindParam(":helper_id", $data->helper_id);

    if($stmt->execute()) {
        echo json_encode(["message" => "Vehicle created successfully."]);
    } else {
        echo json_encode(["message" => "Vehicle creation failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
