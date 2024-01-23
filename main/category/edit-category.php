<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?><?php

if(isset($_POST['submit'])){
  
         $id  =     $_POST["id"];
         $catname  =     $_POST["catname"];

   
              $insert_query = "UPDATE tblcategory SET name='$catname' WHERE id=$id";
              $insert_result = mysqli_query($conn, $insert_query);
            
             if ($insert_result) {
                echo"<script>window.location.href='add-category?status=updated'</script>";
            } else {
                echo"<script>window.location.href='add-category?status=error'</script>";

            }

}


?>
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Branch</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <?php
            if (isset($alert_type)) {
                  echo '<div class="alert text-dark l-' . $alert_type . '" role="alert">';
                  echo $alert_message;
                  echo '</div>';
                  
                } 
            ?>
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Category Details</h2>
                        </div>
                        <div class="body">
                            <?php
                                $id=$_POST['category'];
                                $mycat=mysqli_query($conn,"Select * from tblcategory where id=$id");
                                $catdetails=mysqli_fetch_array($mycat);
                            ?>
                             <form  method="post" action="">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" value="<?php echo $catdetails['name'];?>" name="catname" required>
                                    <input type="text" hidden class="form-control" value="<?php echo $id ?>" name="id" required>
                                </div>
                                <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </div>
    
</div>
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

