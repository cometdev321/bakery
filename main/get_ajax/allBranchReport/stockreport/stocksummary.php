<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');
    $slno = 1;
    $fromDate=$_POST['fromDate'];
    $selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set
    $Csession=$_SESSION['admin'];

    if($selectedBranch=='All'){
        $query=mysqli_query($conn,"Select * from tblproducts where status='1' and userID in (select userID from tblusers where superAdminID='$Csession')");
    }else{
        $query=mysqli_query($conn,"Select * from tblproducts where status='1' and userID='$selectedBranch'");
    }
    while($row=mysqli_fetch_array($query)){
        $prid=$row['id'];
        if($selectedBranch=='All'){
            $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date<='$fromDate' and status='1' and userID in (select userID from tblusers where superAdminID='$Csession')");
        }else{
            $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date<='$fromDate' and status='1' and userID='$selectedBranch'");
        }
        $fetchBought=mysqli_fetch_array($queryForBought);
        if($selectedBranch=='All'){
            $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date<='$fromDate' and status='1' and userID in (select userID from tblusers where superAdminID='$Csession')");
        }else{
            $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date<='$fromDate' and status='1' and userID='$selectedBranch'");
        }
        $fetchsold=mysqli_fetch_array($queryForsales);
        
        $closeQty=($row['openingstock']+$fetchBought['qty'])-$fetchsold['qty'];
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