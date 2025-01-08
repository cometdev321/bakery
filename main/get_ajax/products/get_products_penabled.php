<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');


?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT  tp.productname AS product, tpe.product as id,tp.purchaseprice,tp.size,tp.gst
    FROM tblispurchaseenabled tpe
    JOIN tblproducts tp ON tpe.product = tp.id
    WHERE tpe.status = 1 and tp.status='1' and branch='$session'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['id']; ?>"
        data-price="<?php echo $product['purchaseprice']; ?>"
        data-sizetype="<?php echo $product['size']; ?>"
        data-gst="<?php echo $product['gst']; ?>">
        
        <?php echo $product['product']; ?>&nbsp;(<?php echo $product['size']; ?>)</option>
<?php
}
?>