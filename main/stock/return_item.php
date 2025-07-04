<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
$dateToday = date("Y-m-d");
$userId = $_SESSION['user'];

$toastMessage = ""; // To store toast messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($conn)) {
        die("Database connection not established.");
    }

    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $product = mysqli_real_escape_string($conn, $_POST['product']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $exstqty = mysqli_real_escape_string($conn, $_POST['exstqty']); 

    if (empty($date) || empty($product) || empty($qty) || empty($userId)) {
        $toastMessage = "Please fill all fields.";
    } else if (empty($exstqty) || $exstqty <=0 || $qty>$exstqty) {
        $toastMessage = "Cannot return stock. No existing quantity available or Stock not aviable for return.";
    } else {
        // Check if the product exists for the same user on the same day
        $checkQuery = "SELECT qty FROM tblstockreturn WHERE date = '$date' AND product = '$product' AND userID = '$userId'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // If record exists, update the quantity
            $row = mysqli_fetch_assoc($result);
            $newQty = $row['qty'] + $qty;
            $updateQuery = "UPDATE tblstockreturn SET qty = '$newQty' WHERE date = '$date' AND product = '$product' AND userID = '$userId'";
            if (mysqli_query($conn, $updateQuery)) {
                $toastMessage = "Stock quantity updated successfully.";
            } else {
                $toastMessage = "Error updating stock quantity.";
            }
        } else {
            // If no existing record, insert a new one
            $insertQuery = "INSERT INTO tblstockreturn (date, product, qty, userID) VALUES ('$date', '$product', '$qty', '$userId')";
            if (mysqli_query($conn, $insertQuery)) {
                $toastMessage = "Stock added successfully.";
            } else {
                $toastMessage = "Error adding stock.";
            }
        }
    }
}

// Fetch today's added stock
$todaysStockQuery = "SELECT ts.date, ts.qty, tp.productname as product, tp.size as size, tp.saleprice as saleprice  
                     FROM tblstockreturn ts
                     JOIN tblproducts tp ON tp.id = ts.product
                     WHERE ts.date = '$dateToday' AND ts.userID = '$userId'";
$todaysStockResult = mysqli_query($conn, $todaysStockQuery);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Manage Returns</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Returns</h2> 
                    </div>
                    <div class="body">
                        <form method="POST">
                            <div class="row clearfix">
                                <div class="col-lg-3 my-2">
                                    <label>Date</label>
                                    <input type="date" name="date" id="date" value="<?php echo $dateToday; ?>" class="form-control" required>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Select Product</label>
                                    <select name="product" class="form-control select2" id="product" required>
                                        <option value="">Select Item</option>
                                        <?php
                                        $get_p = mysqli_query($conn, "SELECT id, productname, size, barcode, saleprice FROM tblproducts WHERE status='1'");
                                        while ($product = mysqli_fetch_array($get_p)) {
                                            echo "<option value='{$product['id']}'>{$product['productname']} ({$product['size']}) ({$product['barcode']}) (₹{$product['saleprice']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Existing Quantity</label>
                                    <input type="number" name="exstqty" readonly id="exstqty" class="form-control">
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Return Quantity</label>
                                    <input type="number" name="qty" id="qty" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle"></i> Return Stock
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table to show today's stock returns -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Today's Stock Returns</h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $amount = 0;
                                if (mysqli_num_rows($todaysStockResult) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($todaysStockResult)) {
                                        echo "<tr>
                                                <td>{$count}</td>
                                                <td>{$row['date']}</td>
                                                <td>{$row['product']} ({$row['size']}) (&#8377;{$row['saleprice']})</td>
                                                <td>{$row['qty']}</td>
                                            </tr>";
                                        $amount += ($row['saleprice'] * $row['qty']);
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No stock added today</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <h6>Stock Returned Worth of : &#8377;<?php echo $amount; ?> on <?php echo $dateToday; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2();

    <?php if (!empty($toastMessage)) : ?>
        Toastify({
            text: "<?php echo $toastMessage; ?>",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "<?php echo (strpos($toastMessage, 'successfully') !== false) ? 'linear-gradient(to right, #28a745, #218838)' : 'linear-gradient(to right, #dc3545, #c82333)'; ?>",
            stopOnFocus: true,
        }).showToast();
    <?php endif; ?>

    $('#product').change(function() {
        var productID = $(this).val();
        if (productID) {
            $.ajax({
                url: '../get_ajax/stockMng/get_products_existing_qty.php',
                type: 'POST',
                data: { productID: productID },
                success: function(response) {
                    $('#exstqty').val(response);
                },
                error: function() {
                    $('#exstqty').val('Error');
                }
            });
        } else {
            $('#exstqty').val('');
        }
    });
});
</script>

<!-- Include necessary scripts -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>
<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/select2/select2.min.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>
</html>
