<?php
	$servername='localhost';
	$username='brandons_interlinkiq';
	$password='L1873@2019new';
	$dbname = "brandons_interlinkiq";
	$conn=mysqli_connect($servername,$username,$password,"$dbname");
	if(!$conn){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$e_forms_username='brandons_apps';
	$e_forms_password='interlinkapps2022';
	$e_forms_db_name='brandons_qc-forms';
	
	$e_connection=mysqli_connect($servername,$e_forms_username,$e_forms_password,"$e_forms_db_name");
	if(!$e_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$qc_forms_username='brandons_apps';
	$qc_forms_password='interlinkapps2022';
	$qc_forms_db_name='brandons_afia-forms';
	
	$qc_connection=mysqli_connect($servername,$qc_forms_username,$qc_forms_password,"$qc_forms_db_name");
	if(!$qc_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$pmp_username='brandons_apps';
	$pmp_password='interlinkapps2022';
	$pmp_db_name='brandons_pmp';
	
	$pmp_connection=mysqli_connect($servername,$pmp_username,$pmp_password,"$pmp_db_name");
	if(!$pmp_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$payroll_username='brandons_apps';
	$payroll_password='interlinkapps2022';
	$payroll_db_name='brandons_payroll_demo';
	$payroll_connection=mysqli_connect($servername,$payroll_username,$payroll_password,"$payroll_db_name");
	if(!$payroll_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
    $emp_username='brandons_apps';
	$emp_password='interlinkapps2022';
	$emp_db_name='brandons_emp';
	$emp_connection=mysqli_connect($servername,$emp_username,$emp_password,"$emp_db_name");
	if(!$emp_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$sanition_db_name='brandons_sanitation';
	$sanition_connection=mysqli_connect($servername,$username,$password,"$sanition_db_name");
	if(!$sanition_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
	
	$connect = new PDO("mysql:host=localhost;dbname=brandons_interlinkiq", "brandons_interlinkiq", "L1873@2019new");
	
?>