<?php
    //including constants.php into login form
    include('../config/constants.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/log.css">
  <title>Login - Food Order System</title>
</head>
<body>
    
 <div class="hero">
   <div class="form-box">
      <?php
      if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if(isset($_SESSION['not-login']))
        {
          echo $_SESSION['not-login'];
          unset($_SESSION['not-login']);
        }
        ?>
   <div class="social-icon">
      <img src="../images/log.jpg" alt="image">
     </div>
    
     <!--Login from start -->
     <form action="#" class="input-group" method="POST">
       <input type="text" class="input-field" name="username" placeholder="User Name" required>
       <input type="password" class="input-field" name="password" placeholder="Enter Password" required>
        <input type="checkbox" class="check-box" required><span>Remember Password</span>
        <button type="Login" class="submit-btn" name="submit">Login</button>
     </form>
     <!--Login form end-->
     <div class="for">
       <a href="#">Forgot Password</a>
    </div>
     <div class="res">
       <a href="register.php">Create an Account</a>
      </div>
     </div>
    </div>
   </div>
  </div>
</body>
</html>

<?php
    //check whether the submit button is clicked or not 
    if(isset($_POST['submit']))
    {
      //Process for login
      //1.get the data from login form
      $username = $_POST['username'];
      $password = md5($_POST['password']);

      //2.sql query to check whether the username and password exists or not 
      $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

      //3.execute the query
      $res = mysqli_query($conn, $sql);

      //4.count rows to check whether the user exists or not 
      $count = mysqli_num_rows($res);

      if($count == 1)
      {
        //user exist and display session message
       // echo "login successfully";
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username;//to check whether the user is login or not and logout to unset it 
        // redirect to home page/dashboard
        header('location:'.SITEURL.'admin/');
      }
      else
      {
        //user does not exists and dissplay error message
        //echo "login failled";
        $_SESSION['login'] = "<div class='error'>Username and Password does not match.</div>";
        // redirect to home page/dashboard
        header('location:'.SITEURL.'admin/login.php');
      }

    }

?>