
<?php   include('partials/menu.php'); ?>

    <?php
        //check whether id is set or not
        if(isset($_GET['id']))
        {
            //get all details from the database
            $id = $_GET['id'];
            //sql query to get select all details 
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
            //execute the query 
            $res2 = mysqli_query($conn, $sql2);

            //Get details based on query executed
            $row2 = mysqli_fetch_assoc($res2);
            //Get individual details of selected data
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        }
        else
        {
            //redirect to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <form action="#" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-fax">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" class="input" value="<?php echo $title; ?>">
                    </td>
                </tr> 

                <tr>
                    <td>Description:</td>
                    <td>
                    <textarea name="description" cols="30" rows="5"> <?php echo $description; ?> </textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" class="press" value="$<?php echo $price; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image =="")
                            {
                                //image not available
                                echo "<div class='error'>Image not Available.</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                    <select name="category" class="press">

                        <?php
                            //query to get data from category database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute the query 
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check whether category available or not 
                            if($count > 0)
                            {
                                //category available
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    
                                    //html code inside php
                                    //echo "<option value='$category_id'>$category_title</option>"; 
                                    ?>
                                        <option <?php if($current_category == $category_id) {echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category not available
                                echo "<option value='0'>Category Not Available.</option>";// another way of putting html code inside php
                            }

                        ?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" valu="Yes">Yes
                        <input <?php if($featured=="No")  {echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                <td>Active:</td>
                <td>
                <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active"  value="Yes">Yes
                <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active"  value="No">No
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-add">
                    </td>
                </tr>
        
            </table>
        
        </form>

        <?php

            if(isset($_POST['submit']))
            {
               // echo "clicked";
                
                //1.Get all the details from form 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                //2.upload the selected image 
                //check whether upload button is clicked
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    $image_name = $_FILES['image']['name'];///New Image NAME

                    //check whether file is available or not 
                    if($image_name !="")
                    {
                        //image is available
                        //task A. UPLOADING NEW IMAGE
                        //rename the image 
                        $ext = end(explode('.', $image_name));//gets the extenion of image

                        $image_name = "Better-Fact-".rand(0000, 9999).'.'.$ext; // To rename the image

                        //Getting the source and Destination path
                        $source_path = $_FILES['image']['name']; //source path for the image
                        $destination_path = "../images/food/".$image_name;// destination path of the image 

                        //upload the image 
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether image is uploaded or not 
                        if($upload == False)
                        {
                            //failed to upload
                            $_SESSION['load'] = "<div class='error'>Failed to Upload new Image.</div>";
                            //redierct to manage food page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                            
                        //3.Remove th image if new image is uploaded and current image is deleted
                        //B. REMO0VE CURRENT IMAGE
                        if($current_image !="")
                        {
                            //current image is available
                            //remove the image 
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether th eimage is removed or not 
                            if($remove == False)
                            {
                                //failed to remove current image 
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                //redirect to manage food page 
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
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
                
                //4.update the data in the database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured ='$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                //execute the query
                $res3 = mysqli_query($conn, $sql3);  

                //check whether the query is executed successfully or not 
                if($res3 == True)
                {
                    //query executed and update food
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    //redirect to manage food page 
                    header('location:'.SITEURL.'admin/manage-food.php');
                    
                }
                else
                {
                    //failed to update database
                    $_SESSION['update'] = "<div class='error'>Failed to Update.</div>";
                    ///redirect to manage food page 
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>