<?php include('partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">Danh mục sản phẩm </h2>

        <div class="categories-grid ">
            <?php
            // Display all the categories that are active
            // SQL Query
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count Rows
            $count = mysqli_num_rows($res);

            // Check whether categories are available or not
            if ($count > 0) {
                // Categories Available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the Values
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="category-item">
                        <a href="<?php echo SITEURL; ?>category_foods.php?category_id=<?php echo $id; ?>" class="category-link">
                            <div class="category-image-wrapper">
                                <?php if ($image_name != "") { ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="category-image">
                                <?php } else { ?>
                                    <div class="error">Image not Available</div>
                                <?php } ?>
                            </div>
                            <h3 class="category-title"><?php echo $title; ?></h3>
                        </a>
                    </div>

            <?php
                }
            } else {
                echo "<div class='error text-center'>Category not Added.</div>";
            }
            ?>
        </div>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>