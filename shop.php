<?php
include 'includes/navigation_bar.php';


// Initializing variables
$c_id = '';
$user_id = '';
$selected = '';

// Check if the product ID is set and valid
if (isset($_GET['c_id']) && $_GET['c_id'] > 0) {
   
    $c_id = mysqli_real_escape_string($con, $_GET['c_id']);

    $user_id = $_SESSION['USER_ID'];


    $cart_check = mysqli_query($con, "SELECT * FROM CART WHERE consumer_ID = '$user_id' AND product_ID = '$c_id'");

    if (!isset($_SESSION['USER_LOGIN'])) {
        header('Location:login.php');
        exit;
    } else {
        // If the product is already in the cart
        if (mysqli_num_rows($cart_check) > 0) {
            echo "<script>alert('Your Selected Product is Already in Cart, Please Check your Cart Details.');</script>";
            redirect('shop.php');
        } else {
            $insert_query = mysqli_query($con, "INSERT INTO CART(consumer_ID, product_ID, quantity) VALUES ('$user_id', '$c_id', '1')");
            if ($insert_query) {
                echo "<script>alert('Congratulations! Your product was successfully added to cart');</script>";
                redirect('shop.php');
            } else {
                echo "<script>alert('Error adding product to cart');</script>";
            }
        }
    }
}

?>
<!--Shop Page-->
<div class="container shopping">
<div class="row heading">
            <div class="col-xl-12">
                <h2>Welcome !</h2>
                <p>Our Shop</p>
            </div>
        </div>

    <!-- Category and Product Display Section -->
    <div class="wrapp d-flex">
        <!-- Left Side - Categories -->
        <div class="left_side">
    <p>Categories</p>
    <div class="category_display">
        <ul>
            <li>
                <div class="category_body text-center">
                    <p><a href="shop?type=forest" class="text-success">Forest Product</a> <span class="pl-2"><a href="shop?type=tribal" class="text-success">Tribal Product</a></span></p>
                </div>
            </li>
            <li>
                <div class="category_body">
                    <a href="shop"><p>All Products</p></a>
                </div>
            </li>
            <!-- Dummy Category 1 -->
            <li>
                <div class="category_body">
                    <p>Fruits & Vegetables</p>
                    <div class="sub_category">
                        <ul>
                            <li><a href="shop?id=1">Fresh Fruits</a></li>
                            <li><a href="shop?id=2">Green Vegetables</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <!-- Dummy Category 2 -->
            <li>
                <div class="category_body">
                    <p>Dairy & Bakery</p>
                    <div class="sub_category">
                        <ul>
                            <li><a href="shop?id=3">Milk & Yogurt</a></li>
                            <li><a href="shop?id=4">Bread & Cakes</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <!-- Additional categories can be added here -->
        </ul>
    </div>
</div>



<div class="right_side" style="flex-grow: 1; padding: 20px; box-sizing: border-box;">
    <p style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Our Products</p>
    <div class="row" style="display: flex; flex-wrap: wrap; justify-content: start;">
        <?php
        
        $product_query = mysqli_query($con, "SELECT * FROM PRODUCT");
        if (mysqli_num_rows($product_query) > 0) {
            while ($row = mysqli_fetch_assoc($product_query)) {
                ?>
                <div class="col-md-6" style="flex: 0 0 calc(50% - 10px); max-width: calc(50% - 10px); padding: 5px; box-sizing: border-box;">
                    <div class="product_card" style="border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                        <div style="position: relative;">
                            <img src="<?php echo $row['imagelink']; ?>" alt="<?php echo $row['product_name']; ?>" style="width: 100%; display: block;">
                            <div style="position: absolute; top: 10px; right: 10px; z-index: 2;">
                                <a href="product-details?product_ID=<?php echo $row['product_ID']; ?>" style="background-color: #fff; border-radius: 50%; padding: 5px;">
                                    <i class="fa fa-eye" aria-hidden="true" style="color: green;"></i>
                                </a>
                            </div>
                        </div>
                        <div style="padding: 15px; text-align: center;">
                            <h3 style="font-size: 1.5em;"><?php echo $row['product_name']; ?></h3>
                            <h4> &#2547; <?php echo $row['unitprice']; ?> <span>taka for <?php echo $row['description']; ?></span></h4>
                            <a href="?c_id=<?php echo $row['product_ID']; ?>&type=cart">
                                <button style="background-color: #4CAF50; color: white; border: none; border-radius: 20px; padding: 10px 20px; cursor: pointer; margin-top: 10px;">Add To Cart</button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-capitalize p-5 text-danger'>No Products Found!</p>";
        }
        ?>
    </div>
</div>



    </div>
    </div>
<?php include 'includes/footer.php'; ?>