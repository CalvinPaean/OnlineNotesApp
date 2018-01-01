<?php

    $link = mysqli_connect("localhost","laniakea_notes", "Biankai1990", "laniakea_onlinenotes");
    if(mysqli_connect_error()){
        die("ERROR: Unable to connect: ".mysqli_connect_error());
    }

?>