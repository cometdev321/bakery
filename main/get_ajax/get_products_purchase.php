 <?php
 include('../common/cnn.php');
 include('../common/session_control.php');


?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT purchaseprice,size,productname,HSN,id,gst FROM tblproducts  where status='1'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['id']; ?>"
        data-hsn="<?php echo $product['HSN']; ?>"
        data-price="<?php echo $product['purchaseprice']; ?>"
        data-gst="<?php echo $product['gst']; ?>"
        data-sizetype="<?php echo $product['size']; ?>">
        
        <?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)</option>
<?php
}
?>