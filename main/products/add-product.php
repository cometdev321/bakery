<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: "Product added succesfully",
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
      text: "Product adding failed",
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
   if (status === 'exists') {
    Toastify({
      text: "Product with the same name and size already exists!!",
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
if(isset($_POST['submit'])) {
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
    
       $query = "SELECT * FROM tblproducts WHERE productname = '$productname' AND size = '$size'  and userID='$sessionAdmin'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        echo"<script>window.location.href='add-product?status=exists'</script>";
    } else {
      // If the record does not exist, insert the new record
      $query = "INSERT INTO tblproducts (`category`, `sub_category`, `productname`, `saleprice`,`purchaseprice`, `HSN`, `openingstock`, `gst`, `size`,`sizetype`,`userID`) 
        VALUES ('$category', '$sub_category', '$productname', '$saleprice','$purchase', '$HSN', '$openingstock', '$gst', '$sizeJoined','$size','$sessionAdmin')";
      
      if(mysqli_query($conn, $query)) {
        echo"<script>window.location.href='add-product?status=success'</script>";

      } else {
        echo"<script>window.location.href='add-product?status=error'</script>";

      }
    }

}
?>

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Product</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Add Product</li>
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
                                            <label>Category</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="category" >
                                        <option >Select Category</option>
                                        <?php
                                        $getct=mysqli_query($conn,"select name from tblcategory where status='1' and userID='$sessionAdmin'");
                                        while($fetchcat=mysqli_fetch_array($getct)){
                                        ?>
                                        <option value="<?php echo $fetchcat['name']; ?>"><?php echo $fetchcat['name']; ?></option>
                                        <?php } ?>
                                        </select>                               
                                        </div>
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>Product Name</label>
                                            <input type="text" name="productname" placeholder="Type Here" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Sale Price</label>
                                            <input type="number" name="saleprice" placeholder="Type Here"  class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Purchase Price</label>
                                            <input type="number" name="purchaseprice" placeholder="Type Here"  class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>HSN Code</label>
                                            <input type="text" name="HSN" placeholder="Type Here" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Opening Stock</label>
                                            <input type="text" name="openingstock" placeholder="Type Here" class="form-control" >
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Size</label>
                                            <input type="number" name="size_number" placeholder="Type Here" class="form-control" >
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>Size-Type </label>
                                            <select class="form-control show-tick ms select2" name="size">
                                              <option value="GM">Gram (g)</option>
                                              <option value="KG">Kilo Gram (kg)</option>
                                              <option value="ML">Milli Liter (ml)</option>
                                              <option value="L">Liter (L)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>GST Level</label>
                                            <div>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="5" type="radio" checked>
                                                    <span><i></i>5%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="12" type="radio">
                                                    <span><i></i>12%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="18" type="radio">
                                                    <span><i></i>18%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="28" type="radio">
                                                    <span><i></i>28%</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gst" value="0" type="radio">
                                                    <span><i></i>Exempted</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="form-group my-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

 <script>

function getSubCat(val) {
  $.ajax({
  type: "POST",
  url: "get_subcategory.php",
  data:'category='+val,
  success: function(data){
    $("#subcategory").html(data);
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

