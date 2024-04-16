<?php
	$servername='localhost';
	$e_forms_username='brandons_apps';
	$e_forms_password='interlinkapps2022';
	$e_forms_db_name='brandons_qc-forms';
	
	$e_connection=mysqli_connect($servername,$e_forms_username,$e_forms_password,"$e_forms_db_name");
	if(!$e_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>