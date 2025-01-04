<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="category">
    <h1 class="title">Food Category</h1>
    <div class="box-container">

        <a href="category.php?category=fast food" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fast food</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>main dishes</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a>

    </div>
</section>

<section class="products">
    <h1 class="title">Latest Dishes</h1>
    <div class="box-container">
        <?php
        $query = "SELECT * FROM products LIMIT 6";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($fetch_products = $result->fetch_assoc()) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                    <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                    <img src="admin/uploded_imge/<?= $fetch_products['image']; ?>" alt="">
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="flex">
                        <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>
    </div>
    <div class="more-btn">
        <a href="menu.php" class="btn">View All</a>
    </div>
</section>

<?php include 'components/footer.php'; ?>


<!-- custom js file link  -->
<script src="js/script.js"></script>



</body>
</html>
