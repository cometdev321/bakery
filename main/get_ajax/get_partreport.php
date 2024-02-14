<?php
include('../common/cnn.php');
include('../common/session_control.php');




$query = "SELECT * from tblpurchaseinvoices where full_paid = 'No' AND userID = '$session'";

?>