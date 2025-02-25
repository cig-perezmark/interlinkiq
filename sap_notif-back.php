<?php
    include_once 'database_iiq.php';
    $base_url = "https://interlinkiq.com/";


    // PHP MAILER FUNCTION
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    function php_mailer_1($to, $user, $subject, $body, $from, $name) {
        // require 'PHPMailer/src/Exception.php';
        // require 'PHPMailer/src/PHPMailer.php';
        // require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

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
    function php_mailer_2($to, $user, $subject, $body, $from, $name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

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
    function php_mailer_3($to, $user, $subject, $body, $from, $name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

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
    function php_mailer_dynamic($sender, $recipients, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->clearAddresses();

            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            foreach($sender as $email => $name) {
               $mail->addReplyTo($email, $name);
            }
            foreach($recipients as $email => $name) {
               $mail->addAddress($email, $name);
            }

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

    // FREQUENCY
    function check($number, $divisible){
        if($number % $divisible == 0){ return 1; }
        else{ return 0; }
    }
    $current_minute = intval(date('i')); // 0 - 59
    $current_hour = date("G"); // 1 - 24
    $current_day = date("j"); // 1 - 31
    $current_month = date("n"); // 1 - 12
    $current_weekday = date('N', strtotime(date("l"))); // 1 - 7

    $current_date = date('Y-m-d');
    $current_dateNow_o = date('Y/m/d');
    $current_dateNow = new DateTime($current_dateNow_o);
    $current_dateNow = $current_dateNow->format('M d, Y');
?>

<?php
    // Select and update the task that has pass 3 weeks upon its added date
    // $task_mail_status = 1;
    // $expire_task = $conn->prepare("SELECT crmt_id AS list_id FROM tbl_Customer_Relationship_Task WHERE mail_status = ? AND Task_added < NOW() - INTERVAL 3 WEEK");

    // if ($expire_task === false) {
    //     echo 'Error statement: '.$conn->error;
    //     exit;
    // }

    // $expire_task->bind_param('i', $task_mail_status);
    // $expire_task->execute();
    // $result = $expire_task->get_result();

    // if ($result === false) {
    //     echo 'Error retrieving result: '.$conn->error;
    //     exit;
    // }

    // $ids = [];
    // while ($row = $result->fetch_assoc()) {
    //     $ids[] = $row['list_id'];
    // }

    // if (!empty($ids)) {
    //     $ids_list = implode(',', $ids);
    //     $new_mail_status = 0; // Assuming the new mail_status value is 1

    //     $update_query = "UPDATE tbl_Customer_Relationship_Task SET mail_status = ? WHERE crmt_id IN ($ids_list)";
    //     $update_stmt = $conn->prepare($update_query);

    //     if ($update_stmt === false) {
    //         echo 'Error preparing update statement: '.$conn->error;
    //         exit;
    //     }

    //     $update_stmt->bind_param('i', $new_mail_status);
    //     $update_stmt->execute();

    //     if ($update_stmt->affected_rows > 0) {
    //         echo 'Mail status updated successfully for '. $update_stmt->affected_rows .' records.';
    //     } else {
    //         echo 'No records updated.';
    //     }
    // } else {
    //     echo 'No tasks found to update.';
    // }

    // $expire_task->close();
    
    // // End select and update
    
    // // Auto update the campaign if the contact status = Manual and flag = 0
    // $flag1 = 0;
    // $status1 = 'Manual';
    // $campaignStatus = 2;
    // $autoSendStatus = 1;
    // $chunkSize1 = 100;
    // $offset1 = 0;

    // do {
    //     // Fetch a chunk of records from tbl_Customer_Relationship
    //     $stmt = $conn->prepare("SELECT crm_id, account_name, account_email, account_status, flag FROM tbl_Customer_Relationship WHERE flag = ? OR account_status = ? LIMIT $chunkSize1 OFFSET $offset1");
    //     if (!$stmt) {
    //         die("Error in the first prepared statement: " . $conn->error);
    //     }

    //     $stmt->bind_param("is", $flag1, $status1);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     // Break if no more records are fetched
    //     if ($result->num_rows == 0) {
    //         break;
    //     }

    //     // Fetch all campaign records once (assuming they are not very large)
    //     $stmt2 = $conn->prepare("SELECT crm_ids FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ?");
    //     if (!$stmt2) {
    //         die("Error in the second prepared statement: " . $conn->error);
    //     }

    //     $stmt2->bind_param("ii", $campaignStatus, $autoSendStatus);
    //     $stmt2->execute();
    //     $result2 = $stmt2->get_result();

    //     $campaigns = [];
    //     while ($row2 = $result2->fetch_assoc()) {
    //         $campaigns[$row2['crm_ids']] = $row2;
    //     }

    //     while ($row = $result->fetch_assoc()) {
    //         $crmIdToMatch = $row['crm_id'];

    //         if (isset($campaigns[$crmIdToMatch])) {
    //             $updateStmt = $conn->prepare("UPDATE tbl_Customer_Relationship_Campaign SET Auto_Send_Status = 0 WHERE crm_ids = ?");
    //             if (!$updateStmt) {
    //                 die("Error in the update prepared statement: " . $conn->error);
    //             }

    //             $updateStmt->bind_param("s", $crmIdToMatch);  // Assuming crm_ids is a string, adjust accordingly
    //             $updateStmt->execute();
    //             $updateStmt->close();
    //         }
    //     }

    //     // Move to the next chunk
    //     $offset1 += $chunkSize1;
        
    //     // Clean up result sets
    //     $result->free();
    //     $result2->free();

    // } while (true);

    // end auto update campaign status
    
    // $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE is_deleted = 0 AND ID = 558" );
    $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE is_deleted = 0 ORDER BY name" );
    if ( mysqli_num_rows($result) > 0 ) {
        $mail_sent = 0;
        while($row = mysqli_fetch_array($result)) {
            $frequency = $row["frequency"];
            $frequency_custom = $row["frequency_custom"];
            if ($frequency == 1) {
                $frequency_custom = '0 | 0 | * | * | *';    // Once Per Day
            } else if ($frequency == 2) {
                $frequency_custom = '0 | 0 | * | * | 0';    // Once Per Week
            } else if ($frequency == 3) {
                $frequency_custom = '0 | 0 | 1,15 | * | *'; // On the 1st and 15th of the Month
            } else if ($frequency == 4) {
                $frequency_custom = '0 | 0 | 1 | * | *';    // Once Per Month
            } else if ($frequency == 5) {
                $frequency_custom = '0 | 0 | 1 | 1 | *';    // Once Per Year
            } else if ($frequency == 6) {
                $frequency_custom = '0 | 0 | 1 | */2 | *';    // Every Other Month
            } else if ($frequency == 7) {
                $frequency_custom = '0 | 0 | 1 | */4 | *';    // Quarterly
            } else if ($frequency == 8) {
                $frequency_custom = '0 | 0 | 1 | 1,7 | *';    // Bi-Annual
            }
            $frequency_custom_arr = explode(" | ", $frequency_custom);

            $count_send = 0;
            if (is_numeric($frequency_custom_arr[0]) AND $frequency_custom_arr[0] == $current_minute) { // minute
                $count_send++;
            } else {
                if ($frequency_custom_arr[0] == '*') {
                    $count_send++;
                } else if ($frequency_custom_arr[0] == '*/2') {
                    $count_send += intval(check($current_minute, 2));
                } else if ($frequency_custom_arr[0] == '*/5') {
                    $count_send += intval(check($current_minute, 5));
                } else if ($frequency_custom_arr[0] == '*/10') {
                    $count_send += intval(check($current_minute, 10));
                } else if ($frequency_custom_arr[0] == '*/15') {
                    $count_send += intval(check($current_minute, 15));
                } else if ($frequency_custom_arr[0] == '0,30') {
                    $count_send += intval(check($current_minute, 30));
                }
            }

            if (is_numeric($frequency_custom_arr[1]) AND $frequency_custom_arr[1] == $current_hour) { // hour
                $count_send++;
            } else {
                if ($frequency_custom_arr[1] == '*') {
                    $count_send++;
                } else if ($frequency_custom_arr[1] == '*/2') {
                    $count_send += intval(check($current_hour, 2));
                } else if ($frequency_custom_arr[1] == '*/3') {
                    $count_send += intval(check($current_hour, 3));
                } else if ($frequency_custom_arr[1] == '*/4') {
                    $count_send += intval(check($current_hour, 4));
                } else if ($frequency_custom_arr[1] == '*/6') {
                    $count_send += intval(check($current_hour, 6));
                } else if ($frequency_custom_arr[1] == '0,12') {
                    $count_send += intval(check($current_hour, 12));
                }
            }
            
            if (is_numeric($frequency_custom_arr[2]) AND $frequency_custom_arr[2] == $current_day) { // day
                $count_send++;
            } else {
                if ($frequency_custom_arr[2] == '*') {
                    $count_send++;
                } else if ($frequency_custom_arr[2] == '*/2') {
                    $count_send += intval(check($current_day, 2));
                } else if ($frequency_custom_arr[2] == '1,15') {
                    if ($current_day == 1 OR $current_day == 15) {
                        $count_send ++;
                    }
                }
            }
            
            if (is_numeric($frequency_custom_arr[3]) AND $frequency_custom_arr[3] == $current_month) { // month
                $count_send++;
            } else {
                if ($frequency_custom_arr[3] == '*') {
                    $count_send++;
                } else if ($frequency_custom_arr[3] == '*/2') {
                    $count_send += intval(check($current_month, 2));
                } else if ($frequency_custom_arr[3] == '*/4') {
                    $count_send += intval(check($current_month, 3));
                } else if ($frequency_custom_arr[3] == '1,7') {
                    if ($current_month == 1 OR $current_month == 7) {
                        $count_send ++;
                    }
                }
            }
            
            if (is_numeric($frequency_custom_arr[4]) AND $frequency_custom_arr[4] == $current_weekday) { // weekday
                $count_send++;
            } else {
                if ($frequency_custom_arr[4] == '*') {
                    $count_send++;
                } else if ($frequency_custom_arr[4] == '1-5') {
                    if (in_array($current_weekday, range(1,5))) {
                        $count_send ++;
                    }
                } else if ($frequency_custom_arr[4] == '6,7') {
                    if ($current_weekday == 6 OR $current_weekday == 7) {
                        $count_send ++;
                    }
                } else if ($frequency_custom_arr[4] == '1,3,5') {
                    if ($current_weekday == 1 OR $current_weekday == 3 OR $current_weekday == 5) {
                        $count_send ++;
                    }
                } else if ($frequency_custom_arr[4] == '2,4') {
                    if ($current_weekday == 2 OR $current_weekday == 4) {
                        $count_send ++;
                    }
                }
            }

            if ($count_send == 5) {
                $ID = $row["ID"];
                $page = $row["page"];
                $name = $row["name"];
                $email = $row["email"];
                $contact = $row["contact"];
                $status = $row["status"];
                $notification = $row["notification"];

                $user_id = $row["user_id"];
                $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
                if ( mysqli_num_rows($selectUser) > 0 ) {
                    $rowUser = mysqli_fetch_array($selectUser);
                    $rowUser_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                    $rowUser_email = $rowUser["email"];
                }

                $document = $row["document"];
                $document_arr = explode(", ", $document);

                $document_other = $row["document_other"];
                $document_other_arr = explode(", ", $document_other);

                $compliance = 0;
                $compliance_counter = 0;
                $compliance_approved = 0;

                $name_arr = array();
                $email_arr = array();
                $req_arr = array();
                // if ($status == 1) {
                    if ($notification == 0) {
                        array_push($name_arr, $rowUser_name);
                        array_push($email_arr, $rowUser_email);
                    } else {
                        array_push($name_arr, $name);
                        array_push($email_arr, $email);

                        if (!empty($contact)) {
                            $contact_arr = explode(", ", $contact);
                            foreach ($contact_arr as $value) {
                                $selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE ID=$value" );
                                if ( mysqli_num_rows($selectContact) > 0 ) {
                                    while($rowContact = mysqli_fetch_array($selectContact)) {
                                        $contact_name = $rowContact["name"];
                                        $contact_email = $rowContact["email"];

                                        array_push($name_arr, $contact_name);
                                        array_push($email_arr, $contact_email);
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($document)) {
                        $selectRequirement = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                        while($rowRequirement = mysqli_fetch_array($selectRequirement)) {
                            $req_id = $rowRequirement["ID"];
                            $req_name = $rowRequirement["name"];

                            foreach ($document_arr as $value) {
                                if ( $value == $req_id ) {
                                    $selectDocument = mysqli_query( $conn,"SELECT * FROM tbl_supplier_document WHERE user_id = $user_id AND supplier_id = $ID AND type = 0 AND name = '".$req_id."'" );
                                    if ( mysqli_num_rows($selectDocument) > 0 ) {
                                        $rowDocument = mysqli_fetch_array($selectDocument);
                                        $doc_file = $rowDocument["file"];

                                        if (empty($doc_file)) {
                                            array_push($req_arr, $req_name);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (!empty($document_other)) {
                        $count_other = 0;
                        foreach ($document_other_arr as $value) {
                            $selectDocument = mysqli_query( $conn,"SELECT * FROM tbl_supplier_document WHERE user_id = $user_id AND supplier_id = $ID AND type = 1 AND name = '".$value."'" );
                            if ( mysqli_num_rows($selectDocument) > 0 ) {
                                $rowDocument = mysqli_fetch_array($selectDocument);
                                $doc_file = $rowDocument["file"];

                                if (empty($doc_file)) {
                                    array_push($req_arr, $value);
                                }
                            }
                        }
                    }

                    if (!empty($req_arr)) {
                        // echo '<tr id="tr_'. $ID .'">
                        //     <td>'. $ID .'</td>
                        //     <td>'. $name .'</td>
                        //     <td>'. $rowUser_name .'</td>
                        //     <td>'. $rowUser_email .'</td>
                        //     <td>'. implode(' | ', $name_arr) .'</td>
                        //     <td>'. implode(' | ', $email_arr) .'</td>
                        //     <td>'. implode(' | ', $req_arr) .'</td>
                        // </tr>';

                        $index = 0;
                        foreach ($email_arr as $email_arr_value) {
                            $to = $email_arr_value;
                            $user = $name_arr[$index];
                            $subject = 'Supplier Approval Program Follow-ups!';
                            $body = 'Hi '.$user.',<br><br>

                            A gentle reminder on the following items:<br>
                            <ol>';

                            foreach ($req_arr as $req_arr_value) {
                                $body .= '<li>'.$req_arr_value.'</li>';
                            }

                            $body .= '</ol>

                            Follow the instructions below:<br><br>

                            To update Compliance:<br>
                            <ol>
                                <li>Go to <a href="'.$base_url.'" target="_blank">https://interlinkiq.com/</a> and click Log in. Enter your Username and Password.</li>
                                <li>Once successfully logged in, click the Enterprise Module.</li>
                                <li>Click Customer Module to view the list of your Customer.</li>
                                <li>Click View and go to Requirements Tab; comply by uploading the documents required in the list.</li>
                            </ol>

                            Kindly see the link below for our Customer Management Tutorial Video<br><br>

                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;"><b>Tutorial Video</b></td>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;"><b>Video Link</b></td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid; padding: 5px;">Free Access - Enterprise Management Module</td>
                                    <td style="border: 1px solid; padding: 5px;">https://www.youtube.com/watch?v=pyhPjZKTlaE</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid; padding: 5px;">Free Access - Customer Requirements Management Module</td>
                                    <td style="border: 1px solid; padding: 5px;">https://youtu.be/9XklXwGBr7E</td>
                                </tr>
                            </table><br><br>

                            Should you need assistance, kindly call 202-982-3002 or email '.$rowUser_email.'<br><br>

                            InterlinkIQ.com Team<br><br>
                            Consultare Inc.';

                            // if ($mail_sent > 0) {
                            //     php_mailer_2($to, $user, $subject, $body, $rowUser_email, $rowUser_name);
                            //     $mail_sent++;
                            // } else {
                                php_mailer_1($to, $user, $subject, $body, $rowUser_email, $rowUser_name);
                            //     $mail_sent++;
                            // }

                            // echo $to .'<br>';
                            // echo $user .'<br>';
                            // echo $body .'<br>';
                        }
                    }
                // }
            }
        }
    }

    // $chunkSize = 1000; // Adjust the chunk size as needed
    // $offset = 0;
    
    // while (true) {
        
    //     $stopStmt = $conn->prepare("UPDATE tbl_Customer_Relationship_Campaign 
    //                                 SET Auto_Send_Status = 0 
    //                                 WHERE Campaign_Id IN (
    //                                     SELECT Campaign_Id 
    //                                     FROM tbl_Customer_Relationship_Campaign 
    //                                     WHERE Campaign_added < DATE_SUB(CURDATE(), INTERVAL 90 DAY)
    //                                     -- LIMIT $offset, $chunkSize
    //                                 )");
        
    //     if (!$stopStmt) {
    //         die('Prepare failed: ' . $conn->error);
    //     }
    //     // $stopStmt->bind_param('ii', $offset, $chunkSize);
    //     $stopStmt->execute();
    
    //     $affectedRows = $stopStmt->affected_rows;
    //     if ($affectedRows === 0) {
    //         break;
    //     }
    
    //     $offset += $chunkSize;
    // }
    
    // $stopStmt->close();

    // while (true) {
    //     $stmt = $conn->prepare("
    //         SELECT * 
    //         FROM tbl_Customer_Relationship_Campaign 
    //         WHERE Campaign_Status = 2 AND Auto_Send_Status = 1 AND Frequency BETWEEN 1 AND 8
    //         LIMIT $offset, $chunkSize
    //     ");
    //     if (!$stmt) {
    //         die('Prepare failed: ' . $conn->error);
    //     }

    //     // $stmt->bind_param('ii', $offset, $chunkSize);
    //     $stmt->execute();
    //     $result_campaign = $stmt->get_result();

    //     if ($result_campaign->num_rows === 0) {
    //         break;
    //     }

    //     while ($row = $result_campaign->fetch_assoc()) {
    //         $frequency_ids = $row["Campaign_Id"];
    //         $frequency = $row["Frequency"];
    //         $frequency_custom = '0 | 0 | * | * | *';

    //         switch ($frequency) {
    //             case 1: $frequency_custom = '0 | 0 | * | * | *'; break;    // Once Per Day
    //             case 2: $frequency_custom = '0 | 0 | * | * | 0'; break;    // Once Per Week
    //             case 3: $frequency_custom = '0 | 0 | 1,15 | * | *'; break; // On the 1st and 15th of the Month
    //             case 4: $frequency_custom = '0 | 0 | 1 | * | *'; break;    // Once Per Month
    //             case 5: $frequency_custom = '0 | 0 | 1 | 1 | *'; break;    // Once Per Year
    //             case 6: $frequency_custom = '0 | 0 | 1 | */2 | *'; break;  // Every Other Month
    //             case 7: $frequency_custom = '0 | 0 | 1 | */4 | *'; break;  // Quarterly
    //             case 8: $frequency_custom = '0 | 0 | 1 | 1,7 | *'; break;  // Bi-Annual
    //         }

    //         $frequency_custom_arr = explode(" | ", $frequency_custom);
    //         $count_send = 0;

    //         // Check each frequency component
    //         if (is_numeric($frequency_custom_arr[0]) && $frequency_custom_arr[0] == $current_minute) {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[0] == '*') {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[0] == '*/2') {
    //             $count_send += intval(check($current_minute, 2));
    //         } else if ($frequency_custom_arr[0] == '*/5') {
    //             $count_send += intval(check($current_minute, 5));
    //         } else if ($frequency_custom_arr[0] == '*/10') {
    //             $count_send += intval(check($current_minute, 10));
    //         } else if ($frequency_custom_arr[0] == '*/15') {
    //             $count_send += intval(check($current_minute, 15));
    //         } else if ($frequency_custom_arr[0] == '0,30') {
    //             $count_send += intval(check($current_minute, 30));
    //         }

    //         if (is_numeric($frequency_custom_arr[1]) && $frequency_custom_arr[1] == $current_hour) {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[1] == '*') {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[1] == '*/2') {
    //             $count_send += intval(check($current_hour, 2));
    //         } else if ($frequency_custom_arr[1] == '*/3') {
    //             $count_send += intval(check($current_hour, 3));
    //         } else if ($frequency_custom_arr[1] == '*/4') {
    //             $count_send += intval(check($current_hour, 4));
    //         } else if ($frequency_custom_arr[1] == '*/6') {
    //             $count_send += intval(check($current_hour, 6));
    //         } else if ($frequency_custom_arr[1] == '0,12') {
    //             $count_send += intval(check($current_hour, 12));
    //         }

    //         if (is_numeric($frequency_custom_arr[2]) && $frequency_custom_arr[2] == $current_day) {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[2] == '*') {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[2] == '*/2') {
    //             $count_send += intval(check($current_day, 2));
    //         } else if ($frequency_custom_arr[2] == '1,15') {
    //             if ($current_day == 1 || $current_day == 15) {
    //                 $count_send++;
    //             }
    //         }

    //         if (is_numeric($frequency_custom_arr[3]) && $frequency_custom_arr[3] == $current_month) {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[3] == '*') {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[3] == '*/2') {
    //             $count_send += intval(check($current_month, 2));
    //         } else if ($frequency_custom_arr[3] == '*/4') {
    //             $count_send += intval(check($current_month, 4));
    //         } else if ($frequency_custom_arr[3] == '1,7') {
    //             if ($current_month == 1 || $current_month == 7) {
    //                 $count_send++;
    //             }
    //         }

    //         if (is_numeric($frequency_custom_arr[4]) && $frequency_custom_arr[4] == $current_weekday) {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[4] == '*') {
    //             $count_send++;
    //         } else if ($frequency_custom_arr[4] == '1-5') {
    //             if (in_array($current_weekday, range(1, 5))) {
    //                 $count_send++;
    //             }
    //         } else if ($frequency_custom_arr[4] == '6,7') {
    //             if ($current_weekday == 6 || $current_weekday == 7) {
    //                 $count_send++;
    //             }
    //         } else if ($frequency_custom_arr[4] == '1,3,5') {
    //             if ($current_weekday == 1 || $current_weekday == 3 || $current_weekday == 5) {
    //                 $count_send++;
    //             }
    //         } else if ($frequency_custom_arr[4] == '2,4') {
    //             if ($current_weekday == 2 || $current_weekday == 4) {
    //                 $count_send++;
    //             }
    //         }

    //         if ($count_send == 5) {
    //             $crm_ids = $row['crm_ids'];
    //             $acc_query = $conn->query("SELECT * FROM tbl_Customer_Relationship WHERE crm_id = $crm_ids");
    //             $account_name = '';
    //             foreach ($acc_query as $acct) {
    //                 $account_name = $acct['account_name'];
    //             }
    //             $rowUser_name = 'InterlinkIQ.com';
    //             $rowUser_email = $row['Campaign_from'];
    //             $to = $row['Campaign_Recipients'];
    //             $user = '';
    //             $subject = $row['Campaign_Subject'];
    //             $body = 'Hi ' . $account_name . ',<br><br>' . $row['Campaign_body'];

    //             php_mailer_1($to, $user, $subject, $body, $rowUser_email, $rowUser_name);
    //         }
    //     }

    //     // Move to the next chunk
    //     $offset += $chunkSize;
    //     $stmt->close();
    // }
 
    // $result_campaign = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = 2 and Auto_Send_Status = 1 AND Frequency BETWEEN 1 AND 8" );
    // if ( mysqli_num_rows($result_campaign) > 0 ) {
    //     $mail_sent = 0;
    //     while($row = mysqli_fetch_array($result_campaign)) {
    //         $frequency_ids = $row["Campaign_Id"];
    //         $frequency = $row["Frequency"];
    //         $frequency_custom = '0 | 0 | * | * | *';
    //         if ($frequency == 1) {
    //             $frequency_custom = '0 | 0 | * | * | *';    // Once Per Day
    //         } else if ($frequency == 2) {
    //             $frequency_custom = '0 | 0 | * | * | 0';    // Once Per Week
    //         } else if ($frequency == 3) {
    //             $frequency_custom = '0 | 0 | 1,15 | * | *'; // On the 1st and 15th of the Month
    //         } else if ($frequency == 4) {
    //             $frequency_custom = '0 | 0 | 1 | * | *';    // Once Per Month
    //         } else if ($frequency == 5) {
    //             $frequency_custom = '0 | 0 | 1 | 1 | *';    // Once Per Year
    //         } else if ($frequency == 6) {
    //             $frequency_custom = '0 | 0 | 1 | */2 | *';    // Every Other Month
    //         } else if ($frequency == 7) {
    //             $frequency_custom = '0 | 0 | 1 | */4 | *';    // Quarterly
    //         } else if ($frequency == 8) {
    //             $frequency_custom = '0 | 0 | 1 | 1,7 | *';    // Bi-Annual
    //         }
    //         $frequency_custom_arr = explode(" | ", $frequency_custom);

    //         $count_send = 0;
    //         if (is_numeric($frequency_custom_arr[0]) AND $frequency_custom_arr[0] == $current_minute) { // minute
    //             $count_send++;
    //         } else {
    //             if ($frequency_custom_arr[0] == '*') { 
    //                 $count_send++;
    //             } else if ($frequency_custom_arr[0] == '*/2') {
    //                 $count_send += intval(check($current_minute, 2));
    //             } else if ($frequency_custom_arr[0] == '*/5') {
    //                 $count_send += intval(check($current_minute, 5));
    //             } else if ($frequency_custom_arr[0] == '*/10') {
    //                 $count_send += intval(check($current_minute, 10));
    //             } else if ($frequency_custom_arr[0] == '*/15') {
    //                 $count_send += intval(check($current_minute, 15));
    //             } else if ($frequency_custom_arr[0] == '0,30') {
    //                 $count_send += intval(check($current_minute, 30));
    //             }
    //         }

    //         if (is_numeric($frequency_custom_arr[1]) AND $frequency_custom_arr[1] == $current_hour) { // hour
    //             $count_send++;
    //         } else {
    //             if ($frequency_custom_arr[1] == '*') {
    //                 $count_send++;
    //             } else if ($frequency_custom_arr[1] == '*/2') {
    //                 $count_send += intval(check($current_hour, 2));
    //             } else if ($frequency_custom_arr[1] == '*/3') {
    //                 $count_send += intval(check($current_hour, 3));
    //             } else if ($frequency_custom_arr[1] == '*/4') {
    //                 $count_send += intval(check($current_hour, 4));
    //             } else if ($frequency_custom_arr[1] == '*/6') {
    //                 $count_send += intval(check($current_hour, 6));
    //             } else if ($frequency_custom_arr[1] == '0,12') {
    //                 $count_send += intval(check($current_hour, 12));
    //             }
    //         }
            
    //         if (is_numeric($frequency_custom_arr[2]) AND $frequency_custom_arr[2] == $current_day) { // day
    //             $count_send++;
    //         } else {
    //             if ($frequency_custom_arr[2] == '*') {
    //                 $count_send++;
    //             } else if ($frequency_custom_arr[2] == '*/2') {
    //                 $count_send += intval(check($current_day, 2));
    //             } else if ($frequency_custom_arr[2] == '1,15') {
    //                 if ($current_day == 1 OR $current_day == 15) {
    //                     $count_send ++;
    //                 }
    //             }
    //         }
            
    //         if (is_numeric($frequency_custom_arr[3]) AND $frequency_custom_arr[3] == $current_month) { // month
    //             $count_send++;
    //         } else {
    //             if ($frequency_custom_arr[3] == '*') {
    //                 $count_send++;
    //             } else if ($frequency_custom_arr[3] == '*/2') {
    //                 $count_send += intval(check($current_month, 2));
    //             } else if ($frequency_custom_arr[3] == '*/4') {
    //                 $count_send += intval(check($current_month, 3));
    //             } else if ($frequency_custom_arr[3] == '1,7') {
    //                 if ($current_month == 1 OR $current_month == 7) {
    //                     $count_send ++;
    //                 }
    //             }
    //         }
            
    //         if (is_numeric($frequency_custom_arr[4]) AND $frequency_custom_arr[4] == $current_weekday) { // weekday
    //             $count_send++;
    //         } else {
    //             if ($frequency_custom_arr[4] == '*') {
    //                 $count_send++;
    //             } else if ($frequency_custom_arr[4] == '1-5') {
    //                 if (in_array($current_weekday, range(1,5))) {
    //                     $count_send ++;
    //                 }
    //             } else if ($frequency_custom_arr[4] == '6,7') {
    //                 if ($current_weekday == 6 OR $current_weekday == 7) {
    //                     $count_send ++;
    //                 }
    //             } else if ($frequency_custom_arr[4] == '1,3,5') {
    //                 if ($current_weekday == 1 OR $current_weekday == 3 OR $current_weekday == 5) {
    //                     $count_send ++;
    //                 }
    //             } else if ($frequency_custom_arr[4] == '2,4') {
    //                 if ($current_weekday == 2 OR $current_weekday == 4) {
    //                     $count_send ++;
    //                 }
    //             }
    //         }

    //         if ($count_send == 5) {
    //             $crm_ids = $row['crm_ids'];
    //             $acc_query = mysqli_query($conn, "select * from tbl_Customer_Relationship where crm_id = $crm_ids");
    //             foreach($acc_query as $acct){
    //                 $account_name = $acct['account_name'];
    //             }
    //             $rowUser_name = 'InterlinkIQ.com';
    //             $rowUser_email = $row['Campaign_from'];
    //             $to = $row['Campaign_Recipients'];
    //             $user = '';
    //             $subject = $row['Campaign_Subject'];
    //             $body = 'Hi '.$account_name.',<br><br>'.$row['Campaign_body'];

    //             php_mailer_1($to, $user, $subject, $body, $rowUser_email, $rowUser_name);
    //         }
    //     }
    // }

    // Password Expired - DAILY NOTIFICATION
    $frequency_custom = '0 | 0 | * | * | *';    // Once Per Day
    $frequency_custom_arr = explode(" | ", $frequency_custom);
    if ($frequency_custom_arr[0] == $current_minute AND $frequency_custom_arr[1] == $current_hour) {
        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE is_verified = 1 AND is_active = 1 AND last_modified IS NOT NULL" );
        $mail_sent = 0;
        $from_email = 'services@interlinkiq.com';
        $from_user = 'Interlink IQ';
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user_ID = $rowUser["ID"];
                $user_fullname = $rowUser["first_name"] .' '. $rowUser["last_name"];
                $user_email = $rowUser["email"];
                $user_last_modified = $rowUser["last_modified"];

                $now = time(); // or your date as well
                $your_date = strtotime($rowUser["last_modified"]);
                $datediff = $now - $your_date;
                $remaining_days = round($datediff / (60 * 60 * 24));

                $to = $user_email;
                $user = $user_fullname;

                if ($remaining_days == 60) {
                    // echo 'Expired'. $remaining_days;

                    mysqli_query( $conn,"UPDATE tbl_user set is_active = 0 WHERE ID = $user_ID" );

                    $subject = 'Password Expired!';
                    $body = 'Hi '.$user.',<br><br>

                    Your account has been locked due to password expired!<br>

                    To retrieve your account, kindly click the button below<br>

                    <a href="'. $base_url .'CannOS-Login?l=1&i='. $user_ID .'" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">Update Password</a>';
                } else if ($remaining_days >= 45) {
                    // echo 'Remind'. $remaining_days;
                    
                    $subject = 'Password Expired!';
                    $body = 'Hi '.$user.',<br><br>

                    A gentle reminder to update your password before your account gets locked!<br><br>

                    Kindly go to My profile Page and tap Change Password';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from_email, $from_user);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from_email, $from_user);
                //     $mail_sent++;
                // }
            }
        }
    }
    
    
    // CRM Task - Monday/Friday Notification
    // if ($current_minute == 0) {
    // if ($current_minute == 0 AND $current_hour == 0 AND $current_weekday == 1 OR $current_weekday == 5) {
    if ($current_minute == 0 AND $current_hour == 0) {
        if ($current_weekday == 1 OR $current_weekday == 5) {
            $selectCRM = mysqli_query( $conn,"SELECT * FROM tbl_Customer_Relationship_Task WHERE Task_Status != 3 mail_status = 1");
            $mail_sent = 0;
            $from_email = 'services@interlinkiq.com';
            $from_user = 'Interlink IQ';
            if ( mysqli_num_rows($selectCRM) > 0 ) {
                while($rowCRM = mysqli_fetch_array($selectCRM)) {
                    $crm_ids = $rowCRM["crm_ids"];
                    $Assigned_to = $rowCRM["Assigned_to"];
                    $assign_task = $rowCRM["assign_task"];
                    $Task_Description = $rowCRM["Task_Description"];

                    if ($rowCRM["Task_Status"] == 2) {
                        $Task_Status = 'In-Progress';
                    } else {
                        $Task_Status = 'Pending';
                    }

                    $subject = 'CRM Task - Follow-ups!';
                    $body = 'Hi '.$Assigned_to.',<br><br>

                    Gentle reminder on your <b>'.$Task_Status.'</b> Task!<br><br>

                    <b>Task Name:</b> '.$assign_task.'<br>
                    <b>Description:</b> '.$Task_Description.'<br><br>

                    Kindly update the status once done<br><br>

                    <a href="'. $base_url .'customer_details.php?view_id='.$crm_ids.'#tasks" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">View</a>';

                    // if ($mail_sent > 0) {
                    //     php_mailer_2($Assigned_to, '', $subject, $body, $from_email, $from_user);
                    //     $mail_sent++;
                    // } else {
                        php_mailer_1($Assigned_to, '', $subject, $body, $from_email, $from_user);
                    //     $mail_sent++;
                    // }
                }
            }
        }
    }
    
    // for task due date
    $frequency_custom = '0 | 0 | * | * | *';    // Once Per Day
    $frequency_custom_arr = explode(" | ", $frequency_custom);
    if ($frequency_custom_arr[0] == $current_minute AND $frequency_custom_arr[1] == $current_hour) {
        
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
        </table>';
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
    }
    


    if ($current_minute == 0 AND $current_hour == 0) {
        // TRAINING RECORD
        // Expired
        $selectUser = mysqli_query( $conn,"SELECT 
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            e.user_id AS e_user_id,
            e.job_description_id AS e_job_description_id
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tbl_hr_employee
                WHERE suspended = 0
                AND status = 1
            ) AS e
            ON u.employee_id = e.ID

            WHERE u.employee_id > 0
            AND u.is_verified = 1
            AND u.is_active = 1" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $e_user_id = $rowUser["e_user_id"];
            $to = $rowUser["u_email"];
            $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
            $subject = 'Training Record Expired';

            $selectTrainings = mysqli_query( $conn,"SELECT 
                *
                FROM (
                    SELECT
                    t.ID AS t_ID,
                    t.title AS t_title,
                    t.job_description_id AS t_job_description_id,
                    replace(t.quiz_id , ' ','') AS t_quiz_id,
                    t.last_modified AS t_last_modified,
                    t.frequency AS t_frequency,
                    q.ID AS q_ID,
                    q.quiz_id AS q_quiz_id,
                    q.result AS q_result,
                    q.last_modified AS q_last_modified
                    FROM tbl_hr_trainings AS t
                    
                    LEFT JOIN (
                        SELECT * 
                        FROM tbl_hr_quiz_result 
                        WHERE ID IN ( 
                            SELECT MAX(ID) 
                            FROM tbl_hr_quiz_result
                            WHERE user_id = $e_user_id
                            GROUP BY quiz_id 
                        )
                    ) AS q
                    ON FIND_IN_SET(q.quiz_id, t.quiz_id) > 0
                    
                    WHERE q.result = 100
                    AND t.status = 1
                    AND t.deleted = 0
                    AND t.user_id = $e_user_id
                ) AS r" );
            if ( mysqli_num_rows($selectTrainings) > 0 ) {
                while($rowTraining = mysqli_fetch_array($selectTrainings)) {
                    $training_ID = $rowTraining['t_ID'];
                    $title = $rowTraining['t_title'];
                    $array_rowTraining = explode(", ", $rowTraining["t_job_description_id"]);

                    $array_frequency = array(
                        0 => '+1 month',
                        1 => '+3 month',
                        2 => '+6 month',
                        3 => '+1 year'
                    );

                    $array_frequency_type = array(
                        0 => 'monthly',
                        1 => 'quarter',
                        2 => 'bi-annual',
                        3 => 'an annual'
                    );

                    $found = null;
                    $array_row = explode(", ", $rowUser["e_job_description_id"]);
                    foreach($array_row as $emp_JD) {
                        if (in_array($emp_JD,$array_rowTraining)) {
                            $found = true;
                        }
                    }

                    if ( $found == true ) {
                        $completed_date = $rowTraining['q_last_modified'];
                        $completed_date = new DateTime($completed_date);
                        $completed_date = $completed_date->format('M d, Y');

                        if (date('Y-m-d') > date('Y-m-d', strtotime($array_frequency[$rowTraining['t_frequency']], strtotime($completed_date)) )) {
                            $body = 'Hi '.$user.',<br><br>

                            The following training record has expired:<br>

                            '.$title.'<br>
                            '.$completed_date.'<br><br>

                            All trainings must be completed on '.$array_frequency_type[$rowTraining['t_frequency']].' basis. Navigate to the training module to complete your annual training and assessment.<br><br>';

                            if ($rowUser['u_client'] == 1) {
                                $from = 'CannOS@begreenlegal.com';
                                $name = 'BeGreenLegal';
                                $body .= 'Cann OS Team';
                            } else {
                                $from = 'services@interlinkiq.com';
                                $name = 'InterlinkIQ';
                                $body .= 'InterlinkIQ.com Team<br>
                                Consultare Inc.';
                            }

                            // if ($mail_sent > 0) {
                            //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // } else {
                                php_mailer_1($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // }
                        }
                    }
                }
            }
        }

        // 7 days before due
        $selectUser = mysqli_query( $conn,"SELECT 
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            e.user_id AS e_user_id,
            e.job_description_id AS e_job_description_id
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tbl_hr_employee
                WHERE suspended = 0
                AND status = 1
            ) AS e
            ON u.employee_id = e.ID

            WHERE u.employee_id > 0
            AND u.is_verified = 1
            AND u.is_active = 1" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $e_user_id = $rowUser["e_user_id"];
            $to = $rowUser["u_email"];
            $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
            $subject = 'Training Due Date Approaching';

            $selectTrainings = mysqli_query( $conn,"SELECT 
                *
                FROM (
                    SELECT
                    t.ID AS t_ID,
                    t.title AS t_title,
                    t.job_description_id AS t_job_description_id,
                    replace(t.quiz_id , ' ','') AS t_quiz_id,
                    t.last_modified AS t_last_modified,
                    t.frequency AS t_frequency,
                    q.ID AS q_ID,
                    q.quiz_id AS q_quiz_id,
                    q.result AS q_result,
                    q.last_modified AS q_last_modified
                    FROM tbl_hr_trainings AS t
                    
                    LEFT JOIN (
                        SELECT * 
                        FROM tbl_hr_quiz_result 
                        WHERE ID IN ( 
                            SELECT MAX(ID) 
                            FROM tbl_hr_quiz_result
                            WHERE user_id = $e_user_id
                            GROUP BY quiz_id 
                        )
                    ) AS q
                    ON FIND_IN_SET(q.quiz_id, t.quiz_id) > 0
                    
                    WHERE q.result = 100
                    AND t.status = 1
                    AND t.deleted = 0
                    AND t.user_id = $e_user_id
                ) AS r" );
            if ( mysqli_num_rows($selectTrainings) > 0 ) {
                while($rowTraining = mysqli_fetch_array($selectTrainings)) {
                    $training_ID = $rowTraining['t_ID'];
                    $title = $rowTraining['t_title'];
                    $array_rowTraining = explode(", ", $rowTraining["t_job_description_id"]);

                    $array_frequency = array(
                        0 => '+1 month',
                        1 => '+3 month',
                        2 => '+6 month',
                        3 => '+1 year'
                    );

                    $array_frequency_type = array(
                        0 => 'monthly',
                        1 => 'quarter',
                        2 => 'bi-annual',
                        3 => 'an annual'
                    );

                    $found = null;
                    $array_row = explode(", ", $rowUser["e_job_description_id"]);
                    foreach($array_row as $emp_JD) {
                        if (in_array($emp_JD,$array_rowTraining)) {
                            $found = true;
                        }
                    }

                    if ( $found == true ) {
                        $completed_date = $rowTraining['q_last_modified'];
                        $completed_date = new DateTime($completed_date);
                        $completed_date = $completed_date->format('M d, Y');

                        $due_date = date('Y-m-d', strtotime($array_frequency[$rowTraining['t_frequency']], strtotime($completed_date)) );
                        $due_date = new DateTime($due_date);
                        $due_date = $due_date->format('M d, Y');

                        if (date('Y-m-d') >= date('Y-m-d', strtotime('-7 day', strtotime($due_date)) )  AND date('Y-m-d') < date('Y-m-d', strtotime($due_date)) ) {
                            $body = 'Hi '.$user.',<br><br>

                            The following training is due to be completed in the next 7 days:<br>

                            '.$title.'<br>
                            '.$due_date.'<br><br>

                            Navigate to the training module to complete your assigned training and assessment.<br><br>';

                            if ($rowUser['u_client'] == 1) {
                                $from = 'CannOS@begreenlegal.com';
                                $name = 'BeGreenLegal';
                                $body .= 'Cann OS Team';
                            } else {
                                $from = 'services@interlinkiq.com';
                                $name = 'InterlinkIQ';
                                $body .= 'InterlinkIQ.com Team<br>
                                Consultare Inc.';
                            }

                            // if ($mail_sent > 0) {
                            //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // } else {
                                php_mailer_1($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // }
                        }
                    }
                }
            }
        }

        // Due
        $selectUser = mysqli_query( $conn,"SELECT 
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            e.user_id AS e_user_id,
            e.job_description_id AS e_job_description_id
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tbl_hr_employee
                WHERE suspended = 0
                AND status = 1
            ) AS e
            ON u.employee_id = e.ID

            WHERE u.employee_id > 0
            AND u.is_verified = 1
            AND u.is_active = 1" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $e_user_id = $rowUser["e_user_id"];
            $to = $rowUser["u_email"];
            $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
            $subject = 'Training Due';

            $selectTrainings = mysqli_query( $conn,"SELECT 
                *
                FROM (
                    SELECT
                    t.ID AS t_ID,
                    t.title AS t_title,
                    t.job_description_id AS t_job_description_id,
                    replace(t.quiz_id , ' ','') AS t_quiz_id,
                    t.last_modified AS t_last_modified,
                    t.frequency AS t_frequency,
                    q.ID AS q_ID,
                    q.quiz_id AS q_quiz_id,
                    q.result AS q_result,
                    q.last_modified AS q_last_modified
                    FROM tbl_hr_trainings AS t
                    
                    LEFT JOIN (
                        SELECT * 
                        FROM tbl_hr_quiz_result 
                        WHERE ID IN ( 
                            SELECT MAX(ID) 
                            FROM tbl_hr_quiz_result
                            WHERE user_id = $e_user_id
                            GROUP BY quiz_id 
                        )
                    ) AS q
                    ON FIND_IN_SET(q.quiz_id, t.quiz_id) > 0
                    
                    WHERE q.result = 100
                    AND t.status = 1
                    AND t.deleted = 0
                    AND t.user_id = $e_user_id
                ) AS r" );
            if ( mysqli_num_rows($selectTrainings) > 0 ) {
                while($rowTraining = mysqli_fetch_array($selectTrainings)) {
                    $training_ID = $rowTraining['t_ID'];
                    $title = $rowTraining['t_title'];
                    $array_rowTraining = explode(", ", $rowTraining["t_job_description_id"]);

                    $array_frequency = array(
                        0 => '+1 month',
                        1 => '+3 month',
                        2 => '+6 month',
                        3 => '+1 year'
                    );

                    $array_frequency_type = array(
                        0 => 'monthly',
                        1 => 'quarter',
                        2 => 'bi-annual',
                        3 => 'an annual'
                    );

                    $found = null;
                    $array_row = explode(", ", $rowUser["e_job_description_id"]);
                    foreach($array_row as $emp_JD) {
                        if (in_array($emp_JD,$array_rowTraining)) {
                            $found = true;
                        }
                    }

                    if ( $found == true ) {
                        $completed_date = $rowTraining['q_last_modified'];
                        $completed_date = new DateTime($completed_date);
                        $completed_date = $completed_date->format('M d, Y');

                        $due_date = date('Y-m-d', strtotime($array_frequency[$rowTraining['t_frequency']], strtotime($completed_date)) );
                        $due_date = new DateTime($due_date);
                        $due_date = $due_date->format('M d, Y');

                        if ( date('Y-m-d') == date('Y-m-d', strtotime($due_date)) ) {
                            $body = 'Hi '.$user.',<br><br>

                            The following training is due:<br>

                            '.$title.'<br>
                            '.$due_date.'<br><br>

                            Navigate to the training module to complete your assigned training and assessment.<br><br>';

                            if ($rowUser['u_client'] == 1) {
                                $from = 'CannOS@begreenlegal.com';
                                $name = 'BeGreenLegal';
                                $body .= 'Cann OS Team';
                            } else {
                                $from = 'services@interlinkiq.com';
                                $name = 'InterlinkIQ';
                                $body .= 'InterlinkIQ.com Team<br>
                                Consultare Inc.';
                            }

                            // if ($mail_sent > 0) {
                            //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // } else {
                                php_mailer_1($to, $user, $subject, $body, $from, $name);
                            //     $mail_sent++;
                            // }
                        }
                    }
                }
            }
        }

        // MY PRO Task Due Soon
        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id > 0 AND is_verified = 1 AND is_active = 1" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $to = $rowUser["email"];
                $user = $rowUser["first_name"].' '.$rowUser["last_name"];
                $user_id = $rowUser["employee_id"];
                $subject = date("l").' – Tasks Due Soon';

                $selectAction = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE is_deleted = 0 AND LENGTH(CAI_Action_due_date) > 0 AND CAI_Action_due_date >= CURDATE() AND CAI_Assign_to = $user_id" );
                if ( mysqli_num_rows($selectAction) > 0 ) {

                    $body = 'Hi '.$user.',<br><br>

                    Here’s your '.date("l").' update!<br>

                    <table cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;table-layout:fixed;width:100%">';
                        while($rowAction = mysqli_fetch_array($selectAction)) {
                            $body .= '<tr>
                                <td>'.$rowAction["CAI_filename"].'</td>
                                <td>'.$rowAction["CAI_Accounts"].'</td>
                                <td>'.$rowAction["CAI_Action_due_date"].'</td>
                            </tr>';
                        }

                    $body .= '</table><br><br>';

                    if ($rowUser['client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }

                    // if ($mail_sent > 0) {
                    //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                    //     $mail_sent++;
                    // } else {
                        php_mailer_1($to, $user, $subject, $body, $from, $name);
                    //     $mail_sent++;
                    // }
                }
            }
        }
        
        
        // CAPAM - Every Friday
        if ($current_weekday == 5) {
            // $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
            $selectUser = mysqli_query( $conn,"SELECT
                u.ID AS u_ID,
                u.first_name AS u_first_name,
                u.last_name AS u_last_name,
                u.email AS u_email,
                u.client AS u_client,
                c.user_id AS c_user_id
                FROM tbl_user AS u

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_cam
                ) AS c
                ON u.ID = c.user_id

                WHERE u.is_active = 1
                AND u.employee_id = 0

                GROUP BY u.ID" );
            if ( mysqli_num_rows($selectUser) > 0 ) {
                $mail_sent = 0;
                while($rowUser = mysqli_fetch_array($selectUser)) {
                    $switch_user_id = $rowUser["u_ID"];
                    $to = $rowUser["u_email"];
                    $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                    $subject = 'CAPA Status Update!';
                    $body = 'Hi '.$user.',<br><br>

                    Here is your weekly CAPA status update!<br><br>

                    Open:<br>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: 1px solid; padding: 5px; text-align: center;"><b>CAPA ID</b></td>
                            <td style="border: 1px solid; padding: 5px; text-align: center;"><b>Date Created</b></td>
                            <td style="border: 1px solid; padding: 5px;"><b>Personnel Involved</b></td>
                            <td style="border: 1px solid; padding: 5px;"><b>Department</b></td>
                        </tr>';

                        $selectCamOpen = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE status = 0 AND user_id = $switch_user_id ORDER BY ID DESC" );
                        if ( mysqli_num_rows($selectCamOpen) > 0 ) {
                            while ($rowOpen= mysqli_fetch_array($selectCamOpen)) {
                                $cam_ID = $rowOpen['ID'];
                                $cam_reference = $rowOpen['reference'];
                                $cam_date = $rowOpen['date'];
                                $cam_observed_by = $rowOpen['observed_by'];
                                $cam_reported_by = $rowOpen['reported_by'];
                                $cam_description = $rowOpen['description'];

                                $cam_department_id = $rowOpen['department_id'];
                                $cam_department_other = $rowOpen['department_other'];
                                $data_department_id = array();
                                if (!empty($cam_department_id)) {
                                    $array_department_id = explode(", ", $cam_department_id);
                                    $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                    if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                        while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                            if (in_array($rowDept["ID"], $array_department_id)) {
                                                array_push($data_department_id, $rowDept["title"]);
                                            }
                                        }
                                    }

                                    if (in_array(0, $array_department_id)) {
                                        array_push($data_department_id, stripcslashes($cam_department_other));
                                    }
                                }
                                $data_department_id = implode(", ",$data_department_id);

                                $cam_employee_id = $rowOpen['employee_id'];
                                $data_employee_id = array();
                                if (!empty($cam_employee_id)) {
                                    $array_employee_id = explode(", ", $cam_employee_id);
                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                            }
                                        }
                                    }
                                }
                                $data_employee_id = implode(", ",$data_employee_id);

                                $body .= '<tr>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;">'.$cam_ID.'</td>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;">'.$cam_date.'</td>
                                    <td style="border: 1px solid; padding: 5px;">'.$data_employee_id.'</td>
                                    <td style="border: 1px solid; padding: 5px;">'.$data_department_id.'</td>
                                </tr>';
                            }
                        }

                    $body .= '</table><br><br>

                    Closed:<br>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: 1px solid; padding: 5px; text-align: center;"><b>CAPA ID</b></td>
                            <td style="border: 1px solid; padding: 5px; text-align: center;"><b>Date Created</b></td>
                            <td style="border: 1px solid; padding: 5px;"><b>Personnel Involved</b></td>
                            <td style="border: 1px solid; padding: 5px;"><b>Department</b></td>
                        </tr>';

                        $selectCamClose = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE status = 1 AND user_id = $switch_user_id ORDER BY ID DESC" );
                        if ( mysqli_num_rows($selectCamClose) > 0 ) {
                            while ($rowClose= mysqli_fetch_array($selectCamClose)) {
                                $cam_ID = $rowClose['ID'];
                                $cam_reference = $rowClose['reference'];
                                $cam_date = $rowClose['date'];
                                $cam_observed_by = $rowClose['observed_by'];
                                $cam_reported_by = $rowClose['reported_by'];
                                $cam_description = $rowClose['description'];

                                $cam_department_id = $rowClose['department_id'];
                                $cam_department_other = $rowClose['department_other'];
                                $data_department_id = array();
                                if (!empty($cam_department_id)) {
                                    $array_department_id = explode(", ", $cam_department_id);
                                    $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                    if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                        while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                            if (in_array($rowDept["ID"], $array_department_id)) {
                                                array_push($data_department_id, $rowDept["title"]);
                                            }
                                        }
                                    }

                                    if (in_array(0, $array_department_id)) {
                                        array_push($data_department_id, stripcslashes($cam_department_other));
                                    }
                                }
                                $data_department_id = implode(", ",$data_department_id);

                                $cam_employee_id = $rowClose['employee_id'];
                                $data_employee_id = array();
                                if (!empty($cam_employee_id)) {
                                    $array_employee_id = explode(", ", $cam_employee_id);
                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                            }
                                        }
                                    }
                                }
                                $data_employee_id = implode(", ",$data_employee_id);

                                $body .= '<tr>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;">'.$cam_ID.'</td>
                                    <td style="border: 1px solid; padding: 5px; text-align: center;">'.$cam_date.'</td>
                                    <td style="border: 1px solid; padding: 5px;">'.$data_employee_id.'</td>
                                    <td style="border: 1px solid; padding: 5px;">'.$data_department_id.'</td>
                                </tr>';
                            }
                        }
                        
                    $body .= '</table><br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }

                    // if ($mail_sent > 0) {
                    //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                    //     $mail_sent++;
                    // } else {
                        php_mailer_1($to, $user, $subject, $body, $from, $name);
                    //     $mail_sent++;
                    // }
                }
            }
        }
        
        
        // ENTERPRISE - Certification / Accreditation / Record - Daily
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            r.ownedby AS r_ownedby,
            r.expiry_date AS r_expiry_date
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_registration
                WHERE table_entities = 3
                OR table_entities = 4
            ) AS r
            ON u.ID = r.ownedby

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND DATE(r.expiry_date) = CURDATE()

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $subject = 'Expired Document: Enterprise Certification/Accreditation!';
                $body = 'Hi '.$user.',<br><br>

                The following document(s) will expire today:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_registration WHERE table_entities = 3 AND ownedby = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["registration_name"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            r.user_cookies AS r_user_cookies,
            r.DocumentDueDate AS r_DocumentDueDate
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblEnterpiseDetails_Records
            ) AS r
            ON u.ID = r.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND DATE(r.DocumentDueDate) = CURDATE()

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $subject = 'Expired Document: Enterprise Record!';
                $body = 'Hi '.$user.',<br><br>

                The following document(s) will expire today:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Records WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["DocumentTitle"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        
        // ENTERPRISE - Certification / Accreditation / Record - After 30/60days
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            r.ownedby AS r_ownedby,
            r.expiry_date AS r_expiry_date
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_registration
                WHERE table_entities = 3
                OR table_entities = 4
            ) AS r
            ON u.ID = r.ownedby

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND (DATE(r.expiry_date) = DATE_ADD(CURDATE(),INTERVAL 30 DAY) OR DATE(r.expiry_date) = DATE_ADD(CURDATE(),INTERVAL 60 DAY))

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $date1=date_create($rowUser["r_expiry_date"]);
                $date2=date_create($current_date);
                $diff=date_diff($date1,$date2);

                $subject = 'Expired Document: Enterprise Certification/Accreditation - '.$diff->format("%a days");
                $body = 'Hi '.$user.',<br><br>

                The following document(s) have expired:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_registration WHERE table_entities = 3 AND ownedby = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["registration_name"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            r.user_cookies AS r_user_cookies,
            r.DocumentDueDate AS r_DocumentDueDate
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblEnterpiseDetails_Records
            ) AS r
            ON u.ID = r.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND (DATE(r.DocumentDueDate) = DATE_ADD(CURDATE(),INTERVAL 30 DAY) OR DATE(r.DocumentDueDate) = DATE_ADD(CURDATE(),INTERVAL 60 DAY))

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $date1=date_create($rowUser["r_DocumentDueDate"]);
                $date2=date_create($current_date);
                $diff=date_diff($date1,$date2);

                $subject = 'Expired Document: Enterprise Record - '.$diff->format("%a days");
                $body = 'Hi '.$user.',<br><br>

                The following document(s) have expired:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails_Records WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["DocumentTitle"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
    
        // FACILITY - Certification / Accreditation - Daily
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            c.user_cookies AS c_user_cookies,
            c.Expiration_Date_Certification AS c_Expiration_Date_Certification
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_Certification
            ) AS c
            ON u.ID = c.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND DATE(c.Expiration_Date_Certification) = CURDATE()

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $subject = 'Expired Document: Enterprise Certification!';
                $body = 'Hi '.$user.',<br><br>

                The following document(s) will expire today:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Certification WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["Type_Certification"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            a.user_cookies AS a_user_cookies,
            a.Expiration_Date_Type_Accreditation AS a_Expiration_Date_Type_Accreditation
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_Accreditation
            ) AS a
            ON u.ID = a.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND DATE(a.Expiration_Date_Type_Accreditation) = CURDATE()

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $subject = 'Expired Document: Enterprise Accreditation!';
                $body = 'Hi '.$user.',<br><br>

                The following document(s) will expire today:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Accreditation WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["Type_Accreditation"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        
        // FACILITY - Certification / Accreditation - After 30/60days
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            c.user_cookies AS c_user_cookies,
            c.Expiration_Date_Certification AS c_Expiration_Date_Certification
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_Certification
            ) AS c
            ON u.ID = c.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND (DATE(c.Expiration_Date_Certification) = DATE_ADD(CURDATE(),INTERVAL 30 DAY) OR DATE(c.Expiration_Date_Certification) = DATE_ADD(CURDATE(),INTERVAL 60 DAY))

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $date1=date_create($rowUser["c_Expiration_Date_Certification"]);
                $date2=date_create($current_date);
                $diff=date_diff($date1,$date2);

                $subject = 'Expired Document: Enterprise Certification - '.$diff->format("%a days");
                $body = 'Hi '.$user.',<br><br>

                The following document(s) have expired:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Certification WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["Type_Certification"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            a.user_cookies AS a_user_cookies,
            a.Expiration_Date_Type_Accreditation AS a_Expiration_Date_Type_Accreditation
            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tblFacilityDetails_Accreditation
            ) AS a
            ON u.ID = a.user_cookies

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND (DATE(a.Expiration_Date_Type_Accreditation) = DATE_ADD(CURDATE(),INTERVAL 30 DAY) OR DATE(a.Expiration_Date_Type_Accreditation) = DATE_ADD(CURDATE(),INTERVAL 60 DAY))

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $date1=date_create($rowUser["a_Expiration_Date_Type_Accreditation"]);
                $date2=date_create($current_date);
                $diff=date_diff($date1,$date2);

                $subject = 'Expired Document: Enterprise Accreditation - '.$diff->format("%a days");
                $body = 'Hi '.$user.',<br><br>

                The following document(s) have expired:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tblFacilityDetails_Accreditation WHERE user_cookies = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["Type_Accreditation"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        
        // COMPLIANCE DASHBOARD - File - Daily
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            f.user_id AS f_user_id,
            f.due_date AS f_due_date

            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tbl_library_file
                WHERE deleted = 0
            ) AS f
            ON u.ID = f.user_id

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND DATE(f.due_date) = CURDATE()

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $subject = 'Expired Document: Compliance Dashboard File!';
                $body = 'Hi '.$user.',<br><br>

                The following document(s) will expire today:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND user_id = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["name"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }
        
        
        // COMPLIANCE DASHBOARD - File - After 30/60days
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            f.user_id AS f_user_id,
            f.due_date AS f_due_date

            FROM tbl_user AS u

            INNER JOIN (
                SELECT
                *
                FROM tbl_library_file
                WHERE deleted = 0
            ) AS f
            ON u.ID = f.user_id

            WHERE u.is_active = 1
            AND u.employee_id = 0
            AND (DATE(f.due_date) = DATE_ADD(CURDATE(),INTERVAL 30 DAY) OR DATE(f.due_date) = DATE_ADD(CURDATE(),INTERVAL 60 DAY))

            GROUP BY u.ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $mail_sent = 0;
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $switch_user_id = $rowUser["u_ID"];
                $to = $rowUser["f_due_date"];
                $to = $rowUser["u_email"];
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];

                $date1=date_create($rowUser["f_due_date"]);
                $date2=date_create($current_date);
                $diff=date_diff($date1,$date2);

                $subject = 'Expired Document: Compliance Dashboard File - '.$diff->format("%a days");
                $body = 'Hi '.$user.',<br><br>

                The following document(s) have expired:
                <ul>';

                $selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND user_id = $switch_user_id" );
                if ( mysqli_num_rows($selectData) > 0 ) {
                    while($rowData = mysqli_fetch_array($selectData)) {
                        $body .= '<li>'.$rowData["name"].'</li>';
                    }
                }

                $body .= '</ul>';

                if ($rowUser['u_client'] == 1) {
                    $from = 'CannOS@begreenlegal.com';
                    $name = 'BeGreenLegal';
                    $body .= 'Cann OS Team';
                } else {
                    $from = 'services@interlinkiq.com';
                    $name = 'InterlinkIQ';
                    $body .= 'InterlinkIQ.com Team<br>
                    Consultare Inc.';
                }

                // if ($mail_sent > 0) {
                //     php_mailer_2($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                //     $mail_sent++;
                // }
            }
        }


        // SAP MODULE
        // Send 30/60 days before expire notif to the sender
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.user_id = u.ID

            WHERE s.page = 1
            AND s.is_deleted = 0

            GROUP BY s.user_id

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.user_id = $u_ID
                        
                        UNION ALL
                        
                        SELECT
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        WHERE s2.page = $s_page 
                        AND s2.is_deleted = 0 
                        AND s2.user_id = $u_ID
                    )
                    SELECT 
                    s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = '30/60 Days Before Expiration: Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["s_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send expired notif to the sender
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.user_id = u.ID

            WHERE s.page = 1
            AND s.is_deleted = 0

            GROUP BY s.user_id

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID
                        
                        WHERE s1.page = $s_page 
                        AND s1.is_deleted = 0 
                        AND s1.user_id = $u_ID
                        
                        UNION ALL
                        
                        SELECT
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        WHERE s2.page = $s_page 
                        AND s2.is_deleted = 0 
                        AND s2.user_id = $u_ID
                    )
                    SELECT 
                    s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = 'Expired Document: Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["s_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send 30/60 days before expire notif to the receiver
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.email = u.email

            WHERE s.page = 1
            AND s.is_deleted = 0

            GROUP BY u.ID

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        u1.ID AS u_ID,
                        u1.first_name AS u_first_name,
                        u1.last_name AS u_last_name,
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u1
                        ON s1.user_id = u1.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.email = $to
                        
                        UNION ALL
                        
                        SELECT
                        u2.ID AS u_ID,
                        u2.first_name AS u_first_name,
                        u2.last_name AS u_last_name,
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u2
                        ON s2.user_id = u2.ID

                        WHERE s2.page = $s_page
                        AND s2.is_deleted = 0 
                        AND s2.email = $to
                    )
                    SELECT 
                    u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = '30/60 Days Before Expiration: Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["u_first_name"].' '.$rowSupplier["u_last_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send expired notif to the receiver
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.email = u.email

            WHERE s.page = 1
            AND s.is_deleted = 0

            GROUP BY u.ID

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        u1.ID AS u_ID,
                        u1.first_name AS u_first_name,
                        u1.last_name AS u_last_name,
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u1
                        ON s1.user_id = u1.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.email = $to
                        
                        UNION ALL
                        
                        SELECT
                        u2.ID AS u_ID,
                        u2.first_name AS u_first_name,
                        u2.last_name AS u_last_name,
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u2
                        ON s2.user_id = u2.ID

                        WHERE s2.page = $s_page
                        AND s2.is_deleted = 0 
                        AND s2.email = $to
                    )
                    SELECT 
                    u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = 'Expired Document: Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["u_first_name"].' '.$rowSupplier["u_last_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }


        // CUSTOMER MODULE
        // Send 30/60 days before expire notif to the sender
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.user_id = u.ID

            WHERE s.page = 2
            AND s.is_deleted = 0

            GROUP BY s.user_id

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.user_id = $u_ID
                        
                        UNION ALL
                        
                        SELECT
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0
                        
                        WHERE s2.page = $s_page 
                        AND s2.is_deleted = 0 
                        AND s2.user_id = $u_ID
                    )
                    SELECT 
                    s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = '30/60 Days Before Expiration: Customer Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["s_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send expired notif to the sender
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.user_id = u.ID

            WHERE s.page = 2
            AND s.is_deleted = 0

            GROUP BY s.user_id

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID
                        
                        WHERE s1.page = $s_page 
                        AND s1.is_deleted = 0 
                        AND s1.user_id = $u_ID
                        
                        UNION ALL
                        
                        SELECT
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        WHERE s2.page = $s_page 
                        AND s2.is_deleted = 0 
                        AND s2.user_id = $u_ID
                    )
                    SELECT 
                    s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = 'Expired Document: Customer Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["s_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$rowSupplier["s_name"].'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send 30/60 days before expire notif to the receiver
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.email = u.email

            WHERE s.page = 2
            AND s.is_deleted = 0

            GROUP BY u.ID

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        u1.ID AS u_ID,
                        u1.first_name AS u_first_name,
                        u1.last_name AS u_last_name,
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u1
                        ON s1.user_id = u1.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.email = $to
                        
                        UNION ALL
                        
                        SELECT
                        u2.ID AS u_ID,
                        u2.first_name AS u_first_name,
                        u2.last_name AS u_last_name,
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR STR_TO_DATE(file_due, '%m/%d/%Y') = DATE_SUB(CURDATE(),INTERVAL 60 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 30 DAY) OR DATE(file_due) = DATE_SUB(CURDATE(),INTERVAL 60 DAY))
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u2
                        ON s2.user_id = u2.ID

                        WHERE s2.page = $s_page
                        AND s2.is_deleted = 0 
                        AND s2.email = $to
                    )
                    SELECT 
                    u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = '30/60 Days Before Expiration: Customer Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["u_first_name"].' '.$rowSupplier["u_last_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }

        // Send expired notif to the receiver
        $selectUser = mysqli_query( $conn,"SELECT
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            s.page AS s_page

            FROM tbl_supplier AS s

            INNER JOIN (
                SELECT
                *
                FROM tbl_user
                WHERE employee_id = 0
                AND is_verified = 1
                AND is_active = 1
            ) AS u
            ON s.email = u.email

            WHERE s.page = 2
            AND s.is_deleted = 0

            GROUP BY u.ID

            ORDER BY s.user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
                $to = $rowUser["u_email"];
                $u_ID = $rowUser["u_ID"];
                $s_page = $rowUser["s_page"];

                $s_ID_arr = array();
                $s_ID_last = '';
                $selectSupplier = mysqli_query( $conn,"WITH RECURSIVE cte (u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due) AS
                    (
                        SELECT
                        u1.ID AS u_ID,
                        u1.first_name AS u_first_name,
                        u1.last_name AS u_last_name,
                        s1.ID AS s_ID,
                        s1.name AS s_name,
                        s1.status AS s_status,
                        s1.document AS s_document,
                        d1.ID AS d_ID,
                        d1.type AS d_type,
                        r.name AS d_name,
                        d1.file AS d_file,
                        d1.file_due AS d_file_due

                        FROM tbl_supplier AS s1

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 0
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d1
                        ON s1.ID = d1.supplier_ID
                        AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0
                        
                        LEFT JOIN (
                            SELECT *
                            FROM tbl_supplier_requirement
                        ) AS r
                        ON d1.name = r.ID

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u1
                        ON s1.user_id = u1.ID
                        
                        WHERE s1.page = $s_page
                        AND s1.is_deleted = 0 
                        AND s1.email = $to
                        
                        UNION ALL
                        
                        SELECT
                        u2.ID AS u_ID,
                        u2.first_name AS u_first_name,
                        u2.last_name AS u_last_name,
                        s2.ID AS s_ID,
                        s2.name AS s_name,
                        s2.status AS s_status,
                        s2.document_other AS s_document,
                        d2.ID AS d_ID,
                        d2.type AS d_type,
                        d2.name AS d_name,
                        d2.file AS d_file,
                        d2.file_due AS d_file_due

                        FROM tbl_supplier AS s2

                        INNER JOIN (
                            SELECT
                            * 
                            FROM tbl_supplier_document 
                            WHERE type = 1
                            AND LENGTH(file) > 0
                            AND (STR_TO_DATE(file_due, '%m/%d/%Y') < CURDATE() OR DATE(file_due) < CURDATE())
                            AND reviewed_by > 0
                            AND approved_by > 0
                        ) AS d2
                        ON s2.ID = d2.supplier_ID
                        AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_user
                            WHERE employee_id = 0
                            AND is_verified = 1
                            AND is_active = 1
                        ) AS u2
                        ON s2.user_id = u2.ID

                        WHERE s2.page = $s_page
                        AND s2.is_deleted = 0 
                        AND s2.email = $to
                    )
                    SELECT 
                    u_ID, u_first_name, u_last_name, s_ID, s_name, s_status, s_document, d_ID, d_type, d_name, d_file, d_file_due
                    FROM cte

                    ORDER BY s_ID");
                if ( mysqli_num_rows($selectSupplier) > 0 ) {

                    $subject = 'Expired Document: Customer Supplier Approval Program (SAP) Document';
                    $body = 'Hi '.$user.',<br><br>

                    Gentle reminder to update your document before they expired

                    <ol>';

                    while($rowSupplier = mysqli_fetch_array($selectSupplier)) {
                        $s_ID = $rowSupplier["s_ID"];
                        $s_name = $rowSupplier["u_first_name"].' '.$rowSupplier["u_last_name"];

                        // Opening
                        if (empty($s_ID_last)) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                $body .= '<li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                        // Succeeding
                        if ($s_ID_last != $s_ID) {
                            if (!in_array($s_ID, $s_ID_arr)) {
                                array_push($s_ID_arr, $s_ID);
                                $s_ID_last = $s_ID;

                                    $body .= '</ul>
                                </li>
                                <li><b>'.$s_name.'</b>
                                    <ul>';
                            }
                        }

                                        $body .= '<li>'.$rowSupplier["d_name"].'</li>';
                    }

                                    $body .= '</ul>
                                </li>
                    <ol><br><br>

                    Thanks<br><br>';

                    if ($rowUser['u_client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }
                        
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                }
            }
        }
        
        
        // SIDEBAR SETTING
        $selectData = mysqli_query( $conn,"
            SELECT 
            m.ID AS m_ID,
            m.name AS m_name,
            m.description AS m_description,
            s.ID AS s_ID,
            s.type AS s_type,
            s.date_start AS s_date_start,
            s.date_end AS s_date_end,
            s.user_id AS s_user_id,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name
            FROM tbl_menu_subscription s

            RIGHT JOIN (
                SELECT
                ID,
                name,
                description
                FROM tbl_menu
                WHERE deleted = 0
            ) AS m
            ON s.menu_id = m.ID

            RIGHT JOIN (
                SELECT
                ID,
                first_name,
                last_name
                FROM tbl_user
                WHERE employee_id = 0
            ) AS u
            ON s.user_id = u.ID

            WHERE s.deleted  = 0

            ORDER BY m.description, u.first_name
        " );
        if ( mysqli_num_rows($selectData) > 0 ) {
            $sub_array = array();
            $sub_ID_last = '';
            $sub_count = 0;

            $sub_body = '<ol>';
            while($rowData = mysqli_fetch_array($selectData)) {
                $sub_ID = $rowData["m_ID"];
                $sub_description = $rowData["m_description"];
                $sub_first_name = $rowData["u_first_name"];
                $sub_last_name = $rowData["u_last_name"];

                $sub_date_start = $rowData["s_date_start"];
                $sub_date_start = new DateTime($sub_date_start);
                $sub_date_start_o = $sub_date_start->format('Y/m/d');
                $sub_date_start = $sub_date_start->format('M d, Y');

                $sub_date_end = $rowData["s_date_end"];
                $sub_date_end = new DateTime($sub_date_end);
                $sub_date_end_o = $sub_date_end->format('Y/m/d');
                $sub_date_end = $sub_date_end->format('M d, Y');

                if ($sub_date_start_o < $current_dateNow_o && date('Y/m/d', strtotime($sub_date_end_o . ' - 3 days')) < $current_dateNow_o && $sub_date_end_o >= $current_dateNow_o) {
                    $sub_count++;

                    // Opening
                    if (empty($sub_ID_last)) {
                        if (!in_array($sub_ID, $sub_array)) {
                            array_push($sub_array, $sub_ID);
                            $sub_ID_last = $sub_ID;

                            $sub_body .= '<li><b>'.$sub_description.'</b>
                                <ul>';
                        }
                    }

                    // Succeeding
                    if ($sub_ID_last != $sub_ID) {
                        if (!in_array($sub_ID, $sub_array)) {
                            array_push($sub_array, $sub_ID);
                            $sub_ID_last = $sub_ID;

                                $sub_body .='</ul>
                            </li>
                            <li><b>'.$sub_description.'</b>
                                <ul>';
                        }
                    }

                    $sub_body .= '<li>'.$sub_first_name.' '.$sub_last_name.'</li>';

                }
            }
            $sub_body .= '</ul></li></ol>';

            if ($sub_count > 0) {
                $sender_name = 'Interlink IQ';
                $sender_email = 'services@interlinkiq.com';
                $sender[$sender_email] = $sender_name;

                $recipients_name = 'Customer Success';
                $recipients_email = 'csuccess@consultareinc.com';
                $recipients[$recipients_email] = $recipients_name;

                $subject = 'Sidebar Menu - Expired - '.$current_dateNow;
                $body = 'Good day,<br><br>

                Kindly see nearly expire subscription below:<br><br>

                '.$sub_body.'

                InterlinkIQ.com Team<br>
                Consultare Inc. Group';

                php_mailer_dynamic($sender, $recipients, $subject, $body);
            }
        }
    }
    
    // closeDBConnection();
    
    
    
    
    // =====================================================================
    // =====================================================================
    
    
    
    // DAILY NOTIFICATION
    if ($current_minute == 0 AND $current_hour == 0) {
        $selectUser = mysqli_query( $conn,"
            SELECT 
            u.ID AS u_ID,
            u.first_name AS u_first_name,
            u.last_name AS u_last_name,
            u.email AS u_email,
            u.client AS u_client,
            c.url AS c_url
            FROM tbl_user AS u
            
            LEFT JOIN (
                SELECT
                *
                FROM tbl_user_client
            ) AS c
            ON u.client = c.ID
            
            WHERE u.is_verified = 1 
            AND u.is_active = 1
            AND u.password_status = 0
            AND  (
                (u.date_registered < CURDATE() - INTERVAL 3 MONTH AND u.password_update IS NULL)
                OR
                (u.password_update < CURDATE() - INTERVAL 3 MONTH)
            )
        " );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            
            $sender_name = 'Interlink IQ';
            $sender_email = 'services@interlinkiq.com';
            $sender[$sender_email] = $sender_name;
            
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user_ID = $rowUser["u_ID"];
                
                $client_url = 'login';
                if ($rowUser['u_client'] > 0) {
                    $client_url = $rowUser['c_url'];
                }
                
                mysqli_query( $conn,"UPDATE tbl_user SET password_status = 1 WHERE ID = $user_ID" );
                
                $recipients_name = $rowUser["u_first_name"] .' '. $rowUser["u_last_name"];
                $recipients_email = $rowUser["u_email"];
                $recipients[$recipients_email] = $recipients_name;
                
                $subject = 'Password Expired!';
                $body = 'Hi '.$recipients_name.',<br><br>

                Your account has been locked due to password expired!<br>

                To retrieve your account, kindly click the button below and update your password.<br><br>

                <a href="'.$base_url.$client_url.'?p=1&i='.$user_ID.'" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">Update Password</a><br><br>
                
                
                Thanks';

                php_mailer_dynamic($sender, $recipients, $subject, $body);
            }
        }
    }
    
    
    
    
    // =====================================================================
    // =====================================================================
    
    
    
    
?>
