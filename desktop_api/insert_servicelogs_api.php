<?php
header('Content-Type: application/json');

// Set the PHP time zone to "Asia/Manila" (Philippine Time, UTC +8)
date_default_timezone_set('Asia/Manila');

// Get the current date and time in Manila
$currentDateTime = new DateTime();  // Get current time in Manila
$desktop_inserted = $currentDateTime->format('Y-m-d H:i:s');  // Format as "YYYY-MM-DD HH:MM:SS"

// Example of inserting data into the database
include "../database_iiq.php";

// Get the POST data
$data = json_decode(file_get_contents("php://input"));

if($data->action == "update_status"){
    $sql = "UPDATE tbl_service_logs SET desktop_pending = 0 WHERE user_id = 108 AND desktop_pending = 1";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}
else{
   if (isset($data->task_id) && isset($data->description) && isset($data->action) && isset($data->comment) && isset($data->account) && isset($data->task_date) && isset($data->minute)) {
        $task_id = $data->task_id;
        $user_id = '108';
        $description = $data->description;
        $action = $data->action;
        $comment = $data->comment;
        $account = $data->account;
        $task_date = $data->task_date; // Format as "YYYY-MM-DD"
        $minute = $data->minute;
    
        // Insert the data into the database
        $sql = "INSERT INTO tbl_service_logs (task_id, user_id, description, action, comment, account, task_date, minute, desktop_pending, desktop_inserted) 
                VALUES ('$task_id', '$user_id', '$description', '$action', '$comment', '$account', '$task_date', '$minute' , '1', '$desktop_inserted')";
    
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Record inserted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    } 
}


$conn->close();
?>
