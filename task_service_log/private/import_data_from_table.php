<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["service_account"])) {
    include "connection.php";
    
    // $connect = new PDO("mysql:host=localhost;dbname=interlink_service_logs", "root", "");
    $_desc = $_POST["service_description"];
    $_action = $_POST["service_action"];
    $_comment = $_POST["service_comment"];
    $_account = $_POST["service_account"];
    $_task_date = $_POST["service_date"];
    $_time = $_POST["service_time"];

    $sql = "INSERT INTO tbl_service_logs(`user_id`, `description`, `action`, `comment`, `account`, `task_date`, `minute`) VALUES(?,?,?,?,?,?,?)";
    $logs = array();
    
    for($count = 0; $count < count($_account); $count++) {
        $stmt = $con->prepare($sql);
        $stmt->bind_param('isssssd', 
            $_COOKIE['ID'],
            $_desc[$count],
            $_action[$count],
            $_comment[$count],
            $_account[$count],
            $_task_date[$count],
            $_time[$count]
        );

        if($stmt->execute()) {
            $log = $con->query("SELECT * FROM tbl_service_logs WHERE task_id = {$con->insert_id}");
            $logs[] = $log->fetch_assoc();
        }

        $con->next_result();
    }

    echo json_encode($logs);
    $con->close();
}

function e($str) {
    global $con;
    return htmlspecialchars(mysqli_real_escape_string($con, $str));
}