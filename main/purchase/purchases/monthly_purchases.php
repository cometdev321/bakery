<?php 
    include('../../common/header3.php');
    include('../../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');

$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;

if(isset($_SESSION['user'])){
    echo "<script>window.location.href='$base/purchase/enabledpurchase/purchase_invoice'</script>";
}
?>
<style>
    #exportTable input[type="text"] {
        width: 100px; 
        maxlength: 5;      
    }
    .checkbox-container input[type="checkbox"] {
        transform: scale(1.5); 
        width: 15px;           
        height: 15px;          
        cursor: pointer;       
    }

</style>

<div id="main-content">
        <div class="container-fluid">
           <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Purchase Invoices</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Purchase Invoices</li>
                    </ul>
                </div>            
             
            </div>
        </div>

        <div class="row clearfix">


<div class="col-lg-12">
    <div class="card">
    <div class="header">
    <h3>Nayan Food Products</h3>
    </div>
    <!-- <button type="button" class="btn btn-secondary mt-2 btn-sm" onclick="toggleCheckboxes()">Check/Uncheck All</button> -->

        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">

                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Inlude for export</th>
                            <th>Date</th>
                            <th>Bill No</th>
                            <th>Exempted</th>
                            <th>18%</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>12%</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>5%</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>28%</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>R/O</th>
                            <th>Total</th>
                            <th>GST</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="Purchase-list">
                        <?php
                        $slno = 1;
                    if ($year && $month) {
    // Database connection - replace $connection with your actual DB connection variable
                                    $query = "SELECT tp.id, td.*
                                            FROM tblheadpurchases tp
                                            JOIN tblhead_purchase_details td ON tp.id = td.purchaseID
                                            WHERE tp.year = '$year' AND tp.month = '$month'
                                            and tp.status='1' and td.status='1'";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr id='row-{$slno}'>";
                                            echo '<td><input type="text" class="form-control" placeholder="Type here" id="slno-' . $slno . '" value="' . $slno . '" name="slno[]"><input type="text" hidden  value="old" name="type[]"></td>';
                                            echo "<td><div class='checkbox-container'><input type='checkbox' name='include[]' " . ($row['purchase_date'] ? "checked" : "") . " id='include-{$slno}'></div></td>";
                                            echo '<td><input type="date" class="form-control" placeholder="Type here" id="date-' . $slno . '" value="' . $row['purchase_date'] . '" name="date[]"></td>';
                                            echo '<td><input type="text" class="form-control" placeholder="Type here" id="billno-' . $slno . '" value="' . $row['billno'] . '" name="billno[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="callmajor()" id="exempted-' . $slno . '" value="' . $row['exempted'] . '" name="exempted[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculateighteen(' .$slno . ')" id="eighteen_amount-' . $slno . '" value="' . $row['eighteen_amount'] . '" name="eighteen_amount[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="eighteen_cgst-' . $slno . '" value="' . $row['eighteen_cgst'] . '" name="eighteen_cgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="eighteen_sgst-' . $slno . '" value="' . $row['eighteen_sgst'] . '" name="eighteen_sgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculatetwelve(' .$slno. ')" id="twelve_amount-' . $slno . '" value="' . $row['twelve_amount'] . '" name="twelve_amount[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="twelve_cgst-' . $slno . '" value="' . $row['twelve_cgst'] . '" name="twelve_cgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="twelve_sgst-' . $slno . '" value="' . $row['twelve_sgst'] . '" name="twelve_sgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here"  onkeyup="calculatefive(' .$slno. ')" id="five_amount-' . $slno . '" value="' . $row['five_amount'] . '" name="five_amount[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="five_cgst-' . $slno . '" value="' . $row['five_cgst'] . '" name="five_cgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="five_sgst-' . $slno . '" value="' . $row['five_sgst'] . '" name="five_sgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculatetwenty(' .$slno. ')" id="twenty_amount-' . $slno . '" value="' . $row['twenty_amount'] . '" name="twenty_amount[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="twenty_cgst-' . $slno . '" value="' . $row['twenty_cgst'] . '" name="twenty_cgst[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="twenty_sgst-' . $slno . '" value="' . $row['twenty_sgst'] . '" name="twenty_sgst[]"></td>';
                                            echo '<td><input type="text" class="form-control" placeholder="Type here" id="ro-' . $slno . '" value="' . $row['ro'] . '" name="ro[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="total-' . $slno . '" value="' . $row['total'] . '" name="total[]"></td>';
                                            echo '<td><input type="number" class="form-control" placeholder="Type here" id="gst-' . $slno . '" value="' . $row['gst'] . '" name="gst[]"></td>';
                                            echo "<td><button type='button' onclick='deleteRow({$slno})' class='btn btn-danger'><i class='icon-trash'></i></button></td>";
                                            echo "</tr>";
                                            $slno++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='21'>No records found for the specified year and month.</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='21'>Year and month parameters are required.</td></tr>";
                                }

                                
                                ?>
                                <input id="existingslno" value="<?php echo $slno ;?>" hidden>
                    </tbody>
                    <tfoot>
                        <tr>
                        <td colspan="4"></td>

                        <td>
                            <label for="total_exempted">Exempted</label>
                            <input type="text" class="form-control" id="total_exempted" value="0" name="exempted[]">
                        </td>

                        <td>
                            <label for="total_eighteen_amount">18% Amount</label>
                            <input type="text" class="form-control" id="total_eighteen_amount" value="0" name="eighteen_amount[]">
                        </td>

                        <td>
                            <label for="total_eighteen_cgst">18% CGST</label>
                            <input type="text" class="form-control" id="total_eighteen_cgst" value="" name="eighteen_cgst[]">
                        </td>

                        <td>
                            <label for="total_eighteen_sgst">18% SGST</label>
                            <input type="text" class="form-control" id="total_eighteen_sgst" value="" name="eighteen_sgst[]">
                        </td>

                        <td>
                            <label for="total_twelve_amount">12% Amount</label>
                            <input type="text" class="form-control" id="total_twelve_amount" value="" name="twelve_amount[]">
                        </td>

                        <td>
                            <label for="total_twelve_cgst">12% CGST</label>
                            <input type="text" class="form-control" id="total_twelve_cgst" value="" name="twelve_cgst[]">
                        </td>

                        <td>
                            <label for="total_twelve_sgst">12% SGST</label>
                            <input type="text" class="form-control" id="total_twelve_sgst" value="" name="twelve_sgst[]">
                        </td>

                        <td>
                            <label for="total_five_amount">5% Amount</label>
                            <input type="text" class="form-control" id="total_five_amount" value="" name="five_amount[]">
                        </td>

                        <td>
                            <label for="total_five_cgst">5% CGST</label>
                            <input type="text" class="form-control" id="total_five_cgst" value="" name="five_cgst[]">
                        </td>

                        <td>
                            <label for="total_five_sgst">5% SGST</label>
                            <input type="text" class="form-control" id="total_five_sgst" value="" name="five_sgst[]">
                        </td>

                        <td>
                            <label for="total_twenty_amount">20% Amount</label>
                            <input type="text" class="form-control" id="total_twenty_amount" value="" name="twenty_amount[]">
                        </td>

                        <td>
                            <label for="total_twenty_cgst">20% CGST</label>
                            <input type="text" class="form-control" id="total_twenty_cgst" value="" name="twenty_cgst[]">
                        </td>

                        <td>
                            <label for="total_twenty_sgst">20% SGST</label>
                            <input type="text" class="form-control" id="total_twenty_sgst" value="" name="twenty_sgst[]">
                        </td>

                        <td>
                        
                        </td>

                        <td>
                            <label for="total_total">Total</label>
                            <input type="text" class="form-control" id="total_total" value="" name="total[]">
                        </td>

                        <td>
                            <label for="total_gst">GST</label>
                            <input type="text" class="form-control" id="total_gst" value="" name="gst[]">
                        </td>
                        <td>
                            
                        </td>
                    </tr>

                    </tfoot>

                    </table>
                    <button type="button" class="btn btn-primary mt-2 btn-sm" onclick="addrow()"><i class="fa fa-plus"></i> <span>Add Row</span></button>
            </div>
        </div>

         <div class="card planned_task">
                  
                        <div class="body">
                                 <div class="row clearfix">

                                            <div class="col-lg-3 col-md-12 my-2">
                                                <label>Purchases</label>
                                                <input type="text" name="purchases"  id="purchases"  value="0" readonly class="form-control" >
                                            </div>
                                            <div class="col-lg-3 col-md-12 my-2">
                                                <label>Total Purchase Input</label>
                                                <input type="number" name="totalpurchaseinput" value="0" readonly placeholder="Type Here"  id="totalpurchaseinput"  class="form-control" >
                                            </div>
                                            <div class="col-lg-3 col-md-12 my-2">
                                                <label>Total</label>
                                                <input type="text" name="finaltotal"  id="finaltotal"  value="0"  readonly class="form-control" >
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-12 my-4">
                                                 <button type="button" class="btn btn-success mx-2" onclick="create_purchase_invoice()">
                                                    <i class="fa fa-check-circle"></i> <span>Save </span>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="location.reload()">
                                                    <i class="icon-refresh"></i> <span></span>
                                                </button>
                                            </div>
                                            

                                            
                                    </div>
                                  
                            </div>
                        </div>

    </div>
