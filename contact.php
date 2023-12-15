<?php
    require_once 'includes/database.inc.php';
    include_once("includes/constant.inc.php");
    include 'includes/navigation_bar.php';
    include('smtp/PHPMailerAutoload.php');

    $name ='';
    $email ='';
    $subject ='';
    $message ='';

    if(isset($_POST['submit'])){
        $name =  mysqli_escape_string($con,$_POST['contact_name']);
        $email = mysqli_escape_string($con,$_POST['contact_email']);
        $subject =  mysqli_escape_string($con,$_POST['contact_subject']);
        $message =  mysqli_escape_string($con,$_POST['contact_message']);
        
        mysqli_query($con,"INSERT INTO contact(contact_name, contact_email, contact_subject, contact_message) VALUES('$name','$email','$subject','$message')");
        // $html="<p><b>Thank You $name </b> ! <br> for connecting with us, Will get back to you shortly.</p>";
        // send_email($email,$html,'Contact~E-marketplace');
        echo "<script>
                alert(`Thank You $name for connecting with us, Will get back to you shortly !`);
            </script>"; 
        redirect('index.php');
    }
?>

<!-- Contact Page -->
    <div class="container contact">
        <div class="row heading">
            <div class="col-xl-12">
                <h2>Get in Touch</h2>
                <p>CONTACT INFORMATION</p>
            </div>
        </div>
        <div class="row form-body">
            <div class="col-xl-6">
                <div class="contact-body">
                    <div class="contact-icon">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info">
                        <p>Bashundhara R/A,Block-B,Road 10</p>
                    </div>
                </div>
                <div class="contact-body">
                    <div class="contact-icon">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info">
                        <p>01978627888</p>
                    </div>
                </div>
                <div class="contact-body">
                    <div class="contact-icon">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info">
                        <p>cow@sitename.com</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <form method="post" action="">
                    <div class="form-input">
                        <input type="text" name="contact_name" placeholder="Enter Your Name" required>
                    </div>
                    <div class="form-input">
                        <input type="email" name="contact_email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="form-input">
                        <input type="text" name="contact_subject" placeholder="Enter Your Subject" required>
                    </div>
                    <div class="form-input">
                        <textarea name="contact_message" id="" cols="30" rows="10" placeholder="Enter your message"></textarea>
                    </div>
                    <div class="form-input">
                        <button type="submit" name="submit">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--X- Contact Page -X-->

<?php
    include 'includes/footer.php';
?>