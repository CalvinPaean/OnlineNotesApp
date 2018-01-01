<?php
//the user is re-directed to this file after clicking on the activation link
//signup link contains two GET parameters: email and activation key
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
    <title>Password Reset</title>

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
            <h1>Reset Password</h1>
            <div id="resultmessage">
            
            </div>
<?php
          //if user id or activation key is missing.
            if(!isset($_GET['user_id']) || !isset($_GET['key'])){
                echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email. </div>';
                exit;
            }
            //else
                //store them in 2 variables
            $user_id = $_GET['user_id'];
            $key = $_GET['key'];
            $time = time() - 86400;
            //prepare the variables for the query
            $user_id = mysqli_real_escape_string($link, $user_id);
            $key = mysqli_real_escape_string($link, $key);
           
            //run query: check combination of user_id and key exist and less than 24 hours old.
            $sql = "SELECT user_id FROM forgotpassword WHERE `rkey` = '$key' AND `user_id` = '$user_id' AND `time` > '$time' AND status = 'pending'";
            $result = mysqli_query($link, $sql);
            if(!$result){
                echo "<div class='alert alert-danger'>ERROR running the query!</div>";
                exit;
            }    
            //if the combination does not exist
            //show error message
            $count = mysqli_num_rows($result);
            if($count!=1){
                echo "<div class='alert alert-danger'>Please try again.</div>";
                exit;
            }
            //print reset password form with hidden user_id and key fields
            echo "
                <form method = 'post' id='passwordreset'>
                    <input type='hidden' name='key' value=$key>
                    <input type='hidden' name='user_id' value=$user_id>
                    <div class='form-group'>
                        <label for='password'>Enter new Password: </label>
                        <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label for='password2'>Re-enter Password: </label>
                        <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
                    </div>
                    <input type='submit' name = 'resetpassword' class='btn btn-success btn-lg' value='Reset Password'>
                </form>
            ";
            
?>
            
        </div>
    </div>

</div>

   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script>
          //script for Ajax call to storeresetpassword.php which processes form data
          $("#passwordreset").submit(function(event){
                //prevent the default php processing
                event.preventDefault();
                //collect user inputs
                var datatopost = $(this).serializeArray();
                //send them to signup.php using AJAX
                $.ajax({
                    url: "storeresetpassword.php",//the url it will redirect
                    type: "POST",//the type of the call is POST call
                    data: datatopost,
                    success: function(data){//what to do if the call is successful
                        $('#resultmessage').html(data);
                    },
                    error: function(){//what to do if the call fails
                        $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

                    }
                }); 
            });
      </script>
      
  </body>
</html>
