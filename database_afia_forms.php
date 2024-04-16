<?php
	$servername='localhost';
	$qc_forms_username='brandons_apps';
	$qc_forms_password='interlinkapps2022';
	$qc_forms_db_name='brandons_qc-forms';
	
	$qc_connection=mysqli_connect($servername,$qc_forms_username,$qc_forms_password,"$qc_forms_db_name");
	if(!$qc_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>