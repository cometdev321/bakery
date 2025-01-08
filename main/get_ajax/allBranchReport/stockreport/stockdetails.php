<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');

$slno = 1;
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set
$Csession = $_SESSION['admin'];

// Prepare base query to fetch product details
$query = "
    SELECT  p.id as pid, p.productname, p.saleprice, p.openingstock, p.purchaseprice 
    FROM tblproducts p
    WHERE p.status = '1' 
";


$query .= " GROUP BY p.productname, p.saleprice, p.openingstock, p.purchaseprice";

// Fetch product data
$fetchProducts = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($fetchProducts)) {
    $prid = $row['pid'];

    // Query for purchased quantity
    if ($selectedBranch == 'All' || $selectedBranch == 'ALL') {
        $queryForBought = "
            SELECT COALESCE(SUM(Qty), 0) AS qty 
            FROM tblpurchaseinvoice_details 
            WHERE ItemName = '$prid' 
            AND date >= '$fromDate' 
            AND date <= '$toDate' 
            AND status = '1' 
            AND userID IN (SELECT userID FROM tblusers WHERE superAdminID = '$Csession')
        ";
    } else {
        $queryForBought = "
            SELECT COALESCE(SUM(Qty), 0) AS qty 
            FROM tblpurchaseinvoice_details 
            WHERE ItemName = '$prid' 
            AND date >= '$fromDate' 
            AND date <= '$toDate' 
            AND status = '1' 
            AND userID = '$selectedBranch'
        ";
    }

    // Execute purchase query
    $fetchBought = mysqli_fetch_array(mysqli_query($conn, $queryForBought));

    // Query for sales quantity
    if ($selectedBranch == 'All' || $selectedBranch == 'ALL') {
        $queryForsales = "
            SELECT COALESCE(SUM(Qty), 0) AS qty 
            FROM tblsalesinvoice_details 
            WHERE ItemName = '$prid' 
            AND date >= '$fromDate' 
            AND date <= '$toDate' 
            AND status = '1' 
            AND userID IN (SELECT userID FROM tblusers WHERE superAdminID = '$Csession')
        ";
    } else {
        $queryForsales = "
            SELECT COALESCE(SUM(Qty), 0) AS qty 
            FROM tblsalesinvoice_details 
            WHERE ItemName = '$prid' 
            AND date >= '$fromDate' 
            AND date <= '$toDate' 
            AND status = '1' 
            AND userID = '$selectedBranch'
        ";
    }

    // Execute sales query
    $fetchsold = mysqli_fetch_array(mysqli_query($conn, $queryForsales));

    // Calculate closing quantity
    $closeQty = intval($row['openingstock']) + intval($fetchBought['qty']) - intval($fetchsold['qty']);
?>
    <tr>
        <td><?php echo $slno; ?></td>
        <td><?php echo $row['productname']; ?></td>
        <td><?php echo '&#8377;' . number_format($row['saleprice'], 2); ?></td>
        <td><?php echo $row['openingstock']; ?></td>
        <td><?php echo $fetchBought['qty']; ?></td>
        <td><?php echo '&#8377;' . number_format($row['purchaseprice'], 2); ?></td>
        <td><?php echo $fetchsold['qty']; ?></td>
        <td><?php echo $closeQty; ?></td>
    </tr>
<?php
    $slno++;
}
?>
