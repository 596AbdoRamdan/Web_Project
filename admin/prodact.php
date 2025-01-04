<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prodauct</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/stlye.css">
</head>

<body>

    <?php
    include 'connect.php';

    // Check if admin is logged in
    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
        exit;
    }

    // MySQL connection details

    if (isset($_POST['add_product'])) {

        $name = $conn->real_escape_string($_POST['name']);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $price = $conn->real_escape_string($_POST['price']);
        $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');
        $category = $conn->real_escape_string($_POST['category']);
        $category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');

        $image = $_FILES['image']['name'];
        $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploded_imge/' . $image;

        $query = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
        $query->bind_param("s", $name);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $message[] = 'Product name already exists!';
        } else {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);

                $insert_query = $conn->prepare("INSERT INTO `products` (name, category, price, image) VALUES (?, ?, ?, ?)");
                $insert_query->bind_param("ssss", $name, $category, $price, $image);
                $insert_query->execute();

                $message[] = 'New product added!';
                $insert_query->close();
            }
        }

        $query->close();
    }
    if (isset($_GET['delete'])) {

        $delete_id = $_GET['delete'];

        $stmt = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch_delete_image = $result->fetch_assoc();

        if ($fetch_delete_image) {
            unlink('uploded_imge/' . $fetch_delete_image['image']); // Delete the image file
        }

        $stmt = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();


        header('location:prodact.php');
    }





    ?>


    <?php include 'componat/admin_header.php' ?>


    <section class="add-products">

        <form action="" method="POST" enctype="multipart/form-data">
            <h3>add product</h3>
            <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
            <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
            <select name="category" class="box" required>
                <option value="" disabled selected>select category --</option>
                <option value="main dish">main dish</option>
                <option value="fast food">fast food</option>
                <option value="drinks">drinks</option>
                <option value="desserts">desserts</option>
            </select>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
            <input type="submit" value="add product" name="add_product" class="btn btn-primary">
        </form>

    </section>


    <section class="show-products" style="padding-top: 0;">

        <div class="box-container">
            <?php

            $query = $conn->prepare("SELECT * FROM `products`");
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
            ?>
                    <div class="box">
                        <img src="uploded_imge/<?= htmlspecialchars($fetch_products['image'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="flex">
                            <div class="price"><span>$</span><?= htmlspecialchars($fetch_products['price'], ENT_QUOTES, 'UTF-8'); ?><span>/-</span></div>
                            <div class="category"><?= htmlspecialchars($fetch_products['category'], ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                        <div class="name"><?= htmlspecialchars($fetch_products['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <!-- Inside the product display (show-products) -->
                        <div class="flex-btn">
                            <a href="update_prodact.php?update=<?= $fetch_products['id']; ?>" class="btn btn-primary">update</a>
                            <a href="prodact.php?delete=<?= $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm('delete this product?');">delete</a>

                        </div>

                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }

            $query->close();

            $conn->close();
            ?>



        </div>

    </section>


    <script src="js/admin_script.js"></script>
</body>

</html>