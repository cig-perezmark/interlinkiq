<?php
include 'database.php';


	
	// add New Message
if (isset($_POST['btn_Collab'])) {  
   $userID = $_COOKIE['ID'];
    $from = mysqli_real_escape_string($conn,$_POST['from']);
    $ccrm_id = mysqli_real_escape_string($conn,$_POST['ID']);
    $as_editor = 0;
    
    $to = $_POST['invite_mail'];
	$user = 'InterlinkIQ';
	$subject = 'Invitation';
	$body = mysqli_real_escape_string($conn,$_POST['body_content']);

	$mail = php_mailer($from, $to, $user, $subject, $body);
	
    $sql = "INSERT INTO tbl_Customer_Relationship_collaboration(invite_mail,body_content,as_editor,ccrm_id,user_cookies) VALUES ('$to','$body','$as_editor','$ccrm_id','$userID')";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "Customer_Relationship_Management";</script>';
        }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	function php_mailer($from, $to, $user, $subject, $body) {
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);
		try {
		    $mail->isSMTP();
		    $mail->CharSet = 'UTF-8';
		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->Host       = 'interlinkiq.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom($from, $user);
		    $mail->addAddress($to, $user);
		    $mail->addReplyTo($from, $user);

		    $mail->isHTML(true);
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		    $msg = 'Message has been sent';
		} catch (Exception $e) {
		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		return $msg;
		
	}
?>