<?php

include 'connect.php';


$error_message = '';
if (isset($_POST['submit'])) {

    $name = $conn->real_escape_string($_POST['name']);
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $pass = sha1($_POST['pass']);
    $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');

    $query = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $query->bind_param("ss", $name, $pass);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $fetch_admin_id = $result->fetch_assoc();
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:dashboard.php');
    } else {
        $error_message = 'Incorrect username or password!';
    }

    $query->close();
}

$conn->close();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login as admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">


<body>

    <section class="form-container">

        <form action="" method="POST">
            <h3>login now</h3>
            <?php if ($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <p>default username = <span>admin</span> & password = <span>111</span></p>
            <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="login now" name="submit" class="btn">
        </form>

    </section>
</body>

</html>