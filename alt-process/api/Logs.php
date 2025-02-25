<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require '../../database.php';
    
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
            
            case 'generate_client_logs':
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=service_logs.csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                
                $account = sanitizeInput($_POST['account'], $conn);
                $start = sanitizeInput($_POST['from'], $conn);
                $end = sanitizeInput($_POST['to'], $conn);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $stmt = $conn->prepare("SELECT description, action, comment, account, task_date, `minute` 
                                        FROM tbl_service_logs 
                                        WHERE account LIKE ? AND task_date BETWEEN ? AND ? 
                                        ORDER BY task_date ASC");
                
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                
                // Add % wildcards for LIKE condition
                $account_param = "%$account%";
                $stmt->bind_param('sss', $account_param, $start, $end);
                
                if (!$stmt->execute()) {
                    die("Error executing statement: " . $stmt->error);
                }
                
                $result = $stmt->get_result();
                
                $output = fopen("php://output", "w");
                
                fputcsv($output, ["Description", "Action", "Comment", "Account", "Task Date", "Minutes"]);
                
                while ($row = $result->fetch_assoc()) {
                    fputcsv($output, $row);
                }
                
                fclose($output);
                $stmt->close();
                $conn->close();
                break;
                
            case 'generate_va_logs':
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=service_logs.csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                
                $employee = sanitizeInput($_POST['employee'], $conn);
                $start = sanitizeInput($_POST['from'], $conn);
                $end = sanitizeInput($_POST['to'], $conn);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $stmt = $conn->prepare("SELECT description, action, comment, account, task_date, `minute` 
                                        FROM tbl_service_logs 
                                        WHERE user_id = ? AND task_date BETWEEN ? AND ? 
                                        ORDER BY task_date ASC");
                
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                
                $stmt->bind_param('iss', $employee, $start, $end);
                
                if (!$stmt->execute()) {
                    die("Error executing statement: " . $stmt->error);
                }
                
                $result = $stmt->get_result();
                
                $output = fopen("php://output", "w");
                
                fputcsv($output, ["Description", "Action", "Comment", "Account", "Task Date", "Minutes"]);
                
                while ($row = $result->fetch_assoc()) {
                    fputcsv($output, $row);
                }
                
                fclose($output);
                $stmt->close();
                $conn->close();
                break;
                
            default:
                echo json_encode(["success" => false, "message" => "Invalid action."]);
            break;
        }
    }