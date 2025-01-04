<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/stlye.css">
</head>

<body>
    <?php
    include 'connect.php';

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
        exit;
    }

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");

        $delete_admin->bind_param("i", $delete_id);


        if ($delete_admin->execute()) {
            header('Location: admins_accounts.php');
        } else {
            echo "Error: Unable to delete account.";
        }
        $delete_admin->close();
    }

    ?>
    <?php include 'componat/admin_header.php' ?>
    <section class="accounts">
        <h1 class="heading">admins account</h1>
        <div class="box-countaner">

            <div class="box">
                <p>register new admin</p>
                <a href="index_reg.php" class="btn btn-primary">register</a>
            </div>

            <?php
            $select_account = $conn->query("SELECT * FROM `admin`");

            if ($select_account->num_rows > 0) {
                while ($fetch_accounts = $select_account->fetch_assoc()) {
            ?>
                    <div class="box">
                        <p> admin id : <span><?= htmlspecialchars($fetch_accounts['id']); ?></span> </p>
                        <p> username : <span><?= htmlspecialchars($fetch_accounts['name']); ?></span> </p>
                        <div class="flex-btn">
                            <a href="admins_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?');">delete</a>
                            <?php
                            if ($fetch_accounts['id'] == $admin_id) {
                                echo '<a href="update_account.php" class="btn btn-primary">update</a>';
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No accounts available</p>';
            }
            ?>


        </div>
    </section>
    <script src="js/admin_script.js"></script>
</body>

</html>