<?php
include('../config/constants.php');
include('login_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        /* General Navbar Styling */
        .navbar {
            background-color: #343a40; /* Màu nền tối */
            padding: 10px 20px;
        }

        .navbar-brand {
            font-size: 1.8em;
            font-weight: bold;
            color: #ffffff !important; /* Màu chữ cho tên dashboard */
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ffc107 !important; /* Màu vàng khi hover */
        }

        .nav-link {
            color: #ffffff !important; /* Màu chữ mặc định */
            font-size: 1.1em;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffc107 !important; /* Màu vàng khi hover */
        }

        .navbar-toggler {
            border: none;
            outline: none;
        }

        .navbar-toggler-icon {
            filter: brightness(0) invert(1); /* Màu trắng cho biểu tượng toggle */
        }

        .nav-item {
            position: relative; /* Dùng để tạo gạch dưới */
        }

        .nav-item::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ffc107; /* Màu vàng gạch dưới */
            transition: width 0.3s ease-in-out;
        }

        .nav-item:hover::after {
            width: 100%; /* Tạo hiệu ứng gạch dưới */
        }

        @media (max-width: 992px) {
            .navbar-nav {
                text-align: center;
            }

            .nav-link {
                padding: 10px 0;
            }
        }

        /* Optional: For better visual styling */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar Section -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_admin.php">Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_category.php">Category</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_food.php">Food</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_order.php">Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_user.php">User</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_revenue.php">Revenue</a></li> <!-- Đã thêm Revenue -->
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
