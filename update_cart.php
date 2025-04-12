    <?php
    include('config/constants.php');

    if (isset($_POST['food_id']) && isset($_POST['quantity'])) {
        $food_id = $_POST['food_id'];
        $quantity = $_POST['quantity'];
        $size = $_POST['size'];

        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (isset($_SESSION['cart'][$food_id])) {
            // Cập nhật số lượng
            $_SESSION['cart'][$food_id]['quantity'] = $quantity;
            $_SESSION['cart'][$food_id]['total_price'] = $_SESSION['cart'][$food_id]['price'] * $quantity;
            $_SESSION['cart'][$food_id]['size'] = $size;
        }

        header("Location: view_cart.php");
        exit();
    } else {
        // Nếu không có food_id hoặc quantity, chuyển về trang giỏ hàng
        header("Location: view_cart.php");
        exit();
    }
    $stmt = $conn->prepare("SELECT price FROM tbl_food WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $response = [];
    if ($product = $res->fetch_assoc()) {
        $price = $product['price'];


        if (!isset($size)) {
            $size = $_SESSION['cart'][$food_id]['size'] ?? 'S';
        }
        if ($size == 'M') {
            $price *= 1.10;
        } elseif ($size == 'L') {
            $price *= 1.20;
        }


        $item_total = $price * $quantity;
        $response['item_total'] = number_format($item_total, 0, ',', '.');

        $total_price = 0;
        foreach ($_SESSION['cart'] as $id => $details) {
            $total_price += $details['total_price'];
        }
        $response['total_price'] = number_format($total_price, 0, ',', '.');
    }
    $stmt->close();
    echo json_encode($response);
