<?php
include('../common/cnn.php');

// Get parameters from URL
$date = isset($_GET['date']) ? $_GET['date'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';
$productid = isset($_GET['productid']) ? $_GET['productid'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Validate inputs
if (!$date || !$branch || !$productid || !$id) {
    echo "<p>Invalid parameters.</p>";
    exit;
}

// Update the indent status to 'Rejected'
$sql = "UPDATE tblindent 
        SET status = 'Rejected' 
        WHERE id = ? 
        AND userID = ? 
        AND DATE(created_at) = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $id, $branch, $date);
if ($stmt->execute()) {
    header("Location: view_indents.php?date=" . urlencode($date) . "&branch=" . urlencode($branch));
} else {
    echo "<p>Error updating record: " . $conn->error . "</p>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
