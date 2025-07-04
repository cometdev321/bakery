<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // ID of the stock record to update
    $qty = $_POST['qty']; // New quantity value

    // Ensure ID and qty are not empty
    if (!empty($id) && isset($qty)) {
        $query = "UPDATE tblstockreturn SET qty = ? WHERE id = ? AND userID = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iii', $qty, $id, $session); 
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }

    mysqli_close($conn);
}
?>
