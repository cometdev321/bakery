<?php 
include('../common/header2.php');

$userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
if($userID=='All'){
    $query = "SELECT image FROM admin where unicode='$session'"; 
} else if(isset($_SESSION['subSession'])){
    $query = "SELECT image FROM admin where unicode in(select superAdminID from tblusers where userID='$userID')"; 
} else if(isset($_SESSION['admin'])){
    $query = "SELECT image FROM admin where unicode='$session'"; 
} else {
    $query = "SELECT image FROM admin where unicode in(select superAdminID from tblusers where userID='$session')"; 
}

$result = mysqli_query($conn,$query);
$fetch = mysqli_fetch_array($result);
$id=0;
if(isset($_POST['sale_id'])){
    $id=$_POST['sale_id'];
} else if(isset($_POST['purchase_id'])){
    $id=$_POST['purchase_id'];
}
if(isset($_POST['sale_id'])){
    $query1 = "SELECT si.*, p.name as name,p.mobno as mobno
    FROM tblsalesinvoices si
    INNER JOIN tblparty p ON si.party_name = p.id
    WHERE si.status = '1' and si.id='$id'
    ORDER BY si.id DESC"; 
} else if(isset($_POST['purchase_id'])){
    $query1 = "SELECT pi.*, p.name as name,p.mobno as mobno
    FROM tblpurchaseinvoices pi
    INNER JOIN tblparty p ON pi.party_name = p.id
    WHERE pi.status = '1' AND  pi.id='$id'
    ORDER BY pi.id DESC "; 
}
$result1 = mysqli_query($conn, $query1);
$row = mysqli_fetch_array($result1);

$query3="select name,location from branch where id in (select branch from tblusers where userID='$session')";
$result3 = mysqli_query($conn, $query3);
$row3 = mysqli_fetch_array($result3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../../assets/bundles/libscripts.bundle.css">
    <link rel="stylesheet" href="../../assets/bundles/vendorscripts.bundle.css">
    <link rel="stylesheet" href="../../assets/bundles/mainscripts.bundle.css">
    <style>
        @media print {
            /* General styles for avoiding page breaks */
            .invoice1, .table-responsive, .clearfix, .invoice-top, .invoice-start {
                page-break-inside: avoid;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            tr {
                page-break-inside: avoid;
            }

            td, th {
                page-break-inside: avoid;
                page-break-after: auto;
                padding: 10px;
                text-align: left;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            .hidden-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }

            html, body {
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            .card.invoice1 {
                padding: 20px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .invoice-top, .invoice-start, .invoice-end {
                margin-bottom: 20px;
            }
        }
    </style>

</head>
<body>
    <div class="container-fluid my-4">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card invoice1">    
                    <div class="hidden-print col-md-12 text-right mt-2">
                        <button class="btn btn-outline-secondary" id="printButton"><i class="icon-printer"></i></button>
                    </div>                    
                    <div class="body">
                        <div class="invoice-top clearfix">
                            <div class="logo">
                                <img src="../../Images/<?php echo $fetch['image'];?>" alt="user" class="rounded-circle img-fluid">
                            </div>
                            <div class="info">
                                <h6><b><?php echo strtoupper($row3['name']); ?></b></h6>
                                <p> <?php echo $row3['location']; ?> <br>
                                </p>
                            </div>
                            <div class="title">
                                <h4>Invoice #<?php echo (isset($row['sales_invoice_number']))?$row['sales_invoice_number']:$row['purchase_invoice_number']; ?></h4>
                                <p>Issued:<?php echo (isset($row['sales_invoice_date']))?$row['sales_invoice_date']:$row['purchase_invoice_date']; ?> <br>
                                    Payment Pending: <?php echo $row['full_paid']; ?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="invoice-start clearfix">
                            <div class="clientlogo">
                                <h6>Customer Info</h6>
                            </div>
                            <div class="info">
                                <h6><?php echo $row['name']; ?></h6>
                                <?php echo $row['mobno']; ?></p>
                            </div>   
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Item Name</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $slno = 1;
                                        if(isset($_POST['sale_id'])){
                                            $salesInvoiceNum = $row['sales_invoice_number'];
                                            $query2 = "SELECT ts.*,tp.productname as `pname` FROM `tblsalesinvoice_details` ts
                                                    inner join tblproducts tp on tp.id=ts.ItemName
                                                    WHERE ts.sales_invoice_number='$salesInvoiceNum' AND ts.userID='$session' AND ts.status='1' ORDER BY ts.id ASC";
                                        } else if(isset($_POST['purchase_id'])){
                                            $purchaseInvoiceNum = $row['purchase_invoice_number'];
                                            $query2 = "SELECT ts.*, tp.productname AS pname 
                                            FROM tblpurchaseinvoice_details ts
                                            INNER JOIN tblproducts tp ON tp.id = ts.ItemName
                                            WHERE ts.purchase_invoice_number = '$purchaseInvoiceNum' 
                                            AND ts.userID = '$session' 
                                            AND ts.status = '1' 
                                            ORDER BY ts.id ASC";
                                        }
                                        $result3 = mysqli_query($conn, $query2);
                                        if (mysqli_num_rows($result3) > 0) {
                                            while ($row2 = mysqli_fetch_array($result3)) {
                                                $product = $row2['ItemName']; 
                                    ?>
                                    <tr class="gradeA">
                                        <td><?php echo $slno; ?></td>
                                        <td><?php echo $row2['pname']; ?></td>
                                        <td><?php echo $row2['Size']; ?></td>
                                        <td><?php echo $row2['Qty']; ?></td>
                                        <td><?php echo $row2['Price']; ?></td>
                                        <td><?php echo $row2['Discount']; ?></td>
                                        <td><?php echo $row2['Tax']; ?></td>
                                        <td><?php echo $row2['Amount']; ?></td>
                                    </tr>
                                    <?php
                                                $slno++;
                                            }
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <h5>Note</h5>
                                <p></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p class="m-b-0"><b>Sub-total:</b> <?php echo $row['sub_total']; ?>.00</p>
                                <p class="m-b-0"><b>Discount:</b> <?php echo $row['discount']; ?>.00</p>
                                <h3 class="m-b-0 m-t-10"><?php echo $row['after_discount_total']; ?>.00</h3>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../assets/bundles/libscripts.bundle.js"></script>    
    <script src="../../assets/bundles/vendorscripts.bundle.js"></script>
    <script src="../../assets/bundles/mainscripts.bundle.js"></script>
    <script>
        document.getElementById('printButton').addEventListener('click', function () {
            window.print();
        });
    </script>
</body>
</html>
