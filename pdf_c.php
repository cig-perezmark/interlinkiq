<?php
    include_once ('database_iiq.php');
    
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
    function fileExtension($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        $type = 'iframe';
    	if (strtolower($extension) == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
		else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
		else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
		else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
		else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
		else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
		else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

		$output['src'] = $src;
	    $output['embed'] = $embed;
	    $output['type'] = $type;
	    $output['file_extension'] = $file_extension;
	    $output['file_mime'] = $extension;
	    return $output;
    }

    $ID = $_GET['id'];
    $type = $_GET['t'];
    $html = '';
    $base_url = 'https://interlinkiq.com/';

    //============================================================+
    // File name   : example_006.php
    // Begin       : 2008-03-04
    // Last Update : 2013-05-14
    //
    // Description : Example 006 for TCPDF class
    //               WriteHTML and RTL support
    //
    // Author: Nicola Asuni
    //
    // (c) Copyright:
    //               Nicola Asuni
    //               Tecnick.com LTD
    //               www.tecnick.com
    //               info@tecnick.com
    //============================================================+

    /**
     * Creates an example PDF TEST document using TCPDF
     * @package com.tecnick.tcpdf
     * @abstract TCPDF - Example: WriteHTML and RTL support
     * @author Nicola Asuni
     * @since 2008-03-04
     */

    // Include the main TCPDF library (search for installation path).
    require_once('TCPDF/tcpdf.php');

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('InterlinkIQ.com');
    $pdf->SetTitle('InterlinkIQ.com');
    $pdf->SetSubject('InterlinkIQ.com');
    $pdf->SetKeywords('InterlinkIQ.com');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // // set header and footer fonts
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setHeaderMargin(0);
    // $pdf->setMargins(0, 0, 0, true);
    // $pdf->setPageOrientation('', false, 0);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 9);

    // add a page
    $pdf->AddPage();

	if ($type == 1) {
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE ID = $ID" );
    } else {
    	$selectData = mysqli_query( $conn,"SELECT * FROM tbl_complaint_records WHERE care_id = $ID" );
    }
    if ( mysqli_num_rows($selectData) > 0 ) {
		$row = mysqli_fetch_array($selectData);

		$corrective_status = $row['corrective_status'];
		$implementation_status = $row['implementation_status'];
		$preventive_status = $row['preventive_status'];
		$evaluation_status = $row['evaluation_status'];
		$status_array = array(
			0 => 'N/A',
			1 => 'Proposed',
			2 => 'Implemented',
		);

		$user_client = 0;
		$user_id = employerID($row['portal_user']);
		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
		if ( mysqli_num_rows($selectUser) > 0 ) {
			$rowUser = mysqli_fetch_array($selectUser);
			$user_client = $rowUser['client'];
		}

		$html .= '<html>
			<head>
				<title>PDF</title>
				<style>
					table {
						table-layout: fixed;
						width: 100%;
						border-collapse: collapse;
					}
					table tr:first-child {
						background-color: #e1e5ec;
					}
					td {
						vertical-align: top;
						word-wrap: break-word;
  						overflow-wrap: break-word;
					}
				</style>
			</head>
			<body>
				<h3 style="text-align: center;">Corrective Action Management</h3>
				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td><b>Date of Issue</b></td>
						<td><b>Time of Issue</b></td>
						<td><b>Observed By</b></td>
						<td><b>Reported By</b></td>';

						if ($user_client == 0) {
							$html .= '<td><b>CAPA Reference No.</b></td>';
						}
						
					$html .= '</tr>
					<tr>
						<td>'; $html .= $type == 1 ? $row['date']:date('Y-m-d', strtotime($row['care_date'])); $html .= '</td>
						<td>'.$row['time'].'</td>
						<td>'.htmlentities($row['observed_by']).'</td>
						<td>'.htmlentities($row['reported_by']).'</td>';

						if ($user_client == 0) {
							$html .= '<td>'.htmlentities($row['reference']).'</td>';
						}
						
					$html .= '</tr>
				</table>

				<p></p>';

				if ($user_client == 1) {
					$html .= '<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
						<tr>
							<td style="width: 50%;"><b>Program</b></td>
							<td style="width: 50%;"><b>Category</b></td>
						</tr>
						<tr>
							<td>
								<ol>';
									$selectProgram = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE type = 1 AND deleted = 0 AND user_id = $user_id AND FIND_IN_SET(ID, REPLACE('".$row['program_id']."', ' ', '')  ) > 0 ORDER BY name" );
		                            if ( mysqli_num_rows($selectProgram) > 0 ) {
		                                while ($rowProg = mysqli_fetch_array($selectProgram)) {
		                                	$html .= '<li>'.htmlentities($rowProg['name']).'</li>';
		                                }
		                            }
								$html .= '</ol>
							</td>
							<td>
								<ol>';
									if ($type == 1) {
										$selectComplaint = mysqli_query( $conn,"SELECT * FROM tbl_cam_complaint_category WHERE deleted = 0 AND FIND_IN_SET(ID, REPLACE('".$row['complaint_id']."', ' ', '')  ) > 0 ORDER BY name" );
			                            if ( mysqli_num_rows($selectComplaint) > 0 ) {
			                                while ($rowComp = mysqli_fetch_array($selectComplaint)) {
			                                	$html .= '<li>'.htmlentities($rowComp['name']).'</li>';
			                                }
			                            }
									} else {
										if (is_numeric($row['complaint_category'])) {
											$selectComplaint = mysqli_query( $conn,"SELECT * FROM tbl_cam_complaint_category WHERE deleted = 0 AND FIND_IN_SET(ID, REPLACE('".$row['complaint_category']."', ' ', '')  ) > 0 ORDER BY name" );
				                            if ( mysqli_num_rows($selectComplaint) > 0 ) {
				                                while ($rowComp = mysqli_fetch_array($selectComplaint)) {
				                                	$html .= '<li>'.htmlentities($rowComp['name']).'</li>';
				                                }
				                            }
										} else {
											$html .= '<li>'.htmlentities($row['complaint_category']).'</li>';
										}
									}
								$html .= '</ol>
							</td>
						</tr>
					</table>

					<p></p>';
				}

				$html .= '<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td style="width: 50%;"><b>Department(s) Involved</b></td>
						<td style="width: 50%;"><b>Involved Personnel</b></td>
					</tr>
					<tr>
						<td>
							<ol>';
								$selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $user_id AND FIND_IN_SET(ID, REPLACE('".$row['department_id']."', ' ', '')  ) > 0 ORDER BY title" );
	                            if ( mysqli_num_rows($selectDepartment) > 0 ) {
	                                while ($rowDept = mysqli_fetch_array($selectDepartment)) {
	                                	$html .= '<li>'.htmlentities($rowDept['title']).'</li>';
	                                }
	                            }
							$html .= '</ol>
						</td>
						<td>
							<ol>';
								$selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $user_id AND FIND_IN_SET(ID, REPLACE('".$row['employee_id']."', ' ', '')  ) > 0 ORDER BY first_name" );
	                            if ( mysqli_num_rows($selectEmployee) > 0 ) {
	                                while ($rowEmp = mysqli_fetch_array($selectEmployee)) {
	                                	$html .= '<li>'.htmlentities($rowEmp['first_name']).' '.htmlentities($rowEmp['last_name']).'</li>';
	                                }
	                            }
							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td><b>Description of Issue</b></td>
					</tr>
					<tr>
						<td>'; $html .= $type == 1 ? nl2br(htmlentities($row['description'])):nl2br(htmlentities($row['nature_complaint'])); $html .= '</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Observation / Issue(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">'.nl2br(htmlentities($row['observation'])).'</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['observation_file'])) {
									$array_training_file = explode(' | ', $row['observation_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								} 

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Root Cause(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">'.nl2br(htmlentities($row['root_cause'])).'</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['root_cause_file'])) {
									$array_training_file = explode(' | ', $row['root_cause_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								} 

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Corrective Action(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							Status: '.$status_array[$corrective_status].'<br>';

							if ($type == 1) {
								$html .= nl2br(htmlentities($row['corrective_desc'])).'<br>
								Date: '.$row['corrective_date'].'<br>';
							} else {
								$html .= $row['action_taken'].'<br>
								Date: '.date('Y-m-d', strtotime($row['date_resolution'])).'<br>';
							}

							$html .= 'Time: '.$row['corrective_time'].'<br>
							Corrective By: '.htmlentities($row['corrective_by']).'<br>
						</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['corrective_file'])) {
									$array_training_file = explode(' | ', $row['corrective_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Implementation(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							Status: '.$status_array[$implementation_status].'<br>
							'.nl2br(htmlentities($row['implementation_desc'])).'<br>
							Effective Date of Resolution: '.$row['implementation_date'].'<br>
							Implementated By: '.htmlentities($row['implementation_by']).'
						</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['implementation_file'])) {
									$array_training_file = explode(' | ', $row['implementation_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Preventive Action(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							Status: '.$status_array[$preventive_status].'<br>
							'.nl2br(htmlentities($row['preventive_desc'])).'
						</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['preventive_file'])) {
									$array_training_file = explode(' | ', $row['preventive_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Evaluation(s) and Follow Up(s)</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							Status: '.$status_array[$evaluation_status].'<br>
							'.nl2br(htmlentities($row['evaluation_desc'])).'
						</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['evaluation_file'])) {
									$array_training_file = explode(' | ', $row['evaluation_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
					<tr>
						<td colspan="2"><b>Comments</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">'.nl2br(htmlentities($row['comment'])).'</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['comment_file'])) {
									$array_training_file = explode(' | ', $row['comment_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" style="ver">
					<tr>
						<td colspan="2"><b>Applicable Trainings</b></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							Time: '.$row['training_date'].'
							<ol>';
								$selectTraining = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE status = 1 AND deleted = 0 AND user_id = $user_id AND FIND_IN_SET(ID, REPLACE('".$row['training']."', ' ', '')  ) > 0 ORDER BY title" );
	                            if ( mysqli_num_rows($selectTraining) > 0 ) {
	                                while ($rowTraining = mysqli_fetch_array($selectTraining)) {
	                                	$html .= '<li>'.htmlentities($rowTraining['title']).'</li>';
	                                }
	                            }
							$html .= '</ol>
						</td>
						<td style="width: 50%;">
							Supporting Documents / Evidence:
							<ol>';

								if (!empty($row['training_file'])) {
									$array_training_file = explode(' | ', $row['training_file']);
									foreach($array_training_file as $value) {
										if (!empty($value)) {
											$html .= '<li><a href="'.$base_url.'uploads/cam/'.$value.'" class="btn btn-link">'.$value.'</a></li>';
										}
									}
								}

							$html .= '</ol>
						</td>
					</tr>
				</table>

				<p></p>

				<table cellpadding="7" cellspacing="0" border="0" nobr="true" width="100%" >
					<tr bor>
						<td style="border-bottom: 1px solid #444; border-right: 1px solid #444; background-color: #fff;"></td>
						<td style="border: 1px solid #444;"><b>Name</b></td>
						<td style="border: 1px solid #444;"><b>Title</b></td>
						<td style="border: 1px solid #444;"><b>Date</b></td>
						<td style="border: 1px solid #444;"><b>Time</b></td>
					</tr>
					<tr>
						<td style="border: 1px solid #444;"><b>Investigated By</b></td>
						<td style="border: 1px solid #444;">'.htmlentities($row['investigated_by']).'</td>
						<td style="border: 1px solid #444;">'.$row['investigated_title'].'</td>
						<td style="border: 1px solid #444;">'.$row['investigated_date'].'</td>
						<td style="border: 1px solid #444;">'.$row['investigated_time'].'</td>
					</tr>
					<tr>
						<td style="border: 1px solid #444;"><b>CAPA Verified By</b></td>
						<td style="border: 1px solid #444;">'.htmlentities($row['verified_by']).'</td>
						<td style="border: 1px solid #444;">'.$row['verified_title'].'</td>
						<td style="border: 1px solid #444;">'.$row['verified_date'].'</td>
						<td style="border: 1px solid #444;">'.$row['verified_time'].'</td>
					</tr>
					<tr>
						<td style="border: 1px solid #444;"><b>CAPA Completed By</b></td>
						<td style="border: 1px solid #444;">'.htmlentities($row['completed_by']).'</td>
						<td style="border: 1px solid #444;">'.$row['completed_title'].'</td>
						<td style="border: 1px solid #444;">'.$row['completed_date'].'</td>
						<td style="border: 1px solid #444;">'.$row['completed_time'].'</td>
					</tr>
				</table>

			</body>
		</html>';
	}

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('Title -'.date('Ymd').'.pdf', 'I');
?>