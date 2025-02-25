<?php
header('Content-Type: application/json');

include '../database.php';

if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}

$facility_switch_user_id2 = 0;
if (isset($_COOKIE['facilityswitchAccount'])) {
    $facility_switch_user_id2 = $_COOKIE['facilityswitchAccount'];
}

function employerID($ID) {
    global $conn;

    $stmt = $conn->prepare("SELECT * from tbl_user WHERE ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowUser = $result->fetch_assoc();

    $current_userEmployeeID = $rowUser['employee_id'];
    $current_userEmployerID = $ID;

    if ($current_userEmployeeID > 0) {
        $stmt = $conn->prepare("SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID = ?");
        $stmt->bind_param("i", $current_userEmployeeID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rowEmployer = $result->fetch_assoc();
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// $sql = "SELECT
//     SUM(LENGTH(material) - LENGTH(REPLACE(material, ',', '')) + 1) AS total_materials,
//     (SELECT COUNT(*) FROM tbl_supplier_material WHERE user_id = $user_id AND active = 1) AS total_active_materials,
//     (SELECT COUNT(*) FROM tbl_supplier_material WHERE user_id = $user_id AND active = 0) AS total_inactive_materials
// FROM
//     tbl_supplier
// WHERE
//     user_id = $user_id
//     AND page = 1
//     AND is_deleted = 0
//     AND material IS NOT NULL
//     AND material <> ''";
    
    
$sql = "
    SELECT
    COUNT(m.ID) AS total_materials,
    SUM(CASE WHEN m.active = 0 THEN 1 ELSE 0 END) AS total_inactive_materials,
    SUM(CASE WHEN m.active = 1 THEN 1 ELSE 0 END) AS total_active_materials
    
    FROM tbl_supplier_material AS m
    
    INNER JOIN (
    	SELECT
        *
        FROM tbl_supplier
        WHERE page = 1 
    	AND is_deleted = 0
    	AND facility_switch = $facility_switch_user_id2
    ) AS s
    ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
    
    WHERE m.user_id = $user_id
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [
        "total_materials" => 0,
        "total_active_materials" => 0,
        "total_inactive_materials" => 0
    ];
}

$conn->close();

echo json_encode($data);
?>
