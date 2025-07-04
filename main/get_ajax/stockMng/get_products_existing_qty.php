<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$product = $_POST['productID'];

$query = "
SELECT 
    COALESCE(SUM(ts.qty), 0) 
    - COALESCE(sales.total_sold, 0) 
    - COALESCE(returns.total_returned, 0) AS available_stock
FROM tblstock ts
LEFT JOIN (
    SELECT ItemName, SUM(Qty) AS total_sold
    FROM tblsalesinvoice_details 
    WHERE status = '1' AND userID = '$session'
    GROUP BY ItemName
) sales 
ON sales.ItemName COLLATE utf8mb4_unicode_ci = ts.product COLLATE utf8mb4_unicode_ci
LEFT JOIN (
    SELECT product, SUM(qty) AS total_returned
    FROM tblstockreturn
    WHERE userID = '$session'
    GROUP BY product
) returns 
ON returns.product = ts.product
WHERE ts.product COLLATE utf8mb4_unicode_ci = '$product'
AND ts.userID = '$session';
";

$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo $row['available_stock'];
} else {
    echo "0";
}
?>
