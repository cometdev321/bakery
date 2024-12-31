<?php
include('../common/cnn.php'); 
session_start();

if (isset($_FILES['partyfile'])) {
    $uploadedFile = $_FILES['partyfile']['tmp_name'];
    if($_POST['branch']){
        $userID=$_POST['branch'];
    }else{
        $userID=$_SESSION['user'];
    }

    if (($file = fopen($uploadedFile, "r")) !== FALSE) {
        // Skip the first line (header)
        fgetcsv($file);
 
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $category = mysqli_real_escape_string($conn, $data[0]);
            $productname = mysqli_real_escape_string($conn, $data[1]);
            $saleprice = mysqli_real_escape_string($conn, $data[2]);
            $purchase = mysqli_real_escape_string($conn, $data[3]);
            $sizeJoined = mysqli_real_escape_string($conn, $data[4]);
            $size = mysqli_real_escape_string($conn, $data[5]);
            $HSN = mysqli_real_escape_string($conn, $data[6]);
            $openingstock = mysqli_real_escape_string($conn, $data[7]);
            $gst = mysqli_real_escape_string($conn, $data[8]);

            // Check if the record already exists
            $checkSql = "SELECT COUNT(*) as count FROM tblproducts WHERE productname = '$product' AND size = '$size' and userID='$userID' and status='1'";
            $result = $conn->query($checkSql);
            $row = $result->fetch_assoc();

            if ($row['count'] == 0) {
                // Record does not exist, proceed with insertion
                $sql = "INSERT INTO tblproducts (`category`, `productname`, `saleprice`,`purchaseprice`, `HSN`, `openingstock`, `gst`, `size`,`sizetype`,`userID`) 
                VALUES ('$category', '$productname', '$saleprice','$purchase', '$HSN', '$openingstock', '$gst', '$sizeJoined','$size','$userID')";
                if ($conn->query($sql) === TRUE) {
                    // Insert successful
                } else {
                    // Insert failed
                }
            }
        }

        fclose($file);
        header("Location:import-products");
    } else {
        echo "Error opening the file.";
    }
} else {
    echo "File upload error.";
}

$conn->close();
?>
