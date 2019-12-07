<html>
<head>
<style>
body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        }

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
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="home.php">Home</a>
  <a href="profile.php">Profiles</a>
  <!-- <a href="#about">About</a> -->
  <!-- <a href="login.php" style="float:right;">Login</a> -->
</div>

    <form method='post' action='addawards.php'>
    <fieldset>
        <label for='awards'> Add Award </label><br>
        <textarea name='body' rows='4' cols='50'></textarea><br>
        <input type='submit' value='Add Award'/> 
    </fieldset>
    </form>

</body>
</html>

<?php

    session_start();
    require_once 'dbconnect.php';

    if(!isset($_POST['body'])){
        exit;
    }

    $user_id = $_SESSION['user'];
    $userData = $db->facultyProfileUsers->findOne(array('_id'=>$user_id));
    $body = substr($_POST['body'], 0, 140);

    $db->facultyAwards->insertOne(array(
        'authorId' => $user_id,
        'authorName' => $userData['username'],
        'body' => $body
    ));

    header('Location: home.php');

?>