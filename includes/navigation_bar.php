<?php include 'top.php'; ?>

<nav class="d-flex fixed-top">
    <div class="nav_brand">
        <a href="<?php echo WEBSITE_PATH; ?>index.php">
            <span>Agro-Link</span>
        </a>
    </div>
    <div class="nav_menu ml-auto"> 
        <ul class="d-flex">
            <li>
                <a href="<?php echo WEBSITE_PATH; ?>index.php">home</a>
            </li>
            <li>
                <a href="<?php echo WEBSITE_PATH; ?>about.html">about</a>
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
                        <a class="dropdown-item" href="<?php echo WEBSITE_PATH; ?>cart.php">Cart</a>
                        <a class="dropdown-item" href="<?php echo WEBSITE_PATH; ?>logout.php">LogOut</a>
                    </div>
                </li>
            <?php }?>
        </ul>
    </div>
 
</nav>
