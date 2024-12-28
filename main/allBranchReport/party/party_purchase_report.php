<?php  
  include('../../common/header3.php');  
  include('../../common/sidebar.php'); 
  $selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set

 ?> 



 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Party Wise Purchase</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Party Wise Purchase</li>
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
                                        <select class="form-control show-tick ms select2" id="party" data-placeholder="Select" name="category" onchange="getPurchase()" >
                                        <option >Select Party</option>
                                        <?php
                                        if($selectedBranch=='All'||$selectedBranch=='ALL'){
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
                                            <input type="date" name="fromDate" onkeyup="getPurchase()" id="fromDate" value="<?php echo date('Y-m-01'); ?>"   class="form-control" required>
                                        </div>
                                        <div class="col-lg-3 col-md-12  my-2">
                                            <label>To Date</label>
                                            <input type="date" name="toDate" onkeyup="getPurchase()" id="toDate" value="<?php echo date('Y-m-d'); ?>"  class="form-control" required>
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
            <form id="PurchaseInvoice" action="../../purchase/view_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="sale_id" id="sale_id">
            </form>
            <form id="edit_PurchaseInvoice" action="../../purchase/edit_invoice" method="POST" style="display: none;">
                <input type="text" hidden name="edit_sale_id" id="edit_sale_id">
            </form>

<script>
    function submitSaleInvoiceForm(val) {
        document.getElementById('sale_id').value=val;
        document.getElementById('PurchaseInvoice').submit();
    }
    function edit_invoice(val) {
        document.getElementById('edit_sale_id').value=val;
        document.getElementById('edit_PurchaseInvoice').submit();
    }
</script>                   

 <script>


function getPurchase() {
    var partyName=document.getElementById('party').value;
    console.log(partyName);
    var fromDate=document.getElementById('fromDate').value;
    var toDate=document.getElementById('toDate').value;
    const formData={
        partyName:partyName,
        fromDate:fromDate,
        toDate:toDate
    };

    $.ajax({
    type: "POST",
    url: "../../get_ajax/allBranchReport/partyreport/getPartyWisePurchase.php",
    data:formData,
    success: function(response){
        loadTabledata();
      $("#table-body").html(response);
    //   loadAdditionalScripts();
    },
    error:function(){
        loadTabledata();
    }
    });
  }
   

  </script>

<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>


