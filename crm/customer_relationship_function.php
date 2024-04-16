<?php
include '../database.php';

// PHP MAILER FUNCTION
	use \PHPMailer\PHPMailer\PHPMailer;
	use \PHPMailer\PHPMailer\SMTP;
	use \PHPMailer\PHPMailer\Exception;
	function php_mailer($to, $user, $subject, $body) {
		require '../PHPMailer/src/Exception.php';
		require '../PHPMailer/src/PHPMailer.php';
		require '../PHPMailer/src/SMTP.php';

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
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
		    $mail->addAddress($to, $user);
            $mail->addReplyTo('services@interlinkiq.com', 'Interlink IQ');
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
	
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// add New Collaborator
if (isset($_POST['btn_Collab'])) {  
    
    if(!empty($_POST['as_editor'])){
        $userID = $_COOKIE['ID'];
        $ccrm_id = mysqli_real_escape_string($conn,$_POST['ID']);
        $invite_mail = mysqli_real_escape_string($conn,$_POST['invite_mail']);
        $body_content = mysqli_real_escape_string($conn,$_POST['body_content']);
        $as_editor = mysqli_real_escape_string($conn,$_POST['as_editor']);
        
        $sql = "INSERT INTO tbl_Customer_Relationship_collaboration(invite_mail,body_content,as_editor,ccrm_id,user_cookies) VALUES ('$invite_mail','$body_content','$as_editor','$ccrm_id','$userID')";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../Customer_Relationship_Management";</script>';
        }
    }
    else{
        $userID = $_COOKIE['ID'];
        $ccrm_id = mysqli_real_escape_string($conn,$_POST['ID']);
        $invite_mail = mysqli_real_escape_string($conn,$_POST['invite_mail']);
        $body_content = mysqli_real_escape_string($conn,$_POST['body_content']);
        $as_editor = 0;
        
        $sql = "INSERT INTO tbl_Customer_Relationship_collaboration(invite_mail,body_content,as_editor,ccrm_id,user_cookies) VALUES ('$invite_mail','$body_content','$as_editor','$ccrm_id','$userID')";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../Customer_Relationship_Management";</script>';
        }
    }
    
}

// add New Customer Relationship
if (isset($_POST['btnacct_submit'])) {  
    $userID = $_COOKIE['ID'];
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
    
    
    $sql = "INSERT INTO tbl_Customer_Relationship(account_name,parent_account,account_status,account_email,account_phone,account_fax,account_address,account_country,contact_name,contact_title,contact_report,contact_email,contact_phone,contact_fax,contact_address,contact_website,contact_facebook,contact_twitter,contact_linkedin,contact_interlink,account_product,account_service,account_industry,account_certification,account_category,userID) VALUES ('$account_name','$parent_account','$account_status','$account_email','$account_phone','$account_fax','$account_address','$account_country','$contact_name','$contact_title','$contact_report','$contact_email','$contact_phone','$contact_fax','$contact_address','$contact_website','$contact_facebook','$contact_twitter','$contact_linkedin','$contact_interlink','$account_product','$account_service','$account_industry','$account_certification','$account_category','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../Customer_Relationship_Management";</script>';
    }
}

