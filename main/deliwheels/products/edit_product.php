<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Product</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Product Details</h2>
                    </div>
                    <div class="body">
                        <form id="productForm">
                            <input type="hidden" name="id" id="productId">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" id="productName" placeholder="Enter Product Name" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" id="productPrice" placeholder="Enter Product Price" class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label>HSN</label>
                                <input type="number" id="hsn" placeholder="Enter Product HSN" class="form-control" name="hsn" required>
                            </div>
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" id="productStock" placeholder="Enter Stock Quantity" class="form-control" name="stock" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check-circle"></i> Update
                                </button>
                                <button id="deleteButton" type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function () {
    const productId = new URLSearchParams(window.location.search).get("id");

    // Fetch product details from the API
    $.ajax({
        url: `../../api/dw_products/getsingleproduct.php?id=${productId}`,
        type: "GET",
        contentType: "application/json",
        success: function (response) {
            if (response && response.id) {
                $("#productId").val(response.id);
                $("#productName").val(response.name);
                $("#productPrice").val(response.price);
                $("#productStock").val(response.stock);
                $("#hsn").val(response.hsn); // Populate HSN field
            } else {
                Toastify({
                    text: response.message || "Product not found.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        },
        error: function () {
            Toastify({
                text: "Error fetching product details.",
                duration: 3000,
                backgroundColor: "red",
            }).showToast();
        },
    });

    // Handle product update
    $("#productForm").on("submit", function (event) {
        event.preventDefault();

        const productData = {
            id: $("#productId").val(),
            name: $("#productName").val(),
            price: $("#productPrice").val(),
            stock: $("#productStock").val(),
            hsn: $("#hsn").val(), // Include HSN in the update payload
        };

        $.ajax({
            url: "../../api/dw_products/updateproduct.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(productData),
            success: function (response) {
                const message = response.message;
                Toastify({
                    text: message,
                    duration: 3000,
                    backgroundColor: message.includes("successfully") ? "green" : "red",
                }).showToast();
                if (message === "Product updated successfully.") {
                    window.location.href = "create_product";
                }
            },
            error: function () {
                Toastify({
                    text: "Something went wrong.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            },
        });
    });

    // Handle product deletion
    $("#deleteButton").on("click", function () {
        const productId = $("#productId").val();

        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                url: "../../api/dw_products/updateproduct.php",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({ id: productId, status: 0 }),
                success: function (response) {
                    const message = response.message;
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: message.includes("successfully") ? "green" : "red",
                    }).showToast();
                    if (message === "Product status updated successfully.") {
                        window.location.href = "create_product";
                    }
                },
                error: function () {
                    Toastify({
                        text: "Something went wrong.",
                        duration: 3000,
                        backgroundColor: "red",
                    }).showToast();
                },
            });
        }
    });
});


</script>

<!-- Include your scripts as before -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script> 
<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> 
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script> 
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> 
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>
</html>
