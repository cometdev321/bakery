    <?
    $db_host1 ='localhost';
    $db_user1='u736864550_billprofiles';
    $db_pass1='Keshav@12345';
    $db_databse1='u736864550_billprofiles';

    $connect= mysqli_connect($db_host1,$db_user1,$db_pass1,$db_databse1);
    $file_path = 'code.txt';
            
    if (!file_exists($file_path)) { 
        if(isset($_POST['setup'])){
            $first_name = mysqli_real_escape_string($connect, $_POST['first-name']);
            $last_name = mysqli_real_escape_string($connect, $_POST['last-name']);
            $admin_username = mysqli_real_escape_string($connect, $_POST['admin-username']);
            $admin_password = mysqli_real_escape_string($connect, $_POST['admin-password']);
            $unicode = mysqli_real_escape_string($connect, $_POST['unicode']);
            // $company_logo = $_FILES['company-logo'];
            
            $cnn=mysqli_query($connect,"select * from profile where unicode='$unicode'");
            $fetchcn=mysqli_fetch_array($cnn);
            
            $db_host ='localhost';
            $db_user=$fetchcn['dbusername'];
            $db_pass=$fetchcn['dbpassword'];
            $db_databse=$fetchcn['dbhostname'];
        
            $conn= mysqli_connect($db_host,$db_user,$db_pass,$db_databse);
                        
                  // Handle file upload
            $company_logo = $_FILES["company-logo"]["name"];
            $tmp_name = $_FILES['company-logo']['tmp_name'];
            $new_name = "../Images/" . $_FILES['company-logo']['name'];
            $new_name1 = "../../shop/Images/" . $_FILES['company-logo']['name'];
            
            // Move the uploaded file to the first destination
            if (move_uploaded_file($tmp_name, $new_name)) {
                // Make a copy of the file
                if (copy($new_name, $new_name1)) {
                    // File has been successfully moved to both destinations
                    // Insert data into admin table
                    mysqli_query($conn, "DELETE FROM admin");
                    $sql = "INSERT INTO admin (first_name, last_name, username, password, image)
                            VALUES ('$first_name', '$last_name', '$admin_username', '$admin_password', '$company_logo')";
            
                    if (mysqli_query($conn, $sql)) {
                        // Additional code here (if needed)
                        $file = fopen("code.txt", "w");
                        fwrite($file, $unicode);
                        fclose($file);
                        header("Location: ../");
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
                    }
                } else {
                    echo "Failed to copy the file to the second destination.";
                }
            } else {
                echo "Failed to move the file to the first destination.";
            }

            
            
                    
        }
        ?>
        <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Profile Setup</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    </head>
    
    <body>
        <center>
        <style>
       body {
      font-family: 'Open Sans', sans-serif;
    }
    
    .custom-input {
      border-radius: 10px;
      border: none;
      background-color: #f2f2f2;
      padding: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      color: #333;
    }
    
    .custom-btn {
      border-radius: 20px;
      background-color: #007bff;
      color: #fff;
      font-size: 18px;
      font-weight: bold;
      padding: 10px 30px;
      margin-top: 20px;
    }
    
    
    
        </style>
     <div class="container py-5 text-center">
      <img src="https://morningwind.in/demos/logo.png" height="70" width="200"/>
      <h1 class="mb-4 my-4">Activate Your Account</h1>
    
      <!-- Code Input Form -->
      <div id="code-form">
          <div class="form-group">
            <label for="code" class="form-label">Enter The Unique Provided Code:</label>
            <input type="text" class="form-control custom-input" id="code" name="code" placeholder="Type Here" required>
                  <div id="error" class="invalid-feedback">Invalid Code.Please Enter Valid Code</div>
          </div>
          <button type="button" class="btn btn-primary btn-sm custom-btn" onclick="checkcode()">Next</button>
      </div>
    
      <!-- Admin Form (hidden by default) -->
      <div id="admin-form" style="display:none">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="first-name" class="form-label">First Name:</label>
            <input type="text" class="form-control custom-input" id="first-name" name="first-name" required>
          </div>
          <div class="form-group">
            <label for="last-name" class="form-label">Last Name:</label>
            <input type="text" class="form-control custom-input" id="last-name" name="last-name" required>
          </div>
          <div class="form-group">
            <label for="company-logo" class="form-label">Company Logo(PNG prefered):</label>
            <input type="file" class="form-control custom-input" id="company-logo" name="company-logo" accept=".png, .jpg, .jpeg" required>
          </div>
          <div class="form-group">
            <label for="admin-username" class="form-label">Set login Username:</label>
            <input type="text" class="form-control custom-input" id="admin-username" name="admin-username" required>
            <input type="hidden" class="form-control custom-input" id="unicode" name="unicode" required>
          </div>
          <div class="form-group">
            <label for="admin-password" class="form-label">Set login Password:</label>
            <input type="password" class="form-control custom-input" id="admin-password" name="admin-password" required>
          </div>
          <button type="submit"  name="setup" class="btn btn-primary custom-btn">Submit</button>
        </form>
      </div>
    
    </div>
    
    </center>
              <!-- Bootstrap JS -->
              <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script>
             <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
              <script>
               function checkcode() {
      let codes = document.getElementById("code").value;
      $.ajax({
        type: "POST",
        url: "check_code.php",
        data: {code: codes},
        success: function(response) {
         if(response==' found'){
            unicode.value=codes;
            document.getElementById("code-form").style.display = "none";
            document.getElementById("admin-form").style.display = "block";
        }else{
            document.getElementById("error").style.display = "block";
        }
    
        }
      });
    }
              </script>
    </body>
    </html>
    <?
    } else{
        

    }
?>

