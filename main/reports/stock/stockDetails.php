<?php  
  include('../../common/header3.php'); 
  include('../../common/sidebar.php'); 

 ?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Stock Details</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Stock Details</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            
                    <div class="card planned_task">
                        <div class="body">
                             <form id="basic-form" method="post" action="">
                                 <div class="row clearfix">
                                        <div class="col-lg-6 col-md-12 my-2">
                                            <label>From Date</label>
                                            <input type="date" name="fromDate" onkeyup="getDetails()" id="fromDate" value="<?php echo date('Y-m-01'); ?>"   class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-md-12  my-2">
                                            <label>To Date</label>
                                            <input type="date" name="toDate" onkeyup="getDetails()" id="toDate" value="<?php echo date('Y-m-d'); ?>"  class="form-control" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
             
                        <div class="card planned_task">
                            <div class="body">
                                <div class="body table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Sale Price</th>
                                                <th>Begining Quantity</th>
                                                <th>Quantity In</th>
                                                <th>Purchase Amount</th>
                                                <th>Quantity Out</th>
                                                <th>Sale Amount</th>
                                                <th>Close Quantity</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Sale Price</th>
                                                <th>Begining Quantity</th>
                                                <th>Quantity In</th>
                                                <th>Purchase Amount</th>
                                                <th>Quantity Out</th>
                                                <th>Sale Amount</th>
                                                <th>Close Quantity</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="table-body">
                                            <?php
                                                $slno=1;
                                                $query="SELECT 
                                                p.id,
                                                p.productname,
                                                p.saleprice,
                                                p.openingstock,
                                                COALESCE(SUM(purchase_details.purchasedQty), 0) AS purchasedQty,
                                                COALESCE(SUM(purchase_details.purchasePrice), 0) AS purchasePrice,
                                                COALESCE(sales_details.salesQty, 0) AS salesQty,
                                                COALESCE(sales_details.salePrice, 0) AS salePrice
                                            FROM 
                                                tblproducts p
                                            LEFT JOIN 
                                                (SELECT 
                                                     ItemName,
                                                     SUM(Qty) AS purchasedQty,
                                                     SUM(Amount) AS purchasePrice
                                                 FROM 
                                                     tblpurchaseinvoice_details
                                                 GROUP BY 
                                                     ItemName) AS purchase_details ON purchase_details.ItemName = p.id
                                            LEFT JOIN 
                                                (SELECT 
                                                     ItemName,
                                                     SUM(Qty) AS salesQty,
                                                     SUM(Amount) AS salePrice
                                                 FROM 
                                                     tblsalesinvoice_details
                                                 GROUP BY 
                                                     ItemName) AS sales_details ON sales_details.ItemName = p.id
                                            WHERE 
                                                p.status = '1' 
                                                AND p.userID = '$session' 
                                            GROUP BY 
                                                p.id;
                                            ";
                                                $fetchProducts=mysqli_query($conn,$query);
                                                    while($row=mysqli_fetch_array($fetchProducts)){
                                                        $closeQty=$row['purchasedQty']-$row['salesQty'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $slno;?></td>
                                                        <td><?php echo $row['productname'];?></td>
                                                        <td><?php echo $row['saleprice'];?></td>
                                                        <td><?php echo $row['openingstock'];?></td>
                                                        <td><?php echo $row['purchasedQty'];?></td>
                                                        <td><?php echo '&#8377;'.$row['purchasePrice'];?></td>
                                                        <td><?php echo $row['salesQty'];?></td>
                                                        <td><?php echo '&#8377;'.$row['salePrice'];?></td>
                                                        <td><?php echo $closeQty;?></td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
           <script>
                function submitSaleInvoiceForm(val) {
                    document.getElementById('sale_id').value=val;
                    document.getElementById('salesInvoice').submit();
                }
                function edit_invoice(val) {
                    document.getElementById('edit_sale_id').value=val;
                    document.getElementById('edit_salesInvoice').submit();
                }
            </script>

<script>
function getDetails() {
    var fromDate=document.getElementById('fromDate').value;
    var toDate=document.getElementById('toDate').value;
    const formData={
        fromDate:fromDate,
        toDate:toDate
    };
    $.ajax({
        url: "../get_ajax/.php",
        data: formData,
        type: 'POST',
        success: function(response) {
            $("#sales-list").html(response);
        },
        error: function() {
            console.log("Error occurred while fetching parties.");
        }
    });
}

</script>

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