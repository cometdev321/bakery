<?php
include('cnn.php');
$name=$_POST['category_name'];



$query = "SELECT * FROM tblcategory WHERE name = '$name' ";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
            
            } else {
             $insert_query = "INSERT INTO tblcategory (name) VALUES ('$name')";
            $insert_result = mysqli_query($conn, $insert_query);
            }
