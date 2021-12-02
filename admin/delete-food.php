<?php 

    //include constants file
    include('../config/constants.php');

    //echo "delete"

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //procedd to delete
        //1.get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2.remove the image if available
        //check whether the image is available or not and delete 
        if($image_name != "")
        {
            //image is available. remove or delete it 
            //get image path
            $path = "../images/food/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            //check whether th image is removed or not 
            if($remove == False)
            {
                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Removed Image File.</div>";
                //stop the precess
                die();
            }
        }

        //3.delete food from database
        $sql = "DELETE FROM tbl_food WHERE id = $id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //checking whether the query is executed or not and display session message 
        //4.redirect to manage food and display session message
        if($res == True)
        {
            //successfully deleted 
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete 
            $_SESSION['delete'] = "<div class='error'>Failed To  Delete Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        
    }
    else
    {
        //redierect to manage food page
        //echo "redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    
?>  