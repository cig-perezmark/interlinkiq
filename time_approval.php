<?php 

    include_once 'database.php';
    
    $user_id = $_POST["userid"];
    $current_userfullname = $_POST["emp_name"];
    $date = $_POST["date"];
    $time_input = $_POST["timeout"];
    $reason = $_POST["reason"];
    $actual_timeout = date('h:i:s A', strtotime($time_input = $_POST["timeout"]));

    $sql = "INSERT INTO `tbl_time_approval`( `userid`, `employee_name`, `correspond_date`, `actual_timeout`, `incident_explanation`) VALUES ($user_id, '$current_userfullname', '$date', '$actual_timeout','$reason')";
	
	if (mysqli_query($conn, $sql)) {
	    echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	
	mysqli_close($conn);
	
?>