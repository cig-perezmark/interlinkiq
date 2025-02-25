<?php
include 'database.php';


	
	// add New Message
if (isset($_POST['btnmail_submit'])) {  
    $userID = $_COOKIE['ID']; 
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $from = mysqli_real_escape_string($conn,$_POST['from']);
    $Recipients= mysqli_real_escape_string($conn,$_POST['Recipients']);
    $Subject = mysqli_real_escape_string($conn,$_POST['Subject']);
    $Message_body = mysqli_real_escape_string($conn,$_POST['Message_body']);
    
    $to = $_POST['Recipients'];
	$user = 'InterlinkIQ.com';
	$subject = $_POST['Subject'];
	$body = $_POST['Message_body'];

	$mail = php_mailer($from, $to, $user, $subject, $body);
	
    $sql = "INSERT INTO tbl_Customer_Relationship_Mailing(Recipients,Subject,Message_body,crm_ids,user_cookies) VALUES ('$Recipients','$Subject','$Message_body','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "customer_relationship_View.php?view_id='.$crm_ids.'#email";</script>';
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
		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->CharSet = 'UTF-8';
		    $mail->Host       = 'interlinkiq.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom($from, $user);
		    $mail->addAddress($to, $user);
		    $mail->addReplyTo($from, $user);
		  //  $mail->addCC('services@interlinkiq.com');

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
