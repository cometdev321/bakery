<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$category = $_POST['categoryID'];

// Query to fetch products based on category
$get_p = mysqli_query($conn, "SELECT productname, id
FROM tblproducts WHERE status='1' AND category='$category' AND ispurchaseEnabled='1'
");

while ($row = mysqli_fetch_array($get_p)) {
    echo '<option value="' . $row['id'] . '">' . $row['productname'] .'</option>';
}
?>
