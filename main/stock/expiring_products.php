<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
$dateToday = date("Y-m-d");
$userId = $_SESSION['user'];

// Fetch today's added stock
$expiredate=date('Y-m-d',strtotime('+2 days'));
$todaysStockQuery = "SELECT ts.expire_date,
                            ts.qty,tp.productname  as product,
                            tp.size as size,
                            tp.saleprice as saleprice
                            FROM tblstock ts
                      join tblproducts tp on tp.id=ts.product
                      WHERE ts.userID='$userId' and ts.expire_date<='$expiredate'";
$todaysStockResult = mysqli_query($conn, $todaysStockQuery);
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Expiring Stock</h2>
        </div>



        <!-- Table to show today's added stock -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>About to Expire Stock</h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Expiring On</th>
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
                                            <td>{$row['expire_date']}</td>
                                            <td>{$row['product']}({$row['size']})(&#8377;{$row['saleprice']})</td>
                                            <td>{$row['qty']}</td>
                                        </tr>";
                                        $count++;
                                        $amount+=($row['saleprice']*$row['qty']);
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No stock expiring soon</td></tr>";
                                }
                                ?>
                            </tbody>
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
