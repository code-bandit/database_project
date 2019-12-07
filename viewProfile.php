<?php
    session_start();
    require_once 'dbconnect.php';
    // if(!isset($_SESSION['user'])){
    //     header('Location: index.php');
    // }
    $userData = $db->facultyProfileUsers->findOne(array('_id' => new MongoDB\BSON\ObjectID($_GET['id'])));
    
    function get_publications($db){
        $id = $_GET['id'];
        $result = $db->facultyPublications->find(array('authorId' => new MongoDB\BSON\ObjectID($id)));
        $all_publications = iterator_to_array($result);
        return $all_publications;
    }

    function get_awards($db){
        $id = $_GET['id'];
        $result = $db->facultyAwards->find(array('authorId' => new MongoDB\BSON\ObjectID($id)));
        $all_awards = iterator_to_array($result);
        return $all_awards;
    }

?>

<!DOCTYPE html>
<html>
<title>Faculty Portal</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <style>

        </style>

<style>
        /* body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        } */

        .topnav {
        overflow: hidden;
        background-color: #333;
        }

        .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        .topnav a:hover {
        background-color: #ddd;
        color: black;
        }

        .topnav a.active {
        background-color: #4CAF50;
        color: white;
        }


html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
a:link {
    text-decoration: none;
}
a:hover {
    color: teal;
}
a:visited {
    /* color: red; */
}
</style>
<body class="w3-light-grey">

<?php include('header.php') ?>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="/images/avatar_hat.jpg" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
          <h2><?php 
              $array = explode('@', $userData['username'], 2);
              echo 'Welcome, ' . $array[0]; 
            ?>
          </h2>
          </div>
        </div>
        <div class="w3-container">
          <p><b><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Professor</b></p>
          <p><b><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>IIT Ropar, India</b></p>
          <p><b><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>ex@mail.com</b></p>
          <p><b><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>1224435534</b></p>
          <!-- <hr> -->
          <!-- <div class="w3-container"> -->
          <!-- <p><b><i class="fa fa-chevron-right  fa-fw w3-margin-right w3-text-teal"></i><a href='addawards.php'>Update Profile</a></i></b></p>
          <p><b><i class="fa fa-chevron-right  fa-fw w3-margin-right w3-text-teal"></i><a href='addawards.php'>Add Awards</a></i></b></p>
          <p><b><i class="fa fa-chevron-right  fa-fw w3-margin-right w3-text-teal"></i><a href='addpublication.php'>Add Publications</a></i></b></p>
          <p><b><i class="fa fa-chevron-right  fa-fw w3-margin-right w3-text-teal"></i><a href='logout.php'>Logout</a></i></b></p>
          <br> -->
          <!-- </div> -->
           
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
    <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-trophy fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Awards/Grants</h2>
            
        <?php 
            $all_awards = get_awards($db);
            if(($all_awards)){
                $counter_hr=0;
                foreach($all_awards as $awards){
                    echo '<div class="w3-container">';
                    echo '<h5 class="w3-opacity"><b> '. $awards['body'] .'</b></h5>';
                    echo '<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>' . 'Jan 2015';
                    // echo '<a href=\'delete.php?id='. $awards['_id'] .'\' style="float:right;">'.'Delete'.'</a>';
                    echo '</div>';
                    $counter_hr = $counter_hr+1;
                    if($counter_hr != count($all_awards)) { 
                        echo '<hr>';
                    } else {
                        echo'<br>';
                    }
                } 
                // echo '</div>';$all_publications
            }
             
        ?>
        </div>
        <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-newspaper-o fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Publications</h2>
            
      <?php
            $all_publications = get_publications($db);
            if($all_publications){
                $counter_hr=0;
                foreach($all_publications as $pub){
                    echo '<div class="w3-container">';
                    echo '<h5 class="w3-opacity"><b>'.$pub['body'].'</b></h5>';
                    echo '<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Forever</h6>';
                    // echo '<a href=\'delete.php?id='. $pub['_id'] .'\' style="float:right;">'.'Delete'.'</a>';
                    echo '</div>';  
                    $counter_hr = $counter_hr+1;
                    if($counter_hr != count($all_publications)) { 
                        echo '<hr>';
                    } else {
                        echo '<br>';
                    }
                }
            }    
      ?>
        </div>
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>

<footer class="w3-container w3-teal w3-center w3-margin-top">
  <p>Find me on social media.</p>
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <p>Powered by IIT Ropar</p>
</footer>

</body>
</html>
