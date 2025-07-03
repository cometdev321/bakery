<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$date=$_POST['date'];
    $query="
   SELECT 
  tp.productname,
  SUM(ts.Qty) AS total_sold,
  SUM(COALESCE(stck.qty, 0)) AS total_stock
FROM 
  tblsalesinvoice_details AS ts
JOIN 
  tblproducts tp 
    ON tp.id = ts.ItemName
LEFT JOIN 
  tblstock stck 
    ON stck.product COLLATE utf8mb4_unicode_ci = ts.ItemName 
    AND stck.date = '$date'
WHERE 
  ts.userID = '$session'
  AND ts.Date = '$date'
  AND ts.status = '1'
GROUP BY 
  stck.product



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