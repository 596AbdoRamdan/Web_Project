<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
}

if (isset($_POST['submit'])) {

   $address = $_POST['flat'] . ', ' . $_POST['building'] . ', ' . $_POST['area'] . ', ' . $_POST['town'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
   $address = htmlspecialchars($address);

   $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
   $update_address->bind_param("si", $address, $user_id);
   $update_address->execute();

   if ($update_address->affected_rows > 0) {
       $message[] = 'Address saved!';
   } else {
       $message[] = 'Failed to save address.';
   }

   $update_address->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Address</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Your Address</h3>
      <input type="text" class="box" placeholder="Flat No." required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="Building No." required maxlength="50" name="building">
      <input type="text" class="box" placeholder="Area Name" required maxlength="50" name="area">
      <input type="text" class="box" placeholder="Town Name" required maxlength="50" name="town">
      <input type="text" class="box" placeholder="City Name" required maxlength="50" name="city">
      <input type="text" class="box" placeholder="State Name" required maxlength="50" name="state">
      <input type="text" class="box" placeholder="Country Name" required maxlength="50" name="country">
      <input type="number" class="box" placeholder="Pin Code" required max="999999" min="0" maxlength="6" name="pin_code">
      <input type="submit" value="Save Address" name="submit" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
