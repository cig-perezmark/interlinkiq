<?php
    include '../database.php';
    if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
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
if (isset($_COOKIE['switchAccount'])) { $userID = $_COOKIE['switchAccount']; }
else { $userID = $_COOKIE['ID']; }
$your_cookie = $_COOKIE['ID'];
$userIds = $_COOKIE['employee_id'];
$data = array();
$sql = "SELECT * FROM tbl_project_management WHERE addedby = $your_cookie and is_completed = 0" ; 
$result = mysqli_query ($conn, $sql);

$sql1 = "SELECT * FROM tbl_project_management WHERE addedby != $your_cookie and is_completed = 0" ; 
$result1 = mysqli_query ($conn, $sql1);

foreach($result as $row){
    // $end = 2023-01-01 00:00:00;
    $start = $row['start_date'];
    $end = $row['completion_date'];
    if(empty($end)) { 
        $end = $row['start_date'];
    } else if($end < $start) { 
        $end = $row['start_date'];
    } else if (str_contains($end, '1970-01-01')) {
        $end = $row['start_date'];
    }
    $end = date('Y-m-d h:m:s', strtotime($end. ' + 10 hours'));
    $title = $row['project_name'];
    $data[] = array(
        'id' => $row['project_pk'],
        'title' => $title,
        'start' => $row['start_date'],
        'task_name' => $row['project_name'],
        'end' => $end
    );
}

foreach($result1 as $row){
    $array_data = explode(", ", $row["collaborator_pk"]);
    if(in_array($userIds,$array_data)){
        // $end = 2023-01-01 00:00:00;
        $start = $row['start_date'];
        $end = $row['completion_date'];
        if(empty($end)) { 
            $end = $row['start_date'];
        } else if($end < $start) { 
            $end = $row['start_date'];
        } else if (str_contains($end, '1970-01-01')) {
            $end = $row['start_date'];
        }
        $end = date('Y-m-d h:m:s', strtotime($end. ' + 10 hours'));
        $title = $row['project_name'];
        $data[] = array(
            'id' => $row['project_pk'],
            'title' => $title,
            'start' => $row['start_date'],
            'task_name' => $row['project_name'],
            'end' => $end
        );
    }
}
echo json_encode($data);
?>
