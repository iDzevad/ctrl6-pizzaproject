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

    // Check if the "Agent" key is defined
    if (isset($data['Agent'])) {
        $agentData = $data['Agent'];

        // Access the required keys within "Agent"
	$uptime = isset($agentData['Uptime']) ? $agentData['Uptime'] : null;
        $deviceName = isset($agentData['DeviceName']) ? $agentData['DeviceName'] : null;
        $model = isset($agentData['Model']) ? $agentData['Model'] : null;
        $mac = isset($agentData['MAC']) ? $agentData['MAC'] : null;
        $serialNumber = isset($agentData['SerialNumber']) ? $agentData['SerialNumber'] : null;

        // Insert new data into the database only if DeviceName doesn't already exist
        $checkExistingSql = "SELECT COUNT(*) as count FROM Network WHERE DeviceName = '$uptime'";
        $result = $conn->query($checkExistingSql);
        $row = $result->fetch_assoc();
        $existingCount = $row['count'];

        if ($existingCount == 0) {
            $insertSql = "INSERT INTO Network (Uptime, DeviceName, Model, Mac, SerialNumber) VALUES ('$uptime', '$deviceName', '$model', '$mac', '$serialNumber')";
           
            try {
                if ($conn->query($insertSql) !== TRUE) {
                    throw new Exception("Error: " . $conn->error);
                } else {
                    echo "Data inserted successfully!\n";

                    // Check the total number of records
                    $countSql = "SELECT COUNT(*) as count FROM Network";
                    $result = $conn->query($countSql);
                    $row = $result->fetch_assoc();
                    $totalCount = $row['count'];

                    // Delete older records if the total count exceeds 100
                    if ($totalCount > 100) {
                        $deleteCount = $totalCount - 100;
                        $deleteSql = "DELETE FROM Network ORDER BY Timestamp ASC LIMIT $deleteCount";
                        $conn->query($deleteSql);
                        echo "$deleteCount oldest records deleted.\n";
                    }
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        } else {
            echo "Device with the name '$deviceName' already exists. Skipping insertion.\n";
        }
    } else {
        echo "Agent key is not defined in the JSON data.\n";
    }

    // Sleep for 1 second before fetching data again
    sleep(1);
}

// Note: The script will run indefinitely until manually stopped.
?>