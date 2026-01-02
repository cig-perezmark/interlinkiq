<?php
session_start();
if(!isset($_COOKIE['ID'])) 
    die("Invalid access");

include "connection.php";
$user_id = $_COOKIE['ID'];
$query = mysqli_real_escape_string($con, $_POST['query']);
$answer = $_POST['has_answer'];

if($con->query("INSERT INTO tbl_user_queries(user_id,query,has_answer) VALUES('$user_id','$query','$answer')")) {
    echo 1;
}

$con->close();
