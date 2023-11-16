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
      setcookie('username', $username, time() + 3600 * 24 * 30, "/");
      if ($row['username'] == 'admin') {
        header('Location: admin_product.php');
      } else {
        header('Location: user.php');
      }
    } else {
      if ($row['username'] == 'admin') {
        header('Location: admin_product.php');
      } else {
        header('Location: user.php');
      }
    }
  }
}
mysqli_close($conn);
?>
<br>
<a href="index.php"> Quay lại form</a>