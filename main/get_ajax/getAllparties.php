<?php
include('../common/cnn.php');
include('../common/session_control.php');



$query = "UPDATE tblpartyreport 
          SET 
            r_balance = CASE 
                          WHEN r_balance > p_balance THEN r_balance - p_balance 
                          ELSE 0 
                        END,
            p_balance = CASE 
                          WHEN p_balance > r_balance THEN p_balance - r_balance 
                          ELSE 0 
                        END";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "Update successful";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}


$slno = 1;
$credit;
//$query = "SELECT `id`,`name`,`mobno` from tblparty where userID='$session'";

$query = "SELECT pr.*,p.name AS pname FROM tblpartyreport pr JOIN tblparty p ON pr.partyname = p.id WHERE pr.userID = '$session'";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
<<<<<<< HEAD
=======
                $party=$row['id'];

                $querySalesTotal="select sum(total_balance) as totalSales from tblsalesinvoices 
                                where userID='$session' and party_name='$party' and full_paid='No'";

                $queryPurchaseTotal="select sum(total_balance) as totalPurchase from tblpurchaseinvoices 
                                where userID='$session' and party_name='$party' and full_paid='No'";

                $queryPaymentIn="select sum(paymentAmount)as totalPayIn from tblpaymentin
                                 where userID='$session' and partyname='$party' ";

                $queryPaymentOut="select sum(paymentAmount)as totalPayOut from tblpaymentout
                                 where userID='$session' and partyname='$party'";

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
                    $fetchSalesTotal['totalSales'] ;
                $credit=0;
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['pname']; ?></td>
                <td><?php echo $row['mobno']; ?></td>
                <td>
                    <?php
                    $arrow_direction = ($recievable >= 0) ? 'down' : 'up';
                    $amount_display = ($recievable >= 0) ? $recievable . '&darr;' : abs($recievable) . '&uarr;';
                    $color_class = ($arrow_direction === 'down') ? 'green-text' : 'red-text';
                    ?>
                    <span class="<?php echo $color_class; ?>">&#8377;<?php echo $amount_display; ?></span>
                </td>
                <td>
                    <?php
                    $arrow_direction = ($payable >= 0) ? 'up' : 'down';
                    $amount_display = ($payable >= 0) ? $payable . '&uarr;' : abs($payable) . '&darr;';
                    $color_class = ($arrow_direction === 'down') ? 'green-text' : 'red-text';
                    ?>
                    <span class="<?php echo $color_class; ?>">&#8377;<?php echo $amount_display; ?></span>
                </td>
                <!-- <td>&#8377;<?php echo abs($credit); ?></td> -->
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
