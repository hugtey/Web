<?php
session_start();
include 'connect.php';

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password' ";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['uid'] = $row['uid'];
    $_SESSION['username'] = $row['username'];
    if (isset($_POST['remember']) && $_POST['remember'] == 1) {
      $token = uniqid(); // Tạo một token ngẫu nhiên
      setcookie('username', $username, time() + 3600 * 24 * 30, "/");
      setcookie('token', $token, time() + 3600 * 24 * 30, "/");
      $uid = $row['uid'];
      $sql_update_token = "UPDATE tbl_users SET token = '$token' WHERE uid = '$uid'";
      mysqli_query($conn, $sql_update_token);
    } else {
      // Nếu không chọn "Ghi nhớ đăng nhập", xóa cookie token nếu có
      setcookie('token', "", time() - 3600, "/");
    }

    if ($row['role'] == 'admin') {
      header('Location: admin_product.php');
    } else {
      header('Location: user.php');
    }
  } else {
    // Xử lý khi thông tin đăng nhập không chính xác
    header('Location: index.php'); // Chuyển hướng về trang đăng nhập
  }
}


mysqli_close($conn);
?>
<br>
<a href="index.php"> Quay lại form</a>