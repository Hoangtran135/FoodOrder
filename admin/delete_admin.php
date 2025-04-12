<?php
include('../config/constants.php');

// Kiểm tra nếu 'id' tồn tại trong URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ép kiểu để tránh SQL Injection

    // Chuẩn bị câu lệnh xóa
    $sql = "DELETE FROM tbl_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Gán giá trị cho tham số
        mysqli_stmt_bind_param($stmt, "i", $id);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>Xóa nhân viên thành công</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Lỗi khi xóa nhân viên: " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['delete'] = "<div class='error'>Không thể chuẩn bị câu lệnh SQL</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>ID không hợp lệ</div>";
}
header('location:' . SITEURL . '/admin/manage_admin.php');
?>
