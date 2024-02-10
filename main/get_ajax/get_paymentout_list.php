<?php
 include('../common/cnn.php');
 include('../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$query = "SELECT * FROM tblpaymentOUT WHERE entrytime >= '$fromDate' AND entrytime <= '$toDate'  AND userID='$session' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
    
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['paymentDate']; ?></td>
                <td><?php echo $row['paymentOutNumber']; ?></td>
                <td><?php echo $row['partyName']; ?></td>
                <td><?php echo $row['paymentAmount']; ?></td>
                <td>
                    <div class="row">
                        
                    <button type="button" class="btn btn-outline-primary btn-sm mx-2"  data-toggle="tooltip" data-placement="top" title="View PaymentIN"  onclick="submitPaymentIN('<?php echo $row['paymentInNumber']; ?>')"><i class="icon-drawer"></i></button>
                    <button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit PaymentIN"  onclick="edit_paymentIN('<?php echo $row['paymentInNumber']; ?>')"><i class="icon-pencil"></i></button>
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
