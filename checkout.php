<?php
    include 'includes/navigation_bar.php';
    include('smtp/PHPMailerAutoload.php');
    if(!isset($_SESSION['USER_LOGIN'])){
        header('Location:login.php?type=msg&page=Cart.php');
    }

    $qunty ='';
    $price ='';

    $name = '';
    $mobile_no ='';
    $house_no='';
    $city='';
    $pin_code='';
    $address_type='';
    $product_iteam_img='';
    

    $total='';

    $cart_total =0;
    $user_id = $_SESSION['USER_ID'];
    $product_id ='';

    if(isset($_GET['cart_total'])){
        $total_cart = mysqli_escape_string($con,$_GET['cart_total']);
        if($total_cart==0){
            echo "<script>
                    alert('You are not cart any product plese cart the product.');
                </script>";
            redirect('shop');
        }
        if($total_cart!=1){
            echo "<script>
                    alert('Please Only One Iteam Checkout at a time');
                </script>";
            redirect('shop');
        }
    }

   

    $sql = mysqli_query($con,"SELECT * FROM cart WHERE consumer_ID	='$user_id' ORDER BY product_id DESC");
?>

<!-- Checkout Page -->
    <div class="container checkout">
        <div class="row heading">
            <div class="col-xl-12">
                <h2>Welcome !</h2>
                <p>Place Your order</p>
            </div>
        </div>
        <div class="row checkout_row">
            <div class="col-xl-6">
                <div class="checkout_sumery">
                    <h2><i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;<span>Cart Summary</span></h2>
                    <?php 
                        while($res = mysqli_fetch_assoc($sql)){
                            $product_id=$res['product_ID'];
                            $product_iteam = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM product WHERE product_ID='$product_id'"));

                    ?>
                    <div class="cart_sumary_info d-flex">
                        <div class="cart_summary_iteam_details">
                            <h3><?php echo $res['quantity'];?> X <span><?php echo $product_iteam['product_name'] ?> ( <?php echo $product_iteam['unitprice'] ?> <?php echo $product_iteam['description'] ?> )</span></h3>
                            <h3>Delivery Charges</h3>
                        </div>
                        <div class="cart_iteam_total_sumary">
                            <?php
                                $qunty = $res['quantity'];
                                $price = $product_iteam['unitprice'];
                                $total = $qunty * $price;
                                $cart_total = $cart_total + $total;
                            ?>
                            <h3>&#2547; <span><?php echo $total; ?></span></h3>
                            <h3>FREE</h3>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="checkout_total">
                            <h3>Sub Total : <span>&#2547;  <?php echo $cart_total;?></span></h3>
                    </div>
                </div>
                
            </div>
            <div class="col-xl-6">
                <h2>Billing Details</h2>
                <?php
                    $sql_info =mysqli_query($con,"SELECT * FROM consumer WHERE consumer_ID = '$user_id'");
                    $res_row = mysqli_fetch_assoc($sql_info);
                ?>
                <form method="post" action="">
                    <div class="form-input">
                        <label for="">Name</label>
                        <input type="text" name="name" value="<?php echo  $res_row['consumer_name']?>">
                    </div>
                    <div class="form-input">
                        <label for="">Mobile Number</label>
                        <input type="number" name="mobile_no" value="<?php echo  $res_row['consumer_contact']?>">
                    </div>
                    <div class="form-input">
                        <label for="">House / Building No</label>
                        <input type="text" name="house_no" value="<?php echo  $res_row['house_no']?>">
                    </div>
                    <div class="form-input">
                        <label for="">City / Vilage</label>
                        <input type="text" name="city" value="<?php echo  $res_row['district']?>">
                    </div>

                    <h2 class="mt-5">Payment Method</h2>
                    
                    <div class="payment">
                        <input type="radio" value="cod" checked="checked" name="payment"> <label for="">Cash On Delivery (COD)</label>
                    </div>
                    <p>By Clicking the button , you are agree to the <a href="#">Terms and Conditions.</a></p>
                    <div class="form-input d-flex align-items-center flex-wrap">
                        <button type="submit" name="update">Place Order Now</button>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
<!--X- Checkout Page -X-->

<?php

if(isset($_POST['update'])){
    $name= mysqli_escape_string($con,$_POST['name']);
    $mobile_no =mysqli_escape_string($con,$_POST['mobile_no']);
    $house_no=mysqli_escape_string($con,$_POST['house_no']);
    $city=mysqli_escape_string($con,$_POST['city']);
    $product_iteam_img = $product_iteam['imagelink'];

    var_dump($product_iteam);

    mysqli_query($con,"UPDATE consumer SET consumer_name='$name' WHERE consumer_ID='$user_id'");
    $query = "INSERT INTO order_table(order_Date, shipping_Mode, consumer_ID, product_ID, order_Status, delivery_ID) VALUES
        ('" . date("Y-m-d H:i:s") . "', 'Express', '$user_id', '" . $product_iteam['product_ID'] . "', 'Pending', '1')";

    $result = mysqli_query($con, $query);

    $insert_id=mysqli_insert_id($con);
	$_SESSION['ORDER_ID']=$insert_id;
    $order_id =$_SESSION['ORDER_ID'];
    $product_email_name = $product_iteam['product_name'];
    $html="
            <h2>Hi,$name<br> Your Order has been <br> placed successfully !</h2>
                <ul style='list-style-type:none;'>
                    <li>Name : <span>$name</span></li>
                    <li>Order Id : <span>$order_id</span></li>
                    <li>Mobile No : <span>$mobile_no</span></li>
                    <li>Address : <span>$house_no $city $pin_code $address_type</li>
                </ul>
            </div>
            <table class='table table-striped table-responsive'>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>qunty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>$product_email_name</td>
                        <td>$qunty</td>
                        <td>&#8377; $cart_total</td>
                    </tr>
                </tbody>
            </table>
            <div class='subtotal'>
                <h2>SubToal <span>&#8377;$cart_total</span></h2>
            </div>
           ";
    redirect('success.php?id='.$user_id);
}

    include 'includes/footer.php';
?>