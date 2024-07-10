<?php
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

// Define the SQL query
$sql = "
    SELECT 
        COALESCE(SUM(c.compliant), 0) AS compliantCount,
        COALESCE(SUM(c.non_compliant), 0) AS nonCompliantCount,
        CASE 
            WHEN (SUM(c.compliant) + SUM(c.non_compliant)) > 0 THEN
                (SUM(c.compliant) / (SUM(c.compliant) + SUM(c.non_compliant))) * 100
            ELSE 0 
        END AS compliantPercentage,
        CASE 
            WHEN (SUM(c.compliant) + SUM(c.non_compliant)) > 0 THEN
                (SUM(c.non_compliant) / (SUM(c.compliant) + SUM(c.non_compliant))) * 100
            ELSE 0 
        END AS nonCompliantPercentage
    FROM tbl_library AS t1
    LEFT JOIN (
        SELECT
            library_id,
            SUM(CASE WHEN compliant = 1 THEN 1 ELSE 0 END) AS compliant,
            SUM(CASE WHEN compliant = 0 THEN 1 ELSE 0 END) AS non_compliant
        FROM tbl_library_compliance 
        WHERE deleted = 0
        GROUP BY library_id
    ) AS c 
    ON t1.ID = c.library_id
    WHERE t1.deleted = 0 
        AND t1.user_id = $user_id
      /*AND t1.parent_id = 0*/
";

// Execute the query
$selectCompliance = mysqli_query($conn, $sql);

$result = mysqli_fetch_assoc($selectCompliance);

$response = [
    'compliantPercentage' => floatval($result['compliantPercentage']),
    'nonCompliantPercentage' => floatval($result['nonCompliantPercentage'])
];

// Output the compliance data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
