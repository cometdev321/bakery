<?php 
    include('../common/header2.php');
    include('../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');

?>

    <div id="main-content">
        <div class="container-fluid">
           <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Purchase Invoices</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Purchase Invoices</li>
                    </ul>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='create_purchase_invoice'"><i class="fa fa-plus"></i> <span>&nbsp;Create Purchase Invoice</span></button>
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
                                <select class="form-control" name="time_period" id="time_period" onchange="get_list(this.value)">
                                    <option selected value="Today">Today</option>
                                    <option value="Yesterday">Yesterday</option>
                                    <option value="This-Week">This-Week</option>
                                    <option value="This-Month">This-Month</option>
                                    <option value="Current-Fiscal-Year">Current Fiscal Year </option>
                                    <option value="Last-7-days">Last 7 days</option>
                                </select>
                                </div>
                            </div>
                         <div class="col-lg-9 col-md-12 row">
                            <div class="form-group">
                                <label>Time</label>
                                <div class="input-group">
                                    <div class="col-lg-4" style="width:250px">
                                        <input type="date" class="form-control" id="startDate" value="date-range" onchange="get_list(this.value)">
                                    </div>
                                    <span class="input-group-addon">TO</span>
                                    <div class="col-lg-4" style="width:250px">
                                        <input type="date" class="form-control" id="endDate" value="date-range" onchange="get_list(this.value)">
                                    </div>
                                </div>
                            </div>
                        </div>


                        </div>
                    </div>
                </div>

                               <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Purchase INVOICE LIST </h2>                            
                        </div>
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>SLNO</th>
                                        <th>DATE</th>
                                        <th>PURCHASE INVOICE NUMBER</th>
                                        <th>PARTY NAME</th>
                                        <th>AMOUNT</th>
                                        <th>TYPE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>SLNO</th>
                                        <th>DATE</th>
                                        <th>PURCHASE INVOICE NUMBER</th>
                                        <th>PARTY NAME</th>
                                        <th>AMOUNT</th>
                                        <th>TYPE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </tfoot>
                                <tbody id="Purchase-list">
                                 
                                </tbody>
                            </table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <form id="PurchaseInvoice" action="view_purchase" method="POST" style="display: none;">
                <input type="text" hidden name="purchase_id" id="purchase_id">
            </form>
            <form id="edit_PurchaseInvoice" action="edit_purchase" method="POST" style="display: none;">
                <input type="text" hidden name="edit_purchase_id" id="edit_purchase_id">
            </form>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
           <script>
                function submitPurchaseInvoiceForm(val) {
                    document.getElementById('purchase_id').value=val;
                    document.getElementById('PurchaseInvoice').submit();
                }
                function edit_invoice(val) {
                    document.getElementById('edit_purchase_id').value=val;
                    document.getElementById('edit_PurchaseInvoice').submit();
                }
            </script>
<script>
function get_list(val) {
    var formData = {};

      if (val === 'Today') {
        formData = {
            fromDate: "<?php echo date('Y-m-d'); ?> 00:00:00",
            toDate: "<?php echo date('Y-m-d'); ?> 23:59:59"
        };
    }else if (val === 'Yesterday') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?> 00:00:00",
            toDate: "<?php echo date('Y-m-d', strtotime('yesterday')); ?> 23:59:59"
        };
    }else if (val === 'This-Week') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('this week'));?> 00:00:00",
            toDate: "<?php echo date('Y-m-d'); ?> 23:59:59"
        };
    }else if (val === 'This-Month') {
        formData = {
            fromDate: "<?php echo date('Y-m-1');?> 00:00:00",
            toDate: "<?php echo date('Y-m-d'); ?> 23:59:59"
        };
    }else if (val === 'Current-Fiscal-Year') {
        formData = {
            fromDate: "<?php echo date('Y-4-1');?> 00:00:00",
            toDate: "<?php echo date('Y-m-d'); ?> 23:59:59"
        };
    }else if (val === 'Last-7-days') {
        formData = {
            fromDate: "<?php echo date('Y-m-d', strtotime('-7 days'));?> 00:00:00",
            toDate: "<?php echo date('Y-m-d'); ?> 23:59:59"
        };
    }else {
        let start = document.getElementById('startDate').value;
        let end = document.getElementById('endDate').value;
        formData = {
            fromDate: start,
            toDate: end 
        };
    }
    
    $.ajax({
        url: "../get_ajax/get_Purchase_invoice_list.php",
        data: formData,
        type: 'POST',
        success: function(response) {
            $("#Purchase-list").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}

  get_list("Today");
</script>
<script>
    document.title="NAYAN"
</script>
<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>

