<?php
$db_host ='127.0.0.1:3307';
$db_user='root';
$db_pass='';
$db_databse='bakery';

$conn= mysqli_connect($db_host,$db_user,$db_pass,$db_databse);

if(!$conn)
{
    die("Connection Failed".mysqli_connect_error());
}


?>
