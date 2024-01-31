<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vendor Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Vendor Information Form</h2>
    
    <form>
        <!-- Vendor Name -->
        <div class="form-group">
            <label for="vendorName">Vendor Name:</label>
            <input type="text" class="form-control" id="vendorName" placeholder="Enter vendor name" required>
        </div>

        <!-- Vendor Phone Number -->
        <div class="form-group">
            <label for="vendorPhoneNumber">Vendor Phone Number:</label>
            <input type="tel" class="form-control" id="vendorPhoneNumber" placeholder="Enter phone number" required>
        </div>

        <!-- Vendor Email -->
        <div class="form-group">
            <label for="vendorEmail">Vendor Email:</label>
            <input type="email" class="form-control" id="vendorEmail" placeholder="Enter email" required>
        </div>

        <!-- Vendor Address -->
        <div class="form-group">
            <label for="vendorAddress">Vendor Address:</label>
            <textarea class="form-control" id="vendorAddress" rows="3" placeholder="Enter address" required></textarea>
        </div>

        <!-- Opening Balance -->
        <div class="form-group">
            <label for="openingBalance">Opening Balance:</label>
            <input type="number" class="form-control" id="openingBalance" placeholder="Enter opening balance" required>
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
