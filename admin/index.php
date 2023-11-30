<?php include('top.php');
if($_SESSION['ADMIN_ROLE'] == '0'){
    redirect('product');
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="row">
    <?php 
        $total_users = mysqli_num_rows(mysqli_query($con,"select * from users where email_verification='1'"));
        $total_farmers = mysqli_num_rows(mysqli_query($con,"select * from admin where email_verification='1' and roll='0'"));
        $total_delivery_boy = mysqli_num_rows(mysqli_query($con,"select * from delivery_boy where status='1'"));
    ?>

    <!-- Chart 1 -->
    <div class="col-md-4">
        <canvas id="chartUsers"></canvas>
    </div>

    <!-- Chart 2 -->
    <div class="col-md-4">
        <canvas id="chartFarmers"></canvas>
    </div>

    <!-- Chart 3 -->
    <div class="col-md-4">
        <canvas id="chartDeliveryBoy"></canvas>
    </div>

    <script>
        var totalUsers = <?php echo $total_users; ?>;
        var totalFarmers = <?php echo $total_farmers; ?>;
        var totalDeliveryBoy = <?php echo $total_delivery_boy; ?>;

        // Chart for Users
        new Chart("chartUsers", {
            type: "pie",
            data: {
                labels: ["Customers"],
                datasets: [{
                    backgroundColor: ["#b91d47"],
                    data: [totalUsers]
                }]
            },
            options: { title: { display: true, text: "Customers" }}
        });

        // Chart for Farmers
        new Chart("chartFarmers", {
            type: "pie",
            data: {
                labels: ["Farmers"],
                datasets: [{
                    backgroundColor: ["#00aba9"],
                    data: [totalFarmers]
                }]
            },
            options: { title: { display: true, text: "Farmers" }}
        });

        // Chart for Delivery Boys
        new Chart("chartDeliveryBoy", {
            type: "pie",
            data: {
                labels: ["Delivery Boys"],
                datasets: [{
                    backgroundColor: ["#ff6347"],
                    data: [totalDeliveryBoy]
                }]
            },
            options: { title: { display: true, text: "Delivery Boys" }}
        });
    </script>
</div>

<?php include('footer.php'); ?>
