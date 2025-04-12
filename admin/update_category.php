<?php
ob_start();
include('partials/header.php');
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
    width: 100%; /* Nút chiếm toàn bộ chiều rộng của div */
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
    gap: 10px;
}

input[type="radio"] {
    margin-right: 2px;
    width: auto;
    height: auto;
    vertical-align: middle;
}

.radio-group label {
    margin-right: 5px;
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

/* New Div Style for Wrapping Bottom Part */
.bottom-wrapper {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}
</style>

<div class="main-content">
   

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_category WHERE id = '$id'";

        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $old_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            $_SESSION['no_category_found'] = "<div class='error'>Không tìm thấy danh mục</div>";
            header('location: admin/manage_category.php');
        }
    } else {
        header('location: admin/manage_category.php');
    }
    ?>

    <!-- Start of Bottom Wrapper Div -->
    <div class="bottom-wrapper">
    <h1>Cập nhật danh mục</h1><br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Tên danh mục:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>
                <tr>
                    <td>Hình ảnh:</td>
                    <td>
                        <?php
                        if ($old_image != "") {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $old_image ?>" width="150px">
                        <?php
                        } else {
                            echo "<div class='error'>Không có hình ảnh</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Hình ảnh mới:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td class="radio-group">
                        <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes"> Có
                        <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td class="radio-group">
                        <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes"> Có
                        <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="old_image" value="<?php echo $old_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Cập nhật danh mục">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $old_image = $_POST['old_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Xử lý ảnh mới
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "Category_" . rand(0000, 9999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination = "../images/category/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination);
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Tải lên thất bại</div>";
                        header('location: ' . SITEURL . "admin/add_category.php");
                        die();
                    }

                    if ($old_image != "") {
                        $remove_path = "../images/category/" . $old_image;
                        $remove = unlink($remove_path);
                        if ($remove == false) {
                            $_SESSION['fail_remove'] = "<div class='error'>Xóa ảnh thất bại</div>";
                            header('location:' . SITEURL . "admin/manage_category.php");
                            die();
                        }
                    }
                } else {
                    $image_name = $old_image;
                }
            } else {
                $image_name = $old_image;
            }

            // Cập nhật danh mục vào cơ sở dữ liệu
            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Cập nhật danh mục thành công</div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Cập nhật thất bại</div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            }
        }
        ?>
    </div>
    <!-- End of Bottom Wrapper Div -->
</div>

<?php
include('partials/footer.php');
?>
