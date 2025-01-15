<?php
if ($_SERVER['HTTP_HOST'] === 'nayanfood.in') {

$host = "localhost";
$db_name = "u736864550_deliwheels";
$username = "u736864550_deliwheels";
$password = "Deliwheels@123";
}else{
$host = "127.0.0.1";
$db_name = "deliwheels";
$username = "root";
$password = "";
}
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>
