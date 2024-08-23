<?php
include('../common/cnn.php');

// Get the selected date and branch from the GET parameters
$date = isset($_GET['date']) ? $_GET['date'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

if (!$date || !$branch) {
    echo "<p>Please select both a date and a branch.</p>";
    exit;
}

// Start a transaction
$conn->begin_transaction();

try {
    // Fetch all indent requests for the selected date, branch
    $sql = "SELECT ti.id, ti.productid, ti.new_order_qty 
            FROM tblindent ti 
            WHERE DATE(ti.created_at) = '$date' 
            AND ti.status='Created'
            AND ti.userID = '$branch'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productid = $row['productid'];
            $order_qty = $row['new_order_qty'];
            $indent_id = $row['id'];

            // Fetch the current opening stock of the product
            $product_sql = "SELECT openingstock FROM tblproducts WHERE id = '$productid'";
            $product_result = $conn->query($product_sql);

            if ($product_result->num_rows > 0) {
                $product_row = $product_result->fetch_assoc();
                $current_stock = $product_row['openingstock'];

                // Calculate the new stock
                $new_stock = $current_stock + $order_qty;

                // Update the opening stock in tblproducts
                $update_product_sql = "UPDATE tblproducts SET openingstock = '$new_stock' WHERE id = '$productid'";
                $conn->query($update_product_sql);

                // Update the status of the indent to "approved"
                $update_indent_sql = "UPDATE tblindent SET status = 'approved' WHERE id = '$indent_id'";
                $conn->query($update_indent_sql);
            }
        }

        // Commit the transaction
        $conn->commit();

        echo "<script>
        window.location.href = 'viewindentrequests?date=" . urlencode($date) . "&branch=" . urlencode($branch) . "';
    </script>";    } else {
        echo "<p>No indent requests found for the selected date and branch.</p>";
    }
} catch (Exception $e) {
    // Rollback the transaction if anything fails
    $conn->rollback();
    echo "<p>Error updating stock or approving indents: " . $conn->error . "</p>";
}

// Close the connection
$conn->close();
?>
