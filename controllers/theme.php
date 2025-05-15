<?php
$theme = ($_COOKIE['theme'] ?? 'light') === 'dark' ? 'light' : 'dark';
setcookie('theme', $theme, time() + (86400 * 30), "/");

header("Location: ../index.php");
exit;
?>