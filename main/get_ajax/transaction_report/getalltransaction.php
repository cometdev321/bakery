<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1; 
$fromDate=$_POST['fromDate'];
$toDate=$_POST['toDate'];
    $query="select ts.sales_invoice_date,tp.name,ts.sales_invoice_number as refno,ts.recordType,ts.after_discount_total,ts.full_paid from tblsalesinvoices as ts
    join tblparty tp on tp.id=ts.party_name 
    where ts.userID='$session' and ts.sales_invoice_date>='$fromDate' and ts.sales_invoice_date<='$toDate'  and ts.status='1' union 

    select tpi.purchase_invoice_date,tp.name,tpi.purchase_invoice_number  as refno,tpi.recordType,tpi.after_discount_total,tpi.full_paid from tblpurchaseinvoices as tpi
    join tblparty tp on tp.id=tpi.party_name 
    where tpi.userID='$session' and tpi.purchase_invoice_date>='$fromDate' and  tpi.purchase_invoice_date<='$toDate' and tpi.status='1' union

    select tpin.paymentDate,tp.name,tpin.paymentInNumber  as refno,tpin.recordType,tpin.paymentAmount,tpin.full_paid from tblpaymentin as tpin
    join tblparty tp on tp.id=tpin.partyName  
    where tpin.userID='$session'  and tpin.paymentDate>='$fromDate' and tpin.paymentDate<='$toDate' and tpin.status='1' union 

    select tpou.paymentDate,tp.name,tpou.paymentOutNumber  as refno,tpou.recordType,tpou.paymentAmount,tpou.full_paid from tblpaymentout as tpou
    join tblparty tp on tp.id=tpou.partyName 
    where tpou.userID='$session' and tpou.paymentDate>='$fromDate' and tpou.paymentDate<='$toDate' and tpou.status='1'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['sales_invoice_date']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['refno']; ?></td>
                <td><?php echo strtoupper($row['recordType']); ?></td>
                <td>&#8377;<?php echo $row['after_discount_total']; ?></td>
                <td>&#8377;<?php echo ($row['full_paid'] == 'Yes') ? $row['after_discount_total'] : 0; ?></td>
                <td>&#8377;<?php echo ($row['full_paid'] == 'No' ) ? $row['after_discount_total'] : 0; ?></td>
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