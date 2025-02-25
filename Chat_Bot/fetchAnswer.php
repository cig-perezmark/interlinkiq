<?php


if(!isset($_COOKIE['ID']))
    die('Invalid access');

include "connection.php";

$result = $con->query("SELECT a FROM tbl_chatbot_faq WHERE id={$_GET['id']}");

echo $result->fetch_assoc()['a'];

$con->close();
