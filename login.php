<?php
//start session
session_start();
//connect to database
include ('connection.php');

//check user input
$missingEmail = "<p><strong>Please enter your email address.</strong></p>";
$missingPassword = "<p><strong>Please enter your password.</strong></p>";

//get email and password
//store errors in error variables
if(empty($_POST['loginemail'])){
    $errors .= $missingEmail;
}else{
    $email = filter_var($_POST['loginemail'], FILTER_SANITIZE_EMAIL);
}
if(empty($_POST['loginpassword'])){
    $errors .= $missingPassword;
}else{
    $password = filter_var($_POST['loginpassword'], FILTER_SANITIZE_STRING);
}

//if any errors
if($errors){
    //print error message
    $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
}else{//no errors
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);//produce 256 bits random number -> 64 characters
    $sql = "SELECT * FROM users WHERE (`email` = '$email' AND `password` = '$password' AND `activation` = 'activated')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "<div class='alert alert-danger'>ERROR running the query!</div>";
        exit;//stop the script
    }
    
    $count = mysqli_num_rows($result);
    if($count!==1){
        echo "<div class='alert alert-danger'>Wrong username or password!</div>";
    }else{
        //log user in, set session variables
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);//return associative array
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        if(empty($_POST['rememberme'])){
            //if rememberme is not checked.
            echo "success";
        }else{
            //create two variables $authentificator1 and $authentificator2
            $authetificator1 = bin2hex(openssl_random_pseudo_bytes(10));
            $authetificator2 = openssl_random_pseudo_bytes(20);
            //store them in a cookie
            function f1($a, $b){
                $c = $a . "," . bin2hex($b);
                return $c;
            }
            $cookieValue = f1($authetificator1, $authetificator2);
            setcookie(
                "rememberme",
                $cookieValue,
                time() + 15*24*3600
            );
            //run query to store them in rememberme table
            function f2($a){
                $b = hash('sha256', $a);
                return $b;
            }
            $f2authentificator2 = f2($authentificator2);
            $user_id = $_SESSION['user_id'];
            $expiration = date('Y-m-d H:i:s',time()+1296000);
            $sql = "INSERT INTO rememberme (`authentificator1`, `f2authentificator2`,`user_id`,`expires`) VALUES ('$authetificator1', '$f2authentificator2','$user_id','$expiration')";
            $result = mysqli_query($link, $sql);
            if(!$result){
                echo "<div class='alert alert-danger'>There was an error storing data to remember you next time. </div>";
            }else{
                echo "success";
            }
        }
    }
}














?>