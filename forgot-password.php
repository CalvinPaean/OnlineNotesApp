
<?php
//start session
session_start();
//connect to database
include ('connection.php');

//check user inputs
    //define error messages
$missingEmail = "<p><strong>Please enter your email address!</strong></p>";
$invalidEmail = "<p><strong>Please enter a valid email address!</strong></p>";
    //get email
    //store errors in errors variable
if(empty($_POST['forgotemail'])){
    $errors .= $missingEmail;
}else{
    $email = filter_var($_POST['forgotemail'], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}
    //if any errors, print errors
if($errors){
    $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
    exit;
}
//else: no error
    //prepare variables for the query
$email = mysqli_real_escape_string($link, $email);

//run the query to check if email exists in the forgot password table
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>ERROR running the query!</div>";
    exit;//stop the script
}
$count = mysqli_num_rows($result);
if($count != 1){
    echo "<div class='alert alert-danger'>That email does not exist on our database.</div>";
    exit;
}
//else  
    //get the user_id
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];
    //get a unique activation code
$key = bin2hex(openssl_random_pseudo_bytes(16));
    //insert user details and activation code in the forgotpassword table
$time = time();
$status = "pending";
$sql = "INSERT INTO forgotpassword (`user_id`,`rkey`,`time`,`status`) VALUES ('$user_id','$key','$time','$status')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>ERROR running the query!</div>";
    exit;//stop the script
}
//send the user an email with a link to resetpassword.php with user id and activation code
$message = "Please click on this link to reset your password:\n\n";
$message .= "http://laniakea.thecompletewebhosting.com/resetpassword.php?user_id=$user_id&key=$key";

if(mail($email, "Reset your password", $message, 'From:'.'biankai2099@gmail.com')){
    //if email is sent successfully, print the success message
    echo "<div class='alert alert-success'>An email has been sent to $email. Please click on the link to reset your password.</div>";
}














?>