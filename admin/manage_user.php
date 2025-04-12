<?php
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
            max-width: 1200px;
        }

        /* Title Styling */
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

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
        }

        /* Buttons */
        .btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            margin-right: 5px;
        }

        .btn-primary {
            background-color: #17a2b8; /* Updated background color */
            color: white;
        }

        .btn-primary:hover {
            background-color: #117a8b; /* Adjust hover color */
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #117a8b;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #17a2b8; /* Updated background color */
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <div class="wrapper">
            <h1 class="text-center">Quản lý người dùng</h1>
            <br>
            <?php
            if (isset($_SESSION['add'])) {
                echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
                unset($_SESSION['add']);
            }
            if (isset($_SESSION['delete'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['change-pwd'])) {
                echo '<div class="alert alert-info">' . $_SESSION['change-pwd'] . '</div>';
                unset($_SESSION['change-pwd']);
            }
            ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên người dùng</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL query to fetch all user data
                    $sql = "SELECT * FROM users";
                    $res = mysqli_query($conn, $sql);
                    $sn = 1;

                    if ($res == true) {
                        $count = mysqli_num_rows($res);

                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $full_name = $row['customer_name'];
                                $username = $row['username'];
                                $email = $row['customer_email'];
                                $address = $row['customer_address'];
                                $contact = $row['customer_contact'];
                    ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $address; ?></td>
                                    <td><?php echo $contact; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>/admin/update_user.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                                        <a href="<?php echo SITEURL; ?>/admin/delete_user.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Xóa</a>
                                    </td>
                                </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-danger'>Chưa có người dùng nào</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa người dùng này không?");
        }
    </script>
</body>

</html>

<?php
include("partials/footer.php");
?>
