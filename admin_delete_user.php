<?php
include 'connect.php';

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $deleteQuery = "DELETE FROM tbl_users WHERE uid = $uid";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "Xóa người dùng thành công.";
    } else {
        echo "Lỗi xóa người dùng: " . mysqli_error($conn);
    }
}
?>

<br>
<a href="admin_user.php"> Quay lại</a>