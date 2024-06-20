<?php include('base.php');?>
<?php include('baseScript.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<style>

    .demo-card label{ display: block; position: relative;}
    .demo-card .col-lg-4{ margin-bottom: 30px;}
</style>
<style>
  .green-text {
    color: green;
}

.red-text {
    color: #FF5617; /* Light red color */
}
</style>
<style>
    /* Hide default scrollbar
    body {
        overflow: hidden;
    }

    /* Style your custom scrollbar here */
    /* For WebKit-based browsers */
    /* ::-webkit-scrollbar {
        width: 0;  
        background: transparent; 
    } */
    /* For Firefox */
    /* scrollbar-width: none; */
    /* For IE and Edge */
    /* -ms-overflow-style: none; */ 
</style>
<body class="theme-cyan">

    <!-- Page Loader -->
<!--<div class="page-loader-wrapper">-->
<!--    <div class="loader">-->
<!--        <div class="m-t-30"><img src="https://www.wrraptheme.com/templates/lucid/html/assets/images/logo-icon.svg" width="48" height="48" alt="Lucid"></div>-->
<!--        <p>Please wait...</p>        -->
<!--    </div>-->
<!--</div>-->
<!-- Overlay For Sidebars -->

<?php
if(isset($_POST['ProductSubmit'])) {
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
    
       $query = "SELECT * FROM tblproducts WHERE productname = '$productname' AND size = '$size'  and userID='$session'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        echo"<script>window.location.href='add-product?status=exists'</script>";
    } else {
      // If the record does not exist, insert the new record
      $query = "INSERT INTO tblproducts (`category`, `sub_category`, `productname`, `saleprice`,`purchaseprice`, `HSN`, `openingstock`, `gst`, `size`,`sizetype`,`userID`) 
        VALUES ('$category', '$sub_category', '$productname', '$saleprice','$purchase', '$HSN', '$openingstock', '$gst', '$sizeJoined','$size','$session')";
      
      if(mysqli_query($conn, $query)) {
        echo "<script> Toastify({
            text: 'Product added successfully',
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: 'top', // top, bottom, left, right
            position: 'right', // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
            backgroundColor: 'linear-gradient(to right, #84fab0, #8fd3f4)', // Use gradient color
            marginTop: '202px', // corrected to marginTop
            stopOnFocus: true, // Prevents dismissing of toast on hover
            onClick: function(){}, // Callback after click
            style: {
                margin: '70px 15px 10px 15px', // Add padding on the top of the toast message
            },
        }).showToast();</script>";
        
      } else {
        echo "<script> Toastify({
            text: 'Error occured try later',
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: 'top', // top, bottom, left, right
            position: 'right', // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
            backgroundColor: 'linear-gradient(to right, #fe8c00, #f83600)', // Use gradient color with red mix
            marginTop: '202px', // corrected to marginTop
            stopOnFocus: true, // Prevents dismissing of toast on hover
            onClick: function(){}, // Callback after click
            style: {
                margin: '70px 15px 10px 15px', // Add padding on the top of the toast message
            },
        }).showToast();</script>";
      }
    }

}
?>
    <?php
    if(isset($_SESSION['admin'])){
        $getadmin=mysqli_query($conn,"select * from admin where unicode='$session'");
        $fetchadmin=mysqli_fetch_array($getadmin);        
    }else if(isset($_SESSION['user'])){
        $getadmin=mysqli_query($conn,"select * from tblusers where userID='$session'");
        $fetchadmin=mysqli_fetch_array($getadmin);        
    }
    ?>

