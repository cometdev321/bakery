<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> All Parties</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">All Parties</li>
                        </ul>
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
                                                <th>PartyName</th>
                                                <th>Mobno</th>
                                                <th>Receivable Balance</th>
                                                <th>Payable Balance</th>
                                                <!-- <th>Credit</th> -->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PartyName</th>
                                                <th>Mobno</th>
                                                <th>Receivable Balance</th>
                                                <th>Payable Balance</th>
                                                <!-- <th>Credit</th> -->
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
  function getSales() {
    $.ajax({
      type: "GET",
      url: "../../get_ajax/getAllparties.php",
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
    getSales();


  });
  document.title='AllParties';


  

</script>


<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>

</html>

