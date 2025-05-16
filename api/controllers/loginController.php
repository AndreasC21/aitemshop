<?php
require_once(__DIR__ . '/../models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $username = $_POST['name'];
    $password = $_POST['password'];

    session_start();

    #cek username ada di database
    $data = $user->getUserByUsername($username);
    if(!$data) {
        $_SESSION['message'] = "Username atau password salah!";
        header("Location: /login.php");
        exit();
    }

    #cek apakah password benar
    if(password_verify($password, $data['password'])) {
       if ($data['admin'] == '1') {
           $_SESSION['role'] = 'admin';
       } else {
           $_SESSION['role'] = 'user';
       }
       $_SESSION['user'] = $data['name'];
       header("Location: /index.php");
       exit();
       
    } else {
        $_SESSION['message'] = "Username atau password salah!";
        header("Location: /login.php");
        exit();
    }
}

?>