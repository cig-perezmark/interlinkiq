<?php
    function counterup_cam() {
    	global $conn;
    	if (!empty($_COOKIE['switchAccount'])) {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = $_COOKIE['switchAccount'];
    	} else {
    		$portal_user = $_COOKIE['ID'];
    		$user_id = employerID($portal_user);
    	}
    
    	$selectOpen = mysqli_query($conn, "SELECT * FROM tbl_cam WHERE status = 0 AND user_id = $user_id");
    	$statusOpen = mysqli_num_rows($selectOpen);
    
    	$selectOpen2 = mysqli_query($conn, "SELECT * FROM tbl_complaint_records WHERE deleted = 0 AND capam = 1 AND status = 0 AND care_ownedby = $user_id");
    	$statusOpen2 = mysqli_num_rows($selectOpen2);
    
    	$selectClose = mysqli_query($conn, "SELECT * FROM tbl_cam WHERE status = 1 AND user_id = $user_id");
    	$statusClose = mysqli_num_rows($selectClose);
    
    	$selectClose2 = mysqli_query($conn, "SELECT * FROM tbl_complaint_records WHERE deleted = 0 AND capam = 1 AND status = 1 AND care_ownedby = $user_id");
    	$statusClose2 = mysqli_num_rows($selectClose2);
    
    
    	$output = array(
    		'statusOpen' => $statusOpen + $statusOpen2,
    		'statusClose' => $statusClose + $statusClose2
    	);
    	return $output;
    }
    
    if (isset($_GET['counterup_cam'])) {
    	echo json_encode(counterup_cam());
    }
    
    if (isset($_GET['modalView_CAM'])) {
	$ID = $_GET['modalView_CAM'];

	$current_client = 0;
	if (isset($_COOKIE['client'])) {
		$current_client = $_COOKIE['client'];
	}

	if (!empty($_COOKIE['switchAccount'])) {
		$portal_user = $_COOKIE['ID'];
		$user_id = $_COOKIE['switchAccount'];
	} else {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
	}

	$selectData = mysqli_query($conn, "SELECT * FROM tbl_cam WHERE ID = $ID");
	if (mysqli_num_rows($selectData) > 0) {
		$row = mysqli_fetch_array($selectData);

		echo '<input class="form-control" type="hidden" name="ID" value="' . $ID . '" />
			<div class="portlet box default margin-bottom-15">
				<div class="portlet-body">
					<div class="row form-horizontal">
						<div class="col-md-3">
							<label class="control-label">Is this a Product related  issue?</label>
						</div>
						<div class="col-md-1">
							<select class="form-control margin-bottom-15" name="product_related" disabled>
								<option value="0"';
		echo $row['product_related'] == 0 ? 'SELECTED' : '';
		echo '>No</option>
								<option value="1"';
		echo $row['product_related'] == 1 ? 'SELECTED' : '';
		echo '>Yes</option>
							</select>
						</div>
						<div class="';
		echo $user_id == 1 ? '' : '';
		echo '">
							<div class="product_related_2 ';
		echo $row['product_related'] == 1 ? '' : 'hide';
		echo ' col-md-2 col-md-offset-1">
								<select class="form-control" name="related_supplier" disabled>
									<option value="0">Select Supplier</option>';

		$selectSupplier = mysqli_query($conn, "SELECT ID, name FROM tbl_supplier WHERE user_id = $user_id AND facility_switch = $facility_switch_user_id AND page = 1 AND is_deleted = 0 ORDER BY name");
		if (mysqli_num_rows($selectSupplier) > 0) {
			while ($rowSupplier = mysqli_fetch_array($selectSupplier)) {
				echo '<option value="' . $rowSupplier['ID'] . '" ';
				echo $row['related_supplier'] == $rowSupplier['ID'] ? 'SELECTED' : '';
				echo '>' . htmlentities($rowSupplier['name'] ?? '') . '</option>';
			}
		}

		echo '</select>
								<small class="help-block">List of Suppliers</small>
							</div>
							<div class="product_related_2 ';
		echo $row['product_related'] == 1 ? '' : 'hide';
		echo ' col-md-2">
								<select class="form-control" name="related_product" disabled>
									<option value="0">Select Product</option>';

		$selectProduct = mysqli_query($conn, "
										SELECT
										*
										FROM (
											SELECT CONCAT('p_', ID) AS ID, name 
											FROM tbl_products
											WHERE user_id = $user_id AND facility_switch = $facility_switch_user_id AND deleted = 0

											UNION ALL

											SELECT
											CONCAT('m_', m.ID) AS ID,
											m.material_name AS name
											FROM tbl_supplier AS s

											RIGHT JOIN (
												SELECT
												*
												FROM tbl_supplier_material
											) AS m
											ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')) > 0

											WHERE s.user_id = $user_id AND s.facility_switch = $facility_switch_user_id
											AND s.page = 1 AND s.is_deleted = 0
									   ) r
									   ORDER BY r.name
									");
		if (mysqli_num_rows($selectProduct) > 0) {
			while ($rowProduct = mysqli_fetch_array($selectProduct)) {
				echo '<option value="' . $rowProduct['ID'] . '" ';
				echo $row['related_product'] == $rowProduct['ID'] ? 'SELECTED' : '';
				echo '>' . htmlentities($rowProduct['name'] ?? '') . '</option>';
			}
		}

		echo '</select>
								<small class="help-block">List of Products</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="control-label">Date of Issue</label>
							<input type="date" class="form-control" name="date" value="' . $row['date'] . '" disabled />
						</div>
						<div class="col-md-2">
							<label class="control-label">Time of Issue</label>
							<input type="time" class="form-control" name="time" value="' . $row['time'] . '" disabled />
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label class="control-label">Observed By</label>
							<input type="text" class="form-control" name="observed_by" value="' . htmlentities($row['observed_by'] ?? '') . '" disabled />
						</div>
						<div class="col-md-2">
							<label class="control-label">Reported By</label>
							<input type="text" class="form-control" name="reported_by" value="' . htmlentities($row['reported_by'] ?? '') . '" disabled />
						</div>
						<div class="col-md-2 col-md-offset-1 ';
		echo $current_client == 1 ? 'hide' : '';
		echo '">
							<label class="control-label">CAPA Reference No.</label>
							<input type="text" class="form-control" name="reference" value="' . htmlentities($row['reference'] ?? '') . '" disabled />
						</div>
					</div>
				</div>
			</div>';

		if ($current_client == 1) {
			echo '<div class="portlet box default margin-bottom-15">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark bold">Program</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="mt-checkbox-inline">';

			$selectProgram = mysqli_query($conn, "SELECT * FROM tbl_library WHERE type = 1 AND deleted = 0 AND user_id = $user_id");
			if (mysqli_num_rows($selectProgram) > 0) {
				while ($rowProgram = mysqli_fetch_array($selectProgram)) {
					$program_ID = $rowProgram['ID'];
					$program_name = htmlentities($rowProgram['name'] ?? '');

					$arr_program_ID = array();
					if (!empty($row['program_id'])) {
						$arr_program_ID = explode(', ', $row['program_id']);
					}

					echo '<label class="mt-checkbox mt-checkbox-outline">
										<input type="checkbox" name="program_id[]" value="' . $program_ID . '" ';
					echo in_array($program_ID, $arr_program_ID) ? 'checked' : '';
					echo ' disabled> ' . $program_name . '
										<span></span>
									</label>';
				}
			}

			echo '</div>
					</div>
				</div>';
		} else {
			echo '<div class="portlet box default margin-bottom-15">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark bold">Category</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="mt-checkbox-inline">';

			$selectCategory = mysqli_query($conn, "SELECT * FROM tbl_cam_category WHERE deleted = 0 ORDER BY name");
			if (mysqli_num_rows($selectCategory) > 0) {
				while ($rowCat = mysqli_fetch_array($selectCategory)) {
					$cat_ID = $rowCat['ID'];
					$cat_name = htmlentities($rowCat['name'] ?? '');
					$arr_category_id = explode(', ', $row['category_id']);

					echo '<label class="mt-checkbox mt-checkbox-outline">
										<input type="checkbox" name="category_id[]" value="' . $cat_ID . '" ';
					echo in_array($cat_ID, $arr_category_id) ? 'checked' : '';
					echo ' disabled /> ' . $cat_name . '
										<span></span>
									</label>';
				}
			}

			echo '<label class="mt-checkbox mt-checkbox-outline">
								<input type="checkbox" name="category_id[]" value="0" ';
			echo !empty($row['category_other']) ? 'checked' : '';
			echo ' onClick="btnCategory(this)" disabled /> Other
								<span></span>
							</label>
							<input type="text" class="form-control ';
			echo !empty($row['category_other']) ? '' : 'hide';
			echo '" name="category_other" placeholder="Specify Category" value="' . htmlentities($row['category_other'] ?? '') . '" disabled />
						</div>
					</div>
				</div>';
		}

		echo '<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Department(s) Involved</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="mt-checkbox-inline">';

		// $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_cam_department WHERE deleted = 0 ORDER BY name" );
		// if ( mysqli_num_rows($selectDepartment) > 0 ) {
		//     while ($rowDept = mysqli_fetch_array($selectDepartment)) {
		//         $dept_ID = $rowDept['ID'];
		//         $dept_name = $rowDept['name'];
		//         $arr_department_id =  explode(', ', $row['department_id']);

		//         echo '<label class="mt-checkbox mt-checkbox-outline">
		//             <input type="checkbox" name="department_id[]" value="'.$dept_ID.'" '; echo in_array($dept_ID, $arr_department_id) ? 'checked':''; echo ' disabled> '.$dept_name.'
		//             <span></span>
		//         </label>';
		//     }
		// }

		$selectDepartment = mysqli_query($conn, "SELECT * FROM tbl_hr_department WHERE deleted = 0 AND status = 1 AND user_id = $user_id ORDER BY title");
		if (mysqli_num_rows($selectDepartment) > 0) {
			while ($rowDept = mysqli_fetch_array($selectDepartment)) {
				$dept_ID = $rowDept['ID'];
				$dept_title = htmlentities($rowDept['title'] ?? '');
				$arr_department_id = explode(', ', $row['department_id']);

				echo '<label class="mt-checkbox mt-checkbox-outline">
									<input type="checkbox" class="department_id_3" name="department_id[]" value="' . $dept_ID . '" ';
				echo in_array($dept_ID, $arr_department_id) ? 'checked' : '';
				echo ' onclick="changeDepartment(3)" disabled /> ' . $dept_title . '
									<span></span>
								</label>';
			}
		}

		echo '<label class="mt-checkbox mt-checkbox-outline hide">
							<input type="checkbox" name="department_id[]" value="0" disabled> Other
							<span></span>
						</label>
						<input type="text" class="form-control hide" name="department_other" placeholder="Specify Department" value="' . htmlentities($row['department_other'] ?? '') . '" disabled />
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Involved Personnel</span>
					</div>
				</div>
				<div class="portlet-body">
					<select class="form-control mt-multiselect employee_id_3" data-placeholder="Select Personnel" name="employee_id[]" multiple="multiple" disabled></select>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Description of Issue</span>
					</div>
				</div>
				<div class="portlet-body">
					<textarea class="form-control" rows="3" name="description" disabled>' . $row['description'] . '</textarea>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15 hide ';
		echo $_COOKIE['client'] == 0 ? '' : 'hide';
		echo '">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Trend Category</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="mt-repeater mt-repeater-trend">
						<div data-repeater-list="trend">';

		if (!empty($row['trend'])) {
			$array_trend = explode(' | ', $row['trend']);
			foreach ($array_trend as $value) {
				if (!empty($value)) {
					echo '<div class="mt-repeater-item row" data-repeater-item>
											<div class="col-xs-12">
												<input class="form-control" type="text" name="trend_desc" value="' . $value . '" disabled />
											</div>
										</div>';
				}
			}
		}

		echo '</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Observation';
		echo $current_client == 1 ? '(s)' : ' / Issue(s)';
		echo '</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<textarea class="form-control" rows="10" name="observation_desc" disabled>' . htmlentities($row['observation'] ?? '') . '</textarea>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-observation">
								<div data-repeater-list="observation">';

		if (!empty($row['observation_file'])) {
			$array_observation_file = explode(' | ', $row['observation_file']);
			foreach ($array_observation_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Root Cause(s)</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<textarea class="form-control" rows="10" name="root_cause_desc" disabled>' . $row['root_cause'] . '</textarea>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-root_cause">
								<div data-repeater-list="root_cause">';

		if (!empty($row['root_cause_file'])) {
			$array_root_cause_file = explode(' | ', $row['root_cause_file']);
			foreach ($array_root_cause_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Corrective Action(s)</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<select class="form-control margin-bottom-15 ';
		echo $current_client == 1 ? 'hide' : '';
		echo '" name="corrective_status" disabled>
								<option value="0" ';
		echo $row['corrective_status'] == 0 ? 'SELECTED' : '';
		echo '>--Select Status--</option>
								<option value="1" ';
		echo $row['corrective_status'] == 1 ? 'SELECTED' : '';
		echo '>Proposed</option>
								<option value="2" ';
		echo $row['corrective_status'] == 2 ? 'SELECTED' : '';
		echo '>Implemented</option>
							</select>
							<textarea class="form-control margin-bottom-15" rows="10" name="corrective_desc" disabled>' . htmlentities($row['corrective_desc'] ?? '') . '</textarea>
							<div class="row">
								<div class="col-md-4">
									<input type="date" class="form-control margin-bottom-15" name="corrective_date" placeholder="Date" value="' . $row['corrective_date'] . '" disabled />
								</div>
								<div class="col-md-4">
									<input type="time" class="form-control margin-bottom-15" name="corrective_time" placeholder="Time" value="' . $row['corrective_time'] . '" disabled />
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control margin-bottom-15" name="corrective_by" placeholder="Corrected By" value="' . htmlentities($row['corrective_by'] ?? '') . '" disabled />
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-corrective">
								<div data-repeater-list="corrective">';

		if (!empty($row['corrective_file'])) {
			$array_corrective_file = explode(' | ', $row['corrective_file']);
			foreach ($array_corrective_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Implementation(s)</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<select class="form-control margin-bottom-15" name="implementation_status" disabled>
								<option value="0" ';
		echo $row['implementation_status'] == 0 ? 'SELECTED' : '';
		echo '>--Select Status--</option>
								<option value="1" ';
		echo $row['implementation_status'] == 1 ? 'SELECTED' : '';
		echo '>Proposed</option>
								<option value="2" ';
		echo $row['implementation_status'] == 2 ? 'SELECTED' : '';
		echo '>Implemented</option>
							</select>
							<textarea class="form-control margin-bottom-15" rows="10" name="implementation_desc" disabled>' . htmlentities($row['implementation_desc'] ?? '') . '</textarea>
							<div class="row form-horizontal">
								<div class="col-md-4">
									<label class="control-label">Effective Date of Resolution</label>
								</div>
								<div class="col-md-4">
									<input type="date" class="form-control margin-bottom-15" name="implementation_date" placeholder="Date" value="' . $row['implementation_date'] . '" disabled/>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control margin-bottom-15" name="implementation_by" placeholder="Implemented By" value="' . htmlentities($row['implementation_by'] ?? '') . '" disabled />
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-implementation">
								<div data-repeater-list="implementation">';

		if (!empty($row['implementation_file'])) {
			$array_implementation_file = explode(' | ', $row['implementation_file']);
			foreach ($array_implementation_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Preventive Action(s)</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<select class="form-control margin-bottom-15" name="preventive_status" disabled>
								<option value="0" ';
		echo $row['implementation_status'] == 0 ? 'SELECTED' : '';
		echo '>--Select Status--</option>
								<option value="1" ';
		echo $row['implementation_status'] == 1 ? 'SELECTED' : '';
		echo '>Proposed</option>
								<option value="2" ';
		echo $row['implementation_status'] == 2 ? 'SELECTED' : '';
		echo '>Implemented</option>
							</select>
							<textarea class="form-control margin-bottom-15" rows="10" name="preventive_desc" disabled>' . $row['preventive_desc'] . '</textarea>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-preventive">
								<div data-repeater-list="preventive">';

		if (!empty($row['preventive_file'])) {
			$array_preventive_file = explode(' | ', $row['preventive_file']);
			foreach ($array_preventive_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Evaluation(s) and Follow Up(s)</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<select class="form-control margin-bottom-15" name="evaluation_status" disabled>
								<option value="0" ';
		echo $row['evaluation_status'] == 0 ? 'SELECTED' : '';
		echo '>--Select Status--</option>
								<option value="1" ';
		echo $row['evaluation_status'] == 1 ? 'SELECTED' : '';
		echo '>Proposed</option>
								<option value="2" ';
		echo $row['evaluation_status'] == 2 ? 'SELECTED' : '';
		echo '>Implemented</option>
							</select>
							<textarea class="form-control margin-bottom-15" rows="10" name="evaluation_desc" disabled>' . htmlentities($row['evaluation_desc'] ?? '') . '</textarea>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-evaluation">
								<div data-repeater-list="evaluation">';

		if (!empty($row['evaluation_file'])) {
			$array_evaluation_file = explode(' | ', $row['evaluation_file']);
			foreach ($array_evaluation_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Comments</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">
							<textarea class="form-control margin-bottom-15" rows="10" name="comment_desc" disabled>' . htmlentities($row['comment'] ?? '') . '</textarea>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-comment">
								<div data-repeater-list="comment">';

		if (!empty($row['comment_file'])) {
			$array_comment_file = explode(' | ', $row['comment_file']);
			foreach ($array_comment_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold">Applicable Trainings</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-7">';

		// if ($current_client == 1) {
		echo '<label>Training(s):</label>
								<select class="form-control mt-multiselect training_desc_3" data-placeholder="Please Select" name="training_desc[]" multiple="multiple"></select>';
		// } else {
		//     echo '<textarea class="form-control" rows="10" name="training_desc" disabled>'.$row['training'].'</textarea>';
		// }

		echo '<div class="row margin-top-15">
								<div class="col-md-6">
									<input type="time" class="form-control margin-bottom-15" name="training_date" placeholder="Date" value="' . $row['training_date'] . '" disabled />
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<label>Supporting Documents / Evidence:</label>
							<div class="mt-repeater mt-repeater-training">
								<div data-repeater-list="training">';

		if (!empty($row['training_file'])) {
			$array_training_file = explode(' | ', $row['training_file']);
			foreach ($array_training_file as $value) {
				if (!empty($value)) {
					$file = $value;
					$fileExtension = fileExtension($file);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
					$url = $base_url . 'uploads/cam/';
					$file_src = $src . $url . rawurlencode($file) . $embed;

					echo '<div class="mt-repeater-item row" data-repeater-item>
													<div class="col-xs-12">
														<p class="';
					echo !empty($file) ? '' : 'hide';
					echo '" style="margin: 0;"><a data-src="' . $file_src . '" ' . $datafancybox . ' data-type="' . $type . '" class="btn btn-link">View</a></p>
													</div>
												</div>';
				}
			}
		}

		echo '</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="portlet box default margin-bottom-15">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-4">
							<div class="signatureContainer hide">
								<div class="form-group">
									<label class="col-md-3 control-label">Signature</label>
									<div class="col-md-5">
										<select class="form-control margin-bottom-15" onchange="selectType(this)" name="investigated_type">
											<option value="0">Select</option>
											<option value="1">Sign</option>
											<option value="2">Upload</option>
										</select>
									</div>
								</div>
								<input type="file" class="form-control margin-bottom-15 hide sign signature_upload" name="investigated_file" />
								<div class="hide sign signature_sign">
									<input type="button" class="btn btn-danger btnClear" onclick="btnClear(this)" value="Clear" />
									<div class="signature investigated_sign"></div>
								</div>
							</div>
							<div class="signatureResult text-center">
								<button type="button" class="btn btn-link btn-sm" onclick="editSignature(this)"><i class="fa fa-pencil"></i> [edit signature]</button>
								<img src="' . $row['investigated_sign'] . '" class="signature_img" style="display: block; border: 0; border-bottom: 1px solid; object-fit: contain;"/>
								<input type="hidden" name="investigated_sign_temp" value="' . $row['investigated_sign'] . '" />
							</div>
							<input type="text" class="form-control margin-bottom-15" name="investigated_by" placeholder="Investigated By" value="' . htmlentities($row['investigated_by'] ?? '') . '" />
							<input type="text" class="form-control margin-bottom-15" name="investigated_title" placeholder="Title" value="' . htmlentities($row['investigated_title'] ?? '') . '" />
							<input type="datetime-local" class="form-control margin-bottom-15" name="investigated_datetime" value="' . $row['investigated_date'] . 'T' . $row['investigated_time'] . '" />
						</div>
						<div class="col-md-4">
							<div class="signatureContainer hide">
								<div class="form-group">
									<label class="col-md-3 control-label">Signature</label>
									<div class="col-md-5">
										<select class="form-control margin-bottom-15" onchange="selectType(this)" name="verified_type">
											<option value="0">Select</option>
											<option value="1">Sign</option>
											<option value="2">Upload</option>
										</select>
									</div>
								</div>
								<input type="file" class="form-control margin-bottom-15 hide sign signature_upload" name="verified_file" />
								<div class="hide sign signature_sign">
									<input type="button" class="btn btn-danger btnClear" onclick="btnClear(this)" value="Clear" />
									<div class="signature verified_sign"></div>
								</div>
							</div>
							<div class="signatureResult text-center">
								<button type="button" class="btn btn-link btn-sm" onclick="editSignature(this)"><i class="fa fa-pencil"></i> [edit signature]</button>
								<img src="' . $row['verified_sign'] . '" class="signature_img" style="display: block; border: 0; border-bottom: 1px solid; object-fit: contain;"/>
								<input type="hidden" name="verified_sign_temp" value="' . $row['verified_sign'] . '" />
							</div>
							<input type="text" class="form-control margin-bottom-15" name="verified_by" placeholder="CAPA Verified By" value="' . htmlentities($row['verified_by'] ?? '') . '" />
							<input type="text" class="form-control margin-bottom-15" name="verified_title" placeholder="Title" value="' . htmlentities($row['verified_title'] ?? '') . '" />
							<input type="datetime-local" class="form-control margin-bottom-15" name="verified_datetime" value="' . $row['verified_date'] . 'T' . $row['verified_time'] . '" />
						</div>
						<div class="col-md-4">
							<div class="signatureContainer hide">
								<div class="form-group">
									<label class="col-md-3 control-label">Signature</label>
									<div class="col-md-5">
										<select class="form-control margin-bottom-15" onchange="selectType(this)" name="completed_type">
											<option value="0">Select</option>
											<option value="1">Sign</option>
											<option value="2">Upload</option>
										</select>
									</div>
								</div>
								<input type="file" class="form-control margin-bottom-15 hide sign signature_upload" name="completed_file" />
								<div class="hide sign signature_sign">
									<input type="button" class="btn btn-danger btnClear" onclick="btnClear(this)" value="Clear" />
									<div class="signature completed_sign"></div>
								</div>
							</div>
							<div class="signatureResult text-center">
								<button type="button" class="btn btn-link btn-sm" onclick="editSignature(this)"><i class="fa fa-pencil"></i> [edit signature]</button>
								<img src="' . $row['completed_sign'] . '" class="signature_img" style="display: block; border: 0; border-bottom: 1px solid; object-fit: contain;"/>
								<input type="hidden" name="completed_sign_temp" value="' . $row['completed_sign'] . '" />
							</div>
							<input type="text" class="form-control margin-bottom-15" name="completed_by" placeholder="CAPA Completed By" value="' . htmlentities($row['completed_by'] ?? '') . '" />
							<input type="text" class="form-control margin-bottom-15" name="completed_title" placeholder="Title" value="' . htmlentities($row['completed_title'] ?? '') . '" />
							<input type="datetime-local" class="form-control margin-bottom-15" name="completed_datetime" value="' . $row['completed_date'] . 'T' . $row['completed_time'] . '" />
						</div>
					</div>
				</div>
			</div>';
	}
}
  