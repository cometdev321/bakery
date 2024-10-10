<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

// Check for required fields
if (!empty($data->id)) {
    if (isset($data->name) && isset($data->mobile) && isset($data->role)) {
        // Update employee details
        $query = "UPDATE dw_employees SET name = :name, mobile = :mobile, role = :role WHERE id = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":mobile", $data->mobile);
        $stmt->bindParam(":role", $data->role);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Employee updated successfully."]);
        } else {
            echo json_encode(["message" => "Employee update failed."]);
        }
    } elseif (isset($data->status)) {
        // Update employee status
        $query = "UPDATE dw_employees SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":status", $data->status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Employee status updated successfully."]);
        } else {
            echo json_encode(["message" => "Employee status update failed."]);
        }
    } else {
        echo json_encode(["message" => "No update data provided."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
