 <?php
    $db_host ='localhost';
    $db_user='u736864550_billprofiles';
    $db_pass='Keshav@12345';
    $db_databse='u736864550_billprofiles';

    $connect= mysqli_connect($db_host,$db_user,$db_pass,$db_databse);
    
    
    $code=$_POST['code'];
    $fetchcode=mysqli_query($connect,"select * from profile where unicode='$code'");
    if(mysqli_num_rows($fetchcode)>0){
        echo "found";
    }else{
        echo "error";
    }