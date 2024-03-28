<?php
 include('common/header.php'); 
 include('common/sidebar.php'); 

 ?>
 <style>
    .graph-container{
        width:80%;
        height: 50%;

    }
    #salesChart{
        display:block;
        width:80%;
        height: 50%;
    }
 </style>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-2.html"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">


                                <?php
                                $currentMonth = date("n");
                                $query = "SELECT SUM(total_balance) AS total_sales 
                                FROM tblsalesinvoices 
                                WHERE MONTH(timestamp) = $currentMonth AND userID = '$session'";
                                $querySalesResult = mysqli_query($conn, $query);
                                $rowSales = mysqli_fetch_array($querySalesResult);
                                ?>
                                <h4>Sales</h4>
                                <span><?php echo $rowSales['total_sales']; ?></span>

                            </div>
                             <small class="text-muted">Total sales of all time</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#f79647" data-fill-Color="#fac091">1,4,1,3,7,1</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <?php
                                $querySales = "SELECT sum(total_balance) as total FROM tblpurchaseinvoices where userID='$session'"; 
                                $querySalesResult = mysqli_query($conn, $querySales);
                                $rowSales = mysqli_fetch_array($querySalesResult);
                          ?>
                                <h6>Purchase</h6>
                                <span>&#8377;&nbsp;<?php echo $rowSales['total']?></span>
                            </div>
                            <small class="text-muted">Total purchase of all time</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#604a7b" data-fill-Color="#a092b0">1,4,2,3,6,2</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                            <?php
                                $querySales = "SELECT sum(r_balance) as total FROM tblpartyreport where userID='$session'"; 
                                $querySalesResult = mysqli_query($conn, $querySales);
                                $rowSales = mysqli_fetch_array($querySalesResult);
                          ?>
                                <h6>Receiable Amount</h6>
                                <span>&#8377;&nbsp;<?php echo $rowSales['total']?></span>
                            </div>
                            <small class="text-muted">total amount to be received</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4aacc5" data-fill-Color="#92cddc">1,4,2,3,1,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                            <?php
                                $querySales = "SELECT sum(p_balance) as total FROM tblpartyreport where userID='$session'"; 
                                $querySalesResult = mysqli_query($conn, $querySales);
                                $rowSales = mysqli_fetch_array($querySalesResult);
                          ?>
                                <h6>Payable remaining</h6>
                                <span>&#8377;&nbsp;<?php echo $rowSales['total']?></span>
                            </div>
                            <small class="text-muted">total amount to be paid</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4f81bc" data-fill-Color="#95b3d7">1,3,5,1,4,2</div>

                        <div class="graph-container">
                            <?php
                                $sql = "SELECT MONTH(timestamp) AS month, YEAR(timestamp) AS year, SUM(total_balance) AS total_sales
                                FROM tblsalesinvoices
                                GROUP BY YEAR(timestamp), MONTH(timestamp)
                                ORDER BY YEAR(timestamp), MONTH(timestamp)";

                                $result = mysqli_query($conn, $sql);
                                $data = [];
                                while ($row = mysqli_fetch_array($result)){
                                    $data[] = [
                                        'label' => date("F", mktime(0, 0, 0, $row['month'], 1)) . ' ' . $row['year'],
                                        'value' => $row['total_sales']
                                    ];
                                }
                                
                            ?>
                            <canvas id="salesChart" ></canvas>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
    
</div>

<script>
     $(document).ready(function(){
      $('#monthSelect').change(function(){
        var selectedMonth = $(this).val();

        $.ajax({
          type: 'POST',
          url: './get_ajax/get_monthsales.php',
          data: { month: selectedMonth },
          success: function(response){
            $('#salesResult').html(response);
          }
        });
      });

      // Trigger initial call to load sales data for the default selected month
      $('#monthSelect').change();
    });
</script>
<script>
        // Prepare data for Chart.js
        var data = <?php echo json_encode($data); ?>;

        // Initialize Chart.js
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => item.label),
                datasets: [{
                    label: 'Total Sales',
                    data: data.map(item => item.value),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/bundles/chartist.bundle.js"></script>
<script src="../assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<!--<script src="../assets/vendor/toastr/toastr.js"></script>-->

<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script src="../assets/js/index.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:09:54 GMT -->
</html>
