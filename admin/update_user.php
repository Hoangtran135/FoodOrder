<?php ob_start();
 include('partials/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        /* General Styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Main content styling */
        .main-content {
            width: 70%; /* Set the main content div width */
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
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

        table.tbl-30 input[type="text"] {
            font-size: 16px;
            padding: 10px;
            width: 100%; /* Full width for input fields */
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        table.tbl-30 input[type="submit"] {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%; /* Make button full width */
            margin-top: 15px;
        }

        table.tbl-30 input[type="submit"]:hover {
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

        /* Centering the "Update User" Heading */
        h1 {
            text-align: center;
            color: #333;
            font-size: 30px;
            margin-bottom: 20px;
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
            table.tbl-30 input[type="submit"] {
                width: 100%; /* Ensure all inputs/buttons are full width */
            }
        }

    </style>
</head>
<body>

<div class="main-content">
    <div class="wrapper">
        <h1>Update User</h1>

        <br><br>

        <?php
        // Retrieve user data
        $id = $_GET['id'];

        $sql = "SELECT * FROM users WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['customer_name'];
                $username = $row['username'];
                $customer_email = $row['customer_email'];
                $customer_contact = $row['customer_contact'];
                $customer_address = $row['customer_address'];
            } else {
                header('location:' . SITEURL . 'admin/manage-users.php');
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Họ và tên: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="customer_address" value="<?php echo $customer_address; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update User" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['customer_name'];
    $username = $_POST['username'];
    $customer_email = $_POST['customer_email'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    $sql = "UPDATE users SET
        customer_name = '$full_name',
        username = '$username',
        customer_email = '$customer_email',
        customer_contact = '$customer_contact',
        customer_address = '$customer_address'
        WHERE id='$id'";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['update'] = "<div class='success'>User Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage_user.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update User.</div>";
        header('location:' . SITEURL . 'admin/manage_update.php');
    }
}
?>

<?php include('partials/footer.php'); ?>
</body>
</html>
