<?php
session_start();
setcookie('username', '', time() - 3600, "/");

// Hủy bỏ phiên đăng nhập
session_unset();
session_destroy();

header('Location: index.php');
exit();
?>