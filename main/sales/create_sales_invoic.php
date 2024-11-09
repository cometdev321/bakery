<?php 
    include('../common/header2.php');
    include('../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');

?>
<style>
#suggestions {
    position: absolute;
    width: 100%;
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
}

#suggestions .suggestion-box {
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
    cursor: pointer;
    background-color: #f9f9f9;
}

#suggestions .suggestion-box:hover,
#suggestions .suggestion-box.suggestion-selected {
    background-color: #e9e9e9;
}

/* Optional: Hide last border for a cleaner look */
#suggestions .suggestion-box:last-child {
    border-bottom: none;
}
</style>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a>Create Sales Invoice</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Create Sales Invoice</li>
                    </ul>
                </div>
                <label class="control-inline fancy-checkbox">
                    <input type="checkbox" id="posActive" name="posActive" checked>
                    <span>Automatic Invoice</span>
                </label>
            </div>
        </div>
    </div>
    <form action="" method="post">
        
        <div class="card planned_task">
        <form action="" method="post">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 my-2">
                        <label>Add Product</label>
                        <select  name="barcodeproduct" class="form-control show-tick ms select2"
                        onchange="addRow(this.options[this.selectedIndex].dataset.id,this.options[this.selectedIndex].dataset.name,this.options[this.selectedIndex].dataset.price,this.options[this.selectedIndex].dataset.sizetype,
                            this.options[this.selectedIndex].dataset.gst)"
                            id="barcodeproduct">
                            <option value="null">Select Item</option>
                            <?php
                                $get_p = mysqli_query($conn, "SELECT `saleprice`,`size`,`productname`,`HSN`,`id`,`openingstock`,`gst`,`barcode` FROM tblproducts  where status='1'");
                                while($product = mysqli_fetch_array($get_p)){
                                    ?>
                                <option value="<?php echo $product['id']; ?>" 
                                data-Existingqty="<?php echo $product['openingstock']; ?>"
                                data-hsn="<?php echo $product['HSN']; ?>"
                                data-id="<?php echo $product['id']; ?>"
                                data-name="<?php echo $product['productname']; ?>"
                                data-price="<?php echo $product['saleprice']; ?>"
                                data-sizetype="<?php echo $product['size']; ?>"
                                data-gst="<?php echo $product['gst']; ?>"
                                >
                                <?php echo $product['productname']; ?>&nbsp;(<?php echo $product['size']; ?>)&nbsp;(<?php echo $product['barcode']; ?>)</option>
                                <?php
                                }
                                ?> 
                            </select>
                        </div>
                </div>
            </div>
    </div>
    <div class="card planned_task">
    <div class="body">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12 my-2">
                <label>Party</label>
                <input type="text" id="partySelect" class="form-control show-tick ms select2" name="party_name"
                placeholder="Enter party name">
                <input type="text" hidden id="party_id" name="party_id">
                <div id="suggestions"></div>
                <!-- <select class="form-control show-tick ms select2" data-placeholder="Select" name="party_name" id="partySelect" onchange="handleSelectChange(this.value, this.options[this.selectedIndex].dataset.mobno),clear_product_error()">
                    <option value="add_new" class="btn btn-secondary btn-sm">Add New Party</option>
                                                </select> -->
                        <small id="party_errorMessage" class="text-danger" style="display: none;">Select Party</small>
                    </div>
                    <div class="col-lg-3 col-md-12 my-2">
                        <label>Party Mobile Number</label>
                        <input type="number" name="party_mobno" placeholder="Type here" id="party_mobno"
                            class="form-control">
                    </div>
                    <?php
                        $query1 = "SELECT `sales_invoice_number` FROM `tblsalesinvoices` where `userID`='$session' and status='1' ORDER BY `id` DESC LIMIT 1 ";
                        $result1 = mysqli_query($conn, $query1);
                                                
                        if ($result1 && mysqli_num_rows($result1) > 0) {
                            $row = mysqli_fetch_assoc($result1);
                            $lastInvoiceNumber = $row['sales_invoice_number'];
                            $nextInvoiceNumber = $lastInvoiceNumber + 1;
                        }else{
                            $nextInvoiceNumber=1;
                        }
                                                
                    ?>

                    <!-- Update the "Sale Invoice Number" input field -->
                    <div class="col-lg-3 col-md-12 my-2">
                        <label>Sale Invoice Number</label>
                        <input type="number" readonly name="saleprice" id="sale_invoice_number"
                            value="<?php echo $nextInvoiceNumber; ?>" class="form-control" required>
                    </div>

                    <div class="col-lg-3 col-md-12  my-2">
                        <label>Sales Invoice Date</label>
                        <input type="date" name="sales_invoice_date" id="sales_invoice_date"
                            value="<?php echo date("Y-m-d") ?>" class="form-control" required>
                    </div>
                </div>
            </div>
    </div>

 


    <div class="card planned_task">
        <div class="body">
            <div class="body table-responsive">
                <table class="table table-bordered  table-striped table-hover" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Item Name</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Sales Price</th>
                            <th>Tax</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sl.No</th>
                            <th>Item Name</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Sales Price</th>
                            <th>Tax</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody id="table-body">

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card planned_task">

        <div class="body">
            <div class="row clearfix">

                <div class="col-lg-2 col-md-12 my-2">
                    <label>Sub-Total</label>
                    <input type="text" name="subtotal" placeholder="---" id="subtotal" readonly class="form-control">
                </div>
                <div class="col-lg-2 col-md-12 my-2">
                    <label>Add-Discount</label>
                    <input type="number" name="total_discount" value="0" placeholder="Type Here"
                        onkeyup="calculate_total_discount()" id="discount" class="form-control">
                </div>
                <div class="col-lg-2 col-md-12 my-2">
                    <label>After Discount Total</label>
                    <input type="text" name="total" id="total" readonly class="form-control">
                </div>

                <div class="col-lg-2 col-md-12 my-2">
                    <center>
                        <label>Mark As Fully Paid</label><br>
                        <label class="control-inline fancy-checkbox">
                            <input id="received_pay" type="checkbox" value="No" name="paid_checkbox" checked
                                onclick="update_paid()" data-parsley-mincheck="2"
                                data-parsley-errors-container="#error-checkbox2" data-parsley-multiple="checkbox2">

                            <span></span>
                        </label>
                    </center>
                </div>

                <div class="col-lg-2 col-md-12 my-2">
                    <label>Amount Received</label>
                    <div class="input-group">
                        <input type="text" id="amount_received" name="amount_received" readonly class="form-control"
                            aria-label="Text input with select button" fdprocessedid="nnp09r">
                        <div class="input-group-append">
                            <select class="custom-select" required name="amount_received_type" disabled
                                id="amount_received_type" aria-label="Select dropdown" fdprocessedid="dgdb28">
                                <option selected value="cash">Cash</option>
                                <option value="bank">Bank</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-lg-2 col-md-12 my-2">
                    <label>Total Balance</label>
                    <input type="text" name="balance_total" id="balance_total" readonly class="form-control">
                </div>

            </div>
            <div class="row">&nbsp;</div>
            <div class="row">&nbsp;</div>
            <div class="row">&nbsp;</div>
            <div class="row clearfix" style="float: right;">
                <button type="button" class="btn btn-success mx-2" id="save_sales" onclick="create_sales_invoice()">
                    <i class="fa fa-check-circle"></i> <span>Save Sales Invoice</span>

                </button>
                <button type="button" class="btn btn-primary" onclick="location.reload()">
                    <i class="icon-refresh"></i> <span></span>
                </button>

            </div>
            <div class="my-2">&nbsp;</div>
        </div>
    </div>
