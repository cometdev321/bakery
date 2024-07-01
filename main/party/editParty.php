<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
include('../common/session_control.php'); 
$id=$_POST['pid'];
if(isset($_SESSION['subSession'])){
   $userID= $_SESSION['subSession'];
}else{
    $userID= $session;

}
$query = "SELECT * FROM `tblparty` WHERE `id`='$id' AND userID='$userID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
 ?>

<?php
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobno'];
    $gstno = $_POST['gstno'];
   

      // Update the record based on the provided $id
      $updateQuery = "UPDATE tblparty SET name = '$name', mobno = '$mobile', gstno = '$gstno' WHERE id = '$id'";
      
      if(mysqli_query($conn, $updateQuery)) {
        echo "<script>window.location.href='manage-party?status=success'</script>";
      } else {
        echo "<script>window.location.href='manage-party?status=error'</script>";
      }
  }
  

?>

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Party</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Edit Party</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

                    <div class="card planned_task">
                        <div class="header">
                            <h2>User Details</h2>
                        </div>
                        <div class="body">
                             <form id="basic-form" method="post" action="">
                                 <div class="row clearfix">
                                  
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>Party Name</label>
                                            <input type="text" name="id" hidden value="<?php echo $id;?>" placeholder="Type Here" class="form-control" required>
                                            <input type="text" name="name" placeholder="Type Here" value="<?php echo $row['name'];?>" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Party Contact Info</label>
                                            <input type="number" name="mobno" placeholder="Type Here" value="<?php echo $row['mobno'];?>"  class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>GST</label>
                                            <input type="text" name="gstno" placeholder="Type Here" value="<?php echo $row['gstno'];?>" class="form-control" required>
                                        </div>
                                       

                                    </div>
                                <div class="form-group my-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>

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
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>


</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

