<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT dwr.id as routeid,dwr.startpoint,dwr.endpoint,dwv.name as vehiclename,dwv.number_plate as number_plate  FROM dw_routes dwr
join dw_vehicles dwv on dwr.vehicle_id=dwv.id
where dwr.status='1'

";
$stmt = $conn->prepare($query);
$stmt->execute();

$routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($routes);
?>
