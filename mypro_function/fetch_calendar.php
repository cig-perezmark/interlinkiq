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

$userIds = $_COOKIE['employee_id'];
$data = array();
$sql = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
WHERE CAI_Assign_to	 = '$userIds' and is_deleted=0 and CIA_progress != 2  and CAI_Assign_to !=0 and CAI_Assign_to !='' and CAI_Assign_to !=' ' or user_pk = $user_id ORDER BY CAI_id" ; 
$result = mysqli_query ($conn, $sql);

foreach($result as $row){
    // $end = 2023-01-01 00:00:00;
    $start = $row['CAI_Action_date'];
    $end = $row['CAI_Action_due_date'];
    if(empty($end)) { 
        $end = $row['CAI_Action_date'];
    } else if($end < $start) { 
        $end = $row['CAI_Action_date'];
    } else if (str_contains($end, '1970-01-01')) {
        $end = $row['CAI_Action_date'];
    }
    $end = date('Y-m-d h:m:s', strtotime($end. ' + 10 hours'));
    $title = $row['CAI_filename'];
    $data[] = array(
        'id' => $row['CAI_id'],
        'title' => $title,
        'start' => $row['CAI_Action_date'],
        'task_name' => $row['CAI_filename'],
        'end' => $end
    );
}
echo json_encode($data);
?>