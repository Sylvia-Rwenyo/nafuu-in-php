<?php
$current_user_email = $_SESSION['email'];
$current_user_category = $_SESSION['category'];
$fname_chatting_with = 0;

if (isset($_GET['p_id'])) {
    $requested_patient = $_GET['p_id'];
}else{
    $requested_patient = $_SESSION['id'];
}
$data_points_sleep = array();
$sql = "SELECT recordDate, sleepTime FROM patientsleeplog WHERE userID = '$requested_patient'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
while ($rows = mysqli_fetch_array($result)) {
    $point = array("label" => $rows['recordDate'], "y" => $rows["sleepTime"]);
    array_push($data_points_sleep, $point);
}

$sql2 = "SELECT firstName, lastName FROM regpatients WHERE id = '$requested_patient'";
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
while ($row = mysqli_fetch_array($result2)) {
    $patient_sleep_chart_title = $row['firstName'] . ' ' . $row['lastName'] . '\'s Sleep Progress';
}
?>

<canvas id="sleepChart"  class="canvas-chart"></canvas>
<!-- <script src="../js/cdnjs.cloudflare.com_ajax_libs_Chart.js_2.9.4_Chart.js"></script> -->
<script type="text/JavaScript">
    var data_points_sleep = <?php echo json_encode($data_points_sleep); ?>;

    var sleepChart = new Chart("sleepChart", {
        type: "bar",
        data: {
            labels: data_points_sleep.map(point => point.label),
            datasets: [{
                label: "Sleep Time",
                data: data_points_sleep.map(point => point.y),
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Customize the chart color
                borderColor: 'rgba(75, 192, 192, 1)', // Customize the border color
                borderWidth: 1 // Customize the border width
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true, // Start the scale from zero
                    min: 0,           // Minimum value on the y-axis
                    max: 24,         // Maximum value on the y-axis
                    stepSize: 1,
                    title: {
                        display: true,
                        text: 'Sleep Time'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Record Date'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: "<?php echo $patient_sleep_chart_title; ?>",
                    fontSize: 16
                }
            }
        }
    });
</script>
