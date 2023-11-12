<?php
include 'connect.php';

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $deleteQuery = "DELETE FROM tbl_products WHERE uid = $uid";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "Xóa sản phẩm thành công!!";
    } else {
        echo "Lỗi xóa sản phẩm: " . mysqli_error($conn);
    }
}
?>

<br>
<a href="admin_product.php"> Quay lại</a>