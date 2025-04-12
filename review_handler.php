<?php
include 'config/constants.php'; // Ensure this file contains the database connection setup
if (!isset($_SESSION['u_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
    $user_id = $_SESSION['u_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    

    // Handle image upload if an image is provided
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];

        // Ensure the file extension is safely extracted
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);

        // Rename the file to avoid conflicts
        $image_name = "Review_Name_" . rand(0000, 9999) . '.' . $ext;
        $src = $_FILES['image']['tmp_name'];
        $dst = "./images/reviews/" . $image_name;

        // Move the uploaded file
        $upload = move_uploaded_file($src, $dst);
        if ($upload == false) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            header('location:' . SITEURL . "food_detail_show.php");
            exit(); // Use exit() to stop further script execution
        }
    } else {
        $image_name = ""; // Set default value if no image is uploaded
    }

    // Insert data into the database, with secure handling for SQL injection
    $sql = "INSERT INTO tbl_review (f_id, u_id, comment, rating, create_at, image_name) 
            VALUES ('$food_id', '$user_id', '$comment', '$rating',Now(), '$image_name')";

    // Execute SQL query and handle potential errors
    $res = mysqli_query($conn, $sql);

    if ($res === true) {
        // Chuyển hướng về trang chi tiết sản phẩm nếu thành công
        header("Location: food_detail_show.php?food_id=$food_id");
        exit();
    } else {
        // Hiển thị lỗi nếu có vấn đề với câu lệnh SQL
        echo "Lỗi khi thêm đánh giá: " . mysqli_error($conn);
    }
}
