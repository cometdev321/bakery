<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 

// Fetch vehicle ID from URL
$vehicle_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch vehicle details from the database
$vehicle_query = "SELECT dwv.id as id, dwv.name as name,
dwe.name as driver, dwe.id as driverid,
dwe1.name as helper, dwe1.id as helperid,
dwv.number_plate as number_plate
FROM dw_vehicles dwv 
JOIN dw_employees dwe ON dwe.id = dwv.driver_id 
JOIN dw_employees dwe1 ON dwe1.id = dwv.helper_id WHERE dwv.id = '$vehicle_id'";
$vehicle_result = mysqli_query($deliwheelsConn, $vehicle_query);
$vehicle = mysqli_fetch_assoc($vehicle_result);
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Vehicle</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Edit Vehicle</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Edit Vehicle Details</h2>
                    </div>
                    <div class="body">
                        <form id="vehicleEditForm">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" value="<?php echo $vehicle_id ?>" hidden name="vehicleId" id="vehicleId">
                                <input type="text" value="<?php echo htmlspecialchars($vehicle['name']); ?>" placeholder="Type Here" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Number Plate</label>
                                <input type="text" value="<?php echo htmlspecialchars($vehicle['number_plate']); ?>" placeholder="Type Here" class="form-control" name="numberplate" required>
                            </div>
                            <div class="form-group">
                                <label>Driver</label>
                                <select class="form-control show-tick ms select2" name="driver" data-placeholder="Select" required>
                                    <option value="<?php echo htmlspecialchars($vehicle['driverid']); ?>">Current Driver: <?php echo htmlspecialchars($vehicle['driver']); ?></option>
                                <?php
                                    $query = "SELECT id,name FROM dw_employees WHERE status = '1' and role='1' order by id desc";
                                    $result = mysqli_query($deliwheelsConn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Partner</label>
                                <select class="form-control show-tick ms select2" name="partner" data-placeholder="Select" required>
                                <option value="<?php echo htmlspecialchars($vehicle['helperid']); ?>">Current Partner: <?php echo htmlspecialchars($vehicle['helper']); ?></option>
                                <?php
                                    $query = "SELECT id,name FROM dw_employees WHERE status = '1' and role='2' order by id desc";
                                    $result = mysqli_query($deliwheelsConn, $query);
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Update</span></button>
                                <button type="button" id="deleteVehicleBtn" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> <span>Delete</span></button>
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
    $('#vehicleEditForm').on('submit', function(event) {
        event.preventDefault();

        const VehicleData = {
            id: $('input[name="vehicleId"]').val(),
            name: $('input[name="name"]').val(),
            number_plate: $('input[name="numberplate"]').val(),
            driver_id: $('select[name="driver"]').val(),
            helper_id: $('select[name="partner"]').val()
        };

        $.ajax({
            url: '../../api/dw_vehicles/update_vehicle.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(VehicleData),
            success: function(response) {
                const message = response.message;
                if (message === "Vehicle updated successfully.") {
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: "green",
                    }).showToast();
                    setTimeout(function() {
                        window.location.href = 'create';
                    }, 500); 
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

    $('#deleteVehicleBtn').on('click', function() {
        const vehicleId = document.getElementById('vehicleId').value; 
        const deleteData = {
            id: vehicleId,
            status: 0
        };
        $.ajax({
            url: '../../api/dw_vehicles/update_vehicle.php',
            type: 'PUT', 
            contentType: 'application/json',
            data: JSON.stringify(deleteData),
            success: function(response) {
                const message = response.message;
                if (message) {
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: "green",
                    }).showToast();
                    setTimeout(function() {
                        window.location.href = 'create';
                    }, 500); 
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
});
</script>

<!-- Javascript -->
<script src="../../../assets/bundles/libscripts.bundle.js"></script>    
<script src="../../../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../../../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../../../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>
<script src="../../../assets/vendor/sweetalert/sweetalert.min.js"></script> 
<script src="../../../assets/js/pages/ui/dialogs.js"></script>
<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script> 
<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> 
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script> 
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> 
<script src="../../../assets/vendor/select2/select2.min.js"></script> 
<script src="../../../assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>
</html>
