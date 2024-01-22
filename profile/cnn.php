    <?php
    $db_host1 ='localhost';
    $db_user1='u736864550_billprofiles';
    $db_pass1='Keshav@12345';
    $db_databse1='u736864550_billprofiles';

    $connect= mysqli_connect($db_host1,$db_user1,$db_pass1,$db_databse1);
    
        $data = file_get_contents('https://nayanfood.in/admin/profile/code.txt');
         $cnn=mysqli_query($connect,"select * from profile where unicode='$data'");
        $fetchcn=mysqli_fetch_array($cnn);
        
        $db_host ='localhost';
        $db_user=$fetchcn['dbusername'];
        $db_pass=$fetchcn['dbpassword'];
        $db_databse=$fetchcn['dbhostname'];
        mysqli_close($connect);

        $conn= mysqli_connect($db_host,$db_user,$db_pass,$db_databse);
