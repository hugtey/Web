<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

$uid = $_SESSION['uid'];

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
            echo "<a href='edit.php?uid={$product['uid']}' class='btn btn-primary'>Thêm vào giỏ hàng</a>";
            echo "<a onclick='return confirm(\"Bạn có muốn xóa không ?\")' href='admin_delete_product.php?uid={$product['uid']}' class='btn btn-danger'>Mua</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    while ($r = mysqli_fetch_assoc($result_user)) {
    ?>
        <div style="position: fixed; top: 10px; right: 150px; background-color: #0074D9; color: #fff; padding: 10px 20px;">
            <a href="user_edit.php?uid=<?php echo $r['uid']; ?>" style="text-decoration: none; color: #fff;">Sửa thông tin người dùng</a>
        </div>
    <?php
    }
    ?>
</body>

</html>