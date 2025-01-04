<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>



   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>about us</h3>
   <p><a href="home.php">home</a> <span> / about</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Who are we ?</h3>
         <p>Since launching in Egypt in 2024, talabat, the leading on-demand food and Q-commerce app for everyday deliveries, has been offering convenience and reliability to its customers. talabat’s local roots run deep, offering a real understanding of the needs of the communities we serve in eight countries across the region. We harness innovative technology and knowledge to simplify everyday life for our customers, optimize operations for our restaurants and local shops, and provide our riders with reliable earning opportunities daily. </p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

   </div>

</section>

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choose order</h3>
         <p>Easy-to-select and eye-pleasing menu.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>fast delivery</h3>
         <p>The fastest on the planet</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food</h3>
         <p>We serve food with a big smile.</p>
      </div>

   </div>

</section>



<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>


<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>