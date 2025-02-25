<?php

include "connection.php";

$user_id        = $_COOKIE['ID'];
$description    = htmlspecialchars($_POST['description']);
$action         = $_POST['action'];
$account        = $_POST['account'];
$task_date      = $_POST['task_date'];
$minute         = $_POST['minute'];
$comment        = htmlspecialchars($_POST['comment']);

//filter overtime
    $total_minute =0;
    $total = 0;
    $not_approved = 3;
    $ot_query = mysqli_query($con, "select * from tbl_service_logs where user_id = '$user_id' and not_approved = 0");
    foreach($ot_query as $ot_row){
        
        $input_date = date('Y-m-d',strtotime($task_date));
        $find_date = date('Y-m-d',strtotime($ot_row['task_date']));
        
        if($input_date == $find_date){
            $total_minute += $ot_row['minute'];
        }
    }
    $total_minute;
    $overall = $total_minute + $minute;
     
     if($overall > 480){
         $stmt_ot = $con->prepare("INSERT INTO tbl_service_logs(user_id, description, action, comment, account, task_date, minute, not_approved) 
                VALUES (?,?,?,?,?,?,?,?)");
        $stmt_ot->bind_param('isssssdi', $user_id, $description, $action, $comment, $account, $task_date, $minute,$not_approved);
        
        if($stmt_ot->execute()) {
            $task_ot = $con->query("SELECT * FROM tbl_service_logs WHERE task_id = {$con->insert_id}");
            echo json_encode(["success" => "Your task has been recorded!", "task_details" => $task_ot->fetch_assoc()]);
        }
        else {
            echo json_encode(["error" => "Unable to proceed this action"]);
        }
        exit;
     }
//end filter overtime


$stmt = $con->prepare("INSERT INTO tbl_service_logs(user_id, description, action, comment, account, task_date, minute) 
                VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param('isssssd', $user_id, $description, $action, $comment, $account, $task_date, $minute);

if($stmt->execute()) {
    $task = $con->query("SELECT * FROM tbl_service_logs WHERE task_id = {$con->insert_id}");
    echo json_encode(["success" => "Your task has been recorded!", "task_details" => $task->fetch_assoc()]);
}
else {
    echo json_encode(["error" => "Unable to proceed this action"]);
}

?>
