<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Employee</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Employee Details</h2>
                    </div>
                    <div class="body">
                        <form id="employeeForm">
                            <input type="hidden" name="id" id="employeeId">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="employeeName" placeholder="Type Here" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" id="employeeMobile" placeholder="Type Here" class="form-control" name="mobile" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control show-tick ms select2" name="role" id="employeeRole" data-placeholder="Select" required>
                                    <option value='1'>Driver</option>
                                    <option value='2'>Partner</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check-circle"></i> <span>Update</span>
                                </button>
                                <button id="deleteButton" type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> <span>Delete</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const employeeId = new URLSearchParams(window.location.search).get('id');

    // Fetch employee details from the API
    $.ajax({
        url: `../../api/dw_employees/getsingleemployee.php?id=${employeeId}`,
        type: 'GET',
        contentType: 'application/json',
        success: function(response) {
            if (response && response.id) {
                $('#employeeId').val(response.id);
                $('#employeeName').val(response.name);
                $('#employeeMobile').val(response.mobile);
                $('#employeeRole').val(response.role).trigger('change');
            } else {
                Toastify({
                    text: response.message || "Employee not found.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        },
        error: function() {
            Toastify({
                text: "Error fetching employee details.",
                duration: 3000,
                backgroundColor: "red",
            }).showToast();
        }
    });

    $('#employeeForm').on('submit', function(event) {
        event.preventDefault();

        const employeeData = {
            id: $('#employeeId').val(),
            name: $('#employeeName').val(),
            mobile: $('#employeeMobile').val(),
            role: $('#employeeRole').val()
        };

        $.ajax({
            url: '../../api/dw_employees/updateemployee.php', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(employeeData),
            success: function(response) {
                const message = response.message;
                if (message === "Employee updated successfully.") {
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: "green",
                    }).showToast();
                    window.location.href = 'create'; // Redirect to employee list after successful update
                } else {
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: "red",
                    }).showToast();
                }
            },
            error: function() {
                Toastify({
                    text: "Something went wrong.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        });
    });

    $('#deleteButton').on('click', function() {
        const employeeId = $('#employeeId').val();

        if (confirm("Are you sure you want to delete this employee?")) {
            $.ajax({
                url: '../../api/dw_employees/updateemployee.php', 
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: employeeId, status: 0 }), // Set status to 0
                success: function(response) {
                    const message = response.message;
                    if (message === "Employee status updated successfully.") {
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: "green",
                        }).showToast();
                        window.location.href = 'create'; // Redirect after deletion
                    } else {
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: "red",
                        }).showToast();
                    }
                },
                error: function() {
                    Toastify({
                        text: "Something went wrong.",
                        duration: 3000,
                        backgroundColor: "red",
                    }).showToast();
                }
            });
        }
    });
});
</script>

<!-- Include your scripts as before -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script> 
<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> 
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script> 
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> 
    
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>
</html>
