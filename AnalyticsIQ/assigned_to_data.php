<?php

require '../database.php';


$portal_user = !empty($_COOKIE['ID']) ? $_COOKIE['ID'] : null;
$user_id = !empty($_COOKIE['switchAccount']) ? $_COOKIE['switchAccount'] : employerID($portal_user);

function employerID($ID) {
    global $conn;

    $selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $ID");
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query($conn, "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID");
        if (mysqli_num_rows($selectEmployer) > 0) {
            $rowEmployer = mysqli_fetch_array($selectEmployer);
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("

    SELECT e.ID, e.first_name, e.last_name, 
           COUNT(FIND_IN_SET(e.ID, r.assigned_to_id)) AS count_assigned_forms
    FROM tbl_hr_employee AS e
    LEFT JOIN tbl_eforms AS r ON FIND_IN_SET(e.ID, r.assigned_to_id) > 0
    WHERE e.status = 1 
    AND e.user_id = ?
    GROUP BY e.ID, e.first_name, e.last_name");

    // 

// Uncomment this to filter user
$stmt->bind_param("i", $user_id); 

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

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
    echo json_encode(["error" => "No results found"]);
    $stmt->close();
    $conn->close();
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();

// Encode data to JSON
echo json_encode($employeeData);
?>
