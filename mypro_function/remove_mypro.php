<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    
    include '../database.php';
    
    header('Content-Type: application/json; charset=utf-8');
    
    if (!isset($_POST['removeItems'])) {
        echo json_encode(["success" => false, "error" => "Invalid request"]);
        exit;
    }
    
    $referenceId   = isset($_POST['itemId']) ? (int) $_POST['itemId'] : 0;
    $table         = $_POST['table'] ?? '';
    $deletedStatus = 1;
    $reason        = $_POST['reason'] ?? '';
    $userId        = isset($_COOKIE['ID']) ? (int) $_COOKIE['ID'] : 0;
    $mainId        = $_POST['mainId'] ?? '';
                
    $allowedTables = [
        "tbl_MyProject_Services",
        "tbl_MyProject_Services_History",
        "tbl_MyProject_Services_Childs_action_Items"
    ];
    
    if (!in_array($table, $allowedTables)) {
        echo json_encode(["success" => false, "error" => "Invalid table"]);
        exit;
    }
    
    $deletedIds = [];
    
    $serviceIds = [];
    $historyIds = [];
    $actionItemIds = [];
    
    function getIdsBeforeDelete($conn, $table, $column, $value)
    {
        $ids = [];
        $stmt = $conn->prepare("SELECT " . $column . " FROM " . $table . " WHERE " . $column . " = ? AND is_deleted = 0");
        if ($stmt) {
            $stmt->bind_param('i', $value);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $ids[] = $row[$column];
            }
            $stmt->close();
        }
        return $ids;
    }
    
    // Function to run prepared UPDATE statements
    function runUpdate($conn, $sql, $params)
    {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $conn->error);
            return false;
        }
    
        $types = '';
        foreach ($params as $param) {
            $types .= is_int($param) ? 'i' : 's';
        }
    
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        if (!$success) {
            error_log("SQL Execute Error: " . $stmt->error);
        }
        $stmt->close();
        return $success;
    }
    
    // Run the appropriate updates based on table and track deleted IDs
    $allSuccess = true;
    
    switch ($table) {
        case "tbl_MyProject_Services":
            // Track Service IDs
            $serviceIds = array_merge($serviceIds, getIdsBeforeDelete($conn, "tbl_MyProject_Services", "MyPro_id", $referenceId));
            
            // Track History IDs
            $stmt = $conn->prepare("SELECT History_id FROM tbl_MyProject_Services_History WHERE MyPro_PK = ? AND is_deleted = 0");
            if ($stmt) {
                $stmt->bind_param('i', $referenceId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $historyIds[] = $row['History_id'];
                }
                $stmt->close();
            }
            
            // Track Action Item IDs
            $stmt = $conn->prepare("SELECT CAI_id FROM tbl_MyProject_Services_Childs_action_Items WHERE Parent_MyPro_PK = ? AND is_deleted = 0");
            if ($stmt) {
                $stmt->bind_param('i', $referenceId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $actionItemIds[] = $row['CAI_id'];
                }
                $stmt->close();
            }
            
            // Now perform deletions
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services SET is_deleted = ? WHERE MyPro_id = ?", [$deletedStatus, $referenceId]);
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_History SET is_deleted = ? WHERE MyPro_PK = ?", [$deletedStatus, $referenceId]);
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET is_deleted = ? WHERE Parent_MyPro_PK = ?", [$deletedStatus, $referenceId]);
            break;
    
        case "tbl_MyProject_Services_History":
            // Track History IDs
            $historyIds = array_merge($historyIds, getIdsBeforeDelete($conn, "tbl_MyProject_Services_History", "History_id", $referenceId));
            
            // Track Action Item IDs
            $stmt = $conn->prepare("SELECT CAI_id FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = ? AND is_deleted = 0");
            if ($stmt) {
                $stmt->bind_param('i', $referenceId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $actionItemIds[] = $row['CAI_id'];
                }
                $stmt->close();
            }
            
            // Now perform deletions
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_History SET is_deleted = ? WHERE History_id = ?", [1, $referenceId]);
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET is_deleted = ? WHERE Services_History_PK = ?", [$deletedStatus, $referenceId]);
            break;
    
        case "tbl_MyProject_Services_Childs_action_Items":
            // Track Action Item IDs
            $actionItemIds = array_merge($actionItemIds, getIdsBeforeDelete($conn, "tbl_MyProject_Services_Childs_action_Items", "CAI_id", $referenceId));
            
            // Track Indented Child Action Item IDs
            $stmt = $conn->prepare("SELECT CAI_id FROM tbl_MyProject_Services_Childs_action_Items WHERE CIA_Indent_Id = ? AND is_deleted = 0");
            if ($stmt) {
                $stmt->bind_param('i', $referenceId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $actionItemIds[] = $row['CAI_id'];
                }
                $stmt->close();
            }
            
            // Now perform deletions
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET is_deleted = ? WHERE CAI_id = ?", [$deletedStatus, $referenceId]);
            $allSuccess &= runUpdate($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET is_deleted = ? WHERE CIA_Indent_Id = ?", [$deletedStatus, $referenceId]);
            break;
    }
    
    // Remove duplicates
    $serviceIds = array_unique($serviceIds);
    $historyIds = array_unique($historyIds);
    $actionItemIds = array_unique($actionItemIds);
    
    // Add table indicator prefixes to each ID
    // s = tbl_MyProject_Services
    // h = tbl_MyProject_Services_History
    // i = tbl_MyProject_Services_Childs_action_Items
    $prefixedIds = [];
    
    foreach ($serviceIds as $id) {
        $prefixedIds[] = 's' . $id;
    }
    
    foreach ($historyIds as $id) {
        $prefixedIds[] = 'h' . $id;
    }
    
    foreach ($actionItemIds as $id) {
        $prefixedIds[] = 'i' . $id;
    }
    
    // Create a single formatted string for all deleted IDs with prefixes
    $deletedIdsString = !empty($prefixedIds) ? implode(',', $prefixedIds) : null;
    
    
    
    // --- INSERT LOG AFTER SUCCESSFUL UPDATE ---
    if ($allSuccess && !empty($reason)) {
        // Safe handling of deletedBy
        $deletedBy = 'Unknown';
        if (isset($_COOKIE['first_name']) && isset($_COOKIE['last_name'])) {
            $deletedBy = $_COOKIE['first_name'] . ' ' . $_COOKIE['last_name'];
        } elseif ($userId > 0) {
            $deletedBy = 'User ID: ' . $userId;
        }
    
        $logs = "Deleted record ID: $referenceId from table: $table";
    
        $stmtLog = $conn->prepare("
            INSERT INTO tbl_mypro_history_logs
                (deleted_by, user_id, mypro_id, deleted_ids, reasons, logs)
            VALUES
                (?, ?, ?, ?, ?, ?)
        ");
    
        if ($stmtLog) {
            $stmtLog->bind_param("sissss", $deletedBy, $userId, $mainId, $deletedIdsString, $reason, $logs);
            if (!$stmtLog->execute()) {
                error_log("Log Insert Error: " . $stmtLog->error);
                echo json_encode([
                    "success" => false,
                    "deleted_id" => $referenceId,
                    "table" => $table,
                    "error" => "Log insert failed: " . $stmtLog->error
                ]);
                exit;
            }
            $stmtLog->close();
        } else {
            error_log("Log Prepare Error: " . $conn->error);
            echo json_encode([
                "success" => false,
                "deleted_id" => $referenceId,
                "table" => $table,
                "error" => "Log prepare failed: " . $conn->error
            ]);
            exit;
        }
    }
    
    // Return final JSON response
    echo json_encode([
        "success" => $allSuccess ? true : false,
        "deleted_id" => $referenceId,
        "table" => $table,
        "deleted_ids" => $deletedIdsString
    ]);
exit;

