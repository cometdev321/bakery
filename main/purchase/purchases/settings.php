<?php  
include('../../common/header3.php');
include('../../common/sidebar.php');
include('../../common/cnn.php'); // Database connection
date_default_timezone_set('Asia/Kolkata');

?>
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
      text: "something went wrong",
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
   if (status === 'deleted') {
    Toastify({
      text: "Product removed!!",
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

// Handle form submission to insert into tblispurchaseenabled
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch = $_POST['branch'];
    $product = $_POST['product'];
    $status = 1; // Default status

    // Insert query without parameterization
    $insertQuery = "INSERT INTO tblispurchaseenabled (branch, product, status) VALUES ('$branch', '$product', '$status')";

    if (mysqli_query($conn, $insertQuery)) {
        // Redirect with success status
        echo "<script>window.location.href='settings?status=sucess'</script>";
        exit;
    } else {
        // Redirect with error status
        echo "<script>window.location.href='settings?status=error'</script>";
        exit;
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $idToDelete = $_GET['delete_id'];
    $updateQuery = "UPDATE tblispurchaseenabled SET status = 0 WHERE id = '$idToDelete'";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect with success status
        echo "<script>window.location.href='settings?status=deleted'</script>";
        exit;
    } else {
        // Redirect with error status
        echo "<script>window.location.href='settings?status=error'</script>";
        exit;
    }
}

// Fetch all records where status is 1
$fetchQuery = "
    SELECT tpe.id, tu.username AS branch, tp.productname AS product, tpe.status
    FROM tblispurchaseenabled tpe
    JOIN tblusers tu ON tpe.branch = tu.userID
    JOIN tblproducts tp ON tpe.product = tp.id
    WHERE tpe.status = 1";
    
$results = mysqli_query($conn, $fetchQuery);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Fetch products when a category is selected
    $('#category').change(function() {
        var categoryID = $(this).val();
        if (categoryID) {
            $.ajax({
                url: "../get_ajax/products/get_products_option.php",
                type: "POST",
                data: { categoryID: categoryID },
                success: function(response) {
                    $('#productSelect').html(response); // Update product dropdown with new options
                }
            });
        } else {
            $('#productSelect').html('<option value="">Select Product</option>'); // Reset product dropdown
        }
    });
});
</script>   




<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Values Settings</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Values Settings</li>
                    </ul>
                </div>            
            </div>
        </div>

        <!-- Form for Branch and Product Selection -->
        <form method="POST" action="">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="body row">
                            <div class="col-lg-12 col-md-6 my-2">
                                <label>Branch</label>
                                <select class="form-control show-tick ms select2" id="branch" name="branch" data-placeholder="Select" required>
                                    <?php
                                        $branchQ = "SELECT tu.userID AS unicodeBranch, b.name AS name FROM branch b
                                                    JOIN tblusers tu ON tu.branch=b.id
                                                    WHERE b.status='1' AND b.userID='$session'";
                                        $getbrx = mysqli_query($conn, $branchQ);
                                        while($fetchbx = mysqli_fetch_array($getbrx)){
                                            echo '<option value="' . $fetchbx['unicodeBranch'] . '">' . strtoupper($fetchbx['name']) . '</option>';
                                        }
                                    ?>
                                </select> 
                            </div>

                            <div class="col-lg-12 col-md-6 my-2">
                                <label for="category">Select Category</label>
                                <select id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php
                                        $categoryQuery = "SELECT `id`, `name` FROM tblcategory GROUP BY `name`";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);
                                        while($category = mysqli_fetch_assoc($categoryResult)) {
                                            echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-6 my-2">
                                <label for="productSelect">Select Product</label>
                                <select id="productSelect" name="product" class="form-control" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-6 my-2">
                                <button type="submit" class="btn btn-success btn-sm">Enable Purchase</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

     
    </div>
</div>

<script>
    document.title = "NAYAN";
</script>
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>
