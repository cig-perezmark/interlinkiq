<?php
include '../database.php';

if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}

function employerID($ID) {
    global $conn;

    $selectUser = mysqli_query($conn, "SELECT * from tbl_user WHERE ID = $ID");
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

// Connect to the database
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// COUNT(user_id) AS total_send,
// Query for donut chart
$donutQuery = "
    SELECT 
        SUM(LENGTH(material) - LENGTH(REPLACE(material, ',', '')) + 1) AS total_send,
        SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS pending,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS approved,
        SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS non_approved,
        SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) AS emergency_use_only,
        SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) AS do_not_use
    FROM tbl_supplier
    WHERE is_deleted = 0 AND user_id = $user_id AND page = 2
";

$donutResult = $mysqli->query($donutQuery);
$donutData = $donutResult->fetch_assoc();

// Query for line chart
$lineQuery = "
    SELECT 
        SUM(CASE WHEN frequency = 1 THEN 1 ELSE 0 END) AS once_per_day,
        SUM(CASE WHEN frequency = 2 THEN 1 ELSE 0 END) AS once_per_week,
        SUM(CASE WHEN frequency = 3 THEN 1 ELSE 0 END) AS first_and_fifteenth,
        SUM(CASE WHEN frequency = 4 THEN 1 ELSE 0 END) AS once_per_month,
        SUM(CASE WHEN frequency = 5 THEN 1 ELSE 0 END) AS once_per_year
    FROM tbl_supplier
    WHERE is_deleted = 0 AND user_id = $user_id AND page = 2
";

$lineResult = $mysqli->query($lineQuery);
$lineData = $lineResult->fetch_assoc();

// Close the connection
$mysqli->close();

// Encode the data to JSON format
header('Content-Type: application/json');
echo json_encode(['donutData' => $donutData, 'lineData' => $lineData]);
?>
