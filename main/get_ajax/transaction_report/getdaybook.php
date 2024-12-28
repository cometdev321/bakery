<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$date=$_POST['date'];
    $query="select tp.name,ts.sales_invoice_number as refno,ts.recordType,ts.after_discount_total,ts.full_paid from tblsalesinvoices as ts
    join tblparty tp on tp.id=ts.party_name 
    where ts.userID='$session' and ts.sales_invoice_date='$date' and ts.status='1' union 
    
    select tp.name,tpi.purchase_invoice_number  as refno,tpi.recordType,tpi.after_discount_total,tpi.full_paid from tblpurchaseinvoices as tpi
    join tblparty tp on tp.id=tpi.party_name 
     where tpi.userID='$session' and tpi.purchase_invoice_date='$date' and tpi.status='1' union

    select tp.name,tpin.paymentInNumber  as refno,tpin.recordType,tpin.paymentAmount,tpin.full_paid from tblpaymentin as tpin
    join tblparty tp on tp.id=tpin.partyName 
     where tpin.userID='$session'  and tpin.paymentDate='$date' and tpin.status='1' union 

    select tp.name,tpo.paymentOutNumber  as refno,tpo.recordType,tpo.paymentAmount,tpo.full_paid from tblpaymentout as tpo
    join tblparty tp on tp.id=tpo.partyName 
     where tpo.userID='$session' and tpo.paymentDate='$date' and tpo.status='1'
    ";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['refno']; ?></td>
                <td><?php echo strtoupper($row['recordType']); ?></td>
                <td>&#8377;<?php echo $row['after_discount_total']; ?></td>
                <td><span class="green-text">&#8377;<?php echo ($row['recordType'] == 'sales' || $row['recordType'] == 'paymentIn') ? $row['after_discount_total'] .'&darr;': 0 .'&darr;'; ?></span></td>
                <td><span class="red-text">&#8377;<?php echo ($row['recordType'] == 'purchase' || $row['recordType'] == 'paymentOut') ? $row['after_discount_total'].'&uarr;' : 0 .'&uarr;'; ?></span></td>
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