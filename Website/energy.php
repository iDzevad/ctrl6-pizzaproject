<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ctrl 6 - Energy Consumption</title>
    <link href="css/energy.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="pictures/icon-website.png" type="image/x-icon">
    <script src="script2.js"></script>
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
            <h2> Energy Consumption</h2>
            <p>
                Timestamp:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="timestamp"></span>
                <br>Current Voltage:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="voltage"></span>
                V
                <br>Total Current:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="totalCurrent"></span>
                mA
                <br>Total Energy:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="totalEnergy"></span>
                Wh
                <br>Frequency:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="frequency"></span>
                Hz
                <br>Phase:
                <span style="color: rgb(1, 150, 170); font-weight: bold;" id="totalPhase"></span>
                °
            </p>
        </div>
    </div>

    <h1>Welcome back</h1>

    <script>
        function refreshData() {
            var timestampElement = document.getElementById('timestamp');
            var voltageElement = document.getElementById('voltage');
            var totalCurrentElement = document.getElementById('totalCurrent');
            var totalEnergyElement = document.getElementById('totalEnergy');
            var frequencyElement = document.getElementById('frequency');
            var totalPhaseElement = document.getElementById('totalPhase');

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    timestampElement.innerHTML = data.Timestamp;
                    voltageElement.innerHTML = data.Voltage;
                    totalCurrentElement.innerHTML = data.TotalCurrent;
                    totalEnergyElement.innerHTML = data.TotalEnergy;
                    frequencyElement.innerHTML = data.Frequency;
                    totalPhaseElement.innerHTML = data.TotalPhase;
                }
            };
            xhr.open('GET', 'data_refresh.php', true);
            xhr.send();
        }

        // Refresh every second (1000 milliseconds)
        setInterval(refreshData, 1000);

        // Initial fetch on page load
        refreshData();
    </script>

</body>

</html>