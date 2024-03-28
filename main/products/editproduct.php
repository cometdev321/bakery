<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?><?php

if(isset($_POST['submit'])){
  
$id = $_POST['id'];
$category = $_POST['category'];
// $sub_category = $_POST['sub_category'];
$productname = $_POST['productname'];
$saleprice = $_POST['saleprice'];
$purchase = $_POST['purchaseprice'];
$size_number = $_POST['size_number'];
$size = $_POST['size'];
$HSN = $_POST['HSN'];
$openingstock = $_POST['openingstock'];
$gst = $_POST['gst'];
$sizeJoined=$size_number.$size;

$query = "UPDATE tblproducts SET category = '$category', sub_category = '$sub_category', productname = '$productname', saleprice = '$saleprice', purchaseprice = '$purchase', HSN = '$HSN', openingstock = '$openingstock', gst = '$gst', size = '$sizeJoined', sizetype = '$size' WHERE id = '$id'";

if(mysqli_query($conn,$query)){
    echo"<script>window.location.href='manage-products?status=success'</script>";
}else{
    echo"<script>window.location.href='manage-products?status=error'</script>";
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
                            <li class="breadcrumb-item active">Edit Branch</li>
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
                            <h2>Branch Details</h2>
                        </div>
                        <div class="body">
                            <?php
                                $id=$_POST['pid'];
                                $product = mysqli_query($conn,"SELECT tp.*,tc.name FROM tblproducts tp join tblcategory tc on tc.id=tp.category WHERE tp.status = '1'  and tp.userID='$session' and tp.id='$id' ");
                                $pro_details=mysqli_fetch_array($product);
                            ?>
                             <form  method="post" action="">
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>Category</label>
                                             <!--onChange="getSubCat(this.value);updatesub(this.value)"-->
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="category" >
                                        <option value="<?php echo $pro_details['category'];?>"><?php echo $pro_details['name'];?></option>
                                        <?php
                                        $present_cat=$pro_details['category'];
                                        $getct=mysqli_query($conn,"select name,id from tblcategory where status='1' and id!='$present_cat'");
                                        while($fetchcat=mysqli_fetch_array($getct)){
                                        ?>
                                        <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['name']; ?></option>
                                        <?php } ?>
                                        </select>                               
                                        </div>
                                        <!--<div class="col-lg-6 col-md-12 my-2">-->
                                        <!--    <label>Sub-Category</label>-->
                                        <!--<select class="form-control show-tick ms select2" data-placeholder="Select" name="sub_category" id="subcategory" required>-->
                                        <!--<option id="getcat" value="<?php echo $fetchcat['name']; ?>"><?php echo $fetchcat['name']; ?></option>-->
                                            
                                        <!--</select>                                -->
                                        <!--</div>-->
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>Product Name</label>
                                            <input type="text" name="productname" value="<?php echo $pro_details['productname'];?>" class="form-control" required>
                                            <input type="hidden" name="id" value="<?php echo $id;?>" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Sale Price</label>
                                            <input type="number"  placeholder="Type Here" name="saleprice" value="<?php echo $pro_details['saleprice'];?>" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Purchase Price</label>
                                            <input type="number" placeholder="Type Here" name="purchaseprice" value="<?php echo $pro_details['purchaseprice'];?>" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>HSN Code</label>
                                            <input type="text" placeholder="Type Here" name="HSN" class="form-control" value="<?php echo $pro_details['HSN'];?>" >
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Opening Stock</label>
                                            <input type="text" placeholder="Type Here" name="openingstock"  value="<?php echo $pro_details['openingstock'];?>" class="form-control" >
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Size</label>
                                            <input type="number" placeholder="Type Here" name="size_number" value="<?php echo intval($pro_details['size']);?>" class="form-control" >
                                        </div>
                                         <div class="col-lg-6 col-md-12  my-2">
                                            <label>Size-Type </label>
                                            <select class="form-control show-tick ms select2" name="size">
                                              <option selected value="<?php echo $pro_details['sizetype'];?>"><?php echo $pro_details['sizetype'];?></option>
                                              <option value="GM">Gram (g)</option>
                                              <option value="KG">Kilo Gram (kg)</option>
                                              <option value="ML">Milli Liter (ml)</option>
                                              <option value="L">Liter (L)</option>
                                            </select>
                                        </div>
                                          <?php
                                        $gst = $pro_details['gst'];
                                        ?>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>GST Level</label>
                                            <div>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="5" type="radio"  <?php if($gst=='5'){echo 'checked';}?>>
                                                    <span><i></i>5%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="12" type="radio" <?php if($gst=='12'){echo 'checked';}?>>
                                                    <span><i></i>12%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="18" type="radio" <?php if($gst=='18'){echo 'checked';}?>>
                                                    <span><i></i>18%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="28" type="radio" <?php if($gst=='28'){echo 'checked';}?>>
                                                    <span><i></i>28%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="0" type="radio" <?php if($gst=='0'){echo 'checked';}?>>
                                                    <span><i></i>Exempted</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                
                                <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Update</span></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

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

