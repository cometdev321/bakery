<?php
include('../common/cnn.php');
include('../common/session_control.php');


$slno = 1;
$credit;
$query = "SELECT `id`,`name`,`mobno` from tblparty where userID='$session'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
                $party=$row['id'];

                $querySalesTotal="select sum(total_balance) as totalSales from tblsalesinvoices where userID='$session' and party_name='$party' and full_paid='No'";
                $queryPurchaseTotal="select sum(total_balance) as totalPurchase from tblpurchaseinvoices where userID='$session' and party_name='$party' and full_paid='No'";
                $queryPaymentIn="select sum(paymentAmount)as totalPayIn from tblpaymentin where userID='$session' and partyname='$party' ";
                $queryPaymentOut="select sum(paymentAmount)as totalPayOut from tblpaymentout where userID='$session' and partyname='$party'";

                $exeSalesTotal=mysqli_query($conn,$querySalesTotal);
                $exePurchaseTotal=mysqli_query($conn,$queryPurchaseTotal);
                $exeSalesIn=mysqli_query($conn,$queryPaymentIn);
                $exePaymentOut=mysqli_query($conn,$queryPaymentOut);

                $fetchSalesTotal=mysqli_fetch_array($exeSalesTotal);
                $fetchPurchaseTotal=mysqli_fetch_array($exePurchaseTotal);
                $fetchPaymentIn=mysqli_fetch_array($exeSalesIn);
                $fetchPaymentOut=mysqli_fetch_array($exePaymentOut);

                $recievable=(($fetchSalesTotal['totalSales'])-($fetchPaymentIn['totalPayIn']));
                $payable=(($fetchPurchaseTotal['totalPurchase'])-($fetchPaymentOut['totalPayOut']));
                
                    //receivables are 
                    $fetchSalesTotal['totalSales'] 

            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['mobno']; ?></td>
                <td>&#8377;<?php echo $recievable; ?></td>
                <td>&#8377;<?php echo $payable; ?></td>
                <td>&#8377;<?php echo abs($credit); ?></td>
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
