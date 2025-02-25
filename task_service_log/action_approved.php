<?php
	require '../database.php';
	// Get status only
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

if(isset($_POST["scope_update_id"]))
{
     foreach($_POST["scope_update_id"] as $id)
     {
            $query = "UPDATE tbl_service_logs set not_approved = 0 WHERE task_id = '".$id."'";
            mysqli_query($conn, $query);
     }
}

if(isset($_POST['scope_disapprove_id'])){
    foreach($_POST["scope_update_id"] as $id)
     {
            $query = "UPDATE tbl_service_logs set not_approved = 4 WHERE task_id = '".$id."'";
            mysqli_query($conn, $query);
     }
}

if(isset($_POST["send_update_id"]))
{
     foreach($_POST["send_update_id"] as $id)
     {
            $query = "UPDATE tbl_service_logs set not_approved = 1 WHERE task_id = '".$id."'";
            mysqli_query($conn, $query);
     }
}

if(isset($_POST['action'])){
    if($_POST['action'] == "disapprove"){
        $task_id = $_POST['task_id'];
        $comment = $_POST['comment'];
        
       $query = "UPDATE tbl_service_logs set not_approved = 4,reasons = '$comment' WHERE task_id = '".$task_id."' ";
       mysqli_query($conn, $query);
    }
}
?>
