<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
include('../common/session_control.php'); 

 ?><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: "Party added succesfully",
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
      text: "Party adding failed",
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
      text: "Party with the same name already exists!!",
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
    $name = $_POST['name'];
    $mobile = $_POST['mobno'];
    $gstno = $_POST['gstno'];
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $payment_info = isset($_POST['payment_info']) ? $_POST['payment_info'] : '';

    if (isset($_POST['branch'])) {
        $userID = $_POST['branch'];
    } else {
        $userID = $session;
    }

    // If the user selected "All Branch", gather all relevant user IDs
    if ($userID == "all") {
        $allUserIDs = [];
        $branchQuery = "SELECT tu.userID FROM branch b
                        JOIN tblusers tu ON tu.branch = b.id
                        WHERE b.status = '1' AND b.userID = '$session'";
        $result = mysqli_query($conn, $branchQuery);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $allUserIDs[] = $row['userID'];
            }
        }
    }

    // Check for existence in the case of multiple branches
    if (isset($allUserIDs)) {
        foreach ($allUserIDs as $userID) {
            $checkQuery = "SELECT * FROM tblparty WHERE mobno = '$mobile' AND userID='$userID'";
            if (!empty($gstno)) {
                $checkQuery .= " OR gstno = '$gstno'";
            }

            $result = $conn->query($checkQuery);

            if ($result->num_rows > 0) {
                echo "<script>window.location.href='add-party?status=exists'</script>";
                exit; 
            }
        }

        // Insert for all branches
        foreach ($allUserIDs as $userID) {
            $query = "INSERT INTO `tblparty` (`name`, `mobno`, `gstno`, `address`, `payment_info`, `userID`) 
                      VALUES ('$name', '$mobile', '$gstno', '$address', '$payment_info', '$userID')";
            if (!mysqli_query($conn, $query)) {
                echo "<script>window.location.href='add-party?status=error'</script>";
                exit; 
            }
        }
        echo "<script>window.location.href='add-party?status=success'</script>";
    } else {
        // Regular check for a single user
        $checkQuery = "SELECT * FROM tblparty WHERE mobno = '$mobile' AND userID='$userID'";
        if (!empty($gstno)) {
            $checkQuery .= " OR gstno = '$gstno'";
        }

        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            echo "<script>window.location.href='add-party?status=exists'</script>";
        } else {
            $query = "INSERT INTO `tblparty` (`name`, `mobno`, `gstno`, `address`, `payment_info`, `userID`) 
                      VALUES ('$name', '$mobile', '$gstno', '$address', '$payment_info', '$userID')";
            if (mysqli_query($conn, $query)) {
                echo "<script>window.location.href='add-party?status=success'</script>";
            } else {
                echo "<script>window.location.href='add-party?status=error'</script>";
            }
        }
    }
}
?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Party</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Add Party</li>
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
                <?php if(isset($_SESSION['subSession'])){?>
                <div class="col-lg-6 col-md-12 my-2">
                    <label>Branch</label>
                     <select class="form-control show-tick ms select2" id="branch" name="branch" data-placeholder="Select" required > 
                                         <option>Select Branch</option>
                                         <?php
                                                $branchQ="select tu.userID as unicodeBranch,b.name as name from branch b
                                                    join tblusers tu on tu.branch=b.id
                                                where b.status='1' and b.userID='$session'";
                                                $getbrx=mysqli_query($conn,$branchQ);
                                                $row_count = mysqli_num_rows($getbrx);
                                                if ($row_count > 0) {
                                                while($fetchbx=mysqli_fetch_array($getbrx)){
                                            ?>
                                                <option value="<?php echo $fetchbx['unicodeBranch'];?>"><?php echo strtoupper($fetchbx['name']);?></option>
                                            <?php   
                                                }
                                                echo "<option value='all'>All Branch</option>";
                                              }
                                            ?>
                                        </select>  
                </div>
                <?php } ?>
                <div class="col-lg-6 col-md-12 my-2">
                    <label>Party Name</label>
                    <input type="text" name="name" placeholder="Type Here" class="form-control" required>
                </div>
                <div class="col-lg-6 col-md-12  my-2">
                    <label>Party Contact Info</label>
                    <input type="number" name="mobno" placeholder="Type Here"  class="form-control" required>
                </div>
                <div class="col-lg-6 col-md-12  my-2">
                    <label>GST</label>
                    <input type="text" name="gstno" placeholder="Type Here"  class="form-control" >
                </div>
                <div class="col-lg-6 col-md-12  my-2">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Type Here"  class="form-control">
                </div>
                <div class="col-lg-6 col-md-12  my-2">
                    <label>Payment Info</label>
                    <input type="text" name="payment_info" placeholder="Type Here"  class="form-control">
                </div>
            </div>
            <div class="form-group my-2">
                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
            </div>
        </form>
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

