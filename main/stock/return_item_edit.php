<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
$dateToday = date("Y-m-d");
$userId = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectedDate'])) {
    $dateToday = $_POST['selectedDate'];
}

// Fetch today's added stock
$todaysStockQuery = "SELECT ts.date,ts.qty,tp.productname as product,tp.size as size,tp.saleprice as saleprice FROM tblstockreturn ts
                      join tblproducts tp on tp.id=ts.product
                      WHERE date = '$dateToday' and ts.userID='$userId'";
$todaysStockResult = mysqli_query($conn, $todaysStockQuery);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Manage Entry</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Stock Entry</h2> 
                    </div>
                    <div class="body">
                        <form method="POST">
                            <div class="row clearfix">
                                <div class="col-lg-3 my-2">
                                    <label>Date</label>
                                    <input type="date" name="date" id="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Select Product</label>
                                    <select name="product" class="form-control select2" id="product">
                                        <option value="">Select Item</option>
                                        <?php
                                            $get_p = mysqli_query($conn, "SELECT id, productname, size, barcode, saleprice FROM tblproducts WHERE status='1'");
                                            while($product = mysqli_fetch_array($get_p)){
                                                echo "<option value='{$product['id']}'>{$product['productname']} ({$product['size']}) ({$product['barcode']}) (₹{$product['saleprice']})</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Recorded Quantity</label>
                                    <input type="number" name="exstqty" readonly id="exstqty" class="form-control">
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label>Returned Quantity</label>
                                    <input type="number" name="qty" id="qty" class="form-control" required>
                                </div>
                                <div class="col-lg-3 my-2" hidden>
                                    <input type="text" name="id" id="id" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-success btn-sm" onclick="window.location.reload();">
                                <i class="icon-refresh"></i>  ReLoad
                                </button>
                                <button type="button" class="btn btn-success btn-sm ml-3" onclick="updatestock()">
                                    <i class="fa fa-check-circle"></i> Update Stock
                                </button>
                                <button type="button" class="btn btn-danger btn-sm ml-3" onclick="removestock()">
                                    <i class="icon-trash"></i> Remove Stock
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>My Stock</h2> 
                    </div>
                    <div class="body">
                    <form method="POST" action="">
                        <div class="row clearfix">
                            <div class="col-lg-3 my-2">
                                <label>Date</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="date" name="selectedDate" value="<?php echo $dateToday; ?>" class="form-control" required>
                                    <button type="submit" class="btn btn-primary  ml-2">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Table to show today's added stock -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Stock Returned</h2>
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
                                $amount=0;
                                if (mysqli_num_rows($todaysStockResult) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($todaysStockResult)) {
                                        echo "<tr>
                                            <td>{$count}</td>
                                            <td>{$row['date']}</td>
                                            <td>{$row['product']}({$row['size']})(&#8377;{$row['saleprice']})</td>
                                            <td>{$row['qty']}</td>
                                        </tr>";
                                        $count++;
                                        $amount+=($row['saleprice']*$row['qty']);
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No stock added today</td></tr>";
                                }
                                ?>
                            </tbody>
                            <h6>Stock Returned Worth of :&#8377;<?php echo $amount;?> on <?php echo $dateToday;?></h6>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

function removestock() {
    var id = document.getElementById('id').value.trim();

    if (!id) {
        Toastify({
            text: "Select Product to remove !",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #dc3545, #c82333)", // Red for error
            stopOnFocus: true,
        }).showToast();
        return;
    }

    var data = { id: id };

    $.ajax({
        url: '../get_ajax/stockMng/update_return_to_zero.php',
        type: 'POST',
        data: data,
        success: function(response) {
            Toastify({
                text: "Stock updated successfully!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #28a745, #218838)", // Green for success
                stopOnFocus: true,
            }).showToast();
        },
        error: function() {
            $('#exstqty').val('Error');
        }
    });
}

function updatestock() {
    var id = document.getElementById('id').value.trim();
    var qty = document.getElementById('qty').value.trim();

    if (!id || !qty) {
        Toastify({
            text: "Error: Quantity is required!",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #dc3545, #c82333)", // Red for error
            stopOnFocus: true,
        }).showToast();
        return;
    }

    var data = { id: id, qty: qty };

    $.ajax({
        url: '../get_ajax/stockMng/update_return_stock.php',
        type: 'POST',
        data: data,
        success: function(response) {
            Toastify({
                text: "Stock updated successfully!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #28a745, #218838)", // Green for success
                stopOnFocus: true,
            }).showToast();
            
        },
        error: function() {
            $('#exstqty').val('Error');
        }
    });
}


$(document).ready(function() {
    $('.select2').select2();

    // Fetch existing quantity when a product is selected
    $('#product').change(function() {
        var productID = $(this).val();
        var date = $('#date').val();
        var data = { 
            product: productID,
            date: date
        };

        if (productID) {
            $.ajax({
                url: '../get_ajax/stockMng/get_returned_product_records.php',
                type: 'POST',
                data: data,
                dataType: 'json', // Ensure response is treated as JSON
                success: function(response) {
                    if (response && response.length > 0) { 
                        $('#id').val(response[0].id);
                        $('#exstqty').val(response[0].qty);
                    } else {
                        $('#id').val(0);
                        $('#exstqty').val(0);
                        
                        // Show error toast if no stock found
                        Toastify({
                            text: "No stock found on this date!",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #dc3545, #c82333)", // Red for error
                            stopOnFocus: true,
                        }).showToast();
                    }
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
