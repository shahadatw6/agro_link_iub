<?php include('top.php');
if($_SESSION['ADMIN_ROLE'] == '0'){
    redirect('product');
}
$total_users = mysqli_num_rows(mysqli_query($con,"select * from users where email_verification='1'"));
$total_farmers = mysqli_num_rows(mysqli_query($con,"select * from admin where email_verification='1' and roll='0'"));
$total_delivery_boy = mysqli_num_rows(mysqli_query($con,"select * from delivery_boy where status='1'"));
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> <!-- Datalabels plugin -->

<div class="row">
    <!-- Chart 1 -->
    <div class="col-md-4">
        <canvas id="chartUsers"></canvas>
    </div>
</div>

<script>
    var totalUsers = <?php echo $total_users; ?>;
    var totalFarmers = <?php echo $total_farmers; ?>;
    var totalDeliveryBoy = <?php echo $total_delivery_boy; ?>;

    var ctx = document.getElementById('chartUsers').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Customers", "Farmers", "Delivery Men"],
            datasets: [{
                backgroundColor: ["#b91d47", "#00aba9", "#ff6347"],
                data: [totalUsers, totalFarmers, totalDeliveryBoy]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'User Distribution'
            },

        }
    });
</script>

<?php include('footer.php'); ?>
