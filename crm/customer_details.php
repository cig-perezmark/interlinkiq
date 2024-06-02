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

    // Details tab
    if(isset($_POST['get_contact_details'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare('SELECT account_rep, account_name, account_address, account_country, Account_Source, parent_account, account_email, account_phone, account_fax, account_website, account_facebook, account_twitter, account_linkedin, account_interlink, flag, Account_Directory, account_status FROM tbl_Customer_Relationship WHERE crm_id = ?');

        if ($stmt == false) {
            echo 'Error preparing Statement: ' . $conn->error;
            exit;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $stmt->bind_result($account_rep, $account_name, $account_address, $account_country, $Account_Source, $parent_account, $account_email, $account_phone, $account_fax, $account_website, $account_facebook, $account_twitter, $account_linkedin, $account_interlink, $flag, $Account_Directory, $account_status);

        if ($stmt->fetch()) {
            $data = [
                'account_rep'           =>  $account_rep,
                'account_name'          =>  $account_name,
                'account_address'       =>  $account_address,
                'account_country'       =>  $account_country,
                'Account_Source'        =>  $Account_Source,
                'parent_account'        =>  $parent_account,
                'account_email'         =>  $account_email,
                'account_phone'         =>  $account_phone,
                'account_fax'           =>  $account_fax,
                'account_website'       =>  $account_website,
                'account_facebook'      =>  $account_facebook,
                'account_twitter'       =>  $account_twitter,
                'account_linkedin'      =>  $account_linkedin,
                'account_interlink'     =>  $account_interlink,
                'flag'                  =>  $flag,
                'Account_Directory'     =>  $Account_Directory,
                'account_status'        =>  $account_status,
                'crm_id'                => $id
            ];
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No data found']);
        }

        $stmt->close();
    }

    elseif(isset($_POST['update_contact_details'])) {
        $id                 =   mysqli_real_escape_string($conn, $_POST['id']);
        $account_rep        =   mysqli_real_escape_string($conn, $_POST['account_rep']);
        $account_name       =   mysqli_real_escape_string($conn, $_POST['account_name']);
        $account_address    =   mysqli_real_escape_string($conn, $_POST['account_address']);
        $account_country    =   mysqli_real_escape_string($conn, $_POST['account_country']);
        $account_source     =   mysqli_real_escape_string($conn, $_POST['Account_Source']);
        $parent_account     =   mysqli_real_escape_string($conn, $_POST['parent_account']);
        $account_email      =   mysqli_real_escape_string($conn, $_POST['account_email']);
        $account_phone      =   mysqli_real_escape_string($conn, $_POST['account_phone']);
        $account_fax        =   mysqli_real_escape_string($conn, $_POST['account_fax']);
        $account_website    =   mysqli_real_escape_string($conn, $_POST['account_website']);
        $account_facebook   =   mysqli_real_escape_string($conn, $_POST['account_facebook']);
        $account_twitter    =   mysqli_real_escape_string($conn, $_POST['account_twitter']);
        $account_interlink  =   mysqli_real_escape_string($conn, $_POST['account_interlink']);
        $account_linkedin   =   mysqli_real_escape_string($conn, $_POST['account_linkedin']);
        $account_directory  =   mysqli_real_escape_string($conn, $_POST['Account_Directory']);
        $account_status     =   mysqli_real_escape_string($conn, $_POST['account_status']);

        if ($account_status == 0) {
            $flag = 0;
            $status = ' ';
        } elseif (empty($account_status)) {
            $flag = 1;
            $status = '';
        } else {
            $flag = 1;
            $status = $account_status;
        }

        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship 
                                    SET  account_rep = ?,
                                        account_name = ?,
                                        account_address = ?,
                                        account_country = ?,
                                        Account_Source = ?,
                                        parent_account = ?,
                                        account_email = ?,
                                        account_phone = ?,
                                        account_fax = ?,
                                        account_website = ?,
                                        account_facebook = ?,
                                        account_twitter = ?,
                                        account_linkedin = ?,
                                        account_interlink = ?,
                                        Account_Directory = ?,
                                        account_status = ?,
                                        flag = ?
                                    WHERE crm_id = ?");
        if($stmt === false) {
            echo 'Error preparing Statement: '. $conn->error;
            exit;
        }

        $stmt->bind_param('sssssssssssssssssi', $account_rep, $account_name, $account_address, $account_country, $account_source, $parent_account, $account_email, $account_phone, $account_fax, $account_website, $account_facebook, $account_twitter, $account_linkedin, $account_interlink, $account_directory, $status, $flag, $id);

        if($stmt->execute()) {
            echo 'Contact details updated successfully';
        } else {
            echo 'Error updating contact details: '. $stmt->error;
        }

        $stmt->close();
    }

    elseif(isset($_POST['get_contacts'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("SELECT C_ids as id, CONCAT(TRIM(First_Name), ' ', TRIM(Last_Name)) as name, C_Title as title, Report_to as reporting_to, C_Address as address, C_Email as email, C_Phone as phone, C_Fax as fax FROM tbl_Customer_Relationship_More_Contacts WHERE C_crm_ids = ?");
        if($stmt === false) {
            echo json_encode(['error' => 'Error preparing statement: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $contacts = [];
        
        while($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }

        $stmt->close();
        echo json_encode($contacts);
    }

    elseif (isset($_POST['get_tasks'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $query = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS originator, t.crmt_id as taskid, t.assign_task as task_name, t.Assigned_to as assigned_email, t.Task_Description as description, DATE(t.Task_added) AS date_added, DATE(t.Deadline) as due_date, t.Task_Status as status, c.account_name as contact, c.crm_id
                FROM tbl_Customer_Relationship_Task t
                JOIN tbl_user u ON t.user_cookies = u.ID
                JOIN tbl_Customer_Relationship c ON t.crm_ids = c.crm_id
                WHERE crm_ids = ? AND t.Task_Status != 3 ORDER BY t.Deadline DESC";
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }
        
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $stmt->store_result();  // Store result to allow new queries on the same connection
            $pending = [];
            $stmt->bind_result($originator, $taskid, $task_name, $assigned_email, $description, $date_added, $due_date, $status, $contact, $crmid);
            while ($stmt->fetch()) {
                $pending[] = [
                    'originator' => $originator,
                    'taskid' => $taskid,
                    'task_name' => $task_name,
                    'assigned_email' => $assigned_email,
                    'description' => $description,
                    'date_added' =>format_date($date_added, 'F d, Y'),
                    'due_date' => format_date($due_date, 'F d, Y'),
                    'status' => $status,
                    'contact' => $contact,
                    'crmid' => $crmid
                ];
            }
            
            $stmt->close();

            // Process pending tasks to get the assigned names
            foreach ($pending as &$task) {
                $task['assigned'] = get_name($task['assigned_email']);
                unset($task['assigned_email']);
            }

            $query2 = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS originator, t.crmt_id as taskid, t.assign_task as task_name, t.Assigned_to as assigned_email, t.Task_Description as description, DATE(t.Task_added) AS date_added, DATE(t.Deadline) as due_date, t.Task_Status as status, c.account_name as contact, c.crm_id
                    FROM tbl_Customer_Relationship_Task t
                    JOIN tbl_user u ON t.user_cookies = u.ID
                    JOIN tbl_Customer_Relationship c ON t.crm_ids = c.crm_id
                    WHERE crm_ids = ? AND t.Task_Status = 3 ORDER BY t.Deadline DESC";
            
            $stmt2 = $conn->prepare($query2);
            if (!$stmt2) {
                die('Error preparing statement: ' . $conn->error);
            }
            
            $stmt2->bind_param('i', $id);
            if ($stmt2->execute()) {
                $stmt2->store_result();  // Store result to allow new queries on the same connection
                $completed = [];
                $stmt2->bind_result($originator, $taskid, $task_name, $assigned_email, $description, $date_added, $due_date, $status, $contact, $crmid);
                while ($stmt2->fetch()) {
                    $completed[] = [
                        'originator' => $originator,
                        'taskid' => $taskid,
                        'task_name' => $task_name,
                        'assigned_email' => $assigned_email,
                        'description' => $description,
                        'date_added' => format_date($date_added, 'F d, Y'),
                        'due_date' => format_date($due_date, 'F d, Y'),
                        'status' => $status,
                        'contact' => $contact,
                        'crmid' => $crmid
                    ];
                }
                
                $stmt2->close();

                // Process completed tasks to get the assigned names
                foreach ($completed as &$task) {
                    $task['assigned'] = get_name($task['assigned_email']);
                    unset($task['assigned_email']);
                }

                $data = [
                    'pendings' => $pending,
                    'completed' => $completed
                ];
                
                echo json_encode($data);
            } else {
                echo 'Error executing statement: ' . $stmt2->error;
            }
        } else {
            echo 'Error executing statement: ' . $stmt->error;
        }
    }

    elseif(isset($_POST['add_task'])) {
        $contact = $_POST['contact'];
        $task = $_POST['task'];
        $description = $_POST['description'];
        $assignee = $_POST['assignee'];
        $startdate = format_date($_POST['startdate'], 'Y-m-d');
        $duedate = format_date($_POST['duedate'], 'Y-m-d');
        $status = 1;

        $stmt = $conn->prepare('INSERT INTO tbl_Customer_Relationship_Task (assign_task, Assigned_to, Task_Description, Task_added, Deadline, crm_ids, user_cookies, Task_Status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');

        if($stmt == false) {
            echo 'Error preparing Statement: '. $conn->error;
        }
        $stmt->bind_param('ssssssii', $task, $assignee, $description, $startdate, $duedate, $contact, $_COOKIE['ID'], $status);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }

    elseif(isset($_POST['get_task_details'])) {
        $taskid = $_POST['taskid'];
        $stmt = $conn->prepare("SELECT crmt_id, assign_task, Assigned_to, Task_Description, Task_added, Deadline, Task_Status, Date_Updated FROM tbl_Customer_Relationship_Task WHERE crmt_id = ?");
        $stmt->bind_param('i', $taskid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($crmt_id, $assign_task, $Assigned_to, $Task_Description, $Task_added, $Deadline, $Task_Status, $Date_Updated);
        $stmt->fetch();
        $assigned = (!empty(get_name($Assigned_to))) ? get_name($Assigned_to) : $Assigned_to;

        $data = [
                    'id'            => $crmt_id,
                    'name'          => $assign_task,
                    'assignedto'    => $assigned,
                    'email'         => $Assigned_to,
                    'description'   => $Task_Description,
                    'startdate'     => $Task_added,
                    'duedate'       => $Deadline,
                    'status'        => $Task_Status,
                    'last_updated'  => $Date_Updated
                ];

        echo json_encode($data);
    }

    elseif(isset($_POST['update_task'])) {
        $old_assigned = $_POST['old_assigned'];
        $taskid       = $_POST['taskid'];
        $assign_task  = $_POST['task_name'];
        $Assigned_to  = $_POST['assign_to'];
        $description  = $_POST['description'];
        $startdate    = $_POST['startdate'];
        $duedate      = $_POST['duedate'];
        $status       = $_POST['status'];
    
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
    
            $stmt->close();
        }
    }

    // Note tab
    elseif(isset($_POST['get_notes'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("SELECT 
                    CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                    n.Notes AS note, 
                    n.notes_id AS note_id, 
                    DATE_FORMAT(n.notes_stamp, '%M %e, %Y') AS date 
                FROM 
                    tbl_Customer_Relationship_Notes n
                LEFT JOIN 
                    tbl_user u ON u.ID = n.user_cookies
                WHERE 
                    crm_ids = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $note, $note_id, $date);
        $notes = [];
        while ($stmt->fetch()) {
            $notes[] = [
                'name' => $name,
                'note' => $note,
                'id' => $note_id,
                'date' => $date,
            ];
        }
        echo json_encode($notes);
    }

    elseif(isset($_POST['add_notes'])) {
        $notes      = $_POST['notes'];
        $contactid  = $_POST['contactid'];
        $taskid     = $_POST['taskid'];
        $user_id    = $_COOKIE['ID'];

        $stmt = $conn->prepare("INSERT INTO tbl_Customer_Relationship_Notes (Notes, crm_ids, taskid, user_cookies) VALUES (?, ?, ?, ?)");
        
        if($stmt  === false) {
            echo "Error preparing Statement: ". $conn->error;
            exit;
        }

        $stmt->bind_param("siii", $notes, $contactid, $taskid, $user_id);
        $stmt->execute();
        echo "New notes added successfully";

        $stmt->close();
        $conn->close();
    }

    elseif(isset($_POST["get_notes_details"])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare('SELECT Notes, notes_id from tbl_Customer_Relationship_Notes WHERE notes_id = ?');
        if($stmt === false) { 
            echo 'Error preparing Statement: '. $conn->error;
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($notes, $notesid);
        if($stmt->fetch()) {
            $data = ['notes' => $notes, 'notesid'=> $notesid];
            echo json_encode($data);
        }
    }

    elseif(isset($_POST['update_notes'])) {
        $notes_id = $_POST['noteid'];
        $notes = $_POST['notes'];

        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship_Notes SET Notes = ? WHERE notes_id = ?");
        if($stmt === false) { 
            echo "Error preparing Statement: ". $conn->error;
            exit;
        }

        $stmt->bind_param("si", $notes, $notes_id);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            echo "Notes updated successfully";
        }
        $stmt->close();
        $conn->close();
    }

    // Contact
    elseif(isset($_POST['add_contact'])) {
        $first         =    $_POST['first'];
        $last          =    $_POST['last'];
        $title         =    $_POST['title'];
        $report        =    $_POST['report'];
        $address       =    $_POST['address'];
        $phone         =    $_POST['phone'];
        $email         =    $_POST['email'];
        $fax           =    $_POST['fax'];
        $website       =    $_POST['website'];
        $facebook      =    $_POST['facebook'];
        $twitter       =    $_POST['twitter'];
        $linkedin      =    $_POST['linkedin'];
        $interlink     =    $_POST['interlink'];
        $user_id       =    $_COOKIE['ID'];
        $contactid     =    $_POST['contactid'];

        $stmt = $conn->prepare("INSERT INTO tbl_Customer_Relationship_More_Contacts (First_Name, Last_Name, C_Title, Report_to, C_Address, C_Phone, C_Email, C_Fax, contact_website, contact_facebook, contact_twitter, contact_linkedin, contact_interlink, C_user_cookies, C_crm_ids) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if($stmt  === false) {
            echo "Error preparing Statement: ". $conn->error;
            exit;
        }

        $stmt->bind_param("sssssssssssssii", $first, $last, $title, $report, $address, $phone, $email, $fax, $website, $facebook, $twitter, $linkedin, $interlink, $user_id, $contactid);
        $stmt->execute();
        echo "New notes added successfully";

        $stmt->close();
        $conn->close();
    }

    elseif(isset($_POST["get_contact_infos"])) {
        $contact_id = $_POST['id'];;
        $stmt = $conn->prepare("SELECT C_ids, First_Name, Last_Name, C_Title, Report_to, C_Address, C_Phone, C_Email, C_Fax, contact_website, contact_facebook, contact_twitter, contact_linkedin, contact_interlink, C_crm_ids from tbl_Customer_Relationship_More_Contacts WHERE C_ids = ?");
        if($stmt === false) { 
            echo 'Error preparing Statement: '. $conn->error;
            exit;
        }
        $stmt->bind_param('i', $contact_id);
        $stmt->execute();
        $stmt->bind_result($id, $first, $last, $title, $report_to, $address, $phone, $email, $fax, $website, $facebook, $twitter, $linkedin, $interlink, $contactid);
        if($stmt->fetch()) {
            $data = [
                        'id'        =>  $id, 
                        'first'     =>  $first,
                        'last'      =>  $last,
                        'title'     =>  $title,
                        'report_to' =>  $report_to,
                        'address'   =>  $address,
                        'phone'     =>  $phone,
                        'email'     =>  $email,
                        'fax'       =>  $fax,
                        'website'   =>  $website,
                        'facebook'  =>  $facebook,
                        'twitter'   =>  $twitter,
                        'linkedin'  =>  $linkedin,
                        'interlink' =>  $interlink,
                        'contactid' =>  $contactid
                    ];
            echo json_encode($data);
        }
    }

    elseif(isset($_POST['update_contact'])) {
        $first         =    $_POST['first'];
        $last          =    $_POST['last'];
        $title         =    $_POST['title'];
        $report        =    $_POST['report'];
        $address       =    $_POST['address'];
        $phone         =    $_POST['phone'];
        $email         =    $_POST['email'];
        $fax           =    $_POST['fax'];
        $website       =    $_POST['website'];
        $facebook      =    $_POST['facebook'];
        $twitter       =    $_POST['twitter'];
        $linkedin      =    $_POST['linkedin'];
        $interlink     =    $_POST['interlink'];
        $user_id       =    $_COOKIE['ID'];
        $contactid     =    $_POST['contactid'];

        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship_More_Contacts SET First_Name=?, Last_Name=?, C_Title=?, Report_to=?, C_Address=?, C_Phone=?, C_Email=?, C_Fax=?, contact_website=?, contact_facebook=?, contact_twitter=?, contact_linkedin=?, contact_interlink=? WHERE C_ids=?");
        
        if($stmt  === false) {
            echo "Error preparing Statement: ". $conn->error;
            exit;
        }

        $stmt->bind_param("sssssssssssssi", $first, $last, $title, $report, $address, $phone, $email, $fax, $website, $facebook, $twitter, $linkedin, $interlink, $contactid);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo "Contact updated successfully";
        } else {
            echo "No changes made to the contact";
        }

        $stmt->close();
        $conn->close();
    }

    elseif(isset($_POST["get_contact_references"])) {
        $reference_id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("
            SELECT 
                CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                r.reference_id, 
                r.Title, 
                r.Description, 
                DATE_FORMAT(r.Date_Added, '%M %e, %Y') AS added, 
                DATE_FORMAT(r.Date_End, '%M %e, %Y') AS end, 
                DATE_FORMAT(r.default_reference_added, '%M %e, %Y') AS inserted, 
                r.Documents 
            FROM 
                tbl_Customer_Relationship_References r 
            JOIN 
                tbl_user u 
            ON 
                r.user_cookies = u.ID 
            WHERE 
                crm_ids = ?
        ");
        $stmt->bind_param('i', $reference_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $reference_id, $title, $description, $added, $end, $inserted, $document);
        $references = [];
        while ($stmt->fetch()) {
            $references[] = [
                'name'        => $name, 
                'id'          => $reference_id, 
                'title'       => $title,
                'description' => $description,
                'added'       => $added,
                'end'         => $end,
                'inserted'    => $inserted,
                'documents'   => $document
            ];
        }
        echo json_encode($references);
    }

    elseif(isset($_POST["get_references_details"])) {
        $reference_id = $_POST['id'];
        $stmt = $conn->prepare("SELECT CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                        r.reference_id, 
                        r.Title, 
                        r.Description, 
                        DATE_FORMAT(r.Date_Added, '%Y-%m-%d') AS added, 
                        DATE_FORMAT(r.Date_End, '%Y-%m-%d') AS end, 
                        DATE_FORMAT(r.default_reference_added, '%Y-%m-%d') AS inserted, 
                        r.Documents 
                        FROM tbl_Customer_Relationship_References r 
                        JOIN tbl_user u ON r.user_cookies = u.ID 
                        WHERE r.reference_id = ?");
        if($stmt === false) { 
            echo 'Error preparing Statement: '. $conn->error;
            exit;
        }
        $stmt->bind_param('i', $reference_id);
        $stmt->execute();
        $stmt->bind_result($name, $id, $title, $description, $added, $end, $inserted, $document);
        if($stmt->fetch()) {
            $data = [
                        'name'          =>  $name, 
                        'id'            =>  $id, 
                        'title'         =>  $title,
                        'description'   =>  $description,
                        'added'         =>  $added,
                        'end'           =>  $end,
                        'inserted'      =>  $inserted,
                        'documents'     =>  $document
                    ];
            echo json_encode($data);
        }
    }

    elseif(isset($_POST['add_references'])) {
        $user_id       = $_COOKIE['ID'];
        $contactid     = $_POST['contactid'];
        $title         = $_POST['title'];
        $description   = $_POST['description'];
        $added         = $_POST['added'];
        $expiration    = $_POST['ended'];

        $file = $_FILES['reference']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $filename_parts = explode(".", $_FILES['reference']['name']);
        $extension = end($filename_parts);
        $rand = rand(10,1000000);
        $to_File_Documents = $rand." - ".$filename.".".$extension;

        $upload_dir = "../Customer_Relationship_files_Folder/";

        // Check if the upload directory exists, if not, create it
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory with full permissions
        }

        $Documents = mysqli_real_escape_string($conn, $to_File_Documents);

        if (move_uploaded_file($_FILES['reference']['tmp_name'], $upload_dir . $to_File_Documents)) {
            $stmt = $conn->prepare("INSERT INTO tbl_Customer_Relationship_References (Title, Description, Date_Added, Date_End, Documents, user_cookies, crm_ids) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssii", $title, $description, $added, $expiration, $Documents, $user_id, $contactid);
            $stmt->execute();
            echo "New notes added successfully";

            $stmt->close();
            $conn->close();
        } else {
            echo "Error uploading file.";
        }
    }

    elseif(isset($_POST['update_references'])) {
        $reference_id  = $_POST['reference_id'];
        $user_id       = $_COOKIE['ID'];
        // $contactid     = $_POST['contactid'];
        $title         = $_POST['title'];
        $description   = $_POST['description'];
        $added         = $_POST['added'];
        $expiration    = $_POST['ended'];
        $old_file      = $_POST['old_file'];

        // Initialize $Documents variable
        $Documents = $old_file;

        // Check if a new file is being uploaded
        if (!empty($_FILES['reference']['name'])) {
            $file = $_FILES['reference']['name'];
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $filename_parts = explode(".", $_FILES['reference']['name']);
            $extension = end($filename_parts);
            $rand = rand(10,1000000);
            $to_File_Documents = $rand." - ".$filename.".".$extension;

            $upload_dir = "../Customer_Relationship_files_Folder/";

            // Check if the upload directory exists, if not, create it
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create the directory with full permissions
            }

            // Delete the old file
            if (!empty($old_file)) {
                unlink($upload_dir . $old_file); // Delete the old file
            }

            // Upload the new file
            if (move_uploaded_file($_FILES['reference']['tmp_name'], $upload_dir . $to_File_Documents)) {
                // Set $Documents to the new file name
                $Documents = mysqli_real_escape_string($conn, $to_File_Documents);
            } else {
                echo "Error uploading file.";
                exit;
            }
        }

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship_References SET Title=?, Description=?, Date_Added=?, Date_End=?, Documents=? WHERE reference_id=?");
        $stmt->bind_param("sssssi", $title, $description, $added, $expiration, $Documents, $reference_id);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo "References updated successfully";
        } else {
            echo "No changes made to the references";
        }

        $stmt->close();
        $conn->close();
    }

    elseif(isset($_POST['update_about'])) {
        $contact_id      = $_POST['contact_id'];
        $account_about   = $_POST['account_about'];
    
        $sql = "UPDATE tbl_Customer_Relationship SET account_about = ? WHERE crm_id = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param('si', $account_about, $contact_id);
    
            if ($stmt->execute()) {
                $response = array('status' => 'success', 'message' => "Details updated Successfully!");
            } else {
                $response = array('status' => 'error', 'message' => "Error updating record:  '. $stmt->error .'");
            }
            
            echo json_encode($response);
    
            $stmt->close();
        }
    }

    elseif(isset($_POST['update_product_services'])) {
        $contact_id     = $_POST['contact_id'];
        $product        = $_POST['account_product'];
        $service        = $_POST['account_service'];
        $industry       = $_POST['account_industry'];
        $category       = $_POST['account_category'];
        $certification  = $_POST['account_certification'];
    
        $sql = "UPDATE tbl_Customer_Relationship SET account_product = ?, account_service = ?, account_industry = ?, account_category = ?, account_certification = ? WHERE crm_id = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param('sssssi', $product, $service, $industry, $category, $certification, $contact_id);
    
            if ($stmt->execute()) {
                $response = array('status' => 'success', 'message' => "Details updated Successfully!");
            } else {
                $response = array('status' => 'error', 'message' => "Error updating record:  '. $stmt->error .'");
            }
            
            echo json_encode($response);
    
            $stmt->close();
        }
    }

    // Email Tab
    elseif(isset($_POST['get_contact_emails'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("SELECT mail_id as mailid,
                    CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                    m.Subject AS subject, 
                    m.Recipients AS recipient,
                    DATE_FORMAT(m.mail_date, '%M %e, %Y') AS date 
                FROM 
                    tbl_Customer_Relationship_Mailing m
                LEFT JOIN 
                    tbl_user u ON u.ID = m.user_cookies
                WHERE 
                    crm_ids = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mailid, $name, $subject, $recipient, $date);
        $emails = [];
        while ($stmt->fetch()) {
            $emails[] = [
                'id' => $id,
                'mailid'   => $mailid,
                'name' => $name,
                'subject' => $subject,
                'recipient' => $recipient,
                'date' => $date,
            ];
        }
        echo json_encode($emails);
    }

    elseif(isset($_POST['get_contact_campaigns'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("SELECT c.Campaign_Id AS id,
                    CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                    c.Campaign_Subject AS subject, 
                    c.Campaign_Recipients AS recipient,
                    c.Campaign_Name AS campaign,
                    c.Frequency AS frequency,
                    c.Auto_Send_Status AS status,
                    DATE_FORMAT(c.date_execute, '%M %e, %Y') AS date 
                FROM 
                    tbl_Customer_Relationship_Campaign c
                LEFT JOIN 
                    tbl_user u ON u.ID = c.userID
                WHERE 
                    c.crm_ids = ? AND c.Campaign_Status = 2");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $subject, $recipient, $campaign, $frequency, $status, $date);
        $campaigns = [];
        while ($stmt->fetch()) {
            $campaigns[] = [
                'id' => $id,
                'name' => $name,
                'subject' => $subject,
                'recipient' => $recipient,
                'campaign' => $campaign,
                'frequency' => $frequency,
                'status' => $status,
                'date' => $date,
            ];
        }
        echo json_encode($campaigns);
    }

    elseif(isset($_POST['get_contact_fse'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $stmt = $conn->prepare("SELECT c.FSE_id AS id,
                    CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                    c.FSE_Title AS title, 
                    c.FSE_Description AS description,
                    c.FSE_Documents AS document,
                    c.FSE_Source_Link AS link,
                    DATE_FORMAT(c.FSE_Event_Date, '%M %e, %Y') AS event,
                    DATE_FORMAT(c.FSE_Date_Added, '%M %e, %Y') AS date 
                FROM 
                    tbl_Customer_Relationship_FSE c
                LEFT JOIN 
                    tbl_user u ON u.ID = c.FSE_Addedby
                WHERE 
                    c.crm_ids = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $title, $description, $document, $link, $event, $date);
        $fses = [];
        while ($stmt->fetch()) {
            $fses[] = [
                'id' => $id,
                'name' => $name,
                'title' => $title,
                'description' => $description,
                'document' => $document,
                'link' => $link,
                'event' => $event,
                'date' => $date,
            ];
        }
        echo json_encode($fses);
    }

    elseif(isset($_POST['get_projects'])) {
        $stmt = $conn->prepare("SELECT s.MyPro_id AS id, s.Project_Name AS project, s.Project_Description AS description, 
                        DATE_FORMAT(s.Start_Date, '%M %e, %Y') AS start, 
                        DATE_FORMAT(s.Desired_Deliver_Date, '%M %e, %Y') AS due 
                    FROM 
                        tbl_MyProject_Services s 
                    LEFT JOIN 
                        tbl_myproject_services_assigned a ON a.MyPro_PK = s.MyPro_id 
                    WHERE 
                        s.user_cookies = 456 AND Project_status != 2");
        // $stmt->bind_param('i', $_COOKIE['ID']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $project, $description, $start, $due);
        $projects = [];
        while ($stmt->fetch()) {
            $projects[] = [
                'id' => $id,
                'project' => $project,
                'description' => $description,
                'start' => $start,
                'due' => $due
            ];
        }
        echo json_encode($projects);
    }

    if(isset($_POST['get_campaign_message'])) {
        $id = $_POST['id'];
        $sql = "SELECT Campaign_body FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($message);
        
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

    elseif(isset($_POST["get_campaign_details"])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("SELECT c.Campaign_Id AS id,
                    CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name, 
                    c.Campaign_Subject AS subject, 
                    c.Campaign_Recipients AS recipient,
                    c.Campaign_Name AS campaign,
                    c.Frequency AS frequency,
                    c.Campaign_Body AS message,
                    c.Auto_Send_Status AS status,
                    DATE_FORMAT(c.date_execute, '%M %e, %Y') AS date 
                FROM 
                    tbl_Customer_Relationship_Campaign c
                LEFT JOIN 
                    tbl_user u ON u.ID = c.userID
                WHERE 
                    c.Campaign_Id = ?");
        if($stmt === false) { 
            echo 'Error preparing Statement: '. $conn->error;
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $subject, $recipient, $campaign, $frequency, $message, $status, $date);
        if($stmt->fetch()) {
            $campaigns = [
                    'id' => $id,
                    'name' => $name,
                    'message' => $message,
                    'subject' => $subject,
                    'recipient' => $recipient,
                    'campaign' => $campaign,
                    'frequency' => $frequency,
                    'status' => $status,
                    'date' => $date
                ];
            echo json_encode($campaigns);
        }
    }

    elseif(isset($_POST['update_campaign'])) {
        $campaign      = $_POST['campaign'];
        $recipient     = $_POST['recipient'];
        $subject       = $_POST['subject'];
        $body          = $_POST['body'];
        $status        = $_POST['status'];
        $campaignid    = $_POST['campaignid'];

        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship_Campaign SET Campaign_Name=?, Campaign_Recipients=?, Campaign_Subject=?, Campaign_body=?, Auto_Send_Status=? WHERE Campaign_Id=?");

        if($stmt === false) {
            echo json_encode(["status" => "error", "message" => "Error preparing Statement: ". $conn->error]);
            exit;
        }

        $stmt->bind_param("sssssi", $campaign, $recipient, $subject, $body, $status, $campaignid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Campaign updated successfully"]);
        } else {
            echo json_encode(["status" => "info", "message" => "No changes made to the campaign"]);
        }

        $stmt->close();
        $conn->close();
    }

    






