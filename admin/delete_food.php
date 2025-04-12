<?php
include('../config/constants.php');

// Check if the required parameters are set
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = intval($_GET['id']);
    $image_name = $_GET['image_name'];

    // Remove image file if it exists
    if (!empty($image_name)) {
        $path = "../images/food/" . $image_name;

        // Attempt to remove the file and handle failure
        if (!unlink($path)) {
            $_SESSION['upload'] = "<div class='error'>Lỗi xóa ảnh</div>";
            header('location:' . SITEURL . 'admin/manage_food.php');
            exit;
        }
    }

    // Prepare and execute SQL query to delete the food item
    $sql = "DELETE FROM tbl_food WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>Xóa món ăn thành công</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Xóa món ăn thất bại</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['delete'] = "<div class='error'>Lỗi khi chuẩn bị câu lệnh</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>Thao tác không hợp lệ</div>";
}

// Redirect to manage food page
header('location:' . SITEURL . 'admin/manage_food.php');
exit;
?>
