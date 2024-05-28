
<?php
	$servername='localhost';
	$username='brandons_apps';
	$password='interlinkapps2022';
	$dbname = "brandons_pmp";
	$conn=mysqli_connect($servername,$username,$password,"$dbname");
	if(!$conn){
	   die('Could not Connect My Sql:' .mysqli_error());
	}
?>