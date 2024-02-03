<?php
session_start();
include('cnn.php');
include('base.php');

if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location:$base/auth/page-login.php");
    exit();
}

if(isset($_SESSION['admin'])){
$session=$_SESSION['admin'];
}
if(isset($_SESSION['user'])){
$session=$_SESSION['user'];
}
date_default_timezone_set('Asia/Kolkata');


?>