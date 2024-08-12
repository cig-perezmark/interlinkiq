<?php
require '../database.php'; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


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


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "WITH ParsedData AS (
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
              AND user_id = $user_id
              AND page = 1
              AND ID = 1223
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
          p.reviewed_by,
          p.audit_report_date AS `Audit Report Date`,
          p.audit_report_end_date AS `Audit Report End Date`,
          p.audit_certificate_date AS `Audit Certificate Date`,
          p.audit_certificate_end_date AS `Audit Certificate End Date`,
          p.audit_action_date AS `Audit Corrective Action Date`,
          p.audit_action_end_date AS `Audit Corrective Action End Date`,
          p.reviewed_date AS `Reviewed Date`,
          p.reviewed_due AS `Reviewed Due`,
          a.audit_report_count + a.audit_certificate_count + a.audit_action_count AS total_audits,
          a.annual_review_count
      FROM
          ParsedData p
      JOIN
          AuditCounts a ON p.reviewed_by = a.reviewed_by";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = []; // Return empty array if no data
}
$conn->close();

// Output JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
