<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');
$selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set


 
$slno = 1;
$credit;

if($selectedBranch =='All'){
    $Csession=$_SESSION['admin'];
    $query = "SELECT tp.id, tp.name, tp.mobno, tu.username 
                FROM tblparty tp
                JOIN tblusers tu ON tp.userID = tu.userID                
                WHERE tp.status = '1' 
                AND tp.userID IN (SELECT userID FROM tblusers WHERE superAdminID = '$Csession')";

}else{
    $query = "SELECT tp.id,tp.name,tp.mobno,tu.username from tblparty tp 
            JOIN tblusers tu ON tp.userID = tu.userID 
             where tp.status='1' and tp.userID='$selectedBranch'";
}

// $query = "SELECT pr.*,p.name AS pname FROM tblpartyreport pr JOIN tblparty p ON pr.partyname = p.id WHERE pr.userID = '$session'";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
                $party=$row['id'];
                if($selectedBranch =='All'){
                    $Csession=$_SESSION['admin'];
                    $querySalesTotal="select sum(total_balance) as totalSales from tblsalesinvoices 
                                where party_name='$party' and full_paid='No' and userID in (select userID from tblusers where superAdminID='$Csession')";

                    $queryPurchaseTotal="select sum(total_balance) as totalPurchase from tblpurchaseinvoices 
                                where party_name='$party' and full_paid='No' and userID in (select userID from tblusers where superAdminID='$Csession')";

                    $queryPaymentIn="select sum(paymentAmount)as totalPayIn from tblpaymentin
                                where partyname='$party' and full_paid='No' and userID in (select userID from tblusers where superAdminID='$Csession')";

                    $queryPaymentOut="select sum(paymentAmount)as totalPayOut from tblpaymentout
                                where partyname='$party' and full_paid='No' and userID in (select userID from tblusers where superAdminID='$Csession')";

                    
                }else{

                $querySalesTotal="select sum(total_balance) as totalSales from tblsalesinvoices 
                                where userID='$selectedBranch' and party_name='$party' and full_paid='No'";

                $queryPurchaseTotal="select sum(total_balance) as totalPurchase from tblpurchaseinvoices 
                                where userID='$selectedBranch' and party_name='$party' and full_paid='No'";

                $queryPaymentIn="select sum(paymentAmount)as totalPayIn from tblpaymentin
                                 where userID='$selectedBranch' and partyname='$party' ";

                $queryPaymentOut="select sum(paymentAmount)as totalPayOut from tblpaymentout
                                 where userID='$selectedBranch' and partyname='$party'";
                }

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
                <td><?php echo strtoupper($row['username']); ?></td>
                <td><?php echo $row['name']; ?></td>
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
