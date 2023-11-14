<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (isset($_GET['name_product'])) {
    $name_product = $_GET['name_product'];
    $query_product = "SELECT * FROM tbl_products WHERE name_product LIKE '%$name_product%'";
} else {
    $query_product = "SELECT * FROM tbl_products";
}

$result_product = mysqli_query($conn, $query_product);


$query_user = "SELECT * FROM tbl_users";
$result_user = mysqli_query($conn, $query_user);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Sản phẩm</title>
</head>

<body>
    <h1>Sản phẩm</h1>
    <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>">
    <div style="position: fixed; top: 10px; right: 10px; background-color: #0074D9; color: #fff; padding: 10px 20px;">
        <a href="index.php" style="text-decoration: none; color: #fff;">Đăng xuất</a>
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
            <th>Tùy chọn</th>
        </tr>
        <?php
        while ($product = mysqli_fetch_assoc($result_product)) {
            // Hiển thị thông tin sản phẩm
            echo "<tr>";
            echo "<td>{$product['name_product']}</td>";
            echo "<td>{$product['num_product']}</td>";
            echo "<td>{$product['price_product']}</td>";
            echo "<td><img src='{$product['image']}' width='200px'></td>";
            echo "<td>";
            echo "<a href='cart.php?uid={$product['uid']}' class='btn btn-primary'>Thêm vào giỏ hàng</a>";
            echo "<a href='edit.php?uid={$product['uid']}' class='btn btn-primary'>Mua</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "<tr>";
        echo "<td><a href='user_edit.php?uid={$_SESSION['uid']}' style='position:fixed; top: 10px; right: 150px; background-color: #0074D9;color: #fff;text-decoration: none;padding: 5px 10px;border-radius: 5px;display: inline-block;transition: background-color 0.3s;'onmouseover='this.style.backgroundColor=\"#0056b3\"' onmouseout='this.style.backgroundColor=\"#0074D9\"'>Sửa thông tin người dùng</a></td>";
        echo "</tr>";
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