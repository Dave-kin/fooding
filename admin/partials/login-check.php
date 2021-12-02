<?php

    //AUTHORIZATION - ACCCESS CONTROL
    //Check whether the user is logged in or not 
    if(!isset($_SESSION['user']))//if user session is not set
    {
        //user is not login 
        //redirect to login page with message
        $_SESSION['not-login'] = "<div class='error'>please login to access Admin panel</div>";
        //redirect to login page
        header('Location:'.SITEURL.'admin/login.php');
    }


?>