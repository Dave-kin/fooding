<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
            //1. geting the id of selected admin
            $id = $_GET['id'];

            //2. creating sql query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            //Exexcut the query
            $res = mysqli_query($conn, $sql);

            //checking whether the query is exexcuted or not 
            if($res == True){
            //checking whether there is a data or not 
            $count = mysqli_num_rows($res);

            if($count == 1){
                //getting details
                //echo "Admin is Available";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];

            }
            else{
                //redirecting to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }

            }
        
        ?>

        <form action="#" method="POST">
        
            <table class="tbl-fax"> 
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>
                
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                </td>
            </tr>
            </table>

        </form>
    </div>
</div>

<?php 

    //checking whether the submit button id clicked or not 
    if(isset($_POST['submit']))
    {
        //echo "button is clicked";
        //getting all admin details from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //creating sql query to update admin
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username'
        WHERE id = $id
        ";

        //Executing the query
        $res = mysqli_query($conn, $sql);

        //checking whether the query is executed successfully or not 
        if($res ==True)
        {
            //session message to display if admin is update successfully
            $_SESSION['update'] = "<div class='success'>Admin is Update Successfully.</div>";
            //redirecting to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to update admin
            $_SESSION['update'] = "<div class='error'>Failled to Update Admin.</div>";
            //redirecting to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>

<?php include('partials/footer.php'); ?>