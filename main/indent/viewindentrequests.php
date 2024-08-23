<?php
include('../common/cnn.php');
include('../common/header2.php');
include('../common/sidebar.php');

// Get the selected date and branch from the GET parameters
$date = isset($_GET['date']) ? $_GET['date'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

if (!$date || !$branch) {
    echo "<p>Please select both a date and a branch.</p>";
    exit;
}

// Fetch records for the selected date, branch, and the logged-in user using a SQL query
$sql = "SELECT ti.*, p.productname 
        FROM tblindent ti 
        JOIN tblproducts p ON ti.productid = p.id 
        WHERE DATE(ti.created_at) = '$date' 
        AND ti.status='Created'
        AND ti.userID = '$branch'";  
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
                        <li class="breadcrumb-item active">View Indent Requests</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="body table-responsive">
                <a href="approve_all_indents?date=<?php echo urlencode($date); ?>&branch=<?php echo urlencode($branch); ?>" class="btn btn-success btn-sm mb-3">Approve All</a>
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Product Name</th>
                            <th>Order Qty</th>
                            <th>Date</th>
                            <th>Action</th>
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
                                    <td>
                                        <a class="btn btn-success btn-sm" href="approve_indent.php?date=<?php echo $date; ?>&branch=<?php echo $branch; ?>&productid=<?php echo urlencode($row['productId']); ?>&id=<?php echo urlencode($row['id']); ?>&order_qty=<?php echo urlencode($row['new_order_qty']); ?>">Approve</a>
                                        <a class="btn btn-danger btn-sm" href="reject_indent.php?date=<?php echo $date; ?>&branch=<?php echo $branch; ?>&productid=<?php echo urlencode($row['productId']); ?>&id=<?php echo urlencode($row['id']); ?>&order_qty=<?php echo urlencode($row['new_order_qty']); ?>">Reject</a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>No records found for the selected date and branch.</td></tr>";
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
