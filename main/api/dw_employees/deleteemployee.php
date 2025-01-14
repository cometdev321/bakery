<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $query = "DELETE FROM line_men WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $data->id);

    if($stmt->execute()) {
        echo json_encode(["message" => "Employee deleted successfully."]);
    } else {
        echo json_encode(["message" => "Employee deletion failed."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
