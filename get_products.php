<?php
include('cnn.php');
$get_p = mysqli_query($conn, "SELECT saleprice, productname FROM tblproducts");
    $options = array();
    while ($product = mysqli_fetch_array($get_p)) {
        $options[] = array(
            "saleprice" => $product['saleprice'],
            "productname" => $product['productname']
        );
    }

    // Send the options as JSON response
    header('Content-Type: application/json');
    echo json_encode($options);
?>
