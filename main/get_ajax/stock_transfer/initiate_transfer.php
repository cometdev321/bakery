<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$date = $_POST['date'];
$fromBranch = $_POST['fromBranch'];
$toBranch = $_POST['toBranch'];
$product = $_POST['product']; 
$requestQty = $_POST['qty'];




// $query = "UPDATE tblproducts p
// JOIN tblusers u ON p.userID = u.userID
// SET p.openingstock = p.openingstock - $requestQty
// WHERE p.id = $product
// AND u.branch = $fromBranch";

// $res = mysqli_query($conn, $query); // <-- Add semicolon here

// request transfer
$insertQuery = "INSERT INTO tbltransfer (`userID`,`date`,`fromBranch`, `ToBranch`, `product`,`qty`,`status`) 
                VALUES ('$session','$date','$fromBranch', '$toBranch', '$product','$requestQty','requested')";
$result = mysqli_query($conn, $insertQuery);

if ($result) {
    echo 'success';
} else {
    echo 'error';
}
?>
