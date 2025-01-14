<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Product</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Product Details</h2>
                    </div>
                    <div class="body">
                         <form id="productForm">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" placeholder="Enter product name" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" placeholder="Enter product price" class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" placeholder="Enter stock quantity" class="form-control" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label>HSN</label>
                                <input type="text" placeholder="Enter HSN code" class="form-control" name="hsn" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Product Details<small>Manage Your Products</small></h2>                            
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="productTable">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>HSN</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>HSN</th>
                                        <th>Edit</th>
                                    </tr>
                                </tfoot>
                                <tbody>
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
        // Fetch products from the API
        $.ajax({
            url: '../../api/dw_products/get_all_product.php', // Update with your API endpoint
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let slno = 1;
                const tbody = $('#productTable tbody');
                tbody.empty(); // Clear existing rows

                data.forEach(function(product) {
                    tbody.append(`
                        <tr>
                            <td>${slno}</td>
                            <td>${product.name}</td>
                            <td>${product.price}</td>
                            <td>${product.stock}</td>
                            <td>${product.hsn}</td>
                            <td>
                                <a href="edit_product?id=${product.id}" class="btn btn-success btn-sm"><i class="icon-pencil"></i></a>
                            </td>
                        </tr>
                    `);
                    slno++;
                });
                loadTabledata();
            },
            error: function() {
                Toastify({
                    text: "Failed to fetch product data.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        });

        $('#productForm').on('submit', function(event) {
            event.preventDefault();

            const productData = {
                name: $('input[name="name"]').val(),
                price: $('input[name="price"]').val(),
                stock: $('input[name="stock"]').val(),
                hsn: $('input[name="hsn"]').val()
            };

            $.ajax({
                url: '../../api/dw_products/create_product.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(productData),
                success: function(response) {
                    const message = response.message;
                    if (message === "Product created successfully.") { 
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: "green",
                        }).showToast();
                        $('#productForm')[0].reset(); // Reset form fields
                        // Optionally, refresh the product table here
                    } else {
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: "red",
                        }).showToast();
                    }
                },
                error: function() {
                    Toastify({
                        text: "Something went wrong.",
                        duration: 3000,
                        backgroundColor: "red",
                    }).showToast();
                }
            });
        });
    });
</script>
