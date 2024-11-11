<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the year and month values sent via POST
    $year = $_POST['year'];
    $month = $_POST['month'];

    // First, check if a record with the same year, month, and status = 1 exists
    $checkQuery = "SELECT COUNT(*) AS record_count FROM tblheadpurchases WHERE year = $year AND month = $month AND status = 1";
    $result = $conn->query($checkQuery);

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['record_count'] > 0) {
            // If a record exists with the same year, month, and status = 1, return an error
            echo "exists";
        } else {
            // If no such record exists, insert the new record
            $query = "INSERT INTO tblheadpurchases (year, month, status) VALUES ($year, $month, 1)";  // assuming status = 1
            if ($conn->query($query) === TRUE) {
                echo "success";
            } else {
                echo "error";
            }
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?>
