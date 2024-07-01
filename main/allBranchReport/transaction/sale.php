<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 
?>
<link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../../../assets/css/main.css">


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
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="body row">
                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">
                                <label>Time</label>
                                <select class="form-control show-tick ms select2" data-placeholder="Select" name="time_period" id="time_period" onchange="get_list(this.value)">
                                    <option value="Today">Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="This-Week">This-Week</option>
                                    <option selected value="This-Month">This-Month</option>
                                    <option value="Current-Fiscal-Year">Current Fiscal Year </option>
                                    <option value="Last-7-days">Last 7 days</option>
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
            <div class="card planned_task">
                <div class="body">
                    <div class="body table-responsive">
                        <!-- <button class="btn btn-primary btn-sm my-4" id="exportButton">Excel Export</button>
                        <button class="btn btn-primary btn-sm my-4" id="pdfButton">Pdf</button> -->
                        <table class="table table-bordered table-striped table-hover" id="exportTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Party Name</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>Balance Due</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Party Name</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>Balance Due</th>
                                </tr>
                            </tfoot>
                            <tbody id="table-body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <form id="edit_salesInvoice" action="../../sales/edit_invoice" method="POST" style="display: none;">
            <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
        </form>
    </div>

    <script>
        // let ajaxData = [];

        function edit_invoice(val) {
            document.getElementById('edit_sale_id').value = val;
            document.getElementById('edit_salesInvoice').submit();
        }

        function get_list(val) {
            var formData = {};
            
            if (val === 'Today') {
                formData = {
                    fromDate: "<?php echo date('Y-m-d'); ?>",
                    toDate: "<?php echo date('Y-m-d'); ?>"
                };
            } else if (val === 'Yesterday') {
                formData = {
                    fromDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?>",
                    toDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?>"
                };
            } else if (val === 'This-Week') {
                formData = {
                    fromDate: "<?php echo date('Y-m-d', strtotime('this week'));?>",
                    toDate: "<?php echo date('Y-m-d'); ?>"
                };
            } else if (val === 'This-Month') {
                formData = {
                    fromDate: "<?php echo date('Y-m-01');?>",
                    toDate: "<?php echo date('Y-m-d'); ?>"
                };
            } else if (val === 'Current-Fiscal-Year') {
                formData = {
                    fromDate: "<?php echo date('Y-4-01');?>",
                    toDate: "<?php echo date('Y-m-d'); ?>"
                };
            } else if (val === 'Last-7-days') {
                formData = {
                    fromDate: "<?php echo date('Y-m-d', strtotime('-7 days'));?>",
                    toDate: "<?php echo date('Y-m-d'); ?>"
                };
            } else {
                let start = document.getElementById('startDate').value;
                let end = document.getElementById('endDate').value;
                formData = {
                    fromDate: start,
                    toDate: end 
                };
            }

            formData.branch = document.getElementById('branch').value;
            if (formData.branch == 'null') {
                formData.branch = 'all';
            }

            $.ajax({
                url: "../../get_ajax/allBranchReport/transaction_report/getsales.php",
                data: formData,
                type: 'POST',
                success: function(response) {
                    $("#table-body").empty();
                    loadTabledata();

                    $("#table-body").html(response);
                    
                    // Parse response and store in ajaxData
                    // ajaxData = [];
                    // $("#table-body tr").each(function() {
                    //     var row = [];
                    //     $(this).find("td").each(function() {
                    //         row.push($(this).text().trim());
                    //     });
                    //     ajaxData.push(row);
                    // });

                },
                error: function() {
                    console.log("Error occurred while fetching sales data.");
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            get_list("This-Month");
        });

    </script>
<script>
      
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script> -->
  
    <script src="../../../assets/bundles/mainscripts.bundle.js"></script>
    <script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>
