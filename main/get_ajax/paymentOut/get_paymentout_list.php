<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$query = "SELECT po.*,p.name as `name` FROM tblpaymentout po 
inner join tblparty p on po.partyName=p.id
 WHERE po.entrytime >= '$fromDate' AND po.entrytime <= '$toDate'
 AND po.userID='$session' and po.status='1' ORDER BY id DESC";
 
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
    
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['paymentDate']; ?></td>
                <td><?php echo $row['paymentOutNumber']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['paymentAmount']; ?></td>
                <td>
                    <div class="row">
                        &nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit PaymentOUT"  onclick="edit_paymentOUT('<?php echo $row['id']; ?>')"><i class="icon-pencil"></i></button>
                        &nbsp;&nbsp;<button type="button" class="btn btn-outline-danger btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit PaymentOUT"  onclick="delete_paymentOUT('<?php echo $row['id']; ?>')"><i class="icon-trash"></i></button>
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
