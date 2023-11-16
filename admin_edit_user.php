<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");


if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit();
}
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $edit_sql = "SELECT * FROM tbl_users WHERE uid=$uid";
    $result = mysqli_query($conn, $edit_sql);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['gender'])) {
    $fullname = $_POST['fullname'];
    $newUsername = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $rank = $_POST['rank'];
    $balance = $_POST['balance'];
    $uid = $_POST['uid'];

    // Kiểm tra xem tên người dùng mới có bị trùng không
    $checkUsernameSql = "SELECT uid FROM tbl_users WHERE username='$newUsername' AND uid != $uid";
    $checkResult = mysqli_query($conn, $checkUsernameSql);
    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Tên người dùng đã tồn tại. Vui lòng chọn một tên người dùng khác");</script>';
    } else {
        $updatesql = "UPDATE tbl_users SET fullname='$fullname', username='$newUsername', password='$password', gender='$gender', rank='$rank', email='$email', balance='$balance' WHERE uid='$uid'";
        if (mysqli_query($conn, $updatesql)) {
            header("Location: admin_user.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Edit người dùng
    </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>
            Sửa thông tin người dùng

            <form action="admin_edit_user.php" method="post">
                <input type="hidden" name="uid" value="<?php echo $uid; ?>" id="" />
                <div class="form-group">
                    <label for="fullname"> Họ và tên </label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname'] ?>">
                </div>
                <div class="form-group">
                    <label for="username"> Tài khoản </label>
                    <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>">
                </div>
                <div class="form-group">
                    <label for="lop"> Mật khẩu </label>
                    <input type="text" name="password" class="form-control" value="<?php echo $row['password'] ?>">
                </div>
                <div class="form-group">
                    <label for="gender"> Giới tính </label>
                    <h2>Nam</h2>
                    <input type="radio" name="gender" value="male" <?php echo ($row['gender'] == 'male') ? 'checked' : ''; ?>>
                    <h2>Nữ</h2>
                    <input type="radio" name="gender" value="female" <?php echo ($row['gender'] == 'female') ? 'checked' : ''; ?>>
                <div class="form-group">
                    <label for="rank"> Hạng tài khoản </label>
                    <h2>Vàng</h2>
                    <input type="radio" name="rank" value="gold" <?php echo ($row['rank'] == 'gold') ? 'checked' : ''; ?>>
                    <h2>Bạc</h2>
                    <input type="radio" name="rank" value="silver" <?php echo ($row['rank'] == 'silver') ? 'checked' : ''; ?>>
                    <h2>Đồng</h2>
                    <input type="radio" name="rank" value="bronze" <?php echo ($row['rank'] == 'bronze') ? 'checked' : ''; ?>>
                
                <div class="form-group">
                        <label for="email"> Gmail </label>
                        <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>">
                    </div>
                </div>
                <div class="form-group">
                        <label for="email"> Số dư tài khoản </label>
                        <input type="text" name="balance" class="form-control" value="<?php echo $row['balance'] ?>">
                    </div>
                </div>
                <button class="btn btn-success"> Update người dùng </button>
            </form>
        </h1>

    </div>
</body>

</html>