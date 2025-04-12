<?php include('partials-front/menu.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
            font-family: Arial, sans-serif;
        }

        .main-body {
            padding: 0;
        }

        .card {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            border: none;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
            background-color: #fff;
        }

        .card-body {
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .text-secondary {
            color: #718096 !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        a.btn-outline-primary {
            border: 1px solid #007bff;
            color: #007bff;
            padding: 0.375rem 0.75rem;
            text-decoration: none;
            border-radius: 0.25rem;
            font-weight: 500;
            transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        a.btn-outline-primary:hover {
            color: #fff;
            background-color: #007bff;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <?php
    // Check if u_id exists in URL
    if (isset($_GET['u_id']) && is_numeric($_GET['u_id'])) {
        $u_id = $_GET['u_id'];

        // Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $u_id);
        $stmt->execute();
        $res = $stmt->get_result();
        
        // Fetch the result if user exists
        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $username = $row['username'];
            $full_name = $row['customer_name'];
            $email = $row['customer_email'];
            $image = $row['customer_image'];
            $contact = $row['customer_contact'];
            $address = $row['customer_address'];
        } else {
            echo "<div class='alert alert-danger'>User not found</div>";
            exit();
        }
    }

    // Display success message after update
    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
    ?>

    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="images/user/<?php echo $image; ?>" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?php echo $username; ?></h4>
                                    <a href="message.php?u_id=<?php echo $u_id; ?>" class="btn btn-outline-primary">Message</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?php echo $full_name; ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone Number</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?php echo $contact; ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?php echo $address; ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-info" href="edit_profile.php?u_id=<?php echo $u_id; ?>">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
