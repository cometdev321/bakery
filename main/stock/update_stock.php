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
    $expire_date = mysqli_real_escape_string($conn, $_POST['expire_date']);

    if (empty($date) || empty($product) || empty($qty) || empty($userId) || empty($expire_date) ) {
        $toastMessage = "Please fill all fields.";
    } else {
        // Check if the product exists for the same user on the same day
        $checkQuery = "SELECT qty FROM tblstock WHERE date = '$date' AND product = '$product' AND userID = '$userId' AND expire_date='$expire_date'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // If record exists, update the quantity
            $row = mysqli_fetch_assoc($result);
            $newQty = $row['qty'] + $qty;
            $updateQuery = "UPDATE tblstock SET qty = '$newQty' WHERE date = '$date' AND product = '$product' AND userID = '$userId' AND expire_date='$expire_date'";
            if (mysqli_query($conn, $updateQuery)) {
                $toastMessage = "Stock quantity updated successfully.";
                echo "<script>window.location.href = 'update_stock?status=success'</script>";

            } else {
                $toastMessage = "Error updating stock quantity.";
                echo "<script>window.location.href = 'update_stock?status=error'</script>";
            }
        } else {
            // If no existing record, insert a new one
            $insertQuery = "INSERT INTO tblstock (date, product, qty,expire_date, userID) VALUES ('$date', '$product', '$qty','$expire_date' ,'$userId')";
            if (mysqli_query($conn, $insertQuery)) {
                $toastMessage = "Stock added successfully.";
                echo "<script>window.location.href = 'update_stock?status=success'</script>";
            } else {
                $toastMessage = "Error adding stock.";
                echo "<script>window.location.href = 'update_stock?status=error'</script>";

            }
        }
    }
}


// Fetch today's added stock
$todaysStockQuery = "SELECT ts.date,ts.qty,tp.productname  as product,tp.size as size,tp.saleprice as saleprice  FROM tblstock ts
                      join tblproducts tp on tp.id=ts.product
                      WHERE date = '$dateToday' and ts.userID='$userId'";
$todaysStockResult = mysqli_query($conn, $todaysStockQuery);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: " sales stored succesfully",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top",
      position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
      backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)", // Use gradient color
      margintop:"202px",
      stopOnFocus: true, // Prevents dismissing of toast on hover
      onClick: function(){}, // Callback after click
       style: {
        margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
      },
    }).showToast();
  }

 
   if (status === 'error') {
    Toastify({
      text: "Something Went Wrong",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // top, bottom, left, right
      position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
      backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)", // Use gradient color with red mix
      stopOnFocus: true, // Prevents dismissing of toast on hover
      onClick: function(){}, // Callback after click
       style: {
        margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
      },
    }).showToast();
  }
});
</script>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Manage Stock</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Stock</h2> 
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
                                <div class="col-lg-2 my-2">
                                    <label>Expire Date</label>
                                    <input type="date" name="expire_date" id="expire_date" value="<?php echo date('Y-m-d',strtotime('+7 days'))?>" class="form-control" required>
                                </div>
                                <div class="col-lg-2 my-2">
                                    <label>Existing Quantity</label>
                                    <input type="number" name="exstqty" readonly id="exstqty" class="form-control">
                                </div>
                                <div class="col-lg-2 my-2">
                                    <label>Adding Quantity</label>
                                    <input type="number" name="qty" id="qty" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check-circle"></i> Update Stock
                                </button>
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
                        <h2>Today's Added Stock</h2>
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
                            <h6>Stock Added Worth of :&#8377;<?php echo $amount;?> on <?php echo $dateToday;?></h6>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2();

    // Show toast notification if there's a message
    <?php if (!empty($toastMessage)) : ?>
        Toastify({
            text: "<?php echo $toastMessage; ?>",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #28a745, #218838)", // Green for success
            stopOnFocus: true,
        }).showToast();
    <?php endif; ?>

    // Fetch existing quantity when a product is selected
    $('#product').change(function() {
        var productID = $(this).val();
        if (productID) {
            $.ajax({
                url: '../get_ajax/stockMng/get_products_existing_qty.php',
                type: 'POST',
                data: { productID: productID },
                success: function(response) {
                    console.log(response)
                    $('#exstqty').val(response); // Set existing quantity
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
