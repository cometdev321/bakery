<?php
include('../../../common/cnn.php');
include('../../../common/session_control.php');
    $slno = 1;
    $fromDate=$_POST['fromDate'];
    $toDate=$_POST['toDate'];
    $selectedBranch = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : 'All'; // Default to 'All' if not set
    $Csession=$_SESSION['admin'];
 
    if($selectedBranch=='All'){
        $query = "SELECT u.username,p.id, p.productname, p.saleprice, p.openingstock, p.purchaseprice 
        FROM tblproducts p
        JOIN tblusers u ON p.userID = u.userID
        WHERE p.status = '1' 
        AND u.superAdminID = '$Csession'
        AND u.status = '1'
        GROUP BY p.productname, p.saleprice, p.openingstock, p.purchaseprice";

    }else{
        $query = "SELECT u.username,p.id, p.productname, p.saleprice, p.openingstock, p.purchaseprice 
        FROM tblproducts p
        JOIN tblusers u ON p.userID = u.userID
        WHERE p.status = '1' 
        AND p.userID = '$selectedBranch'
        GROUP BY p.productname, p.saleprice, p.openingstock, p.purchaseprice;
";
    }                    
    
 
                                                
                                            
        $fetchProducts=mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($fetchProducts)){
            $prid=$row['id'];
            if($selectedBranch=='All'){
                $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID in (select userID from tblusers where superAdminID='$Csession')");
            }else{
                $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$selectedBranch'");
            }
            $fetchBought=mysqli_fetch_array($queryForBought);
            if($selectedBranch=='All'){
                $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID  in (select userID from tblusers where superAdminID='$Csession')");
            }else{
                $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$selectedBranch'");
            }
            $fetchsold=mysqli_fetch_array($queryForsales);

            $closeQty=($row['openingstock']+$fetchBought['qty'])-$fetchsold['qty'];
            ?>
                <tr>
                    <td><?php echo $slno;?></td>
                    <td><?php echo strtoupper($row['username']);?></td>
                    <td><?php echo $row['productname'];?></td>
                    <td><?php echo '&#8377;'.$row['saleprice'];?></td>
                    <td><?php echo $row['openingstock'];?></td>
                    <td><?php echo $fetchBought['qty'];?></td>
                    <td><?php echo '&#8377;'.$row['purchaseprice'];?></td>
                    <td><?php echo $fetchsold['qty'];?></td>
                    <!-- <td><?php echo '&#8377;'.$fetchsold['amt'];?></td> -->
                    <td><?php echo $closeQty;?></td>
                </tr>
            <?php
                $slno++;
                }
            ?>