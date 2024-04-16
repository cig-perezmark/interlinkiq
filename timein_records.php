<?php 

    include_once 'database.php';
    
    $user_id = $_POST["current_user_id"];
    $current_userfullname = $_POST["fullname_user"];
    $user_action = $_POST["user_action"];
    $timeref = $_POST['reset_timeref'];
    
    // Set the timezone to "Asia/Tokyo"
    date_default_timezone_set('America/Chicago');
    
    // Get the current date and time in the specified timezone
    $currentDateTimeCST = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `tbl_timein`(`user_id`, `time_in_datetime`, `user_name`, `action`, `recorded_time`, `reset_time`) VALUES ($user_id , '$currentDateTimeCST', '$current_userfullname', '$user_action', '$currentDateTimeCST', $timeref)";
	
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	
	mysqli_close($conn);
	
	
	
?>