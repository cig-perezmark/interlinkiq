<?php
	$servername='localhost';
	$payroll_username='brandons_apps';
	$payroll_password='interlinkapps2022';
	$payroll_db_name='brandons_payroll_demo';
	$payroll_connection=mysqli_connect($servername,$payroll_username,$payroll_password,"$payroll_db_name");
	if(!$payroll_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>