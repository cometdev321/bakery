<?php
include('../../common/cnn.php');
include('../../common/session_control.php');
    $slno = 1;
    $fromDate=$_POST['fromDate'];
    $toDate=$_POST['toDate'];
    $query = "
        SELECT 
        p.id,
        p.productname,
        p.saleprice,
        p.openingstock,
        p.purchaseprice
        FROM 
        tblproducts p
        where p.status='1' and p.userID='$session'
        GROUP BY 
        p.productname, p.saleprice, p.openingstock, p.purchaseprice;
        ";
                                            

                                               
                                            
        $fetchProducts=mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($fetchProducts)){
            $prid=$row['id'];
            $queryForBought=mysqli_query($conn,"select COALESCE(SUM(Qty), 0)  as qty from tblpurchaseinvoice_details where ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$session'");
            $fetchBought=mysqli_fetch_array($queryForBought);
            $queryForsales=mysqli_query($conn,"select COALESCE(SUM(Qty), 0) as qty from tblsalesinvoice_details where  ItemName='$prid' and date>='$fromDate' and date<='$toDate' and status='1' and userID='$session'");
            $fetchsold=mysqli_fetch_array($queryForsales);

            $closeQty=$fetchBought['qty']-$fetchsold['qty'];
            ?>
                <tr>
                    <td><?php echo $slno;?></td>
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