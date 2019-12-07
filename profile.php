<?php

    session_start();
    require_once 'dbconnect.php';

    function get_faculty_profiles($db){
        $faculty_data = $db->facultyProfileUsers->find();
        $faculty_data_final = iterator_to_array($faculty_data);
        return $faculty_data_final;
    }
    
?>

<html>
    <head>
        <title> Profiles </title>
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
    <?php include 'header.php'?>
    Faculty :<br>
    <?php
        $faculty_profiles = get_faculty_profiles($db);
        foreach($faculty_profiles as $fp){
            echo '<a href=\'viewProfile.php?id=' . $fp['_id'] .'\'>'.$fp['username'].'</a>';
            echo '<br>';
        }

    ?>

</body>
</html>