</div>
<div class="">
    <div class="my-2">&nbsp;</div>
    <form id="salesInvoice" action="../invoice/print" method="POST" style="display: none;">
        <input type="text" hidden name="sale_id" id="sale_id">
    </form>
    <form id="PosInvoice" action="../invoice/posprint" method="POST" style="display: none;">
        <input type="text" hidden name="sale_id" id="Pos_sale_id">
    </form>
    <form id="edit_salesInvoice" action="edit_invoice" method="POST" style="display: none;">
        <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
    </form>

</div>
<script>
function submitSalePosForm(val) {
    document.getElementById('Pos_sale_id').value = val;
    document.getElementById('PosInvoice').submit();
}

function submitSaleInvoiceForm(val) {
    document.getElementById('sale_id').value = val;
    document.getElementById('salesInvoice').submit();
}

function edit_invoice(val) {
    document.getElementById('edit_sale_id').value = val;
    document.getElementById('edit_salesInvoice').submit();
}
</script>
</div>
<div class="my-2">&nbsp;</div>
</div>
<form id="posInvoicePrint" action="../invoice/posprint" method="POST" style="display: none;">
    <input type="text" hidden name="new_sale_id" id="new_sale_id">
</form>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const checkbox = document.getElementById('posActive');

    // Function to update the checkbox value
    function updateCheckboxValue() {
        checkbox.value = checkbox.checked ? 'on' : 'off';
    }

    // Initial setting of the value when the page loads
    updateCheckboxValue();

    // Add an event listener to update the value when the checkbox is clicked
    checkbox.addEventListener('change', updateCheckboxValue);
});
</script>

