<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/stlye.css">
</head>

<body>

    <?php include 'connect.php' ?>
    <?php


    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:index_login.php');
    };
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");

        $delete_message->bind_param("i", $delete_id);

        if ($delete_message->execute()) {

            header('Location: mails.php');
            exit();
        } else {
            echo "Error: Unable to delete account.";
        }
        $delete_message->close();
    }
    ?>
    <?php include 'componat/admin_header.php' ?>
    <section class="messages">

        <h1 class="heading">messages</h1>

        <div class="box-container1">

            <?php
            $select_messages = $conn->query("SELECT * FROM `messages`");

            if ($select_messages->num_rows > 0) {
                while ($fetch_messages =  $select_messages->fetch_assoc()) {
            ?>
                    <div class="box2">
                        <p> name: <span><?= htmlspecialchars($fetch_messages['name']); ?></span> </p>
                        <p> number: <span><?= htmlspecialchars($fetch_messages['number']); ?></span> </p>
                        <p> email : <span><?= htmlspecialchars($fetch_messages['email']); ?></span> </p>
                        <p> message : <span><?= htmlspecialchars($fetch_messages['message']); ?></span> </p>
                        <a href="mails.php?delete=<?= $fetch_messages['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this massege?');">delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No massages available</p>';
            }
            ?>

        </div>

    </section>
    <script src="js/admin_script.js"></script>
</body>

</html>