<?php include('../config/constants.php'); 

    include('login-check.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Oder Website - Home Page</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!--Menu Section Start----->
    <div class="menu text-center">
    <div class="wrapper">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage-admin.php">Admin</a></li>
            <li><a href="manage-category.php">Category</a></li>
            <li><a href="manage-food.php">Food</a></li>
            <li><a href="manage-order.php">Order</a></li>
            <nav class="navbar navbar-default navbar-fixed-top" id="navbar">
            <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="logout.php">LogOut</a>
                    <a href="#">Change Password</a>
                </div>
                </div>
        </ul>
    </div>
    </div>
    <!--Menu Section ends----->