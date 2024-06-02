<?php 

include_once 'database.php';
$newcomment = $_POST["new_value"];

$sql = "UPDATE tbl_service_logs_draft SET comment = '".$newcomment."' WHERE task_id = '".$_POST["row_id"]."'";  
mysqli_query($conn, $sql);


?>