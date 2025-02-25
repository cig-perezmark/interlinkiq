<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require '../database.php';
    
    // Sanitize Input Function
    function sanitizeInput($input, $conn) {
        return mysqli_real_escape_string($conn, trim($input));
    }
    
    function employerID($ID) {
    	global $conn;
    
    	$selectUser = mysqli_query( $conn,"SELECT employee_id from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];
    
        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT user_id FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }
    
        return $current_userEmployerID;
    }
    
    $employeeid = $_COOKIE['ID'];
    $user_id = !empty($_COOKIE['switchAccount']) ? $_COOKIE['switchAccount'] : employerID($employeeid);
    
    // API Endpoints Handler
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch($action) {
            // // get all data via owner and date period based on the current date
            // case 'get':
            //     $currentDate = date('Y-m-d');
            //     $year = date('Y');
            //     $month = date('m');
            //     $day = (int) date('d');
            
            //     // Define the start and end date for the range based on the current day
            //     if ($day >= 1 && $day <= 15) {
            //         // If the day is between 1 and 15, set the range to 1st to 15th
            //         $startDate = "$year-$month-01";
            //         $endDate = "$year-$month-15";
            //     } else {
            //         // If the day is between 16 and 30, set the range to 16th to the last day of the month
            //         $endDate = "$year-$month-" . cal_days_in_month(CAL_GREGORIAN, $month, $year);  // Get the last day of the month
            //         $startDate = "$year-$month-16";
            //     }
            
            //     $stmt = $conn->prepare("SELECT user_id,
            //                                       task_id,
            //                                       task_date,
            //                                       description,
            //                                       action,
            //                                       comment,
            //                                       account,
            //                                       minute
            //                             FROM tbl_service_logs
            //                             WHERE user_id = ? 
            //                             AND task_date BETWEEN ? AND ?");
            //     if ($stmt === false) {
            //         echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
            //         exit;
            //     }
            
            //     $stmt->bind_param('iss', $employeeid, $startDate, $endDate);
            
            //     if (!$stmt->execute()) {
            //         echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
            //         exit;
            //     }
            
            //     $result = $stmt->get_result();
            
            //     if ($result->num_rows > 0) {
            //         $records = [];
            //         while ($row = $result->fetch_assoc()) {
            //             $records[] = $row;
            //         }
            
            //         echo json_encode(["success" => true, "data" => $records]);
            //     } else {
            //         echo json_encode(["success" => false, "message" => "No records found"]);
            //     }
            //     // Close the statement
            //     $stmt->close();
            //     break;
            
            case 'get':
                $last15Days = date('Y-m-d', strtotime('-15 days'));
                $currentDate = date('Y-m-d');
            
                $stmt = $conn->prepare("SELECT user_id,
                                               task_id,
                                               task_date,
                                               description,
                                               action,
                                               comment,
                                               account,
                                               minute
                                        FROM tbl_service_logs
                                        WHERE user_id = ? 
                                        AND task_date BETWEEN ? AND ?
                                        AND deleted = 0
                                        AND not_approved = 0
                                        AND minute > 0
                                        ORDER BY task_date DESC");
            
                if ($stmt === false) {
                    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                    exit;
                }
            
                $stmt->bind_param('iss', $employeeid, $last15Days, $currentDate);
            
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
                    exit;
                }
            
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    $records = [];
                    while ($row = $result->fetch_assoc()) {
                        $records[] = $row;
                    }
            
                    echo json_encode(["success" => true, "data" => $records]);
                } else {
                    echo json_encode(["success" => false, "message" => "No records found"]);
                }
            
                // Close the statement
                $stmt->close();
                break;
                
            case 'loadActionLogs':
                $stmt = $conn->prepare("SELECT name FROM tbl_service_logs_actions WHERE deleted = 0 ORDER BY name ASC");
            
                if ($stmt === false) {
                    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                    exit;
                }
            
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
                    exit;
                }
            
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    $records = [];
                    while ($row = $result->fetch_assoc()) {
                        $records[] = $row;
                    }
                    echo json_encode(["success" => true, "data" => $records]);
                } else {
                    echo json_encode(["success" => false, "message" => "No records found"]);
                }
            
                $stmt->close();
                break;

            // Fetch record via id
            case 'fetch':
                $id = sanitizeInput($_POST['taskid'], $conn);
            
                if (empty($id)) {
                    echo json_encode(["success" => false, "message" => "Task ID is required."]);
                    exit;
                }
            
                $stmt = $conn->prepare("SELECT task_id, 
                                               task_date,
                                               description,
                                               action,
                                               comment,
                                               account,
                                               minute
                                        FROM tbl_service_logs
                                        WHERE task_id = ?");
                if ($stmt === false) {
                    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                    exit;
                }
            
                $stmt->bind_param('i', $id);
            
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
                    exit;
                }
            
                $stmt->bind_result($task_id, $task_date, $description, $action, $comment, $account, $minute);
            
                if ($stmt->fetch()) {
                    // Fix new lines for JSON encoding
                    $description = str_replace(["\r\n", "\r", "\n"], ' ', $description);
                    
                    $data = [
                        'task_id' => $task_id,
                        'task_date' => $task_date,
                        'description' => $description,
                        'action' => $action,
                        'comment' => $comment,
                        'account' => $account,
                        'minute' => $minute,
                    ];
                    echo json_encode(["success" => true, "data" => $data]);
                } else {
                    echo json_encode(["success" => false, "message" => "No record found for the given Task ID."]);
                }
            
                $stmt->close();
                break;
                
            case 'update':
                $id = sanitizeInput($_POST['sl_taskid'], $conn);
                $description = sanitizeInput($_POST['sl_description'], $conn);
                $action = sanitizeInput($_POST['sl_action'], $conn);
                $comment = sanitizeInput($_POST['sl_comment'], $conn);
                $account = sanitizeInput($_POST['sl_account'], $conn);
                $date = sanitizeInput($_POST['sl_date'], $conn);
                $minutes = sanitizeInput($_POST['sl_minutes'], $conn);
                
                // Check if action exists in tbl_service_logs_actions
                $checkStmt = $conn->prepare("SELECT id FROM tbl_service_logs_actions WHERE name = ? AND deleted = 0");
                $checkStmt->bind_param('s', $action);
                $checkStmt->execute();
                $result = $checkStmt->get_result();
            
                if ($result->num_rows == 0) {
                    // Insert new action if not found
                    $insertStmt = $conn->prepare("INSERT INTO tbl_service_logs_actions (name) VALUES (?)");
                    $insertStmt->bind_param('s', $action);
                    if (!$insertStmt->execute()) {
                        echo json_encode(["success" => false, "message" => "Error inserting new action: " . $insertStmt->error]);
                        exit;
                    }
                    $insertStmt->close();
                }
                $checkStmt->close();
            
                $stmt = $conn->prepare("UPDATE tbl_service_logs SET 
                    description = ?, 
                    action = ?, 
                    comment = ?, 
                    account = ?, 
                    task_date = ?, 
                    minute = ? 
                    WHERE task_id = ?");
                if ($stmt === false) {
                    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                    exit;
                }
            
                $stmt->bind_param('ssssssi', $description, $action, $comment, $account, $date, $minutes, $id);
            
                if ($stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Service log has been updated successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error executing update: " . $stmt->error]);
                }
                
                $logs_action = $conn->prepare("SELECT name FROM tbl_service_logs_actions WHERE deleted = 0 ORDER BY name");
                
            
                $stmt->close();
                break;
                
            case 'delete':
                $id = sanitizeInput($_POST['id'], $conn);
            
                if (empty($id)) {
                    echo json_encode(["success" => false, "message" => "ID is required."]);
                    exit;
                }
            
                $stmt = $conn->prepare("DELETE FROM tbl_service_logs WHERE task_id = ?");
                if (!$stmt) {
                    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
                    exit;
                }
            
                $stmt->bind_param('i', $id);
            
                if ($stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Service logs have been deleted successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
                }
            
                $stmt->close();
                break;
                
            default:
                echo json_encode(["success" => false, "message" => "Invalid action."]);
            break;
        }
    }
