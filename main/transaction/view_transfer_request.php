<?php  
include('../common/header2.php'); 
include('../common/sidebar.php');
$id=$_POST['id'];
$query = "SELECT tt.*,b.name as branchname,p.productname,b1.name as b1name from tbltransfer tt 
                                 join tblproducts p on p.id=tt.product
                                 join branch b on b.id=tt.fromBranch
                                 join branch b1 on b1.id=tt.toBranch
                                 join tblusers tu on b1.id=tu.branch
                                 where tt.status='requested' and tu.userID='$session' and tt.id='$id'
   ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result)
 ?>
  
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Transfer Request</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Transfer Request</li>
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
                                        <input type="date"  id="date" class="form-control" readonly value="<?php echo $row['date']; ?>">

                                      </div>
                                    <div class="col-lg-3 col-md-12 my-2">
                                        <label>From Branch</label>
                                        <input type="text" id="from" class="form-control" readonly placeholder="Enter quantity" value="<?php echo $row['branchname']; ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                        <label>To Branch</label>
                                        <input type="text" id="to" class="form-control" readonly placeholder="Enter quantity" value="<?php echo $row['b1name']; ?>">
                                          </div>
                                          <div class="col-lg-3 col-md-12 my-2">
                                            <label>Product Name</label>
                                            <input type="text" id="product" class="form-control" readonly placeholder="Enter quantity" value="<?php echo $row['productname']; ?>">
                                        </div>
                                    <div class="col-lg-3 col-md-12 my-2">
                                        <label>Quantity</label>
                                        <input type="text" id="qty" class="form-control" readonly placeholder="Enter quantity" value="<?php echo $row['qty']; ?>">
                                        <input type="text" id="id" hidden value="<?php echo $id; ?>">

                                      </div>
                                      <div class="col-lg-6 col-md-12 my-2">
                                        <label>Select Product</label>
                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="product" id="add_to_product"  onchange="updateError()">
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
                                        </div>                             
                                </div>
                                <div class="form-group">
                                  <button type="button"  name="submit" class="btn btn-success btn-sm" onclick="save()"><i class="fa fa-check-circle"></i> <span>Save </span></button>&nbsp;
                                  <button type="button"  name="submit" class="btn btn-success btn-sm" onclick="saveasnew()"><i class="icon-login"></i> <span>&nbsp;Save as New Product</span></button>&nbsp;
                                  <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('<?php echo $id; ?>')"><i class="icon-trash"></i></button>&nbsp;
                                  </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

            



            </div>




<br>
<br>
<br>
<br>
<br>
&nbsp;


</div>
        </div>
    </div>
    
</div>
<script>
function deleteItem(val){
    $.ajax({
        url: "../common/remove_item.php",
        data: {deleteTransaction:val},
        type: 'POST',
        success: function(response) {
           window.location.href='transfer_history';
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}
</script>

<script>


function updateError(){
  product_errorMessage.style.display = 'none';
}


function saveasnew() {
    formData={};


  var id=document.getElementById('id').value;
  
  formData={
    id:id
    }

    $.ajax({
      url:"../get_ajax/stock_transfer/save_as_new.php",
       type:"post",
       data:formData,
       success:function(response){
            window.location.href='transfer_history?status=success';
       
       },error: function() {
            console.log('error occured');
        }
    });
  }


  function save() {
    formData={};


  var id=document.getElementById('id').value;
  var add_to_product=document.getElementById('add_to_product').value;
  
  if (add_to_product=='null') {
    product_errorMessage.style.display = 'block';
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    add_to_product.focus();
    event.preventDefault();
    return;
  }
 

  formData={
    id:id,
    add_to_product:add_to_product,
    }

    $.ajax({
      url:"../get_ajax/stock_transfer/save_stock.php",
       type:"post",
       data:formData,
       success:function(response){
            window.location.href='transfer_history?status=success';
       
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

