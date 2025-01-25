<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
$adminID = $_SESSION['admin'];
?>

<!-- Add necessary JS and CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
$(document).ready(function() {
  // Fetch products when a category is selected
  $('#category').change(function() {
    var categoryID = $(this).val();
    if (categoryID) {
      $.ajax({
        url: "../get_ajax/products/get_products_by_category.php",
        type: "POST",
        data: { categoryID: categoryID },
        success: function(response) {
          $('#productTable tbody').html(response); // Update the product table with new products
        }
      });
    } else {
      $('#productTable tbody').html(''); // Clear the table if no category is selected
    }
  });
});
</script>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Product</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Manage Product</li>
                    </ul>
                </div>            
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Manage Products</h2>                            
                    </div>
                    <div class="body">
                        <div class="form-group">
                            <!-- Category Dropdown -->
                            <label for="category">Select Category</label>
                            <select id="category" class="form-control">
                                <option value="">Select Category</option>
                                <?php
                                    // Fetch categories from the database
                                    $categoryQuery = "SELECT `id`, `name` FROM tblcategory GROUP BY `name`";
                                    $categoryResult = mysqli_query($conn, $categoryQuery);
                                    while($category = mysqli_fetch_assoc($categoryResult)) {
                                        echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- Product Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="productTable">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Sale Price</th>
                                        <th>Purchase Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Products will be loaded here via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Update sale price on change
    $(document).on('change', '.saleprice-input', function() {
        var productID = $(this).data('productid'); // Get the productID
        var newSalePrice = $(this).val();
        if (isNaN(newSalePrice) || newSalePrice === '') {
            Toastify({
                text: "Invalid input: Please enter a valid number",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "red"
            }).showToast();
            return; // Prevent saving if not a number
        }
        console.log({ 
            productID: productID,
            saleprice: newSalePrice
        })
        $.ajax({
            url: "../get_ajax/products/update_price.php",
            type: "POST",
            data: { 
                productID: productID,
                saleprice: newSalePrice
            },
            success: function(response) {
                response = response.trim();
                if (response == 'success') {
                    Toastify({
                        text: "Sale price updated successfully",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "green"
                    }).showToast();
                } else {
                    Toastify({
                        text: "Error updating sale price",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();
                }
            }
        });
    });

    // Update purchase price on change
    $(document).on('change', '.purchaseprice-input', function() {
        var productID = $(this).data('productid'); // Get the productID
        var newPurchasePrice = $(this).val();
        if (isNaN(newPurchasePrice) || newPurchasePrice === '') {
            Toastify({
                text: "Invalid input: Please enter a valid number",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "red"
            }).showToast();
            return; // Prevent saving if not a number
        }
        $.ajax({
            url: "../get_ajax/products/update_price.php",
            type: "POST",
            data: {
                productID: productID,
                purchaseprice: newPurchasePrice
            },
            success: function(response) {
                response = response.trim();
                if (response == 'success') {
                    Toastify({
                        text: "Purchase price updated successfully",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "green"
                    }).showToast();
                } else {
                    Toastify({
                        text: "Error updating purchase price",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();
                }
            }
        });
    });
});

</script>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 
<script src="../../assets/js/pages/ui/dialogs.js"></script>
<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 

<script src="../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>

<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
  <script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
  
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

