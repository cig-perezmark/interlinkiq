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
    
    function format_date($date, $format) {
        $timestamp = strtotime($date);
        return date($format, $timestamp);
    }
    
    if(isset($_POST['filter_value'])) { // Filter data through date
        $column = $_POST['column'];
        $value = $_POST['value'];
        $output = '';
        if($column == 'crm_date_added') {
            $sql = "SELECT
                    cr.crm_id, 
                    cr.userID, 
                    cr.account_rep, 
                    cr.account_name, 
                    cr.account_email,  
                    cr.Account_Source, 
                    cr.account_status,
                    cr.contact_phone,
                    cr.enterprise_id,
                    cr.flag,
                    chd.timestamp,
                    chd.performer_name,
                    CONCAT(u.first_name, ' ', u.last_name) AS uploader
                FROM 
                    tbl_Customer_Relationship cr
                LEFT JOIN 
                    (SELECT 
                         contact_id, MAX(history_id) AS max_history_data_id
                     FROM 
                         tbl_crm_history_data
                     GROUP BY 
                         contact_id) latest_history
                ON 
                    cr.crm_id = latest_history.contact_id
                LEFT JOIN 
                    tbl_crm_history_data chd
                ON 
                    latest_history.contact_id = chd.contact_id
                    AND latest_history.max_history_data_id = chd.history_id
                LEFT JOIN 
                    tbl_user u
                ON 
                    chd.user_id = u.ID
                WHERE 
                    LENGTH(account_name) > 0
                    AND crm_date_added >= DATE_SUB(NOW(), INTERVAL $value) AND flag = 1
                    AND cr.enterprise_id = $user_id
                GROUP BY
                    cr.crm_id,
                    cr.userID,
                    cr.account_name,
                    cr.account_email,
                    cr.Account_Source,
                    cr.contact_phone,
                    cr.flag,
                    cr.enterprise_id,
                    cr.account_status
                ORDER BY 
                    cr.crm_date_added DESC";
                
            $result = mysqli_query($conn, $sql);
            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                        $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                        $activity_date = $date ? $date->format('F j, Y') : '';
                        $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                        $output .= '
                        <tr class="contact-row">
                            <td class="text-center">
                                <label class="mt-checkbox '.$checkbox_display.'">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                    <span></span>
                                </label>
                            </td>    
                            <td>'.$row["account_name"].'</td>
                            <td>'.$row["account_email"].'</td>
                            <td>'.$row["contact_phone"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td class="contact-status">'.$status.'</td>
                            <td>'.$activity_date.'</td>
                            <td>'.$row["uploader"].'</td>
                            <td class="text-center">
                                <div class="clearfix">
                                    <div class="btn-group btn-group-solid">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }
                 echo $output;
                }
            }
        } elseif($column == 'account_status') { // Filter data by category/status 
            $sql = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                $column = '$value' AND flag = 1
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
                
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    if($row['enterprise_id'] == $user_id) {
                        $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                        $output .= '
                        <tr class="contact-row">
                            <td class="text-center">
                                <label class="mt-checkbox '.$checkbox_display.'">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                    <span></span>
                                </label>
                            </td>    
                            <td>'.$row["account_name"].'</td>
                            <td>'.$row["account_email"].'</td>
                            <td>'.$row["contact_phone"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td class="contact-status">'.$status.'</td>
                            <td>'.$activity_date.'</td>
                            <td>'.$row["uploader"].'</td>
                            <td class="text-center">
                                <div class="clearfix">
                                    <div class="btn-group btn-group-solid">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }
                }
             echo $output;
            }
        } elseif($column == 'flag') { // Filter data by category/status 
            $sql = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                $column = '$value' AND flag = 0
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
            $result = mysqli_query($conn, $sql);
            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                        $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                        $activity_date = $date ? $date->format('F j, Y') : '';
                        if($row['enterprise_id'] == $user_id) {
                            $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                            $output .= '
                            <tr class="contact-row">
                                <td class="text-center">
                                    <label class="mt-checkbox '.$checkbox_display.'">
                                        <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                        <span></span>
                                    </label>
                                </td>    
                                <td>'.$row["account_name"].'</td>
                                <td>'.$row["account_email"].'</td>
                                <td>'.$row["contact_phone"].'</td>
                                <td>'.$row["Account_Source"].'</td>
                                <td><span class="font-red">Archived</span></td>
                                <td>'.$activity_date.'</td>
                                <td>'.$row["uploader"].'</td>
                                <td class="text-center">
                                    <div class="clearfix">
                                        <div class="btn-group btn-group-solid">
                                            <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                            <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                            <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>';
                        }
                    }
                 echo $output;
                }
            }
        }
    }
    
    if(isset($_POST['filter_range'])) {  // filter contacts by date ranges
        $from = $_POST['from'];
        $from_date = date_create($from);
        $rfrom = date_format($from_date, "Y-m-d");
        $output = '';
        $to = $_POST['to'];
        $to_date = date_create($to);
        $rto = date_format($to_date, "Y-m-d");
        $sql = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                crm_date_added BETWEEN ? AND ? AND flag = 1
                AND cr.enterprise_id = $user_id
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
    
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $rfrom, $rto);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
            echo $output;
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    if(isset($_POST['query'])) { // get all contact
        $output = '';
        // $employeeid = $_COOKIE['ID'];
        
            // AND cr.crm_date_added >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
        $employeeid = $_COOKIE['ID'];
        $query = "SELECT
            cr.crm_id, 
            cr.userID, 
            cr.account_rep, 
            cr.account_name, 
            cr.account_email,  
            cr.Account_Source, 
            cr.account_status,
            cr.contact_phone,
            cr.enterprise_id,
            cr.flag,
            chd.timestamp,
            chd.performer_name,
            CONCAT(u.first_name, ' ', u.last_name) AS uploader
        FROM 
            tbl_Customer_Relationship cr
        LEFT JOIN 
            (SELECT 
                 contact_id, MAX(history_id) AS max_history_data_id
             FROM 
                 tbl_crm_history_data
             GROUP BY 
                 contact_id) latest_history
        ON 
            cr.crm_id = latest_history.contact_id
        LEFT JOIN 
            tbl_crm_history_data chd
        ON 
            latest_history.contact_id = chd.contact_id
            AND latest_history.max_history_data_id = chd.history_id
        LEFT JOIN 
            tbl_user u
        ON 
            chd.user_id = u.ID
        WHERE 
            LENGTH(cr.account_name) > 0 
            AND cr.enterprise_id = $user_id
            AND cr.userID = $employeeid
        GROUP BY
            cr.crm_id,
            cr.userID,
            cr.account_name,
            cr.account_email,
            cr.Account_Source,
            cr.contact_phone,
            cr.flag,
            cr.enterprise_id,
            cr.account_status
        ORDER BY 
            cr.crm_date_added DESC";
        $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm blue tooltips d-none" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
             echo $output;
            }
        }
    }
    
    if(isset($_POST['search_contact'])) {   // get searched contact by account name
        $output = '';
        $searchValue = $_POST['searchVal'];
        $query = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                account_name LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                AND cr.enterprise_id = $user_id
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
        $result = mysqli_query($conn, $query);
        if($result){
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
             echo $output;
            }   
        }
    }
    
    if(isset($_POST['search_contact_email'])) {  // get searched contact by account email
        $output = '';
        $searchValue = $_POST['searchEmailVal'];
        $query = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                account_email LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                AND cr.enterprise_id = $user_id
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
                
        $result = mysqli_query($conn, $query);
        $output = '';

        $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
             echo $output;
            }
        }
    }
    
    if(isset($_POST['search_contact_phone'])) {   // get searched contact by account phone
        $output = '';
        $searchValue = $_POST['searchPhoneVal'];
        $query = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                contact_phone LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                AND cr.enterprise_id = $user_id
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
                
        $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
             echo $output;
            }
        }
    }
    
    if(isset($_POST['search_contact_source'])) {   // get searched contact by account source
        $output = '';
        $searchValue = $_POST['searchSourceVal'];
        $query = "SELECT
                cr.crm_id, 
                cr.userID, 
                cr.account_rep, 
                cr.account_name, 
                cr.account_email,  
                cr.Account_Source, 
                cr.account_status,
                cr.contact_phone,
                cr.enterprise_id,
                cr.flag,
                chd.timestamp,
                chd.performer_name,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader
            FROM 
                tbl_Customer_Relationship cr
            LEFT JOIN 
                (SELECT 
                     contact_id, MAX(history_id) AS max_history_data_id
                 FROM 
                     tbl_crm_history_data
                 GROUP BY 
                     contact_id) latest_history
            ON 
                cr.crm_id = latest_history.contact_id
            LEFT JOIN 
                tbl_crm_history_data chd
            ON 
                latest_history.contact_id = chd.contact_id
                AND latest_history.max_history_data_id = chd.history_id
            LEFT JOIN 
                tbl_user u
            ON 
                chd.user_id = u.ID
            WHERE 
                Account_Source LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                AND cr.enterprise_id = $user_id
            GROUP BY
                cr.crm_id,
                cr.userID,
                cr.account_name,
                cr.account_email,
                cr.Account_Source,
                cr.contact_phone,
                cr.flag,
                cr.enterprise_id,
                cr.account_status
            ORDER BY 
                cr.crm_date_added DESC";
                
        $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                    $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                    $activity_date = $date ? $date->format('F j, Y') : '';
                    $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                    $output .= '
                    <tr class="contact-row">
                        <td class="text-center">
                            <label class="mt-checkbox '.$checkbox_display.'">
                                <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                <span></span>
                            </label>
                        </td>    
                        <td>'.$row["account_name"].'</td>
                        <td>'.$row["account_email"].'</td>
                        <td>'.$row["contact_phone"].'</td>
                        <td>'.$row["Account_Source"].'</td>
                        <td class="contact-status">'.$status.'</td>
                        <td>'.$activity_date.'</td>
                        <td>'.$row["uploader"].'</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                    <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                    <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
             echo $output;
            }
        }
    }
    
    if(isset($_POST['filter_campaign'])) {  // Filter data through campaign date
        $slug = $_POST['slug'];
        $output = '';
        if($slug == 'has_campaign') {
            $sql = "SELECT
                    cr.crm_id, 
                    cr.userID, 
                    cr.account_rep, 
                    cr.account_name, 
                    cr.account_email,  
                    cr.Account_Source, 
                    cr.account_status,
                    cr.contact_phone,
                    cr.enterprise_id,
                    cr.flag,
                    chd.timestamp,
                    chd.performer_name,
                    CONCAT(u.first_name, ' ', u.last_name) AS uploader,
                    latest_campaign.Campaign_added AS latest_campaign_added
                FROM 
                    tbl_Customer_Relationship cr
                LEFT JOIN 
                    (SELECT 
                         contact_id, MAX(history_id) AS max_history_data_id
                     FROM 
                         tbl_crm_history_data
                     GROUP BY 
                         contact_id) latest_history
                ON 
                    cr.crm_id = latest_history.contact_id
                LEFT JOIN 
                    tbl_crm_history_data chd
                ON 
                    latest_history.contact_id = chd.contact_id
                    AND latest_history.max_history_data_id = chd.history_id
                LEFT JOIN 
                    tbl_user u
                ON 
                    chd.user_id = u.ID
                LEFT JOIN 
                    (SELECT 
                         crm_ids, MAX(Campaign_added) AS Campaign_added
                     FROM 
                         tbl_Customer_Relationship_Campaign
                     GROUP BY 
                         crm_ids) latest_campaign
                ON 
                    cr.crm_id = latest_campaign.crm_ids
                WHERE 
                    LENGTH(cr.account_name) > 0
                    AND LENGTH(latest_campaign.Campaign_added) > 0 
                    AND cr.flag = 1
                    AND cr.enterprise_id = $user_id
                GROUP BY
                    cr.crm_id,
                    cr.userID,
                    cr.account_name,
                    cr.account_email,
                    cr.Account_Source,
                    cr.contact_phone,
                    cr.flag,
                    cr.enterprise_id,
                    cr.account_status,
                    latest_campaign.Campaign_added
                ORDER BY 
                    cr.crm_date_added DESC";  
            $result = mysqli_query($conn, $sql);
            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                        $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                        $activity_date = $date ? $date->format('F j, Y') : '';
                        $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                        $output .= '
                        <tr class="contact-row">
                            <td class="text-center">
                                <label class="mt-checkbox '.$checkbox_display.'">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                    <span></span>
                                </label>
                            </td>    
                            <td>'.$row["account_name"].'</td>
                            <td>'.$row["account_email"].'</td>
                            <td>'.$row["contact_phone"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td class="contact-status">'.$status.'</td>
                            <td>'.$activity_date.'</td>
                            <td>'.$row["uploader"].'</td>
                            <td class="text-center">
                                <div class="clearfix">
                                    <div class="btn-group btn-group-solid">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                        <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }
                 echo $output;
                }
            }
        } elseif($slug == 'no_campaign') { // Filter data by category/status 
            $sql = "SELECT
                        cr.crm_id, 
                        cr.userID, 
                        cr.account_rep, 
                        cr.account_name, 
                        cr.account_email,  
                        cr.Account_Source, 
                        cr.account_status,
                        cr.contact_phone,
                        cr.enterprise_id,
                        cr.flag,
                        cr.crm_date_added,
                        CONCAT(u.first_name, ' ', u.last_name) AS uploader,
                        MAX(crc.Campaign_added) AS latest_campaign_added,
                        chd.timestamp AS activity_timestamp,
                        chd.performer_name AS activity_performer
                    FROM 
                        tbl_Customer_Relationship cr
                    LEFT JOIN 
                        tbl_Customer_Relationship_Campaign crc ON cr.crm_id = crc.crm_ids
                    LEFT JOIN 
                        tbl_user u ON crc.userID = u.ID
                    LEFT JOIN 
                        tbl_crm_history_data chd ON cr.crm_id = chd.contact_id
                    WHERE 
                        cr.flag = 1
                        AND cr.enterprise_id = $user_id
                        AND crc.Campaign_added IS NULL -- Condition to filter out rows with no campaign
                    GROUP BY
                        cr.crm_id, 
                        cr.userID, 
                        cr.account_rep, 
                        cr.account_name, 
                        cr.account_email,  
                        cr.Account_Source, 
                        cr.contact_phone,
                        cr.flag,
                        cr.enterprise_id,
                        cr.crm_date_added,
                        cr.account_status,
                        chd.timestamp,
                        chd.performer_name
                    ORDER BY 
                        cr.crm_date_added";
            $result = mysqli_query($conn, $sql);
            if($result) {
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        $status = ($row['flag'] == 1) ? $row["account_status"] : '<span class="font-red">Archived</span>';
                        $date = isset($row['timestamp']) ? new DateTime($row['timestamp']) : null;
                        $activity_date = $date ? $date->format('F j, Y') : '';
                        $checkbox_display = ($row['flag'] != 0 && $row['account_status'] != "Manual") ? '' : 'd-none';
                        $activity_performer = null;
                        if (!empty($row['latest_campaign_added'])) {
                            $activity_performer = $row['activity_performer']; // Set performer from the database
                        }

                        $output .= '
                        <tr class="contact-row">
                            <td class="text-center">
                                <label class="mt-checkbox '.$checkbox_display.'">
                                    <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$row["crm_id"].'"/>
                                    <span></span>
                                </label>
                            </td>    
                            <td>'.$row["account_name"].'</td>
                            <td>'.$row["account_email"].'</td>
                            <td>'.$row["contact_phone"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td class="contact-status">'.$status.'</td>
                            <td>'.$activity_date.'</td>
                            <td>'.$activity_performer.'</td>
                            <td class="text-center">
                                <div class="clearfix">
                                    <div class="btn-group btn-group-solid">
                                        <a class="btn btn-sm blue tooltips" data-original-title="Add Task" href="customer_relationship_View.php?view_id='.$row['crm_id'].'"><i class="icon-eye"></i> View</a>
                                        <a class="btn btn-sm red tooltips delete_contact d-none" id="'.$row['crm_id'].'"><i class="icon-trash"></i></a>
                                        <a class="btn btn-sm red tooltips activity-history" id="'.$row['crm_id'].'" data-toggle="modal" href="#activity-history"><i class="bi bi-activity"></i> Activity</a>
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }
                 echo $output;
                }
            }
        }
    }
    
    if(isset($_POST['get_campaign_message'])) {
        $id = $_POST['id'];
        $sql = "SELECT Campaign_body FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($message);
    
        // Fetch the result
        if ($stmt->fetch()) {
            echo $message;
        } else {
            echo "Campaign not found";
        }
        $stmt->close();
    }
    
    if(isset($_POST['get_email_message'])) {
        $id = $_POST['id'];
        $sql = "SELECT Message_body FROM tbl_Customer_Relationship_Mailing WHERE mail_id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($message);
    
        if ($stmt->fetch()) {
            echo $message;
            if(!empty($message)) {
                echo $message;
            } else {
                echo 'Empty Message Content';
            }
        } else {
            echo "Email not found";
        }
    
        $stmt->close();
    }

    if(isset($_POST['get_history_data'])) { // History
        $contact_id = $_POST['contact_id'];
        $output = '';
        $sql = "SELECT * FROM tbl_crm_history_data WHERE contact_id = $contact_id ORDER BY history_id DESC";
        $result = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($result)) {
            while($row = mysqli_fetch_array($result)) {
                $dateTime = new DateTime($row['updated_at']);
                $formattedDate = $dateTime->format("F d, Y  D, g:i:s A");
                $output .= '
                <tr>
                    <td>'.$row["history_id"].'</td>
                    <td>'.$row["action_taken"].'</td>
                    <td>'.$row["performer_name"].'</td>
                    <td>'.$formattedDate.'</td>
                </tr>';
            }
            echo $output;
        }
    }
    
    if(isset($_POST['add_remarks'])) { // add comment/chat/remarks
        $id = $_POST['contactid'];
        $parentid = $_POST['parentid'];
        $userid = $_COOKIE['ID'];
        $commentator = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
        $action = $_POST['action'];
        $remark = $_POST['message'];
        
        $sql = "INSERT INTO (contact_id,user_id,parent_id,action,commentator,remarks) VALUES ('$id','$userid','$action','$commentator','$remark')";
        $result = mysqli_query($conn,$sql);
        if(!result) {
            die("Query failed: " . mysqli_error($conn));
        }
    }

    if(isset($_POST['get_notification_count'])) { 
        $id = $_POST['contact_id'];
        $sql = "SELECT COUNT(*) FROM tbl_crm_remarks WHERE contact_id = $id AND status = 1";
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            $row = mysqli_fetch_row($result);
            $count = $row[0];
            echo $count;
        } else {
            die("Query failed: " . mysqli_error($conn));
        }
    }
    
    if(isset($_POST['get_crm_remarks'])) { // Message/Chat/Remarks Threads
        $id = $_POST['contact_id'];
        $output = '<ul class="chats">';
        $sql = "SELECT * FROM tbl_crm_remarks WHERE contact_id = $id";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $word = $row['commentator'];
                $dateTime = new DateTime($row['remarked_at']);
                $formattedDate = $dateTime->format(" D g:i A, F d, Y ");
                $type = ($row['user_id'] != $_COOKIE['ID']) ? 'in' : 'out';
                $bg = ($type == 'in') ? 'style="background-color:#e9eff3"' : '';
                $placement = ($type == 'in') ? 'right' : 'left';
                $reply_style = ($type == 'in') ? 'display: flex; justify-content: start; margin-left: 6.3rem; margin-top: 0.3rem;' : 'display: flex; justify-content: end; margin-right: 6.3rem; margin-top: 0.3rem;';
                $areply_style = ($type == 'in') ? 'display: flex; justify-content: start; margin-left: 6.3rem; margin-bottom: 0.3rem; padding: 5px;' : 'display: flex; justify-content: end; margin-right: 6.3rem; margin-bottom: 0.3rem; padding: 5px;';
                $action = (!empty($row['action'])) ? $row['action'] : '';
                $output .= '
                    <li class="' . $type . '">
                        <a class="btn btn-circle btn-icon-only btn-default uppercase avatar">
                            <span style="font-size: 2rem; font-weight: bolder" class="toggler tooltips" data-container="body" data-placement="' . $placement . '" data-html="true" data-original-title="' . $row['commentator'] . '">' . $firstLetter = $word[0] . '</span>
                        </a>
                        <span style="'.$areply_style.'">'.$action.'</span>
                        <div class="message" ' . $bg . '>
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> ' . $row['commentator'] . ' </a>
                            <span class="datetime"> at ' . $formattedDate . ' </span>
                            <span class="body"> ' . $row['remarks'] . ' </span>
                        </div>
                        <a class="replyMessage" data-id="'. $row['remarks_id'] .'" style="'.$reply_style.'">Reply<a>
                    </li>';
            }
            $output .= '</ul>';
            echo $output;
        } else {
            echo '<div class="note note-success">
                    <p><i class="fa fa-exclamation-circle"></i> No Message/Remarks. </p>
                  </div>';
        }
    }
    
    if (isset($_POST['manage_contacts'])) {
        $selectedIds = $_POST['ids'];
        $action = $_POST['action'];
        $updated_by = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
    
        if (!is_array($selectedIds) || empty($selectedIds)) {
            $response = array('status' => 'error', 'message' => 'Invalid or empty IDs array.');
            echo json_encode($response);
            exit;
        }
    
        $idString = implode(',', $selectedIds);
    
        $checkSql = "SELECT crm_id, account_email FROM tbl_Customer_Relationship WHERE crm_id IN ($idString)";
        $checkResult = mysqli_query($conn, $checkSql);
    
        if (!$checkResult) {
            $response = array('status' => 'error', 'message' => 'Error checking IDs: ' . mysqli_error($conn));
            echo json_encode($response);
            exit;
        }
    
        $records = mysqli_fetch_all($checkResult, MYSQLI_ASSOC);
        $missingIds = array_diff($selectedIds, array_column($records, 'crm_id'));
    
        if (!empty($missingIds)) {
            $response = array('status' => 'error', 'message' => 'Some IDs do not exist in the database.');
            echo json_encode($response);
            exit;
        }
    
        if ($action == 'archive') {
            $sql = "UPDATE tbl_Customer_Relationship SET flag = 0, updated_by = ? WHERE crm_id IN ($idString)";
            $response = array('status' => 'success', 'message' => 'Contact moved to archive successfully.');
        } 
        if ($action == 'suspend') {
            $sql = "UPDATE tbl_Customer_Relationship SET flag = 0, updated_by = ? WHERE crm_id IN ($idString)";
            $response = array('status' => 'success', 'message' => 'Contact moved to archive successfully.');
        } 
        if ($action == 'restore') {
            $sql = "UPDATE tbl_Customer_Relationship SET flag = 1, updated_by = ? WHERE crm_id IN ($idString)";
            $response = array('status' => 'success', 'message' => 'Contact restored successfully.');
        }
        if ($action == 'delete') {
            $sql = "DELETE FROM tbl_Customer_Relationship WHERE crm_id IN ($idString)";
            $response = array('status' => 'success', 'message' => 'Contact deleted successfully.');
        } 
        if ($action == 'campaign') {
            $campaign_name = isset($_POST['name']) ? $_POST['name'] : '';
            $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
            $body = isset($_POST['body']) ? $_POST['body'] : '';
            $userID = isset($_COOKIE['ID']) ? $_COOKIE['ID'] : 0;
            $from = isset($_POST['from']) ? $_POST['from'] : '';
            $action_taken = isset($_POST['taken_action']) ? $_POST['taken_action'] : '';
            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
            $send_status = 1;
            $campaign_status = 2;
            $user = 'InterlinkIQ';
            $today = $date_default_tx->format('Y/m/d');
        
            foreach ($records as $data) {
            $sql = "INSERT INTO tbl_Customer_Relationship_Campaign (
                        Campaign_from, 
                        Campaign_Name, 
                        Campaign_Recipients, 
                        Campaign_Subject, 
                        Campaign_body, 
                        Campaign_Status,
                        crm_ids, 
                        Auto_Send_Status,
                        userID) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = mysqli_prepare($conn, $sql);
        
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sssssiiii',
                    $from,
                    $campaign_name,
                    $data['account_email'],
                    $subject,
                    $body,
                    $campaign_status,
                    $data['crm_id'],
                    $send_status,
                    $userID
                );
                if (!mysqli_stmt_execute($stmt)) {
                    $response = array('status' => 'error', 'message' => 'Error executing statement: ' . mysqli_error($conn));
                    echo json_encode($response);
                    exit;
                } else {
                    $mail = php_mailer($from, $data['account_email'], $user, $subject, $body);
                    $last_insert_id = mysqli_insert_id($conn);
                    $action = 'Added new Campaign';
                    $name = $_COOKIE['first_name'] .' '. $_COOKIE['last_name'];
                    $id = $data['crm_id'];
                    $activity = "INSERT INTO tbl_crm_history_data (contact_id, user_id, performer_name, action_taken, type, action_id) VALUES ($id, $userID, '$name', '$action', 1, $last_insert_id)";
                    if (!$mail) {
                       $response = array('status' => 'error', 'message' => 'Error sending email.');
                       echo json_encode($response);
                       exit;
                    } else {
                       // Insert activity here
                       if (!mysqli_query($conn, $activity)) {
                           $response = array('status' => 'error', 'message' => 'Error inserting activity: ' . mysqli_error($conn));
                           echo json_encode($response);
                           exit;
                       }
                    }
                }
                mysqli_stmt_close($stmt);
            } else {
                $response = array('status' => 'error', 'message' => 'Error preparing statement: ' . mysqli_error($conn));
                echo json_encode($response);
                exit;
            }
        }
        
        $response = array('status' => 'success', 'message' => 'Email sent to contacts selected successfully.');
        echo json_encode($response);
        exit;
        }
    
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            $response = array('status' => 'error', 'message' => 'Error preparing statement: ' . mysqli_error($conn));
            echo json_encode($response);
            exit;
        }
    
        if ($action == 'archive' || $action == 'restore') {
            mysqli_stmt_bind_param($stmt, 's', $updated_by);
        }
        
        if (!mysqli_stmt_execute($stmt)) {
            $response = array('status' => 'error', 'message' => 'Error executing statement: ' . mysqli_error($conn));
            echo json_encode($response);
            exit;
        }
        echo json_encode($response);
        mysqli_stmt_close($stmt);
    }
    
    if(isset($_POST['update_details_account'])) {
        $userID = $_COOKIE['ID'];
        $crm_ids = $_POST['ids'];
        $Account_Directory = isset($_POST['Account_Directory']) ? 1 : 0;
        $account_rep = mysqli_real_escape_string($conn, $_POST['account_rep']);
        $Account_Source = mysqli_real_escape_string($conn, $_POST['Account_Source']);
        $account_name = mysqli_real_escape_string($conn, $_POST['account_name']);
        $parent_account = mysqli_real_escape_string($conn, $_POST['parent_account']);
        $account_status = mysqli_real_escape_string($conn, $_POST['account_status']);
        $account_email = mysqli_real_escape_string($conn, $_POST['account_email']);
        $account_phone = mysqli_real_escape_string($conn, $_POST['account_phone']);
        $account_fax = mysqli_real_escape_string($conn, $_POST['account_fax']);
        $account_address = mysqli_real_escape_string($conn, $_POST['account_address']);
        $account_country = mysqli_real_escape_string($conn, $_POST['account_country']);
        $account_website = mysqli_real_escape_string($conn, $_POST['account_website']);
        $account_interlink = mysqli_real_escape_string($conn, $_POST['account_interlink']);
        $account_facebook = mysqli_real_escape_string($conn, $_POST['account_facebook']);
        $account_twitter = mysqli_real_escape_string($conn, $_POST['account_twitter']);
        $account_linkedin = mysqli_real_escape_string($conn, $_POST['account_linkedin']);
    
        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship 
                                SET account_rep = ?,
                                    Account_Source = ?,
                                    account_name = ?,
                                    parent_account = ?,
                                    account_status = ?,
                                    account_email = ?,
                                    account_phone = ?,
                                    account_fax = ?,
                                    account_address = ?,
                                    account_country = ?,
                                    account_website = ?,
                                    account_interlink = ?,
                                    account_facebook = ?,
                                    account_twitter = ?,
                                    account_linkedin = ?,
                                    Account_Directory = ? 
                                WHERE crm_id = ?");
    
        $stmt->bind_param("ssssssssssssssssi", 
                            $account_rep,
                            $Account_Source,
                            $account_name,
                            $parent_account,
                            $account_status,
                            $account_email,
                            $account_phone,
                            $account_fax,
                            $account_address,
                            $account_country,
                            $account_website,
                            $account_interlink,
                            $account_facebook,
                            $account_twitter,
                            $account_linkedin,
                            $Account_Directory,
                            $crm_ids);
    
        if ($stmt->execute()) {
            echo '<script> window.location.href = "../customer_relationship_View.php?view_id=' . $crm_ids . '";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    }
    
    if(isset($_POST['add_contact'])) {  
        $status = null;
        if(empty($_POST['account_status'])) {
            $status = 'In-Active';
        } else {
            $status = $_POST['account_status'];
        }
        $userID = $_COOKIE['ID']; 
        $enterprise_id = $user_id;
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y/m/d h:i:s');
        $from = $_POST['from'];
        $account_rep = $_POST['account_rep'];
        $account_name = $_POST['account_name'];
        $parent_account = $_POST['parent_account'];
        $account_status = $status;
        $account_email = $_POST['account_email'];
        $account_phone = $_POST['account_phone'];
        $account_fax = $_POST['account_fax'];
        $account_address = $_POST['account_address'];
        $account_country = $_POST['account_country'];
        $contact_name = $_POST['contact_name'];
        $contact_title = $_POST['contact_title'];
        $contact_report = $_POST['contact_report'];
        $contact_email = $_POST['contact_email'];
        $contact_phone = $_POST['contact_phone'];
        $contact_fax = $_POST['contact_fax'];
        $contact_address = $_POST['contact_address'];
        $contact_website = $_POST['contact_website'];
        $contact_interlink = $_POST['contact_interlink'];
        $contact_facebook = $_POST['contact_facebook'];
        $contact_twitter = $_POST['contact_twitter'];
        $contact_linkedin = $_POST['contact_linkedin'];
        $account_product = $_POST['account_product'];
        $account_service = $_POST['account_service'];
        $account_industry = $_POST['account_industry'];
        $account_certification = $_POST['account_certification'];
        $account_category = $_POST['account_category'];
        $account_website = $_POST['account_website'];
        $account_facebook = $_POST['account_facebook'];
        $account_twitter = $_POST['account_twitter'];
        $account_linkedin = $_POST['account_linkedin'];
        $account_interlink = $_POST['account_interlink'];
        $Account_Source = $_POST['Account_Source'];
        $mutiple_added = 0;
        
        $to = $_POST['account_email'];
    	$user = 'interlinkiq.com';
    	$subject = 'Invitation to Connect via InterlinkIQ.com';
    	$body = '<p>Hello '.$_POST['account_name'].',<br><br>
    	
            You are cordially invited to join <a href="https://interlinkiq.com/">InterlinkIQ.com</a> to connect with customers and suppliers.<br>
            InterlinkIQ connectivity allows you to offer products, services, and share documents with customers, suppliers, contacts, and employees.
            <br><br>
            IntelinkIQ.com</p>';
    	
    	$checkEmail = 'SELECT COUNT(*) FROM tbl_Customer_Relationship WHERE account_email = ? AND enterprise_id = ?';
    	$checkEmailStmt = mysqli_prepare($conn, $checkEmail);
    	
    	if(!$checkEmailStmt) {
    	    die('Error in preparing statement: ' . mysqli_error($conn));
    	}
    	
    	mysqli_stmt_bind_param($checkEmailStmt, 'si', $account_email, $enterprise_id);
    	mysqli_stmt_execute($checkEmailStmt);
    	mysqli_stmt_bind_result($checkEmailStmt, $email);
    	mysqli_stmt_fetch($checkEmailStmt);
    	mysqli_stmt_close($checkEmailStmt);
    	
    	if(!empty($email)) {
    	    $response = array('status' => 'error', 'message' => 'Email Already Exist');
    	    echo json_encode($response);
    	} else {
    	    $sql = "INSERT INTO 
                    tbl_Customer_Relationship (
                        account_rep, 
                        enterprise_id,
                        account_name, 
                        parent_account, 
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
                        crm_date_added ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
        
            if (!$stmt) {
                die('Error in preparing statement: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssssssssiis", 
                $account_rep, 
                $user_id,
                $account_name, 
                $parent_account, 
                $account_status, 
                $account_email, 
                $account_phone, 
                $account_fax, 
                $account_address, 
                $account_country, 
                $account_website, 
                $account_facebook, 
                $account_twitter, 
                $account_linkedin, 
                $account_interlink, 
                $contact_name, 
                $contact_title, 
                $contact_report, 
                $contact_email, 
                $contact_phone, 
                $contact_fax, 
                $contact_address, 
                $contact_website, 
                $contact_facebook, 
                $contact_twitter, 
                $contact_linkedin, 
                $contact_interlink, 
                $account_product, 
                $account_service, 
                $account_industry, 
                $account_certification, 
                $account_category, 
                $Account_Source, 
                $userID, 
                $mutiple_added, 
                $today);
        
            mysqli_stmt_execute($stmt);
            $success = mysqli_stmt_affected_rows($stmt) > 0;
            mysqli_stmt_close($stmt);
        
            if ($success) {
                $mail = php_mailer($from, $to, $user, $subject, $body);
                $response = array('status' => 'success', 'message' => 'A new contact added successfully');
                echo json_encode($response);
            } else {
                $error_message = "Error: " . mysqli_error($conn);
                error_log($error_message);
                $response = array('status' => 'error', 'message' => 'An error occurred while adding a new contact');
                echo json_encode($response);
            }
    	}
         
    }
    
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    if (isset($_POST['upload_multiple_contacts'])) {
        $file = $_FILES["csvfile"]["tmp_name"];
        $skippedRows = [];
        $successfulRows = [];
    
        if (($handle = fopen($file, "r")) !== false) {
            $stmt = $conn->prepare("INSERT INTO clone_crm (account_rep, account_name, account_email, account_phone, Account_Source, userID, enterprise_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
            if (!$stmt) {
                die("Error in preparing the statement: " . $conn->error);
            }
    
            $stmt->bind_param("sssssii", $account_rep, $account_name, $account_email, $account_phone, $account_source, $binded_employee_id, $binded_employeer_id);
            $successfullyInsertedCount = 0;
            $skippedExistingEmailCount = 0;
            fgetcsv($handle);
    
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $account_rep            = 'InterlinkIQ';
                $account_name           = cleanInput($data[0]);
                $account_email          = cleanInput($data[1]);
                $account_phone          = cleanInput($data[2]);
                $account_source         = cleanInput($data[3]);
                $binded_employee_id     = $_COOKIE['ID']; // integer 
                $binded_employeer_id    = $user_id; // integer
    
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM clone_crm WHERE account_email = ? AND enterprise_id = ?");
                if (!$checkStmt) {
                    die("Error in preparing the statement: " . $conn->error);
                }
    
                $checkStmt->bind_param("si", $account_email, $binded_employeer_id);
                $checkStmt->execute();
                $checkStmt->bind_result($emailCount);
                $checkStmt->fetch();
                $checkStmt->close();
    
                if ($emailCount == 0) {
                    if ($stmt->execute()) {
                        $successfulRows[] = $data;
                        $successfullyInsertedCount++;
                    } else {
                        die("Error in executing the statement: " . $stmt->error);
                    }
                } else {
                    $skippedRows[] = $data;
                    $skippedExistingEmailCount++;
                }
            }
    
            $stmt->close();
            fclose($handle);
    
            $success_data = '';
            foreach ($successfulRows as $success) {
                $success_data .= '
                    <tr>
                        <td></td>
                        <td>' . $success[0] . '</td>
                        <td>' . $success[1] . '</td>
                        <td>' . $success[2] . '</td>
                        <td>' . $success[3] . '</td>
                    </tr>';
            }
    
            // Create HTML for skipped rows
            $skipped_data = '';
            foreach ($skippedRows as $skipped) {
                $skipped_data .= '
                    <tr>
                        <td></td>
                        <td>' . $skipped[0] . '</td>
                        <td>' . $skipped[1] . '</td>
                        <td>' . $skipped[2] . '</td>
                        <td>' . $skipped[3] . '</td>
                    </tr>';
            }
    
            if ($skippedExistingEmailCount > 0) {
                echo $response = 'error|Some entries failed to save to the record because the entries exist in the record or have issues with special characters|' . $success_data . '|' . $skipped_data;
            } else {
                echo $response = 'success|All contact entries added successfully|' . $success_data . '|' . $skipped_data;
            }
        } else {
            echo json_encode(['error' => 'Error opening the CSV file']);
        }
    }
    
    if (isset($_POST['get_activity_history'])) {
    $stmt = $conn->prepare("SELECT crm.performer_name, crm.action_taken, crm.type, crm.action_id, DATE_FORMAT(crm.timestamp, '%M %e') AS date, DATE_FORMAT(crm.timestamp, '%h:%i %p') AS time, user_info.avatar FROM tbl_crm_history_data AS crm JOIN tbl_user_info AS user_info ON crm.user_id = user_info.user_id WHERE crm.contact_id = ? ORDER BY crm.history_id DESC");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $id = $_POST['id'];
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($performer_name, $action, $type, $action_id, $date, $time, $avatar);
            $output = '<div class="mt-actions">';
            while ($stmt->fetch()) {
                $output .= '
                    <div class="mt-action">
                        <div class="mt-action-img">
                            <img src="uploads/avatar/'. $avatar .'" / height="50" width="50"> </div>
                        <div class="mt-action-body">
                            <div class="mt-action-row">
                                <div class="mt-action-info ">
                                    <div class="mt-action-icon ">
                                        <i class="bi bi-activity"></i>
                                    </div>
                                    <div class="mt-action-details ">
                                        <span class="mt-action-author">' . $performer_name . '</span><br>
                                        <a class="mt-action-desc view-content" data-id="' . $type . '" id="' . $action_id . '" data-toggle="modal" href="#view-content">' . $action . '</a>
                                    </div>
                                </div>
                                <div class="mt-action-datetime ">
                                    <span class="mt-action-date"><i class="bi bi-calendar"></i> ' . $date . '</span>
                                    <span class="mt-action-dot bg-green"></span>
                                    <span class="mt=action-time"><i class="bi bi-clock"></i> ' . $time . '</span>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            $output .= '</div>';
            echo $output;
        } else {
            echo 'No Activities Found';
        }
        $stmt->close();
    }
    
    if(isset($_POST['get_content_message'])) {
        $type = $_POST['type'];
        $action_id = $_POST['action_id'];
        $table = null;
        $columns = null;
        $retrieve_cols = null;
        $table_id = null;
    
        if($type == 1) {
            $table = 'tbl_Customer_Relationship_Campaign';
            $columns = 'Campaign_Subject, Campaign_body, Frequency';
            $table_id = 'Campaign_Id';
        } elseif($type == 2) {
            $table = 'tbl_Customer_Relationship_Notes';
            $columns = 'Notes';
            $table_id = 'notes_id';
        }
    
        $sql = "SELECT $columns FROM $table WHERE $table_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $action_id);
        $stmt->execute();
        if ($type == 1) {
            $stmt->bind_result($subject, $body, $frequency);
        } elseif ($type == 2) {
            $stmt->bind_result($notes);
        }
        if ($stmt->fetch()) {
            if($type == 1) {
                $frequencyStatus = [
                    1 => 'Once Per Day',
                    2 => 'Once Per Week',
                    3 => 'On the 1st and 15th of the Month',
                    4 => 'Once Per Month',
                    5 => 'Once Per Year',
                    6 => 'Once Per Three Months (Quarterly)',
                    7 => 'Once Per Six Months (Bi-Annual)',
                    8 => 'Once Per Two Months (Every Other Month)'
                ];
                $status = isset($frequencyStatus[$frequency]) ? $frequencyStatus[$frequency] : '';
                echo '<h3 style="display:flex; justify-content:center; margin: 1rem 0; font-weight: bold">'.$subject . '</h3><br>';
                echo '<div style="border: 2px dashed #4444; padding: 3rem;">'. $body . '</div><br>';
                echo '<strong style="margin: 1rem 0;">Frequency:</strong> '. $status .'<br>';
            } elseif($type == 2) {
                echo $notes . '<br>';
            }
        } else {
            echo "No results found.";
        }
    }
    
    if(isset($_POST['get_counts'])) {
        // Initialize count variables
        $relationshipCount = 0;
        $campaignCount = 0;
        $campaignerCount = 0;
        $campaignAverage = 0;
    
        // Prepare and execute query for tbl_Customer_Relationship
        $query_relationship = 'SELECT COUNT(*) FROM tbl_Customer_Relationship WHERE enterprise_id = ? AND flag = ?';
        $stmt_relationship = $conn->prepare($query_relationship);
        if(!$stmt_relationship) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_relationship->bind_param('ii', $enterprise_id, $flag);
        if($stmt_relationship->execute()) {
            $stmt_relationship->bind_result($relationshipCount);
            $stmt_relationship->fetch();
        } else {
            echo "Error executing statement: " . $stmt_relationship->error;
        }
        $stmt_relationship->close();
    
        // Prepare and execute query for tbl_Customer_Relationship_Campaign
        $query_campaign = 'SELECT COUNT(*) FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ?';
        $stmt_campaign = $conn->prepare($query_campaign);
        if(!$stmt_campaign) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaign->bind_param('ii', $campaign_status, $send_status);
        if($stmt_campaign->execute()) {
            $stmt_campaign->bind_result($campaignCount);
            $stmt_campaign->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaign->error;
        }
        $stmt_campaign->close();
    
        // Prepare and execute query for campaigner count
        $query_campaigner = 'SELECT COUNT(DISTINCT userID) AS user_count FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ?';
        $stmt_campaigner = $conn->prepare($query_campaigner);
        if(!$stmt_campaigner) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaigner->bind_param('ii', $campaign_status, $send_status);
        if($stmt_campaigner->execute()) {
            $stmt_campaigner->bind_result($campaignerCount);
            $stmt_campaigner->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaigner->error;
        }
        $stmt_campaigner->close();
    
        // Prepare and execute query for campaign average
        $query_campaign_average = 'SELECT ROUND(SUM(total_campaigns_sent) / COUNT(DISTINCT month)) AS avg_campaigns_per_month FROM ( SELECT YEAR(campaign_stamp) AS year, MONTHNAME(campaign_stamp) AS month, COUNT(*) AS total_campaigns_sent FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND enterprise_id = ? GROUP BY YEAR(campaign_stamp), MONTH(campaign_stamp) ) AS subquery GROUP BY year';
        $stmt_campaign_average = $conn->prepare($query_campaign_average);
        if(!$stmt_campaign_average) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaign_average->bind_param('iii', $campaign_status, $send_status, $enterprise_id);
        if($stmt_campaign_average->execute()) {
            $stmt_campaign_average->bind_result($campaignAverage);
            $stmt_campaign_average->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaign_average->error;
        }
        $stmt_campaign_average->close();
    
        // Close database connection
        $conn->close();
    
        // Create an associative array to hold counts
        $counts = array(
            'relationshipCount' =>  $relationshipCount,
            'campaignCount'     =>  $campaignCount,
            'campaignerCount'   =>  $campaignerCount,
            'campaignAverage'   =>  $campaignAverage
        );
    
        // Convert counts array to JSON format
        $json_counts = json_encode($counts);
    
        // Return JSON response
        echo $json_counts;
    }
    
    if(isset($_POST['get_campaigns_per_subject'])) {
        $enterprise_id = $user_id;
        $status = 'Manual';
        $flag = 1;
        $campaign_status = 2;
        $send_status = 1;
        $campaigns = "SELECT Campaign_Name, COUNT(*) AS subject_count FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND enterprise_id = ? AND Campaign_Subject NOT LIKE '%Test Subject%' AND Campaign_Subject NOT LIKE '%Internal Email Campaign Test%' GROUP BY Campaign_Subject";
        $stmt_campaign = $conn->prepare($campaigns);
        if(!$stmt_campaign) {
            die('Error preparing statement: ' .$conn->error);
        }
        $stmt_campaign->bind_param('iii', $campaign_status, $send_status, $enterprise_id);
        if($stmt_campaign->execute()) {
            $stmt_campaign->bind_result($campaign_name, $subject_count);
            $output = '';
            while ($stmt_campaign->fetch()) {
                $output .='
                    <li>
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col2">
                                    <div class="desc"> '.$campaign_name.' </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <span class=" text-white h5 label label-md label-success">'.$subject_count.'</span>
                        </div>
                    </li>
                ';
            }
            echo $output;
            $stmt_campaign->close();
        } else {
            echo 'Error executing statement: ' . $stmt_campaign->error;
        }
    }

    if(isset($_POST['get_graph_campaign'])) {
        $stmt_graph_campaign = $conn->prepare("SELECT CONCAT(u.first_name, ' ', u.last_name) AS name, COUNT(*) AS campaign_sent
          FROM tbl_Customer_Relationship_Campaign c
          JOIN tbl_user u ON c.userID = u.ID
          WHERE c.Campaign_Status = ? AND c.enterprise_id = ? AND c.Auto_Send_Status = ?
          GROUP BY c.userID");
        
        if ($stmt_graph_campaign) {
            $stmt_graph_campaign->bind_param("iii", $campaign_status, $enterprise_id, $send_status);
        
            // Execute the prepared statement
            if ($stmt_graph_campaign->execute()) {
                // Bind result variables
                $stmt_graph_campaign->bind_result($name, $campaign_sent);
        
                $data = array();
        
                // Fetch rows
                while ($stmt_graph_campaign->fetch()) {
                    $item = array(
                        'value' => $campaign_sent,
                        'category' => $name
                    );
                    $data[] = $item;
                }
        
                // Encode the data array as JSON
                $graph_data_campaign = json_encode($data);
            } else {
                echo "Error executing prepared statement: " . $stmt_graph_campaign->error;
            }
        
            // Close the statement
            $stmt_graph_campaign->close();
        } else {
            echo "Error in preparing statement: " . $conn->error;
        }
        $conn->close();
    }
    
    if(isset($_POST['get_graphs'])) {
        // Prepare the contact graph query
        $stmt_graph_contact = $conn->prepare("SELECT CONCAT(u.first_name, ' ', u.last_name) AS name, COUNT(*) AS uploaded_contacts 
                                            FROM tbl_Customer_Relationship c 
                                            JOIN tbl_user u ON c.userID = u.ID 
                                            WHERE c.account_status != ? 
                                                AND c.enterprise_id = ? 
                                                AND c.flag = ? 
                                                AND YEAR(c.crm_date_added) >= YEAR(CURRENT_DATE) 
                                            GROUP BY c.userID;");
        
        if ($stmt_graph_contact) {
            $stmt_graph_contact->bind_param("sii", $status, $enterprise_id, $flag);
            
            // Execute the prepared statement
            if ($stmt_graph_contact->execute()) {
                // Bind result variables
                $stmt_graph_contact->bind_result($name, $uploaded_contacts);
        
                $contact_graph = array();
        
                // Fetch rows
                while ($stmt_graph_contact->fetch()) {
                    $item = array(
                        'value' => $uploaded_contacts,
                        'category' => $name
                    );
                    $contact_graph[] = $item;
                }
            } else {
                echo "Error executing prepared statement (Contact graph): " . $stmt_graph_contact->error;
            }
        
            // Close the statement
            $stmt_graph_contact->close();
        } else {
            echo "Error in preparing statement (Contact graph): " . $conn->error;
        }
        
        // Prepare the campaign graph query
        $stmt_graph_campaign = $conn->prepare("SELECT CONCAT(u.first_name, ' ', u.last_name) AS name, COUNT(*) AS campaign_sent
                                            FROM tbl_Customer_Relationship_Campaign c
                                            JOIN tbl_user u ON c.userID = u.ID
                                            WHERE c.Campaign_Status = ? AND c.enterprise_id = ? AND c.Auto_Send_Status = ?
                                            GROUP BY c.userID");
        
        if ($stmt_graph_campaign) {
            $stmt_graph_campaign->bind_param("iii", $campaign_status, $enterprise_id, $send_status);
            
            // Execute the prepared statement
            if ($stmt_graph_campaign->execute()) {
                // Bind result variables
                $stmt_graph_campaign->bind_result($name, $campaign_sent);
        
                $campaign_graph = array();
        
                // Fetch rows
                while ($stmt_graph_campaign->fetch()) {
                    $item = array(
                        'value' => $campaign_sent,
                        'category' => $name
                    );
                    $campaign_graph[] = $item;
                }
            } else {
                echo "Error executing prepared statement (Campaign graph): " . $stmt_graph_campaign->error;
            }
        
            // Close the statement
            $stmt_graph_campaign->close();
        } else {
            echo "Error in preparing statement (Campaign graph): " . $conn->error;
        }
        
        $stmt_graph_campaign_daily = $conn->prepare("SELECT DATE_FORMAT(campaign_date, '%M %e, %Y') AS date, ROUND(SUM(total_campaigns_sent) / COUNT(DISTINCT DAY(campaign_date))) AS average_campaign_daily 
                                            FROM ( SELECT DATE(Campaign_added) AS campaign_date, COUNT(*) AS total_campaigns_sent 
                                                    FROM tbl_Customer_Relationship_Campaign 
                                                    WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND enterprise_id = ? GROUP BY DATE(Campaign_added) ) AS subquery 
                                                    GROUP BY MONTH(campaign_date), DAY(campaign_date)");
        
        if ($stmt_graph_campaign_daily) {
            $stmt_graph_campaign_daily->bind_param("iii", $campaign_status, $send_status, $enterprise_id);
            
            // Execute the prepared statement
            if ($stmt_graph_campaign_daily->execute()) {
                // Bind result variables
                $stmt_graph_campaign_daily->bind_result($date, $average_campaign_daily);
        
                $campaign_graph_daily = array();
        
                // Fetch rows
                while ($stmt_graph_campaign_daily->fetch()) {
                    // Convert date string to JavaScript Date format
                    $timestamp = strtotime($date) * 1000; // Convert to milliseconds
                    // Convert value string to integer
                    $average_campaign_daily = intval($average_campaign_daily);
        
                    $item = array(
                        'date' => $timestamp,
                        'value' => $average_campaign_daily
                    );
                    $campaign_graph_daily[] = $item;
                }
            } else {
                echo "Error executing prepared statement (Campaign graph): " . $stmt_graph_campaign_daily->error;
            }
        
            // Close the statement
            $stmt_graph_campaign_daily->close();
        } else {
            echo "Error in preparing statement (Campaign graph): " . $conn->error;
        }
        
        $graph_data = array(
            'contact'           =>  $contact_graph,
            'campaign'          =>  $campaign_graph,
            'daily_campaign'    =>  $campaign_graph_daily
        );
        
        // Encode the combined data array as JSON
        $json_data = json_encode($graph_data);
        
        // Output the JSON data
        echo $json_data;
        
        // Close the database connection
        $conn->close();
    }
    
    if(isset($_POST['user_graphs'])) {
        $daily_average = $conn->prepare("SELECT DATE_FORMAT(campaign_date, '%M %e, %Y') AS date, ROUND(SUM(total_campaigns_sent) / COUNT(DISTINCT DAY(campaign_date))) AS average_campaign_daily 
                                            FROM ( SELECT DATE(Campaign_added) AS campaign_date, COUNT(*) AS total_campaigns_sent 
                                                    FROM tbl_Customer_Relationship_Campaign 
                                                    WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND enterprise_id = ? AND userID = ? GROUP BY DATE(Campaign_added) ) AS subquery 
                                                    GROUP BY MONTH(campaign_date), DAY(campaign_date)");
        
        if ($daily_average) {
            $daily_average->bind_param("iiii", $campaign_status, $send_status, $enterprise_id, $_COOKIE['ID']);
            
            // Execute the prepared statement
            if ($daily_average->execute()) {
                // Bind result variables
                $daily_average->bind_result($date, $average_campaign_daily);
                $campaign_graph_daily = array();
        
                // Fetch rows
                while ($daily_average->fetch()) {
                    // Convert date string to JavaScript Date format
                    $timestamp = strtotime($date) * 1000; // Convert to milliseconds
                    // Convert value string to integer
                    $average_campaign_daily = intval($average_campaign_daily);
        
                    $item = array(
                        'date' => $timestamp,
                        'value' => $average_campaign_daily
                    );
                    $campaign_graph_daily[] = $item;
                }
            } else {
                echo "Error executing prepared statement (Campaign graph): " . $daily_average->error;
            }
        
            // Close the statement
            $daily_average->close();
        } else {
            echo "Error in preparing statement (Campaign graph): " . $conn->error;
        }
        
        $graph_data = array(
            'daily_campaign'    =>  $campaign_graph_daily
        );
        
        // Encode the combined data array as JSON
        $json_data = json_encode($graph_data);
        
        // Output the JSON data
        echo $json_data;
        
        // Close the database connection
        $conn->close();
    }
    
    if(isset($_POST['get_user_campaigns'])) {
        $campaigns = "SELECT Campaign_Subject, COUNT(*) AS subject_count FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND userID = ? AND enterprise_id = ? GROUP BY Campaign_Subject";
        $stmt_campaign = $conn->prepare($campaigns);
        if(!$stmt_campaign) {
            die('Error preparing statement: ' .$conn->error);
        }
        $stmt_campaign->bind_param('iiii', $campaign_status, $send_status, $_COOKIE['ID'], $enterprise_id);
        if($stmt_campaign->execute()) {
            $stmt_campaign->bind_result($campaign_subject, $subject_count);
            $output = '';
            while ($stmt_campaign->fetch()) {
                $output .='
                            <tr>
                                <td> '.$campaign_subject.' </td>
                                <td> '.$subject_count.' </td>
                                <td class="text-center"> 
                                    <a class="btn blue btn-sm campaignListPerSubject" data-value="'.$campaign_subject.'" data-toggle="modal" href="#modalCampaignList">View list</a> 
                                </td>
                            </tr>
                ';
            }
            echo $output;
            $stmt_campaign->close();
        } else {
            echo 'Error executing statement: ' . $stmt_campaign->error;
        }
    }
    
    if(isset($_POST['get_user_task'])) {
        $email = 'marvin@consultareinc.com';
        $campaigns = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS originator, t.crmt_id as taskid, t.assign_task as task_name, t.Assigned_to as assigned, t.Task_Description as description, DATE(t.Task_added) AS date_added, DATE(t.Deadline) as due_date, t.Task_Status as status, c.account_name as contact
                                            FROM tbl_Customer_Relationship_Task t
                                            JOIN tbl_user u ON t.user_cookies = u.ID
                                            JOIN tbl_Customer_Relationship c ON t.crm_ids = c.crm_id
                                            WHERE t.user_cookies = ? OR t.Assigned_to = ? ORDER BY t.Task_Status ASC";
        $stmt_campaign = $conn->prepare($campaigns);
        if(!$stmt_campaign) {
            die('Error preparing statement: ' .$conn->error);
        }
        $stmt_campaign->bind_param('is', $_COOKIE['ID'], $email);
        if($stmt_campaign->execute()) {
            $results = [];
            $stmt_campaign->bind_result($originator, $taskid, $task_name, $assigned, $description, $date_added, $due_date, $status, $contact);
            while ($stmt_campaign->fetch()) {
                $results[] = [
                    'originator' => $originator,
                    'taskid' => $taskid,
                    'task_name' => $task_name,
                    'assigned' => $assigned,
                    'description' => $description,
                    'date_added' => $date_added,
                    'due_date' => $due_date,
                    'status' => $status,
                    'contact' => $contact
                ];
            }
    
            $output = '';
            foreach ($results as $result) {
                // Fetching assigned_to using get_name() function
                $assigned_to = get_name($result['assigned']);
                
                // Converting due date format
                $date = isset($result['due_date']) ? new DateTime($result['due_date']) : null;
                $due = $date ? $date->format('F j, Y') : '';
                $status = '<span class="label label-sm label-success">Completed</span>';
                if($result['status'] == 1) {
                    $status = '<span class="label label-sm label-default">Pending</span>';
                } elseif($result['status'] == 2) {
                    $status = '<span class="label label-sm label-warning">In progress</span>';
                }
                
    
                // Building output HTML
                $output .= '
                    <tr>
                        <td>' . $result['task_name'] . '</td>
                        <td>' . $result['originator'] . '</td>
                        <td>' . $assigned_to . '</td>
                        <td>' . $result['description'] . '</td>
                        <td>' . $status . '</td>
                        <td>' . $due . '</td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="btn-group btn-group-solid">
                                    <a class="btn btn-sm blue tooltips edit-assigned-task" data-id="' . $result['taskid'] . '" data-toggle="modal" href="#modalEditTaskForm"><i class="bi bi-activity"></i> View</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                ';
            }
    
            echo $output;
            $stmt_campaign->close();
        } else {
            echo 'Error executing statement: ' . $stmt_campaign->error;
        }
    }
    
    if(isset($_POST['group_campaign_list_by_subject'])) {
        $subject = $_POST['subject'];
        $campaigns = "SELECT c.Campaign_Id, c.Campaign_from, c.Campaign_Name, c.Campaign_body, c.Campaign_Subject, c.Frequency, cc.account_name, cc.account_email, c.Campaign_Status, c.Auto_Send_Status, c.Campaign_added,
                            TIMESTAMPDIFF(WEEK, NOW(), DATE_ADD(c.Campaign_added, INTERVAL 1 YEAR)) AS remaining_weeks
                            FROM tbl_Customer_Relationship_Campaign c 
                            JOIN tbl_Customer_Relationship cc 
                            ON c.crm_ids = cc.crm_id 
                            WHERE c.Campaign_Subject = ?
                            AND c.Campaign_Status = ? AND c.Auto_Send_Status = ? AND c.userID = ?";
        $stmt_campaign = $conn->prepare($campaigns);
        if(!$stmt_campaign) {
            die('Error preparing statement: ' .$conn->error);
        }
        $stmt_campaign->bind_param('siii', $subject, $campaign_status, $send_status, $_COOKIE['ID']);
        if($stmt_campaign->execute()) {
            $stmt_campaign->bind_result($Campaign_Id, $Campaign_from, $Campaign_Name, $Campaign_body, $Campaign_Subject, $Frequency, $account_name, $account_email, $Campaign_Status, $Auto_Send_Status, $Campaign_added, $remaining_weeks);
            $output = '';
            while ($stmt_campaign->fetch()) {
                $date = isset($Campaign_added) ? new DateTime($Campaign_added) : null;
                $sent_date = $date ? $date->format('F j, Y') : '';
                $frequencies = '';
                $status = '';
                if($Frequency == 1){ $frequencies = 'Once Per Day'; }
                else if($Frequency == 2){ $frequencies = 'Once Per Week'; }
                else if($Frequency == 3){ $frequencies = 'On the 1st and 15th of the Month'; }
                else if($Frequency == 4){ $frequencies = 'Once Per Month'; }
                else if($Frequency == 5){ $frequencies = 'Once Per Year'; }
                else if($Frequency == 6){ $frequencies = 'Once Per Two Months (Every Other Month)'; }
                else if($Frequency == 7){ $frequencies = 'Once Per Three Months (Quarterly)'; }
                else if($Frequency == 8){ $frequencies = 'Once Per Six Months (Bi-Annual)'; }
                if($Auto_Send_Status == 0) {
                    $status = '<span class="text-danger">Stopped</span>';
                } else {
                    $status = '<span class="text-success">Active</span>';
                }
                
                $remaining_weeks = ($status > 0) ? $remaining_weeks : '';

                $output .='
                            <tr>
                                <td class="text-center">
                                    <label class="mt-checkbox">
                                        <input type="checkbox" class="checkbox_action" data-value="crm_date_added" value="'.$Campaign_Id.'"/>
                                        <span></span>
                                    </label>
                                </td> 
                                <td> '.$sent_date.' </td>
                                <td> '.$Campaign_Name.' </td>
                                <td> '.$account_email.' </td>
                                <td> <a class="viewCampaignMessage" data-toggle="modal" href="#view-campaign-message" data-id="'.$Campaign_Id.'">View message</a></td></td>
                                <td> '.$frequencies.' </td>
                                <td> '.$status.' </td>
                                <td> '.$remaining_weeks.' Weeks</td>
                                <td class="text-center"> 
                                    <a class="btn blue btn-sm campaignDetails" data-toggle="modal" href="#modalCampaignDetails" data-id="'.$Campaign_Id.'">View</a> 
                                </td>
                            </tr>
                ';
            }
            echo $output;
            $stmt_campaign->close();
        } else {
            echo 'Error executing statement: ' . $stmt_campaign->error;
        }
    }
    
    if(isset($_POST['get_campaign_message_content'])) {
        $campaignid = $_POST['campaignid'];
        $sql = "SELECT Campaign_body FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $campaignid);
        $stmt->execute();
            $stmt->bind_result($body);
        
        if ($stmt->fetch()) {
                echo $body . '<br>';
        } else {
            echo "No results found.";
        }
    }
    
    if(isset($_POST['get_campaign_details'])) {
        $campaignid = $_POST['id'];
        $sql = "SELECT Campaign_Id, Campaign_Name, Campaign_Recipients, Campaign_Subject, Frequency, Campaign_body, Auto_Send_Status FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $campaignid);
        $stmt->execute();
            $stmt->bind_result($Campaign_Id, $Campaign_Name, $Campaign_Recipients, $Campaign_Subject, $Frequency, $Campaign_body, $Auto_Send_Status);
        
        if ($stmt->fetch()) {
            $data = array(
                    'id'        =>  $Campaign_Id,
                    'name'      =>  $Campaign_Name,
                    'subject'   =>  $Campaign_Subject,
                    'message'   =>  $Campaign_body,
                    'recipient' =>  $Campaign_Recipients,
                    'frequency' =>  $Frequency,
                    'status'    =>  $Auto_Send_Status
                );
                echo json_encode($data);
        }
    }
    
    if(isset($_POST['get_task_details'])) {
        $taskid = $_POST['taskid'];
        $stmt = $conn->prepare("SELECT crmt_id, assign_task, Assigned_to, Task_Description, Task_added, Deadline, Task_Status, Date_Updated FROM tbl_Customer_Relationship_Task WHERE crmt_id = ?");
        $stmt->bind_param('i', $taskid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($crmt_id, $assign_task, $Assigned_to, $Task_Description, $Task_added, $Deadline, $Task_Status, $Date_Updated);
        $stmt->fetch();
        
        $startdate = format_date($Task_added, 'Y/d/m');
        $duedate = format_date($Deadline, 'Y/d/m');
        $assigned = (!empty(get_name($Assigned_to))) ? get_name($Assigned_to): $Assigned_to;
    
        $data = array(
            'id'            =>  $crmt_id,
            'name'          =>  $assign_task,
            'assignedto'    =>  $assigned,
            'email'         =>  $Assigned_to,
            'description'   =>  $Task_Description,
            'startdate'     =>  $startdate,
            'duedate'       =>  $duedate,
            'status'        =>  $Task_Status,
            'last_updated'  =>  $Date_Updated
        );
    
        echo json_encode($data);
    }
    
    if(isset($_POST['update_task'])) {
        $old_assigned = $_POST['old_assigned'];
        $taskid = $_POST['taskid'];
        $assign_task = $_POST['task_name'];
        $Assigned_to = $_POST['assign_to'];
        $description = $_POST['description'];
        $startdate = $_POST['startdate'];
        $duedate = $_POST['duedate'];
        $status = $_POST['status'];
    
        $assign = ($Assigned_to == "Select Person") ? $old_assigned : $Assigned_to;
    
        $sql = "UPDATE tbl_Customer_Relationship_Task 
                SET assign_task = ?, 
                    Assigned_to = ?, 
                    Task_Description = ?, 
                    Task_added = ?, 
                    Deadline = ?, 
                    Task_Status = ? 
                WHERE crmt_id = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param('sssssii', $assign_task, $assign, $description, $startdate, $duedate, $status, $taskid);
    
            if ($stmt->execute()) {
                $response = array('status' => 'success', 'message' => "Task updated Successfully!");
            } else {
                $response = array('status' => 'error', 'message' => "Error updating record:  '. $stmt->error .'");
            }
            
            echo json_encode($response);
    
            // Close the statement
            $stmt->close();
        }
    }
    
    if(isset($_POST['update_campaign'])) {
        $campaignid = $_POST['campaignid'];
        $name       = $_POST['name'];
        $recipient  = $_POST['recipient'];
        $subject    = $_POST['subject'];
        $message    = $_POST['body'];
        $frequenct  = $_POST['frequency'];
        $status     = $_POST['status'];
    
        $sql = "UPDATE tbl_Customer_Relationship_Campaign 
                SET Campaign_Name = ?, 
                    Campaign_Recipients = ?, 
                    Campaign_Subject = ?, 
                    Campaign_body = ?, 
                    Frequency = ?, 
                    Auto_Send_Status = ? 
                WHERE Campaign_Id = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param('sssssii', $name, $recipient, $subject, $message, $frequenct, $status, $campaignid);
    
            if ($stmt->execute()) {
                $response = array('status' => 'success', 'message' => "Campaign updated successfully!");
            } else {
                $response = array('status' => 'error', 'message' => "Error updating record:  '. $stmt->error .'");
            }
            
            echo json_encode($response);
    
            // Close the statement
            $stmt->close();
        }
    }
    
    if(isset($_POST['user_contributions'])) {
        // Initialize count variables
        $userContacts       = 0;
        $campaignCount      = 0;
        $campaignSentToday  = 0;
        $dailyAverage       = 0;
    
        // Prepare and execute query for tbl_Customer_Relationship
        $query_relationship = 'SELECT COUNT(*) FROM tbl_Customer_Relationship WHERE enterprise_id = ? AND flag = ? AND userID = ?';
        $stmt_relationship = $conn->prepare($query_relationship);
        if(!$stmt_relationship) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_relationship->bind_param('iii', $enterprise_id, $flag, $_COOKIE['ID']);
        if($stmt_relationship->execute()) {
            $stmt_relationship->bind_result($userContacts);
            $stmt_relationship->fetch();
        } else {
            echo "Error executing statement: " . $stmt_relationship->error;
        }
        $stmt_relationship->close();
    
        // Prepare and execute query for tbl_Customer_Relationship_Campaign
        $query_campaign = 'SELECT COUNT(*) FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND userID = ?';
        $stmt_campaign = $conn->prepare($query_campaign);
        if(!$stmt_campaign) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaign->bind_param('iii', $campaign_status, $send_status, $_COOKIE['ID']);
        if($stmt_campaign->execute()) {
            $stmt_campaign->bind_result($campaignSentToday);
            $stmt_campaign->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaign->error;
        }
        $stmt_campaign->close();
    
        // Prepare and execute query for campaigner count
        $query_campaign_today = 'SELECT COUNT(*) FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND userID = ? AND DATE(campaign_stamp) = CURDATE()';
        $stmt_campaign_today = $conn->prepare($query_campaign_today);
        if(!$stmt_campaign_today) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaign_today->bind_param('iii', $campaign_status, $send_status, $_COOKIE['ID']);
        if($stmt_campaign_today->execute()) {
            $stmt_campaign_today->bind_result($campaignSentToday);
            $stmt_campaign_today->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaign_today->error;
        }
        $stmt_campaign_today->close();
    
        // Prepare and execute query for campaign average
        $query_campaign_average = 'SELECT ROUND(SUM(total_campaigns_sent) / COUNT(DISTINCT campaign_date)) AS avg_campaigns_per_day FROM (SELECT DATE(campaign_stamp) AS campaign_date, COUNT(*) AS total_campaigns_sent FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ? AND enterprise_id = ? AND userID = ? GROUP BY DATE(campaign_stamp) ) AS subquery';
        $stmt_campaign_average = $conn->prepare($query_campaign_average);
        if(!$stmt_campaign_average) {
            die('Error in preparing statement: ' . $conn->error);
        }
        $stmt_campaign_average->bind_param('iiii', $campaign_status, $send_status, $enterprise_id, $_COOKIE['ID']);
        if($stmt_campaign_average->execute()) {
            $stmt_campaign_average->bind_result($dailyAverage);
            $stmt_campaign_average->fetch();
        } else {
            echo "Error executing statement: " . $stmt_campaign_average->error;
        }
        $stmt_campaign_average->close();
    
        // Close database connection
        $conn->close();
    
        // Create an associative array to hold counts
        $counts = array(
            'userContacts'        =>   $userContacts,
            'campaignCount'       =>   $campaignCount,
            'campaignSentToday'   =>   $campaignSentToday,
            'dailyAverage'        =>   $dailyAverage
        );
    
        // Convert counts array to JSON format
        $json_counts = json_encode($counts);
    
        // Return JSON response
        echo $json_counts;
    }
?>