<?php
include('../common/cnn.php');

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Query to fetch available stock for the selected product
    $query = "SELECT openingstock FROM tblproducts WHERE id = '$productId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $availableStock = $row['openingstock'];

        // Return JSON response
        echo json_encode(['stock' => $availableStock]);
    } else {
        // Handle error if product not found
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    // Handle error if product_id parameter is missing
    echo json_encode(['error' => 'Product ID parameter is missing']);
}
?>
