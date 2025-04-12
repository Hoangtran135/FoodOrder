<?php
ob_start();

include('partials/header.php');

// Kiểm tra xem có ID người quản trị không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<style>
/* General Styling for the page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.main-content {
    width: 70%;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table td {
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

table input[type="password"] {
    font-size: 16px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    width: 100%;
}

table input[type="submit"] {
    background-color: #17a2b8;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
    width: 100%;
    margin-top: 15px;
}

table input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Success/Failure Message Styling */
.success {
    background-color: #28a745;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    border-radius: 4px;
}

.error {
    background-color: #dc3545;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    border-radius: 4px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        width: 90%;
    }
    table td {
        padding: 8px;
    }
    table input[type="password"],
    table input[type="submit"] {
        width: 100%;
    }
}
</style>

<div class="main-content">
    <h1>Đổi mật khẩu</h1>

    <?php
    // Hiển thị thông báo lỗi hoặc thành công nếu có
    if (isset($_SESSION['old_pass_wrong'])) {
        echo $_SESSION['old_pass_wrong'];
        unset($_SESSION['old_pass_wrong']);
    }
    if (isset($_SESSION['pwd-not-match'])) {
        echo $_SESSION['pwd-not-match'];
        unset($_SESSION['pwd-not-match']);
    }
    ?>

    <br><br>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Nhập mật khẩu hiện tại: </td>
                <td><input type="password" name="old_password" placeholder="Mật khẩu hiện tại" required></td>
            </tr>
            <tr>
                <td>Nhập mật khẩu mới: </td>
                <td><input type="password" name="new_password" placeholder="Mật khẩu mới " required></td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu: </td>
                <td><input type="password" name="cf_password" placeholder="Xác nhận mật khẩu" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Đổi mật khẩu">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
// Xử lý thay đổi mật khẩu
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $cf_password = md5($_POST['cf_password']);

    // Kiểm tra mật khẩu cũ có đúng không
    $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$old_password'";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // Kiểm tra mật khẩu mới và xác nhận mật khẩu có trùng khớp không
            if ($new_password == $cf_password) {
                // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                $sql2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id = $id";
                $res2 = mysqli_query($conn, $sql2);
                if ($res2 == true) {
                    $_SESSION['change-pwd'] = "<div class='success'>Đổi mật khẩu thành công</div>";
                    header('location:' . SITEURL . 'admin/manage_admin.php');
                } else {
                    $_SESSION['change-pwd'] = "<div class='error'>Đổi mật khẩu thất bại</div>";
                    header('location:' . SITEURL . 'admin/manage_admin.php');
                }
            } else {
                $_SESSION['pwd-not-match'] = "<div class='error'>Mật khẩu không trùng khớp</div>";
                header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
            }
        } else {
            $_SESSION['old_pass_wrong'] = "<div class='error'>Mật khẩu cũ không đúng</div>";
            header('location:' . SITEURL . 'admin/update_password.php?id=' . $id);
        }
    }
}
?>

<?php
include('partials/footer.php');
?>
