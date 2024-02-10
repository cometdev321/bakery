<?php
include('../../common/cnn.php');
include('../../common/session_control.php');


$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$party=$_POST['party'];

if($party=='all'){

$query = "SELECT si.*, p.name AS party_name 
          FROM tblsalesinvoices si
          INNER JOIN tblparty p ON si.party_name = p.id
          WHERE si.sales_invoice_date >= '$fromDate' AND si.sales_invoice_date <= '$toDate' AND si.userID = '$session' AND si.status = '1' 
          ORDER BY si.id DESC";
}else{
    
$query = "SELECT si.*, p.name AS party_name 
FROM tblsalesinvoices si
INNER JOIN tblparty p ON si.party_name = p.id
WHERE si.sales_invoice_date >= '$fromDate' AND si.sales_invoice_date <= '$toDate' AND si.userID = '$session' AND si.status = '1' and p.id=$party
ORDER BY si.id ASC";
}


          $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 
        
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['sales_invoice_date']; ?></td>
                <td><?php echo $row['sales_invoice_number']; ?></td>
                <td><?php echo $row['party_name']; ?></td>
                <td><?php echo $row['amount_received_type']; ?></td>
                <td><?php echo $row['full_paid']=='Yes'?$row['after_discount_total']:$row['total_balance']; ?></td>
                <td><?php echo $row['full_paid']=='Yes'?'0':$row['total_balance']-$row['amount_received']; ?></td>
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
