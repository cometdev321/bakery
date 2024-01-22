<?php
include('cnn.php');
session_start();

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
    header("Location:page-login");   
}

$session=$_SESSION['admin'];

if(isset($_POST['category']) && isset($_POST['productName']) && isset($_POST['salePrice'])) {
    $category = $_POST['category'];
    $productName = $_POST['productName'];
    $salePrice = $_POST['salePrice'];

    // Check if the product already exists
    $query = "SELECT * FROM tblproducts WHERE productname = '$productName' and userID='$sessionAdmin'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        // If the record does not exist, insert the new record
        $query = "INSERT INTO tblproducts (category, productname, saleprice,userID)
                  VALUES ('$category', '$productName', '$salePrice','$sessionAdmin')";
      
        if(mysqli_query($conn, $query)) {
            echo "product_added";
        } else {
            echo "error";
        }
    }
}

if(isset($_POST['category']) && isset($_POST['productName']) && isset($_POST['PurchasePrice'])) {
    $category = $_POST['category'];
    $productName = $_POST['productName'];
    $PurchasePrice = $_POST['PurchasePrice'];

    // Check if the product already exists
    $query = "SELECT * FROM tblproducts WHERE productname = '$productName' and userID='$session'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        // If the record does not exist, insert the new record
        $query = "INSERT INTO tblproducts (category, productname, purchaseprice,userID)
                  VALUES ('$category', '$productName', '$PurchasePrice','$session')";
      
        if(mysqli_query($conn, $query)) {
            echo "product_added";
        } else {
            echo "error";
        }
    }
}
?>
