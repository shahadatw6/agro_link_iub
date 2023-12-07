<?php 
include('top.php');

$farmer_id = $_SESSION['FARMER_ID'];

$order_query = "SELECT OT.*, P.product_name, P.weight, P.unitprice
                FROM order_table OT
                INNER JOIN product P ON OT.product_ID = P.product_ID
                WHERE P.added_by = '$farmer_id'";

$order_result = mysqli_query($con, $order_query);
?>

<div class="card">
    <div class="card-body">
        <h1 class="grid_title">Order Master</h1>
        <div class="row grid_box">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>order_ID</th>                    
                                <th>order_Date</th>
                                <th>shipping_Mode</th>
                                <th>consumer_ID</th>
                                <th>product_ID</th>
                                <th>product_name </th>
                                <th>weight</th>
                                <th>unitprice</th>
                                <th>order_Status</th>
                                <!-- Add more columns if needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($order_result) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($order_result)) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="div_order_id">
                                            <a href="order_detailes?id=<?php echo $row['order_ID']?>"><?php echo $row['order_ID']?></a>
                                        </div>
                                    </td>
                                    <td><p><?php echo $row['order_Date']?></p></td>
                                    <td><p><?php echo $row['shipping_Mode']?></p></td>
                                    <td><?php echo $row['consumer_ID']?></td>
                                    <td><?php echo $row['product_ID']?></td>
                                    <td><?php echo $row['product_name']?></td>
									<td><?php echo $row['weight']?></td>
									<td><?php echo $row['unitprice']?>
                                    </td>
                                    <td><p><?php echo $row['order_Status']?></p></td>
                                    <!-- Add more columns if needed -->
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
