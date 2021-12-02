<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>

        <br><br>

        <?php 
            //checking whether id is set or not
            if(isset($_GET['id']))
            {
                //get order id 
                $id = $_GET['id'];
                //getting other id details
                //sql query to get order details
                $sql ="SELECT * FROM tbl_order WHERE id=$id";
                //execute query
                $res = mysqli_query($conn, $sql);
                //counting the number of rows of order
                $count = mysqli_num_rows($res);
                
                if($count ==1)
                {
                    //detaild available
                    $row=mysqli_fetch_assoc($res);
                    //creating new object to hold the attributes in order database
                    $food = $row['food'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                }
                else
                {
                    //details not available
                    //redirect to manage order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }

            } 
            else
            {
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        ?>

        <form action="#" method="POST">

            <table class="tbl-fax">
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <b>$<?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Quantity:</td>
                    <td>
                        <input type="number" name="quantity" class="input" value="<?php echo $quantity; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status" class="press">
                            <option <?php if($status=="Ordered") {echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery") {echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered") {echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled") {echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" class="input" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" class="input" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" class="input" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5" ><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-add">
                    </td>
                </tr>
            
            
            </table>
        
        
        </form>

        <?php 
            //checking whether update button is clicked
            if(isset($_POST['submit']))
            {
                //getting all the data from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                $total = $price * $quantity;

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];

                //query to update data
                $sql2 = "UPDATE tbl_order SET
                    quantity = $quantity,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id = $id 
                ";

                //query to execute 
                $res2 = mysqli_query($conn, $sql2);

                //checking whether update or not
                //redirect to manage order with message
                if($res2 ==True)
                {
                    //update
                    $_SESSION['update'] = "<div class='success'>Order Update Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //failed ro update
                    $_SESSION['update'] = "<div class='error'>Failled to Update Order.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>