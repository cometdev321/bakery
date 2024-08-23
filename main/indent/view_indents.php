<?php
include('../common/cnn.php');
include('../common/header2.php');
include('../common/sidebar.php');

// Get the selected date from the POST parameter
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$date) {
    echo "<p>Please select a date.</p>";
    exit;
}

// Assuming the session variable holds the user ID
$session = $_SESSION['user']; 

// Fetch records for the selected date and the logged-in user using a normal SQL query
$sql = "SELECT ti.*, p.productname 
        FROM tblindent ti 
        JOIN tblproducts p ON ti.productid = p.id 
        WHERE DATE(ti.created_at) = '$date' AND ti.userid = '$session'";
$result = $conn->query($sql);

?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2>Indent Records for <?php echo date('F j, Y', strtotime($date)); ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">View Indent Records</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="body table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
            <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Product Name</th>
                            <th>Order Qty</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th> <!-- New column for Edit button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $slNo = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $slNo++; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['new_order_qty']; ?></td>
                                    <td><?php echo date('F j, Y', strtotime($row['created_at'])); ?></td>
                                    <td><?php echo strtoupper($row['status']); ?></td>
                                    <td>
                                    <?php if ($row['status'] === 'Created'): ?>
                                        <a href="edit_indent.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <?php else: ?>
                                        <button class="btn btn-primary btn-sm" disabled>Edit</button>
                                    <?php endif; ?>
                                </td>

                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>No records found for this date.</td></tr>"; // Updated colspan to 5
                        }
                        ?>
                    </tbody>
                </table>
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
