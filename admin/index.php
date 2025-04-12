<?php
include('partials/header.php');
?>
<html>
<head>
    <style>
        /* Global Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif; /* Đồng bộ font chữ */
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        .main-content {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 1200px;
        }

        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }

        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .stat-box {
            flex: 1 1 calc(25% - 20px); /* Four columns layout with spacing */
            background-color: #17a2b8; /* Bootstrap info color */
            color: white; /* Default text color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-box h1 {
            font-size: 36px;
            margin: 0;
            color: #343a40; /* Updated text color */
        }

        .stat-box p {
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
            color: #343a40; /* Updated text color */
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stat-box {
                flex: 1 1 100%; /* Full width on smaller screens */
            }
        }

        .alert {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .text-center {
            text-align: center;
        }

        /* Optional: For better visual styling */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        /* Navbar adjustments */
        .navbar {
            background-color: #343a40;
            padding: 10px 20px;
        }

        .navbar-brand {
            font-size: 1.8em;
            font-weight: bold;
            color: #ffffff !important;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <div class="wrapper">
            <h1 class="text-center">Dashboard</h1>
            <br><br>

            <!-- Example success alert message -->
            <?php if (isset($alertMessage)) { ?>
                <div class="alert">
                    <?php echo $alertMessage; ?>
                </div>
            <?php } ?>

            <!-- Dashboard Stats Section -->
            <div class="dashboard-stats">
                <!-- Categories Stat Box -->
                <div class="col-4 text-center stat-box">
                    <a href="manage_category.php">
                        <?php
                        $sql = "SELECT COUNT(*) AS categoryCount FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($res);
                        $categoryCount = $row['categoryCount'];
                        ?>
                        <h1><?php echo $categoryCount; ?></h1>
                        <p>Categories</p>
                    </a>
                </div>

                <!-- Food Stat Box -->
                <div class="col-4 text-center stat-box">
                    <a href="manage_food.php">
                        <?php
                        $sql2 = "SELECT COUNT(*) AS foodCount FROM tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($res2);
                        $foodCount = $row2['foodCount'];
                        ?>
                        <h1><?php echo $foodCount; ?></h1>
                        <p>Food</p>
                    </a>
                </div>

                <!-- Orders Stat Box -->
                <div class="col-4 text-center stat-box">
                    <a href="manage_order.php">
                        <?php
                        $sql3 = "SELECT COUNT(*) AS orderCount FROM tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $row3 = mysqli_fetch_assoc($res3);
                        $orderCount = $row3['orderCount'];
                        ?>
                        <h1><?php echo $orderCount; ?></h1>
                        <p>Orders</p>
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</body>

</html>

<?php
include('partials/footer.php');
?>
