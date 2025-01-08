<?php
include('../common/cnn.php');

// Get productid, order_qty, and indent_id from the query parameters
$productid = isset($_GET['productid']) ? $_GET['productid'] : '';
$order_qty = isset($_GET['order_qty']) ? $_GET['order_qty'] : '';
$indent_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$productid || !$order_qty || !$indent_id) {
    echo "<p>Invalid request. Product ID, order quantity, or indent ID is missing.</p>";
    exit;
}

// Fetch the current opening stock of the product
$sql = "SELECT openingstock FROM tblproducts WHERE id = '$productid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_stock = $row['openingstock'];

    // Calculate the new stock
    $new_stock = $current_stock + $order_qty;

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the opening stock in tblproducts
        $update_product_sql = "UPDATE tblproducts SET openingstock = '$new_stock' WHERE id = '$productid'";
        $conn->query($update_product_sql);

        // Update the status of the indent to "approved"
        $update_indent_sql = "UPDATE tblindent SET status = 'approved' WHERE id = '$indent_id'";
        $conn->query($update_indent_sql);

        // Commit the transaction
        $conn->commit();

        echo "<script>
        window.location.href = 'viewindentrequests.php?date=" . urlencode($_GET['date']) . "&branch=" . urlencode($_GET['branch']) . "';
    </script>";        // Optionally, you can redirect to another page like the main list page
        // header("Location: view_indents.php");
        // exit;

    } catch (Exception $e) {
        // Rollback the transaction if anything fails
        $conn->rollback();
        echo "<p>Error updating stock or approving indent: " . $conn->error . "</p>";
    }
} else {
    echo "<p>Product not found.</p>";
}

// Close the connection
$conn->close();
?>
