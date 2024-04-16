<?php

include_once __DIR__ . '/mysqli_extended.php';

// $servername='localhost';
// $username='brandons_interlinkiq';
// $password='L1873@2019new';
// $dbname = "brandons_interlinkiq";

if (isset($conn) && is_object($conn) && $conn instanceof mysqli) {
	$conn->close();
} else {
	$servername='localhost';
	$username='brandons_interlinkiq';
	$password='L1873@2019new';
	$dbname = "brandons_interlinkiq";
}

$conn = new mysqli_extended($servername, $username, $password, $dbname);

?>