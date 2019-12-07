<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client;

$companydb = $client->facultydb;

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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

<?php include 'header.php' ?>

<div style="padding-left:16px">
  <h2>Faculty Portal</h2>
  <p>IIT Ropar's Faculty Portal created by Ripudaman Singh and Jai Garg</p>
</div>

</body>
</html>
