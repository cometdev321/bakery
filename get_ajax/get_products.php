 <?php
session_start();
 include('../cnn.php');

if(!isset($_SESSION['admin'])){
    header("Location:../page-login");   
}

$session=$_SESSION['admin'];
?>
<option value="null">Select Item</option>
<?php
$get_p = mysqli_query($conn, "SELECT saleprice,size,productname FROM tblproducts  where userID='$session'");
while($product = mysqli_fetch_array($get_p)){
?>
<option value="<?php echo $product['productname']; ?>" data-price="<?php echo $product['saleprice']; ?>" data-sizetype="<?php echo $product['size']; ?>"><?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)</option>
<?php
}
?>