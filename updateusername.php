<?php
//start session
session_start();
include ('connection.php');

//get the user_id
$user_id = $_SESSION['user_id'];

//get username through Ajax call
$username = $_POST['username'];

//run query and update the username
$sql = "UPDATE users SET username='$username' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo "<div class='alert alert-danger'>There was an error storing the new user name in the database!</div>";
}


?>