<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">

    <section class="flex">

        <a href="home.php" class="logo">Elshabrawy &#128076</a>

        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="menu.php">menu</a>
            <a href="orders.php">orders</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <?php
            // Initialize cart item count
            $total_cart_items = 0;
            if (isset($user_id)) {
                // Count cart items for the user
                $stmt = $conn->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->bind_result($total_cart_items);
                $stmt->fetch();
                $stmt->close();
            }
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>

        <div class="profile">
            <?php
            if (isset($user_id)) {
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $fetch_profile = $result->fetch_assoc();
            ?>
                    <p class="name"><?= htmlspecialchars($fetch_profile['name']); ?></p>
                    <div class="flex">
                        <a href="profile.php" class="btn">profile</a>
                        <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
                    </div>
                    <p class="account">
                        <a href="login.php">login</a> or
                        <a href="register.php">register</a>
                    </p>
            <?php
                } else {
            ?>
                    <p class="name">please login first!</p>
                    <a href="login.php" class="btn">login</a>
            <?php
                }
                $stmt->close();
            } else {
            ?>
                <p class="name">please login first!</p>
                <a href="login.php" class="btn">login</a>
            <?php
            }
            ?>
        </div>

    </section>

</header>
