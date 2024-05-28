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
	function form_childView($data_ID, $sheet_id, $data_result) {
		global $conn;
		$data = '';

		$selectDataRowChild  = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = $data_ID AND deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
		if ( mysqli_num_rows($selectDataRowChild) > 0 ) {
			while($rowDataChild = mysqli_fetch_array($selectDataRowChild)) {
				$dataChild_ID = $rowDataChild['ID'];

        		$selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
    			if ( mysqli_num_rows($selectFormat) > 0 ) {
    				while($rowFormat = mysqli_fetch_array($selectFormat)) {
			            $formatID = $rowFormat['ID'];

			            if(!empty($_POST['radio_'.$dataChild_ID.'_'.$formatID])) {

			            	$data_column = array (
								'column' => $formatID,
								'data' => addslashes($_POST['radio_'.$dataChild_ID.'_'.$formatID])
							);

			            	$data_output = array (
								'row' => $dataChild_ID,
								'content' => $data_column
							);
							array_push($data_result, $data_output);
			            } else if(!empty($_POST['columnData_'.$dataChild_ID.'_'.$formatID])) {

			            	$data_column = array (
								'column' => $formatID,
								'data' => addslashes($_POST['columnData_'.$dataChild_ID.'_'.$formatID])
							);

			            	$data_output = array (
								'row' => $dataChild_ID,
								'content' => $data_column
							);
							array_push($data_result, $data_output);
			            }
			        }
			    }

			    $data_result = form_childView($dataChild_ID, $sheet_id, $data_result);
			}
		}
		
		return $data_result;
	}

	if (!empty($_COOKIE['switchAccount'])) {
		$portal_user = $_COOKIE['ID'];
		$user_id = $_COOKIE['switchAccount'];
	}
	else {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
	}

	$btnType = 'btnEdit_Form'; // $_POST['btnType'];
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

	mysqli_query( $conn,"UPDATE tbl_ia_form set portal_user = '". $portal_user ."', organization = '". $organization ."', audit_type = '". $audit_type ."', inspected_by = '". $inspected_by ."', auditee = '". $auditee ."', verified_by = '". $verified_by ."', audit_scope = '". $audit_scope ."', file = '". $file ."', label = '". $label ."', description = '". $description ."', operation = '". $operation ."', shipper = '". $shipper ."', operation_type = '". $operation_type ."', audit_ex = '". $audit_ex ."', addendum = '". $addendum ."', product_observed = '". $product_observed ."', similar_product = '". $similar_product ."', product_applied = '". $product_applied ."', auditor = '". $auditor ."', preliminary_audit = '". $preliminary_audit ."', final_audit = '". $final_audit ."', cert_valid = '". $cert_valid ."', date_review_started = '". $date_review_started ."', date_review_finished = '". $date_review_finished ."', total_time_review = '". $total_time_review ."', date_inspection_started = '". $date_inspection_started ."', date_inspection_finished = '". $date_inspection_finished ."', total_time_inspection = '". $total_time_inspection ."', date_start = '". $date_start ."', date_end = '". $date_end ."' WHERE ID = '". $ID ."'" );
        
    // echo json_encode('...');
	$selectForm = mysqli_query( $conn,"SELECT * FROM tbl_ia_form WHERE ID = $ID");
	if ( mysqli_num_rows($selectForm) > 0 ) {
		$rowForm = mysqli_fetch_array($selectForm);
		$form_ia_id = $rowForm['ia_id'];

		$selectIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE ID = $form_ia_id");
		if ( mysqli_num_rows($selectIA) > 0 ) {
			$rowIA = mysqli_fetch_array($selectIA);
			$ia_title = $rowIA['title'];
			$ia_sheet_id = $rowIA['sheet_id'];

	        $date_start = new DateTime($date_start);
	        $date_start = $date_start->format('M d, Y');

	        $date_end = new DateTime($date_end);
	        $date_end = $date_end->format('M d, Y');

	        $data = '<td>'.stripcslashes($ia_title).'</td>
	        <td>'.stripcslashes($organization).'</td>
	        <td>'.stripcslashes($audit_type).'</td>
	        <td>'.stripcslashes($inspected_by).'</td>
	        <td>'.stripcslashes($auditee).'</td>
	        <td>'.stripcslashes($verified_by).'</td>
	        <td class="text-center">'.$date_start.'</td>
	        <td class="text-center">'.$date_end.'</td>
	        <td>'.$audit_scope.'</td>
	        <td class="text-center">
	            <a href="#modalEditForm" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEditForm('.$ID.')" title="Edit"><i class="fa fa-pencil"></i></a>
	            <a href="'.$base_url.'pdf_dom?id='.$ID.'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
	            <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDeleteForm(this, '.$ID.')" title="Delete"><i class="fa fa-trash"></i></a>
	            <a href="javascript:;" class="btn btn-xs btn-info m-0" onclick="btnCloseForm(this, '.$ID.')" title="Close"><i class="fa fa-check"></i></a>
	        </td>';

			$output = array(
				"ID" => $ID,
				"data" => $data
			);


			if (!empty($ia_sheet_id)) {
				$data_result = array();
	        	$ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
	        	$columnResult = 0;
        		$columnYes = 0;
        		$columnNA = 0;
        		$columnCount = 0;
	        	foreach($ia_sheet_id_arr as $sheet_id) {
					$selectDataRow = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = 0 AND deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
					if ( mysqli_num_rows($selectDataRow) > 0 ) {
						while($rowData = mysqli_fetch_array($selectDataRow)) {
							$data_ID = $rowData['ID'];

			        		$selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
	            			if ( mysqli_num_rows($selectFormat) > 0 ) {
	            				while($rowFormat = mysqli_fetch_array($selectFormat)) {
						            $formatID = $rowFormat['ID'];

						            if(!empty($_POST['radio_'.$data_ID.'_'.$formatID])) {
						            	$data_column = array (
											'column' => $formatID,
											'data' => addslashes($_POST['radio_'.$data_ID.'_'.$formatID])
										);

						            	$data_output = array (
											'row' => $data_ID,
											'content' => $data_column
										);
										array_push($data_result, $data_output);
						            } else if(!empty($_POST['columnData_'.$data_ID.'_'.$formatID])) {
						            	$data_column = array (
											'column' => $formatID,
											'data' => addslashes($_POST['columnData_'.$data_ID.'_'.$formatID])
										);

						            	$data_output = array (
											'row' => $data_ID,
											'content' => $data_column
										);
										array_push($data_result, $data_output);
						            }
						        }
						    }
							
							$data_result = form_childView($data_ID, $sheet_id, $data_result);
						}
					}

					// Compute Each Radio Button per Sheet
	        		$selectFormat2 = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND type = 2 AND sheet_id = $sheet_id ORDER BY order_id" );
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
				if ($btnType == 'btnEdit_Form2') {
					mysqli_query( $conn,"UPDATE tbl_ia_form set preliminary_audit = 0, final_audit = 0 WHERE ID = '". $ID ."'" );
				} else if ($btnType == 'btnEdit_Form3') {
					mysqli_query( $conn,"UPDATE tbl_ia_form set preliminary_audit = '". $columnPercent ."', final_audit = 0 WHERE ID = '". $ID ."'" );
				} else {
					mysqli_query( $conn,"UPDATE tbl_ia_form set final_audit = '". $columnPercent ."' WHERE ID = '". $ID ."'" );
				}

				$data_content = json_encode($data_result, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
				mysqli_query( $conn,"UPDATE tbl_ia_form set data = '". $data_content ."' WHERE ID = '". $ID ."'" );
	        }
			echo json_encode($output);
		} else {
            $message = "Error2: " . $sql . "<br>" . mysqli_error($conn);
            echo json_encode($message);
        }
	} else {
        $message = "Error1: " . $sql . "<br>" . mysqli_error($conn);
        echo json_encode($message);
    }
?>