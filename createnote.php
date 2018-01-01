<?php
session_start();
include ('connection.php');
//get the user_id
$user_id = $_SESSION['user_id'];
//get the current time
$time = time()+60*60*7;
//run a query to create a new note
$sql = "INSERT INTO notes (`user_id`,`note`, `time`) VALUES ('$user_id', '', '$time')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "error";
}else{
    //mysqli_insert_id returns the auto-generated id used in the last query
    echo mysqli_insert_id($link);
}

?>