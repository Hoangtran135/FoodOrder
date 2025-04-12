<?php
include('partials-front/menu.php');
$u_id = $_SESSION['u_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart'])) {
    $cart = $_POST['cart'];
    $total_price = $_POST['total_price'];
    $note = $_POST['note'];
?>

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
            width: 150px;
            height: auto;
            border-radius: 8px;
        }

        /* Form and Button Styling */
        .form-group {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-success {
            background-color: #51aa1b;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #4e9a1a;
        }

        /* Table Style for the Grand Total */
        .table tfoot tr td {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .table .error {
            color: red;
            font-weight: bold;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .table td, .table th {
                font-size: 12px;
                padding: 8px;
            }

            .table td img {
                width: 120px;
            }

            .form-group label, .form-control {
                font-size: 14px;
            }

            .btn-success {
                width: 100%;
                padding: 12px;
                font-size: 18px;
            }
        }
    </style>

    <h2>Thông tin đặt hàng</h2>
    
    <table class="table">
        <tr>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Size</th>
            <th>Ghi chú</th>
            <th>Tổng</th>
        </tr>

        <?php
        $grand_total = 0;

        foreach ($cart as $food_id => $details) {
            $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
            $stmt->bind_param("i", $food_id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($product = $res->fetch_assoc()) {
                $title = $product['title'];
                $image_name = $product['image_name'];
                $price = $product['price'];
                $quantity = $details['quantity'];
                $size = $details['size'];
                $item_total = $price * $quantity;

                if ($size == 'M') {
                    $item_total *= 1.10;
                } elseif ($size == 'L') {
                    $item_total *= 1.20;
                }
        ?>
                <tr>
                    <td width="250px"><?= htmlspecialchars($title) ?></td>
                    <td style="width: 200px">
                        <?php if ($image_name != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image" width="150px">
                        <?php } else { ?>
                            <div class="error">Image not available.</div>
                        <?php } ?>
                    </td>
                    <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                    <td><?= htmlspecialchars($quantity) ?></td>
                    <td><?= htmlspecialchars($size) ?></td>
                    <td><?= htmlspecialchars($note) ?></td>
                    <td><?= number_format($item_total, 0, ',', '.') ?> VND</td>
                </tr>
        <?php
                $grand_total += $item_total;
            }
            $stmt->close();
        }
        ?>
        <tr>
            <td colspan='4'><strong>Tổng cộng</strong></td>
            <td></td>
            <td><strong><?= number_format($grand_total, 0, ',', '.') ?> VND</strong></td>
        </tr>
    </table>
    
    <form action="process_payment.php" method="post">
        <input type="hidden" name="cart" value='<?= json_encode($cart) ?>'>
        <input type="hidden" name="note" value='<?= json_encode($note) ?>'>
        <input type="hidden" name="total_price" value="<?= $grand_total ?>">
        
        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán:</label>
            <select name="payment_method" id="payment_method" class="form-control" required> 
                <?php
                $sql = "SELECT * FROM tbl_payment";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $pm_id = $row['pm_id'];
                        $pm_name = $row['pm_name'];
                        echo "<option value='$pm_id'>$pm_name</option>";
                    }
                } else {
                    echo "<option value=''>Không có phương thức thanh toán nào</option>";
                }
                ?>
            </select>     
        </div>

        <input type="submit" class="btn btn-success" value="Xác nhận đặt hàng">
    </form>

<?php
} else {
?>
    <p>Không có thông tin giỏ hàng.</p>
<?php
}

include('partials-front/footer.php');
?>
