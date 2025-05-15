<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$darkMode = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - aitemshop.</title>
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
<body class="<?= $darkMode ? 'dark' : '' ?> font-gabarito bg-blue-300 text-black dark:bg-blue-950 dark:text-white transition duration-300 ease-in-out">
    <!-- navigation bar -->
    <nav class="flex my-5 items-center justify-between mx-20">
        <div class="">
            <h1 class="text-2xl font-bold">aitemshop.</h1>
        </div>
        <div id="to-dark-icon" class="<?= $darkMode ? 'hidden' : '' ?> hover:cursor-pointer pl-5">
            <i class="fa-solid fa-moon"></i>
        </div>
        <div id="to-light-icon" class="<?= $darkMode ? '' : 'hidden' ?> hover:cursor-pointer pl-4">
            <i class="fa-solid fa-sun"></i>
        </div>
    </nav>
    <div class="flex flex-col pt-10">
        <div class="flex align-middle justify-center flex-wrap">
        <div class="background-item <?= $darkMode ? 'dark' : '' ?> bg-blue-100 dark:bg-gray-800 shadow-lg rounded-lg p-5 m-5 transition duration-300 ease-in-out">
            <form action="controllers/registerController.php" method="POST" class="space-y-4">
                <div class="m-5 flex justify-between">
                    <h2 class=" text-2xl font-bold">Daftar akun</h2>
                </div>

                <div class="m-5 flex justify-between">
                    <p class=" text-sm">Sudah mempunyai akun? <a href='./login.php' id="other-opt" class="<?= $darkMode ? 'dark' : '' ?> text-blue-800 dark:text-blue-200 text-sm  hover:cursor-pointer text-amber transition duration-300 ease-in-out">Login</a></p>
                </div>

                <div class="m-5 flex flex-col justify-between">
                    <label for="name" class="">Username</label>  
                    <input name="name" type="name" id="name" class="border-2 border-gray-600 rounded-md p-1" required>
                </div>

                <div class="m-5 flex flex-col justify-between">
                    <label for="password" class="">Password</label>  
                    <input name="password" type="password" id="password" class="border-2 border-gray-600 rounded-md p-1" required>
                </div>

                <div class="m-5 flex flex-col justify-between">
                    <label for="passwordConfirm" class="">Konfirmasi Password</label>  
                    <input name="passwordConfirm" type="password" id="passwordConfirm" class="border-2 border-gray-600 rounded-md p-1" required>
                </div>

                <div class="m-5 align-center justify-center ">
                    <button type="submit" name="submit" class="rounded-md p-2 text-white cursor-pointer bg-blue-500 hover:bg-blue-600 w-full transition duration-300 ease-in-out">Daftar</button>
                </div>
            </form>
        </div>
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
