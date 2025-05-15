<?php
session_start();
require_once "../models/Product.php";

$user = isset($_SESSION['user']);
$admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    $sortColumn = null;
    $sortDirection = 'ASC';

    switch ($sort) {
        case 'price-asc':
            $sortColumn = 'price';
            $sortDirection = 'ASC';
            break;
        case 'price-desc':
            $sortColumn = 'price';
            $sortDirection = 'DESC';
            break;
        case 'name-asc':
            $sortColumn = 'name';
            $sortDirection = 'ASC';
            break;
        case 'name-desc':
            $sortColumn = 'name';
            $sortDirection = 'DESC';
            break;
        default:
            $sortColumn = null;
            $sortDirection = 'ASC';
            break;
    }

    $product = new Product();
    $products = $product->getAllProducts($sortColumn, $sortDirection);

    if ($products) {
        foreach ($products as $item) {
            ?>
                <div class="background-item product-item <?= $darkMode ? 'dark' : '' ?> bg-blue-100 dark:bg-gray-800 shadow-lg rounded-lg p-5 m-5 hover:scale-102 transition duration-300 ease-in-out">
                <ul class="flex flex-col">
                    <li>
                        <img src="./uploads/img/<?= $item['img']?>"alt="<?=$item['name']?>" class="w-50 h-50 object-cover rounded-md">
                    </li>
                    <li>
                        <h2 class="text-xl font-bold max-w-50 product-name"><?= $item['name']?></h2>
                    </li>
                    <li>
                        <p class="product-price">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>

                    </li>
                    <div class=" <?= $user ? '' : 'hidden' ?> flex">
                        <li class="<?= $admin ? '' : 'hidden' ?> flex">
                          <button class="editButton bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition duration-300   ease-in-out mr-4" data-item='<?= json_encode($item) ?>'><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                          <button onclick="if(confirm('Apakah anda yakin akan menghapus produk ini?')) { location.href='controllers/delete.php? id=<?= $item['id']?>'; }" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-red-600 transition duration-300     ease-in-out"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </li>
                        <li class="<?= $admin ? 'hidden' : '' ?> flex">
                          <button class="editButton bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition duration-300   ease-in-out mr-4" data-item='<?= json_encode($item) ?>'><i class="fa-solid fa-bag-shopping"></i> Beli</button>
                        </li>
                    </div>
                    <li>
                        <p>Stok: <?= $item['stock']?></p>
                    </li>
                </div>
            <?php
        }
    } else {
        echo "<p>No products found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
