<?php
include('../../common/header3.php');
include('../../common/deliwheelsSidebar.php');
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Settle Payment</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Settle Payment</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Settle Payment</h2>
                    </div>
                    <div class="body">
                        <form id="settlePaymentForm">
                            <div class="form-group">
                                <label>Select Line Man</label>
                                <select class="form-control" name="line_man" id="lineManDropdown" required>
                                    <option value="">Select Line Man</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Trip</label>
                                <select class="form-control" name="trip_id" id="tripDropdown" required>
                                    <option value="">Select Trip</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Enter Amount</label>
                                <input type="number" class="form-control" name="amount" id="settlementAmount" readonly="true" required min="0">
                            </div>
                            <div class="form-group">
                                <button type="button" id="settlePaymentBtn" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Settle Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Payment History</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="paymentHistoryTable">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Line Man</th>
                                        <th>Trip ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
    // Fetch line men
    $.ajax({
        url: '../../api/dw_employees/getallemployees.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const lineManDropdown = $('#lineManDropdown');
            lineManDropdown.empty();
            lineManDropdown.append('<option value="">Select Line Man</option>');
            data.forEach(function(lineMan) {
                lineManDropdown.append(`<option value="${lineMan.id}">${lineMan.name} (${lineMan.mobile})</option>`);
            });
        },
        error: function() {
            Toastify({ text: "Failed to load line men.", duration: 3000, backgroundColor: "red" }).showToast();
        }
    });

    // Fetch trips for selected line man
    $('#lineManDropdown').change(function() {
        const lineManId = $(this).val();
        if (!lineManId) {
            $('#tripDropdown').empty().append('<option value="">Select Trip</option>');
            return;
        }

        $.ajax({
            url: `../../api/dw_delivery/get_trips.php?line_man_id=${lineManId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const tripDropdown = $('#tripDropdown');
                    tripDropdown.empty();
                    tripDropdown.append('<option value="">Select Trip</option>');
                    response.data.forEach(function(trip) {
                        tripDropdown.append(`<option value="${trip.delivery_id}">Trip ID: ${trip.delivery_id} - ${trip.total_amount}</option>`);
                    });
                    
                } else {
                    Toastify({ text: "No trips found.", duration: 3000, backgroundColor: "yellow" }).showToast();
                }
            },
            error: function() {
                Toastify({ text: "Failed to load trips.", duration: 3000, backgroundColor: "red" }).showToast();
            }
        });
    });

    $('#tripDropdown').change(function() {
        const selectedTripId = $(this).val();
        const settlementAmount = $('#settlementAmount');

        // Clear the settlement amount if no trip is selected
        if (!selectedTripId) {
            settlementAmount.val('');
            return;
        }

        $.ajax({
            url: `../../api/dw_delivery/get_trips.php?delivery_id=${selectedTripId}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.data) {
                    const totalAmount = response.data[0].total_amount;
                    console.log(totalAmount);
                    settlementAmount.val(totalAmount);
                } else {
                    settlementAmount.val('');
                    Toastify({
                        text: "Failed to fetch trip details.",
                        duration: 3000,
                        backgroundColor: "yellow",
                    }).showToast();
                }
            },
            error: function () {
                settlementAmount.val('');
                Toastify({
                    text: "Failed to fetch trip details.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            },
        });
    });


    // Handle settle payment
    $('#settlePaymentBtn').click(function() {
    const tripId = $('#tripDropdown').val();
    const amount = $('#settlementAmount').val();

    // Check if fields are valid before proceeding
    if (!tripId || !amount || amount <= 0) {
        Toastify({ text: "Please fill all fields with valid data.", duration: 3000, backgroundColor: "red" }).showToast();
        return;
    }

    const data = { trip_id: tripId, amount: amount };

    // Log the data before sending it
    console.log("Sending Data:", JSON.stringify(data));  // Debugging step

    $.ajax({
        url: '../../api/dw_payment/settle_payment.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            console.log("Server Response:", response);  // Debugging step
            if (response.success) {
                Toastify({ text: "Payment settled successfully.", duration: 3000, backgroundColor: "green" }).showToast();
                $('#settlePaymentForm')[0].reset();
                fetchPaymentHistory();
            } else {
                Toastify({ text: response.message, duration: 3000, backgroundColor: "red" }).showToast();
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX Error:", status, error);  // Debugging step
            Toastify({ text: "Failed to settle payment.", duration: 3000, backgroundColor: "red" }).showToast();
        }
    });
});





    // Fetch payment history
    function fetchPaymentHistory() {
        $.ajax({
            url: '../../api/dw_payment/get_payment_history.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const paymentHistoryTable = $('#paymentHistoryTable tbody');
                paymentHistoryTable.empty();
                data.forEach(function(payment) {
                    const row = `
                        <tr>
                            <td>${payment.id}</td>
                            <td>${payment.lineManName} (${payment.lineManPhone})</td>
                            <td>${payment.delivery_id}</td>
                            <td>${payment.amount}</td>
                            <td>${payment.date}</td>
                        </tr>
                    `;
                    paymentHistoryTable.append(row);
                });
            },
            error: function() {
                Toastify({ text: "Failed to fetch payment history.", duration: 3000, backgroundColor: "red" }).showToast();
            }
        });
    }

    fetchPaymentHistory();
});
</script>
