<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (!isset($_SESSION['uid']) && !isset($_COOKIE['token'])) {
    header('Location: index.php');
    exit();
}

// Nếu có cookie token, kiểm tra và xác định vai trò của người dùng
if (!isset($_SESSION['uid']) && isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $sql_check_token = "SELECT * FROM tbl_users WHERE token = '$token'";
    $result_check_token = mysqli_query($conn, $sql_check_token);
    if (mysqli_num_rows($result_check_token) > 0) {
        $row_token = mysqli_fetch_assoc($result_check_token);

        $_SESSION['uid'] = $row_token['uid'];
        $_SESSION['username'] = $row_token['username'];
        $_SESSION['role'] = $row_token['role'];

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
if (isset($_GET['name_product'])) {
    $name_product = $_GET['name_product'];
    $query_product = "SELECT * FROM tbl_products WHERE name_product LIKE '%$name_product%'";
} else {
    $query_product = "SELECT * FROM tbl_products";
}

$result_product = mysqli_query($conn, $query_product);


$query_user = "SELECT * FROM tbl_users WHERE uid = {$_SESSION['uid']}";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="user.css">
    <title>Sản phẩm</title>
</head>

<body>
    <div class="user-info">
        <p class="rank">Hạng tài khoản: <?php echo $user['rank']; ?></p>
        <p class="balance">Số dư tài khoản: <?php echo number_format($user['balance'], 0, ',', '.');?> VNĐ</p>
    </div>
    <h1>Sản phẩm</h1>
    <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>">
    <div style="position: fixed; top: 10px; right: 10px; background-color: #0074D9; color: #fff; padding: 10px 20px;">
        <a href="logout.php" style="text-decoration: none; color: #fff;">Đăng xuất</a>
    </div>
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
        while ($product = mysqli_fetch_assoc($result_product)) {
            // Hiển thị thông tin sản phẩm
            echo "<tr>";
            echo "<td>{$product['name_product']}</td>";
            echo "<td>{$product['num_product']}</td>";
            echo "<td>" . number_format($product['price_product'], 0, ',', '.') . "</td>";
            echo "<td><img src='{$product['image']}' width='200px'></td>";
            echo "<td>";
            echo "<a href='pay.php?uid={$product['uid']}' class='btn btn-primary'>Mua</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "<tr>";
        echo "<td><a href='user_edit.php?uid={$_SESSION['uid']}' style='position:fixed; top: 10px; right: 150px; background-color: #0074D9;color: #fff;text-decoration: none;padding: 5px 10px;border-radius: 5px;display: inline-block;transition: background-color 0.3s;'onmouseover='this.style.backgroundColor=\"#0056b3\"' onmouseout='this.style.backgroundColor=\"#0074D9\"'>Sửa thông tin người dùng</a></td>";
        echo "</tr>";
        ?>
    </table>
</body>
</html>