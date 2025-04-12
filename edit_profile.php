<?php
ob_start();
include('partials-front/menu.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật người dùng</title>
</head>

<body>
    <h1 style="text-align:center;">Cập nhật người dùng</h1>

    <?php
    if (isset($_GET['u_id'])) {
        $u_id = $_GET['u_id'];
        $sql = "SELECT * FROM users WHERE id = $u_id";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        $customer_name = $row["customer_name"];
        $customer_email = $row["customer_email"];
        $old_customer_image = $row["customer_image"];
        $customer_contact = $row["customer_contact"];
        $customer_address = $row["customer_address"];
    } else {
        header('location:' . SITEURL . 'user_profile.php');
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table style="margin: 0 auto; border-spacing: 10px;">
            <tr>
                <td>Tên người dùng</td>
                <td>
                    <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                </td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td>
                    <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                </td>
            </tr>
            <tr>
                <td>Địa chỉ</td>
                <td>
                    <input type="text" name="customer_address" value="<?php echo $customer_address; ?>">
                </td>
            </tr>
            <tr>
                <td>Ảnh đại diện hiện tại</td>
                <td>
                    <img src="<?php echo SITEURL; ?>images/user/<?php echo $old_customer_image; ?>" alt="Ảnh đại diện" width="100px">
                </td>
            </tr>
            <tr>
                <td>Thay ảnh đại diện</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="hidden" name="old_customer_image" value="<?php echo $old_customer_image; ?>">
                    <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
                    <input type="submit" name="submit" value="Cập nhật thông tin">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST["submit"])) {
        $u_id = $_POST["u_id"];
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_contact = $_POST['customer_contact'];
        $customer_address = $_POST['customer_address'];

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $image_name = $_FILES['image']['name'];
            $ext = end(explode('.', $image_name));
            $image_name = "User_" . rand(0000, 9999) . '.' . $ext;
            $src_path = $_FILES['image']['tmp_name'];
            $dest_path = "images/user/" . $image_name;

            $upload = move_uploaded_file($src_path, $dest_path);
            if ($upload == false) {
                $_SESSION['upload'] = "<div style='color:red;'>Lỗi tải ảnh lên</div>";
                header('location:' . SITEURL . "user_profile.php?u_id=" . $u_id);
                die();
            }
        } else {
            $image_name = $old_customer_image;
        }

        $sql2 = "UPDATE users SET
            customer_name = '$customer_name',
            customer_email = '$customer_email',
            customer_contact = '$customer_contact',
            customer_address = '$customer_address',
            customer_image = '$image_name'
            WHERE id = $u_id";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2 == true) {
            $_SESSION['update'] = "<div style='color:green;'>Cập nhật thành công</div>";
            header('location:' . SITEURL . 'user_profile.php?u_id=' . $u_id);
        } else {
            $_SESSION['update'] = "<div style='color:red;'>Cập nhật thất bại</div>";
            header('location:' . SITEURL . 'user_profile.php?u_id=' . $u_id);
        }
    }
    ?>
</body>

</html>
