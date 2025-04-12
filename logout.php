<?php
session_name('user_session'); // Đặt tên session dành riêng cho user
session_start();

$_SESSION = array();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Chuyển hướng về trang đăng nhập
header("location: login.php");
exit;
?>
