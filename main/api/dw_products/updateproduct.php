<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

// Check for required fields
if (!empty($data->id)) {
    // Update product details
    if (isset($data->name) && isset($data->price) && isset($data->stock)) {
        $query = "UPDATE products SET name = :name, price = :price, hsn = :hsn, stock = :stock WHERE id = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":hsn", $data->hsn);
        $stmt->bindParam(":price", $data->price);
        $stmt->bindParam(":stock", $data->stock);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product updated successfully."]);
        } else {
            echo json_encode(["message" => "Product update failed."]);
        }
    } elseif (isset($data->status)) {
        // Update product status
        $query = "UPDATE products SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":status", $data->status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product status updated successfully."]);
        } else {
            echo json_encode(["message" => "Product status update failed."]);
        }
    } else {
        echo json_encode(["message" => "No update data provided."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
