<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

// Check if productname and price data is being updated
if (isset($_POST['productname'])) {
    $productname = $_POST['productname'];

    if (isset($_POST['saleprice'])) {
        $newSalePrice = $_POST['saleprice'];

        // Update sale price query using productname
        $updateQuery = "UPDATE tblproducts 
                        SET saleprice='$newSalePrice' 
                        WHERE productname='$productname' 
                      ";
        
        if (mysqli_query($conn, $updateQuery)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    if (isset($_POST['purchaseprice'])) {
        $newPurchasePrice = $_POST['purchaseprice'];

        // Update purchase price query using productname
        $updateQuery = "UPDATE tblproducts 
                        SET purchaseprice='$newPurchasePrice' 
                        WHERE productname='$productname' 
                       ";
        
        if (mysqli_query($conn, $updateQuery)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>
