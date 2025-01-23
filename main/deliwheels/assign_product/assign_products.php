<?php
include('../../common/header3.php');
include('../../common/deliwheelsSidebar.php');
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Assign Product</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Assign Product</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Assign Products to Line Man</h2>
                    </div>
                    <div class="body">
                        <form id="assignProductForm">
                            <div class="form-group">
                                <label>Select Line Man</label>
                                <select class="form-control" name="line_man" id="lineManDropdown" required>
                                    <option value="">Select Line Man</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Driver Name & Phone</label>
                                <input type="text" class="form-control" id="driverInfo" readonly>
                            </div>
                            <div class="form-group">
                                <label>Select Product</label>
                                <select class="form-control" id="productDropdown">
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" id="addProductBtn" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Selected Products</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="selectedProductsTable">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>HSN</th>
                                        <th>Available Quantity</th>
                                        <th>Assign Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submitAssignmentBtn" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Assign Products</button>
                            <button type="button" id="updateAssignmentBtn" class="btn btn-warning btn-sm" style="display: none;"><i class="fa fa-refresh"></i> Update Assignment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="editDeliveryId" value="">

        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Deliveries</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="deliveriesTable">
                            <thead>
                                <tr>
                                    <th>Delivery ID</th>
                                    <th>Line Man</th>
                                    <th>Assigned Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div id="trackModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delivery Stock Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Placeholder for dynamic data -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Line Man</th>
                                <th>Delivery ID</th>
                            </tr>
                        </thead>
                        <tbody id="trackModalTableBody">
                            <!-- Data will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>

