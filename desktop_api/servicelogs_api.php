<?php
header('Content-Type: application/json');

// Include your database connection
include "../database_iiq.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the default timezone to Manila
date_default_timezone_set('Asia/Manila');

// Get the current date in "YYYY-MM-DD" format
$currentDate = date('Y-m-d'); // Use date() function to get current date

// Fetch data from tbl_service_logs based on the current date
$sql = "SELECT * FROM tbl_service_logs WHERE user_id = 108 AND task_date = '$currentDate'"; // Use the current date in the query
$result = $conn->query($sql);

$serviceLogs = [];

// Check if we have records
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $serviceLogs[] = $row; // Add each record to the serviceLogs array
    }
}

// Return the result as JSON
echo json_encode($serviceLogs);

// Close the database connection
$conn->close();
?>
