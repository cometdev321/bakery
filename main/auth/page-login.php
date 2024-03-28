<?php
session_start();
include('../common/cnn.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status === 'usernotfound') {
      Toastify({
        text: "Wrong username or password",
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // top, bottom, left, right
        position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
        backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)", // Use gradient color
        margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
        stopOnFocus: true, // Prevent dismissing of toast on hover
        onClick: function() {}, // Callback after click
      }).showToast();
    }
  });
</script>
<!doctype html>
<html lang="en">


<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:11:42 GMT -->
<head>
<title>ADMIN</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!--<link rel="icon" href="Images/nayanlogo.png" type="Images/nayanlogo.png">-->
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../../assets/css/main.css">
<link rel="stylesheet" href="../../assets/css/color_skins.css">
</head>
<style>
    body {
  background-image: url("../../Images/back.gif");

  height: 100vh;
}

</style>
<body class="theme-cyan" >
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
				         <?php
            //                 $getadmin=mysqli_query($conn,"select * from admin");
            //                 $fetchadmin=mysqli_fetch_array($getadmin);        
            //             ?>
            <!--//         <div class="top">-->
            <!--//             <img src="Images/<?php  echo $fetchadmin['image']; ?>" alt="Nayan">-->
            <!--//         </div>-->
					<div class="card">
                        <div class="header">
                            <p class="lead">Login to your account</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="../common/session_control.php" method="post">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                    <input type="text" class="form-control" id="signin-email" name="username"  placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" id="signin-password" name="password"  placeholder="Password">
                                </div>
                              
                                <button type="submit" name="login-submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-user"></i> <a href="create_new">Create New</a></span>
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="#" >Forgot password?</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
