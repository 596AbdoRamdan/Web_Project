<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ordars</title>
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
    if (isset($_POST['update_payment'])) {

        $order_id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];

        $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");

        $update_status->bind_param("si", $payment_status, $order_id);

        if ($update_status->execute()) {
            $message[] = 'Payment status updated!';
        } else {
            $message[] = 'Error: Unable to update payment status.';
        }

        $update_status->close();
    }
    if (isset($_GET['delete'])) {

        $delete_id = $_GET['delete'];

        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");

        $delete_order->bind_param("i", $delete_id);

        if ($delete_order->execute()) {
            header('Location: porders.php');
            exit();
        } else {
            echo "Error: Unable to delete the order.";
        }

        $delete_order->close();
    }

    ?>
    <?php include 'componat/admin_header.php' ?>

    <section class="placed-orders">
        <h1 class="heading">placed orders</h1>
        <div class="box-container">

            <?php
            $select_account = $conn->query("SELECT * FROM `orders`");

            if ($select_account->num_rows > 0) {
                while ($fetch_accounts = $select_account->fetch_assoc()) {
            ?>
                    <div class="box">
                        <p> user id : <span><?= htmlspecialchars($fetch_accounts['user_id']); ?></span> </p>
                        <p> placed on : <span><?= htmlspecialchars($fetch_accounts['placed_on']); ?></span> </p>
                        <p> anme : <span><?= htmlspecialchars($fetch_accounts['name']); ?></span> </p>
                        <p> email : <span><?= htmlspecialchars($fetch_accounts['email']); ?></span> </p>
                        <p> number : <span><?= htmlspecialchars($fetch_accounts['number']); ?></span> </p>
                        <p> address : <span><?= htmlspecialchars($fetch_accounts['address']); ?></span> </p>
                        <p> total products : <span><?= htmlspecialchars($fetch_accounts['total_products']); ?></span> </p>
                        <p> total price : <span><?= htmlspecialchars($fetch_accounts['total_price']); ?></span> </p>
                        <p> payment method : <span><?= htmlspecialchars($fetch_accounts['method']); ?></span> </p>
                        <form action="" method="POST">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_accounts['id']); ?>">
                            <select name="payment_status" class="drop-down">
                                <option value="" selected disabled><?= htmlspecialchars($fetch_accounts['payment_status']); ?>option>
                                <option value="pending">pending</option>
                                <option value="completed">completed</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" value="update" class="btn btn-primary" name="update_payment">
                                <a href="porders.php?delete=<?= htmlspecialchars($fetch_accounts['id']); ?>" class="btn btn-danger" onclick="return confirm('delete this order?');">delete</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p empty">no orders placed yet!</p>';
            }
            ?>
        </div>
    </section>
    <script src="js/admin_script.js"></script>
</body>

</html>