<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
    
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-fax">
        <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" class="input" placeholder="Enter Food Title" required>
            </td>
        </tr>

        <tr>
            <td>Description:</td>
            <td>
                <textarea name="description" cols="30" rows="5" placeholder="Enter Description" required></textarea>
            </td>
        </tr>

        <tr>
            <td>price:</td>
            <td>
                <input type="number" name="price" class="press">
            </td>       
        </tr>

        <tr>
            <td>Select Image:</td>
            <td>
                <input type="file" name="image" class="img">
            </td>
        </tr>

        <tr>
            <td>Category:</td>
            <td>
                <select name="category" class="press">

                <?php 
                    //php code to display all category of food from database
                   //1. sql query to get all active category from database
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                    
                    //executing the query
                    $res = mysqli_query($conn, $sql);

                    //countin rows to check whether we have category or not 
                    $count = mysqli_num_rows($res);

                    //if count is greater than zero, we have categories else we dont have categories
                    if($count)
                    {
                        //have categories
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //get the details of categories
                            $id = $row['id'];
                            $title = $row['title'];

                            ?>
                                <option value=""></option>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php
                        }
                    }
                    else
                    {
                        //do no have categories
                        ?>
                        <option value="0">No Category Found</option>
                        <?php
                    }
                   //2. display on dropdwon 
                
                ?>
                
                </select>
            </td>
        </tr>

        <tr>    
            <td>Featured:</td>
            <td>
                <input type="radio" name="featured" value="Yes">Yes
                <input type="radio" name="featured" value="No">No
            </td>
        </tr>

        <tr>
            <td>Active:</td>
            <td>
                <input type="radio" name="active" value="Yes">Yes
                <input type="radio" name="active" value="No">No
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add Food" class="btn-add">
            </td>
        </tr>
        
        </table>
        
        </form>

        <?php

            //checking whether the button is clicked 
            if(isset($_POST['submit']))
            {
                //adding the food in database
                //echo "clicked";
                //1.get data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //checking whether radio button for featured and active is checked or not 
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //setting default value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //setting default value
                }
                //2. upload the image if checked
                //checked whether the selected image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                     //getting the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //checking whether the image is selected or not 
                    if($image_name != "")
                    {
                        //image is selected
                        //A. rename the image
                        //get the extensio of selected image (jpg, png gif etc)
                        $ext = end(explode('.', $image_name));

                        //creating new name for image
                        $image_name = "Better-Fact-".rand(0000,9999).'.'.$ext;//new image name("Better-Fact-123.jpg)

                        //B. upload the image 
                        //get the source and destination path

                        //source path is the cureent location odf the image 
                        $src = $_FILES['image']['tmp_name']; 

                        //Destination path for the iamge to be uploaded
                        $dst ="../images/food/".$image_name;


                        //finally upload the food image
                        $upload =move_uploaded_file($src, $dst);

                        //check whether image is uploaded or not
                        if($upload == False)
                        {
                            //failed to upload food image 
                            //redirect to add food page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = "";//setting default value as blank 
                }
                //3.insert into database
                //create sql query to save data into database
                //note for numerical or integer value inside ('') qoute is not needed but for string inside ('') qoute is compulsory  
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price, 
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',  
                    active = '$active'
                
                ";


                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether data is inserted or not 
                 //4.redirect with message to manage food page
                if($res2 == True)
                {
                    //Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to Added Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
               
            }

        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>