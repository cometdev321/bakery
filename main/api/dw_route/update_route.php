<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->startpoint) && !empty($data->endpoint) && !empty($data->vehicle_id)) {
    $query = "UPDATE dw_routes SET startpoint = :startpoint, endpoint = :endpoint, vehicle_id = :vehicle_id WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":startpoint", $data->startpoint);
    $stmt->bindParam(":endpoint", $data->endpoint);
    $stmt->bindParam(":vehicle_id", $data->vehicle_id);

    if($stmt->execute()) {
        echo json_encode(["message" => "Route updated successfully."]);
    } else {
        echo json_encode(["message" => "Route update failed."]);
    }
}  else if (isset($data->id) && isset($data->status)) {
    $query = "UPDATE dw_routes SET status = :status WHERE id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":status", $data->status);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Status updated successfully."]);
    } else {
        echo json_encode(["message" => "Status update failed."]);
    }
} else {
    echo json_encode(["message" => "No status provided."]);
}
?>
