 <?php
 include('../common/cnn.php');
 include('../common/session_control.php');


?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT purchaseprice,size,productname,HSN,id FROM tblproducts  where userID='$session'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['id']; ?>" data-hsn="<?php echo $product['HSN']; ?>"  data-price="<?php echo $product['purchaseprice']; ?>" data-sizetype="<?php echo $product['size']; ?>"><?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)</option>
<?php
}
?>