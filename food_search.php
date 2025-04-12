<?php include('partials-front/menu.php'); ?>

<html>
    <head>
     
    </head>
<body>
    

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        $search =isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu-section">
    <div class="container">
        <h2 class="section-title">Danh sách món ăn</h2>
        <?php
        if (isset($_SESSION['add_cart_success'])) {
            echo $_SESSION['add_cart_success'];
            unset($_SESSION['add_cart_success']);
        } ?>
        <div class="food-menu-grid">
            <?php
            $limit = 12; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
            $offset = ($page - 1) * $limit; // Calculate offset

           
            $sql ="SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%' LIMIT $limit OFFSET $offset";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count > 0) {
            
                while ($row = mysqli_fetch_assoc($res)) {
                    
                    $id = $row['id'];
                    $title = $row['title'];
    
                    $price = $row['price'];
                    $image_name = $row['image_name'];
            ?>
                 
                        <div class="food-item">
                        <a href="<?php echo SITEURL; ?>food_detail_show.php?food_id=<?php echo $id; ?>" class="food-item-link">
                            <div class="food-image-wrapper">
                                <?php if ($image_name != "") { ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image">
                                <?php } else { ?>
                                    <div class="error">Image not available.</div>
                                <?php } ?>
                            </div>
                            <div class="food-details">
                                <h4 class="food-title"><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?> VND</p>
                                
                            </div>
                            </a>
                        </div>
                   
            <?php
                }
            } else {
                
                echo "<div class='error'>Food not found.</div>";
            }
            ?>
        </div>

        <div class="clearfix"></div>

       
        <div class="pagination">
            <?php
            $total_sql = "SELECT COUNT(*) as total FROM tbl_food WHERE active='Yes'";
            $total_res = mysqli_query($conn, $total_sql);
            $total_row = mysqli_fetch_assoc($total_res);
            $total_products = $total_row['total'];
            $total_pages = ceil($total_products / $limit); 

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='page-number active'>$i</span> "; 
                } else {
                    echo "<a href='?page=$i&search=$search' class='page-number'>$i</a> "; 
                }
            }
            ?>
        </div>
    </div>
</section>
</body>
</html>
<?php include('partials-front/footer.php'); ?>