<?php 

	$servername='localhost';
	$username='brandons_interlinkiq';
	$password='L1873@2019new';
	$dbname = "brandons_interlinkiq";
	$conn=mysqli_connect($servername,$username,$password,"$dbname");
	if(!$conn){
	   die('Could not Connect My Sql:' .mysql_error());
	}

$userid = 1;
$servicetitleheading = $_POST['servicetitleheading_send'];
$description = $_POST['commentTitle_send'];
$action  = $_POST['action_send'];
$comment = $_POST['commentContent_send'];

$account = "";
$datenow = new DateTime("now", new DateTimeZone('America/New_York') );
$finaldescription = $servicetitleheading.$description;


$sql = "INSERT INTO `tbl_service_logs_draft`( `user_id`, `description`, `action`, `comment`, `account`, `task_date`, `minute`) 
VALUES ($userid, '$finaldescription','$action','$comment','$account',$datenow,$minute)";

if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);




?>