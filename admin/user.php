<?php 
include('top.php');

$condition = '';

if ($_SESSION['ADMIN_ROLE'] == '0') {
    redirect('product');
}

if (isset($_GET['type']) && $_GET['type'] !== '' && isset($_GET['consumer_ID']) && $_GET['consumer_ID'] > 0) {
    $type = get_safe_value($_GET['type']);
    $id = get_safe_value($_GET['consumer_ID']);
    
    if ($type == 'active' || $type == 'deactive') {
        $status = ($type == 'deactive') ? 0 : 1;
        mysqli_query($con, "UPDATE consumer SET status='$status' WHERE consumer_ID='$id'");
        redirect('user');
    }
}

$sql = "SELECT * FROM consumer";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h1 class="grid_title">Consumer</h1>
        <div class="row grid_box">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>consumer_ID</th>
                                <th>consumer_name</th>
                                <th>road</th>
                                <th>district</th>
                                <th>house_no</th>
                                <th>username</th>
                                <th>password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($res) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $i?></td>
                                        <td><?php echo $row['consumer_ID']?></td>
                                        <td><?php echo $row['consumer_name']?></td>
                                        <td><?php echo $row['road']?></td>
                                        <td><?php echo $row['district']?></td>
                                        <td><?php echo $row['house_no']?></td>
                                        <td><?php echo $row['username']?></td>
                                        <td><?php echo $row['password']?></td>
                                        <td>
                                        <a href="manage_product?id=<?php echo $user['consumer_ID']?>"><label class="badge badge-success hand_cursor">Edit</label></a>&nbsp;
                                            <?php if ($row['status'] == 1): ?>
                                                <a href="?consumer_ID=<?php echo $row['consumer_ID']?>&type=deactive">
                                                    <label class="badge badge-danger hand_cursor">Active</label>
                                                </a>
                                            <?php elseif ($row['status'] == 0): ?>
                                                <a href="?consumer_ID=<?php echo $row['consumer_ID']?>&type=active">
                                                    <label class="badge badge-info hand_cursor">Deactive</label>
                                                </a>
                                                
                                            <?php endif; ?>
                                            <a href="?id=<?php echo $user['consumer_ID']?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>
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
