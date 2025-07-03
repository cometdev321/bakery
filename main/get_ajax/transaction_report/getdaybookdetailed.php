<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$date=$_POST['date'];
    $query="
   SELECT 
    tp.productname,
    sales.total_sold,
    COALESCE(stock.today_stock, 0) AS total_stock
FROM 
    (
        SELECT 
            ts.ItemName,
            SUM(ts.Qty) AS total_sold
        FROM 
            tblsalesinvoice_details ts
        WHERE 
            ts.userID = '$session'
            AND ts.Date = '$date'
            AND ts.status = '1'
        GROUP BY 
            ts.ItemName
    ) AS sales
JOIN 
    tblproducts tp ON tp.id = sales.ItemName
LEFT JOIN 
    (
        SELECT 
            stck.product,
            stck.qty AS today_stock
        FROM 
            tblstock stck
        WHERE 
            stck.date = '$date'
            stck.userId='$session'
    ) AS stock
ON stock.product COLLATE utf8mb4_unicode_ci = sales.ItemName COLLATE utf8mb4_unicode_ci;


    ";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['productname']; ?></td>
                <td><?php echo $row['total_stock']; ?></td>
                <td><?php echo $row['total_sold']; ?></td>
                <td><?php echo ($row['total_stock']-$row['total_sold']); ?></td>
           </tr> 
            <?php $slno++;
        } ?>
<?php
} else {
    ?>
        <tr>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
    </tr>
<?php
}
?>