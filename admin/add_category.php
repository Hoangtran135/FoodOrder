<?php
ob_start();
include('partials/header.php'); ?>

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
}

.wrapper {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

/* Heading Styling */
h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Table Styling */
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

table input[type="text"],
table input[type="file"],
table input[type="radio"] {
     font-size: 16px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

/* Submit Button Styling */
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

/* Radio Button Group Styling */
.radio-group {
    display: flex;
    align-items: center;
    gap: 10px; /* Adjust space between the radio buttons */
}

input[type="radio"] {
    margin-right: 2px; /* Reduce space between radio button and label */
    width: auto;
    height: auto;
    vertical-align: middle; /* Align the radio button vertically with the text */
}

/* Label Styling */
.radio-group label {
    margin-right: 5px; /* Reduce space between radio button and label */
    margin-bottom: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        width: 90%;
    }
    table td {
        padding: 8px;
    }
    table input[type="text"],
    table input[type="file"],
    table input[type="radio"],
    table input[type="submit"] {
        width: 100%;
    }
}

</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Thêm danh mục</h1>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên danh mục: </td>
                    <td><input type="text" name="title" placeholder="Tên danh mục" required></td>
                </tr>
                <tr>
                    <td>Tải ảnh lên: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td class="radio-group">
                        <input type="radio" name="featured" value="Yes" id="featuredYes">
                        <label for="featuredYes">Có</label>
                        <input type="radio" name="featured" value="No" id="featuredNo">
                        <label for="featuredNo">Không</label>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái: </td>
                    <td class="radio-group">
                        <input type="radio" name="active" value="Yes" id="activeYes">
                        <label for="activeYes">Có</label>
                        <input type="radio" name="active" value="No" id="activeNo">
                        <label for="activeNo">Không</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm Danh Mục">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Sanitize inputs
            $title = htmlspecialchars($_POST['title']);
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            $image_name = "";
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];

                // Validate file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_types)) {
                    $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination = "../images/category/" . $image_name;

                    // Move file to the destination
                    if (!move_uploaded_file($source_path, $destination)) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        header('location:' . SITEURL . "admin/add_category.php");
                        die();
                    }
                } else {
                    $_SESSION['upload'] = "<div class='error'>Định dạng ảnh không hợp lệ</div>";
                    header('location:' . SITEURL . "admin/add_category.php");
                    die();
                }
            }

            // Use prepared statements for the SQL query
            $sql = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $title, $image_name, $featured, $active);

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['add'] = "<div class='success'>Thêm danh mục thành công</div>";
                    header('location:' . SITEURL . 'admin/manage_category.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Lỗi thêm danh mục</div>";
                    header('location:' . SITEURL . 'admin/add_category.php');
                }
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['add'] = "<div class='error'>Lỗi chuẩn bị câu lệnh SQL</div>";
                header('location:' . SITEURL . 'admin/add_category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
