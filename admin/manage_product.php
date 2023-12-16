<?php
include('top.php');

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
$best_before = "";
$weight = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE product_ID='$id'"));
    $product_name = get_safe_value($row['product_name']);
	$category_id = get_safe_value($row['category']);
    $product_detail = get_safe_value($row['description']);
    $added_on = date('Y-m-d h:i:s');
	$unit_price = get_safe_value($row['UnitPrice']);
	$product_origin = get_safe_value($row['product_Origin']);
	$amount = get_safe_value($row['availability']);
	$best_before = get_safe_value($row['bestBefore']);
	$weight = get_safe_value($row['weight']);
}

if (isset($_POST['submit'])) {
	$category_id = get_safe_value($_POST['category_id']);
    $product_name = get_safe_value($_POST['product']);
    $product_detail = get_safe_value($_POST['product_detail']);
    $added_on = date('Y-m-d h:i:s');
	$unit_price = get_safe_value($_POST['UnitPrice']);
	$product_origin = get_safe_value($_POST['product_origin']);
	$amount = get_safe_value($_POST['availability']);
	$best_before = get_safe_value($_POST['bestBefore']);
	$weight = get_safe_value($_POST['weight']);


    $_name = $_SESSION['FARMER_ID'];

    if ($id == '') {
        $sql = "SELECT * FROM product WHERE product_name='$product_name'";
    } else {
        $sql = "SELECT * FROM product WHERE product_name='$product_name' AND product_ID!='$id'";
    }
	
    if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
        $msg = "Product already added";
    } else {
        $type = $_FILES['image']['type'];
        if ($id == '') {
            if ($type != 'image/jpeg' && $type != 'image/png') {
                $image_error = "Invalid image format please select png/jpeg format";
            } else {
				$image = $product_name. '_' . $_FILES['image']['name'];
				$targetPath = 'images/new data/product/' . $image;
				move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
				$imagelink = $targetPath;

                mysqli_query($con, "INSERT INTO product(product_name, product_Origin, availability, dateAdded, bestBefore, weight, imagelink, category, unitprice, description, added_by) VALUES 
				('$product_name', '$product_origin', '$amount','$added_on', '$best_before', '$weight', '$imagelink','$category_id','$unit_price','$product_detail','" . $_name . "')");
                $did = mysqli_insert_id($con);
                redirect('product');
            }
        } else {
            if ($_FILES['image']['type'] == '') {
                if ($type != 'image/jpeg' && $type != 'image/png' ) {
                    $image_error = "Invalid image format please select png/jpeg format";
                } else {
                    $image = $product_name. '_' . $_FILES['image']['name'];
                    $targetPath = 'images/new data/product/' . $image;
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
                    $imagelink = $targetPath;
                    mysqli_query($con, "UPDATE product SET 
                    product_name='$product_name', 
                    product_Origin='$product_origin', 
                    availability='$amount', 
                    dateAdded='$added_on', 
                    bestBefore='$best_before', 
                    weight='$weight', 
                    imagelink='$imagelink', 
                    category='$category_id', 
                    unitprice='$unit_price', 
                    description='$product_detail', 
                    added_by='$_name' 
                    WHERE product_ID='$id'");
                    redirect('product');}
            } else if ($type != 'image/jpeg' && $type != 'image/png') {
                $image_error = "Invalid image format please select png/jpeg format";
            } else {
                $sql = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE product_ID='$id'"));
                $old_image = unlink($sql['imagelink']);
				$image = $product_name. '_' . $_FILES['image']['name'];
				
                $targetPath = 'images/new data/product/' . $image;
				move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
				$imagelink = $targetPath;
                mysqli_query($con, "UPDATE product SET 
                    product_name='$product_name', 
                    product_Origin='$product_origin', 
                    availability='$amount', 
                    dateAdded='$added_on', 
                    bestBefore='$best_before', 
                    weight='$weight', 
                    imagelink='$imagelink', 
                    category='$category_id', 
                    unitprice='$unit_price', 
                    description='$product_detail', 
                    added_by='$_name' 
                    WHERE product_ID='$id'");
                    redirect('product');
                redirect('product');
            }
        }
    }
}

$res_category = mysqli_query($con, "SELECT * FROM category WHERE status='1' ORDER BY category");
?>

<div class="row">
    <h1 class="grid_title ml10 ml15">Product </h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
				<div class="form-group">
    				<label for="exampleInputName1">Category</label>
    				<select class="form-control" name="category_id" required>
        			<option value="1" <?php echo ($category_id == 1) ? 'selected' : ''; ?>>Grains</option>
        			<option value="2" <?php echo ($category_id == 2) ? 'selected' : ''; ?>>Fruits</option>
        			<option value="3" <?php echo ($category_id == 3) ? 'selected' : ''; ?>>Poultry</option>
    				</select>
				</div>


                    <div class="form-group">
                        <label for="exampleInputName1">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product" name="product" required value="<?php echo $product_name ?>">
                        <div class="error mt8"><?php echo $msg ?></div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3" required>Product Detail</label>
                        <textarea name="product_detail" class="form-control" placeholder="Short description"><?php echo $product_detail ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3" required>Unit Price</label>
                        <textarea name="UnitPrice" class="form-control" placeholder="Unit Price"><?php echo $unit_price ?></textarea>
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
