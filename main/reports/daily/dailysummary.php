<?php  
include('../../common/header3.php'); 
include('../../common/sidebar.php'); 
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2>
                        <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                            <i class="fa fa-arrow-left"></i>
                        </a> 
                        Daily Expense
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index"><i class="icon-home"></i></a>
                        </li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Daily Expense</li>
                    </ul>
                </div>
            </div>
        </div>
            <!-- 3) Today Stock vs Today Sales (Diff) -->
            <div class="col-lg-12 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            $today = date('Y-m-d');

                            // Single query with 2 sub-selects: sales + stock
                            $query = "
                                SELECT
                                    IFNULL((
                                        SELECT SUM(after_discount_total)
                                        FROM tblsalesinvoices
                                        WHERE status = 1
                                        AND sales_invoice_date = '$today'
                                        AND userID = '$session'
                                    ), 0) AS today_sales,

                                    IFNULL((
                                        SELECT SUM(ts.qty * tp.saleprice)
                                        FROM tblstock ts
                                        JOIN tblproducts tp ON tp.id = ts.product
                                        WHERE ts.date   = '$today'
                                        AND ts.userID = '$session'
                                    ), 0) AS today_stock_worth
                            ";

                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);

                            $todaySales      = (float)$fetch['today_sales'];
                            $todayStockWorth = (float)$fetch['today_stock_worth'];
                            // Difference = stock added worth - sales
                            $diff            = $todayStockWorth - $todaySales;
                        ?>
                        <h5>
                            Stock Added: &#8377;<b><?php echo $todayStockWorth; ?></b> &nbsp;Sales Today: &#8377;<b><?php echo $todaySales; ?></b><br>
                        </h5>
                        <h3>
                            Diff: &#8377;<?php echo $diff; ?>
                            <i class="fa fa-balance-scale float-right"></i>
                        </h3>
                        <span>Today Stock vs Today Sales </span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>

        <!-- CARDS ROW -->
        <div class="row clearfix">

            <!-- 1) Total Sales Today -->
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            $today = date('Y-m-d'); 

                         
                                $query = "SELECT count(id) as total, sum(after_discount_total) as totalamount 
                                          FROM tblsalesinvoices 
                                          WHERE status=1 
                                            AND sales_invoice_date='$today' 
                                            AND userID='$session' 
                                           ";
                            

                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);
                        ?>
                        <h3>
                            <?php echo $fetch['total'] ? $fetch['total'] : '0'; ?> - 
                            &#8377;<?php echo $fetch['totalamount'] ? $fetch['totalamount'] : '0'; ?>
                            <i class="fa fa-dollar float-right"></i>
                        </h3>
                        <span>Total Sales Today</span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>

            <!-- 2) Total Cash Sales -->
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            // reuse same logic or change query as required for "cash sales"
                            $today = date('Y-m-d'); 

                                $query = "SELECT count(id) as total, sum(amount_received) as totalamount 
                                          FROM tblsalesinvoices 
                                          WHERE status=1 
                                            AND sales_invoice_date='$today' 
                                            and amount_received_type='cash'
                                            AND userID='$session' 
                                            ";
                            

                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);
                        ?>
                        <h3>
                            <?php echo $fetch['total'] ? $fetch['total'] : '0'; ?> - 
                            &#8377;<?php echo $fetch['totalamount'] ? $fetch['totalamount'] : '0'; ?>
                            <i class="fa fa-dollar float-right"></i>
                        </h3>
                        <span>Total Cash Sales</span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>

            <!-- 2) Total bank Sales -->
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            // reuse same logic or change query as required for "cash sales"
                            $today = date('Y-m-d'); 

                                $query = "SELECT count(id) as total, sum(amount_received) as totalamount 
                                          FROM tblsalesinvoices 
                                          WHERE status=1 
                                            AND sales_invoice_date='$today' 
                                            and amount_received_type='bank'
                                            AND userID='$session' 
                                            ";
                            

                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);
                        ?>
                        <h3>
                            <?php echo $fetch['total'] ? $fetch['total'] : '0'; ?> - 
                            &#8377;<?php echo $fetch['totalamount'] ? $fetch['totalamount'] : '0'; ?>
                            <i class="fa fa-dollar float-right"></i>
                        </h3>
                        <span>Total UPI Sales</span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>

           
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            // reuse same logic or change query as required for "credit sales"
                            $today = date('Y-m-d'); 

                           
                                 $query = "SELECT count(id) as total, sum(total_balance) as totalamount 
                                          FROM tblsalesinvoices 
                                          WHERE status=1 
                                            AND sales_invoice_date='$today' 
                                            and amount_received_type='none'
                                            AND userID='$session'" ;
                            

                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);
                        ?>
                        <h3>
                            <?php echo $fetch['total'] ? $fetch['total'] : '0'; ?> - 
                            &#8377;<?php echo $fetch['totalamount'] ? $fetch['totalamount'] : '0'; ?>
                            <i class="fa fa-dollar float-right"></i>
                        </h3>
                        <span>Total Credit Sales</span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>

            <!-- 3) Total added stock value -->
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <?php
                            // reuse same logic or change query as required for "credit sales"
                            $today = date('Y-m-d'); 

                           
                                 $query = "SELECT 
                                        IFNULL(SUM(ts.qty * tp.saleprice), 0) AS today_stock_worth
                                    FROM tblstock ts
                                    JOIN tblproducts tp ON tp.id = ts.product
                                    WHERE ts.date   = '$today'
                                    AND ts.userID = '$session' ;
                                    " ;
                            
                            $result = mysqli_query($conn, $query);
                            $fetch  = mysqli_fetch_array($result);
                        ?>
                        <h3>
                            &#8377;<?php echo $fetch['today_stock_worth'] ? $fetch['today_stock_worth'] : '0'; ?>
                            <i class="fa fa-dollar float-right"></i>
                        </h3>
                        <span>Stock Added Worth </span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>





        </div> <!-- end .row clearfix -->

    </div> <!-- end .container-fluid -->
</div> <!-- end #main-content -->

<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>
