<?php
include('../db.php'); // Ensure you include your database connection file

$startOfYear = date('Y-01-01'); // Set to the first day of the current year

// Prepare the query using PDO
$query = "
    SELECT DATE_FORMAT(DATE(payment_date), '%Y-%m') AS month, COUNT(id) AS total
    FROM payment_records
    WHERE payment_date >= :startOfYear
    GROUP BY DATE_FORMAT(DATE(payment_date), '%Y-%m')
    ORDER BY month ASC
";

$stmt = $conn->prepare($query);
$stmt->bindParam(':startOfYear', $startOfYear);
$stmt->execute();

// Fetch results
$salesData = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $salesData[$row['month']] = $row['total'];
}

// Initialize an array to hold data for the current year's months
$last12Months = [];
$currentYear = date('Y');
for ($month = 1; $month <= 12; $month++) {
    $monthKey = sprintf("%s-%02d", $currentYear, $month);
    $last12Months[$monthKey] = isset($salesData[$monthKey]) ? $salesData[$monthKey] : 0;
}

echo json_encode($last12Months); // Return the sales data as a JSON object
?>