<script>
    // Apply select2 on page load
$(document).ready(function() {
    $('#barcodeproduct').select2({
        placeholder: "Select Item",
        allowClear: true // Allows clearing the selection
    });
});

document.addEventListener('keydown', function(event) {
    if (event.ctrlKey && event.key === 'y') {
        event.preventDefault();
        addRow();
    }
    if (event.key === "-") {
        event.preventDefault();
    }
});


let rowCount = 1;


// Function to add a new row to the table
function addRow(id,name,price, sizetype, gst) {

    
    const rowId = 'row-' + rowCount;
    const newRow = document.createElement('tr');
    newRow.id = rowId;
    newRow.className = 'gradeA';
    
    const newRowContent =
    '<td><input type="text" class="form-control" id="' + rowCount + '" value="' + rowCount +
    '" name="slno[]" readonly></td>' +
    '<td><input type="text" style="width:200px" class="form-control" id="itemname-' + rowCount +
        '"  name="product[]" type="text" value="'+name+'('+sizetype+')" readonly>'+
        '<input type="text" style="width:200px" class="form-control" id="itemname-' + rowCount +
        '"  name="itemname[]" type="text" value="'+id+'" hidden></td>' +
        '<td><input type="text" style="width:100px" class="form-control" value="'+sizetype+'" id="sizetype-' + rowCount +
        '"  name="size[]" type="text" readonly></td>' +
        '<td><input type="number" style="width:100px" class="form-control" id="qty-' + rowCount +
        '" value="1" name="qty[]" onkeyup="update_amount(' + rowCount + ')" required></td>' +
        '<td><input type="text" style="width:100px" class="form-control" id="price-' + rowCount +
        '" readonly name="price[]" value="0" onkeyup="update_amount(' + rowCount + ')" required></td>' +
        '<td><input type="text" style="width:100px" class="form-control" value="'+gst+'" readonly id="tax-' + rowCount +
        '" name="tax[]" value="0" onkeyup="update_amount(' + rowCount + ')" required></td>' +
        '<td><input type="text" style="width:100px" class="form-control" id="amount-' + rowCount +
        '" name="amount[]" value="0" readonly></td>' +
        '<td><button type="button" onclick="deleteRow(' + rowCount +
        ')" class="btn btn-danger"><i class="icon-trash"></i></button></td>';
        
        
    newRow.innerHTML = newRowContent;
    document.getElementById('table-body').appendChild(newRow);
    
    // Initialize Select2 for the new select element
   // const selectElement = newRow.querySelector('select[name="itemname[]"]');
    
    //$(selectElement).select2();
    //addRow();
   // document.getElementById('add-row-btn').disabled = true;
    //getproducts(rowCount);
    const selectElement = document.getElementById("barcodeproduct");

    selectElement.selectedIndex = 0; // Clears the selection by setting it to the first option
    selectElement.focus(); 
     $('#barcodeproduct').select2('open'); 
    update_price(price,sizetype,rowCount,gst)
    calculate_total_discount();
    rowCount++;
}

