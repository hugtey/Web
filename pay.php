<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $query_product = "SELECT * FROM tbl_products WHERE uid = $uid";
    $result_product = mysqli_query($conn, $query_product);
    $selectedProduct = mysqli_fetch_assoc($result_product);
}

$query_user = "SELECT * FROM tbl_users WHERE uid = {$_SESSION['uid']}";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

$discount = 0;
if ($user['rank'] == 'gold') {
    $discount = 0.3;
} elseif ($user['rank'] == 'silver') {
    $discount = 0.2;
} elseif ($user['rank'] == 'bronze') {
    $discount = 0.1;
}

$discounted_price = $selectedProduct['price_product'] - ($selectedProduct['price_product'] * $discount);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="user.css">
    <title>Thanh toán</title>
    <style>
        button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            width: 200px;
            display: inline-block;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            border: none;
        }

        button:hover {
            background-color: #218838;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="user-info">
        <p class="rank">Hạng tài khoản: <?php echo $user['rank']; ?></p>
        <p class="balance">Số dư tài khoản: <?php echo number_format($user['balance'], 0, ',', '.'); ?> VND</p>
    </div>
    <h1>Thanh toán</h1>
    <p>Giảm giá dựa trên hạng tài khoản:</p>
    <ul>
        <li>Rank Gold: Giảm 30%</li>
        <li>Rank Silver: Giảm 20%</li>
        <li>Rank Bronze: Giảm 10%</li>
    </ul>
    <div class="selected-product">
        <h2>Thông tin sản phẩm</h2>
        <img src="<?php echo $selectedProduct['image']; ?>" alt="Selected Product" width="200px">
        <p>Tên sản phẩm: <?php echo $selectedProduct['name_product']; ?></p>
        <p>Giá tiền: <?php echo number_format($selectedProduct['price_product'], 0, ',', '.'); ?> VND</p>
    </div>
    <p>Giá sau khi giảm giá: <?php echo number_format($discounted_price, 0, ',', '.'); ?> VND</p>
    <form method="post" action="process_pay.php">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>">
        <input type="hidden" name="price" value="<?php echo $discounted_price; ?>">
        <button type="submit" name="buy">Mua</button>
    </form>
</body>
</html>