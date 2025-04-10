<?php
// Your database connection parameters
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

// URL of the NetIO JSON API
$netioApiUrl = "http://192.168.137.133/netio.json";

// Set the maximum execution time to 0 to prevent script timeouts
set_time_limit(0);

// Run the script indefinitely
while (true) {
    // Fetch data from the NetIO JSON API
    $jsonData = file_get_contents($netioApiUrl);
    $data = json_decode($jsonData, true);

    // Check if the "GlobalMeasure" key is defined
    if (isset($data['GlobalMeasure'])) {
        $globalMeasure = $data['GlobalMeasure'];

        // Access the required keys within "GlobalMeasure"
        $voltage = isset($globalMeasure['Voltage']) ? $globalMeasure['Voltage'] : null;
        $totalCurrent = isset($globalMeasure['TotalCurrent']) ? $globalMeasure['TotalCurrent'] : null;
        $totalEnergy = isset($globalMeasure['TotalEnergy']) ? $globalMeasure['TotalEnergy'] : null;
        $frequency = isset($globalMeasure['Frequency']) ? $globalMeasure['Frequency'] : null;
        $totalPhase = isset($globalMeasure['TotalPhase']) ? $globalMeasure['TotalPhase'] : null;

        // Insert new data into the database
        $insertSql = "INSERT INTO Energy (Voltage, TotalCurrent, TotalEnergy, Frequency, TotalPhase) VALUES ('$voltage', '$totalCurrent', '$totalEnergy', '$frequency', '$totalPhase')";

        try {
            if ($conn->query($insertSql) !== TRUE) {
                throw new Exception("Error: " . $conn->error);
            } else {
                echo "Data inserted successfully!\n";

                // Check the total number of records
                $countSql = "SELECT COUNT(*) as count FROM Energy";
                $result = $conn->query($countSql);
                $row = $result->fetch_assoc();
                $totalCount = $row['count'];

                // Delete older records if the total count exceeds 50
                if ($totalCount > 100) {
                    $deleteCount = $totalCount - 100;
                    $deleteSql = "DELETE FROM Energy ORDER BY Timestamp ASC LIMIT $deleteCount";
                    $conn->query($deleteSql);
                    echo "$deleteCount oldest records deleted.\n";
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "GlobalMeasure key is not defined in the JSON data.\n";
    }

    // Sleep for 1 seconds before fetching data again
    sleep(1);
}

// Note: The script will run indefinitely until manually stopped.
?>