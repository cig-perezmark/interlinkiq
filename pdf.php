<?php
	include_once ('database_iiq.php');

	$id = $_GET['id'];
	$current_client = 0;
	if (!empty($_COOKIE['client'])) { $current_client = $_COOKIE['client']; }
	
	$selectData = mysqli_query( $conn,"SELECT * FROM tbl_hr_quiz_result WHERE ID = $id" );
	if ( mysqli_num_rows($selectData) > 0 ) {
		$row = mysqli_fetch_array($selectData);
		$data_result = $row['result'];
		$data_start_time = $row['start_time'];
		$data_end_time = $row['end_time'];

		$datetime1 = new DateTime($data_start_time);
		$datetime2 = new DateTime($data_end_time);
		$interval = $datetime1->diff($datetime2);

		$data_signature = $row['signature'];
		$img_base64_encoded = 'data:'.$data_signature;

		$topic = '';
		$data_quiz_id = $row['quiz_id'];
		$selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE status=1" );
		if ( mysqli_num_rows($selectTrainings) > 0 ) {
			while($rowTrainings = mysqli_fetch_array($selectTrainings)) {
				$trainings_id = $rowTrainings['ID']; // 22
				$trainings_title = $rowTrainings['title']; // topic
				$trainings_quiz_id = $rowTrainings['quiz_id']; // 2 4 5

				if (!empty($trainings_quiz_id)) {
					$trainings_quiz_id_arr = explode(", ", $trainings_quiz_id);

					if (in_array($data_quiz_id, $trainings_quiz_id_arr)) {
						$topic = $rowTrainings['title'];
						// exit();
					}
				}
			}
		}

		$data_user_id = $row['user_id'];
		$trainee_name = userFullname($data_user_id);

		$current_userEmployerID = employerID($data_user_id);
		$trainer_name = userFullname($current_userEmployerID);

		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID=$data_user_id" );
		if ( mysqli_num_rows($selectUser) > 0 ) {
			$rowUser = mysqli_fetch_array($selectUser);
			$user_employee_id = $rowUser['employee_id'];

			$selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID=$user_employee_id" );
			if ( mysqli_num_rows($selectEmployer) > 0 ) {
				$rowEmployee = mysqli_fetch_array($selectEmployer);
				$employee_dept_id = $rowEmployee['department_id'];
				
				$department_title = '';
				if(!empty($rowEmployee['department_id'])) {
				    $department_title_arr = array();
				    $employee_dept_id_arr = explode(", ", $rowEmployee['department_id']);
				    foreach($employee_dept_id_arr as $employee_dept_id){
				        
				        $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE ID=$employee_dept_id" );
        				if ( mysqli_num_rows($selectDepartment) > 0 ) {
        					$rowDepartment = mysqli_fetch_array($selectDepartment);
        					array_push($department_title_arr, $rowDepartment['title']);
        				}
    				}
    				$department_title = implode(", ",$department_title_arr);
				}

				// $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE ID=$employee_dept_id" );
				// if ( mysqli_num_rows($selectDepartment) > 0 ) {
				// 	$rowDepartment = mysqli_fetch_array($selectDepartment);
				// 	$department_title = $rowDepartment['title'];
				// }
			}
		}

		$user_trainer_name = '';
		$data_trainer_id = $row['trainer_id'];
		if ($data_trainer_id > 0) {
			$selectTrainer = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id=$data_trainer_id" );
			if ( mysqli_num_rows($selectTrainer) > 0 ) {
				$rowTrainer = mysqli_fetch_array($selectTrainer);
				$user_trainer_name = $rowTrainer['first_name'] .' '. $rowTrainer['last_name'];
			}
		}

		$selectQuizSet = mysqli_query( $conn,"SELECT * FROM tbl_hr_quiz_set WHERE ID=$data_quiz_id" );
		if ( mysqli_num_rows($selectQuizSet) > 0 ) {
			$rowQuizSet = mysqli_fetch_array($selectQuizSet);
			$quiz_set_language = $rowQuizSet['language'];
		}

		$enterprise_name = 'Sample Enterprise Name';

		$enterprise_bldg = "Cluster 36";
		$enterprise_city = "Cainta";
		$enterprise_state = "Rizal";
		$enterprise_zip = "Zip";
		$enterprise_country = "PH";
		$enterprise_address = array();
		array_push($enterprise_address, $enterprise_bldg);
		array_push($enterprise_address, $enterprise_city);
		array_push($enterprise_address, $enterprise_state);
		array_push($enterprise_address, $enterprise_zip);
		array_push($enterprise_address, $enterprise_country);
		$enterprise_address = implode(', ', $enterprise_address);

		$selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE users_entities=$current_userEmployerID" );
		if ( mysqli_num_rows($selectEnterprise) > 0 ) {
		    $rowEnterprise = mysqli_fetch_array($selectEnterprise);
		    $enterprise_logo = $rowEnterprise['BrandLogos'];
		    $enterprise_name = $rowEnterprise['businessname'];

		    $enterprise_bldg = $rowEnterprise['Bldg'];
		    $enterprise_city = $rowEnterprise['city'];
		    $enterprise_state = $rowEnterprise['States'];
		    $enterprise_zip = $rowEnterprise['ZipCode'];

		    $enterprise_country = $rowEnterprise["country"];
		    $selectCountry = mysqli_query( $conn,"SELECT * FROM countries WHERE id = $enterprise_country" );
		    $rowCountry = mysqli_fetch_array($selectCountry);
		    $enterprise_country = $rowCountry["name"];

		    $enterprise_address = array();
		    array_push($enterprise_address, $enterprise_bldg);
		    array_push($enterprise_address, $enterprise_city);
		    array_push($enterprise_address, $enterprise_state);
		    array_push($enterprise_address, $enterprise_zip);
		    array_push($enterprise_address, $enterprise_country);
		    $enterprise_address = implode(', ', $enterprise_address);
		}

		$last_modified = $row["last_modified"];
		$last_modified = new DateTime($last_modified);
		$last_modified = $last_modified->format('M d, Y');
	}

	function userFullname($ID) {
		global $conn;

		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $ID" );
		$rowUser = mysqli_fetch_array($selectUser);
		$user_fullname = $rowUser['first_name'] .' '. $rowUser['last_name'];

		return $user_fullname;
	}
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

	// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

    // create some HTML content
    
    // $img_base64_encoded = str_replace("image/;base64,", "", $img_base64_encoded);
    
    // // Image from data stream ('PHP rules')
    // $imgLogo = base64_decode($img_base64_encoded);
    
    // $imgLogo = setImageScale(7);
    // $imgLogo = Image('@'.$imgLogo);


	$html = '
	<p style="text-align: center;">
		<img src="/companyDetailsFolder/'.$enterprise_logo.'" height="50" /><br>
		'.$enterprise_name.'<br>
		<b>
			Training Record';

			if ($quiz_set_language == 1) { $html .= '<br>Record de entrenamiento'; }
			else if ($quiz_set_language == 2) { $html .= '<br>	سجل دي إنترينامينتو	'; }
			
		$html .= '</b>
	</p>

	<table cellpadding="7" cellspacing="0" border="1">
		<tr>
			<td style="text-align: center;">
				<b>
					Training Topic';

					if ($quiz_set_language == 1) { $html .= ' / Descripción de entrenamiento'; }
					else if ($quiz_set_language == 2) { $html .= ' / موضوع التدريب	'; }

				$html .= '</b>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">'. htmlentities($topic).'</td>
		</tr>
	</table>

	<p style="text-align: justify;">';

	if ($current_client == 1) {
		$html .= 'All personnel shall be trained on all applicable policies and procedures. At the completion of training, the trainee will sign and date this training requirement acknowledging that all training requirements have been met.';
	} else {
		$html .= 'All personnel shall be trained on these policies and procedures. A copy of this training record will be placed in the Personnel Training File located in the QC’s office. At the completion of training, the trainee must sign and date this training document and the trainer will sign and affix the date and time to acknowledge that all training requirements have been met.';
	}

	$html .= '</p>';
	
	if ($quiz_set_language == 1) { $html .= '<p style="text-align: justify;">Todo el personal deberá estar capacitado en estas políticas y procedimientos. Se colocará una copia de este registro de capacitación en el Archivo de capacitación del personal ubicado en la oficina del control de calidad. Al finalizar la capacitación, el alumno debe firmar y fechar este documento de capacitación y el capacitador firmará y fijará la fecha y hora para reconocer que se han cumplido todos los requisitos de capacitación.</p>'; }
	else if ($quiz_set_language == 2) { $html .= '<p style="text-align: justify;"> يجب تدريب جميع الموظفين على هذه السياسات والإجراءات. سيتم وضع نسخة من سجل التدريب هذا في ملف تدريب الموظفين الموجود في مكتب مراقبة الجودة. عند الانتهاء من التدريب ، يجب على المتدرب التوقيع على وثيقة التدريب وتأريخها وسيوقع المدرب ويلصق التاريخ والوقت للإقرار باستيفاء جميع متطلبات     التدريب.
	</p>'; }

	$html .= '<table cellpadding="7" cellspacing="0" border="1" style="text-align: justify;">
		<tr>
			<td style="text-align: center;">
				<b>';

					if ($current_client == 1) { $html .= 'Training '; }

					$html .= 'Requirements';

					if ($quiz_set_language == 1) { $html .= ' / Requisitos'; }
					else if ($quiz_set_language == 2) { $html .= ' / Requisitos'; }

				$html .= '</b>
			</td>
		</tr>
		<tr>
			<td>';

				if ($current_client == 1) {
					$html .= '(1) The trainee has read the standard operating procedure for which they are being trained. (2) The trainee has observed a demonstration for the process or procedure for which they are being trained as required. (3) The trainee has demonstrated the ability to perform the process or procedure with acceptable proficiency and with minimal supervision as required. (4) The trainee has successfully completed the required training assessment.';
				} else {
					$html .= '(1) The trainee (employee/visitor) has read or received a verbal translation of all or part of the policy, procedure, method, and or SOP for which they are being trained. (2) The trainee has observed a demonstration for the task they are to perform or the procedure for which they are being trained as required. (3) The trainee has demonstrated the ability to perform the task with acceptable proficiency and with minimal supervision as required.';
				}
				
				if ($quiz_set_language == 1) { $html .= '<br><br>(1) El aprendiz (empleado / visitante) ha leído o recibido una traducción verbal de toda o parte de la política, el procedimiento, el método o el SOP para el que está siendo capacitado. (2) El alumno ha observado una demostración de la tarea que debe realizar o el procedimiento para el que está siendo entrenado según sea necesario. (3) El alumno ha demostrado la capacidad de realizar la tarea con competencia aceptable y con una supervisión mínima, según sea necesario.'; }
				else if ($quiz_set_language == 2) { $html .= '<br><br> 	(1) قام المتدرب (الموظف / الزائر) بقراءة أو تلقي ترجمة شفهية لكل أو جزء من السياسة ، والإجراءات ، والطريقة ، و / أو الإجراء التشغيلي الموحد الذي يتم تدريبهم عليها. (2) لاحظ المتدرب عرضًا توضيحيًا للمهمة التي يتعين عليهم القيام بها أو الإجراء الذي يتم تدريبهم من أجله على النحو المطلوب. (3) أظهر المتدرب قدرته على داء المهمة بكفاءة مقبولة وبأقل قدر من الإشراف كما هو مطلوب.	'; }
				
			$html .= '</td>
		</tr>
	</table>

	<p></p>

	<table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">
		<tr>
			<td>
				<b>
					Trainee';

					if ($quiz_set_language == 1) { $html .= '<br> / Aprendiz (Escriba el nombre aqui)'; }
					else if ($quiz_set_language == 2) { $html .= '<br> / ممتدرب   (اطبع الاسم هنا)    '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Department';

					if ($quiz_set_language == 1) { $html .= '<br> / Departamento'; }
					else if ($quiz_set_language == 2) { $html .= '<br> / مقسم:    '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Trainee Signature';

					if ($quiz_set_language == 1) { $html .= '<br> / Firma del<br>aprendiz'; }
					else if ($quiz_set_language == 2) { $html .= '<br> / متوقيع المتدرب:    '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Score';

					if ($quiz_set_language == 1) { $html .= '<br> / Puntaje'; }
					else if ($quiz_set_language == 2) { $html .= '<br> / منتيجة   '; }

				$html .= '</b>
			</td>
		</tr>
		<tr>
			<td>'.$trainee_name.'</td>
			<td>'.$department_title.'</td>
			<td><img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $data_signature) . '" height="60" border="0" /></td>
			<td>'.$data_result.'%</td>
		</tr>
		<tr>
			<td>
				<b>
					Start Time';

					if ($quiz_set_language == 1) { $html .= ' / Hora de inicio'; }
					else if ($quiz_set_language == 2) { $html .= '/  وقتالبدء:   '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					End Time';

					if ($quiz_set_language == 1) { $html .= ' / Hora de finalización'; }
					else if ($quiz_set_language == 2) { $html .= '/   وقت      النهاية:   '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Total Time';

					if ($quiz_set_language == 1) { $html .= ' / Tiempo Total'; }
					else if ($quiz_set_language == 2) { $html .= '/  الوقت الكلي:  '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Date';

					if ($quiz_set_language == 1) { $html .= ' / Fecha'; }
					else if ($quiz_set_language == 2) { $html .= '/   تاريخ:      '; }

				$html .= '</b>
			</td>
		</tr>
		<tr>
			<td>'.$data_start_time.'</td>
			<td>'.$data_end_time.'</td>
			<td>'.$interval->format('%h')."Hrs ".$interval->format('%i')."Mins ".$interval->format('%s')."Secs".'</td>
			<td>'.$last_modified.'</td>
		</tr>
		<tr>
			<td>
				<b>
					Trainer / Supervisor Printed Name:';

					if ($quiz_set_language == 1) { $html .= ' / Entrenador / Supervisor Nombre impreso:'; }
					else if ($quiz_set_language == 2) { $html .= '/   اسم المدرب / المشرف المطبوع:   '; }

				$html .= '</b>
			</td>
			<td>
				<b>
					Location';

					if ($quiz_set_language == 1) { $html .= ' / Ubicación'; }
					else if ($quiz_set_language == 2) { $html .= '/  موقع:   '; }

				$html .= '</b>
			</td>
			<td colspan="2">
				<b>
					Frequency';

					if ($quiz_set_language == 1) { $html .= ' / Frecuencia'; }
					else if ($quiz_set_language == 2) { $html .= '/  تكرار       '; }

				$html .= '</b>
			</td>
		</tr>
		<tr>
			<td>'.$user_trainer_name.'</td>
			<td>
				<span style="text-align: center; margin: 0;">';

					if ($current_client == 1) {
						$html .= '<img src="assets/img/Canna-OS-Logo_gear.png" style="width: 100px;" />';
					} else {
						$html .= '<img src="assets/img/interlinkiq%20v3.png" style="width: 100px;" />';
					}

					$html .= '<br>LMS
				</span>
			</td>
			<td colspan="2">
				Annually / If changes occur';

				if ($quiz_set_language == 1) { $html .= '<br>Anualme nte / Si ocurren cambios'; }
				else if ($quiz_set_language == 2) { $html .= '<br>  سنويا / في حالة حدوث   تغييرات   '; }

			$html .= '</td>
		</tr>
	</table>

	<p></p>

	<table cellpadding="7" cellspacing="0" border="0">
		<tr>';

			if ($current_client == 1) {
				$html .= '<td style="text-align: left;">Learning Management System</td>
				<td style="text-align: center;">www.begreenlegal.com</td>
				<td style="text-align: center;">916-758-8470</td>
				<td style="text-align: right;">info@begreenlegal.com</td>';
			} else {
				$html .= '<td style="text-align: left;">Learning Management System</td>
				<td style="text-align: center;">www.InterlinkIQ.com</td>
				<td style="text-align: center;">202-982-3002</td>
				<td style="text-align: right;">services@interlinkiq.com</td>';
			}

		$html .= '</tr>
	</table>';

	// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

	// reset pointer to the last page
	$pdf->lastPage();

	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output($topic.'-'.date('Ymd').'.pdf', 'I');

	//============================================================+
	// END OF FILE
	//============================================================+
