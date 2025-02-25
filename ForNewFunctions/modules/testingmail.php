<?php
require "config.php";

require "PHPMailer/PHPMailer/src/Exception.php";
require "PHPMailer/PHPMailer/src/PHPMailer.php";
require "PHPMailer/PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

        try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 3;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = 'erwinjames.manugas.it@gmail.com';
    $mail->Password = 'ypcppkbimgugfdgw';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->setFrom('erwinjames.manugas.it@gmail.com', 'IIQ');
    $mail->addAddress("erwinjames.manugas.it@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = "Testing";
        $mail->Body = "
        <!DOCTYPE html>

        <head>
            <style>
                body {
                    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                }
            </style>
        </head>

        <body>
            <div class='container m-auto'>
                Testing
            </div>
        </body>

        </html>";
        if($mail->send()){
            echo "success";
        }else{
            echo "failed";
        }
       
        } catch (Exception $e) {
        echo "Could not sent. Mailer Error: {$mail->ErrorInfo}";
        }

?>
