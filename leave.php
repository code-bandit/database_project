<?php
    session_start();
    require_once 'dbconnect.php';
    require_once 'pgconnect.php';

    $query = "SELECT paths.path from paths";
    $res = pg_query($conn, $query);
    $path = pg_fetch_row($res);
    $path_string = '';
    foreach($path as $p){
        $path_string = $path_string . $p;
    }


    $_id = $_SESSION['user'];
    $found = $db->facultyProfileUsers->findOne(array('_id' => ($_id)));
    $username = $found['username'];
    // echo $username;

    $query = "SELECT department from faculty where id = '$username'";
    $res = pg_query($conn, $query);
    $row = pg_fetch_row($res);
    
    $paths = explode('->', $path_string, 4);
    if($paths[0] == 'hod'){
        $query = "SELECT id from currenthod where department = '$row[0]'";
        $res = pg_query($conn, $query);
        $row = pg_fetch_row($res);
    }else{
        $query = "SELECT id from currentcrossfaculty where designation = '$paths[0]'";
        $res = pg_query($conn, $query);
        $row = pg_fetch_row($res);
    }
    $path0 = $row[0];
    if(sizeof($paths) > 1){
        $query = "SELECT id from currentcrossfaculty where designation = '$paths[1]'";
        $res = pg_query($conn, $query);
        $row = pg_fetch_row($res);
    }

    $path1 = $row[0];
    // echo $path1.'<br>';
    $body = $_POST['body'];
    // echo $body;
    // echo $paths[];
    if(isset($body)){
        if(sizeof($paths) == 1) {
            $query = "TRUNCATE leaves";
            pg_query($conn, $query);
            $query = "INSERT INTO leaves(path, authorID, currentAuthorId, nextAuthorId, body, reviews, pathtra) values('$path_string', '$username', '$path0', 'NULL', '$body', 'NULL', 1)";
            pg_query($conn, $query);
        }else{
            $query = "TRUNCATE leaves";
            pg_query($conn, $query);
            $query = "INSERT INTO leaves(path, authorID, currentAuthorId, nextAuthorId, body, reviews, pathtra) values('$path_string', '$username', '$path0', '$path1', '$body', 'NULL', 1)";
            pg_query($conn, $query);
        }
    }
    // header('Location: home.php');
?>

<html>
<head>
<title>Request Leave</title>

<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  di splay: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.bod {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding-left: 200px;
  padding-right: 200px;
  padding-top: 30px;
}

body{
    margin: 0;
    background-color: #f2f2f2;
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

.topnav a:hover {currenthod
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
  <?php
    if($_SESSION['user']){
      echo '<a href="logout.php" style="float:right;">'.'LogOut'.'</a>';
    }else{
      echo '<a href="login.php" style="float:right;">'.'Login'.'</a>';
    }
  ?>
  <!-- <a href="login.php" style="float:right;">Login</a> -->
</div>

<div class="bod">
<form action="leave.php" method="post">
    <label ><h3>Write Leave</h3></label><br>
    <input type="text" name='body' rows='20' style="height:50%;width:100%;"></input><br>
    <?php

      $query = "SELECT status from leaves where authorId = '$username'";
      $res = pg_query($conn, $query);
      $row = pg_fetch_row($res);
      $r = $row[0];

      $query = "SELECT authorId from leaves where authorId = '$username'";
      $res = pg_query($conn, $query);
      $row = pg_fetch_row($res);
      $_id = $row[0];

      if($r == 'reject' || $r == 'finished' || !$_id){
        echo '<input type="submit" value="Apply"/>';
      }

    ?>
  </form>
</div>
</body>
</html>