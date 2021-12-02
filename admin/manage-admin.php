<?php include('partials/menu.php'); ?>

    <!--Menu Content Section Staart---->
        <div class="main-content">
        <div class="wrapper">
        <h1>Manage Admin</h1>

        <br /><br /><br />
            <!--implementing session to display message 
        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; // display session message
                unset($_SESSION['add']); //removing session message
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

            if(isset($_SESSION['pws-not-match']))
            {
                echo $_SESSION['pws-not-match'];
                unset($_SESSION['pws-not-match']);
            }

            if(isset($_SESSION['change-pws']))
            {
                echo $_SESSION['change-pws'];
                unset($_SESSION['change-pws']);
            }
        ?>

        <br><br><br>
        <!--buttom for adding admin----->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>

        <br /> <br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php 
            //Query to select all added admin from database
            $sql = "SELECT * FROM tbl_admin";
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //checkinh whether the query is executed or not 
            if($res == TRUE)
            {
                //count rows to check whther we have data in databae or not 
                $count = mysqli_num_rows($res); //functio to get all rows in database

                $sn = 1;//creating a variable and replace sn with id 

                //check the num of rows
                if($count > 0)
                {
                    //we ahve data in database
                    while($rows = mysqli_fetch_assoc($res))
                    {
                        //using while to get all the data from database
                        //and  while loop will run as long as we have data in database


                        //gettinh individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //display all the dettails in the table
                        ?>
                            
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $username; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/change-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> update Admin</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                </td>
                            </tr>
                        <?php
                    }
                }
                else
                {
                    //we do n0t have data in database
                }
            }
            ?>

        </table>

        </div>
        </div>

    <!--Menu Content Section Ends------>

    <?php include('partials/footer.php'); ?>