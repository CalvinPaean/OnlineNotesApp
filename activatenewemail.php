<?php
//the user is re-directed to this file after clicking on the link received by email and aiming at proving they own the new email address
//link contains three GET parameters: email, new email, and activation key
session_start();
include ("connection.php");


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>New Email Activation</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <style>
          h1{
              color: purple;
          }
          .contactForm{
              border: 1px solid #7c73f6;
              margin-top: 50px; 
              border-radius: 15px;
          }
      </style>
  </head>
  <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Email Activation</h1>
<?php
          //if email or activation key is missing.
            if(!isset($_GET['email']) || !isset($_GET['newemail'])|| !isset($_GET['key'])){
                echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email. </div>';
                exit;
            }
            //else
                //store them in 2 variables
            $email = $_GET['email'];
            $newemail = $_GET['newemail'];
            $key = $_GET['key'];
            //prepare the variables for the query
            $email = mysqli_real_escape_string($link, $email);
            $newemail = mysqli_real_escape_string($link, $newemail);
            $key = mysqli_real_escape_string($link, $key);
            //run query: update email.
            $sql = "UPDATE users SET email = '$newemail', activation2 = '0' WHERE (email = '$email' AND activation2 = '$key') LIMIT 1";
            $result = mysqli_query($link, $sql);
            //if query is successful, show success message 
            if(mysqli_affected_rows($link) == 1){//the number of affected rows after executing one query
                session_destroy();//destroy the session
                setcookie("rememberme","", time()-3600);//destroy the cookie
                echo '<div class="alert alert-success">Your email has been updated. </div>';
                echo "<a type='button' class='btn-lg btn-success' href='index.php'>Log in.</a>";
            }else{
                echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
                echo '<div class="alert alert-danger">'.mysqli_error($link).'</div>';
            }
   
?>
            
        </div>
    </div>

</div>

   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      
  </body>
</html>