function update_price(val, sizetype, row, gst) {
    if (!isNaN(val)) {
        if (gst < 0) {
            gst = 0;
        }
        console.log(val,sizetype,row,gst)
        // document.getElementById(`hsn-${row}`).value = hsn;
        document.getElementById(`price-${row}`).value = val;
        document.getElementById(`sizetype-${row}`).value = sizetype;
        document.getElementById(`tax-${row}`).value = gst;
        update_amount(rowCount);
        // document.getElementById('add-row-btn').disabled = false;
    } else {
        document.getElementById(`price-${row}`).value = '';
        document.getElementById('add-row-btn').disabled = true;
    }
    calculate_total_discount();
    update_paid();
}

function create_sales_invoice() {
    let party = party_id.value;
    let party_mob = party_mobno.value;
    let sale_invoice_no = sale_invoice_number.value;
    let sale_invoice_date = sales_invoice_date.value;
    let subtotal_value = subtotal.value;
    // let discount_value = 0;
    let discount_value = discount.value;
    let after_discount_total_value = total.value;
    let check_payment_received = received_pay.value;
    let amount_received_value = amount_received.value;
    let balance_total_value = balance_total.value;
    let posActive_value = posActive.value;
    var amount_received_type_value;
    if (!amount_received_type.disabled) {
        amount_received_type_value = amount_received_type.value;
    }

    if (isNaN(balance_total_value) || balance_total_value.trim() === '' || balance_total_value < 0) {
        Toastify({
            text: 'Values entered not correct',
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: 'top', // top, bottom, left, right
            position: 'right', // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
            backgroundColor: 'linear-gradient(to right, #fe8c00, #f83600)', // Use gradient color with red mix
            marginTop: '202px', // corrected to marginTop
            stopOnFocus: true, // Prevents dismissing of toast on hover
            onClick: function() {}, // Callback after click
            style: {
                margin: '70px 15px 10px 15px', // Add padding on the top of the toast message
            },
        }).showToast();
        event.preventDefault();
        return;
    }

    if (!party || party.trim() === '') {
        party_errorMessage.style.display = 'block';
        party_errorMessage.textContent = 'Party name is required.';
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Optional: Add smooth scrolling behavior
        });
        partySelect.focus();
        event.preventDefault();
        return;
    }

    var formData = {
        party: party,
        party_mob: party_mob,
        sale_invoice_no: sale_invoice_no,
        sale_invoice_date: sale_invoice_date,
        subtotal_value: subtotal_value,
        discount_value: discount_value,
        after_discount_total_value: after_discount_total_value,
        check_payment_received: check_payment_received,
        amount_received_value: amount_received_value,
        // amount_remaining_value: amount_remaining,
        amount_received_type_value: amount_received_type_value,
        balance_total_value: balance_total_value,
        PosActive: posActive_value
    };

    // event.preventDefault();
    // return;
    const rows = document.querySelectorAll('#table-body tr');
    const data = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];

        const itemname = row.querySelector('[name="itemname[]"]').value;
        const hsn = 0;
        // const batchno = row.querySelector('[name="batchno[]"]').value;
        // const expiredate = row.querySelector('[name="expiredate[]"]').value;
        // const mafdate = row.querySelector('[name="mafdate[]"]').value;
        const qty = row.querySelector('[name="qty[]"]').value;
        const size = row.querySelector('[name="size[]"]').value;
        const price = row.querySelector('[name="price[]"]').value;
        // const discount = row.querySelector('[name="discount[]"]').value;
        const discount = 0;
        const tax = row.querySelector('[name="tax[]"]').value;
        const amount = row.querySelector('[name="amount[]"]').value;
        if (itemname === 'null') {
            showError = i + 1; //because i start from 0 and rowCount starts from 1
            const errorMessage = document.querySelector(`#product_errorMessage-${showError}`);
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Select the product';
            event.preventDefault();
            return;
        }

        const rowData = {
            itemname,
            // hsn,
            // batchno,
            // expiredate,
            // mafdate,
            qty,
            size,
            price,
            discount,
            tax,
            amount
        };

        data.push(rowData);
    }
    const url = 'functions/insert_sales_invoice.php';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            formData: formData,
            data: data
        })
    };

    // Send the AJAX request and handle the response
    fetch(url, options)
        .then(response => response.text())
        .then(result => {
            if (result === 'error') {
                window.location.href = "sales_invoice?status=error";
                //console.log(result);
            } else if (!isNaN(result)) { // Check if result is a number
                document.getElementById('new_sale_id').value = result;
                document.getElementById('posInvoicePrint').submit();
                //console.log(result);
            } else {
                window.location.href = "sales_invoice?status=success";
                // console.log(result);
            }
        })

        .catch(error => {
            console.error('Error:', error);
        });
}

