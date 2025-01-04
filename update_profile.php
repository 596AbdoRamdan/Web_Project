<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
   exit();
}

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = htmlspecialchars($name);

   $email = $_POST['email'];
   $email = htmlspecialchars($email);

   $number = $_POST['number'];
   $number = htmlspecialchars($number);

   // Update name if provided
   if (!empty($name)) {
      $stmt = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $stmt->bind_param("si", $name, $user_id);
      $stmt->execute();
      $stmt->close();
   }

   // Update email if provided
   if (!empty($email)) {
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $message[] = 'Email already taken!';
      } else {
         $stmt = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $stmt->bind_param("si", $email, $user_id);
         $stmt->execute();
      }
      $stmt->close();
   }

   // Update number if provided
   if (!empty($number)) {
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
      $stmt->bind_param("s", $number);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $message[] = 'Number already taken!';
      } else {
         $stmt = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
         $stmt->bind_param("si", $number, $user_id);
         $stmt->execute();
      }
      $stmt->close();
   }

   // Handle password update
   $empty_pass = sha1('');
   $stmt = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $fetch_prev_pass = $result->fetch_assoc();
   $prev_pass = $fetch_prev_pass['password'];

   $old_pass = sha1($_POST['old_pass']);
   $old_pass = htmlspecialchars($old_pass);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = htmlspecialchars($new_pass);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = htmlspecialchars($confirm_pass);

   if ($old_pass != $empty_pass) {
      if ($old_pass != $prev_pass) {
         $message[] = 'Old password not matched!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'Confirm password not matched!';
      } else {
         if ($new_pass != $empty_pass) {
            $stmt = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $confirm_pass, $user_id);
            $stmt->execute();
            $message[] = 'Password updated successfully!';
         } else {
            $message[] = 'Please enter a new password!';
         }
      }
   }
   $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header Section Starts -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<section class="form-container update-form">

   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
      <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="old_pass" placeholder="Enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
