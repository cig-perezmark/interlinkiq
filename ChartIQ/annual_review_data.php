<?php
header('Content-Type: application/json');

// Include database connection setup
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

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Execute the SQL query
$sql = "
    SELECT
        COALESCE(SUM(r.compliant) * 100.0 / NULLIF(COUNT(r.ID), 0), 0) AS review_percentage
    FROM tbl_library AS l
    LEFT JOIN tbl_library_review AS r ON l.ID = r.library_id
        AND r.parent_id = 0
        AND r.is_deleted = 0
        AND YEAR(r.last_modified) = YEAR(CURDATE())
    WHERE l.deleted = 0
        AND l.parent_id = 0
        AND l.user_id = $user_id;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();
    echo json_encode(["review_percentage" => $row['review_percentage']]);
} else {
    echo json_encode(["review_percentage" => 0]);
}

$conn->close();
?>
