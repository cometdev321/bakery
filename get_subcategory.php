<?php
include('cnn.php');
$category=$_POST['category'];
$query=mysqli_query($conn,"SELECT * FROM tblsubcategory WHERE category='$category' and status='1'");
?>
<option value="">Select Subcategory</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo $row['subcat_name']; ?>"><?php echo $row['subcat_name']; ?></option>
  <?php
 }
?>