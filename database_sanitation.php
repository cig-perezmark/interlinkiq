<?php
	$servername='localhost';
	$username='brandons_interlinkiq';
	$password='L1873@2019new';
	$sanition_db_name='brandons_sanitation';
	
	$sanition_connection=mysqli_connect($servername,$username,$password,"$sanition_db_name");
	if(!$sanition_connection){
	   die('Could not Connect My Sql:' .mysql_error());
	}
?>