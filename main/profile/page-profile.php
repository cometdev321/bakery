<?php 

include('../common/header2.php'); 
include('../common/sidebar.php'); 
if (!isset($_SESSION['admin'])) {
    echo '<script type="text/javascript">
    window.location.href = "../dashboard";
  </script>';
}

?>
<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Update the database
  $sql = "UPDATE admin SET Name='$first_name', PhoneNumber='$last_name', Email='$username', Password='$password' WHERE unicode='$session'";
  mysqli_query($conn, $sql);

  // Update the profile photo if a new one has been uploaded
  if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['photo']['tmp_name'];
    $new_name = "../../Images/" . $_FILES['photo']['name'];
    move_uploaded_file($tmp_name, $new_name);
    $photo_name = $_FILES['photo']['name'];
    $sql = "UPDATE `admin` SET image='$photo_name' WHERE unicode='$session'";
    mysqli_query($conn, $sql);
  }
}

?>

    <div id="main-content" class="profilepage_1">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> User Profile</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-2.html"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <ul class="nav nav-tabs">                                
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Settings">Settings</a></li>
                                <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#billings">Billings</a></li>-->
                                <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#preferences">Preferences</a></li>-->
                            </ul>
                        </div>
                         <?php
                            $getadmin=mysqli_query($conn,"select * from admin  where unicode='$session'");
                            $fetchadmin=mysqli_fetch_array($getadmin);        
                        ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="Settings">
                                <form action="" method="post" enctype="multipart/form-data">
                                <div class="body">
                                    <h6>Company Logo</h6>
                                    <div class="media">
                                        <div class="media-left m-r-15">
                                            <img src="../../Images/<?php  echo $fetchadmin['image']; ?>" class="user-photo media-object" alt="User">
                                        </div>
                                        <div class="media-body">
                                            <p>Upload your photo.
                                                <!--<br> <em>Image should be at least 140px x 140px</em>-->
                                                <!--</p>-->
                                            <button type="button" class="btn btn-default-dark" id="btn-upload-photo">Upload Photo</button>
                                            <input type="file" id="filePhoto" accept="image/*" name="photo" class="sr-only">
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="body">
                                    <h6>Basic Information</h6>
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md -12">
                                            <div class="form-group">                                                
                                                <input type="text" class="form-control" value="<?php echo $fetchadmin['Name']; ?>" name="first_name" placeholder="First Name">
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">                                                
                                                <input type="text" class="form-control" value="<?php echo $fetchadmin['PhoneNumber']; ?>" name="last_name" placeholder="Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-12">
                                            <h6>Account Data</h6>
                                            <div class="form-group">                                                
                                                <input type="text" class="form-control" value="<?php echo $fetchadmin['Email']; ?>" name="username"  placeholder="Username">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12">
                                            <h6>Change Password</h6>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="<?php echo $fetchadmin['Password']; ?>" name="password" placeholder="Current Password">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="save" class="btn btn-success btn-sm">Update</button> &nbsp;&nbsp;
                                </div>
                                </form>
                            </div>
    
                            <div class="tab-pane" id="billings">
                                
                                <div class="body">
                                    <h6>Payment Method</h6>
                                    <div class="payment-info">
                                        <h3 class="payment-name"><i class="fa fa-paypal"></i> PayPal ****2222</h3>
                                        <span>Next billing charged $29</span>
                                        <br>
                                        <em class="text-muted">Autopay on May 12, 2018</em>
                                        <a href="javascript:void(0);" class="edit-payment-info">Edit Payment Info</a>
                                    </div>
                                    <p class="margin-top-30"><a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add Payment Info</a></p>
                                </div>

                                <div class="body">
                                    <h6>Billing History</h6>
                                    <table class="table billing-history">
                                        <thead class="sr-only">
                                            <tr>
                                                <th>Plan</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h3 class="billing-title">Basic Plan <span class="invoice-number">#LA35628</span></h3>
                                                    <span class="text-muted">Charged at April 17, 2018</span>
                                                </td>
                                                <td class="amount">$29</td>
                                                <td class="action"><a href="javascript:void(0);">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h3 class="billing-title">Pro Plan <span class="invoice-number">#LA3599</span></h3>
                                                    <span class="text-muted">Charged at March 18, 2018</span>
                                                </td>
                                                <td class="amount">$59</td>
                                                <td class="action"><a href="javascript:void(0);">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h3 class="billing-title">Platinum Plan <span class="invoice-number">#LA1245</span></h3>
                                                    <span class="text-muted">Charged at Feb 02, 2018</span>
                                                </td>
                                                <td class="amount">$89</td>
                                                <td class="action"><a href="javascript:void(0);">View</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>

                            </div>
    
                            <div class="tab-pane" id="preferences">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="body">
                                            <h6>Your Login Sessions</h6>
                                            <ul class="list-unstyled list-login-session">
                                                <li>
                                                    <div class="login-session">
                                                        <i class="fa fa-laptop device-icon"></i>
                                                        <div class="login-info">
                                                            <h3 class="login-title">Mac - New York, United States</h3>
                                                            <span class="login-detail">Chrome - <span class="text-success">Active Now</span></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="login-session">
                                                        <i class="fa fa-desktop device-icon"></i>
                                                        <div class="login-info">
                                                            <h3 class="login-title">Windows 10 - New York, United States</h3>
                                                            <span class="login-detail">Firefox - about an hour ago</span>
                                                        </div>
                                                        <button type="button" class="btn btn-link btn-logout" data-container="body" data-toggle="tooltip" title="Close this login session"><i class="fa fa-times-circle text-danger"></i></button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="login-session">
                                                        <i class="fa fa-mobile fa-fw device-icon"></i>
                                                        <div class="login-info">
                                                            <h3 class="login-title">Android - New York, United States</h3>
                                                            <span class="login-detail">Android Browser - yesterday</span>
                                                        </div>
                                                        <button type="button" class="btn btn-link btn-logout" data-container="body" data-toggle="tooltip" title="Close this login session"><i class="fa fa-times-circle text-danger"></i></button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="body">
                                            <h6>Connected Social Media</h6>
                                            <ul class="list-unstyled list-connected-app">
                                                <li>
                                                    <div class="connected-app">
                                                        <i class="fa fa-facebook app-icon"></i>
                                                        <div class="connection-info">
                                                            <h3 class="app-title">FaceBook</h3>
                                                            <span class="actions"><a href="javascript:void(0);">View Permissions</a> <a href="javascript:void(0);" class="text-danger">Revoke Access</a></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="connected-app">
                                                        <i class="fa fa-twitter app-icon"></i>
                                                        <div class="connection-info">
                                                            <h3 class="app-title">Twitter</h3>
                                                            <span class="actions"><a href="javascript:void(0);">View Permissions</a> <a href="javascript:void(0);" class="text-danger">Revoke Access</a></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="connected-app">
                                                        <i class="fa fa-instagram app-icon"></i>
                                                        <div class="connection-info">
                                                            <h3 class="app-title">Instagram</h3>
                                                            <span class="actions"><a href="javascript:void(0);">View Permissions</a> <a href="javascript:void(0);" class="text-danger">Revoke Access</a></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="connected-app">
                                                        <i class="fa fa-linkedin app-icon"></i>
                                                        <div class="connection-info">
                                                            <h3 class="app-title">Linkedin</h3>
                                                            <span class="actions"><a href="javascript:void(0);">View Permissions</a> <a href="javascript:void(0);" class="text-danger">Revoke Access</a></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="connected-app">
                                                        <i class="fa fa-vimeo app-icon"></i>
                                                        <div class="connection-info">
                                                            <h3 class="app-title">Vimeo</h3>
                                                            <span class="actions"><a href="javascript:void(0);">View Permissions</a> <a href="javascript:void(0);" class="text-danger">Revoke Access</a></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script>
    $(function() {
        // photo upload
        $('#btn-upload-photo').on('click', function() {
            $(this).siblings('#filePhoto').trigger('click');
        });

        // plans
        $('.btn-choose-plan').on('click', function() {
            $('.plan').removeClass('selected-plan');
            $('.plan-title span').find('i').remove();

            $(this).parent().addClass('selected-plan');
            $(this).parent().find('.plan-title').append('<span><i class="fa fa-check-circle"></i></span>');
        });
    });
    </script>
</body>

</html>