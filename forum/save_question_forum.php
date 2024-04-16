<?php 
session_start();
include 'database.php';   
$question_title = $_POST['question_title'];
$question_description = $_POST['question_description'];
$user_id = $_POST['user_id'];
$status = $_POST['status'];
$question_tags = $_POST['question_tags'];
$user_fname = $_COOKIE['first_name'];

// $to = $member_email;
// $subject = "PMS - Project  (" . $project_name .") was moved to Archived By:".$signedin_user ;
// $from = 'PMS@NotificationSystem.com';

// $sql = "INSERT INTO PRP_Voices (voice_content) VALUES ('$messagess')";
// $conn->query($sql);

// // To send HTML mail, the Content-type header must be set
// $headers  = 'MIME-Version: 1.0' . "\r\n";
// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// // Create email headers
// $headers .= 'From: '.$from."\r\n".
//     'Reply-To: '.$from."\r\n" .
//     'X-Mailer: PHP/' . phpversion();
 
// // Compose a simple HTML email message
// $message = '<html><body>';
// $message .= '<h1 style="color:#0a91de;">Hurray! Project was moved to Archived! keep pushing projects to Done!</h1>';
// $message .= '<div style="width:700px;height:auto;margin:0 auto;margin-top:40px;">
//     <div style="font-style:italic;font-size:20px;padding:30px;border-radius:30px 30px 30px 30px;background-color:#cae3e2;width:500px;height:auto;padding:20px;font-family:calibri;">
//         <span style="font-size: italic;">Project Name('.$project_name.')</span><hr> 
//         <span style="font-size: italic;">Moved to Archived by ('.$signedin_user.')</span><hr>
//         <hr> Project URL'.$currenturl.'
//     </div>

//    </div>';
// $message .= '</body></html>';
 
// // Sending email
// if(mail($to, $subject, $message, $headers)){
    
// } else{
//     echo 'Unable to send email. Please try again.';
// }	


$sql ="INSERT INTO `questions`(`question_title`, `content`, `asked_by`, `status`, `question_tags`, `user_fname`) VALUES ('$question_title','$question_description ','$user_id','$status','$question_tags','$user_fname')";

	

	if (mysqli_query($conn, $sql)) {

		echo json_encode(array("statusCode"=>200));

	} 

	else {

		echo json_encode(array("statusCode"=>201));

	}

    mysqli_close($conn);

    

?>