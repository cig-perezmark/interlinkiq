<?php 

    include_once 'database.php';
    
    $timeid = $_POST["timeid"];
    $userid = $_POST["userid"];
    $emp_name = $_POST["emp_name"];
    $actual_datetimeout = $_POST["date"].' '.$_POST["timeout"];
    $explanation = $_POST["explanation"];
    $action = 'OUT';
    
    date_default_timezone_set('America/Chicago');
    $actual_timeout = date('Y-m-d h:i:s A', strtotime($actual_datetimeout));
    
    $sql = "UPDATE tbl_time_approval SET is_approved = 'Yes' WHERE timeid={$timeid}";
	
	if (mysqli_query($conn, $sql)) {
	    $insert = "INSERT INTO `tbl_timein`(`user_id`, `time_in_datetime`, `user_name`, `action`,`recorded_time`) VALUES ($userid, '$actual_timeout', '$emp_name', '$action', '$actual_timeout')";
	    if(mysqli_query($conn, $insert)) {
	        echo json_encode(array("statusCode"=>200));
	    }
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
	
?>