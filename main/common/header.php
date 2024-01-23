<?php
session_start();
include('cnn.php');

if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location:auth/page-login.php");
    exit();
}
if(isset($_SESSION['admin'])){
$sessionAdmin=$_SESSION['admin'];
}
if(isset($_SESSION['user'])){
$sessionUser=$_SESSION['user'];
}
date_default_timezone_set('Asia/Kolkata');


?>
<!doctype html>
<html lang="en">

<head>
<title>ADMIN</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


<link rel="icon" href="favicon.ico" type="Images/nayanlogo.png">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css"/>
<link rel="stylesheet" href="../assets/vendor/select2/select2.css" />

<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<link rel="stylesheet" href="../assets/vendor/multi-select/css/multi-select.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css">
<link rel="stylesheet" href="../assets/vendor/nouislider/nouislider.min.css" />
<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/color_skins.css">
</head>
