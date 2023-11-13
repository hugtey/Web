<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hungtran");

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $query = "SELECT * FROM tbl_products WHERE uid = $uid";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Lỗi: " . mysqli_error($conn);
        exit;
    }
}

if (isset($_POST['update_product'])) {
    $name_product = $_POST['name_product'];
    $num_product = $_POST['num_product'];
    $price_product = $_POST['price_product'];

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '<script>alert("Chỉ chấp nhận file có định dạng JPG, JPEG, PNG & GIF");</script>';
            $uploadOk = 0;
        }
        if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $update_query = "UPDATE tbl_products SET name_product = '$name_product', num_product = $num_product,price_product = $price_product, image = '$target_file' WHERE uid = $uid";
            $update_result = mysqli_query($conn, $update_query);
            if ($update_result) {
                echo "Cập nhật sản phẩm thành công!";
                header("refresh:1; url = admin_product.php");
            } else {
                echo "Lỗi cập nhật sản phẩm: " . mysqli_error($conn);
            }
        }
    } else {
        // Nếu không có tệp ảnh mới, chỉ cập nhật thông tin sản phẩm
        $update_query = "UPDATE tbl_products SET name_product = '$name_product', num_product = $num_product, price_product = $price_product WHERE uid = $uid";
        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            echo "Cập nhật sản phẩm thành công!";
            header("refresh:1; url = admin_product.php");
        } else {
            echo "Lỗi cập nhật sản phẩm: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sửa sản phẩm</title>
</head>

<body>
    <h1>Sửa sản phẩm</h1>

    <form action="admin_edit_product.php?uid=<?php echo $uid; ?>" method="POST" enctype="multipart/form-data">
        Tên sản phẩm: <input type="text" name="name_product" value="<?php echo $product['name_product']; ?>" required><br>
        Số lượng: <input type="number" name="num_product" value="<?php echo $product['num_product']; ?>" required><br>
        Giá: <input type="number" name="price_product" value="<?php echo $product['price_product']; ?>" required> VNĐ<br>
        Ảnh: <input type="file" name="image"><br>
        <img src="<?php echo $product['image']; ?>" width="200px">
        <input type="submit" name="update_product" value="Cập nhật sản phẩm">
    </form>
</body>

</html>