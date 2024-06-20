<?php
session_start();
include('../common/cnn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
body {
    margin: 0;
    padding: 0;
    background-image: url('login/bck-image.jpg'); /* Correct path to your image file */
    background-size: cover;
    background-position: center;
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-style: normal;
    height: 100vh;
}
.bg-custom {
    background-image: url('login/bck-image.jpg'); /* Correct path to your image file */
    background-size: cover;
    background-position: center;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  // $(document).ready(function() {
  //   const urlParams = new URLSearchParams(window.location.search);
  //   const status = urlParams.get('status');
  //   if (status === 'usernotfound') {
  //     Toastify({
  //       text: "Wrong username or password",
  //       duration: 3000,
  //       newWindow: true,
  //       close: true,
  //       gravity: "top", // top, bottom, left, right
  //       position: "right", // top-left, top-center, top-right, bottom-left, bottom-center, bottom-right, center
  //       backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)", // Use gradient color
  //       margin: "70px 15px 10px 15px", // Add padding on the top of the toast message
  //       stopOnFocus: true, // Prevent dismissing of toast on hover
  //       onClick: function() {}, // Callback after click
  //     }).showToast();
  //   }
  // });
</script>
<body class="flex justify-center items-center h-screen bg-custom">
    <div class="p-8 rounded-lg shadow-md text-left w-full max-w-md mx-4 md:mx-auto">
      <form action="../common/session_control.php" method="post">
        <h2 class="text-2xl font-semibold mb-8 mt-0">Admin Login</h2>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">UserName</label>
            <input type="text" id="email" name="username" class="mt-1 px-4 py-2 w-full rounded-full border border-gray-300 focus:outline-none focus:border-blue-500 font-light font-poppins text-sm bg-gray-200">
        </div>
        <div class="mb-4 relative">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="mt-1 px-4 py-2 w-full rounded-full border border-gray-300 focus:outline-none focus:border-blue-500 font-light font-poppins text-sm bg-gray-200">
            <div class="absolute top-6 right-4 transform translate-y-1/2">
              <div onclick="togglePasswordVisibility()" style="cursor: pointer;">
                <img src="login/view.png" alt="Toggle Password Visibility" class="h-6 w-6 opacity-50">
              </div>
            </div>
        </div>
        <button type="submit" name="login-submit" class="w-full text-white py-4 px-4 rounded-full focus:outline-none" style="background-color: rgb(231,1,19); margin-top: 1rem;">Login</button>
      </form>
    </div>
    <!-- <img src="login/undraw_undraw_undraw_undraw_undraw_undraw_undraw_undraw_undraw_undraw_undraw_selectoption_y9cm_mx7w_-2.svg" alt="Your Image" class="hidden md:block absolute top-1/2 transform -translate-y-1/2 right-8 h-40 md:h-80"> Hide image on small screens -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>
</html>
