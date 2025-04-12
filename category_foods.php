<?php include('partials-front/menu.php'); ?>

<?php
// Check whether id is passed or not
if (isset($_GET['category_id'])) {
    // Category id is set and get the id
    $category_id = $_GET['category_id'];
    // Get the Category Title Based on Category ID
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Get the value from Database
    $row = mysqli_fetch_assoc($res);
    // Get the Title
    $category_title = $row['title'];
} else {
    // Category not passed
    // Redirect to Home page
    header('location:' . SITEURL);
}
?>

<section class="food-search text-center py-5 ">
    <div class="container">
        <h2 class="display-6"><span class="text-primary-food"><?php echo $category_title; ?></span></h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu section">
    <div class="container">
        <h2 class="section-title">Món ăn</h2>

        <div class="food-menu-grid">
            <?php
            $limit = 12;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id LIMIT $limit OFFSET $offset";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // Count the Rows
            $count2 = mysqli_num_rows($res2);

            // Check whether food is available or not
            if ($count2 > 0) {
                // Food is Available
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
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
                            <form action="<?php echo SITEURL; ?>carts.php?food_id=<?php echo $id; ?>" method="POST" class="add-to-cart-form">
                                    <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                    <label for="quantity-<?php echo $id; ?>">Số lượng:</label>
                                    <input type="number" name="quantity" id="quantity-<?php echo $id; ?>" value="1" min="1" class="quantity-input">
                                    <button type="submit" class="btn btn-add-to-cart">Thêm vào giỏ</button>
                                </form>
                        </div>
            <?php
                }
            } else {
                // Food not Available
                echo "<div class='error'>Food not found.</div>";
            }
            ?>

        </div>
        <div class="clearfix"></div>
        <div class="pagination">
            <?php
            // Get total number of products
            $total_sql = "SELECT COUNT(*) as total FROM tbl_food WHERE category_id=$category_id";
            $total_res = mysqli_query($conn, $total_sql);
            $total_row = mysqli_fetch_assoc($total_res);
            $total_products = $total_row['total'];
            $total_pages = ceil($total_products / $limit); // Calculate total pages

            // Display pagination links
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='page-number active'>$i</span> "; // Current page
                } else {
                    echo "<a href='?page=$i' class='page-number'>$i</a> "; // Other pages
                }
            }
            ?>
        </div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>