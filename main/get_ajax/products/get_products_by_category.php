<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$category = $_POST['categoryID'];
$adminID = $_SESSION['admin'];

// Query to fetch products based on category and adminID
$get_p = mysqli_query($conn, "SELECT tp.id,productname, GROUP_CONCAT(DISTINCT size) AS sizes, saleprice, purchaseprice
FROM tblproducts tp where status='1' and category='$category'
GROUP BY productname, saleprice, purchaseprice;
");

// Initialize serial number 
$slno = 1;
 
// Loop through the results and generate table rows with editable price fields
while ($row = mysqli_fetch_array($get_p)) {
    echo ' 
    <tr>
        <td>' . $slno . '</td>    
        <td>' . $row['productname'] . '</td>
        <td>' . $row['sizes'] . '</td>
        <td><input type="text" class="form-control saleprice-input" data-productid="'.$row['id'].'" data-productname="' . $row['productname'] . '" value="' . $row['saleprice'] . '" /></td>
        <td><input type="text" class="form-control purchaseprice-input" data-productid="'.$row['id'].'"  data-productname="' . $row['productname'] . '" value="' . $row['purchaseprice'] . '" /></td>
    </tr>';
    $slno++;
}
?>
