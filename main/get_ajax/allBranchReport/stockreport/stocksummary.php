<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');

$slno = 1;
$fromDate = $_POST['fromDate'];
$selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All';
$Csession = $_SESSION['admin'];

if ($selectedBranch == 'All') {
    $query = mysqli_query($conn, "SELECT * FROM tblproducts WHERE status='1' AND userID IN (SELECT userID FROM tblusers WHERE superAdminID='$Csession')");
} else {
    $query = mysqli_query($conn, "SELECT * FROM tblproducts WHERE status='1'");
}

while ($row = mysqli_fetch_array($query)) {
    $prid = $row['id'];
    
    if ($selectedBranch == 'All') {
        $queryForBought = mysqli_query($conn, "SELECT COALESCE(SUM(Qty), 0) AS qty FROM tblpurchaseinvoice_details WHERE ItemName='$prid' AND date<='$fromDate' AND status='1' AND userID IN (SELECT userID FROM tblusers WHERE superAdminID='$Csession')");
    } else {
        $queryForBought = mysqli_query($conn, "SELECT COALESCE(SUM(Qty), 0) AS qty FROM tblpurchaseinvoice_details WHERE ItemName='$prid' AND date<='$fromDate' AND status='1' AND userID='$selectedBranch'");
    }

    $fetchBought = mysqli_fetch_array($queryForBought);
    
    if ($selectedBranch == 'All') {
        $queryForSales = mysqli_query($conn, "SELECT COALESCE(SUM(Qty), 0) AS qty FROM tblsalesinvoice_details WHERE ItemName='$prid' AND date<='$fromDate' AND status='1' AND userID IN (SELECT userID FROM tblusers WHERE superAdminID='$Csession')");
    } else {
        $queryForSales = mysqli_query($conn, "SELECT COALESCE(SUM(Qty), 0) AS qty FROM tblsalesinvoice_details WHERE ItemName='$prid' AND date<='$fromDate' AND status='1' AND userID='$selectedBranch'");
    }

    $fetchSold = mysqli_fetch_array($queryForSales);
    
    $closeQty = intval($row['openingstock']) + intval($fetchBought['qty']) - intval($fetchSold['qty']);
    ?>
    <tr>
        <td><?php echo $slno; ?></td>
        <td><?php echo $row['productname']; ?></td>
        <td><?php echo '&#8377;' . $row['saleprice']; ?></td>
        <td><?php echo '&#8377;' . $row['purchaseprice']; ?></td>
        <td><?php echo $closeQty; ?></td>
        <td><?php echo '&#8377;' . $closeQty * $row['purchaseprice']; ?></td>
    </tr>
    <?php 
    $slno++;
}
?>
