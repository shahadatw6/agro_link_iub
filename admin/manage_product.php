<?php
include('top.php');

// $condition = '';
// $condition1 = '';
// if ($_SESSION['ADMIN_ROLE'] == '0') {
//     $condition = " and product.added_by='" . $_SESSION['ADMIN_ID'] . "'";
//     $condition1 = " and added_by='" . $_SESSION['ADMIN_ID'] . "'";
// }

$msg = "";
$category_id = "";
$product_name = "";
$product_detail = "";
$image = "";
$id = "";
$image_status = 'required';
$image_error = "";
$unit_price = "";
$product_origin = "";
$amount = "";
$bestbefore = "";
$weight = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE product_ID='$id' $condition1"));
    $category_id = $row['category'];
    $product_name = $row['product_name'];
    $product_detail = $row['description'];
    $image = $row['imagelink'];
    $image_status = '';
    $admin_name = '';
}

if (isset($_POST['submit'])) {
    $product_name = get_safe_value($_POST['product']);
    $product_detail = get_safe_value($_POST['product_detail']);
    $product_type = get_safe_value($_POST['type']);
    $added_on = date('Y-m-d h:i:s');

    $admin_name = $_SESSION['ADMIN_NAME'];

    if ($id == '') {
        $sql = "SELECT * FROM product WHERE product_name='$product' $condition1";
    } else {
        $sql = "SELECT * FROM product WHERE product_name='$product' AND product_ID!='$id' $condition1";
    }
    if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
        $msg = "Product already added";
    } else {
        $type = $_FILES['image']['type'];
        if ($id == '') {
            if ($type != 'image/jpeg' && $type != 'image/png') {
                $image_error = "Invalid image format please select png/jpeg format";
            } else {
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], SERVER_PRODUCT_IMAGE . $image);
                mysqli_query($con, "INSERT INTO product(category, product_name, description, status, dateAdded, imagelink, type, added_by) VALUES ('$category_id', '$product', '$product_detail', 1, '$added_on', '$image', '$product_type', '" . $_SESSION['ADMIN_ID'] . "')");
                $did = mysqli_insert_id($con);

                $attributeArr = $_POST['attribute'];
                $priceArr = $_POST['price'];
                foreach ($attributeArr as $key => $val) {
                    $attribute = $val;
                    $price = $priceArr[$key];
                    mysqli_query($con, "INSERT INTO product_detailes(product_id, attribute, price, status, added_on) VALUES ('$did', '$attribute', '$price', 1, '$added_on')");
                }
                redirect('product');
            }
        } else {
            if ($_FILES['image']['type'] == '') {
                mysqli_query($con, "UPDATE product SET category='$category_id', product_name='$product', description='$product_detail', imagelink='$image', type='$product_type', added_by='" . $_SESSION['ADMIN_ID'] . "' WHERE product_ID='$id'");
                $attributeArr = $_POST['attribute'];
                $priceArr = $_POST['price'];
                $productDetailsIdArr = $_POST['product_details_id'];
                foreach ($attributeArr as $key => $val) {
                    $attribute = $val;
                    $price = $priceArr[$key];

                    if (isset($productDetailsIdArr[$key])) {
                        $did = $productDetailsIdArr[$key];
                        mysqli_query($con, "UPDATE product_detailes SET attribute='$attribute', price='$price' WHERE id='$did'");
                    } else {
                        mysqli_query($con, "INSERT INTO product_detailes(product_id, attribute, price, status, added_on) VALUES ('$id', '$attribute', '$price', 1, '$added_on')");
                    }
                }
                redirect('product');
            } else if ($type != 'image/jpeg' && $type != 'image/png') {
                $image_error = "Invalid image format please select png/jpeg format";
            } else {
                $sql = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE product_ID='$id'"));
                $old_image = unlink(SERVER_PRODUCT_IMAGE . $sql['imagelink']);
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], SERVER_PRODUCT_IMAGE . $image);
                mysqli_query($con, "UPDATE product SET category='$category_id', product_name='$product', description='$product_detail', imagelink='$image', type='$product_type', added_by='$admin_name' WHERE product_ID='$id'");

                foreach ($attributeArr as $key => $val) {
                    $attribute = $val;
                    $price = $priceArr[$key];

                    if (isset($productDetailsIdArr[$key])) {
                        $did = $productDetailsIdArr[$key];
                        mysqli_query($con, "UPDATE product_detailes SET attribute='$attribute', price='$price' WHERE id='$did'");
                    } else {
                        mysqli_query($con, "INSERT INTO product_detailes(product_id, attribute, price, status, added_on) VALUES ('$id', '$attribute', '$price', 1, '$added_on')");
                    }
                }
                redirect('product');
            }
        }
    }
}

$res_category = mysqli_query($con, "SELECT * FROM category WHERE status='1' ORDER BY category");
$arrType = ["tribal", "forest"];
?>

<div class="row">
    <h1 class="grid_title ml10 ml15">Product</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName1">Category</label>
                        <select class="form-control" name="category_id" required>
                            <option value="1">Grains</option>
                            <option value="2">Fruits</option>
                            <option value="3">Poultry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product" name="product" required value="<?php echo $product ?>">
                        <div class="error mt8"><?php echo $msg ?></div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3" required>Product Detail</label>
                        <textarea name="product_detail" class="form-control" placeholder="Short description"><?php echo $product_detail ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3" required>Unit Price</label>
                        <textarea name="Unit_Price" class="form-control" placeholder="Unit Price"><?php echo $unit_price ?></textarea>
                    </div>                   

                    <div class="form-group">
                        <label for="exampleInputEmail3" required>Product origin</label>
                        <textarea name="product_origin" class="form-control" placeholder="Product Origin"><?php echo $product_origin ?></textarea>
                    </div>

					<div class="form-group">
                        <label for="exampleInputEmail3" required>Amount</label>
                        <textarea name="amount" class="form-control" placeholder="amount"><?php echo $amount ?></textarea>
                    </div>

					<div class="form-group">
    					<label for="exampleInputEmail3" required>Best Before</label>
    					<input type="date" class="form-control" placeholder="Best Before" name="best_before" value="<?php echo $bestbefore ?>">
					</div>		

					<div class="form-group">
    					<label for="exampleInputEmail3" required>Weight</label>
    					<input type="number" step="0.01" class="form-control" name="weight" placeholder="Weight" value="<?php echo $weight ?>">
					</div>


                    <div class="form-group">
                        <label for="exampleInputEmail3">Product Image</label>
                        <input type="file" class="form-control" placeholder="Product Image" name="image" <?php echo $image_status ?>>
                        <div class="error mt8"><?php echo $image_error ?></div>
                    </div>

                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="add_more" value="1" />
<script>
    function add_more() {
        var add_more = jQuery('#add_more').val();
        add_more++;
        jQuery('#add_more').val(add_more);
        var html = '<div class="row mt8" id="box' + add_more + '"><div class="col-5"><input type="text" class="form-control" placeholder="Attribute" name="attribute[]" required></div><div class="col-5"><input type="text" class="form-control" placeholder="Price" name="price[]" required></div><div class="col-2"><button type="button" class="btn badge-danger mr-2" onclick=remove_more("' + add_more + '")>Remove</button></div></div>';
        jQuery('#dish_box1').append(html);
    }

    function remove_more(id) {
        jQuery('#box' + id).remove();
    }

    function remove_more_new(id) {
        var result = confirm('Are you sure?');
        if (result == true) {
            var cur_path = window.location.href;
            window.location.href = cur_path + "&dish_details_id=" + id;
        }
    }
</script>
<?php include('footer.php'); ?>
