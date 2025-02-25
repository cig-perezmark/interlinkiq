<?php 

include_once 'database.php';
$newminute = $_POST["new_value"];

$sql = "UPDATE tbl_service_logs_draft SET minute = '".$newminute."' WHERE task_id = '".$_POST["row_id"]."'";  
mysqli_query($conn, $sql);


?>
