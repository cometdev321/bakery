<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header"> 
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Day Book</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Day Book</li>
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
                            <label>Day</label>
                            <div class="input-group">
                                    <input type="date" style="width:250px" class="form-control" id="date" value="<?php echo date('Y-m-d');?>" onchange="get_list()">
                            </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
                     
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <!-- <table class="table table-bordered table-striped table-hover dataTable js-exportable"> -->
                                <table class="table table-bordered table-striped table-hover " id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>PartyName</th>
                                                <th>Invoice No</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Money In</th>
                                                <th>Money Out</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>PartyName</th>
                                                <th>Invoice No</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Money In</th>
                                                <th>Money Out</th>
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
    var date=document.getElementById('date').value;
   $.ajax({
    url: "../../get_ajax/allBranchReport/transaction_report/getdaybook.php",
      type: "POST",
      data:{date:date},
      success: function(response) {
        $("#table-body").empty();
        loadTabledata();
        $("#table-body").html(response);
      },
    error:function(){
    }
    });
    
  }

  

  document.addEventListener('DOMContentLoaded', function() {
    get_list();
  });
</script>



<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>



</body>

</html>

