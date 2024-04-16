<?php
require '../database.php';
if( isset($_POST['btnSave']) ) {
		
        $user_id = $_COOKIE['ID'];
		$services_name = mysqli_real_escape_string($conn,$_POST['services_name']);
		$services_category = mysqli_real_escape_string($conn,$_POST['services_category']);

		$sql = "INSERT INTO tbl_Project_Services (added_by,services_name,services_category)
		VALUES ('$user_id','$services_name', '$services_category')";
		
		if (mysqli_query($conn, $sql)) {
		}
		else{
		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		    echo $message;
		}
		mysqli_close($conn);
		echo json_encode($conn);
	}
?>