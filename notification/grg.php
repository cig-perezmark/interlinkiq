<?php
    include(__DIR__ . '/../database_iiq.php');
    include(__DIR__ . '/../PHPMailer/config.php');
    $base_url = "https://interlinkiq.com/";
    $local_date = date('Y-m-d');


    $sender = array();
    $sender_name = 'Interlink IQ';
    $sender_email = 'services@interlinkiq.com';
    $sender[$sender_email] = $sender_name;
    
    $user = 'Greeg Gimongala';
    $to = 'greeggimongala@gmail.com';
    $subject2 = 'Test with Image';
    $data_email = 'greeg@consultareinc.com';
    $data_company = 'Marukan Vinegar (U.S.A.), Inc.';
    $body = 'Please note that the submission deadline for the requested documents is <b>15 days</b> from the receipt of this email.<br><br>

    Thank you,<br><br>

    Lizbeth Reyes<br>
    Food Safety and Quality Manager<br>
    '.$data_company.'<br>
    562-602-8340 Ext. 109<br>
    <img src="https://interlinkiq.com/companyDetailsFolder/449248%20-%20marukan%20logo.png" width="133"><br>
    <a href="https://www.marukan-usa.com/" target="_blank">www.marukan-usa.com</a>';
    
    // echo $body;
    php_mailer_2($to, $user, $subject2, $body, $data_email, $data_company);
?>