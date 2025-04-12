<?php
ob_start();

include('partials/header.php');
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Sửa đổi thông tin nhân viên</h1>
    </div>
    <br><br>

    <?php
    // Lấy thông tin nhân viên theo ID
    $sql = "SELECT * FROM tbl_admin WHERE id = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $full_name = $row['full_name'];
            $username = $row['username'];
            $email = $row['email'];
            $address = $row['address'];
            $contact = $row['contact'];
        } else {
            // Nếu không tìm thấy nhân viên
            header('location: ' . SITEURL . 'admin/manage_admin.php');
        }
    }
    ?>

    <!-- Form sửa thông tin -->
    <form action="" method="POST">
        <table>
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
            </tr>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
            </tr>
            <tr>
                <td>Địa chỉ: </td>
                <td><input type="text" name="address" value="<?php echo $address; ?>"></td>
            </tr>
            <tr>
                <td>Số điện thoại: </td>
                <td><input type="text" name="contact" value="<?php echo $contact; ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>

    <?php
    // Xử lý khi người dùng nhấn nút Update
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        // Cập nhật thông tin nhân viên vào cơ sở dữ liệu
        $sql2 = "UPDATE tbl_admin SET 
            full_name='$full_name', 
            username='$username', 
            email='$email', 
            address='$address', 
            contact='$contact' 
            WHERE id='$id'";
        $res2 = mysqli_query($conn, $sql2);

        // Kiểm tra kết quả và thông báo
        if ($res2 == true) {
            $_SESSION['update'] = "<div class='success'>Thay đổi thông tin thành công</div>";
            header('location: ' . SITEURL . 'admin/manage_admin.php');
        } else {
            $_SESSION['update'] = "<div class='error'>Thay đổi thông tin thất bại</div>";
            header('location: ' . SITEURL . 'admin/update_admin.php?id=' . $id);
        }
    }
    ?>

</div>

<?php
include('partials/footer.php');
?>

<!-- CSS Style -->
<style>
    /* General Page Layout */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .main-content {
        background-color: #ffffff;
        padding: 20px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    h1 {
        font-size: 28px;
        color: #343a40;
        text-align: center;
    }

    /* Table Styling */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    table tr td {
        padding: 10px;
        font-size: 16px;
    }

    table input {
        padding: 8px;
        width: 100%;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Buttons */
    input[type="submit"] {
        background-color: #17a2b8;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #117a8b;
    }

    /* Alerts */
    .success {
        color: #155724;
        background-color: #d4edda;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
</style>
