<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Vehicle</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Add Vehicle</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Vehicle Details</h2>
                    </div>
                    <div class="body">
                         <form id="vehicleForm">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" placeholder="Type Here" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Number Plate</label>
                                <input type="text" placeholder="Type Here" class="form-control" name="numberplate" required>
                            </div>
                            <div class="form-group">
                                <label>Driver</label>
                                <select class="form-control show-tick ms select2" name="driver" data-placeholder="Select" required>
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
                            <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Vehicle Details<small>Manage Your Vehicles</small></h2>                            
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="VehicleTable">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Vehicle</th>
                                        <th>NumberPlate</th>
                                        <th>Driver</th>
                                        <th>Helper</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Vehicle</th>
                                        <th>NumberPlate</th>
                                        <th>Driver</th>
                                        <th>Helper</th>
                                        <th>Edit</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
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
        // Fetch Vehicles from the API

        $.ajax({
            url: '../../api/dw_vehicles/read_vehicles.php', // Update with your API endpoint
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let slno = 1;
                const tbody = $('#VehicleTable tbody');
                tbody.empty(); // Clear existing rows
console.log(data)
                data.forEach(function(Vehicle) {
                    tbody.append(`
                        <tr>
                            <td>${slno}</td>
                            <td>${Vehicle.name}</td>
                            <td>${Vehicle.numberplate}</td>
                            <td>${Vehicle.driver}</td>
                            <td>${Vehicle.helper}</td>
                            <td>
                                <a href="edit_Vehicle?id=${Vehicle.id}" class="btn btn-success btn-sm"><i class="icon-pencil"></i></a>
                            </td>
                        </tr>
                    `);
                    slno++;
                });
            },
            error: function() {
                Toastify({
                    text: "Failed to fetch Vehicle data.",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        });

        $('#vehicleForm').on('submit', function(event) {
            event.preventDefault();

            const VehicleData = {
                name: $('input[name="name"]').val(),
                number_plate: $('input[name="numberplate"]').val(),
                driver_id: $('select[name="driver"]').val(),
                helper_id: $('select[name="partner"]').val()
            };
            $.ajax({
                url: '../../api/dw_vehicles/create_vehicle.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(VehicleData),
                success: function(response) {
                    const message = response.message;
                    if (message === "Vehicle created successfully.") {
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: "green",
                        }).showToast();

                        $('#VehicleForm')[0].reset(); // Reset form fields
                        // Optionally, you could refresh the Vehicle table here
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

<script src="../../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 
<script src="../../../assets/js/pages/ui/dialogs.js"></script>
<script src="../../../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 

<script src="../../../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../../../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../../../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>

<script src="../../../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../../../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="../../../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../../../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 

<script src="../../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
  <script src="../../../assets/js/pages/tables/jquery-datatable.js"></script>
  
<script src="../../../assets/bundles/mainscripts.bundle.js"></script>
<script src="../../../assets/js/pages/forms/advanced-form-elements.js"></script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:17 GMT -->
</html>

