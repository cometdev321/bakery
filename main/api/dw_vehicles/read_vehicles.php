<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db.php';

$query = "SELECT dwv.id as id,dwv.name as name,dwe.name as driver,dwe1.name as helper ,dwv.number_plate as numberplate
FROM dw_vehicles dwv 
join dw_employees dwe on dwe.id=dwv.driver_id 
join dw_employees dwe1 on dwe1.id=dwv.helper_id
where dwv.status='1'
;
            ";
$stmt = $conn->prepare($query);
$stmt->execute();

$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($vehicles);
?>
