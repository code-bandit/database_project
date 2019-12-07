<?php
    session_start();
    require_once 'dbconnect.php';
    $id = $_GET['id'];
    $res = $db->facultyPublications->findOne(array('_id' => new MongoDB\BSON\ObjectId ($id)));
    // var_dump($res);
    if($res){
        $deleteResult = $db->facultyPublications->deleteOne(array('_id' => new MongoDB\BSON\ObjectId ($id)));
        printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount());
    }else{
        $deleteResult = $db->facultyAwards->deleteOne(array('_id' => new MongoDB\BSON\ObjectId ($id)));
        printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount());
    }

    header('Location: home.php');
?>

<html>
<body>


    <!-- <form method='post' action='delete.php'>
    <fieldset>
        <label> Add Publication </label><br>
        <input class="btn btn-primary" type="submit" value="Submit">
    </fieldset>
    </form> -->

</body>
</html>