<?php 

include 'database.php';   
$comment_content = $_POST['commentcontent'];
$question_id = $_POST['selectedid'];
$user_fname = $_POST['userfname'];
$current_user =  $_POST['currentuser'];
 



$sql ="INSERT INTO `questions_comment`(`question_id`, `commented_by`, `comment_content`, `user_fname`) VALUES ('$question_id','$current_user','$comment_content','$user_fname')";

	

	if (mysqli_query($conn, $sql)) {

		echo json_encode(array("statusCode"=>200));

	} 

	else {

		echo json_encode(array("statusCode"=>201));

	}

    mysqli_close($conn);

    

?>
