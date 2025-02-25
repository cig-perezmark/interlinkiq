<?php
include 'database.php';

   
    $query = "SELECT * FROM tbl_Customer_Relationship_Campaign where Campaign_Status = 1 and userID = 185";
    $result = mysqli_query($conn, $query);
                           
    while($rowc = mysqli_fetch_array($result))
    {
        $today = date("Y/m/d"); 
      $date = date_create($rowc['Target_Date']);
      $sched = date_format($date,"Y/m/d");
      $user = 'interlinkiq.com';
    //   $dina = '2022-09-30';
      if($sched == $today){
           $from = $rowc['Campaign_from'];
           $to = $rowc['Campaign_Recipients'];
           $subject = $rowc['Campaign_Subject'];
           $body = $rowc['Campaign_body'];
        	$mail = php_mailer($from, $to, $user, $subject, $body);
      }
    }
    
    
    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
// 	require 'PHPMailer/src/Exception.php';
// 	require 'PHPMailer/src/PHPMailer.php';
// 	require 'PHPMailer/src/SMTP.php';
	
	function php_mailer($from, $to, $user, $subject, $body) {
		
        echo "test";
// 		$mail = new PHPMailer(true);
// 		try {
// 		    $mail->isSMTP();
// 		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
// 		    $mail->CharSet = 'UTF-8';
// 		    $mail->Host       = 'interlinkiq.com';
// 		    $mail->SMTPAuth   = true;
// 		    $mail->Username   = 'admin@interlinkiq.com';
// 		    $mail->Password   = 'L1873@2019new';
// 		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
// 		    $mail->Port       = 465;
// 		    $mail->setFrom($from, $user);
// 		    $mail->addAddress($to, $user);
// 		    $mail->addReplyTo($from, $user);
// 		  //  $mail->addCC('services@interlinkiq.com');

// 		    $mail->isHTML(true);
// 		    $mail->Subject = $subject;
// 		    $mail->Body    = $body;

// 		    $mail->send();
// 		    $msg = 'Message has been sent';
// 		} catch (Exception $e) {
// 		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 		}

// 		return $msg;
		
	}
?>
