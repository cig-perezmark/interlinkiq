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
		function form_childView($data_ID, $sheet_id, $data_result, $formData_arr) {
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

		            		if (array_search('radio_'.$dataChild_ID.'_'.$formatID, array_column($formData_arr, 'name')) == true) {
					            $radio_key = array_search('radio_'.$dataChild_ID.'_'.$formatID, array_column($formData_arr, 'name'));
								$radio_dataVal = $formData_arr[$radio_key]['value'];

				            	$data_column = array (
									'column' => $formatID,
									'data' => addslashes($radio_dataVal)
								);

				            	$data_output = array (
									'row' => $dataChild_ID,
									'content' => $data_column
								);
								array_push($data_result, $data_output);
				            } else if (array_search('columnData_'.$dataChild_ID.'_'.$formatID, array_column($formData_arr, 'name')) == true) {
					            $column_key = array_search('columnData_'.$dataChild_ID.'_'.$formatID, array_column($formData_arr, 'name'));
								$column_dataVal = $formData_arr[$column_key]['value'];

				            	$data_column = array (
									'column' => $formatID,
									'data' => addslashes($column_dataVal)
								);

				            	$data_output = array (
									'row' => $dataChild_ID,
									'content' => $data_column
								);
								array_push($data_result, $data_output);
				            }
				        }
				    }

				    $data_result = form_childView($dataChild_ID, $sheet_id, $data_result, $formData_arr);
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

		$btnType = $_POST['btnType'];
		$data = $_POST['data'];
		$data = json_encode($data);
		$label = '';
		$description = '';

		$formData_arr = json_decode($data, true);
		foreach($formData_arr as $key) {
			if ($key['name'] == 'ID') { $ID = $key['value']; }
			else if ($key['name'] == 'organization') { $organization = addslashes($key['value']); }
			else if ($key['name'] == 'audit_type') { $audit_type = addslashes($key['value']); }
			else if ($key['name'] == 'inspected_by') { $inspected_by = addslashes($key['value']); }
			else if ($key['name'] == 'auditee') { $auditee = addslashes($key['value']); }
			else if ($key['name'] == 'verified_by') { $verified_by = addslashes($key['value']); }
			else if ($key['name'] == 'audit_scope') { $audit_scope = addslashes($key['value']); }

			else if ($key['name'] == 'operation') { $operation = addslashes($key['value']); }
			else if ($key['name'] == 'shipper') { $shipper = addslashes($key['value']); }
			else if ($key['name'] == 'operation_type') { $operation_type = addslashes($key['value']); }
			else if ($key['name'] == 'audit_ex') { $audit_ex = addslashes($key['value']); }
			else if ($key['name'] == 'addendum') { $addendum = addslashes($key['value']); }
			else if ($key['name'] == 'product_observed') { $product_observed = addslashes($key['value']); }
			else if ($key['name'] == 'similar_product') { $similar_product = addslashes($key['value']); }
			else if ($key['name'] == 'product_applied') { $product_applied = addslashes($key['value']); }
			else if ($key['name'] == 'auditor') { $auditor = addslashes($key['value']); }
			else if ($key['name'] == 'preliminary_audit') { $preliminary_audit = addslashes($key['value']); }
			else if ($key['name'] == 'final_audit') { $final_audit = addslashes($key['value']); }
			else if ($key['name'] == 'cert_valid') { $cert_valid = addslashes($key['value']); }

			else if ($key['name'] == 'date_review_started') { $date_review_started = addslashes($key['value']); }
			else if ($key['name'] == 'date_review_finished') { $date_review_finished = addslashes($key['value']); }
			else if ($key['name'] == 'total_time_review') { $total_time_review = addslashes($key['value']); }
			else if ($key['name'] == 'date_inspection_started') { $date_inspection_started = addslashes($key['value']); }
			else if ($key['name'] == 'date_inspection_finished') { $date_inspection_finished = addslashes($key['value']); }
			else if ($key['name'] == 'total_time_inspection') { $total_time_inspection = addslashes($key['value']); }

			else if ($key['name'] == 'daterange') {
				$date = $key['value'];
				$date = explode(' - ', $date);
				$date_start = $date[0];
				$date_end = $date[1];
			}

			else if ($key['name'] == 'label') {
				$label = $key['value'];
				if (!empty($label)) {
					$label = implode(' | ', $label);
				}
			}

			else if ($key['name'] == 'description') {
				$description = $key['value'];
				if (!empty($description)) {
					$description = implode(' | ', $description);
				}
			}
			
			else if ($key['name'] == 'file_temp') { $file = addslashes($key['value']); }
		}

		mysqli_query( $conn,"UPDATE tbl_ia_form set portal_user = '". $portal_user ."', organization = '". $organization ."', audit_type = '". $audit_type ."', inspected_by = '". $inspected_by ."', auditee = '". $auditee ."', verified_by = '". $verified_by ."', audit_scope = '". $audit_scope ."', file = '". $file ."', label = '". $label ."', description = '". $description ."', operation = '". $operation ."', shipper = '". $shipper ."', operation_type = '". $operation_type ."', audit_ex = '". $audit_ex ."', addendum = '". $addendum ."', product_observed = '". $product_observed ."', similar_product = '". $similar_product ."', product_applied = '". $product_applied ."', auditor = '". $auditor ."', preliminary_audit = '". $preliminary_audit ."', final_audit = '". $final_audit ."', cert_valid = '". $cert_valid ."', date_review_started = '". $date_review_started ."', date_review_finished = '". $date_review_finished ."', total_time_review = '". $total_time_review ."', date_inspection_started = '". $date_inspection_started ."', date_inspection_finished = '". $date_inspection_finished ."', total_time_inspection = '". $total_time_inspection ."', date_start = '". $date_start ."', date_end = '". $date_end ."' WHERE ID = '". $ID ."'" );
        
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
		            <a href="'.$base_url.'pdf_ia?id='.$ID.'" class="btn btn-xs btn-success m-0" title="PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
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

					            		if (array_search('radio_'.$data_ID.'_'.$formatID, array_column($formData_arr, 'name')) !== false) {
								            $radio_key = array_search('radio_'.$data_ID.'_'.$formatID, array_column($formData_arr, 'name'));
											$radio_dataVal = $formData_arr[$radio_key]['value'];

							            	$data_column = array (
												'column' => $formatID,
												'data' => addslashes($radio_dataVal)
											);

							            	$data_output = array (
												'row' => $data_ID,
												'content' => $data_column
											);
											array_push($data_result, $data_output);
							            } else if (array_search('columnData_'.$data_ID.'_'.$formatID, array_column($formData_arr, 'name')) !== false) {
								            $column_key = array_search('columnData_'.$data_ID.'_'.$formatID, array_column($formData_arr, 'name'));
											$column_dataVal = $formData_arr[$column_key]['value'];

							            	$data_column = array (
												'column' => $formatID,
												'data' => addslashes($column_dataVal)
											);

							            	$data_output = array (
												'row' => $data_ID,
												'content' => $data_column
											);
											array_push($data_result, $data_output);
							            }
							        }
							    }
								
								$data_result = form_childView($data_ID, $sheet_id, $data_result, $formData_arr);
							}
						}

						// Compute Each Radio Button per Sheet
		        		$selectFormat2 = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND type = 2 AND sheet_id = $sheet_id ORDER BY order_id" );
	        			if ( mysqli_num_rows($selectFormat2) > 0 ) {
	        				while($rowFormat2 = mysqli_fetch_array($selectFormat2)) {
					            $formatID2 = $rowFormat2['ID'];


					            foreach ($formData_arr as $keys => $values) {
					            	if ($values['name'] == 'columnData_'.$formatID2.'[]') {
					            		$columnCount++;

					            		if (strtolower($values['value']) == 'yes') {
					            			$columnYes++;
					            		}
					            		else if (strtolower($values['value']) == 'n/a' OR strtolower($values['value']) == 'na') {
					            			$columnNA++;
					            		}
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
				echo json_encode($formData_arr);
			} else {
                $message = "Error2: " . $sql . "<br>" . mysqli_error($conn);
                echo json_encode($message);
            }
		} else {
            $message = "Error1: " . $sql . "<br>" . mysqli_error($conn);
            echo json_encode($message);
        }
?>
