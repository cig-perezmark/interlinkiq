<?php
// Include database connection
require '../database.php';

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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count main folders and subfolders
$sql_folders = "
    SELECT 
        user_id,
        SUM(CASE WHEN parent_id = 0 THEN 1 ELSE 0 END) AS main_folder_count,
        SUM(CASE WHEN parent_id != 0 THEN 1 ELSE 0 END) AS sub_folder_count
    FROM tbl_library
    WHERE deleted = 0 
    AND user_id = $user_id
    AND facility_switch = $facility_switch_user_id2
    GROUP BY user_id
";

$result_folders = $conn->query($sql_folders);

// Check for query execution errors
if (!$result_folders) {
    die("Query failed: " . $conn->error);
}

// Prepare folder data
$folderData = [];
if ($result_folders->num_rows > 0) {
    while ($row = $result_folders->fetch_assoc()) {
        $folderData[] = [
            'user_id' => $row["user_id"],
            'main_folder_count' => $row["main_folder_count"],
            'sub_folder_count' => $row["sub_folder_count"]
        ];
    }
} else {
    $folderData = [];
}

// SQL query to get the latest entries per library_id and expiry counts, including non-expired latest files count
// $sql_files = "
//     SELECT 
//         COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) AS expired,
//         COUNT(CASE WHEN due_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY THEN 1 END) AS nearly_expired_30_days,
//         COUNT(CASE WHEN due_date BETWEEN CURDATE() + INTERVAL 31 DAY AND CURDATE() + INTERVAL 60 DAY THEN 1 END) AS nearly_expired_60_days,
//         COUNT(CASE WHEN due_date BETWEEN CURDATE() + INTERVAL 61 DAY AND CURDATE() + INTERVAL 90 DAY THEN 1 END) AS nearly_expired_90_days,
//         COUNT(CASE WHEN due_date >= CURDATE() THEN 1 END) AS non_expired,
//         COUNT(DISTINCT library_id) AS latest_files_count
//     FROM (
//         SELECT * FROM tbl_library_file 
//         WHERE deleted = 0 AND user_id = $user_id
//         AND id IN (
//             SELECT MAX(id) FROM tbl_library_file 
//             WHERE deleted = 0 AND user_id = $user_id 
//             GROUP BY library_id
//         )
//     ) AS latest_files
// ";

$sql_files = "
    SELECT 
        l.ID AS l_ID,
        l.collaborator_id AS l_collaborator_id,
        f.ID AS f_ID,
        f.library_id AS f_library_id,
        f.files AS f_files,
        f.last_modified AS f_last_modified,
        f.due_date AS f_due_date,
        COUNT(CASE WHEN f.due_date < CURDATE() THEN 1 END) AS expired,
        COUNT(CASE WHEN f.due_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY THEN 1 END) AS nearly_expired_30_days,
        COUNT(CASE WHEN f.due_date BETWEEN CURDATE() + INTERVAL 31 DAY AND CURDATE() + INTERVAL 60 DAY THEN 1 END) AS nearly_expired_60_days,
        COUNT(CASE WHEN f.due_date BETWEEN CURDATE() + INTERVAL 61 DAY AND CURDATE() + INTERVAL 90 DAY THEN 1 END) AS nearly_expired_90_days,
        COUNT(CASE WHEN f.due_date >= CURDATE() THEN 1 END) AS non_expired,
        COUNT(l.ID) AS latest_files_count
            
    FROM tbl_library AS l
    
    LEFT JOIN (
    	SELECT
        ID,
        library_id,
        type,
        filetype,
        files,
        last_modified,
        due_date
        FROM tbl_library_file
        WHERE deleted = 0
        AND ID IN (
            SELECT MAX(ID) 
            FROM tbl_library_file 
            WHERE deleted = 0
            GROUP BY library_id
    	)
    ) AS f
    ON l.ID = f.library_id
    
    WHERE l.deleted = 0
    AND LENGTH(f.files ) > 0
    AND l.user_id = $user_id
    AND l.facility_switch = $facility_switch_user_id2
    -- AND l.collaborator_id LIKE '%326%'
    
    -- GROUP BY l.ID
";

$result_files = $conn->query($sql_files);

// Check for query execution errors
if (!$result_files) {
    die("Query failed: " . $conn->error);
}

// Prepare file data
$fileData = $result_files->fetch_assoc();

// Combine data
$data = [
    'folderData' => $folderData,
    'fileData' => $fileData
];

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
?>
