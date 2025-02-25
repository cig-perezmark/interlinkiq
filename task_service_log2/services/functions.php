<?php 

function getTotalMinutesForDate($date = null) {
    global $conn, $portal_user;
    $currentDate = $date ?? date('Y-m-d');

    /**
     * @disregard P1009 Undefined type
     */
    $total = $conn->execute( 
        "   SELECT SUM(MINUTE) AS total 
            FROM tbl_service_logs 
            WHERE user_id = ? 
                AND task_date = ?
            GROUP BY task_date
        ", $portal_user, $currentDate
    )->fetchAssoc()['total'] ?? 0;  
    
    return floatval($total);
}
