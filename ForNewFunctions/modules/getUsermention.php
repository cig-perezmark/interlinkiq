<?php
include('database.php');

$user_data = array();
$users = $conn->query("SELECT * FROM tbl_hr_employee");

foreach ($users as $key => $val) {
    $user_data[$key]['user_id'] = $val['user_id'];
    $user_data[$key]['name'] = $val['first_name'] . ' ' . $val['last_name'];
}

header('Content-Type: application/json');
echo json_encode($user_data);

?>
