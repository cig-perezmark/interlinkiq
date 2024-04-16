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
	function cloneDataChild($value_sheet_id, $data_ID, $last_id_sheet, $last_id_data, $temp_data) {
		global $conn;

		$selectDataChild = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE sheet_id = $value_sheet_id AND parent_id = $data_ID");
		if ( mysqli_num_rows($selectDataChild) > 0 ) {
			while($rowDataChild = mysqli_fetch_array($selectDataChild)) {
				$datachild_ID = $rowDataChild['ID'];

				$sql_datachild = "INSERT INTO tbl_ia_data (order_id, sheet_id, parent_id, include, data)
				SELECT order_id, $last_id_sheet, $last_id_data, include, data
				FROM tbl_ia_data
				WHERE deleted = 0 AND ID = $datachild_ID";
				if (mysqli_query($conn, $sql_datachild)) {
					$last_id_data = mysqli_insert_id($conn);

					if ($temp_data <> NULL) {
						$data_Y = array (
							'old' => $datachild_ID,
							'new' => $last_id_data
						);
						array_push($temp_data, $data_Y);
					}

					$temp_data = cloneDataChild($value_sheet_id, $datachild_ID, $last_id_sheet, $last_id_data, $temp_data);
				}
			}
		}

		return $temp_data;
	}

