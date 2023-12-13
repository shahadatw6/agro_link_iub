<?php
session_start();
require_once '../includes/database.inc.php';
include_once("../includes/constant.inc.php");
include '../includes/function.inc.php';

$username = '';
$password = '';
$msg = '';
$type = '';
$page = '';


if (isset($_POST['login'])) {
    $username = mysqli_escape_string($con, $_POST['username']);
    $password = mysqli_escape_string($con, $_POST['password']);

    $check = mysqli_query($con, "SELECT * FROM farmer WHERE username = '$username' AND password='$password'");
    $res = mysqli_fetch_assoc($check);

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['FARMER_LOGIN'] = 'yes';
        $_SESSION['ADMIN_ROLE'] = '0';
        $_SESSION['NAME'] = $res['farmer_Name'];
        $_SESSION['FARMER_ID'] = $res['farmer_ID'];
        header('Location: product.php'); 
    } else {
        $msg = "<div class='alert' role='alert'>
            Please Enter Correct Username And Password Otherwise <a href='admin_registration'> SIGNUP NOW </a>
            </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo WEBSITE_NAME; ?>-farmer Login</title>

    <!-- Favicon -->
    <link href="https://pics.freeicons.io/uploads/icons/png/8026814321579250998-512.png" rel="icon" type="image/x-icon"/>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto+Condensed:wght@400;700&display=swap"
          rel="stylesheet">
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- External Style Sheet -->
    <link rel="stylesheet" href="<?php echo WEBSITE_PATH; ?>style/style.css">
</head>
<body>
<!-- Login Page -->
<div class="container login_page">
    <div class="row heading">
        <div class="col-xl-12">
            <h2>Login Now As Farmer</h2>
        </div>
    </div>
    <?php echo $msg; ?>
    <div class="row signup-form-body">
        <div class="col-xl-6">
            <form method="post" action="">
                <div class="form-input">
                    <input type="text" name="username" placeholder="Enter Your Username" required>
                </div>
                <div class="form-input">
                    <input type="password" name="password" placeholder="Enter Your Password" required>
                </div>
                <p class="m-0">Forgot Password?<a href="<?php echo WEBSITE_PATH; ?>admin/forgot_password"> Here</a>.</p>
                <div class="form-input d-flex align-items-center flex-wrap">
                    <button type="submit" name="login">Login Now</button><br>
                    <br>
                    <p>You are Not Signed Up, Please <a href="admin/farmer_registration.php">sign up Here</a>.</p>
                </div>
            </form>
        </div>
    </div>
</div>
<!--X- Login Page -X-->
</body>
</html>
