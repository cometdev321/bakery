<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->name) && !empty($data->mobile) && !empty($data->role)) {
    $query = "UPDATE dw_employees SET name = :name, mobile = :mobile, role = :role WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":mobile", $data->mobile);
    $stmt->bindParam(":role", $data->role);

    if($stmt->execute()) {
        echo json_encode(["message" => "Employee updated successfully."]);
    } else {
        echo json_encode(["message" => "Employee update failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
