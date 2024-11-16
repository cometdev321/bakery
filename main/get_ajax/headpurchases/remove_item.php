<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchaseID = $_POST['purchaseID'];
    $status = $_POST['status'];

    $query = "UPDATE tblhead_purchase_details SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $status, $purchaseID);

    if ($stmt->execute()) {
        // Construct the executed query with actual values
        $executedQuery = "UPDATE tblhead_purchase_details SET status = $status WHERE id = $purchaseID";
        echo json_encode(['success' => true, 'query' => $executedQuery]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
