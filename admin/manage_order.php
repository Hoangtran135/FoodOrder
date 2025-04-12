<?php
include("partials/header.php");
$sql = "SELECT tbl_order.*, users.customer_name FROM tbl_order JOIN users ON tbl_order.u_id = users.id WHERE tbl_order.status IN (1, 2)";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <style>
        /* General Page Layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Main Content Container */
        .main-content {
            background-color: #ffffff;
            padding: 30px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1100px; /* Reduced width for smaller table */
        }

        /* Page Title */
        h1 {
            font-size: 32px;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px; /* Reduced margin */
        }

        /* Outer Table Wrapper */
        .table-wrapper {
            margin: 20px 0;
            overflow-x: auto; /* Allows horizontal scrolling if needed */
            padding: 10px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px; /* Reduced font size for a smaller table */
        }

        table th,
        table td {
            text-align: center;
            padding: 10px 12px; /* Reduced padding */
            border: 1px solid #ddd;
        }

        table th {
            background-color: #17a2b8; /* Header color */
            color: white;
            font-size: 14px; /* Slightly larger font size for header */
        }

        table tr:nth-of-type(even) {
            background-color: #f9f9f9;
        }

        /* Buttons Styling */
        button {
            padding: 6px 12px; /* Reduced padding */
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* View Details Button */
        button.view-btn {
            background-color: #17a2b8;
            color: white;
        }

        button.view-btn:hover {
            background-color: #117a8b;
        }

        /* Cancel Button */
        button.cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        button.cancel-btn:hover {
            background-color: #c82333;
        }

        /* Alerts */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
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

        /* Pagination or Additional Buttons */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination a {
            text-decoration: none;
            padding: 8px 15px;
            margin: 0 5px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            table th,
            table td {
                padding: 8px 10px;
                font-size: 12px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <h1>Quản lý Đơn Hàng</h1>

        <!-- Outer Div for Table Wrapper -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng số tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tình trạng</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Hủy</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    while ($row = mysqli_fetch_array($res)) {
                        $customer_name = $row['customer_name'];
                        $order_date = $row['order_date'];
                        $total_amount = $row['total_amount'];
                        $payment_method_id = $row['payment_method'];
                        $payment_sql = "SELECT pm_name FROM tbl_payment WHERE pm_id = $payment_method_id";
                        $payment_res = mysqli_query($conn, $payment_sql);
                        $payment_row = mysqli_fetch_assoc($payment_res);
                        $payment_name = $payment_row['pm_name'];
                        $status = (($row['status'] == 1) ? 'Đang đặt hàng' : 'Đang giao hàng');
                    ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo number_format($total_amount, 0, '', '.'); ?> VND</td>
                            <td><?php echo $payment_name; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><button class="view-btn" onclick="window.location.href='view_order_detail.php?order_id=<?php echo $row['id']; ?>'">Xem chi tiết</button></td>
                            <td><button class="cancel-btn" onclick="window.location.href='cancel_order.php?id=<?php echo $row['id']; ?>'">Hủy</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php
include("partials/footer.php");
?>
