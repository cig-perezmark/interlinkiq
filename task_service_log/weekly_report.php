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

if($_POST['key']) {
   if($_POST['key'] == 'get_wreport') {
    $cookies = $_COOKIE['ID'];
    $query = "SELECT *  FROM tbl_hr_employee where user_id = 34 and status = 1 order by first_name ASC";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $emp_id = $row['ID'];
        $query1 = mysqli_query($conn, "SELECT *  FROM tbl_user where employee_id = '$emp_id' order by first_name ASC");
        foreach($query1 as $user_row){?>
            <tr id="user_id_<?= $user_row['ID']; ?>">
                <td><?= $user_row['first_name']; ?>&nbsp;<?= $user_row['last_name']; ?></td>
                <td>
                    <?php
                        $user_logs_id = $user_row['ID'];
                        $query_tasks = mysqli_query($conn, "select count(*) as total_task,task_date,user_id,minute from tbl_service_logs where minute > 0 and week(task_date) = week(now()) and user_id = '$user_logs_id' AND not_approved = 0");
                        foreach($query_tasks as $task_row){
                            echo $task_row['total_task'];
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $user_logs_id = $user_row['ID'];
                        $query_logs = mysqli_query($conn, "select ifnull(sum(minute), 0) as total_mim,task_date,user_id from tbl_service_logs where minute > 0 and week(task_date) = week(now()) and user_id = '$user_logs_id' AND not_approved = 0");
                        foreach($query_logs as $log_row){
                            $time = $log_row['total_mim'];
                            $hours = floor($time / 60);
                            $minutes = ($time % 60);
                            if($minutes == 0 && $hours == 0){ echo '<i style="color:red;">No logs this week!</i>';}
                            
                            if($hours != 0){echo $hours;}
                            if($hours != 0){ echo ' hour'; }
                            if($hours > 1){ echo 's '; }
                            
                            if($minutes != 0 && $hours != 0){ echo ' & ';}
                            if($minutes != 0){ echo $minutes;}
                            if($minutes != 0){ echo ' minute';}
                            if($minutes > 1){ echo 's';}
                        }
                    ?>
                </td>
            </tr>
        <?php }
    }
   }
}
?>
