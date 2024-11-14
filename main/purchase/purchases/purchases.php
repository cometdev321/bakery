<?php 
    include('../../common/header3.php');
    include('../../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');
if(isset($_SESSION['user'])){
    echo "<script>window.location.href='$base/purchase/enabledpurchase/purchase_invoice'</script>";
}
?>

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
                <div class="col-lg-7 col-md-4 col-sm-12">
                    <div class="text-right">
                        <span class="text-primary  cursor-pointer" style="cursor: pointer;" onclick="window.location.href='settings'"><i class="fa fa-gear"></i> <span>&nbsp;Settings</span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body row">
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label>Year</label>
                        <select class="form-control" name="year" id="year" onchange="populateMonths()">
                            <!-- Year options will be populated by JavaScript -->
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label>Month</label>
                        <select class="form-control" name="month" id="month">
                            <!-- Month options will be populated based on selected year -->
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label></label>
                        <button type="button" class="btn btn-primary mt-2 btn-sm d-flex align-items-center" id="loadbtn">load</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <?php

        // Query to fetch year and full month name from tblheadpurchases where status = 1
        $query = "SELECT id,year,month, DATE_FORMAT(STR_TO_DATE(CONCAT(year, '-', month, '-01'), '%Y-%m-%d'), '%M') AS month_name 
          FROM tblheadpurchases 
          WHERE status = 1 
          ORDER BY year DESC, month DESC";
        $result = $conn->query($query);

?>

<div class="col-lg-12">
    <div class="card">
        <div class="header">
            <h2>Purchase List</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="exportTable">
                    <thead>
                        <tr>
                            <th>SLNO</th>
                            <th>Year/Month</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SLNO</th>
                            <th>Year/Month</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody id="Purchase-list">
                        <?php
                        if ($result->num_rows > 0) {
                            $slno = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $slno++ . "</td>";
                                echo "<td>" . $row['year'] .'/'. $row['month_name'] . "</td>";
                                echo "<td><button class='btn btn-success btn-sm' onclick='redirectto(" . $row['year'] .','. $row['month'] .','.$row['id']. ")'>Load Excel</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
?>

</div>
<script>
function redirectto(year,month,id){
    window.location.href=`export_excel?year=${year}&&month=${month}&&id=${id}`;
}
// Function to populate the Year dropdown with the current year and the previous 5 years
function populateYears() {
    let currentYear = new Date().getFullYear();
    let yearSelect = document.getElementById('year');
    
    // Add options for the last 5 years and the current year
    for (let i = 0; i < 6; i++) {
        let year = currentYear - i;
        let option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    // Set the current year as the default selected year
    yearSelect.value = currentYear;
}

// Function to populate the Month dropdown based on the selected year
function populateMonths() {
    let year = document.getElementById('year').value;
    let monthSelect = document.getElementById('month');
    
    // Clear the previous months
    monthSelect.innerHTML = '';
    
    // Add all 12 months
    for (let i = 1; i <= 12; i++) {
        let option = document.createElement('option');
        option.value = i;
        option.textContent = getMonthName(i);
        monthSelect.appendChild(option);
    }
    
    // Set the current month as the default selected month
    let currentMonth = new Date().getMonth() + 1; 
    monthSelect.value = currentMonth;
}

// Helper function to get the month name
function getMonthName(month) {
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return months[month - 1];
}

// Call populateYears and populateMonths when the page loads
window.onload = function() {
    populateYears();  // Populate the year dropdown
    populateMonths(); // Populate months and set the current month as default
};


$('#loadbtn').on('click', function() {
    const year = $('#year').val();
    const month = $('#month').val();

    $.ajax({
        type: 'POST',
        url: '../../get_ajax/headpurchases/save_purchase_data.php',
        data: { year: year, month: month },
        success: function(response) {
            if (response.trim() === 'success') {
                Toastify({
                    text: "New Report Created",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #84fab0, #8fd3f4)",
                    style: { margin: "70px 15px 10px 15px" }
                }).showToast();
            } else if (response.trim() === 'error') {
                Toastify({
                    text: "Something went wrong",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)",
                    style: { margin: "70px 15px 10px 15px" }
                }).showToast();
            } else if (response.trim() === 'exists') {
                window.location.href=`monthly_purchases?year=${year}&&month=${month}`
            }
        },
        error: function() {
            Toastify({
                text: "Error saving data",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #fe8c00, #f83600)",
                style: { margin: "70px 15px 10px 15px" }
            }).showToast();
        }
    });
});

</script>
<script>
    document.title="NAYAN"
</script>
<!-- Javascript -->
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
</body>

</html>

