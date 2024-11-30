<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Item Report(Select a branch to view) </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Item Report </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            
                    <div class="card planned_task">
                        <div class="body">
                             <form id="basic-form" method="post" action="">
                                 <div class="row clearfix">
                                        <div class="col-lg-3 col-md-12 my-2">
                                            <label>Date</label>
                                            <input type="date" name="fromDate" onkeyup="getDetails()" id="fromDate" value="<?php echo date('Y-m-01'); ?>"   class="form-control" required>
                                        </div>
                                        <div class="col-lg-3 col-md-12  my-2">
                                            <label>To Date</label>
                                            <input type="date" name="toDate" onkeyup="getDetails()" id="toDate" value="<?php echo date('Y-m-d'); ?>"  class="form-control" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
             
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th> 
                                                <th>Sale Quantity</th>
                                                <th>Sale Amount</th>
                                                <th>Purchase Quantity</th>
                                                <th>Purchase Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>#</th>
                                                <th>Product</th>
                                                <th>Sale Quantity</th>
                                                <th>Sale Amount</th>
                                                <th>Purchase Quantity</th>
                                                <th>Purchase Amount</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>


<script>
function getDetails() {
    var fromDate=document.getElementById('fromDate').value;
    var toDate=document.getElementById('toDate').value;
    const formData={
        fromDate:fromDate,
        toDate:toDate,
    };
    $.ajax({
        url: "../../get_ajax/allBranchReport/stockreport/itemreport.php",
        data: formData,
        type: 'POST',
        success: function(response) {
            loadTabledata();
            $("#table-body").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    getDetails();
});

</script>
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>