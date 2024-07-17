<?php 

include_once __DIR__ .  '/../../alt-setup/setup.php';

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
        'date' => $past30days,
    ]);
}