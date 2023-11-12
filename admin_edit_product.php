<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "hungtran");


if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $edit_sql = "SELECT * FROM tbl_products WHERE uid=$uid";
    $result = mysqli_query($conn, $edit_sql);
    $row = mysqli_fetch_assoc($result);
}
if (isset($_POST['name_product']) && isset($_POST['num_product']) && isset($_POST['price_product']) && isset($_POST['image'])) {
    $name_product = $_POST['name_product'];
    $num_product = $_POST['num_product'];
    $price_product = $_POST['price_product'];
    $image = $_POST['image'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    $updatesql = "UPDATE tbl_products SET name_product='$name_product', num_product='$num_product', price_product='$price_product', image='$target_file' WHERE uid='$uid'";
    $conn = mysqli_connect("localhost", "root", "", "hungtran");
    if (mysqli_query($conn, $updatesql)) {
        header("Location: admin_product.php");
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
        Edit sản phẩm
    </title>
</head>

<body>
    <div class="container">
        <h1>
            Sửa thông tin sản phẩm

            <form action="admin_edit_product.php" method="POST">
                <input type="hidden" name="uid" value="<?php echo $uid; ?>" id="" />
                <div class="form-group">
                    <label for="name_product"> Tên sản phẩm </label>
                    <input type="text" name="name_product" class="form-control" value="<?php echo $row['name_product'] ?>">
                </div>
                <div class="form-group">
                    <label for="num_product"> Số lượng </label>
                    <input type="text" name="num_product" class="form-control" value="<?php echo $row['num_product'] ?>">
                </div>
                <div class="form-group">
                    <label for="price_product"> Giá </label>
                    <input type="text" name="price_product" class="form-control" value="<?php echo $row['price_product'] ?>">
                </div>
                <label for="image"> Ảnh </label>
                <input type="file" name="fileToUpload" class="form-control" value="<?php echo $row['image'] ?>">
                <img src="<?php echo $row['image']; ?>" width="200px">
    </div>

    </div>
    <button class="btn btn-success"> Update sản phẩm </button>
    </form>
    </h1>

    </div>
</body>

</html>