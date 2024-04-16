<?php
	$servername='localhost';
	$username='brandons_interlinkiq';
	$password='L1873@2019new';
	$dbname = "brandons_interlinkiq";
	$conn=mysqli_connect($servername,$username,$password,"$dbname");
	if(!$conn){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>