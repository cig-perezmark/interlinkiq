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

$sql = "SELECT
    SUM(LENGTH(category) - LENGTH(REPLACE(category, ',', '')) + 1) AS total_requirements,
    SUM(CASE WHEN compliance = 1 THEN 1 ELSE 0 END) AS compliance_count,
    SUM(CASE WHEN compliance = 0 THEN 1 ELSE 0 END) AS non_compliance_count,
    SUM(LENGTH(material) - LENGTH(REPLACE(material, ',', '')) + 1) AS total_materials,
    (SELECT COUNT(*) FROM tbl_supplier_material WHERE user_id = $user_id AND active = 1) AS total_active_materials,
    (SELECT COUNT(*) FROM tbl_supplier_material WHERE user_id = $user_id AND active = 0) AS total_inactive_materials
FROM
    tbl_supplier
WHERE
    user_id = $user_id
    AND page = 1
    AND is_deleted = 0
    AND material IS NOT NULL
    AND material <> ''";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [
        "total_requirements" => 0,
        "compliance_count" => 0,
        "non_compliance_count" => 0,
        "total_materials" => 0,
        "total_active_materials" => 0,
        "total_inactive_materials" => 0
    ];
}

$conn->close();

echo json_encode($data);
?>

