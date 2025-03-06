<?php
include('../../common/cnn.php');
include('../../common/session_control.php');
$userId = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = $_POST['productID'];
    $date = $_POST['date']; // Fetch the selected date

    if (empty($product) || empty($date)) {
        echo "0";
        exit;
    }

    // Escape inputs to prevent SQL injection
    $product = mysqli_real_escape_string($conn, $product);
    $date = mysqli_real_escape_string($conn, $date);

    $query = "
    SELECT 
        tp.productname AS product, 
        COALESCE(stock.totalstock, 0) - COALESCE(sales.totalsales, 0) AS available_stock
    FROM tblproducts tp
    LEFT JOIN (
        SELECT product, SUM(qty) AS totalstock 
        FROM tblstock 
        WHERE product = '$product' 
                and date<='$date'
              AND userID = '$userId'
        GROUP BY product
    ) stock ON stock.product = tp.id
    LEFT JOIN (
        SELECT ItemName COLLATE utf8mb4_unicode_ci AS product, SUM(Qty) AS totalsales 
        FROM tblsalesinvoice_details 
        WHERE ItemName = '$product' 
              AND Date <= '$date' 
              AND userID = '$userId'
        GROUP BY ItemName COLLATE utf8mb4_unicode_ci
    ) sales ON sales.product = tp.id 
     WHERE tp.id = '$product'
    GROUP BY tp.productname, stock.totalstock, sales.totalsales";

    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['available_stock'];
    } else {
        echo "0";
    }

    mysqli_close($conn);
}
?>
