<?php
$showAlert = false;
$showError = false;
$exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('config/constants.php');

    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $customer_contact = $_POST["customer_contact"];
    $customer_address = $_POST["customer_address"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 0) {
        if ($password == $cpassword && $exists == false) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, customer_name,customer_image, customer_email, customer_contact, customer_address, created_at) 
                    VALUES ('$username', '$hash', '$customer_name','avt_default.jpg', '$customer_email', '$customer_contact', '$customer_address', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }

    if ($num > 0) {
        $exists = "Username not available";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
    <title>Signup</title>
</head>

<body>

    <section class="navbar navbar-light bg-light">
        <div class="container">
            <div class="logo">
                <a href="index.php" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive" style="max-height: 50px;">
                </a>
            </div>
        </div>
    </section>

    <?php
    if ($showAlert) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your account is now created and you can <a href="login.php">login.</a> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button> 
        </div> ';
    }

    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
            <strong>Error!</strong> ' . $showError . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span> 
            </button> 
        </div> ';
    }

    if ($exists) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $exists . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button>
        </div> ';
    }
    ?>

    <div class="container my-5">
        <h2 class="text-center">Signup Here</h2>
        <form action="" method="post">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_name">Full Name</label>
                    <input type="text" class="form-control" name="customer_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    <small id="emailHelp" class="form-text text-muted">Make sure to type the same password</small>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="customer_email">Email</label>
                    <input type="email" class="form-control" name="customer_email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_contact">Phone</label>
                    <input type="number" class="form-control" name="customer_contact" required>
                    <small id="emailHelp" class="form-text text-muted">Please Enter a valid 10 digit mobile number</small>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="customer_address">Address</label>
                <textarea class="form-control" name="customer_address" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">SignUp</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>