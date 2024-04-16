<?php
include 'database.php';

// PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	function php_mailer($from, $to, $user, $subject, $body) {
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
		    $mail->AddEmbeddedImage =$body;
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		    $msg = 'Message has been sent';
		} catch (Exception $e) {
		    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		return $msg;
		
	}
	
	// add New Message
if (isset($_POST['btncampaign_submit'])) { 
    if(!empty($_POST['Target_Date'])){
        $userID = $_COOKIE['ID']; 
        $name = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y/m/d');
        
        $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
        $from = mysqli_real_escape_string($conn,$_POST['from']);
        $Campaign_Recipients = mysqli_real_escape_string($conn,$_POST['Campaign_Recipients']);
        $Campaign_Subject = mysqli_real_escape_string($conn,$_POST['Campaign_Subject']);
        $Campaign_body = mysqli_real_escape_string($conn,$_POST['Campaign_body']);
        $Campaign_Name = mysqli_real_escape_string($conn,$_POST['Campaign_Name']);
        $Target_Date = mysqli_real_escape_string($conn,$_POST['Target_Date']);
        $Campaign_Status = 1;
    	$to = $_POST['Campaign_Recipients'];
    	$user = 'InterlinkIQ.com';
    	$subject = $_POST['Campaign_Subject'];
    	$body = $_POST['Campaign_body'];
    
    	$mail = php_mailer($from, $to, $user, $subject, $body);
    	
        $sql = "INSERT INTO tbl_Customer_Relationship_Campaign(Campaign_from,Campaign_Name,Campaign_Recipients,Campaign_Subject,Campaign_body,Campaign_Status,Target_Date,crm_ids,Campaign_added,Auto_Send_Status,userID) VALUES ('$from','$Campaign_Name','$Campaign_Recipients','$Campaign_Subject','$Campaign_body','$Campaign_Status','$Target_Date','$crm_ids','$today',1,'$userID')";
        if(mysqli_query($conn, $sql)){
            $last_insert_id = mysqli_insert_id($conn);
            $action = 'Send new Campaign';
            $activity = "INSERT INTO tbl_crm_history_data (contact_id, user_id, performer_name, action_taken, type, action_id) VALUES ($crm_ids, $userID, '$name', $action, 1, $last_insert_id)";
            if (mysqli_query($conn, $activity)) {
                echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#notes";</script>';
            } else {
                echo "Error inserting history data: " . $conn->error;
            }
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    }
    else{
        $userID = $_COOKIE['ID']; 
        $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
        $from = mysqli_real_escape_string($conn,$_POST['from']);
        $Campaign_Recipients = mysqli_real_escape_string($conn,$_POST['Campaign_Recipients']);
        $Campaign_Subject = mysqli_real_escape_string($conn,$_POST['Campaign_Subject']);
        $Campaign_body = mysqli_real_escape_string($conn,$_POST['Campaign_body']);
        $Campaign_Name = mysqli_real_escape_string($conn,$_POST['Campaign_Name']);
        $Frequency = mysqli_real_escape_string($conn,$_POST['Frequency']);
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d h:i:s');
        $Campaign_Status = 2;
        
        $to = $_POST['Campaign_Recipients'];
    	$user = 'InterlinkIQ.com';
    	$subject = $_POST['Campaign_Subject'];
    	$body = $_POST['Campaign_body'];
    
    	$mail = php_mailer($from, $to, $user, $subject, $body);
    	
        $sql = "INSERT INTO tbl_Customer_Relationship_Campaign(Campaign_from,Campaign_Name,Campaign_Recipients,Campaign_Subject,Campaign_body,Frequency,date_execute,Campaign_Status,crm_ids,Campaign_added,Auto_Send_Status,userID) VALUES ('$from','$Campaign_Name','$Campaign_Recipients','$Campaign_Subject','$Campaign_body','$Frequency','$today','$Campaign_Status','$crm_ids','$today',1,'$userID')";
        if(mysqli_query($conn, $sql)){
            $last_insert_id = mysqli_insert_id($conn);
            $action = 'Send new Campaign'; // Enclose the string in single quotes
            $name = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
            $activity = "INSERT INTO tbl_crm_history_data (contact_id, user_id, performer_name, action_taken, type, action_id) VALUES ($crm_ids, $userID, '$name', '$action', 1, $last_insert_id)";
            if (mysqli_query($conn, $activity)) {
                echo '<script> window.location.href = "customer_relationship_View.php?view_id='.$crm_ids.'#campaign";</script>';
            } else {
                echo "Error inserting history data: " . $conn->error;
            }
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
}


?>