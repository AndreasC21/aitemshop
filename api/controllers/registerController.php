<?php
require_once(__DIR__ . '/../models/Product.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $username = $_POST['name'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    #cek apakah password sama dengan password konfirmasi
    if(!checkPassword($password, $passwordConfirm)) {
        return false;
    }

    #cek apakah username belum pernah dipakai
    if ($user->checkUsername($username)) {
        $_SESSION['message'] = "Username sudah digunakan!";
        header("Location: /register.php");
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $user->createUser($username, $passwordHash);
    $_SESSION['message'] = "Registrasi berhasil! Silakan login";
    header("Location: /login.php");
    exit();
}

function checkPassword($password, $passwordConfirm) {
    if ($password !== $passwordConfirm) {
        $_SESSION['message'] = "Password tidak sama!";
        header("Location: /register.php");
        exit();
    }
    if (strlen($password) < 8) {
        $_SESSION['message'] = "Password minimal 8 karakter!";
        header("Location: /register.php");
        exit();
    }
    return true;
}

?>