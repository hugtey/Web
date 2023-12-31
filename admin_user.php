<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (!isset($_SESSION['uid']) && !isset($_COOKIE['token'])) {
    header('Location: index.php');
    exit();
}

// Nếu có cookie token, kiểm tra và xác định vai trò của người dùng
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $sql_check_token = "SELECT * FROM tbl_users WHERE token = '$token'";
    $result_check_token = mysqli_query($conn, $sql_check_token);

    if (mysqli_num_rows($result_check_token) > 0) {
        $row_token = mysqli_fetch_assoc($result_check_token);

        if ($row_token['role'] == 'user') {
            header('Location: user.php');
            exit();
        }
    } else {
        // Nếu không tìm thấy thông tin từ token, đăng xuất và chuyển hướng đến trang đăng nhập
        header('Location: logout.php');
        exit();
    }
}
if (isset($_GET['fullname'])) {
    $fullname = $_GET['fullname'];
    $query = "SELECT * FROM tbl_users WHERE fullname LIKE '%$fullname%'";
} else {
    $query = "SELECT * FROM tbl_users";
}
$result = mysqli_query($conn, $query);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Admin
    </title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h1> Danh sách người dùng</h1>
        <div class="logout">
            <a href="logout.php">Đăng xuất</a>
        </div>
        <div class="logout">
            <a href="admin_product.php">Quản lý sản phẩm</a>
        </div>
        <form>
            <div class="btn btn-primary" value="">
            Thêm người dùng
            </div>
        </form>

        <br><br><br><br>
        <div class="wrap">
            <form action="" class="search">
                <input type="text" name="fullname" class="searchTerm" placeholder="Bạn muốn tìm ai?">
                <button type="submit" class="searchButton" id="search">
                    Tìm Kiếm
                </button>
            </form>
        </div>
        <br>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th> ID </th>
                    <th> Họ và tên </th>
                    <th> Gmail </th>
                    <th> Giới tính </th>
                    <th> Hạng tài khoản </th>
                    <th> Vai trò </th>
                    <th> Số dư tài khoản </th>
                    <th> Thao tác </th>
                </tr>
            </thead>
            <?php


            while ($r = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $r['uid']; ?></td>
                    <td><?php echo $r['fullname']; ?></td>
                    <td><?php echo $r['email']; ?></td>
                    <td><?php echo $r['gender']; ?></td>
                    <td><?php echo $r['rank']; ?></td>
                    <td><?php echo $r['role']; ?></td>
                    <td><?php echo $r['balance']; ?></td>
                    <td>
                        <a href="admin_edit_user.php?uid=<?php echo $r['uid']; ?>" class="btn btn-primary">Sửa</a>
                        <a onclick="return confirm('Bạn có muốn xóa không ?')" href="admin_delete_user.php?uid=<?php echo $r['uid']; ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <div id="wrapper">
            <form action="admin_add_user.php" method="post" id="form-signup">
                <h1 class="form-heading">Thêm người dùng</h1>
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
                    <h2>Nam</h2>
                    <input type="radio" name="gender" value="female">
                    <h2>Nữ</h2>
                </div>
                <div class="form-group">
                    <i class="far fa-user"></i>
                    <label class="form-input" for="">Hạng tài khoản: </label>
                    <input type="radio" name="rank" value="gold">
                    <h2>Vàng</h2>
                    <input type="radio" name="rank" value="silver">
                    <h2>Bạc</h2>
                    <input type="radio" name="rank" value="bronze">
                    <h2>Đồng</h2>
                    <input type="radio" name="rank" value="no rank">
                    <h2>Không có</h2>
                </div>
                <div class="form-group">
                    <i class="far fa-user"></i>
                    <label class="form-input" for="">Hạng tài khoản: </label>
                    <input type="radio" name="role" value="admin">
                    <h2>admin</h2>
                    <input type="radio" name="role" value="user">
                    <h2>user</h2>
                </div>
                <div class="form-group">
                    <i class="far fa-user"></i>
                    <input type="number" class="form-input" name="balance" placeholder="Số dư tài khoản">
                </div>

                <input type="submit" name="submit" value="Thêm" class="form-submit">
                <p class="close">X</p>
            </form>
        </div>

        <body>
            <script>
                const close = document.querySelector(".close")
                const btnadd = document.querySelector(".btn-primary")
                const wrapper = document.getElementById("wrapper")
                btnadd.onclick = function() {
                    wrapper.style.display = "flex";
                }
                close.onclick = function() {
                    wrapper.style.display = "none";
                }
                // wrapper.onclick = function() {
                //     wrapper.style.display = "none";
                // }
                window.onclick = function(event) {
                    if (event.target == wrapper) {
                        wrapper.style.display = "none";
                    }
                }
            </script>
            <html>