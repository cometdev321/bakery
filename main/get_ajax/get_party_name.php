 <?php
 include('../cnn.php');
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:../page-login");   
}

$session=$_SESSION['admin'];
$getParties = mysqli_query($conn, "SELECT mobno,name FROM tblparty where userID='$session'");
?>
<option selected value="null">Select Party Name</option>
<?php
while($party = mysqli_fetch_array($getParties)){
?>

<option value="<?php echo $party['name']; ?>" data-mobno="<?php echo $party['mobno']; ?>"><?php echo $party['name']; ?></option>
<?php
}
?>
<option value="add_new" class="btn btn-secondary btn-sm">Add New Party</option>
