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
                                  if(isset($_SESSION['subSession']) || isset($_SESSION['admin'])){
                                  ?>
                                      <div class="col-lg-3 col-md-12 my-2">
                                        <label>Select From Branches</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="from" id="from" onchange="getProductsOfBranches()" >                                        >
                                        <option >Select Branch</option>
                                        <?php
                                            $slno=1;
                                            if(isset($_SESSION['admin'])){
                                              $queryBatch="select b.name as Bname,b.id as branchID from branch b
                                              join tblusers tu on tu.branch=b.id
                                              where b.status='1' and tu.status=1";
                                            }else{
                                              $queryBatch="select name as Bname,id as branchID from branch where status='1' and id in
                                              (select branch from tblusers  )";
                                            }
                                            $getct=mysqli_query($conn,$queryBatch);
                                            while($fetchcat=mysqli_fetch_array($getct)){
                                            ?>
                                            <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
                                            <?php } ?>
                                            </select>  
                                            <small id="from_errorMessage" class="text-danger" style="display: none;">Select different batch</small> 
                                        </div>
                                  <?php
                                  }else{ ?>

                                    <div class="col-lg-3 col-md-12 my-2">
                                        <label>From Branch</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="from" id="from"onchange="updateError()" >                                        >
                                        <?php 
                                          if(isset($_SESSION['admin'])){
                                          ?>
                                            <option value="null">Select Branch</option>
                                          <?php } ?>

                                            <?php
                                            $slno=1;
                                            if(isset($_SESSION['admin'])){
                                              $queryBatch="select b.name as Bname,b.id as `branchID` from branch b
                                              join tblusers tu on tu.branch=b.id
                                              where b.status='1' and tu.status=1";
                                            }else{
                                              $queryBatch="select name as Bname,id as branchID from branch where status='1' and id in
                                              (select branch from tblusers )";
                                            }
                                            $getct=mysqli_query($conn,$queryBatch);
                                            while($fetchcat=mysqli_fetch_array($getct)){
                                            ?>
                                            <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
                                            <?php } ?>
                                            </select>  
                                            <small id="from_errorMessage" class="text-danger" style="display: none;">Select different batch</small> 
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="col-lg-6 col-md-12  my-2">
                                        <label>To Branch</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="to" id="to" onchange="updateError()">
                                            <option value="null">Select Branch</option>
                                            <?php
                                                $slno=1;
                                                $queryBatch="select b.name as Bname,b.id as `branchID` from branch b
                                                    join tblusers tu on tu.branch=b.id
                                                    where b.status='1' and tu.userID not in('$session') and tu.status=1";
                                                $getct=mysqli_query($conn,$queryBatch);
                                                while($fetchcat=mysqli_fetch_array($getct)){
                                                ?>
                                                <option value="<?php echo $fetchcat['branchID']; ?>"><?php echo strtoupper($fetchcat['Bname']); ?></option>
                                                <?php } ?>
                                            </select>  
                                            <small id="to_errorMessage" class="text-danger" style="display: none;">Select different batch</small> 
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
                                            $queryBatch="select id,productname,size from tblproducts where status='1'";
                                            $getct=mysqli_query($conn,$queryBatch);
                                            while($fetchcat=mysqli_fetch_array($getct)){
                                              ?>
                                            <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['productname'] . " (size: " . $fetchcat['size'] . ")"; ?></option>
                                            <?php } ?>
                                          </select>  
                                          <small id="product_errorMessage" class="text-danger" style="display: none;">Select Product</small> 
                                        </div>
                                            <?php
                                          }
                                          ?>
                                    <div class="col-lg-6 col-md-12 my-2">
                                        <label>Quantity</label>
                                        <input type="number" value="1" id="qty" class="form-control" placeholder="Enter quantity" onkeyup="updateError()">
                                        <small id="qty_errorMessage" class="text-danger" style="display: none;">Add Quantity</small> 

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

function getProductsOfBranches(){
  var from=document.getElementById('from').value;
  $.ajax({
      url:"../get_ajax/stock_transfer/fetch_products.php",
       type:"post",
       data:{branch_id:from},
       success:function(response){
        $("#product").html(response);
       },error: function() {
            console.log('error occured');
        }
    });
}


function updateError(){
  from_errorMessage.style.display = 'none';
  to_errorMessage.style.display = 'none';
  product_errorMessage.style.display = 'none';
  qty_errorMessage.style.display = 'none';
}

function updateTransfer() {
    // Reset error messages
    updateError();

    // Fetch form values
    var date = document.getElementById('date').value;
    var from = document.getElementById('from').value;
    var to = document.getElementById('to').value;
    var product = document.getElementById('product').value;
    var qty = parseFloat(document.getElementById('qty').value);

    // Validate form fields
    if (from == 'null') {
        from_errorMessage.style.display = 'block';
        return;
    }

    if (from == to || to == 'null') {
        to_errorMessage.style.display = 'block';
        return;
    }

    if (product == 'null' || product ==null) {
        product_errorMessage.style.display = 'block';
        return;
    }

    if (qty == '' || qty < 1) {
        qty_errorMessage.style.display = 'block';
        return;
    }

    // Fetch available stock using AJAX
    $.ajax({
        url: "../get_ajax/stock_transfer/fetch_product_stock.php",
        type: "GET",
        data: { product_id: product },
        success: function(response) {
            var availableStock = parseFloat(response.trim()); 
            // Compare quantity with available stock
           

            if((qty) > (availableStock)) {
                qty_errorMessage.innerHTML = 'Quantity is more than available stock';
                qty_errorMessage.style.display = 'block';
                return; // Prevent further execution
            }

            // If validation passes, proceed to save transfer
            var formData = {
                date: date,
                fromBranch: from,
                toBranch: to,
                product: product,
                qty: qty
            };
            $.ajax({
                url: "../get_ajax/stock_transfer/initiate_transfer.php",
                type: "post",
                data: formData,
                success: function(response) {
                    response = response.trim();
                    console.log(response);
                    if (response == 'success') {
                        window.location.href = 'transfer_history';
                    }
                },
                error: function() {
                    console.log('error occurred');
                }
            });
        },
        error: function() {
            console.log('error occurred while fetching product stock');
        }
    });
}
</script>


</script>
<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>


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
