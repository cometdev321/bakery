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

        // Process each remaining row in the file
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            // Mapping CSV columns to table columns
            $barcode = trim($data[1]);
            $productname = trim($data[2]);
            $purchaseprice = (float) $data[3];  // Cast to float
            $saleprice = (float) $data[4];      // Cast to float
            $openingstock = (int) $data[5];     // Cast to int
            $category = (int) $data[6];         // Cast to int
            $gst = (float) $data[7];            // Cast to float
            $size = trim($data[8]);
            $sizetype = trim($data[9]);         // This was missing previously

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error inserting row: " . $stmt->error . "<br>";
            }
        }

        // Close the file and statement
        fclose($file);
        $stmt->close();

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
