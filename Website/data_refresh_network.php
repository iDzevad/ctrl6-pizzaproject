<?php
$servername = "localhost";
$username = "ctrl6";
$password = "fontys123";
$database = "ctrl6";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Network ORDER BY Timestamp DESC LIMIT 1";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['Timestamp'] = $row['Timestamp'];
    $response['DeviceName'] = $row['DeviceName'];
    $response['Model'] = $row['Model'];
    $response['Mac'] = $row['Mac'];
    $response['Uptime'] = $row['Uptime'];
    $response['SerialNumber'] = $row['SerialNumber'];
} else {
    $response['error'] = "No data found in the database";
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>