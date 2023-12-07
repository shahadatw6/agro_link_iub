<?php 
include('top.php');

if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id'] >0){
	$id=get_safe_value($_GET['id']);
	$type=get_safe_value($_GET['type']);

    if($type=='active' || $type=='deactive'){
        $status = 1;
        if($type=='deactive'){
            $status = 0;
        }
        mysqli_query($con, "update order set status='$status' where order_ID='$id'");
        redirect('order_table');
    }	
    if($type == 'delete'){
        $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM order_table WHERE order_ID='$id'"));
        mysqli_query($con, "DELETE FROM order_table WHERE order_ID='$id'");
        
        redirect('orders');
    }

}


$sql="SELECT * FROM order_table order by order_ID desc";
$res=mysqli_query($con,$sql);

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
							<th width="15%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(mysqli_num_rows($res)>0){
						$i=1;
						while($row=mysqli_fetch_assoc($res)){

                            $user_id=$row['order_ID'];
                            $user = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM order_table WHERE order_ID = '$user_id'"));
                            
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
							<td>	<p><?php echo $user['shipping_Mode']?></p>
						</td>
								<td> <?php echo $user['consumer_ID']?> </td>
								<td> <?php echo $user['product_ID']?></td>
								<td><p><?php echo $user['order_Status']?></p></td>
								<td>
                                        <a href="manage_product?id=<?php echo $user['product_ID']?>"><label class="badge badge-success hand_cursor">Edit</label></a>&nbsp;
                                        <?php
                                        if($user['order_Status']==1){
                                        ?>
                                        <a href="?id=<?php echo $user['product_ID']?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>
                                        <?php
                                        }else{
                                        ?>
                                        <a href="?id=<?php echo $user['product_ID']?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
                                        <?php
                                        }
                                        ?>
                                        <a href="?id=<?php echo $user['product_ID']?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>
                                    </td>
							
                        </tr>
                        <?php 
						$i++;
						} } else { ?>
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