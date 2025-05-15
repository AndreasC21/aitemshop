<?php
require_once "../models/Product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = new Product();

    //mengupload gambar
    $img = $product->uploadImage();
    if(!$img) {
        return false;
    }

$product->createProduct($_POST['name'], (int)$_POST['price'], $img, (int)$_POST['stock']);
    session_start();
    $_SESSION['message'] = 'Produk ' . $_POST['name'] . ' berhasil ditambahkan!';
    header("Location: ../index.php");
    exit();
}
?>