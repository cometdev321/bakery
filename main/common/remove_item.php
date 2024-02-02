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
    $sql = "UPDATE tblsalesinvoices SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

#remove the sales invoice product from the list
if(isset($_POST['sales_invoice_item'])){
    $id=$_POST['sales_invoice_item'];
    $sql = "UPDATE tblsalesinvoice_details SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}
