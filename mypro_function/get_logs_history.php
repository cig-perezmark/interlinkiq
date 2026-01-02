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
    $userId        = isset($_COOKIE['ID']) ? (int) $_COOKIE['ID'] : 0;

    if ($referenceId <= 0) {
        echo json_encode(["success" => false, "error" => "Invalid reference ID"]);
        exit;
    }

    /**
     * Function to decode a prefixed ID and retrieve the item name from the appropriate table
     * @param object $conn - Database connection
     * @param string $prefixedId - ID with prefix (e.g., 's123', 'h456', 'i789')
     * @return array - Contains 'id', 'table', 'item_name', and 'prefix'
     */
    function decodeAndFetchItemName($conn, $prefixedId) {
        // Extract prefix and numeric ID
        $prefix = substr($prefixedId, 0, 1);
        $numericId = (int) substr($prefixedId, 1);
        
        $itemName = null;
        $tableName = null;
        $matchColumn = null;
        $nameColumn = null;
        
        // Determine table, match column, and name column based on prefix
        switch ($prefix) {
            case 's':
                $tableName = 'tbl_MyProject_Services';
                $matchColumn = 'MyPro_id';
                $nameColumn = 'Project_Name';
                break;
            case 'h':
                $tableName = 'tbl_MyProject_Services_History';
                $matchColumn = 'History_id';
                $nameColumn = 'filename';
                break;
            case 'i':
                $tableName = 'tbl_MyProject_Services_Childs_action_Items';
                $matchColumn = 'CAI_id';
                $nameColumn = 'CAI_filename';
                break;
            default:
                // Unknown prefix
                return [
                    'id' => $numericId,
                    'prefix' => $prefix,
                    'table' => 'Unknown',
                    'item_name' => 'Unknown Item',
                    'error' => 'Unknown prefix'
                ];
        }
        
        // Query the appropriate table to get the item name
        $sql = "SELECT $nameColumn FROM $tableName WHERE $matchColumn = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param('i', $numericId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $itemName = $row[$nameColumn] ?? 'N/A';
            } else {
                $itemName = 'Item not found';
            }
            
            $stmt->close();
        } else {
            error_log("SQL Prepare Error for ID $prefixedId: " . $conn->error);
            $itemName = 'Error fetching item';
        }
        
        return [
            'id' => $numericId,
            'prefix' => $prefix,
            'table' => $tableName,
            'item_name' => $itemName,
            'original_prefixed_id' => $prefixedId
        ];
    }

    // Fetch history logs from tbl_mypro_history_logs
    $sql = "SELECT * FROM tbl_mypro_history_logs WHERE mypro_id = ? ORDER BY deleted_at DESC";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "Failed to prepare query: " . $conn->error]);
        exit;
    }
    
    $stmt->bind_param('i', $referenceId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $historyLogs = [];
    
    while ($row = $result->fetch_assoc()) {
        $deletedItemsDetails = [];
        
        // Parse the deleted_ids column
        if (!empty($row['deleted_ids'])) {
            $deletedIdsArray = explode(',', $row['deleted_ids']);
            
            // Loop through each prefixed ID
            foreach ($deletedIdsArray as $prefixedId) {
                $prefixedId = trim($prefixedId);
                if (!empty($prefixedId)) {
                    // Decode and fetch item details
                    $itemDetails = decodeAndFetchItemName($conn, $prefixedId);
                    $deletedItemsDetails[] = $itemDetails;
                }
            }
        }
        
        // Build enriched log entry
        $historyLogs[] = [
            'log_id' => $row['id'] ?? null,
            'mypro_id' => $row['mypro_id'] ?? null,
            'deleted_by' => $row['deleted_by'] ?? 'Unknown',
            'user_id' => $row['user_id'] ?? null,
            'reasons' => $row['reasons'] ?? '',
            'logs' => $row['logs'] ?? '',
            'deleted_ids_raw' => $row['deleted_ids'] ?? '',
            'deleted_items_details' => $deletedItemsDetails,
            'total_deleted_items' => count($deletedItemsDetails),
            'deleted_at' => $row['deleted_at'] ?? null
        ];
    }
    
    $stmt->close();
    
    // Return enriched history logs
    echo json_encode([
        "success" => true,
        "reference_id" => $referenceId,
        "total_logs" => count($historyLogs),
        "history_logs" => $historyLogs
    ]);
    exit;
