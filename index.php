

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <title>hugtey</title>
</head>

<body>
  <div id="wrapper">

  <?php
    session_start();
    include 'connect.php';
    if (isset($_COOKIE['token'])) {
      $token = $_COOKIE['token'];
      $sql_check_token = "SELECT * FROM tbl_users WHERE token = '$token'";
      $result_check_token = mysqli_query($conn, $sql_check_token);
      if (mysqli_num_rows($result_check_token) > 0) {
        $row_token = mysqli_fetch_assoc($result_check_token);
        if ($row_token['role'] == 'admin') {
          header('Location: admin_product.php');
          exit();
        } else {
          header('Location: user.php');
          exit();
        }
      }
    }

    mysqli_close($conn);
  ?>
  
    <form action="register.php" method="POST" id="form-signup">
      <h1 class="form-heading">Form đăng ký</h1>
      <div class="form-group">
        <i class="far fa-user"></i>
        <input type="text" class="form-input" name="fullname" placeholder="Họ và tên">
      </div>
      <div class="form-group">
        <i class="far fa-user"></i>
        <input type="text" class="form-input" name="username" placeholder="Tên đăng nhập">
      </div>
      <div class="form-group">
        <i class="fas fa-key"></i>
        <input type="password" class="form-input" name="password" placeholder="Mật khẩu">
      </div>
      <div class="form-group">
        <i class="far fa-user"></i>
        <input type="email" class="form-input" name="email" placeholder="Gmail">
      </div>

      <div class="form-group">
        <i class="far fa-user"></i>
        <label class="form-input" for="">Giới tính: </label>
        <input type="radio" name="gender" value="male">
        <h2 style="color: white;">Nam</h2>
        <input type="radio" name="gender" value="female">
        <h2 style="color: white;">Nữ</h2>
      </div>

      <input type="submit" name="submit" value="Đăng ký" class="form-submit">
    </form>

    <form action="login.php" method="POST" id="form-login">
      <h1 class="form-heading">Form đăng nhập</h1>
      <div class="form-group">
        <i class="far fa-user"></i>
        <input type="text" class="form-input" name="username" value="<?php if (isset($_COOKIE['username'])) echo $_COOKIE['username'];  ?>" placeholder="Tên đăng nhập">
      </div>
      <div class="form-group">
        <i class="fas fa-key"></i>
        <input type="password" class="form-input" name="password" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>" placeholder="Mật khẩu">
      </div>
      <div class="remember-cookie" style="color: white;">
        <input type="checkbox" name="remember" value="1">Ghi nhớ đăng nhập
      </div>
      <input type="submit" name="submit" value="Đăng nhập" class="form-submit1">
    </form>

  </div>

</body>

</html>

