<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>

<?php
if(isset($_POST['submit'])) {
  
}
?>

 <div id="main-content">
        <div class="container-fluid"> 
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Sale Transactions</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Sale Transactions</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">

                        <div class="col-lg-12 col-md-12">
                            <div class="card planned_task">
                                <div class="body row">
                                    <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="time_period" id="time_period" onchange="get_list(this.value)">
                                            <option selected value="Today">Today</option>
                                            <option value="Yesterday">Yesterday</option>
                                            <option value="This-Week">This-Week</option>
                                            <option selected value="This-Month">This-Month</option>
                                            <option value="Current-Fiscal-Year">Current Fiscal Year </option>
                                            <option value="Last-7-days">Last 7 days</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label>Party</label>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" name="party" id="party" onchange="get_list(this.value)">
                                        <?php
                                        $getParties = mysqli_query($conn, "SELECT `name`,`id` FROM `tblparty` where userID='$session'");
                                            ?>
                                            <option selected value="null">Select Party Name</option>
                                            <?php
                                            while($party = mysqli_fetch_array($getParties)){
                                            ?>
                                            <option value="<?php echo $party['id']; ?>" ><?php echo $party['name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>

                                <div class="col-lg-6 col-md-12 row">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <div class="input-group">
                                            <div class="col-lg-4" style="width:250px">
                                                <input type="date" class="form-control" id="startDate" value="<?php echo date('Y-m-01');?>" onchange="get_list(this.value)">
                                            </div>
                                            <span class="input-group-addon">TO</span>
                                            <div class="col-lg-4" style="width:250px">
                                                <input type="date" class="form-control" id="endDate" value="<?php echo date('Y-m-d');?>" onchange="get_list(this.value)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <?php
                            $salesPaid="select sum(after_discount_total) as totalpaid from tblsalesinvoices where userID='$session' and status='1' and full_paid='Yes'";
                            $salesPending="select sum(after_discount_total) as totalPending from tblsalesinvoices where userID='$session' and status='1' and full_paid='No'";
                            $getPaid=mysqli_query($conn,$salesPaid);
                            $getPending=mysqli_query($conn,$salesPending);
                            $fetchPaid=mysqli_fetch_array($getPaid);
                            $fetchPending=mysqli_fetch_array($getPending);

                        ?>
                        <!-- <div class="row clearfix">
                            <div class="col-lg-4 col-md-6 col-sm-12" >
                            <div class="card" style="background: linear-gradient(to right, lightgreen, #49c5b6);color:black"> 
                                    <div class="body">
                                    <h6>Paid : <?php echo $fetchPaid['totalpaid']? $fetchPaid['totalpaid']:0;?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card" style="background: linear-gradient(to right, lightgreen, #49c5b6);color:black"> 
                                    <div class="body">
                                    <h6>Un-Paid : <?php echo $fetchPending['totalPending']?$fetchPending['totalPending']:0;?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card" style="background: linear-gradient(to right, lightgreen, #49c5b6);color:black"> 
                                    <div class="body">
                                    <h6>Total : <?php echo ($fetchPaid['totalpaid']+$fetchPending['totalPending']);?></h6>
                                    </div>
                                </div>
                            </div>
                        
                            </div> -->
             
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Inovice No</th>
                                                <th>Party Name</th>
                                                <th>Payment Type</th>
                                                <th>Amount</th>
                                                <th>Balance Due</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Inovice No</th>
                                                <th>Party Name</th>
                                                <th>Payment Type</th>
                                                <th>Amount</th>
                                                <th>Balance Due</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                           
                                        </tbody>
                                    </table>
                                </div>  
                            </div>
                        </div> 
                    </div>
            <form id="edit_salesInvoice" action="../../sales/edit_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
            </form>
                    <script>
                function edit_invoice(val) {
                    document.getElementById('edit_sale_id').value=val;
                    document.getElementById('edit_salesInvoice').submit();
                }
            </script>
                    <script>
function get_list(val) {
    var formData = {};

    if (val === 'Today') {
        formData = {
            fromDate: "<?php echo date('Y-m-d'); ?> ",
            toDate: "<?php echo date('Y-m-d'); ?> "
        };
    }else if (val === 'Yesterday') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?> ",
            toDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?> "
        };
    }else if (val === 'This-Week') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('this week'));?> ",
            toDate: "<?php echo date('Y-m-d'); ?> "
        };
    }else if (val === 'This-Month') {
        formData = {
            fromDate: "<?php echo date('Y-m-01');?> ",
            toDate: "<?php echo date('Y-m-d'); ?> "
        };
    }else if (val === 'Current-Fiscal-Year') {
        formData = {
            fromDate: "<?php echo date('Y-4-01');?> ",
            toDate: "<?php echo date('Y-m-d'); ?> "
        };
    }else if (val === 'Last-7-days') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('-7 days'));?> ",
            toDate: "<?php echo date('Y-m-d'); ?> "
        };
    }else {
        let start = document.getElementById('startDate').value;
        let end = document.getElementById('endDate').value;
        formData = {
            fromDate: start,
            toDate: end 
        };
    }

    formData.party=document.getElementById('party').value;
    if(formData.party=='null'){
        formData.party='all';
    }
    $.ajax({
        url: "../../get_ajax/transaction_report/getsales.php",
        data: formData,
        type: 'POST',
        success: function(response) {
            loadTabledata(response);
            $("#table-body").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    get_list("This-Month");
});


</script>
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>