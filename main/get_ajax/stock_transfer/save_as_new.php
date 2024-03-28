<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$tranferID=$_POST['id'];

$getTransfer="select * from tbltransfer where id='$tranferID'";
$exeGetTrans=mysqli_query($conn,$getTransfer);
$fetchGetTransfer=mysqli_fetch_array($exeGetTrans);


$deductQtyFromProduct=$fetchGetTransfer['product'];
$transferQty=$fetchGetTransfer['qty'];


$getavailablestock1="select * from tblproducts where id='$deductQtyFromProduct'";
$exeAvaialble1=mysqli_query($conn,$getavailablestock1);
$fetchAvailableStock1=mysqli_fetch_array($exeAvaialble1);


$category=$fetchAvailableStock1['category'];
$productname=$fetchAvailableStock1['productname'];
$saleprice=$fetchAvailableStock1['saleprice	'];
$purchase=$fetchAvailableStock1['purchaseprice'];
$size_number=$fetchAvailableStock1['size'];
$size=$fetchAvailableStock1['sizetype'];    
$HSN=$fetchAvailableStock1['HSN'];    
$openingstock=$transferQty;    
$gst=$fetchAvailableStock1['gst'];    



$query = "INSERT INTO tblproducts (`category`,  `productname`, `saleprice`,`purchaseprice`, `HSN`, `openingstock`, `gst`, `size`,`sizetype`,`userID`) 
VALUES ('$category', '$productname', '$saleprice','$purchase', '$HSN', '$openingstock', '$gst', '$size_number','$size','$session')";
mysqli_query($conn,$query);


$newQty=$fetchAvailableStock1['openingstock']-$transferQty;
$updateQty1="update tblproducts set openingstock='$newQty' where id='$deductQtyFromProduct'";
mysqli_query($conn,"update tbltransfer set status='transfered' where id='$tranferID'");
$result1=mysqli_query($conn,$updateQty1);


if($result1){
    echo "success";
}else{
    echo "error";
}