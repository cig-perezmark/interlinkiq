<?php

include "connection.php";

if(isset($_COOKIE['ID'])) {
    $last_month = date('Y-m-d', strtotime('-30 days'));

    $result = $con->query("SELECT * FROM tbl_service_logs WHERE minute > 0 and `user_id` = {$_COOKIE['ID']} 
                                AND `task_date` >= '$last_month' and not_approved = 0 ORDER BY `task_date` DESC");
    if(mysqli_num_rows($result) > 0) {
        $logs = array( 'data' => [] );
        while($row = $result->fetch_assoc()) {
            $logs['data'][] = $row;
        }

        echo json_encode($logs);
    }
    else {
        echo json_encode([ 'data' => []]);
    }

    $con->close();
}
else {
    die("non-user account access!");
}