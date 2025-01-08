<?php
include('../../common/cnn.php');

$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;

if(isset($_SESSION['user'])){
    echo "<script>window.location.href='$base/purchase/enabledpurchase/purchase_invoice'</script>";
}



$query = "SELECT tp.id as purchase_id,tblp.name as partyname,td.*
FROM tblheadpurchases tp
LEFT JOIN tblhead_purchase_details td ON tp.id = td.purchaseID
LEFT join tblparty tblp on tblp.id=td.trader
WHERE tp.year = '$year' AND tp.month = '$month'
and tp.status='1' and td.status='1' and td.include='yes'";
$result = mysqli_query($conn, $query);
$r = mysqli_fetch_array($result);

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Table</title>
    <!-- Include Bootstrap for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include SheetJS for Excel export -->
     <style>
 #exportTable td {
    width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container mt-5">
    <h3 id="">Excel Preview</h3>
        <div class="col-lg-12">
            <div class="card">
        <div class="header">
            <h3 id="exportTitle">NAYAN FOOD PRODUCTS</h3>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Trader</th>
                            <th>Date</th>
                            <th>Bill No</th>
                            <th>Exempted</th>
                            <th>18%</th>
                            <th>IGST</th>
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
                                            echo "<td id='slno-{$slno}'>{$slno}</td>";
                                            echo "<td id='party-{$slno}'>{$row['partyname']}</td>";
                                            echo "<td id='date-{$slno}'>" . date('d-m-Y', strtotime($row['purchase_date'])) . "</td>";
                                            echo "<td id='billno-{$slno}'>{$row['billno']}</td>";
                                            echo "<td id='exempted-{$slno}'>{$row['exempted']}</td>";
                                            echo "<td id='eighteen_amount-{$slno}'>{$row['eighteen_amount']}</td>";
                                            echo "<td id='eighteen_igst-{$slno}'>{$row['eighteen_igst']}</td>";
                                            echo "<td id='eighteen_cgst-{$slno}'>{$row['eighteen_cgst']}</td>";
                                            echo "<td id='eighteen_sgst-{$slno}'>{$row['eighteen_sgst']}</td>";
                                            echo "<td id='twelve_amount-{$slno}'>{$row['twelve_amount']}</td>";
                                            echo "<td id='twelve_cgst-{$slno}'>{$row['twelve_cgst']}</td>";
                                            echo "<td id='twelve_sgst-{$slno}'>{$row['twelve_sgst']}</td>";
                                            echo "<td id='five_amount-{$slno}'>{$row['five_amount']}</td>";
                                            echo "<td id='five_cgst-{$slno}'>{$row['five_cgst']}</td>";
                                            echo "<td id='five_sgst-{$slno}'>{$row['five_sgst']}</td>";
                                            echo "<td id='twenty_amount-{$slno}'>{$row['twenty_amount']}</td>";
                                            echo "<td id='twenty_cgst-{$slno}'>{$row['twenty_cgst']}</td>";
                                            echo "<td id='twenty_sgst-{$slno}'>{$row['twenty_sgst']}</td>";
                                            echo "<td id='ro-{$slno}'>{$row['ro']}</td>";
                                            echo "<td id='total-{$slno}'>{$row['total']}</td>";
                                            echo "<td id='gst-{$slno}'>{$row['gst']}</td>";
                                            echo "</tr>";
                                    $slno++;
                                }
                            } else {

                            }
                        } else {
                            echo "<tr><td colspan='21'>Please select a year and month.</td></tr>";
                        }
                        ?>
                    </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td id="total_exempted"></td>
                        <td id="total_eighteen_amount"></td>
                        <td id="total_eighteen_igst"></td>
                        <td id="total_eighteen_cgst"></td>
                        <td id="total_eighteen_sgst"></td>
                        <td id="total_twelve_amount"></td>
                        <td id="total_twelve_cgst"></td>
                        <td id="total_twelve_sgst"></td>
                        <td id="total_five_amount"></td>
                        <td id="total_five_cgst"></td>
                        <td id="total_five_sgst"></td>
                        <td id="total_twenty_amount"></td>
                        <td id="total_twenty_cgst"></td>
                        <td id="total_twenty_sgst"></td>
                        <td colspan="1"></td>
                        <td id="total_total"></td>
                        <td id="total_gst"></td>              
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><label>Purchases</label></td>
                        <td><label>Total Purchase Input</label></td>
                        <td><label>Total</label></td>
                        <td colspan="14"></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td id="purchases"></td>
                        <td id="totalpurchaseinput" ></td>
                        <td id="finaltotal"></td>
                        <td colspan="14"></td>
                    </tr>
                </tfoot>
                </table>
                <button type="button" class="btn btn-primary mt-2 btn-sm" onclick="exportTableToCSV()">
                    Export to CSV
                </button>
            </div>
        </div>
    </div>
</div>

<script src="calculation_excel.js"></script>
<script>
function exportTableToCSV() {
    const title = document.getElementById("exportTitle").textContent.trim();
    const table = document.getElementById("exportTable");
    const rows = table.querySelectorAll("tr");

    let csvContent = "";

    // Add the title as the first row with bold styling
    csvContent += `"${title}"\n\n`;

    // Loop through the rows of the table
    rows.forEach((row, index) => {
        const cells = row.querySelectorAll("th, td");
        let rowData = [];

        // Check if it's the first <tr> in <thead> to apply bold to the header row
        if (index === 0) { // First row is the header
            cells.forEach(cell => {
                rowData.push(`"${cell.textContent.trim()}"`);
            });
        } else if (index === rows.length - 3) { // Last 3 rows are <tfoot>, first <tr> has colspan=4
            cells.forEach(cell => {
                if (cell.hasAttribute("colspan")) {
                    const colspan = parseInt(cell.getAttribute("colspan"));
                    for (let i = 0; i < colspan; i++) {
                        rowData.push(`"${cell.textContent.trim()}"`);
                    }
                } else {
                    rowData.push(`"${cell.textContent.trim()}"`);
                }
            });
        } else if (index === rows.length - 2 || index === rows.length - 1) { // Second and third <tr> in <tfoot>
            // For these rows, set colspan="1"
            cells.forEach(cell => {
                rowData.push(`"${cell.textContent.trim()}"`);
            });
        } else {
            // For all other rows (not <tfoot>), proceed normally
            cells.forEach(cell => {
                if (cell.hasAttribute("colspan")) {
                    const colspan = parseInt(cell.getAttribute("colspan"));
                    for (let i = 0; i < colspan; i++) {
                        rowData.push(`"${cell.textContent.trim()}"`);
                    }
                } else {
                    rowData.push(`"${cell.textContent.trim()}"`);
                }
            });
        }

        csvContent += rowData.join(",") + "\n";
    });

    // Create a Blob and trigger download
    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "Nayan_Food_Products.csv";
    link.click();
}



    function callmajor() {
        horizontalTotal();
        verticalTotal();
        calculateTotal();
    }

    
    document.addEventListener('DOMContentLoaded', function() {
        callmajor();
    });

</script>

</body>
</html>
