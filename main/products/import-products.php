<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?><!-- Add this to the "Import/Export-products" page -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: "Product updated succesfully",
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
   if (status === 'error') {
    Toastify({
      text: "Product update failed",
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Import/Export Product</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Import/Export Product</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <form id="basic-form" method="post" action="insert_imported.php" enctype="multipart/form-data">
                        <div class="card">
                            <div class="body">
                           <div class="col-lg-12 col-md-12 ">
                                <label >Import file</label>
                                <input type="file" name="partyfile" placeholder="Type Here" class="form-control" required>
                            </div>
                            <div class="form-group my-4">
                                    <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Import</span></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card">
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Poduct</th>
                                        <th>Sale Price</th>
                                        <th>Purchase Price</th>
                                        <th>Size</th>
                                        <th>SizeType</th>
                                        <th>HSN</th>
                                        <th>Opening_Stock</th>
                                        <th>GST</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Category</th>
                                        <th>Poduct</th>
                                        <th>Sale Price</th>
                                        <th>Purchase Price</th>
                                        <th>Sizes</th>
                                        <th>SizeType</th>
                                        <th>HSN</th>
                                        <th>Opening_Stock</th>
                                        <th>GST</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                    if(isset($_SESSION['subSession'])){
                                        $userID=$_SESSION['subSession'];
                                      }else{
                                        $userID=$session;
                                      }
                                    $query = "SELECT tp.*,tc.id FROM tblproducts tp
                                     join tblcategory tc on tc.id=tp.category 
                                     WHERE tp.status = '1' 
                                      order by tp.id desc";
                                    $result = mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                    <tr>
                                        <td><?php echo $row['id'];?></td>
                                        <td><?php echo $row['productname'];?></td>
                                        <td><?php echo $row['saleprice'];?></td>
                                        <td><?php echo $row['purchaseprice'];?></td>
                                        <td><?php echo $row['size'];?></td>
                                        <td><?php echo $row['sizetype'];?></td>
                                        <td><?php echo $row['HSN'];?></td>
                                        <td><?php echo $row['openingstock'];?></td>
                                        <td><?php echo $row['gst']=='0'?'Exempted':$row['gst'];?></td>
                                    </tr>
                                <?php  } ?>
                                </tbody>
                            </table>
							</div>
              
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
    
</div>

<script>

  function delete_product(val) {
      
    $.ajax({
      url:"../common/remove_item.php",
       type:"post",
       data:{remove_product:val},
       success:function(response){
        location.reload();
       }
    });

  }
  


  function recover(val) {
      
      $.ajax({
        url:"../common/remove_item.php",
         type:"post",
         data:{recover:val},
         success:function(response){
          location.reload();
         }
      });
  
    }
    



</script>

<!--script to auto hide alert-->
<script>
// Wait for the document to load
document.addEventListener("DOMContentLoaded", function() {
  // Get the Bootstrap alert element
  var alert = document.querySelector(".alert");

  // If the alert element exists
  if (alert) {
    // Hide the alert after 2 seconds
    setTimeout(function() {
      alert.style.display = "none";
    }, 2000);
  }
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

