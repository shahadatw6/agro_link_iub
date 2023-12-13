<?php
    include 'includes/navigation_bar.php';
    $c_id='';
    $user_id='';
    $selected ='';
    if(isset($_GET['product_ID']) && $_GET['product_ID']>0){
            $product_ID = mysqli_escape_string($con,$_GET['product_ID']);
            $consumer_ID = $_SESSION['USER_ID'];
            $cart_check = mysqli_query($con,"SELECT * FROM CART WHERE user_id='$consumer_ID' AND product_id='$product_ID'");
            if(!isset($_SESSION['USER_LOGIN'])){
                header('Location:login?type=msg&page=Add to Cart');
            }else{
                if(mysqli_num_rows($cart_check)>0){
                    echo "<script>
                            alert(`Your Selected Product Alrady Cart, Please Check your Cart Detailes.`);
                        </script>";
                redirect('shop');
                }else{
                    $size = 1;
                    mysqli_query($con,"INSERT INTO CART(cart_ID, consumer_ID,product_ID,quantity) VALUES('$size','$user_id','$c_id','1')");
                    echo "<script>
                            alert(`Congratulation ! your product successfully Added to cart`);
                        </script>"; 
                redirect('shop');
                }
            }
    }
?>

<!--Shop Page  -->
    <div class="container shopping">
        <div class="row heading">
            <div class="col-xl-12">
                <h2>Welcome !</h2>
                <p>Our Shop</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 open_filter">
                <p>Filter <span id="open_filter"><i class="fa fa-plus" aria-hidden="true"></i></span><span id="close_filter"><i class="fa fa-times" aria-hidden="true"></i></span></p>
            </div>
        </div>
    </div>
    <div class="wrapp d-flex">
      
        <!--X- Categories Body -X-->

    </div>
<!--X-Shop Page-X-->
       
<?php
    include 'includes/footer.php';
?>