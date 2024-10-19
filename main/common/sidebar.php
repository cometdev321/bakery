<?php include('base.php');?>
<?php include('baseScript.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- DataTables CSS -->
 <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<script>
       
       function loadScript(url, callback) {
            // Check if script already exists
            let existingScript = document.querySelector(`script[src="${url}"]`);
            if (existingScript) {
                existingScript.remove();
            }
            let script = document.createElement("script");
            script.type = "text/javascript";
            script.src = url;
            script.onload = callback;
            document.head.appendChild(script);
        }

        function loadStylesheet(url) {
            // Check if stylesheet already exists
            let existingLink = document.querySelector(`link[href="${url}"]`);
            if (existingLink) {
                existingLink.remove();
            }
            let link = document.createElement("link");
            link.rel = "stylesheet";
            link.href = url;
            document.head.appendChild(link);
        }

        function destroyExistingTable() {
            if ($.fn.DataTable.isDataTable('#exportTable')) {
                $('#exportTable').DataTable().clear().destroy();
            }
        }

        function loadTabledata() {
            // Destroy any existing DataTable instance
            destroyExistingTable();

            // Load CSS files
            loadStylesheet("https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css");
            loadStylesheet("https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css");

            // Load JS files in sequence
            loadScript("https://code.jquery.com/jquery-3.6.0.min.js", function() {
                loadScript("https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js", function() {
                    loadScript("https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js", function() {
                        loadScript("https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js", function() {
                            loadScript("https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js", function() {
                                // Initialize DataTable after all scripts are loaded
                                $('#exportTable').DataTable({
                                    destroy: true,
                                    dom: 'Bfrtip',
                                    paging: true,
                                    searching: true,
                                    ordering: true,
                                    lengthChange: true,
                                    pageLength: 10,
                                });
                            });
                        });
                    });
                });
            });
        }
    
    </script>
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
if (isset($_POST['ProductSubmit'])) {
    $category = $_POST['category'];
    // $sub_category = $_POST['sub_category'];
    $productname = $_POST['productname'];
    $saleprice = $_POST['saleprice'];
    $purchase = $_POST['purchaseprice'];
    $size_number = $_POST['size_number'];
    $size = $_POST['size'];
    $sizetype=$size_number.$size;
    $HSN = isset($_POST['HSN']) ? $_POST['HSN'] : '';
    $openingstock = $_POST['openingstock'];
    $gst = $_POST['gst'];
    $discount = $_POST['default_discount_per_unit'];

    $sizeJoined = $size_number.$size;

    // Determine userID based on branch selection
    if (isset($_POST['branch'])) {
        if ($_POST['branch'] == "all") {
            // Retrieve all user IDs for the branches
            $allUserIDs = [];
            $branchQuery = "SELECT tu.userID FROM branch b
                            JOIN tblusers tu ON tu.branch = b.id
                            WHERE b.status = '1' AND b.userID = '$session'";
            $result = mysqli_query($conn, $branchQuery);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $allUserIDs[] = $row['userID'];
                }
            } else {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        } else {
            $userID = $_POST['branch'];
        }
    } else {
        $userID = $session;
    }

    // Check for product existence for each user or just the selected branch
    if (isset($allUserIDs)) {
        foreach ($allUserIDs as $userID) {
            $query = "SELECT * FROM tblproducts WHERE productname = '$productname' AND size = '$sizeJoined' AND userID='$userID'  AND status='1'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>window.location.href='product/add-product?status=exists'</script>";
                exit;
            }
        }

        // Insert product for all branches
        foreach ($allUserIDs as $userID) {
            $query = "INSERT INTO tblproducts (`category`, `sub_category`, `productname`, `saleprice`, `purchaseprice`, `HSN`, `openingstock`, `gst`, `size`, `sizetype`, `default_discount`, `userID`) 
                      VALUES ('$category', '$sub_category', '$productname', '$saleprice', '$purchase', '$HSN', '$openingstock', '$gst', '$sizeJoined', '$size', '$discount', '$userID')";
            if (!mysqli_query($conn, $query)) {
                echo "<script>window.location.href='product/add-product?status=error'</script>";
                exit;
            }
        }

    } else {
        // Single branch
        $query = "SELECT * FROM tblproducts WHERE productname = '$productname' AND size = '$sizeJoined' AND userID='$userID'  AND status='1'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>window.location.href='products/add-product?status=exists'</script>";
        } else {
            $query = "INSERT INTO tblproducts (`category`, `sub_category`, `productname`, `saleprice`, `purchaseprice`, `HSN`, `openingstock`, `gst`, `size`, `sizetype`, `default_discount`, `userID`) 
                      VALUES ('$category', '$sub_category', '$productname', '$saleprice', '$purchase', '$HSN', '$openingstock', '$gst', '$sizeJoined', '$size', '$discount', '$userID')";
            if (mysqli_query($conn, $query)) {
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
                    text: 'Error occurred, try later',
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'linear-gradient(to right, #fe8c00, #f83600)',
                    marginTop: '202px',
                    stopOnFocus: true,
                    onClick: function(){},
                    style: {
                        margin: '70px 15px 10px 15px',
                    },
                }).showToast();</script>";
            }
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
                <h5 class="modal-title" id="userDetailsModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="basic-form" method="post" action="">
                    <div class="row clearfix">
                        <!-- Branch Dropdown (only if admin) -->
                        <?php if(isset($_SESSION['admin'])){?>
                        <div class="col-lg-6 col-md-6 my-2">
                            <label>Branch</label>
                            <select class="form-control show-tick ms select2" id="branch" name="branch" data-placeholder="Select" required>
                                <option>Select Branch</option>
                                <?php
                                    $branchQ="SELECT tu.userID as unicodeBranch,b.name as name FROM branch b
                                              JOIN tblusers tu ON tu.branch=b.id
                                              WHERE b.status='1' AND b.userID='$session'";
                                    $getbrx = mysqli_query($conn, $branchQ);
                                    $row_count = mysqli_num_rows($getbrx);
                                    if ($row_count > 0) {
                                        while($fetchbx = mysqli_fetch_array($getbrx)){
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

                        <!-- Category Dropdown -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Category</label>
                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="category" required>
                                <option value="6360">Select Category</option>
                                <?php
                                    if(isset($_SESSION['subSession'])){
                                        $userID = $_SESSION['subSession'];
                                        if($userID == 'ALL' || $userID == 'all'){
                                            $getct = mysqli_query($conn, "SELECT id, name FROM tblcategory WHERE status='1' GROUP BY name");
                                        } else {
                                            $getct = mysqli_query($conn, "SELECT id, name FROM tblcategory WHERE status='1' AND userID='$userID' GROUP BY name");
                                        }
                                    } else {
                                        $getct = mysqli_query($conn, "SELECT id, name FROM tblcategory WHERE status='1' AND userID='$session' GROUP BY name");
                                    }
                                    while($fetchcat = mysqli_fetch_array($getct)){
                                ?>
                                <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Product Name -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Product Name</label>
                            <input type="text" name="productname" placeholder="Type Here" class="form-control" required>
                        </div>

                        <!-- Sale Price -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Sale Price</label>
                            <input type="number" name="saleprice" placeholder="Type Here" class="form-control" required>
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Purchase Price</label>
                            <input type="number" name="purchaseprice" placeholder="Type Here" class="form-control" required>
                        </div>

                        <!-- HSN Code -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>HSN Code</label>
                            <input type="text" name="HSN" placeholder="Type Here" class="form-control">
                        </div>

                        <!-- Opening Stock -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Opening Stock</label>
                            <input type="text" name="openingstock" placeholder="Type Here" class="form-control">
                        </div>

                        <!-- Default Discount Per Unit -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Default Discount Per Unit</label>
                            <input type="number" name="default_discount_per_unit" value="0" placeholder="Type Here" class="form-control">
                        </div>

                        <!-- Size -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>Size</label>
                            <input type="number" name="size_number" value="0" placeholder="Type Here" class="form-control">
                        </div>

                        <!-- UOM (Unit of Measure) -->
                        <div class="col-lg-6 col-md-12 my-2">
                            <label>UOM (Unit of Measure)</label>
                            <select class="form-control show-tick ms select2" name="size">
                                <option value="GM">Gram (g)</option>
                                <option value="KG">Kilo Gram (kg)</option>
                                <option value="ML">Milli Liter (ml)</option>
                                <option value="L">Liter (L)</option>
                            </select>
                        </div>

                        <!-- GST Level -->
                        <div class="col-lg-6 col-md-12 my-2">
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

                    <!-- Save Button -->
                    <div class="form-group my-2">
                        <button type="submit" name="ProductSubmit" class="btn btn-success btn-sm">
                            <i class="fa fa-check-circle"></i> <span>Save</span>
                        </button>
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
                     <?php 
                            if(isset($_SESSION['admin'])){
                                echo 'SuperAdmin';
                            }else{
                                echo 'Admin';
                            }
                     ?>
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
                <option value="ALL">Select Branch</option> 
                <option value="ALL">All</option>
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
                            <!-- <li>
                                <a href="<?php echo $base ?>/deliwheels/dashboard" class=""><i class="fa fa-truck"></i><span>DeliWheels</span></a>
                               
                            </li>                         -->
                               <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#Dashboard" class="has-arrow"><i class="icon-home"></i> <span>Dashboard</span></a>
                                <ul>
                                    <li><a href="<?php echo $base ?>/branches/mybranches"><i class="fa fa-building-o"></i> My Branch</a></li>
                                    <li><a href="<?php echo $base ?>/users/myusers"><i class="fa fa-users"></i> My Users</a></li>
                                </ul>
                                <?php } ?>
                            </li>
                           
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-link"></i> <span>Category</span></a>
                                <ul>
                               
                                    <li><a href="<?php echo $base ?>/category/add-category"><i class="fa icon-mouse"></i> Add New Category</a></li>
                                    <li><a href="<?php echo $base ?>/category/import-category"><i class="fa icon-mouse"></i>Import/Export Category</a></li>

                                </ul>
                            </li>
                            <li>
                                <a href="#App" class="has-arrow"><i class=" icon-users"></i> <span>Party</span></a>
                                <ul>
                              
                                    <li><a href="<?php echo $base ?>/party/add-party"><i class="fa icon-mouse"></i> Add New Party</a></li>
                                    <li><a href="<?php echo $base ?>/party/manage-party"><i class="fa icon-mouse"></i> Manage Party</a></li>
                                    <li><a href="<?php echo $base ?>/party/import-party"><i class="fa icon-mouse"></i> Import/Export Party</a></li>
                               
                                </ul>
                            </li>
                          
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Products</span></a>
                                <ul>
                              
                                    <li><a href="<?php echo $base ?>/products/add-product"><i class="fa icon-mouse"></i> Add New Product</a></li>
                                    <li><a href="<?php echo $base ?>/products/manage-products"><i class="fa icon-mouse"></i> Manage Products</a></li>
                                    <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                                    <li><a href="<?php echo $base ?>/products/mass-products"><i class="fa icon-mouse"></i> mass-products</a></li>
                                    <?php } ?>

                                    <li><a href="<?php echo $base ?>/products/import-products"><i class="fa icon-mouse"></i> Import/Export Products</a></li>
                               
                                </ul>
                            </li>
                            <?php
                                   if(!isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-basket"></i> <span>Indent</span></a>
                                <ul>                                    
                                    <li><a href="<?php echo $base ?>/indent/create_indent">Create Indent</a></li>
                                    <li><a href="<?php echo $base ?>/indent/selectdate">View indent</a></li>
                                </ul>
                            </li>
                            <?php
                                } ?>

<?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-basket"></i> <span>Indent</span></a>
                                <ul>                                    
                                    <li><a href="<?php echo $base ?>/indent/selectdateandbranch">Indent Requests</a></li>
                                    <li><a href="<?php echo $base ?>/indent/indenthistory">Indent History </a></li>
                                </ul>
                            </li>
                            <?php
                                } ?>
                                
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
                                <a href="#FileManager" class="has-arrow"><i class="icon-plane"></i> <span>Stock Transfer</span></a>
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
