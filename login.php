<?php

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
        if ($row['username'] == 'admin') {
          setcookie("username", $username, time() + 3600, '/', '', 0, 0);
          setcookie("password", $password, time() + 3600, '/', '', 0, 0);
          header('Location: admin_product.php');
        } else {
          setcookie("username", $username, time() + 3600, '/', '', 0, 0);
          setcookie("password", $password, time() + 3600, '/', '', 0, 0);
          header('Location: user.php');
        }
      }
  } else {
    setcookie("username", '', time() - 3600, '/', '', 0, 0);
    setcookie("password", '', time() - 3600, '/', '', 0, 0);
    while ($row = mysqli_fetch_assoc($result))
      if (mysqli_num_rows($result) > 0) {
        if ($row['username'] == 'admin') {
          header('Location: admin_product.php');
        } else {
          header('Location: user.php');
        }
      }
  }
  mysqli_close($conn);
}
?>


<br>
<a href="index.php"> Quay lại form</a>