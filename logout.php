<?php
if(isset($_SESSION['user_id']) && $_GET['logout']==1){
    session_destroy();//log out the user.
    setcookie("rememberme", "", time()-3600);
}

?>
