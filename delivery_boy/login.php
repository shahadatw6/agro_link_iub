<?php
session_start();
require_once '../includes/database.inc.php';
include_once("../includes/constant.inc.php");
include '../includes/function.inc.php';

$username = '';
$password = '';

if (isset($_POST['login'])) {
    $username = mysqli_escape_string($con, $_POST['username']);
    $password = mysqli_escape_string($con, $_POST['password']);

    $check = mysqli_query($con, "SELECT * FROM employee WHERE username = '$username' AND password='$password'");
    $res = mysqli_fetch_assoc($check);

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['DELIVERYBOY_LOGIN'] = 'yes';
        $_SESSION['ADMIN_ROLE'] = '5';
        $_SESSION['NAME'] = $res['emp_name'];
        $_SESSION['DELIVERYBOY_ID'] = $res['employee_ID'];
        header('Location: index.php');
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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Delivery Boy - Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../admin/assets/css/style.css">
</head>
<body class="sidebar-light">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center">
                <h3 class="text-center text-success">Delivery Boy</h3>
              </div>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="post">
                <div class="form-group">
                  <input type="textbox" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="username" name="username" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password"  name="password" required>
                </div>
                <div class="mt-3">
                  <input type="submit" class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn" value="SIGN IN" name="submit"/>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
</body>
</html>
