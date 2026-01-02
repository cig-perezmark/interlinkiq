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
    
    $sender_name = 'InterlinkIQ';
    $sender_email = 'services@interlinkiq.com';
    $sender[$sender_email] = $sender_name;
    
    
    $selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
    if ( mysqli_num_rows($selectAPI) > 0 ) {
        $rowAPI = mysqli_fetch_array($selectAPI);
        $api_key = $rowAPI["ID"]; // 32 chars for AES-256
        $api_iv = openssl_random_pseudo_bytes(16);
    }
    
    $selectData = mysqli_query( $conn,"
        SELECT
        s.ID AS s_ID,
        s.last_modified AS s_last_modified,
        s.date_added AS s_date_added,
        s.frequency AS s_frequency,
        s.notification AS s_notification,
        s.document AS s_document,
        s.document_other AS s_document_other,
        s.name AS s_name,
        s.email AS s_email,
        s.facility_switch AS s_facility_id,
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
        AND s.page = 1
        AND s.notification = 1
        AND s.user_id != 1684
        AND (
            (s.document != '' AND s.document IS NOT NULL) OR (s.document_other != '' AND s.document_other IS NOT NULL) 
        )
    " );
    if ( mysqli_num_rows($selectData) > 0 ) {
        while($rowData = mysqli_fetch_array($selectData)) {
            $s_ID = $rowData['s_ID'];
            $s_user_id = $rowData['s_user_id'];
            $s_facility_id = $rowData['s_facility_id'];
            $client_ID = $rowData['u_client'];
            $client_url = $rowData['c_url'];
            $s_frequency = $rowData['s_frequency'];
            
            // Encrypt
            $api_encrypted_d = openssl_encrypt($s_ID, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
            $api_encrypted_u = openssl_encrypt($s_user_id, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
            $api_encrypted_f = openssl_encrypt($s_facility_id, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
    
            // URL-safe encoding
            $api_encoded_d = urlencode(base64_encode($api_iv . $api_encrypted_d));
            $api_encoded_u = urlencode(base64_encode($api_iv . $api_encrypted_u));
            $api_encoded_f = urlencode(base64_encode($api_iv . $api_encrypted_f));
            
            $proceed = true;
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
                    CURDATE() AS file_datenow,
                    d.reviewed_by,
                    d.approved_by
                    FROM tbl_supplier_requirement AS r
    
                    RIGHT JOIN (
                        SELECT
                        ID,
                        user_id,
                        supplier_id,
                        name,
                        file,
                        file_date,
                        file_due,
                        reviewed_by,
                        approved_by
                        FROM tbl_supplier_document
                        WHERE type = 0
                        AND user_id = $s_user_id
                        AND supplier_id = $s_ID
                        AND file != '' 
                        AND file IS NOT NULL
                        AND STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE()
                        AND (reviewed_by = 0 OR approved_by = 0)
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
                            AND file != '' 
                            AND file IS NOT NULL
                            AND STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE()
                            AND (reviewed_by = 0 OR approved_by = 0)
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
                // $to = 'lreyes@marukan-usa.com';
    
                $data_company = htmlentities($rowData['u_name'] ?? '');
                if (!empty($rowData['e_name'])) { $data_company = htmlentities($rowData['e_name'] ?? ''); }
    
                $data_email = $rowData['u_email'];
                if (!empty($rowData['e_email'])) { $data_email = htmlentities($rowData['e_email'] ?? ''); }
    
                if (!empty($requirement_email)) {
                    $subject2 = 'Supplier Module - For Review/Approval - '.date('Ymd');
                    $body2_extra = 'Hi '.$data_company.'<br><br>';
    
                    $body2 = $user.' has successfully uploaded the required documents. You may now proceed with reviewing and approving the documents.';
    
                    if ($s_user_id == 1486) {
                        $recipients = array();
                        $recipients_name = $data_company;
                        $recipients_email = $data_email;
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Lizbeth Reyes';
                        $recipients_email = 'lreyes@marukan-usa.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Virginia Wageyen';
                        $recipients_email = 'virginia@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $body2 .= '<br>
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
    
                        Should you need assistance, kindly call 202-982-3002 or email at csuccess@consultareinc.com<br><br>
    
                        InterlinkIQ Team,<br>
                        Consultare Inc. Group<br>
                        '.$data_company.' Team';
                        
                        
                        php_mailer_dynamic($sender, $recipients, $subject2, $body2_extra.$body2);
                    } else {
                        $recipients = array();
                        // $recipients_name = $data_company;
                        // $recipients_email = $data_email;
                        // $recipients[$recipients_email] = $recipients_name;
                        
                        // $recipients_name = 'Gregy '.$s_ID;
                        // $recipients_email = 'greeg+'.$s_ID.'@consultareinc.com';
                        // $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Christopher Santianez';
                        $recipients_email = 'chris@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Ezra Mabutas';
                        $recipients_email = 'ezra@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Sophia Baria';
                        $recipients_email = 'sophia@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Sophia Baria';
                        $recipients_email = 'sophia.baria.qms@gmail.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Arnel Ryan';
                        $recipients_email = 'arnel@consultareinc.com ';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Virginia Wageyen';
                        $recipients_email = 'virginia@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'CIG Services';
                        $recipients_email = 'services@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $recipients_name = 'Maria Alyn Tarray';
                        $recipients_email = 'alyn@consultareinc.com';
                        $recipients[$recipients_email] = $recipients_name;
                        
                        $body2 .= '<br><ol>';
    
                            $requirement_arr = explode(" | ", $requirement_email);
                            foreach ($requirement_arr as $value) {
                                $body2 .= '<li>'.$value.'</li>';
                            }
    
                        $body2 .= '</ol><br><br>
                        
                        Click <a href="'.$base_url.'supplier?d='.$api_encoded_d.'&u='.$api_encoded_u.'&f='.$api_encoded_f.'" target="_blank">here</a> to view<br><br>
    
                        Should you need assistance, kindly call 202-982-3002 or email at csuccess@consultareinc.com<br><br>
    
                        InterlinkIQ Team,<br>
                        Consultare Inc. Group<br>
                        '.$data_company.' Team';
                        
                        php_mailer_dynamic($sender, $recipients, $subject2, $body2_extra.$body2);
                    }
                }
            }
        }
    }
?>