<div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="basic-form" method="post" action="">
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Category</label>
                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="category">
                                <option>Select Category</option>
                                <?php   
                                $getct=mysqli_query($conn,"select id,name from tblcategory where status='1' and userID='$session'");
                                while($fetchcat=mysqli_fetch_array($getct)){
                                ?>
                                <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['name']; ?></option>
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
                                    <button type="submit" name="ProductSubmit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
                <a href="<?php echo $base ?>/dashboard" class="text-dark">
                    &nbsp; &nbsp; &nbsp; &nbsp; ADMIN
                    <!--<img src="Images/img1.png"  height="33" class="img-responsive logo">-->
                    </a>                
            </div>
            
            <div class="navbar-right">
                <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo $base ?>/party/add-party" title="New New Party"  class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-users"></i></a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#userDetailsModal" title="Add New Product" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-briefcase"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo $base ?>/sales/create_sales_invoice"  title="Sales Invoice"  class="icon-menu d-none d-sm-block"><i class="icon-tag"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo $base ?>/purchase/create_purchase_invoice   "  title="Purchase Invoice" class="icon-menu d-none d-sm-block"><i class="icon-bag"></i></a>
                            <!-- <span class="notification-dot"></span> -->
                        </li>
                        
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-equalizer"></i></a>
                            <ul class="dropdown-menu user-menu menu-icon">
                                <li class="menu-heading">Transaction Report</li>
                                <li><a href="<?php echo $base ?>/reports/transaction/sale"><i class="icon-note"></i> <span>Sale</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/transaction/purchase"><i class="icon-note"></i> <span>Purchase</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/transaction/daybook"><i class="icon-note"></i> <span>Day Book</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/transaction/alltransaction"><i class="icon-note"></i> <span>All Transaction</span></a></li>
                                <li class="menu-heading">Party Reports</li>
                                <li><a href="<?php echo $base ?>/reports/party/party_sales_report"><i class="icon-credit-card"></i> <span>PartyWise Sales Report</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/party/party_purchase_report"><i class="icon-credit-card"></i> <span>PartyWise Purchase Report</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/party/allParties"><i class="icon-credit-card"></i> <span>All Parties</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/party/partySummary"><i class="icon-credit-card"></i> <span>Sale Purchase By Party</span></a></li>
                                <li class="menu-heading">Item/Stock Report</li>
                                <li><a href="<?php echo $base ?>/reports/stock/stockDetails"><i class="icon-credit-card"></i> <span>Stock Details</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/stock/itemreport"><i class="icon-credit-card"></i> <span>Item Report By Party</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/stock/stocksummary"><i class="icon-credit-card"></i> <span>Stock Summary</span></a></li>
                                <li><a href="<?php echo $base ?>/reports/stock/lowStock"><i class="icon-credit-card"></i> <span>Low Stock Summary</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo $base ?>/auth/logout" class="icon-menu"><i class="icon-login"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="left-sidebar" class="sb sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                <!--<img src="Images/<?php
                if(isset($_SESSION['admin'])){
                    echo $fetchadmin['image'];
                }
                  
                  ?>" class="rounded-circle user-photo" alt="User Profile Picture">-->
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>
                        <?php 
                        if(isset($_SESSION['admin'])){
                            echo strtoupper($fetchadmin['Name']); 
                    }else if(isset($_SESSION['user'])){
                            echo strtoupper($fetchadmin['username']);
                        } 
                        
                        ?>&nbsp;
                    </strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account">
                        <li><a href="<?php echo $base ?>/profile/page-profile"><i class="icon-user"></i>My Profile</a></li>
                        <!--<li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>-->
                        <li><a href="<?php echo $base ?>/profile/page-profile"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base ?>/auth/logout"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>
                <hr>
                <ul class="row list-unstyled">
                    <li class="col-4">
                        <small>Sales</small>
                        <h6>0</h6>
                    </li>
                    <li class="col-4">
                        <small>Order</small>
                        <h6>0</h6>
                    </li>
                    <li class="col-4">
                        <small>Revenue</small>
                        <h6>0</h6>
                    </li>
                </ul>
            </div>


            <?php
            
                if(!isset($_SESSION['user']) ){
                    if(isset($_SESSION['subSession'])){
                        $S_O_branch=$_SESSION['subSession'];
                        $getSessionName=mysqli_query($conn,"SELECT name from branch where id in(select branch from tblusers where userID='$S_O_branch')");
                        $getSessionValue=mysqli_fetch_array($getSessionName);
                    }
              ?>
            <div class="form-group mx-3">
                <label>Select Branch</label>
                <select onchange="setSessionValue(this)" class="form-control show-tick ms select2" id="branch"  data-placeholder="Select"  > 
                <?php  if(isset($_SESSION['subSession'])){ ?>
                <option value="<?php echo $S_O_branch;?>"><?php echo isset($getSessionValue['name']) ? strtoupper($getSessionValue['name']) : 'All';?> </option>
                <?php } ?>
                <option >Select Branch</option>
                <option value="All">All</option>
                    <?php
                        $branchQ="select tu.userID as unicodeBranch,b.name as name from branch b
                            join tblusers tu on tu.branch=b.id
                        where b.status='1' and b.userID='$session'";
                        $getbrx=mysqli_query($conn,$branchQ);
                        while($fetchbx=mysqli_fetch_array($getbrx)){
                    ?>
                        <option value="<?php echo $fetchbx['unicodeBranch'];?>"><?php echo strtoupper($fetchbx['name']);?></option>
                    <?php   
                        }
                    ?>
                </select>                                
             </div>
             <?php
            }
            ?>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            </ul>
                
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu">                            
                            <li>
                                <a href="#Dashboard" class="has-arrow"><i class="icon-home"></i> <span>Dashboard</span></a>
                               <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                                <ul>
                                    <li><a href="<?php echo $base ?>/branches/mybranches"><i class="fa fa-building-o"></i> My Branch</a></li>
                                    <li><a href="<?php echo $base ?>/users/myusers"><i class="fa fa-users"></i> My Users</a></li>
                                </ul>
                                <?php } ?>
                            </li>
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-basket"></i> <span>Category</span></a>
                                <ul>
                               
                                    <li><a href="<?php echo $base ?>/category/add-category"><i class="fa icon-mouse"></i> Add New Category</a></li>
                                    <!-- <li><a href="new-category"><i class="fa icon-mouse"></i>Category Requests</a></li> -->
                                    <!--<li><a href="add-subcategory"><i class="fa icon-mouse"></i> Add Sub-Category</a></li>-->

                                </ul>
                            </li>
                            <li>
                                <a href="#App" class="has-arrow"><i class=" icon-users"></i> <span>Party</span></a>
                                <ul>
                              
                                    <li><a href="<?php echo $base ?>/party/add-party"><i class="fa icon-mouse"></i> Add New Party</a></li>
                                    <li><a href="<?php echo $base ?>/party/manage-party"><i class="fa icon-mouse"></i> Manage Party</a></li>
                               
                                </ul>
                            </li>
                          
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Products</span></a>
                                <ul>
                              
                                    <li><a href="<?php echo $base ?>/products/add-product"><i class="fa icon-mouse"></i> Add New Product</a></li>
                                    <li><a href="<?php echo $base ?>/products/manage-products"><i class="fa icon-mouse"></i> Manage Products</a></li>
                               
                                </ul>
                            </li>
                            <?php
                                   if(!isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-tag"></i> <span>Sales</span></a>
                                <ul>                                    
                                    <li><a href="<?php echo $base ?>/sales/sales_invoice">Sales Invoices</a></li>
                                    <li><a href="<?php echo $base ?>/sales/paymentIn_list">Payment In</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-bag"></i> <span>Purchase</span></a>
                                <ul>                                    
                                    <li><a href="<?php echo $base ?>/purchase/purchase_invoice">Purchase Invoices</a></li>
                                    <!-- <li><a href="<?php echo $base ?>/vendors/vendor.php">Vendor</a></li> -->
                                    <li><a href="<?php echo $base ?>/purchase/paymentout_list">Payment Out</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-plane"></i> <span>Transport</span></a>
                                <ul>                                    
                                    <li><a href="<?php echo $base ?>/transaction/transfer">Transfer Stock</a></li>
                                    <li><a href="<?php echo $base ?>/transaction/transfer_history">Transfer History</a></li>
                                    <li><a href="<?php echo $base ?>/transaction/transfer_requests">Transfer Requests</a></li>
                              
                                </ul>
                            </li>
                            <!-- reports for admin only -->
                            <?php if(isset($_SESSION['admin'])){?>
                            <li>
                                <a href="#menu-level-1" class="has-arrow"><i class="icon-book-open"></i> <span>All Branches Reports</span></a>
                                <ul>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Transaction Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/sale">Sale</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/purchase">Purchase</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/daybook">Day Book</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/alltransaction">All Transaction</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Party Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/party_sales_report">PartyWise Sales Report</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/party_purchase_report">PartyWise Purchase Report</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/allParties">All Parties</a></li>
                                            <!-- <li><a href="<?php echo $base ?>/allBranchReport/party/partySummary">Sale Purchase By Party</a></li> -->
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Item/Stock Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/stockDetails">Stock Details</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/itemreport">Item Report By Party</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/stocksummary">Stock Summary</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/lowStock">Low Stock Summary</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Expense Report</a>
                                        <ul>
                                            <li><a href="">Expense Details</a></li>
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>
                            <?php } ?>
                            <!-- reports for users -->
                            <?php
                                   if(!isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#menu-level-1" class="has-arrow"><i class="icon-book-open"></i> <span>Reports</span></a>
                                <ul>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Transaction Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/transaction/sale">Sale</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/purchase">Purchase</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/daybook">Day Book</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/alltransaction">All Transaction</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Party Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/party/party_sales_report">PartyWise Sales Report</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/party_purchase_report">PartyWise Purchase Report</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/allParties">All Parties</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/partySummary">Sale Purchase By Party</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Item/Stock Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/stock/stockDetails">Stock Details</a></li>
                                            <li><a href="<?php echo $base ?>/reports/stock/itemreport">Item Report By Party</a></li>
                                            <li><a href="<?php echo $base ?>/reports/stock/stocksummary">Stock Summary</a></li>
                                            <li><a href="<?php echo $base ?>/reports/stock/lowStock">Low Stock Summary</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Expense Report</a>
                                        <ul>
                                            <li><a href="">Expense Details</a></li>
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>
                            <?php } ?>
                            <li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li>
                        </ul>
                    </nav>
                </div>
                <div class="tab-pane p-l-15 p-r-15" id="setting">
                    <h6>Choose Skin</h6>
                    <ul class="choose-skin list-unstyled">
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>                   
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="cyan" class="active">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="blush">
                            <div class="blush"></div>
                            <span>Blush</span>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>          
        </div>
    </div>
    
            <!-- Input Slider -->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Input Slider <small>Taken from <a href="http://refreshless.com/nouislider" target="_blank">refreshless.com/nouislider</a> & <a href="http://materializecss.com/" target="_blank">materializecss.com</a></small> </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <p><b>Basic Example</b></p>
                                    <div id="nouislider_basic_example"></div>
                                    <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <p><b>Range Example</b></p>
                                    <div id="nouislider_range_example"></div>
                                    <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  <style>
      input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
  </style>
 <script>
function setSessionValue(branchValue) {
    var selectedText = branchValue.options[branchValue.selectedIndex].text;
    $.ajax({
        type: "POST",
        url: `${baseSet}/session_control.php`,
        data: {
            branch: branchValue.value,
            itemname: selectedText
        },
        success: function(response) {
            // Handle the response from the server if needed
            console.log(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the error if needed
            console.error("Error: " + error);
        }
    });
}

</script>
