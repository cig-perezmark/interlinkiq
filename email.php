<?php

    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
    // require 'ses.php';
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $to = 'greeggimongala@gmail.com';
    // $to = 'greeg@consultareinc.com';
    $user = 'Greg';
    $subject = 'Test';
    $body = '<html><header></header><body><p>Hi this is sample msg testing only</p></body></html>';
    $bodyText =  "Hi this is sample msg testing only222";
    echo php_mailer($to, $user, $subject, $body);
    

    function php_mailer($to, $user, $subject, $body) {

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@interlinkiq.com';
            $mail->Password   = ';r8SfB*Ow!xj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->clearAddresses();
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);

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
	function php_mailer_old($to, $user, $subject, $body) {
		$mail = new PHPMailer(true);
        try {
            $mail->isSMTP(true);
        	$mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet 	  = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    
            $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                	'verify_peer' => true,
                	'verify_peer_name' => true,
                	'allow_self_signed' => false
                )
            );
            $mail->Port       = 587;
            $mail->clearAddresses();
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody    = $bodyText;
        
            $mail->send();
            $msg = 'Message has been sent';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        return $msg;
	}
?>
