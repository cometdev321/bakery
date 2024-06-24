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
            $name = mysqli_real_escape_string($conn, $data[0]);
            $mobno = mysqli_real_escape_string($conn, $data[1]);
            $gstno = mysqli_real_escape_string($conn, $data[2]);

            // Check if the record already exists
            $checkSql = "SELECT COUNT(*) as count FROM tblparty WHERE name = '$name' AND mobno = '$mobno' and userID='$userID' and status='1'";
            $result = $conn->query($checkSql);
            $row = $result->fetch_assoc();

            if ($row['count'] == 0) {
                // Record does not exist, proceed with insertion
                $sql = "INSERT INTO tblparty (userID, name, mobno, gstno) VALUES ('$userID', '$name', '$mobno', '$gstno')";
                if ($conn->query($sql) === TRUE) {
                    // Insert successful
                } else {
                    // Insert failed
                }
            }
        }

        fclose($file);
        header("Location:import-party");
    } else {
        echo "Error opening the file.";
    }
} else {
    echo "File upload error.";
}

$conn->close();
?>
