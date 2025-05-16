<?php
require_once(__DIR__ . '/../models/Product.php');

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
        echo "<script>alert('Username sudah digunakan!'); window.history.back();</script>";
        return false;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);


    $user->createUser($username, $passwordHash);
    header("Location: ../login.php");
    exit();
}

function checkPassword($password, $passwordConfirm) {
    if ($password !== $passwordConfirm) {
        echo "<script>alert('Password tidak sama!'); window.history.back();</script>";
        return false;
    }
    if (strlen($password) < 8) {
        echo "<script>alert('Password minimal 8 karakter!'); window.history.back();</script>";
        return false;
    }
    return true;
}

?>