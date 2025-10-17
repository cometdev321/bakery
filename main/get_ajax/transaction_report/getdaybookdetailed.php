<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

$slno = 1;
$date = $_POST['date'];

// 1️⃣ Get Available Stock Till Yesterday
$exisitngquery = "
SELECT 
    ts.product,
    COALESCE(SUM(ts.qty), 0) 
    - COALESCE(sales.total_sold, 0) 
    - COALESCE(returns.total_returned, 0) AS available_stock
FROM tblstock ts
LEFT JOIN (
    SELECT ItemName, SUM(Qty) AS total_sold
    FROM tblsalesinvoice_details 
    WHERE status = '1' 
      AND userID = '$session'
      AND DATE(Date) < CURDATE()  
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
WHERE ts.userID = '$session'
GROUP BY ts.product;
";

$exisitngqueryresult = mysqli_query($conn, $exisitngquery);

// Store results in array for later use
$yesterdayStock = [];
while ($row = mysqli_fetch_assoc($exisitngqueryresult)) {
    $yesterdayStock[$row['product']] = $row['available_stock'];
}

// 2️⃣ Get Today’s Sales
$query = "
SELECT 
    tp.id AS product_id,
    tp.productname,
    tp.size,
    tp.saleprice,
    COALESCE(SUM(ts.Qty), 0) AS total_sold_today
FROM tblsalesinvoice_details ts
JOIN tblproducts tp ON tp.id = ts.ItemName
WHERE 
    ts.userID = '$session'
    AND DATE(ts.Date) = '$date'
    AND ts.status = '1'
GROUP BY tp.id, tp.productname;
";

$result = mysqli_query($conn, $query);

// 3️⃣ Display Results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $productId = $row['product_id'];
        $productName = $row['productname'];
        $soldToday = $row['total_sold_today'];
        
        // Yesterday's available stock (if not found, treat as 0)
        $availableTillYesterday = isset($yesterdayStock[$productId]) ? $yesterdayStock[$productId] : 0;
        
        // Remaining stock = available till yesterday - today's sales
        $remainingStock = $availableTillYesterday - $soldToday;
        ?>
        <tr>
            <td><?php echo $slno++; ?></td>
<td>
    <?php echo htmlspecialchars($productName) . " (" . $row['size'] . ") (₹" . $row['saleprice'] . ")"; ?>
</td>
            <td><?php echo $availableTillYesterday; ?></td> <!-- Available till yesterday -->
            <td><?php echo $soldToday; ?></td> <!-- Today's sales -->
            <td><?php echo $remainingStock; ?></td> <!-- Remaining stock -->
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="5" class="text-center">No records found</td>
    </tr>
    <?php
}
?>
