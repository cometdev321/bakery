<?php
session_start();
include('cnn.php');
include('base.php');

date_default_timezone_set('Asia/Kolkata');

if (isset($_POST["login-submit"])) {
    $username  = $_POST["username"]; 
    $password  = $_POST["password"];
       
    $adm = mysqli_query($conn, "SELECT * FROM `admin` WHERE `Email`='$username' AND `Password`='$password'");
    if ($adm->num_rows > 0) {    
        $admindetails = mysqli_fetch_array($adm);
        $_SESSION['admin'] = $admindetails['unicode'];
        $_SESSION['isAdmin'] = 1;

        header("Location:../dashboard");
        exit();
    } else {
        $usr = mysqli_query($conn, "SELECT * FROM `tblusers` WHERE `username`='$username' AND `password`='$password' and `status`=1");
        if ($usr->num_rows > 0) {
            $userdetails = mysqli_fetch_array($usr);
            $_SESSION['user'] = $userdetails['userID'];
            $_SESSION['isAdmin'] = 0;
            header("Location:../dashboard");
            exit();
        } else {
            header("Location:../auth/page-login?status=usernotfound");
            exit();
        }
    }
}

if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location:$base/auth/page-login");
    exit(); 
}

if (isset($_SESSION['admin'])) {
    $session = $_SESSION['admin'];
}
if (isset($_SESSION['user'])) {
    $session = $_SESSION['user'];
}

if (isset($_POST['branch'])) {
    unset($_SESSION['subSession']);
    $_SESSION['subSession'] = $_POST['branch'];  
    
}

date_default_timezone_set('Asia/Kolkata');
?>
