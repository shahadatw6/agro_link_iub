<?php 
include('top.php');

// $condition = '';

if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type = get_safe_value($_GET['type']);
    $id = get_safe_value($_GET['id']);
    
    if($type=='active' || $type=='deactive'){
        $status = 1;
        if($type=='deactive'){
            $status = 0;
        }
        mysqli_query($con, "update product set status='$status' where product_ID='$id'");
        redirect('product');
    }

    if($type == 'delete'){
        $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE product_ID='$id'"));
        $oldImage = $res['imagelink'];
        $imagePath = SERVER_PRODUCT_IMAGE.$oldImage;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        mysqli_query($con, "DELETE FROM product WHERE product_ID='$id'");
        mysqli_query($con, "DELETE FROM product_detailes WHERE product_id='$id'");
        redirect('product');
    }
}

if($_SESSION['ADMIN_ROLE'] == 1){
    $sql = "SELECT * FROM product  ORDER BY product_ID DESC";
    $res = mysqli_query($con, $sql);
}else if ($_SESSION['ADMIN_ROLE'] == 0){
    $sql = "SELECT * FROM product WHERE added_by = {$_SESSION['FARMER_ID']}  ORDER BY product_ID DESC";
    $res = mysqli_query($con, $sql);
}
?>
<div class="card">
    <div class="card-body">
        <h1 class="grid_title">Product Master</h1>
        
        <a href="manage_product" class="add_link">
           <button style= "background-color: rgb(175, 207, 99); 
				border-radius: 5px; border-color: rgb(175, 207, 99);
				color: white"> Add Product </button>
        </a>
        <div class="row grid_box">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Added On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($res)>0){
                                $i=1;
                                while($row=mysqli_fetch_assoc($res)){
$imagePath = 'C:/xampp/htdocs/agro_link_iub/images/new data/product/' . $row['product_ID'] . '.' . $row['product_name'];
                            ?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $row['product_name']?></td>
                                    <td><a target="_blank" href="<?php echo $imagePath?>"><img src="<?php echo $imagePath?>"/></a></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['dateAdded']));?></td>
                                    <td>
                                        <a href="manage_product?id=<?php echo $row['product_ID']?>"><label class="badge badge-success hand_cursor">Edit</label></a>&nbsp;
                                        <?php
                                        if($row['status']==1){
                                        ?>
                                        <a href="?id=<?php echo $row['product_ID']?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>
                                        <?php
                                        }else{
                                        ?>
                                        <a href="?id=<?php echo $row['product_ID']?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
                                        <?php
                                        }
                                        ?>
                                        <a href="?id=<?php echo $row['product_ID']?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>
                                    </td>
                                </tr>
                            <?php 
                                $i++;
                                } 
                            } else { ?>
                                <tr>
                                    <td colspan="5">No data found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>
