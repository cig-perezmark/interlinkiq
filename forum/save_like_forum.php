<?php 
session_start();
include 'database.php';   

$liked_by = $_POST['liked_by'];
$question_id = $_POST["question_id"];


$sql ="INSERT INTO `questions_like`(`question_id`, `liked_by`) VALUES ('$question_id','$liked_by')";

	

	if (mysqli_query($conn, $sql)) {

		echo json_encode(array("statusCode"=>200));

	} 

	else {

		echo json_encode(array("statusCode"=>201));

	}

    mysqli_close($conn);

    

?>

