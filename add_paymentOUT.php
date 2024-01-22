<?php
include('cnn.php');
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:page-login");   
}

$session=$_SESSION['admin'];

$partySelect = $_POST['partySelect'];
$partyMobno = $_POST['partyMobno'];
$paymentAmount = $_POST['paymentAmount'];
$paymentOUTNumber = $_POST['Payment_Out_number'];
$paymentDate = $_POST['paymentDate'];
$paymentMode = $_POST['paymentMode'];
$note = $_POST['note'];



// Prepare the INSERT query
$query = "INSERT INTO tblpaymentOUT (partyName, partyMobno, paymentAmount, paymentDate, paymentMode, paymentOutNumber, Notes,userID)
          VALUES ('$partySelect', '$partyMobno', '$paymentAmount', '$paymentDate', '$paymentMode', '$paymentOUTNumber', '$note','$session')";

// Execute the query
if (mysqli_query($conn, $query)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>