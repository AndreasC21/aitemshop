<?php
require_once(__DIR__ . '/../models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $username = $_POST['name'];
    $password = $_POST['password'];

    #cek username ada di database
    $data = $user->getUserByUsername($username);
    if(!$data) {
        echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
        exit();
    }

    #cek apakah password benar
    if(password_verify($password, $data['password'])) {
       session_start();
       if ($data['admin'] == '1') {
           $_SESSION['role'] = 'admin';
       } else {
           $_SESSION['role'] = 'user';
       }
       $_SESSION['user'] = $data['name'];
       echo "<script>window.location.href = '../index.php';</script>";
       exit();
    } else {
        echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
        exit();
    }
}

?>