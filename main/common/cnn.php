<?php
// Determine database connection parameters based on the current domain
if ($_SERVER['HTTP_HOST'] === 'nayanfood.in') {
    $db_host = 'localhost'; // Change if your production host is different
    $db_user = 'u736864550_nayan';
    $db_pass = 'Nayanabakery@123';
    $db_database = 'u736864550_nayan';
} else {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_database = 'bakery';
}

// Establish the connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_database);

// Check the connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// You can now use $conn to interact with your database
?>
