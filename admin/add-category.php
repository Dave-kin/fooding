<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br><br>

        <!--add category form start-->
        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl_fax">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" class="input" placeholder="Category Title" required>
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image" class="img">
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
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Category" class="btn-add">
                </td>
            </tr>
            
            </table>
        </form>
        <!--add category form end -->

        <?php
            //checking whether the submit button is clicked or not 
            if(isset($_POST['submit']))
            {
               // echo "clicked";

                //1.Get the value from category form
                $title = $_POST['title'];
                //for radio button,checkng whether the button is selected or not 
                if(isset($_POST['featured']))
                {
                    //getting the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //checking whether the image is selected or not and set the value for image name accordingly
               // print_r($_FILES['image']);

               // die();//break the code
                if(isset($_FILES['image']['name']))
                {
                    //Upload image
                    //To Upload image we need image name,the source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload the image only if image is selected 
                    if($image_name != "")
                    {

                
                        //Auto rename the image
                        //get the extension of the image (jpg, png, gif etc)e.g "specialfood.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;//e.g Food_category_342.jpg
                        
                        //source of current image for upload
                        $source_path = $_FILES['image']['tmp_name'];

                        //Destination for new image for upload 
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
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    //dont upload the image and set the image value blank
                    $image_name = "";
                }

                //2.sql query to insert data in to database
                $sql = "INSERT INTO tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                ";

                //3.exexcute the query and save data
                $res = mysqli_query($conn, $sql);

                //4.check whether the query is executed successfully or not 
                if($res == True)
                {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Added Category..</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }

        ?>



    </div>
</div>


<?php include('partials/footer.php'); ?>