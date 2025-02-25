<?php
    // include_once 'database_iiq.php';
    // $base_url = "https://interlinkiq.com/";
    // $local_date = date('Y-m-d');
    
    // $current_minute = intval(date('i')); // 0 - 59
    // $current_hour = date("G"); // 1 - 24
    // $current_day = date("j"); // 1 - 31
    // $current_month = date("n"); // 1 - 12
    // $current_weekday = date('N', strtotime(date("l"))); // 1 - 7

    // $current_date = date('Y-m-d');
    // $current_dateNow_o = date('Y/m/d');
    // $current_dateNow = new DateTime($current_dateNow_o);
    // $current_dateNow = $current_dateNow->format('M d, Y');


    // // PHP MAILER FUNCTION
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    // use PHPMailer\PHPMailer\Exception;
    // require 'PHPMailer/src/Exception.php';
    // require 'PHPMailer/src/PHPMailer.php';
    // require 'PHPMailer/src/SMTP.php';
    // function php_mailer_dynamic($sender, $recipients, $subject, $body) {
    //     $mail = new PHPMailer(true);
    //     try {
    //         $mail->isSMTP();
    //         // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
    //         $mail->Host       = 'interlinkiq.com';
    //         $mail->CharSet    = 'UTF-8';
    //         $mail->SMTPAuth   = true;
    //         $mail->Username   = 'admin@interlinkiq.com';
    //         $mail->Password   = 'zN?=?J+CzI0P';
    //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //         $mail->Port       = 465;
    //         $mail->clearAddresses();

    //         $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
    //         foreach($sender as $email => $name) {
    //           $mail->addReplyTo($email, $name);
    //         }
    //         foreach($recipients as $email => $name) {
    //           $mail->addAddress($email, $name);
    //         }

    //         $mail->isHTML(true);
    //         $mail->Subject = $subject;
    //         $mail->Body    = $body;

    //         $mail->send();
    //         $msg = 'Message has been sent';
    //     } catch (Exception $e) {
    //         $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    //     }

    //     return $msg;
    // }

    // // FREQUENCY
    // function check($number, $divisible){
    //     if($number % $divisible == 0){ return 1; }
    //     else{ return 0; }
    // }
     
    
    // DAILY NOTIFICATION
    // Every 12MN   
    // if ($current_minute == 0 AND $current_hour == 0) {
        // $selectUser = mysqli_query( $conn,"
        //     SELECT 
        //     u.ID AS u_ID,
        //     u.first_name AS u_first_name,
        //     u.last_name AS u_last_name,
        //     u.email AS u_email,
        //     u.client AS u_client,
        //     c.url AS c_url
        //     FROM tbl_user AS u
            
        //     LEFT JOIN (
        //         SELECT
        //         *
        //         FROM tbl_user_client
        //     ) AS c
        //     ON u.client = c.ID
            
        //     WHERE u.is_verified = 1 
        //     AND u.is_active = 1
        //     AND u.client = 0
        //     AND u.password_status = 0
        //     -- AND u.ID = 1
        //     AND  (
        //         (u.date_registered < CURDATE() - INTERVAL 3 MONTH AND u.password_update IS NULL)
        //         OR
        //         (u.password_update < CURDATE() - INTERVAL 3 MONTH)
        //     )
        // " );
        // if ( mysqli_num_rows($selectUser) > 0 ) {
            
        //     $sender_name = 'Interlink IQ';
        //     $sender_email = 'services@interlinkiq.com';
        //     $sender[$sender_email] = $sender_name;
            
        //     while($rowUser = mysqli_fetch_array($selectUser)) {
        //         $user_ID = $rowUser["u_ID"];
                
        //         $client_url = 'login';
        //         if ($rowUser['u_client'] > 0) {
        //             $client_url = $rowUser['c_url'];
        //         }
                
        //         mysqli_query( $conn,"UPDATE tbl_user SET password_status = 1 WHERE ID = $user_ID" );
                
        //         $recipients_name = htmlentities($rowUser["u_first_name"] ?? '') .' '. htmlentities($rowUser["u_last_name"] ?? '');
        //         $recipients_email = $rowUser["u_email"];
        //         $recipients = array();
        //         $recipients[$recipients_email] = $recipients_name;
                
        //         $subject = 'Password Expired!';
        //         $body = 'Hi '.$recipients_name.',<br><br>

        //         Your account has been locked due to outdated password!<br>

        //         To retrieve your account, kindly click the button below and update your password.<br><br>

        //         <a href="'.$base_url.$client_url.'?p=1&i='.$user_ID.'&x=1" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">Update Password</a><br><br>
                
        //         Thanks';

        //         php_mailer_dynamic($sender, $recipients, $subject, $body);
        //     }
        // }
        
        
        // Job Ticket
        // $selectUser = mysqli_query( $conn,"SELECT first_name, last_name, email FROM `tbl_user` WHERE ID = 35 OR ID = 54 OR ID = 55 OR ID = 42 OR ID = 178 OR ID = 40 OR ID = 153 OR ID = 43" );
        // $selectUser = mysqli_query( $conn,"SELECT first_name, last_name, email FROM tbl_user WHERE ID = 43 OR ID = 153 OR ID = 456" );
        // if ( mysqli_num_rows($selectUser) > 0 ) {
        //     $sender = array();
        //     $sender_name = 'Interlink IQ';
        //     $sender_email = 'services@interlinkiq.com';
        //     $sender[$sender_email] = $sender_name;
            
        //     $recipients = array();
        //     while($rowUser = mysqli_fetch_array($selectUser)) {
        //         $recipients_name = htmlentities($rowUser["first_name"] ?? '') .' '. htmlentities($rowUser["last_name"] ?? '');
        //         $recipients_email = $rowUser["email"];
        //         $recipients[$recipients_email] = $recipients_name;
        //     }
            
        //     $subject = 'IT-Job Ticket Tracker Update-'.$local_date;
        //     $body = 'Hi Team<br><br>

        //     Here are the daily updates of our Job Ticket Report.<br><br>
            
        //     <table style="width: 100%; border-collapse: collapse;" cellpadding="7" cellspacing="0" border="1">
        //         <tbody>';
                
        //             $selectTotalStatus = mysqli_query( $conn,"
        //                 SELECT
        //                 SUM(pending) AS un_assigned,
        //                 SUM(assigned) AS assigned,
        //                 SUM(on_queue) AS on_queue,
        //                 SUM(on_going) AS on_going,
        //                 SUM(fixed) AS fixed,
        //                 SUM(unresolve) AS unresolve
        //                 FROM (
        //                     SELECT
        //                     CASE WHEN type = 0 AND assigned_to_id IS NULL AND assigned_to_id = '' THEN 1 ELSE 0 END AS pending,
        //                     CASE WHEN type = 0 AND assigned_to_id IS NOT NULL AND assigned_to_id != '' THEN 1 ELSE 0 END AS assigned,
        //                     CASE WHEN type = 1 THEN 1 ELSE 0 END AS on_queue,
        //                     CASE WHEN type = 2 THEN 1 ELSE 0 END AS on_going,
        //                     CASE WHEN type = 3 THEN 1 ELSE 0 END AS fixed,
        //                     CASE WHEN type = 4 THEN 1 ELSE 0 END AS unresolve
        //                     FROM tbl_services

        //                     WHERE deleted = 0
        //                     AND status = 0
        //                 ) r
        //             " );
        //             if ( mysqli_num_rows($selectTotalStatus) > 0 ) {
        //                 while($rowTotalStatus = mysqli_fetch_array($selectTotalStatus)) {
        //                     $body .= ' <tr>
        //                         <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Status</h5></td>
        //                     </tr>
        //                     <tr>
        //                         <td>Pending</td>
        //                         <td>'.$rowTotalStatus["un_assigned"].'</td>
        //                     </tr>
        //                     <tr>
        //                         <td>Assigned</td>
        //                         <td>'.$rowTotalStatus["assigned"].'</td>
        //                     </tr>
        //                     <tr>
        //                         <td>On Queue</td>
        //                         <td>'.$rowTotalStatus["on_queue"].'</td>
        //                     </tr>
        //                     <tr>
        //                         <td>On Going</td>
        //                         <td>'.$rowTotalStatus["on_going"].'</td>
        //                     </tr>
        //                     <tr>
        //                         <td>Fixed</td>
        //                         <td>'.$rowTotalStatus["fixed"].'</td>
        //                     </tr>
        //                     <tr>
        //                         <td>Unresolved</td>
        //                         <td>'.$rowTotalStatus["unresolve"].'</td>
        //                     </tr>';
        //                 }
        //             }



        //             $ticket_open = 0;
        //             $ticket_close = 0;
        //             $selectOpenClose = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(s_status) AS s_total,
        //                 SUM(s_status) AS s_close,
        //                 COUNT(s_status) - SUM(s_status) AS s_open
        //                 FROM (
        //                     SELECT
        //                     s_status
        //                     FROM (
        //                         SELECT 
        //                         s.ID AS s_ID,
        //                         s.assigned_to_id AS s_assigned_to_id,
        //                         s.status AS s_status

        //                         FROM tbl_services AS s

        //                         LEFT JOIN (
        //                             SELECT
        //                             *
        //                             FROM tbl_user
        //                         ) AS u
        //                         ON s.user_id = u.ID

        //                         LEFT JOIN (
        //                             SELECT
        //                             *
        //                             FROM tbl_hr_employee
        //                         ) AS e
        //                         ON u.employee_id = e.ID

        //                         WHERE s.deleted = 0
        //                     ) r

        //                     LEFT JOIN (
        //                         SELECT
        //                         *
        //                         FROM tbl_hr_employee
        //                     ) AS ee
        //                     ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

        //                     GROUP BY s_ID

        //                     ORDER BY s_ID
        //                 ) r
        //             " );
        //             if ( mysqli_num_rows($selectOpenClose) > 0 ) {
        //                 $rowOpenClose = mysqli_fetch_array($selectOpenClose);
        //                 $ticket_open = $rowOpenClose["s_open"];
        //                 $ticket_close = $rowOpenClose["s_close"];
        //             }
        //             $body .= '<tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Open and Close Tickets</h5></td>
        //             </tr>
        //             <tr>
        //                 <td>Open</td>
        //                 <td>'.$ticket_open.'</td>
        //             </tr>
        //             <tr>
        //                 <td>Close</td>
        //                 <td>'.$ticket_close.'</td>
        //             </tr>';



        //             $ticket_completed_today = 0;
        //             $selectCompletedToday = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(s_ID) AS completed_today
        //                 FROM (
        //                     SELECT
        //                     s_ID,
        //                     s_last_modified
        //                     FROM (
        //                         SELECT 
        //                         s.ID AS s_ID,
        //                         s.last_modified AS s_last_modified,
        //                         s.assigned_to_id AS s_assigned_to_id

        //                         FROM tbl_services AS s

        //                         LEFT JOIN (
        //                             SELECT
        //                             *
        //                             FROM tbl_user
        //                         ) AS u
        //                         ON s.user_id = u.ID

        //                         LEFT JOIN (
        //                             SELECT
        //                             *
        //                             FROM tbl_hr_employee
        //                         ) AS e
        //                         ON u.employee_id = e.ID

        //                         WHERE s.status = 1 
        //                         AND s.deleted = 0
        //                     ) r

        //                     LEFT JOIN (
        //                         SELECT
        //                         *
        //                         FROM tbl_hr_employee
        //                     ) AS ee
        //                     ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

        //                     WHERE DATE(s_last_modified) = CURDATE()

        //                     GROUP BY s_ID

        //                     ORDER BY s_ID
        //                 ) t
        //             " );
        //             if ( mysqli_num_rows($selectCompletedToday) > 0 ) {
        //                 $rowCompletedToday = mysqli_fetch_array($selectCompletedToday);
        //                 $ticket_completed_today = $rowCompletedToday["completed_today"];
        //             }
        //             $body .= '<tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Completed Tickets Today</h5></td>
        //             </tr>
        //             <tr>
        //                 <td>Completed</td>
        //                 <td>'.$ticket_completed_today.'</td>
        //             </tr>';
                    
                    

        //             $body .= ' <tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Assigned Tickets</h5></td>
        //             </tr>';
        //             $selectTotalAssigned = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(e_ID) AS e_total,
        //                 e_first_name,
        //                 e_last_name
        //                 FROM (
        //                     SELECT
        //                     e.ID AS e_ID,
        //                     e.first_name AS e_first_name,
        //                     e.last_name AS e_last_name
        //                     FROM tbl_services AS s

        //                     RIGHT JOIN (
        //                         SELECT
        //                         *
        //                         FROM tbl_hr_employee
        //                     ) AS e
        //                     ON FIND_IN_SET(e.ID, REPLACE(REPLACE(s.assigned_to_id, ' ', ''), '|',','  )  ) > 0

        //                     WHERE s.deleted = 0
        //                     AND s.status = 0
        //                     AND s.assigned_to_id IS NOT NULL
        //                     AND s.assigned_to_id != ''
        //                 ) r

        //                 GROUP BY e_ID
        //                 ORDER BY e_first_name
        //             " );
        //             if ( mysqli_num_rows($selectTotalAssigned) > 0 ) {
        //                 while($rowTotalAssigned = mysqli_fetch_array($selectTotalAssigned)) {
        //                     $body .= '<tr>
        //                         <td>'.htmlentities($rowTotalAssigned["e_first_name"] ?? '').' '.htmlentities($rowTotalAssigned["e_last_name"] ?? '').'</td>
        //                         <td>'.$rowTotalAssigned["e_total"].'</td>
        //                     </tr>';
        //                 }
        //             } else {
        //                 $body .= ' <tr>
        //                     <td colspan="2">No available record</td>
        //                 </tr>';
        //             }
                    
                    

        //             $body .= ' <tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Closed Ticket by Assigned VA Today</h5></td>
        //             </tr>';
        //             $selectTotalAssignedClose = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(e_ID) AS e_total,
        //                 e_first_name,
        //                 e_last_name
        //                 FROM (
        //                     SELECT
        //                     e.ID AS e_ID,
        //                     e.first_name AS e_first_name,
        //                     e.last_name AS e_last_name
        //                     FROM tbl_services AS s

        //                     RIGHT JOIN (
        //                         SELECT
        //                         *
        //                         FROM tbl_hr_employee
        //                     ) AS e
        //                     ON FIND_IN_SET(e.ID, REPLACE(REPLACE(s.assigned_to_id, ' ', ''), '|',','  )  ) > 0

        //                     WHERE s.deleted = 0
        //                     AND s.status = 1
        //                     AND s.assigned_to_id IS NOT NULL
        //                     AND s.assigned_to_id != ''
        //                     AND DATE(s.last_modified) = CURDATE()
        //                 ) r

        //                 GROUP BY e_ID
        //                 ORDER BY e_first_name
        //             " );
        //             if ( mysqli_num_rows($selectTotalAssignedClose) > 0 ) {
        //                 while($rowTotalAssignedClose = mysqli_fetch_array($selectTotalAssignedClose)) {
        //                     $body .= '<tr>
        //                         <td>'.htmlentities($rowTotalAssignedClose["e_first_name"] ?? '').' '.htmlentities($rowTotalAssignedClose["e_last_name"] ?? '').'</td>
        //                         <td>'.$rowTotalAssignedClose["e_total"].'</td>
        //                     </tr>';
        //                 }
        //             } else {
        //                 $body .= ' <tr>
        //                     <td colspan="2">No available record</td>
        //                 </tr>';
        //             }
                    
                    

        //             $body .= ' <tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Due</h5></td>
        //             </tr>';
        //             $selectTotalDue = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(ID) AS total_due
        //                 FROM tbl_services
        //                 WHERE deleted = 0
        //                 AND status = 0
        //                 AND DATE(due_date) <= CURDATE()
        //             " );
        //             if ( mysqli_num_rows($selectTotalDue) > 0 ) {
        //                 while($rowTotalDue = mysqli_fetch_array($selectTotalDue)) {
        //                     $body .= '<tr>
        //                         <td>Passed Due</td>
        //                         <td>'.$rowTotalDue["total_due"].'</td>
        //                     </tr>';
        //                 }
        //             } else {
        //                 $body .= ' <tr>
        //                     <td colspan="2">No available record</td>
        //                 </tr>';
        //             }
                    
                    

        //             $body .= ' <tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Ticket Recieved Today</h5></td>
        //             </tr>';
        //             $selectTotalReceivedToday = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(ID) AS received_today
        //                 FROM tbl_services
        //                 WHERE deleted = 0
        //                 AND status = 0
        //                 AND DATE(date_added) = CURDATE()
        //             " );
        //             if ( mysqli_num_rows($selectTotalReceivedToday) > 0 ) {
        //                 $rowTotalReceivedToday = mysqli_fetch_array($selectTotalReceivedToday);
        //                 $body .= '<tr>
        //                     <td>Received</td>
        //                     <td>'.$rowTotalReceivedToday["received_today"].'</td>
        //                 </tr>';
        //             } else {
        //                 $body .= ' <tr>
        //                     <td colspan="2">No available record</td>
        //                 </tr>';
        //             }



        //             $selectTotalPerCategory = mysqli_query( $conn,"
        //                 SELECT
        //                 SUM(it_services) AS it_services,
        //                 SUM(technical_services) AS technical_services,
        //                 SUM(sales) AS sales,
        //                 SUM(request_demo) AS request_demo,
        //                 SUM(suggestion) AS suggestion,
        //                 SUM(problem) AS problem,
        //                 SUM(praise) AS praise,
        //                 SUM(others) AS others
        //                 FROM (
        //                     SELECT
        //                     CASE WHEN category = 1 THEN 1 ELSE 0 END AS it_services,
        //                     CASE WHEN category = 2 THEN 1 ELSE 0 END AS technical_services,
        //                     CASE WHEN category = 3 THEN 1 ELSE 0 END AS sales,
        //                     CASE WHEN category = 4 THEN 1 ELSE 0 END AS request_demo,
        //                     CASE WHEN category = 5 THEN 1 ELSE 0 END AS suggestion,
        //                     CASE WHEN category = 6 THEN 1 ELSE 0 END AS problem,
        //                     CASE WHEN category = 7 THEN 1 ELSE 0 END AS praise,
        //                     CASE WHEN category = 0 THEN 1 ELSE 0 END AS others
        //                     FROM tbl_services

        //                     WHERE deleted = 0
        //                     AND status = 0
        //                 ) r
        //             " );
        //             if ( mysqli_num_rows($selectTotalPerCategory) > 0 ) {
        //                 $rowTotalPerCategory = mysqli_fetch_array($selectTotalPerCategory);
        //                 $body .= '<tr>
        //                     <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Ticket Per Category</h5></td>
        //                 </tr>
        //                 <tr>
        //                     <td>IT Services</td>
        //                     <td>'.$rowTotalPerCategory["it_services"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Technical Services</td>
        //                     <td>'.$rowTotalPerCategory["technical_services"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Sales</td>
        //                     <td>'.$rowTotalPerCategory["sales"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Request Demo</td>
        //                     <td>'.$rowTotalPerCategory["request_demo"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Suggestion</td>
        //                     <td>'.$rowTotalPerCategory["suggestion"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Problem</td>
        //                     <td>'.$rowTotalPerCategory["problem"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Praise</td>
        //                     <td>'.$rowTotalPerCategory["praise"].'</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Others</td>
        //                     <td>'.$rowTotalPerCategory["others"].'</td>
        //                 </tr>';
        //             }



        //             $body .= '<tr>
        //                 <td colspan="2" style="background: #e1e5ec!important;"><h5 class="bold">Total Tickets requested by the VA</h5></td>
        //             </tr>';
        //             $selectTotalRequested = mysqli_query( $conn,"
        //                 SELECT
        //                 COUNT(name) AS total_name,
        //                 name
        //                 FROM tbl_services
        //                 WHERE deleted = 0
        //                 AND name IS NOT NULL
        //                 AND name != ''

        //                 GROUP BY name
        //                 ORDER BY name
        //             " );
        //             if ( mysqli_num_rows($selectTotalRequested) > 0 ) {
        //                 while($rowTotalRequested = mysqli_fetch_array($selectTotalRequested)) {
        //                     $body .= '<tr>
        //                         <td>'.$rowTotalRequested["name"].'</td>
        //                         <td>'.$rowTotalRequested["total_name"].'</td>
        //                     </tr>';
        //                 }
        //             } else {
        //                 $body .= ' <tr>
        //                     <td colspan="2">No available record</td>
        //                 </tr>';
        //             }
                    
        //         $body .= '</tbody>
        //     </table><br><br><br>

        //     Thanks';

        //     php_mailer_dynamic($sender, $recipients, $subject, $body);
        // }
    // }
?>
