<?php 

define('SERVICE_LOG_DIRECT_ADD', 0);
define('SERVICE_LOG_NEEDS_APPROVAL', 3);
define('FULLTIME_MINUTES', 480);

// add new service log
if(isset($_GET['add_log'])) {
    try {
        $description    = htmlspecialchars($_POST['description']);
        $action         = $_POST['action'];
        $account        = $_POST['account'];
        $task_date      = $_POST['task_date'];
        $minute         = floatval($_POST['minute']);
        $comment        = htmlspecialchars($_POST['comment']);
        $runningTotalMinutes = getTotalMinutesForDate($task_date) + $minute;
        $approveStatus = ($runningTotalMinutes) > FULLTIME_MINUTES ? SERVICE_LOG_NEEDS_APPROVAL : SERVICE_LOG_DIRECT_ADD;
        
        $conn->begin_transaction();

        $conn->execute(
            "INSERT INTO tbl_service_logs(user_id, description, action, comment, account, task_date, minute, not_approved) VALUES (?,?,?,?,?,?,?,?)",
            $portal_user,
            $description,
            $action,
            $comment,
            $account,
            $task_date,
            $minute,
            $approveStatus
        );
        $id = $conn->getInsertId();

        $name = $conn->execute("SELECT CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name FROM tbl_user WHERE ID = ?", $portal_user)->fetchAssoc()['name'] ?? '';

        $conn->commit();

        send_response([
            'data' => [
                'task_id' => $id,
                'name' => $name,
                'description' => $description,
                'action' => $action,
                'account' => $account,
                'comment' => $comment,
                'minute' => $minute,
                'task_date' => $task_date,
            ],
            'message' => 'Successfully saved.'
        ]);
    } catch(Exception $e) {
        $conn->rollback();
        send_response([ 'error' => 'Error: Unable to complete action.' ], 500);
    }
}

// get all service logs within 30-day period
if(isset($_GET['logs'])) {
    $past30days = date('Y-m-d', strtotime('-120 days'));
    // $overtime_query = mysqli_query($conn, "select * from tbl_service_logs where not_approved = 1 and minute > 0 and user_id = {$_COOKIE['ID']} 
    // AND task_date >= '$last_month' ORDER BY task_date DESC");

    $serviceLogs = $conn->execute("SELECT 
                task_id,
                description,
                action, 
                comment,
                account,
                minute,
                CONCAT(TRIM(u.first_name), ' ', TRIM(u.last_name)) AS name,
                task_date
            FROM tbl_service_logs sl
            LEFT JOIN tbl_user u ON u.ID = sl.user_id 
            WHERE CAST(task_date AS DATE) >= ? 
                AND user_id = ?
                AND deleted = 0
            ORDER BY task_date DESC
        ", 
        $past30days, $portal_user
    )->fetchAll();

    send_response([
        'data' => $serviceLogs,
    ]);
}

if(isset($_GET['va_summary'])) {
    $results = [];
    $currentDate = date("Y-m-d");
    $last30Days = date('Y-m-d', strtotime('-120 days'));

    $showAllClause = "";
    if(
        // $portal_user == 1105 || 
        $portal_user == 54 || // ms tin
        $portal_user == 387 || // ms girl
        $portal_user == 34 // hr
    ) {
        //  ...
    } else {
        // fetch summary for individual account
        $results = $conn->execute("SELECT 
                    COUNT(task_id) AS tasks,
                    SUM(minute) AS minutes,
                    task_date AS date,
                    user_id,
                    IF(not_approved = ?, 1, 0) AS overtime
                FROM tbl_service_logs 
                LEFT JOIN tbl_user on ID = user_id
                WHERE task_date >= ? 
                    AND task_date <= ? 
                    AND is_active = 1 
                    AND user_id = ?
                    AND (not_approved = ?  OR not_approved = ?)
                GROUP BY task_date, not_approved
                ORDER BY task_date DESC
            ", 
            SERVICE_LOG_NEEDS_APPROVAL, $last30Days, $currentDate, $portal_user, SERVICE_LOG_DIRECT_ADD, SERVICE_LOG_NEEDS_APPROVAL
        )->fetchAll();

        $tempData = [];
        foreach($results as $row) {
            unset($row['user_id']);
            
            if(!isset($tempData[$row['date']])) {
                $tempData[$row['date']] = [];
            }

            if($row['overtime']) {
                $tempData[$row['date']]['overtime'] = $row['minutes'];
                $tempData[$row['date']]['minutes'] += $row['minutes'];
            } else {
                $tempData[$row['date']] = array_merge($tempData[$row['date']], $row);
            }
        }

        $results = array_values($tempData);
    }
     
    send_response([
        'data' => $results
    ]);
}
