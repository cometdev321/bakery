<?php  
include('../common/header2.php'); 
include('../common/sidebar.php'); 

 ?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Category</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Add Category</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Category File</h2>
                        </div>
                        <form  method="post" action="insert-category.php"  enctype="multipart/form-data">
                        <div class="body">
                             <?php if(isset($_SESSION['subSession'])){?>
                                  <div class="col-lg-12 col-md-6 my-2">
                                  <label>Branch</label>
                                  <select class="form-control show-tick ms select2" id="branch" name="branch" data-placeholder="Select" required > 
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
                                        <?php } ?>
                                <div class="col-lg-12 col-md-6 my-2">
                                    <label>Category File</label>
                                    <input type="file"  placeholder="Type Here" class="form-control" name="categoryfile" required>
                                </div>
                                <div class="form-group my-2">
                                <button type="submit"  name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
             

                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Category Details<small>Edit and Remove your Category here</small> </h2>                            
                        </div>
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Category Name</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                    if(isset($_SESSION['subSession'])){
                                      $userID=$_SESSION['subSession'];
                                    }else{
                                      $userID=$session;
                                 }
                                    $query = "SELECT * FROM tblcategory WHERE status = '1' and userID='$userID' order by id desc";
                                    $result = mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                    <tr>
                                        <td><?php echo $row['name'];?></td>
                                       </tr>
                                <?php } ?>
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

let catid=0;
function ready(val){
    catid+=val;
  setTimeout(function() {getalert(val);},50);
}

function getalert(val){
    const sweetAlertDiv = document.querySelector('.sweet-alert');
  if (sweetAlertDiv.style.display === 'block') {
     
     
    const h2Element = document.querySelector('.sweet-alert h2');
    h2Element.innerHTML = 'This will remove the category from list';
    
    const pElement = document.querySelector('.sweet-alert p');
    pElement.innerHTML = 'Press ok to proceed';
    

       
       setTimeout(checkok(),50);

  }
}


function checkok(){

  const okButton = document.querySelector('.sweet-alert .sa-confirm-button-container .confirm');
  
  function newOnClick() {
    $.ajax({
      url:"../common/remove_item.php",
       type:"post",
       data:{category:catid},
       success:function(response){
        setTimeout(displaysuccess,1980);
       }
    });

  }
  
      okButton.addEventListener('click', newOnClick);
}

function displaysuccess(){
   // Find the div element with data-has-cancel-button="false" and style="display: block;"
const divs = document.querySelectorAll('div[data-has-cancel-button="false"][style*="display: block;"]');

// Loop through each matching div element
for (const div of divs) {

  // Find the h2 element inside the div element
  const h2 = div.querySelector('h2');

  // If the h2 element contains the text "Ajax request finished!", replace it with "done"
if (h2 && h2.textContent.trim() === "Ajax request finished!") {
  h2.textContent = "Category Removed From List";
  const successDiv = document.createElement("div");
  successDiv.className = "sa-icon sa-success animate";
  successDiv.style.display = "block";
  successDiv.innerHTML = `
    <span class="sa-line sa-tip"></span>
    <span class="sa-line sa-long"></span>
    <div class="sa-placeholder"></div>
    <div class="sa-fix"></div>
  `;
  h2.insertAdjacentElement("afterend", successDiv);
        setTimeout(checkoks(),50);

}

}

}


function checkoks(){

  const okButton = document.querySelector('.sweet-alert .sa-confirm-button-container .confirm');
  
  function newOnClick() {
   window.location="";

  }
  
      okButton.addEventListener('click', newOnClick);
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

