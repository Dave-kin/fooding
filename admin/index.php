<?php include('partials/menu.php'); ?>

    <!--Menu Content Section Staart---->
        <div class="main-content">
        <div class="wrapper">
        <h1>Dashboard</h1>

        <br><br>
        <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>

        <div class="col-4 text-center">

            <?php 
                //sql query select detaild from category table
                $sql = "SELECT * FROM tbl_category";
                //execute the query
                $res = mysqli_query($conn, $sql);
                //counting rows 
                $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">
            <?php 
                //sql query select detaild from food table
                $sql2 = "SELECT * FROM tbl_food";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                //counting rows 
                $count2 = mysqli_num_rows($res2);
            ?>
            <h1><?php echo $count2; ?></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">
            <?php 
                //sql query select detaild from order table
                $sql3 = "SELECT * FROM tbl_order";
                //execute the query
                $res3 = mysqli_query($conn, $sql3);
                //counting rows 
                $count3 = mysqli_num_rows($res3);
            ?>
            <h1><?php echo $count3; ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">
        <?php 
                //sql query select total from order
                //using sql aggregate function to get total revenue generated
                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status ='Delivered'";
                //execute the query
                $res4 = mysqli_query($conn, $sql4);
                //getting the values
                $row4 = mysqli_fetch_assoc($res4);

                //getting total revenue
                $total_revenue = $row4['Total'];
            ?>
            <h1><?php echo $total_revenue; ?></h1>
            <br />
            Revenue Generated
        </div>

        <div class="clearfix"></div>
        </div>
        </div>

    <!--Menu Content Section Ends------>

<?php include('partials/footer.php'); ?>