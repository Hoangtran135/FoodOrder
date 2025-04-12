<?php
include('config/constants.php');

// Xóa toàn bộ giỏ hàng
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

header("Location: view_cart.php");
exit();
