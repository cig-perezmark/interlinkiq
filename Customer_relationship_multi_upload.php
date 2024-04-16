<?php
include 'database.php';
 // Add multiple accounts
    if(isset($_POST['btn_Multi_acct_submit'])) {
        $userID = $_COOKIE['ID'];
        $from = $_POST['from'];
         $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y/m/d h:i:s');
        $fileTypes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
        );

        // Validate whether selected file is a CSV file
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileTypes)) {
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== false) {
              // Get row data
            $account_name = mysqli_real_escape_string($conn,$getData[0]);
            $to_mail = mysqli_real_escape_string($conn,$getData[1]);
            $account_phone = mysqli_real_escape_string($conn,$getData[2]);
            $account_fax = mysqli_real_escape_string($conn,$getData[3]);
            $account_address = mysqli_real_escape_string($conn,$getData[4]);
            $account_website = mysqli_real_escape_string($conn,$getData[5]);
            $account_facebook = mysqli_real_escape_string($conn,$getData[6]);
            $account_twitter = mysqli_real_escape_string($conn,$getData[7]);
            $account_linkedin = mysqli_real_escape_string($conn,$getData[8]);
            $account_interlink = mysqli_real_escape_string($conn,$getData[9]);
            $account_product = mysqli_real_escape_string($conn,$getData[10]);
            $account_service = mysqli_real_escape_string($conn,$getData[11]);
            $account_certification = mysqli_real_escape_string($conn,$getData[12]);
            $Account_Source = mysqli_real_escape_string($conn,$getData[13]);
            
            $sql = "INSERT INTO tbl_Customer_Relationship(account_rep,account_name,account_email,account_phone,account_fax,account_address,account_website,account_facebook,account_twitter,account_linkedin,account_interlink,account_product,account_service,account_certification,userID,Account_Source,mutiple_added,crm_date_added) 
            VALUES ('InterlinkIQ','$account_name','$to_mail','$account_phone','$account_fax','$account_address','$account_website','$account_facebook','$account_twitter','$account_linkedin','$account_interlink','$account_product','$account_service','$account_certification','$userID','$Account_Source',1,'$today')";
            if(mysqli_query($conn, $sql)){
                echo '<script> window.location.href = "Customer_Relationship_Management";</script>';
                }
            }
            // Close opened CSV file
            fclose($csvFile);
            // $user = 'interlinkiq.com';
            // $subject = 'Invitation to Connect via InterlinkIQ.com';
            // $body = '<p>Hello '.$a_name.',<br><br>
            //         You are cordially invited to join <a href="https://interlinkiq.com/">InterlinkIQ.com</a> to connect with customers and suppliers.<br>
            //         InterlinkIQ connectivity allows you to offer products, services, and share documents with customers, suppliers, contacts, and employees.
            //         <br><br>
            //         IntelinkIQ.com</p>';
            // $mail = php_mailer($from, $to, $user, $subject, $body);
        }
        else {
          echo "Please select valid file";
        }
    }
        
        // PHP MAILER FUNCTION
// 	use PHPMailer\PHPMailer\PHPMailer;
// 	use PHPMailer\PHPMailer\SMTP;
// 	use PHPMailer\PHPMailer\Exception;
	
// 	function php_mailer($from, $to, $user, $subject, $body) {
// 		require 'PHPMailer/src/Exception.php';
// 		require 'PHPMailer/src/PHPMailer.php';
// 		require 'PHPMailer/src/SMTP.php';

// 		$mail = new PHPMailer(true);
// 		try {
// 		    $mail->isSMTP();
// 		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
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
		
// 	}

?>