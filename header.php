<div class="topnav">
  <a class="active" href="home.php">Home</a>
  <a href="profile.php">Profiles</a>
  <!-- <a href="#about">About</a> -->
  <?php
    if($_SESSION['user']){
      echo '<a href="logout.php" style="float:right;">'.'LogOut'.'</a>';
    }else{
      echo '<a href="login.php" style="float:right;">'.'Login'.'</a>';
    }
  ?>
  <!-- <a href="login.php" style="float:right;">Login</a> -->
</div>