 <?php
 include('../common/cnn.php');
 include('../common/session_control.php');


$getParties = mysqli_query($conn, "SELECT `mobno`,`name`,`id` FROM `tblparty` where userID='$session' and status='1' order by id desc");
?>
<option selected value="null">Select Party Name</option>
<?php
while($party = mysqli_fetch_array($getParties)){
?>
<option value="<?php echo $party['id']; ?>" data-mobno="<?php echo $party['mobno']; ?>"><?php echo $party['name']; ?></option>
<?php
}
?>
 