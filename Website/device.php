<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ctrl 6 - Device Information</title>
    <link href="css/device.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="pictures/icon-website.png" type="image/x-icon">
    <script src="script.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
            <h2>Device Information</h2>
            <p>
                Timestamp:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="Timestamp"></span>
                <br>Name of the Device:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="DeviceName"></span>
               
                <br>Model:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="Model"></span>
               
                <br>MAC-Address:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="Mac"></span>
               
                <br>Serial Number:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="SerialNumber"></span>
               
                <br>Uptime:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="Uptime"></span>
                seconds
            </p>
        </div>
    </div>

    <h1>Welcome back</h1>

    <script>
        function refreshData() {
            var TimestampElement = document.getElementById('Timestamp');
            var DeviceNameElement = document.getElementById('DeviceName');
            var ModelElement = document.getElementById('Model');
            var MacElement = document.getElementById('Mac');
            var SerialNumberElement = document.getElementById('SerialNumber');
            var UptimeElement = document.getElementById('Uptime');

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    TimestampElement.innerHTML = data.Timestamp;
                    DeviceNameElement.innerHTML = data.DeviceName;
                    ModelElement.innerHTML = data.Model;
                    MacElement.innerHTML = data.Mac;
                    SerialNumberElement.innerHTML = data.SerialNumber;
                    UptimeElement.innerHTML = data.Uptime;
                }
            };
            xhr.open('GET', 'data_refresh_network.php', true);
            xhr.send();
        }

        // Refresh every second (1000 milliseconds)
        setInterval(refreshData, 1000);

        // Initial fetch on page load
        refreshData();
    </script>

</body>

</html>