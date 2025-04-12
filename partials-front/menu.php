<?php
ob_start();
include('config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<style>
    .btn-outline-success {
        width: 150px;
    }

    .custom-nav-link-section {
        background-color: #428B16;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
    }

    .custom-navbar {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .custom-navbar-top {
        display: flex;
        justify-content: flex-end;
        list-style: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .custom-nav-item {
        justify-content: center;
        padding-left: 100px;
        display: inline-block;
        flex: 1;
        text-align: center;
    }

    .custom-nav-item-top {
        display: inline-block;
        padding: 5px;
    }

    .custom-nav-item-top i {
        display: inline-block;
        padding: 3px;
    }

    .custom-nav-link {
        text-decoration: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        white-space: nowrap;
        transition: color 0.3s ease;
    }

    .custom-nav-link-top {
        text-decoration: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        white-space: nowrap;
        transition: color 0.3s ease;
    }

    .separator {
        display: flex;
        align-items: center;
        color: white;
        font-size: 18px;
    }

    .custom-nav-link:hover {
        color: #FFD700;
    }

    .input-group {
        position: relative;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #555;
        font-size: 16px;
        cursor: pointer;
    }

    .form-control {
        padding-right: 35px;
    }

    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
    }

    input[type="search"] {
        -moz-appearance: textfield;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food order</title>
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="asset/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <script src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
    <div class="custom-nav-link-section">
        <ul class="custom-navbar-top">
            <?php if (empty($_SESSION["u_id"])): ?>
                <li class="custom-nav-item-top">
                    <a href="login.php" class="custom-nav-link-top"><i class="fas fa-sign-in-alt"></i>Đăng nhập</a>
                </li>
                <li class="custom-nav-item-top separator">
                    <span>|</span>
                </li>
                <li class="custom-nav-item-top">
                    <a href="register.php" class="custom-nav-link-top"><i class="fas fa-user-plus"></i> Đăng kí</a>
                </li>
            <?php else:
                $u_id = $_SESSION["u_id"];
            ?>
                <li class="custom-nav-item">
                    <a href="logout.php" class="custom-nav-link-top">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a href="http://localhost/Foodordering-main/index.php" class="navbar-brand">
                <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive" width="50px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form action="<?php echo SITEURL; ?>food_search.php" class="d-flex" role="search" method="GET">
                    <div class="input-group">
                        <div class="search-container">
                            <input class="form-control" type="search" name="search" placeholder="Nhập món ăn cần tìm"
                                aria-label="Search"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="search-icon" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if (empty($_SESSION["u_id"])): ?>
                <li class="custom-nav-item">
                    <a href="login.php" class="custom-nav-link">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    </a>
                </li>
            <?php else:
                $u_id = $_SESSION["u_id"]; ?>
                <li class="custom-nav-item">
                    <a href="view_cart.php" class="custom-nav-link">
                        <i class="fas fa-shopping-cart"></i> Giỏ Hàng
                    </a>
                </li>
                <li class="custom-nav-item">
                    <a href="<?php echo SITEURL; ?>user_profile.php?u_id=<?php echo $u_id ?>"
                        class="custom-nav-link"><i class="fas fa-user-circle"></i>Profile</a>
                </li>
            <?php endif; ?>
        </div>
    </nav>
    <div class="custom-nav-link-section">
        <ul class="custom-navbar">
            <li class="custom-nav-item">
                <a href="<?php echo SITEURL; ?>" class="custom-nav-link">Trang chủ</a>
            </li>
            <li class="custom-nav-item">
                <a href="#" class="custom-nav-link">Giới thiệu</a>
            </li>
            <li class="custom-nav-item">
                <a href="categories.php" class="custom-nav-link">Danh mục</a>
            </li>
            <li class="custom-nav-item">
                <a href="foods.php" class="custom-nav-link">Sản phẩm</a>
            </li>
            <li class="custom-nav-item">
                <a href="#" class="custom-nav-link">Liên hệ</a>
            </li>
            <li class="custom-nav-item" style="padding-right: 100px;">
                <a href="#" class="custom-nav-link">Cửa hàng</a>
            </li>
            
            
        </ul>
    </div>
</body>

</html>
