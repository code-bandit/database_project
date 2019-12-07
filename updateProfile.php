  <?php
  session_start();
  require_once 'dbconnect.php';
  
  $_id = $_SESSION['user'];
  
  $res = $db->facultyProfileUsers->findOne(array('_id' => $_id));
  $username = $res['username'];
  
  $host        = "host = 127.0.0.1";
  $port        = "port = 5432";
  $dbname      = "dbname = facultydb";
  $credentials = "user = postgres password=1234";
  $conn = pg_connect("$host $port $dbname $credentials");
  // $db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
  if(!$conn) {
     echo "Error : Unable to open database\n";
  } else {
   //   echo "Opened database successfully\n";
     $name = $_POST['name'];
     $phone_number = $_POST['phone'];
     $depart = $_POST['department'];
     $designation = $_POST['designation'];
  
     // $sql1 = 'INSERT INTO department(name) VALUES(\'cse\')';
     // $result1 = pg_query($conn, $sql1);
  
     // $sql2 = 'INSERT INTO department(name) VALUES(\'ee\')';
     // $result2 = pg_query($conn, $sql2);
  
     // $sql3 = 'INSERT INTO department(name) VALUES(\'me\')';
     // $result3 = pg_query($conn, $sql3);
  
   //   echo $depart.'<br>';
     // $sql4 = 'select * from faculty';
     if($depart == 'cse' || $depart == 'ee' || $depart == 'me'){
        $sql4 = "INSERT INTO faculty(id, name, leaves, department) VALUES('$username', '$name', '30', '$depart')";
        $result4 = pg_exec($conn, $sql4);
     }
  
     if($designation != "faculty"){
        $sql5 = "INSERT INTO currentcrossfaculty(id, designation, starttime) VALUES('$username', '$designation', 'now()')";
        $result5 = pg_query($conn, $sql5);
     }
  }
  ?>
<html>
<head>
<title> Update Profile </title>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
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

body {
   background-color: #f2f2f2;
}

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
  <?php
    if($_SESSION['user']){
      echo '<a href="logout.php" style="float:right;">'.'LogOut'.'</a>';
    }else{
      echo '<a href="login.php" style="float:right;">'.'Login'.'</a>';
    }
  ?>
  <!-- <a href="login.php" style="float:right;">Login</a> -->
</div>
<div class = "bod">
   <h2> Update Information </h2>
  <form action="updateProfile.php" method="post">
    <label for="name">Name*</label>
    <input type="text" name="name" placeholder="Your name.." required>

    <label for="phone">Phone Number</label>
    <input type="text" name="phone" placeholder="Phone Number..">

    <label for="department">Department*</label>
    <select name="department">
      <option value="">--</option>
      <option value="cse">CSE</option>
      <option value="ee">EE</option>
      <option value="me">ME</option>
    </select>

    <label for="designation">Designation*</label>
    <select name="designation">
       <option value="">--</option>
      <option value="faculty">Faculty</option>
      <option value="deanfa">Dean Faculty Affairs</option>
      <option value="assdeanfa">Associate Dean Faculty Affairs</option>
      <option value="director">Director</option>
    </select>
  
    <input type="submit" value="Submit">
  </form>
</div>
</body>
</html>
