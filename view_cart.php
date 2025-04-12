<?php
include('partials-front/menu.php');
?>
<html>
<style>.cart-container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

h2 {
    text-align: left;
    font-size: 1.8em;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    background-color: #fff;
}

/* Table header styling */
.table th {
    background-color: #428b16;
    color: white;
    padding: 12px;
    text-align: center;
    border: 1px solid #ebebeb;
    font-weight: bold;
}

.table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ebebeb;
}

.table td img {
    width: 60px;
    height: auto;
    border-radius: 8px;
}

/* Button colors */
.btn-danger {
    background-color: red;
    color: white;
}

.btn-danger:hover {
    background-color: #d9534f;
}

.btn {
    padding: 5px 15px;
    text-align: center;
    border: none;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.btn-primary, .btn-success {
    background-color: #51aa1b;
    color: white;
    height: 50px;
}

.btn-primary:hover, .btn-success:hover {
    background-color: #4e9a1a;
}

/* Adjusting the layout for buttons and total */
.btn-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px; /* Added gap between buttons */
}

.total-container {
    font-size: 1.2em;
    font-weight: bold;
    color: #333;
    display: flex;
    justify-content: space-between; /* Align items in one row */
    align-items: center;
    width: 100%;
}

/* Total Price styling - spread across the space */
.total-container .total-price {
    flex-grow: 1; /* Allow total price to take up remaining space */
    text-align: left;
}

/* Buttons container layout */
.btn-container button {
    width: 150px; /* Buttons take 150px width */
}

.btn-container button:hover {
    background-color: #4e9a1b;
}

/* Wrapper for the total price and buttons */
.total-container-wrapper {
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}

/* Styling the total container */
.total-container {
    display: flex;
    justify-content: space-between; /* Make it horizontal */
    align-items: center;
    gap: 10px; /* Add gap between the items */
    width: 100%;
}

.total-price p {
    font-size: 1.5em;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

/* Buttons container styling */
.btn-container {
    display: flex;
    gap: 10px;
    justify-content: flex-end; /* Align buttons to the right */
    width: 100%;
}

.btn-container button {
    width: 170px;
    font-size: 16px;
}

/* Input Fields Styling */
input[type="number"] {
    width: 50px;
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
}

select {
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

/* Textarea for order notes */
textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    margin-top: 10px;
    resize: vertical;
}

/* Error message styling */
.error {
    color: red;
    font-weight: bold;
}

/* Styling the individual buttons */
.btn-container button:hover {
    background-color: #4e9a1a;
}


</style>

<h2>Giỏ hàng của bạn</h2>
<form action="payment.php" method="post">
    <div class="cart-container">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
            <table class='table'>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Tổng</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>

                <?php $total_price = 0;
                foreach ($_SESSION['cart'] as $food_id => $details) {
                    if (!is_numeric($food_id)) continue;
                    $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE id = ?");
                    $stmt->bind_param("i", $food_id);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($product = $res->fetch_assoc()) {
                        $title = $product['title'];
                        $image_name = $product['image_name'];
                        $price = $product['price'];
                        $quantity = $details['quantity'];
                        $size = isset($details['size']) ? $details['size'] : 'S';
                        $item_total = $price * $quantity;

                        if ($size == 'M') $item_total *= 1.10;
                        elseif ($size == 'L') $item_total *= 1.20; ?>

                        <tr>
                            <td><?= $title ?></td>
                            <td>
                                <?php if ($image_name != "") { ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image">
                                <?php } else { ?>
                                    <div class="error">Hình ảnh không có.</div>
                                <?php } ?>
                            </td>
                            <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                            <td>
                                <input type='number' name='quantity[<?= $food_id ?>]' value='<?= $quantity ?>' min='1' style='width: 50px;' onchange='updateQuantity(this, <?= $food_id ?>)' />
                            </td>
                            <td>
                                <select name='size[<?= $food_id ?>]' onchange='updateSize(this, <?= $food_id ?>)'>
                                    <option value='S' <?= ($size == 'S' ? 'selected' : '') ?>>S</option>
                                    <option value='M' <?= ($size == 'M' ? 'selected' : '') ?>>M</option>
                                    <option value='L' <?= ($size == 'L' ? 'selected' : '') ?>>L</option>
                                </select>
                            </td>
                            <td id='item-total-<?= $food_id ?>'><?= number_format($item_total, 0, ',', '.') ?> VND</td>
                            <td>
                                <textarea name="note" cols="30" rows="5" placeholder="Ghi chú cho cửa hàng"></textarea>
                            </td>
                            <td>
                                <a href='remove_cart.php?food_id=<?= $food_id ?>' class='btn btn-danger'>Xóa</a>
                            </td>
                        </tr>

                        <?php $total_price += $item_total; ?>
                    <?php } ?>
                    <?php $stmt->close(); ?>
                <?php } ?>

                <?php foreach ($_SESSION['cart'] as $food_id => $details) { ?>
                    <input type="hidden" name="cart[<?= $food_id ?>][quantity]" value="<?= $details['quantity'] ?>" />
                    <input type="hidden" name="cart[<?= $food_id ?>][size]" value="<?= (isset($details['size']) ? $details['size'] : 'S') ?>" />
                <?php } ?>

            </table>
        <?php } else { ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php } ?>

        <!-- Total Price and Buttons Section -->
        <div class="total-container-wrapper">
            <div class="total-container">
                <div class="total-price">
                    <p>Tổng cộng: <strong id="total-price"><?= number_format($total_price, 0, ',', '.') ?> VND</strong></p>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-success">Đặt hàng</button>
                    <button type="button" class="btn btn-primary" onclick='updateCart()'>Cập nhật giỏ hàng</button>
                </div>
            </div>
        </div>

        <input type="hidden" name="total_price" value="<?= $total_price ?>" />
    </div>
</form>

<script>
    // Update cart quantities and sizes with AJAX
    function updateQuantity(input, food_id) {
        let quantity = input.value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                document.getElementById(item-total-${food_id}).innerText = response.item_total + " VND";
                document.getElementById('total-price').innerText = response.total_price + " VND";
            }
        };

        xhr.send("food_id=" + food_id + "&quantity=" + quantity);
    }

    function updateSize(select, food_id) {
        let size = select.value;
        let quantity = document.querySelector(input[name="quantity[${food_id}]"]).value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                document.getElementById(item-total-${food_id}).innerText = response.item_total + " VND";
                document.getElementById('total-price').innerText = response.total_price + " VND";
            }
        };

        xhr.send("food_id=" + food_id + "&quantity=" + quantity + "&size=" + size);
    }

    // Function to reload the page to apply updates
    function updateCart() {
        location.reload();
    }
</script>

</html>

<?php
include('partials-front/footer.php');
?>