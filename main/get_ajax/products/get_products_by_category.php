<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$category = $_POST['categoryID'];
$adminID = $_SESSION['admin'];

// Query to fetch products based on category and adminID
$get_p = mysqli_query($conn, "SELECT 
                                tp.productname,
                                MIN(tp.saleprice) as saleprice, 
                                MIN(tp.purchaseprice) as purchaseprice,
                                MIN(tp.default_discount) as default_discount,
                                MIN(tp.gst) as gst,
                                MIN(tp.size) as size,
                                tc.name as name,
                                MIN(b.name) as branch
                            FROM 
                                tblproducts tp
                            JOIN 
                                tblusers tu ON tp.userID = tu.userID
                            JOIN 
                                branch b ON b.id = tu.branch
                            JOIN 
                                tblcategory tc ON tc.id = tp.category 
                            WHERE 
                                tp.status = '1' 
                                AND tu.superAdminID = '$adminID'
                                AND tp.category='$category'
                            GROUP BY 
                                tp.productname
                            ORDER BY 
                                tp.productname ASC");

// Initialize serial number
$slno = 1;

// Loop through the results and generate table rows with editable price fields
while ($row = mysqli_fetch_array($get_p)) {
    echo '
    <tr>
        <td>' . $slno . '</td>    
        <td>' . $row['productname'] . '</td>
        <td><input type="text" class="form-control saleprice-input" data-productname="' . $row['productname'] . '" value="' . $row['saleprice'] . '" /></td>
        <td><input type="text" class="form-control purchaseprice-input" data-productname="' . $row['productname'] . '" value="' . $row['purchaseprice'] . '" /></td>
    </tr>';
    $slno++;
}
?>
