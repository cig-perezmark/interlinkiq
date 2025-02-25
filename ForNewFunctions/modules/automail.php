<?php
require "database.php";
require "PHPMailer/PHPMailer/src/Exception.php";
require "PHPMailer/PHPMailer/src/PHPMailer.php";
require "PHPMailer/PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Set the number of days before the due date for reminders
$reminderDays = 3;

// Get tasks that are near their due date
$now = time();
$reminderDate = $now + ($reminderDays * 24 * 60 * 60);

$sql = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE CAI_Action_due_date <= $reminderDate";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Load PHPMailer
    $mail = new PHPMailer(true);

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = 'interlinkiq.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@interlinkiq.com';
    $mail->Password = 'L1873@2019new';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');

    // Prepare and send reminders
    while ($row = $result->fetch_assoc()) {
        $taskMyProId = $row['Parent_MyPro_PK'];
        $taskName = $row['CAI_filename'];
        $dueDate = strtotime($row['CAI_Action_due_date']);
        $assign_to_id = $row['CAI_Assign_to']; // Fixed issue

        // Fetch user information
        $userQuery = "SELECT * FROM tbl_hr_employee WHERE ID = $assign_to_id";
        $userResult = $conn->query($userQuery);
         $formattedDueDate = date('M d', $dueDate);
        $userRow = $userResult->fetch_assoc();
        // $useremail = $userRow['email'];
         $useremail = "manugasewinjames@gmail.com";
        // Set recipient and reply-to addresses
        $mail->addAddress($useremail, $userRow['first_name']);
        // Set email subject and body
        $currentDayName = date('l');
        $mail->Subject = 'Reminder: Due Date Approaching';
        $mail->isHTML(true);
        $mail->Body = '
         <table cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;table-layout:fixed;width:100%">
    <tbody>
        <tr>
            <td style="text-align:center">
                <table style="border-collapse:separate;border-spacing:0;margin-bottom:32px;margin-left:auto;margin-right:auto;margin-top:8px;table-layout:fixed;text-align:left;width:100%">
                    <tbody>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                    <tbody>
                                        <tr>
                                            <td><span style="font-size:20px;font-weight:400;line-height:26px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Hi '.$userRow['first_name'].', </span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="font-size:20px;font-weight:600;line-height:26px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Here is your '.$currentDayName.' update!</span></td>
                                        </tr>
                                        <tr>
                                            <td style="line-height:16px;max-width:0;min-width:0;height:16px;width:0;font-size:16px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4573d2;border-radius:4px">
                                                                <a href="https://interlinkiq.com/test_task_mypro.php?view_id='.$row['Parent_MyPro_PK'].'" style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #4573d2;display:inline-block" target="_blank" data-saferedirecturl=""><span style="font-size:16px;font-weight:600;line-height:24px;color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Go to MyPro</span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="line-height:32px;max-width:0;min-width:0;height:32px;width:0;font-size:32px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" style="border-bottom:1px solid #edeae9"></td>
                                        </tr>
                                        <tr>
                                            <td style="line-height:32px;max-width:0;min-width:0;height:32px;width:0;font-size:32px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <a href="" style="text-decoration:none" target="_blank" data-saferedirecturl="">
                                                                <span style="font-size:16px;font-weight:400;line-height:24px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
                                                                Tasks due soon</span></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="line-height:8px;max-width:0;min-width:0;height:8px;width:0;font-size:8px">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0;border-color:#edeae9;border-radius:4px;border-style:solid;border-width:1px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:100%">
                                                                                <a href="" style="text-decoration:none" target="_blank" data-saferedirecturl="">
                                                                                    <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="line-height:8px;max-width:8px;min-width:8px;height:8px;width:8px;font-size:8px">&nbsp;</td>
                                                                                                <td style="line-height:8px;max-width:auto;min-width:auto;height:8px;width:auto;font-size:8px">&nbsp;</td>
                                                                                                <td style="line-height:8px;max-width:4px;min-width:4px;height:8px;width:4px;font-size:8px">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
                                                                                                <td style="width:100%">
                                                                                                    <table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="height:24px;width:16px;vertical-align:middle"><img src="https://ci3.googleusercontent.com/proxy/LkbGr6KEEycu-Cd27TCe2P_XtmXFEFaqztubEddWxfdYJocAtp-QQ_opK4S29DrhJCVCrlMM-e-yqsft-e26Duf9yvBw8h_tXgcXTdiZe3BUv6redFjXGc7DrlR0Zh0sLhPciaY0rOOAqsBwTMXLjBXz872uXOUAUud6JgnW=s0-d-e1-ft#https://d3ki9tyy5l5ruj.cloudfront.net/obj/17ebaf90443cc42469dfeeaf11302fa63f0a3386/checkmark-icon-32x32.png"
                                                                                                                        style="border:none;display:block;outline:none;text-decoration:none;text-align:center" height="16" width="16" class="CToWUd" data-bit="iit"></td>
                                                                                                                <td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
                                                                                                                <td style="overflow:hidden;width:100%;text-overflow:ellipsis;vertical-align:middle;white-space:nowrap">
                                                                                                                    <a href="https://interlinkiq.com/test_task_mypro.php?view_id='.$taskMyProId.'" style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$taskName.'</span></a>
                                                                                                                </td>
                                                                                                                <td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
                                                                                                                <td style="width:80px;vertical-align:middle">
                                                                                                                    <table cellpadding="0" cellspacing="0" style="width:80px;min-width:80px;table-layout:fixed;border-collapse:separate;border-spacing:0">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td><span style="background-color:#8d84e8;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:20px;line-height:20px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">Complia…</span></span>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                                <td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
                                                                                                                <td style="overflow:hidden;width:48px;text-align:right;text-overflow:ellipsis;vertical-align:middle;white-space:nowrap"><span style="font-size:13px;font-weight:400;line-height:20px;color:#c92f54;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$formattedDueDate.'</span></td>
                                                                                                                <td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
                                                                                                                <td style="width:14px;vertical-align:middle"><img src="https://ci3.googleusercontent.com/proxy/3DGtYJHJVfitlVffsDyelsVbFspPAqSvhSswU88UexTZOYM8hHm0Rbuwwe06KfFGOp5AElwrIX3UKJCETU4k3vu3wZnNLipngwPzEpYUacNADTrbefpfpdr33_Cq79-15iNUxVJjHGu8sh9iQr5bWyAdn5wnt0dNLaXei1w=s0-d-e1-ft#https://d3ki9tyy5l5ruj.cloudfront.net/obj/44f5654475ec4d9fad41014461c7561e0a5811fa/right_icon-16x16@2x.png"
                                                                                                                        style="border:none;display:block;outline:none;text-decoration:none;text-align:center" height="14" width="14" class="CToWUd" data-bit="iit"></td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td style="max-width:4px;min-width:4px;width:4px">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="line-height:8px;max-width:8px;min-width:8px;height:8px;width:8px;font-size:8px">&nbsp;</td>
                                                                                                <td style="line-height:8px;max-width:auto;min-width:auto;height:8px;width:auto;font-size:8px">&nbsp;</td>
                                                                                                <td style="line-height:8px;max-width:4px;min-width:4px;height:8px;width:4px;font-size:8px">&nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
        ';
        // Send the email
        if (!$mail->send()) {
            echo "Error sending email for task ID {$row['id']}: " . $mail->ErrorInfo . "<br>";
        } else {
            echo "Reminder email sent for task ID {$row['id']}<br>";
        }

        // Clear recipient addresses for the next iteration
        $mail->clearAddresses();
    }
} else {
    echo "No tasks found near the due date.";
}

// Close the database connection
$conn->close();
?>
