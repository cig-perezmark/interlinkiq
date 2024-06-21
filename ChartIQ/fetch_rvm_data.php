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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute query and fetch the count
function get_count($conn, $query, $alias) {
    $result = $conn->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        return $row[$alias] ?? 0;
    }
    return 0;
}

// Queries for counts
$data = [
    'filled_out' => [
        'filled_out_1' => get_count($conn, "SELECT COUNT(*) AS count_1 FROM tbl_eforms WHERE filled_out = 1 AND user_id = $user_id", 'count_1'),
        'filled_out_0' => get_count($conn, "SELECT COUNT(*) AS count_0 FROM tbl_eforms WHERE filled_out = 0 AND user_id = $user_id", 'count_0'),
    ],
    'signed' => [
        'signed_1' => get_count($conn, "SELECT COUNT(*) AS count_1 FROM tbl_eforms WHERE signed = 1 AND user_id = $user_id", 'count_1'),
        'signed_0' => get_count($conn, "SELECT COUNT(*) AS count_0 FROM tbl_eforms WHERE signed = 0 AND user_id = $user_id", 'count_0'),
    ],
    'compliance' => [
        'compliance_1' => get_count($conn, "SELECT COUNT(*) AS count_1 FROM tbl_eforms WHERE compliance = 1 AND user_id = $user_id", 'count_1'),
        'compliance_0' => get_count($conn, "SELECT COUNT(*) AS count_0 FROM tbl_eforms WHERE compliance = 0 AND user_id = $user_id", 'count_0'),
    ],
    'frequency' => [
        'frequency_0' => get_count($conn, "SELECT COUNT(*) AS count_0 FROM tbl_eforms WHERE frequency = 0 AND user_id = $user_id", 'count_0'),
        'frequency_1' => get_count($conn, "SELECT COUNT(*) AS count_1 FROM tbl_eforms WHERE frequency = 1 AND user_id = $user_id", 'count_1'),
        'frequency_2' => get_count($conn, "SELECT COUNT(*) AS count_2 FROM tbl_eforms WHERE frequency = 2 AND user_id = $user_id", 'count_2'),
        'frequency_3' => get_count($conn, "SELECT COUNT(*) AS count_3 FROM tbl_eforms WHERE frequency = 3 AND user_id = $user_id", 'count_3'),
        'frequency_4' => get_count($conn, "SELECT COUNT(*) AS count_4 FROM tbl_eforms WHERE frequency = 4 AND user_id = $user_id", 'count_4'),
        'frequency_5' => get_count($conn, "SELECT COUNT(*) AS count_5 FROM tbl_eforms WHERE frequency = 5 AND user_id = $user_id", 'count_5'),
    ]
];

// Calculate totals
$data['totals'] = [
    'filled_out_1_total' => $data['filled_out']['filled_out_1'],
    'filled_out_0_total' => $data['filled_out']['filled_out_0'],
    'signed_1_total' => $data['signed']['signed_1'],
    'signed_0_total' => $data['signed']['signed_0'],
    'compliance_1_total' => $data['compliance']['compliance_1'],
    'compliance_0_total' => $data['compliance']['compliance_0'],
    'frequency_0_total' => $data['frequency']['frequency_0'],
    'frequency_1_total' => $data['frequency']['frequency_1'],
    'frequency_2_total' => $data['frequency']['frequency_2'],
    'frequency_3_total' => $data['frequency']['frequency_3'],
    'frequency_4_total' => $data['frequency']['frequency_4'],
    'frequency_5_total' => $data['frequency']['frequency_5'],
];

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

?>
