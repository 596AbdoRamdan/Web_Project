<?php

if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:login.php');
    } else {

        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Check if the item is already in the cart
        $stmt = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $name, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message[] = 'Already added to cart!';
        } else {
            // Insert the item into the cart
            $stmt = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissis", $user_id, $pid, $name, $price, $qty, $image);
            $stmt->execute();
            $message[] = 'Added to cart!';
        }

        $stmt->close();
    }
}

?>
