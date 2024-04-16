<?php
	include '../database.php';
	$base_url = "https://interlinkiq.com/";
    // PHP MAILER FUNCTION
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    function php_mailer_1($to, $user, $subject, $body, $from, $name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            $msg = 'Message has been sent';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $msg;
    }
    function php_mailer_2($to, $user, $subject, $body, $from, $name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            $msg = 'Message has been sent';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $msg;
    }
    function php_mailer_3($to, $user, $subject, $body, $from, $name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            // $mail->SMTPDebug  = 3;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            $msg = 'Message has been sent';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $msg;
    }
    
	function fileExtension($file) {
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		$src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
		$embed = '&embedded=true';
		$type = 'iframe';
		if ($extension == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
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
		return $output;
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
	function employeeID($ID) {
		global $conn;

		$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        return $current_userEmployeeID;
	}

	if (!empty($_COOKIE['switchAccount'])) {
		$portal_user = $_COOKIE['ID'];
		$user_id = $_COOKIE['switchAccount'];
        $userEmployeeID = employeeID($portal_user);
	} else {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
        $userEmployeeID = employeeID($portal_user);
	}


	// Update Projects
	if (isset($_POST['update_Project'])) { 
		$today = date('Y-m-d');
		$MyPro_id = $_POST['ID'];
		$cCollaborator = '';
		$userID = $_COOKIE['ID'];
		$Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
		$Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
		$Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
		$Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
		$Project_status = mysqli_real_escape_string($conn,$_POST['Project_status']);
		$Accounts = mysqli_real_escape_string($conn,$_POST['Accounts_PK']);
		
		$file = $_FILES['Sample_Documents']['name'];
		if(!empty($file)) {
			$filename = pathinfo($file, PATHINFO_FILENAME);
			$extension = end(explode(".", $_FILES['Sample_Documents']['name']));
			$rand = rand(10,1000000);
			$Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
			$to_File_Documents = $rand." - ".$filename.".".$extension;
			move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
		} else{
			$Sample_Documents = $_POST['Sample_Documents2'];
		}
		if(!empty($_POST["Collaborator"])) {
			foreach($_POST["Collaborator"] as $Collaborator) {
				$cCollaborator .= $Collaborator.', ';
			}
		}
		$cCollaborator = substr($cCollaborator, 0, -2);
		$sql = "UPDATE tbl_MyProject_Services set Project_Name = '$Project_Name',Project_Description='$Project_Description',Start_Date='$Start_Date',Desired_Deliver_Date='$Desired_Deliver_Date',Sample_Documents ='$Sample_Documents',Collaborator_PK = '$cCollaborator',Project_status='$Project_status',Accounts_PK='$Accounts' where MyPro_id = $MyPro_id";
		if(mysqli_query($conn, $sql)) {
			// autologs
			$sql2= "INSERT INTO tbl_service_logs_draft (user_id,description,action,comment,account,task_date,minute) 
			VALUES ('$userID','$Project_Name','Updated','$Project_Description','$Accounts','$today',2)";
			if(mysqli_query($conn, $sql2)){
				$last_id_log = mysqli_insert_id($conn);
				echo '<script> window.location.href = "../mypro_task.php?view_id='.$MyPro_id.'";</script>';
			}
		} else {
			$message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	// add new parent
	if( isset($_GET['modalNew_File']) ) {
		$ID = $_GET['modalNew_File'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="project_id" value="'. $ID .'" />';
		$query_proj = "SELECT * FROM tbl_MyProject_Services where MyPro_id = $ID";
		$result_proj = mysqli_query($conn, $query_proj);
		while($row_proj = mysqli_fetch_array($result_proj)) {
			echo'<div class="form-group">
				<div class="col-md-12">
					<label>Task Name</label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="text" name="filename" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Supporting File</label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="file" name="file">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label>Action Items</label>
					 <select class="form-control mt-multiselect btn btn-default" type="text" name="Action_taken" required>
						<option value="">---Select---</option>';
						$queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
						$resultType = mysqli_query($conn, $queryType);
						while($rowType = mysqli_fetch_array($resultType)) { 
						   echo '<option value="'.$rowType['Action_Items_id'].'" >'.$rowType['Action_Items_name'].'</option>'; 
						}

						echo '<option value="0">Others</option> 
					</select>
				</div>
				<div class="col-md-6">
					<label>Account</label>
					<select class="form-control mt-multiselect btn btn-default" type="text" name="h_accounts" required>
						<option value="">---Select---</option>
						';
							$query_accounts = "SELECT * FROM tbl_service_logs_accounts  where owner_pk = '$user_id' and  is_status = 0 order by name ASC";
							$result_accounts = mysqli_query($conn, $query_accounts);
							while($row_accounts = mysqli_fetch_array($result_accounts))
								 { 
								   echo '<option value="'.$row_accounts['name'].'" '; echo $row_proj['Accounts_PK'] == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
							   } 
						 echo '
						 <option value="0">Others</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Description</label>
				</div>
				<div class="col-md-12">
					<textarea class="form-control" name="description" required></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label>Estimated Time (minutes)</label>
					<input class="form-control" type="number" name="Estimated_Time" value="0" required />
				</div>
				<div class="col-md-6">
					<label>Desired Due Date</label>
					<input class="form-control" type="date" name="Action_date" value="'.date("Y-m-d", strtotime(date("Y/m/d"))).'" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Assign to</label>
				</div>
				<div class="col-md-12">
					<select class="form-control mt-multiselect btn btn-default" type="text" name="Assign_to_history" required>
						<option value="0">---Select---</option>';
						$queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
						$resultAssignto = mysqli_query($conn, $queryAssignto);
						while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
							echo '<option value="'.$rowAssignto['ID'].'" >'.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'</option>'; 
						}
						echo '<option value="0">Others</option> 
					</select>
				</div>
			</div>';
		}
	}
	if( isset($_POST['btnSave_History']) ) {
		
		$user_cookie = $_COOKIE['ID'];
		$today = date('Y-m-d');
		$ID = $_POST['ID'];
		$filename = mysqli_real_escape_string($conn,$_POST['filename']);
		$description = mysqli_real_escape_string($conn,$_POST['description']);
		$h_accounts = mysqli_real_escape_string($conn,$_POST['h_accounts']);
		$Estimated_Time = $_POST['Estimated_Time'];
		$Assign_to_history = $_POST['Assign_to_history'];
		$Action_taken = $_POST['Action_taken'];
		$Action_date = $_POST['Action_date'];
		$rand_id = rand(10,1000000);
		$task_date = date('Y-m-d');
		$action = 'Created';
		
		$to_Db_files = "";
		$files = $_FILES['file']['name'];
		if (!empty($files)) {
			$path = '../MyPro_Folder_Files/';
			$tmp = $_FILES['file']['tmp_name'];
			$files = rand(1000,1000000) . ' - ' . $files;
			$to_Db_files = mysqli_real_escape_string($conn,$files);
			$path = $path.$files;
			move_uploaded_file($tmp,$path);
		}
		
		$sql2 = "INSERT INTO tbl_service_logs (user_id, description, comment, action, account, task_date, minute)
		VALUES ('$user_cookie', '$filename', '$description', '$action', '$h_accounts', '$task_date', 2)"; 
		$logs = mysqli_query($conn, $sql2);
			
		$sql = "INSERT INTO tbl_MyProject_Services_History (user_id,MyPro_PK,files, filename, description,Estimated_Time,Action_taken,Action_date,Assign_to_history,Services_History_Status,rand_id,h_accounts)
		VALUES ('$user_cookie','$ID', '$to_Db_files', '$filename', '$description','$Estimated_Time','$Action_taken','$Action_date','$Assign_to_history',1,'$rand_id','$h_accounts')";
		
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);

			$selectData = mysqli_query( $conn,'SELECT *,tbl_MyProject_Services_History.user_id as owner FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken left join tbl_hr_employee on Assign_to_history = ID WHERE  History_id="'. $last_id .'" ORDER BY History_id LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['History_id'];
				$data_filename = $rowData['filename'];
				$data_description = $rowData['description'];
				$Action_Items_name = $rowData['Action_Items_name'];
				$first_name = $rowData['first_name'];
				$first_name = $rowData['first_name'];
				$h_accounts = $rowData['h_accounts'];

				$data_files = $rowData['files'];
				$fileExtension = fileExtension($data_files);
				$src = $fileExtension['src'];
				$embed = $fileExtension['embed'];
				$type = $fileExtension['type'];
				$file_extension = $fileExtension['file_extension'];
				$url = $base_url.'MyPro_Folder_Files/';

				$Action_date = $rowData['Action_date'];
				$Action_date = new DateTime($Action_date);
				$Action_date = $Action_date->format('M d, Y');
				
				echo'<div class="panel-group accordion " id="accordion1" style="">
					<div class="panel panel" >
						<div class="panel-heading bg-primary" style="background-color:#f5f5f5;color:;" >
						   <div class="row">
								<div class="col-md-9">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#'.$rowData['History_id'].'"> 
										<table style="table-layout: fixed; width: 100%;font-size:13px;">
											<tbody>
												<tr onclick="view_more('.$rowData['History_id'].')">
													<th class="child_1" width="80px">'.$rowData['History_id'].'</th>';
													$owner  = $rowData['owner'];
													$query = "SELECT * FROM tbl_user where ID = '$owner'";
													$result = mysqli_query($conn, $query);
													while($row = mysqli_fetch_array($result)){ 
														echo '<th class="child_1">From: '.$row['first_name'].'</th>';
													}
													echo '<th class="child_1">'.$rowData['filename'].'</th>
													<th class="child_1" width="20%">';
														$stringProduct = strip_tags($rowData['description']); 
														if(strlen($stringProduct) > 76) {
															$stringCut = substr($stringProduct,0,76);
															$endPoint = strrpos($stringCut,' ');
															$stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
															$stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$data1['History_id'].')"><i style="color:black;">See more...</i></a>';
														}
														echo $stringProduct;
													echo '</th>
													
													<th class="child_1">Account: '.$rowData['h_accounts'].'</th>
													<th class="child_1">Assign to: '.$rowData['first_name'].'</th>
													<th class="child_1">'.$rowData['Action_Items_name'].'</th>
													<th class="child_1">Desired Date: '.date("Y-m-d", strtotime($rowData['Action_date'])).'</th>
													<th class="child_1" width="5%">';
														if (!empty($data_files)) {
															echo '<a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
																<i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
																<span class="badge" style="background-color:blue;margin-left:-7px;"><b style="font-size:14px;">1</b></span>
															</a>';
														} else {
															echo '<a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
																<i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
																<span class="badge" style="background-color:red;margin-left:-7px;"><b style="font-size:14px;">0</b></span>
															</a>';
														}
													
													echo'</th>
													<th></th>
												</tr>
											</tbody>
										</table>
									</a>
								</div>
								<div class="col-md-3">';
									$id_st = $rowData['History_id'];
									$ck = $_COOKIE['employee_id'];
									$counter = 1;
									$counter_result = 0;
									$sql__MyTask = $conn->query("SELECT * FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and CAI_Assign_to = $ck ");
									while($data_MyTask = $sql__MyTask->fetch_array()) {
										$MyTask = $data_MyTask['CAI_Assign_to'];
										$h_id = $data_MyTask['Services_History_PK'];
										$counter_result = $counter++;
									}
									
									$view_id = $rowData['MyPro_PK'];
									$sql_counter = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Childs_action_Items where Parent_MyPro_PK = '$view_id'");
									while($data_counter = $sql_counter->fetch_array()) {
										 $count_result = $data_counter['counter'];
									}
									$sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2");
									while($data_compliance = $sql_compliance->fetch_array()) {
										   $comp = $data_compliance['compliance'];
									}
									$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2");
									while($data_none_compliance = $sql_none_compliance->fetch_array()) {
										   $non = $data_none_compliance['non_comp'];
									}
									$ptc = 0;
									if( !empty($comp) && !empty($non) ){ 
										$percent = $comp / $count_result;
										$ptc = number_format($percent * 100, 2) . '%';
									}
									else if(empty($non) && !empty($comp)){ $ptc = '100%';}
									else{ $ptc = '0%';}
										
										
									echo '<a style="font-size:14px;"  class="btn dark btn-xs btn-outline" onclick="get_myTask('.$MyTask.','.$h_id.')">My Task('; if(!empty($counter_result)){echo $counter_result; }else{echo '0';} echo')</a>
									<a style="font-size:14px;"  class="btn dark btn-xs btn-outline">Compliance('; echo $ptc; echo ')</a>';
									echo '
								
									<a style="font-weight:800;font-size:14px;" href="#modalGetHistory" data-toggle="modal" class="btn green btn-xs btn-outline" onclick="btnNew_History('.$rowData['History_id'].')">Add</a>
									<a style="font-weight:800;font-size:14px;" href="#modalGet_parent" data-toggle="modal" class="btn red btn-xs btn-outline" onclick="onclick_parent('.$rowData['History_id'].')">Edit</a>
								</div>
						   </div>
						</div>
						<div id="'.$rowData['History_id'].'" class="panel-collapse collapse">
							<div class="panel-body" >
								<div id="data_child'.$rowData['History_id'].'"></div>
							</div>
						</div>
					</div>
				</div>';
			}
			// autologs
			$sql2= "INSERT INTO tbl_service_logs_draft (user_id,description,action,comment,account,task_date,minute) 
			VALUES ('$user_cookie','$filename','Created','$description','$h_accounts','$today',2)";
			if(mysqli_query($conn, $sql2)){$last_id_log = mysqli_insert_id($conn);}
		}
		else{
			$message = "Error: " . $sql . "<br>" . mysqli_error($conn);
			echo $message;
		}
		mysqli_close($conn);
	}

	// Project Section
	if( isset($_GET['btnDelete_Project']) ) {
		$ID = $_GET['btnDelete_Project'];

		mysqli_query( $conn,"UPDATE tbl_MyProject_Services SET is_deleted = 1 WHERE MyPro_id = $ID" );
	}
	if( isset($_GET['btnArchive_Project']) ) {
		$ID = $_GET['btnArchive_Project'];

		mysqli_query( $conn,"UPDATE tbl_MyProject_Services SET is_deleted = 2 WHERE MyPro_id = $ID" );
		
		
        $selectMP = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $ID" );
        if ( mysqli_num_rows($selectMP) > 0 ) {
            $rowMP = mysqli_fetch_array($selectMP);
            $title = $rowMP["Project_Name"];
        }
        
        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $to = $rowUser["email"];
            $user = $rowUser["first_name"] .' '. $rowUser["last_name"];
        }
        
        $subject = 'New Activity: '.$title;
		$body = $title.' has been archived';
        if ($rowUser['client'] == 1) {
            $from = 'CannOS@begreenlegal.com';
            $name = 'BeGreenLegal';
            $body .= 'Cann OS Team';
        } else {
            $from = 'services@interlinkiq.com';
            $name = 'InterlinkIQ';
            $body .= 'InterlinkIQ.com Team<br>
            Consultare Inc.';
        }

        php_mailer_1($to, $user, $subject, $body, $from, $name);
	}
	if( isset($_GET['btnEdit_Project']) ) {
		$ID = $_GET['btnEdit_Project'];

		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $ID" );
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);

			$colNum=6;
			if ($user_id != 34){ $colNum =12; }

			echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
			<div class="form-group">
				<div class="col-md-'.$colNum.'">
					<label>Project Name</label>
					<input class="form-control" type="text" name="Project_Name" value="'.$rowData['Project_Name'].'" required />
				</div>
				<div class="col-md-6 '; echo $user_id == 34 ? '':'hide'; echo '" >
					<label>Account</label>
					<select class="form-control mt-multiselect btn btn-default" type="text" name="h_accounts">
						<option value="NONE">--Select--</option>';

						$query_accounts = "SELECT * FROM tbl_service_logs_accounts where owner_pk = '$user_id' and  is_status = 0 order by name ASC";
						$result_accounts = mysqli_query($conn, $query_accounts);
						while($row_accounts = mysqli_fetch_array($result_accounts)) { 
							echo '<option value="'.$row_accounts['name'].'" '; echo 'CONSULTAREINC' == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
						}

					echo '</select>
				</div>
			</div>
			<div class="form-group">
				 <div class="col-md-12">
					<label>Descriptions</label>
				</div>
				<div class="col-md-12">
					<textarea class="form-control" type="text" name="Project_Description" rows="4" required>'.$rowData['Project_Description'].'</textarea>
				</div>
			</div>
			<div class="form-group">
				 <div class="col-md-12">
					<label>Image/file </label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="file" name="Sample_Documents">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label>Start Date</label>
					<input class="form-control" type="date" name="Start_Date" value="'.date("Y-m-d", strtotime($rowData['Start_Date'])).'" required />
				</div>
				<div class="col-md-6" >
					<label>Desired Due Date</label>
					<input class="form-control" type="date" name="Desired_Deliver_Date" value="'.date("Y-m-d", strtotime($rowData['Desired_Deliver_Date'])).'" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Collaborator</label>
					<select class="form-control mt-multiselect btn btn-default" type="text" name="Collaborator[]" multiple required>
						<option value="">---Select---</option>';

						$array_collab = explode(", ", $rowData["Collaborator_PK"]);
						$queryCollab = "SELECT * FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
						$resultCollab = mysqli_query($conn, $queryCollab);
						while($rowCollab = mysqli_fetch_array($resultCollab)) {
							echo '<option value="'.$rowCollab['ID'].'" '; echo in_array($rowCollab['ID'], $array_collab) ? 'SELECTED':''; echo '>'.$rowCollab['first_name'] .' '. $rowCollab['last_name'].'</option>';
						}

					echo '</select>
				</div>
			</div>';
		}
	}
	if (isset($_POST['btnCreate_Project'])) { 
		if (!empty($_COOKIE['switchAccount'])) {
			$userID = $_COOKIE['switchAccount'];
		} else {
			$userID = $_COOKIE['ID'];
		}
		
		$cCollaborator = '';
		$today = date('Y-m-d');
		$Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
		$Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
		$Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
		$Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
		$h_accounts = mysqli_real_escape_string($conn,$_POST['h_accounts']);

		$file = $_FILES['Sample_Documents']['name'];
		if(!empty($file)){
			$filename = pathinfo($file, PATHINFO_FILENAME);
			$extension = end(explode(".", $_FILES['Sample_Documents']['name']));
			$rand = rand(10,1000000);
			$Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
			$to_File_Documents = $rand." - ".$filename.".".$extension;
			move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
		} else{ $Sample_Documents ='';}

		if(!empty($_POST["Collaborator"])) {
			foreach($_POST["Collaborator"] as $Collaborator) {
				$cCollaborator .= $Collaborator.', ';
			}
		}
		$cCollaborator = substr($cCollaborator, 0, -2);
		$sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Sample_Documents,Collaborator_PK,user_cookies,switch_id,Project_status,Accounts_PK) 
		VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$Sample_Documents','$cCollaborator','$userID','$user_id',0,'$h_accounts')";
		if(mysqli_query($conn, $sql)) {
			//append
			$last_id = mysqli_insert_id($conn);
			//new added
			foreach ($_POST["Collaborator"] as $Collaborator) {
				$sql1 = "INSERT INTO tbl_myproject_services_collab (my_pro_id, collab_id)
				VALUES ('$last_id', '$Collaborator')";
				mysqli_query($conn, $sql1);
			}
			//end of it
			
			$query = mysqli_query($conn, "SELECT *  FROM tbl_MyProject_Services left join tbl_MyProject_Services_Assigned on MyPro_PK = MyPro_id where  MyPro_id  = $last_id");
			foreach($query as $row) {
				echo '<tr id="row_proj_'.$row['MyPro_id'].'">
					<td>No. '.$row['MyPro_id'].'</td>
					<td>'.$row['Project_Name'].'</td>
					<td>'.$row['Project_Description'].'</td>
					<td>'.date("Y-m-d", strtotime($row['Start_Date'])).'</td>
					<td>'.date("Y-m-d", strtotime($row['Desired_Deliver_Date'])).'</td>
					<td>';
						if ($_COOKIE['ID'] == 38) {
							echo '<a class="btn blue btn-outline btnViewMyPro_update" data-toggle="modal" href="#modalGetMyPro_update" data-id="'.$row['MyPro_id'].'">Edit</a>';
						} else {
							echo '<a href="mypro_task.php?view_id='.$row['MyPro_id'].'" class="btn green btn-outline" >View</a>';
						}
					echo '</td>
				</tr>';
			}

			// autologs
			$sql2= "INSERT INTO tbl_service_logs_draft (user_id,description,action,comment,account,task_date,minute) 
			VALUES ('$userID','$Project_Name','Created','$Project_Description','$h_accounts','$today',1)";
			if(mysqli_query($conn, $sql2)){$last_id_log = mysqli_insert_id($conn);}
		}
	}
	if (isset($_POST['btnUpdate_Project'])) {
		$ID = $_POST['ID'];
		$Project_Name = addslashes($_POST['Project_Name']);
		$h_accounts = addslashes($_POST['h_accounts']);
		$Project_Description = addslashes($_POST['Project_Description']);
		$Start_Date = $_POST['Start_Date'];
		$Desired_Deliver_Date = $_POST['Desired_Deliver_Date'];

		$cCollaborator = '';
		if (!empty($_POST['Collaborator'])) {
			$cCollaborator = implode(", ",$_POST['Collaborator']);
		}

		mysqli_query( $conn,"UPDATE tbl_MyProject_Services SET Project_Name='". $Project_Name ."', Accounts_PK='". $h_accounts ."', Project_Description='". $Project_Description ."', Start_Date='". $Start_Date ."', Desired_Deliver_Date='". $Desired_Deliver_Date ."', Collaborator_PK='". $cCollaborator ."', Project_Description='". $Project_Description ."' WHERE MyPro_id='". $ID ."'" );

		$file = $_FILES['Sample_Documents']['name'];
		if(!empty($file)){
			$filename = pathinfo($file, PATHINFO_FILENAME);
			$extension = end(explode(".", $_FILES['Sample_Documents']['name']));
			$rand = rand(10,1000000);
			$Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
			$to_File_Documents = $rand." - ".$filename.".".$extension;
			move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);

			mysqli_query( $conn,"UPDATE tbl_MyProject_Services set Sample_Documents='". $Sample_Documents ."' WHERE MyPro_id='". $ID ."'" );
		}

		$selectData = mysqli_query($conn, "SELECT
			mp.MyPro_id AS project_ID,
			mp.Project_Name AS project_name,
			mp.Project_Description AS project_description,
			mp.Start_Date AS date_stated,
			mp.Desired_Deliver_Date AS date_delivery,
			SUM(mh.tmsh_column_status = 0) AS count_NS,
			SUM(mh.tmsh_column_status = 1) AS count_IP,
			SUM(mh.tmsh_column_status = 2) AS count_C

			FROM tbl_MyProject_Services AS mp

			LEFT JOIN (
				SELECT
			   	*
			    FROM tbl_MyProject_Services_History
			    WHERE is_deleted = 0
			) AS mh
			ON mp.MyPro_ID = mh.MyPro_PK

			WHERE  mp.MyPro_id = $ID");
		if ( mysqli_num_rows($selectData) > 0 ) {
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['ID'];

			$data = '<td class="hide">No. '.$rowData['project_ID'].'</td>
            <td>'.$rowData['project_name'].'</td>
            <td class="text-center">'.$rowData['count_NS'].'</td>
            <td class="text-center">'.$rowData['count_IP'].'</td>
            <td class="text-center">'.$rowData['count_C'].'</td>
            <td>'.$rowData['project_description'].'</td>
            <td>'.$rowData['date_stated'].'</td>
            <td>'.$rowData['date_delivery'].'</td>
            <td class="text-center">';

        		if ($portal_user == 458) {
        			$data .= '<a href="#modalEdit_Project" data-toggle="modal" class="btn btn-xs dark m-0" onclick="btnEdit_Project('.$rowData['project_ID'].')" title="Edit"><i class="fa fa-pencil"></i></a>';
        		}

        		$data .= '<a href="test_task_mypro.php?view_id='.$rowData['project_ID'].'" class="btn btn-xs btn-success m-0" title="View" target="_blank"><i class="fa fa-search"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-danger m-0" onclick="btnDelete_Project('.$rowData['project_ID'].', this)" title="Delete"><i class="fa fa-trash"></i></a>
            </td>';
		}

		$output = array(
			"ID" => $ID,
			"data" => $data
		);
		echo json_encode($output);
	}
	
	
    if( isset($_GET['mypro_pending']) ) {
        $ID = $_GET['mypro_pending'];
        $current_userAdminAccess = $_GET['a'];
        $serries_array = array();
        // $series_data = array();

        if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
            $result = mysqli_query($conn, "SELECT
                o.m_ID,
                o.m_name,
                COUNT(o.task_ID) AS m_count
                FROM (
                    SELECT
                    m.MyPro_id AS m_ID,
                    m.Project_Name AS m_name,
                    m.Project_Description AS m_description,
                    m.Start_Date AS m_start,
                    m.Desired_Deliver_Date AS m_due,
                    h_ID,
                    h_MP_ID,
                    h_name,
                    h_description,
                    h_start,
                    h_due,
                    h_status,
                    c_ID,
                    c_name,
                    c_description,
                    c_start,
                    c_due,
                    c_status,

                    CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
                    CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
                    CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
                    CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
                    CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
                    CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

                    FROM (
                        SELECT
                        h.History_id AS h_ID,
                        h.MyPro_PK AS h_MP_ID,
                        h.filename AS h_name,
                        h.description AS h_description,
                        h.history_added AS h_start,
                        h.Action_date AS h_due,
                        h.tmsh_column_status AS h_status,
                        c.CAI_id AS c_ID,
                        c.CAI_filename AS c_name,
                        c.CAI_description AS c_description,
                        c.CAI_Action_date AS c_start,
                        c.CAI_Action_due_date AS c_due,
                        c.CIA_progress AS c_status
                        
                        FROM tbl_MyProject_Services_History AS h

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_MyProject_Services_Childs_action_Items
                            WHERE is_deleted = 0
                        ) AS c
                        ON h.History_id = c.Services_History_PK

                        WHERE h.is_deleted = 0
                    ) r

                    RIGHT JOIN (
                        SELECT
                        *
                        FROM tbl_MyProject_Services
                        WHERE is_deleted = 0
                        AND switch_id = $user_id
                    ) as m
                    ON m.MyPro_id = r.h_MP_ID

                    WHERE LENGTH(r.h_ID) > 0
                ) o
                WHERE o.task_status != 2

                GROUP BY o.m_ID
        																
        		ORDER BY o.m_name
            ");
        } else {
            $result = mysqli_query($conn, "SELECT
                o.m_ID,
                o.m_name,
                COUNT(o.task_ID) AS m_count
                FROM (
                    SELECT
                    m.MyPro_id AS m_ID,
                    m.Project_Name AS m_name,
                    m.Project_Description AS m_description,
                    m.Start_Date AS m_start,
                    m.Desired_Deliver_Date AS m_due,
                    h_ID,
                    h_MP_ID,
                    h_name,
                    h_description,
                    h_start,
                    h_due,
                    h_status,
                    c_ID,
                    c_name,
                    c_description,
                    c_start,
                    c_due,
                    c_status,

                    CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
                    CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
                    CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
                    CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
                    CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
                    CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status

                    FROM (
                        SELECT
                        h.History_id AS h_ID,
                        h.MyPro_PK AS h_MP_ID,
                        h.filename AS h_name,
                        h.description AS h_description,
                        h.history_added AS h_start,
                        h.Action_date AS h_due,
                        h.tmsh_column_status AS h_status,
                        c.CAI_id AS c_ID,
                        c.CAI_filename AS c_name,
                        c.CAI_description AS c_description,
                        c.CAI_Action_date AS c_start,
                        c.CAI_Action_due_date AS c_due,
                        c.CIA_progress AS c_status
                        
                        FROM tbl_MyProject_Services_History AS h

                        LEFT JOIN (
                            SELECT
                            *
                            FROM tbl_MyProject_Services_Childs_action_Items
                            WHERE is_deleted = 0
                        ) AS c
                        ON h.History_id = c.Services_History_PK

                        WHERE h.is_deleted = 0
                    ) r

                    RIGHT JOIN (
                        SELECT
                        *
                        FROM tbl_MyProject_Services
                        WHERE is_deleted = 0
                        AND switch_id = $user_id
                    ) as m
                    ON m.MyPro_id = r.h_MP_ID

                    WHERE LENGTH(r.h_ID) > 0
                    AND (m.user_cookies = $portal_user OR FIND_IN_SET($userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
                ) o
                WHERE o.task_status != 2

                GROUP BY o.m_ID
        																
        		ORDER BY o.m_name
            ");
        }

        while($row = mysqli_fetch_array($result)) {
            $m_ID = $row['m_ID'];
            $m_name = $row['m_name'];
            $m_count = $row['m_count'];


            $series_data = array(
                $m_name,
                intval($m_count)
            );
            
            
            // $series_data = array(
            //     'name' => $m_name,
            //     'data' => [$m_count]
            // );

            // array_push($series_data, $m_name);
            // array_push($series_data, $m_count);

            array_push($serries_array, $series_data);
        }

        $output = array(
            "series" => $serries_array
        );
        echo json_encode($output);
    }
    if( isset($_GET['mypro_completed']) ) {
        $ID = $_GET['mypro_completed'];
        $current_userAdminAccess = $_GET['a'];
        $serries_array = array();
        // $series_data = array();
        $data_count = array();
        
		$countPending = 0;
		$countDue = 0;
		$countCompleted = 0;
		$countTotal = 0;
        if (!empty($ID)) {
            if (!empty($_COOKIE['switchAccount']) OR $current_userAdminAccess == 1) {
                $result = mysqli_query($conn, "SELECT
                    SUM(CASE WHEN o.task_status = 2 THEN 1 ELSE 0 END) AS countCompleted,
                    SUM(CASE WHEN o.task_status != 2 THEN 1 ELSE 0 END) AS countPending,
                    SUM(CASE WHEN o.task_status != 2 AND DATE(o.task_due) < CURDATE() THEN 1 ELSE 0 END) AS countDue,
                    COUNT(o.task_ID) AS countTotal
                    
                    FROM (
                    	SELECT
                    	m.MyPro_id AS m_ID,
                    	m.Project_Name AS m_name,
                    	m.Project_Description AS m_description,
                    	m.Start_Date AS m_start,
                    	m.Desired_Deliver_Date AS m_due,
                    	h_ID,
                    	h_MP_ID,
                    	h_name,
                    	h_description,
                    	h_start,
                    	h_due,
                    	h_status,
                    	c_ID,
                    	c_name,
                    	c_description,
                    	c_start,
                    	c_due,
                    	c_status,
                    
                    	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
                    	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
                    	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
                    	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
                    	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
                    	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status
                    
                    	FROM (
                    		SELECT
                    		h.History_id AS h_ID,
                    		h.MyPro_PK AS h_MP_ID,
                    		h.filename AS h_name,
                    		h.description AS h_description,
                    		h.history_added AS h_start,
                    		h.Action_date AS h_due,
                    		h.tmsh_column_status AS h_status,
                    		c.CAI_id AS c_ID,
                    		c.CAI_filename AS c_name,
                    		c.CAI_description AS c_description,
                    		c.CAI_Action_date AS c_start,
                    		c.CAI_Action_due_date AS c_due,
                    		c.CIA_progress AS c_status
                    		
                    		FROM tbl_MyProject_Services_History AS h
                    
                    		LEFT JOIN (
                    			SELECT
                    		    *
                    		    FROM tbl_MyProject_Services_Childs_action_Items
                    		    WHERE is_deleted = 0
                    		) AS c
                    		ON h.History_id = c.Services_History_PK
                    
                    		WHERE h.is_deleted = 0
                    	) r
                    
                    	RIGHT JOIN (
                    	 	SELECT
                    	    *
                    	    FROM tbl_MyProject_Services
                    	    WHERE is_deleted = 0
                    	    AND switch_id = $user_id
                    	) as m
                    	ON m.MyPro_id = r.h_MP_ID
                    
                    	WHERE LENGTH(r.h_ID) > 0
                        AND m.MyPro_id = $ID
                    ) o
                ");
            } else {
                $result = mysqli_query($conn, "SELECT
                    SUM(CASE WHEN o.task_status = 2 THEN 1 ELSE 0 END) AS countCompleted,
                    SUM(CASE WHEN o.task_status != 2 THEN 1 ELSE 0 END) AS countPending,
                    SUM(CASE WHEN o.task_status != 2 AND DATE(o.task_due) < CURDATE() THEN 1 ELSE 0 END) AS countDue,
                    COUNT(o.task_ID) AS countTotal
                    
                    FROM (
                    	SELECT
                    	m.MyPro_id AS m_ID,
                    	m.Project_Name AS m_name,
                    	m.Project_Description AS m_description,
                    	m.Start_Date AS m_start,
                    	m.Desired_Deliver_Date AS m_due,
                    	h_ID,
                    	h_MP_ID,
                    	h_name,
                    	h_description,
                    	h_start,
                    	h_due,
                    	h_status,
                    	c_ID,
                    	c_name,
                    	c_description,
                    	c_start,
                    	c_due,
                    	c_status,
                    
                    	CASE WHEN c_ID IS NULL THEN h_ID ELSE c_ID END AS task_ID,
                    	CASE WHEN c_name IS NULL THEN h_name ELSE c_name END AS task_name,
                    	CASE WHEN c_description IS NULL THEN h_description ELSE c_description END AS task_description,
                    	CASE WHEN c_start IS NULL THEN h_start ELSE c_start END AS task_start,
                    	CASE WHEN c_due IS NULL THEN h_due ELSE c_due END AS task_due,
                    	CASE WHEN c_status IS NULL THEN h_status ELSE c_status END AS task_status
                    
                    	FROM (
                    		SELECT
                    		h.History_id AS h_ID,
                    		h.MyPro_PK AS h_MP_ID,
                    		h.filename AS h_name,
                    		h.description AS h_description,
                    		h.history_added AS h_start,
                    		h.Action_date AS h_due,
                    		h.tmsh_column_status AS h_status,
                    		c.CAI_id AS c_ID,
                    		c.CAI_filename AS c_name,
                    		c.CAI_description AS c_description,
                    		c.CAI_Action_date AS c_start,
                    		c.CAI_Action_due_date AS c_due,
                    		c.CIA_progress AS c_status
                    		
                    		FROM tbl_MyProject_Services_History AS h
                    
                    		LEFT JOIN (
                    			SELECT
                    		    *
                    		    FROM tbl_MyProject_Services_Childs_action_Items
                    		    WHERE is_deleted = 0
                    		) AS c
                    		ON h.History_id = c.Services_History_PK
                    
                    		WHERE h.is_deleted = 0
                    	) r
                    
                    	RIGHT JOIN (
                    	 	SELECT
                    	    *
                    	    FROM tbl_MyProject_Services
                    	    WHERE is_deleted = 0
                    	    AND switch_id = $user_id
                    	) as m
                    	ON m.MyPro_id = r.h_MP_ID
                    
                    	WHERE LENGTH(r.h_ID) > 0
						AND (m.user_cookies = $portal_user OR FIND_IN_SET($userEmployeeID, REPLACE(m.Collaborator_PK, ' ', '')) > 0)
                        AND m.MyPro_id = $ID
                    ) o
                ");
            }
            
            while($row = mysqli_fetch_array($result)) {
    			$countCompleted = $row['countCompleted'];
    			$countPending = $row['countPending'];
    			$countDue = $row['countDue'];
    			$countTotal = $row['countTotal'];
                
                $result_data = array(
                    'name' => 'Completed',
                    'sliced' => true,
                    'selected' => true,
                    'y' => intval($countCompleted)
                );
                array_push($data_count, $result_data);
                
                $result_data = array(
                    'name' => 'Pending',
                    'y' => intval($countPending)
                );
                array_push($data_count, $result_data);
                
                $result_data = array(
                    'name' => 'Overdue',
                    'y' => intval($countDue)
                );
                array_push($data_count, $result_data);
            }
        }
    	$series_data = array(
            'name' => 'Project',
            'colorByPoint' => true,
            'data' => $data_count
        );
        array_push($serries_array, $series_data);

        $output = array(
            "series" => $serries_array
        );
        echo json_encode($output);
    }


	if( isset($_GET['modalDate_Select']) ) {
		$ID = $_GET['modalDate_Select'];
		$path = $_GET['p'];
		$type = $_GET['t'];

		if ($path == 1) {
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE CAI_id = $ID" );
			if ( mysqli_num_rows($selectData) > 0 ) {
	            while($rowData = mysqli_fetch_array($selectData)) {
	                if ($type == 1) {
	                	$date = $rowData["CAI_Action_due_date"];
	                } else {
	                	$date = $rowData["CAI_Action_date"];
	                }
	            }
	        }
		} else {
			$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History WHERE History_id = $ID" );
			if ( mysqli_num_rows($selectData) > 0 ) {
	            while($rowData = mysqli_fetch_array($selectData)) {
	                if ($type == 1) {
	                	$date = $rowData["Action_date"];
	                } else {
	                	$date = $rowData["history_added"];
	                }
	            }
	        }
		}


		$date = new DateTime($date);
		$date = $date->format('Y-m-d');

		echo '
		<input type="hidden" name="ID" value="'.$ID.'" />
		<input type="hidden" name="path" value="'.$path.'" />
		<input type="hidden" name="type" value="'.$type.'" />
		<input class="form-control" type="date" name="date" value="'.$date.'" required="" />';
	}
	if( isset($_GET['btnComplete_Project']) ) {
		$ID = $_GET['btnComplete_Project'];
		$path = $_POST['path'];

		if ($path == 1) {
            mysqli_query( $conn,"UPDATE CIA_progress set CAI_Action_date = 2 WHERE CAI_id = $ID" );
		} else {
            mysqli_query( $conn,"UPDATE tbl_MyProject_Services_History set tmsh_column_status = 2 WHERE History_id = $ID" );
		}
	}
	if (isset($_POST['btnSave_Date'])) { 
		$ID = $_POST['ID'];
		$path = $_POST['path'];
		$type = $_POST['type'];
		$date = $_POST['date'];

		if ($path == 1) {
            if ($type == 1) {
            	mysqli_query( $conn,"UPDATE tbl_MyProject_Services_Childs_action_Items set CAI_Action_due_date = '".$date."' WHERE CAI_id = $ID" );
            } else {
            	mysqli_query( $conn,"UPDATE tbl_MyProject_Services_Childs_action_Items set CAI_Action_date = '".$date."' WHERE CAI_id = $ID" );
            }
		} else {
            if ($type == 1) {
            	mysqli_query( $conn,"UPDATE tbl_MyProject_Services_History set Action_date = '".$date."' WHERE History_id = $ID" );
            } else {
            	mysqli_query( $conn,"UPDATE tbl_MyProject_Services_History set history_added = '".$date."' WHERE History_id = $ID" );
            }
		}

		$date = new DateTime($date);
		$date = $date->format('M d, Y');

		$output = array(
			"ID" => $ID,
			"path" => $path,
			"type" => $type,
			"date" => $date
		);
		echo json_encode($output);
	}
	
	
	if( isset($_GET['btnModalAccess']) ) {
		$page = $_GET['btnModalAccess'];
		
		echo '<input class="form-control" type="hidden" name="page" value="'.$page.'" />
		<div class="form-group">
			<label class="col-md-3 control-label">Select Users</label>
			<div class="col-md-8">
				<select class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple">';
				
					$selectEmployee = mysqli_query( $conn,"SELECT 
                        e.ID AS e_ID,
                        e.first_name AS e_first_name,
                        e.last_name AS e_last_name,
                        CASE WHEN a.ID IS NOT NULL THEN 1 ELSE 0 END AS collab
                        FROM tbl_hr_employee AS e
                        
                        LEFT JOIN (
                        	SELECT
                            *
                            FROM tbl_access
                            WHERE deleted = 0
                            AND user_id = $user_id
                            AND page = $page
                        ) AS a
                        ON FIND_IN_SET(e.ID, REPLACE(a.collab, ' ',''))
                        
                        WHERE e.status = 1 
                        AND e.user_id = $user_id
                        
                        ORDER BY e.first_name" );
					if ( mysqli_num_rows($selectEmployee) > 0 ) {
						while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
							echo '<option value="'. $rowEmployee["e_ID"] .'" '; echo $rowEmployee["collab"] == 0 ? '':'SELECTED'; echo '>'. $rowEmployee["e_first_name"] .' '. $rowEmployee["e_last_name"] .'</option>';
						}
					} else {
						echo '<option disabled>No Available</option>';
					}
						
				echo '</select>
			</div>
		</div>';
	}
	if (isset($_POST['btnSave_Access'])) { 
		$msg = '';
		$page = $_POST['page'];
		$assigned_to_id = '';
        if (!empty($_POST['assigned_to_id'])) {
            $assigned_to_id = implode(", ",$_POST['assigned_to_id']);
        }
		
		$selectAccess = mysqli_query( $conn,"SELECT * FROM tbl_access WHERE deleted = 0 AND page = $page AND user_id = $user_id" );
		if ( mysqli_num_rows($selectAccess) > 0 ) {
            $rowAccess = mysqli_fetch_array($selectAccess);
            $access_ID = $rowAccess["ID"];
            
            mysqli_query( $conn,"UPDATE tbl_access set collab = '".$assigned_to_id."' WHERE ID = $access_ID" );
            $msg = 1;
		} else {
		    $sql = "INSERT INTO tbl_access (user_id, portal_user, page, collab)
			VALUES ('$user_id', '$portal_user', '$page', '$assigned_to_id')";
			if (mysqli_query($conn, $sql)) {
				$msg = mysqli_insert_id($conn);
			}
		}
		echo $msg;
	}
?>