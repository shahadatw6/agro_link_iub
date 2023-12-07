<?php
include('top.php');
if ($_SESSION['ADMIN_ROLE'] == '0') {
	redirect('employee');
}
$msg = "";
$name = "";
$mobile = "";
$password = "";
$id = "";
$email = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = get_safe_value($_GET['id']);
	$row = mysqli_fetch_assoc(mysqli_query($con, "select * from employee where employee_ID='$id'"));
	$name = $row['emp_name'];
	$password = $row['password'];
	$mobile = $row['emp_contact'];
	$email = $row['email'];
}

if (isset($_POST['submit'])) {
	$name = get_safe_value($_POST['name']);
	$password = get_safe_value($_POST['password']);
	$mobile = get_safe_value($_POST['mobile']);
	$email = get_safe_value($_POST['email']);


	if ($id == '') {
		$sql = "select * from employee where emp_contact='$mobile'";
	} else {
		$sql = "select * from employee where emp_contact='$mobile' and employee_ID!='$id'";
	}
	if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
		$msg = "Delivery boy already added";
	} else {
		if ($id == '') {

			mysqli_query($con, "insert into employee(emp_name,emp_contact,department,usertype,email,username,password,status) values('$name','$mobile','delivery Boy',5,'$email','$name','$password',1)");
		} else {
			mysqli_query($con, "update employee set emp_name='$name', password='$password' , emp_contact='$mobile' where employee_ID='$id'");
		}

		redirect('employee');
	}
}
?>
<div class="row">
	<h1 class="grid_title ml10 ml15">Manage Delivery Boy</h1>
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<form class="forms-sample" method="post">
					<div class="form-group">
						<label for="exampleInputName1">Name</label>
						<input type="text" class="form-control" placeholder="name" name="name" required value="<?php echo $name ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputName1">Mobile</label>
						<input type="text" class="form-control" placeholder="mobile" name="mobile" required value="<?php echo $mobile ?>">
						<div class="error mt8"><?php echo $msg ?></div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail3" required>Password</label>
						<input type="textbox" class="form-control" placeholder="Password" name="password" value="<?php echo $password ?>">
					</div>
					<div class="form-group">
						<label for="exampleInputName1">Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email" required value="<?php echo $email ?>">
						<div class="error mt8"><?php echo $msg ?></div>

						<button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>

</div>

<?php include('footer.php'); ?>