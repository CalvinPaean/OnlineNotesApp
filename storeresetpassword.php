

<?php

//This file receives: user_id, generated key to reset password, password1, and password2.
//This file then resets password for user_id if all checks are correct.

            session_start();
            include ('connection.php');
            //if user id or activation key is missing.
            if(!isset($_POST['user_id']) || !isset($_POST['key'])){
                echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email. </div>';
                exit;
            }
            //else
                //store them in 2 variables
            $user_id = $_POST['user_id'];
            $key = $_POST['key'];
            $time = time() - 86400;
            //prepare the variables for the query
            $user_id = mysqli_real_escape_string($link, $user_id);
            $key = mysqli_real_escape_string($link, $key);
           
            //run query: check combination of user_id and key exist and less than 24 hours old.
            $sql = "SELECT user_id FROM forgotpassword WHERE rkey = '$key' AND user_id = '$user_id' AND time > '$time'  AND status = 'pending'";
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
            //Define error messages
            $missingPassword = "<p><strong>Please enter a Password!</strong></p>";
            $invalidPassword = "<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>";
            $differentPassword = "<p><strong>Passwords do not match!</strong></p>";
            $missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
            //get password
            if(empty($_POST['password'])){
                $errors .= $missingPassword;
            }elseif(!(strlen($_POST['password'])>6 
                    and preg_match( '/[A-Z]/', $_POST['password']) 
                    && preg_match('/[0-9]/', $_POST['password']))){
                $errors .= $invalidPassword;
            }else{
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                if(empty($_POST['password2'])){
                    $errors .= $missingPassword2;
                }else{
                    $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
                    if($password!==$password2){
                        $errors .= $differentPassword;
                    }
                }
            }
            //    <!--if there are any errors print error-->
            if($errors){
                $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
                echo $resultMessage;
                exit;
            }
            //prepare variabels for the query
            $password = mysqli_real_escape_string($link, $password);
            //$password = md5($password);
            $password = hash('sha256', $password);//produce 256 bits random number -> 64 characters
            $user_id = mysqli_real_escape_string($link, $user_id);
            //run query: update users password in the users table
            $sql = "UPDATE users SET password='$password' WHERE user_id = '$user_id'";
            $result = mysqli_query($link, $sql);
            if($result==false){
                echo "<div class='alert alert-danger'>There was a problem storing the new password!</div>";
                //echo "<div class='alert alert-danger'>".mysqli_error($link)."</div>";
                exit;//stop the script
            }
            //set the key status to used in the forgotpassword table to prevent the key from being used twice
            $sql = "UPDATE forgotpassword SET status = 'used' WHERE rkey='$key' AND user_id = '$user_id'";
            $result = mysqli_query($link, $sql);
            if($result==false){
                echo "<div class='alert alert-danger'>ERROR running the query!</div>";
                //echo "<div class='alert alert-danger'>".mysqli_error($link)."</div>";
                
            }else{
                echo "<div class='alert alert-success'>Your password has been updated successfully!<a href='index.php'>Login</a></div>";
            }





















?>