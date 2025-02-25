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
    
    // //get credentials at http://aws.amazon.com My Account / Console > Security Credentials
    // $ses = new SimpleEmailService('AKIAROKUUVANWTUPGMV6', 'BPnAVc81PnSOt9/Q/UXtQoToXARkfF6NuzRP/kU66JYO');
    
    // $m = new SimpleEmailServiceMessage();
    // //note that from and to emails must be verified using AWS SES dashboard.  Can remove limitations here https://aws-portal.amazon.com/gp/aws/html-forms-controller/contactus/SESProductionAccess2011Q3.
    // $m->addTo('greeggimongala@gmail.com');
    // $m->setFrom('John Doe <services@interlinkiq.com>');
    // $m->setSubject('Amazon php SES test');
    // $m->setMessageFromString('Message Body');
    
    // print_r($ses->sendEmail($m));

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
            // $mail->addReplyTo('services@interlinkiq.com', 'Interlink IQ');
            // $mail->addReplyTo($to, $user);
            // $mail->addCC('services@interlinkiq.com');

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
        // 	$mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        	$mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            // $mail->Host       = 'mail.smtp2go.com';
            // $mail->Host       = 'email-smtp.us-west-2.amazonaws.com';
            $mail->CharSet 	  = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            // $username = 'greeg';
            // $password = 'ajNb4ytIliXyZOCK';
            // $username = 'AKIAROKUUVANWTUPGMV6';
            // $password = 'BPnAVc81PnSOt9/Q/UXtQoToXARkfF6NuzRP/kU66JYO';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
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
            // $mail->addReplyTo('services@interlinkiq.com', 'Interlink IQ');
            // $mail->addReplyTo($to, $user);
            // $mail->addCC('services@interlinkiq.com');
        
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


        // // This email address must be verified with Amazon SES to send.
        // $sender = 'admin@interlinkiq.com';
        // $senderName = 'IIQ';
         
        // // is still in the sandbox, this address must be verified.
        // $recipient = 'greeg@consultareinc.com';
         
        // // Replace smtp_username with your Amazon SES SMTP user name.
        // $username = 'AKIAROKUUVANWTUPGMV6';
        // // $username = 'admin@interlinkiq.com';
        // // $username = 'noreply@interlinkiq.com';
         
        // // Replace smtp_password with your Amazon SES SMTP password.
        // $password = 'BPnAVc81PnSOt9/Q/UXtQoToXARkfF6NuzRP/kU66JYO';
        // // $password = 'L1873@2019new';
        // // $password = 'J[3OrvA_!4G8';
         
         
        // // If you're using Amazon SES in a region other than US West (Oregon),
        // // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
        // // endpoint in the appropriate region.
        // // $host = 'interlinkiq.com'; // please enter you endpoint
        // $host = 'email-smtp.us-west-2.amazonaws.com'; // please enter you endpoint
        // $port = 465;
        // $configurationSet = 'ConfigSet';
         
        // // The subject line of the email
        // $subject = 'Testing';
         
        // // If you are sending The plain-text body of the email then uncomment below code line
        // //$bodyText =  "-- Put body text here --";
         
        // // The HTML-formatted body of the email
        // $bodyHtml = 'Enter body html here';
         
        // $mail = new PHPMailer(true);
         
        // try {
        //     // Specify the SMTP settings.
        //     $mail->isSMTP(true);
        //     $mail->setFrom($sender, $senderName);
        //     $mail->Username   = $username;
        //     $mail->Password   = $password;
        //     $mail->Host       = $host;
        //     $mail->Port       = $port;
        //     $mail->SMTPAuth   = true;
        //     $mail->SMTPSecure = 'SSL';
        //     // $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
         
        //     // Specify the message recipients.
        //     $mail->addAddress($recipient);
        //     // You can also add CC, BCC, and additional To recipients here.
         
        //     //If you want to send reply to specific email , then use below code for Reply To
        //     // $mail->ClearReplyTos();
        //     // $mail->addReplyTo('Enter Reply to Email here', 'Enter Reply to name here');
         
        //     //Add attachments
        //     // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
         
        //     // Specify the content of the message.
        //     $mail->isHTML(true);
        //     $mail->Subject    = $subject;
        //     $mail->Body       = $bodyHtml;
        //     // $mail->AltBody    = $bodyText;
        //     $mail->Send();
        //     $msg = "Email sent successfully!";
        // } catch (phpmailerException $e) {
        //     $msg = "An error occurred. {$e->errorMessage()}"; //Catch errors from PHPMailer.
        // } catch (Exception $e) {
        //     $msg = "Email not sent. {$mail->ErrorInfo}"; //Catch errors from Amazon SES.
        // }

        // return $msg;

// 		try {
// 		    $mail->isSMTP();
// 			// $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
// 		    $mail->Host       = 'email-smtp.us-west-2.amazonaws.com';
// 		    $mail->CharSet 	  = 'UTF-8';
// 		    $mail->SMTPAuth   = true;
// 		    $mail->Username   = 'AKIAROKUUVANWTUPGMV6';
// 		    $mail->Password   = 'BPnAVc81PnSOt9/Q/UXtQoToXARkfF6NuzRP/kU66JYO';
// 		    $mail->SMTPSecure = 'TLS';
// 		    $mail->Port       = 587;
// 		    $mail->clearAddresses();
// 		    $mail->setFrom('admin@interlinkiq.com', 'Interlink IQ');
// 		    $mail->addAddress($to, $user);
//             // $mail->addReplyTo('services@interlinkiq.com', 'Interlink IQ');
//             // $mail->addReplyTo($to, $user);
// 		    // $mail->addCC('services@interlinkiq.com');

// 		    $mail->isHTML(true);
// 		    $mail->Subject = $subject;
// 		    $mail->Body    = $body;

// 		    $mail->send();
// 		    $msg = 'Message has been sent';
// 		} catch (Exception $e) {
// 		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 		}

// 		return $msg;

// 		try {
// 			// $mail->isMail();
// 			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
// 			// $mail->isSMTP();
// 			// $mail->Host       = 'interlinkiq.com';
// 			// $mail->SMTPAuth   = true;
// 			// $mail->Username   = 'admin@interlinkiq.com';
// 			// $mail->Password   = 'L1873@2019new';
// 			// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
// 			// $mail->Port       = 465;
// 			// $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
// 			// $mail->addAddress('greeggimongala@gmail.com', 'Joe User');     //Add a recipient

// 			// Server settings
// 			$mail->isSMTP();                                            //Send using SMTP
// 			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
// 			$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';   //Set the SMTP server to send through
// 			$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
// 			$mail->SMTPSecure = 'TLS';                                  //Enable implicit TLS encryption
// 			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
// 			$mail->Username   = 'AKIAROKUUVANWTUPGMV6';                     //SMTP username
// 			$mail->Password   = 'BPnAVc81PnSOt9/Q/UXtQoToXARkfF6NuzRP/kU66JYO';                               //SMTP password


// 			$mail->setFrom('admin@interlinkiq.com', 'Interlink IQ');
// 			$mail->addAddress($to, $user);
	        

// 			$mail->isHTML(true);
// 			$mail->Subject = $subject;
// 			$mail->Body    = $body;

// 			$mail->send();
// 			$msg = 'Message has been sent';
// 		} catch (Exception $e) {
// 		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 		}

// 		return $msg;
	}
?>
