<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');


    // Retrieve the JSON data
    $postData = json_decode(file_get_contents('php://input'), true);

    // Retrieve the common data
    $partyName = $postData['formData']['party'];
    $partyMobNo = $postData['formData']['party_mob'];
    $invoiceNumber = $postData['formData']['sale_invoice_no'];
    $invoiceDate = $postData['formData']['sale_invoice_date'];
    $subtotal = $postData['formData']['subtotal_value'];
    $totalDiscount = $postData['formData']['discount_value'];
    $afterDiscountTotal = $postData['formData']['after_discount_total_value'];
    $fullyPaid = $postData['formData']['check_payment_received'];
    $amountReceived = $postData['formData']['amount_received_value'];
    $totalBalance = $postData['formData']['balance_total_value'];
    $amountReceivedtype='none';
    if (isset($postData['formData']['amount_received_type_value'])) {
        $amountReceivedtype = $postData['formData']['amount_received_type_value'];
    }
    
    // Prepare and execute the query for tblsalesinvoices
    $query = "INSERT INTO tblsalesinvoices (party_name, party_mobno, sales_invoice_number, sales_invoice_date, sub_total, discount, after_discount_total, full_paid, amount_received,amount_received_type, total_balance,userID) 
              VALUES ('$partyName', '$partyMobNo', '$invoiceNumber', '$invoiceDate', '$subtotal', '$totalDiscount', '$afterDiscountTotal', '$fullyPaid', '$amountReceived', '$amountReceivedtype','$totalBalance','$session')";

    // Perform the database query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Insertion successful

        // Retrieve the auto-generated sales_invoice_id
        $salesInvoiceId =$invoiceNumber;

        // Iterate through the posted data and insert the details records
        foreach ($postData['data'] as $key => $val) {
            $itemName = $val['itemname'];
            $hsn = $val['hsn'];
            $batchNo = $val['batchno'];
            $expireDate = $val['expiredate'];
            $manufactureDate = $val['mafdate'];
            $qty = $val['qty'];
            $size = $val['size'];
            $price = $val['price'];
            $itemDiscount = $val['discount']; // Use a different variable name for the discount
            $tax = $val['tax'];
            $amount = $val['amount'];

            // Perform the INSERT query for tblsalesinvoice_details
            $details_query = "INSERT INTO tblsalesinvoice_details (`sales_invoice_number`,`ItemName`,`HSN`,`BatchNo`,`ExpireDate`,`ManufactureDate`,`Size`,`Qty`,`Price`,`Discount`,`Tax`,`Amount`,`userID`,`Date`) 
              VALUES ('$salesInvoiceId', '$itemName', '$hsn', '$batchNo', '$expireDate', '$manufactureDate','$size','$qty', '$price', '$itemDiscount', '$tax', '$amount','$session','$invoiceDate')";
            mysqli_query($conn, $details_query);
        }
        echo "success";
    } else {
        // Insertion failed
        echo "error";
    }

    // Close the database connection
    mysqli_close($conn);

?>
