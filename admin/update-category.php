<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            //checking whether the id is set or not 
            if(isset($_GET['id']))
            {
                //get the id and all other details
               // echo "getting the data";
                $id = $_GET['id'];
               //creating sql query to get all details
               $sql = "SELECT * FROM tbl_category WHERE id = $id";

               //execute the query
                $res = mysqli_query($conn, $sql); 

               //count rows to check whether the id is valid or not 
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    //get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to  manage category page and display session message
                    $_SESSION['category_not_found'] = "<div class='error'>Category not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl_full">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                //display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image Not  Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Imagee:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            
            </table>
            
        </form>

        <?php

            if(isset($_POST['submit']))
            {
               // echo "clicked";
               //1.get all the values from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

               //1.updating the image if selected
                //checking whether the image is selected or not 
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];

                    //checked whether the image ia available oe not 
                    if($image_name != "")
                    {
                        //image available
                        //A. Upload the new image
                        //Auto rename the image
                        //get the extension of the image (jpg, png, gif etc)e.g "specialfood.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;//e.g Food_category_342.jpg
                        
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        //uploading the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not 
                        //if the image is not uploaded then stop the process and display error message
                        if($upload == False)
                        {
                            //SESSION MESSAGE
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload image.</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }

                        //B. Remove the current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);
    
                            //cheked whether the image is removed or not 
                            // if failed to remove then display message and stop process
                            if($remove == False)
                            {
                                //failed to remove image
                                $_SESSION['remove-failed'] = "<div class='error'> Failed to Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3.update the database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //checking whether the query executed or not 
                if($res2 == True){

                    //category update
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Updated Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

                //4.redirect to manage category
            }

        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>