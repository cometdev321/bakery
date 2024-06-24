<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$date=$_POST['date'];
$fromBranch=$_POST['fromBranch'];
$toBranch=$_POST['toBranch'];
$product=$_POST['product']; 
$requestQty=$_POST['qty'];

$checkQty="select p.openingstock,tpi.Qty as qty,tt.qty as transfered from tblproducts p
            join tblpurchaseinvoice_details tpi on tpi.ItemName=p.id
            join tbltransfer tt on tt.product=p.id
            where p.id='$product' ";

$exeCheckQty=mysqli_query($conn,$checkQty);
$fetchCheckqty=mysqli_fetch_array($exeCheckQty);

$openingstock=$fetchCheckqty['openingstock'];
$purchase=$fetchCheckqty['qty'];
$transfered=$fetchCheckqty['transfered'];
$availableQty=($openingstock+$purchase)-$transfered;


if($requestQty>$availableQty){
    echo $availableQty;
}else{
    //request transfer
    $insertQuery = "INSERT INTO tbltransfer (`userID`,`date`,`fromBranch`, `ToBranch`, `product`,`qty`,`status`) 
    VALUES ('$session','$date','$fromBranch', '$toBranch', '$product','$requestQty','requested')";
    $result=mysqli_query($conn,$insertQuery);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
