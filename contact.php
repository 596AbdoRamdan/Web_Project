<?php

include 'components/connect.php';

session_start();
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['send'])) {

   $name = $_POST['name'];
   $name = htmlspecialchars($name);
   $email = $_POST['email'];
   $email = htmlspecialchars($email);
   $number = $_POST['number'];
   $number = htmlspecialchars($number);
   $msg = $_POST['msg'];
   $msg = htmlspecialchars($msg);

   // Check if message already exists
   $stmt = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $stmt->bind_param("ssss", $name, $email, $number, $msg);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      $message[] = 'Message already sent!';
   } else {
      // Insert the new message
      $stmt = $conn->prepare("INSERT INTO `messages` (user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $user_id, $name, $email, $number, $msg);
      $stmt->execute();

      $message[] = 'Message sent successfully!';
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
   <title>Contact</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header Section Starts -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<div class="heading">
   <h3>Contact Us</h3>
   <p><a href="home.php">Home</a> <span> / Contact</span></p>
</div>

<!-- Contact Section Starts -->
<section class="contact">
   <div class="row">
      <div class="image">
         <img src="images/2761902.jpg" alt="">
      </div>

      <form action="" method="post">
         <h3>Tell us something!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
         <textarea name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="Send Message" name="send" class="btn">
      </form>

   </div>

</section>
<!-- Contact Section Ends -->

<!-- Footer Section Starts -->
<?php include 'components/footer.php'; ?>
<!-- Footer Section Ends -->

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
