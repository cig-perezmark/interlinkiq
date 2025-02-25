<?php
	include 'database.php';

	// add New Task
	if (isset($_POST['btntask_submit'])) {  
		$userID = $_COOKIE['ID'];
		$crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
		$assign_task = mysqli_real_escape_string($conn,$_POST['assign_task']);
		$Assigned_to = mysqli_real_escape_string($conn,$_POST['Assigned_to']);
		$Task_added = mysqli_real_escape_string($conn,$_POST['Task_added']);
		$Deadline = mysqli_real_escape_string($conn,$_POST['Deadline']);
		$from = mysqli_real_escape_string($conn,$_POST['from']);
		$as_editor = 1;
		$Task_Status = 1;
		$account = mysqli_real_escape_string($conn,$_POST['account']);
		$Task_Description = mysqli_real_escape_string($conn,$_POST['Task_Description']);
		$to = $_POST['Assigned_to'];
		$user = 'InterlinkIQ.com';
		$subject = $_POST['assign_task'];
		$body = 'Account Name: '.$account.'<br><br> '.$_POST['assign_task'].'<br> <br>'. $Task_Description.'<br><br><b>Task Added:</b> '.$_POST['Task_added'].' - <b>Deadline: </b> '.$_POST['Deadline'].'
		<br><br><a class="btn" href="https://interlinkiq.com/customer_relationship_View.php?view_id='.$crm_ids.'#tasks" target="_blank">Click here</a>';

		$mail = php_mailer($from, $to, $user, $subject, $body);

		$sql = "INSERT INTO tbl_Customer_Relationship_Task(assign_task,Assigned_to,Task_Description,Task_added,Deadline,crm_ids,as_editor,Task_Status,user_cookies) VALUES ('$assign_task','$Assigned_to','$Task_Description','$Task_added','$Deadline','$crm_ids','$as_editor','$Task_Status','$userID')";
		if(mysqli_query($conn, $sql)){
			echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#tasks";</script>';
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
		  	// $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->Host       = 'interlinkiq.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
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
