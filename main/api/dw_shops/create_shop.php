<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->address) && !empty($data->route_id)) {
    // Check if a shop with the same name and route_id already exists
    $checkQuery = "SELECT id FROM dw_shops WHERE name = :name AND route_id = :route_id";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(":name", $data->name);
    $checkStmt->bindParam(":route_id", $data->route_id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo json_encode(["message" => "A shop with the same name already exists on this route."]);
    } else {
        // Proceed with shop creation
        $query = "INSERT INTO dw_shops SET name=:name, address=:address, route_id=:route_id, status=1";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":address", $data->address);
        $stmt->bindParam(":route_id", $data->route_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Shop created successfully."]);
        } else {
            echo json_encode(["message" => "Shop creation failed."]);
        }
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
