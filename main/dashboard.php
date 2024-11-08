<?php
include('common/header.php'); 
include('common/sidebar.php'); 
?>
<style>
        .alert-placeholder {
            position: fixed;
            top: 15%;
            right: 10px;
            z-index: 9999;
            width: 80%; 
            max-width: 600px; 
            margin: auto;
            left: 40%;
            right: 0;
        }
    </style>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="text-right">
                        <!--<button type="button" class="btn btn-primary" onclick="window.location.href='sales/create_sales_invoice'"><i class="fa fa-plus"></i> <span>&nbsp;Create Sales Invoice</span></button>-->
                    </div>
        <div class="alert-placeholder"></div>

         <!-- basic -->
        <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php   
                                
                                $query = "SELECT count(id) as total FROM tblproducts where status='1'";  
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?><i class="icon-basket-loaded float-right"></i></h3>
                            <span>Products </span>                            
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php   
                            $userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
                                if($userID=='ALL'){
                                    $query = "SELECT count(id) as total FROM tblparty where status=1 and  userID in(select userID from tblusers where superAdminID='$session')"; 
                                }else if(isset($_SESSION['subSession'])){
                                    $query = "SELECT count(id) as total FROM tblparty where status=1 and  userID='$userID' and status='1'"; 
                                }else{
                                    $query = "SELECT count(id) as total FROM tblparty where status=1 and  userID='$session' and status='1'"; 
                                }
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?><i class="icon-user-follow float-right"></i></h3>
                            <span>My Parties</span>                    
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php   
                                $userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
                                if($userID=='ALL'){
                                    $query = "SELECT count(id) as total FROM tblpurchaseinvoices where status=1 and userID in(select userID from tblusers where superAdminID='$session')"; 
                                }else if(isset($_SESSION['subSession'])){
                                    $query = "SELECT count(id) as total FROM tblpurchaseinvoices where status=1 and  userID='$userID' and status='1'"; 
                                }else{
                                    $query = "SELECT count(id) as total FROM tblpurchaseinvoices where status=1 and  userID='$session' and status='1'"; 
                                }
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Purchases</span>       
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                        <?php   
                                $userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
                                if($userID=='ALL'){
                                    $query = "SELECT count(id) as total FROM tblsalesinvoices where status=1 and  userID in(select userID from tblusers where superAdminID='$session')"; 
                                }else if(isset($_SESSION['subSession'])){
                                    $query = "SELECT count(id) as total FROM tblsalesinvoices where status=1 and  userID='$userID' and status='1'"; 
                                }else{
                                    $query = "SELECT count(id) as total FROM tblsalesinvoices where status=1 and  userID='$session' and status='1'"; 
                                }
                                $result = mysqli_query($conn,$query);
                                $fetch = mysqli_fetch_array($result);
                          ?>
                            <h3><?php echo $fetch['total']?$fetch['total']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Sales</span>        
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="row clearfix">  
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card overflowhidden number-chart">
                            <div class="body">
                                <div class="number">
                                <?php
                                    $userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
                                    $startDate = date('Y-m-d', strtotime('-7 days')); // Adjusted to start 7 days ago
                                    $endDate = date('Y-m-d');

                                    if ($userID == 'ALL' || $userID == 'all') {
                                        $query = "SELECT sum(after_discount_total) as total, DATE(purchase_invoice_date) as purchase_date 
                                                FROM tblpurchaseinvoices 
                                                WHERE userID IN (SELECT userID FROM tblusers WHERE superAdminID='$session') 
                                                AND purchase_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                AND status=1
                                                GROUP BY purchase_date 
                                                ORDER BY purchase_date ASC"; // Ordering by date ascending
                                    } else if (isset($_SESSION['subSession'])) {
                                        $query = "SELECT sum(after_discount_total) as total, DATE(purchase_invoice_date) as purchase_date 
                                                FROM tblpurchaseinvoices 
                                                WHERE userID='$userID' AND status='1' 
                                                AND purchase_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                GROUP BY purchase_date 
                                                ORDER BY purchase_date ASC";
                                    } else {
                                        $query = "SELECT sum(after_discount_total) as total, DATE(purchase_invoice_date) as purchase_date 
                                                FROM tblpurchaseinvoices 
                                                WHERE userID='$session' AND status='1' 
                                                AND purchase_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                GROUP BY purchase_date 
                                                ORDER BY purchase_date ASC";
                                    }
                                    $result = mysqli_query($conn, $query);
                                    $purchaseData = [];

                                    // Initialize an array with 0 for the last 7 days (including today)
                                    for ($i = 7; $i >= 0; $i--) {
                                        $date = date('Y-m-d', strtotime("-$i days", strtotime($endDate))); // Calculate date in ascending order
                                        $purchaseData[$date] = ['total' => 0.00, 'date' => $date];
                                    }

                                    // Fill the purchase data
                                    while ($fetch = mysqli_fetch_assoc($result)) {
                                        $purchaseData[$fetch['purchase_date']] = ['total' => $fetch['total'], 'date' => $fetch['purchase_date']];
                                    }

                                    // Prepare output for sparkline and display
                                    $sparklineValues = [];
                                    foreach ($purchaseData as $data) {
                                        $sparklineValues[] = $data['total'];
                                    }
                                ?>
                                    <h6>PURCHASES LAST 7 DAYS </h6>
                                    <span>&#8377;<?php echo array_sum($sparklineValues) ? array_sum($sparklineValues) : '0.00'; ?></span>
                                </div>
                                <!-- <smALL class="text-muted">19% compared to last week</smALL> -->
                            </div>
                            <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                            data-line-Width="1" data-line-Color="#604a7b" data-fill-Color="#a092b0">
                            <?php foreach ($sparklineValues as $value): ?>
                                <?php echo $value . ','; ?>
                            <?php endforeach; ?>
                            </div>
                            <!-- <div class="dates">
                                <?php foreach ($purchaseData as $data): ?>
                                    <span><?php echo $data['date']; ?></span>
                                <?php endforeach; ?>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card overflowhidden number-chart">
                                <div class="body">
                                    <div class="number">
                                    <?php
                                        $userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
                                        $startDate = date('Y-m-d', strtotime('-7 days')); // Start 7 days ago
                                        $endDate = date('Y-m-d');

                                        if ($userID == 'ALL') {
                                            $query = "SELECT sum(after_discount_total) as total, DATE(sales_invoice_date) as sales_date 
                                                    FROM tblsalesinvoices 
                                                    WHERE userID IN (SELECT userID FROM tblusers WHERE superAdminID='$session') 
                                                    AND sales_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                    AND status=1
                                                    GROUP BY sales_date 
                                                    ORDER BY sales_date ASC"; // Ordering by date ascending
                                        } else if (isset($_SESSION['subSession'])) {
                                            $query = "SELECT sum(after_discount_total) as total, DATE(sales_invoice_date) as sales_date 
                                                    FROM tblsalesinvoices 
                                                    WHERE userID='$userID' AND status='1' 
                                                    AND sales_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                    GROUP BY sales_date 
                                                    ORDER BY sales_date ASC";
                                        } else {
                                            $query = "SELECT sum(after_discount_total) as total, DATE(sales_invoice_date) as sales_date 
                                                    FROM tblsalesinvoices 
                                                    WHERE userID='$session' AND status='1' 
                                                    AND sales_invoice_date BETWEEN '$startDate' AND '$endDate'
                                                    GROUP BY sales_date 
                                                    ORDER BY sales_date ASC";
                                        }
                                        $result = mysqli_query($conn, $query);
                                        $salesData = [];

                                        // Initialize an array with 0 for the last 7 days (including today)
                                        for ($i = 7; $i >= 0; $i--) {
                                            $date = date('Y-m-d', strtotime("-$i days", strtotime($endDate))); // Calculate date in ascending order
                                            $salesData[$date] = ['total' => 0.00, 'date' => $date];
                                        }

                                        // Fill the sales data
                                        while ($fetch = mysqli_fetch_assoc($result)) {
                                            $salesData[$fetch['sales_date']] = ['total' => $fetch['total'], 'date' => $fetch['sales_date']];
                                        }

                                        // Prepare output for sparkline and display
                                        $sparklineValues = [];
                                        foreach ($salesData as $data) {
                                            $sparklineValues[] = $data['total'];
                                        }
                                    ?>
                                        <h6>SALES LAST 7 DAYS </h6>
                                        <span>&#8377;<?php echo array_sum($sparklineValues) ? array_sum($sparklineValues) : '0.00'; ?></span>
                                    </div>
                                    <!-- <smALL class="text-muted">19% compared to last week</smALL> -->
                                </div>
                                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                                data-line-Width="1" data-line-Color="#604a7b" data-fill-Color="#a092b0">
                                <?php foreach ($sparklineValues as $value): ?>
                                    <?php echo $value . ','; ?>
                                <?php endforeach; ?>
                                </div>
                                <!-- <div class="dates">
                                    <?php foreach ($salesData as $data): ?>
                                        <span><?php echo $data['date']; ?></span>
                                    <?php endforeach; ?>
                                </div> -->
                            </div>
                        </div>
                    </div>    
        </div>    
        
        <!-- Annual Sales and purchase -->
        <div class="row clearfix">  
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                    <h2>Annual Sales And Purchase</h2>
                    </div>
                    <div class="body">
                    <div id="multiple-chart" class="ct-chart"></div>
                    </div>
                </div>
            </div>  
            <div class="col-lg-6 col-md-12">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                <a href="profile/page-profile">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-info"><i class="icon-user"></i> </div>
                            <div class="content">
                            <?php
                                if(isset($_SESSION['admin'])){
                                    $getadmin=mysqli_query($conn,"select Name from admin  where unicode='$session'");
                                }else{
                                    $getadmin=mysqli_query($conn,"select name as Name from branch  where id in(select branch from tblusers where userID='$session')");
                                }
                                $fetchadmin=mysqli_fetch_array($getadmin);        
                            ?>
                                <div class="text">My Account</div>
                                <h5 class="number"><?php echo strtoupper($fetchadmin['Name']); ?></h5>
                            </div>
                            
                        </div>
                    </div>
                </a>
                <a href="products/import-products">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-info"><i class="icon-paper-plane"></i> </div>
                            <div class="content">
                                <div class="text">Import/Export </div>
                                <h5 class="number">Products</h5>
                            </div>
                            
                        </div>
                    </div>
                </a>
                <a href="transaction/transfer">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-info"><i class="icon-rocket"></i> </div>
                            <div class="content">
                                <div class="text">Products</div>
                                <h5 class="number">Transfer Stock</h5>
                            </div>
                            
                        </div>
                    </div>
                </a>
                </div>
            
            </div>
            </div>  
         
            
          
        </div>





        <!-- sales -->
        <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Sales In Months</h2>
                        </div>
                        <div class="body">
                            <div id="line-chartSales" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Sales In Months</h2>
                        </div>
                        <div class="body">
                            <div id="bar-chartSales" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
        </div>


      


     <!-- purchase -->
             
             <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Purchases In Months</h2>
                        </div>
                        <div class="body">
                            <div id="line-chart" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Purchases In Months</h2>
                        </div>
                        <div class="body">
                            <div id="bar-chart" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
               


            
        </div>
</div>
<script src="js/dashboard.js"></script>

<script src="../assets/bundles/chartist.bundle.js"></script>
<script src="../assets/vendor/chartist/polar_area_chart.js"></script>
<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>    
<script src="../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script src="../assets/js/index.js"></script>
<script>
     <?php if (isset($_SESSION['admin'])): ?>
     $(document).ready(function() {
            // Check if a branch is selected
            var branchSelected = <?php echo isset($_SESSION['subSession']) ? 'true' : 'false'; ?>;

            if (!branchSelected) {
                displayAlert('Please select a branch.');
            }
            $('#branch').change(function() {
                var selectedBranch = $(this).val();
                if (selectedBranch) {
                    $('.alert-placeholder').empty(); // Remove the alert
                    // Add logic to store selected branch in session and reload or update content
                }
            });
        });
        function displayAlert(message) {
            var alertHtml = `
                <div class="alert alert-danger" role="alert">
                    ${message}
                </div>
            `;
            $('.alert-placeholder').html(alertHtml);
        }
        <?php endif; ?>
</script>
</body>
</html>