// Update Customer Relationship Account
if (isset($_POST['update_detail_account'])) {
    
   $old_status = $_POST['old_status'];
    $current_status = $_POST['account_status'];
    
    if (strtolower($old_status) != strtolower($current_status)) {
        $contact_id = $_POST['ids'];
        $userid = $_COOKIE['ID'];
        $performed_by = $_COOKIE['first_name']. ' ' . $_COOKIE['last_name'];
        $customer = $_POST['account_name'];
        $action = $customer . ' status has been changed from ' . $old_status . ' to ' . $current_status;
    
        $sql = "INSERT INTO tbl_crm_history_data (contact_id, user_id, performer_name, action_taken) VALUES ('$contact_id', '$userid', '$performed_by', '$action')";
        $result = mysqli_query($conn, $sql);
    
        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
    }
    
    if(!empty($_POST['Account_Directory'])){
            $userID = $_COOKIE['ID'];
            $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
            $account_rep = mysqli_real_escape_string($conn,$_POST['account_rep']);
            $account_name = mysqli_real_escape_string($conn,$_POST['account_name']);
            $parent_account = mysqli_real_escape_string($conn,$_POST['parent_account']);
            $account_status = mysqli_real_escape_string($conn,$_POST['account_status']);
            $account_email = mysqli_real_escape_string($conn,$_POST['account_email']);
            $account_phone = mysqli_real_escape_string($conn,$_POST['account_phone']);
            $account_fax = mysqli_real_escape_string($conn,$_POST['account_fax']);
            $account_address = mysqli_real_escape_string($conn,$_POST['account_address']);
            $account_country = mysqli_real_escape_string($conn,$_POST['account_country']);
            $account_website = mysqli_real_escape_string($conn,$_POST['account_website']);
            $account_interlink = mysqli_real_escape_string($conn,$_POST['account_interlink']);
            $account_facebook = mysqli_real_escape_string($conn,$_POST['account_facebook']);
            $account_twitter = mysqli_real_escape_string($conn,$_POST['account_twitter']);
            $account_linkedin = mysqli_real_escape_string($conn,$_POST['account_linkedin']);
            
            $Account_Source = mysqli_real_escape_string($conn,$_POST['Account_Source']);
            $Account_Directory = mysqli_real_escape_string($conn,$_POST['Account_Directory']);
            
            
            $sql = "UPDATE tbl_Customer_Relationship SET 
                account_rep = '$account_rep',
                Account_Source= '$Account_Source',
                account_name = '$account_name',
                parent_account = '$parent_account',
                account_category = '$account_status',
                account_email = '$account_email',
                account_phone = '$account_phone',
                account_fax = '$account_fax',
                account_address = '$account_address',
                account_country = '$account_country',
                account_website = '$account_website',
                account_interlink = '$account_interlink',
                account_facebook = '$account_facebook',
                account_twitter = '$account_twitter',
                account_linkedin = '$account_linkedin',
                Account_Directory = '$Account_Directory' 
            WHERE crm_id = '$crm_ids' ";
            if(mysqli_query($conn, $sql)){
                echo '<script> window.location.href = "../crm_view_details.php?view_id='.$crm_ids.'";</script>';
            }
            else{
                 echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
        }
        else{
            $userID = $_COOKIE['ID'];
            $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
            $account_rep = mysqli_real_escape_string($conn,$_POST['account_rep']);
            $account_name = mysqli_real_escape_string($conn,$_POST['account_name']);
            $parent_account = mysqli_real_escape_string($conn,$_POST['parent_account']);
            $account_status = mysqli_real_escape_string($conn,$_POST['account_status']);
            $account_email = mysqli_real_escape_string($conn,$_POST['account_email']);
            $account_phone = mysqli_real_escape_string($conn,$_POST['account_phone']);
            $account_fax = mysqli_real_escape_string($conn,$_POST['account_fax']);
            $account_address = mysqli_real_escape_string($conn,$_POST['account_address']);
            $account_country = mysqli_real_escape_string($conn,$_POST['account_country']);
            $account_website = mysqli_real_escape_string($conn,$_POST['account_website']);
            $account_interlink = mysqli_real_escape_string($conn,$_POST['account_interlink']);
            $account_facebook = mysqli_real_escape_string($conn,$_POST['account_facebook']);
            $account_twitter = mysqli_real_escape_string($conn,$_POST['account_twitter']);
            $account_linkedin = mysqli_real_escape_string($conn,$_POST['account_linkedin']);
            
            $Account_Source = mysqli_real_escape_string($conn,$_POST['Account_Source']);
            $Account_Directory = 0;
            
            
            // account_status = '$account_status',
            $sql = "UPDATE tbl_Customer_Relationship SET
                        account_rep = '$account_rep',
                        Account_Source= '$Account_Source',
                        account_name = '$account_name',
                        parent_account = '$parent_account',
                        account_category = '$account_status',
                        account_email = '$account_email',
                        account_phone = '$account_phone',
                        account_fax = '$account_fax',
                        account_address = '$account_address',
                        account_country = '$account_country',
                        account_website = '$account_website',
                        account_interlink = '$account_interlink',
                        account_facebook = '$account_facebook',
                        account_twitter = '$account_twitter',
                        account_linkedin = '$account_linkedin',
                        Account_Directory = '$Account_Directory' 
                    WHERE crm_id = '$crm_ids' ";
            if(mysqli_query($conn, $sql)){
                echo '<script> window.location.href = "../crm_view_details.php?view_id='.$crm_ids.'";</script>';
            }
            else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    
}

// Update About
if (isset($_POST['update_about'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $account_about = mysqli_real_escape_string($conn,$_POST['account_about']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship set account_about = '$account_about' where crm_id = '$crm_ids' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#about";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update FSE
if (isset($_POST['update_FSE'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $account_fse = mysqli_real_escape_string($conn,$_POST['account_fse']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship set account_fse = '$account_fse' where crm_id = '$crm_ids' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#fse";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Task Status
if (isset($_POST['update_details_contact_status'])) {  
    $userID = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $Date_Updated   = date("Y-m-d H:i:s");
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $Task_Status = mysqli_real_escape_string($conn,$_POST['Task_Status']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship_Task set Task_Status = '$Task_Status',Date_Updated = '$Date_Updated' where crmt_id = '$ID' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#tasks";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Customer Relationship Contact
if (isset($_POST['update_details_contact'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $account_product = mysqli_real_escape_string($conn,$_POST['account_product']);
    $account_service = mysqli_real_escape_string($conn,$_POST['account_service']);
    $account_industry = mysqli_real_escape_string($conn,$_POST['account_industry']);
    $account_category = mysqli_real_escape_string($conn,$_POST['account_category']);
    $account_certification = mysqli_real_escape_string($conn,$_POST['account_certification']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship set account_product = '$account_product',account_service = '$account_service',account_industry = '$account_industry',account_category = '$account_category',account_certification = '$account_certification' where crm_id = '$crm_ids' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#products";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Customer Relationship Contact2
if (isset($_POST['update_details_contact2'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $contact_name = mysqli_real_escape_string($conn,$_POST['contact_name']);
    $contact_title = mysqli_real_escape_string($conn,$_POST['contact_title']);
    $contact_report = mysqli_real_escape_string($conn,$_POST['contact_report']);
    $contact_address = mysqli_real_escape_string($conn,$_POST['contact_address']);
    $contact_email = mysqli_real_escape_string($conn,$_POST['contact_email']);
    $contact_phone = mysqli_real_escape_string($conn,$_POST['contact_phone']);
    $contact_fax = mysqli_real_escape_string($conn,$_POST['contact_fax']);  
    
    
    $sql = "UPDATE tbl_Customer_Relationship set contact_name = '$contact_name',contact_title = '$contact_title',contact_report = '$contact_report',contact_address = '$contact_address',contact_email = '$contact_email',contact_phone = '$contact_phone',contact_fax = '$contact_fax' where crm_id = '$crm_ids' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#contacts";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add New Task
if (isset($_POST['btntask_submit'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $assign_task = mysqli_real_escape_string($conn,$_POST['assign_task']);
    $Assigned_to = mysqli_real_escape_string($conn,$_POST['Assigned_to']);
    $Task_added = mysqli_real_escape_string($conn,$_POST['Task_added']);
    $Deadline = mysqli_real_escape_string($conn,$_POST['Deadline']);
    
    $sql = "INSERT INTO tbl_Customer_Relationship_Task(assign_task,Assigned_to,Task_added,Deadline,crm_ids,user_cookies) VALUES ('$assign_task','$Assigned_to','$Task_added','$Deadline','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#tasks";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Completed Task
// if(isset($_GET['ids_crmt'])){
//     $ids = $_GET['ids_crmt'];
//      $sql = "INSERT INTO tbl_Customer_Relationship_Task(assign_task,Assigned_to,Task_added,Deadline,crm_ids,user_cookies) VALUES ('$assign_task','$Assigned_to','$Task_added','$Deadline','$crm_ids','$userID')";
//     if(mysqli_query($conn, $sql)){
//         echo '<script> window.location.href = "../customer_relationship_View.php?ids_crmt='.$crm_ids.'#tasks";</script>';
//     }
//     else{
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

// add New Message
if (isset($_POST['btnmail_submit'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $Recipients= mysqli_real_escape_string($conn,$_POST['Recipients']);
    $Subject = mysqli_real_escape_string($conn,$_POST['Subject']);
    $Message_body = mysqli_real_escape_string($conn,$_POST['Message_body']);
    
    $to = $rowUser['Recipients'];
	$user = '';
	$subject = mysqli_real_escape_string($conn,$_POST['Subject']);
	$body = mysqli_real_escape_string($conn,$_POST['Message_body']);

	$mail = php_mailer($to, $user, $subject, $body);
	
    $sql = "INSERT INTO tbl_Customer_Relationship_Mailing(Recipients,Subject,Message_body,crm_ids,user_cookies) VALUES ('$Recipients','$Subject','$Message_body','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#email";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add New Noted
if (isset($_POST['btnnotes_submit'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $Notes_Types = mysqli_real_escape_string($conn,$_POST['Notes_Types']);
    $Title = mysqli_real_escape_string($conn,$_POST['Title']);
    $Notes = mysqli_real_escape_string($conn,$_POST['Notes']);
    
    $sql = "INSERT INTO tbl_Customer_Relationship_Notes(Notes_Types,Title,Notes,crm_ids,user_cookies) VALUES ('$Notes_Types','$Title','$Notes','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#notes";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add New Reference
if (isset($_POST['btnreference_submit'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $Title = mysqli_real_escape_string($conn,$_POST['Title']);
    $Description = mysqli_real_escape_string($conn,$_POST['Description']);
    $Date_Added = mysqli_real_escape_string($conn,$_POST['Date_Added']);
    $Date_End = mysqli_real_escape_string($conn,$_POST['Date_End']);
    
    $file = $_FILES['Documents']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['Documents']['name']));
    $rand = rand(10,1000000);
    $Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['Documents']['tmp_name'],'../Customer_Relationship_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tbl_Customer_Relationship_References(Title,Description,Date_Added,Date_End,Documents,crm_ids,user_cookies) VALUES ('$Title','$Description','$Date_Added','$Date_End','$Documents','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#references";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// add New FSE
if (isset($_POST['btnrfse_submit'])) {  
    $userID = $_COOKIE['ID'];
    $crm_ids = mysqli_real_escape_string($conn,$_POST['crm_ids']);
    $FSE_Title = mysqli_real_escape_string($conn,$_POST['FSE_Title']);
    $FSE_Description = mysqli_real_escape_string($conn,$_POST['FSE_Description']);
    $FSE_Event_Date = mysqli_real_escape_string($conn,$_POST['FSE_Event_Date']);
    $FSE_Source_Link = mysqli_real_escape_string($conn,$_POST['FSE_Source_Link']);
    
    $file = $_FILES['FSE_Documents']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['FSE_Documents']['name']));
    $rand = rand(10,1000000);
    $FSE_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['FSE_Documents']['tmp_name'],'../Customer_Relationship_files_Folder/'.$to_File_Documents);
    
    $sql = "INSERT INTO tbl_Customer_Relationship_FSE(FSE_Title,FSE_Description,FSE_Documents,FSE_Event_Date,FSE_Source_Link,crm_ids,FSE_Addedby) VALUES ('$FSE_Title','$FSE_Description','$FSE_Documents','$FSE_Event_Date','$FSE_Source_Link','$crm_ids','$userID')";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#fse";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Campaign
if (isset($_POST['update_campaign'])) {  
    $userID = $_COOKIE['ID'];
    $ID = mysqli_real_escape_string($conn,$_POST['ID']);
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $Campaign_Name = mysqli_real_escape_string($conn,$_POST['Campaign_Name']);
    $Campaign_Recipients = mysqli_real_escape_string($conn,$_POST['Campaign_Recipients']);
    $Campaign_Subject = mysqli_real_escape_string($conn,$_POST['Campaign_Subject']);
    $Campaign_body = mysqli_real_escape_string($conn,$_POST['Campaign_body']);
    $Frequency = mysqli_real_escape_string($conn,$_POST['Frequency']);
    $Auto_Send_Status = mysqli_real_escape_string($conn,$_POST['Auto_Send_Status']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship_Campaign set Campaign_Name = '$Campaign_Name',Campaign_Recipients = '$Campaign_Recipients',Campaign_Subject = '$Campaign_Subject',Campaign_body = '$Campaign_body',Frequency = '$Frequency',Auto_Send_Status = '$Auto_Send_Status' where Campaign_Id = '$ID' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#campaign";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Greetings
if (isset($_POST['update_greeting'])) {  
    $userID = $_COOKIE['ID'];
    $ID = mysqli_real_escape_string($conn,$_POST['ID']);
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $Campaign_Name = mysqli_real_escape_string($conn,$_POST['Campaign_Name']);
    $Campaign_Recipients = mysqli_real_escape_string($conn,$_POST['Campaign_Recipients']);
    $Campaign_Subject = mysqli_real_escape_string($conn,$_POST['Campaign_Subject']);
    $Campaign_body = mysqli_real_escape_string($conn,$_POST['Campaign_body']);
    $Target_Date = mysqli_real_escape_string($conn,$_POST['Target_Date']);
    $Auto_Send_Status = mysqli_real_escape_string($conn,$_POST['Auto_Send_Status']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship_Campaign set Campaign_Name = '$Campaign_Name',Campaign_Recipients = '$Campaign_Recipients',Campaign_Subject = '$Campaign_Subject',Campaign_body = '$Campaign_body',Target_Date = '$Target_Date',Auto_Send_Status = '$Auto_Send_Status' where Campaign_Id = '$ID' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#campaign";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Update Notes
if (isset($_POST['update_notes'])) {  
    $userID = $_COOKIE['ID'];
    $ID = mysqli_real_escape_string($conn,$_POST['ID']);
    $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
    $Notes_Types = mysqli_real_escape_string($conn,$_POST['Notes_Types']);
    $Notes = mysqli_real_escape_string($conn,$_POST['Notes']);
    $Title = mysqli_real_escape_string($conn,$_POST['Title']);
    
    
    $sql = "UPDATE tbl_Customer_Relationship_Notes set Notes_Types = '$Notes_Types', Notes = '$Notes',Title = '$Title' where notes_id = '$ID' ";
    if(mysqli_query($conn, $sql)){
        echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#notes";</script>';
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Reference
if (isset($_POST['update_reference'])) {
    if(!empty($_FILES['Documents']['name'])){
        $userID = $_COOKIE['ID'];
        $ID = mysqli_real_escape_string($conn,$_POST['ID']);
        $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
        $Title = mysqli_real_escape_string($conn,$_POST['Title']);
        $Description = mysqli_real_escape_string($conn,$_POST['Description']);
        $Date_Added = mysqli_real_escape_string($conn,$_POST['Date_Added']);
        $Date_End = mysqli_real_escape_string($conn,$_POST['Date_End']);
        
        $file = $_FILES['Documents']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['Documents']['name']));
        $rand = rand(10,1000000);
        $Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['Documents']['tmp_name'],'../Customer_Relationship_files_Folder/'.$to_File_Documents);
        
        $sql = "UPDATE tbl_Customer_Relationship_References set Title = '$Title',Description = '$Description',Date_Added = '$Date_Added',Date_End ='$Date_End',Documents = '$Documents' where reference_id = '$ID' ";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#references";</script>';
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{
        $userID = $_COOKIE['ID'];
        $ID = mysqli_real_escape_string($conn,$_POST['ID']);
        $crm_ids = mysqli_real_escape_string($conn,$_POST['ids']);
        $Title = mysqli_real_escape_string($conn,$_POST['Title']);
        $Description = mysqli_real_escape_string($conn,$_POST['Description']);
        $Date_Added = mysqli_real_escape_string($conn,$_POST['Date_Added']);
        $Date_End = mysqli_real_escape_string($conn,$_POST['Date_End']);
        
        
        
        $sql = "UPDATE tbl_Customer_Relationship_References set Title = '$Title',Description = '$Description',Date_Added = '$Date_Added',Date_End ='$Date_End' where reference_id = '$ID' ";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$crm_ids.'#references";</script>';
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
}

// add Projects
if (isset($_POST['btnCreate_Project'])) { 
    if(!empty($_FILES['Sample_Documents']['name'])){
        $userID = $_COOKIE['ID'];
        $cCollaborator = '';
        $view_id = mysqli_real_escape_string($conn,$_POST['view_id']);
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        
       
        
        $file = $_FILES['Sample_Documents']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['Sample_Documents']['name']));
        $rand = rand(10,1000000);
        $Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
         if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
        $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Sample_Documents,Collaborator_PK,user_cookies,Project_status) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$Sample_Documents','$cCollaborator','$userID',0)";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$view_id.'#MyPro";</script>';
        }
    }else{
        $userID = $_COOKIE['ID'];
        $cCollaborator = '';
        $view_id = mysqli_real_escape_string($conn,$_POST['view_id']);
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
            $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Collaborator_PK,user_cookies,Project_status) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$cCollaborator','$userID',0)";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../customer_relationship_View.php?view_id='.$view_id.'#MyPro";</script>';
        }
    }
}
$conn->close();
?>