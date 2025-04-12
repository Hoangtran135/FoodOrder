<?php
if (strpos($_SERVER['SCRIPT_NAME'], 'admin') !== false) {
    session_name('admin_session'); // Đặt tên session riêng cho admin
} else {
    session_name('user_session'); // Đặt tên session riêng cho user
}
session_start();
define('SITEURL', 'http://localhost/Foodordering/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'doanweb');
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); //selecting database
