<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = $_POST['productID'];
    $date = $_POST['date']; // Fetch the selected date

    if (empty($product) || empty($date)) {
        echo "0";
        exit;
    }

    $query = "SELECT 
                COALESCE(SUM(ts.qty), 0) - COALESCE(SUM(tblsales.Qty), 0) AS available_stock 
              FROM tblstock ts 
              LEFT JOIN tblsalesinvoice_details tblsales 
              ON tblsales.ItemName COLLATE utf8mb4_unicode_ci = ts.product COLLATE utf8mb4_unicode_ci 
              WHERE ts.product COLLATE utf8mb4_unicode_ci = ? 
              AND ts.date = ? 
              AND ts.userID = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $product, $date, $session); // $session = userID
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['available_stock'];
    } else {
        echo "0";
    }

    mysqli_stmt_close($stmt);
}
?>
