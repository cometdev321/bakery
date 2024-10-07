<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->startpoint) && !empty($data->endpoint) && !empty($data->vehicle_id)) {
    // Check if the route already exists
    $checkQuery = "SELECT * FROM dw_routes WHERE startpoint = :startpoint AND endpoint = :endpoint AND vehicle_id = :vehicle_id";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(":startpoint", $data->startpoint);
    $checkStmt->bindParam(":endpoint", $data->endpoint);
    $checkStmt->bindParam(":vehicle_id", $data->vehicle_id);
    $checkStmt->execute();
    
    if($checkStmt->rowCount() > 0) {
        // Route already exists
        echo json_encode(["message" => "Route already exists."]);
    } else {
        // Insert new route
        $query = "INSERT INTO dw_routes SET startpoint=:startpoint, endpoint=:endpoint, vehicle_id=:vehicle_id, status=1";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":startpoint", $data->startpoint);
        $stmt->bindParam(":endpoint", $data->endpoint);
        $stmt->bindParam(":vehicle_id", $data->vehicle_id);

        if($stmt->execute()) {
            echo json_encode(["message" => "Route created successfully."]);
        } else {
            echo json_encode(["message" => "Route creation failed."]);
        }
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
