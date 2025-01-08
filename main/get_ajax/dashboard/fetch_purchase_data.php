<?php
include('../../common/cnn.php'); // Ensure you include your database connection file
include('../../common/session_control.php'); // Ensure you include your session control file

$userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
$startOfYear = date('Y-01-01'); // Set to the first day of the current year

if ($userID == 'All' || $userID == 'ALL') {
    $query = "SELECT DATE_FORMAT(purchase_invoice_date, '%Y-%m') AS month, SUM(after_discount_total) AS total 
              FROM tblpurchaseinvoices 
              WHERE userID IN (SELECT userID FROM tblusers WHERE superAdminID='$session')
              AND purchase_invoice_date >= '$startOfYear' 
              AND status=1
              GROUP BY DATE_FORMAT(purchase_invoice_date, '%Y-%m') 
              ORDER BY month ASC"; 
} else if (isset($_SESSION['subSession'])) {
    $query = "SELECT DATE_FORMAT(purchase_invoice_date, '%Y-%m') AS month, SUM(after_discount_total) AS total 
              FROM tblpurchaseinvoices 
              WHERE userID='$userID' 
              AND purchase_invoice_date >= '$startOfYear' 
              AND status=1
              GROUP BY DATE_FORMAT(purchase_invoice_date, '%Y-%m') 
              ORDER BY month ASC"; 
} else {
    $query = "SELECT DATE_FORMAT(purchase_invoice_date, '%Y-%m') AS month, SUM(after_discount_total) AS total 
              FROM tblpurchaseinvoices 
              WHERE userID='$session' 
              AND purchase_invoice_date >= '$startOfYear' 
              AND status=1
              GROUP BY DATE_FORMAT(purchase_invoice_date, '%Y-%m') 
              ORDER BY month ASC"; 
}

$result = mysqli_query($conn, $query);

$salesData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $salesData[$row['month']] = $row['total'];
}

// Initialize an array to hold data for the current year months
$last12Months = [];
$currentYear = date('Y');
for ($month = 1; $month <= 12; $month++) {
    $monthKey = sprintf("%s-%02d", $currentYear, $month);
    $last12Months[$monthKey] = isset($salesData[$monthKey]) ? $salesData[$monthKey] : 0;
}

echo json_encode($last12Months); // Return the sales data as a JSON object
?>
