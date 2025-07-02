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
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Pending Payments</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Pending Payments</li>
                    </ul>
                </div>            
            </div>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>PENDING PAYMENT LIST </h2>                            
                        </div>
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                                <thead>
                                    <tr>
                                        <th>SLNO</th>
                                        <th>DATE</th>
                                        <th>SALES INVOICE NUMBER</th>
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
                                        <th>SALES INVOICE NUMBER</th>
                                        <th>PARTY NAME</th>
                                        <th>AMOUNT</th>
                                        <th>TYPE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </tfoot>
                                <tbody id="sales-list">
                                 
                                </tbody>
                            </table>
							</div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
            <form id="salesInvoice" action="../invoice/print" method="POST" style="display: none;">
                <input type="text" hidden name="sale_id" id="sale_id">
            </form>
            <form id="PosInvoice" action="../invoice/posprint" method="POST" style="display: none;">
                <input type="text" hidden name="sale_id" id="Pos_sale_id">
            </form>
            <form id="edit_salesInvoice" action="edit_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
            </form>
 
</div>
           <script>
                function submitSalePosForm(val) {
                    document.getElementById('Pos_sale_id').value=val;
                    document.getElementById('PosInvoice').submit();
                }
                function submitSaleInvoiceForm(val) {
                    document.getElementById('sale_id').value=val;
                    document.getElementById('salesInvoice').submit();
                }
                function edit_invoice(val) {
                    document.getElementById('edit_sale_id').value=val;
                    document.getElementById('edit_salesInvoice').submit();
                }
            </script>

<script>
function get_list() {

    $.ajax({
        url: "../get_ajax/get_pending_payment_list.php",
        type: 'POST',
        success: function(response) {
            $("#sales-list").empty();
            loadTabledata();
            $("#sales-list").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}

  get_list();
</script>
<script>
    document.title="NAYAN"
</script>
<!-- Javascript -->
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
</body>

</html>

