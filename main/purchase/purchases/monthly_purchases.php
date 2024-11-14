<?php 
    include('../../common/header3.php');
    include('../../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');

$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;

if(isset($_SESSION['user'])){
    echo "<script>window.location.href='$base/purchase/enabledpurchase/purchase_invoice'</script>";
}

$getPId="SELECT tp.id as purchase_id
FROM tblheadpurchases tp
WHERE tp.year = '$year' AND tp.month = '$month'
and tp.status='1' ";
$resultP = mysqli_query($conn, $getPId);
$r1 = mysqli_fetch_array($resultP);


$query = "SELECT tp.id as purchase_id, td.*
FROM tblheadpurchases tp
JOIN tblhead_purchase_details td ON tp.id = td.purchaseID
WHERE tp.year = '$year' AND tp.month = '$month'
and tp.status='1' and td.status='1'";
$result = mysqli_query($conn, $query);
$r = mysqli_fetch_array($result);



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
<!-- Toastify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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
    <input type="text" hidden id="current_purchase_id" value="<?php echo $r1['purchase_id']; ?>" />

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
                                    if (mysqli_num_rows($result) > 0) {
                                        mysqli_data_seek($result, 0); 
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr id='row-{$slno}'>";
                                            echo '<td><input type="text" hidden name="pvalue[]"  id="purchaseID-' . $slno . '" value="' . $row['id']  . '"><input type="text" class="form-control" placeholder="Type here" id="slno-' . $slno . '" value="' . $slno . '" name="slno[]"></td>';
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
                                            echo '<td><input hidden type="text" class="form-control" placeholder="Type here" id="type-' . $slno . '" value="update" name="type[]"><input type="number" class="form-control" placeholder="Type here" id="gst-' . $slno . '" value="' . $row['gst'] . '" name="gst[]"></td>';
                                            echo "<td><button type='button' onclick='deleteRow({$slno})' class='btn btn-danger'><i class='icon-trash'></i></button></td>";
                                            echo "</tr>";
                                            $slno++;
                                        }
                                    } else {
                                    }
                                } else {
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
                                                 <button type="button" class="btn btn-success mx-2" id="saveRecords">
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


    function addrow() {
        // Increment row count for each new row
        rowCount++;

        // Constructing new row content
        const newRowContent = `
            <td>
                <input type="text" class="form-control" placeholder="Type here" id="slno-${rowCount}" value="${rowCount}" readonly name="slno[]">
                <input type="text" value="insert" id="type-${rowCount}" hidden name="type[]">
            </td>
            <td>
                <div class="checkbox-container">
                    <input type="checkbox" checked id="include-${rowCount}" name="include[]">
                </div>
            </td>
            <td><input type="date" class="form-control" id="date-${rowCount}" name="date[]"></td>
            <td><input type="text" class="form-control" id="billno-${rowCount}" name="billno[]"></td>
            <td><input type="number" class="form-control" onkeyup="callmajor()" id="exempted-${rowCount}" name="exempted[]"></td>
            <td><input type="number" class="form-control" onkeyup="calculateighteen(${rowCount})" id="eighteen_amount-${rowCount}" name="eighteen_amount[]"></td>
            <td><input type="number" class="form-control" id="eighteen_cgst-${rowCount}" name="eighteen_cgst[]"></td>
            <td><input type="number" class="form-control" id="eighteen_sgst-${rowCount}" name="eighteen_sgst[]"></td>
            <td><input type="number" class="form-control" onkeyup="calculatetwelve(${rowCount})" id="twelve_amount-${rowCount}" name="twelve_amount[]"></td>
            <td><input type="number" class="form-control" id="twelve_cgst-${rowCount}" name="twelve_cgst[]"></td>
            <td><input type="number" class="form-control" id="twelve_sgst-${rowCount}" name="twelve_sgst[]"></td>
            <td><input type="number" class="form-control" onkeyup="calculatefive(${rowCount})" id="five_amount-${rowCount}" name="five_amount[]"></td>
            <td><input type="number" class="form-control" id="five_cgst-${rowCount}" name="five_cgst[]"></td>
            <td><input type="number" class="form-control" id="five_sgst-${rowCount}" name="five_sgst[]"></td>
            <td><input type="number" class="form-control" onkeyup="calculatetwenty(${rowCount})" id="twenty_amount-${rowCount}" name="twenty_amount[]"></td>
            <td><input type="number" class="form-control" id="twenty_cgst-${rowCount}" name="twenty_cgst[]"></td>
            <td><input type="number" class="form-control" id="twenty_sgst-${rowCount}" name="twenty_sgst[]"></td>
            <td><input type="text" class="form-control" id="ro-${rowCount}" name="ro[]"></td>
            <td><input type="number" class="form-control" id="total-${rowCount}" name="total[]"></td>
            <td><input type="number" class="form-control" id="gst-${rowCount}" name="gst[]"></td>
            <td>
                <button type="button" onclick="deleteRow(${rowCount})" class="btn btn-danger">
                    <i class="icon-trash"></i>
                </button>
            </td>
        `;

        // Append the new row to the table body
        const tableBody = document.getElementById("Purchase-list");
        const newRow = document.createElement("tr");
        newRow.id = `row-${rowCount}`;
        newRow.innerHTML = newRowContent;
        tableBody.appendChild(newRow);
    }

    
   function deleteRow(row) {
    
    const purchaseId = `purchaseID-${row}`;
    const purchaseIdElement = document.getElementById(purchaseId);
    if (purchaseIdElement) {
        console.error("Element with ID purchaseID-" + row + " not found.");
        const purchaseIdValue = purchaseIdElement.value;

        $.ajax({
            url: '../../get_ajax/headpurchases/remove_item.php', 
            type: 'POST',
            data: {
                purchaseID: purchaseIdValue,
                status: 0
            },
            success: function(response) {
                
            },
            error: function() {
                alert("Error in AJAX request.");
            }
        });
    }
  
    const rowId = `row-${row}`;
    const rowElement = document.getElementById(rowId);

    if (rowElement) {
        rowElement.remove();
    }
    callmajor();
}

    

    function toggleCheckboxes() {
        const checkboxes = document.querySelectorAll('#Purchase-list input[type="checkbox"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
    }
    
 
    $(document).ready(()=>{
        addrow();
        console.log("called")
        callmajor();
    })

  document.getElementById('saveRecords').addEventListener('click', function () {
    let rows = [];
   
    let pID=document.getElementById('current_purchase_id').value;
    document.querySelectorAll('#Purchase-list tr').forEach((row) => {
        let rowData = {
            purchaseID: pID,
            date: row.querySelector('[id^="date-"]') ? row.querySelector('[id^="date-"]').value : '',
            billno: row.querySelector('[id^="billno-"]') ? row.querySelector('[id^="billno-"]').value : '',
            exempted: row.querySelector('[id^="exempted-"]') ? row.querySelector('[id^="exempted-"]').value : '',
            eighteen_amount: row.querySelector('[id^="eighteen_amount-"]') ? row.querySelector('[id^="eighteen_amount-"]').value : '',
            eighteen_cgst: row.querySelector('[id^="eighteen_cgst-"]') ? row.querySelector('[id^="eighteen_cgst-"]').value : '',
            eighteen_sgst: row.querySelector('[id^="eighteen_sgst-"]') ? row.querySelector('[id^="eighteen_sgst-"]').value : '',
            twelve_amount: row.querySelector('[id^="twelve_amount-"]') ? row.querySelector('[id^="twelve_amount-"]').value : '',
            twelve_cgst: row.querySelector('[id^="twelve_cgst-"]') ? row.querySelector('[id^="twelve_cgst-"]').value : '',
            twelve_sgst: row.querySelector('[id^="twelve_sgst-"]') ? row.querySelector('[id^="twelve_sgst-"]').value : '',
            five_amount: row.querySelector('[id^="five_amount-"]') ? row.querySelector('[id^="five_amount-"]').value : '',
            five_cgst: row.querySelector('[id^="five_cgst-"]') ? row.querySelector('[id^="five_cgst-"]').value : '',
            five_sgst: row.querySelector('[id^="five_sgst-"]') ? row.querySelector('[id^="five_sgst-"]').value : '',
            twenty_amount: row.querySelector('[id^="twenty_amount-"]') ? row.querySelector('[id^="twenty_amount-"]').value : '',
            twenty_cgst: row.querySelector('[id^="twenty_cgst-"]') ? row.querySelector('[id^="twenty_cgst-"]').value : '',
            twenty_sgst: row.querySelector('[id^="twenty_sgst-"]') ? row.querySelector('[id^="twenty_sgst-"]').value : '',
            ro: row.querySelector('[id^="ro-"]') ? row.querySelector('[id^="ro-"]').value : '',
            total: row.querySelector('[id^="total-"]') ? row.querySelector('[id^="total-"]').value : '',
            gst: row.querySelector('[id^="gst-"]') ? row.querySelector('[id^="gst-"]').value : '',
            type: row.querySelector('[id^="type-"]') ? row.querySelector('[id^="type-"]').value : '', // 'insert' or 'update'
        };

        // Check if date is not empty; if empty, skip the row
        if (rowData.date) {
            rows.push(rowData);
        }
    });

    // Log rows data to make sure it's populated

    // Send the data via AJAX
    $.ajax({
    url: "../../get_ajax/headpurchases/save_purchase.php",  // The PHP script to handle the data
    type: 'POST',
    data: { 
        records: rows  // Send all the row data as an array of objects
    },
    success: function (response) {
        // Show success notification using Toastify
        Toastify({
            text: "File updated!",  // Message to display
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",  // Gradient success color
            duration: 3000,                      // Display time in milliseconds
            close: true,                         // Show close button
        }).showToast();
        
        // Optionally reload the page
        setTimeout(() => {
            window.location.href = "";
        }, 500);
    },
    error: function (xhr, status, error) {
        // Show error notification using Toastify
        Toastify({
            text: "An error occurred while updating the file.",  // Message to display
            backgroundColor: "red",                               // Error color
            duration: 3000,                                       // Display time
            close: true,                                          // Show close button
        }).showToast();

        console.error("AJAX error:", error);  // Log detailed error message
    }
});

});


</script>

<!-- Javascript -->
<script src="calculation_file.js"></script>
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

