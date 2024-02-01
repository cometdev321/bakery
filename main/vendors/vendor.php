<?php 
    include('../common/header2.php');
    include('../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vendor Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
    .side-container{
        margin-left: 20%;
    }
</style>
<body>

<div class="side-container container mt-5">
    <h2 class="mb-4">Vendor Information Form</h2>
    
    <form method="post" action="vendor.php">
        <!-- Vendor Name -->
        <div class="form-group">
            <label for="vendorName">Vendor Name:</label>
            <input type="text" class="form-control" id="vendorName" placeholder="Enter vendor name" name="vendorName" required>
        </div>

        <!-- Vendor Phone Number -->
        <div class="form-group">
            <label for="vendorPhoneNumber">Vendor Phone Number:</label>
            <input type="tel" class="form-control" id="vendorPhoneNumber" placeholder="Enter phone number" name="vendorPhoneNumber" required>
        </div>

        <!-- Vendor Email -->
        <div class="form-group">
            <label for="vendorEmail">Vendor Email:</label>
            <input type="email" class="form-control" id="vendorEmail" placeholder="Enter email" name="vendorEmail" required>
        </div>

        <!-- Vendor Address -->
        <div class="form-group">
            <label for="vendorAddress">Vendor Address:</label>
            <textarea class="form-control" id="vendorAddress" rows="3" placeholder="Enter address" name="vendorAddress" required></textarea>
        </div>

        <!-- Opening Balance -->
        <div class="form-group">
            <label for="openingBalance">Opening Balance:</label>
            <input type="number" class="form-control" id="openingBalance" placeholder="Enter opening balance" name="openingBalance" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
<?php
// Replace these with your database connection details
$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "bakery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $vendorName = mysqli_real_escape_string($conn, $_POST['vendorName']);
    $vendorPhoneNumber = mysqli_real_escape_string($conn, $_POST['vendorPhoneNumber']);
    $vendorEmail = mysqli_real_escape_string($conn, $_POST['vendorEmail']);
    $vendorAddress = mysqli_real_escape_string($conn, $_POST['vendorAddress']);
    $openingBalance = mysqli_real_escape_string($conn, $_POST['openingBalance']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO vendors_table (vendor_name, email, phone_num, vendor_add, opening_balance) 
            VALUES ('$vendorName', '$vendorEmail','$vendorPhoneNumber', '$vendorAddress', '$openingBalance')";
    $successMessage = "inserted successfully"; 
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('$successMessage');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
