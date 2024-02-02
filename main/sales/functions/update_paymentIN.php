<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');

 
$salesInId = $_POST['salesInId'];
$partySelect = $_POST['partySelect'];
$partyMobno = $_POST['partyMobno'];
$paymentAmount = $_POST['paymentAmount'];
$paymentINNumber = $_POST['paymentINNumber'];
$paymentDate = $_POST['paymentDate'];
$paymentMode = $_POST['paymentMode'];
$note = $_POST['note'];



$query = "UPDATE tblpaymentIN
          SET partyName = '$partySelect',
              partyMobno = '$partyMobno',
              paymentAmount = '$paymentAmount',
              paymentDate = '$paymentDate',
              paymentMode = '$paymentMode',
              paymentInNumber = '$paymentINNumber',
              Notes = '$note'
          WHERE id = $salesInId";
// Execute the query
if (mysqli_query($conn, $query)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>