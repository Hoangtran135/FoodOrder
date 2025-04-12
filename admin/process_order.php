<?php
include('../config/constants.php');

// Kiểm tra nếu 'order_id' tồn tại và hợp lệ
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Sử dụng Prepared Statement để tránh SQL Injection
    $stmt = $conn->prepare("UPDATE tbl_order_details SET status = 2 WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("UPDATE tbl_order SET status = 2 WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Chỉ điều hướng đến trang quản lý đơn hàng sau khi cập nhật thành công
        header('Location: ' . SITEURL . 'admin/manage_order.php');
        exit;
    } else {
        echo "Lỗi khi cập nhật thông tin đơn hàng.";
    }

    $stmt->close();
} else {
    echo "Đơn hàng không hợp lệ hoặc không tồn tại.";
}
?>
