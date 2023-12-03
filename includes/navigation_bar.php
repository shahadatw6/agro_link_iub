<?php include 'top.php'; ?>
    <!--NavBar Start -->
        <nav class="d-flex fixed-top">
            <div class="nav_brand">
                <a href="<?php echo WEBSITE_PATH; ?>index.php"><img src = "/images/new data/logo1.png"></i> <span>Agro-Link</span></a>
            </div>
            <div class="responsive_icon">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="nav_menu">
                <ul class="d-flex">
                    <li>
                        <a href="index.html">home</a>
                    </li>
                    <li>
                        <a href="about.html">about</a>
                    </li>
                    <li>
                        <a href="<?php echo WEBSITE_PATH; ?>shop.php">shop</a>
                    </li>

                    <?php if(!isset($_SESSION['USER_LOGIN'])){?>
                        <li>
                            <a href="<?php echo WEBSITE_PATH; ?>registration.php">signup</a>
                        </li>
                        <li>
                            <a href="<?php echo WEBSITE_PATH; ?>login.php">login</a>
                        </li>
                    <?php }else{?>
                        <li>
                            <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hello ,  <span><?php echo $_SESSION['USER_NAME']; ?></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?php echo WEBSITE_PATH; ?>profile.php">Profile</a>
                                <a class="dropdown-item" href="<?php echo WEBSITE_PATH; ?>orders.php">Orders</a>
                                <a class="dropdown-item" href="<?php echo WEBSITE_PATH; ?>logout.php">LogOut</a>
                            </div>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <?php if(isset($_SESSION['USER_LOGIN'])){?>
                <?php
                    $user_id=$_SESSION['USER_ID'];
                    $total_cart = mysqli_num_rows(mysqli_query($con,"SELECT * FROM user_cart WHERE user_id='$user_id'"));
                ?>
                <div class="cart_nav">
                    <a href="<?php echo WEBSITE_PATH; ?>cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span><?php echo $total_cart; ?></span></a>
                </div>
              <?php }else{ ?>
                  <div class="cart_nav">
                    <a href="<?php echo WEBSITE_PATH; ?>cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>0</span></a>
                  </div>
                <?php } ?>  
        </nav>
    <!--X-NavBar End -X-->
