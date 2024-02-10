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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Sale Purchase By Party</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Sale Purchase By Party</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

             
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
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
                                                $query="select p.name as party,sum(ts.total_balance) as totalSales,
                                                sum(tp.total_balance) as totalPurchase from tblparty p
                                                LEFT join tblsalesinvoices ts on ts.party_name=p.id
                                                LEFT join tblpurchaseinvoices tp on tp.party_name=p.id
                                                 where p.status='1'and p.userID='$session' GROUP BY p.name;
                                                 ";
                                                $fetchProducts=mysqli_query($conn,$query);
                                                    while($row=mysqli_fetch_array($fetchProducts)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $slno;?></td>
                                                        <td><?php echo $row['party'];?></td>
                                                        <td><?php echo $row['totalSales']>0?'&#8377;'.$row['totalSales']:'&#8377;'.'0';?></td>
                                                        <td><?php echo $row['totalPurchase']>0?'&#8377;'.$row['totalPurchase']:'&#8377;'.'0';?></td>
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


<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 


<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/tables/jquery-datatable.js"></script>