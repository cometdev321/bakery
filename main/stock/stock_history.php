<?php 
include('../common/header2.php');
include('../common/sidebar.php');
date_default_timezone_set('Asia/Kolkata');
?>


<div id="main-content">
    <div class="container-fluid">

    
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i></a> Stock History
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Stock History</li>
                    </ul>
                </div>            
            </div>
        </div>

        <div class="row clearfix">


        <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="body row">
                            <div class="col-lg-3 col-md-12">
                            <div class="form-group">
                                <label>Select Time</label>
                                <input type="date" class="form-control" id="endDate" value="date-range" onchange="get_list(this.value)">
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Stock History</h2>                            
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="exportTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="stock-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>


<script>
$(document).ready(function() {
    // Get today's date in YYYY-MM-DD format
    let today = new Date().toISOString().split('T')[0];

    // Set the date input field to today's date
    $("#endDate").val(today);

    // Call get_list with today's date
    get_list(today);
});

function get_list(selectedDate) {
    $.ajax({
        url: "../get_ajax/stockMng/get_stock_history.php",
        type: 'POST',
        dataType: "json",
        data: { date: selectedDate }, // Pass the selected date
        success: function(response) {
            $("#stock-list").empty();
            console.log(response);
            if (response.length > 0) {
                response.forEach(function(item, index) {
                    $("#stock-list").append(
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${item.productname}</td>
                            <td>${item.available_stock}</td>
                        </tr>`
                    );
                });
                loadTabledata();
            } else {
                $("#stock-list").html("<tr><td colspan='3' class='text-center'>No data available</td></tr>");
            }
        },
        error: function() {
            console.log("Error occurred while fetching stock history.");
        }
    });
}

// Trigger function on date change
$("#endDate").on("change", function() {
    let selectedDate = $(this).val();
    get_list(selectedDate);
});
</script>


<!-- JavaScript -->
<script src="../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../assets/bundles/vendorscripts.bundle.js"></script>
</body>
</html>
