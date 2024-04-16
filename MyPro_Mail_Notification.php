<?php
include 'database.php';
$base_url = "https://interlinkiq.com/";
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// Mail History
	if( isset($_GET['modalHistory_Notification']) ) {
		$ID = $_GET['modalHistory_Notification'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
		            
		           <div class="form-group">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Body</th>
                                    <th>To</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                ';
                                  
                                    $queryFrom = "SELECT * FROM tbl_MyProject_Services_Mail where Projects_id = $ID";
                                    $resultFrom = mysqli_query($conn, $queryFrom);
                                    while($rowFrom = mysqli_fetch_array($resultFrom))
                                         { 
                                           echo '<tr>
                                                    <td>'.$rowFrom['Sender'].'</td>
                                                    <td>'.$rowFrom['Mail_Subject'].'</td>
                                                    <td>'; 
                                                        $content = strip_tags($rowFrom['Mail_body']); 
                                                         echo str_replace('Click here...','',$content);
                                                        echo'
                                                    </td>
                                                    <td>'.$rowFrom['Sent_to'].'</td>
                                                    <td>'.$rowFrom['Mail_Date'].'</td>
                                                </tr>
                                           '; 
                                       } 
                                 echo '
                            </tbody>
                        <table>
                    </div>
                </div>
            	
	        	';
        }
// Mailing
	if( isset($_GET['modalAdd_Notification']) ) {
		$ID = $_GET['modalAdd_Notification'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
		           <div class="form-group">
                    <div class="col-md-12">
                        <label>From</label>
                    </div>
                    <div class="col-md-12">
                            ';
                                $sender = $_COOKIE['ID'];
                                $queryFrom = "SELECT * FROM tbl_user where ID = $sender";
                                $resultFrom = mysqli_query($conn, $queryFrom);
                                while($rowFrom = mysqli_fetch_array($resultFrom))
                                     { 
                                       echo '<input class="form-control" name="from" value="'.$rowFrom['email'].'" readonly>'; 
                                   } 
                             echo '
                    </div>
                </div>
            		<div class="form-group">
                    <div class="col-md-12">
                        <label>Send to</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control mt-multiselect btn btn-default" type="text" name="sent_to" required>
                            <option value="">---Select---</option>
                            ';
                                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                 { 
                                   echo '<option value="'.$rowAssignto['email'].'" >'.$rowAssignto['first_name'].' ('.$rowAssignto['email'].')</option>'; 
                               } 
                             echo '
                        </select>
                    </div>
                </div>
	        	';
                    $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                $resultType = mysqli_query($conn, $queryType);
                while($rowType = mysqli_fetch_array($resultType))
                     { 
                       echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="'.$rowType['Parent_MyPro_PK'].'" >';
                       echo '<input type="hidden" class="form-control" name="Services_History_PK" value="'.$rowType['Services_History_PK'].'" >'; 
                   } 
                         echo '
                         <div class="form-group">
                            <div class="col-md-12">
                                <label>Subject</label>
                            </div>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="subject" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Body</label>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="body" id="your_summernotes" rows="8" required></textarea>
                            </div>
                        </div>
            
                        ';
        }
        
	if( isset($_POST['btnSave_Notification']) ) {
		$userID = $_COOKIE['ID']; 
        $project = mysqli_real_escape_string($conn,$_POST['ID']);
        $from = mysqli_real_escape_string($conn,$_POST['from']);
        $to = $_POST['sent_to'];
        $querySend= "SELECT * FROM tbl_hr_employee where email = '$to'";
            $resultSend = mysqli_query($conn, $querySend);
            while($rowSend = mysqli_fetch_array($resultSend)){
                $name = $rowSend['first_name'];
            }
    	$user = 'InterlinkIQ.com';
    	$subject = mysqli_real_escape_string($conn,$_POST['subject']);
    	$body = '<p>
    	        Hi '.$name.',<br><br>
    	        '.$_POST['body'].'
    	        <br><br><a class="btn btn-info" href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project.'" target="_blank">Click here</a>';
    
    	$mail = php_mailer($from, $to, $user, $subject, $body);

 		$sql = "INSERT INTO tbl_MyProject_Services_Mail (Projects_id,Sender,Sent_to,Mail_Subject,Mail_body,user_perform)
 		VALUES ('$project','$from','$to','$subject','$body','$userID')";
 		if (mysqli_query($conn, $sql)) {
		
 		}
 		else{
 		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
 		    echo $message;
 		}
 		mysqli_close($conn);
 		echo json_encode($output);
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
$conn->close();
?>