<?php
session_start();
include('cnn.php');

if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: page-login.php");
    exit();
}
if(isset($_SESSION['admin'])){
$sessionAdmin=$_SESSION['admin'];
}
if(isset($_SESSION['user'])){
$sessionUser=$_SESSION['user'];
}
date_default_timezone_set('Asia/Kolkata');


?>
<!doctype html>
<html lang="en">


<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/chart-jquery-knob.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 05:12:26 GMT -->
<head>
<title>ADMIN</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


<link rel="icon" href="favicon.ico" type="Images/nayanlogo.png">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/vendor/sweetalert/sweetalert.css"/>
<link rel="stylesheet" href="assets/vendor/select2/select2.css" />

<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<link rel="stylesheet" href="assets/vendor/multi-select/css/multi-select.css">
<link rel="stylesheet" href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css">
<link rel="stylesheet" href="assets/vendor/nouislider/nouislider.min.css" />
<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
</head>
<!-- Demo CSS not Include in project -->
<style>
    .demo-card label{ display: block; position: relative;}
    .demo-card .col-lg-4{ margin-bottom: 30px;}
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
    <?php
    if(isset($_SESSION['admin'])){
        $getadmin=mysqli_query($conn,"select * from admin where unicode='$sessionAdmin'");
        $fetchadmin=mysqli_fetch_array($getadmin);        
    }else if(isset($_SESSION['user'])){
        $getadmin=mysqli_query($conn,"select * from tblusers where userID='$sessionUser'");
        $fetchadmin=mysqli_fetch_array($getadmin);        
    }
    ?>
