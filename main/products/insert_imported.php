<?php
include('../common/cnn.php'); 
session_start();

if (isset($_FILES['partyfile']) && $_FILES['partyfile']['error'] == UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES['partyfile']['tmp_name'];

    // Open the file
    if (($file = fopen($uploadedFile, "r")) !== FALSE) {
        // Skip the first line (header row)
        fgetcsv($file);

        // Prepare the SQL query
        $stmt = $conn->prepare(
            "INSERT INTO tblproducts 
            (`barcode`, `productname`, `purchaseprice`, `saleprice`, `openingstock`, `category`, `gst`, `size`, `sizetype`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        // Bind the variables to the prepared statement
        $stmt->bind_param("sssssssss", $barcode, $productname, $purchaseprice, $saleprice, $openingstock, $category, $gst, $size, $sizetype);

        $batchSize = 100; // Maximum number of rows per batch
        $currentBatchCount = 0; // Counter for the current batch

        // Process each row in the file
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            // Map CSV columns to table columns
            $barcode = trim($data[1]);
            $productname = trim($data[2]);
            $purchaseprice = (float) $data[3];
            $saleprice = (float) $data[4];
            $openingstock = (int) $data[5];
            $category = (int) $data[6];
            $gst = (float) $data[7];
            $size = trim($data[8]);
            $sizetype = trim($data[9]);

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error inserting row: " . $stmt->error . "<br>";
            }

            $currentBatchCount++;

            // If batch is complete, reset counter
            if ($currentBatchCount >= $batchSize) {
                echo "Batch of $batchSize rows processed.<br>";
                $currentBatchCount = 0;
            }
        }

        // Handle remaining rows in the last batch
        if ($currentBatchCount > 0) {
            echo "Final batch of $currentBatchCount rows processed.<br>";
        }

        // Close the statement and the file
        $stmt->close();
        fclose($file);

        // Redirect to the import-products page
        header("Location: import-products");
        exit;
    } else {
        echo "Error opening the file.";
    }
} else {
    echo "File upload error.";
}

// Close the database connection
$conn->close();
?>
