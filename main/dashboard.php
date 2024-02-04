<?php
 include('common/header.php'); 
 include('common/sidebar.php'); 

 ?>
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
                                <h6>Session of :  <?php if(isset($_SESSION['admin'])){ echo $_SESSION['admin']; echo ' admin';
                                }else{ echo $_SESSION['user'];  echo ' user';}?></h6>
                                <span>$22,500</span>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
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
                                $querySales = "SELECT sum(total_balance) as total FROM tblsalesinvoices where userID='$session'"; 
                                $querySalesResult = mysqli_query($conn, $querySales);
                                $rowSales = mysqli_fetch_array($querySalesResult);
                          ?>
                                <h6>SALES</h6>
                                <span>&#8377;<?php echo $rowSales['total'];?></span>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#604a7b" data-fill-Color="#a092b0">1,4,2,3,6,2</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>VISITS</h6>
                                <span>$21,215</span>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4aacc5" data-fill-Color="#92cddc">1,4,2,3,1,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>LIKES</h6>
                                <span>$421,215</span>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4f81bc" data-fill-Color="#95b3d7">1,3,5,1,4,2</div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>    
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/bundles/chartist.bundle.js"></script>
<script src="../assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<!--<script src="../assets/vendor/toastr/toastr.js"></script>-->

<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script src="../assets/js/index.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:09:54 GMT -->
</html>
