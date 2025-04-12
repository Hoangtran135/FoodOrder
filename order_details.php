<?php
include('partials-front/menu.php'); 

// Lấy ID đơn hàng từ URL
$order_id = $_GET['order_id'];

// Lấy thông tin chi tiết của đơn hàng
$sql = "SELECT * FROM tbl_order WHERE id = $order_id AND u_id = {$_SESSION['u_id']}";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $order = mysqli_fetch_assoc($res);

    // Lấy thông tin chi tiết của đơn hàng từ tbl_order_details
    $details_sql = "SELECT * FROM tbl_order_details WHERE order_id = $order_id";
    $details_res = mysqli_query($conn, $details_sql);
} else {
    $_SESSION['error'] = "Không tìm thấy đơn hàng.";
    header('location: myorders.php');
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <style>
        /* General Table and Order Summary Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            background-color: #fff;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ebebeb;
        }

        .table th {
            background-color: #428b16;
            color: white;
            font-weight: bold;
        }

        .table td {
            font-size: 14px;
        }

        .table td img {
            width: 60px;
            height: auto;
            border-radius: 8px;
        }

        /* Button styling */
        .btn {
            padding: 8px 20px;
            text-align: center;
            border: none;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d; /* Gray background */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s ease; /* Smooth background transition */
        }

        .btn-secondary:hover {
            background-color: #5a6268; /* Darker gray when hovered */
            color: #f8f9fa; /* Lighter text color when hovered */
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .table td, .table th {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <h2>Chi tiết đơn hàng</h2>
    <table class="table">
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Size</th>
            <th>Ghi chú</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Tổng</th>
            <th>Đánh giá</th>
        </tr>

    <?php
    $stt = 1;
    while ($row = mysqli_fetch_assoc($details_res)) {
        // Lấy thông tin sản phẩm từ tbl_food
        $food_sql = "SELECT title, price ,image_name FROM tbl_food WHERE id = {$row['food_id']}";
        $food_res = mysqli_query($conn, $food_sql);
        $food = mysqli_fetch_assoc($food_res);
        $total_price = $row['quantity'] * $food['price'];
    ?>

        <tr>
            <td><?= $stt++ ?></td>
            <td><?= htmlspecialchars($food['title']) ?></td>
            <td><img src="<?= SITEURL . 'images/food/' . $food['image_name'] ?>" alt="<?= htmlspecialchars($food['title']) ?>" style="width: 200px; height: 200px;"></td>
            <td><?= htmlspecialchars($row['size']) ?></td>
            <td><?= htmlspecialchars($row['note']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($food['price'], 0, ',', '.') ?> VNĐ</td>
            <td><?= number_format($total_price, 0, ',', '.') ?> VNĐ</td>
            <td>
            <?php if ($row['status'] == 0): ?>
                <a href="user_comment.php?food_id=<?= $row['food_id'] ?>" class="btn btn-primary">Đánh giá </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php
    }
    ?>

    </table>
    <a href="myorders.php" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>

</body>
</html>
