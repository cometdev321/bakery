<?php
include('../common/cnn.php');

if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];

    // Query to fetch products based on branch_id
    $query = "SELECT p.id as id, p.productname as productname FROM tblproducts p 
              JOIN tblusers t ON t.userID = p.userID  
              WHERE p.status = '1' AND t.branch = '$branch_id'";
    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
