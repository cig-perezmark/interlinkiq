<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require('database_iiq.php');
    // Auto update the campaign if the contact status = Manual and flag = 0
    $flag1 = 0;
    $status1 = 'Manual';
    $campaignStatus = 2;
    $autoSendStatus = 1;
    $crm_id = 11128;
    
    $stmt = $conn->prepare("SELECT crm_id, account_name, account_email, account_status, flag, crm_id FROM tbl_Customer_Relationship WHERE flag = ? OR account_status = ?");
    if (!$stmt) {
        die("Error in the first prepared statement: " . $conn->error);
    }
    
    $stmt->bind_param("is", $flag1, $status1);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stmt2 = $conn->prepare("SELECT crm_ids, Campaign_from, Campaign_Recipients, Campaign_Subject, Campaign_body FROM tbl_Customer_Relationship_Campaign WHERE Campaign_Status = ? AND Auto_Send_Status = ?");
    if (!$stmt2) {
        die("Error in the second prepared statement: " . $conn->error);
    }
    
    $stmt2->bind_param("iii", $campaignStatus, $autoSendStatus, $crm_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $crmIdToMatch = $row['crm_id'];
        $matchingRow = null;
    
        while ($row2 = $result2->fetch_assoc()) {
            if ($row2['crm_ids'] == $crmIdToMatch) {
                $matchingRow = $row2;
                break;
            }
        }
    
        if ($matchingRow !== null) {
            $updateStmt = $conn->prepare("UPDATE tbl_Customer_Relationship_Campaign SET Auto_Send_Status = 0 WHERE crm_ids = ?");
            if (!$updateStmt) {
                die("Error in the update prepared statement: " . $conn->error);
            }
    
            $updateStmt->bind_param("s", $crmIdToMatch);  // Assuming crm_ids is a string, adjust accordingly
            $updateStmt->execute();
            $updateStmt->close();
        }
    
        // Reset the second result set pointer to the beginning for the next iteration
        $result2->data_seek(0);
    }
    
?>
