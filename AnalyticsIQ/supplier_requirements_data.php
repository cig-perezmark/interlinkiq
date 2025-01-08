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
//     SUM(LENGTH(category) - LENGTH(REPLACE(category, ',', '')) + 1) AS total_requirements,
//     SUM(CASE WHEN compliance = 1 THEN 1 ELSE 0 END) AS compliance_count,
//     SUM(CASE WHEN compliance = 0 THEN 1 ELSE 0 END) AS non_compliance_count,
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
	WITH RECURSIVE cte (s_ID, s_name, s_category, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count) AS
    (
        SELECT
        s1.ID AS s_ID,
        s1.name AS s_name,
        s1.category AS s_category,
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
        CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count
    
        FROM tbl_supplier AS s1
    
        LEFT JOIN (
            SELECT
            * 
            FROM tbl_supplier_document 
            WHERE type = 0
            AND ID IN (
                SELECT
                MAX(ID)
                FROM tbl_supplier_document
                WHERE type = 0
                GROUP BY name, supplier_id
            )
        ) AS d1
        ON s1.ID = d1.supplier_ID
        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
        WHERE s1.page = 1 
        AND s1.is_deleted = 0 
        AND s1.facility_switch = $facility_switch_user_id2
        AND s1.user_id = $user_id
        
        UNION ALL
        
        SELECT
        s2.ID AS s_ID,
        s2.name AS s_name,
        s2.category AS s_category,
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
        CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count
    
        FROM tbl_supplier AS s2
    
        LEFT JOIN (
            SELECT
            * 
            FROM tbl_supplier_document 
            WHERE type = 1
            AND ID IN (
                SELECT
                MAX(ID)
                FROM tbl_supplier_document
                WHERE type = 1
                GROUP BY name, supplier_id
            )
        ) AS d2
        ON s2.ID = d2.supplier_ID
        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0
        WHERE s2.page = 1 
        AND s2.is_deleted = 0 
        AND s2.facility_switch = $facility_switch_user_id2
        AND s2.user_id = $user_id
    )
    SELECT
    COUNT(s_ID) AS total_requirements,
    SUM(CASE WHEN d_counting > 0 AND d_compliance = d_counting THEN 1 ELSE 0 END) AS compliance_count,
    SUM(CASE WHEN d_counting > 0 AND d_compliance = d_counting THEN 0 ELSE 1 END) AS non_compliance_count
    FROM (
    	SELECT
    	s_ID,
    	s_name,
    	c_name,
    	d_compliance,
    	d_counting
    	FROM (
    	    SELECT 
    	    s_ID, 
    	    s_name,
    	    c.name AS c_name,
    	    SUM(d_status) AS d_compliance,
    	    SUM(d_count) AS d_counting
    	    FROM cte
    
    	    LEFT JOIN (
    	        SELECT
    	        *
    	        FROM tbl_supplier_category
    	        WHERE deleted = 0
    	    ) AS c
    	    ON s_category = c.ID
    
    	    GROUP BY s_ID
    	) AS r
    
    	GROUP BY s_ID
    
    	ORDER BY s_name
    ) r2
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [
        "total_requirements" => 0,
        "compliance_count" => 0,
        "non_compliance_count" => 0
    ];
}

$conn->close();

echo json_encode($data);
?>