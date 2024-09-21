<?php
 include('../common/cnn.php');
 include('../common/session_control.php');


?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT `saleprice`,`size`,`productname`,`HSN`,`id`,`openingstock`,`gst` FROM tblproducts  where userID='$session' and status='1'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['id']; ?>"
        data-Existingqty="<?php echo $product['openingstock']; ?>"
        data-hsn="<?php echo $product['HSN']; ?>"
        data-price="<?php echo $product['saleprice']; ?>"
        data-sizetype="<?php echo $product['size']; ?>"
        data-gst="<?php echo $product['gst']; ?>"
        >
<?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)&nbsp;(<?php echo $product['HSN']; ?>)</option>
<?php
}
?> 