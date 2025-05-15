<?php
session_start();
$user = isset($_SESSION['user']);
$admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

require_once(__DIR__ . '/models/Product.php');

$product = new Product();
$products = $product->getAllProducts();
$darkMode = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark';

$banners = [
    [
        "image" => "assets/img/bannermoca.png",
        "alt" => "Moondrop Moca",
    ],
    [
        "image" => "assets/img/bannerew300.png",
        "alt" => "SIMGOT EW300",
    ],
    [
        "image" => "assets/img/bannerbtr15.png",
        "alt" => "FIIO BTR15",
    ],
        [
        "image" => "assets/img/bannermay.png",
        "alt" => "MOONDROP MAY",
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>aitemshop.</title>
    <link href="assets/css/output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body class="<?= $darkMode ? 'dark' : '' ?> bg-blue-300 font-gabarito text-black dark:bg-blue-950 dark:text-white transition duration-300 ease-in-out">

<!-- message modal -->
<div id="messageModal" class="fixed inset-0 bg-black/50 flex items-center justify-center <?= $message ? '' : 'hidden' ?> z-50">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-[90%] max-w-md">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold" id="messageTitle">Notifikasi</h2>
    </div>
    <div id="messageContent" class="mb-6">
        <p><?= htmlspecialchars($message) ?></p>
    </div>
    <div class="flex justify-end">
      <button id="messageOk" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">OK</button>
    </div>
  </div>
</div>

    <!-- navigation bar -->
    <nav class="flex my-5 items-center justify-between mx-20">
        <div class="">
            <h1 class="text-2xl font-bold text-customblue">aitemshop.</h1>
        </div>
        <!-- search section -->
        <div class="flex flex-row items-center justify-center relative w-full max-w-md mx-auto">
            <div class="flex flex-col w-full relative">
                <div class="flex items-center bg-blue-100 dark:bg-gray-800 rounded border-gray-500 w-full transition duration-300 ease-in-out">
                    <i class="fa-solid fa-magnifying-glass px-3 text-black dark:text-white transition duration-300 ease-in-out"></i>
                    <input type="text" id="live-search" placeholder="Cari produk..." class="w-full p-2 rounded text-black dark:text-white bg-blue-100 dark:bg-gray-800 active:bg-blue-100 active:dark:bg-gray-800 focus:outline-none transition duration-300 ease-in-out" />
                </div>
                <!-- hasil search section -->
                <div id="search-results-dropdown" class="absolute top-full left-0 right-0 bg-blue-100 dark:bg-gray-800 rounded-b-lg shadow-lg mt-0      z-10 max-h-[70vh] overflow-y-auto hidden">
                    <div id="live-search-result" class="p-4">
                        <!-- hasil search -->
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center">
            <div class="<?= $user ? '' : 'hidden' ?>">
                <p class="mr-4">Halo, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
            </div>
            <div class="<?= $user ? '' : 'hidden' ?>">
                <button onclick="if(confirm('Apakah anda yakin ingin logout?')) { location.href='controllers/logout.php'; }" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-red-600 transition duration-300 ease-in-out">Logout</button>
            </div>
            <div class="<?= $user ? 'hidden' : '' ?>">
                <button onclick="location.href='login.php';" class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition duration-300 ease-in-out">Login</button>
            </div>
            <div id="to-dark-icon" class="<?= $darkMode ? 'hidden' : '' ?> hover:cursor-pointer pl-5">
                <i class="fa-solid fa-moon"></i>
            </div>
            <div id="to-light-icon" class="<?= $darkMode ? '' : 'hidden' ?> hover:cursor-pointer pl-4">
                <i class="fa-solid fa-sun"></i>
            </div>
        </div>
    </nav>

<!-- edit page popup -->
    <div id="productModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
      <div class="bg-blue-100 dark:bg-blue-950 p-6 rounded-lg w-[90%] max-w-md">
      <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Produk</h2>
        <form id="productForm" method="POST" enctype="multipart/form-data" action="">
          <input type="hidden" name="id" id="productId">
          <input type="hidden" name="oldImg" id="oldImg">

          <label class="block mb-2">Nama Produk</label>
          <input type="text" name="name" id="productName" class="w-full p-2 border mb-3 rounded" required>

          <label class="block mb-2">Harga</label>
          <input type="number" name="price" id="productPrice" class="w-full p-2 border mb-3 rounded" required>

          <label class="block mb-2">Stok</label>
          <input type="number" name="stock" id="productStock" class="w-full p-2 border mb-3 rounded" required>

          <label class="block mb-2">Gambar Produk</label>
          <input type="file" name="img" id="productImg" accept=".jpg,.jpeg,.png" class="mb-4 file:cursor-pointer file:bg-blue-600 file:p-1  file:rounded-md">

          <div class="flex justify-end gap-2">
            <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
          </div>
        </form>
      </div>
    </div>

<!-- buy page popup -->
    <div id="buyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
      <div class="bg-blue-100 dark:bg-blue-950 p-6 rounded-lg w-[90%] max-w-md">
      <h2 id="modalTitle" class="text-xl font-bold mb-4">Yakin ingin membeli barang ini?</h2>
      <h3 id="buyName" class=" text-lg"></h3>
        <form id="buyForm" method="POST" action="">
          <input type="hidden" name="id" id="buyId">
          <div class="flex justify-end gap-2">
            <button type="button" id="closeBuyModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Beli</button>
          </div>
        </form>
      </div>
    </div>


<!-- action section -->
    <div class="flex my-5 items-center justify-between mx-20">
    <button <?= $admin ? '' : 'disabled' ?> id="addButton" class="<?= $admin ? '' : 'opacity-0' ?> p-2 rounded-md bg-blue-500 text-white transition  duration-300 ease-in-out hover:bg-blue-600"><i class="fa-solid fa-plus"></i> Tambah produk baru</button>
       <div class="">
       <i class="fa-solid fa-filter"></i>
           <select id="sort-filter" class="rounded p-1 transition duration-300 ease-in-out <?= $darkMode ? 'dark' : '' ?> bg-blue-300  dark:bg-blue-950">
               <option value="default">Terlama ke Terbaru</option>
               <option value="price-asc">Harga: Rendah ke Tinggi</option>
               <option value="price-desc">Harga: Tinggi ke Rendah</option>
               <option value="name-asc">Nama: A ke Z</option>
               <option value="name-desc">Nama: Z ke A</option>
           </select>
       </div>
    </div>

 <!-- banner section -->
    <div class="banner-container flex align-middle justify-center flex-wrap">
        <?php foreach($banners as $index => $banner): ?>
            <img src="<?= $banner['image'] ?>" alt="<?= $banner['alt'] ?>" class="banner w-1/2 absolute opacity-0 transition-opacity duration-1000  drop-shadow-sm drop-shadow-black rounded-3xl">
        <?php endforeach; ?>
    </div>


    <!-- item section -->
    <div class="flex align-middle justify-center flex-wrap mt-70" id="product-list">
        <?php
            foreach($products as $item)  :
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
                            <button class="buyButton  rounded-md px-4 py-2  transition duration-300 ease-in-out mr-4 <?= $item['stock']> 0 ?    'bg-blue-500 hover:bg-blue-600 text-white cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed' ?>" 
                                data-item='<?= json_encode($item) ?>' 
                                <?= $item['stock'] > 0 ? '' : 'disabled' ?>>
                                <i class="fa-solid fa-bag-shopping"></i> Beli
                            </button>
                        </li>
                    </div>
                    <li>
                        <p>Stok: <?= $item['stock']?></p>
                    </li>
                </div>
            <?php
                endforeach
            ?>
    </div>

    <!-- footer section -->
     <div class="p-10 flex flex-col items-center justify-center">
     <h1 class="text-3xl font-bold m-2">aitemshop.</h1>
        <p class="text-xs">Copyright 2025, Andreas Calvin</p>
        <p class="text-xs">Semua hak cipta barang di website ini merujuk ke masing masing brand.</p>
        <p class="text-xs">Website ini bukanlah website jual beli sesungguhnya, melainkan hanya project yang ditujukan untuk keperluan pribadi</p>
     </div>
  </body>
</html>