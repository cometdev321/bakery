<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT dwr.id as routeid,dwr.startpoint,dwr.endpoint,dwv.name as vehiclename,dwv.id as vehicleid,dwv.number_plate as number_plate FROM dw_routes dwr
join dw_vehicles dwv on dwr.vehicle_id=dwv.id
where dwr.status='1' and id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$route = $stmt->fetch(PDO::FETCH_ASSOC);

if($route) {
    echo json_encode($route);
} else {
    echo json_encode(["message" => "Route not found."]);
}
?>
