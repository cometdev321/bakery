<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 
  $selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set

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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Party Wise Sales</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Party Wise Sales</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

                    <div class="card planned_task">
                        <div class="body">
                             <form id="basic-form" method="post" action="">
                                 <div class="row clearfix">
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>Party</label>
                                        <select class="form-control show-tick ms select2" id="party" data-placeholder="Select" name="category" onchange="getSales()" >
                                        <option >Select Party</option>
                                        <?php
                                        if($selectedBranch=='All'){
                                            $Csession=$_SESSION['admin'];
                                            $getct=mysqli_query($conn,"select id,name from tblparty where status='1' and userID in(select userID from tblusers where superAdminID='$Csession')");
                                        }else{
                                            $getct=mysqli_query($conn,"select id,name from tblparty where status='1' and userID='$selectedBranch'");
                                        }
                                        while($fetchcat=mysqli_fetch_array($getct)){
                                        ?>
                                        <option value="<?php echo $fetchcat['id']; ?>"><?php echo $fetchcat['name']; ?></option>
                                        <?php } ?>
                                        </select>                               
                                        </div>
                                        <div class="col-lg-3 col-md-12 my-2">
                                            <label>From Date</label>
                                            <input type="date" name="fromDate" onkeyup="getSales()" id="fromDate" value="<?php echo date('Y-m-01'); ?>"   class="form-control" required>
                                        </div>
                                        <div class="col-lg-3 col-md-12  my-2">
                                            <label>To Date</label>
                                            <input type="date" name="toDate" onkeyup="getSales()" id="toDate" value="<?php echo date('Y-m-d'); ?>"  class="form-control" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Date</th>
                                                <th>Invoice Number</th>
                                                <th>Amount</th>
                                                <th>Paid</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Date</th>
                                                <th>Invoice Number</th>
                                                <th>Amount</th>
                                                <th>Paid</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                        <tr>
                                            <td colspan="6" class="text-center">No records found</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
            <form id="salesInvoice" action="../../sales/view_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="sale_id" id="sale_id">
            </form>
            <form id="edit_salesInvoice" action="../../sales/edit_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
            </form>

<script>
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


function getSales() {
    var partyName=document.getElementById('party').value;;
    var fromDate=document.getElementById('fromDate').value;
    var toDate=document.getElementById('toDate').value;
    const formData={
        partyName:partyName,
        fromDate:fromDate,
        toDate:toDate
    };

    $.ajax({
    type: "POST",
    url: "../../get_ajax/allBranchReport/partyreport/getPartyWiseSales.php",
    data:formData,
    success: function(response){
      $("#table-body").html(response);
    //   loadAdditionalScripts();
    },
    error:function(){
        loadAdditionalScripts();
    }
    });
  }
   
  function loadAdditionalScripts() {
    // Load additional scripts after a delay using setTimeout
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
      "../../../assets/js/pages/forms/advanced-form-elements.js",
      "../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
      "../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js",
      "../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js",
      "../../../assets/vendor/nouislider/nouislider.js",
      "../../../assets/bundles/mainscripts.bundle.js",
      "../../../assets/js/pages/forms/advanced-form-elements.js",
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
  }
  </script>


<!-- Javascript -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>
</html>


