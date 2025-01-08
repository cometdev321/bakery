<?php
include('../common/cnn.php');
include('../common/header2.php');
include('../common/sidebar.php');

// Get the indent ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    echo "<p>No indent ID specified.</p>";
    exit;
}

// Fetch the indent record based on the ID
$sql = "SELECT * FROM tblindent WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $indent = $result->fetch_assoc();
} else {
    echo "<p>Record not found.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save the updated indent data
    $newOrderQty = $_POST['new_order_qty'];

    $updateSql = "UPDATE tblindent SET new_order_qty = '$newOrderQty' WHERE id = '$id'";
    
    if ($conn->query($updateSql)) {
        // Instead of PHP's header redirect, use JavaScript to redirect
        echo "<script>
                window.location.href = 'view_indents?date=" . date('Y-m-d', strtotime($indent['created_at'])) . "';
              </script>";
        exit;
    } else {
        echo "<p>Error updating record: " . $conn->error . "</p>";
    }
}
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Indent Record</h2>
        </div>
        <div class="card">
            <div class="body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="new_order_qty">New Quantity</label>
                        <input type="number" class="form-control" name="new_order_qty" id="new_order_qty" value="<?php echo $indent['new_order_qty']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="view_indents?date=<?php echo date('Y-m-d', strtotime($indent['created_at'])); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="../../assets/vendor/select2/select2.min.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>

<?php
// Close the connection
$conn->close();
?>
