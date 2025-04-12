<?php

include('../config/constants.php');

// Kiểm tra nếu ID tồn tại trong URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

   $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn,$sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"i",$id);
        $res = mysqli_stmt_execute($stmt);
    }

    if ($res) {
        $_SESSION['delete'] = "<div class='success'>Xóa user thành công</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Lỗi xóa user</div>";
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['delete'] = "<div class='error'>ID không hợp lệ</div>";
}

header('Location: ' . SITEURL . '/admin/manage_user.php');
exit;
