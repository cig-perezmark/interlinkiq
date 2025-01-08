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
    //         $mail->Password   = 'L1873@2019new';
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
    //     $selectUser = mysqli_query( $conn,"
    //         SELECT 
    //         u.ID AS u_ID,
    //         u.first_name AS u_first_name,
    //         u.last_name AS u_last_name,
    //         u.email AS u_email,
    //         u.client AS u_client,
    //         c.url AS c_url
    //         FROM tbl_user AS u
            
    //         LEFT JOIN (
    //             SELECT
    //             *
    //             FROM tbl_user_client
    //         ) AS c
    //         ON u.client = c.ID
            
    //         WHERE u.is_verified = 1 
    //         AND u.is_active = 1
    //         AND u.client = 0
    //         AND u.password_status = 0
    //         -- AND u.ID = 1
    //         AND  (
    //             (u.date_registered < CURDATE() - INTERVAL 3 MONTH AND u.password_update IS NULL)
    //             OR
    //             (u.password_update < CURDATE() - INTERVAL 3 MONTH)
    //         )
    //     " );
    //     if ( mysqli_num_rows($selectUser) > 0 ) {
            
    //         $sender_name = 'Interlink IQ';
    //         $sender_email = 'services@interlinkiq.com';
    //         $sender[$sender_email] = $sender_name;
            
    //         while($rowUser = mysqli_fetch_array($selectUser)) {
    //             $user_ID = $rowUser["u_ID"];
                
    //             $client_url = 'login';
    //             if ($rowUser['u_client'] > 0) {
    //                 $client_url = $rowUser['c_url'];
    //             }
                
    //             mysqli_query( $conn,"UPDATE tbl_user SET password_status = 1 WHERE ID = $user_ID" );
                
    //             $recipients_name = htmlentities($rowUser["u_first_name"] ?? '') .' '. htmlentities($rowUser["u_last_name"] ?? '');
    //             $recipients_email = $rowUser["u_email"];
    //             $recipients = array();
    //             $recipients[$recipients_email] = $recipients_name;
                
    //             $subject = 'Password Expired!';
    //             $body = 'Hi '.$recipients_name.',<br><br>

    //             Your account has been locked due to outdated password!<br>

    //             To retrieve your account, kindly click the button below and update your password.<br><br>

    //             <a href="'.$base_url.$client_url.'?p=1&i='.$user_ID.'&x=1" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">Update Password</a><br><br>
                
    //             Thanks';

    //             php_mailer_dynamic($sender, $recipients, $subject, $body);
    //         }
    //     }
    // }
?>
