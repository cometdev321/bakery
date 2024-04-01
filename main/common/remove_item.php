<?php
include('cnn.php');
#remove the branch from list
if(isset($_POST['removeid'])){
    $id=$_POST['removeid'];
    $sql = "UPDATE branch SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}


#remove the branch user
if(isset($_POST['remove_user'])){
    $id=$_POST['remove_user'];
    $sql = "UPDATE tblusers SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove category add-category page 
if(isset($_POST['category'])){
    $id=$_POST['category'];
    $sql = "UPDATE tblcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove subcategory
if(isset($_POST['subcategory'])){
    $id=$_POST['subcategory'];
    $sql = "UPDATE tblsubcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove the product
if(isset($_POST['remove_product'])){
    $id=$_POST['remove_product'];
    $sql = "UPDATE tblproducts SET status='bin' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#recover deleted product
if(isset($_POST['recover'])){
    $id=$_POST['recover'];
    $sql = "UPDATE tblproducts SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#approve product from the user
if(isset($_POST['product_approve'])){
    $id=$_POST['product_approve'];
    $sql = "UPDATE tblproducts SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-products?status=success'</script>";
}

#reject the new product from user 
if(isset($_POST['product_reject'])){
    $id=$_POST['product_reject'];
    $sql = "UPDATE tblproducts SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-products?status=rejected'</script>";
}

#approve new category from user
if(isset($_POST['newcategory_approve'])){
    $id=$_POST['newcategory_approve'];
    $sql = "UPDATE tblcategory SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-category?status=success'</script>";
}

#reject the category from user
if(isset($_POST['newcategory_reject'])){
    $id=$_POST['newcategory_reject'];
    $sql = "UPDATE tblcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-category?status=rejected'</script>";
}

#remove sales invoice
if(isset($_POST['sales_invoice'])){
    $id=$_POST['sales_invoice'];
    $invoice=$_POST['sales_invoice_number'];
    $sql = "UPDATE tblsalesinvoices SET status='0' WHERE id=$id";
    mysqli_query($conn,"UPDATE tblsalesinvoice_details SET status='0' WHERE sales_invoice_number=$invoice");
    mysqli_query($conn, $sql);
}


if(isset($_POST['purchase_invoice'])){
    $id = $_POST['purchase_invoice'];
    $invoice = $_POST['purchase_invoice_number'];
    $sql = "UPDATE tblpurchaseinvoices SET status='0' where id = $id";
    mysqli_query($conn,"UPDATE tblpurchaseinvoice_details SET status='0' WHERE purchase_invoice_number=$invoice");
    mysqli_query($conn,$sql);
}

#remove the sales invoice product from the list
if(isset($_POST['sales_invoice_item'])){
    $id=$_POST['sales_invoice_item'];
    $sql = "UPDATE tblsalesinvoice_details SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}
#remove the purchase invoice product from the list
if(isset($_POST['purchase_invoice_item'])){
    $id=$_POST['purchase_invoice_item'];
    $sql = "UPDATE tblpurchaseinvoice_details SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove the party
if(isset($_POST['remove_party'])){
    $id=$_POST['remove_party'];
    $sql = "UPDATE tblparty SET status='bin' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#recover deleted party
if(isset($_POST['recover_party'])){
    $id=$_POST['recover_party'];
    $sql = "UPDATE tblparty SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove paymentIn
if(isset($_POST['remove_paymentIn'])){
    $id=$_POST['remove_paymentIn'];
    $sql = "UPDATE tblpaymentin SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove paymentOut
if(isset($_POST['remove_paymentOUT'])){
    $id=$_POST['remove_paymentOUT'];
    $sql = "UPDATE tblpaymentout SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove deleteTransaction
if(isset($_POST['deleteTransaction'])){
    $id=$_POST['deleteTransaction'];
    $sql = "UPDATE `tbltransfer` SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}