</div>


</div>
<script>
    var existingslno=document.getElementById('existingslno').value;
    let rowCount = existingslno-1; 

    function addrow(){
        // Increment row count for each new row
        rowCount++;

        // Create the new row content with dynamic IDs and names
        const newRowContent =
            '<td><input type="text" class="form-control" placeholder="Type here" id="slno-' + rowCount + '" value="' + rowCount + '" readonly name="purchaseID[]"><input type="text"  value="new" hidden name="type[]"></td>' +
            '<td ><div class="checkbox-container"><input type="checkbox" checked  id="include-' + rowCount + '" name="include[]"></div></td>' +
            '<td><input type="date" class="form-control" placeholder="Type here" id="date-' + rowCount + '" value="" name="date[]"></td>' +
            '<td><input type="text" class="form-control" placeholder="Type here" id="billno-' + rowCount + '" value="" name="billno[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here"  onkeyup="callmajor()" id="exempted-' + rowCount + '" value="" name="exempted[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculateighteen(' + rowCount + ')" id="eighteen_amount-' + rowCount + '" value="" name="eighteen_amount[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="eighteen_cgst-' + rowCount + '" value="" name="eighteen_cgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="eighteen_sgst-' + rowCount + '" value="" name="eighteen_sgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculatetwelve(' + rowCount + ')" id="twelve_amount-' + rowCount + '" value="" name="twelve_amount[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="twelve_cgst-' + rowCount + '" value="" name="twelve_cgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="twelve_sgst-' + rowCount + '" value="" name="twelve_sgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" onkeyup="calculatefive(' + rowCount + ')"  id="five_amount-' + rowCount + '" value="" name="five_amount[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="five_cgst-' + rowCount + '" value="" name="five_cgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="five_sgst-' + rowCount + '" value="" name="five_sgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here"  onkeyup="calculatetwenty(' + rowCount + ')" id="twenty_amount-' + rowCount + '" value="" name="twenty_amount[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="twenty_cgst-' + rowCount + '" value="" name="twenty_cgst[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="twenty_sgst-' + rowCount + '" value="" name="twenty_sgst[]"></td>' +
            '<td><input type="text" class="form-control" placeholder="Type here" id="ro-' + rowCount + '" value="" name="ro[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="total-' + rowCount + '" value="" name="total[]"></td>' +
            '<td><input type="number" class="form-control" placeholder="Type here" id="gst-' + rowCount + '" value="" name="gst[]"></td>' +
            '<td><button type="button" onclick="deleteRow(' + rowCount + ')" class="btn btn-danger"><i class="icon-trash"></i></button></td>';
        // Append the new row to the table body
        const tableBody = document.getElementById('Purchase-list');
        const newRow = document.createElement('tr');
        newRow.id='row-' + rowCount;
        newRow.innerHTML = newRowContent;
        tableBody.appendChild(newRow);

        
    };

    function calculatefive(i){
        var amount=parseFloat(document.getElementById('five_amount-' + i).value);
        const percentage=0.05;
        let result = Math.round(((amount * percentage) / 2 )* 100) /100; 
        document.getElementById('five_cgst-' + i).value=result;
        document.getElementById('five_sgst-' + i).value=result;
        callmajor();
    }

    function calculatetwelve(i){
        var amount=parseFloat(document.getElementById('twelve_amount-' + i).value);
        const percentage=0.12;
        let result = Math.round(((amount * percentage) / 2 )* 100) / 100; 
        document.getElementById('twelve_cgst-' + i).value=result;
        document.getElementById('twelve_sgst-' + i).value=result;
        callmajor();
    }

    function calculateighteen(i){
        var amount=parseFloat(document.getElementById('eighteen_amount-' + i).value);
        const percentage=0.18;
        let result = Math.round((amount * percentage) / 2 * 100) / 100;
        document.getElementById('eighteen_sgst-' + i).value=result;
        callmajor();
    }

    function calculatetwenty(i){
        var amount = parseFloat(document.getElementById('twenty_amount-' + i).value);
        const percentage = 0.28; 
        let result = Math.round(((amount * percentage) / 2) * 100) / 100; 
        document.getElementById('twenty_cgst-' + i).value = result;
        document.getElementById('twenty_sgst-' + i).value = result;
        callmajor();
    }

    
    
    function deleteRow(row) {
        const rowId = `row-${row}`;
        const rowElement = document.getElementById(rowId);
        rowElement.remove();
        callmajor();
    }

    function toggleCheckboxes() {
        const checkboxes = document.querySelectorAll('#Purchase-list input[type="checkbox"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
    }
    
    function horizontalTotal(){
        const table = document.getElementById("Purchase-list");
        const tableRowcount = table.rows.length;
        var total=0;
        var gst=0;
        for(var i=1;i<=tableRowcount;i++){

            total += parseFloat(document.getElementById('exempted-' + i)?.value) || 0;

            total += parseFloat(document.getElementById('eighteen_amount-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('eighteen_cgst-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('eighteen_sgst-' + i)?.value) || 0;

            total += parseFloat(document.getElementById('twelve_amount-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('twelve_cgst-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('twelve_sgst-' + i)?.value) || 0;

            total += parseFloat(document.getElementById('five_amount-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('five_cgst-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('five_sgst-' + i)?.value) || 0;

            total += parseFloat(document.getElementById('twenty_amount-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('twenty_cgst-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('twenty_sgst-' + i)?.value) || 0;

            document.getElementById('total-' + i).value=(total+gst);
            document.getElementById('gst-' + i).value=gst/2;
            total=0;
            gst=0;
        }

    }
    
    function verticalTotal(){
        const table = document.getElementById("Purchase-list");
        const tableRowcount = table.rows.length;
        var exemptedTotal=0;

        var eighteenTotal=0;
        var eighteenCgst=0;
        var eighteenSgst=0;

        var twelveTotal=0;
        var twelveCgst=0;
        var twelveSgst=0;

        var fiveTotal=0;
        var fiveCgst=0;
        var fiveSgst=0;

        var twentyTotal=0;
        var twentyCgst=0;
        var twentySgst=0;

        var total=0;
        var gst=0;

        for(var i=1;i<=tableRowcount;i++){

            exemptedTotal += parseFloat(document.getElementById('exempted-' + i)?.value) || 0;

            eighteenTotal += parseFloat(document.getElementById('eighteen_amount-' + i)?.value) || 0;
            eighteenCgst += parseFloat(document.getElementById('eighteen_cgst-' + i)?.value) || 0;
            eighteenSgst += parseFloat(document.getElementById('eighteen_sgst-' + i)?.value) || 0;

            twelveTotal += parseFloat(document.getElementById('twelve_amount-' + i)?.value) || 0;
            twelveCgst += parseFloat(document.getElementById('twelve_cgst-' + i)?.value) || 0;
            twelveSgst += parseFloat(document.getElementById('twelve_sgst-' + i)?.value) || 0;
            
            fiveTotal += parseFloat(document.getElementById('five_amount-' + i)?.value) || 0;
            fiveCgst += parseFloat(document.getElementById('five_cgst-' + i)?.value) || 0;
            fiveSgst += parseFloat(document.getElementById('five_sgst-' + i)?.value) || 0;
            
            twentyTotal += parseFloat(document.getElementById('twenty_amount-' + i)?.value) || 0;
            twentyCgst += parseFloat(document.getElementById('twenty_cgst-' + i)?.value) || 0;
            twentySgst += parseFloat(document.getElementById('twenty_sgst-' + i)?.value) || 0;
            
            total += parseFloat(document.getElementById('total-' + i)?.value) || 0;
            gst += parseFloat(document.getElementById('gst-' + i)?.value) || 0;
        }

        total_exempted.value=exemptedTotal;

        total_eighteen_amount.value=eighteenTotal;
        total_eighteen_cgst.value=eighteenCgst;
        total_eighteen_sgst.value=eighteenSgst;

        total_twelve_amount.value=twelveTotal;
        total_twelve_cgst.value=twelveCgst;
        total_twelve_sgst.value=twelveSgst;
        
        total_five_amount.value=fiveTotal;
        total_five_cgst.value=fiveCgst;
        total_five_sgst.value=fiveSgst;
        
        total_twenty_amount.value=twentyTotal;
        total_twenty_cgst.value=twentyCgst;
        total_twenty_sgst.value=twentySgst;

        total_total.value=total;
        total_gst.value=gst;
    }

    function calculateTotal(){
        var totalPurchase = 0;
        var totalPurchaseInput = 0;
        var finalTotal = 0;

        totalPurchase += parseFloat(total_exempted.value) || 0;
        totalPurchase += parseFloat(total_eighteen_amount.value) || 0;
        totalPurchaseInput += parseFloat(total_eighteen_cgst.value) || 0;
        totalPurchaseInput += parseFloat(total_eighteen_sgst.value) || 0;

        totalPurchase += parseFloat(total_twelve_amount.value) || 0;
        totalPurchaseInput += parseFloat(total_twelve_cgst.value) || 0;
        totalPurchaseInput += parseFloat(total_twelve_sgst.value) || 0;

        totalPurchase += parseFloat(total_five_amount.value) || 0;
        totalPurchaseInput += parseFloat(total_five_cgst.value) || 0;
        totalPurchaseInput += parseFloat(total_five_sgst.value) || 0;

        totalPurchase += parseFloat(total_twenty_amount.value) || 0;
        totalPurchaseInput += parseFloat(total_twenty_cgst.value) || 0;
        totalPurchaseInput += parseFloat(total_twenty_sgst.value) || 0;

        purchases.value = totalPurchase;
        totalpurchaseinput.value = totalPurchaseInput;
        finaltotal.value = (totalPurchase + totalPurchaseInput);
    
    }

    function callmajor(){
        horizontalTotal();
        verticalTotal();
        calculateTotal();
    }
    $(document).ready(()=>{
        addrow();
        callmajor();
    })
</script>

<!-- Javascript -->
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>



<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

</html>

