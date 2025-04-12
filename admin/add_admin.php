<?php
ob_start();
include('partials/header.php');
?>

<html>
<head>
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

        /* Alerts */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        /* Form Layout */
        form {
            width: 100%;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td {
            padding: 10px;
            text-align: left;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #17a2b8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #117a8b;
        }

        /* Title and Form Styling */
        form h3 {
            color: #343a40;
            font-size: 22px;
            margin-bottom: 20px;
        }

        table tr {
            border-bottom: 1px solid #ddd;
        }

        table td {
            font-size: 16px;
            color: #343a40;
        }

        table input {
            font-size: 14px;
        }

        table tr td:first-child {
            width: 150px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            table td {
                padding: 8px;
            }

            input[type="submit"] {
                padding: 8px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="wrapper">
            <h1>Thêm Nhân Viên</h1>
        </div>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST">
            <table>
                <tr>
                    <td>Tên nhân viên:</td>
                    <td><input type="text" name="full_name" placeholder="Điền tên của bạn" required></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <td>Mật khẩu: </td>
                    <td>
                        <input type="password" name="password" placeholder="Mật khẩu" required>
                    </td>
                </tr>
                <tr>
                    <td>Xác nhận mật khẩu: </td>
                    <td>
                        <input type="password" name="cf_password" placeholder="Xác nhận mật khẩu" required>
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><input type="text" name="email" placeholder="Email"></td>
                </tr>
                <tr>
                    <td>Địa chỉ:</td>
                    <td><input type="text" name="address" placeholder="Địa chỉ"></td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td><input type="text" name="contact" placeholder="Contact"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm nhân viên">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['submit'])) {

    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cf_password = $_POST['cf_password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    if ($password === $cf_password) {
        $hashed_password = md5($password);
        $sql = "INSERT INTO tbl_admin (full_name, username, password, email, address, contact) VALUES (?, ?, ?, ?, ?, ?)";

        // Sử dụng Prepared Statements để tránh SQL Injection
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Gán giá trị vào các placeholder (?)
            mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $username, $hashed_password, $email, $address, $contact);

            // Thực thi câu lệnh
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['add'] = "<div class='success'>Thêm nhân viên thành công</div>";
                header('location:' . SITEURL . 'admin/manage_admin.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Thêm nhân viên thất bại</div>";
                header('location:' . SITEURL . 'admin/add_admin.php');
            }

            // Đóng câu lệnh chuẩn bị
            mysqli_stmt_close($stmt);
        } else {
            echo "Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['add'] = "<div class='error'>Mật khẩu không trùng khớp</div>";
        header('location:' . SITEURL . 'admin/add_admin.php');
    }
}
?>

<?php
include('partials/footer.php');
?>
