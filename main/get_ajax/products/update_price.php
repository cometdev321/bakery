<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

// Check if productID and price data are being updated
if (isset($_POST['productID'])) {
    $productID = $_POST['productID']; 

    if (isset($_POST['saleprice'])) {
        $newSalePrice = $_POST['saleprice'];

        // Update sale price query using productID
        $updateQuery = "UPDATE tblproducts 
                        SET saleprice = '$newSalePrice' 
                        WHERE id = '$productID'";
        
        if (mysqli_query($conn, $updateQuery)) {
            echo 'success';
        } else { 
            echo 'error';
        }
    }

    if (isset($_POST['purchaseprice'])) {
        $newPurchasePrice = $_POST['purchaseprice'];

        // Update purchase price query using productID
        $updateQuery = "UPDATE tblproducts 
                        SET purchaseprice = '$newPurchasePrice' 
                        WHERE id = '$productID'";
        
        if (mysqli_query($conn, $updateQuery)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>
