<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../database.php';

if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}
function employerID($ID) {
    global $conn;

    $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
        if ( mysqli_num_rows($selectEmployer) > 0 ) {
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

$field = $_GET['field'] ?? '';

if ($field) {
    $query = "";
    switch ($field) {
        case 'filled_out':
            $query = "SELECT 
                        SUM(filled_out = 1) AS count_1,
                        SUM(filled_out = 0) AS count_0
                      FROM tbl_eforms WHERE user_id = $user_id";
            break;
        case 'signed':
            $query = "SELECT 
                        SUM(signed = 1) AS count_1,
                        SUM(signed = 0) AS count_0
                      FROM tbl_eforms WHERE user_id = $user_id";
            break;
        case 'compliance':
            $query = "SELECT 
                        SUM(compliance = 1) AS count_1,
                        SUM(compliance = 0) AS count_0
                      FROM tbl_eforms WHERE user_id = $user_id";
            break;
        case 'frequency':
            $query = "SELECT 
                        SUM(frequency = 0) AS daily,
                        SUM(frequency = 1) AS weekly,
                        SUM(frequency = 2) AS monthly,
                        SUM(frequency = 3) AS quarterly,
                        SUM(frequency = 4) AS biannual,
                        SUM(frequency = 5) AS annually
                      FROM tbl_eforms WHERE user_id = $user_id";
            break;
        case 'assigned_count':
            $query = "SELECT 
                        e.name, 
                        COUNT(f.id) AS assigned_count
                        FROM tbl_eforms f
                        JOIN tbl_hr_employee e ON f.assigned_to_id = e.user_id
                        WHERE e.status = 1 
                        GROUP BY e.name";
            break;
        default:
            break;
    }

    if ($query) {
        $result = $conn->query($query);
        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
    }
}

$conn->close();
?>
