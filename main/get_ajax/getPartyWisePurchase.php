<?php
include('../common/cnn.php');
include('../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$party=$_POST['partyName'];

$query = "SELECT id,purchase_invoice_number,purchase_invoice_date,full_paid,total_balance from tblpurchaseinvoices
        where status='1' and  party_name='$party' and purchase_invoice_date>='$fromDate' and purchase_invoice_date<='$toDate'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['purchase_invoice_date']; ?></td>
                <td><?php echo $row['purchase_invoice_number']; ?></td>
                <td><?php echo $row['total_balance']; ?></td>
                <td><?php echo $row['full_paid'] == 'Yes' ? 'Paid' : 'Pending'; ?></td>
                <td>
                    <div class="row">
                        
                    <button type="button" class="btn btn-outline-primary btn-sm mx-2"  data-toggle="tooltip" data-placement="top" title="View Sales Invoice"  onclick="submitSaleInvoiceForm('<?php echo $row['id']; ?>')"><i class="icon-drawer"></i></button>
                    <button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit Sales Invoice"  onclick="edit_invoice('<?php echo $row['id']; ?>')"><i class="icon-pencil"></i></button>
                    </div>
                    
                </td>
            </tr> 
            <?php $slno++;
        } ?>
<?php
} else {
    ?>
         <tr>
            <td colspan="6" class="text-center">No records found</td>
        </tr>
<?php
}
?>