// 	if( isset($_POST['btnGenerate']) ) {
		if (!empty($_COOKIE['switchAccount'])) {
			$portal_user = $_COOKIE['ID'];
			$user_id = $_COOKIE['switchAccount'];
		}
		else {
			$portal_user = $_COOKIE['ID'];
			$user_id = employerID($portal_user);
		}

        // echo json_encode('sample');
        
		$btnType = $_GET['btnType'];
		$ID = $_POST['ID'];
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

		$sql = "INSERT INTO tbl_ia_form (user_id, portal_user, ia_id, organization, audit_type, inspected_by, auditee, verified_by, date_start, date_end, audit_scope, file, score_type, score_data, label, description, operation, shipper, operation_type, audit_ex, addendum, product_observed, similar_product, product_applied, auditor, cert_valid, date_review_started, date_review_finished, total_time_review, date_inspection_started, date_inspection_finished, total_time_inspection)
		VALUES ('$user_id', '$portal_user', '$ID', '$organization', '$audit_type', '$inspected_by', '$auditee', '$verified_by', '$date_start', '$date_end', '$audit_scope', '$file', '$score_type', '$score_data', '$label', '$description', '$operation', '$shipper', '$operation_type', '$audit_ex', '$addendum', '$product_observed', '$similar_product', '$product_applied', '$auditor', '$cert_valid', '$date_review_started', '$date_review_finished', '$total_time_review', '$date_inspection_started', '$date_inspection_finished', '$total_time_inspection')";
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);
			
	        $last_modified = date('Y-m-d');
	        $sql_history = "INSERT INTO tbl_ia_history (user_id, portal_user, action, page, activity, last_modified)
	        VALUES ('$user_id', '$portal_user', '1', '2', '$last_id', '$last_modified')";
	        mysqli_query($conn, $sql_history);

            $date_start = new DateTime($date_start);
            $date_start = $date_start->format('M d, Y');

            $date_end = new DateTime($date_end);
            $date_end = $date_end->format('M d, Y');

			$last_modified = date('Y-m-d');
			$new_sheet_id = array();

			// Clone IA
			$sql_ia = "INSERT INTO tbl_ia (user_id, portal_user, title, description, sheet_id, last_modified, is_generated)
			SELECT user_id, $portal_user, title, description, sheet_id, '$last_modified', 1
			FROM tbl_ia
			WHERE ID = $ID";
			if (mysqli_query($conn, $sql_ia)) {
				$last_id_ia = mysqli_insert_id($conn);

				$selectIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE ID = $last_id_ia");
				if ( mysqli_num_rows($selectIA) > 0 ) {
					$rowIA = mysqli_fetch_array($selectIA);
					$ia_title = $rowIA['title'];
					$ia_sheet_id = $rowIA['sheet_id'];

		            $data = '<tr id="tr_'.$last_id.'">
		                <td>'.stripcslashes($ia_title).'</td>
		                <td>'.stripcslashes($organization).'</td>
		                <td>'.stripcslashes($audit_type).'</td>
		                <td>'.stripcslashes($inspected_by).'</td>
		                <td>'.stripcslashes($auditee).'</td>
		                <td>'.stripcslashes($verified_by).'</td>
		                <td class="text-center">'.$date_start.'</td>
		                <td class="text-center">'.$date_end.'</td>
		                <td>'.$audit_scope.'</td>
		                <td class="text-center">
				            <a href="#modalEditForm" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEditForm('.$last_id.')" title="Edit"><i class="fa fa-pencil"></i></a>
				            <a href="'.$base_url.'pdf_dom?id='.$last_id.'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
				            <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteForm(this, '.$last_id.')" title="Delete"><i class="fa fa-trash"></i></a>
				            <a href="javascript:;" class="btn btn-xs btn-info m-0" onclick="btnCloseForm(this, '.$last_id.')" title="Close"><i class="fa fa-check"></i></a>
				        </td>
		            </tr>';

					$output = array(
						"ID" => $last_id,
						"data" => $data
					);

		            if (!empty($ia_sheet_id)) {
						$data_result = array();
						$temp_data = array();
		            	$ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
		        		$columnResult = 0;
		        		$columnYes = 0;
		        		$columnNA = 0;
		        		$columnCount = 0;
						foreach($ia_sheet_id_arr as $value_sheet_id) {

							// Clone Sheet
							$sql_sheet = "INSERT INTO tbl_ia_sheet (user_id, portal_user, name)
							SELECT user_id, $portal_user, name
							FROM tbl_ia_sheet
							WHERE deleted = 0 AND ID = $value_sheet_id";
							if (mysqli_query($conn, $sql_sheet)) {
								$last_id_sheet = mysqli_insert_id($conn);
								array_push($new_sheet_id, $last_id_sheet);

								// Select and Clone Data Parent
								$selectData = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = 0 AND deleted = 0 AND sheet_id = $value_sheet_id ORDER BY order_id");
								if ( mysqli_num_rows($selectData) > 0 ) {
									while($rowData = mysqli_fetch_array($selectData)) {
										$data_ID = $rowData['ID'];

										$sql_data = "INSERT INTO tbl_ia_data (order_id, sheet_id, parent_id, include, data)
										SELECT order_id, $last_id_sheet, parent_id, include, data
										FROM tbl_ia_data
										WHERE deleted = 0 AND ID = $data_ID";
										if (mysqli_query($conn, $sql_data)) {
											$last_id_data = mysqli_insert_id($conn);

											$data_Y = array (
												'old' => $data_ID,
												'new' => $last_id_data
											);
											array_push($temp_data, $data_Y);

											// Select and Clone Data Child
											$temp_data = cloneDataChild($value_sheet_id, $data_ID, $last_id_sheet, $last_id_data, $temp_data);
										}
									}
								}

								// Select and Clone Format
								$selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $value_sheet_id ORDER BY order_id");
								if ( mysqli_num_rows($selectFormat) > 0 ) {
									while($rowFormat = mysqli_fetch_array($selectFormat)) {
										$format_ID = $rowFormat['ID'];

										// Clone Format
										$sql_format = "INSERT INTO tbl_ia_format (order_id, sheet_id, type, label)
										SELECT order_id, $last_id_sheet, type, label
										FROM tbl_ia_format
										WHERE deleted = 0 AND ID = $format_ID";
										if (mysqli_query($conn, $sql_format)) {
											$last_id_format = mysqli_insert_id($conn);

											$selectFormatData = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE deleted = 0 AND sheet_id = $last_id_sheet ORDER BY order_id");
											if ( mysqli_num_rows($selectFormatData) > 0 ) {
												while($rowFormatData = mysqli_fetch_array($selectFormatData)) {
													$formatdata_ID = $rowFormatData['ID'];

													// Reformat Include
													$new_include = array();
													$formatdata_include_arr = explode(' | ', $rowFormatData['include']);
													foreach($formatdata_include_arr as $value_include) {
														if ($format_ID == $value_include) {
															array_push($new_include, $last_id_format);
														} else {
															array_push($new_include, $value_include);
														}
													}
													$new_include = implode(' | ', $new_include);
													
													// Reformat Data
													$new_data = array();
													$formatdata_data_arr = json_decode($rowFormatData['data'], true);
													foreach($formatdata_data_arr as $key => $value_data) {
														if ($format_ID == $value_data['ID']) {
															$data_output = array (
																'ID' => $last_id_format,
																'content' => addslashes($value_data['content'])
															);
														} else {
															$data_output = array (
																'ID' => $value_data['ID'],
																'content' => addslashes($value_data['content'])
															);
														}
														array_push($new_data, $data_output);
													}
													$new_data = json_encode($new_data, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);

													mysqli_query( $conn,"UPDATE tbl_ia_data set include = '". $new_include ."', data = '". $new_data ."' WHERE ID = '". $formatdata_ID ."'" );


													// Gather Result
													$oldValue = array_search($formatdata_ID, array_column($temp_data, 'new'));
													if ($oldValue !== false) {
													    $oldValue = $temp_data[$oldValue]['old'];

														if(!empty($_POST['radio_'.$oldValue.'_'.$format_ID])) {
											            	$generate_data_column = array (
																'column' => strval($last_id_format),
																'data' => addslashes($_POST['radio_'.$oldValue.'_'.$format_ID])
															);

											            	$generate_data_output = array (
																'row' => $formatdata_ID,
																'content' => $generate_data_column
															);
															array_push($data_result, $generate_data_output);
											            } else if(!empty($_POST['columnData_'.$oldValue.'_'.$format_ID])) {
											            	$generate_data_column = array (
																'column' => strval($last_id_format),
																'data' => addslashes($_POST['columnData_'.$oldValue.'_'.$format_ID])
															);

											            	$generate_data_output = array (
																'row' => $formatdata_ID,
																'content' => $generate_data_column
															);
															array_push($data_result, $generate_data_output);
											            }
													}
												}
											}
										}
									}
								}
							}

							// Compute Each Radio Button per Sheet
			        		$selectFormat2 = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND type = 2 AND sheet_id = $value_sheet_id ORDER BY order_id" );
		        			if ( mysqli_num_rows($selectFormat2) > 0 ) {
		        				while($rowFormat2 = mysqli_fetch_array($selectFormat2)) {
						            $formatID2 = $rowFormat2['ID'];

						            if(!empty($_POST['columnData_'.$formatID2])) {
										$columnDatas = $_POST['columnData_'.$formatID2];
							        	$columnCount += count($columnDatas);

										if (in_array(strtolower('yes'), array_map('strtolower', $columnDatas))) {
											if (in_array(strtolower('n/a'), array_map('strtolower', $columnDatas))) {
												$columnNA += array_count_values(array_map('strtolower', $columnDatas))['n/a'];
											}
							        		$columnYes += array_count_values(array_map('strtolower', $columnDatas))['yes'];
										}
						            }
						        }
						    }
						}

						if ($columnCount > $columnNA) { $columnResult = $columnYes / ($columnCount - $columnNA); }
						$columnPercent = round($columnResult * 100);
						$columnPercent = round($columnResult * 100);
						if ($btnType == 'btnGenerate2') { $columnPercent = 0; }

						$score_result = array();
						array_push($score_result, $columnYes);
						array_push($score_result, $columnCount - $columnNA - $columnYes);
						array_push($score_result, $columnCount - $columnNA);
						$score_result = implode(" | ",$score_result);

						$new_sheet_id = implode(' | ', $new_sheet_id);
						// $new_temp_data = json_encode($temp_data, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
						// $de_temp_data = json_decode($temp_data, true);
						$data_content = json_encode($data_result, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
						mysqli_query( $conn,"UPDATE tbl_ia set sheet_id = '". $new_sheet_id ."' WHERE ID = '". $last_id_ia ."'" );
						mysqli_query( $conn,"UPDATE tbl_ia_form set ia_id = '". $last_id_ia ."', data = '".$data_content."', preliminary_audit = '".$columnPercent."', score_result = '".$score_result."' WHERE ID = '". $last_id ."'" );

						if ($columnPercent == 100) { mysqli_query( $conn,"UPDATE tbl_ia_form set final_audit = '".$columnPercent."' WHERE ID = '". $last_id ."'" ); }
		            }
				}
			}
			echo json_encode($output);
		}
// 	}
?>