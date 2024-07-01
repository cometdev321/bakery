<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');
    $slno = 1;
    $fromDate=$_POST['fromDate'];
    $toDate=$_POST['toDate'];
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
            $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty,COALESCE(sum(Amount),0) as sprice from tblsalesinvoice_details where  ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID in (select userID from tblusers where superAdminID='$Csession')");
        }else{
            $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty,COALESCE(sum(Amount),0) as sprice from tblsalesinvoice_details where  ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$selectedBranch'");
        }
        $fetchsold=mysqli_fetch_array($queryForsales);
        if($selectedBranch=='All'){
            $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty,COALESCE(sum(Amount),0) as bprice from tblpurchaseinvoice_details where ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID  in (select userID from tblusers where superAdminID='$Csession')");
        }else{
            $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty,COALESCE(sum(Amount),0) as bprice from tblpurchaseinvoice_details where ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$selectedBranch'");
        }
        $fetchBought=mysqli_fetch_array($queryForBought);
        
        ?>
            <tr>        
                <td><?php echo $slno;?></td>
                <td><?php echo $row['productname'];?></td>
                <td><?php echo $fetchsold['qty'];?></td>
                <td><?php echo '&#8377;'.$fetchsold['sprice'];?></td>
                <td><?php echo $fetchBought['qty'];?></td>
                <td><?php echo '&#8377;'.$fetchBought['bprice'];?></td>
            </tr>
        <?php
            $slno++;
            }
        ?>