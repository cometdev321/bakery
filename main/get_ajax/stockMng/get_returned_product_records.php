<?php
include('../../common/cnn.php');
include('../../common/session_control.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'] ?? date('Y-m-d'); // Get the selected date, default to today
    $product=$_POST['product']; 
    // Fetch stock history
    $query = "
    SELECT id,qty from tblstockreturn where date='$date' and product='$product' and userID='$session'
    ";
    
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['id'],
            'qty' => $row['qty'],
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);

    mysqli_close($conn);
}
?>
