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
    width: 70%; /* Make div smaller */
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Table Styles */
table.tbl-30 {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table.tbl-30 td {
    padding: 12px;
    text-align: left;
    font-size: 16px;
    vertical-align: middle;
}

table.tbl-30 input[type="text"],
table.tbl-30 input[type="number"],
table.tbl-30 select,
table.tbl-30 textarea {
    font-size: 16px;
    padding: 10px;
    width: 100%; /* Full width for input fields */
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

table.tbl-30 input[type="file"] {
    font-size: 16px;
    margin-top: 5px;
}

table.tbl-30 img {
    margin-top: 10px;
    border-radius: 4px;
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

/* Radio Button Styling */
table.tbl-30 input[type="radio"] {
    margin-top: 10px;
    margin-right: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        width: 90%; /* Make div smaller on mobile */
    }

    table.tbl-30 td {
        padding: 8px;
    }

    table.tbl-30 input[type="text"],
    table.tbl-30 input[type="number"],
    table.tbl-30 select,
    table.tbl-30 textarea,
    table.tbl-30 input[type="file"],
    table.tbl-30 input[type="submit"] {
        width: 100%; /* Ensure all inputs/buttons are full width */
    }
}

/* Style the button container for full width */
.button-container {
    width: 100%;
    display: flex;
    justify-content: center;
    padding-top: 20px;
}

.button-container input[type="submit"] {
    width: 100%; /* Make button full width */
    padding: 12px 20px;
    background-color: #17a2b8;
    color: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}

.button-container input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Cập nhật món ăn</h1>

        <br><br>

        <?php
        // Check whether the id 
        if (isset($_GET['id'])) {
            // Get the id and all the details
            $id = $_GET['id'];
            $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);

            $row2 = mysqli_fetch_assoc($res2);

            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $old_image = $row2['image_name'];
            $old_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        } else {
            header('location:' . SITEURL . 'admin/manage_food.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description :</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Hình Ảnh:</td>
                    <td>
                        <?php
                        if ($old_image != "") {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $old_image ?>" width="100px">
                        <?php
                            // Display the image
                        } else {
                            // Display the message
                            echo "<div class='error'>Không có ảnh</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                            ?>
                                    <option
                                        value="<?php echo $category_id; ?>"
                                        <?php if ($old_category == $category_id) {
                                            echo "selected";
                                        } ?>>
                                        <?php echo $category_title; ?>
                                    </option>
                            <?php
                                }
                            } else {
                                echo "<option value='0'>Danh mục không tồn tại</option>";
                            }
                            ?>
                        </select>
                    </td>

                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Có
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> Không
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Có
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">Không
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="old_image" value="<?php echo $old_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </td>
                </tr>

            </table>

            <div class="button-container">
                <input type="submit" name="submit" value="Update Food">
            </div>

        </form>

        <?php
        if (isset($_POST["submit"])) {
            $id = $_POST["id"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $old_image = $_POST["old_image"];
            $category = $_POST["category"];
            $featured = $_POST["featured"];
            $active = $_POST["active"];

            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    // Image available

                    // Upload new image
                    $ext = end(explode('.', $image_name));

                    // Rename the image with unique name
                    $image_name = "Food_" . rand(0000, 9999) . '.' . $ext;

                    $src_path = $_FILES['image']['tmp_name'];

                    $dest_path = "../images/food/" . $image_name;

                    // Finally upload
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // Check whether the image 
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Lỗi tải ảnh lên</div>";
                        // Redirect to add Category
                        header('location' . SITEURL . "admin/add_food.php");
                        // Stop the process
                        die();
                    }

                    if ($old_image != "") {

                        $remove_path = "../images/food/" . $old_image;
                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            $_SESSION['fail-remove'] = "<div class='error'>Lỗi xóa hình ảnh</div>";
                            // Redirect to add Category
                            header('location:' . SITEURL . "admin/manage_food.php");
                            // Stop the process
                            die();
                        }
                    }
                } else {
                    $image_name = $old_image;
                }
            } else {
                $image_name = $old_image;
            }

            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Cập nhật thành công</div>";
                header('location:' . SITEURL . 'admin/manage_food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Cập nhât thất bại</div>";
                header('location:' . SITEURL . 'admin/manage_food.php');
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>
