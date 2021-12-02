<?php
    //Include conststnts file
    include('../config/constants.php');

   // echo "delete category";
   //check whether the id and image_name value is set or not 
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
       //echo "get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file 
        if($image_name != "")
        {
            //image is available, so remove it 
            $path = "../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);
            
            //if fail to remove image then error message display and stop process
            if($remove == False)
            {
                //set session message
                $_SESSION['remove'] = "div class='error'>Failed to Remove Image.</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();

            }
        }

        //Delete data from database
        $sql = "DELETE FROM tbl_category WHERE id = $id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the data is delete from database or not 
        if($res == True)
        {
            //set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successffully.</div>";
            //redirect 
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else 
        {
            //set fail message 
            $_SESSION['delete'] = "<div class='error'>Failed to  Delete Category.</div>";
            //redirect 
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        //redirect to manage category page with message
    }
    else
    {
        //redirect to manage 
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>