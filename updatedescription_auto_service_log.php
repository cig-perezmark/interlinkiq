<?php 

include_once 'database.php';
$newdescription = $_POST["new_value"];

$sql = "UPDATE tbl_service_logs_draft SET description = '".$newdescription."' WHERE task_id = '".$_POST["row_id"]."'";  
mysqli_query($conn, $sql);


?>
