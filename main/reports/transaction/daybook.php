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
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PartyName</th>
                                                <th>Ref NO</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Money In</th>
                                                <th>Money Out</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PartyName</th>
                                                <th>Ref NO</th>
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
    url: "../../get_ajax/transaction_report/getdaybook.php",
      type: "POST",
      data:{date:date},
      success: function(response) {
        $("#table-body").html(response);
        loadAdditionalScripts();
      },
    error:function(){
        loadAdditionalScripts();
    }
    });
    
  }

  function loadAdditionalScripts() {
    // Load additional scripts after a delay using setTimeout
    // setTimeout(function() {

    var scriptElements = [
      "../../../assets/bundles/libscripts.bundle.js",
      "../../../assets/bundles/vendorscripts.bundle.js",
      "../../../assets/bundles/datatablescripts.bundle.js",
      "../../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js",
      "../../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js",
      "../../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js",
      "../../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js",
      "../../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js",
      "../../../assets/bundles/mainscripts.bundle.js",
      "../../../assets/js/pages/tables/jquery-datatable.js",
      "../../../assets/bundles/mainscripts.bundle.js",
      "../../../assets/js/pages/forms/advanced-form-elements.js"
    ];

    // Dynamically create script elements and append them to the document
    scriptElements.forEach(function(src) {
      // Check if the script already exists, if yes, remove it
      var existingScript = document.querySelector('script[src="' + src + '"]');
      if (existingScript) {
        existingScript.remove();
      }
      var script = document.createElement('script');
      script.src = src;
      document.body.appendChild(script);
    });
    // }, 2000);
  }

  document.addEventListener('DOMContentLoaded', function() {
    get_list();
  });
</script>




<!-- Javascript -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
<!--  -->
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>



</body>

</html>

