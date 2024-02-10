<?php
 include('../common/cnn.php');
 include('../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$query = "SELECT * FROM tblpurchaseinvoices WHERE timestamp >= '$fromDate' AND timestamp <= '$toDate' AND userID='$session' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
    
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['purchase_invoice_date']; ?></td>
                <td><?php echo $row['purchase_invoice_number']; ?></td>
                <td><?php echo $row['party_name']; ?></td>
                <td><?php echo $row['after_discount_total']; ?></td>
                <td><?php echo $row['full_paid'] == 'Yes' ? 'Paid' : 'Pending'; ?></td>
                <td>
                    <div class="row">
                        
                    <button type="button" class="btn btn-outline-primary btn-sm mx-2"  data-toggle="tooltip" data-placement="top" title="View Sales Invoice"  onclick="submitSaleInvoiceForm('<?php echo $row['purchase_invoice_number']; ?>')"><i class="icon-drawer"></i></button>
                    <button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit Sales Invoice"  onclick="edit_invoice('<?php echo $row['purchase_invoice_number']; ?>')"><i class="icon-pencil"></i></button>
                    </div>
                    
                </td>
            </tr>

 
            <?php $slno++;
        } ?>
<?php
} else {
    ?>
        <tr>
            <td>No Records Found</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
<?php
}
?>
