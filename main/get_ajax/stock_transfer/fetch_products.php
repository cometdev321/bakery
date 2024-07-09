<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];

    // Query to fetch products based on branch_id
    $query = "SELECT p.id as id, p.productname as productname, p.openingstock as qty FROM tblproducts p 
              JOIN tblusers t ON t.userID = p.userID  
              WHERE p.status = '1' AND t.branch = '$branch_id'";
    $result = mysqli_query($conn, $query);

    // Initialize an empty string to store options HTML
    $options = '<option value="">Select a Product</option>';

    // Loop through the result set and generate <option> elements
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['productname'] . ' (Qty: ' . $row['qty'] . ')</option>';
    }

    // Output the options HTML directly
    echo $options;
}
?>
