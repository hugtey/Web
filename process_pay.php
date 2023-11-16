<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (isset($_POST['buy'])) {
    $uid = $_POST['uid'];
    $price_product = $_POST['price'];

    $query_user = "SELECT * FROM tbl_users WHERE uid = {$_SESSION['uid']}";
    $result_user = mysqli_query($conn, $query_user);
    $user = mysqli_fetch_assoc($result_user);

    if ($user['balance'] >= $price_product) {
        $new_balance = $user['balance'] - $price_product;
        $update_balance_query = "UPDATE tbl_users SET balance = $new_balance WHERE uid = {$_SESSION['uid']}";
        mysqli_query($conn, $update_balance_query);

        echo "<h1>Mua thành công!</h1>";
        echo "<a href='user.php'>Quay lại</a>";
    } else {
        echo "<h1>Không đủ tiền để mua sản phẩm!!!</h1>";
        echo "<a href='user.php'>Quay lại</a>";
    }
}
?>
