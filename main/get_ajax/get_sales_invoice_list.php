<?php
include('../common/cnn.php');
include('../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$query = "SELECT si.sales_invoice_date,si.full_paid,si.id,si.after_discount_total,si.sales_invoice_number,p.name AS party_name 
          FROM tblsalesinvoices si
          INNER JOIN tblparty p ON si.party_name = p.id
          WHERE si.sales_invoice_date >= '$fromDate' AND si.sales_invoice_date <= '$toDate' AND si.userID = '$session' AND si.status = '1' 
          ORDER BY si.id DESC";
          $result = mysqli_query($conn, $query);





if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
         
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo date("d/m/y", strtotime($row['sales_invoice_date'])); ?></td>
                <td><?php echo $row['sales_invoice_number']; ?></td>
                <td><?php echo $row['party_name']; ?></td>
                <td><?php echo $row['after_discount_total']; ?></td>
                <td><?php echo $row['full_paid'] == 'Yes' ? 'Paid' : 'Pending'; ?></td>
                <td>
                    <div class="row">
                        
                    <button type="button" class="btn btn-outline-primary btn-sm mx-2"  data-toggle="tooltip" data-placement="top" title="View Pos Invoice"  onclick="submitSalePosForm('<?php echo $row['id']; ?>')"><i class="icon-doc"></i></button>
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
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
        <td  class="text-center">No records found</td>
    </tr>
<?php
}
?>
