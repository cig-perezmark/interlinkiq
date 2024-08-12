<?php
// Database connection
require '../database.php';

// Function to get employer ID
function employerID($ID) {
    global $conn;

    $stmt = $conn->prepare("SELECT employee_id FROM tbl_user WHERE ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowUser = $result->fetch_assoc();

    $current_userEmployeeID = $rowUser['employee_id'];
    $current_userEmployerID = $ID;

    if ($current_userEmployeeID > 0) {
        $stmt = $conn->prepare("SELECT user_id FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID = ?");
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

// Check and get user IDs from cookies
if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the id from the POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Log the id and user_id
error_log("id: " . $id);
error_log("user_id: " . $user_id);

// Combined SQL Query
$sql = "
WITH MaterialSplit AS (
    SELECT
        tbl_supplier.id AS supplier_id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_supplier.material, ',', numbers.n), ',', -1) AS material_id
    FROM
        tbl_supplier
    INNER JOIN (
        SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
        SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL
        SELECT 9 UNION ALL SELECT 10
    ) numbers ON CHAR_LENGTH(tbl_supplier.material)
        -CHAR_LENGTH(REPLACE(tbl_supplier.material, ',', '')) >= numbers.n - 1
    WHERE
        tbl_supplier.page = 1
        AND tbl_supplier.is_deleted = 0
        AND tbl_supplier.user_id = ?
        AND tbl_supplier.id = ?
),
ParsedData AS (
    SELECT
        ID,
        user_id,
        audit,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_report, '|', 2), '|', -1) AS audit_report_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_report, '|', 3), '|', -1) AS audit_report_end_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_certificate, '|', 2), '|', -1) AS audit_certificate_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_certificate, '|', 3), '|', -1) AS audit_certificate_end_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_action, '|', 2), '|', -1) AS audit_action_date,
        SUBSTRING_INDEX(SUBSTRING_INDEX(audit_action, '|', 3), '|', -1) AS audit_action_end_date,
        reviewed_by,
        reviewed_date,
        reviewed_due,
        is_deleted
    FROM
        tbl_supplier
    WHERE
        is_deleted = 0
        AND user_id = ?
        AND page = 1
        AND ID = ?
),
AuditCounts AS (
    SELECT
        reviewed_by,
        COUNT(DISTINCT audit_report_date) AS audit_report_count,
        COUNT(DISTINCT audit_certificate_date) AS audit_certificate_count,
        COUNT(DISTINCT audit_action_date) AS audit_action_count,
        COUNT(DISTINCT reviewed_date) AS annual_review_count
    FROM
        ParsedData
    GROUP BY
        reviewed_by
)
SELECT
    main.name,
    main.document_count,
    main.document_other_count,
    main.material_count,
    IFNULL(material_counts.active_material_count, 0) AS active_material_count,
    IFNULL(material_counts.inactive_material_count, 0) AS inactive_material_count,
    SUM(CASE 
            WHEN DATEDIFF(STR_TO_DATE(main.file_due, '%m/%d/%Y'), NOW()) < 0 THEN 1
            ELSE 0
        END) AS expired,
    SUM(CASE 
            WHEN DATEDIFF(STR_TO_DATE(main.file_due, '%m/%d/%Y'), NOW()) BETWEEN 0 AND 30 THEN 1
            ELSE 0
        END) AS nearly_expired_30,
    SUM(CASE 
            WHEN DATEDIFF(STR_TO_DATE(main.file_due, '%m/%d/%Y'), NOW()) BETWEEN 31 AND 60 THEN 1
            ELSE 0
        END) AS nearly_expired_60,
    SUM(CASE 
            WHEN DATEDIFF(STR_TO_DATE(main.file_due, '%m/%d/%Y'), NOW()) BETWEEN 61 AND 90 THEN 1
            ELSE 0
        END) AS nearly_expired_90,
    SUM(CASE 
            WHEN DATEDIFF(STR_TO_DATE(main.file_due, '%m/%d/%Y'), NOW()) > 90 THEN 1
            ELSE 0
        END) AS non_expired,
    SUM(CASE 
            WHEN main.compliance = 1 OR main.approved_by > 0 THEN 1
            ELSE 0
        END) AS compliant_count,
    SUM(CASE 
            WHEN main.compliance = 0 OR main.approved_by = 0 THEN 1
            ELSE 0
        END) AS non_compliant_count,
    p.reviewed_by,
    p.audit_report_date AS audit_report_date,
    p.audit_report_end_date AS audit_report_end_date,
    p.audit_certificate_date AS audit_certificate_date,
    p.audit_certificate_end_date AS audit_certificate_end_date,
    p.audit_action_date AS audit_action_date,
    p.audit_action_end_date AS audit_action_end_date,
    p.reviewed_date AS reviewed_date,
    p.reviewed_due AS reviewed_due,
    a.audit_report_count + a.audit_certificate_count + a.audit_action_count AS total_audits,
    a.annual_review_count
