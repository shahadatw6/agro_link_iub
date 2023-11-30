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
    <!-- Pie Chart -->
    <div class="col-md-6">
        <canvas id="chartUsers"></canvas>
    </div>

    <!-- Bar Chart -->
    <div class="col-md-6">
        <canvas id="barChart"></canvas>
    </div>
</div>

<script>
    // Existing script for pie chart
    var totalUsers = <?php echo $total_users; ?>;
    var totalFarmers = <?php echo $total_farmers; ?>;
    var totalDeliveryBoy = <?php echo $total_delivery_boy; ?>;

    var ctxPie = document.getElementById('chartUsers').getContext('2d');
    new Chart(ctxPie, {
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

    // Data for bar chart
    // Replace with your actual data
    var barChartData = {
        labels: ['Oct', 'Nov', 'Dec'], // Replace with your labels
        datasets: [{
            label: 'Order Chart',
            backgroundColor: '#3498db',
            borderColor: '#2980b9',
            data: [20, 30, 40] // Replace with your data
        }]
    };

    var ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: barChartData,
        options: {
            title: {
                display: true,
                text: 'Order Chart'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<?php include('footer.php'); ?>
