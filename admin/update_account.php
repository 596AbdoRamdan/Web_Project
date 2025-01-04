<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update account</title>
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

    if (isset($_POST['submit'])) {

        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

            if (!empty($name)) {
                $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
                $select_name->bind_param("s", $name);
                $select_name->execute();
                $result = $select_name->get_result();
                if ($result->num_rows > 0) {
                    $message[] = 'username already taken!';
                } else {
                    $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
                    $update_name->bind_param("si", $name, $admin_id);
                    $update_name->execute();
                }
            }

            $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
            $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
            $select_old_pass->bind_param("i", $admin_id);
            $select_old_pass->execute();
            $result = $select_old_pass->get_result();
            $fetch_prev_pass = $result->fetch_assoc();
            $prev_pass = $fetch_prev_pass['password'];

            $old_pass = sha1($_POST['old_pass']);
            $old_pass = htmlspecialchars($old_pass, ENT_QUOTES, 'UTF-8');
            $new_pass = sha1($_POST['new_pass']);
            $new_pass = htmlspecialchars($new_pass, ENT_QUOTES, 'UTF-8');
            $confirm_pass = sha1($_POST['confirm_pass']);
            $confirm_pass = htmlspecialchars($confirm_pass, ENT_QUOTES, 'UTF-8');

            if ($old_pass != $empty_pass) {
                if ($old_pass != $prev_pass) {
                    $message[] = 'old password not matched!';
                } elseif ($new_pass != $confirm_pass) {
                    $message[] = 'confirm password not matched!';
                } else {
                    if ($new_pass != $empty_pass) {
                        $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
                        $update_pass->bind_param("si", $confirm_pass, $admin_id);
                        $update_pass->execute();
                        $message[] = 'password updated successfully!';
                    } else {
                        $message[] = 'please enter a new password!';
                    }
                }
            }
        }
    }
    ?>

    <?php include 'componat/admin_header.php' ?>

    <section class="form-container">

        <form action="" method="POST">
            <h3>update profile</h3>
            <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
            <input type="password" name="old_pass" maxlength="20" placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" maxlength="20" placeholder="enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" maxlength="20" placeholder="confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="update now" name="submit" class="btn">
        </form>

    </section>
    <script src="js/admin_script.js"></script>
</body>

</html>