FROM (
    SELECT
        tbl_supplier.id,
        tbl_supplier.name,
        tbl_supplier_document.file_due,
        tbl_supplier_document.compliance,
        tbl_supplier_document.approved_by,
        CASE 
            WHEN tbl_supplier.document IS NULL OR tbl_supplier.document = '' THEN 0
            ELSE (LENGTH(tbl_supplier.document) - LENGTH(REPLACE(tbl_supplier.document, '|', '')) + 1)
        END AS document_count,
        CASE 
            WHEN tbl_supplier.document_other IS NULL OR tbl_supplier.document_other = '' THEN 0
            ELSE (LENGTH(tbl_supplier.document_other) - LENGTH(REPLACE(tbl_supplier.document_other, '|', '')) + 1)
        END AS document_other_count,
        CASE 
            WHEN tbl_supplier.material IS NULL OR tbl_supplier.material = '' THEN 0
            ELSE (LENGTH(tbl_supplier.material) - LENGTH(REPLACE(tbl_supplier.material, ',', '')) + 1)
        END AS material_count
    FROM
        tbl_supplier
    LEFT JOIN
        tbl_supplier_document ON tbl_supplier.id = tbl_supplier_document.supplier_id
    WHERE
        tbl_supplier.page = 1
        AND tbl_supplier.is_deleted = 0
        AND tbl_supplier.user_id = ?
        AND tbl_supplier.id = ?
) AS main
LEFT JOIN (
    SELECT
        MaterialSplit.supplier_id,
        SUM(CASE WHEN tbl_supplier_material.active = 1 THEN 1 ELSE 0 END) AS active_material_count,
        SUM(CASE WHEN tbl_supplier_material.active = 0 THEN 1 ELSE 0 END) AS inactive_material_count
    FROM
        MaterialSplit
    LEFT JOIN
        tbl_supplier_material ON MaterialSplit.material_id = tbl_supplier_material.id
    GROUP BY
        MaterialSplit.supplier_id
) AS material_counts ON main.id = material_counts.supplier_id
LEFT JOIN
    ParsedData p ON main.id = p.ID
LEFT JOIN
    AuditCounts a ON p.reviewed_by = a.reviewed_by
GROUP BY
    main.name, main.document_count, main.document_other_count, main.material_count, active_material_count, inactive_material_count, p.reviewed_by, p.audit_report_date, p.audit_report_end_date, p.audit_certificate_date, p.audit_certificate_end_date, p.audit_action_date, p.audit_action_end_date, p.reviewed_date, p.reviewed_due, a.audit_report_count, a.annual_review_count;";

// Log the query
error_log("SQL Query: " . $sql);

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiii", $user_id, $id, $user_id, $id, $user_id, $id);
$stmt->execute();
$result = $stmt->get_result();

$data = [
    "vendor_name" => "",
    "document_count" => 0,
    "document_other_count" => 0,
    "expired" => 0,
    "nearly_expired_30" => 0,
    "nearly_expired_60" => 0,
    "nearly_expired_90" => 0,
    "non_expired" => 0,
    "compliant_count" => 0,
    "non_compliant_count" => 0,
    "material_count" => 0,
    "active_material_count" => 0,
    "inactive_material_count" => 0,
    "reviewed_by" => "",
    "audit_report_date" => "",
    "audit_report_end_date" => "",
    "audit_certificate_date" => "",
    "audit_certificate_end_date" => "",
    "audit_action_date" => "",
    "audit_action_end_date" => "",
    "reviewed_date" => "",
    "reviewed_due" => "",
    "total_audits" => 0,
    "annual_review_count" => 0
];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data["vendor_name"] = $row['name'];
    $data["document_count"] = (int) $row['document_count'];
    $data["document_other_count"] = (int) $row['document_other_count'];
    $data["expired"] = (int) $row['expired'];
    $data["nearly_expired_30"] = (int) $row['nearly_expired_30'];
    $data["nearly_expired_60"] = (int) $row['nearly_expired_60'];
    $data["nearly_expired_90"] = (int) $row['nearly_expired_90'];
    $data["non_expired"] = (int) $row['non_expired'];
    $data["compliant_count"] = (int) $row['compliant_count'];
    $data["non_compliant_count"] = (int) $row['non_compliant_count'];
    $data["material_count"] = (int) $row['material_count'];
    $data["active_material_count"] = (int) $row['active_material_count'];
    $data["inactive_material_count"] = (int) $row['inactive_material_count'];
    $data["reviewed_by"] = $row['reviewed_by'];
    $data["audit_report_date"] = $row['audit_report_date'];
    $data["audit_report_end_date"] = $row['audit_report_end_date'];
    $data["audit_certificate_date"] = $row['audit_certificate_date'];
    $data["audit_certificate_end_date"] = $row['audit_certificate_end_date'];
    $data["audit_action_date"] = $row['audit_action_date'];
    $data["audit_action_end_date"] = $row['audit_action_end_date'];
    $data["reviewed_date"] = $row['reviewed_date'];
    $data["reviewed_due"] = $row['reviewed_due'];
    $data["total_audits"] = (int) $row['total_audits'];
    $data["annual_review_count"] = (int) $row['annual_review_count'];
} else {
    // Log no results
    error_log("No results found for the query.");
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
