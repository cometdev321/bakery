<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$product = $_POST['productID'];

// Use prepared statement to prevent SQL injection
$query = "
SELECT 
    COALESCE(SUM(ts.qty), 0) - COALESCE(sales.total_sold, 0) AS available_stock
FROM tblstock ts
LEFT JOIN (
    SELECT ItemName, SUM(Qty) AS total_sold
    FROM tblsalesinvoice_details 
    WHERE status='1' AND userID = ?
    GROUP BY ItemName
) sales 
ON sales.ItemName COLLATE utf8mb4_unicode_ci = ts.product COLLATE utf8mb4_unicode_ci
WHERE ts.product COLLATE utf8mb4_unicode_ci = ?
AND ts.userID = ?;
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "isi", $session, $product, $session); 
 // Assuming $session is an integer (userID)
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo $row['available_stock'];
} else {
    echo "0";
}

mysqli_stmt_close($stmt);
?>
