<?php
require_once(__DIR__ . '/../models/Product.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = new Product();
    $id = $_POST['id'];
    $item = $product->getProductById($id);
    session_start();
    if (!$item) {
        $_SESSION['message'] = "Produk tidak ditemukan.";
        header("Location: ../index.php");
        exit();
    }

    $stock = $item['stock'];
    if ($stock <= 0) {
        $_SESSION['message'] = "Stok habis. Tidak dapat membeli produk ini.";
        header("Location: ../index.php");
        exit();
    }


    $newStock = $stock - 1;
    if ($product->buyProduct($id, $newStock)) {
        $_SESSION['message'] = "Pembelian berhasil!";
    } else {
        $_SESSION['message'] = "Gagal membeli barang.";
    }

    header("Location: ../index.php");
    exit();

}


?>