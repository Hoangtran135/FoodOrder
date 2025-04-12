<?php
ob_start();
include('partials/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>

    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Main content container */
        .main-content {
            max-width: 1000px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Form styling */
        form {
            width: 100%;
        }

        .form-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 10px;
            vertical-align: top;
        }

        .form-table .label {
            font-weight: bold;
            color: #333;
        }

        /* Input and Textarea Fields */
        .input-field {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        /* Radio buttons styling */
        input[type="radio"] {
            margin-right: 5px;
        }

        /* Submit button styling */
        .submit-btn {
            padding: 12px 30px;  /* Increased padding to make it wider */
            background-color: #17a2b8;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 100%;  /* Make the button span the full width */
            margin: 10px 0;
            display: block;
        }

        .submit-btn:hover {
            background-color: #138496;
        }

        /* Success/Error message */
        .error, .success {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>

</head>
<body>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <td class="label">Tên món:</td>
                    <td>
                        <input type="text" name="title" placeholder="Tên món" required class="input-field">
                    </td>
                </tr>
                <tr>
                    <td class="label">Miêu tả:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Miêu tả món ăn" class="input-field"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">Giá bán:</td>
                    <td>
                        <input type="number" name="price" required class="input-field">
                    </td>
                </tr>
                <tr>
                    <td class="label">Chọn ảnh:</td>
                    <td>
                        <input type="file" name="image" class="input-field">
                    </td>
                </tr>
                <tr>
                    <td class="label">Danh mục:</td>
                    <td>
                        <select name="category" required class="input-field">
                            <?php
                            // Fetch categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                                }
                            } else {
                                echo "<option value='0'>Không có danh mục</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Có
                        <input type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td class="label">Trạng thái:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Có
                        <input type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm món" class="submit-btn">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Sanitize inputs
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['price']);
            $category = intval($_POST['category']);
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            $image_name = "";

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];

                // Validate image file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_types)) {
                    $image_name = "Food_" . rand(0000, 9999) . '.' . $ext;
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/food/" . $image_name;

                    if (!move_uploaded_file($src, $dst)) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        header('location:' . SITEURL . "admin/add_food.php");
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Định dạng ảnh không hợp lệ</div>";
                    header('location:' . SITEURL . "admin/add_food.php");
                    die();
                }
            }

            // Insert into database
            $sql2 = "INSERT INTO tbl_food SET
                        title = ?,
                        description = ?,
                        price = ?,
                        image_name = ?,
                        category_id = ?,
                        featured = ?,
                        active = ?";

            if ($stmt = mysqli_prepare($conn, $sql2)) {
                mysqli_stmt_bind_param($stmt, "ssdsiss", $title, $description, $price, $image_name, $category, $featured, $active);
                $res2 = mysqli_stmt_execute($stmt);

                if ($res2) {
                    $_SESSION['add'] = "<div class='success'>Thêm món thành công</div>";
                    header('location:' . SITEURL . 'admin/manage_food.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Thêm món thất bại</div>";
                    header('location:' . SITEURL . 'admin/add_food.php');
                }

                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['add'] = "<div class='error'>Lỗi chuẩn bị truy vấn</div>";
                header('location:' . SITEURL . 'admin/add_food.php');
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>

</body>
</html>
