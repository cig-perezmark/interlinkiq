<?php 

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require '../database.php';
    
    $ouput = '';
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    } else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    }
    
    $enterprise_id = $user_id;
    $status = 'Manual';
    $flag = 1;
    $campaign_status = 2;
    $send_status = 1;
    $method = "AES-256-CBC";
    $key = "interlink";
    $options = 0;
    $iv = '1234567891011121';
    $token = time();
    $pageUrl =  "http://" . $_SERVER['SERVER_NAME'];
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageUrl = "https://" . $_SERVER['SERVER_NAME'];
    }

    // PHP MAILER FUNCTION
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';
	
	function php_mailer($from, $to, $user, $subject, $body) {

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
		    $mail->CharSet = 'UTF-8';
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
    
    function employerID($ID) {
    	global $conn;
    
    	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];
    
        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }
    
        return $current_userEmployerID;
    }
    
    function get_name($email) {
        global $conn;
    
        if ($conn === false) {
            return "Database connection error";
        }
    
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM tbl_user WHERE email = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            return "Error preparing statement: " . $conn->error;
        }
    
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            return "Error executing statement: " . $stmt->error;
        }
        $stmt->bind_result($name);
        $stmt->fetch();
        $stmt->close();
    
        return $name;
    }
    
    function format_date($date_str, $format) {
        if (!empty($date_str)) {
            return date($format, strtotime($date_str));
        } else {
            return '';
        }
    }

    if(isset($_POST['get_records'])) {
        $id = $_POST['id'];
        $date = $_POST['date'];

        $stmt = $conn->prepare("SELECT 
                                    DATE_FORMAT(t1.time_in_datetime, '%H:%i') AS in_time, 
                                    DATE_FORMAT(t2.time_in_datetime, '%H:%i') AS out_time,
                                    t1.batch,
                                    t1.notes,
                                    TIMESTAMPDIFF(MINUTE, t1.time_in_datetime, t2.time_in_datetime) AS minutes_span
                                FROM 
                                    tbl_timein t1
                                JOIN 
                                    tbl_timein t2
                                ON 
                                    t1.batch = t2.batch
                                    AND t1.action = 'IN'
                                    AND t2.action = 'OUT'
                                    AND t1.user_id = ?
                                    AND t2.user_id = ?
                                WHERE 
                                    DATE(t1.time_in_datetime) = ?
                                    AND DATE(t2.time_in_datetime) = ?
                                ORDER BY 
                                    t1.batch");
       if($stmt === false) {
            echo json_encode(['error' => 'Error preparing statement: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param('iiss', $id, $id, $date, $date);
        $stmt->execute();

        $result = $stmt->get_result();
        $records = [];
        
        while($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        $stmt->close();
        echo json_encode($records);
    }
