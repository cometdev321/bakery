<?php 
    include('../common/header2.php');
    include('../common/cnn.php');
    include('../common/sidebar.php');

    $id=$_POST['edit_purchase_id'];

    
$query = "SELECT si.*, p.name AS `name` 
          FROM tblpurchaseinvoices si
          INNER JOIN tblparty p ON si.party_name = p.id
          WHERE  si.userID = '$session' AND si.status = '1' 
          ORDER BY si.id DESC"; 
          
          $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status === 'success') {
      Toastify({
        text: "Party added successfully",
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
    if (status === 'error') {
      Toastify({
        text: "Party could not be added",
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
    if (status === 'alreadyexists') {
      Toastify({
        text: "Party details already exist!",
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
  });
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Create New Party</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <label for="nameInput"><span class="required">*</span> Name:</label>
          <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter name" required>
        </div>
        <div class="modal-body">
          <label for="mobileInput"><span class="required">*</span> Mobile Number:</label>
          <input type="number" class="form-control" id="mob1" name="mobile" placeholder="Enter mobile number" required onkeyup="update();">
          <small id="mobile_errorMessage" class="text-danger" style="display: none;">Invalid Mobile Number</small>
        </div>
        <div class="modal-body">
          <label for="gstInput">GST Number (Optional):</label>
          <input type="text" class="form-control" id="gstInput" name="gstno" placeholder="Enter GST number" aria-describedby="gstHelpText">
          <small id="gstHelpText" class="form-text text-muted">Example: GSTIN-12**34**56*78ZA</small>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm" id="saveButton" onclick="check_data();" name="add_party">Save</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Create New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <label for="categorySelect"><span class="required">*</span> Category:</label>
            <select class="form-control show-tick ms select2" data-placeholder="Select" name="category" id="category" required onchange="clear_product_error();">
                <option value="null">Select Category</option>
                <?php
                    $getct=mysqli_query($conn,"select name from tblcategory where status='1'  and userID='$session'");
                    while($fetchcat=mysqli_fetch_array($getct)){
                    ?>
                    <option value="<?php echo $fetchcat['name']; ?>"><?php echo $fetchcat['name']; ?></option>
                <?php } ?>
            </select>
            <small id="category_errorMessage" class="text-danger" style="display: none;">Select Category</small>
        </div>
        <div class="modal-body">
          <label for="productNameInput"><span class="required">*</span> Product Name:</label>
          <input type="text" class="form-control" id="productNameInput" name="product_name" placeholder="Enter product name" required onkeyup="clear_product_error();"> 
          <small id="product_errorMessage" class="text-danger" style="display: none;">Type Product Name</small>
        </div>
        <div class="modal-body">
          <label for="purchasePriceInput"><span class="required">*</span> purchase Price:</label>
          <input type="number" class="form-control" id="purchasePriceInput" name="purchase_price" placeholder="Enter purchase price" required onkeyup="clear_product_error();">
          <small id="purchase_errorMessage" class="text-danger" style="display: none;">Type purchase Price</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" id="saveButton" onclick="check_product_data();" name="add_product">Save</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<script>
  function update() {
    mobile_errorMessage.style.display = 'none';
    mob1.style.borderColor = "initial";
  }

  function check_data() {
    let mobno = mob1.value;
    let firstChar = mobno.charAt(0);

    if (mobno.length !== 10) {
      mobile_errorMessage.style.display = 'block';
      mob1.style.borderColor = "red";
      mob1.focus();
      event.preventDefault();
      return;
    }else if (firstChar !== '6' && firstChar !== '7' && firstChar !== '8' && firstChar !== '9') {
      mobile_errorMessage.style.display = 'block';
      mob1.style.borderColor = "red";
      mob1.focus();
      event.preventDefault();
      return;
    }else{
        let name=nameInput.value;
        let gst=gstInput.value;

        var formdata={
            name:name,
            mobno:mobno,
            gstno:gst
        }
        
              $.ajax({
                url: '../get_ajax/create_party_ajax.php',
                type: 'POST',
                data: formdata,
                success: function(response) {
                if(response=='alreadyexists'){
                    Toastify({
                        text: "Party already exists",
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
                
                if(response=='error'){
                    Toastify({
                        text: "Party could not be added.Error Occured",
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
                if(response=='success'){
                     Toastify({
                        text: "Party added successfully",
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
                
                
                
                $('#myModal').modal('hide');
                getparties();
                },
                error: function(xhr, status, error) {
                  console.error('Error: ' + error);
                }
              });
            }

    }
    
    
  
  
    function handleSelectChange(selectElement,val) {
        if (selectElement === 'add_new') {
            $('#myModal').modal('show');
        }else{
          party_name.value=selectElement;
            party_mobno.value=val;
        }
        
    }
   function getproducts(val) {
        $.ajax({
            url: "../get_ajax/get_products_purchase.php",
            method: "GET",
            success: function(response) {
                $("#select_products-" + val).append(response);
            },
            error: function() {
                console.log("Error occurred while fetching products.");
            }
        });
    }

    
</script>

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> purchase Invoice</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active"> purchase Invoice</li>
                        </ul>
                        <br>
                        <button type="button" onclick="deleteInvoice(<?php echo $row['id']; ?>)" class="btn btn-danger"><i class="icon-trash"></i>&nbsp;&nbsp;Delete Invoice</button>
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="card planned_task">
                  <form action="" method="post">
                        <div class="body">
                                 <div class="row clearfix">
                                        <div class="col-lg-3 col-md-12 my-2">
                                            <label>Party</label>
                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="party_name" id="partySelect" onchange="handleSelectChange(this.value, this.options[this.selectedIndex].dataset.mobno),clear_product_error()"> 
                                                <option selected value="<?php echo $row['party_name']; ?>" class="btn btn-secondary btn-sm"><?php echo $row['name']; ?></option>
                                                <option value="add_new" class="btn btn-secondary btn-sm">Add New Party</option>
                                                </select>
                                                <small id="party_errorMessage" class="text-danger" style="display: none;">Select Party</small>
                                             </div>
                                            <div class="col-lg-3 col-md-12 my-2">
                                                <label>Party Mobile Number</label>
                                                <input type="text" name="party_mobno" value="<?php echo $row['party_mobno']; ?>" placeholder="Type here" id="party_mobno"class="form-control" >
                                              </div>

                                                
                                                <!-- Update the "purchase Invoice Number" input field -->
                                                <div class="col-lg-3 col-md-12 my-2">
                                                    <label>purchase Invoice Number</label>
                                                    <input type="number" name="purchaseprice" id="purchase_invoice_number"value="<?php echo $row['purchase_invoice_number']; ?>" class="form-control" readonly>
                                                </div>

                                            <div class="col-lg-3 col-md-12  my-2">
                                                <label>purchase Invoice Date</label>
                                                <input type="date" name="purchase_invoice_date" id="purchase_invoice_date" value="<?php echo $row['purchase_invoice_date']; ?>" class="form-control" readonly>
                                            </div>
                                    </div>

                                    <input hidden type="text" value="<?php echo $row['party_name']; ?>" id="party_name" >
                                    <input hidden type="text" value="<?php echo $id ?>" id="purchase_invoice_id" >
                                  </div>
                        </div>

                <div class="card planned_task">
                    <div class="body">
                        <button id="add-row-btn" class="btn btn-primary m-b-15 btn-sm" type="button" onclick="addRow();">
                           Add Item&nbsp;<i class="fa fa-plus"></i> 
                        </button>
                        <button type="button" value="add_new" class="btn btn-secondary btn-sm m-b-15" onClick="$('#product_modal').modal('show');">Add New Product</button>
                        <div class="body table-responsive">
                            <table class="table table-bordered  table-striped table-hover" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Item Name</th>
                                        <th>HSN</th>
                                        <th>Batch No</th>
                                        <th>Expire Date</th>
                                        <th>Manuf. Date</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Item Name</th>
                                        <th>HSN</th>
                                        <th>Batch No</th>
                                        <th>Expire Date</th>
                                        <th>Manuf. Date</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody id="table-body">
                                <?php
                                $slno = 1;
                                $purchaseInvoiceNum = $row['purchase_invoice_number'];
                                $query1 = "SELECT ts.*,tp.productname as `pname` FROM `tblpurchaseinvoice_details` ts
                                          inner join tblproducts tp on tp.id=ts.ItemName
                                           WHERE ts.purchase_invoice_number='$purchaseInvoiceNum' AND ts.userID='$session' AND ts.status='1' ORDER BY ts.id ASC";
                                $result1 = mysqli_query($conn, $query1);

                                if (mysqli_num_rows($result1) > 0) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                            $product=$row1['ItemName']; 
                                        ?>
                                        <tr id="row-<?php echo $slno; ?>" class="gradeA">
                                        <td>
                                          <input type="text" hidden id="purchaseDetailsId-<?php echo $slno; ?>" value="<?php echo $row1['id']; ?>" name="purchaseID[]">
                                          <input type="text" hidden  value="old" name="type[]">
                                          <input type="text" class="form-control" id="<?php echo $slno; ?>" value="<?php echo $slno; ?>" name="slno[]" readonly></td>
                                            <td>
                                              <select style="width:200px" name="itemname[]" class="form-control show-tick ms select2" id="select_products-<?php echo $slno; ?>" data-placeholder="Select" onchange="update_price(this.options[this.selectedIndex].dataset.hsn,this.options[this.selectedIndex].dataset.price,this.options[this.selectedIndex].dataset.sizetype,<?php echo $slno; ?>),clear_product_error(<?php echo $slno; ?>)">
                                                <option value="<?php echo $row1['ItemName']; ?>"><?php echo $row1['pname']; ?></option>
                                              </select>
                                              <script> getproducts(<?php echo $slno; ?>);</script>
                                            </td>
                                            <td><input type="text" style="width:100px" class="form-control" id="hsn-<?php echo $slno; ?>" value="<?php echo $row1['HSN']; ?>" name="hsn[]"></td>
                                            <td><input type="text" style="width:100px" class="form-control" id="batchno-<?php echo $slno; ?>" value="<?php echo $row1['BatchNo']; ?>" name="batchno[]"></td>
                                            <td><input type="date" style="width:150px" class="form-control" id="expiredate-<?php echo $slno; ?>" value="<?php echo $row1['ExpireDate']; ?>" name="expiredate[]"></td>
                                            <td><input type="date" style="width:150px" class="form-control" id="mafdate-<?php echo $slno; ?>" value="<?php echo $row1['ManufactureDate']; ?>" name="mafdate[]"></td>
                                            <td><input type="text" style="width:100px" class="form-control" id="sizetype-<?php echo $slno; ?>" value="<?php echo $row1['Size']; ?>" readonly name="size[]"></td>
                                            <td><input type="number" style="width:100px" class="form-control" id="qty-<?php echo $slno; ?>" onkeyup="update_amount(<?php echo $slno; ?>)" value="<?php echo $row1['Qty']; ?>" name="qty[]"></td>
                                            <td><input type="number" style="width:100px" class="form-control" id="price-<?php echo $slno; ?>" onkeyup="update_amount(<?php echo $slno; ?>)" readonly value="<?php echo $row1['Price']; ?>" name="price[]"></td>
                                            <td><input type="number" style="width:100px" class="form-control" id="discount-<?php echo $slno; ?>" onkeyup="update_amount(<?php echo $slno; ?>)" value="<?php echo $row1['Discount']; ?>" name="discount[]"></td>
                                            <td><input type="number" style="width:100px" class="form-control" id="tax-<?php echo $slno; ?>" onkeyup="update_amount(<?php echo $slno; ?>)" value="<?php echo $row1['Tax']; ?>" name="tax[]"></td>
                                            <td><input type="number" style="width:100px" class="form-control" id="amount-<?php echo $slno; ?>" value="<?php echo $row1['Amount']; ?>" name="amount[]" ></td>
                                            <td><button type="button" onclick="deletepurchase(<?php echo $slno; ?>,<?php echo $row1['id']; ?>)" class="btn btn-danger"><i class="icon-trash"></i></button></td>
                                        </tr>
                                        <?php
                                        $slno++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td>No Records Found</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <input type="text" id="lastslno" hidden value="<?php echo $slno; ?>">
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
                                                <input type="text" name="subtotal"  id="subtotal" value="<?php echo $row['sub_total']; ?>" readonly class="form-control" >
                                            </div>
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Add-Discount</label>
                                                <input type="number" name="total_discount" value="0" placeholder="Type Here"  value="<?php echo $row['discount']; ?>" onkeyup="calculate_total_discount()" id="discount"  class="form-control" >
                                            </div>
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>After Discount Total</label>
                                                <input type="text" name="total"  id="total"  value="<?php echo $row['after_discount_total']; ?>" readonly class="form-control" >
                                            </div>
                                            
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <center>
                                                <label>Mark As Fully Paid</label><br>
                                                <label class="control-inline fancy-checkbox">
                                            <input id="received_pay" type="checkbox" value="No" <?php $paid=$row['full_paid']; if($paid=='Yes'){echo 'checked';}else{ }?> name="paid_checkbox"  onclick="update_paid()"  data-parsley-mincheck="2" data-parsley-errors-container="#error-checkbox2" data-parsley-multiple="checkbox2">
                                        <span></span>
                                            </label>
                                                </center>
                                            </div>
                                            
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Amount Received</label>
                                                <div class="input-group">
                                                    <input type="text"  id="amount_received"  value="<?php echo $row['amount_received']; ?>" name="amount_received" readonly  class="form-control" aria-label="Text input with select button" fdprocessedid="nnp09r">
                                                    <div class="input-group-append">
                                                        <select class="custom-select" required name="amount_received_type" disabled id="amount_received_type" aria-label="Select dropdown" fdprocessedid="dgdb28">
                                                            <option selected value="<?php echo $row['amount_received_type']; ?>"><?php echo strtoupper($row['amount_received_type']); ?></option>
                                                            <option  value="cash">Cash</option>
                                                            <option value="bank">Bank</option>
                                                            <option value="cheque">Cheque</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            
                     
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Total Balance</label>
                                                <input type="text" name="balance_total"  value="<?php echo $row['total_balance']; ?>" id="balance_total" readonly class="form-control" >
                                            </div>
                                            
                                    </div>
                                    <div class="row">&nbsp;</div>
                                    <div class="row">&nbsp;</div>
                                    <div class="row">&nbsp;</div>
                                    <div class="row clearfix" style="float: right;">
                                      <button type="button" class="btn btn-success mx-2" onclick="create_purchase_invoice()">
                                        <i class="fa fa-check-circle"></i> <span>Save purchase Invoice</span>
                                      </button>
                                      <button type="button" class="btn btn-primary" onclick="location.reload()">
                                        <i class="icon-refresh"></i> <span></span>
                                      </button>

                                    </div>
                                        <div class="my-2">&nbsp;</div>
                            </div>
                        </div>
<div class="">
  <div class="my-2">&nbsp;</div>

  </div>
  <div class="my-2">&nbsp;</div>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('number')) {
                if (event.target.value === '') {
                    event.target.value = 0;
                }
            }
        });
    </script>
<script>
    let rowCount = document.getElementById('lastslno').value-1;

    // Function to add a new row to the table
    function addRow() {
        rowCount++;

        const rowId = 'row-' + rowCount;
        const newRow = document.createElement('tr');
        newRow.id = rowId;
        newRow.className = 'gradeA';

        const newRowContent =
            '<td><input type="text" hidden name="purchaseID[]" ><input type="text" hidden value="new" name="type[]"><input type="text" class="form-control" id="' + rowCount + '" value="' + rowCount + '" name="slno[]" readonly></td>' +
            '<td>' +
            '  <select style="width:200px" name="itemname[]" class="form-control show-tick ms select2" id="select_products-' + rowCount + '" data-placeholder="Select" onchange="update_price(this.options[this.selectedIndex].dataset.hsn,this.options[this.selectedIndex].dataset.price,this.options[this.selectedIndex].dataset.sizetype,' + rowCount + '),clear_product_error(' + rowCount + ')">' +
            '    <option value="null">Select Product</option>' +
            '  </select>' +
            '  <small id="product_errorMessage-' + rowCount + '" class="text-danger" style="display: none;">Select Product</small>' +
            '</td>' +
            '<td><input type="text" style="width:100px" class="form-control" id="hsn-' + rowCount + '" name="hsn[]"></td>' +
            '<td><input type="text" style="width:100px" class="form-control" id="batchno-' + rowCount + '" name="batchno[]"></td>' +
            '<td><input type="date" style="width:150px" class="form-control" id="expiredate-' + rowCount + '" name="expiredate[]"></td>' +
            '<td><input type="date" style="width:150px" class="form-control" id="mafdate-' + rowCount + '" name="mafdate[]"></td>' +
            '<td><input type="text" style="width:100px" class="form-control" id="sizetype-' + rowCount + '"  name="size[]" type="text" readonly></td>' +
            '<td><input type="number" style="width:100px" class="form-control" id="qty-' + rowCount + '" value="1" name="qty[]" onkeyup="update_amount(' + rowCount + ')" required></td>' +
            '<td><input type="number" style="width:100px" class="form-control" id="price-' + rowCount + '" readonly name="price[]" value="0" onkeyup="update_amount(' + rowCount + ')" required></td>' +
            '<td><input type="number" style="width:100px" class="form-control" id="discount-' + rowCount + '" name="discount[]" value="0" onkeyup="update_amount(' + rowCount + ')" required></td>' +
            '<td><input type="number" style="width:100px" class="form-control" id="tax-' + rowCount + '" name="tax[]" value="0" onkeyup="update_amount(' + rowCount + ')" required></td>' +
            '<td><input type="number" style="width:100px" class="form-control" id="amount-' + rowCount + '" name="amount[]" value="0" readonly></td>' +
            '<td><button type="button" onclick="deleteRow(' + rowCount + ')" class="btn btn-danger"><i class="icon-trash"></i></button></td>';


        newRow.innerHTML = newRowContent;
        document.getElementById('table-body').appendChild(newRow);

        // Initialize Select2 for the new select element
        const selectElement = newRow.querySelector('select[name="itemname[]"]');
        $(selectElement).select2();

        document.getElementById('add-row-btn').disabled = false;
        getproducts(rowCount);
        calculate_total_discount();
    }
    
    function update_price(hsn,val,sizetype,row) {
        if (!isNaN(val)) {
            document.getElementById(`hsn-${row}`).value = hsn;
            document.getElementById(`price-${row}`).value = val;
            document.getElementById(`sizetype-${row}`).value = sizetype;
            update_amount(row);
            document.getElementById('add-row-btn').disabled = false;
        } else {
            document.getElementById(`price-${row}`).value = '';
            document.getElementById('add-row-btn').disabled = true;
        }
        calculate_total_discount();
        update_paid();
        
    }
    
function create_purchase_invoice() {
  
  let purchaseId = purchase_invoice_id.value;
  let party = party_name.value;
  let party_mob = party_mobno.value;
  let purchase_invoice_no = purchase_invoice_number.value;
  let purchase_invoice_date = purchase_invoice_date.value;
  let subtotal_value = subtotal.value;
  let discount_value = discount.value;
  let after_discount_total_value = total.value;
  let check_payment_received = received_pay.value;
  let amount_received_value = amount_received.value;
  let balance_total_value = balance_total.value;
  var  amount_received_type_value;
    if (!amount_received_type.disabled) {
      amount_received_type_value = amount_received_type.value;
    }



  var formData = {
    purchaseId:purchaseId,
    party: party,
    party_mob: party_mob,
    purchase_invoice_no: purchase_invoice_no,
    purchase_invoice_date: purchase_invoice_date,
    subtotal_value: subtotal_value,
    discount_value: discount_value,
    after_discount_total_value: after_discount_total_value,
    check_payment_received: check_payment_received,
    amount_received_value: amount_received_value,
    amount_received_type_value: amount_received_type_value,
    balance_total_value: balance_total_value
  };

    // console.log(formData)
    // event.preventDefault();
    // return;
  const rows = document.querySelectorAll('#table-body tr');
  const data = [];

  for (let i = 0; i < rows.length; i++) {
    const row = rows[i];

    const purchaseID = row.querySelector('[name="purchaseID[]"]').value;
    const type = row.querySelector('[name="type[]"]').value;
    const itemname = row.querySelector('[name="itemname[]"]').value;
    const hsn = row.querySelector('[name="hsn[]"]').value;
    const batchno = row.querySelector('[name="batchno[]"]').value;
    const expiredate = row.querySelector('[name="expiredate[]"]').value;
    const mafdate = row.querySelector('[name="mafdate[]"]').value;
    const qty = row.querySelector('[name="qty[]"]').value;
    const size = row.querySelector('[name="size[]"]').value;
    const price = row.querySelector('[name="price[]"]').value;
    const discount = row.querySelector('[name="discount[]"]').value;
    const tax = row.querySelector('[name="tax[]"]').value;
    const amount = row.querySelector('[name="amount[]"]').value;

    if (itemname === 'null') {
        showError=i+1;//because i start from 0 and rowCount starts from 1
      const errorMessage = document.querySelector(`#product_errorMessage-${showError}`);
      errorMessage.style.display = 'block';
      errorMessage.textContent = 'Select the product';
      event.preventDefault();
      return;
    }
    const rowData = {
      purchaseID,
      type,
      itemname,
      hsn,
      batchno,
      expiredate,
      mafdate,
      qty,
      size,
      price,
      discount,
      tax,
      amount
    };

    data.push(rowData);
  }
  console.log(data);
  const url = 'functions/update_invoice.php';
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ formData: formData, data: data })
  };

  // Send the AJAX request and handle the response
  fetch(url, options)
    .then(response => response.text())
    .then(result => {
      if (result === 'error') {
        Toastify({
          text: "Party could not be added. Error Occurred",
          duration: 3000,
          newWindow: true,
          close: true,
          gravity: "top",
          position: "right",
          backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)",
          margin: "70px 15px 10px 15px",
          stopOnFocus: true,
          onClick: function() {},
        }).showToast();
        window.location.href = "purchase_invoice?status=error";
      } else if (result === 'success') {
        Toastify({
          text: "Party added successfully",
          duration: 3000,
          newWindow: true,
          close: true,
          gravity: "top",
          position: "right",
          backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)",
          margin: "70px 15px 10px 15px",
          stopOnFocus: true,
          onClick: function() {},
        }).showToast();
        window.location.href = "purchase_invoice?status=success";
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
            document.getElementById('amount_received').value = document.getElementById('total').value;
            document.getElementById('balance_total').value -= document.getElementById('amount_received').value;
            document.getElementById("received_pay").value="Yes";
            var selectElement = document.getElementById('amount_received_type');
            selectElement.disabled = false;
        } else {
            document.getElementById("received_pay").value="No";
            document.getElementById('amount_received').value = '0';
            document.getElementById('balance_total').value = document.getElementById('total').value;
             var selectElement = document.getElementById('amount_received_type');
            selectElement.disabled = true;
        }
    }

    function update_amount(row) {
        const qtyInput = document.getElementById(`qty-${row}`);
        const priceInput = document.getElementById(`price-${row}`);
        const discountInput = document.getElementById(`discount-${row}`);
        const taxInput = document.getElementById(`tax-${row}`);
        const amountInput = document.getElementById(`amount-${row}`);

        const qty = parseFloat(qtyInput.value);
        const price = parseFloat(priceInput.value);
        const discount = parseFloat(discountInput.value);
        const tax = parseFloat(taxInput.value);

        const subtotal = (qty * price) - discount;
        const amount = subtotal + (subtotal * tax / 100);
        amountInput.value = amount;

        calculate_subtotal();
    }

    function deleteRow(row) {
        const rowId = `row-${row}`;
        const rowElement = document.getElementById(rowId);
        rowElement.remove();
        calculate_total_discount();
    }


    function deletepurchase(row, id) {
    $.ajax({
        url: '../common/remove_item.php',
        type: 'POST',
        data: { purchase_invoice_item: id }, 
        success: function (response) {
            console.log("removed");
        }
    });

    const rowId = `row-${row}`;
    const rowElement = document.getElementById(rowId);
    rowElement.remove();
    calculate_total_discount();
  }
    function deleteInvoice(id) {
    $.ajax({
        url: '../common/remove_item.php',
        type: 'POST',
        data: { purchase_invoice: id }, 
        success: function (response) {
            console.log("removed");
            window.location.href="purchase_invoice";
        }
    });
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

 
 function clear_product_error(val) {
    category_errorMessage.style.display = 'none';
    purchase_errorMessage.style.display = 'none';
    product_errorMessage.style.display = 'none';
    party_errorMessage.style.display = 'none';
      const errorMessage = document.querySelector(`#product_errorMessage-${val}`);
      errorMessage.style.display = 'none';
  }

    function check_product_data() {
        let categoryName = category.value;
        let productName = productNameInput.value;
        let purchasePrice = purchasePriceInput.value;
        
        let category_errorMessage = document.getElementById('category_errorMessage');
        let purchase_errorMessage = document.getElementById('purchase_errorMessage');
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
        
        if (purchasePrice === '') {
          purchase_errorMessage.style.display = 'block';
          purchase_errorMessage.textContent = 'purchase price is required.';
          event.preventDefault();
          return;
        }

        
        // Create an object to store the form data
        var formData = {
            category: categoryName,
            productName: productName,
            purchasePrice: purchasePrice
        };

        // Send AJAX request using jQuery
        $.ajax({
            url: '../get_ajax/add_product_ajax.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response=='exists'){
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
                
                if(response=='error'){
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
                if(response=='product_added'){
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

<script src="../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>