function calculate_subtotal() {
    let amount = 0;

    for (let i = 1; i <= rowCount; i++) {
        try {
            amount += parseFloat(document.getElementById(`amount-${i}`).value);
        } catch (error) {

        }
    }

    document.getElementById('subtotal').value = parseFloat(amount);
    document.getElementById('total').value = parseFloat(amount);
    document.getElementById('balance_total').value = parseFloat(amount);
}

function calculate_total_discount() {
    calculate_subtotal();
    let val = parseFloat(document.getElementById('discount').value);

    if (isNaN(val)) {
        val = 0;
    }

    document.getElementById('total').value = parseFloat(document.getElementById('subtotal').value) - val;
    document.getElementById('balance_total').value = parseFloat(document.getElementById('subtotal').value) - val;
    update_paid();
}

function update_paid() {
    var checkbox = document.getElementById("received_pay");

    if (checkbox.checked) {
        // document.getElementById('amount_received').value = '0';
        document.getElementById('amount_received').value = document.getElementById('total').value;
        // document.getElementById('balance_total').value -= document.getElementById('amount_received').value;
        document.getElementById('balance_total').value = 0
        document.getElementById("received_pay").value = "Yes";
        var selectElement = document.getElementById('amount_received_type');
        // document.getElementById('amt_remaining').value = 0;

        selectElement.disabled = false;
    } else {
        document.getElementById("received_pay").value = "No";
        document.getElementById('amount_received').value = '0';
        document.getElementById('balance_total').value = document.getElementById('total').value;
        var selectElement = document.getElementById('amount_received_type');
        selectElement.disabled = true;
    }
}




function update_remaining() {
    const tot_val = document.getElementById('balance_total').value;
    const amt_paid = document.getElementById('amount_received').value;

    document.getElementById('amt_remaining').value = tot_val - amt_paid;
}

function update_remaining() {
    const tot_val = document.getElementById('balance_total').value;
    const amt_paid = document.getElementById('amount_received').value;

    let remaining_value = tot_val - amt_paid;
    if (amt_paid > tot_val) {
        document.getElementById('save_sales').disabled = true;
    } else {
        document.getElementById('save_sales').disabled = false;
    }
    document.getElementById('amt_remaining').value = remaining_value;
}

function update_amount(row) {
    const qtyInput = document.getElementById(`qty-${row}`);
    const priceInput = document.getElementById(`price-${row}`);
    const discountInput = document.getElementById(`discount-${row}`);
    const taxInput = document.getElementById(`tax-${row}`);
    const amountInput = document.getElementById(`amount-${row}`);

    const qty = parseFloat(qtyInput.value);
    const price = parseFloat(priceInput.value);
    const discount = 0
    // const discount = parseFloat(discountInput.value);
    const tax = parseFloat(taxInput.value);
    let subtotal = (qty * price) - discount;
    let amount = subtotal + (subtotal * tax / 100);
    amount = subtotal; //skipping gst adding again
    amountInput.value = amount;

    calculate_subtotal();
}

