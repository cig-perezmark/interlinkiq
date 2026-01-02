<?php
	require_once __DIR__ . '/vendor/autoload.php';
	include_once ('../database_iiq.php');

	$mpdf = new \Mpdf\Mpdf();
	$base_url = "https://interlinkiq.com/";
	$html = '';
	
	$current_dateNow_o = date('Y/m/d');
	$current_dateNow = new DateTime($current_dateNow_o);
	$current_dateNow = $current_dateNow->format('M d, Y');
	
	$local_date = date('Y-m-d');
	
	$ID = 0;
	
	$selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
	if ( mysqli_num_rows($selectAPI) > 0 ) {
		$rowAPI = mysqli_fetch_array($selectAPI);
		$api_key = $rowAPI["ID"]; // 32 chars for AES-256
	}
	$encoded = urlencode($_GET['i']);
	if (!empty($encoded)) {
		$decoded = base64_decode(urldecode($encoded));

		// Extract IV (first 16 bytes) and ciphertext
		$api_iv = substr($decoded, 0, 16);
		$api_ciphertext = substr($decoded, 16);
		// $api_ciphertext2 = substr($decoded2, 16);

		$ID = openssl_decrypt($api_ciphertext, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
	}
	
	function fileExtension($file) {
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		$src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
		$embed = '&embedded=true';
		$type = 'iframe';
		if (strtolower($extension) == "pdf") {
			$src = '';
			$embed = '';
			$type = '';
			$file_extension = "fa-file-pdf-o";
		} else if (strtolower($extension) == "doc" or strtolower($extension) == "docx") {
			$file_extension = "fa-file-word-o";
		} else if (strtolower($extension) == "ppt" or strtolower($extension) == "pptx") {
			$file_extension = "fa-file-powerpoint-o";
		} else if (strtolower($extension) == "xls" or strtolower($extension) == "xlsb" or strtolower($extension) == "xlsm" or strtolower($extension) == "xlsx" or strtolower($extension) == "csv" or strtolower($extension) == "xlsx") {
			$file_extension = "fa-file-excel-o";
		} else if (strtolower($extension) == "gif" or strtolower($extension) == "jpg" or strtolower($extension) == "jpeg" or strtolower($extension) == "png" or strtolower($extension) == "ico") {
			$src = '';
			$embed = '';
			$type = '';
			$file_extension = "fa-file-image-o";
		} else if (strtolower($extension) == "mp4" or strtolower($extension) == "mov" or strtolower($extension) == "wmv" or strtolower($extension) == "flv" or strtolower($extension) == "avi" or strtolower($extension) == "avchd" or strtolower($extension) == "webm" or strtolower($extension) == "mkv") {
			$src = '';
			$embed = '';
			$type = '';
			$file_extension = "fa-file-video-o";
		} else {
			$src = '';
			$embed = '';
			$type = '';
			$file_extension = "fa-file-code-o";
		}

		$output['src'] = $src;
		$output['embed'] = $embed;
		$output['type'] = $type;
		$output['file_extension'] = $file_extension;
		$output['file_mime'] = $extension;
		return $output;
	}
	
	$facility = '';
	$facility_main = 0;
	$facility_other = 0;

	$material = '';
	$material_tr = '';

	$record = '';

	$html = '<html>
		<head>
			<title>Supplier Report</title>
			<style>
				.bg-tbl-gray {
					background: #dbdbdb;
					font-weight: 700;
				}
				.text-red {
					color: red;
				}
				.text-danger {
					color: #ed6b75;
					font-weight: 700;
				}
				.text-warning {
					color: #F1C40F;
					font-weight: 700;
				}
				table td {
					vertical-align: top;
				}
			</style>
		</head>
		<body>';
		
			if (ctype_digit($ID)) {
			
				$selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $ID" );
				if ( mysqli_num_rows($selectData) > 0 ) {
					$row = mysqli_fetch_array($selectData);
					$user_account_id = $row["user_id"];
					$user_id = $row["user_id"];
					$page = $row["page"];
					$category = $row["category"];
					$industry = $row["industry"];
		
					$address = htmlentities($row["address"] ?? '');
					$address_arr = array();
					$address_arr[0] = '';
					$address_arr[1] = $address;
					$address_arr[2] = '';
					$address_arr[3] = '';
					$address_arr[4] = '';
					
					$bldg = '';
					$city = '';
					$state = '';
					$country = '';
					$zip = '';
					if (!empty($address)) {
						if (str_contains($address, '|')) {
							$address_arr = explode(" | ", $address);
						} else if (str_contains($address, ',')) {
							
							if (count(explode(", ", $address)) == 5) {
								$address_arr = explode(", ", $address);
							}
						}
						
						$bldg = $address_arr[1];
						$city = $address_arr[2];
						$state = $address_arr[3];
						$zip = $address_arr[4];
						
						$selectCountry = mysqli_query( $conn,"SELECT * FROM countries WHERE iso2 = '".$address_arr[0]."'" );
						$rowCountry = mysqli_fetch_array($selectCountry);
						$country = $rowCountry["name"];
					}
					$address_full = $bldg .', '. $city .', '. $state .', '. $zip .', '. $country;
		
					$document = '';
					$document_reformat = '';
					$document_arr = array();
					if (!empty($row["document"])) {
						$document = $row["document"];
						$document_arr = explode(" | ", $document);
						if (count($document_arr) <= 1) {
							$document_arr = explode(", ", $document);
						}
						
						$document_reformat = implode(' | ', $document_arr);
					}
		
					$document_other = '';
					$document_other_reformat = '';
					$document_other_arr = array();
					if (!empty($row["document_other"])) {
						$document_other = $row["document_other"];
						$document_other_arr = explode(" | ", $document_other);
						// if (count($document_other_arr) <= 1 ) {
						//     $document_other_arr = explode(", ", $document_other);
						// }
						
						$document_other_reformat = implode(' | ', $document_other_arr);
					}
				}
				
				$html .= '<table width="100%" cellpadding="7" cellspacing="0" border="1">
					<tr class="bg-tbl-gray">
						<td colspan="2"><strong>'; $html .= ($user_id == 1984 OR $user_id == 1986) ? 'SHIPPER':'SUPPLIER'; $html .= ' INFORMATION</strong></td>
					</tr>
					<tr>
						<td style="width: 25%;"><strong>Name</strong></td>
						<td>'.$row["name"].'</td>
					</tr>
					<tr>
						<td><strong>Address</strong></td>
						<td>'.$address_full.'</td>
					</tr>
					<tr>
						<td><strong>Email</strong></td>
						<td>'.$row["email"].'</td>
					</tr>
					<tr>
						<td><strong>Phone</strong></td>
						<td>'.$row["phone"].'</td>
					</tr>
					<tr>
						<td><strong>Website</strong></td>
						<td>'.$row["website"].'</td>
					</tr>
				</table>';
				
				if (!empty($row["contact"])) {
					$html .= '<br>
				
					<table width="100%" cellpadding="7" cellspacing="0" border="1">
						<tr class="bg-tbl-gray">
							<td colspan="5"><strong>CONTACT DETAILS</strong></td>
						</tr>
						<tr>
							<td><strong>Name</strong></td>
							<td><strong>Title</strong></td>
							<td><strong>Address</strong></td>
							<td><strong>Email</strong></td>
							<td><strong>Phone</strong></td>
						</tr>';
						
						$contact_arr = $row["contact"];
						$selectContact = mysqli_query( $conn,"SELECT * FROM tbl_supplier_contact WHERE FIND_IN_SET(ID, REPLACE('$contact_arr', ' ', ''))" );
						if ( mysqli_num_rows($selectContact) > 0 ) {
							while($rowContact = mysqli_fetch_array($selectContact)) {
								$contact_id = $rowContact["ID"];
								$contact_notification = $rowContact["notification"];
								$contact_name = htmlentities($rowContact["name"] ?? '');
								$contact_title = htmlentities($rowContact["title"] ?? '');
								$contact_address = htmlentities($rowContact["address"] ?? '');
								$contact_email = htmlentities($rowContact["email"] ?? '');
								$contact_phone = htmlentities($rowContact["phone"] ?? '');
								$contact_cell = htmlentities($rowContact["cell"] ?? '');
								$contact_fax = htmlentities($rowContact["fax"] ?? '');
								
								$html .= '<tr>
									<td>'.$contact_name.'</td>
									<td>'.$contact_title.'</td>
									<td>'.$contact_address.'</td>
									<td>'.$contact_email.'</td>
									<td>'.$contact_phone.'</td>
								</tr>';
							}
						}
						
					$html .= '</table>';
				}
				
				if (!empty($row["material"])) {
					$material .= '<br><table width="100%" cellpadding="7" cellspacing="0" border="1">';
					
					    if ($user_id == 1984 OR $user_id == 1986) {
    						$material .= '<tr class="bg-tbl-gray">
    							<td colspan="7"><strong>SHIPMENTS</strong></td>
    						</tr>';
					    } else {
    						$material .= '<tr class="bg-tbl-gray">
    							<td colspan="7"><strong>MATERIALS</strong></td>
    						</tr>';
					    }
						
						$material .= '<tr>
							<td style="width: 25%;"><strong>Name</strong></td>
							<td><strong>Description</strong></td>
							<td><strong>Requirement</strong></td>
							<td><strong>Documents</strong></td>
							<td style="width: 300px;"><strong>Comment</strong></td>
							<td style="width: 180px;"><strong>Validity Period</strong></td>
							<td style="width: 105px;"><strong>Status</strong></td>
						</tr>';
						
						$material_arr = $row["material"];
						$selectMaterial = mysqli_query( $conn,"
							SELECT
							ID,
							material_name,
							description,
							document,
							document_other,
							spec_file,
							spec_date_from,
							spec_date_to,
							spec_reviewer,
							spec_reviewer_date,
							spec_approver,
							spec_approver_date,
							spec_comment_id,
							other
							FROM tbl_supplier_material 
							WHERE FIND_IN_SET(ID, REPLACE('$material_arr', ' ', ''))
							ORDER BY material_name
						" );
						if ( mysqli_num_rows($selectMaterial) > 0 ) {
							while($rowMaterial = mysqli_fetch_array($selectMaterial)) {
								$material_ID = $rowMaterial["ID"];
								$material_document = $rowMaterial["document"];
								$material_document_other = $rowMaterial["document_other"];
								$material_name = htmlentities($rowMaterial["material_name"] ?? '');
								$material_description = htmlentities($rowMaterial["description"] ?? '');
								$td = '';
								$td_span = 2;
								$material_total = 0;
								$material_count = 0;
								$material_percentage = 0;

								// $international = '';
								// if ($f == 0) {
								// 	$international = ' OR r.materials = -1 ';
								// }
								$international = ' OR r.materials = -1 ';

								$compliance = 0;
								$compliance_counter = 0;
								$compliance_approved = 0;

								$compliance_other = 0;
								$compliance_counter_other = 0;
								$compliance_approved_other = 0;

								$selectRequirement = mysqli_query( $conn,"
									SELECT
									*
									FROM (
										WITH checklist AS (
											SELECT *
											FROM tbl_supplier_checklist
											WHERE deleted = 0
											  AND type = 0
											  AND user_id = $user_id
										),
										checked AS (
											SELECT *
											FROM tbl_supplier_checklist_checked
											WHERE deleted = 0
											  AND user_id = $user_id
										)
										SELECT
											r.ID AS r_ID,
											r.international AS r_international,
											r.facility AS r_facility,
											r.materials AS r_materials,
											r.name AS r_name,
											CASE WHEN FIND_IN_SET(r.ID, REPLACE(REPLACE('$material_document', ' ', ''), '|',',')) THEN 1 ELSE 0 END AS r_checked,

											d.ID AS d_ID,
											d.file AS d_file,
											d.filetype AS d_filetype,
											d.filename AS d_filename,
											d.file_date AS d_file_date,
											d.file_due AS d_file_due,
											d.template AS d_template,
											d.comment AS d_comment,
											d.reviewed_by AS d_reviewed_by,
											d.reviewed_date AS d_reviewed_date,
											d.approved_by AS d_approved_by,
											d.approved_date AS d_approved_date,

											-- Checklist stats per requirement/document
											ROUND(
												CASE WHEN COUNT(COALESCE(c.checked, 0)) > 0 
													THEN (SUM(COALESCE(c.checked, 0)) / COUNT(COALESCE(c.checked, 0))) * 100 
													ELSE 0 END
											) AS checked_percentage,
											COUNT(DISTINCT cl.ID) AS total_item_checklist,
											SUM(CASE WHEN c.checked = 1 THEN 1 ELSE 0 END) AS total_item_checked,
											MIN(c.date_updated) AS min_date_updated,
											MAX(c.date_updated) AS max_date_updated,

											-- Min portal_user for the earliest check (MySQL-compatible)
											(
												SELECT c2.portal_user
												FROM checked c2
												INNER JOIN checklist cl2 ON cl2.ID = c2.checklist_id
												WHERE cl2.requirement_id = r.ID
												  AND c2.document_id = d.ID
												ORDER BY c2.date_updated ASC
												LIMIT 1
											) AS min_portal_user,

											-- Max portal_user for the latest check (MySQL-compatible)
											(
												SELECT c3.portal_user
												FROM checked c3
												INNER JOIN checklist cl3 ON cl3.ID = c3.checklist_id
												WHERE cl3.requirement_id = r.ID
												  AND c3.document_id = d.ID
												ORDER BY c3.date_updated DESC
												LIMIT 1
											) AS max_portal_user,

											s.ID AS s_ID,
											s.file AS s_file,
											s.filetype AS s_filetype,
											i.ID AS i_ID,
											i.file AS i_file,
											i.filetype AS i_filetype,
											t.ID AS t_ID,
											t.file AS t_file,
											t.filetype AS t_filetype

										FROM tbl_supplier_requirement AS r

										LEFT JOIN (
											SELECT *
											FROM tbl_supplier_document
											WHERE archived = 0 AND type = 0 AND user_id = $user_id AND material_id = $material_ID
										) AS d ON d.name = r.ID

										LEFT JOIN (
											SELECT *
											FROM tbl_supplier_checklist
											WHERE deleted = 0 AND user_id = $user_id
										) AS cl ON cl.requirement_id = r.ID

										LEFT JOIN (
											SELECT *
											FROM tbl_supplier_checklist_checked
											WHERE deleted = 0 AND user_id = $user_id
										) AS c ON c.checklist_id = cl.ID AND c.document_id = d.ID

										LEFT JOIN (
											SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id
										) AS s ON s.requirement_id = r.ID

										LEFT JOIN (
											SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id
										) AS i ON i.requirement_id = r.ID

										LEFT JOIN (
											SELECT * FROM tbl_supplier_template WHERE deleted = 0 AND user_id = $user_id
										) AS t ON t.requirement_id = r.ID

										WHERE r.deleted = 0 
											AND r.organic = 0 
											AND (FIND_IN_SET($user_id, REPLACE(REPLACE(r.materials, ' ', ''), '|',',')) OR r.materials = 0 OR r.materials = -2 $international) 

										GROUP BY r.name
										ORDER BY r.name
									) o
									WHERE o.r_checked = 1
									ORDER BY o.r_name
								" );
								if ( mysqli_num_rows($selectRequirement) > 0 ) {
									while($rowReq = mysqli_fetch_array($selectRequirement)) {
										$r_ID = $rowReq["r_ID"];
										$r_international = $rowReq["r_international"];
										$r_facility = $rowReq["r_facility"];
										$r_materials = $rowReq["r_materials"];
										$r_checked = $rowReq["r_checked"];

										$r_name = htmlentities($rowReq["r_name"] ?? '');
										if ($user_id == 1774 AND $r_ID == 156) {
											$r_name = htmlentities($rowReq["r_name"] ?? '').' - from Suwerte\'s forwarder';
										}

										$d_ID = $rowReq["d_ID"];
										$d_file = $rowReq["d_file"];
										$d_filetype = $rowReq["d_filetype"];
										$d_filename = $rowReq["d_filename"];
										$d_template = $rowReq["d_template"];
										$d_comment = $rowReq["d_comment"];

										$d_reviewed_by = $rowReq["d_reviewed_by"];
										$d_reviewed_date = $rowReq["d_reviewed_date"];
										if ($rowReq["total_item_checked"] > 0) {
											$d_reviewed_by = $rowReq["min_portal_user"];
											$d_reviewed_date = $rowReq["min_date_updated"];
											$d_reviewed_date = new DateTime($d_reviewed_date);
											$d_reviewed_date = $d_reviewed_date->format('Y-m-d');
										}
										$d_approved_by = $rowReq["d_approved_by"];
										$d_approved_date = $rowReq["d_approved_date"];
										if ($rowReq["total_item_checked"] > 0 AND $rowReq["total_item_checked"] == $rowReq["total_item_checklist"]) {
											$d_approved_by = $rowReq["max_portal_user"];
											$d_approved_date = $rowReq["max_date_updated"];
											$d_approved_date = new DateTime($d_approved_date);
											$d_approved_date = $d_approved_date->format('Y-m-d');
										}

										$d_file_date = $rowReq["d_file_date"];
										if (!empty($d_file_date)) {
											$d_file_date = new DateTime($d_file_date);
											$d_file_date_o = $d_file_date->format('Y/m/d');
											$d_file_date = $d_file_date->format('m/d/Y');
										}

										$d_file_due = $rowReq["d_file_due"];
										if (!empty($d_file_due)) {
											$d_file_due = new DateTime($d_file_due);
											$d_file_due_o = $d_file_due->format('Y/m/d');
											$d_file_due_o_nearly = date('Y/m/d', strtotime($d_file_due_o. ' - 30 days'));
											$d_file_due = $d_file_due->format('m/d/Y');
										}

										$s_ID = $rowReq["s_ID"];
										$s_file = $rowReq["s_file"];
										$s_filetype = $rowReq["s_filetype"];

										$i_ID = $rowReq["i_ID"];
										$i_file = $rowReq["i_file"];
										$i_filetype = $rowReq["i_filetype"];

										$t_ID = $rowReq["t_ID"];
										$t_file = $rowReq["t_file"];
										$t_filetype = $rowReq["t_filetype"];

										$mc = 0;
										$td_span++;
										$material_total++;
										$compliance_counter++;

										$td .= '<tr>
											<td>';
												$doc_stat = '';
												if (!empty($d_file_date) AND !empty($d_file_due)) {
													if ($d_file_date_o < $current_dateNow_o && $d_file_due_o < $current_dateNow_o) {
														$doc_stat = 'text-danger';
													} else {
														if ($d_file_date_o <= $current_dateNow_o && $d_file_due_o_nearly <= $current_dateNow_o) {
															$doc_stat = 'text-warning';
														}
													}
												}

												$td .= '<span class="'.$doc_stat.'">'.$r_name.'</span>
											</td>
											<td>'.$d_filename.'</td>
											<td>';
												
            									$selectComment = mysqli_query( $conn,"
            										SELECT
            										c.comment,
            										c.last_modified,
            										CASE WHEN e.user_id = c.user_id THEN u.name ELSE 'Compliance' END AS name
            										FROM tbl_supplier_comment AS c
            										
            										LEFT JOIN (
            											SELECT
            											ID,
            											employee_id,
            											CONCAT_WS(' ', first_name, last_name) AS name
            											FROM tbl_user
            										) AS u
            										ON u.ID = c.portal_user
            										
            										LEFT JOIN (
            											SELECT
            											ID,
            											user_id
            											FROM tbl_hr_employee
            										) AS e
            										ON e.ID = u.employee_id
            										
            										WHERE c.supplier_document_id = '".$d_ID."'
            									" );
            									if ( mysqli_num_rows($selectComment) > 0 ) {
            										$td .= '<ul style="padding-left: 1.5rem; margin: 0;">';
            											while($rowComment = mysqli_fetch_array($selectComment)) {
            												$comment_text = $rowComment["comment"];
            												$comment_user_name = $rowComment["name"];
            												
            												$comment_last_modified = $rowComment["last_modified"];
            												$comment_last_modified = new DateTime($comment_last_modified);
            												$comment_last_modified = $comment_last_modified->format('M d, Y');
            
            												$td .= '<li>
            													<b>'.$comment_user_name.'</b> | <i>'.$comment_last_modified.'</i><br>
            													'.$comment_text.'
            												</li>';
            											}
            										$td .= '</ul>';
            									}
												
											$td .= '</td>
											<td>'.$d_file_date.' - '.$d_file_due.'</td>
											<td>';
												$doc_com = $rowReq["checked_percentage"];
												if ($doc_com == 100) {
													$compliance_approved++;
												}
												$td .= $doc_com.'%
											</td>
										</tr>';
									}
								}
								
								if (!empty($material_document_other)) {
									$selectDocument = mysqli_query( $conn,"
										SELECT
										*
										FROM (
											WITH checklist AS (
												SELECT *
												FROM tbl_supplier_checklist
												WHERE deleted = 0
												  AND type = 1
												  AND user_id = $user_id
											),
											checked AS (
												SELECT *
												FROM tbl_supplier_checklist_checked
												WHERE deleted = 0
												  AND user_id = $user_id
											)
											SELECT
												d.ID AS d_ID,
												d.name AS d_name,
												d.file AS d_file,
												d.filetype AS d_filetype,
												d.filename AS d_filename,
												d.file_date AS d_file_date,
												d.file_due AS d_file_due,
												d.template AS d_template,
												d.comment AS d_comment,
												d.reviewed_by AS d_reviewed_by,
												d.reviewed_date AS d_reviewed_date,
												d.approved_by AS d_approved_by,
												d.approved_date AS d_approved_date,

												-- Checklist stats per requirement/document
												ROUND(
													CASE WHEN COUNT(COALESCE(c.checked, 0)) > 0 
														THEN (SUM(COALESCE(c.checked, 0)) / COUNT(COALESCE(c.checked, 0))) * 100 
														ELSE 0 END
												) AS checked_percentage,
												COUNT(DISTINCT cl.ID) AS total_item_checklist,
												SUM(CASE WHEN c.checked = 1 THEN 1 ELSE 0 END) AS total_item_checked,
												MIN(c.date_updated) AS min_date_updated,
												MAX(c.date_updated) AS max_date_updated,

												-- Min portal_user for the earliest check (MySQL-compatible)
												(
													SELECT c2.portal_user
													FROM checked c2
													INNER JOIN checklist cl2 ON cl2.ID = c2.checklist_id
													WHERE cl2.requirement_id = d.ID
													  AND c2.document_id = d.ID
													ORDER BY c2.date_updated ASC
													LIMIT 1
												) AS min_portal_user,

												-- Max portal_user for the latest check (MySQL-compatible)
												(
													SELECT c3.portal_user
													FROM checked c3
													INNER JOIN checklist cl3 ON cl3.ID = c3.checklist_id
													WHERE cl3.requirement_id = d.ID
													  AND c3.document_id = d.ID
													ORDER BY c3.date_updated DESC
													LIMIT 1
												) AS max_portal_user,

												s.ID AS s_ID,
												s.file AS s_file,
												s.filetype AS s_filetype,
												i.ID AS i_ID,
												i.file AS i_file,
												i.filetype AS i_filetype,
												t.ID AS t_ID,
												t.file AS t_file,
												t.filetype AS t_filetype

											FROM tbl_supplier_document AS d

											LEFT JOIN (
												SELECT *
												FROM tbl_supplier_checklist
												WHERE deleted = 0 AND user_id = $user_id
											) AS cl ON cl.requirement_id = d.ID

											LEFT JOIN (
												SELECT *
												FROM tbl_supplier_checklist_checked
												WHERE deleted = 0 AND user_id = $user_id
											) AS c ON c.checklist_id = cl.ID AND c.document_id = d.ID

											LEFT JOIN (
												SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id
											) AS s ON s.requirement_id = d.ID

											LEFT JOIN (
												SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id
											) AS i ON i.requirement_id = d.ID

											LEFT JOIN (
												SELECT * FROM tbl_supplier_template WHERE deleted = 0 AND user_id = $user_id
											) AS t ON t.requirement_id = d.ID

											WHERE d.archived = 0
												AND d.type = 1
												AND d.material_id = $material_ID
												AND FIND_IN_SET(
													REPLACE(d.name, ',', '*'),   -- normalize the key
													REPLACE(REPLACE('$material_document_other', ',', '*'), ' | ', ',')  -- normalize the list
												)

											GROUP BY d.ID
											ORDER BY d.name
										) o

										WHERE o.d_ID IS NOT NULL
										ORDER BY o.d_name
									" );
									if (mysqli_num_rows($selectDocument) > 0) {
										while ($rowReq = mysqli_fetch_array($selectDocument)) {
											$d_ID = $rowReq["d_ID"];
											$d_name = $rowReq["d_name"];
											$d_file = $rowReq["d_file"];
											$d_filetype = $rowReq["d_filetype"];
											$d_filename = $rowReq["d_filename"];
											$d_template = $rowReq["d_template"];
											$d_comment = $rowReq["d_comment"];
										
											$d_reviewed_by = $rowReq["d_reviewed_by"];
											$d_reviewed_date = $rowReq["d_reviewed_date"];
											if ($rowReq["total_item_checked"] > 0) {
												$d_reviewed_by = $rowReq["min_portal_user"];
												$d_reviewed_date = $rowReq["min_date_updated"];
												$d_reviewed_date = new DateTime($d_reviewed_date);
												$d_reviewed_date = $d_reviewed_date->format('Y-m-d');
											}

											$d_approved_by = $rowReq["d_approved_by"];
											$d_approved_date = $rowReq["d_approved_date"];
											if ($rowReq["total_item_checked"] > 0 AND $rowReq["total_item_checked"] == $rowReq["total_item_checklist"]) {
												$d_approved_by = $rowReq["max_portal_user"];
												$d_approved_date = $rowReq["max_date_updated"];
												$d_approved_date = new DateTime($d_approved_date);
												$d_approved_date = $d_approved_date->format('Y-m-d');
											}

											$d_file_date = $rowReq["d_file_date"];
											if (!empty($d_file_date)) {
												$d_file_date = new DateTime($d_file_date);
												$d_file_date_o = $d_file_date->format('Y/m/d');
												$d_file_date = $d_file_date->format('m/d/Y');
											}

											$d_file_due = $rowReq["d_file_due"];
											if (!empty($d_file_due)) {
												$d_file_due = new DateTime($d_file_due);
												$d_file_due_o = $d_file_due->format('Y/m/d');
												$d_file_due_o_nearly = date('Y/m/d', strtotime($d_file_due_o. ' - 30 days'));
												$d_file_due = $d_file_due->format('m/d/Y');
											}

											$s_ID = $rowReq["s_ID"];
											$s_file = $rowReq["s_file"];
											$s_filetype = $rowReq["s_filetype"];

											$i_ID = $rowReq["i_ID"];
											$i_file = $rowReq["i_file"];
											$i_filetype = $rowReq["i_filetype"];

											$t_ID = $rowReq["t_ID"];
											$t_file = $rowReq["t_file"];
											$t_filetype = $rowReq["t_filetype"];

											$mc = 0;
											$td_span++;
											$material_total++;
											$compliance_counter_other++;
											
											$td .= '<tr>
												<td>';

													$d_stat = '';
													if (!empty($d_file_date) AND !empty($d_file_due)) {
														if ($d_file_date_o < $current_dateNow_o && $d_file_due_o < $current_dateNow_o) {
															$d_stat = 'text-danger';
														} else {
															if ($d_file_date_o <= $current_dateNow_o && $d_file_due_o_nearly <= $current_dateNow_o) {
																$d_stat = 'text-warning';
															}
														}
													}

													$td .= '<span class="'.$d_stat.'">'.$d_name.'</span>
												</td>
												<td>'.$d_filename.'</td>
												<td>';
														
													$val_comment = '';
													if (isset($value['comment']) AND !empty($value['comment'])) {
														$val_comment = $value['comment'];
														$selecMaterialComment = mysqli_query( $conn,"
															SELECT
															c.ID,
															CASE WHEN e.user_id = c.user_id THEN u.name ELSE 'Compliance' END AS name,
															c.date_added,
															c.comment
															FROM tbl_supplier_material_comment AS c
				
															LEFT JOIN (
																SELECT
																ID,
																CONCAT_WS(' ', first_name, last_name) AS name,
																employee_id
																FROM tbl_user
															) AS u
															ON u.ID = c.portal_user
				
															LEFT JOIN (
																SELECT
																ID,
																user_id
																FROM tbl_hr_employee
															) AS e
															ON e.ID = u.employee_id
				
															WHERE c.deleted = 0
															AND c.user_id = $user_id
															AND FIND_IN_SET(c.ID, REPLACE('$val_comment' , ' ', ''))
														" );
														if ( mysqli_num_rows($selecMaterialComment) > 0 ) {
															$td .= '<ul style="padding-left: 1.5rem; margin: 0;">';
																while($rowMaterialComment = mysqli_fetch_array($selecMaterialComment)) {
																	$td .= '<li>
																		<b>'.$rowMaterialComment["name"].'</b> | <small>'.$rowMaterialComment["date_added"].'</small><br>
																		'.htmlentities($rowMaterialComment["comment"] ?? '').'
																	</li>';
																}
															$td .= '</ul>';
														}
													}
													
												$td .= '</td>
												<td>'.$d_file_date.' - '.$d_file_due.'</td>
												<td>';
													$doc_com = $rowReq["checked_percentage"];
													if ($doc_com == 100) {
														$compliance_approved_other++;
													}

													$td .= $doc_com.'%
												</td>
											</tr>';
										}
									}
								}
								
								$compliance_approved += $compliance_approved_other;
								$compliance_counter += $compliance_counter_other;
								if ($compliance_approved > 0) {
									$compliance = ($compliance_approved / $compliance_counter) * 100;
								}
								
								$material .= '<tr>
									<td rowspan="'.$td_span.'">'.$material_name.'</td>
									<td rowspan="'.$td_span.'">'.$material_description.'</td>
									'.$td.'
								</tr>
								<tr>
									<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
									<td><strong>'.round($compliance).'%</strong></td>
								</tr>';

								$material_tr .= '<tr>
									<td>'.$material_name.'</td>
									<td>'.round($compliance).'%</td>
								</tr>';
							}
						}
						
					$material .= '</table>';
				}
				
				if (!empty($row["record"])) {
					$record .= '<br><table width="100%" cellpadding="7" cellspacing="0" border="1">
						<tr class="bg-tbl-gray">
							<td colspan="7"><strong>RECORD</strong></td>
						</tr>
						<tr>
							<td><strong>Requirement</strong></td>
							<td style="width: 140px;"><strong>Document</strong></td>
							<td style="width: 200px;"><strong>Validity Period</strong></td>
						</tr>';
						
						$record_arr = $row["record"];
						$selectRecord = mysqli_query( $conn,"
							SELECT 
							r.ID AS r_ID,
							r.title AS r_title,
							r.description AS r_description,
							r.remark AS r_remark,
							r.requirement AS r_requirement,
							f.type AS f_type,
							f.name AS f_name,
							r.file_date AS f_date,
							r.file_date_due AS f_date_due,
							f.date_added AS f_uploaded
							FROM tbl_supplier_record AS r

							LEFT JOIN (
								SELECT
								*
								FROM tbl_file
							) As f
							ON f.ID = r.file_id

							WHERE r.deleted = 0
							AND FIND_IN_SET(r.ID, REPLACE(REPLACE('$record_arr', ' ', ''), '|',','))
						" );
						if ( mysqli_num_rows($selectRecord) > 0 ) {
							while($rowRecord = mysqli_fetch_array($selectRecord)) {
								$r_ID = $rowRecord["r_ID"];
								$r_requirement = $rowRecord["r_requirement"];
								
								$files = $rowRecord["f_name"];
								$filetype = $rowRecord["f_type"];
								$type = 'iframe';
								if (!empty($files)) {
									if ($filetype == 1) {
										$fileExtension = fileExtension($files);
										$src = $fileExtension['src'];
										$embed = $fileExtension['embed'];
										$type = $fileExtension['type'];
										$file_extension = $fileExtension['file_extension'];
										$url = $base_url.'uploads/supplier/';

										$files = $src.$url.rawurlencode($files).$embed;
									} else if ($filetype == 3) {
										$files = preg_replace('#[^/]*$#', '', $files).'preview';
									}
									$files = '<p style="margin: 0;"><a href="'.$files.'" target="_blank">View</a></p>';
								}

								$file_date = $rowRecord['f_date'];
								$file_date_due = $rowRecord['f_date_due'];
								
								$file_expiry = 'N/A';
								if (!empty($file_date_due)){
    								// $expirationDateString = '2025-08-01';
    
                                    // Create DateTime objects for the expiration date and the current date
                                    $expirationDate = new DateTime($file_date_due);
                                    $currentDate = new DateTime(); // Defaults to the current date and time
                                    
                                    // Compare the dates
                                    if ($expirationDate < $currentDate) {
                                        $file_expiry = 'Expired';
                                    } elseif ($expirationDate > $currentDate) {
                                        $file_expiry = 'Active';
                                    } else {
                                        $file_expiry = 'Today';
                                    }
								}

								$requirement_type = array(
									0 => '',
									1 => 'Facility',
									2 => 'Material'
								);

								$record .= '<tr>
									<td>'.$rowRecord["r_title"].'</td>
									<td>'.$files.'</td>
									<td>'.$file_date.' - '.$file_date_due.'</td>
								</tr>';
							}
						}
						
					$record .= '</table>';
				}
				
				$facility .= '<br><table width="100%" cellpadding="7" cellspacing="0" border="1">
					<tr class="bg-tbl-gray">
						<td colspan="5"><strong>FACILITY</strong></td>
					</tr>
					<tr>
						<td style="width: 25%;"><strong>Requirements</strong></td>
						<td><strong>Documents</strong></td>
						<td style="width: 300px;"><strong>Comment</strong></td>
						<td style="width: 180px;"><strong>Validity Period</strong></td>
						<td style="width: 105px;"><strong>Status</strong></td>
					</tr>';

					$sql_supplier = '';
					$checked = '';
					$tblOther = 0;
					$default_list = '';
					$fsvp_list = '';
					$sql_req = ' * ';
					$international = ' ';

					$data_new = '';
					$compliance = 0;
					$compliance_counter = 0;
					$compliance_approved = 0;

					$data_new_other = '';
					$compliance_other = 0;
					$compliance_counter_other = 0;
					$compliance_approved_other = 0;

					$checked = 'CHECKED';
					if ($user_id == 1211 OR $user_id == 1486 OR $user_id == 1774 OR $user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) { $tblOther = 1; }
					// if ($address_arr[0] != $c) { $international = ' OR r.facility = -1 '; }
					$international = ' OR r.facility = -1 ';
					
					$compliance = 0;
					$compliance_counter = 0;
					$compliance_approved = 0;
	
					if (!empty($document)) {
						$selectRequirement = mysqli_query( $conn,"
							SELECT
							*
							FROM (
								WITH checklist AS (
									SELECT *
									FROM tbl_supplier_checklist
									WHERE deleted = 0
									  AND type = 0
									  AND user_id = $user_id
								),
								checked AS (
									SELECT *
									FROM tbl_supplier_checklist_checked
									WHERE deleted = 0
									  AND user_id = $user_id
								)
								SELECT
									r.ID AS r_ID,
									r.international AS r_international,
									r.facility AS r_facility,
									r.name AS r_name,
									CASE WHEN FIND_IN_SET(r.ID, REPLACE(REPLACE('$document', ' ', ''), '|',',')) THEN 1 ELSE 0 END AS r_checked,

									d.ID AS d_ID,
									d.file AS d_file,
									d.filetype AS d_filetype,
									d.filename AS d_filename,
									d.file_date AS d_file_date,
									d.file_due AS d_file_due,
									d.template AS d_template,
									d.comment AS d_comment,
									d.reviewed_by AS d_reviewed_by,
									d.reviewed_date AS d_reviewed_date,
									d.approved_by AS d_approved_by,
									d.approved_date AS d_approved_date,

									-- Checklist stats per requirement/document
									ROUND(
										CASE WHEN COUNT(COALESCE(c.checked, 0)) > 0 
											THEN (SUM(COALESCE(c.checked, 0)) / COUNT(COALESCE(c.checked, 0))) * 100 
											ELSE 0 END
									) AS checked_percentage,
									COUNT(DISTINCT cl.ID) AS total_item_checklist,
									SUM(CASE WHEN c.checked = 1 THEN 1 ELSE 0 END) AS total_item_checked,
									MIN(c.date_updated) AS min_date_updated,
									MAX(c.date_updated) AS max_date_updated,

									-- Min portal_user for the earliest check (MySQL-compatible)
									(
										SELECT c2.portal_user
										FROM checked c2
										INNER JOIN checklist cl2 ON cl2.ID = c2.checklist_id
										WHERE cl2.requirement_id = r.ID
										  AND c2.document_id = d.ID
										ORDER BY c2.date_updated ASC
										LIMIT 1
									) AS min_portal_user,

									-- Max portal_user for the latest check (MySQL-compatible)
									(
										SELECT c3.portal_user
										FROM checked c3
										INNER JOIN checklist cl3 ON cl3.ID = c3.checklist_id
										WHERE cl3.requirement_id = r.ID
										  AND c3.document_id = d.ID
										ORDER BY c3.date_updated DESC
										LIMIT 1
									) AS max_portal_user,

									s.ID AS s_ID,
									s.file AS s_file,
									s.filetype AS s_filetype,
									i.ID AS i_ID,
									i.file AS i_file,
									i.filetype AS i_filetype,
									t.ID AS t_ID,
									t.file AS t_file,
									t.filetype AS t_filetype

								FROM tbl_supplier_requirement AS r

								LEFT JOIN (
									SELECT *
									FROM tbl_supplier_document
									WHERE archived = 0 AND type = 0 AND user_id = $user_id AND supplier_id = $ID
								) AS d ON d.name = r.ID

								LEFT JOIN (
									SELECT *
									FROM tbl_supplier_checklist
									WHERE deleted = 0 AND user_id = $user_id
								) AS cl ON cl.requirement_id = r.ID

								LEFT JOIN (
									SELECT *
									FROM tbl_supplier_checklist_checked
									WHERE deleted = 0 AND user_id = $user_id
								) AS c ON c.checklist_id = cl.ID AND c.document_id = d.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id
								) AS s ON s.requirement_id = r.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id
								) AS i ON i.requirement_id = r.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_template WHERE deleted = 0 AND user_id = $user_id
								) AS t ON t.requirement_id = r.ID

								WHERE r.deleted = 0 
									AND r.organic = 0 
									AND (FIND_IN_SET($user_id, REPLACE(REPLACE(r.facility, ' ', ''), '|',',')) OR r.facility = 0 $international)

								GROUP BY r.name
								ORDER BY r.name
							) o
							WHERE o.r_checked = 1
						" );
						while($rowReq = mysqli_fetch_array($selectRequirement)) {
							$r_ID = $rowReq["r_ID"];
							$r_international = $rowReq["r_international"];
							$r_facility = $rowReq["r_facility"];
							$r_checked = $rowReq["r_checked"];

							$r_name = htmlentities($rowReq["r_name"] ?? '');
							if ($r_ID == 118 and $user_id == 1738) {
								$r_name = 'Traceability System';
							}
			
							if ($user_id == 1774) {
								if ($r_ID == 3 OR $r_ID == 4) {
									$r_name = htmlentities($rowReq["r_name"] ?? '').' (Signed Copy from Suwerte)';
								}
								if ($r_ID == 181 OR $r_ID == 33) {
									$r_name = htmlentities($rowReq["r_name"] ?? '').' (if applicable)';
								}
								if ($r_ID == 16) {
									$r_name = 'U.S. FDA Bioterrorism Registration Affidavit/ U.S. FDA Food Facility Registration';
								}
								if ($r_ID == 115 OR $r_ID == 18 OR $r_ID == 20 OR $r_ID == 71 OR $r_ID == 72 OR $r_ID == 75 OR $r_ID == 102 OR $r_ID == 193 OR $r_ID == 191 OR $r_ID == 192 OR $r_ID == 24) {
									$r_name = 'FSVP QI - '.htmlentities($rowReq["r_name"] ?? '');
								}
								if ($r_ID == 156) {
									$r_name = htmlentities($rowReq["r_name"] ?? '').' - from Suwerte\'s forwarder';
								}
							}

							$d_ID = $rowReq["d_ID"];
							$d_file = $rowReq["d_file"];
							$d_filetype = $rowReq["d_filetype"];
							$d_filename = $rowReq["d_filename"];
							$d_template = $rowReq["d_template"];
							$d_comment = $rowReq["d_comment"];

							$d_reviewed_by = $rowReq["d_reviewed_by"];
							$d_reviewed_date = $rowReq["d_reviewed_date"];
							if ($rowReq["total_item_checked"] > 0) {
								$d_reviewed_by = $rowReq["min_portal_user"];
								$d_reviewed_date = $rowReq["min_date_updated"];
								$d_reviewed_date = new DateTime($d_reviewed_date);
								$d_reviewed_date = $d_reviewed_date->format('Y-m-d');
							}
							$d_approved_by = $rowReq["d_approved_by"];
							$d_approved_date = $rowReq["d_approved_date"];
							if ($rowReq["total_item_checked"] > 0 AND $rowReq["total_item_checked"] == $rowReq["total_item_checklist"]) {
								$d_approved_by = $rowReq["max_portal_user"];
								$d_approved_date = $rowReq["max_date_updated"];
								$d_approved_date = new DateTime($d_approved_date);
								$d_approved_date = $d_approved_date->format('Y-m-d');
							}

							$d_file_date = $rowReq["d_file_date"];
							if (!empty($d_file_date)) {
								$d_file_date = new DateTime($d_file_date);
								$d_file_date_o = $d_file_date->format('Y/m/d');
								$d_file_date = $d_file_date->format('m/d/Y');
							}

							$d_file_due = $rowReq["d_file_due"];
							if (!empty($d_file_due)) {
								$d_file_due = new DateTime($d_file_due);
								$d_file_due_o = $d_file_due->format('Y/m/d');
								$d_file_due_o_nearly = date('Y/m/d', strtotime($d_file_due_o. ' - 30 days'));
								$d_file_due = $d_file_due->format('m/d/Y');
							}

							$s_ID = $rowReq["s_ID"];
							$s_file = $rowReq["s_file"];
							$s_filetype = $rowReq["s_filetype"];

							$i_ID = $rowReq["i_ID"];
							$i_file = $rowReq["i_file"];
							$i_filetype = $rowReq["i_filetype"];

							$t_ID = $rowReq["t_ID"];
							$t_file = $rowReq["t_file"];
							$t_filetype = $rowReq["t_filetype"];
							
							$compliance_counter++;

							$data_new .= '<tr>
								<td>';
									$doc_stat = '';
									if (!empty($d_file_date) AND !empty($d_file_due)) {
										if ($d_file_date_o < $current_dateNow_o && $d_file_due_o < $current_dateNow_o) {
											$doc_stat = 'text-danger';
										} else {
											if ($d_file_date_o <= $current_dateNow_o && $d_file_due_o_nearly <= $current_dateNow_o) {
												$doc_stat = 'text-warning';
											}
										}
									}
	
									$data_new .= '<span class="'.$doc_stat.'">'.$r_name.'</span>
								</td>
								<td>'.$d_filename.'</td>
								<td>';
								
									$selectComment = mysqli_query( $conn,"
										SELECT
										c.comment,
										c.last_modified,
										CASE WHEN e.user_id = c.user_id THEN u.name ELSE 'Compliance' END AS name
										FROM tbl_supplier_comment AS c
										
										LEFT JOIN (
											SELECT
											ID,
											employee_id,
											CONCAT_WS(' ', first_name, last_name) AS name
											FROM tbl_user
										) AS u
										ON u.ID = c.portal_user
										
										LEFT JOIN (
											SELECT
											ID,
											user_id
											FROM tbl_hr_employee
										) AS e
										ON e.ID = u.employee_id
										
										WHERE c.supplier_document_id = '".$d_ID."'
									" );
									if ( mysqli_num_rows($selectComment) > 0 ) {
										$data_new .= '<ul style="padding-left: 1.5rem; margin: 0;">';
											while($rowComment = mysqli_fetch_array($selectComment)) {
												$comment_text = $rowComment["comment"];
												$comment_user_name = $rowComment["name"];
												
												$comment_last_modified = $rowComment["last_modified"];
												$comment_last_modified = new DateTime($comment_last_modified);
												$comment_last_modified = $comment_last_modified->format('M d, Y');

												$data_new .= '<li>
													<b>'.$comment_user_name.'</b> | <i>'.$comment_last_modified.'</i><br>
													'.$comment_text.'
												</li>';
											}
										$data_new .= '</ul>';
									}
								
								$data_new .= '</td>
								<td>'.$d_file_date.' - '.$d_file_due.'</td>
								<td>';
									$doc_com = $rowReq["checked_percentage"];
									if ($doc_com == 100) {
										$compliance_approved++;
									}
									$data_new .= $doc_com.'%
								</td>
							</tr>';
						}
					}

					if (!empty($document_other)) {
						$selectDocument = mysqli_query( $conn,"
							SELECT
							*
							FROM (
								WITH checklist AS (
									SELECT *
									FROM tbl_supplier_checklist
									WHERE deleted = 0
									  AND type = 1
									  AND user_id = $user_id
								),
								checked AS (
									SELECT *
									FROM tbl_supplier_checklist_checked
									WHERE deleted = 0
									  AND user_id = $user_id
								)
								SELECT
									d.ID AS d_ID,
									d.name AS d_name,
									d.file AS d_file,
									d.filetype AS d_filetype,
									d.filename AS d_filename,
									d.file_date AS d_file_date,
									d.file_due AS d_file_due,
									d.template AS d_template,
									d.comment AS d_comment,
									d.reviewed_by AS d_reviewed_by,
									d.reviewed_date AS d_reviewed_date,
									d.approved_by AS d_approved_by,
									d.approved_date AS d_approved_date,

									-- Checklist stats per requirement/document
									ROUND(
										CASE WHEN COUNT(COALESCE(c.checked, 0)) > 0 
											THEN (SUM(COALESCE(c.checked, 0)) / COUNT(COALESCE(c.checked, 0))) * 100 
											ELSE 0 END
									) AS checked_percentage,
									COUNT(DISTINCT cl.ID) AS total_item_checklist,
									SUM(CASE WHEN c.checked = 1 THEN 1 ELSE 0 END) AS total_item_checked,
									MIN(c.date_updated) AS min_date_updated,
									MAX(c.date_updated) AS max_date_updated,

									-- Min portal_user for the earliest check (MySQL-compatible)
									(
										SELECT c2.portal_user
										FROM checked c2
										INNER JOIN checklist cl2 ON cl2.ID = c2.checklist_id
										WHERE cl2.requirement_id = d.ID
										  AND c2.document_id = d.ID
										ORDER BY c2.date_updated ASC
										LIMIT 1
									) AS min_portal_user,

									-- Max portal_user for the latest check (MySQL-compatible)
									(
										SELECT c3.portal_user
										FROM checked c3
										INNER JOIN checklist cl3 ON cl3.ID = c3.checklist_id
										WHERE cl3.requirement_id = d.ID
										  AND c3.document_id = d.ID
										ORDER BY c3.date_updated DESC
										LIMIT 1
									) AS max_portal_user,

									s.ID AS s_ID,
									s.file AS s_file,
									s.filetype AS s_filetype,
									i.ID AS i_ID,
									i.file AS i_file,
									i.filetype AS i_filetype,
									t.ID AS t_ID,
									t.file AS t_file,
									t.filetype AS t_filetype

								FROM tbl_supplier_document AS d

								LEFT JOIN (
									SELECT *
									FROM tbl_supplier_checklist
									WHERE deleted = 0 AND user_id = $user_id
								) AS cl ON cl.requirement_id = d.ID

								LEFT JOIN (
									SELECT *
									FROM tbl_supplier_checklist_checked
									WHERE deleted = 0 AND user_id = $user_id
								) AS c ON c.checklist_id = cl.ID AND c.document_id = d.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id
								) AS s ON s.requirement_id = d.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id
								) AS i ON i.requirement_id = d.ID

								LEFT JOIN (
									SELECT * FROM tbl_supplier_template WHERE deleted = 0 AND user_id = $user_id
								) AS t ON t.requirement_id = d.ID

								WHERE d.archived = 0
									AND d.type = 1
									AND d.supplier_id = $ID
									AND FIND_IN_SET(
										REPLACE(d.name, ',', '*'),   -- normalize the key
										REPLACE(REPLACE('$document_other', ',', '*'), ' | ', ',')  -- normalize the list
									)

								GROUP BY d.ID
								ORDER BY d.name
							) o

							WHERE o.d_ID IS NOT NULL
						" );
						if ( mysqli_num_rows($selectDocument) > 0 ) {
							while ($rowReq = mysqli_fetch_array($selectDocument)) {
								$d_ID = $rowReq["d_ID"];
								$d_name = $rowReq["d_name"];
								$d_file = $rowReq["d_file"];
								$d_filetype = $rowReq["d_filetype"];
								$d_filename = $rowReq["d_filename"];
								$d_template = $rowReq["d_template"];
								$d_comment = $rowReq["d_comment"];
							
								$d_reviewed_by = $rowReq["d_reviewed_by"];
								$d_reviewed_date = $rowReq["d_reviewed_date"];
								if ($rowReq["total_item_checked"] > 0) {
									$d_reviewed_by = $rowReq["min_portal_user"];
									$d_reviewed_date = $rowReq["min_date_updated"];
									$d_reviewed_date = new DateTime($d_reviewed_date);
									$d_reviewed_date = $d_reviewed_date->format('Y-m-d');
								}

								$d_approved_by = $rowReq["d_approved_by"];
								$d_approved_date = $rowReq["d_approved_date"];
								if ($rowReq["total_item_checked"] > 0 AND $rowReq["total_item_checked"] == $rowReq["total_item_checklist"]) {
									$d_approved_by = $rowReq["max_portal_user"];
									$d_approved_date = $rowReq["max_date_updated"];
									$d_approved_date = new DateTime($d_approved_date);
									$d_approved_date = $d_approved_date->format('Y-m-d');
								}

								$d_file_date = $rowReq["d_file_date"];
								if (!empty($d_file_date)) {
									$d_file_date = new DateTime($d_file_date);
									$d_file_date_o = $d_file_date->format('Y/m/d');
									$d_file_date = $d_file_date->format('m/d/Y');
								}

								$d_file_due = $rowReq["d_file_due"];
								if (!empty($d_file_due)) {
									$d_file_due = new DateTime($d_file_due);
									$d_file_due_o = $d_file_due->format('Y/m/d');
									$d_file_due_o_nearly = date('Y/m/d', strtotime($d_file_due_o. ' - 30 days'));
									$d_file_due = $d_file_due->format('m/d/Y');
								}

								$s_ID = $rowReq["s_ID"];
								$s_file = $rowReq["s_file"];
								$s_filetype = $rowReq["s_filetype"];

								$i_ID = $rowReq["i_ID"];
								$i_file = $rowReq["i_file"];
								$i_filetype = $rowReq["i_filetype"];

								$t_ID = $rowReq["t_ID"];
								$t_file = $rowReq["t_file"];
								$t_filetype = $rowReq["t_filetype"];

								$compliance_counter_other++;

								$data_new_other .= '<tr>
									<td>';

										$d_stat = '';
										if (!empty($d_file_date) AND !empty($d_file_due)) {
											if ($d_file_date_o < $current_dateNow_o && $d_file_due_o < $current_dateNow_o) {
												$d_stat = 'text-danger';
											} else {
												if ($d_file_date_o <= $current_dateNow_o && $d_file_due_o_nearly <= $current_dateNow_o) {
													$d_stat = 'text-warning';
												}
											}
										}

										$data_new_other .= '<span class="'.$d_stat.'">'.$d_name.'</span>
									</td>
									<td>'.$d_filename.'</td>
									<td>';
										
										$selectComment = mysqli_query( $conn,"
											SELECT
											c.comment,
											c.last_modified,
											CASE WHEN e.user_id = c.user_id THEN u.name ELSE 'Compliance' END AS name
											FROM tbl_supplier_comment AS c
											
											LEFT JOIN (
												SELECT
												ID,
												employee_id,
												CONCAT_WS(' ', first_name, last_name) AS name
												FROM tbl_user
											) AS u
											ON u.ID = c.portal_user
											
											LEFT JOIN (
												SELECT
												ID,
												user_id
												FROM tbl_hr_employee
											) AS e
											ON e.ID = u.employee_id
											
											WHERE c.supplier_document_id = '".$d_ID."'
										" );
										if ( mysqli_num_rows($selectComment) > 0 ) {
											$data_new_other .= '<ul style="padding-left: 1.5rem; margin: 0;">';
												while($rowComment = mysqli_fetch_array($selectComment)) {
													$comment_text = $rowComment["comment"];
													$comment_user_name = $rowComment["name"];
													
													$comment_last_modified = $rowComment["last_modified"];
													$comment_last_modified = new DateTime($comment_last_modified);
													$comment_last_modified = $comment_last_modified->format('M d, Y');

													$data_new_other .= '<li>
														<b>'.$comment_user_name.'</b> | <i>'.$comment_last_modified.'</i><br>
														'.$comment_text.'
													</li>';
												}
											$data_new_other .= '</ul>';
										}
										
									$data_new_other .= '</td>
									<td>'.$d_file_date.' - '.$d_file_due.'</td>
									<td>';

										$doc_com = $rowReq["checked_percentage"];
										if ($doc_com == 100) {
											$compliance_approved_other++;
										}

										$data_new_other .= $doc_com.'%
									</td>
								</tr>';
							}
						}
					}
	
					$facility .= $data_new;
					if ($user_id != 1211 AND $user_id != 1486 AND $user_id != 1774 AND $user_id != 1832 AND $user_id != 1773 AND $user_id != 1850) {
						$compliance_approved += $compliance_approved_other;
						$compliance_counter += $compliance_counter_other;
						$facility . $data_new_other;
					}

					if ($compliance_approved > 0) {
						$compliance = ($compliance_approved / $compliance_counter) * 100;
						$facility_main = $compliance;
					}
					
					$facility .= '<tr>
						<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
						<td><strong>'.round($compliance).'%</strong></td>
					</tr>
				</table>';
				
				if ($user_id == 1211 OR $user_id == 1486 OR $user_id == 1774 OR $user_id == 1832 OR $user_id == 1773) {
					$facility .= '<br><table width="100%" cellpadding="7" cellspacing="0" border="1">
						<tr class="bg-tbl-gray">
							<td colspan="5"><strong>OTHER REQUIREMENTS</strong></td>
						</tr>
						<tr>
							<td style="width: 25%;"><strong>Requirements</strong></td>
							<td><strong>Documents</strong></td>
							<td style="width: 300px;"><strong>Comment</strong></td>
							<td style="width: 180px;"><strong>Validity Period</strong></td>
							<td style="width: 105px;"><strong>Status</strong></td>
						</tr>'.$data_new_other;
	
						if ($compliance_counter_other > 0) {
							$compliance_other = ($compliance_approved_other / $compliance_counter_other) * 100;
							$facility_other = $compliance_other;
						}
	
						$facility .= '<tr>
							<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
							<td><strong>'.round($compliance_other).'%</strong></td>
						</tr>
					</table>';
				}
				
				$html .= '<br><table width="100%" cellpadding="7" cellspacing="0" border="1">
					<tr class="bg-tbl-gray">
						<td><strong>COMPLIANCE SUMMARY</strong></td>
						<td style="width: 105px;"><strong>Compliance %</strong></td>
					</tr>
					<tr>
						<td colspan="2"><strong>Facility Requirements</strong></td>
					</tr>
					<tr>
						<td>Main</td>
						<td>'.round($facility_main).'%</td>
					</tr>
					<tr>
						<td>Other</td>
						<td>'.round($facility_other).'%</td>
					</tr>';

					if (!empty($material)) {
					    if ($user_id == 1984 OR $user_id == 1986) {
    						$html .= '<tr>
    							<td colspan="2"><strong>Shipment Requirements</strong></td>
    						</tr>';
					    } else {
    						$html .= '<tr>
    							<td colspan="2"><strong>Material Requirements</strong></td>
    						</tr>';
					    }

						$html .= $material_tr;
					}
				$html .= '</table>';
				$html .= $facility;
				$html .= $material;
				$html .= $record;
			}
		$html .= '</body>
	</html>';
	

	// $mpdf->SetHTMLHeader('
	// <table width="100%" cellpadding="7" cellspacing="0" border="0">
	//     <tr>
	//         <td width="50%" style="border: 0;">'.$l_name.' Requirements</td>
	//         <td width="50%" style="border: 0; text-align: right;">Date: '.date('F j, Y').'</td>
	//     </tr>
	// </table>');
	// $mpdf->SetHTMLFooter('<div style="text-align: right;">{PAGENO}</div>');
	// $mpdf->AddPageByArray([
	//     'margin-top' => '30px'
	// ]);
	
	echo $html;
	
	// $mpdf->WriteHTML($html);
	// $mpdf->Output();
	
	// $title = htmlentities($topic ?? '').' - '.date('mdy');
	// $mpdf->SetDisplayMode('fullpage');
	// $mpdf->WriteHTML($html);
	// $mpdf->Output($title.'.pdf', 'I');
	
?>