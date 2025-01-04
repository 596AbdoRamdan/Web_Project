<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="dashboard.php" style="text-decoration: none;">home</a>
         <a href="prodact.php" style="text-decoration: none;">products</a>
         <a href="porders.php" style="text-decoration: none;">orders</a>
         <a href="admins_accounts.php" style="text-decoration: none;">admins</a>
         <a href="users_accounts.php" style="text-decoration: none;">users</a>
         <a href="mails.php" style="text-decoration: none;">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         // MySQLi connection


         // Prepare the query
         $stmt = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
         $stmt->bind_param("i", $admin_id); // Bind the admin_id parameter

         // Execute the query
         $stmt->execute();

         // Fetch the result
         $result = $stmt->get_result();
         $fetch_profile = $result->fetch_assoc();

         // Close the statement and connection

         ?>
         <p><?= htmlspecialchars($fetch_profile['name']); ?></p>

         <div class="flexs-btn">
            <a href="update_account.php" class="btn btn-primary" style="width: max-content; display: flex; text-transform: capitalize; font-size: 1.8rem; margin-top: 1rem; padding:1.2rem 3rem;">update profile</a>
            <a href="index_login.php" class="btn btn-primary" style="width: 200; display: flex; text-transform: capitalize; font-size: 1.8rem;margin-top: 1rem; padding:1.2rem 3rem; ">login</a>
            <a href="index_reg.php" class="btn btn-primary" style="width: 200; display: flex; text-transform: capitalize; font-size: 1.8rem;margin-top: 1rem; padding:1.2rem 3rem;">register</a>
            <a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="btn btn-danger" style="width: 200; display: flex;margin-top: 1rem; text-transform: capitalize; font-size: 1.8rem; padding:1.2rem 3rem;">logout</a>
         </div>

      </div>


   </section>

</header>