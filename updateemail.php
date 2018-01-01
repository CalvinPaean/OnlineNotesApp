<?php
//start session and connect to database
session_start();
include ('connection.php');

//get user_id and new email through ajax 
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

//check if the new email exists
$sql = "SELECT * FROM users WHERE 'email'='$newemail'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'>There is already a user who registered with that email. Please choose another one!</div>";
    exit;
}

//get the current email of our user 
//get username and email
$sql = "SELECT * from users WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count==1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];
}else{
    echo "<div class='alert alert-danger'>There was an error retrieving the email from the database!</div>";
    exit;
}
//create a unique activation code
$activationKey = openssl_random_pseudo_bytes(16);
$activationKey = bin2hex($activationKey);

//insert new activation code in the user table
$sql = "UPDATE users SET activation2='$activationKey' WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error inserting the user details in the database!</div>";
    exit;
}else{
    //send email with link to activatenewemail.php with current email, new email and activation code
    $message = "Please click on this link to prove that you own this email address:\n\n";
    $message .= "http://laniakea.thecompletewebhosting.com/activatenewemail.php?email=".urlencode($email)."&newemail=".urlencode($newemail)."&key=$activationKey";
    if(mail($newemail, "Email Update for Your Online Notes App", $message, 'From:'.'biankai2099@gmail.com')){
        echo "<div class='alert alert-success'>An email has been sent to $newemail. Please click on the link to prove that you own the email address.</div>";
    }
}





?>