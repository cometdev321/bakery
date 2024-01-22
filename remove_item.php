<?php
include('cnn.php');

if(isset($_POST['removeid'])){
    $id=$_POST['removeid'];
    $sql = "UPDATE branch SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}


if(isset($_POST['remove_user'])){
    $id=$_POST['remove_user'];
    $sql = "UPDATE tblusers SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

if(isset($_POST['category'])){
    $id=$_POST['category'];
    $sql = "UPDATE tblcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

if(isset($_POST['subcategory'])){
    $id=$_POST['subcategory'];
    $sql = "UPDATE tblsubcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}


if(isset($_POST['remove_product'])){
    $id=$_POST['remove_product'];
    $sql = "UPDATE tblproducts SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
}

if(isset($_POST['product_approve'])){
    $id=$_POST['product_approve'];
    $sql = "UPDATE tblproducts SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-products?status=success'</script>";
}

if(isset($_POST['product_reject'])){
    $id=$_POST['product_reject'];
    $sql = "UPDATE tblproducts SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-products?status=rejected'</script>";
}


if(isset($_POST['newcategory_approve'])){
    $id=$_POST['newcategory_approve'];
    $sql = "UPDATE tblcategory SET status='1' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-category?status=success'</script>";

}

if(isset($_POST['newcategory_reject'])){
    $id=$_POST['newcategory_reject'];
    $sql = "UPDATE tblcategory SET status='0' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo"<script>window.location.href='new-category?status=rejected'</script>";
}

