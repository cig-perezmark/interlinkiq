<?php
require_once('../database.php');
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
// Insert data to tbl_jobs
    if(isset($_POST['save'])){    
        $userId=$_COOKIE['ID'];
        $jobtitle=$_POST['jobtitle'];
        $jobdescription=$_POST['jobdescription'];
        $jobskills=$_POST['jobskills'];
        $jobstatus=$_POST['jobstatus'];
        $location=$_POST['location'];
        $isworldwide=$_POST['isworldwide'];
        $jobsalary=$_POST['jobsalary'];        
        $sql="INSERT INTO `tbl_jobs` (`id`, `userId`,`title`, `description`, `skill`, `status`, `location`, `isworldwide`, `salary`, `isactive`, `createdat`, `lastmodified`) VALUES (NULL,'$userId', '$jobtitle', '$jobdescription', '$jobskills', '$jobstatus', '$location', '$isworldwide', '$jobsalary', '1', current_timestamp(), NULL)";
        $message='Success';
        $result=$conn->query($sql);
        if($result){
           echo ('success');
        }
        else{
           echo $conn->error;
       }		
    }
    //update
    if(isset($_POST['edit'])){
        $id = $_POST['jobid'];
        $jobtitle=$_POST['jobtitle'];
        $jobdescription=$_POST['jobdescription'];
        $jobskills=$_POST['jobskills'];
        $jobstatus=$_POST['jobstatus'];
        $location=$_POST['location'];
        $isworldwide=$_POST['isworldwide'];
        $jobsalary=$_POST['jobsalary'];
        $sql="UPDATE tbl_jobs SET title='$jobtitle' ,description='$jobdescription',skill='$jobskills',status='$jobstatus', location='$location' , isworldwide='$isworldwide', salary ='$jobsalary', lastmodified=(select now()) WHERE id = $id";
        $result=$conn->query($sql);
        if($result){
           echo ('success');
        }
        else{
           echo $conn->error;
       }
    }
    //find id
    if(isset($_POST['find'])){
        $id=$_POST['id'];
        $sql="SELECT * from tbl_jobs where id=".$id;
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_array($result);
        echo json_encode($row);
    }
    //fetch all data
    if(isset($_POST['fetchwithUser'])){
        $sql="SELECT * from tbl_jobs where userId=".$_COOKIE['ID'];
        $message='Success';
        $output="";
        $result=$conn->query($sql);
        if(mysqli_num_rows($result) > 0){
           $rowData =mysqli_fetch_all($result,MYSQLI_ASSOC);
            echo json_encode($rowData);           
        }
        else{
           echo $conn->error;
       }
    }
    
      if(isset($_POST['fetch'])){
        $sql="SELECT * from tbl_jobs";
        $message='Success';
        $output="";
        $result=$conn->query($sql);
        if(mysqli_num_rows($result) > 0){
           $rowData =mysqli_fetch_all($result,MYSQLI_ASSOC);
            echo json_encode($rowData);           
        }
        else{
           echo $conn->error;
       }
    }
    
    //get current date and time from the server
    if(isset($_POST['date'])){
        $currentDate="";
        foreach($conn->query('SELECT NOW()') as $row) {
                    $currentDate=$row['NOW()'];
                }
                echo json_encode($currentDate);
   }
   if(isset($_POST['getUserType'])){
       if($_COOKIE['ID']!=null){
        //$id=$_POST['id'];
        $sql="SELECT type from tbl_user where id=".$_COOKIE['ID'];
        $result=mysqli_query($conn, $sql);
        //// echo $result;
        $row = mysqli_fetch_array($result);
        echo json_encode($row);
       }
       else{
           echo json_encode(null);
       }
   }
   if(isset($_POST['getID'])){
    $id=$_COOKIE['ID'];
    echo json_encode($id);
   }
   if(isset($_POST['appLetter'])){
    $currentDate="";
    foreach($conn->query('SELECT NOW()') as $row) {
        $currentDate=$row['NOW()'];
    }
    $appLetter=$_POST['appLetter'];
    $uId=$_COOKIE['ID'];
    $jobId=$_POST['jobId'];
    $jobUserId=$_POST['jobuserId'];
    $email=$_POST['email'];
    $cleanDate=clean($currentDate).'-'.$uId.$jobId;
    $target_directory="files/";
    $target_file=$target_directory.basename($_FILES['file']['name']);
    $filetype=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $newfilename=$target_directory.$cleanDate.'.'.$filetype;
    $getFilename=$newfilename;
    move_uploaded_file($_FILES['file']['tmp_name'], $getFilename);
         $sql="INSERT INTO `tbl_applicant` (`id`, `appLetter`, `job_id`, `user_id`, `file`, `date_applied`, `status`) VALUES (NULL, '$appLetter', '$jobId', '$uId', '$getFilename',current_timestamp(), 1)";
         $message='Success';
         $result=$conn->query($sql);
         echo json_encode("Saved");
       //echo json_encode( getEmail($jobId)."jobid");
    
   }
    if(isset($_POST['jobuserid'])){
        $appLetter=$_POST['appLetter'];
        $id=$_POST['id'];
        $sql="SELECT `email` FROM `tbl_user` WHERE `ID`=".$id;
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_array($result);
        $to = $row["email"];
		$subject = 'New Job Applicant';
		$body = $appLetter;
        $mail=php_mailer($to, $user, $subject, $body);

        echo json_encode("Success");
    }
    
    
   function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }
 
 function php_mailer($to, $user, $subject, $body) {

		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);

		try {
		    $mail->isSMTP();
		    $mail->Host       = 'mail.prpblaster.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'fsms@prpblaster.com';
		    $mail->Password   = 'Brandon@2020';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		    $mail->Port       = 465;
		    $mail->setFrom('fsms@prpblaster.com', 'FSMS');

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
	
    if(isset($_POST['country'])){
        $data=file_get_contents("asset/data_json.json");
        echo ($data);
    }

?>