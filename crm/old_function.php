    <?php
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
    	
    	function php_mailer($from, $to, $user, $subject, $body) {
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
        
        if(isset($_POST['filter_value'])) { // Filter data through date
            $column = $_POST['column'];
            $value = $_POST['value'];
            $output = '';
            // Filter data by date 
            if($column == 'crm_date_added') {
                $sql = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                        WHERE LENGTH(account_name) > 0
                        AND crm_date_added >= DATE_SUB(NOW(), INTERVAL $value)
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        if(employerID($userID) == $user_id) {
                            $default_added = date_create($row['crm_date_added']);
                            $output .= '
                            <tr>
                                <td>'.$row["account_rep"].'</td>
                                <td>'.date_format($default_added,"F d, Y").'</td>
                                <td>'.$row["account_name"].'</td>
                                <td width="250px">'.$row["account_email"].'</td>
                                <td>'.$row["account_phone"].'</td>
                                <td>'.$row["account_address"].'</td>
                                <td>'.$row["account_certification"].'</td>
                                <td>'.$row["Account_Source"].'</td>
                                <td>'.$row["account_category"].'</td>
                                <td>'.$row["latest_campaign_added"].'</td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["account_status"].'</td>
                                <td>
                                   <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                   <i class="icon-eye"></i> View </a>
                                </td>
                            </tr>';
                        }
                    }
                    echo $output;
                }
            } elseif($column == 'account_status') { // Filter data by category/status 
                $sql = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                        WHERE $column = '$value'
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        if(employerID($userID) == $user_id) {
                            $default_added = date_create($row['crm_date_added']);
                            $output .= '
                            <tr>
                                <td>'.$row["account_rep"].'</td>
                                <td>'.date_format($default_added,"F d, Y").'</td>
                                <td>'.$row["account_name"].'</td>
                                <td width="250px">'.$row["account_email"].'</td>
                                <td>'.$row["account_phone"].'</td>
                                <td>'.$row["account_address"].'</td>
                                <td>'.$row["account_certification"].'</td>
                                <td>'.$row["Account_Source"].'</td>
                                <td>'.$row["account_category"].'</td>
                                <td>'.$row["latest_campaign_added"].'</td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["account_status"].'</td>
                                <td>
                                    <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                    <i class="icon-eye"></i> View </a>
                                </td>
                            </tr>';
                        }
                    }
                    echo $output;
                }
            }
        }
        
        if (isset($_POST['filter_range'])) { // filter contacts by date ranges

            $from = $_POST['from'];
            $from_date = date_create($from);
            $rfrom = date_format($from_date, "Y-m-d");
        
            $to = $_POST['to'];
            $to_date = date_create($to);
            $rto = date_format($to_date, "Y-m-d");
        
            $sql = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                    WHERE crm_date_added BETWEEN ? AND ?
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
        
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $rfrom, $rto);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $crm_date_added = date_create($row["crm_date_added"]);
                    $output .= '
                        <tr>
                            <td>'.$row["account_rep"].'</td>
                            <td>'.date_format($crm_date_added, "F d, Y").'</td>
                            <td>'.$row["account_name"].'</td>
                            <td width="250px">'.$row["account_email"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["account_address"].'</td>
                            <td>'.$row["account_certification"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td>'.$row["account_category"].'</td>
                            <td>'.$row["latest_campaign_added"].'</td>
                            <td>'.$row["uploader"].'</td>
                            <td>'.$row["account_status"].'</td>
                            <td>
                                <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                <i class="icon-eye"></i> View </a>
                            </td>
                        </tr>';
                }
        
                echo $output;
            } else {
                echo 'No data Found!';
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }

        
        if(isset($_POST['query'])) { // get all contact
            $output = '';
            $query = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                    WHERE LENGTH(account_name) > 0 
                        AND crm_date_added >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added;
                ";
                    
            $result = mysqli_query($conn, $query);
            
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    if(employerID($userID) == $user_id) {
                        $default_added = date_create($row['crm_date_added']);
                        $campaign_date = date_create($row['latest_campaign_added']);
                        $output .= '
                        <tr>
                            <td>'.$row["account_rep"].'</td>
                            <td>'.date_format($default_added,"F d, Y").'</td>
                            <td>'.$row["account_name"].'</td>
                            <td width="250px">'.$row["account_email"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["account_address"].'</td>
                            <td>'.$row["account_certification"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td>'.$row["account_category"].'</td>
                            <td>'.$row["latest_campaign_added"].'</td>
                            <td>'.$row["uploader"].'</td>
                            <td>'.$row["account_status"].'</td>
                            <td>
                                 <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                               <i class="icon-eye"></i> View </a>
                            </td>
                        </tr>';
                    }
                }
             echo $output;
            }
        }
        
        if(isset($_POST['search_contact'])) {  // get searched contact by account name
            $output = '';
            $searchValue = $_POST['searchVal'];
            $query = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                   WHERE  account_name LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                   GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                    
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    if(employerID($userID) == $user_id) {
                        $default_added = date_create($row['crm_date_added']);
                        $output .= '
                        <tr>
                            <td>'.$row["account_rep"].'</td>
                            <td>'.date_format($default_added,"F d, Y").'</td>
                            <td>'.$row["account_name"].'</td>
                            <td width="250px">'.$row["account_email"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["account_address"].'</td>
                            <td>'.$row["account_certification"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td>'.$row["account_category"].'</td>
                            <td>'.$row["latest_campaign_added"].'</td>
                            <td>'.$row["uploader"].'</td>
                            <td>'.$row["account_status"].'</td>
                            <td>
                                 <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                               <i class="icon-eye"></i> View </a>
                            </td>
                        </tr>';
                    }
                }
             echo $output;
            }
        }
        
        if(isset($_POST['search_contact_email'])) {
            $output = '';
            $searchValue = $_POST['searchEmailVal'];
            $query = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                        CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                        MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                    WHERE tbl_Customer_Relationship.account_email LIKE '%$searchValue%' AND LENGTH(tbl_Customer_Relationship.account_name) > 0
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
        
            $result = mysqli_query($conn, $query);
        
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    if(employerID($userID) == $user_id) {
                        $default_added = date_create($row['crm_date_added']);
                        $output .= '
                            <tr>
                                <td>'.$row["account_rep"].'</td>
                                <td>'.date_format($default_added,"F d, Y").'</td>
                                <td>'.$row["account_name"].'</td>
                                <td width="250px">'.$row["account_email"].'</td>
                                <td>'.$row["account_phone"].'</td>
                                <td>'.$row["account_address"].'</td>
                                <td>'.$row["account_certification"].'</td>
                                <td>'.$row["Account_Source"].'</td>
                                <td>'.$row["account_category"].'</td>
                                <td>'.$row["latest_campaign_added"].'</td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["account_status"].'</td>
                                <td>
                                    <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                        <i class="icon-eye"></i> View
                                    </a>
                                </td>
                            </tr>';
                    }
                }
                echo $output;
            } else {
                echo "No results found.";
            }
        }

        
        if(isset($_POST['search_contact_phone'])) {  // get searched contact by account phone
            $output = '';
            $searchValue = $_POST['searchPhoneVal'];
            $query = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                   WHERE contact_phone LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                   GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                    
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    if(employerID($userID) == $user_id) {
                        $default_added = date_create($row['crm_date_added']);
                        $output .= '
                        <tr>
                            <td>'.$row["account_rep"].'</td>
                            <td>'.date_format($default_added,"F d, Y").'</td>
                            <td>'.$row["account_name"].'</td>
                            <td width="250px">'.$row["account_email"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["account_address"].'</td>
                            <td>'.$row["account_certification"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td>'.$row["account_category"].'</td>
                            <td>'.$row["latest_campaign_added"].'</td>
                            <td>'.$row["uploader"].'</td>
                            <td>'.$row["account_status"].'</td>
                            <td>
                                 <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                               <i class="icon-eye"></i> View </a>
                            </td>
                        </tr>';
                    }
                }
             echo $output;
            }
        }
        
        if(isset($_POST['search_contact_source'])) {  // get searched contact by account source
            $output = '';
            $searchValue = $_POST['searchSourceVal'];
            $query = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                   WHERE Account_Source LIKE '%".$searchValue."%' AND LENGTH(account_name) > 0
                   GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                    
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $userID = $row["userID"];
                    if(employerID($userID) == $user_id) {
                        $default_added = date_create($row['crm_date_added']);
                        $output .= '
                        <tr>
                            <td>'.$row["account_rep"].'</td>
                            <td>'.date_format($default_added,"F d, Y").'</td>
                            <td>'.$row["account_name"].'</td>
                            <td width="250px">'.$row["account_email"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["account_address"].'</td>
                            <td>'.$row["account_certification"].'</td>
                            <td>'.$row["Account_Source"].'</td>
                            <td>'.$row["account_category"].'</td>
                            <td>'.$row["latest_campaign_added"].'</td>
                            <td>'.$row["uploader"].'</td>
                            <td>'.$row["account_status"].'</td>
                            <td>
                                <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                               <i class="icon-eye"></i> View </a>
                            </td>
                        </tr>';
                    }
                }
             echo $output;
            }
        }
        
        if(isset($_POST['filter_campaign'])) { // Filter data through campaign date
            $slug = $_POST['slug'];
            $output = '';
            // Filter data by date 
            if($slug == 'has_campaign') {
                $sql = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                    CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                    MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                        WHERE LENGTH(account_name) > 0
                        AND LENGTH(tbl_Customer_Relationship_Campaign.Campaign_added) > 0
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        if(employerID($userID) == $user_id) {
                            $default_added = date_create($row['crm_date_added']);
                            $output .= '
                            <tr>
                                <td>'.$row["account_rep"].'</td>
                                <td>'.date_format($default_added,"F d, Y").'</td>
                                <td>'.$row["account_name"].'</td>
                                <td width="250px">'.$row["account_email"].'</td>
                                <td>'.$row["account_phone"].'</td>
                                <td>'.$row["account_address"].'</td>
                                <td>'.$row["account_certification"].'</td>
                                <td>'.$row["Account_Source"].'</td>
                                <td>'.$row["account_category"].'</td>
                                <td>'.$row["latest_campaign_added"].'</td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["account_status"].'</td>
                                <td>
                                   <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                   <i class="icon-eye"></i> View </a>
                                </td>
                            </tr>';
                        }
                    }
                    echo $output;
                }
            } elseif($slug == 'no_campaign') { // Filter data by category/status 
                $sql = "SELECT
                        tbl_Customer_Relationship.crm_id, 
                        tbl_Customer_Relationship.userID, 
                        tbl_Customer_Relationship.crm_date_added, 
                        tbl_Customer_Relationship.account_rep, 
                        tbl_Customer_Relationship.account_name, 
                        tbl_Customer_Relationship.account_email, 
                        tbl_Customer_Relationship.account_phone, 
                        tbl_Customer_Relationship.account_address, 
                        tbl_Customer_Relationship.account_certification, 
                        tbl_Customer_Relationship.Account_Source, 
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status,
                        CONCAT(tbl_user.first_name, ' ', tbl_user.last_name) AS uploader,
                        MAX(tbl_Customer_Relationship_Campaign.Campaign_added) AS latest_campaign_added
                    FROM tbl_Customer_Relationship
                    LEFT JOIN tbl_Customer_Relationship_Campaign
                        ON tbl_Customer_Relationship.crm_id = tbl_Customer_Relationship_Campaign.crm_ids
                    LEFT JOIN tbl_user
                        ON tbl_Customer_Relationship.userID = tbl_user.ID
                    GROUP BY
                        tbl_Customer_Relationship.crm_id,
                        tbl_Customer_Relationship.userID,
                        tbl_Customer_Relationship.crm_date_added,
                        tbl_Customer_Relationship.account_rep,
                        tbl_Customer_Relationship.account_name,
                        tbl_Customer_Relationship.account_email,
                        tbl_Customer_Relationship.account_phone,
                        tbl_Customer_Relationship.account_address,
                        tbl_Customer_Relationship.account_certification,
                        tbl_Customer_Relationship.Account_Source,
                        tbl_Customer_Relationship.account_category,
                        tbl_Customer_Relationship.account_status
                    ORDER BY tbl_Customer_Relationship.crm_date_added;
                    ";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $userID = $row["userID"];
                        if(employerID($userID) == $user_id) {
                            if(empty($row["latest_campaign_added"])) {
                              $default_added = date_create($row['crm_date_added']);
                              $output .= '
                                <tr>
                                    <td>'.$row["account_rep"].'</td>
                                    <td>'.date_format($default_added,"F d, Y").'</td>
                                    <td>'.$row["account_name"].'</td>
                                    <td width="250px">'.$row["account_email"].'</td>
                                    <td>'.$row["account_phone"].'</td>
                                    <td>'.$row["account_address"].'</td>
                                    <td>'.$row["account_certification"].'</td>
                                    <td>'.$row["Account_Source"].'</td>
                                    <td>'.$row["account_category"].'</td>
                                    <td>'.$row["latest_campaign_added"].'</td>
                                    <td>'.$row["uploader"].'</td>
                                    <td>'.$row["account_status"].'</td>
                                    <td>
                                        <a class="btn btn-sm blue" href="customer_relationship_View.php?view_id='.$row['crm_id'].'">
                                        <i class="icon-eye"></i> View </a>
                                    </td>
                                </tr>';  
                            }
                        }
                    }
                    echo $output;
                }
            }
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
 
        if (isset($_POST['get_notification_count'])) { // Notification Count
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
        
        if (isset($_POST['get_crm_remarks'])) { // Message/Chat/Remarks Threads
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
        
        if (isset($_POST['update_details_account'])) {
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
        
            // Assuming $conn is your mysqli connection object
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
        	
             $sql = "INSERT INTO 
                        tbl_Customer_Relationship (
                            account_rep, 
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
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
        
            if (!$stmt) {
                die('Error in preparing statement: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssiis", 
                $account_rep, 
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
                echo '<script>window.location.href = "/Customer_Relationship_Management";</script>';
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
        
        if (isset($_POST['btn_Multi_acct_submit'])) {
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
        
            // Validate whether the selected file is a CSV file
            if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileTypes)) {
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                fgetcsv($csvFile);
                
                // Prepare the statement
                $stmt = mysqli_prepare($conn, "INSERT INTO tbl_Customer_Relationship(account_rep, account_name, account_email, account_phone, account_fax, account_address, account_website, account_facebook, account_twitter, account_linkedin, account_interlink, account_product, account_service, account_certification, userID, Account_Source, mutiple_added, crm_date_added) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
                // Check for errors in preparation
                if (!$stmt) {
                    die('Error in preparing statement: ' . mysqli_error($conn));
                }
        
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $account_rep, $account_name, $to_mail, $account_phone, $account_fax, $account_address, $account_website, $account_facebook, $account_twitter, $account_linkedin, $account_interlink, $account_product, $account_service, $account_certification, $userID, $Account_Source, $today);
        
                while (($getData = fgetcsv($csvFile, 10000, ",")) !== false) {
                    // Get row data
                    $account_rep = 'InterlinkIQ';
                    $account_name = mysqli_real_escape_string($conn, $getData[0]);
                    $to_mail = mysqli_real_escape_string($conn, $getData[1]);
                    $account_phone = mysqli_real_escape_string($conn, $getData[2]);
                    $account_fax = mysqli_real_escape_string($conn, $getData[3]);
                    $account_address = mysqli_real_escape_string($conn, $getData[4]);
                    $account_website = mysqli_real_escape_string($conn, $getData[5]);
                    $account_facebook = mysqli_real_escape_string($conn, $getData[6]);
                    $account_twitter = mysqli_real_escape_string($conn, $getData[7]);
                    $account_linkedin = mysqli_real_escape_string($conn, $getData[8]);
                    $account_interlink = mysqli_real_escape_string($conn, $getData[9]);
                    $account_product = mysqli_real_escape_string($conn, $getData[10]);
                    $account_service = mysqli_real_escape_string($conn, $getData[11]);
                    $account_certification = mysqli_real_escape_string($conn, $getData[12]);
                    $Account_Source = mysqli_real_escape_string($conn, $getData[13]);
        
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                }
        
                // Close the statement
                mysqli_stmt_close($stmt);
        
                fclose($csvFile);
                
                echo '<script>window.location.href = "Customer_Relationship_Management";</script>';
            } else {
                echo "Please select a valid file";
            }
        }
        
    ?>