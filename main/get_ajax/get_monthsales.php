<?php
include('../common/cnn.php');
include('../common/session_control.php');

if(isset($_POST['month'])){
    $month = $_POST['month'];

    // Construct SQL query to retrieve total sales for the specified month
    $sql = "SELECT SUM(total_balance) AS total_sales 
            FROM tblsalesinvoices 
            WHERE MONTH(timestamp) = '$month' AND userID = '$session'";

    $result = mysqli_query($conn, $sql);

    //id="salesResult"



    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_array($result)) {
            echo  $row["total_sales"];
        }
    } else {
        echo "No sales found for selected month";
    }
}

?>