function deleteRow(row) {
    const rowId = `row-${row}`;
    const rowElement = document.getElementById(rowId);
    rowElement.remove();
    calculate_total_discount();
}

function getparties() {
    $.ajax({
        url: "../get_ajax/get_party_name.php",
        method: "GET",
        success: function(response) {
            $("#partySelect").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
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
    category_errorMessage.style.display = 'none';
    sale_errorMessage.style.display = 'none';
    product_errorMessage.style.display = 'none';
    party_errorMessage.style.display = 'none';
    const errorMessage = document.querySelector(`#product_errorMessage-${val}`);
    errorMessage.style.display = 'none';
}

function check_product_data() {
    let categoryName = category.value;
    let productName = productNameInput.value;
    let salePrice = salePriceInput.value;

    let category_errorMessage = document.getElementById('category_errorMessage');
    let sale_errorMessage = document.getElementById('sale_errorMessage');
    let product_errorMessage = document.getElementById('product_errorMessage');

    if (categoryName === 'null') {
        category_errorMessage.style.display = 'block';
        category_errorMessage.textContent = 'Category is required.';
        event.preventDefault();
        return;
    }

    if (productName === '') {
        product_errorMessage.style.display = 'block';
        product_errorMessage.textContent = 'Product name is required.';
        event.preventDefault();
        return;
    }

    if (salePrice === '') {
        sale_errorMessage.style.display = 'block';
        sale_errorMessage.textContent = 'Sale price is required.';
        event.preventDefault();
        return;
    }


    // Create an object to store the form data
    var formData = {
        category: categoryName,
        productName: productName,
        salePrice: salePrice
    };

    // Send AJAX request using jQuery
    $.ajax({
        url: '../get_ajax/add_product_ajax.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response == 'exists') {
                Toastify({
                    text: "Product already exists",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // top, bottom, left, right
                    position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
                    backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)", // Use gradient color with red mix
                    margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
                    stopOnFocus: true, // Prevent dismissing of toast on hover
                    onClick: function() {}, // Callback after click
                }).showToast();
            }

            if (response == 'error') {
                Toastify({
                    text: "Product could not be added.Error Occured",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // top, bottom, left, right
                    position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
                    backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)", // Use gradient color with red mix
                    margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
                    stopOnFocus: true, // Prevent dismissing of toast on hover
                    onClick: function() {}, // Callback after click
                }).showToast();
            }
            if (response == 'product_added') {
                Toastify({
                    text: "Product added successfully",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // top, bottom, left, right
                    position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
                    backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)", // Use gradient color
                    margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
                    stopOnFocus: true, // Prevent dismissing of toast on hover
                    onClick: function() {}, // Callback after click
                }).showToast();
            }


            $('#product_modal').modal('hide');

            try {
                for (let i = 1; i <= rowCount; i++) {
                    getproducts(i);
                }
            } catch (error) {
                console.error("An error occurred:", error);
            }
        },
        error: function() {
            console.log("Error occurred while adding the product.");
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    getparties();
   // addRow();

});


$(document).ready(function() {
    $("#addNewPartyButton").on("click", function() {
        // No suggestion selected; assume new entry
        var newpartySelect = $("#partySelect").val().trim();
        console.log("clicked")
        if (newpartySelect.length > 0) {
            $.ajax({
                url: "../get_ajax/searchParty/getparty.php  ",
                method: "POST",
                data: {
                    new_party: newpartySelect
                },
                success: function(response) {
                    alert("New party added");
                    $("#party_id").val(
                        response); // Assuming the server returns the new party ID
                    $("#suggestions").html(""); // Clear suggestions
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                },
            });
        } else {
            alert("Please enter a party name.");
        }
    });
});
</script>

<!-- Javascript -->
<script src="../js/chooseparty.js"></script>
<script src="../../assets/bundles/libscripts.bundle.js"></script>
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>


<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js -->

<script src="../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<!-- Bootstrap Colorpicker Js -->
<script src="../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js -->
<script src="../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<!-- Bootstrap Tags Input Plugin Js -->
<script src="../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js -->

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>