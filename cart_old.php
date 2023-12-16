<?php
    include 'includes/navigation_bar.php';
    if(!isset($_SESSION['USER_LOGIN'])){
        header('Location:login?type=msg&page=Cart');
    }
    $qunty ='';
    $price ='';
    $type ='';
    $total='';
    $qty = '';
    $cart_total =0;
    $cart_roow='';
    $user_id = $_SESSION['USER_ID'];
<<<<<<< HEAD
    if(isset($_GET['quantity']) && $_GET['quantity'] >0 && $_GET['update'] && $_GET['update'] >0){
        $qty = mysqli_escape_string($con,$_GET['quantity']);
        $cart_user_id = mysqli_escape_string($con,$_GET['update']);
        mysqli_query($con,"update CART set quantity='$quantity' where consumer_ID='$cart_user_id'");
    }
    if(isset($_GET['cart_ID']) && $_GET['cart_ID']>0 && $_GET['type']) {
        $cart_ID = mysqli_escape_string($con,$_GET['cart_ID']);
        $type = mysqli_escape_string($con,$_GET['type']);
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM CART WHERE id ='$cart_ID'");
            header("Location:cart.php");
        }
    }
    $sql = mysqli_query($con,"SELECT * FROM CART WHERE consumer_ID='$user_id' ORDER BY product_ID DESC");
=======
    if(isset($_GET['qty']) && $_GET['qty'] >0 && $_GET['update'] && $_GET['update'] >0){
        $qty = mysqli_escape_string($con,$_GET['qty']);
        $cart_user_id = mysqli_escape_string($con,$_GET['update']);
        mysqli_query($con,"update user_cart set qty='$qty' where id='$cart_user_id'");
    }
    if(isset($_GET['id']) && $_GET['id']>0 && $_GET['type']) {
        $id = mysqli_escape_string($con,$_GET['id']);
        $type = mysqli_escape_string($con,$_GET['type']);
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM user_cart WHERE id ='$id'");
            header("Location:cart");
        }
    }
    $sql = mysqli_query($con,"SELECT * FROM cart WHERE user_id='$user_id' ORDER BY product_id DESC");
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
?>

<!-- Cart Page -->
    <div class="container-fluid cart_page">
        <div class="row heading">
            <div class="col-xl-12">
                <h2>Welcome !</h2>
                <p>Your Shopping Cart</p>
            </div>
        </div>
        <div class="row shoppping_cart">
            <?php 
                if(mysqli_num_rows($sql)>0){
                    $cart_roow = mysqli_num_rows($sql);
                    while($row=mysqli_fetch_array($sql)){
<<<<<<< HEAD
                        $product_id=$row['product_ID'];
                        $product_iteam = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM PRODUCT WHERE product_ID='$product_id'"));
            ?>
                <div class="d-flex  shopping_cart_iteam">
                    <img src="http://127.0.0.1/agro_link_iub/images/new%20data/crops%20and%20fruits.jpg" alt="">
                    <div class="cart_iteam_desc">
                        <h3><?php echo $product_iteam['product_name']; ?></h3>
=======
                        $product_id=$row['product_id'];
                        $product_iteam = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM product WHERE id='$product_id'"));
            ?>
                <div class="d-flex  shopping_cart_iteam">
                    <img src="<?php echo SITE_PRODUCT_IMAGE.$product_iteam['image']; ?>" alt="">
                    <div class="cart_iteam_desc">
                        <h3><?php echo $product_iteam['product']; ?></h3>
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
                        <?php
                            $attei_sql = mysqli_query($con,"SELECT * FROM product_detailes WHERE product_id	='$product_id'");
                            $row_price=mysqli_fetch_assoc($attei_sql);
                         ?>
<<<<<<< HEAD
                            <h4> &#8377; <?php echo $product_iteam['unitprice'];?> <span> for <?php echo $product_iteam['weight'];?></span></h4>
=======
                            <h4> &#8377; <?php echo $row_price['price'];?> <span> for <?php echo $row_price['attribute'];?></span></h4>
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
                        <ul class="d-flex">
                            <li>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </li>
                            <li>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </li>
                            <li>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </li>
                            <li>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </li>
                        </ul>
                    </div>
                    <select name="qty" value="" id="qty"  onchange="updatecart()">
<<<<<<< HEAD
                            <option value="<?php echo $row['quantity'] ?>"><?php echo $row['quantity'] ?></option>
=======
                            <option value="<?php echo $row['qty'] ?>"><?php echo $row['qty'] ?></option>
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
                        <?php $i=1;
                            while($i<6){?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php $i++; } ?>
                    </select>
                    <?php 
<<<<<<< HEAD
                        $qunty = $row['quantity'];
                        $price = $product_iteam['unitprice'];
=======
                        $qunty = $row['qty'];
                        $price = $row_price['price'];
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
                        $total = $qunty * $price;
                        $cart_total = $cart_total + $total             
                    ?>
                    <h3>&#8377; <?php echo $total ?></h3>
                   <?php $cart_row_id =$row['id']  ?>
<<<<<<< HEAD
                    <a href="?id=<?php echo $row['cart_id'] ?>&type=delete"><i class="fa fa-times" aria-hidden="true"></i></a>
=======
                    <a href="?id=<?php echo $row['id'] ?>&type=delete"><i class="fa fa-times" aria-hidden="true"></i></a>
>>>>>>> 7aedf4ddc6b1f83dac21101745dea59216241502
                </div>
                <?php } 
            }else{
                echo "<p class='text-center text-danger'><b>You are Not Cart Any Iteam, please <a href='shop' class='text-success'> shopping Now. </a></b></p>";
            } ?>
        </div>
        <div class="row shopping_cart_total">
             <h3>Total : <span>&#8377; <?php echo $cart_total?></span></h3>
        </div>
        <div class="row cart_checkout">
            <a href="<?php echo WEBSITE_PATH; ?>shop"><button class="btn">Continue Shopping</button></a>
            <a href="<?php echo WEBSITE_PATH; ?>checkout?cart_total=<?php echo $cart_roow; ?>"><button class="btn">Checkout Now</button></a>
        </div>
    </div>
<!--X-Cart Page-X -->

<script>
    function updatecart(){
        var cart_qty=jQuery('#qty').val();
        if(cart_qty!=''){
            var oid="<?php echo $cart_row_id?>";
            window.location.href='<?php echo WEBSITE_PATH ?>cart?update='+oid+'&qty='+cart_qty;
        }
    }
</script>
<?php
    include 'includes/footer.php';
?>