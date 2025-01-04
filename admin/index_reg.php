<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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
    if (isset($_POST['submit'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $pass = sha1($_POST['pass']);
        $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
        $cpass = sha1($_POST['cpass']);
        $cpass = htmlspecialchars($cpass, ENT_QUOTES, 'UTF-8');

        $query = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
        $query->bind_param("s", $name);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            echo 'Username already exists!';
        } else {
            if ($pass != $cpass) {
                echo 'Confirm password not matched!';
            } else {
                $insert_query = $conn->prepare("INSERT INTO `admin` (name, password) VALUES (?, ?)");
                $insert_query->bind_param("ss", $name, $cpass);
                $insert_query->execute();
                echo 'New admin registered!';
                $insert_query->close();
            }
        }


        $query->close();
    }



    ?>

    <?php include 'componat/admin_header.php' ?>


    <section class="form-container">
        <form action="" method="POST">
            <h3>register new</h3>
            <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" name="submit" class="btn btn-primary">
        </form>
    </section>




    <script src="js/admin_script.js"></script>

</body>

</html>