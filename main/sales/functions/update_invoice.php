<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');


    // Retrieve the JSON data
    $postData = json_decode(file_get_contents('php://input'), true);

    // Retrieve the common data
    $salesID= $postData['formData']['salesId'];
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
    $query = "UPDATE tblsalesinvoices 
    SET party_name = '$partyName', 
        party_mobno = '$partyMobNo', 
        sales_invoice_number = '$invoiceNumber', 
        sales_invoice_date = '$invoiceDate', 
        sub_total = '$subtotal', 
        discount = '$totalDiscount', 
        after_discount_total = '$afterDiscountTotal', 
        full_paid = '$fullyPaid', 
        amount_received = '$amountReceived', 
        amount_received_type = '$amountReceivedtype',
        total_balance = '$totalBalance'
        WHERE id = $salesID;
    ";

    // Perform the database query
    $result = mysqli_query($conn, $query);
    $salesInvoiceId =$invoiceNumber;

    if ($result) {
        // Insertion successful
            // Iterate through the posted data and insert the details records
        foreach ($postData['data'] as $key => $val) {
            $salesID = $val['salesID'];
            $type = $val['type'];
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
            $details_query;
            // Perform the INSERT query for tblsalesinvoice_details
            if($type=='old'){

                $details_query = "UPDATE tblsalesinvoice_details 
                SET `ItemName` = '$itemName',
                `HSN` = '$hsn',
                `BatchNo` = '$batchNo',
                `ExpireDate` = '$expireDate',
                `ManufactureDate` = '$manufactureDate',
                `Size` = '$size',
                `Qty` = '$qty',
                `Price` = '$price',
                `Discount` = '$itemDiscount',
                `Tax` = '$tax',
                `Amount` = '$amount'
                WHERE `id` = '$salesID';
                ";
            } 

            if($type=='new'){
                $details_query = "INSERT INTO tblsalesinvoice_details (`sales_invoice_number`,`ItemName`,`HSN`,`BatchNo`,`ExpireDate`,`ManufactureDate`,`Size`,`Qty`,`Price`,`Discount`,`Tax`,`Amount`,`userID`) 
                VALUES ('$salesInvoiceId', '$itemName', '$hsn', '$batchNo', '$expireDate', '$manufactureDate','$size','$qty', '$price', '$itemDiscount', '$tax', '$amount','$session')";
            }

            mysqli_query($conn, $details_query);
        }
        // Retrieve the auto-generated sales_invoice_id
       
        echo "success";
    } else {
        // Insertion failed
        echo "error";
    }

    // Close the database connection
    mysqli_close($conn);

?>
