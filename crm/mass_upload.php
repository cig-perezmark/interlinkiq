<?php 
    require '../database.php';
    
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
    
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    } else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    }
    
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['upload_multiple_contacts'])) {
        $file = $_FILES["csvfile"]["tmp_name"];
        $skippedRows = [];
        $successfulRows = [];
    
        if (($handle = fopen($file, "r")) !== false) {
            $stmt = $conn->prepare("INSERT INTO tbl_Customer_Relationship (account_rep, account_name, account_email, account_phone, Account_Source, userID, enterprise_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
            if (!$stmt) {
                die("Error in preparing the statement: " . $conn->error);
            }
    
            $stmt->bind_param("sssssii", $account_rep, $account_name, $account_email, $account_phone, $account_source, $binded_employee_id, $binded_employeer_id);
            $successfullyInsertedCount = 0;
            $skippedExistingEmailCount = 0;
        fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $account_rep            = 'InterlinkIQ';
                $account_name           = cleanInput($data[0]);
                $account_email          = cleanInput($data[1]);
                $account_phone          = cleanInput($data[2]);
                $account_source         = cleanInput($data[3]);
                $binded_employee_id     = $_COOKIE['ID']; // integer 
                $binded_employeer_id    = $user_id; // integer
    
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM tbl_Customer_Relationship WHERE account_email = ? AND enterprise_id = ?");
                if (!$checkStmt) {
                    die("Error in preparing the statement: " . $conn->error);
                }
    
                $checkStmt->bind_param("si", $account_email, $binded_employeer_id);
                $checkStmt->execute();
                $checkStmt->bind_result($emailCount);
                $checkStmt->fetch();
                $checkStmt->close();
    
                if ($emailCount == 0) {
                    if ($stmt->execute()) {
                        $successfulRows[] = $data;
                        $successfullyInsertedCount++;
                    } else {
                        die("Error in executing the statement: " . $stmt->error);
                    }
                } else {
                    $skippedRows[] = $data;
                    $skippedExistingEmailCount++;
                }
            }
    
            $stmt->close();
            fclose($handle);
    
            $success_data = '';
            foreach ($successfulRows as $success) {
                $success_data .= '
                    <tr>
                        <td></td>
                        <td>' . $success[0] . '</td>
                        <td>' . $success[1] . '</td>
                        <td>' . $success[2] . '</td>
                        <td>' . $success[3] . '</td>
                    </tr>';
            }
    
            // Create HTML for skipped rows
            $skipped_data = '';
            foreach ($skippedRows as $skipped) {
                $skipped_data .= '
                    <tr>
                        <td></td>
                        <td>' . $skipped[0] . '</td>
                        <td>' . $skipped[1] . '</td>
                        <td>' . $skipped[2] . '</td>
                        <td>' . $skipped[3] . '</td>
                    </tr>';
            }
    
            if ($skippedExistingEmailCount > 0) {
                echo $response = 'error|Some entries failed to save to the record because the entries exist in the record or have issues with special characters|' . $success_data . '|' . $skipped_data;
            } else {
                echo $response = 'success|All contact entries added successfully|' . $success_data . '|' . $skipped_data;
            }
        } else {
            echo json_encode(['error' => 'Error opening the CSV file']);
        }
    }



