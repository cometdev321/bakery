<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> All Transaction</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">All Transaction</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="body row">
                        <div class="form-group"  style="padding-left:40px">
                            <label>From</label>
                            <div class="input-group">
                                    <input type="date" style="width:250px" class="form-control" id="fromDate" value="<?php echo date('Y-m-01');?>" onchange="get_list()">
                            </div>
                    </div>
                        <div class="form-group"  style="padding-left:40px">
                            <label>To</label>
                            <div class="input-group">
                                    <input type="date" style="width:250px" class="form-control" id="toDate" value="<?php echo date('Y-m-d');?>" onchange="get_list()">
                            </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
                     
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>PartyName</th>
                                                <th>Ref NO</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Received/Paid</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>PartyName</th>
                                                <th>Ref NO</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Received/Paid</th>
                                                <th>Balance</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                            <tr>
                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
  
                    <script>
                        function get_list() {
                            var fromDate=document.getElementById('fromDate').value;
                            var toDate=document.getElementById('toDate').value;
                            var formData={
                                fromDate:fromDate,
                                toDate:toDate
                            };
                        $.ajax({
                            url: "../../get_ajax/transaction_report/getalltransaction.php",
                            type: "POST",
                            data:formData,
                            success: function(response) {
                               loadTabledata();                            
                                $("#table-body").html(response);
                            },
                            error:function(){
                                loadTabledata();                            
                            }
                            });
                            
                        }

  
  document.addEventListener('DOMContentLoaded', function() {
    get_list();
  });
</script>




<!-- Javascript -->
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

</body>

</html>

