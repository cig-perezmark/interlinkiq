<?php
    include_once 'database_iiq.php';
    $base_url = "https://interlinkiq.com/";
    $local_date = date('Y-m-d');


    // PHP MAILER FUNCTION
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    function php_mailer_dynamic($sender, $recipients, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'zN?=?J+CzI0P';
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

    $sender = array();
    $sender_name = 'Interlink IQ';
    $sender_email = 'services@interlinkiq.com';
    $sender[$sender_email] = $sender_name;

    // DAILY NOTIFICATION
    // Every 12MN   
    // if ($current_minute == 0 AND $current_hour == 0) {
        
        $selectUser = mysqli_query( $conn,"
        	SELECT 
			u.first_name AS u_first_name,
			u.last_name AS u_last_name,
			u.email AS u_email,
			s.user_id AS s_user_id,
			s.page AS s_page

			FROM tbl_supplier AS s

			LEFT JOIN (
			    SELECT
			    ID,
			    first_name,
			    last_name,
			    email
			    FROM tbl_user
			) AS u
			ON s.user_id = u.ID

			WHERE s.is_deleted = 0
			AND s.document IS NOT NULL
			AND s.document != ''
			AND s.user_id = 250

			GROUP BY s.page , s.user_id
			ORDER BY u.first_name, s.page
        " );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $recipients = '';
                $recipients = array();
                $recipients_name = htmlentities($rowUser["u_first_name"] ?? '') .' '. htmlentities($rowUser["u_last_name"] ?? '');
                $recipients_email = $rowUser["u_email"];
                // $recipients_email = 'greeggimongala+'.$rowUser["s_user_id"].'@gmail.com';
                $recipients[$recipients_email] = $recipients_name;
            
                $s_page = $rowUser["s_page"];
                $s_user_id = $rowUser["s_user_id"];
                $s_ID_arr = '';
                $s_ID_arr = array();
                $s_ID_last = '';
                
                $subject = 'Expired and 30days before Expiration of Document: Supplier Approval Program (SAP) - '.date('Y-m-d');
                $selectSupplierCustomer = mysqli_query( $conn,"
		        	SELECT
					*
					FROM (
					    SELECT
					    s.ID AS s_ID,
					    s.name AS s_name,
					    r.name COLLATE utf8mb4_general_ci AS r_name,
					    d.ID AS d_ID,
					    d.file AS d_file,
					    d.file_due AS d_file_due,
					    DATE_FORMAT(STR_TO_DATE(d.file_due, '%m/%d/%Y'), '%Y-%m-%d') AS d_d

					    FROM tbl_supplier AS s

					    RIGHT JOIN (
					        SELECT
					        * 
					        FROM tbl_supplier_document 
					        WHERE type = 0
					        AND file IS NOT NULL
					        AND file != ''
					        AND ID IN (
					            SELECT
					            MAX(ID)
					            FROM tbl_supplier_document
					            WHERE type = 0
					            AND file IS NOT NULL
					            AND file != ''
					            AND (
					                DATE_FORMAT(STR_TO_DATE(file_due, '%m/%d/%Y'), '%Y-%m-%d') = CURDATE() OR 
					                DATE_FORMAT(STR_TO_DATE(file_due, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN CURDATE() AND DATE_SUB(CURDATE(),INTERVAL 30 DAY)
					            )
					            GROUP BY name, supplier_id
					        )
					    ) AS d
					    ON s.ID = d.supplier_ID
					    AND FIND_IN_SET(d.name, REPLACE(REPLACE(s.document, ' ', ''), '|',','  )  ) > 0

					    LEFT JOIN (
					        SELECT
					        ID,
					        name
					        FROM tbl_supplier_requirement
					    ) AS r
					    ON d.name = r.ID

					    WHERE s.is_deleted = 0
					    AND s.document IS NOT NULL
					    AND s.document != ''
					    AND s.page = $s_page
					    AND s.user_id = $s_user_id

					    UNION ALL

					    SELECT
					    s.ID AS s_ID,
					    s.name AS s_name,
					    d.name AS r_name,
					    d.ID AS d_ID,
					    d.file AS d_file,
					    d.file_due AS d_file_due,
					    DATE_FORMAT(STR_TO_DATE(d.file_due, '%m/%d/%Y'), '%Y-%m-%d') AS d_d

					    FROM tbl_supplier AS s

					    RIGHT JOIN (
					        SELECT
					        * 
					        FROM tbl_supplier_document 
					        WHERE type = 1
					        AND file IS NOT NULL
					        AND file != ''
					        AND ID IN (
					            SELECT
					            MAX(ID)
					            FROM tbl_supplier_document
					            WHERE type = 1
					            AND file IS NOT NULL
					            AND file != ''
					            AND (
					                DATE_FORMAT(STR_TO_DATE(file_due, '%m/%d/%Y'), '%Y-%m-%d') = CURDATE() OR 
					                DATE_FORMAT(STR_TO_DATE(file_due, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN CURDATE() AND DATE_SUB(CURDATE(),INTERVAL 30 DAY)
					            )
					            GROUP BY name, supplier_id
					        )
					    ) AS d
					    ON s.ID = d.supplier_ID
					    AND FIND_IN_SET(REPLACE(d.name, ', ', ' / '), REPLACE(REPLACE(s.document_other, ', ', ' / '), ' | ',','  )  ) > 0

					    WHERE s.is_deleted = 0
					    AND s.document IS NOT NULL
					    AND s.page = $s_page
					    AND s.user_id = $s_user_id
					) r
					ORDER BY r.s_name
		        " );
		        if ( mysqli_num_rows($selectSupplierCustomer) > 0 ) {

		        	$body = 'Hi '.$recipients_name.',<br><br>

		            The see the following document(s):

		            <ol>';
			            while($rowSupplierCustomer = mysqli_fetch_array($selectSupplierCustomer)) {
			                $s_ID = $rowSupplierCustomer["s_ID"];
			                $s_name = $rowSupplierCustomer["s_name"];
			                $d_name = $rowSupplierCustomer["r_name"];
			                $d_file_due = $rowSupplierCustomer["d_file_due"];

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

			                                $body .= '<li>'.$d_name.' - <i>'.$d_file_due.'</i></li>';
			            }

		                            $body .= '</ul>
		                        </li>
		            <ol><br><br>

		            Thanks<br>
