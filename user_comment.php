<?php
include('config/constants.php');
if (isset($_GET['food_id']) && is_numeric($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .comment-form {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .comment-form h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        textarea.form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        input[type="file"].form-control-file {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label.star {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked + label.star {
            color: #f39c12;
        }

        button.btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="comment-form mt-5">
        <h2>Đánh giá</h2>
        <form action="review_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="food_id" value="<?php echo $food_id; ?>" />
            <div class="form-group">
                <textarea name="comment" id="comment" class="form-control" placeholder="Thêm đánh giá của bạn" required></textarea>
            </div>

            <!-- Star Rating -->
            <div class="form-group">
                <label for="rating">Rating: </label><br>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1" class="star">&#9733;</label>

                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2" class="star">&#9733;</label>

                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3" class="star">&#9733;</label>

                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4" class="star">&#9733;</label>

                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5" class="star">&#9733;</label>
            </div>

            <div class="form-group">
                <label for="image">Thêm hình ảnh: </label>
                <input type="file" name="image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Đánh giá</button>
        </form>
    </div>
</body>
<script>
    const stars = document.querySelectorAll('.star');
    const form = document.querySelector('form');
    
    function highlightStars(index) {
        stars.forEach((star, i) => {
            star.style.color = i <= index ? '#f39c12' : '#ccc';
        });
    }
    
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            highlightStars(index);
        });
    });
    
    window.addEventListener('load', () => {
        highlightStars(4); // Default to 5 stars
        document.getElementById('star5').checked = true; 
    });
    
    form.addEventListener('submit', function (e) {
        const imageInput = document.querySelector('input[name="image"]');
        if (!imageInput.files || imageInput.files.length === 0) {
            e.preventDefault(); 
            alert('Bạn phải tải lên ít nhất một hình ảnh!');
        }
    });
</script>
</html>
