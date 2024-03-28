<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$party=$_POST['party'];

if($party=='all'){

$query = "SELECT pi.*, p.name AS party_name 
          FROM tblpurchaseinvoices pi
          INNER JOIN tblparty p ON pi.party_name = p.id
          WHERE pi.purchase_invoice_date >= '$fromDate' AND pi.purchase_invoice_date <= '$toDate' AND pi.userID = '$session' AND pi.status = '1' 
          ORDER BY pi.id DESC";
}else{
    
$query = "SELECT pi.*, p.name AS party_name 
FROM tblpurchaseinvoices pi
INNER JOIN tblparty p ON pi.party_name = p.id
WHERE pi.purchase_invoice_date >= '$fromDate' AND pi.purchase_invoice_date <= '$toDate' AND pi.userID = '$session' AND pi.status = '1' and p.id=$party
ORDER BY pi.id ASC";
}


          $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['purchase_invoice_date']; ?></td>
                <td><?php echo $row['purchase_invoice_number']; ?></td>
                <td><?php echo $row['party_name']; ?></td>
                <td><?php echo strtoupper($row['amount_paid_type']); ?></td>
                <td>&#8377;<?php echo $row['full_paid']=='Yes'?$row['after_discount_total']:$row['total_balance']; ?></td>
                <td><span class="red-text">&#8377;<?php echo $row['full_paid']=='Yes'?'0'.'&uarr;':$row['total_balance']-$row['amount_paid'].'&uarr;';?></span></td>

                <td >
                    <div class="row"> 

                        &nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Edit Sales Invoice"  onclick="edit_invoice('<?php echo $row['id']; ?>')"><i class="icon-pencil"></i></button>
                    </div>
                    
                </td>
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
