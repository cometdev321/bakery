<?php
 include('../common/cnn.php');
 session_start();

if(!isset($_SESSION['admin'])){
    header("Location:page-login");   
}

$session=$_SESSION['admin'];
$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$query = "SELECT pi.*,p.name as `name` FROM tblpaymentIN pi inner join tblparty p on pi.partyName=p.id WHERE pi.entrytime >= '$fromDate' AND pi.entrytime <= '$toDate' AND pi.userID='$session' and pi.status='1' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
    
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['paymentDate']; ?></td>
                <td><?php echo $row['paymentInNumber']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['paymentAmount']; ?></td>
                <td>
                    <div class="row">                        
                    &nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit PaymentIN"  onclick="edit_paymentIN('<?php echo $row['id']; ?>')"><i class="icon-pencil"></i></button>
                    &nbsp;&nbsp;<button type="button" class="btn btn-outline-danger btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit PaymentIN"  onclick="delete_paymentIN('<?php echo $row['id']; ?>')"><i class="icon-trash"></i></button>
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
