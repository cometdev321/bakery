<?php
session_start();
include('../common/cnn.php');

if(isset($_POST["login-submit"])){
  

 $username  =   $_POST["username"];
 $password  =   $_POST["password"];
    
        $adm=mysqli_query($conn,"SELECT * FROM `admin` WHERE `Email`='$username' AND `Password`='$password'");
         if($adm->num_rows>0)
            {
                $admindetails=mysqli_fetch_array($adm);
                $_SESSION['admin']=$admindetails['unicode'];
                $_SESSION['isAdmin']=1;
                header("Location:../dashboard");
                exit();
            }else{
        
        $usr=mysqli_query($conn,"SELECT * FROM `tblusers` WHERE `username`='$username' AND `password`='$password' and `status`=1");
         if($usr->num_rows>0)
            {
                $userdetails=mysqli_fetch_array($usr);
                $_SESSION['user']=$userdetails['userID'];
                $_SESSION['isAdmin']=0;
                header("Location:../dashboard");
                exit();
            }else{
                header("Location:page-login");
                exit();

            }
        }

}
?>
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
                            <form class="form-auth-small" action="" method="post">
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
