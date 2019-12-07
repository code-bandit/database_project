<?php

    session_start();
    require_once 'pgconnect.php';
    require_once 'dbconnect.php';

    $_id = $_SESSION['user'];
    $found = $db->facultyProfileUsers->findOne(array('_id' => ($_id)));
    $username = $found['username'];

    $authorID = $_GET['id'];
    
    
    $u = $_GET['id'];
    $q = "select reviews from leaves where authorId = '$u'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $review = $row[0];
    
    $review = $review."->".$username;
    $review = $review."->".$_POST['comment'];
    $review = $review."->".$_POST['ss'];

    $q = "select nextAuthorId from leaves where authorId = '$u'";
    $res = pg_query($conn, $q);
    $row = pg_fetch_row($res);
    $next = $row[0];
    // echo $next.'<br>';
    if($_POST['ss'] == 'approve'){


        if($row[0] == 'NULL'){
            $q = "select leaves from faculty where authorId = '$u'";
            $res = pg_query($conn, $q);
            $row = pg_fetch_row($res);
            $leaves = $row[0]-1;
            $q = "UPDATE faculty SET leaves='$leaves";
            pg_query($conn, $q);
            $review = $review.'finished';
            $q = "UPDATE leaves SET reviews = '$review', status = 'finished'";
            pg_query($conn, $q);
          $q = "INSERT INTO pastleaves(path, authorId, body, reviews, approvedby, status) values ('$path', '$username', '$body', '$review', '$idd', 'finished')"; 
          // $q = "INSERT INTO pastleaves(path , authorId , body, reviews, status) values('$path', '$username', '$body', '$review', 'finished')";
          pg_query($conn, $q);
        }else{
            // echo "sd";
            $q = "select path from leaves where authorId = '$u'";
            $res = pg_query($conn, $q);
            $row = pg_fetch_row($res);
            // var_dump($row);
            // echo $row[0];
            $path = $row[0];
            $paths = explode('->', $path, 10);
            // echo $paths[0];
            $i=1;
            // echo $next.'<br>';
            // foreach($paths as $p){
            //     if($p != $next){
            //         $i=$i+1;
            //     }else{
            //         break;
            //     }
            // }

            $q1 = "select pathtra from leaves where authorId = '$u'";
            $res1 = pg_query($conn, $q1);
            $row1 = pg_fetch_row($res1);
            $pathtra = $row1[0];
            $pathtra =$pathtra +1;
        // echo sizeof($paths); 
        // echo $pathtra;

        $q1 = "SELECT id from currentcrossfaculty where designation = '$paths[$pathtra]'";
        $res1 = pg_query($conn, $q1);
        $row1 = pg_fetch_row($res1);
        $idd = $row1[0];
        // echo $idd;
        if(sizeof($paths) > $pathtra){
                $q = "UPDATE leaves SET reviews = '$review', currentAuthorId = '$next', nextAuthorId = '$idd', pathtra = '$pathtra'";
                pg_query($conn, $q);
            }else if(sizeof($paths) == $pathtra){
              $q = "UPDATE leaves SET reviews = '$review', currentAuthorId = '$next', nextAuthorId = '$idd', pathtra = '$pathtra'";
              pg_query($conn, $q);
            }
            else{
              $q = "INSERT INTO pastleaves(path, authorId, body, reviews, approvedby, status) values ('$path', '$username', '$body', '$review', '$idd', 'finished')"; 
              // $q = "INSERT INTO pastleaves(path , authorId , body, reviews, status) values('$path', '$username', '$body', '$review', 'finished')";
              pg_query($conn, $q);
                $q = "UPDATE leaves SET reviews = '$review', currentAuthorId = '$next', nextAuthorId = 'NULL', pathtra = '$pathtra', status = 'finished'";
                pg_query($conn, $q);
            }
        }

    }else if($_POST['ss'] == 'reject'){
        $q = "UPDATE leaves SET currentAuthorId = '', reviews = '$review', status = 'reject'";
        pg_query($conn, $q);

        $q = "INSERT INTO pastleaves(path, authorId, body, reviews, approvedby, status) values ('$path', '$username', '$body', '$review', '$idd', 'rejected')"; 
        // $q = "INSERT INTO pastleaves(path , authorId , body, reviews, status) values('$path', '$username', '$body', '$review', 'finished')";
        pg_query($conn, $q);
    }else if ($_POST['ss'] == 'sendback'){

        $q = "UPDATE leaves SET reviews = '$review', currentAuthorId = '$authorID'";
        pg_query($conn, $q);
        $q = "UPDATE leaves SET status = 'sendback'";
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

</style>

</head>
<body>
    <?php include 'header.php'?>

<div class="bod">
    <?php
        $us = $_GET['id'];
        $q = "select body from leaves where authorId = '$us'";
        $res = pg_query($conn, $q);
        $row = pg_fetch_row($res);
        echo '<h3>Leave Application</h3>';
        echo '<p>'.$row[0].'</p><br>';
        echo 'asda'.$us;
        echo '<form action="checkleave.php?id='.$us.'" method="post">';
    ?>
    <label ><h3>Write Comment</h3></label><br>
    <input type="text" name='comment' rows='20' style="height:50%;width:100%;"></input><br>
    <!-- <input type="submit" name="comment" value="Submit Comment"/> -->
    <select name="ss">
        <option value="approve"> Approve </option>
        <?php
            $q = "select path from leaves where authorId = '$u'";
            $res = pg_query($conn, $q);
            $row = pg_fetch_row($res);
            $path = $row[0];
            $paths = explode('->', $path, 10);
            $q = "select designation from currentcrossfaculty where id = '$username'";
            $res = pg_query($conn, $q);
            $row = pg_fetch_row($res);
            $designation = $row[0];
            if($designation == $paths[sizeof($paths)-1] || $paths[sizeof($paths)-1] == 'hod'){
              echo '<option value="reject"/> Reject </option>';
            }
        ?>
        <option value="sendback"> Send Back </option>
    </select>
    <input type="submit" value ="Submit"/>
  </form>
</div>
</body>
</html>