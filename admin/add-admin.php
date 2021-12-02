<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        
        <br /><br />

        <?php 
            if(isset($_SESSION['add']))// checking whether session is se or not 
            {
                echo $_SESSION['add'];//display session mesage
                unset($_SESSION['add']);//removing session message
            }
        ?>

        <form action="#" method="POST">
            <table class="tbl-fax">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" class="input" placeholder="Enter Name" required>
                    </td>
                    </tr>

                    <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" class="input" placeholder="Enter username" required>
                    </td>
                    </tr>

                    <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" class="input" placeholder="Enter Password" required>
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-add">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 

if(isset($_POST['submit'])){
    //1. Get data from form  
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // password encrypyion with md5

    //2. SQl Query to save data into database
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";
    

    //3. Execute Query and save data into database
    $res = mysqli_query($conn, $sql);

    //4. checking whether the Query is executed and data is inserted or not 
    if($res == True){
        //data is unserted
       // echo "data is successfully inserted ";
       //creating session variable to display message
        $_SESSION['add'] = "Admin Added Successfully";
        //redirect page to manage Admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //failed to insert data 
       // echo "failled to unsert data";
       $_SESSION['add'] = "Failled to Add Admin ";
       //redirect page to manage Admin
       header("location:".SITEURL.'admin/manage-admin.php');
    }

}

?>