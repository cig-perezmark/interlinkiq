<?php 
session_start();
include 'database.php';   

$viewed_by = $_POST['viewed_by'];
$question_id = $_POST["question_id"];


$sql ="INSERT INTO `questions_view`(`question_id`, `viewed_by`) VALUES ('$question_id','$viewed_by')";

	

	if (mysqli_query($conn, $sql)) {

		echo json_encode(array("statusCode"=>200));

	} 

	else {

		echo json_encode(array("statusCode"=>201));

	}

    mysqli_close($conn);

    

?>
