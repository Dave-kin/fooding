<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>

        <br><br>

        <?php 
        
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
        
        ?>

        <form action="" method="POST">
        
        <table class="tbl-fax">
        <tr>
            <td>Olde Password:</td>
            <td>
                <input type="password" name="current_password" placeholder="Current Passowrd" required>
            </td>
        </tr>

        <tr>
            <td>New Passowrd:</td>
            <td>
                <input type="password" name="new_password" placeholder="New Password" required>
            </td>
        </tr>

        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" name="submit" value="Change Password" class="btn-secondary">
            </td>
        </tr>
        </table>

        </form>

    </div>
</div>

    <?php
        //checki(ng whether the submit is clicked
        if(isset($_POST['submit']))
        {

        //echo "clicked";

        //1.get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. check whether the user with current id and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //execute the query
        $res = mysqli_query($conn, $sql);

        if($res == True)
        {
            //checking whether data is available or not 
            $count = mysqli_num_rows($res);

            if($count == 1)
            {
                // user exists and password can be change
                //echo "User Found";

                //checking whether the new password and confrim password match or not 
                if($new_password == $confirm_password)
                {
                    //update the password
                    $sql2 = "UPDATE tbl_admin SET
                        password = '$new_password'
                        WHERE id = $id
                    ";

                    //execute query
                    $res2 = mysqli_query($conn, $sql2);

                    //checking whether the query is executed or not 
                    if($res2 == True)
                    {
                        //display success message
                $_SESSION['change-pws'] = "<div class='success'>Password Change Successfully.</div>";
                //redirect to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                //display error message
                $_SESSION['change-pws'] = "<div class='error'>Failed to Change Password.</div>";
                //redirect to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                //redirect the user
                $_SESSION['pws-not-match'] = "<div class='error'>Password not Match.</div>";
                //redirect to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //user does not exists, dispaly message and redirect to manage adnin
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
                //redirect to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        //3.check whether the new password and the confirm password match or not 

        //4.change password if all is true

    }

    ?>

<?php include('partials/footer.php'); ?>