<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');

// fetch_sales_data.php

// Your database connection code goes here

// Example query to fetch sales data
$query = "SELECT seles_invoice_date, total_balance FROM tblsalesinvoices";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return data as JSON
echo json_encode($data);
?>
