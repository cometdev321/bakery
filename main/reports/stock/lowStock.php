<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>

<?php
if(isset($_POST['submit'])) {
  
}
?>

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Low Stock Summary</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Low Stock Summary</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

             
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                        <?php
                                                $slno = 1;
                                                
                                                $query = "SELECT p.productname, p.saleprice, p.size, p.openingstock AS opstock, SUM(tpi.Qty) AS totalpurchased, SUM(tsi.Qty) AS totalsold FROM tblproducts p
                                                 JOIN tblpurchaseinvoice_details tpi ON tpi.ItemName = p.id 
                                                 JOIN tblsalesinvoice_details tsi ON tsi.ItemName = p.id 
                                                 WHERE p.status = '1' AND p.userID = '$session' 
                                                 GROUP BY p.productname, p.saleprice, p.size, p.openingstock
                                                 HAVING (SUM(tpi.Qty) + p.openingstock) - SUM(tsi.Qty) < 10
                                            ";
                                            
                                                $fetchProducts = mysqli_query($conn, $query);
                                                
                                                if (mysqli_num_rows($fetchProducts) > 0) {
                                                    while ($row = mysqli_fetch_array($fetchProducts)) {
                                            ?>
                                                        <tr>
                                                            <td><?php echo $slno; ?></td>
                                                            <td><?php echo $row['productname']; ?></td>
                                                            <td><?php echo '&#8377;' . $row['saleprice']; ?></td>
                                                            <td><?php echo $row['size']; ?></td>
                                                            <td><?php echo $row['opstock']; ?></td>
                                                        </tr>
                                            <?php
                                                        $slno++;
                                                    }
                                                } else {
                                            ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No records found</td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <script src="../../../assets/bundles/mainscripts.bundle.js"></script>
                    <script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
                    <script>loadTabledata();</script>
</body>
</html>