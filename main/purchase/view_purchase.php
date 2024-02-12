<?php

include('../common/header2.php');
include('../common/sidebar.php');

$id=$_POST['purchase_id'];




//$query = "SELECT * FROM tblpurchaseinvoices WHERE id ='$id' AND userID= '$session' ";

$query = "SELECT pi.* , p.name AS party_name
        FROM tblpurchaseinvoices pi JOIN tblparty p
        ON pi.party_name = p.id where pi.userId = '$session' AND pi.id = '$id'
        ORDER BY pi.id DESC";


$result = mysqli_query($conn, $query);

$row = mysqli_fetch_array($result);
date_default_timezone_set('Asia/Kolkata');
?>


 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Purchase Invoice</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active"> Purchase Invoice</li>
                        </ul>
                        <br>
                        <button type="button" onclick="deleteInvoice(<?php echo $row['id']; ?>)" class="btn btn-danger"><i class="icon-trash"></i>&nbsp;&nbsp;Delete Invoice</button>
                    </div>
                    </div>
                </div>
            </div>

                    <div class="card planned_task">
                  <form action="" method="post">
                        <div class="body">
                                 <div class="row clearfix">
                                        <div class="col-lg-3 col-md-12 my-2">
                                            <label>Party</label>
                                            <input type="text" value="<?php echo $row['party_name']; ?>" class="form-control" >
                                             </div>
                                            <div class="col-lg-3 col-md-12 my-2">
                                                <label>Party Mobile Number</label>
                                                <input type="text" name="party_mobno" value="<?php echo $row['party_mobno']; ?>" placeholder="Type here" id="party_mobno"class="form-control" >
                                            </div>
                                                
                                                <!-- Update the "Sale Invoice Number" input field -->
                                                <div class="col-lg-3 col-md-12 my-2">
                                                    <label>Purchase Invoice Number</label>
                                                    <input type="number" name="purchaseprice" id="purchase_invoice_number" value="<?php echo $row['purchase_invoice_number']; ?>" class="form-control" required>
                                                </div>

                                            <div class="col-lg-3 col-md-12  my-2">
                                                <label>Purchase Invoice Date</label>
                                                <input type="date" name="purchase_invoice_date" id="purchase_invoice_date" value="<?php echo $row['purchase_invoice_date']; ?>" class="form-control" required>
                                            </div>
                                    </div>

                            </div>
                        </div>

                <div class="card planned_task">
                    <div class="body">
                        <div class="body table-responsive">
                            <table class="table table-bordered  table-striped table-hover" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Purchase invoice number</th>
                                        <th>Item name</th>
                                        <th>HSN</th>
                                        <th>Batch No</th>
                                        <th>Expire Date</th>
                                        <th>Manuf. Date</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Purchase invoice number</th>
                                        <th>Item name</th>
                                        <th>HSN</th>
                                        <th>Batch No</th>
                                        <th>Expire Date</th>
                                        <th>Manuf. Date</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                    </tr>
                                </tfoot>
                                <tbody id="table-body">
                                <?php   
                                    $slno=1;
                                    $purchseInvoiceNum=$row['purchase_invoice_number']; 
                                    $query1 = "SELECT * FROM `tblpurchaseinvoice_details` WHERE `purchase_invoice_number`='$purchseInvoiceNum' AND userID='$session' ORDER BY id ASC";
                                    $result1 = mysqli_query($conn, $query1);

                                    if (mysqli_num_rows($result1) > 0) {
                                        ?>
                                            <?php while ($row1 = mysqli_fetch_array($result1)) { ?>
                                        
                                                <tr>
                                                    <td><?php echo $slno; ?></td>
                                                    <td><?php echo $row1['purchase_invoice_number']; ?></td>
                                                    <td><?php echo $row1['ItemName']; ?></td>
                                                    <td><?php echo $row1['HSN']; ?></td>
                                                    <td><?php echo $row1['BatchNo']; ?></td>
                                                    <td><?php echo $row1['ExpireDate']; ?></td>
                                                    <td><?php echo $row1['ManufactureDate']; ?></td>
                                                    <td><?php echo $row1['Size']; ?></td>
                                                    <td><?php echo $row1['Qty']; ?></td>
                                                    <td><?php echo $row1['Price']; ?></td>
                                                    <td><?php echo $row1['Discount']; ?></td>
                                                    <td><?php echo $row1['Tax']; ?></td>
                                                    <td><?php echo $row1['Amount']; ?></td>
                                                </tr> 
                                                <?php $slno++;
                                            } ?>
                                    <?php
                                    } else {
                                        ?>
                                            <tr>
                                                <td>No Records Found</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                
                <div class="card planned_task">
                  
                        <div class="body">
                                 <div class="row clearfix">

                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Sub-Total</label>
                                                <input type="text" value="<?php echo $row['sub_total']; ?>" name="subtotal" placeholder="---" id="subtotal" readonly class="form-control" >
                                            </div>
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Discount</label>
                                                <input type="number" value="<?php echo $row['discount']; ?>" name="total_discount" value="0" placeholder="Type Here" onkeyup="calculate_total_discount()" id="discount"  class="form-control" >
                                            </div>
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>After Discount Total</label>
                                                <input type="text" name="total" value="<?php echo $row['after_discount_total']; ?>" id="total" readonly class="form-control" >
                                            </div>
                                            
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <center>
                                                <label> Fully Paid</label><br>
                                                <label class="control-inline fancy-checkbox">
                                            <input id="received_pay" type="checkbox" <?php $checked=$row['full_paid'];   if($checked=='Yes'){ echo 'checked';} ?> name="paid_checkbox">
                                        <span></span>
                                            </label>
                                                </center>
                                            </div>
                                            
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Amount Received</label>
                                                <div class="input-group">
                                                    <?php 
                                                    if($row['amount_received']>0){?>
                                                <input type="text"  id="amount_received" name="amount_received" value="<?php echo $row['amount_received']; ?> via <?php echo $row['amount_received_type']; ?>" readonly  class="form-control" aria-label="Text input with select button" fdprocessedid="nnp09r">
                                                <?php } ?> 
                                                <div class="input-group-append">
                                                    </div>
                                                </div>

                                            </div>
                                            
                     
                                            <div class="col-lg-2 col-md-12 my-2">
                                                <label>Total Balance</label>
                                                <input type="text" name="balance_total" value="<?php echo $row['total_balance']; ?>" id="balance_total" readonly class="form-control" >
                                            </div>
                                            
                                    </div>
                            </div>
                        </div>
<div class="">
  <div class="my-2">&nbsp;</div>

  </div>
  <div class="my-2">&nbsp;</div>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>
        function deleteInvoice(id) {
    $.ajax({
        url: '../common/remove_item.php',
        type: 'POST',
        data: { purchase_invoice: id }, 
        success: function (response) {
            console.log("removed");
            window.location.href="purchase_invoice";
        }
    });
  }
  </script>


<!-- Javascript -->
<script src="../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>


<script src="../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 

<script src="../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>

