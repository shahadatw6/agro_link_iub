<?php
include('top.php');

$condition = '';

if (isset($_GET['type']) && $_GET['type'] !== '' && isset($_GET['id']) && $_GET['id'] > 0) {
	$type = get_safe_value($_GET['type']);
	$id = get_safe_value($_GET['id']);

	// Delete block should be outside the active/deactive block
	if ($type == 'delete') {
		$res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM employee WHERE employee_ID='$id'"));
		mysqli_query($con, "DELETE FROM employee WHERE employee_ID='$id'");
		redirect('employee');
	} else {
		// Active/Deactive block
		$status = 1;
		if ($type == 'deactive') {
			$status = 0;
		}
		mysqli_query($con, "update employee set status='$status' where employee_id='$id'");
		redirect('employee');
	}
}


$sql = "select * from employee WHERE usertype=5 Order by employee_ID desc";
$res = mysqli_query($con, $sql);

?>
<div class="card">
	<div class="card-body">
		<h1 class="grid_title">Delivery Boy Master</h1>
		<a href="manage_delivery_boy" class="add_link">Add Delivery</a>
		<div class="row grid_box">

			<div class="col-12">
				<div class="table-responsive">
					<table id="order-listing" class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>employee ID</th>
								<th>Name</th>
								<th>Contact</th>
								<th>Email</th>
								<th>Actions</th>

							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($res) > 0) {
								$i = 1;
								while ($row = mysqli_fetch_assoc($res)) {
							?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo $row['employee_ID'] ?></td>
										<td><?php echo $row['emp_name'] ?></td>
										<td><?php echo $row['emp_contact'] ?></td>
										<td><?php echo $row['email'] ?></td>


										<td>
											<a href="manage_delivery_boy?id=<?php echo $row['employee_ID'] ?>"><label class="badge badge-success hand_cursor">Edit</label></a>&nbsp;
											<?php
											if ($row['status'] == 1) {
											?>
												<a href="?id=<?php echo $row['employee_ID'] ?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>
											<?php
											} else {
											?>
												<a href="?id=<?php echo $row['employee_ID'] ?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
											<?php
											}

											?>
											<a href="?id=<?php echo $row['employee_ID'] ?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>

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

<?php include('footer.php'); ?>