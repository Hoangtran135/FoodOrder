<?php include('config/constants.php');

$u_id = $_SESSION['u_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = json_decode($_POST['cart'], true);
    $note = $_POST['note'];
    $grand_total = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $sql = "INSERT INTO tbl_order SET
        order_date = NOW(),
        total_amount = $grand_total,
        payment_method = $payment_method,
        status = 1 ,
        u_id = $u_id
    ";
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $order_id = $conn->insert_id; 

      
        $sql_order_details = "INSERT INTO tbl_order_details (order_id, food_id,size,note,quantity, price,status) VALUES (?, ?, ?, ?,?,?,?)";
        $stmt_details = $conn->prepare($sql_order_details);

        foreach ($cart as $food_id => $details) {
            $quantity = $details['quantity'];
            $size = $details['size'];       
            $sql_food = "SELECT price FROM tbl_food WHERE id = ?";
            $stmt_food = $conn->prepare($sql_food);
            $stmt_food->bind_param("i", $food_id);
            $stmt_food->execute();
            $res_food = $stmt_food->get_result();
            $food = $res_food->fetch_assoc();
            $status=1;

            if ($food) {
                $price = $food['price'];

               
                if ($size == 'M') {
                    $price *= 1.10; 
                } elseif ($size == 'L') {
                    $price *= 1.20; 
                }

                $stmt_details->bind_param("iissidi", $order_id, $food_id, $size,$note, $quantity, $price,$status);
                $stmt_details->execute();
            }
        }
        $_SESSION['payment_success'] = "<div class='success'>Đặt hàng thành công</div>";
        header('location:' . SITEURL . 'myorders.php');
    } else {
        $_SESSION['payment_success'] = "<div class='error'>Đặt hàng thất bại</div>";
    }
} else {
    header('location:' . SITEURL . 'view_cart.php');
}
