<?php
function fetch_employee_data() {


    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    global $conn, $config;
    require '../database.php';
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Query to fetch employees and count of assigned forms
    $sql = "
        SELECT e.ID, e.first_name, e.last_name, 
                COUNT(FIND_IN_SET(e.ID, r.assigned_to_id)) AS count_assigned_forms
                FROM tbl_hr_employee AS e
                LEFT JOIN tbl_eforms AS r ON FIND_IN_SET(e.ID, r.assigned_to_id) > 0
                WHERE e.status = 1
                GROUP BY e.ID, e.first_name, e.last_name"; 


    $result = $conn->query($sql);

    // Initialize analytics variables
    $employeeData = [];

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["count_assigned_forms"] > 0) {
                // Update employee data for the chart
                $employeeData[] = [
                    "employee" => $row["first_name"] . ' ' . $row["last_name"],
                    "assigned_forms" => (int)$row["count_assigned_forms"]
                ];
            }
        }
    } else {
        echo "No results found";
    }

    // Close connection
    $conn->close();

    return $employeeData;
}
?>
