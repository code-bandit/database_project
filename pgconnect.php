<?php
require_once 'dbconnect.php';
$host        = "host = 127.0.0.1";
$port        = "port = 5432";
$dbname      = "dbname = facultydb";
$credentials = "user = postgres password=1234";
$conn = pg_connect("$host $port $dbname $credentials");

?>