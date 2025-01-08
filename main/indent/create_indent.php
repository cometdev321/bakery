<?php 
    include('../common/header2.php');
    include('../common/sidebar.php');
    date_default_timezone_set('Asia/Kolkata');
?>
<style>
  .required {
    color: red;
  }
  
  .modal-body {
    margin-top: -10px;
  }
</style>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Create Indent</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Create Indent</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card planned_task">
        <div class="body">
            <div class="body table-responsive">
                <table class="table table-bordered table-striped table-hover" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Item Name</th>
                            <th>Existing Qty</th>
                            <th>New Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sl.No</th>
                            <th>Item Name</th>
                            <th>Existing Qty</th>
                            <th>New Order</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody id="table-body">
                    </tbody>
                </table>
                <div class="row">
                <button id="add-row-btn" class="btn btn-primary m-b-15 btn-sm" type="button" onclick="addRow();">
                    Add Item&nbsp;<i class="fa fa-plus"></i> 
                </button>
                <!-- Save Button -->
                    <button class="ml-1 btn btn-success m-b-15 btn-sm" onclick="create_indent();">Save</button>
                </div>
            </div>
        </div>
    </div>
    
   
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function update_price(Existingqty, row) {
    if (Existingqty != null) {
        document.getElementById(`Existingqty-${row}`).value = Existingqty;
        document.getElementById('add-row-btn').disabled = false;
    } else {
        document.getElementById('add-row-btn').disabled = true;
    }
}

let rowCount = 0;

function addRow() {
    rowCount++;
    const rowId = 'row-' + rowCount;
    const newRow = document.createElement('tr');
    newRow.id = rowId;
    newRow.className = 'gradeA';

    const newRowContent = `
        <td><input type="text" class="form-control" id="${rowCount}" value="${rowCount}" name="slno[]" readonly></td>
        <td>
            <select style="width:200px" name="itemname[]" class="form-control show-tick ms select2" id="select_products-${rowCount}" data-placeholder="Select" onchange="update_price(this.options[this.selectedIndex].dataset.existingqty, ${rowCount}), clear_product_error(${rowCount})">
                <option value="null">Select Product</option>
            </select>
            <small id="product_errorMessage-${rowCount}" class="text-danger" style="display: none;">Select Product</small>
        </td>
        <td><input type="text" style="width:100px" readonly class="form-control" id="Existingqty-${rowCount}" value="Select Product" name="Exisitngqty[]" required></td>
        <td><input type="number" style="width:100px" class="form-control" id="qty-${rowCount}" value="1" name="qty[]" required></td>
        <td><button type="button" onclick="deleteRow(${rowCount})" class="btn btn-danger"><i class="icon-trash"></i></button></td>`;

    newRow.innerHTML = newRowContent;
    document.getElementById('table-body').appendChild(newRow);

    const selectElement = newRow.querySelector('select[name="itemname[]"]');
    $(selectElement).select2();

    document.getElementById('add-row-btn').disabled = true;
    getproducts(rowCount);
}

function create_indent() {
    const rows = document.querySelectorAll('#table-body tr');
    const data = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const itemname = row.querySelector('[name="itemname[]"]').value;
        const qty = row.querySelector('[name="qty[]"]').value;

        if (itemname === 'null') {
            const errorMessage = document.querySelector(`#product_errorMessage-${i + 1}`);
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Select the product';
            return;
        }

        const rowData = { productId: itemname, new_order_qty: qty };
        data.push(rowData);
    }

    const url = 'functions/insert_indent.php';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ data: data })  // Make sure you're sending the correct format
    };

    fetch(url, options)
        .then(response => response.text())
        .then(result => {
            if (result === 'error') {
                window.location.href = " ";
            } else if (!isNaN(result)) {
                window.location.href = " ";
            } else {
                window.location.href = " ";
            }
        })
        .catch(error => console.error('Error:', error));
}


function deleteRow(row) {
    const rowId = `row-${row}`;
    const rowElement = document.getElementById(rowId);
    rowElement.remove();
}

function getproducts(val) {
    $.ajax({
        url: "../get_ajax/get_products_sales.php",
        method: "GET",
        success: function(response) {
            $("#select_products-" + val).html(response);
        },
        error: function() {
            console.log("Error occurred while fetching products.");
        }
    });
}

function clear_product_error(val) {
    const errorMessage = document.querySelector(`#product_errorMessage-${val}`);
    errorMessage.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    addRow();
});
</script>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="../../assets/vendor/select2/select2.min.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
