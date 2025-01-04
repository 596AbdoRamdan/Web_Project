<?php

include 'connect.php';



$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($pid && $name && $price && $category) {
        $stmt = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $category, $price, $pid);
        $stmt->execute();
        $message[] = 'Product updated!';
    } else {
        $message[] = 'Invalid input data!';
    }

    $old_image = filter_input(INPUT_POST, 'old_image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!empty($_FILES['image']['name'])) {
        $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = 'uploded_imge/' . $image;

        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $stmt = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $stmt->bind_param("si", $image, $pid);
            $stmt->execute();
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($old_image) {
                unlink('uploded_imge/' . $old_image);
            }
            $message[] = 'Image updated!';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/stlye.css">

</head>

<body>
    <?php include 'componat/admin_header.php' ?>

    <!-- update product section starts  -->

    <section class="update-product">
        <div class="form-container1">
            <h1 class="heading">Update Product</h1>
            <?php
            $update_id = $_GET['update'];
            $stmt = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $stmt->bind_param("i", $update_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
            ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                        <img src="uploded_imge/<?= htmlspecialchars($fetch_products['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image">
                        <span>Update Name</span>
                        <input type="text" required placeholder="Enter product name" name="name" class="box1" maxlength="100" value="<?= htmlspecialchars($fetch_products['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        <span>Update Price</span>
                        <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" class="box1" value="<?= htmlspecialchars($fetch_products['price'], ENT_QUOTES, 'UTF-8'); ?>">
                        <span>Update Category</span>
                        <select name="category" class="box1" required>
                            <option selected value="<?= htmlspecialchars($fetch_products['category'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($fetch_products['category'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <option value="main dish">Main Dish</option>
                            <option value="fast food">Fast Food</option>
                            <option value="drinks">Drinks</option>
                            <option value="desserts">Desserts</option>
                        </select>
                        <span>Update Image</span>
                        <input type="file" name="image" class="box1" accept="image/jpg, image/jpeg, image/png, image/webp">
                        <div class="flex-btn">
                            <input type="submit" value="Update" class="btn" name="update">
                            <a href="prodact.php" class="option-btn">Go Back</a>
                        </div>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>
    </section>


    <script src="js/admin_script.js"></script>
    <!-- update product section ends -->



</body>

</html>