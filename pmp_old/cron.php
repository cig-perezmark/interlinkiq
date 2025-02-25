<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    include 'connection/config.php';
    
   	date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d', time());
    $sql1 = "SELECT * FROM parts_maintainance " ;
    $result1 = mysqli_query ($conn, $sql1);
    while($row1 = mysqli_fetch_array($result1))
    {
    	 if($date == $row1['next_maintainance']){
    	     $next_maint = $row1['next_maintainance'];
    	    $sql = "SELECT * FROM parts_maintainance WHERE  next_maintainance = '$next_maint'" ;
            $result = mysqli_query ($conn, $sql);
            foreach($result as $row){
                $job_no = $row['job_no'];
                $assignee = $row['assignee'];
                $date = $row['next_maintainance'];
                
                    $to = 'mjtayros21@gmail.com';
                    $subject = 'Preventive Maintenance Shedule - '.$date.'';
                    $from = 'pmp@consultareinc.com';
                     
                    // To send HTML mail, the Content-type header must be set
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                     
                    // Create email headers
                    $headers .= 'From: '.$from."\r\n".
                        'Reply-To: '.$from."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                     
                    // Compose a simple HTML email message
                    $message = '<html><body>';
                    $message .= '<p>Hi '.$assignee.',<br>Please perform the equipment parts forklift hand of forklift with the job no of '.$job_no.'<p> <br>';
                    $message .= '<p>Link: <a href="http://prpblaster.com/pmp/maintenance_checklist.php">http://prpblaster.com/pmp/maintenance_checklist.php</a> <p>';
                    $message .= '</body></html>';
                     
                    // Sending email
                    if(mail($to, $subject, $message, $headers)){
                        echo 'Your mail has been sent successfully.';
                    } else{
                        echo 'Unable to send email. Please try again.';
                    }
    	}    }
    }
    
    
    


?>
