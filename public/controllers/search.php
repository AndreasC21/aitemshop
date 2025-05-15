<?php
require_once(__DIR__ . '/../models/Product.php');
session_start();
$darkMode = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark';
$user = isset($_SESSION['user']);
$admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $product = new Product();
    $result = $product->searchProduct($keyword);

    if ($result === false) {
        echo '<p class="text-gray-400 p-2">Tidak ada hasil ditemukan.</p>';
    } else {
        ?>
        <div class="grid grid-cols-1 gap-4">
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-2 last:border-0">
                    <img src="./uploads/img/<?= htmlspecialchars($item['img']) ?>" class="w-16 h-16 object-cover rounded-md mr-3">
                    <div class="flex flex-col flex-grow">
                        <h3 class="font-bold text-black dark:text-white"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-black dark:text-white">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>
                        <div class="flex mt-2">
                            <div class=" <?= $user ? '' : 'hidden' ?> flex">
                                <li class="<?= $admin ? '' : 'hidden' ?> flex">
                                    <button class="editButton bg-blue-500 text-white rounded-md px-2 py-1 text-sm hover:bg-blue-600 transition  duration-300 ease-in-out mr-2" data-item='<?= json_encode($item) ?>'>
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button onclick="if(confirm('Apakah anda yakin akan menghapus produk ini?')) { location.href='controllers/  delete.php?id=<?= $item['id']?>'; }" class="bg-red-500 text-white rounded-md px-2 py-1 text-sm    hover:bg-red-600 transition duration-300 ease-in-out">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </li>
                                <li class="<?= $admin ? 'hidden' : '' ?> flex">
                                    <button class="buyButton rounded-md px-2 py-1 text-sm transition duration-300 ease-in-out <?= $item['stock'] >  0 ? 'bg-blue-500 hover:bg-blue-600 text-white cursor-pointer' : 'bg-gray-200 text-gray-400   cursor-not-allowed' ?>" 
                                        data-item='<?= json_encode($item) ?>' 
                                        <?= $item['stock'] > 0 ? '' : 'disabled' ?>>
                                        <i class="fa-solid fa-bag-shopping"></i> Beli
                                    </button>
                                </li>
                            </div>
                            <p class="ml-auto text-sm">Stok: <?= $item['stock'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
    }
}
?>