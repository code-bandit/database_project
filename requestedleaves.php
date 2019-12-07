<?php

    session_start();
    require_once 'dbconnect.php';
    require_once 'pgconnect.php';

?>

<html>
<head>
<title>Requested Leaves</title>
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
    <?php include 'header.php'?>
    <?php
        $_id = $_SESSION['user'];
        $found = $db->facultyProfileUsers->findOne(array('_id' => ($_id)));
        $username = $found['username'];
        // echo 
        $query = "SELECT leaves.authorId from leaves where leaves.currentAuthorId='$username'";
        $res = pg_query($conn, $query);
        $row = pg_fetch_row($res);
        foreach($row as $r){
            echo '<a href=\'checkleave.php?id='. $r .'\' >'.$r.'</a>';
        }
    ?>
</body>
</html>