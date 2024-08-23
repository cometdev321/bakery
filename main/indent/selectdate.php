<?php 
include('../common/header2.php');
include('../common/sidebar.php');
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2>Select Date to View Indent Records</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">View Indent Records</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="body">
                <form action="view_indents" method="GET">
                    <div class="form-group">
                        <label for="date">Select Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required value=<?php echo date('Y-m-d') ?>>
                    </div>
                    <button type="submit" class="btn btn-primary">View Records</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="../../assets/vendor/select2/select2.min.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
