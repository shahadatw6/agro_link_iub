<?php
    include 'includes/navigation_bar.php';
    include('smtp/PHPMailerAutoload.php');
    $consumer_name = '';
    $username = '';
    $password = '';
    $consumer_contact ='';
    $house_no='';
    $road = '';
    $district = ' ';
    if(isset($_POST['signup'])){
        $consumer_name = mysqli_escape_string($con,$_POST['name']);
        $username = mysqli_escape_string($con,$_POST['username']);
        $password = mysqli_escape_string($con,$_POST['password']);
        $consumer_contact =mysqli_escape_string($con,$_POST['contact']);
        $house_no=mysqli_escape_string($con,$_POST['houseno']);
        $road = mysqli_escape_string($con,$_POST['road']);
        $district = mysqli_escape_string($con, $_POST['district']);

        //$password = md5($password);


        mysqli_query($con,"INSERT INTO consumer (consumer_name,username,password,consumer_contact,house_no,road,district) 
        VALUES('$consumer_name','$username','$password','$consumer_contact','$house_no','$road','$district')");
        $id = mysqli_insert_id($con);
        mysqli_query($con,"INSERT INTO consumer(consumer_ID) VALUES('$id')");

            echo "<script>
            alert('You have successfully registered!');
          </script>";
        }
?>

<!-- Registration Page -->
    <div class="container registration">
        <div class="row heading">
            <div class="col-xl-12">
                <h2>Signup Now</h2>
                <p>REGISTER YOUR SELF</p>
                <p class="text-center text-danger"><?php $email_msg; ?></p>
            </div>
        </div>

        <div class="row signup-form-body">
            <div class="col-xl-6">
                <!-- <div class="social_register">
                    <button class="btn"><span><i class="fa fa-google" aria-hidden="true"></i></span> &nbsp; SignUp With Google </button>
                    <p>OR</p>
                </div> -->
                <form method="post" action="">
                    <div class="form-input">
                        <input type="text" name="name" placeholder="Enter Your Full Name" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="contact" placeholder="Enter Your Contact Number" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="username" placeholder="Enter Your Username" required>
                    </div>
                    <div class="form-input">
                        <input type="password" name="password" placeholder="Enter Your Password" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="road" placeholder="Enter Your Road Number" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="district" placeholder="Enter Your District" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="house" placeholder="Enter Your House Number" required>
                    </div>

                    <div class="form-input d-flex align-items-center flex-wrap">
                        <button type="submit" name="signup">Signup Now</button>
                        <p>You are Alrady Signup,Please <a href="<?php echo WEBSITE_PATH; ?>login">Login Here</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--X- Registration Page -X-->

<?php
    include 'includes/footer.php';
?>