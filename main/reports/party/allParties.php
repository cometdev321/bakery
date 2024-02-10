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
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PartyName</th>
                                                <th>Mobno</th>
                                                <th>Receivable Balance</th>
                                                <th>Payable Balance</th>
                                                <th>Credit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PartyName</th>
                                                <th>Mobno</th>
                                                <th>Receivable Balance</th>
                                                <th>Payable Balance</th>
                                                <th>Credit</th>
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
    getSales();
  });
  document.title='AllParties';
</script>




<!-- Javascript -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>



</body>

</html>

