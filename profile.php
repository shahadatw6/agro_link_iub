<?php
    include 'includes/navigation_bar.php';
    if(!isset($_SESSION['USER_LOGIN'])){
        header('Location: login?type=msg&page=Cart');
    }
    $user_id = $_SESSION['USER_ID'];

    // Fetching consumer details
    $consumer_sql = mysqli_query($con, "SELECT * FROM consumer_table WHERE consumer_ID = '$user_id'");
    $is_consumer = mysqli_num_rows($consumer_sql) > 0;
    $user_info = mysqli_fetch_assoc($consumer_sql);

    // Fetching farmer details
    $farmer_sql = mysqli_query($con, "SELECT * FROM farmer_table WHERE farmer_ID = '$user_id'");
    $is_farmer = mysqli_num_rows($farmer_sql) > 0;
    $farmer_info = mysqli_fetch_assoc($farmer_sql);
?>

<!-- profile body -->
<div class="container profile">
    <div class="row heading">
        <div class="col-xl-12">
            <h2>Your Profile</h2>
            <p>Update Now</p>
        </div>
        <div class="update_profile">
            <?php if($is_consumer): ?>
                <a href="<?php echo WEBSITE_PATH; ?>manage_consumer_profile?type=update"><button class="btn">Update Consumer Profile</button></a>
            <?php elseif($is_farmer): ?>
                <a href="<?php echo WEBSITE_PATH; ?>manage_farmer_profile?type=update"><button class="btn">Update Farmer Profile</button></a>
            <?php else: ?>
                <!-- Display options for new user registration -->
                <a href="<?php echo WEBSITE_PATH; ?>register?type=consumer"><button class="btn">Register as Consumer</button></a>
                <a href="<?php echo WEBSITE_PATH; ?>register?type=farmer"><button class="btn">Register as Farmer</button></a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($is_consumer): ?>
        <!-- Display Consumer Info -->
        <div class="row personal_info">
            <div class="col-xl-6 personal_info_row">
                <p>Consumer Information</p>
                <div class="prosonal_filed">
                    <ul>
                        <li>ID: <span><?php echo $user_info['consumer_ID'];?></span></li>
                        <li>Name: <span><?php echo $user_info['consumer_name'];?></span></li>
                        <li>Contact: <span><?php echo $user_info['consumer_contact'];?></span></li>
                        <!-- Add other consumer fields here -->
                    </ul>
                </div>
            </div>
        </div>
    <?php elseif($is_farmer): ?>
        <!-- Display Farmer Info -->
        <div class="row personal_info">
            <div class="col-xl-6 personal_info_row">
                <p>Farmer Information</p>
                <div class="prosonal_filed">
                    <ul>
                        <li>ID: <span><?php echo $farmer_info['farmer_ID'];?></span></li>
                        <li>Name: <span><?php echo $farmer_info['farmer_Name'];?></span></li>
                        <li>Contact: <span><?php echo $farmer_info['farmer_contact'];?></span></li>
                        <!-- Add other farmer fields here -->
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!--X- profile body -X-->

<?php
    include 'includes/footer.php';
?>
