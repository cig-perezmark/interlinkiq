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

	if( isset($_POST['btnGenerate']) ) {
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

        $timestamp_date = new DateTime(); //this returns the current date time
        $timestamp_id_new = $timestamp_date->format('YmdHisu');

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
		}

		$columnResult = 0;
		$columnYes = 0;
		$columnNA = 0;
		$columnCount = 0;

		// Select and Clone Format
        $format_output_arr = array();
        $format_type_arr = array();
        $format_ID_arr = array();
        $format_ID_new_arr = array();
		$selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $timestamp_id");
		if ( mysqli_num_rows($selectFormat) > 0 ) {
			while($rowFormat = mysqli_fetch_array($selectFormat)) {
				$format_ID = $rowFormat['ID'];
				$format_type = $rowFormat['type'];
				$format_label = $rowFormat['label'];

				$sql_format = "INSERT INTO tbl_ia_format (order_id, timestamp_id, type, label)
				SELECT order_id, '$timestamp_id_new', type, label
				FROM tbl_ia_format
				WHERE deleted = 0 AND ID = $format_ID";
				if (mysqli_query($conn, $sql_format)) {
					$last_id_format = mysqli_insert_id($conn);

					$output_format = array (
						'old' => $format_ID,
						'new' => $last_id_format,
						'label' => $format_label
					);
					array_push($format_output_arr, $output_format);
	                array_push($format_type_arr, $format_type);
	                array_push($format_ID_arr, $format_ID);
	                array_push($format_ID_new_arr, $last_id_format);
				}

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
		$format_ID_new_arr_data = implode(' | ', $format_ID_new_arr);

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

		// Select and Clone Sheet
        $sheet_output_arr = array();
        $sheet_ID_arr = array();
        $sheet_ID_new_arr = array();
		$selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND timestamp_id = $timestamp_id");
		if ( mysqli_num_rows($selectSheet) > 0 ) {
			while($rowSheet = mysqli_fetch_array($selectSheet)) {
				$sheet_ID = $rowSheet['ID'];

				$sql_format = "INSERT INTO tbl_ia_sheet (user_id, portal_user, timestamp_id, name)
				SELECT user_id, '$portal_user', '$timestamp_id_new', name
				FROM tbl_ia_sheet
				WHERE deleted = 0 AND ID = $sheet_ID";
				if (mysqli_query($conn, $sql_format)) {
					$last_id_sheet = mysqli_insert_id($conn);

					$output_sheet = array (
						'old' => $sheet_ID,
						'new' => $last_id_sheet
					);
					array_push($sheet_output_arr, $output_sheet);
                    array_push($sheet_ID_arr, $sheet_ID);
                    array_push($sheet_ID_new_arr, $last_id_sheet);
				}
			}
		}
		$sheet_ID_new_arr_data = implode(' | ', $sheet_ID_new_arr);

		// Select and Clone IA
		$sql_ia = "INSERT INTO tbl_ia (user_id, portal_user, timestamp_id, title, description, sheet_id, last_modified, is_generated)
		SELECT user_id, '$portal_user', '$timestamp_id_new', title, description, '$sheet_ID_new_arr_data', '$last_modified', 1
		FROM tbl_ia
		WHERE ID = $ID";
		if (mysqli_query($conn, $sql_ia)) {
			$last_id_ia = mysqli_insert_id($conn);
		}

		// Loop each sheet (old)
		$i = 0;
		$data_output_arr = array();
		$data_ID_arr = array();
		$data_ID_new_arr = array();
		foreach($sheet_ID_arr as $sheet_ID_val) {

			// Select and Clone and Update Data
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE deleted = 0 AND sheet_id = $sheet_ID_val");
			if ( mysqli_num_rows($selectData) > 0 ) {
				while($rowData = mysqli_fetch_array($selectData)) {
					$data_ID = $rowData['ID'];

					$sql_data = "INSERT INTO tbl_ia_data (order_id, sheet_id, parent_id, include, data)
					SELECT order_id, '$sheet_ID_new_arr[$i]', parent_id, '$format_ID_new_arr_data', data
					FROM tbl_ia_data
					WHERE deleted = 0 AND ID = $data_ID";
					if (mysqli_query($conn, $sql_data)) {
						$last_id_data = mysqli_insert_id($conn);

						$output_data = array (
							'old' => $data_ID,
							'new' => $last_id_data
						);
						array_push($data_output_arr, $output_data);
		                array_push($data_ID_arr, $data_ID);
		                array_push($data_ID_new_arr, $last_id_data);
					}
				}
			}
			$i++;
		}

		// Loop each sheet (new) 
		foreach($sheet_ID_new_arr as $sheet_ID_new_val) {

			// Select and Reformat Data parent id and data
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE deleted = 0 AND sheet_id = $sheet_ID_new_val");
			if ( mysqli_num_rows($selectData) > 0 ) {
				while($rowData = mysqli_fetch_array($selectData)) {
					$data_ID = $rowData['ID'];
					$data_data = $rowData['data'];

					$data_parent_id_new = $rowData['parent_id'];
					$data_key = array_search($rowData['parent_id'], array_column($data_output_arr, "old"));
					if ($data_key !== false) {
					    $data_parent_id_new = $data_output_arr[$data_key]["new"];
					}

					// Loop each format (old)
					$data_data_output = json_decode($data_data, true);
					$data_data_new = array();
					$f = 0;
					foreach($format_ID_arr as $format_ID_val) {

						$format_key = array_search($format_ID_val, array_column($data_data_output, "ID"));
						if ($format_key !== false) {
							$data_output_new = array (
								'ID' => $format_ID_new_arr[$f],
								'content' => addslashes($data_data_output[$format_key]["content"])
							);
							array_push($data_data_new, $data_output_new);
						}
						$f++;
					}
					$data_data_new = json_encode($data_data_new, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);

					mysqli_query( $conn,"UPDATE tbl_ia_data set parent_id = $data_parent_id_new, data = '".$data_data_new."' WHERE ID = $data_ID" );
				}
			}
		}

		// Gather result
		$data_result = array();
		for ($d=0; $d < COUNT($data_output_arr); $d++) { 
			$data_ID_old = $data_output_arr[$d]["old"];
			$data_ID_new = $data_output_arr[$d]["new"];

			for ($f=0; $f < count($format_output_arr); $f++) { 
				$format_ID_old = $format_output_arr[$f]["old"];
				$format_ID_new = $format_output_arr[$f]["new"];

				if(!empty($_POST['radio_'.$data_ID_old.'_'.$format_ID_old])) {
	            	$data_column = array (
						'column' => strval($format_ID_new),
						'data' => addslashes($_POST['radio_'.$data_ID_old.'_'.$format_ID_old])
					);

	            	$data_output = array (
						'row' => strval($data_ID_new),
						'content' => $data_column
					);
					array_push($data_result, $data_output);
				} else if(!empty($_POST['columnData_'.$data_ID_old.'_'.$format_ID_old])) {
	            	$data_column = array (
						'column' => strval($format_ID_new),
						'data' => addslashes($_POST['columnData_'.$data_ID_old.'_'.$format_ID_old])
					);

	            	$data_output = array (
						'row' => strval($data_ID_new),
						'content' => $data_column
					);
					array_push($data_result, $data_output);
				}
			}
		}
		$data_content = json_encode($data_result, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);

		// Save Form
		$sql_form = "INSERT INTO tbl_ia_form (user_id, portal_user, ia_id, organization, audit_type, inspected_by, auditee, verified_by, date_start, date_end, audit_scope, score_type, score_data, label, description, operation, shipper, operation_type, audit_ex, addendum, product_observed, similar_product, product_applied, auditor, cert_valid, date_review_started, date_review_finished, total_time_review, date_inspection_started, date_inspection_finished, total_time_inspection, preliminary_audit, score_result)
		VALUES ('$user_id', '$portal_user', '$last_id_ia', '$organization', '$audit_type', '$inspected_by', '$auditee', '$verified_by', '$date_start', '$date_end', '$audit_scope', '$score_type', '$score_data', '$label', '$description', '$operation', '$shipper', '$operation_type', '$audit_ex', '$addendum', '$product_observed', '$similar_product', '$product_applied', '$auditor', '$cert_valid', '$date_review_started', '$date_review_finished', '$total_time_review', '$date_inspection_started', '$date_inspection_finished', '$total_time_inspection', '$columnPercent', '$score_result')";
		if (mysqli_query($conn, $sql_form)) {
			$last_id_form = mysqli_insert_id($conn);

			if ($columnPercent == 100) { mysqli_query( $conn,"UPDATE tbl_ia_form set final_audit = '".$columnPercent."' WHERE ID = '". $last_id_form ."'" ); }

			// Update Form separate for Custom Logo and Data
			mysqli_query( $conn,"UPDATE tbl_ia_form set file = '". $file ."' WHERE ID = '". $last_id_form ."'" );
			mysqli_query( $conn,"UPDATE tbl_ia_form set data = '". $data_content ."' WHERE ID = '". $last_id_form ."'" );

			// Insert History after Form
	        $sql_history = "INSERT INTO tbl_ia_history (user_id, portal_user, action, page, activity, last_modified)
	        VALUES ('$user_id', '$portal_user', '1', '2', '$last_id_form', '$last_modified')";
	        mysqli_query($conn, $sql_history);
		}
		echo json_encode($last_id_form);
	}
?>