<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/stlye.css">
</head>

<body>

    <?php include 'connect.php' ?>
    <?php


    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    };
    ?>
    <?php include 'componat/admin_header.php' ?>
    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-containers3">

            <div class="boxs3">
                <h3>welcome!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update_account.php" class="btn btn-primary">update profile</a>
            </div>

            <div class="boxs3">
                <?php
                $total_pendings = 0;
                $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'");
                while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
                    $total_pendings += $fetch_pendings['total_price'];
                }
                ?>
                <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
                <p>total pendings</p>
                <a href="porders.php" class="btn btn-primary">see orders</a>
            </div>

            <div class="boxs3">
                <?php
                $total_completes = 0;
                $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'");
                while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
                    $total_completes += $fetch_completes['total_price'];
                }
                ?>
                <h3><span>$</span><?= $total_completes; ?><span>/-</span></h3>
                <p>total completes</p>
                <a href="porders.php" class="btn btn-primary">see orders</a>
            </div>

            <div class="boxs3">
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`");
                $numbers_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?= $numbers_of_orders; ?></h3>
                <p>total orders</p>
                <a href="porders.php" class="btn btn-primary">see orders</a>
            </div>

            <div class="boxs3">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                $numbers_of_products = mysqli_num_rows($select_products);
                ?>
                <h3><?= $numbers_of_products; ?></h3>
                <p>products added</p>
                <a href="prodact.php" class="btn btn-primary">see products</a>
            </div>

            <div class="boxs3">
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users`");
                $numbers_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?= $numbers_of_users; ?></h3>
                <p>users accounts</p>
                <a href="users_accounts.php" class="btn btn-primary">see users</a>
            </div>

            <div class="boxs3">
                <?php
                $select_admins = mysqli_query($conn, "SELECT * FROM `admin`");
                $numbers_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?= $numbers_of_admins; ?></h3>
                <p>admins</p>
                <a href="admins_accounts.php" class="btn btn-primary">see admins</a>
            </div>

            <div class="boxs3">
                <?php
                $select_messages = mysqli_query($conn, "SELECT * FROM `messages`");
                $numbers_of_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?= $numbers_of_messages; ?></h3>
                <p>new messages</p>
                <a href="mails.php" class="btn btn-primary">see messages</a>
            </div>

        </div>

    </section>

    <script src="js/admin_script.js"></script>
</body>

</html>