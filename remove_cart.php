<?php
include('config/constants.php');

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    // Xóa sản phẩm khỏi giỏ hàng
    if (isset($_SESSION['cart'][$food_id])) {
        unset($_SESSION['cart'][$food_id]);
    }

    header("Location: view_cart.php");
    exit();
} else {
    // Nếu không có food_id, chuyển về trang giỏ hàng
    header("Location: view_cart.php");
    exit();
}
