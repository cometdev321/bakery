<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>



 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Sale Purchase By Party Report</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Sale Purchase By Party Report</li>
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
                                                <th>Party Name</th>
                                                <th>Sale Amount</th>
                                                <th>Purchase Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Party Name</th>
                                                <th>Sale Amount</th>
                                                <th>Purchase Amount</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                            <?php
                                                $slno=1;
                                                $query="SELECT 
                                                p.id,
                                                p.name AS party,
                                                COALESCE(ts.totalSales, 0) AS totalSales,
                                                COALESCE(tp.totalPurchase, 0) AS totalPurchase
                                            FROM 
                                                tblparty p
                                            LEFT JOIN 
                                                (SELECT 
                                                     party_name,
                                                     SUM(after_discount_total) AS totalSales
                                                 FROM 
                                                     tblsalesinvoices
                                                 GROUP BY 
                                                     party_name) AS ts ON ts.party_name = p.id
                                            LEFT JOIN 
                                                (SELECT 
                                                     party_name,
                                                     SUM(after_discount_total) AS totalPurchase
                                                 FROM 
                                                     tblpurchaseinvoices
                                                 GROUP BY 
                                                     party_name) AS tp ON tp.party_name = p.id
                                            WHERE 
                                                p.status = '1' AND p.userID = '$session';
                                            
                                                 ";
                                                $fetchProducts=mysqli_query($conn,$query);
                                                    while($row=mysqli_fetch_array($fetchProducts)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $slno;?></td>
                                                        <td><?php echo $row['party'];?></td>
                                                        <td><span class="green-text">&#8377;<?php echo $row['totalSales']>0?$row['totalSales'] .'&darr;':'0'.'&darr;';?></span></td>
                                                        <td><span class="red-text">&#8377;<?php echo $row['totalPurchase']>0?$row['totalPurchase'].'&uarr;':'0'.'&uarr;';?></span></td>
                                                    </tr>
                                                    <?php
                                                    $slno++;
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
                    <script> setTimeout(() => {
                        loadTabledata()
                    }, 100);</script>
                </body>
</html>