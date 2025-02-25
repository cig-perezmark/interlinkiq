<?php

if(!isset($_COOKIE['ID']) || !isset($_POST['keyword'])) {
    die("Invalid action.");
}

// die($_POST['actions']);

include "connection.php";

$filterClauses = "";
$params = array();

$_POST['keyword'] = mysqli_real_escape_string($con, $_POST['keyword']);

$filterClauses .= "(`task_id` LIKE ? OR `description` LIKE ? OR `action` LIKE ? OR `comment` LIKE ? OR `account` LIKE ?)";
array_push($params, ...array_fill(0, 5, "%{$_POST['keyword']}%"));

if(isset($_POST['accounts'])) {
    $filterClauses .= " AND (". implode(" OR ", array_fill(0, count($_POST['accounts']), " `account` = ? ")) . ")";
    array_push($params, ...$_POST['accounts']);
}

if(isset($_POST['actions'])) {
    $filterClauses .= " AND (". implode(" OR ", array_fill(0, count($_POST['actions']), " `action` = ? ")) . ")";
    array_push($params, ...$_POST['actions']);
}

$s_d = $_POST['startDate'];
$e_d = $_POST['endDate'];

if(!empty($s_d) && !empty($e_d)) {
    $filterClauses .= " AND ( `task_date` >= ? AND `task_date` <= ? )";
    array_push($params, $s_d, $e_d);
}
else if(!empty($s_d)) {
    $filterClauses .= " AND ( `task_date` >= ? )";
    $params[] = $s_d;
}
else if(!empty($e_d)) {
    $filterClauses .= " AND ( `task_date` <= ? )";
    $params[] = $e_d;
}

$data = array();
$stmt = $con->prepare("SELECT * FROM `tbl_service_logs` WHERE `user_id` = {$_COOKIE['ID']} AND $filterClauses ORDER BY `task_date` DESC");
$stmt->bind_param(str_repeat("s", count($params)), ...$params);

if($stmt->execute()) {
    $results = $stmt->get_result();
    if(mysqli_num_rows($results) > 0) {
        while($row = $results->fetch_assoc()) {
            $data[] = $row;
        }
    }
}

echo json_encode($data);

$stmt->close();
$con->close();
