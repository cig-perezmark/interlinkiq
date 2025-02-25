<?php 

    include_once 'database_iiq.php';

    $user_id = $_POST["current_user_id"];
    $current_userfullname = $_POST["fullname_user"];
    $user_action = $_POST["user_action"];
    $timeref = $_POST['reset_timeref'];
    $notes = ($_POST["user_action"] == 'IN') ? $_POST['notes'] : 'time out';

    date_default_timezone_set('America/Chicago');

    $currentDateTimeCST = date('Y-m-d H:i:s');
    echo $currentDate = date('Y-m-d');

    $checkSql = "SELECT MAX(batch) AS max_batch FROM `tbl_timein` WHERE `user_id` = $user_id AND DATE(`time_in_datetime`) = '$currentDate'";
    $result = mysqli_query($conn, $checkSql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($user_action == 'OUT') {
            $innerSql = "SELECT `batch` FROM `tbl_timein` WHERE `user_id` = $user_id AND `action` = 'IN' AND DATE(`time_in_datetime`) = '$currentDate' ORDER BY `time_in_datetime` DESC LIMIT 1";
            $innerResult = mysqli_query($conn, $innerSql);
            
            if ($innerResult && mysqli_num_rows($innerResult) > 0) {
                $innerRow = mysqli_fetch_assoc($innerResult);
                $batch = $innerRow['batch'];
            } else {
                $batch = 1;
            }
        } else {
            $batch = $row['max_batch'] ? $row['max_batch'] + 1 : 1;
        }
    } else {
        $batch = 1;
    }

    $sql = "INSERT INTO `tbl_timein`(`user_id`, `time_in_datetime`, `user_name`, `action`, `notes`, `recorded_time`, `reset_time`, `batch`) 
            VALUES ($user_id, '$currentDateTimeCST', '$current_userfullname', '$user_action', '$notes', '$currentDateTimeCST', $timeref, $batch)";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }

    mysqli_close($conn);

?>
