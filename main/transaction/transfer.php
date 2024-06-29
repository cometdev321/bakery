<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: "Category Created succesfully",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // top, bottom, left, right
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
  if (status === 'updated') {
    Toastify({
      text: "Category Updated succesfully",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // top, bottom, left, right
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
   if (status === 'category_error') {
    Toastify({
      text: "Category Already Exists",
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
<?php

if(isset($_POST['submit'])){
      
}
?>
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Transfer</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Transfer</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Transport Details</h2>
                        </div>
                        <div class="body">
                             <form  method="post" action="">
                               <div class="form-group">
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-12 my-2">
                                        <label>Date</label>
                                        <input type="date"  id="date" class="form-control" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <?php 
    if (isset($_SESSION['subSession']) || isset($_SESSION['admin'])) {
    ?>
        <div class="col-lg-3 col-md-12 my-2">
            <label>Select From Branches</label>
            <select class="form-control show-tick ms select2" data-placeholder="Select" name="from" id="from" onchange="validateBranchSelection(); getProductsOfBranches();">

                <option value="null">Select Branch</option>
                <?php
                    $slno = 1;
                    if (isset($_SESSION['admin'])) {
                        $queryBatch = "SELECT b.name AS Bname, b.id AS branchID FROM branch b
                                       JOIN tblusers tu ON tu.branch = b.id
                                       WHERE b.status = '1' AND tu.status = 1";
                    } else {
                        $queryBatch = "SELECT name AS Bname, id AS branchID FROM branch
                                       WHERE status = '1' AND id IN (SELECT branch FROM tblusers WHERE userID = '$session')";
                    }
                    $getct = mysqli_query($conn, $queryBatch);
                    while ($fetchcat = mysqli_fetch_array($getct)) {
                ?>
                    <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
                <?php } ?>
            </select>
        </div>
    <?php
    } else { ?>
        <div class="col-lg-3 col-md-12 my-2">
            <label>From Branch</label>
            <select class="form-control show-tick ms select2" data-placeholder="Select" name="from" id="from" onchange="validateBranchSelection(); getProductsOfBranches();">

                <option value="null">Select Branch</option>
                <?php
                    $slno = 1;
                    if (isset($_SESSION['admin'])) {
                        $queryBatch = "SELECT b.name AS Bname, b.id AS branchID FROM branch b
                                       JOIN admin ON admin.unicode = b.userID
                                       WHERE b.status = '1' AND admin.admin_id = '$session'";
                    } else {
                        $queryBatch = "SELECT name AS Bname, id AS branchID FROM branch
                                       WHERE status = '1' AND id IN (SELECT branch FROM tblusers WHERE userID = '$session')";
                    }
                    $getct = mysqli_query($conn, $queryBatch);
                    while ($fetchcat = mysqli_fetch_array($getct)) {
                ?>
                    <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
                                        
    <div class="col-lg-6 col-md-12 my-2">
        <label>To Branch</label>
        <select class="form-control show-tick ms select2" data-placeholder="Select" name="to" id="to" onchange="validateBranchSelection()">
            <option value="null">Select Branch</option>
            <?php
                $slno = 1;
                $queryBatch = "SELECT b.name AS Bname, b.id AS branchID FROM branch b
                               JOIN tblusers tu ON tu.branch = b.id
                               WHERE b.status = '1' AND tu.userID NOT IN ('$session') AND tu.status = 1";
                $getct = mysqli_query($conn, $queryBatch);
                while ($fetchcat = mysqli_fetch_array($getct)) {
            ?>
                <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
            <?php } ?>
        </select>
        <small id="branch_errorMessage" class="text-danger" style="display: none;">From Branch and To Branch cannot be the same.</small>
    </div>


                                          <?php 
                                          if(isset($_SESSION['subSession']) || isset($_SESSION['admin'])){ ?>
                                          <div class="col-lg-6 col-md-12 my-2">
                                            <label>Select Product</label>
                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="product" id="product"  onchange="updateError()">
                                           
                                          </select>  
                                          <small id="product_errorMessage" class="text-danger" style="display: none;">Select Product</small> 
                                        </div>
                                         <?php }else{ ?>
                                          <div class="col-lg-6 col-md-12 my-2">
                                            <label>Select Product</label>
                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="product" id="product"  onchange="updateError()">
                                        <option value="null">Select Product</option>
                                            <?php
                                            $slno=1;
                                            $queryBatch="select id,productname from tblproducts where status='1' and userID='$session' ";
                                            $getct=mysqli_query($conn,$queryBatch);
                                            while($fetchcat=mysqli_fetch_array($getct)){
                                              ?>
                                            <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['productname']; ?></option>
                                            <?php } ?>
                                          </select>  
                                          <small id="product_errorMessage" class="text-danger" style="display: none;">Select Product</small> 
                                        </div>
                                            <?php
                                          }
                                          ?>
                                    <div class="col-lg-6 col-md-12 my-2">
                                        <label>Quantity</label>
                                        <input type="number" value="1" id="qty" class="form-control" placeholder="Enter quantity" onchange="validateQuantity()">
                                        <small id="qty_errorMessage" class="text-danger" style="display: none;">Add Quantity</small>
                                        <small id="qty_stock_errorMessage" class="text-danger" style="display: none;">Quantity exceeds available stock</small>
                                    </div>

                                       
                                        </div>                             
                                </div>
                                <div class="form-group">
                                <button type="button"  name="submit" class="btn btn-success btn-sm" onclick="updateTransfer()"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

            



            </div>
        </div>
    </div>
    
</div>
<script>
function validateQuantity() {
    var qtyInput = document.getElementById('qty');
    var qtyErrorMessage = document.getElementById('qty_errorMessage');
    var qtyStockErrorMessage = document.getElementById('qty_stock_errorMessage');

    var selectedProductId = document.getElementById('product').value;
    if (selectedProductId === 'null') {
        qtyErrorMessage.style.display = 'none';
        qtyStockErrorMessage.style.display = 'none';
        return;
    }

    var quantity = parseInt(qtyInput.value);
    if (isNaN(quantity) || quantity < 1) {
        qtyErrorMessage.style.display = 'block';
        qtyStockErrorMessage.style.display = 'none';
        return;
    }

   
    fetchProductStock(selectedProductId, quantity);
}

function fetchProductStock(productId, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            var availableStock = response.stock;

            if (quantity > availableStock) {
                document.getElementById('qty_errorMessage').style.display = 'none';
                document.getElementById('qty_stock_errorMessage').style.display = 'block';
            } else {
                document.getElementById('qty_errorMessage').style.display = 'none';
                document.getElementById('qty_stock_errorMessage').style.display = 'none';
            }
        }
    };

    xhr.open('GET', '../get_ajax/stock_transfer/fetch_product_stock.php?product_id=' + productId, true);
    xhr.send();
  }


function validateBranchSelection() {
            var fromBranch = document.getElementById("from").value;
            var toBranch = document.getElementById("to").value;
            var errorMessage = document.getElementById("branch_errorMessage");

            // Validate From and To Branches
            if (fromBranch === toBranch && fromBranch !== "null" && toBranch !== "null") {
                errorMessage.style.display = "block";
            } else {
                errorMessage.style.display = "none";
            }
        }


        function getProductsOfBranches() {
  var fromBranch = document.getElementById('from').value;
  if (fromBranch !== 'null') {
    $.ajax({
      url: '../get_ajax/stock_transfer/fetch_products.php',
      type: 'POST',
      data: { branch_id: fromBranch },
      success: function(response) {
        var products = JSON.parse(response);
        var productSelect = document.getElementById('product');
        productSelect.innerHTML = '<option value="null">Select Product</option>';
        products.forEach(function(product) {
          var option = document.createElement('option');
          option.value = product.id;
          option.textContent = product.productname;
          productSelect.appendChild(option);
        });
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }
}

function updateError(){
  from_errorMessage.style.display = 'none';
  to_errorMessage.style.display = 'none';
  product_errorMessage.style.display = 'none';
  qty_errorMessage.style.display = 'none';
}

  function updateTransfer() {
    formData={};

  var date=document.getElementById('date').value;
  var from=document.getElementById('from').value;
  var to=document.getElementById('to').value;
  var product=document.getElementById('product').value;
  var qty=document.getElementById('qty').value;
  
  if (from=='null') {
    from_errorMessage.style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Optional: Add smooth scrolling behavior
    });
    from_errorMessage.focus();
    event.preventDefault();
    return;
  }

  if (from == to || to=='null') {
    to_errorMessage.style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Optional: Add smooth scrolling behavior
    });
    to_errorMessage.focus();
    event.preventDefault();
    return;
  }
  
  if (product=='null') {
    product_errorMessage.style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Optional: Add smooth scrolling behavior
    });
    product_errorMessage.focus();
    event.preventDefault();
    return;
  }
  if (qty=='' || qty<1) {
    qty_errorMessage.style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Optional: Add smooth scrolling behavior
    });
    qty_errorMessage.focus();
    event.preventDefault();
    return;
  }

  formData={
      date:date,
      fromBranch:from,
      toBranch:to,
      product:product,
      qty:qty
    }


    $.ajax({
      url:"../get_ajax/stock_transfer/initiate_transfer.php",
       type:"post",
       data:formData,
       success:function(response){
        response = response.trim(); 
        console.log(response)
          // if(response=='qtyError'){
          //     Toastify({
          //       text: "Something Went Wrong",
          //       duration: 3000,
          //       newWindow: true,
          //       close: true,
          //       gravity: "top", // top, bottom, left, right
          //       position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
          //       backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)", // Use gradient color with red mix
          //       stopOnFocus: true, // Prevents dismissing of toast on hover
          //       onClick: function(){}, // Callback after click
          //       style: {
          //         margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
          //       },
          //     }).showToast();
          //   qty_errorMessage.innerHTML='Quantity is more than available stock';
          //   qty_errorMessage.style.display = 'block';
          // }
          if(response=='success'){
            window.location.href='transfer_history';
          }
       },error: function() {
            console.log('error occured');
        }
    });
  }

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

