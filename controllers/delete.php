<?php
require_once "../models/Product.php";

if (isset($_GET['id'])) {
    $product = new Product();

    $data = $product->getProductById($_GET['id']);
    $message = '';



    if ($data && isset($data['img'])) {
        $imagePath = '../uploads/img/' . $data['img'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        session_start();
    if ($product->deleteProduct($_GET['id'])) {
        $message .= "Produk berhasil dihapus.";
        } else {
            $message .= "Gagal menghapus data produk.";
        }
    }

    $_SESSION['message'] = $message;
    header("Location: ../index.php");
    exit();
}
?>
