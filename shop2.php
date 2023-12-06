<?php
include 'includes/navigation_bar.php';


// Initializing variables
$c_id = '';
$user_id = '';
$selected = '';

// Check if the product ID is set and valid
if (isset($_GET['c_id']) && $_GET['c_id'] > 0) {
    // Escaping the product ID to prevent SQL injection
    $c_id = mysqli_real_escape_string($con, $_GET['c_id']);
    // Assuming USER_ID is set in session upon login
    $user_id = $_SESSION['USER_ID'];

    // Checking if the product is already in the cart
    $cart_check = mysqli_query($con, "SELECT * FROM CART WHERE consumer_ID = '$user_id' AND product_ID = '$c_id'");

    // Redirecting to login page if the user is not logged in
    if (!isset($_SESSION['USER_LOGIN'])) {
        header('Location:login?type=msg&page=Add to Cart');
        exit;
    } else {
        // If the product is already in the cart
        if (mysqli_num_rows($cart_check) > 0) {
            echo "<script>alert('Your Selected Product is Already in Cart, Please Check your Cart Details.');</script>";
            // Redirect to the shop page
            redirect('shop');
        } else {
            // Inserting the new product into the cart
            $insert_query = mysqli_query($con, "INSERT INTO CART(consumer_ID, product_ID, quantity) VALUES ('$user_id', '$c_id', '1')");
            if ($insert_query) {
                echo "<script>alert('Congratulations! Your product was successfully added to cart');</script>";
                redirect('shop');
            } else {
                // Handling errors during query execution
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

        <!-- Right Side - Products -->
        <div class="right_side">
            <p>Our Products</p>
            <div class="row">
            <?php
        // Fetching products from the database
        $product_query = mysqli_query($con, "SELECT * FROM PRODUCT");
        if (mysqli_num_rows($product_query) > 0) {
            while ($row = mysqli_fetch_assoc($product_query)) {
                ?>
                <div class="col-md-4">
                    <div class="product_body">
                        <div class="view_product text-right">
                            <a href="product-details?product_ID=<?php echo $row['product_ID']; ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </div>
                        <img src="<?php echo SITE_PRODUCT_IMAGE . $row['imagelink']; ?>" alt="<?php echo $row['product_name']; ?>">
                        <div class="product_desc">
                            <h3><?php echo $row['product_name']; ?></h3>
                            <h4>&#8377; <?php echo $row['unitprice']; ?> <span>for <?php echo $row['description']; ?></span></h4>
                            <ul class="d-flex">
                                <!-- Ratings or other info can go here -->
                            </ul>
                            <a href="?c_id=<?php echo $row['product_ID']; ?>&type=cart">
                                <button class="btn">Add To Cart</button>
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
