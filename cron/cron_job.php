<?php
    include '../database.php';

    if(isset($_COOKIE['ID'])){
        
        $user = 'interlinkiq.com';
       
       echo $from = 'ranel.roxas.me@gmail.com';
       echo $to = 'ranelr@consultareinc.com';
       echo $subject = 'Assigned to You: ';
       echo $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    Create My Pro
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    Ranel Roxas
                    <br>
                    <br>
                    <b>Due date</b> <br>
                    yyyy-mm--dd
                    <br>
                    <br>
                    <b>Projects</b><br>
                    Project Name

                    <br><br><br>
                    <a href="https://interlinkiq.com/MyPro.php#tab_Me" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
       echo $user;
    	$mail = php_mailer($from, $to, $user, $subject, $body);
    }
    
    
    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require '../PHPMailer/src/Exception.php';    
    require '../PHPMailer/src/PHPMailer.php';    
    require '../PHPMailer/src/SMTP.php';  
    
	function php_mailer($from, $to, $user, $subject, $body) {
		require '../PHPMailer/src/Exception.php';
		require '../PHPMailer/src/PHPMailer.php';
		require '../PHPMailer/src/SMTP.php';
		

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
