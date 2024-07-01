<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$tranferID=$_POST['id'];
$add_to_product=$_POST['add_to_product'];

// id transfer id 
// product id is add_to_product

$getTransfer="select * from tbltransfer where id='$tranferID'";
$exeGetTrans=mysqli_query($conn,$getTransfer);
$fetchGetTransfer=mysqli_fetch_array($exeGetTrans);


$deductQtyFromProduct=$fetchGetTransfer['product'];
$transferQty=$fetchGetTransfer['qty'];

$getavailablestock="select openingstock from tblproducts where id='$add_to_product'";
$exeAvaialble=mysqli_query($conn,$getavailablestock);
$fetchAvailableStock=mysqli_fetch_array($exeAvaialble);

$newQty=$transferQty+$fetchAvailableStock['openingstock'];

$updateQty="update tblproducts set openingstock='$newQty' where id='$add_to_product'";
$result=mysqli_query($conn,$updateQty);
$result1;
if($result){
    $getavailablestock1="select openingstock from tblproducts where id='$deductQtyFromProduct'";
    $exeAvaialble1=mysqli_query($conn,$getavailablestock1);
    $fetchAvailableStock1=mysqli_fetch_array($exeAvaialble1);

    $newQty=$fetchAvailableStock1['openingstock']-$transferQty;

    $updateQty1="update tblproducts set openingstock='$newQty' where id='$deductQtyFromProduct'";
    mysqli_query($conn,"update tbltransfer set status='transfered' where id='$tranferID'");
    $result1=mysqli_query($conn,$updateQty1);
}


if($result1){
    echo "success";
}else{
    echo "error";
}