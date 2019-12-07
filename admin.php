<?php
    session_start();
    require_once 'dbconnect.php';
    require_once 'pgconnect.php';

    if(isset($_POST['hodcse'])){
      $hod = $_POST['hodcse'];
      // $res = "select currenthod.id from currenthod"
      $query = "DELETE FROM currenthod where department = 'cse'";
      pg_query($conn, $query);
      $query = "INSERT INTO currenthod(id, department, starttime) values('$hod', 'cse', 'now()')";
      $result = pg_query($conn, $query);
    }
    if(isset($_POST['hodee'])){
      $hod = $_POST['hodee'];
      $query = "DELETE FROM currenthod where currenthod.department = 'ee'";
      pg_query($conn, $query);
      $query = "INSERT INTO currenthod(id, department, starttime) values('$hod', 'ee', 'now()')";
      $result = pg_query($conn, $query);
    }
    if(isset($_POST['hodme'])){
      $hod = $_POST['hodme'];
      $query = "DELETE FROM currenthod where currenthod.department = 'me'";
      pg_query($conn, $query);
      $query = "INSERT INTO currenthod(id, department, starttime) values('$hod', 'me', 'now()')";
      $result = pg_query($conn, $query);
    }    
    if(isset($_POST['deanfa'])){
      $hod = $_POST['deanfa'];
      $query = "SELECT currenthod.id from currenthod where currenthod.id = '$hod'";
      $res = pg_query($conn, $query);
      $row = pg_fetch_row($res);
      if(!$row[0]){
        $query = "DELETE FROM currentcrossfaculty where currentcrossfaculty.designation = 'deanfa'";
        pg_query($conn, $query);
        $query = "INSERT INTO currentcrossfaculty(id, designation, starttime) values('$hod', 'deanfa', 'now()')";
        $result = pg_query($conn, $query);
      }else{
        echo 'already hod';
      }
    }
    if(isset($_POST['assdeanfa'])){
      // echo 'yasas';
      $hod = $_POST['assdeanfa'];
      $query = "SELECT currenthod.id from currenthod where currenthod.id = '$hod'";
      $res = pg_query($conn, $query);
      $row = pg_fetch_row($res);
      if(!$row[0]){
        $query = "DELETE FROM currentcrossfaculty where currentcrossfaculty.designation = 'assdeanfa'";
        pg_query($conn, $query);
        $query = "INSERT INTO currentcrossfaculty(id, designation, starttime) values('$hod', 'assdeanfa', 'now()')";
        $result = pg_query($conn, $query);
      }else{
        echo 'already hod';
      }
    }    
    if(isset($_POST['director'])){
      // echo 'yasas';
      $hod = $_POST['director'];
      $query = "SELECT currenthod.id from currenthod where currenthod.id = '$hod'";
      $res = pg_query($conn, $query);
      $row = pg_fetch_row($res);
      if(!$row[0]){
        $query = "DELETE FROM currentcrossfaculty where currentcrossfaculty.designation = 'director'";
        pg_query($conn, $query);
        $query = "INSERT INTO crossfaculty(id, designation, starttime) values('$hod', 'director', 'now()')";
        $result = pg_query($conn, $query);
      }else{
        echo 'already hod';
      }
    }
    if(isset($_POST['path1']) && isset($_POST['path2']) && isset($_POST['path3']) && isset($_POST['path4'])){
      $string_path="";
      if($_POST['path1'] != 'blank'){
        $string_path = $string_path . $_POST['path1'];
      }
      if($_POST['path2'] != 'blank'){
        if($string_path==""){
          $string_path = $string_path . $_POST['path2'];
        }else{
          $string_path = $string_path ."->". $_POST['path2'];
        }
      }
      if($_POST['path3'] != 'blank'){
        if($string_path==""){
          $string_path = $string_path . $_POST['path3'];
        }else{
          $string_path = $string_path . "->".$_POST['path3'];
        }
      }
      if($_POST['path4'] != 'blank'){
        if($string_path==""){
          $string_path = $string_path . $_POST['path4'];
        }else{
          $string_path = $string_path ."->". $_POST['path4'];
        }
      }
      // echo $string_path;
      $query = "TRUNCATE paths CASCADE;";
      pg_query($conn, $query);
      $query = "INSERT INTO paths(path) values('$string_path')";
      $result = pg_query($conn, $query);
    }
?>

<html>
<head>
<title>Admin Page</title>
</head>
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

<body>
<?php include 'header.php'; ?>
<div class = "bod">
<h2> Admin Page </h2>
  <form action="admin.php" method="post">
    <label for="hodcse">HOD CSE<?php 
      $query = "select currenthod.id from currenthod where department = 'cse'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current HOD -> '. $row[0];
      }
    ?></label>
    <select name="hodcse">
    <?php

        $query = "select faculty.id from faculty where faculty.department = 'cse'";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
          // $hh = $row[0];
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="hodee">HOD EE <?php 
      $query = "select currenthod.id from currenthod where department = 'ee'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current HOD -> '. $row[0];
      }
    ?></label>
    <select name="hodee">
    <?php
        $query = "select faculty.id from faculty where faculty.department = 'ee'";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="hodme">HOD ME<?php 
      $query = "select currenthod.id from currenthod where department = 'me'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current HOD -> '. $row[0];
      }
    ?></label>
    <select name="hodme">
    <?php

        $query = "select faculty.id from faculty where faculty.department = 'me'";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="deanfa">Dean Faculty Affairs<?php 
      $query = "select currentcrossfaculty.id from currentcrossfaculty where designation = 'deanfa'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current HOD -> '. $row[0];
      }
    ?></label>
    <select name="deanfa">
    <?php

        $query = "select faculty.id from faculty";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="assdeanfa">Associate Dean Faculty Affairs<?php 
      $query = "select currentcrossfaculty.id from currentcrossfaculty where designation = 'assdeanfa'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current Ass. Dean -> '. $row[0];
      }
    ?></label>
    <select name="assdeanfa">
    <?php

        $query = "select faculty.id from faculty";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="director">Director<?php 
      $query = "select currentcrossfaculty.id from currentcrossfaculty where designation = 'director'";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      if($row[0]){
        echo ': Current Director -> '. $row[0];
      }
    ?></label>
    <select name="director">
    <?php

        $query = "select faculty.id from faculty";
        $result = pg_query($conn, $query);
        while($row = pg_fetch_row($result)){
            echo '<option value='.$row[0].' >'.$row[0].'</option>';
        }
    ?>
    </select>
    <input type="submit" value="Submit">
  </form>
  <form action="admin.php" method="post">
    <label for="path">Path<?php 
      $query = "select paths.path from paths";
      $res = pg_query($conn, $query); 
      $row = pg_fetch_row($res);
      // var_dump($row);
      // $row_final = iterator_to_array($row);
      if($row){
        echo ': Current path = ' ;
        foreach($row as $r){
          echo $r;
        }
      }
    ?></label>
    <select name="path1">
    <option value="blank"></option>
      <option value="hod"> hod </option>
    </select>
    <select name="path2">
      <option value="blank"></option>
      <option value="deanfa"> deanfa </option> 
    </select>
    <select name="path3">
      <option value="blank"></option>
      <option value="assdeanfa"> assdeanfa </option>
    </select>
    <select name="path4">
      <option value="blank"></option>
      <option value="director"> director </option>
    </select>
    <input type="submit" value="Submit">
  </form>
</div>
</body>
</html>