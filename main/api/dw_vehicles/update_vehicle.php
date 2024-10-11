<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->name) && !empty($data->number_plate) && !empty($data->driver_id) && !empty($data->helper_id)) {
    // Check if the driver or helper is already allocated

    // Proceed with the update
    $query = "UPDATE dw_vehicles SET name = :name, number_plate = :number_plate, driver_id = :driver_id, helper_id = :helper_id WHERE id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":number_plate", $data->number_plate);
    $stmt->bindParam(":driver_id", $data->driver_id);
    $stmt->bindParam(":helper_id", $data->helper_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Vehicle updated successfully."]);
    } else {
        echo json_encode(["message" => "Vehicle update failed."]);
    }
} else if (isset($data->id) && isset($data->status)) {
    $query = "UPDATE dw_vehicles SET status = :status WHERE id = :id";
    
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
