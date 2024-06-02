<?php
include 'database.php';


	
	// add New Message
if (isset($_POST['btnAdd_ContactSubmit'])) {  
    $userID = $_COOKIE['ID']; 
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $from = mysqli_real_escape_string($conn,$_POST['from']);
    $First_Name = mysqli_real_escape_string($conn,$_POST['First_Name']);
    $Last_Name = mysqli_real_escape_string($conn,$_POST['Last_Name']);
    $contact_website = mysqli_real_escape_string($conn,$_POST['contact_website']);
    $contact_facebook = mysqli_real_escape_string($conn,$_POST['contact_facebook']);
    $contact_twitter = mysqli_real_escape_string($conn,$_POST['contact_twitter']);
    $contact_linkedin = mysqli_real_escape_string($conn,$_POST['contact_linkedin']);
    $contact_interlink = mysqli_real_escape_string($conn,$_POST['contact_interlink']);
    $C_Title = mysqli_real_escape_string($conn,$_POST['C_Title']);
    $Report_to = mysqli_real_escape_string($conn,$_POST['Report_to']);
    $C_Address = mysqli_real_escape_string($conn,$_POST['C_Address']);
    $C_Phone = mysqli_real_escape_string($conn,$_POST['C_Phone']);
    $C_Fax = mysqli_real_escape_string($conn,$_POST['C_Fax']);
    $C_Email = mysqli_real_escape_string($conn,$_POST['C_Email']);
    
    $to = $_POST['C_Email'];
	$user = 'InterlinkIQ.com';
	$subject = 'Invitation to Connect via InterlinkIQ.com';
	$body = '<p>Hello '.$_POST['First_Name'].',<br><br>
	
        You are cordially invited to join <a href="https://interlinkiq.com/">InterlinkIQ.com</a> to connect with customers and suppliers.<br>
InterlinkIQ connectivity allows you to offer products, services, and share documents with customers, suppliers, contacts, and employees.
        <br><br>
        IntelinkIQ.com</p>';

	$mail = php_mailer($from, $to, $user, $subject, $body);
	
    $sql = "INSERT INTO tbl_Customer_Relationship_More_Contacts(First_Name,Last_Name,C_Title,Report_to,C_Address,C_Email,C_Phone,C_Fax,contact_website,contact_facebook,contact_twitter,contact_linkedin,contact_interlink,C_crm_ids,C_user_cookies) 
    VALUES ('$First_Name','$Last_Name','$C_Title','$Report_to','$C_Address','$C_Email','$C_Phone','$C_Fax','$contact_website','$contact_facebook','$contact_twitter','$contact_linkedin','$contact_interlink','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "customer_relationship_View.php?view_id='.$crm_ids.'#contacts";</script>';
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