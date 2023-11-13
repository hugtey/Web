<?php
session_start();
include 'connect.php';



if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);


  // Truy vấn dữ liệu từ bảng
  $sql = "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password' ";
  $result = mysqli_query($conn, $sql);

  if (isset($_POST['remember'])) {
    while ($row = mysqli_fetch_assoc($result))
      if (mysqli_num_rows($result) > 0) {
        $_SESSION['uid'] = $row['uid'];
        $_SESSION['username'] = $row['username'];
        if ($row['username'] == 'admin') {
          setcookie("username", $username, time() + 3600, '/', '', 0, 0);
          setcookie("password", $password, time() + 3600, '/', '', 0, 0);
          header('Location: admin_product.php');
          exit();
        } else {
          setcookie("username", $username, time() + 3600, '/', '', 0, 0);
          setcookie("password", $password, time() + 3600, '/', '', 0, 0);
          header('Location: user.php');
          exit();
        }
      }
  } else {
    setcookie("username", '', time() - 3600, '/', '', 0, 0);
    setcookie("password", '', time() - 3600, '/', '', 0, 0);
    while ($row = mysqli_fetch_assoc($result))
      if (mysqli_num_rows($result) > 0) {
        $_SESSION['uid'] = $row['uid'];
        $_SESSION['username'] = $row['username'];
        if ($row['username'] == 'admin') {
          header('Location: admin_product.php');
          exit();
        } else {
          header('Location: user.php');
          exit();
        }
      }
  }
  mysqli_close($conn);
}
?>


<br>
<a href="index.php"> Quay lại form</a>