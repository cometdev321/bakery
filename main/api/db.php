<?php
$host = "localhost";
$db_name = "u736864550_deliwheels";
$username = "u736864550_deliwheels";
$password = "Deliwheels@123";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>