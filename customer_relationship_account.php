<?php
include 'database.php';
	// add New Message
if (isset($_POST['btnacct_submit'])) {  
    $userID = $_COOKIE['ID']; 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y/m/d h:i:s');
    $from = $_POST['from'];
    $account_rep = mysqli_real_escape_string($conn,$_POST['account_rep']);
    $account_name = mysqli_real_escape_string($conn,$_POST['account_name']);
    $parent_account = mysqli_real_escape_string($conn,$_POST['parent_account']);
    $account_status = mysqli_real_escape_string($conn,$_POST['account_status']);
    $account_email = mysqli_real_escape_string($conn,$_POST['account_email']);
    $account_phone = mysqli_real_escape_string($conn,$_POST['account_phone']);
    $account_fax = mysqli_real_escape_string($conn,$_POST['account_fax']);
    $account_address = mysqli_real_escape_string($conn,$_POST['account_address']);
    $account_country = mysqli_real_escape_string($conn,$_POST['account_country']);
    $contact_name = mysqli_real_escape_string($conn,$_POST['contact_name']);
    $contact_title = mysqli_real_escape_string($conn,$_POST['contact_title']);
    $contact_report = mysqli_real_escape_string($conn,$_POST['contact_report']);
    $contact_email = mysqli_real_escape_string($conn,$_POST['contact_email']);
    $contact_phone = mysqli_real_escape_string($conn,$_POST['contact_phone']);
    $contact_fax = mysqli_real_escape_string($conn,$_POST['contact_fax']);
    $contact_address = mysqli_real_escape_string($conn,$_POST['contact_address']);
    $contact_website = mysqli_real_escape_string($conn,$_POST['contact_website']);
    $contact_interlink = mysqli_real_escape_string($conn,$_POST['contact_interlink']);
    $contact_facebook = mysqli_real_escape_string($conn,$_POST['contact_facebook']);
    $contact_twitter = mysqli_real_escape_string($conn,$_POST['contact_twitter']);
    $contact_linkedin = mysqli_real_escape_string($conn,$_POST['contact_linkedin']);
    $account_product = mysqli_real_escape_string($conn,$_POST['account_product']);
    $account_service = mysqli_real_escape_string($conn,$_POST['account_service']);
    $account_industry = mysqli_real_escape_string($conn,$_POST['account_industry']);
    $account_certification = mysqli_real_escape_string($conn,$_POST['account_certification']);
    $account_category = mysqli_real_escape_string($conn,$_POST['account_category']);
    $account_website = mysqli_real_escape_string($conn,$_POST['account_website']);
    $account_facebook = mysqli_real_escape_string($conn,$_POST['account_facebook']);
    $account_twitter = mysqli_real_escape_string($conn,$_POST['account_twitter']);
    $account_linkedin = mysqli_real_escape_string($conn,$_POST['account_linkedin']);
    $account_interlink = mysqli_real_escape_string($conn,$_POST['account_interlink']);
    $Account_Source = mysqli_real_escape_string($conn,$_POST['Account_Source']);
    $mutiple_added = 0;
    
    $to = $_POST['account_email'];
	$user = 'interlinkiq.com';
	$subject = 'Invitation to Connect via InterlinkIQ.com';
	$body = '<p>Hello '.$_POST['account_name'].',<br><br>
	
        You are cordially invited to join <a href="https://interlinkiq.com/">InterlinkIQ.com</a> to connect with customers and suppliers.<br>
InterlinkIQ connectivity allows you to offer products, services, and share documents with customers, suppliers, contacts, and employees.
        <br><br>
        IntelinkIQ.com</p>';

	$mail = php_mailer($from, $to, $user, $subject, $body);
	
    $sql = "INSERT INTO tbl_Customer_Relationship(account_rep,
                                                    account_name,parent_account,
                                                    account_status,
                                                    account_email,
                                                    account_phone,
                                                    account_fax,
                                                    account_address,
                                                    account_country,
                                                    account_website,
                                                    account_facebook,
                                                    account_twitter,
                                                    account_linkedin,
                                                    account_interlink,
                                                    contact_name,
                                                    contact_title,
                                                    contact_report,
                                                    contact_email,
                                                    contact_phone,
                                                    contact_fax,
                                                    contact_address,
                                                    contact_website,
                                                    contact_facebook,
                                                    contact_twitter,
                                                    contact_linkedin,
                                                    contact_interlink,
                                                    account_product,
                                                    account_service,
                                                    account_industry,
                                                    account_certification,
                                                    account_category,
                                                    Account_Source,
                                                    userID,
                                                    mutiple_added,
                                                    crm_date_added
                                                ) 
                                            VALUES ('$account_rep',
                                                    '$account_name',
                                                    '$parent_account',
                                                    '$account_status',
                                                    '$account_email',
                                                    '$account_phone',
                                                    '$account_fax',
                                                    '$account_address',
                                                    '$account_country',
                                                    '$account_website',
                                                    '$account_facebook',
                                                    '$account_twitter',
                                                    '$account_linkedin',
                                                    '$account_interlink',
                                                    '$contact_name',
                                                    '$contact_title',
                                                    '$contact_report',
                                                    '$contact_email',
                                                    '$contact_phone',
                                                    '$contact_fax',
                                                    '$contact_address',
                                                    '$contact_website',
                                                    '$contact_facebook',
                                                    '$contact_twitter',
                                                    '$contact_linkedin',
                                                    '$contact_interlink',
                                                    '$account_product',
                                                    '$account_service',
                                                    '$account_industry',
                                                    '$account_certification',
                                                    '$account_category',
                                                    '$Account_Source',
                                                    '$userID',
                                                    '$mutiple_added',
                                                    '$today'
                                            )";
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
		  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		    $mail->Host       = 'interlinkiq.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'admin@interlinkiq.com';
		    $mail->Password   = 'L1873@2019new';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    //$mail->setFrom($from, $user);
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
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
