<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

// Prepare response array
$response = array('status' => 'error', 'message' => 'Something went wrong.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handling Insert or Update
    $records = $_POST['records']; // Array of records sent via AJAX

    // Check if records data is received properly
    if (empty($records)) {
        $response = array('status' => 'error', 'message' => 'No records data received.');
        echo json_encode($response);
        exit();
    }
    $updateQuery="";
    foreach ($records as $record) {
        // Skip record if 'date' is empty
        if (empty($record['date'])) {
            continue;
        }

        // Sanitize each input
        $id=isset($record['id'])?$record['id']:'';
        $purchaseID = mysqli_real_escape_string($conn, $record['purchaseID']);
        $date = mysqli_real_escape_string($conn, $record['date']);
        $trader = mysqli_real_escape_string($conn, $record['trader']);
        $billno = mysqli_real_escape_string($conn, $record['billno']);
        $exempted = mysqli_real_escape_string($conn, $record['exempted']);
        $eighteenAmount = mysqli_real_escape_string($conn, $record['eighteen_amount']);
        $eighteenCgst = mysqli_real_escape_string($conn, $record['eighteen_cgst']);
        $eighteenSgst = mysqli_real_escape_string($conn, $record['eighteen_sgst']);
        $twelveAmount = mysqli_real_escape_string($conn, $record['twelve_amount']);
        $twelveCgst = mysqli_real_escape_string($conn, $record['twelve_cgst']);
        $twelveSgst = mysqli_real_escape_string($conn, $record['twelve_sgst']);
        $fiveAmount = mysqli_real_escape_string($conn, $record['five_amount']);
        $fiveCgst = mysqli_real_escape_string($conn, $record['five_cgst']);
        $fiveSgst = mysqli_real_escape_string($conn, $record['five_sgst']);
        $twentyAmount = mysqli_real_escape_string($conn, $record['twenty_amount']);
        $twentyCgst = mysqli_real_escape_string($conn, $record['twenty_cgst']);
        $twentySgst = mysqli_real_escape_string($conn, $record['twenty_sgst']);
        $roValue = mysqli_real_escape_string($conn, $record['ro']);
        $total = mysqli_real_escape_string($conn, $record['total']);
        $gstValue = mysqli_real_escape_string($conn, $record['gst']);
        $include = mysqli_real_escape_string($conn, $record['include']); // Assuming export checkbox
        $type = $record['type']; // 'insert' or 'update'

        if ($type == 'update') {
            // Update record query
            $updateQuery = "UPDATE tblhead_purchase_details SET purchase_date = '$date', billno = '$billno',trader='$trader', exempted = '$exempted',eighteen_amount = '$eighteenAmount', eighteen_cgst = '$eighteenCgst', eighteen_sgst = '$eighteenSgst',twelve_amount = '$twelveAmount', twelve_cgst = '$twelveCgst', twelve_sgst = '$twelveSgst',five_amount = '$fiveAmount', five_cgst = '$fiveCgst', five_sgst = '$fiveSgst',twenty_amount = '$twentyAmount', twenty_cgst = '$twentyCgst', twenty_sgst = '$twentySgst',ro = '$roValue', total = '$total', gst = '$gstValue', include = '$include' WHERE id = '$id'";

            if (mysqli_query($conn, $updateQuery)) {
                $response = array('status' => 'success', 'message' => 'Record updated successfully.');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update record.');
            }
        } elseif ($type == 'insert') {
            // Insert new record query
            $insertQuery = "INSERT INTO tblhead_purchase_details (purchase_date, billno, exempted, eighteen_amount, eighteen_cgst, eighteen_sgst,twelve_amount, twelve_cgst, twelve_sgst, five_amount, five_cgst, five_sgst,twenty_amount, twenty_cgst, twenty_sgst, ro, total, gst, include, purchaseID,trader) VALUES ('$date', '$billno', '$exempted', '$eighteenAmount', '$eighteenCgst', '$eighteenSgst','$twelveAmount', '$twelveCgst', '$twelveSgst', '$fiveAmount', '$fiveCgst', '$fiveSgst','$twentyAmount', '$twentyCgst', '$twentySgst', '$roValue', '$total', '$gstValue', '$include', '$purchaseID','$trader')";
            if (mysqli_query($conn, $insertQuery)) {
                $response = array('status' => 'success', 'message' => 'Record inserted successfully.');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to insert record.');
            }
        }
    }
    
    // Return the response as JSON to be used by the client-side AJAX
    echo json_encode($updateQuery);
    exit();
}
