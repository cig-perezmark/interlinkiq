<?php 
include ('database_afia_forms.php');
if( isset($_GET['fscs_action']) ) {
		$action = $_GET['fscs_action'];
		$m 		= $_GET['m'];
		$y 		= $_GET['y'];

		if ( $action=="getFSCSData" ){
			$sql = "SELECT 
						q.question,
						(SELECT count(*) AS Total FROM tbl_fscs_answers WHERE question_title=q.question AND answer='A' AND MONTH(date) IN({$m}) AND YEAR(date)=$y ) AS 'A',
						(SELECT count(*) AS Total FROM tbl_fscs_answers WHERE question_title=q.question AND answer='B' AND MONTH(date) IN({$m}) AND YEAR(date)=$y ) AS 'B',
						(SELECT count(*) AS Total FROM tbl_fscs_answers WHERE question_title=q.question AND answer='C' AND MONTH(date) IN({$m}) AND YEAR(date)=$y ) AS 'C',
						(SELECT count(*) AS Total FROM tbl_fscs_answers WHERE question_title=q.question AND answer='D' AND MONTH(date) IN({$m}) AND YEAR(date)=$y ) AS 'D' 
					FROM tbl_fscs_questionaires q ";
			$result = mysqli_query($qc_connection,$sql);
			$data 	= [];
			if ( mysqli_num_rows($result) > 0 ) {
				while($row = mysqli_fetch_array($result)) {
					array_push($data, $row);
				}
			}
			echo json_encode(['data' => $data]);
		}
	}