<?php

//including constants.php file here
include('../config/constants.php');
//1. get the id of admin to be deleted
$id = $_GET['id'];

//2. create sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id = $id";

//Execute the query
$res = mysqli_query($conn, $sql);

//checking whether the query executed successfully or not 
if($res == TRUE)
{
    //query executed successfully or admin is deleted 
   // echo "Admin is deleted";
   //creating session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
   //Directiing to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    //failled to deleteadmin
   // echo "Failled to delete admin";
   $_SESSION['delete'] = "<div class='error'>Failled to Delete Admin. Try again Later.</div>";
   //Directiing to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//3. redirect to manage admin page with message(successful or error)

?>   