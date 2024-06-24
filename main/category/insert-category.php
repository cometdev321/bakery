<?php
include('../common/cnn.php'); 
session_start();

if (isset($_FILES['categoryfile'])) {
    $uploadedFile = $_FILES['categoryfile']['tmp_name'];
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

            // Check if the record already exists
            $checkSql = "SELECT COUNT(*) as count FROM tblcategory WHERE name = '$name' and userID='$userID' and status='1'";
            $result = $conn->query($checkSql);
            $row = $result->fetch_assoc();

            if ($row['count'] == 0) {
                // Record does not exist, proceed with insertion
                $sql = "INSERT INTO tblcategory (userID, name) VALUES ('$userID', '$name')";
                if ($conn->query($sql) === TRUE) {
                    // Insert successful
                } else {
                    // Insert failed
                }
            }
        }

        fclose($file);
        header("Location:import-category");
    } else {
        echo "Error opening the file.";
    }
} else {
    echo "File upload error.";
}

$conn->close();
?>
