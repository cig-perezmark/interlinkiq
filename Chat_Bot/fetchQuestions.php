<?php
if(!isset($_COOKIE['ID'])) 
    die("Invalid access");

include "connection.php";

$results = $con->query("SELECT id,q,a FROM tbl_chatbot_faq");

$data = [];
if(mysqli_num_rows($results) > 0) 
    while($row = $results->fetch_assoc())
        $data[] = $row;
        // $data .= "{[{$row['id']}]{$row['q']}}";

echo json_encode($data);

$con->close();