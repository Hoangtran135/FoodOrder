<?php
include("partials/header.php");
?>

<html>

<head>
    <style>
   /* General Page Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 0;
}

.main-content {
    background: #ffffff;
    padding: 20px;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
}

/* Title */
h1 {
    color: #343a40;
    font-size: 28px;
    text-align: center;
}

/* Alerts */
.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
}

.alert-info {
    color: #0c5460;
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

/* Buttons */
.btn {
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

.btn-primary {
    background-color: #17a2b8; /* Set primary button color to #17a2b8 */
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #138496; /* Slightly darker shade of #17a2b8 */
}

.btn-warning {
    background-color: #ffc107;
    color: #212529;
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
    padding: 10px;
    border: 1px solid #ddd;
}

.table th {
    background-color: #17a2b8; /* Set table headers to color #17a2b8 */
    color: white;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

/* Images */
img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
}

    </style>
</head>

<body>
    <div class="main-content">
        <div class="wrapper">
            <h1 class="text-center">Quản lý danh mục</h1>

            <br>
            <?php
            if (isset($_SESSION['add'])) {
                echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
                unset($_SESSION['add']);
            }
            if (isset($_SESSION['upload'])) {
                echo '<div class="alert alert-warning">' . $_SESSION['upload'] . '</div>';
                unset($_SESSION['upload']);
            }
            if (isset($_SESSION['update'])) {
                echo '<div class="alert alert-info">' . $_SESSION['update'] . '</div>';
                unset($_SESSION['update']);
            }
            if (isset($_SESSION['delete'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['fail_remove'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['fail_remove'] . '</div>';
                unset($_SESSION['fail_remove']);
            }
            if (isset($_SESSION['no_category_found'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['no_category_found'] . '</div>';
                unset($_SESSION['no_category_found']);
            }
            ?>
            <br>
            <a href="<?php echo SITEURL; ?>admin/add_category.php" class="btn btn-primary">Thêm danh mục</a>

            <br><br><br>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Stt</th>
                        <th>Tên danh mục</th>
                        <th>Image</th>
                        <th>Nổi bật</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_category";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $stt = 1;

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                    ?>
                            <tr>
                                <td><?php echo $stt++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <?php
                                    if ($image_name != "") {
                                    ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                    } else {
                                        echo "<div class='text-danger'>Chưa có ảnh</div>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update_category.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete_category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Xóa</a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center text-danger">Chưa có danh mục</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa danh mục này không?");
        }
    </script>
</body>

</html>
<?php
include("partials/footer.php");
?>
