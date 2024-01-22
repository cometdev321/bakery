<?php
include('cnn.php');
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
    $fullyPaid = $postData['formData']['check_payment_received'] ? 'Yes' : 'No';
    $amountReceived = $postData['formData']['amount_received_value'];
    $totalBalance = $postData['formData']['balance_total_value'];

    // Prepare and execute the query for tblsalesinvoices
    $query = "INSERT INTO tblsalesinvoices (party_name, party_mobno, sale_invoice_number, sale_invoice_date, sub_total, discount, after_discount_total, full_paid, amount_received, total_balance) 
              VALUES ('$partyName', '$partyMobNo', '$invoiceNumber', '$invoiceDate', '$subtotal', '$totalDiscount', '$afterDiscountTotal', '$fullyPaid', '$amountReceived', '$totalBalance')";

    // Perform the database query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Insertion successful
        echo "Sales invoice saved successfully.";

        // Retrieve the auto-generated sales_invoice_id
        $salesInvoiceId = mysqli_insert_id($conn);

        // Iterate through the posted data and insert the details records
        foreach ($postData['data'] as $key => $val) {
            $itemName = $val['itemname'];
            $hsn = $val['hsn'];
            $batchNo = $val['batchno'];
            $expireDate = $val['expiredate'];
            $manufactureDate = $val['mafdate'];
            $qty = $val['qty'];
            $price = $val['price'];
            $itemDiscount = $val['discount']; // Use a different variable name for the discount
            $tax = $val['tax'];
            $amount = $val['amount'];

            // Perform the INSERT query for tblsalesinvoice_details
            $details_query = "INSERT INTO tblsalesinvoice_details (sales_invoice_number,ItemName,HSN,BatchNo,ExpireDate,ManufactureDate,Qty,Price,Discount,Tax,Amount) 
              VALUES ('$salesInvoiceId', '$itemName', '$hsn', '$batchNo', '$expireDate', '$manufactureDate', '$qty', '$price', '$itemDiscount', '$tax', '$amount')";
            mysqli_query($conn, $details_query);
        }
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

?>
