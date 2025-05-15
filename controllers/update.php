<?php
require_once "../models/Product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = new Product();
    $oldImg = $_POST["oldImg"];
    $imagePath = '../uploads/img/' . $oldImg;

    //mengecek jika gambar diupload
    if ($_FILES['img']['error'] === 4) {
        $img = $oldImg;
    } else {
        unlink($imagePath);
        $img = $product->uploadImage();
    }

    $product->updateProduct( $_POST['id'], $_POST['name'], (int)$_POST['price'], $img, (int)$_POST['stock']);
    session_start();
    $_SESSION['message'] = 'Produk ' . $_POST['name'] . ' berhasil diedit!';
        header("Location: ../index.php");
        exit();
}

?>