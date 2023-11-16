<?php
session_start();
include 'connect.php';


if (isset($_POST['add_product'])) {
    $name_product = $_POST['name_product'];
    $num_product = $_POST['num_product'];
    $price_product = $_POST['price_product'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Chỉ chấp nhận file có định dạng JPG, JPEG, PNG & GIF";
        $uploadOk = 0;
    }

    if (!empty($name_product) && !empty($num_product) && !empty($price_product)) {
        $check_query = "SELECT * FROM tbl_products WHERE name_product='$name_product'";
        $result = $conn->query($check_query);
        $sql = "INSERT INTO `tbl_products` (`name_product`,`num_product`,`price_product`,`image`) VALUES ('$name_product','$num_product','$price_product','$target_file') ";

        if ($result->num_rows > 0) {
            echo "Sản phẩm đã tồn tại";
        } else {
            if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                if ($conn->query($sql) === TRUE) {
                    echo "Thêm sản phẩm thành công!!!!";
                } else {
                    echo "Lỗi {$sql}" . $conn->error;
                }
            }
        }
    } else {
        echo "Bạn cần nhập đầy đủ thông tin trước khi thêm sản phẩm!!";
    }
}

mysqli_close($conn);
?>
<br>
<a href="admin_product.php"> Quay lại</a>
