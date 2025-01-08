<?php  
include('../../common/header3.php'); 
include('../../common/deliwheelsSidebar.php'); 

$route_id = isset($_GET['id']) ? $_GET['id'] : 0;

$route_query = "SELECT dwr.id as routeid, dwr.startpoint, dwr.endpoint, dwv.name as vehiclename, 
dwv.id as vehicleid, dwv.number_plate as number_plate FROM dw_routes dwr
JOIN dw_vehicles dwv ON dwr.vehicle_id = dwv.id
WHERE dwr.status = '1' AND dwr.id = '$route_id'";
$result = mysqli_query($deliwheelsConn, $route_query);
$route = mysqli_fetch_assoc($result);
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Route</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Edit Route</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card planned_task">
                    <div class="header">
                        <h2>Route Details</h2>
                    </div>
                    <div class="body">
                         <form id="RouteForm">
                            <div class="form-group">
                                <label>Start Point</label>
                                <input type="text" value="<?php echo $route_id ?>" hidden name="routeId" id="routeId">
                                <input type="text" placeholder="Type Here" value="<?php echo htmlspecialchars($route['startpoint']); ?>" class="form-control" name="startpoint" required>
                            </div>
                            <div class="form-group">
                                <label>End Point</label>
                                <input type="text" placeholder="Type Here" value="<?php echo htmlspecialchars($route['endpoint']); ?>" class="form-control" name="endpoint" required>
                            </div>
                            <div class="form-group">
                                <label>Vehicle</label>
                                <select class="form-control show-tick ms select2" name="vehicle_id" data-placeholder="Select" required>
                                    <option value="<?php echo htmlspecialchars($route['vehicleid']); ?>">Current Vehicle: <?php echo htmlspecialchars($route['vehiclename']); ?> (<?php echo htmlspecialchars($route['number_plate']); ?>)</option>
                                    <?php
                                        $query = "SELECT id, name, number_plate FROM dw_vehicles WHERE status = '1' ORDER BY id DESC";
                                        $result = mysqli_query($deliwheelsConn, $query);
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> (<?php echo $row['number_plate']; ?>)</option>
                                    <?php  } ?>
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> <span>Save</span></button>
                                <button type="button" name="delete" class="btn btn-danger btn-sm" id="deleteRoute"><i class="fa fa-trash"></i> <span>Delete</span></button>
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
        // Handle form submission
        $('#RouteForm').on('submit', function(event) {
            event.preventDefault();

            const route = {
                id: $('input[name="routeId"]').val(),
                startpoint: $('input[name="startpoint"]').val(),
                endpoint: $('input[name="endpoint"]').val(),
                vehicle_id: $('select[name="vehicle_id"]').val()
            };

            $.ajax({
                url: '../../api/dw_route/update_route.php',
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(route),
                success: function(response) {
                    const message = response.message;
                    Toastify({
                        text: message,
                        duration: 3000,
                        backgroundColor: message.includes("success") ? "green" : "red",
                    }).showToast();
                    if (message.includes("success")) {
                        window.location.href = 'create'; // Redirect after update
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

        // Handle delete action (set status to 0)
        $('#deleteRoute').on('click', function() {
            const routeId = $('input[name="routeId"]').val();

                $.ajax({
                    url: '../../api/dw_route/update_route.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: routeId ,status:0}),
                    success: function(response) {
                        const message = response.message;
                        Toastify({
                            text: message,
                            duration: 3000,
                            backgroundColor: message.includes("success") ? "green" : "red",
                        }).showToast();
                            window.location.href = 'create'; 
                        
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

<script src="../../../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
</body>
</html>
