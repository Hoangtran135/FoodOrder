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

        /* Filter Section */
        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Button Styling */
        .btn {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #17a2b8;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #138496;
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
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #17a2b8; /* Header background color */
            color: white; /* Text color */
            font-size: 14px; /* Slightly smaller font */
            font-weight: bold;
            white-space: nowrap; /* Prevent wrapping of text */
        }

        .table td {
            vertical-align: middle;
        }

        /* Increase the width of the action column */
        .table td:last-child,
        .table th:last-child {
            width: 200px; /* Adjust the width of the last column */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        /* Button container (in action column) */
        .table td .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap; /* Allows buttons to wrap when necessary */
        }

        /* Images */
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
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
    </style>
</head>

<body>

<div class="main-content">
    <div class="wrapper">
        <h1>Quản lý món ăn</h1>

        <br>

        <!-- Phần lọc theo danh mục -->
        <div class="filter-section">
            <form method="GET" action="">
                <label for="category">Lọc theo danh mục:</label>
                <select name="category" id="category">
                    <option value="">Tất cả danh mục</option>
                    <?php
                    // Lấy danh sách danh mục từ Cơ sở dữ liệu
                    $category_sql = "SELECT * FROM tbl_category";
                    $category_res = mysqli_query($conn, $category_sql);

                    if ($category_res && mysqli_num_rows($category_res) > 0) {
                        while ($category_row = mysqli_fetch_assoc($category_res)) {
                            $selected = isset($_GET['category']) && $_GET['category'] == $category_row['id'] ? "selected" : "";
                            echo "<option value='" . $category_row['id'] . "' $selected>" . $category_row['title'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>

        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
            unset($_SESSION['add']);
        }
        ?>

        <a href="<?php echo SITEURL ?>admin/add_food.php" class="btn btn-primary">Thêm món ăn</a>
        <br><br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên món ăn</th>
                    <th>Danh mục</th>
                    <th>Miêu tả</th>
                    <th>Giá bán</th>
                    <th>Hình ảnh</th>
                    <th>Nổi bật</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy danh mục lọc từ request
                $filter_category = isset($_GET['category']) ? $_GET['category'] : "";

                $sql = "
                SELECT 
                    tbl_food.id, 
                    tbl_food.title AS food_title, 
                    tbl_food.description, 
                    tbl_food.price, 
                    tbl_food.image_name, 
                    tbl_food.featured, 
                    tbl_food.active, 
                    tbl_category.title AS category_title
                FROM 
                    tbl_food
                INNER JOIN 
                    tbl_category 
                ON 
                    tbl_food.category_id = tbl_category.id
                ";

                // Thêm điều kiện lọc nếu có
                if ($filter_category) {
                    $sql .= " WHERE tbl_food.category_id = '" . mysqli_real_escape_string($conn, $filter_category) . "'";
                }

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $stt = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['food_title'];
                        $category_title = $row['category_title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $category_title ?></td>
                            <td><?php echo $description; ?></td>
                            <td><?php echo number_format($price); ?> VND</td>
                            <td>
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='text-danger'>Không có ảnh</div>";
                                } else {
                                ?>
                                    <img src="<?php echo SITEURL; ?>/images/food/<?php echo $image_name; ?>" width="100px" class="rounded">
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td class="btn-container">
                                <a href="<?php echo SITEURL; ?>admin/update_food.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                                <a href="<?php echo SITEURL; ?>admin/delete_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Xóa</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr> <td colspan='8' class='text-center text-danger'>Không có món ăn </td></tr>";
                }
                ?>
            </tbody>
        </table>

        <script>
            function confirmDelete() {
                return confirm("Bạn có chắc chắn muốn xóa món ăn này không?");
            }
        </script>
    </div>
</div>

</body>

</html>

<?php
include("partials/footer.php");
?>
