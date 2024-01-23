<?php
session_start();
include('../common/cnn.php');

// Assuming you have already established a connection to the database and assigned it to the variable $conn.

function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

if (isset($_POST["create-submit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["Name"]);
    $address = mysqli_real_escape_string($conn, $_POST["Address"]);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST["mob1"]);
    $email = mysqli_real_escape_string($conn, $_POST["Email"]);
    $password = mysqli_real_escape_string($conn, $_POST["Password"]);
    $maxShops = mysqli_real_escape_string($conn, $_POST["MaxShops"]);
    $plan = mysqli_real_escape_string($conn, $_POST["Plan"]);

    $name = str_replace("'", "", $name);
    $address = str_replace("'", "", $address);
    $phoneNumber = str_replace("'", "", $phoneNumber);
    $email = str_replace("'", "", $email);
    $password = str_replace("'", "", $password);
    $maxShops = str_replace("'", "", $maxShops);
    $plan = str_replace("'", "", $plan);

    // Check if email or mobile number already exists
    $checkQuery = "SELECT * FROM admin WHERE Email='$email' OR PhoneNumber='$phoneNumber'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Email or mobile number already exists, handle this case (e.g., show an error message)
        // echo "Email or mobile number already exists. Please use a different one.";
    } else {
        // Email and mobile number are not in use, proceed with the INSERT query
        $randomString = generateRandomString(10);

        $sql = "INSERT INTO admin (Name, unicode, Address, PhoneNumber, Email, Password, MaxShops, Plan)
                VALUES ('$name', '$randomString', '$address', '$phoneNumber', '$email', '$password', '$maxShops', '$plan')";

        if (mysqli_query($conn, $sql)) {
            $adm = mysqli_query($conn, "SELECT * FROM `admin` WHERE `Email`='$email' AND `Password`='$password'");
            if ($adm->num_rows > 0) {
                $userdetails = mysqli_fetch_array($adm);
                $_SESSION['admin'] = $userdetails['unicode'];
                header("Location:../dashboard");
                exit();
            }
        } else {
            // Handle the case when the INSERT query fails (e.g., show an error message)
            echo "Error: " . mysqli_error($conn);
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
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>
<body class="theme-cyan" >
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
					<div class="card">
                        <div class="header">
                            <p class="lead">Create your account</p>
                        </div>
                        <div class="body">
                            <form action="" method="POST">
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="Name" required>
                                  </div>
                                  <div class="form-group">
                                    <textarea class="form-control" placeholder="Address" rows="3" id="comment" name="Address" required></textarea>
                                  </div>
                                  <div class="form-group">
                                     <input id="mob1" name="mob1" class="form-control" maxlength="10"  minlength="10" type="number" value="" onkeyup="update()" placeholder="Enter Mobile No" required> 
                                     <small id="mobile_errorMessage" class="text-danger" style="display: none;">Invalid Mobile Number</small>
                                     </div>
                                  <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="Email" required>
                                  </div>
                                  <div class="form-group">
                                    <input type="text" id="admin_pass" class="form-control" placeholder="Super admin panel password" onkeyup="update()"  name="Password" required>
                                    <small id="adminpass_errorMessage" class="text-danger" style="display: none;">Minimun length should be 6 characters</small>
                                  </div>
                                  <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Max no Shops/Outlets" name="MaxShops" required>
                                  </div>
                                  <div class="form-group">
                                    <select class="form-control" name="Plan">
                                      <option value="free-trial">Free trial</option>
                                      <option value="1-year-no-support">1 year plan without support</option>
                                      <option value="1-year-with-support" selected>1 year plan with customization and support</option>
                                    </select>
                                  </div>
                              
                                <button type="submit" name="create-submit" onclick="check_data();" class="btn btn-primary btn-lg btn-block">CREATE</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-user"></i> <a href="page-login">Already have an accout?</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
<script>

function update(){
    mobile_errorMessage.style.display='none';
    adminpass_errorMessage.style.display='none';
    }

function check_data(){
    let mobno=mob1.value;
	let firstChar = mobno.charAt(0);
	    if(mobno.length!==10){
		    mobile_errorMessage.style.display='block';
			mob1.focus();
            event.preventDefault();
            return; 
		}
		if (firstChar !== '6' && firstChar !== '7' && firstChar !== '8' && firstChar !== '9') {
		    mobile_errorMessage.style.display='block';
			mob1.focus();
            event.preventDefault();
			return;
        }
    let admin_passcode=admin_pass.value;
    if(admin_passcode.length<5){
        adminpass_errorMessage.style.display='block';
        admin_pass.focus();
        event.preventDefault();
		return;
    }
	
}
			                    
			                    
</script>

</html>
