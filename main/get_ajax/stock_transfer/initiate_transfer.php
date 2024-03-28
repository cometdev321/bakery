<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$date=$_POST['date'];
$fromBranch=$_POST['fromBranch'];
$toBranch=$_POST['toBranch'];
$product=$_POST['product'];
$qty=$_POST['qty'];

$checkQty="select openingstock from tblproducts where id='$product'";
$exeCheckQty=mysqli_query($conn,$checkQty);
$fetchCheckqty=mysqli_fetch_array($exeCheckQty);

$availableQty=$fetchCheckqty['openingstock'];
if($qty>$availableQty){
    echo "qtyError";
}else{
    //request transfer
    $insertQuery = "INSERT INTO tbltransfer (`userID`,`date`,`fromBranch`, `ToBranch`, `product`,`qty`,`status`) 
    VALUES ('$session','$date','$fromBranch', '$toBranch', '$product','$qty','requested')";
    $result=mysqli_query($conn,$insertQuery);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}
