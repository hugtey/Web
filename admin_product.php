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
            header('Location: admin_product.php');
            exit();
        }
    } else {
        // Nếu không tìm thấy thông tin từ token, đăng xuất và chuyển hướng đến trang đăng nhập
        header('Location: logout.php');
        exit();
    }
}

if (isset($_GET['name_product'])) {
    $name_product = $_GET['name_product'];
    $query = "SELECT * FROM tbl_products WHERE name_product LIKE '%$name_product%'";
} else {
    $query = "SELECT * FROM tbl_products";
}
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Sản phẩm</title>
</head>

<body>
    <h1>Sản phẩm</h1>
    <div style="position: fixed; top: 10px; right: 150px; background-color: #0074D9; color: #fff; padding: 10px 20px;">
        <a href="admin_user.php" style="text-decoration: none; color: #fff;">Quản lý người dùng</a>
    </div>
    <div style="position: fixed; top: 10px; right: 10px; background-color: #0074D9; color: #fff; padding: 10px 20px;">
        <a href="logout.php" style="text-decoration: none; color: #fff;">Đăng xuất</a>
    </div>
    <h2>Thêm sản phẩm</h2>
    <form action="admin_add_product.php" method="POST" enctype="multipart/form-data">
        Tên sản phẩm: <input type="text" name="name_product" required><br>
        Số lượng: <input type="number" name="num_product" required><br>
        Giá: <input type="number" name="price_product" required> VNĐ<br>
        Ảnh: <input type="file" name="image"><br>
        <input type="submit" name="add_product" value="Thêm sản phẩm">
    </form>


    <h2>Danh sách sản phẩm</h2>
    <form action="" class="search">
        <input type="text" name="name_product" class="searchTerm" placeholder="Bạn muốn tìm sản phẩm nào?">
        <button type="submit" class="searchButton" id="search">
            Tìm Kiếm
        </button>
    </form>
    <table>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Tùy chọn</th>
        </tr>

        <?php


        while ($r = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $r['name_product']; ?></td>
                <td><?php echo $r['num_product']; ?></td>
                <td><?php echo number_format($r['price_product'], 0, ',', '.'); ?></td>
                <td>
                    <img src="<?php echo $r['image']; ?>" width="200px">
                </td>
                <td>
                <a href="admin_edit_product.php?uid=<?php echo $r['uid']; ?>" class="btn btn-primary">Sửa</a>
                <a onclick="return confirm('Bạn có muốn xóa không ?')" href="admin_delete_product.php?uid=<?php echo $r['uid']; ?>" class="btn btn-danger">Xóa</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>




<style>
    .btn {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        color: #fff;
        background-color: #28a745;
        border-radius: 5px;
        transition: background-color 0.3s;
        margin-right: 10px;
    }

    .btn:hover {
        background-color: #218838;
    }
</style>
</html>