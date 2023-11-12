<?php
include 'connect.php';
if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    if (!empty($username) && !empty($fullname) && !empty($password) && !empty($email) && !empty($gender)) {
        $check_query = "SELECT * FROM tbl_users WHERE username='$username'";
        $result = $conn->query($check_query);
        $sql = "INSERT INTO `tbl_users` (`fullname`,`username`,`password`,`email`,`gender`) VALUES ('$fullname','$username','$password','$email','$gender') ";
        if ($result->num_rows > 0) {
            echo "Tài khoản đã có người sử dụng, vui lòng chọn tài khoản khác!";
        } else {
            if ($conn->query($sql) === TRUE) {
                echo "Thêm người dùng thành công!!!!";
            } else {
                echo "Lỗi {$sql}" . $conn->error;
            }
        }
    } else {
        echo "Bạn chưa nhập đủ thông tin ";
    }
}

mysqli_close($conn);
?>
<br>
<a href="admin_user.php"> Quay lại</a>
