<?php
include("partials/header.php");

// Lấy ID đơn hàng từ URL
$order_id = $_GET['order_id'];

$sql = "SELECT * FROM tbl_order WHERE id = $order_id";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$u_id = $row['u_id'];

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Container Styling */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Title Styling */
        h2, h3 {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: #333;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Table Header Styling */
        th {
            background-color: #17a2b8; /* Màu đầu mục bảng */
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-right: 1px solid #ddd; /* Đường kẻ trắng giữa các cột */
        }

        /* Table Data Styling */
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd; /* Đường kẻ giữa các ô */
            font-size: 16px;
            text-align: left;
            color: while;
            border-right: 1px solid #ddd; /* Đường kẻ trắng giữa các cột */
        }

        /* Đường kẻ trắng giữa các cột */
        th:last-child,
        td:last-child {
            border-right: none;
        }

        /* Table Row Hover Effect */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Product Image Styling */
        td img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Customer Info Section Styling */
        .customer-info {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: #333;
            margin-top: 20px;
        }

        .customer-info h3 {
            margin-bottom: 20px;
            font-size: 22px;
            text-align: left;
            color: #17a2b8; /* Màu tiêu đề thông tin khách hàng */
        }

        .customer-info .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .customer-info .info-item strong {
            color: #333;
            font-weight: 600;
        }

        /* Button Styling */
        a.btn {
            display: inline-block;
            padding: 12px;
            background-color: #17a2b8; /* Màu nút xác nhận */
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            margin-top: 20px;
        }

        a.btn:hover {
            background-color: #138496; /* Màu hover nút */
        }

        /* Responsive Design for smaller screens */
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            td img {
                width: 100px;
                height: 100px;
            }

            h2, h3 {
                font-size: 18px;
            }

            .customer-info .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .customer-info .info-item strong {
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>

    <!-- Order Details Section -->
    <div class="container">
        <h2>Chi tiết đơn hàng</h2>
        <table class="table">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Size</th>
                <th>Ghi chú</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Tổng</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($details_res)) {
                // Lấy thông tin sản phẩm từ tbl_food
                $food_sql = "SELECT title, price, image_name FROM tbl_food WHERE id = {$row['food_id']}";
                $food_res = mysqli_query($conn, $food_sql);
                $food = mysqli_fetch_assoc($food_res);
                $total_price = $row['quantity'] * $food['price'];
            ?>

            <tr>
                <td><?= htmlspecialchars($food['title']) ?></td>
                <td><img src="<?= SITEURL . 'images/food/' . $food['image_name'] ?>" alt="<?= htmlspecialchars($food['title']) ?>" style="width: 200px; height: 200px;"></td>
                <td><?= htmlspecialchars($row['size']) ?></td>
                <td><?= htmlspecialchars($row['note']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= number_format($food['price'], 0, ',', '.') ?> VNĐ</td>
                <td><?= number_format($total_price, 0, ',', '.') ?> VNĐ</td>
            </tr>
            <?php
            }
            ?>

        </table>

        <!-- Customer Information Section -->
        <?php
        $sql2 = "SELECT * FROM users WHERE id = $u_id";
        $res2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_array($res2)) {
            $customer_name = $row2['customer_name'];
            $customer_email = $row2['customer_email'];
            $customer_phone = $row2['customer_contact'];
            $customer_address = $row2['customer_address'];
        }
        ?>

        <div class="customer-info">
            <h3>Thông tin khách hàng</h3>

            <div class="info-item">
                <strong>Họ tên:</strong>
                <p><?php echo $customer_name; ?></p>
            </div>
            <div class="info-item">
                <strong>Email:</strong>
                <p><?php echo $customer_email; ?></p>
            </div>
            <div class="info-item">
                <strong>Số điện thoại:</strong>
                <p><?php echo $customer_phone; ?></p>
            </div>
            <div class="info-item">
                <strong>Địa chỉ:</strong>
                <p><?php echo $customer_address; ?></p>
            </div>

            <!-- The button is now inside the customer-info div -->
            <a href="process_order.php?order_id=<?php echo $order_id ?>" class="btn">Xác nhận đơn hàng</a>
        </div>
    </div>

</body>

</html>

<?php
include("partials/footer.php");
?>
