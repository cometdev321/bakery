<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 
$dateToday = date("Y-m-d");
$branch = "";
$userId = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectedDate']) && isset($_POST['branch'])) {
    $dateToday = $_POST['selectedDate'];
    $branch = $_POST['branch'];
}
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Sales History</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><i class="icon-home"></i></li>                            
                        <li class="breadcrumb-item active">Sales History</li>
                    </ul>
                </div>            
            </div>
        </div>
        <form action="" method="post">
        <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body row">
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="selectedDate" value="<?php echo $dateToday;?>" id="selectedDate" class="form-control">
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                    <label>Select Branch</label>
                    <select class="form-control show-tick ms select2" id="branch" name="branch" data-placeholder="Select"> 
                        <option value="">Select Branch</option> 
                        <?php
                            $branchQ = "SELECT tu.userID AS unicodeBranch, b.name AS name 
                                        FROM branch b
                                        JOIN tblusers tu ON tu.branch = b.id
                                        WHERE b.status = '1' AND b.userID = '$session'";
                            $getbrx = mysqli_query($conn, $branchQ);
                            while ($fetchbx = mysqli_fetch_array($getbrx)) {
                                $selected = ($fetchbx['unicodeBranch'] == $branch) ? "selected" : "";
                        ?>
                            <option value="<?php echo $fetchbx['unicodeBranch']; ?>" <?php echo $selected; ?>>
                                <?php echo strtoupper($fetchbx['name']); ?>
                            </option>
                        <?php   
                            }
                        ?>
                    </select>
   
                    </div>
                </div>
     
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label></label>
                        <button type="submit" class="btn btn-primary mt-2  d-flex align-items-center" id="loadbtn">load</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
         <!-- basic -->
        <div class="row clearfix">
                
            
                <div class="col-lg-6 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php   
                                $query = "SELECT count(id) as total,sum(after_discount_total) as totalamount FROM tblpurchaseinvoices where status=1 and purchase_invoice_date='$dateToday' and userID='$branch' and status='1'"; 
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?> - &#8377;<?php echo $fetch['totalamount']?$fetch['totalamount']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Purchases Today</span>       
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php  
                                $query = "SELECT count(id) as total,sum(after_discount_total) as totalamount FROM tblsalesinvoices where status=1 and sales_invoice_date='$dateToday' and  userID='$branch' and status='1'"; 
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?> - &#8377;<?php echo $fetch['totalamount']?$fetch['totalamount']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Sales Today</span>        
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
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

