<?php  
include('../common/header2.php'); 
include('../common/deliwheelsSidebar.php'); 
 ?>
 <style>
/* For Line Chart */
.ct-series-a .ct-line {
    stroke: #3498db; /* Change the line color */
    stroke-width: 3px;
}

.ct-series-a .ct-point {
    stroke: #2ecc71; /* Change the point color */
    stroke-width: 5px;
}

/* For Bar Chart */
.ct-series-a .ct-bar {
    stroke: #e74c3c; /* Change the bar color */
    stroke-width: 15px;
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
                            $query = "SELECT COUNT(id) AS total FROM products WHERE status = '1'";
                            $stmt = $conn->prepare($query); // Prepare the query
                            $stmt->execute(); // Execute the query
                            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array

                            if ($result) {
                            } else {
                                echo "No products found.";
                            }
                            ?>

                            <h3><?php echo $result['total']?$result['total']:'0';?><i class="icon-basket-loaded float-right"></i></h3>
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
                            $query = "SELECT COUNT(id) AS total FROM line_men WHERE status = '1'";
                            $stmt = $conn->prepare($query); // Prepare the query
                            $stmt->execute(); // Execute the query
                            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array

                            if ($result) {
                            } else {
                                echo "No products found.";
                            }
                            ?>
                            <h3><?php echo $result['total']?$result['total']:'0';?><i class="icon-user-follow float-right"></i></h3>
                            <span>My Drivers</span>                    
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
                            $query = "SELECT COUNT(id) AS total FROM deliveries WHERE DATE(delivered_at) = CURDATE();";
                            $stmt = $conn->prepare($query); // Prepare the query
                            $stmt->execute(); // Execute the query
                            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array

                            if ($result) {
                            } else {
                                echo "No products found.";
                            }
                            ?>
                            <h3><?php echo $result['total']?$result['total']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Deliveries Today</span>       
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
                            $query = "SELECT COUNT(id) AS total FROM payment_records where DATE(payment_date) = CURDATE();";
                            $stmt = $conn->prepare($query); // Prepare the query
                            $stmt->execute(); // Execute the query
                            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array

                            if ($result) {
                            } else {
                                echo "No products found.";
                            }
                            ?>
                            <h3><?php echo $result['total']?$result['total']:'0';?><i class="fa fa-dollar float-right"></i></h3>
                            <span>Total Payments Today</span>        
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                            <div class="progress-bar" data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
        </div>


   <!-- sales -->
   <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Deliveries In Months</h2>
                        </div>
                        <div class="body">
                            <div id="line-chartSales" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Deliveries In Months</h2>
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
                            <h2>Total Payments In Months</h2>
                        </div>
                        <div class="body">
                            <div id="line-chart" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Total Payments In Months</h2>
                        </div>
                        <div class="body">
                            <div id="bar-chart" class="ct-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            


            
        </div>


<script>

$(document).ready(function () {
  function updateCharts(salesData) {
    var options;

    // Generate month labels from Jan to Dec
    var months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    var data1 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    var data2 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    // line chart
    options = {
      height: "300px",
      showPoint: true,
      axisX: {
        showGrid: true,
      },
      lineSmooth: false,
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };

    new Chartist.Line("#line-chart", data1, options);

    // bar chart
    options = {
      height: "300px",
      axisX: {
        showGrid: true,
      },
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };
    new Chartist.Bar("#bar-chart", data2, options);
  }

  $.ajax({
    url: "../api/dw_dashboard/fetch_payments_data.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      updateCharts(response);
    },
    error: function (error) {
      console.log("Error fetching sales data:", error);
    },
  });
});
//get sales
$(document).ready(function () {
  function updateChartsSales(salesData) {
    var options;

    // Generate month labels from Jan to Dec
    var months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    var data1 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    var data2 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    // line chart
    options = {
      height: "300px",
      showPoint: true,
      axisX: {
        showGrid: true,
      },
      lineSmooth: false,
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };

    new Chartist.Line("#line-chartSales", data1, options);

    // bar chart
    options = {
      height: "300px",
      axisX: {
        showGrid: true,
      },
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };
    new Chartist.Bar("#bar-chartSales", data2, options);
  }

  $.ajax({
    url: "../api/dw_dashboard/fetch_delivery_data.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
        
      updateChartsSales(response);
    },
    error: function (error) {
      console.log("Error fetching delivery data:", error);
    },
  });
});
</script>
<script src="../../assets/bundles/chartist.bundle.js"></script>
<script src="../../assets/vendor/chartist/polar_area_chart.js"></script>
<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>     
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/index.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>


</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

