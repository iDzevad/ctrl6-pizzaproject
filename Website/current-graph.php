<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ctrl 6 - Current Graph</title>
    <link href="css/styles-graph.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="pictures/icon-website.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <div class="box">
            <img class="logo" src="pictures/logo.png">
            <ul>
                <li>
                    <img class="network" src="pictures/icon-myinfo.png">
                    <a href="index.html" class="haa">My Information</a>
                </li>
                <li>
                    <img class="network" src="pictures/icon-device.png">
                    <a href="device.php" class="haa">Device Information</a>
                </li>
                <li>
                    <img class="energyconsumption" src="pictures/icon-energy.png">
                    <a href="energy.php" class="haa">Energy Consumption</a>
                </li>
                <li>
                    <img class="energyconsumption" src="pictures/icon-current.png">
                    <a href="current-graph.php" class="haa">Current Graph</a>
                </li>
            </ul>
        </div>
        <div class="box2">
            <h2> Total Current Graph</h2>

<canvas id="myChart" width="850px" height="320px"></canvas>


<?php
// Database connection parameters
$servername = "localhost";
$username = "ctrl6";
$password = "fontys123";
$database = "ctrl6";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {    
	die("Connection failed: " . $conn->connect_error);
}

// Sample SQL query - replace this with your own query
$sql = "SELECT Timestamp, TotalCurrent FROM Energy LIMIT 20";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>

<script>
// Use the fetched data to create a chart
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($data, 'Timestamp')); ?>,
        datasets: [{
            label: 'Values',
            data: <?php echo json_encode(array_column($data, 'TotalCurrent')); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
		title: {
			display: true,
			text: '°'
		}
            }
        }
    }
});
</script>
        </div>
    </div>

    <h1>Welcome back</h1>

</body>

</html>