<?php include('header.php');?>
<?php
include('cnn.php');

if(isset($_POST['submit'])){
  
         $id  =     $_POST["id"];
         $catname  =     $_POST["catname"];

   
              $insert_query = "UPDATE tblcategory SET name='$catname' WHERE id=$id";
              $insert_result = mysqli_query($conn, $insert_query);
            
             if ($insert_result) {
                echo"<script>window.location.href='add-category?status=updated'</script>";
            } else {
                echo"<script>window.location.href='add-category?status=error'</script>";

            }

}


?>
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Branch</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <?php
            if (isset($alert_type)) {
                  echo '<div class="alert text-dark l-' . $alert_type . '" role="alert">';
                  echo $alert_message;
                  echo '</div>';
                  
                }
            ?>
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Category Details</h2>
                        </div>
                        <div class="body">
                            <?php
                                $id=$_POST['category'];
                                $mycat=mysqli_query($conn,"Select * from tblcategory where id=$id");
                                $catdetails=mysqli_fetch_array($mycat);
                            ?>
                             <form  method="post" action="">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" value="<?php echo $catdetails['name'];?>" name="catname" required>
                                    <input type="text" hidden class="form-control" value="<?php echo $id ?>" name="id" required>
                                </div>
                                <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

                                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Category Details<small>Edit and Remove your branches here</small> </h2>                            
                        </div>
                        <div class="body">
						<div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Category Name</th>
                                        <th>Edit</th>
                                        <th>remove</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Category Name</th>
                                        <th>Edit</th>
                                        <th>remove</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                    $slno=1;
                                    $query = "SELECT * FROM tblcategory WHERE status = '1' order by id desc";
                                    $result = mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                    <tr>
                                        <td><?php echo $slno;?></td>
                                        <td><?php echo $row['name'];?></td>
                                        <td>
                                            <form action="edit-category" method="post">
                                            <input name="category" value="<?php echo $row['id'];?>" hidden>
                                            <button type="submit" class="btn btn-success btn-sm "><i class="icon-pencil"></i><span></span></button>
                                            </form>
                                        </td>
                                        <td><button type="submit" name="submit" class="btn btn-danger btn-sm js-sweetalert" data-type="ajax-loader" onclick="ready(<?php echo $row['id'];?>)"><i class="icon-trash"></i></button></td>
                                    </tr>
                                <?php $slno++; } ?>
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
       url:"remove_item.php",
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
<script src="assets/bundles/libscripts.bundle.js"></script>    
<script src="assets/bundles/vendorscripts.bundle.js"></script>

<script src="assets/bundles/datatablescripts.bundle.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 
<script src="assets/js/pages/ui/dialogs.js"></script>

<script src="../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>

<script src="../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
  <script src="assets/js/pages/tables/jquery-datatable.js"></script>
  
<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

