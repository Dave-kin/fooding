<?php
    //inlude constanta.php
    include('../config/constants.php');

    //1. destroy session message display for logout
    session_destroy();//unset $_SESSION['user']

    //2.redirect to login page
    header('Location:'.SITEURL.'admin/login.php');


?>