<?php
    include(__DIR__ . '/../database_iiq.php');
    include(__DIR__ . '/../PHPMailer/config.php');
    $base_url = "https://interlinkiq.com/";
    $local_date = date('Y-m-d');


    $sender = array();
    $sender_name = 'Interlink IQ';
    $sender_email = 'services@interlinkiq.com';
    $sender[$sender_email] = $sender_name;
    
    
    // Reference for Frequency
    // <select class="form-control" name="supplier_frequency" onchange="changeFrequency(this.value)">
    //     <option value="1">Once Per Day</option>
    //     <option value="2" selected="">Once Per Week</option>
    //     <option value="3">On the 1st and 15th of the Month</option>
    //     <option value="4">Once Per Month</option>
    //     <option value="6">Once Per Two Months (Every Other Month)</option>
    //     <option value="7">Once Per Three Months (Quarterly)</option>
    //     <option value="8">Once Per Six Months (Bi-Annual)</option>
    //     <option value="5">Once Per Year</option>
    //     <option value="9">Every 20 Days</option>
    // </select>
    
    // Frequency base on cron
    // 1 = 0 0 * * * (Once Per Day)
    // 2 = 0 0 * * 0 (Once Per Week)
    // 3 = 0 0 1,15 * * (On the 1st and 15th of the Month)
    // 4 = 0 0 1 * * (Once Per Month)
    // 6 = 0 0 */2 * * (Once Per Two Months / Every Other Month)
    // 7 = 0 0 */4 * * (Once Per Three Months / Quarterly)
    // 8 = 0 0 */7 * * (Once Per Six Month / Bi-Annual)
    // 5 = 0 0 1 1 * (Once Per Year)
    // 9 = 0 0 * * * (Every 20 Days)
    
    $current_minute = intval(date('i')); // 0 - 59
    $current_hour = date("G"); // 1 - 24
    $current_day = date("j"); // 1 - 31
    $current_month = date("n"); // 1 - 12
    $current_weekday = date('N', strtotime(date("l"))); // 0 - 6
    
    $selectData = mysqli_query( $conn,"
        SELECT
        s.ID AS s_ID,
        s.last_modified AS s_last_modified,
        s.date_added AS s_date_added,
        s.frequency AS s_frequency,
        s.notification AS s_notification,
        s.document AS s_document,
        s.document_other AS s_document_other,
        s.address AS s_address,
        LEFT(s.address, 2) AS s_country,
        s.name AS s_name,
        s.email AS s_email,
        s.user_id AS s_user_id,
        CONCAT_WS(' ', u.first_name, u.last_name) AS u_name,
        u.email AS u_email,
        u.client AS u_client,
        CASE WHEN u.client != 0 THEN c.url ELSE 'login' END AS c_url,
        e.businessname AS e_name,
        e.businessemailAddress AS e_email
        FROM tbl_supplier AS s
        
        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email,
            client
            FROM tbl_user
        ) AS u
        ON u.ID = s.user_id
        
        LEFT JOIN (
            SELECT
            ID,
            url
            FROM tbl_user_client
        ) AS c
        ON c.ID = u.client
        
        LEFT JOIN (
        	SELECT
            users_entities,
            businessname,
            businessemailAddress
            FROM tblEnterpiseDetails
        ) AS e
        ON e.users_entities = s.user_id
        
        WHERE s.is_deleted = 0
        AND s.notification = 1
        AND s.page = 1
        -- AND s.ID = 2505
        -- AND s.status = 1
        AND (s.user_id = 1486 OR s.user_id = 1684)
        AND s.email != ''
        AND s.email IS NOT NULL
        AND (
            (s.document != '' AND s.document IS NOT NULL) OR (s.document_other != '' AND s.document_other IS NOT NULL) 
        )
    " );
    if ( mysqli_num_rows($selectData) > 0 ) {
        while($rowData = mysqli_fetch_array($selectData)) {
            $s_ID = $rowData['s_ID'];
            $s_user_id = $rowData['s_user_id'];
            $client_url = $rowData['c_url'];
            $s_frequency = $rowData['s_frequency'];
            // $s_notification = $rowData['s_notification'];
            $address_country = $rowData['s_country'];
            
            
            $proceed = false;
            if ($s_frequency == 1) { $proceed = true; }
            else if ($s_frequency == 2 AND $current_weekday == 0) { $proceed = true; }
            else if ($s_frequency == 3 AND ($current_day == 1 OR $current_day == 15)) { $proceed = true; }
            else if ($s_frequency == 4 AND $current_day == 1) { $proceed = true; }
            else if ($s_frequency == 5 AND $current_month == 1) { $proceed = true; }
            else if ($s_frequency == 6 AND ($current_month == 2 OR $current_month == 4 OR $current_month == 6 OR $current_month == 8 OR $current_month == 10 OR $current_month == 12)) { $proceed = true; }
            else if ($s_frequency == 7 AND ($current_month == 3 OR $current_month == 6 OR $current_month == 9 OR $current_month == 12)) { $proceed = true; }
            else if ($s_frequency == 8 AND ($current_month == 36 OR $current_month == 12)) { $proceed = true; }
            else if ($s_frequency == 9) {
                // $startDate = "2025-04-12";
                $startDate = $rowData['s_date_added'];
                $startDate = date_create($startDate);
                // $startDate = date_format($startDate, 'Y-m-d');
                
                $currentDate = date('Y-m-d');
                $currentDate = date_create($currentDate);
                // $currentDate = date_format($currentDate, 'Y-m-d');
                
                $diff = $currentDate->diff($startDate)->days;
                if ($diff % 20 === 0) { $proceed = true; }
            }


            if ($proceed == true) {
                // Requirement Section
                $s_document = $rowData['s_document'];
                $s_document_other = $rowData['s_document_other'];
                $requirement_email = "";
                $regulatory_email = "";
                $requirement = array();
                $regulatory = array();
    
                $sqlReq = ' ORDER BY r.name ';
                if ($s_user_id == 1486) {
                    $sqlReq = ' ORDER BY r.req ';
                }
                $selectRequirement = mysqli_query( $conn,"
                    SELECT 
                    r.name AS r_name,
                    r.req AS r_req,
                    r.regulatory AS r_regulatory,
                    d.file,
                    d.file_date,
                    d.file_due,
                    STR_TO_DATE(d.file_due, '%m/%d/%Y') AS file_fotmat,
                    CURDATE() AS file_datenow
                    FROM tbl_supplier_requirement AS r
    
                    RIGHT JOIN (
                        SELECT
                        ID,
                        user_id,
                        supplier_id,
                        name,
                        file,
                        file_date,
                        file_due
                        FROM tbl_supplier_document
                        WHERE type = 0
                        AND user_id = $s_user_id
                        AND supplier_id = $s_ID
                        AND (
                            file = '' OR file IS NULL OR
                            ( (file != '' OR file IS NOT NULL) AND STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() )
                        )
                    ) AS d
                    ON r.ID = d.name
    
                    WHERE FIND_IN_SET(r.ID, REPLACE(REPLACE('".$s_document."', ' ', ''), '|',','  )  ) > 0
                    
                    $sqlReq
                " );
                while($rowRequirement = mysqli_fetch_array($selectRequirement)) {
                    if ($s_user_id == 1486) {
                        $req = htmlentities($rowRequirement["r_req"] ?? '');
                        if (empty($req)) {
                            $req = htmlentities($rowRequirement["r_name"] ?? '');
                        }
    
                        array_push($requirement, $req);
                    } else {
                        array_push($requirement, htmlentities($rowRequirement["r_name"] ?? ''));
                    }
    
                    array_push($regulatory, htmlentities($rowRequirement["r_regulatory"] ?? ''));
                }
                if (!empty($s_document_other)) {
                    $document_other_arr = explode(" | ", $s_document_other);
                    foreach ($document_other_arr as $value) {
                        $selectDocument = mysqli_query( $conn,"
                            SELECT 
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1 
                            AND user_id = $s_user_id 
                            AND supplier_id = $s_ID 
                            AND name = '".$value."'
                            AND (
                                file = '' OR file IS NULL OR
                                (file != '' AND file IS NOT NULL AND file_due < CURDATE())
                            )
                        " );
                        if ( mysqli_num_rows($selectDocument) > 0 ) {
                            array_push($requirement, $value);
                        }
                    }
                }
                if (!empty($requirement)) { 
                    $requirement_email = implode(' | ', $requirement); 
                    $regulatory_email = implode(' | ', $regulatory); 
                }
    
    
                // Email Compose
                $user = htmlentities($rowData['s_name'] ?? '');
                $to = htmlentities($rowData['s_email'] ?? '');
                // $to = 'greeggimongala+'.$s_ID.'@gmail.com';
    
                $data_company = htmlentities($rowData['u_name'] ?? '');
                if (!empty($rowData['e_name'])) { $data_company = htmlentities($rowData['e_name'] ?? ''); }
    
                $data_email = $rowData['u_email'];
                if (!empty($rowData['e_email'])) { $data_email = htmlentities($rowData['e_email'] ?? ''); }
    
                // if ($rowData['u_client'] == 1) {
                //     $subject = 'Welcome to Cann OS!';
                //     $body_extra = '';
                //     $body = 'Be Green Legal, invites you to join <a href="'.$base_url.'CannOS-Login" target="_blank">Cann OS</a> to connect and share documents. If you experience difficulties opening the website, kindly use this link instead <a href="'.$base_url.'CannOS-Login" target="_blank">https://interlinkiq.com/CannOS-Login</a>.<br><br>
    
                //     Should you need assistance, kindly email <a href="mailto:nnelson@begreenlegal.com" target="_blank">nnelson@begreenlegal.com</a>.<br><br>
    
                //     Cann OS Team<br>
                //     BeGreen Legal';
                // } else {
                //     if ($s_user_id == 1684) {
                //         $subject = $data_company.' Supplier Invitation';
                //         $body_extra = 'Hi '.$user.',<br><br>';
                //         $body = 'Your customer, '.$data_company.', invites you to <a href="'.$base_url.$client_url.'" target="_blank">'.$client_name.'</a> Food Safety Management System Software managed by InterlinkIQ.com to connect and share documents to comply with Supplier Approval Program and/or Foreign Supplier Verification Programs for Food Importers Requirements.<br><br>
    
                //         Should you need assistance, kindly call 202-982-3002 or email <a href="mailto:'.$client_email.'">'.$client_email.'</a><br><br>
    
                //         '.$data_company.' Team';
                //     } else if ($s_user_id == 1486) {
                //         $subject = $data_company.' Supplier Invitation';
                //         $body_extra = 'Hi '.$user.',<br><br>';
                //         $body = 'Your customer, '.$data_company.', invites you to click on this <a href="'.$base_url.$client_url.'?sc=1" target="_blank">link</a> to connect and share documents to comply with Supplier Approval and/or Foreign Supplier Verification Programs Requirements.<br><br>
    
                //         <b>If you need assistance with uploading or updating your requirements, please contact us at csuccess@consultareinc.com or services@interlinkiq.com, telephone no. 202-982-3002 for support in navigating the portal.</b><br><br>
    
                //         Thank you,<br><br>
    
                //         '.$data_company.' Team';
                //     } else {
                //         $subject = $data_company.' Customer Invitation';
                //         $body_extra = 'Hi '.$user.',<br><br>';
                //         $body = 'Your supplier, '.$data_company.', invites you to <a href="'.$base_url.$client_url.'" target="_blank">'.$client_name.'</a> Food Safety Management System Software managed by InterlinkIQ.com to connect and share documents to comply with Supplier Approval Program Requirements.<br><br>
    
                //         Should you need assistance, kindly call 202-982-3002 or email <a href="mailto:csuccess@consultareinc.com">csuccess@consultareinc.com</a><br><br>
    
                //         Customer Success Team<br>
                //         Consultare Inc. Group';
                //     }
                // }
                // php_mailer_1($to, $user, $subject, $body_extra.$body, $data_email, $data_company);
    
                if (!empty($requirement_email)) {
                    $subject2 = 'Supplier Approval Requirements!';
                    if ($s_user_id == 1486 OR $s_user_id == 1684) {
                        $subject2 = $data_company.' Request for Supplier Documentation!';
                        $body2_extra = 'Hi '.$user.'<br><br>';
                    } else {
                        $body2_extra = 'Hi '.$user.' Food Safety Team,<br><br>';
                    }
    
                    if ($s_user_id == 254) {
                        $data_company = 'Jensen Meat Company (JMC)';
                        $body2 = 'We are working with '.$data_company.' as part of their Supplier Approval Program (SAP). The '.$user.' has been identified as a Supplier/Service Provider of Jensen Meat Company – Plant Based.<br><br>';
                        $body2 .= 'We are requesting certain documents from your firm to comply with the SAP 21 CFR 117 Subpart G - Supply-Chain Program';
                    } else if ($s_user_id == 1486) {
                        $body2 = 'Your client, '.$data_company.' has identified your company as a supplier and invites you to connect to <a href="'.$base_url.$client_url.'" target="_blank">'.$base_url.$client_url.'</a> and share documents to comply with the requirements of the 21 CFR Part 117 Subpart G - Supply Chain Program<br>';
                    } else {
                        $body2 = 'We are working with '.$data_company.' as part of their Supplier Approval Program (SAP). Your company has been identified as a Supplier/Service Provider of '.$data_company.'.<br><br>';
                        $body2 .= 'We are requesting certain documents from your firm to comply with the SAP 21 CFR 117 Subpart G - Supply-Chain Program';
                    }
    
                    if ($address_country != 'US') { $body2 .= ' / FSVP 21 CFR Subpart L - Foreign Supplier Verification Programs for Food Importers requirement'; }
    
                    if ($s_user_id == 1486) {
                        $body2 .= '.<br>
                        <table cellpadding="7" cellspacing="0" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center" style="width: 350px;">Requirements</th>
                                    <th class="text-center" style="width: 350px;">Regulatory Applicable Codes</th>
                                </tr>
                            </thead>
                            <tbody>';
    
                                $requirement_arr = explode(" | ", $requirement_email);
                                $regulatory_arr = explode(" | ", $regulatory_email);
                                $i = 1;
                                $ii = 0;
                                foreach ($requirement_arr as $value) {
                                    $body2 .= '<tr>
                                        <td class="text-center">'.$i++.'</td>
                                        <td>'.$value.'</td>
                                        <td>'.$regulatory_arr[$ii++].'</td>
                                    </tr>';
                                }
    
                            $body2 .= '</tbody>
                        </table><br><br>
    
                        You may upload the requested documents at <a href="'.$base_url.$client_url.'" target="_blank">'.$base_url.$client_url.'</a> just by following the instructions provided below, 
                        or you may contact our customer service team at csuccess@consultareinc.com, telephone no. 202-982-3002 to assist you in navigating the InterlinkIQ System.<br><br>
    
                        To update Compliance:<br>
                        <ol>
                            <li>Go to <a href="'.$base_url.$client_url.'" target="_blank">'.$base_url.$client_url.'</a> and click Log in. Enter your Username and Password.</li>
                            <li>Once successfully logged in, go to the Requirements Tab; comply by uploading the required documents listed and fill out all necessary details.</li>
                        </ol>
    
                        Please note that the submission deadline for the requested documents is <b>15 days</b> from the receipt of this email.<br><br>

                        If any submitted document or policy is updated, please resubmit the latest version.<br><br>
    
                        Thank you,<br><br>

                        Lizbeth Reyes<br>
                        Food Safety and Quality Manager<br>
                        '.$data_company.'<br>
                        562-602-8340 Ext. 109<br>
                        <img src="https://interlinkiq.com/companyDetailsFolder/449248%20-%20marukan%20logo.png" width="133"><br>
                        <a href="https://www.marukan-usa.com/" target="_blank">www.marukan-usa.com</a>';
                    } else {
                        $body2 .= '.<br><ol>';
    
                        $requirement_arr = explode(" | ", $requirement_email);
                        foreach ($requirement_arr as $value) {
                            $body2 .= '<li>'.$value.'</li>';
                        }
    
                        $body2 .= '</ol>';
                        $body2 .= 'Follow the instructions below:<br><br>
    
                        To update Compliance:<br>
                        <ol>
                            <li>Go to <a href="'.$base_url.$client_url.'" target="_blank">'.$base_url.$client_url.'</a> and click Log in. Enter your Username and Password.</li>
                            <li>Click Customer Module to view the list of your Customer.</li>
                            <li>Click View and go to Requirements Tab; comply by uploading the documents required in the list.</li>
                        </ol>
    
                        Should you need assistance, kindly call 202-982-3002 or email <a href="mailto:'.$data_email.'">'.$data_email.'</a><br><br>
    
                        InterlinkIQ Team,<br>
                        Consultare Inc. Group<br>
                        '.$data_company.' Team';
                    }
    
                    // echo $body2_extra.$body2;
                    php_mailer_2($to, $user, $subject2, $body2_extra.$body2, $data_email, $data_company);
                }
    
                // Email copy for contact
                // if (!empty($rowData['s_contact'])) {
                //     $data_contact_arr = explode(", ", $rowData['s_contact']);
                //     foreach ($data_contact_arr as $value) {
                //         $selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE notification = 1 AND ID = $value" );
                //         if ( mysqli_num_rows($selectContact) > 0 ) {
                //             while($rowContact = mysqli_fetch_array($selectContact)) {
                //                 // $to = htmlentities($rowContact["email"] ?? '');
                //                 $to = 'greeggimongala+'.$s_ID.'@gmail.com';
                //                 $user = htmlentities($rowContact["name"] ?? '');
    
                //                 $body2_extra = 'Hi '.$user.',<br><br>';
                //                 if ($rowData['u_client'] == 1) { $body2_extra = ''; }
    
                //                 // php_mailer_1($to, $user, $subject, $body2_extra.$body, $data_email, $data_company);
    
                //                 if (!empty($requirement_email)) {
                //                     $body2_extra = 'Hi '.$user.' Food Safety Team,<br><br>';
    
                //                     php_mailer_2($to, $user, $subject2, $body2_extra.$body2, $data_email, $data_company);
                //                 }
                //             }
                //         }
                //     }
                // }
            }
        }
    }
?>