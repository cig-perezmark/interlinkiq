<?php 

include_once 'database.php';
$rowid = $_POST["row_id"];



$sql2 = "UPDATE tbl_service_logs_draft SET status = 'deleted' WHERE task_id = '".$rowid."'";  
mysqli_query($conn, $sql2);

//   $actions = $conn->query("SELECT * FROM tbl_service_logs_draft where task_id = $rowid");
//                                         if(mysqli_num_rows($actions) > 0) {
//                                             while($row = $actions->fetch_assoc()) {
//                                                 $user_id = $row["user_id"];
//                                                 $description = $row["description"];
//                                                 $action = $row["action"];
//                                                 $comment = $row["comment"];
//                                                 $account = $row["account"];
//                                                 $task_date = $row["task_date"];
//                                                 $minute = $row["minute"];
                                                
//                                             }
                                            
// $user_id_send        = $user_id;
// $description_send    = htmlspecialchars($description);
// $action_send         = $action;
// $account_send        = $account;
// $task_date_send      = $task_date;
// $minute_send         = $minute;
// $comment_send        = htmlspecialchars($comment);

// $stmt = $conn->prepare("INSERT INTO tbl_service_logs(user_id, description, action, comment, account, task_date, minute) 
//                 VALUES (?,?,?,?,?,?,?)");
// $stmt->bind_param('isssssd', $user_id_send, $description_send, $action_send, $comment_send, $account_send, $task_date_send, $minute_send);
// $stmt->execute();
                                        // }
?>
