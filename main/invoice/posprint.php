<?php 
include('../common/header2.php');

$userID = isset($_SESSION['subSession']) ? $_SESSION['subSession'] : '-';
if ($userID == 'All') {
    $query = "SELECT image FROM admin WHERE unicode='$session'"; 
} else if (isset($_SESSION['subSession'])) {
    $query = "SELECT image FROM admin WHERE unicode IN (SELECT superAdminID FROM tblusers WHERE userID='$userID')"; 
} else if (isset($_SESSION['admin'])) {
    $query = "SELECT image FROM admin WHERE unicode='$session'"; 
} else {
    $query = "SELECT image FROM admin WHERE unicode IN (SELECT superAdminID FROM tblusers WHERE userID='$session')"; 
}

$result = mysqli_query($conn, $query);
$fetch = mysqli_fetch_array($result);

$id = 0;
if (isset($_POST['sale_id'])) {
    $id = $_POST['sale_id'];
} else if (isset($_POST['purchase_id'])) {
    $id = $_POST['purchase_id'];
}else if (isset($_POST['new_sale_id'])) {
    $id = $_POST['new_sale_id'];
}

if (isset($_POST['sale_id']) || isset($_POST['new_sale_id'])) {
    $query1 = "SELECT si.*, p.name as name, p.mobno as mobno
               FROM tblsalesinvoices si
               INNER JOIN tblparty p ON si.party_name = p.id
               WHERE si.status = '1' AND si.id='$id'
               ORDER BY si.id DESC"; 
} else if (isset($_POST['purchase_id'])) {
    $query1 = "SELECT pi.*, p.name as name, p.mobno as mobno
               FROM tblpurchaseinvoices pi
               INNER JOIN tblparty p ON pi.party_name = p.id
               WHERE pi.status = '1' AND pi.id='$id'
               ORDER BY pi.id DESC"; 
}
$result1 = mysqli_query($conn, $query1);
$row = mysqli_fetch_array($result1);

$query3 = "SELECT name, location FROM branch WHERE id IN (SELECT branch FROM tblusers WHERE userID='$session')";
$result3 = mysqli_query($conn, $query3);
$row3 = mysqli_fetch_array($result3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
    <style>
        @media print {
            .receipt {
                width: 58mm;
                font-size: 12px;
            }
            .hidden-print {
                display: none;
            }
            body {
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }
        }
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 58mm;
            padding: 10px;
            margin: auto;
            border: 1px solid #ddd;
        }
        .receipt img {
            display: block;
            margin: auto;
        }
        .receipt .header,
        .receipt .footer {
            text-align: center;
        }
        .receipt .details,
        .receipt .items {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt .details td,
        .receipt .items th,
        .receipt .items td {
            padding: 5px;
            text-align: left;
        }
        .receipt .items th,
        .receipt .items td {
            border-bottom: 1px solid #ddd;
        }
        .receipt .items th:last-child,
        .receipt .items td:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <img src="../../Images/<?php echo $fetch['image'];?>" alt="logo" width="50">
            <h2><?php echo strtoupper($row3['name']); ?></h2>
            <p><?php echo $row3['location'];    
 ?></p>
        </div>
        <div class="details">
            <table>
                <tr>
                    <td>Invoice #</td>
                    <td><?php echo (isset($row['sales_invoice_number'])) ? $row['sales_invoice_number'] : $row['purchase_invoice_number']; ?></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><?php echo (isset($row['sales_invoice_date'])) ? $row['sales_invoice_date'] : $row['purchase_invoice_date']; ?></td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td><?php echo $row['name']; ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?php echo $row['mobno']; ?></td>
                </tr>
            </table>
        </div>
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slno = 1;
                    if (isset($_POST['sale_id'])  || isset($_POST['new_sale_id'])) {
                        $invoiceNum = $row['sales_invoice_number'];
                        $query2 = "SELECT ts.*, tp.productname as `pname`
                                   FROM tblsalesinvoice_details ts
                                   INNER JOIN tblproducts tp ON tp.id=ts.ItemName
                                   WHERE ts.sales_invoice_number='$invoiceNum' 
                                   AND ts.userID='$session' 
                                   AND ts.status='1' 
                                   ORDER BY ts.id ASC";
                    } else if (isset($_POST['purchase_id'])) {
                        $invoiceNum = $row['purchase_invoice_number'];
                        $query2 = "SELECT ts.*, tp.productname as pname
                                   FROM tblpurchaseinvoice_details ts
                                   INNER JOIN tblproducts tp ON tp.id=ts.ItemName
                                   WHERE ts.purchase_invoice_number='$invoiceNum'
                                   AND ts.userID='$session'
                                   AND ts.status='1'
                                   ORDER BY ts.id ASC";
                    }
                    $result3 = mysqli_query($conn, $query2);
                    if (mysqli_num_rows($result3) > 0) {
                        while ($row2 = mysqli_fetch_array($result3)) {
                            echo "<tr>
                                <td>{$row2['pname']}</td>
                                <td>{$row2['Qty']}</td>
                                <td>{$row2['Price']}</td>
                                <td>{$row2['Amount']}</td>
                            </tr>";
                        }
                    } 
                    ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Sub-total: <?php echo $row['sub_total']; ?></p>
            <p>Discount: <?php echo $row['discount']; ?></p>
            <p>Total: <?php echo $row['after_discount_total']; ?></p>
            <p>Thank you for your purchase!</p>
        </div>
    </div>
    
    <div class="hidden-print">
        <button onclick="window.print()">Print</button>
    </div>
</body>
</html>
