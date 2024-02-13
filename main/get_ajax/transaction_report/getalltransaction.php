<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$fromDate=$_POST['fromDate'];
$toDate=$_POST['toDate'];
    $query="select sales_invoice_date,party_name,sales_invoice_number as refno,recordType,after_discount_total,full_paid from tblsalesinvoices where userID='$session' and sales_invoice_date>='$fromDate' and sales_invoice_date<='$toDate'  and status='1' union 
    select purchase_invoice_date,party_name,purchase_invoice_number  as refno,recordType,after_discount_total,full_paid from tblpurchaseinvoices where userID='$session' and purchase_invoice_date>='$fromDate' and  purchase_invoice_date<='$toDate' and status='1' union
    select paymentDate,partyName,paymentInNumber  as refno,recordType,paymentAmount,full_paid from tblpaymentin where userID='$session'  and paymentDate>='$fromDate' and paymentDate<='$toDate' and status='1' union 
    select paymentDate,partyName,paymentOutNumber  as refno,recordType,paymentAmount,full_paid from tblpaymentout where userID='$session' and paymentDate>='$fromDate' and paymentDate<='$toDate' and status='1'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['sales_invoice_date']; ?></td>
                <td><?php echo $row['party_name']; ?></td>
                <td><?php echo $row['refno']; ?></td>
                <td><?php echo $row['recordType']; ?></td>
                <td><?php echo $row['after_discount_total']; ?></td>
                <td><?php echo ($row['full_paid'] == 'Yes') ? $row['after_discount_total'] : 0; ?></td>
                <td><?php echo ($row['full_paid'] == 'No' ) ? $row['after_discount_total'] : 0; ?></td>
            </tr> 
            <?php $slno++;
        } ?>
<?php
} else {
    ?>
        <tr>
        <td colspan="8" class="text-center">No records found</td>
        </tr>
<?php
}
?>