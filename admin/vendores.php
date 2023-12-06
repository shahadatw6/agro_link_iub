<?php 
include('top.php');


if($_SESSION['ADMIN_ROLE']=='0'){
	redirect('product');
}

if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['farmer_ID']) && $_GET['farmer_ID']>0){
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['farmer_ID']);
	if($type=='active' || $type=='deactive'){
		$status=1;
		if($type=='deactive'){
			$status=0;
		}
		mysqli_query($con,"update farmer set status='$status' where id='$id'");
		redirect('vendores');
	}

}








$sql=mysqli_query($con,"select * from farmer");



?>
  <div class="card">
            <div class="card-body">
              <h1 class="grid_title">Vendor Master</h1>
			  <div class="row grid_box">
				
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
							<th>Username</th>
                            <th>Location</th>
							<th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(mysqli_num_rows($sql)>0){
						$i=1;
						while($row=mysqli_fetch_assoc($sql)){
						?>
						<tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $row['farmer_Name']?></td>
							<td><?php echo $row['farmer_contact']?></td>
							<td><?php echo $row['username']?></td>
							<td><?php echo $row['farmer_location']?></td>
							<td>
								<?php
								if($row['status']==1){
								?>
								<a href="?id=<?php echo $row['farmer_ID']?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>
								<?php
								}else{
								?>
								<a href="?id=<?php echo $row['farmer_ID']?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
								<?php
								}
								
								?>
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
