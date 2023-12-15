<?php 
include('top.php');

if (isset($_POST['delete'])) {
    $orderId = get_safe_value($_POST['order_id']);
    mysqli_query($con, "DELETE FROM order_table WHERE order_ID='$orderId'");
    redirect('orders.php');
}

$sql = "SELECT * FROM order_table ORDER BY order_ID DESC";
$res = mysqli_query($con, $sql);
?>

<div class="card">
    <div class="card-body">
        <h1 class="grid_title">Order</h1>
        <div class="row grid_box">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="5%">order_ID</th>                    
                                <th width="20%">order_Date</th>
                                <th width="5%">shipping_Mode</th>
                                <th width="10%">consumer_ID</th>
                                <th width="10%">product_ID</th>
                                <th width="15%">order_Status</th>
                                <th width="15%">delivery_State</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($res) > 0){
                                while($row = mysqli_fetch_assoc($res)){
                                    $user_id = $row['order_ID'];
                                    $user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM order_table WHERE order_ID = '$user_id'"));
                            ?>
                            <tr>
                                <td>
                                    <div class="div_order_id">
                                        <a href="order_detailes?id=<?php echo $user['order_ID']?>"><?php echo $user['order_ID']?></a>
                                    </div>
                                </td>
                                <td>                            
                                    <p><?php echo $user['order_Date']?></p>
                                </td>   
                                <td>    
                                    <p><?php echo $user['shipping_Mode']?></p>
                                </td>
                                <td> <?php echo $user['consumer_ID']?> </td>
                                <td> <?php echo $user['product_ID']?></td>
                                <td>
                                    <p><?php echo $user['order_Status']?></p>
                                </td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $user['order_ID']; ?>">
                                        <div class="form-group">
                                            <select class="form-control" name="new_status">
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Pending" <?php if ($user['order_Status'] == 'Pending') echo 'selected' ?>>Pending</option>
                                                <option value="In Warehouse" <?php if ($user['order_Status'] == 'In Warehouse') echo 'selected' ?>>In Warehouse</option>
                                                <option value="Out for Delivery" <?php if ($user['order_Status'] == 'Out for Delivery') echo 'selected' ?>>Out for Delivery</option>
                                                <option value="Delivered" <?php if ($user['order_Status'] == 'Delivered') echo 'selected' ?>>Delivered</option>
                                                <option value="Out of Stock" <?php if ($user['order_Status'] == 'Out of Stock') echo 'selected' ?>>Out of Stock</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm" name="change_status">Change Status</button>
                                        <button type="submit" class="badge badge-danger delete_red hand_cursor" name="delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                    </form>
                                    <?php
                                    if (isset($_POST['change_status'])) {
                                        $newStatus = get_safe_value($_POST['new_status']);
                                        $orderId = get_safe_value($_POST['order_id']);
                                        $updateQuery = "UPDATE order_table SET order_Status='$newStatus' WHERE order_ID='$orderId'";
                                        if (mysqli_query($con, $updateQuery)) {
                                            echo "Order status updated successfully!";
                                        } else {
                                            echo "Error updating order status: " . mysqli_error($con);
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
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

<?php include('footer.php'); ?>