function finishDelivery(deliveryId) {
    $.ajax({
        url: '../../api/dw_delivery/update_delivery.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ deliveryId: deliveryId }),  // Ensure this is passed as a JSON payload
        success: function(data) {
            if (data.success) {
                alert("Successfully updated the delivery status to finished");
            } else {
                alert('Error updating delivery status: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
}



 

$(document).ready(function() {
    function fetchDeliveries() {
        $.ajax({
            url: '../../api/dw_assign_product/get_all_deliveries.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const deliveriesTable = $('#deliveriesTable tbody');
                deliveriesTable.empty();
                data.forEach(function(delivery) {
                    const products = delivery.products.map(p => `${p.name} (Qty: ${p.quantity})`).join(', ');
                    const row = `
                        <tr data-delivery-id="${delivery.id}">
                            <td>${delivery.id}</td>
                            <td>${delivery.lineManName} (${delivery.lineManPhone})</td>
                            <td>${products}</td>
                            <td>
                                <button class="btn btn-primary btn-sm edit-delivery-btn">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-delivery-btn">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                                <button class="btn btn-success btn-sm finish-delivery-btn" onclick="finishDelivery(${delivery.id})">
                                    <i class="fa fa-check"></i> Finish
                                </button>
                                <button class="btn btn-info btn-sm track-delivery-btn" onclick="trackDelivery(${delivery.id})">
                                    <i class="fa fa-map-marker"></i> Track
                                </button>
                            </td>
                        </tr>
                    `;
                    deliveriesTable.append(row);
                });
            },
            error: function(error) {
            // Check if the error response contains a message from PHP
            if (error.responseJSON && error.responseJSON.error) {
                Toastify({
                    text: "Error: " + error.responseJSON.error,
                    duration: 3000,
                    backgroundColor: "red"
                }).showToast();
            } else {
                // Fallback error message for other errors
                Toastify({
                    text: "Failed to fetch deliveries.",
                    duration: 3000,
                    backgroundColor: "red"
                }).showToast();
            }
        }

        });
    }

    // Initial fetch of deliveries
    fetchDeliveries();

    // Handle Edit Delivery
    $(document).on('click', '.edit-delivery-btn', function() {
        const deliveryId = $(this).closest('tr').data('delivery-id');
        $('#editDeliveryId').val(deliveryId);
        
        // Fetch delivery details
        $.ajax({
            url: `../../api/dw_assign_product/get_delivery_details.php?delivery_id=${deliveryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(delivery) {
                // Populate form with delivery details
                $('#lineManDropdown').val(delivery.line_man_id).change();
                $('#selectedProductsTable tbody').empty();
                delivery.products.forEach(function(product) {
                    const row = `
                        <tr data-id="${product.id}">
                            <td>${product.name}</td>
                            <td>${product.hsn}</td>
                            <td>${product.available_stock}</td>
                            <td>
                                <input type="number" class="form-control assign-quantity" value="${product.quantity}" min="1" max="${product.available_stock}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product-btn"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    $('#selectedProductsTable tbody').append(row);
                });
                $('#submitAssignmentBtn').hide();
                $('#updateAssignmentBtn').show();
            },
            error: function() {
                Toastify({ text: "Failed to fetch delivery details.", duration: 3000, backgroundColor: "red" }).showToast();
            }
        });
    });
    // Handle Update Assignment
    $('#updateAssignmentBtn').on('click', function() {
    const deliveryId = $('#editDeliveryId').val();
    const lineManId = $('#lineManDropdown').val();

    if (!lineManId) {
        Toastify({ text: "Please select a lineman.", duration: 3000, backgroundColor: "red" }).showToast();
        return;
    }

    const updatedProducts = [];
    let isValid = true;

    $('#selectedProductsTable tbody tr').each(function() {
        const productId = $(this).data('id');
        const assignedQuantity = parseInt($(this).find('.assign-quantity').val(), 10);
        const maxQuantity = parseInt($(this).find('.assign-quantity').attr('max'), 10);

        // Check for invalid quantity
        if (isNaN(assignedQuantity) || assignedQuantity <= 0 || assignedQuantity > maxQuantity) {
            isValid = false;
            Toastify({ text: "Invalid quantity for one or more products.", duration: 3000, backgroundColor: "red" }).showToast();
            return false;
        }

        updatedProducts.push({ id: productId, quantity: assignedQuantity });
    });

    if (!isValid) return;


    $.ajax({
        url: '../../api/dw_assign_product/update_delivery.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            delivery_id: deliveryId,
            line_man_id: lineManId,
            products: updatedProducts
        }),
        success: function(response) {
            if (response.success) {
                Toastify({ text: "Delivery updated successfully.", duration: 3000, backgroundColor: "green" }).showToast();
                $('#lineManDropdown').val('');
                $('#selectedProductsTable tbody').empty();
                $('#assignProductBtn').show();
                $('#updateAssignmentBtn').hide();
                fetchDeliveries();
            } else {
                Toastify({ text: response.message, duration: 3000, backgroundColor: "red" }).showToast();
            }
        },
        error: function() {
            Toastify({ text: "Failed to update delivery.", duration: 3000, backgroundColor: "red" }).showToast();
        }
    });
});



    // Handle Delete Delivery
    $(document).on('click', '.delete-delivery-btn', function() {
        const deliveryId = $(this).closest('tr').data('delivery-id');
        if (confirm('Are you sure you want to delete this delivery?')) {
            $.ajax({
                url: '../../api/dw_assign_product/delete_delivery.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ delivery_id: deliveryId }),
                success: function(response) {
                    Toastify({ text: response.message, duration: 3000, backgroundColor: response.message === "Delivery deleted successfully." ? "green" : "red" }).showToast();
                    fetchDeliveries();
                },
                error: function() {
                    Toastify({ text: "Failed to delete delivery.", duration: 3000, backgroundColor: "red" }).showToast();
                }
            });
        }
    });
    const selectedProducts = [];

    // Fetch line men from the API
    $.ajax({
        url: '../../api/dw_employees/getallemployees.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const lineManDropdown = $('#lineManDropdown');
            lineManDropdown.empty();
            lineManDropdown.append('<option value="">Select Line Man</option>');
            data.forEach(function(lineMan) {
                // Show both name and phone number in the dropdown
                lineManDropdown.append(`<option value="${lineMan.id}" data-name="${lineMan.name}" data-phone="${lineMan.mobile}">${lineMan.name} (${lineMan.mobile})</option>`);
            });
        },
        error: function() {
            Toastify({ text: "Failed to fetch line men.", duration: 3000, backgroundColor: "red" }).showToast();
        }
    });

    // Fetch products from the API
    $.ajax({
        url: '../../api/dw_products/get_all_product.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const productDropdown = $('#productDropdown');
            productDropdown.empty();
            productDropdown.append('<option value="">Select Product</option>');
            data.forEach(function(product) {
                // Show both product name and HSN in the dropdown
                productDropdown.append(`<option value="${product.id}" data-stock="${product.stock}" data-hsn="${product.hsn}">${product.name} (HSN: ${product.hsn})</option>`);
            });
        },
        error: function() {
            Toastify({ text: "Failed to fetch products.", duration: 3000, backgroundColor: "red" }).showToast();
        }
    });

    // Update driver info based on selected line man
    $('#lineManDropdown').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const driverName = selectedOption.data('name');
        const driverPhone = selectedOption.data('phone');
        $('#driverInfo').val(`Name: ${driverName}, Phone: ${driverPhone}`);
    });

    // Add product to the table
    $('#addProductBtn').on('click', function() {
        const productId = $('#productDropdown').val();
        const productName = $('#productDropdown option:selected').text().split(' (HSN:')[0];  // Get the product name
        const availableStock = $('#productDropdown option:selected').data('stock');
        const productHSN = $('#productDropdown option:selected').data('hsn');

        if (!productId || selectedProducts.some(p => p.id === productId)) {
            Toastify({ text: "Product already added or not selected.", duration: 3000, backgroundColor: "red" }).showToast();
            return;
        }

        selectedProducts.push({ id: productId, name: productName, stock: availableStock, hsn: productHSN });

        const row = `
            <tr data-id="${productId}">
                <td>${productName}</td>
                <td>${productHSN}</td>
                <td>${availableStock}</td>
                <td>
                    <input type="number" class="form-control assign-quantity" value="1" min="1" max="${availableStock}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-product-btn"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#selectedProductsTable tbody').append(row);
    });

    // Remove product from the table
    $(document).on('click', '.remove-product-btn', function() {
        const row = $(this).closest('tr');
        const productId = row.data('id');
        selectedProducts.splice(selectedProducts.findIndex(p => p.id === productId), 1);
        row.remove();
    });

    // Handle assignment submission
    $('#submitAssignmentBtn').on('click', function() {
        const lineManId = $('#lineManDropdown').val();
        const products = [];

        $('#selectedProductsTable tbody tr').each(function() {
            const productId = $(this).data('id');
            const quantity = $(this).find('.assign-quantity').val();

            // Ensure quantity is a valid number
            if (quantity && !isNaN(quantity) && parseInt(quantity) > 0) {
                products.push({ id: productId, quantity: parseInt(quantity) });
            } else {
                Toastify({ text: "Please enter a valid quantity for all products.", duration: 3000, backgroundColor: "red" }).showToast();
                return false;  // Stop processing further if quantity is invalid
            }
        });

        if (!lineManId || products.length === 0) {
            Toastify({ text: "Please select a line man and products.", duration: 3000, backgroundColor: "red" }).showToast();
            return;
        }

        const assignmentData = { line_man_id: lineManId, products };

        $.ajax({
            url: '../../api/dw_assign_product/assign_product.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(assignmentData),
            success: function(response) {
                const message = response.message;
                Toastify({ text: message, duration: 3000, backgroundColor: message === "Assignment successful." ? "green" : "red" }).showToast();
                if (message === "Assignment successful.") {
                    $('#assignProductForm')[0].reset();
                    $('#selectedProductsTable tbody').empty();
                }
            },
            error: function(xhr, status, error) {
                Toastify({ text: "Something went wrong: " + error, duration: 3000, backgroundColor: "red" }).showToast();
            }
        });
    });


    // Validate assigned quantity
    $(document).on('input', '.assign-quantity', function() {
        const maxStock = $(this).attr('max');
        if (parseInt($(this).val()) > parseInt(maxStock)) {
            $(this).val(maxStock);
        }
    });
});
</script>
