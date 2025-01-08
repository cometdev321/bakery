<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();
 
$query = "SELECT dwv.id as id,dwv.name as name,dwe.name as driver,dwe1.name as helper ,dwv.number_plate as numberplate
FROM dw_vehicles dwv 
join dw_employees dwe on dwe.id=dwv.driver_id 
join dw_employees dwe1 on dwe1.id=dwv.helper_id
where dwv.status='1' And dwv.id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

if($vehicle) {
    echo json_encode($vehicle);
} else {
    echo json_encode(["message" => "Vehicle not found."]);
}
?>
