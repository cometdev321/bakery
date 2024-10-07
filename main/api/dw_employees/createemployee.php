<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->mobile) && !empty($data->role)) {
    // Check if the employee already exists
    $checkQuery = "SELECT * FROM dw_employees WHERE name = :name AND mobile = :mobile";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(":name", $data->name);
    $checkStmt->bindParam(":mobile", $data->mobile);
    $checkStmt->execute();
    
    if($checkStmt->rowCount() > 0) {
        // Employee already exists
        echo json_encode(["message" => "Employee already exists."]);
    } else {
        // Insert new employee
        $query = "INSERT INTO dw_employees SET name=:name, mobile=:mobile, role=:role, status=1";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":mobile", $data->mobile);
        $stmt->bindParam(":role", $data->role);

        if($stmt->execute()) {
            echo json_encode(["message" => "Employee created successfully."]);
        } else {
            echo json_encode(["message" => "Employee creation failed."]);
        }
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
