<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');

 
$PayOutId = $_POST['payOutId'];
$partySelect = $_POST['partySelect'];
$partyMobno = $_POST['partyMobno'];
$paymentAmount = $_POST['paymentAmount'];
$paymentOutNumber = $_POST['paymentOutNumber'];
$paymentDate = $_POST['paymentDate'];
$paymentMode = $_POST['paymentMode'];
$note = $_POST['note'];



$query = "UPDATE tblpaymentout
          SET partyName = '$partySelect',
              partyMobno = '$partyMobno',
              paymentAmount = '$paymentAmount',
              paymentDate = '$paymentDate',
              paymentMode = '$paymentMode',
              paymentOutNumber = '$paymentOutNumber',
              Notes = '$note'
          WHERE id = $PayOutId";
// Execute the query
if (mysqli_query($conn, $query)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>