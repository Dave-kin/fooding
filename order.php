<?php include('partials-front/menu.php'); ?>

    <?php 
        //checking whether food if is set or not
        if(isset($_GET['food_id']))
        {
            //getting food id and details of selected food
            $food_id = $_GET['food_id'];
            //getting details of selected food
            $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
            //executing the query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);
            //checking whether the data is available or not 
            if($count ==1)
            {
                //data available
                //get data from database
                $row = mysqli_fetch_assoc($res);
                //asigning new variables to hold the existing one
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //food not available
                //redirect to home page 
                header('location:'.SITEURL);
            }
        }
        else
        {
            //rediect to home page
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="#" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                            //checking whether image is available or not 
                            if($image_name =="")
                            {
                                //image not available 
                                echo "<div class='error'>Image not Available.</div>";
                            }
                            else
                            {
                                //image Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                    
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="quantity" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php 
                //checking whether submit is clicked or not 
                if(isset($_POST['submit']))
                {
                   //echo "clicked";
                    //getting all the details from form(creating new class to hold names of class in form)
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];
                    
                    $total = $price * $quantity;//calculating price of food 

                    $order_date = date("y-m-d h:i");//date and time for order

                    $status = "Ordered";//ordered, on delivery, delivered and canelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    ///saving order details in database
                    //sql query to save data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        quantity = '$quantity',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    
                    "; 

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //checking whether query executed successfully or not 
                    if($res2 ==True)
                    {
                        //query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Order Failled.</div>";
                        header('location:'.SITEURL);
                    }
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    

    <?php include('partials-front/footer.php'); ?>