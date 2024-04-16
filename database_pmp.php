<?php
	$servername='localhost';
	$pmp_username='brandons_apps';
	$pmp_password='interlinkapps2022';
	$pmp_db_name='brandons_pmp';
	
	$pmp_connection=mysqli_connect($servername,$pmp_username,$pmp_password,"$pmp_db_name");
	if(!$pmp_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>