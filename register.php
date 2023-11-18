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
        $sql = "INSERT INTO `tbl_users` (`fullname`,`username`,`password`,`email`,`gender`,`rank`,`role`) VALUES ('$fullname','$username','$password','$email','$gender', 'no rank','user') ";
        if ($result->num_rows > 0) {
            echo "Tài khoản đã có người sử dụng, vui lòng chọn tài khoản khác!";
        } else {
            if ($conn->query($sql) === TRUE) {
                echo "Đăng ký thành công!!!!";
            } else {
                echo "Lỗi {$sql}" . $conn->error;
            }
        }
    } else {
        echo "Bạn cần nhập đầy đủ thông tin trước khi đăng ký";
    }
}

mysqli_close($conn);
?>
<br>
<a href="index.php"> Quay lại trang chủ</a>