<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'] ?? date('Y-m-d'); // Get the selected date, default to today

    // Fetch stock history
    $query = "
    SELECT 
        tp.productname AS productname,tp.size,tp.saleprice,
        COALESCE(stock.totalstock, 0) - COALESCE(sales.totalsales, 0) AS available_stock
    FROM tblproducts tp
    LEFT JOIN (
        SELECT product, SUM(qty) AS totalstock 
        FROM tblstock 
        WHERE userID = '$session'
        and date<='$date'
        GROUP BY product
    ) stock ON stock.product = tp.id
    LEFT JOIN (
        SELECT ItemName COLLATE utf8mb4_unicode_ci AS product, SUM(Qty) AS totalsales 
        FROM tblsalesinvoice_details 
        WHERE Date <= '$date' AND userID = '$session' and status='1'
        GROUP BY ItemName COLLATE utf8mb4_unicode_ci
    ) sales ON sales.product = tp.id
   ";

    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'productname' => $row['productname'],
            'size' => $row['size'],
            'saleprice' => $row['saleprice'],
            'available_stock' => $row['available_stock']
        ];
    }

    echo json_encode($data);

    mysqli_close($conn);
}
?>
