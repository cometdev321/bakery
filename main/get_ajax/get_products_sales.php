<?php
 include('../common/cnn.php');
 include('../common/session_control.php');
 session_start();

if(!isset($_SESSION['admin'])){
    header("Location:../page-login");   
}

?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT `saleprice`,`size`,`productname`,`HSN` FROM tblproducts  where userID='$session'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['productname']; ?>" data-hsn="<?php echo $product['HSN']; ?>" data-price="<?php echo $product['saleprice']; ?>" data-sizetype="<?php echo $product['size']; ?>">
<?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)</option>
<?php
}
?>