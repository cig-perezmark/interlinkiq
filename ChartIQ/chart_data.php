<?php
include 'db_query.php';

header('Content-Type: application/json');
echo json_encode(fetch_employee_data());
?>
