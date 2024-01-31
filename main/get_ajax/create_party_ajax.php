<?php
session_start();
include('../common/cnn.php');



$session=$_SESSION['admin'];

    $name = $_POST['name'];
    $mobile = $_POST['mobno'];
    $gstno = $_POST['gstno'];

        $checkQuery = "SELECT * FROM tblparty WHERE mobno = '$mobile'  and userID='$session'";
        
        if (!empty($gstno)) {
          $checkQuery .= " OR gstno = '$gstno'";
        }
        
        $result = $conn->query($checkQuery);


    if ($result->num_rows > 0) {
        echo 'alreadyexists';
    } else {

        // Prepare the SQL query to insert the data into the table
        $insertQuery = "INSERT INTO tblparty (name, mobno, gstno,userID) VALUES ('$name', '$mobile', '$gstno','$session')";

        // Execute the SQL query
        if ($conn->query($insertQuery) === TRUE) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
