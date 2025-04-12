<?php
include('config/constants.php');
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    $_SESSION['error'] = "<div class='error'>ID đơn hàng không hợp lệ.</div>";
    header('Location: myorders.php');
    exit();
}
$order_id = $_GET['order_id'];


try {

    $stmt = $conn->prepare("UPDATE tbl_order_details SET status = 3 WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("UPDATE tbl_order SET status = 3 WHERE id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success'] = "<div class='success'>Đã hủy đơn hàng thành công.</div>";
    header('Location: myorders.php');
    exit();
} catch (Exception $e) {
    $_SESSION['error'] = "<div class='error'>Đã xảy ra lỗi: " . $e->getMessage() . "</div>";
    header('Location: myorderss.php');
    exit();
}
