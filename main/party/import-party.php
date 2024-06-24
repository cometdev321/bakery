<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
$(document).ready(function() {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'success') {
    Toastify({
      text: "party updated succesfully",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // top, bottom, left, right
      position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
      backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)", // Use gradient color
      margintop:"202px",
      stopOnFocus: true, // Prevents dismissing of toast on hover
      onClick: function(){}, // Callback after click
       style: {
        margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
      },
    }).showToast();
  }
   if (status === 'error') {
    Toastify({
      text: "party update failed",
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // top, bottom, left, right
      position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
      backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)", // Use gradient color with red mix
      stopOnFocus: true, // Prevents dismissing of toast on hover
      onClick: function(){}, // Callback after click
       style: {
        margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
      },
    }).showToast();
  }

});
</script>
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Import/Export Party</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Import/Export Party</li>
                        </ul>
                    </div>            
                </div>
            </div>
            
            <div class="row clearfix">

            
                <div class="col-lg-12">
                <form id="basic-form" method="post" action="insert_imported.php" enctype="multipart/form-data">
                    <div class="card">
                        <div class="body">
                        <?php 
                                  if(isset($_SESSION['subSession']) || isset($_SESSION['admin'])){
                                    if(isset($_SESSION['subSession'])){
                                        $S_O_branch=$_SESSION['subSession'];
                                        $getSessionName=mysqli_query($conn,"SELECT name from branch where id in(select branch from tblusers where userID='$S_O_branch')");
                                        $getSessionValue=mysqli_fetch_array($getSessionName);
                                    }
                                  ?>
                                      <div class="col-lg-12 col-md-12 my-2">
                                        <label>Select From Branches</label>
                                        <select  class="form-control show-tick ms select2" id="branch" name="branch"  data-placeholder="Select"  > 
                                        <?php  if(isset($_SESSION['subSession'])){ ?>
                                        <option value="<?php echo $S_O_branch;?>"><?php echo isset($getSessionValue['name']) ? strtoupper($getSessionValue['name']) : 'All';?> </option>
                                        <?php } ?>
                                        <option >Select Branch</option>
                                            <?php
                                                $branchQ="select tu.userID as unicodeBranch,b.name as name from branch b
                                                    join tblusers tu on tu.branch=b.id
                                                where b.status='1' and b.userID='$session'";
                                                $getbrx=mysqli_query($conn,$branchQ);
                                                while($fetchbx=mysqli_fetch_array($getbrx)){
                                            ?>
                                                <option value="<?php echo $fetchbx['unicodeBranch'];?>"><?php echo strtoupper($fetchbx['name']);?></option>
                                            <?php   
                                                }
                                            ?>
                                        </select>   
                                        </div>
                                  <?php
                                  }?>
                        <div class="col-lg-12 col-md-12 ">
                            <label >Import file</label>
                            <input type="file" name="partyfile" placeholder="Type Here" class="form-control" required>
                         </div>
                         <div class="form-group my-4">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Import</span></button>
                            </div>
                        </div>
                    </div>
                </form>

                    <!-- table start -->
                    <div class="card">
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>GstNO</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>GstNO</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                    $slno=1;
                                    if(!isset($_SESSION['admin'])){
                                        $query = "SELECT * FROM tblparty WHERE status = '1'  and userID='$session' order by id desc";
                                    }else{
                                        error_reporting(0);
                                        $selectedBranch=$_SESSION['subSession'];
                                        if($selectedBranch=='All'){
                                            $Csession=$_SESSION['admin'];
                                            $query = "SELECT * FROM tblparty WHERE status = '1'  and userID in (select userID from tblusers where superAdminID='$Csession') order by id desc";
                                        }else{
                                            $query = "SELECT * FROM tblparty WHERE status = '1'  and userID='$selectedBranch' order by id desc";

                                        }

                                    }
                                    $result = mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                        
                                ?>
                                    <tr>
                                        <td><?php echo $row['name'];?></td>
                                        <td><?php echo $row['mobno'];?></td>
                                        <td><?php echo $row['gstno'];?></td>
                                    </tr>
                                <?php  } ?>
                                </tbody>
                            </table>
							</div>
              
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
    
</div>

<script>

  function delete_party(val) {
      
    $.ajax({
      url:"../common/remove_item.php",
       type:"post",
       data:{remove_party:val},
       success:function(response){
        location.reload();
       }
    });

  }
  


  function recover(val) {
      
      $.ajax({
        url:"../common/remove_item.php",
         type:"post",
         data:{recover_party:val},
         success:function(response){
          location.reload();
         }
      });
  
    }
    



</script>

<!--script to auto hide alert-->
<script>
// Wait for the document to load
document.addEventListener("DOMContentLoaded", function() {
  // Get the Bootstrap alert element
  var alert = document.querySelector(".alert");

  // If the alert element exists
  if (alert) {
    // Hide the alert after 2 seconds
    setTimeout(function() {
      alert.style.display = "none";
    }, 2000);
  }
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
<script src="../../assets/js/pages/ui/dialogs.js"></script>
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
  <script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
  
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