<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>
          <style>


          </style>
            <div class="navbar-brand">
                <a href="dashboard" class="text-dark">
                    &nbsp; &nbsp; &nbsp; &nbsp; ADMIN
                    <!--<img src="Images/img1.png"  height="33" class="img-responsive logo">-->
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
                            <a href="file-dashboard.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="fa fa-folder-open-o"></i></a>
                        </li>
                        <li>
                            <a href="app-calendar.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-calendar"></i></a>
                        </li>
                        <li>
                            <a href="app-chat.html" class="icon-menu d-none d-sm-block"><i class="icon-bubbles"></i></a>
                        </li>
                        <li>
                            <a href="app-inbox.html" class="icon-menu d-none d-sm-block"><i class="icon-envelope"></i><span class="notification-dot"></span></a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot"></span>
                            </a>
                            <ul class="dropdown-menu notifications">
                                <li class="header"><strong>You have 4 new Notifications</strong></li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-info text-warning"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Campaign <strong>Holiday Sale</strong> is nearly reach budget limit.</p>
                                                <span class="timestamp">10:00 AM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>                               
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-like text-success"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Your New Campaign <strong>Holiday Sale</strong> is approved.</p>
                                                <span class="timestamp">11:30 AM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                    <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-pie-chart text-info"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Website visits from Twitter is 27% higher than last week.</p>
                                                <span class="timestamp">04:00 PM Today</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-info text-danger"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="text">Error on website analytics configurations</p>
                                                <span class="timestamp">Yesterday</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="footer"><a href="javascript:void(0);" class="more">See all notifications</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-equalizer"></i></a>
                            <ul class="dropdown-menu user-menu menu-icon">
                                <li class="menu-heading">ACCOUNT SETTINGS</li>
                                <li><a href="javascript:void(0);"><i class="icon-note"></i> <span>Basic</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-equalizer"></i> <span>Preferences</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-lock"></i> <span>Privacy</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-bell"></i> <span>Notifications</span></a></li>
                                <li class="menu-heading">BILLING</li>
                                <li><a href="javascript:void(0);"><i class="icon-credit-card"></i> <span>Payments</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-printer"></i> <span>Invoices</span></a></li>                                
                                <li><a href="javascript:void(0);"><i class="icon-refresh"></i> <span>Renewals</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="logout" class="icon-menu"><i class="icon-login"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                <!--<img src="Images/<?php
                if(isset($_SESSION['admin'])){
                    echo $fetchadmin['image'];
                }
                  
                  ?>" class="rounded-circle user-photo" alt="User Profile Picture">-->
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>
                        <?php 
                        if(isset($_SESSION['admin'])){
                            echo strtoupper($fetchadmin['Name']); 
                    }else if(isset($_SESSION['user'])){
                            echo strtoupper($fetchadmin['username']);
                        }
                        
                        ?>&nbsp;
                    </strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account">
                        <li><a href="page-profile"><i class="icon-user"></i>My Profile</a></li>
                        <!--<li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>-->
                        <li><a href="page-profile"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>
                <hr>
                <ul class="row list-unstyled">
                    <li class="col-4">
                        <small>Sales</small>
                        <h6>0</h6>
                    </li>
                    <li class="col-4">
                        <small>Order</small>
                        <h6>0</h6>
                    </li>
                    <li class="col-4">
                        <small>Revenue</small>
                        <h6>0</h6>
                    </li>
                </ul>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            </ul>
                
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu">                            
                            <li>
                                <a href="#Dashboard" class="has-arrow"><i class="icon-home"></i> <span>Dashboard</span></a>
                               <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                                <ul>
                                    <li><a href="mybranches"><i class="fa fa-building-o"></i> My Branch</a></li>
                                    <li><a href="myusers"><i class="fa fa-users"></i> My Users</a></li>
                                </ul>
                                <?php } ?>
                            </li>
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-basket"></i> <span>Category</span></a>
                                <ul>
                                <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                                    <li><a href="add-category"><i class="fa icon-mouse"></i> Add New Category</a></li>
                                    <?php } ?>
                                    <li><a href="new-category"><i class="fa icon-mouse"></i>Category Requests</a></li>
                                    <!--<li><a href="add-subcategory"><i class="fa icon-mouse"></i> Add Sub-Category</a></li>-->

                                </ul>
                            </li>
                            <li>
                                <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Products</span></a>
                                <ul>
                                <?php
                                   if(isset($_SESSION['admin'])){
                                ?>
                                    <li><a href="add-product"><i class="fa icon-mouse"></i> Add New Product</a></li>
                                    <li><a href="manage-products"><i class="fa icon-mouse"></i> Manage Products</a></li>
                                    <?php } ?>
                                    <li><a href="new-products"><i class="fa icon-mouse"></i>Product Requests</a></li>

                                </ul>
                            </li>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-tag"></i> <span>Sales</span></a>
                                <ul>                                    
                                    <li><a href="sales_invoice">Sales Invoices</a></li>
                                    <li><a href="paymentIn_list">Payment In</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-bag"></i> <span>Purchase</span></a>
                                <ul>                                    
                                    <li><a href="purchase_invoice">Purchase Invoices</a></li>
                                    <li><a href="paymentout_list">Payment Out</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#FileManager" class="has-arrow"><i class="icon-book-open"></i> <span>Reports</span></a>
                                <ul>                                    
                                    <li><a href="file-dashboard.html">Dashboard</a></li>
                                    <li><a href="file-documents.html">Documents</a></li>
                                    <li><a href="file-media.html">M7edia</a></li>
                                    <li><a href="file-images.html">Images</a></li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
                <div class="tab-pane p-l-15 p-r-15" id="setting">
                    <h6>Choose Skin</h6>
                    <ul class="choose-skin list-unstyled">
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>                   
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="cyan" class="active">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="blush">
                            <div class="blush"></div>
                            <span>Blush</span>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>          
        </div>
    </div>
    
            <!-- Input Slider -->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Input Slider <small>Taken from <a href="http://refreshless.com/nouislider" target="_blank">refreshless.com/nouislider</a> & <a href="http://materializecss.com/" target="_blank">materializecss.com</a></small> </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <p><b>Basic Example</b></p>
                                    <div id="nouislider_basic_example"></div>
                                    <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <p><b>Range Example</b></p>
                                    <div id="nouislider_range_example"></div>
                                    <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                                </div>
                            </div>
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