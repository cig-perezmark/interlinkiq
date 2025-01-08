<?php

include '../database.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    $current_userEmail = $rowUser['email'];
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

    // Return the email and employer ID
    return ['email' => $current_userEmail, 'employerID' => $current_userEmployerID];
    
}

// Get the email and employer ID
$userData = employerID($user_id);
$current_userEmail = $userData['email'];
$current_userEmployerID = $user_id;


$sql = <<<SQL
WITH RECURSIVE cte (
    s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, 
    s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, s_email
) AS (
    SELECT
        s1.ID AS s_ID,
        s1.name AS s_name,
        s1.reviewed_due AS s_reviewed_due,
        s1.status AS s_status,
        s1.material AS s_material,
        s1.service AS s_service,
        s1.address AS s_address,
        s1.category AS s_category,
        s1.contact AS s_contact,
        s1.document AS s_document,
        d1.ID AS d_ID,
        d1.type AS d_type,
        d1.name AS d_name,
        d1.file AS d_file,
        d1.file_due AS d_file_due,
        CASE 
            WHEN 
                LENGTH(d1.file) > 0 
                AND (STR_TO_DATE(d1.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d1.file_due) > CURDATE())
                AND d1.reviewed_by > 0
                AND d1.approved_by > 0
            THEN 1 
            ELSE 0 
        END AS d_status,
        CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count,
        s1.email AS s_email
    FROM tbl_supplier AS s1
    LEFT JOIN (
        SELECT * 
        FROM tbl_supplier_document 
        WHERE type = 0
        AND ID IN (
            SELECT MAX(ID)
            FROM tbl_supplier_document
            WHERE type = 0
            GROUP BY name, supplier_id
        )
    ) AS d1 ON s1.ID = d1.supplier_ID
    AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|', ',')  ) > 0
    WHERE s1.page = 2
    AND s1.is_deleted = 0 
    AND s1.facility_switch = $facility_switch_user_id2
    AND s1.email = '$current_userEmail'
    
    UNION ALL
    
    SELECT
        s2.ID AS s_ID,
        s2.name AS s_name,
        s2.reviewed_due AS s_reviewed_due,
        s2.status AS s_status,
        s2.material AS s_material,
        s2.service AS s_service,
        s2.address AS s_address,
        s2.category AS s_category,
        s2.contact AS s_contact,
        s2.document_other AS s_document,
        d2.ID AS d_ID,
        d2.type AS d_type,
        d2.name AS d_name,
        d2.file AS d_file,
        d2.file_due AS d_file_due,
        CASE 
            WHEN 
                LENGTH(d2.file) > 0 
                AND (STR_TO_DATE(d2.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d2.file_due) > CURDATE())
                AND d2.reviewed_by > 0
                AND d2.approved_by > 0
            THEN 1 
            ELSE 0 
        END AS d_status,
        CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count,
        s2.email AS s_email
    FROM tbl_supplier AS s2
    LEFT JOIN (
        SELECT * 
        FROM tbl_supplier_document 
        WHERE type = 1
        AND ID IN (
            SELECT MAX(ID)
            FROM tbl_supplier_document
            WHERE type = 1
            GROUP BY name, supplier_id
        )
    ) AS d2 ON s2.ID = d2.supplier_ID
    AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  ) > 0
    WHERE s2.page = 2
    AND s2.is_deleted = 0 
    AND s2.facility_switch = $facility_switch_user_id2
    AND s2.email = '$current_userEmail'
)
SELECT
    s_ID,
    s_name,
    s_reviewed_due,
    s_status,
    s_material,
    s_service, 
    s_address, 
    s_category,
    c_name,
    d_compliance,
    d_counting,
    (d_counting - d_compliance) AS d_non_compliance,
    ROUND((d_compliance / d_counting) * 100, 2) AS compliance_percentage,
    cn_name,
    cn_address,
    cn_email,
    cn_phone,
    cn_cell,
    cn_fax,
    COUNT(CASE WHEN s_status = 0 THEN 1 ELSE NULL END) AS pending_count,
    COUNT(CASE WHEN s_status = 1 THEN 1 ELSE NULL END) AS approved_count,
    COUNT(CASE WHEN s_status = 2 THEN 1 ELSE NULL END) AS non_approved_count,
    COUNT(CASE WHEN s_status = 3 THEN 1 ELSE NULL END) AS emergency_use_only_count,
    COUNT(CASE WHEN s_status = 4 THEN 1 ELSE NULL END) AS do_not_use_count,
    received_count
FROM (
    SELECT
        s_ID,
        s_name,
        s_reviewed_due,
        s_status,
        s_material,
        s_service, 
        s_address, 
        s_category,
        c_name,
        d_compliance,
        d_counting,
        cn.name AS cn_name,
        cn.address AS cn_address,
        cn.email AS cn_email,
        cn.phone AS cn_phone,
        cn.cell AS cn_cell,
        cn.fax AS cn_fax,
        s_email,
        COUNT(*) OVER (PARTITION BY s_email) AS received_count
    FROM (
        SELECT 
            s_ID, 
            s_name, 
            s_reviewed_due, 
            s_status, 
            s_material,
            s_service, 
            s_address, 
            s_contact,
            s_category,
            c.name AS c_name,
            SUM(d_status) AS d_compliance,
            SUM(d_count) AS d_counting,
            s_email
        FROM cte
        LEFT JOIN (
            SELECT *
            FROM tbl_supplier_category
            WHERE deleted = 0
        ) AS c ON s_category = c.ID
        GROUP BY s_ID
    ) AS r
    LEFT JOIN (
        SELECT *
        FROM tbl_supplier_contact
    ) AS cn ON FIND_IN_SET(cn.ID, REPLACE(s_contact, ' ', '')) > 0
    GROUP BY s_ID, s_email
    ORDER BY s_name
) AS r2
GROUP BY s_ID
ORDER BY s_name;
SQL;

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

// Encode the data to JSON and output it
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>

