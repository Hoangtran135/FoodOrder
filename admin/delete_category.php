<?php
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = intval($_GET['id']); // Ép kiểu để tránh lỗi bảo mật
    $image_name = $_GET['image_name'];

    // Xóa ảnh nếu tồn tại
    if (!empty($image_name)) {
        $remove_path = "../images/category/" . $image_name;

        if (!unlink($remove_path)) {
            $_SESSION['remove'] = "<div class='error'>Lỗi: Không thể xóa ảnh danh mục</div>";
            header('location:' . SITEURL . 'admin/manage_category.php');
            exit();
        }
    }

    // Chuẩn bị câu lệnh SQL xóa danh mục
    $sql = "DELETE FROM tbl_category WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Gán giá trị tham số và thực thi câu lệnh
        mysqli_stmt_bind_param($stmt, "i", $id);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>Xóa danh mục thành công</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Lỗi: Không thể xóa danh mục</div>";
        }

        // Đóng câu lệnh
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['delete'] = "<div class='error'>Lỗi: Không thể chuẩn bị câu lệnh SQL</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>Lỗi: Thông tin không hợp lệ</div>";
}

// Chuyển hướng về trang quản lý danh mục
header('location:' . SITEURL . 'admin/manage_category.php');
exit();
?>
