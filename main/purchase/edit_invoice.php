<?php 
    include('../common/header2.php');
    include('../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');
$paymentInID=$_POST['edit_payment'];
$query = "SELECT pi.*, p.name AS `name`
          FROM tblpaymentout pi
          INNER JOIN tblparty p ON pi.partyName = p.id
          WHERE pi.id = '$paymentInID' AND pi.userID = '$session'";
          $result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
?>
<style>
  .required {
    color: red;
  }
  
  .modal-body {
    margin-top: -10px;
  }
</style>
<script>
    
  
  
    function handleSelectChange(selectElement,val) {     
            party_name.value=selectElement;
            party_mobno.value=val;
        
        
    }



    
</script>

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Create Payment Out</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Create Payment Out</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

            <div class="card planned_task">
              <form action="" method="post">
                <div class="body">
                  <div class="row clearfix">
                    <div class="col-lg-6">
                      <div class="row">
                        <div class="col-md-12 my-2">
                          <label>Party</label>
                          <input id="party_name" value="<?php echo $row['partyName']; ?>" hidden>
                          <input id="payOutId" value="<?php echo $paymentInID;?>" hidden>
                          <select class="form-control show-tick ms select2" data-placeholder="Select" name="party_name" id="partySelect" onchange="handleSelectChange(this.value, this.options[this.selectedIndex].dataset.mobno),clear_product_error()">
                          <option selected value="<?php echo $row['partyName']; ?>" class="btn btn-secondary btn-sm"><?php echo $row['name']; ?></option>
                         
                        </select>
                          <small id="party_errorMessage" class="text-danger" style="display: none;">Select Party</small>
                        </div>
                        <div class="col-md-12 my-2">
                          <label>Party Mobile Number</label>
                          <input type="text" name="party_mobno" value="<?php echo $row['partyMobno']; ?>" placeholder="Type here" id="party_mobno" readonly class="form-control" >
                        </div>
                       <div class="col-md-12 my-2">
                          <label>Amount Received</label>
                          <style>
                            #payment_amount {
                              height: 60px;
                              font-size: 18px;
                          
                            }
                            .rupee-sign::before {
                              content: "\20B9 "; /* Unicode for the rupee symbol */
                            }
                          </style>
                        
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text rupee-sign"></span>
                            </div>
                            <input type="number" name="payment_amount" id="payment_amount" value="<?php echo $row['paymentAmount']; ?>" placeholder="Type Here" class="form-control" onkeyup="clear_product_error()" required>
                          </div>
                          <small id="payamount_errorMessage" class="text-danger" style="display: none;">Select Party</small>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                        <div class="col-md-12 my-2">
                          <label>Receipt Number</label>
                          <input type="number" name="paymentIN_number" id="paymentIN_number" value="<?php echo $row['paymentOutNumber']; ?>" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 my-2">
                          <label>Payment Out Date</label>
                          <input type="date" name="payment_date" id="payment_date" value="<?php echo $row['paymentDate']; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-12 my-2">
                          <label>Payment Mode</label>
                          <select class="form-control show-tick ms select2" data-placeholder="Select" name="payment_mode" id="payment_mode">
                            <option selected value="<?php echo $row['paymentMode']; ?>"><?php echo $row['paymentMode']; ?></option>
                            <option  value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="cheque">Cheque</option>
                          </select>
                        </div>
                        <div class="col-md-12 my-2">
                          <label>Note</label>
                          <textarea name="note" placeholder="Type here" id="note" class="form-control" ><?php echo $row['Notes']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                     <div class="row">&nbsp;</div>
                    <div class="row clearfix" style="float: right;">
                    <button type="button" class="btn btn-success mx-2" onclick="check_salesOut()">
                        <i class="fa fa-check-circle"></i> <span>Save</span>
                    </button>
                    <button type="button" class="btn btn-primary" onclick="location.reload()">
                        Cancel <span></span>
                    </button>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">&nbsp;</div>
                </div>
              </form>
            </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  
       function getparties() {
        $.ajax({
            url: "../get_ajax/get_party_name.php",
            method: "GET",
            success: function(response) {
                $("#partySelect").html(response);
            },
            error: function() {
                console.log("Error occurred while fetching parties.");
            }
        });
    }


    
 function clear_product_error(val) {
    party_errorMessage.style.display = 'none';
    payamount_errorMessage.style.display = 'none';
      
  }

    function check_salesOut() {
            var payOutId = document.getElementById("payOutId").value;
          var party = document.getElementById("party_name").value;
          var partyMobno = document.getElementById("party_mobno").value;
          var paymentAmount = document.getElementById("payment_amount").value;
          var paymentOutNumber = document.getElementById("paymentIN_number").value;
          var paymentDate = document.getElementById("payment_date").value;
          var paymentMode = document.getElementById("payment_mode").value;
          var note = document.getElementById("note").value;
          
  
          if (party === 'null') {
            party_errorMessage.style.display = 'block';
            party_errorMessage.textContent = 'Party Name Is Required.';
            window.scrollTo({
              top: 0,
              behavior: 'smooth' // Optional: Add smooth scrolling behavior
            });
            partySelect.focus();
            event.preventDefault();
            return;
          }
          if (paymentAmount === '') {
            payamount_errorMessage.style.display = 'block';
            payamount_errorMessage.textContent = 'Please Enter Amount';
            window.scrollTo({
              top: 0,
              behavior: 'smooth' // Optional: Add smooth scrolling behavior
            });
            payment_amount.focus();
            event.preventDefault();
            return;
          }

          var data = {
            payOutId: payOutId,
            partySelect: party,
            partyMobno: partyMobno,
            paymentAmount: paymentAmount,
            paymentOutNumber: paymentOutNumber,
            paymentDate: paymentDate,
            paymentMode: paymentMode,
            note: note
          };
          console.log(data);
          $.ajax({
            url: 'functions/update_paymentOut.php',
            method: 'POST',
            data: data,
             success: function(response) {
                window.location.href='paymentout_list?status=success'
            },
            error: function() {
              window.location.href='paymentout_list?status=error'
            }
          })
       
        
 
}
     document.addEventListener('DOMContentLoaded', function() {
        getparties();

    });    
</script>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>


<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 

<script src="../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>

