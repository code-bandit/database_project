<?php

    session_start();
    require_once 'dbconnect.php';
    require_once 'pgconnect.php';

    $_id = $_SESSION['user'];
    $found = $db->facultyProfileUsers->findOne(array('_id' => ($_id)));
    $username = $found['username'];

    $q = "select department from faculty where id = '$username'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $department = $row[0];

    $q = "select reviews from leaves where authorId = '$username'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $review = $row[0];

    $review = $review."->".$username;
    $review = $review."->".$_POST['comment'];
    $review = $review."->".'approve';   
    
  // echo $review;

    $q = "select nextAuthorId from leaves where authorId = '$username'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $next = $row[0];

// echo $next;

    $q = "select path from leaves where authorId = '$username'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $path = $row[0];
    $paths = explode('->', $path, 10);

// echo $paths[0];

    $q1 = "select pathtra from leaves where authorId = '$username'";
    $res1 = pg_query($conn, $q1);
    $row1 = pg_fetch_row($res1);
    $pathtra = $row1[0];
    $pathtra =$pathtra -1;
    // echo $paths[$pathtra];
    $idd='';
    if($paths[$pathtra] == 'hod'){
      $q1 = "SELECT id from currenthod where department = '$department'";
      $res1 = pg_query($conn, $q1);
      $row1 = pg_fetch_row($res1);
      $idd = $row1[0];
    }else{
      $q1 = "SELECT id from currentcrossfaculty where designation = '$paths[$pathtra]'";
      $res1 = pg_query($conn, $q1);
      $row1 = pg_fetch_row($res1);
      $idd = $row1[0];
    }

// echo $pathtra;

  if(isset($_POST['comment'])){
    $q = "UPDATE leaves SET currentAuthorId = '$idd', reviews = '$review', status = 'approve'";
    pg_query($conn, $q);
  }

?>

<html>
<head>
<title>Check Leaves</title>
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

table {
  width:100%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: black;
  color: white;
}

</style>

</head>
<body>
    <?php include 'header.php'?>

<div class="bod">
    <?php
        $_id = $_SESSION['user'];
        $found = $db->facultyProfileUsers->findOne(array('_id' => ($_id)));
        $us = $found['username'];

        $q = "select body from leaves where authorId = '$us'";
        $res = pg_query($conn, $q);
        $row = pg_fetch_row($res);
        $body = $row[0];
        echo '<h3>Leave Application</h3>';
        echo '<p>'.$row[0].'</p><br>';
    
        $q = "select status from leaves where authorId = '$us'";
        $res = pg_query($conn, $q);
        $row = pg_fetch_row($res);
        // var_dump ($row);
        // echo $row[0];
        if($row[0] == 'sendback'){
          echo '<form action="checkleavepersonal.php" method="post">';
        echo '<label ><h3>Write Comment</h3></label><br>';
        echo '<input type="text" name=\'comment\' rows=\'20\' style="height:30%;width:100%;"></input><br>';
        echo '<input type="submit" value ="Submit"/>';
        echo '</form>';
        
        }
        if($row[0] == 'finished'){
          echo '<h2>Your Leave has been approved</h2>';    
          $idd='';
          if($paths[$pathtra] == 'hod'){
            $q1 = "SELECT id from currenthod where department = '$department'";
            $res1 = pg_query($conn, $q1);
            $row1 = pg_fetch_row($res1);
            $idd = $row1[0];
          }else{
            $q1 = "SELECT id from currentcrossfaculty where designation = '$paths[$pathtra]'";
            $res1 = pg_query($conn, $q1);
            $row1 = pg_fetch_row($res1);
            $idd = $row1[0];
          }
          $q = "INSERT INTO pastleaves(path, authorId, body, reviews, approvedby, status) values ('$path', '$username', '$body', '$review', '$idd', 'finished')"; 
          // $q = "INSERT INTO pastleaves(path , authorId , body, reviews, status) values('$path', '$username', '$body', '$review', 'finished')";
          pg_query($conn, $q);
          // $q = "DELETE FROM leaves"
        }
    ?>
  <?php
    $q = "select reviews from leaves where authorId = '$us'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    // echo $row[0];
    // echo isset($row[0]);
    if($row[0] != 'NULL'){
      $review = explode("->", $row[0], 100);

      echo '<h2>PATH : '.$path.'</h2>';

      echo '<table id="t01">';
      echo '<tr>';
        echo '<th>Reviewer</th>';
        echo '<th>Comment</th> ';
        echo '<th>Action</th>';
      echo '</tr>';
    for($i=0; $i<sizeof($review); $i=$i+3){
      echo '<tr>';
      echo '<td>'.$review[1+$i].'</td>';
      echo '<td>'.$review[2+$i].'</td>'; 
      echo '<td>'.$review[3+$i].'</td>';
      echo '</tr>';
    }
  }
  echo '</table>';


  $q = "select status from leaves where authorId = '$us'";
  $res = pg_query($conn, $q);
  $row = pg_fetch_row($res);
  if($row[0] == 'finished')
  echo '<h2>STATUS : FINISHED</h2>';
  else if($row[0] == 'reject')
  echo '<h2>STATUS : REJECTED</h2>';
  else 
  echo '<h2>STATUS : PENDING</h2>';
    ?>

</div>
</body>
</html>