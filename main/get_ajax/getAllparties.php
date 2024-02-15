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
$query = "SELECT `id`,`name`,`mobno` from tblparty where userID='$session'";

$query = "SELECT pr.*,p.name AS pname FROM tblpartyreport pr JOIN tblparty p ON pr.partyname = p.id WHERE pr.userID = '$session'";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
        <?php while ($row = mysqli_fetch_array($result)) { 


            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo $row['pname']; ?></td>
                <td><?php echo $row['mobno']; ?></td>
                <td><?php echo $row['r_balance']; ?></td>
                <td><?php echo $row['p_balance']; ?></td>
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
