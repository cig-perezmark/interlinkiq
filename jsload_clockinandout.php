<?php
session_start();
include_once 'database.php';

// Query to select unique date from recorded_time and retrieve time-in and time-out for each date
$sql = "
    SELECT DATE(recorded_time) AS date,
           MIN(CASE WHEN action = 'IN' THEN recorded_time END) AS time_in,
           MAX(CASE WHEN action = 'OUT' THEN recorded_time END) AS time_out
    FROM tbl_timein
    GROUP BY DATE(recorded_time)
    LIMIT 31;
";

// Execute the query
$result = $conn->query($sql);

// Store the result in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Generate HTML table
echo "<table>";
// Output table headers
echo "<tr>";
echo "<th>Action</th>";
foreach ($data as $row) {
    echo "<th>{$row['date']}</th>";
}
echo "</tr>";

// Output table rows
$actions = ['IN', 'OUT'];
foreach ($actions as $action) {
    echo "<tr>";
    echo "<td>$action</td>";
    foreach ($data as $row) {
        echo "<td>{$row[$action]}</td>";
    }
    echo "</tr>";
}

echo "</table>";

// Close the MySQL connection
$conn->close();
?>
