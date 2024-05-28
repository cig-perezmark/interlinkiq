<?php
    include_once ('database_iiq.php');
    $base_url = "https://interlinkiq.com/";

	function employerID($ID) {
		global $conn;

		$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
	    $rowUser = mysqli_fetch_array($selectUser);
	    $current_userEmployeeID = $rowUser['employee_id'];

	    $current_userEmployerID = $ID;
	    if ($current_userEmployeeID > 0) {
	        $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
	        if ( mysqli_num_rows($selectEmployer) > 0 ) {
	            $rowEmployer = mysqli_fetch_array($selectEmployer);
	            $current_userEmployerID = $rowEmployer["user_id"];
	        }
	    }

	    return $current_userEmployerID;
	}

	if( isset($_POST['btnEdit_Form']) ) {
		if (!empty($_COOKIE['switchAccount'])) {
			$portal_user = $_COOKIE['ID'];
			$user_id = $_COOKIE['switchAccount'];
		}
		else {
			$portal_user = $_COOKIE['ID'];
			$user_id = employerID($portal_user);
		}

		$btnType = $_POST['btnType'];
		$ID = $_POST['ID'];
		$timestamp_id = $_POST['timestamp_id'];

		$organization = addslashes($_POST['organization']);
		$audit_type = addslashes($_POST['audit_type']);
		$inspected_by = addslashes($_POST['inspected_by']);
		$auditee = addslashes($_POST['auditee']);
		$verified_by = addslashes($_POST['verified_by']);
		$audit_scope = addslashes($_POST['audit_scope']);

		$operation = addslashes($_POST['operation']);
		$shipper = addslashes($_POST['shipper']);
		$operation_type = addslashes($_POST['operation_type']);
		$audit_ex = addslashes($_POST['audit_ex']);
		$addendum = addslashes($_POST['addendum']);
		$product_observed = addslashes($_POST['product_observed']);
		$similar_product = addslashes($_POST['similar_product']);
		$product_applied = addslashes($_POST['product_applied']);
		$auditor = addslashes($_POST['auditor']);
		$preliminary_audit = addslashes($_POST['preliminary_audit']);
		$final_audit = addslashes($_POST['final_audit']);
		$cert_valid = addslashes($_POST['cert_valid']);
		
		$date_review_started = addslashes($_POST['date_review_started']);
		$date_review_finished = addslashes($_POST['date_review_finished']);
		$total_time_review = addslashes($_POST['total_time_review']);
		$date_inspection_started = addslashes($_POST['date_inspection_started']);
		$date_inspection_finished = addslashes($_POST['date_inspection_finished']);
		$total_time_inspection = addslashes($_POST['total_time_inspection']);

		$date = $_POST['daterange'];
		$date = explode(' - ', $date);
		$date_start = $date[0];
		$date_end = $date[1];

        $last_modified = date('Y-m-d');

        $score_type = $_POST['score_type'];
		$score_data = "";
        if (!empty($_POST['score_label'])) {
            $arr_item = array();
            for ($i=0; $i < count($_POST['score_label']); $i++) {
                $score_label = addslashes($_POST['score_label'][$i]);
                $score_rate = addslashes($_POST['score_rate'][$i]);
                $score_color = addslashes($_POST['score_color'][$i]);
                $output = array (
                    'score_label'    =>  $score_label,
                    'score_rate'    =>  $score_rate,
                    'score_color'    =>  $score_color
                );
                array_push($arr_item, $output);
            }
            $score_data = json_encode($arr_item, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
        } else {
            $score_type = 0;
        }

		$label = "";
		if (!empty($_POST['label'])) { 
			$label = $_POST['label'];
			$label = implode(' | ', $label);
		}

		$description = "";
		if (!empty($_POST['description'])) { 
			$description = $_POST['description'];
			$description = implode(' | ', $description);
		}

		$file = $_FILES['file']['name'];
		if (!empty($file)) {
			$base_tmp = $_FILES['file']['tmp_name'];
			$base_type = pathinfo($base_tmp, PATHINFO_EXTENSION);
			$base_data = file_get_contents($base_tmp);
			$file = 'data:image/png;base64,' . base64_encode($base_data);
		} else {
			$file = $_POST['file_temp'];
		}

		$columnResult = 0;
		$columnYes = 0;
		$columnNA = 0;
		$columnCount = 0;

		// Select Format
        $format_ID_arr = array();
		$selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $timestamp_id");
		if ( mysqli_num_rows($selectFormat) > 0 ) {
			while($rowFormat = mysqli_fetch_array($selectFormat)) {
				$format_ID = $rowFormat['ID'];
				array_push($format_ID_arr, $format_ID);

				// Count Answer
				if(!empty($_POST['columnData_'.$format_ID])) {
					$columnDatas = $_POST['columnData_'.$format_ID];
					$columnCount += count($columnDatas);

					if (in_array(strtolower('yes'), array_map('strtolower', $columnDatas))) {
						if (in_array(strtolower('n/a'), array_map('strtolower', $columnDatas))) {
							$columnNA += array_count_values(array_map('strtolower', $columnDatas))['n/a'];
						} else if (in_array(strtolower('na'), array_map('strtolower', $columnDatas))) {
							$columnNA += array_count_values(array_map('strtolower', $columnDatas))['na'];
						}
						$columnYes += array_count_values(array_map('strtolower', $columnDatas))['yes'];
					}
				}
			}
		}

		// Meter Gauge Result
		if ($columnCount > $columnNA) { $columnResult = $columnYes / ($columnCount - $columnNA); }
		$columnPercent = round($columnResult * 100);
		$columnPercent = round($columnResult * 100);
		if ($btnType == 'btnGenerate2') { $columnPercent = 0; }

		// Customize Scoring Setup
		$score_result = array();
		array_push($score_result, $columnYes);
		array_push($score_result, $columnCount - $columnNA - $columnYes);
		array_push($score_result, $columnCount - $columnNA);
		$score_result = implode(" | ",$score_result);

		// Select Sheet, Data and Loop each Format to Get Result
		$data_result = array();
		$selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND timestamp_id = $timestamp_id");
		if ( mysqli_num_rows($selectSheet) > 0 ) {
			while($rowSheet = mysqli_fetch_array($selectSheet)) {
				$sheet_ID = $rowSheet['ID'];

				// Selet Data
				$selectData = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE deleted = 0 AND sheet_id = $sheet_ID");
				if ( mysqli_num_rows($selectData) > 0 ) {
					while($rowData = mysqli_fetch_array($selectData)) {
						$data_ID = $rowData['ID'];

						for ($f=0; $f < count($format_ID_arr); $f++) { 
							$format_ID = $format_ID_arr[$f];

							if(!empty($_POST['radio_'.$data_ID.'_'.$format_ID])) {
				            	$data_column = array (
									'column' => strval($format_ID),
									'data' => addslashes($_POST['radio_'.$data_ID.'_'.$format_ID])
								);

				            	$data_output = array (
									'row' => strval($data_ID),
									'content' => $data_column
								);
								array_push($data_result, $data_output);
							} else if(!empty($_POST['columnData_'.$data_ID.'_'.$format_ID])) {
				            	$data_column = array (
									'column' => strval($format_ID),
									'data' => addslashes($_POST['columnData_'.$data_ID.'_'.$format_ID])
								);

				            	$data_output = array (
									'row' => strval($data_ID),
									'content' => $data_column
								);
								array_push($data_result, $data_output);
							}
						}
					}
				}
			}
		}
		$data_content = json_encode($data_result, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);

		// Update Form
		mysqli_query( $conn,"UPDATE tbl_ia_form set portal_user = '". $portal_user ."', organization = '". $organization ."', audit_type = '". $audit_type ."', inspected_by = '". $inspected_by ."', auditee = '". $auditee ."', verified_by = '". $verified_by ."', audit_scope = '". $audit_scope ."', score_type = '". $score_type ."', score_data = '". $score_data ."', label = '". $label ."', description = '". $description ."', operation = '". $operation ."', shipper = '". $shipper ."', operation_type = '". $operation_type ."', audit_ex = '". $audit_ex ."', addendum = '". $addendum ."', product_observed = '". $product_observed ."', similar_product = '". $similar_product ."', product_applied = '". $product_applied ."', auditor = '". $auditor ."', preliminary_audit = '". $preliminary_audit ."', final_audit = '". $final_audit ."', cert_valid = '". $cert_valid ."', date_review_started = '". $date_review_started ."', date_review_finished = '". $date_review_finished ."', total_time_review = '". $total_time_review ."', date_inspection_started = '". $date_inspection_started ."', date_inspection_finished = '". $date_inspection_finished ."', total_time_inspection = '". $total_time_inspection ."', date_start = '". $date_start ."', date_end = '". $date_end ."', score_result = '". $score_result ."' WHERE ID = '". $ID ."'" );

		// Update Form separate for Custom Logo and Data
		mysqli_query( $conn,"UPDATE tbl_ia_form set file = '". $file ."' WHERE ID = '". $ID ."'" );
		mysqli_query( $conn,"UPDATE tbl_ia_form set data = '". $data_content ."' WHERE ID = '". $ID ."'" );

		if ($btnType == 'btnEdit_Form2') {
			mysqli_query( $conn,"UPDATE tbl_ia_form set preliminary_audit = 0, final_audit = 0 WHERE ID = '". $ID ."'" );
		} else if ($btnType == 'btnEdit_Form3') {
			mysqli_query( $conn,"UPDATE tbl_ia_form set preliminary_audit = '". $columnPercent ."', final_audit = 0 WHERE ID = '". $ID ."'" );
		} else {
			mysqli_query( $conn,"UPDATE tbl_ia_form set final_audit = '". $columnPercent ."' WHERE ID = '". $ID ."'" );
		}

		// Insert History
        $sql_history = "INSERT INTO tbl_ia_history (user_id, portal_user, action, page, activity, last_modified)
        VALUES ('$user_id', '$portal_user', '2', '2', '$ID', '$last_modified')";
        mysqli_query($conn, $sql_history);

		echo json_encode($data_content);
	}
?>