<?php
include('../config/constants.php');
?>
<html>

<head>
    <title>Đăng nhập - Hệ thống</title>
    <!-- CSS tích hợp vào trong file -->
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container Wrapper */
        .login-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Page Title */
        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }

        /* Form Inputs */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #428B16;
        }

        /* Submit Button */
        input[type="submit"] {
            background-color: #428B16;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2e6e10;
        }

        /* Success and Error Messages */
        .success {
            color: #27ae60;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Optional: For better visual styling */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        /* Media Query for Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                padding: 20px;
                width: 90%;
            }

            h1 {
                font-size: 1.8em;
            }

            input[type="submit"] {
                font-size: 1.2em;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php
        if (isset($_SESSION['login'])) {
            echo "<div class='success'>" . $_SESSION['login'] . "</div>";
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo "<div class='error'>" . $_SESSION['no-login-message'] . "</div>";
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br>
        <!-- Form đăng nhập -->
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required> <br>
            <input type="password" name="password" placeholder="Password" required> <br>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // SQL Query kiểm tra tài khoản
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $_SESSION['login'] = "Đăng nhập thành công";
        $_SESSION['user'] = $username;
        header("location:" . SITEURL . 'admin/');
    } else {
        $_SESSION['login'] = "Đăng nhập thất bại";
        header("location:" . SITEURL . 'admin/login.php');
    }
}
?>
