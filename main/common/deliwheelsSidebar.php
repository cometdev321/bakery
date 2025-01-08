<?php include('base.php');?>
<?php include('baseScript.php');?>
<?php
$db_host ='localhost';
$db_user='root';
$db_pass='';
$db_databse='deliwheels';

$deliwheelsConn= mysqli_connect($db_host,$db_user,$db_pass,$db_databse);

if(!$deliwheelsConn)
{
    die("Connection Failed".mysqli_connect_error());
}

?>
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- DataTables CSS -->
 <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<script>
       
       function loadScript(url, callback) {
            // Check if script already exists
            let existingScript = document.querySelector(`script[src="${url}"]`);
            if (existingScript) {
                existingScript.remove();
            }
            let script = document.createElement("script");
            script.type = "text/javascript";
            script.src = url;
            script.onload = callback;
            document.head.appendChild(script);
        }

        function loadStylesheet(url) {
            // Check if stylesheet already exists
            let existingLink = document.querySelector(`link[href="${url}"]`);
            if (existingLink) {
                existingLink.remove();
            }
            let link = document.createElement("link");
            link.rel = "stylesheet";
            link.href = url;
            document.head.appendChild(link);
        }

        function destroyExistingTable() {
            if ($.fn.DataTable.isDataTable('#exportTable')) {
                $('#exportTable').DataTable().clear().destroy();
            }
        }

        function loadTabledata() {
            // Destroy any existing DataTable instance
            destroyExistingTable();

            // Load CSS files
            loadStylesheet("https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css");
            loadStylesheet("https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css");

            // Load JS files in sequence
            loadScript("https://code.jquery.com/jquery-3.6.0.min.js", function() {
                loadScript("https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js", function() {
                    loadScript("https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js", function() {
                        loadScript("https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js", function() {
                            loadScript("https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js", function() {
                                // Initialize DataTable after all scripts are loaded
                                $('#exportTable').DataTable({
                                    destroy: true,
                                    dom: 'Bfrtip',
                                    paging: true,
                                    searching: true,
                                    ordering: true,
                                    lengthChange: true,
                                    pageLength: 10,
                                });
                            });
                        });
                    });
                });
            });
        }
    
    </script>
<style>

    .demo-card label{ display: block; position: relative;}
    .demo-card .col-lg-4{ margin-bottom: 30px;}
</style>
<style>
  .green-text {
    color: green;
}

.red-text {
    color: #FF5617; /* Light red color */
}
</style>
<style>
    /* Hide default scrollbar
    body {
        overflow: hidden;
    }

    /* Style your custom scrollbar here */
    /* For WebKit-based browsers */
    /* ::-webkit-scrollbar {
        width: 0;  
        background: transparent; 
    } */
    /* For Firefox */
    /* scrollbar-width: none; */
    /* For IE and Edge */
    /* -ms-overflow-style: none; */ 
</style>
<body class="theme-cyan">

    <!-- Page Loader -->
<!--<div class="page-loader-wrapper">-->
<!--    <div class="loader">-->
<!--        <div class="m-t-30"><img src="https://www.wrraptheme.com/templates/lucid/html/assets/images/logo-icon.svg" width="48" height="48" alt="Lucid"></div>-->
<!--        <p>Please wait...</p>        -->
<!--    </div>-->
<!--</div>-->
<!-- Overlay For Sidebars -->






<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
                <a href="<?php echo $base ?>/dashboard" class="text-dark">
                     <?php 
                            if(isset($_SESSION['admin'])){
                                echo 'SuperAdmin';
                            }else{
                                echo 'Admin';
                            }
                     ?>
                    </a>                
            </div>
            
            <div class="navbar-right">
                <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo $base ?>/party/add-party" title="New New Party"  class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-users"></i></a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#userDetailsModal" title="Add New Product" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-briefcase"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo $base ?>/sales/create_sales_invoice"  title="Sales Invoice"  class="icon-menu d-none d-sm-block"><i class="icon-tag"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo $base ?>/purchase/create_purchase_invoice   "  title="Purchase Invoice" class="icon-menu d-none d-sm-block"><i class="icon-bag"></i></a>
                            <!-- <span class="notification-dot"></span> -->
                        </li>
                        
                   
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="left-sidebar" class="sb sidebar">
        <div class="sidebar-scroll">
           


                                   
    
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu">    
                            <li>
                                <a href="<?php echo $base ?>/dashboard" class=""><i class="icon-home"></i><span>Home</span></a>
                            </li>                        
                            <li>
                                <a href="<?php echo $base ?>/deliwheels/dashboard" class=""><i class="fa fa-truck"></i><span>DeliWheels</span></a>
                            </li>                        
                            <li>
                                <a href="<?php echo $base ?>/deliwheels/employee/create" class=""><i class="fa fa-users"></i> <span>Employees</span></a>
                            </li>
                            <li>
                                <a href="<?php echo $base ?>/deliwheels/vehicle/create" class=""><i class="fa fa-taxi"></i><span>Vehicle</span></a>
                            </li>
                            <li>
                                <a href="<?php echo $base ?>/deliwheels/route/create" class=""><i class="fa fa-sitemap"></i> <span>Routes</span></a>
                            </li>
                            <li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li>
                        </ul>
                    </nav>
                </div>
               
            </div>          
        </div>
    </div>
    
          
  <style>
      input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
  </style>