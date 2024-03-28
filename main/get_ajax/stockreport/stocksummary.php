<?php
include('../../common/cnn.php');
include('../../common/session_control.php');
    $slno = 1;
    $fromDate=$_POST['fromDate'];
    $query=mysqli_query($conn,"Select * from tblproducts where status='1' and userID='$session'");
    while($row=mysqli_fetch_array($query)){
        $prid=$row['id'];
        $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date<='$fromDate' and status='1' and userID='$session'");
        $fetchBought=mysqli_fetch_array($queryForBought);
        $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date<='$fromDate' and status='1' and userID='$session'");
        $fetchsold=mysqli_fetch_array($queryForsales);
        
        $closeQty=$fetchBought['qty']-$fetchsold['qty'];
        ?>
            <tr>        
                <td><?php echo $slno;?></td>
                <td><?php echo $row['productname'];?></td>
                <td><?php echo '&#8377;'.$row['saleprice'];?></td>
                <td><?php echo '&#8377;'.$row['purchaseprice'];?></td>
                <td><?php echo $closeQty;?></td>
                <td><?php echo '&#8377;'.$closeQty*$row['purchaseprice'];?></td>
            </tr>
        <?php
            $slno++;
            }
        ?>