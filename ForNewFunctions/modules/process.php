<?php
	require "database.php";

	require "PHPMailer/PHPMailer/src/Exception.php";
	require "PHPMailer/PHPMailer/src/PHPMailer.php";
	require "PHPMailer/PHPMailer/src/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if (!empty($_COOKIE['switchAccount'])) {
		$portal_user = $_COOKIE['ID'];
		$user_id = $_COOKIE['switchAccount'];
	}
	else {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
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

	if (isset($_POST['action']) && $_POST['action'] == 'ParentTask') {
		projectTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'ParentTask1') {
		projectTask1($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'ParentTask2') {
		projectTask2($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'insertProject') {
		insertProject($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'viewParentcontrols') {
		InsertParent($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'InsertChildProjectAndHistory') {
		SaveHistoryAndParent($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'dataModal') {
		taskDataModal($conn);
	}

	if (isset($_POST['action']) && $_POST['action'] == 'addingChild') {
		AddChildForm($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingChildSubmit') {
		AddChildSubmit($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingDocumentform') {
		addingChildDocumentform($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingDocument') {
		addingChildDocument($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingSubDocumentform') {
		addingSubChildDocumentform($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingSubDocument') {
		addingSubChildDocument($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'AddComment') {
		addingComment($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'AddCommentSubtask') {
		addingCommentSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'dataModalComments') {
		ListOfComments($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'dataModalCommentsSubtask') {
		ListOfCommentsSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'AddCollaborator') {
		addingProjectcollaborator($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'changeStatus') {
		$columnId = $_POST['columnId'];
		$cardId = $_POST['cardId'];
		changeColumnStatus($conn,$cardId, $columnId);
	}
	// delete after the testing
	if (isset($_POST['action']) && $_POST['action'] == 'changeStatusClone') {
		$columnId = $_POST['status'];
		$cardId = $_POST['task_id'];
		changeColumnStatusClone($conn,$cardId, $columnId);
	}
	// end of it
	if (isset($_GET['action']) && $_GET['action'] == 'CountNumberOfColumn') {
		countNumberOfcolumnStatus($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'getSubTaskData') {
		$base_url = "https://interlinkiq.com/";
		viewSubTaskData($conn,$base_url);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'completeSelectedsubTask') {
		updateCompleteStatusSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'deleteSelectedSubTask') {
		deleteSelectedSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingSubTask') {
		loadTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingSubTask_open') {
		loadTask_open($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingSubTask_close') {
		loadTask_close($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'gettingCalendar') {
		showCalendar($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'changeSubtaskDate') {
		changeSubtaskDate($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'searchingData') {
		searchingMainData($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'ViewHistoryForEdit') {
		viewHistoryservicesToEdit($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'SaveEditHistory') {
		saveEditHistory($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'HistoryDeleted') {
		historyDelete($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'ViewSubTaskForEdit') {
		viewSubTaskDatamodal($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'SubmitEditedSubTask') {
		SubmitEditedSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'passToOtherusers') {
		passProjectOtherusers($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'deleteCollaborator') {
		deleteCollaborator($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingTaskDocument') {
		TaskDocumentlist($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'updatecompleteSelectedsubTask') {
		updatedCompleteStatusSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingSubTaskChild') {
		loadSubTask($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'updateTaskStatus') {
		updatingTaskStatus($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'addingChildSubTask') {
		AddChildSubTaskForm($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'processparentDeletion') {
		processparentDeletion($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'loadingSubtaskdocumentlist') {
		loadingSubtaskdocumentlisting($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'orderUpdate') {
		updatedOrderingIndex($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'ChangingHistoryStatus') {
		ChangeHistoryStatus($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'editTaskNameHistory') {
		editingTaskNameHistory($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'editTaskDescriptionHistory') {
		editingTaskDescriptionHistory($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'changeHistoryDate') {
		changingHistoryDate($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'GetThisJsonEncodeForAssigneeHistory') {
		GetThisJsonEncodeForAssigneeHistory($conn);
	}
	// for subtask editing double click
	if (isset($_POST['action']) && $_POST['action'] == 'editSubtaskName') {
		editingSubTaskName($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'editSubTaskDescription') {
		editingSubtaskDescription($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'InsertTheNewAssignee') {
		InsertingTheNewHistoryAssignee($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'changeSubtaskDate') {
		changingSubtaskDate($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'InsertTheNewSubAssignee') {
		InsertingTheNewSubtaskAssignee($conn);
	}
	if (isset($_POST['action']) && $_POST['action'] == 'GetThisFormentionuser') {
		GetThisFormentionuser($conn);
	}
	function GetThisFormentionuser($conn) {
		$base_url = "https://interlinkiq.com/";
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
		$selectUser = mysqli_query($conn, "SELECT * from tbl_user WHERE ID = $portal_user");
		$rowUser = mysqli_fetch_array($selectUser);
		$current_client = $rowUser['client'];

		$queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = $user_id AND status = 1 ORDER BY first_name ASC";
		$resultAssignto = mysqli_query($conn, $queryAssignto);
		
		$user_data = array();
		while ($rowAssignto = mysqli_fetch_assoc($resultAssignto)) {
			$current_userAvatar = null;
			$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$rowAssignto['user_id']."'");                                                                                                           
			if (mysqli_num_rows($selectUserInfo) > 0) {
				$rowInfo = mysqli_fetch_assoc($selectUserInfo);
				$current_userAvatar = $rowInfo['avatar'];
			}
			
			if ($current_userAvatar == NULL || $current_userAvatar == "") {
				$profilePicture = "https://js.devexpress.com/Demos/WidgetsGallery/JSDemos/images/mentions/John-Heart.png";
			} else {
				$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
			}
			
			$user_data[] = array(
				"user_id" => $rowAssignto['user_id'],
				"name" => $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name'],
				"avatar" => $profilePicture
			);
		}

		header('Content-Type: application/json');
		echo json_encode($user_data);
	}

	function InsertingTheNewSubtaskAssignee($conn){
		$CAI_id = $_POST['id'];
		$newAssignee =  $_POST['selectedValue'];
		
		$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_Assign_to = ? WHERE CAI_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $newAssignee, $CAI_id);

		$response = array();

		if (mysqli_stmt_execute($stmt)) {
			$response['success'] = true;
			$response['message'] = "Date updated successfully";
		} else {
			$response['success'] = false;
			$response['error'] = "Error updating date";
		}

		mysqli_stmt_close($stmt);

		echo json_encode($response);
	}
	function InsertingTheNewHistoryAssignee($conn){
		$history_id = $_POST['id'];
		$newAssignee =  $_POST['selectedValue'];
		
		$sql = "UPDATE tbl_MyProject_Services_History SET Assign_to_history = ? WHERE History_id  = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $newAssignee, $history_id);

		$response = array();

		if (mysqli_stmt_execute($stmt)) {
			$response['success'] = true;
			$response['message'] = "Date updated successfully";
		} else {
			$response['success'] = false;
			$response['error'] = "Error updating date";
		}

		mysqli_stmt_close($stmt);
		


		$selectHistory = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History WHERE History_id = $history_id" );
       	if ( mysqli_num_rows($selectHistory) > 0 ) {
       		while($rowHistory = mysqli_fetch_array($selectHistory)) {
                $history_name = $rowHistory["filename"];
       		}
       	}
       	
		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $portal_user" );
       	if ( mysqli_num_rows($selectUser) > 0 ) {
       		while($rowUser = mysqli_fetch_array($selectUser)) {
                $user_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
       		}
       	}
       	
		$selectUser2 = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id = $newAssignee" );
       	if ( mysqli_num_rows($selectUser2) > 0 ) {
       		while($rowUser2 = mysqli_fetch_array($selectUser2)) {
                $to = $rowUser2["email"];
                $user = $rowUser2["first_name"] .' '. $rowUser2["last_name"];
       		}
       	}

        $to = $rowUser["u_email"];
        $user = $rowUser["u_first_name"].' '.$rowUser["u_last_name"];
        $subject = 'Project Passed on to You: '.$history_name;
		$body = $user_name.' passed a project to you<br><br>';

        if ($_COOKIE['client'] == 1) {
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


		echo json_encode($response);
	}
	function changingSubtaskDate($conn) {
		$subtask_id = $_POST['view_id'];
		$new_date =  $_POST['new_date'];

		$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_Action_due_date = ? WHERE CAI_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_date, $subtask_id);

		$response = array();

		if (mysqli_stmt_execute($stmt)) {
			$response['success'] = true;
			$response['message'] = "Date updated successfully";
		} else {
			$response['success'] = false;
			$response['error'] = "Error updating date";
		}

		mysqli_stmt_close($stmt);

		echo json_encode($response);
	}
	function editingSubtaskDescription($conn){
		$subtask_id = $_POST['subtask_id'];
		$new_text =  $_POST['newText'];
		$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_description = ? WHERE CAI_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_text, $subtask_id);

		$response = array();
		
		if (mysqli_stmt_execute($stmt)) {
			$response['message'] = "Filename updated successfully";
		} else {
			$response['error'] = "Error updating status";
		}
		
		mysqli_stmt_close($stmt);
		
		echo json_encode($response);
	}
	function editingSubTaskName($conn){
		$subtask_id = $_POST['subtask_id'];
		$new_text =  $_POST['newText'];
		$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_filename = ? WHERE CAI_id = ?";
		
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_text, $subtask_id);

		$response = array();
		
		if (mysqli_stmt_execute($stmt)) {
			$response['message'] = "Filename updated successfully";
		} else {
			$response['error'] = "Error updating status";
		}
		
		mysqli_stmt_close($stmt);
		
		echo json_encode($response);
	}
	// end of it
	function GetThisJsonEncodeForAssigneeHistory($conn) {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
		$selectUser = mysqli_query($conn, "SELECT * from tbl_user WHERE ID = $portal_user");
		$rowUser = mysqli_fetch_array($selectUser);
		$current_client = $rowUser['client'];

		$output = array();
		$output[] = array(
			"value" => "0",
			"label" => "---Select---"
		);

		$queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = $user_id AND status = 1 ORDER BY first_name ASC";
		$resultAssignto = mysqli_query($conn, $queryAssignto);

		while ($rowAssignto = mysqli_fetch_array($resultAssignto)) {
			$output[] = array(
				"value" => $rowAssignto['ID'],
				"label" => $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name']
			);
		}
		$output[] = array(
			"value" => "0",
			"label" => "Others"
		);

		echo json_encode($output);
	}

	function changingHistoryDate($conn) {
		$history_id = $_POST['view_id'];
		$new_date =  $_POST['new_date'];

		$sql = "UPDATE tbl_MyProject_Services_History SET Action_date = ? WHERE History_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_date, $history_id);

		$response = array();

		if (mysqli_stmt_execute($stmt)) {
			$response['success'] = true;
			$response['message'] = "Date updated successfully";
		} else {
			$response['success'] = false;
			$response['error'] = "Error updating date";
		}

		mysqli_stmt_close($stmt);

		echo json_encode($response);
	}
	function editingTaskDescriptionHistory($conn){
		$history_id = $_POST['history_id'];
		$new_text =  $_POST['newText'];
		$sql = "UPDATE tbl_MyProject_Services_History SET description = ? WHERE History_id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_text, $history_id);

		$response = array();
		
		if (mysqli_stmt_execute($stmt)) {
			$response['message'] = "Filename updated successfully";
		} else {
			$response['error'] = "Error updating status";
		}
		
		mysqli_stmt_close($stmt);
		
		echo json_encode($response);
	}
	function editingTaskNameHistory($conn){
		$history_id = $_POST['history_id'];
		$new_text =  $_POST['newText'];
		$sql = "UPDATE tbl_MyProject_Services_History SET filename = ? WHERE History_id = ?";
		
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "si", $new_text, $history_id);

		$response = array();
		
		if (mysqli_stmt_execute($stmt)) {
			$response['message'] = "Filename updated successfully";
		} else {
			$response['error'] = "Error updating status";
		}
		
		mysqli_stmt_close($stmt);
		
		echo json_encode($response);
	}

	function ChangeHistoryStatus($conn){
		$History_id = $_POST['HistoryId'];
		$selectedStatus = $_POST['status'];
			$sql = "UPDATE tbl_MyProject_Services_History SET tmsh_column_status = ? WHERE History_id = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "ii", $selectedStatus, $History_id);
			
			if (mysqli_stmt_execute($stmt)) {
				echo "Status updated successfully";
			} else {
				echo "Error updating status";
			}
			mysqli_stmt_close($stmt);
	}
	function updatedOrderingIndex($conn) {
		$response = array();
		$columnId = $_POST['columnId'];
		$updatedOrder = $_POST['updatedOrder'];

		foreach ($updatedOrder as $index => $taskId) {
			$orderIndex = $index + 1;
			$stmt = $conn->prepare("UPDATE tbl_MyProject_Services_History SET order_index = ? WHERE History_id = ? AND tmsh_column_status = ?");
			$stmt->bind_param("iii", $orderIndex, $taskId, $columnId);
			$stmt->execute();
			$stmt->close();
		}

		$response['success'] = true;
		$response['message'] = 'Task order updated successfully';

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function loadingSubtaskdocumentlisting($conn) {
		$view_id = $_POST['id'];
		$base_url = "https://interlinkiq.com/";
		$sql = "SELECT * FROM tbl_myproject_services_documents WHERE history_id = '$view_id'";
		$result = $conn->query($sql);
		$response ='';
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$filename = $row['tmsd_filename'];
				$file = $row['tmsd_files'];
				$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
				$icon = '<i class="fa fa-file"></i>';
				switch ($fileExtension) {
					case 'docx':
						$icon = '<i style="color:#2195f9"  class="fa fa-file-word-o" aria-hidden="true"></i>';
					break;
					case 'pdf':
						$icon = '<i style="color:#e43a45"  class="fa fa-file-pdf-o" aria-hidden="true"></i>';
					break;
					case 'xls':
						$icon = '<i style="color:green" class="fa fa-file-excel-o" aria-hidden="true"></i>';
					break;
				}
				$response .= '<li>
					<div class="task-checkbox">
						<div   class="mt-action-img">'.$icon. '</div>
					</div>
					<div class="task-title">
						<div class="mt-action-details" style="width:70%;text-align:left;">
							<span class="task-title-sp" style="font-size:11px;">' . $filename . '</span>
						</div>
					</div>
					<div class="task-config">
						<div class="task-config-btn btn-group">
							<div class="btn-group">
								<a class="btn btn-circle btn-outline gray" href="' . $base_url . 'ForNewFunctions/resources/uploads/' . $filename . '" target="_blank">
									<i class="fa fa-download"></i>&nbsp;
									<span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
								</a>
							</div>
						</div>
					</div>
				</li>';
			}
		} 
		echo $response;
	}
	function processparentDeletion($conn) {
		$response = array(); 

		if(isset($_POST['id'], $_POST['reason'])) {
			$id = intval($_POST['id']); 
			$reason = mysqli_real_escape_string($conn, $_POST['reason']);
			$current_userID = $_COOKIE['ID'];

			$message = array();
			array_push($message, $current_userID);
			array_push($message, $reason);
			$message = implode(" | ", $message);
			$query = "UPDATE tbl_MyProject_Services SET is_deleted = 1, reason = ? WHERE MyPro_id = ?";
			$stmt = mysqli_prepare($conn, $query);
			
			if($stmt) {
				mysqli_stmt_bind_param($stmt, "si", $message, $id);
				
				if(mysqli_stmt_execute($stmt)) {
					$response['success'] = true;
					$response['message'] = 'Record deleted successfully.';
				} else {
					$response['success'] = false;
					$response['message'] = 'Error deleting record: ' . mysqli_stmt_error($stmt);
				}
				
				mysqli_stmt_close($stmt);
			} else {
				$response['success'] = false;
				$response['message'] = 'Error preparing statement: ' . mysqli_error($conn);
			}
		}

		// Return the JSON response
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	function viewHistoryservicesToEdit($conn) {
		$ID = mysqli_real_escape_string($conn, $_POST['id']); // Sanitize input
		$query_proj = "SELECT * FROM tbl_MyProject_Services_History
					   LEFT JOIN tbl_MyProject_Services_Action_Items ON tbl_MyProject_Services_History.Action_taken = tbl_MyProject_Services_Action_Items.Action_Items_id
					   WHERE tbl_MyProject_Services_History.History_id = $ID";

		$result_proj = mysqli_query($conn, $query_proj);
		if (!$result_proj) {
			// Handle query error
			return;
		}
		$data = array();
		while ($row_proj = mysqli_fetch_assoc($result_proj)) {
			$data[] = $row_proj;
		}
		echo json_encode($data);
	}

	function AddChildSubTaskForm($conn) {
		$ID = $_POST['id'];
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
		$today = date('Y-m-d');
		$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
		$rowUser = mysqli_fetch_array($selectUser);
		$current_client = $rowUser['client'];

		echo '<input class="form-control" type="hidden" name="ID" id="parent_id" value="' . $ID . '" />';
		$queryType_h = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
					   LEFT JOIN tbl_MyProject_Services_History ON tbl_MyProject_Services_Childs_action_Items.Services_History_PK = tbl_MyProject_Services_History.History_id
					   LEFT JOIN tbl_MyProject_Services ON tbl_MyProject_Services.MyPro_id = tbl_MyProject_Services_History.MyPro_PK WHERE tbl_MyProject_Services_Childs_action_Items.CAI_id = ?";
		$stmtType_h = mysqli_prepare($conn, $queryType_h);
		mysqli_stmt_bind_param($stmtType_h, "i", $ID);
		mysqli_stmt_execute($stmtType_h);
		$resultType_h = mysqli_stmt_get_result($stmtType_h);
	   
		while ($rowType_h = mysqli_fetch_array($resultType_h)) {

			echo '<input class="form-control" type="hidden" name="parent_subtask_id" id="parent_subtask_id" value="' . $rowType_h['CAI_id'] . '" />';
			echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="' . $rowType_h['MyPro_id'] . '" >';
			echo '<input type="hidden" class="form-control" name="rand_id_pk" value="' . $rowType_h['rand_id'] . '" >';
			echo '<div class="form-group">
				<div class="col-md-12">
					<label>Task Name</label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="text" name="CAI_filename" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Supporting File</label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="file" name="CAI_files">
				</div>
			</div>';
		  	if($user_id == 34){
				echo '<div class="form-group">
					<div class="col-md-6">
						<label>Action Types</label>
						<select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
							<option value="">---Select---</option>';

							$queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items ORDER BY Action_Items_name ASC";
							$resultType = mysqli_query($conn, $queryType);

							while ($rowType = mysqli_fetch_array($resultType)) {
								echo '<option value="' . $rowType['Action_Items_id'] . '">' . $rowType['Action_Items_name'] . '</option>';
							}

							echo ' <option value="0">Others</option> 
						</select>
					</div>
					<div class="col-md-6">
						<label>Account</label>
						<select name="CAI_Accounts" class="form-control mt-multiselect btn btn-default" type="text">
							<option value="">---Select---</option>';
							echo '<option value="' .  $rowType_h['Accounts_PK']  . '" selected>' . $rowType_h['Accounts_PK'] . '</option>';
							echo'<option value="0">Others</option>';
							$query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE name != ? AND is_status = 0 ORDER BY name ASC";
							$stmt_accounts = mysqli_prepare($conn, $query_accounts);
							mysqli_stmt_bind_param($stmt_accounts, "s", $rowType_h['Accounts_PK']);
							mysqli_stmt_execute($stmt_accounts);
							$result_accounts = mysqli_stmt_get_result($stmt_accounts);

							while ($row_accounts = mysqli_fetch_array($result_accounts)) {
								echo'<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
							}
						echo '</select>
					</div>
				</div>';
			}
		   	echo '<div class="form-group">
				<div class="col-md-12">
					<label>Description</label>
				</div>
				<div class="col-md-12">
					<textarea class="form-control" name="CAI_description" required></textarea>
				</div>
			</div>';

			if ($user_id == NULL) {
				echo '<div class="form-group">
					<div class="col-md-12">
						<label>(<i style="color:red;font-size:12px;"><b style="color:black;">"Yes"</b> it will automatically be reflected in your Service logs. If <b style="color:black;"> "NO"</b> to Auto logs for your review.</i>) </label><br>
						<label><input type="radio" name="checked_choice" value="yes" checked> Yes</label> &nbsp; <label><input type="radio" name="checked_choice" value="no" > No</label>
					</div>
				</div>';
			}
		 
			echo '<div class="form-group">
				<div class="col-md-12">
					<label>Status</label>
				</div>
				<div class="col-md-12">
					<select class="form-control" name="CIA_progress" id="progressSelect">
						<option value="0">Not Started</option>
						<option value="1">In Progress</option>
						<option value="2">Completed</option>
					</select>
				</div>
			</div>
			<div class="form-group">';
				if($user_id == 34){
			  		echo '<div class="col-md-6">
						<label>Estimated Time (minutes)</label>
						<input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required />
					</div>';
				} 
				echo '<div class="col-md-6">
					<label>Due Date</label>
					<input class="form-control" type="date" name="CAI_Action_due_date" value="' . $today . '" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label>Assign to</label>
				</div>
				<div class="col-md-12">
					<select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
						<option value="">---Select---</option>';
						$queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = ? AND status = 1 ORDER BY first_name ASC";
						$stmtAssignto = mysqli_prepare($conn, $queryAssignto);
						mysqli_stmt_bind_param($stmtAssignto, "i", $user_id);
						mysqli_stmt_execute($stmtAssignto);
						$resultAssignto = mysqli_stmt_get_result($stmtAssignto);

						while ($rowAssignto = mysqli_fetch_array($resultAssignto)) {
							echo '<option value="' . $rowAssignto['ID'] . '" ';
							echo $portal_user == $rowAssignto['ID'] ? 'selected' : '';
							echo '>' . $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name'] . '</option>';
						}

						$queryQuest = "SELECT * FROM tbl_user WHERE ID = ?";
						$stmtQuest = mysqli_prepare($conn, $queryQuest);
						mysqli_stmt_bind_param($stmtQuest, "i", $user_id);
						mysqli_stmt_execute($stmtQuest);
						$resultQuest = mysqli_stmt_get_result($stmtQuest);

						while ($rowQuest = mysqli_fetch_array($resultQuest)) {
							echo '<option value="' . $rowQuest['ID'] . '">' . $rowQuest['first_name'] . '</option>';
						}

						echo '
						<option value="0">Others</option> 
					</select>
				</div>
			</div>';
		}
	}
	function loadSubTask($conn) {
		if (!empty($_COOKIE['switchAccount'])) {
			$portal_user = $_COOKIE['ID'];
			$user_id = $_COOKIE['switchAccount'];
		} else {
			$portal_user = $_COOKIE['ID'];
			$user_id = employerID($portal_user);
		}
		$view_id = $_POST['id'];
		$response = '';
		$query = "SELECT *,t_parent.CAI_id AS parentId,t_sub.CAI_id AS ChildId,t_sub.CAI_filename AS Childname,t_sub.CIA_progress AS progresss
			FROM tbl_MyProject_Services_Childs_action_Items AS t_sub
			LEFT JOIN tbl_user AS user ON t_sub.CAI_Assign_to = user.employee_id
			LEFT JOIN tbl_MyProject_Services_Childs_action_Items AS t_parent ON t_sub.Parent_CAI_id = t_parent.CAI_id
			WHERE t_parent.CAI_id = '$view_id';
			";
		$result = mysqli_query($conn, $query);
		while ($row1 = mysqli_fetch_array($result)) {
			$owner = $row1['CAI_Assign_to'];

			$query1 = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result1 = mysqli_query($conn, $query1);
			while ($profile = mysqli_fetch_array($result1)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$profile['ID']."'");
																				
				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($profile['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($profile['last_name'], 0, 1));
			}
														
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
			$actionDate = date('m/d', strtotime($row1['CAI_Action_date']));
			$actionDueDate = date('m/d', strtotime($row1['CAI_Action_due_date']));
			$initials = $firstNameInitial . $lastNameInitial;
			$randomColor = '#' . substr(md5(rand()), 0, 6);
			if ($row1['CIA_progress'] == 0) {
				$colorStatusSub = "label-danger";
			} else  if ($row1['CIA_progress'] == 1) {
				$colorStatusSub = "label-primary";
			} else  if ($row1['CIA_progress'] == 2) {
				$colorStatusSub = "label-success";
			}
			$title = $row1['CAI_filename'];
			$max_length = 26;
			
			if (strlen($title) > $max_length) {
				$truncated_title = substr($title, 0, $max_length) . '...';
			} else {
				$truncated_title = $title;
			}
			$disabledbutton = ($portal_user == $row1['CAI_User_PK']) ? '' : 'disabled';
			$disabledClass = ($row1['CIA_progress'] == 2) ? 'disabled' : '';
			$checkboxContent = ($row1['CIA_progress'] == 2) ? '
			<input data-view="' . $view_id . '" checked value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>' : '
			<input data-view="' . $view_id.'" value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>';
			$response .= '<li id="forCalendarrange">
				<div class="col1">
					<div class="cont">
						<div class="cont-col1">
							<div class="label label-sm">
								<div class="task-checkbox">' . $checkboxContent . '</div>
							</div>
						</div>
						<div class="cont-col2">
							<div class="desc"> 
								<a style="text-decoration: none;color: #717273;" href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" data-id="' . $view_id . '">' . $truncated_title . '</a>
								<span class="label label-sm">
									<a  data-view="' . $view_id . '" data-id="' . $row1["CAI_id"] . '" id="DeleteSelected"><i class="fa fa-trash-o"></i></a>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col2">
					<div data-id="' . $row1["CAI_id"] . '" class="task-config-btn btn-group" style="cursor:pointer;" id="input-picker">
						<div class="date">' . $actionDueDate . '</div>
					</div>
				</div>
				<div class="col2">';
					if (!empty($profilePicture)) {
						$response .= '<a href="#">
							<span class="photo" >
								<img src="'.$profilePicture.'" class="img-circle" alt="'.$initials.'" width="27px" height="27px">
							</span>
						</a>
						<span class="hidden task-title-sp">'.$row1['first_name'].' '.$row1['last_name'].'</span>';
					} else {
						$response .= '<div>
							<span tooltip="'. $row1['first_name'] .' '. $row1['last_name'] .'" class="photo">
							   <label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
							</span>
							<span class="hidden task-title-sp" style="font-size:10px;color:#838FA1;">'. $row1['first_name'] .' '. $row1['last_name'] .'</span>';
					}
				$response.='</div>
				<div class="col2">
					 <a style="font-size:17px;" id="subTask" data-id="' . $row1["CAI_id"] . '"><i class="icon-arrow-right" aria-hidden="true"></i></a> 
				</div>
			</li>
			<li id="forCalendarrange">
			   <div class="task-title">
					<span style="cursor: pointer;"  class="task-title-sp"><a style="text-decoration: none;color: #717273;" href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" data-id="' . $view_id . '">' . $truncated_title . '</a></span>
					<span class="label label-sm ' . $colorStatusSub . '">' . $row1["CAI_Accounts"] . '</span>
					<span><a  data-view="' . $view_id . '" data-id="' . $row1["CAI_id"] . '" id="DeleteSelected"><i class="fa fa-trash-o"></i></a></span>
				</div>
				<div class="task-config">
					<div data-id="' . $row1["CAI_id"] . '" class="task-config-btn btn-group" style="cursor:pointer;" id="input-picker">
						<span>' . $actionDueDate . '</span>
					</div>
					<div class="task-config-btn btn-group">';
					
						if (!empty($profilePicture)) {
							$response .= '<a href="#">
								<span class="photo" >
									<img src="'.$profilePicture.'" class="img-circle" alt="'.$initials.'" width="27px" height="27px">
								</span>
							</a>
							<span class="hidden task-title-sp">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
						} else {
							$response .= '<div>
								<span tooltip="' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '" class="photo">
									<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
								</span>
								<span class="hidden task-title-sp" style="font-size:10px;color:#838FA1;">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
						}
						$response .= '<span>
							<a style="font-size:17px;padding:3px;" id="subTask" data-id="' . $row1["CAI_id"] . '"><i class="icon-arrow-right" aria-hidden="true"></i></a> 
						</span>
					</div>
				</div>
			</li>';
		}
		echo $response;
	}

	function updatingTaskStatus($conn) {
		$id = isset($_POST['subTaskId']) ? intval($_POST['subTaskId']) : 0;
		$Status = $_POST['status'];
		$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items
				SET CIA_progress = ?
				WHERE CAI_id = ?";
		$stmt = $conn->prepare($sql);
		if (!$stmt) {
			die('Error in SQL query: ' . $conn->error);
		}
		$stmt->bind_param("ii", $Status, $id);

		if ($stmt->execute()) {
			echo "success";
		} else {
			echo "error";
		}
	}
	function updatedCompleteStatusSubTask($conn) {
		$id = isset($_POST['subTaskId']) ? intval($_POST['subTaskId']) : 0;
		$Status = $_POST['status'];

		if (isset($_POST['renderedEstimated'])) {
			$renderedEstimated = $_POST['renderedEstimated'];
			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items
					SET CIA_progress = ?, CAI_Rendered_Minutes = ?
					WHERE CAI_id = ?";
			$stmt = $conn->prepare($sql);
			if (!$stmt) {
				die('Error in SQL query: ' . $conn->error);
			}
			$stmt->bind_param("isi", $Status, $renderedEstimated, $id);
		} else {
			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items
					SET CIA_progress = ?
					WHERE CAI_id = ?";
			$stmt = $conn->prepare($sql);
			if (!$stmt) {
				die('Error in SQL query: ' . $conn->error);
			}
			$stmt->bind_param("ii", $Status, $id);
		}

		if ($stmt->execute()) {
			echo "success";
		} else {
			echo "error";
		}
	}

	function deleteCollaborator($conn){
		  $viewId = $_POST['viewId'];
	  $collabId = $_POST['collabId'];
	  $deleteQuery = "DELETE FROM tbl_myproject_services_collab WHERE my_pro_id = $viewId AND collab_id = $collabId";

	  if (mysqli_query($conn, $deleteQuery)) {
		echo 'success';
	  } else {
		echo 'error';
	  }
	}
	function passProjectOtherusers($conn){
	  $assignToHistory = $_POST["assign_to_history"];
	  $viewId = $_POST["view_id"];

	  $query = "UPDATE tbl_MyProject_Services SET user_cookies = $assignToHistory WHERE MyPro_id = $viewId";
	  $result = mysqli_query($conn, $query);

	  if ($result) {
		echo "Cookies updated successfully";
	  } else {
		echo "Error updating cookies: " . mysqli_error($conn);
	  }
	}
	function SubmitEditedSubTask($conn) {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
		$selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $portal_user");
		$rowUser = mysqli_fetch_array($selectUser);
		$current_client = $rowUser['client'];
		
		$CAI_id = $_POST['CAI_id'];
		$CAI_filename = $_POST['CAI_filename'];
		if($user_id == 34){
			$CAI_Action_taken = $_POST['CAI_Action_taken'];
			$CAI_Accounts = $_POST['CAI_Accounts'];
			$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
		}else{
			$CAI_Action_taken = 0;
			$CAI_Accounts = 0;
			$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
		}

		$CAI_description = $_POST['CAI_description'];
		$CAI_Action_due_date = $_POST['CAI_Action_due_date'];
		$CAI_Assign_to = $_POST['CAI_Assign_to'];
		$CAI_Status = $_POST['CIA_progress'];

		$uploadDir = 'uploads/';
		$targetFilePath = '';

		if (!empty($_FILES['CAI_files']['name'])) {
			$CAI_files = $_FILES['CAI_files'];
			$uniqueFilename = uniqid() . '_' . basename($CAI_files['name']);
			$targetFilePath = $uploadDir . $uniqueFilename;
			if (move_uploaded_file($CAI_files['tmp_name'], $targetFilePath)) {
				$stmt = mysqli_prepare($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_filename = ?, CAI_files = ?, CAI_Action_taken = ?, CAI_Accounts = ?, CAI_description = ?, CAI_Estimated_Time = ?, CAI_Action_due_date = ?, CAI_Assign_to = ?, CIA_progress = ? WHERE CAI_id = ?");
				mysqli_stmt_bind_param($stmt, "ssssssssss", $CAI_filename, $targetFilePath, $CAI_Action_taken, $CAI_Accounts, $CAI_description, $CAI_Estimated_Time, $CAI_Action_due_date, $CAI_Assign_to, $CAI_Status, $CAI_id);
				mysqli_stmt_execute($stmt);
				if (mysqli_stmt_affected_rows($stmt) > 0) {
					$response = array('success' => true, 'message' => 'Subtask updated successfully');
				} else {
					$response = array('success' => false, 'message' => 'Failed to update subtask');
				}
				mysqli_stmt_close($stmt);
			} else {
				$response = array('success' => false, 'message' => 'File upload failed');
			}
		} else {
			$stmt = mysqli_prepare($conn, "UPDATE tbl_MyProject_Services_Childs_action_Items SET CAI_filename = ?, CAI_Action_taken = ?, CAI_Accounts = ?, CAI_description = ?, CAI_Estimated_Time = ?, CAI_Action_due_date = ?, CAI_Assign_to = ? , CIA_progress = ? WHERE CAI_id = ?");
			mysqli_stmt_bind_param($stmt, "sssssssss", $CAI_filename, $CAI_Action_taken, $CAI_Accounts, $CAI_description, $CAI_Estimated_Time, $CAI_Action_due_date, $CAI_Assign_to, $CAI_Status , $CAI_id);
			mysqli_stmt_execute($stmt);

			if (mysqli_stmt_affected_rows($stmt) > 0) {
				$response = array('success' => true, 'message' => 'Subtask updated successfully');
			} else {
				$response = array('success' => false, 'message' => 'Failed to update subtask');
			}
			mysqli_stmt_close($stmt);
		}

		echo json_encode($response);
	}

	function viewSubTaskDatamodal($conn) {
		$ID = $_POST['parent_id'];
		$query_proj = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
					   LEFT JOIN tbl_MyProject_Services_Action_Items
					   ON tbl_MyProject_Services_Childs_action_Items.CAI_Action_taken = tbl_MyProject_Services_Action_Items.Action_Items_id
					   WHERE tbl_MyProject_Services_Childs_action_Items.CAI_id = $ID";
		$result_proj = mysqli_query($conn, $query_proj);
		$data = array();
		while ($row_proj = mysqli_fetch_assoc($result_proj)) {
			$data[] = $row_proj;
		}
		echo json_encode($data);
	}

	function historyDelete($conn) {
		$history_id = $_POST['history_id'];
		$reason = $_POST['reason'];
		$current_userID = $_COOKIE['ID'];

		$message = array();
		array_push($message, $current_userID);
		array_push($message, $reason);
		$message = implode(" | ", $message);

		$query = "UPDATE tbl_MyProject_Services_History SET is_deleted = 1, reason = ? WHERE History_id = ?";
		$stmt = mysqli_prepare($conn, $query);

		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "si", $message, $history_id);

			if (mysqli_stmt_execute($stmt)) {
				$response['success'] = true;
				$response['message'] = 'Record deleted successfully.';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error deleting record: ' . mysqli_stmt_error($stmt);
			}

			mysqli_stmt_close($stmt);
		} else {
			$response['success'] = false;
			$response['message'] = 'Error preparing statement: ' . mysqli_error($conn);
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}
function saveEditHistory($conn){
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $portal_user");
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];

	$History_id = $_POST['History_id'];
	$filename = mysqli_real_escape_string($conn, $_POST['filename']);
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	
	if ($current_client == 1) {
		$Action_taken = $_POST['Action_taken'];
		$h_accounts = mysqli_real_escape_string($conn, $_POST['h_accounts']);
		$Estimated_Time = $_POST['Estimated_Time'];
	} else {
		$Action_taken = 0;
		$h_accounts = null;
		$Estimated_Time = $_POST['Estimated_Time'];
	}
	
	$Action_date = $_POST['Action_date'];
	$Assign_to_history = $_POST['Assign_to_history'];
	$h_priority = $_POST['h_priority'];

	$query_update = "UPDATE tbl_MyProject_Services_History SET
		filename = ?,
		description = ?,
		Action_taken = ?,
		h_accounts = ?,
		Estimated_Time = ?,
		Action_date = ?,
		Assign_to_history = ?,
		priority_status = ?
		WHERE History_id = ?";

	$stmt = mysqli_prepare($conn, $query_update);
	
	if (!$stmt) {
		$response = array('success' => false, 'message' => 'Error preparing update: ' . mysqli_error($conn));
		echo json_encode($response);
		return;
	}

	mysqli_stmt_bind_param($stmt, 'ssisssiii', $filename, $description, $Action_taken, $h_accounts, $Estimated_Time, $Action_date, $Assign_to_history, $h_priority, $History_id);

	if (mysqli_stmt_execute($stmt)) {
		$response = array('success' => true, 'message' => 'Record updated successfully');
	} else {
		$response = array('success' => false, 'message' => 'Error updating record: ' . mysqli_error($conn));
	}


	$user = 'interlinkiq.com';
	$subject = 'New Activity: '.$filename;
	//  $frm = "manugasewinjames@gmail.com";
	//  $frm_name = "Bob green";
	//  $t = "manugasewinjames@gmail.com";
	//  $t_fname = "Bob green";

	//   from
	$cookie_frm = $_COOKIE['ID'];
	$selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; $frm_name = $rowFrom['first_name']; }

	//  to
	$cookie_to = $Assign_to_history;
	$select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }

	//   Projects
	$project_id = $History_id;
	$project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History WHERE History_id = $project_id" );
	while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['filename']; }

	//  task
    $child_n = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE is_deleted=0 AND Services_History_PK = $ID AND DATE(CAI_Added) = '$today'");

	$added_users = [];

	while ($child_row_prj = mysqli_fetch_array($child_n)) {
		$base_url = "https://interlinkiq.com/";
		$username = $child_row_prj['CAI_User_PK'];
		$user_query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $username");
		$user_row = mysqli_fetch_array($user_query);
		
		$row_fulname = $user_row['first_name'].'&nbsp;'.$user_row['last_name'];
		$project = $child_row_prj['CAI_filename'];
		$date = $child_row_prj['CAI_Added'];
		$task_id = $project_id;
		$subtask_id = $child_row_prj['CAI_id'];
		// for li
		$dateTime = new DateTime($date, new DateTimeZone('UTC'));
		$dateTime->setTimezone(new DateTimeZone('America/Chicago'));
		$formattedDateTime = $dateTime->format('M d, Y \a\t g:ia');
		// end of li
		// 
		$now = new DateTime();
		$todaydateTime = new DateTime($now->format('Y-m-d H:i:s'));
		$todaydateTime->setTimezone(new DateTimeZone('America/Chicago'));
		$todayformattedDateTime = $todaydateTime->format('M d, Y \a\t g:ia');
		// 
		$added_users[] = ['username' => $row_fulname, 'project' => $project, 'date' => $formattedDateTime, 'project_id' => $task_id];
	}
	$body = '<!DOCTYPE html>
	<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

		<head>
			<title></title>
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<meta content="width=device-width, initial-scale=1.0" name="viewport" />
			<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
			<style>
				* {
					box-sizing: border-box;
				}
				
				body {
					margin: 0;
					padding: 0;
				}
				
				a[x-apple-data-detectors] {
					color: inherit !important;
					text-decoration: inherit !important;
				}
				
				#MessageViewBody a {
					color: inherit;
					text-decoration: none;
				}
				
				p {
					line-height: inherit
				}
				
				.desktop_hide,
				.desktop_hide table {
					mso-hide: all;
					display: none;
					max-height: 0px;
					overflow: hidden;
				}
				
				.image_block img+div {
					display: none;
				}
				
				@media (max-width:560px) {
					.social_block.desktop_hide .social-table {
						display: inline-block !important;
					}
					.mobile_hide {
						display: none;
					}
					.row-content {
						width: 100% !important;
					}
					.stack .column {
						width: 100%;
						display: block;
					}
					.mobile_hide {
						min-height: 0;
						max-height: 0;
						max-width: 0;
						overflow: hidden;
						font-size: 0px;
					}
					.desktop_hide,
					.desktop_hide table {
						display: table !important;
						max-height: none !important;
					}
				}
			</style>
		</head>

		<body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
			<table cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;table-layout:fixed;width:100%">
				<tbody>
					<tr>
						<td style="text-align:center">
							<table style="border-collapse:separate;border-spacing:0;margin-bottom:32px;margin-left:auto;margin-right:auto;margin-top:8px;table-layout:fixed;text-align:left;width:100%">
								<tbody>
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
												<tbody>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td>
																			<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																				<tbody>
																					<tr>
																						<td style="background-color:#f8df72;border-radius:16px;line-height:16px;min-width:32px;height:32px;width:32px;text-align:center;vertical-align:middle">';
																				   			$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$cookie_frm."'");                                                           
																						   	if (mysqli_num_rows($selectUserInfo) > 0) {
																							   $rowInfo = mysqli_fetch_assoc($selectUserInfo);
																							   $current_userAvatar = $rowInfo['avatar'];
																						   	}                            
																						   	$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
																							$initials = "Tt";
																							$randomColor = '#' . substr(md5(rand()), 0, 6);
																							if (!empty($profilePicture)) {
																								$body .= '<img src="' . $profilePicture . '" class="img-circle" alt="' . $initials . '" width="27px" height="27px">';
																							} else {
																								$body .= '<span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">' . $initials . '</span>';
																						 	}
																						$body.='</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																		<td style="max-width:16px;min-width:16px;width:16px">&nbsp;</td>
																		<td>
																			<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																				<tbody>
																					<tr>
																						<td>
																							<a href=""
																								style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:20px;font-weight:400;line-height:26px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$frm_name.' assigned a task to you</span></a>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="line-height:16px;max-width:0;min-width:0;height:16px;width:0;font-size:16px">&nbsp;</td>
																	</tr>
																	<tr>
																		<td style="background-color:#edeae9;height:1px;width:100%"></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
												<tbody>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Task</span></td>
																	</tr>
																	<tr>
																		<td style="vertical-align:top">
																			<a href=""
																				style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:16px;font-weight:600;line-height:24px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$filename.'</span></a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Assigned to</span></td>
																		<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																		<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Due date</span></td>
																	</tr>
																	<tr>
																		<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$t_fname.'</span></td>
																		<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																		<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$Action_date.'</span></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Projects</span></td>
																	</tr>
																	<tr>
																		<td style="vertical-align:top">
																			<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																				<tbody>
																					<tr>
																						<td>
																							<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																								<tbody>
																									<tr>
																										<td style="line-height:20px">
																											<div style="display:inline-block;height:9px;width:9px;min-width:9px;border-radius:3px;background-color:#8d84e8"></div>
																										</td>
																										<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																										<td>
																											<a href=""
																												style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$prj.'</span></a>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0;border-color:#edeae9;border-radius:4px;border-style:solid;border-width:1px">
												<tbody>
													<tr>
														<td style="width:100%">
															<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																		<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																		<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																	</tr>
																	<tr>
																		<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																		<td style="width:100%">
																			<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																				<tbody>';
																					foreach ($added_users as $user) {
																						$body .= '<tr>
																							<td>
																								<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																									<tbody>
																										<tr>
																											<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																											<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																										   
																											<td>
																											<span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>' . $user['username'] . '</strong> added to <a href="https://interlinkiq.com/test_task_mypro.php?view_id=' . $user['project_id'] . '#' . $ID . '" >' . $user['project'] . '</a> . '.$user['date'].'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																												<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																												</span>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																						</tr>';
																					}
																					$body .='<tr>
																						<td>
																							<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																								<tbody>
																									<tr>
																										<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																										<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																										<td><span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>'.$t_fname.'</strong> assigned to you · '.$todayformattedDateTime.'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																											<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																											</span>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																		<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																	</tr>
																	<tr>
																		<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																		<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																		<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
												<tbody>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
												<tbody>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="background-color:#4573d2;border-radius:4px">
																			<a href="https://interlinkiq.com/test_task_mypro.php?view_id='.$ID.'"
																				style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #4573d2;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/test_task_mypro.php?view_id='.$project_id.'">
																				<span style="font-size:13px;font-weight:600;line-height:20px;color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																				View to MyPro</span>
																				</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
														<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
														<td>
															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="background-color:#ffffff;border-radius:4px">
																			<a href="https://interlinkiq.com/complete_task.php?comp_mothtask_id='.$subtask_id.'&&comp_id='.$cookie_to.'"
																				style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #cfcbcb;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/complete_task.php?comp_subtask_id='.$subtask_id.'">
																				<span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																				Mark complete</span>
																			</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
												<tbody>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																<tbody>
																	<tr>
																		<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Collaborators</span></td>
																	</tr>
																	<tr>
																		<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																	</tr>
																	<tr>
																		<td style="vertical-align:top">
																			<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																				<tbody>
																					<tr>
																						<td>
																							<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																								<tbody>
																									<tr>';
																										$selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id");
																										if (mysqli_num_rows($selectData) > 0) {
																											$row = mysqli_fetch_array($selectData);
																										}
																										
																										$queryCollabs = "SELECT * FROM tbl_hr_employee WHERE status = 1 ORDER BY first_name ASC";
																										$stmt = mysqli_prepare($conn, $queryCollabs);
																										mysqli_stmt_execute($stmt);
																										$resultCollabs = mysqli_stmt_get_result($stmt);
																										
																										while ($rowCollabs = mysqli_fetch_array($resultCollabs)) {
																											$array_collab = explode(", ", $row["Collaborator_PK"]);
																											$firstNameInitial = strtoupper(substr($rowCollabs['first_name'], 0, 1));
																											$lastNameInitial = strtoupper(substr($rowCollabs['last_name'], 0, 1));
																											$initials = $firstNameInitial . $lastNameInitial;
																											if (in_array($rowCollabs['ID'], $array_collab)) {
																												$body.='  <td>
																													<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																														<tbody>
																															<tr>
																																<td style="background-color:#f8df72;border-radius:12px;line-height:16px;min-width:24px;height:24px;width:24px;text-align:center;vertical-align:middle"><span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$initials.'</span></td>
																															</tr>
																														</tbody>
																													</table>
																												</td>
																												<td style="max-width:4px;min-width:4px;width:4px">&nbsp;</td>';
																											}
																										}
																									  
																									$body.='</tr>
																								</tbody>
																							</table>
																						</td>
																						<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																						<td style="vertical-align:middle"></td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									  </tr>
								   </tbody>
							</table>
						</td>
					</tr>
			</tbody>
			</table>
		</body>
	</html>';

	$mail = php_mailer($frm, $t, $user, $subject, $body);
	if($mail){
		echo "success";
	}else{
		echo "Failed";
	}

	mysqli_stmt_close($stmt);

	echo json_encode($response);
}
function searchingMainData($conn){
	$searchQuery = $_POST['searchQuery'];
	$id = $_POST['view_id'];
	$sql = "SELECT * FROM tbl_MyProject_Services_History WHERE (History_id = ? OR filename LIKE ?) AND MyPro_PK = ? AND is_deleted=0";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $searchQuery, $searchQueryWildcard, $id);
	$searchQueryWildcard = '%' . $searchQuery . '%';
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		echo '<ul class="results-a">';
		while ($row = $result->fetch_assoc()) {
			echo '<li><a  id="cardData" data-id="' . $row["History_id"] . '">' . $row['filename'] . '</a></li>';
		}
		echo '</ul>';
	} else {
		echo '<ul class="results-a"><li>No results found.</li></ul>';
	}
	$stmt->close();
}
function changeSubtaskDate($conn) {
	$subTaskId = $_POST['subTaskId'];
	$startDate = $_POST['StartDate'];
	$endDate = $_POST['EndDate'];
	$query = "UPDATE tbl_myproject_services_childs_action_items
		SET CAI_Action_date = ?, CAI_Action_due_date = ?
		WHERE CAI_id = ?";
	$statement = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($statement, "ssi", $startDate, $endDate, $subTaskId);
	mysqli_stmt_execute($statement);
	if (mysqli_affected_rows($conn) > 0) {
		$response = array(
			'status' => 'success',
			'message' => 'Subtask date changed successfully'
		);
	} else {
		$response = array(
			'status' => 'error',
			'message' => 'Failed to change subtask date'
		);
	}
	$jsonResponse = json_encode($response);
	echo $jsonResponse;
	mysqli_stmt_close($statement);
	exit;
}
function showCalendar($conn) {
	$subTask = $_POST['subTaskId'];
	$query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE CAI_id  = '$subTask'";
	$result = mysqli_query($conn, $query);
	$data = array();
	while ($row1 = mysqli_fetch_array($result)) {
		$startDat = $row1['CAI_Action_date'];
		$dueDate = $row1['CAI_Action_due_date'];

		$data['startDate'] = $startDat;
		$data['dueDate'] = $dueDate;
	}

	echo json_encode($data);
}
function deleteSelectedSubTask($conn) {
	$response = array();

	if (isset($_POST['subTaskId'], $_POST['reason'])) {
		$id = intval($_POST['subTaskId']);
		$reason = mysqli_real_escape_string($conn, $_POST['reason']);
		$current_userID = $_COOKIE['ID'];
		$message = array();
		array_push($message, $current_userID);
		array_push($message, $reason);
		$message = implode(" | ", $message);

		$query = "UPDATE tbl_MyProject_Services_Childs_action_Items SET is_deleted = 1, reason = ? WHERE CAI_id = ?";
		$stmt = mysqli_prepare($conn, $query);
		
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "si", $message, $id);
			
			if (mysqli_stmt_execute($stmt)) {
				$response['success'] = true;
				$response['message'] = 'Subtask deleted successfully.';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error deleting subtask: ' . mysqli_stmt_error($stmt);
			}
			
			mysqli_stmt_close($stmt);
		} else {
			$response['success'] = false;
			$response['message'] = 'Error preparing statement: ' . mysqli_error($conn);
		}
	} else {
		$response['success'] = false;
		$response['message'] = 'Invalid input data.';
	}

	header('Content-Type: application/json');
	echo json_encode($response);
}

function updateCompleteStatusSubTask($conn) {
	$id = isset($_POST['subTaskId']) ? intval($_POST['subTaskId']) : 0;
	$renderedEstimated = isset($_POST['renderedEstimated']) ? intval($_POST['renderedEstimated']) : 0;
	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items
			SET CAI_Rendered_Minutes = $renderedEstimated, CIA_progress = 2
			WHERE CAI_id = $id";

	if ($conn->query($sql) === TRUE) {
		echo "success";
	} else {
		echo "error";
	}
}
function viewSubTaskData($conn,$base_url){
	$viewSubTaskid = $_POST["taskId"];
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	$current_task_assign = $rowUser['employee_id'];
	
	$query = "SELECT * 
		FROM tbl_MyProject_Services_Childs_action_Items tmscai
		LEFT JOIN tbl_user the ON tmscai.CAI_Assign_to = the.employee_id
		LEFT JOIN tbl_MyProject_Services_Action_Items tmsai ON tmscai.CAI_Action_taken = tmsai.Action_Items_id
		WHERE tmscai.CAI_id = ? LIMIT 1";
	$stmt = mysqli_prepare($conn, $query);
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "i", $viewSubTaskid);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$response ='';
		if ($row1 = mysqli_fetch_assoc($result)) {
			$owner = $row1['CAI_Assign_to'];
			if($owner == NULL){
				$profilePicture = "";
				$initials = "N/A";
				$tooltip="Empty";
				$fullName = 'Empty';
			} else {
				$query1 = "SELECT * FROM tbl_user where employee_id = '$owner'";
				$result1 = mysqli_query($conn, $query1);
				while ($profile = mysqli_fetch_array($result1)) {
					$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$profile['ID']."'");

					if (mysqli_num_rows($selectUserInfo) > 0) {
						$rowInfo = mysqli_fetch_assoc($selectUserInfo);
						$current_userAvatar = $rowInfo['avatar'];
					}
					$firstNameInitial = strtoupper(substr($profile['first_name'], 0, 1));
					$lastNameInitial = strtoupper(substr($profile['last_name'], 0, 1));
				}

				$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';

				$firstNameInitial = strtoupper(substr($row1['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($row1['last_name'], 0, 1));
				$initials = $firstNameInitial . $lastNameInitial;
				$fullName = $row1['first_name'] . '&nbsp;' . $row1['last_name'];
			}
			$randomColor = '#' . substr(md5(rand()), 0, 6);
			if($row1['CIA_progress']==0){
				$stats = "Not Started";
			}
			else if($row1['CIA_progress'] == 1){
				$stats = "In Progress";
			}else if($row1['CIA_progress'] == 2){
				$stats = "Completed";
			}
			$disabledbutton = ($portal_user == $row1['CAI_User_PK'] || $current_task_assign == $row1['CAI_Assign_to']) ? '' : 'disabled';
			$response.='<div>';
				$response .= '<div class="card-header">
					<ul class="list-items">
						<li>
							<div class="col1">
								<div class="cont">
									<div class="cont-col1">
										<div class="desc">
											<span class="label label-m label-default ">
												Task Name
											</span>&nbsp; <i class="fa fa-tasks" aria-hidden="true"></i>
											<span  class="editableSubtask" id="editableTextSubtask'.$viewSubTaskid.'" ondblclick="makeEditableSubtask('.$viewSubTaskid.')">' . $row1['CAI_filename'] . '</span>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="col1">
								<div class="cont">
									<div class="cont-col1">
										<div class="desc">
											<span class="label label-m label-default ">Assignee</span>&nbsp;';
											if (!empty($profilePicture)) {
												$response .= '<a href="#">
													<span class="photo">
														<img src="'.$profilePicture.'" class="img-circle" alt="'.$initials.'" width="27px" height="27px">
													</span>
												</a>
												<span class="uppercase">'.$fullName.'</span>';
											} else {
												$response .= '<span class="photo">
													<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
												</span>
												<span class="uppercase">'.$fullName.'</span>';
											}
											$response .= '<span class="pull-right">
												<a id="changeSubTaskAssignee" data-id="'.$viewSubTaskid.'" class="btn btn-circle btn-outline gray">
													<i class="fa fa-exchange" aria-hidden="true"></i>
													</button>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="col1">
								<div class="cont">
									<div class="cont-col1">
										<div class="desc">
											<span class="label label-m label-default ">Due Date</span>&nbsp;
											<input type="hidden" id="calendarHistoryDate" value="' . date("Y-m-d", strtotime($row['CAI_Action_due_date'])) . '">
											<span class="ui calendar" id="example10" data-id="'.$viewSubTaskid.'">
												<i class="fa fa-calendar"></i>&nbsp;' . date("Y-m-d", strtotime($row1['CAI_Action_due_date'])) . '
											</span>
										</div>
									</div>
									<div class="cont-col2"></div>
								</div>
							</div>
						</li>
						<li>';
							if($user_id == 34){
								$response .='<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="desc">
												<span class="label label-m label-default ">Account</span>&nbsp;';
												$response .='<select disabled style="border: 1px solid #c2cad800;">
													<option active><span>' . $row1['CAI_Accounts'] . '</span></option>';
													$query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE name != ? AND is_status = 0 ORDER BY name ASC";
													$stmt_accounts = mysqli_prepare($conn, $query_accounts);
													mysqli_stmt_bind_param($stmt_accounts, "s", $row1['CAI_Accounts']); // Assuming h_accounts is a string, change "i" to "s"
													mysqli_stmt_execute($stmt_accounts);
													$result_accounts = mysqli_stmt_get_result($stmt_accounts);

													while ($row_accounts = mysqli_fetch_array($result_accounts)) {
														$response .= '<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
													}
													$stringProduct = strip_tags($row1['CAI_description']);
												$response.= '</select>';
								   
											$response .='</div>
										</div>
										<div class="cont-col2"></div>
									</div>
								</div>';
							}  
						$response.='</li>
					</ul>
					<div class="row align-items-center"></div>
				</div>
				<hr>
				<h4>Task Description:</h4>
				<p id="editableTextSubDescription'.$viewSubTaskid.'" ondblclick="makeEditableSubDescription('.$viewSubTaskid.')" class="editableSubDescription todo-task-modal-bg">
					<i>'.$row1["CAI_description"]. '</i>
				</p>
			</div>';
			if($user_id == 34){
				$response.='<div class="portlet tasks-widget">
					<div class="portlet-title">
						<div class="caption">
							<div class="btn-group">
								<button id="getChildSubTaskFormModal" data-id="' . $row1['CAI_id'] . '" class="btn btn-circle btn-outline green">
									<i class="fa fa-plus"></i>&nbsp;
									<span class="hidden-sm hidden-xs"><i></i>Sub Tasks&nbsp;</span>
								</button>
							</div>
						</div>
						<div class="actions">
							<div class="btn-group">
							 <input type="hidden" id="subTaskIdselected" value="">
								<span id="iconsContainerOtherAction" style="display: none;">
									<button type="button" data-id="' . $row1['CAI_id'] . '" class="btn btn-circle btn-outline red" id="DeleteSelected"><i class="fa fa-trash"></i> Delete</button>
								</span>
							</div>
						</div>
					</div>
					<div class="portlet-body" style="overflow:visible;">
						<div class="task-content">
							<ul class="feeds list-items" id="task_list_child"></ul>
						</div>
					</div>
				</div>';
			}
			$response.='<div class="portlet tasks-widget">
				<hr>
				<div class="'.$disabledbutton.' portlet-title">
					<div class="caption">
						<div class="btn-group">
							<button  id="childgetModalDocumentForm" data-id="' . $viewSubTaskid . '" type="button" class="btn btn-circle btn-outline blue">
								<i class="fa fa-plus"></i>&nbsp;
								<span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
							</button>
						</div>
					</div>
				</div>
				<div class="portlet-body">
					<div class="task-content">
						<ul class="task-list" id="SubtaskDocument"></ul>
					</div>
				</div>
			</div>
			<div id="section-1">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bubble font-hide hide"></i>
						<span class="caption-subject font-hide bold uppercase">Comments</span>
					</div>
				</div>
				<hr>
				<div class="portlet-body" id="chats">
					<div class="scroller" style="overflow-y: auto;height: 100px;" data-always-visible="1" data-rail-visible1="1">
						<ul class="chats" id="listOfChatsSubtask"></ul>
					</div>
				</div>
			</div>';
			echo $response;
		} else {
			echo "No matching row found.";
		}
	} else {
		echo "Error retrieving data from the database.";
	}
}
function loadingSubtaskdocument($conn){
	$viewSubTaskid = $_POST['subTaskid'];
	$sql = "SELECT * FROM tbl_myproject_services_documents 
	LEFT JOIN  tbl_MyProject_Services_History ON tbl_myproject_services_documents.history_id = tbl_MyProject_Services_History.History_id 
	LEFT JOIN tbl_user ON tbl_MyProject_Services_History.user_id = tbl_user.ID
	WHERE tbl_myproject_services_documents.history_id = '$viewSubTaskid'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$filename = $row['tmsd_filename'];
			$file = $row['tmsd_files'];
			$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
			$icon = '<i class="fa fa-file"></i>';
			switch ($fileExtension) {
				case 'docx':
					$icon = '<i style="color:#2195f9"  class="fa fa-file-word-o" aria-hidden="true"></i>';
					break;
				case 'pdf':
					$icon = '<i style="color:#e43a45"  class="fa fa-file-pdf-o" aria-hidden="true"></i>';
					break;
				case 'xls':
					$icon = '<i style="color:green" class="fa fa-file-excel-o" aria-hidden="true"></i>';
					break;
			}
			$response .= '<li>
				<div class="task-checkbox">
					<div   class="mt-action-img">
					' . $icon . '
					</div>
				</div>
				<div class="task-title">
					<div class="mt-action-details" style="width:70%;text-align:left;">
						<span class="task-title-sp" style="font-size:11px;">' . $filename . '</span>
					</div>
				</div>
				<div class="task-config">
					<div class="task-config-btn btn-group">
						<div class="btn-group">
							<a class="btn btn-circle btn-outline gray" href="' . $base_url . 'resources/uploads/' . $filename . '">
								<i class="fa fa-download"></i>&nbsp;
								<span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
							</a>
						</div>
					</div>
				</div>
			</li>';
		}
	} 
}
function php_mailer($from, $to, $user, $subject, $body) {
	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
	  //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
		$mail->CharSet = 'UTF-8';
		$mail->Host       = 'interlinkiq.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'admin@interlinkiq.com';
		$mail->Password   = 'L1873@2019new';
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port       = 465;
		$mail->setFrom('services@interlinkiq.com', 'CannOS');
		$mail->addAddress($to, $user);
		$mail->addReplyTo($from, $user);
	  //  $mail->addCC('services@interlinkiq.com');

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
function php_mailer_1($to, $user, $subject, $body, $from, $name) {
	// require 'PHPMailer/src/Exception.php';
	// require 'PHPMailer/src/PHPMailer.php';
	// require 'PHPMailer/src/SMTP.php';

	$mail = new PHPMailer(true);
	try {
	    $mail->isSMTP();
		// $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
	    $mail->Host       = 'interlinkiq.com';
	    $mail->CharSet 	  = 'UTF-8';
	    $mail->SMTPAuth   = true;
	    $mail->Username   = 'admin@interlinkiq.com';
	    $mail->Password   = 'L1873@2019new';
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	    $mail->Port       = 465;
	    $mail->clearAddresses();
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
	    $mail->Host       = 'interlinkiq.com';
	    $mail->CharSet 	  = 'UTF-8';
	    $mail->SMTPAuth   = true;
	    $mail->Username   = 'admin@interlinkiq.com';
	    $mail->Password   = 'L1873@2019new';
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	    $mail->Port       = 465;
	    $mail->clearAddresses();
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

function countNumberOfcolumnStatus($conn){
	$view_id = $_GET['view_id'];
	$query = "SELECT tmsh_column_status, COUNT(*) AS count FROM tbl_MyProject_Services_History WHERE is_deleted = 0 AND MyPro_PK='$view_id' AND tmsh_column_status IN (0, 1, 2) GROUP BY tmsh_column_status";
	$result = $conn->query($query);
	$count = array();
	while ($row = $result->fetch_assoc()) {
		$count[$row['tmsh_column_status']] = $row['count'];
	}
	echo json_encode($count);
}
function changeColumnStatusClone($conn, $cardId, $columnId) {
 $stmt = $conn->prepare("UPDATE tbl_MyProject_Services_History SET tmsh_column_status = ? WHERE History_id = ?");
	$stmt->bind_param("ii", $columnId, $cardId);
	$stmt->execute();

	$response = array();
	if ($stmt->affected_rows > 0) {
		$response['success'] = true;
		$response['message'] = 'Card status updated successfully';
	} else {
		$response['success'] = false;
		$response['message'] = 'Failed to update card status';
	}

	$stmt->close();

	// Return the response as JSON
	header('Content-Type: application/json');
	echo json_encode($response);
}
// will delete after the test
function changeColumnStatus($conn, $cardId, $columnId) {
  $sql = "UPDATE tbl_MyProject_Services_History SET tmsh_column_status = ? WHERE History_id = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $columnId, $cardId);
  $stmt->execute();

  if ($stmt->affected_rows > 1) {
	echo "1";
  } else {
	echo "0";
  }

  $stmt->close();
}
// end of it
function addingProjectcollaborator($conn){
	if (!empty($_COOKIE['switchAccount'])) {
		$portal_user = $_COOKIE['ID'];
		$user_id = $_COOKIE['switchAccount'];
	}
	else {
		$portal_user = $_COOKIE['ID'];
		$user_id = employerID($portal_user);
	}
	$mail_sent = 0;
		
	$viewId = $_POST['viewid'];
	$collaborators = $_POST['collaboratorSelect'];
	// $viewId = mysqli_real_escape_string($conn, $viewId);
	// $collaborators = array_map('intval', $collaborators);

	$collaboratorPK = implode(', ', $collaborators);
	$updateQuery = "UPDATE tbl_MyProject_Services SET Collaborator_PK = '$collaboratorPK' WHERE MyPro_id = $viewId";

	if (mysqli_query($conn, $updateQuery)) {
		echo "Collaborators updated successfully.";
	} else {
		echo "Error updating collaborators: " . mysqli_error($conn);
	}
	
	$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $viewId" );
	if ( mysqli_num_rows($selectData) > 0 ) {
	    $rowData = mysqli_fetch_array($selectData);
	    $data_name = $rowDataUser["Project_Name"];
	    
    	    
    	$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $portal_user" );
    	if ( mysqli_num_rows($selectUser) > 0 ) {
    	    $rowUser = mysqli_fetch_array($selectUser);
        	$user_fullname = $rowUser["first_name"] .' '. $rowUser["last_name"];
        	$data_email = $rowUser["email"];
    	}
    	
    	$selectDataUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE user_id = $user_id" );
    	if ( mysqli_num_rows($selectDataUser) > 0 ) {
    		while($rowDataUser = mysqli_fetch_array($selectDataUser)) {
        		$datauser_fullname = $rowDataUser["first_name"] .' '. $rowDataUser["last_name"];
        		$datauser_email = $rowDataUser["email"];
        
        		$from = $user_fullname;
        		$sender = $data_email;
        		$to = $datauser_email;
        		$user = $datauser_fullname;
        		$subject = 'New Project Shared with You:'.$data_name;




        		$body = $user_fullname.' shared a project with you<br><br>
        		
        		<b>Project Name</b><br>
        		'.$data_name.'<br><br>
        		
        		Thanks';
        		
        		if ($mail_sent == 0) {
    				php_mailer_1($to, $user, $subject, $body, $from, $sender); 
    				$mail_sent++;
    			}
    			else { php_mailer_2($to, $user, $subject, $body, $from, $sender); }
    		}
    	}
	}
}
function addingComment($conn) {
	$taskIds = $_POST['Task_ids'];
	$userId = $_POST['user_id'];
	$comment = $_POST['comment'];
	$taskIds = $conn->real_escape_string($taskIds);
	$userId = $conn->real_escape_string($userId);
	$comment = $conn->real_escape_string($comment);

	$query = "INSERT INTO tbl_MyProject_Services_Comment(Comment_Task, user_id, Task_ids, Comment_Date) 
			  VALUES ('$comment', $userId, $taskIds, NOW())";

	if ($conn->query($query)) {
		if (preg_match('/@(\w+\s+\w+)/i', $comment, $matches)) {
			$mentionedName = $matches[1];
			$query1 = "SELECT email FROM tbl_user WHERE first_name = '$mentionedName'";
			$result1 = $conn->query($query1);
			$subject="New Comment Added: [Task/Subtask Name] ";
			if ($result1 && $result1->num_rows > 0) {
			    $row1 = $result1->fetch_assoc();
				$email = $row1['email'];
				$mention = "Mentioned You In a Comment";
				$commentBody = "Hey $mentionedName,<br><br>You've been mentioned in a comment:<br><br>'$comment'.<br><br>Just thought you should know! ðŸ˜‰";
				ignore_user_abort(true);
				set_time_limit(0);
				header('Connection: close');
				header('Content-Length: ' . ob_get_length());
				ob_end_flush();
				ob_flush();
				flush();
				
				
				$selectHistory = mysqli_query( $conn,"SELECT
                    c.Task_ids AS c_Task_ids,
                    c.Comment_Task AS c_Comment_Task,
                    c.user_id AS c_user_id,
                    c.Comment_Date AS c_Comment_Date,
                    u.first_name AS u_first_name,
                    u.last_name AS u_last_name,
                    u.client AS u_client,
                    h.filename AS h_filename
                    FROM tbl_MyProject_Services_Comment AS c

                    LEFT JOIN (
                    	SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON c.user_id = u.ID
                    
                    LEFT JOIN (
                    	SELECT
                        *
                        FROM tbl_MyProject_Services_History
                        WHERE is_deleted = 0
                    ) AS h
                    ON c.Task_ids = h.History_id
                    
                    WHERE c.Task_ids = $taskIds" );
                if ( mysqli_num_rows($selectHistory) > 0 ) {
                    $rowHistory = mysqli_fetch_array($selectHistory);
                    
                    $to = $row1['email'];
                    $user = $row1["first_name"].' '.$row1["last_name"];
                    $subject = 'New Comment Added: '.$rowHistory['h_filename'];
                    
                    $body = $rowHistory['h_filename'].' '.$rowHistory['h_filename'].' - '.$comment.'<br><br>';

                    if ($_COOKIE['client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }

                    if ($mail_sent > 0) {
                        php_mailer_2($to, $user, $subject, $body, $from, $name);
                        $mail_sent++;
                    } else {
                        php_mailer_1($to, $user, $subject, $body, $from, $name);
                        $mail_sent++;
                    }
                }
				
				
            
				
				// $mail = new PHPMailer(true);
				// $mail->isSMTP();
				// //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
				// $mail->CharSet = 'UTF-8';
				// $mail->Host       = 'interlinkiq.com';
				// $mail->SMTPAuth   = true;
				// $mail->Username   = 'admin@interlinkiq.com';
				// $mail->Password   = 'L1873@2019new';
				// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				// $mail->Port       = 465;
				// $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
				// $mail->addAddress($email);
				// $mail->isHTML(true);
				// $mail->Subject = $mention;
				// $mail->Body = "<!DOCTYPE html>
				// 	<html>
				// 		<head>
				// 			<style>
				// 				body {
				// 					font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				// 				}
				// 			</style>
				// 		</head>
				// 		<body>
				// 			<div class='container m-auto'>
				// 				$commentBody
				// 			</div>
				// 		</body>
				// 	</html>";
				// try {
				// 	$mail->send();
				// } catch (Exception $e) {
				// 	echo "Could not send. Mailer Error: {$mail->ErrorInfo}";
				// }
				echo 'Comment inserted successfully';
			 
			} else {
				echo 'No user found with the mentioned name';
			}
		} else {
			echo 'Comment inserted successfully';
		}
	} else {
		echo 'Error inserting comment: ' . $conn->error;
	}
}
function addingChildDocument($conn) {
	$parent_id = $_POST['ID'];
	// $filename = $_POST['CAI_filename'];
	$file = $_FILES['CAI_files'];
	if ($file['error'] === UPLOAD_ERR_OK) {
		$tempFilePath = $file['tmp_name'];
		$uploadDirectory = '../resources/uploads/';
		$newFilePath = $uploadDirectory . $file['name'];
		if (move_uploaded_file($tempFilePath, $newFilePath)) {
			$stmt = $conn->prepare('INSERT INTO tbl_myproject_services_documents (history_id, tmsd_filename, tmsd_files) VALUES (?, ?, ?)');
			$stmt->bind_param('sss', $parent_id, $file['name'], $newFilePath);
			$stmt->execute();

			if ($stmt->errno) {
				echo 'Error: ' . $stmt->error;
			} else {
			    
			    
			    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $user_id" );
                if ( mysqli_num_rows($selectUser) > 0 ) {
                    while($rowUser = mysqli_fetch_array($selectUser)) {
                        $to = $rowUser["email"];
                        $user = $rowUser["first_name"].' '.$rowUser["last_name"];
                    }
                }
                
			    $selectUser2 = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $portal_user" );
                if ( mysqli_num_rows($selectUser2) > 0 ) {
                    while($rowUser2 = mysqli_fetch_array($selectUser2)) {
                        $to2 = $rowUser2["email"];
                        $user2 = $rowUser2["first_name"].' '.$rowUser2["last_name"];
                    }
                }
                
                $selectHistory = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History WHERE History_id = $parent_id" );
                if ( mysqli_num_rows($selectHistory) > 0 ) {
                    while($rowHistory = mysqli_fetch_array($selectHistory)) {
                        $task = $rowHistory["filename"];
                    }
                }
                
                $subject = 'New Activity: [Task/Subtask Name]';
                $body = $user.' added a new document to '.$task.' <br><br>';

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

                if ($mail_sent > 0) {
                    php_mailer_2($to, $user, $subject, $body, $from, $name);
                    $mail_sent++;
                } else {
                    php_mailer_1($to, $user, $subject, $body, $from, $name);
                    $mail_sent++;
                }
			    
				echo 'success';
			}

			$stmt->close();
		} else {
			echo 'Error moving the uploaded file.';
		}
	} else {
		echo 'Error uploading the file: ' . $file['error'];
	}

	$conn->close();
}
function addingChildDocumentform($conn) {
	$ID = $_POST['id'];
	// $queryType_h = "SELECT * FROM tbl_MyProject_Services_History LEFT JOIN tbl_MyProject_Services ON MyPro_id = MyPro_PK WHERE History_id = ?";
	// $stmtType_h = mysqli_prepare($conn, $queryType_h);
	// mysqli_stmt_bind_param($stmtType_h, "i", $ID);
	// mysqli_stmt_execute($stmtType_h);
	// $resultType_h = mysqli_stmt_get_result($stmtType_h);
	$response = '';
	$response .='<input class="form-control" type="hidden" name="ID" id="parent_id" value="' . $ID . '" />';
	// while ($rowType_h = mysqli_fetch_array($resultType_h)) {
		$response .='
			<div class="form-group">
				<div class="col-md-12">
					<label>Supporting File</label>
				</div>
				<div class="col-md-12">
					<input class="form-control" type="file" name="CAI_files">
				</div>
			</div>';
		  
	// }
	echo $response;
}
function addingSubChildDocument($conn) {
	$parent_id = $_POST['ID'];
	// $filename = $_POST['CAI_filename'];
	$file = $_FILES['CAI_files'];
	if ($file['error'] === UPLOAD_ERR_OK) {
		$tempFilePath = $file['tmp_name'];
		$uploadDirectory = '../resources/uploads/';
		$newFilePath = $uploadDirectory . $file['name'];
		if (move_uploaded_file($tempFilePath, $newFilePath)) {
			$stmt = $conn->prepare('INSERT INTO tbl_myproject_services_documents (Parent_tmsd_id, tmsd_filename, tmsd_files) VALUES (?, ?, ?)');
			$stmt->bind_param('sss', $parent_id, $file['name'], $newFilePath);
			$stmt->execute();

			if ($stmt->errno) {
				echo 'Error: ' . $stmt->error;
			} else {
				echo 'success';
			}

			$stmt->close();
		} else {
			echo 'Error moving the uploaded file.';
		}
	} else {
		echo 'Error uploading the file: ' . $file['error'];
	}
	$conn->close();
}
function addingSubChildDocumentform($conn) {
	$ID = $_POST['id'];
	// $queryType_h = "SELECT * FROM tbl_MyProject_Services_History LEFT JOIN tbl_MyProject_Services ON MyPro_id = MyPro_PK WHERE History_id = ?";
	// $stmtType_h = mysqli_prepare($conn, $queryType_h);
	// mysqli_stmt_bind_param($stmtType_h, "i", $ID);
	// mysqli_stmt_execute($stmtType_h);
	// $resultType_h = mysqli_stmt_get_result($stmtType_h);
	$response ='<input class="form-control" type="hidden" name="ID" id="parent_id" value="' . $ID . '" />';
	// while ($rowType_h = mysqli_fetch_array($resultType_h)) {
		$response .='<div class="form-group">
			<div class="col-md-12">
				<label>Supporting File</label>
			</div>
			<div class="col-md-12">
				<input class="form-control" type="file" name="CAI_files">
			</div>
		</div>';
	// }
	echo $response;
}

function AddChildSubmit($conn) {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$ID = $_POST['ID'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$CIA_progress = $_POST['CIA_progress'];
	if (isset($_POST['parent_subtask_id']) == 0) {
		$CAI_parent_id = NULL;
	} else {
		$CAI_parent_id = $_POST['parent_subtask_id'];
	}
	$filename = $_POST['CAI_filename'];
	$description = $_POST['CAI_description'];
	if($user_id == 34){
		if($CIA_progress == 2){
			 $CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
		}else{
			 $CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
		}
 
		$Action_taken = $_POST['CAI_Action_taken'];
		$CAI_Accounts = $_POST['CAI_Accounts'];
		$checked_choice = $_POST['checked_choice'];
		$selectAction = mysqli_query( $conn,"SELECT * from tbl_MyProject_Services_Action_Items WHERE Action_Items_id  = $Action_taken" );
		$rowAction = mysqli_fetch_array($selectAction);
		$current_action = $rowAction['Action_Items_name'];
	} else {
		$CAI_Estimated_Time = NULL;
		$Action_taken = NULL;
		$CAI_Accounts = NULL;
	}
	// $Action_date = $_POST['CAI_Action_date'];
	if($_POST['CAI_Assign_to']=="NULL") {
		$CAI_Assign_to = NULL;
	} else {
		$CAI_Assign_to = $_POST['CAI_Assign_to'];
	}

	$CAI_Action_due_date = $_POST['CAI_Action_due_date'];
	$rand_id_pk = rand(1000, 1000000);
	$today = date('Y-m-d');
	$to_Db_files = '';
	$CAI_Rendered_Minutes = 0;
	$CAI_status = 1;
  
	 
	$files = $_FILES['CAI_files']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['CAI_files']['tmp_name'];
		$files = rand(1000, 1000000) . ' - ' . $files;
		$to_Db_files = $files;
		$path = $path . $files;
		move_uploaded_file($tmp, $path);
	}
	
	if($current_client == 1){
		$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items 
			(CAI_User_PK,
			Services_History_PK,
			Parent_MyPro_PK,
			Parent_CAI_id,
			CAI_files,
			CAI_filename,
			CAI_description,
			CAI_Action_date,
			CAI_Assign_to,
			CAI_Status,
			CIA_progress,
			CIA_Indent_Id,
			CAI_Rendered_Minutes,
			rand_id_pk,
			CAI_Action_due_date)
			VALUES (?,?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?, ?, ?)";

		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param(
			$stmt,
			"iiiissssiiiiiis",
			$portal_user,
			$ID,
			$Parent_MyPro_PK,
			$CAI_parent_id,
			$to_Db_files,
			$filename,
			$description,
			$today,
			$CAI_Assign_to,
			$CAI_status,
			$CIA_progress,
			$ID,
			$CAI_Rendered_Minutes,
			$rand_id_pk,
			
			$CAI_Action_due_date
		);

		if (mysqli_stmt_execute($stmt)) {
			$user = 'interlinkiq.com';
			$subject = 'Assigned to You: '.$filename;
			//  $frm = "manugasewinjames@gmail.com";
			//  $frm_name = "Bob green";
			//  $t = "manugasewinjames@gmail.com";
			//  $t_fname = "Bob green";

			//   from
			$cookie_frm = $_COOKIE['ID'];
			$selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
			while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; $frm_name = $rowFrom['first_name']; }

			//  to
			$cookie_to = $CAI_Assign_to;
			$select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
			while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }

			//   Projects
			$project_id = $ID;
			$project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services_History WHERE History_id = $project_id" );
			while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['filename']; }

			//  task
		    $child_n = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services_Childs_action_Items WHERE is_deleted=0 AND Services_History_PK = $ID AND DATE(CAI_Added) = '$today'");

			$added_users = [];

			while ($child_row_prj = mysqli_fetch_array($child_n)) {
				$base_url = "https://interlinkiq.com/";
				$username = $child_row_prj['CAI_User_PK'];
				$user_query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE ID = $username");
				$user_row = mysqli_fetch_array($user_query);
				
				$row_fulname = $user_row['first_name'].'&nbsp;'.$user_row['last_name'];
				$project = $child_row_prj['CAI_filename'];
				$date = $child_row_prj['CAI_Added'];
				$task_id = $project_id;
				$subtask_id = $child_row_prj['CAI_id'];
				// for li
				$dateTime = new DateTime($date, new DateTimeZone('UTC'));
				$dateTime->setTimezone(new DateTimeZone('America/Chicago'));
				$formattedDateTime = $dateTime->format('M d, Y \a\t g:ia');
				// end of li
				// 
				$now = new DateTime();
				$todaydateTime = new DateTime($now->format('Y-m-d H:i:s'));
				$todaydateTime->setTimezone(new DateTimeZone('America/Chicago'));
				$todayformattedDateTime = $todaydateTime->format('M d, Y \a\t g:ia');
				// 
				$added_users[] = ['username' => $row_fulname, 'project' => $project, 'date' => $formattedDateTime, 'project_id' => $task_id];
			}
			$body ='<!DOCTYPE html>
			<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
				<head>
					<title></title>
					<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
					<meta content="width=device-width, initial-scale=1.0" name="viewport" />
					<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
					<style>
						* {
							box-sizing: border-box;
						}
						
						body {
							margin: 0;
							padding: 0;
						}
						
						a[x-apple-data-detectors] {
							color: inherit !important;
							text-decoration: inherit !important;
						}
						
						#MessageViewBody a {
							color: inherit;
							text-decoration: none;
						}
						
						p {
							line-height: inherit
						}
						
						.desktop_hide,
						.desktop_hide table {
							mso-hide: all;
							display: none;
							max-height: 0px;
							overflow: hidden;
						}
						
						.image_block img+div {
							display: none;
						}
						
						@media (max-width:560px) {
							.social_block.desktop_hide .social-table {
								display: inline-block !important;
							}
							.mobile_hide {
								display: none;
							}
							.row-content {
								width: 100% !important;
							}
							.stack .column {
								width: 100%;
								display: block;
							}
							.mobile_hide {
								min-height: 0;
								max-height: 0;
								max-width: 0;
								overflow: hidden;
								font-size: 0px;
							}
							.desktop_hide,
							.desktop_hide table {
								display: table !important;
								max-height: none !important;
							}
						}
					</style>
				</head>

				<body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
					<table cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;table-layout:fixed;width:100%">
						<tbody>
							<tr>
								<td style="text-align:center">
									<table style="border-collapse:separate;border-spacing:0;margin-bottom:32px;margin-left:auto;margin-right:auto;margin-top:8px;table-layout:fixed;text-align:left;width:100%">
										<tbody>
											<tr>
												<td>
													<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
														<tbody>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td>
																					<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																						<tbody>
																							<tr>
																								<td style="background-color:#f8df72;border-radius:16px;line-height:16px;min-width:32px;height:32px;width:32px;text-align:center;vertical-align:middle">';
																									$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$cookie_frm."'");                                                           
																									if (mysqli_num_rows($selectUserInfo) > 0) {
																										$rowInfo = mysqli_fetch_assoc($selectUserInfo);
																										$current_userAvatar = $rowInfo['avatar'];
																									}                            
																									$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
																									$initials = "I";
																									$randomColor = '#' . substr(md5(rand()), 0, 6);
																									if (!empty($profilePicture)) {
																										$body .= '<img src="' . $profilePicture . '" class="img-circle" alt="' . $initials . '" width="27px" height="27px">';
																									} else {
																										$body .= '<span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">' . $initials . '</span>';
																									}
																								$body.='</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																				<td style="max-width:16px;min-width:16px;width:16px">&nbsp;</td>
																				<td>
																					<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																						<tbody>
																							<tr>
																								<td>
																									<a href="" style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:20px;font-weight:400;line-height:26px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$frm_name.' assigned a task to you</span></a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="line-height:16px;max-width:0;min-width:0;height:16px;width:0;font-size:16px">&nbsp;</td>
																			</tr>
																			<tr>
																				<td style="background-color:#edeae9;height:1px;width:100%"></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
														<tbody>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Task</span></td>
																			</tr>
																			<tr>
																				<td style="vertical-align:top">
																					<a href=""
																						style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:16px;font-weight:600;line-height:24px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$filename.'</span></a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Assigned to</span></td>
																				<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																				<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Due date</span></td>
																			</tr>
																			<tr>
																				<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$t_fname.'</span></td>
																				<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																				<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$CAI_Action_due_date.'</span></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Projects</span></td>
																			</tr>
																			<tr>
																				<td style="vertical-align:top">
																					<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																						<tbody>
																							<tr>
																								<td>
																									<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																										<tbody>
																											<tr>
																												<td style="line-height:20px">
																													<div style="display:inline-block;height:9px;width:9px;min-width:9px;border-radius:3px;background-color:#8d84e8"></div>
																												</td>
																												<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																												<td>
																													<a href=""
																														style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$prj.'</span></a>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0;border-color:#edeae9;border-radius:4px;border-style:solid;border-width:1px">
														<tbody>
															<tr>
																<td style="width:100%">
																	<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																				<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																				<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																			</tr>
																			<tr>
																				<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																				<td style="width:100%">
																					<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																						<tbody>';
																							foreach ($added_users as $user) {
																								$body .= '<tr>
																									<td>
																										<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																											<tbody>
																												<tr>
																													<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																													<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																												   
																													<td>
																													<span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>' . $user['username'] . '</strong> added to <a href="https://interlinkiq.com/test_task_mypro.php?view_id=' . $user['project_id'] . '#' . $ID . '" >' . $user['project'] . '</a> . '.$user['date'].'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																														<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																														</span>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																								</tr>
																								<tr>
																									<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																								</tr>';
																							}
																							$body .='<tr>
																								<td>
																									<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																										<tbody>
																											<tr>
																												<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																												<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																												<td>
																													<span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>'.$t_fname.'</strong> assigned to you · '.$todayformattedDateTime.'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																													<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																													</span>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																				<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																			</tr>
																			<tr>
																				<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																				<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																				<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
														<tbody>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
														<tbody>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="background-color:#4573d2;border-radius:4px">
																					<a href="https://interlinkiq.com/test_task_mypro.php?view_id='.$Parent_MyPro_PK.'"
																						style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #4573d2;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/test_task_mypro.php?view_id='.$project_id.'">
																						<span style="font-size:13px;font-weight:600;line-height:20px;color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																						View to MyPro</span>
																						</a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
																<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																<td>
																	<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="background-color:#ffffff;border-radius:4px">
																					<a href="https://interlinkiq.com/complete_task.php?comp_subtask_id='.$subtask_id.'&&comp_id='.$cookie_to.'"
																						style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #cfcbcb;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/complete_task.php?comp_subtask_id='.$subtask_id.'">
																						<span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																						Mark complete</span>
																						</a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
														<tbody>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																		<tbody>
																			<tr>
																				<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Collaborators</span></td>
																			</tr>
																			<tr>
																				<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																			</tr>
																			<tr>
																				<td style="vertical-align:top">
																					<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																						<tbody>
																							<tr>
																								<td>
																									<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																										<tbody>
																											<tr>';
																												$selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $Parent_MyPro_PK");
																												if (mysqli_num_rows($selectData) > 0) {
																													$row = mysqli_fetch_array($selectData);
																												}
																												
																												$queryCollabs = "SELECT * FROM tbl_hr_employee WHERE status = 1 ORDER BY first_name ASC";
																												$stmt = mysqli_prepare($conn, $queryCollabs);
																												mysqli_stmt_execute($stmt);
																												$resultCollabs = mysqli_stmt_get_result($stmt);
																												
																												while ($rowCollabs = mysqli_fetch_array($resultCollabs)) {
																													$array_collab = explode(", ", $row["Collaborator_PK"]);
																													$firstNameInitial = strtoupper(substr($rowCollabs['first_name'], 0, 1));
																													$lastNameInitial = strtoupper(substr($rowCollabs['last_name'], 0, 1));
																													$initials = $firstNameInitial . $lastNameInitial;
																													if (in_array($rowCollabs['ID'], $array_collab)) {
																														$body.='  <td>
																															<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																																<tbody>
																																	<tr>
																																		<td style="background-color:#f8df72;border-radius:12px;line-height:16px;min-width:24px;height:24px;width:24px;text-align:center;vertical-align:middle"><span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$initials.'</span></td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																														<td style="max-width:4px;min-width:4px;width:4px">&nbsp;</td>';
																													}
																												}
																											  
																											$body.='</tr>
																										</tbody>
																									</table>
																								</td>
																								<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																								<td style="vertical-align:middle"></td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
					</tbody>
					</table>
				</body>
			</html>';

			$mail = php_mailer($frm, $t, $user, $subject, $body);
			if($mail){ echo "success"; }
			else{ echo "Failed"; }
		} else {
			echo "not";
		}
	}else{
		$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items 
			(CAI_User_PK, 
			Services_History_PK, 
			Parent_MyPro_PK,
			Parent_CAI_id,
			CAI_files, 
			CAI_filename, 
			CAI_description,
			CAI_Estimated_Time, 
			CAI_Action_taken, 
			CAI_Action_date,
			CAI_Assign_to, 
			CAI_Status, 
			CIA_progress, 
			CIA_Indent_Id, 
			CAI_Rendered_Minutes, 
			rand_id_pk, 
			CAI_Accounts, 
			CAI_Action_due_date)
			VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param(
			$stmt,
			"iiiissssssiisiiiss",
			$portal_user,
			$ID,
			$Parent_MyPro_PK,
			$CAI_parent_id,
			$to_Db_files,
			$filename,
			$description,
			$CAI_Estimated_Time,
			$Action_taken,
			$today,
			$CAI_Assign_to,
			$CAI_status,
			$CIA_progress,
			$ID,
			$CAI_Rendered_Minutes,
			$rand_id_pk,
			$CAI_Accounts,
			$CAI_Action_due_date
		);

		if (mysqli_stmt_execute($stmt)){ 
			$sql1 = "INSERT INTO tbl_service_logs_draft (user_id, description, action, comment, account, task_date, minute) 
			VALUES ('$portal_user', '$filename', 'created', '$description', '$CAI_Accounts', '$today', '2')";
			if (mysqli_query($conn, $sql1)) {
				echo "Okay";
			}
		   
			if($CIA_progress == 2 && $checked_choice == "yes"){
				$reasons = NULL;
				$sql = "INSERT INTO tbl_service_logs (user_id, description, action, comment, account, task_date, minute)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
				$stmt = mysqli_prepare($conn, $sql);
				mysqli_stmt_bind_param($stmt, "issssss", $portal_user, $filename,$current_action,$description, $CAI_Accounts, $today, $CAI_Estimated_Time);
				if (mysqli_stmt_execute($stmt)) {
					echo "success";
				}
			} else if ($checked_choice == "no") {
				$sql2 = "INSERT INTO tbl_service_logs_draft (user_id, description, action, comment, account, task_date, minute) 
				VALUES ('$portal_user', '$filename', '$current_action', '$description', '$CAI_Accounts', '$today', '$CAI_Estimated_Time')";
				if (mysqli_query($conn, $sql2)) {
					echo "Successfully inserted data!";
				}
			}
		} else {
			echo "not";
		}
	}
}

function AddChildForm($conn) {
	$ID = $_POST['id'];
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$today = date('Y-m-d');
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	echo '<input class="form-control" type="hidden" name="ID" id="parent_id" value="' . $ID . '" />';

	$queryType_h = "SELECT * FROM tbl_MyProject_Services_History LEFT JOIN tbl_MyProject_Services ON MyPro_id = MyPro_PK WHERE History_id = ?";
	$stmtType_h = mysqli_prepare($conn, $queryType_h);
	mysqli_stmt_bind_param($stmtType_h, "i", $ID);
	mysqli_stmt_execute($stmtType_h);
	$resultType_h = mysqli_stmt_get_result($stmtType_h);

	while ($rowType_h = mysqli_fetch_array($resultType_h)) {
		echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="' . $rowType_h['MyPro_id'] . '" >';
		echo '<input type="hidden" class="form-control" name="rand_id_pk" value="' . $rowType_h['rand_id'] . '" >';
		echo '
		<div class="form-group">
			<div class="col-md-12">
				<label>Task Name</label>
			</div>
			<div class="col-md-12">
				<input class="form-control" type="text" name="CAI_filename" required />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<label>Supporting File</label>
			</div>
			<div class="col-md-12">
				<input class="form-control" type="file" name="CAI_files">
			</div>
		</div>';
	  	if($user_id == 34){
			echo '<div class="form-group">
				<div class="col-md-6">
					<label>Action Types</label>
					<select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
						<option value="">---Select---</option>';

						$queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items ORDER BY Action_Items_name ASC";
						$resultType = mysqli_query($conn, $queryType);

						while ($rowType = mysqli_fetch_array($resultType)) {
							echo '<option value="' . $rowType['Action_Items_id'] . '">' . $rowType['Action_Items_name'] . '</option>';
						}

						echo ' <option value="0">Others</option> 
					</select>
				</div>
				<div class="col-md-6">
					<label>Account</label>
					<select name="CAI_Accounts" class="form-control mt-multiselect btn btn-default" type="text">
						<option value="">---Select---</option>';
						echo '<option value="' .  $rowType_h['Accounts_PK']  . '" selected>' . $rowType_h['Accounts_PK'] . '</option>';
						echo'<option value="0">Others</option>';
						$query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE name != ? AND is_status = 0 ORDER BY name ASC";
						$stmt_accounts = mysqli_prepare($conn, $query_accounts);
						mysqli_stmt_bind_param($stmt_accounts, "s", $rowType_h['Accounts_PK']);
						mysqli_stmt_execute($stmt_accounts);
						$result_accounts = mysqli_stmt_get_result($stmt_accounts);

						while ($row_accounts = mysqli_fetch_array($result_accounts)) {
							echo'<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
						}
					echo '</select>
				</div>
			</div>';
		}
	    echo '<div class="form-group">
			<div class="col-md-12">
				<label>Description</label>
			</div>
			<div class="col-md-12">
				<textarea class="form-control" name="CAI_description" required></textarea>
			</div>
		</div>';

		if ($user_id == NULL) {
			echo '<div class="form-group">
				<div class="col-md-12">
					<label>(<i style="color:red;font-size:12px;"><b style="color:black;">"Yes"</b> it will automatically be reflected in your Service logs. If <b style="color:black;"> "NO"</b> to Auto logs for your review.</i>) </label><br>
					<label><input type="radio" name="checked_choice" value="yes" checked> Yes</label> &nbsp; <label><input type="radio" name="checked_choice" value="no" > No</label>
				</div>
			</div>';
		}
	 
		echo '<div class="form-group">
			<div class="col-md-12">
				<label>Status</label>
			</div>
			<div class="col-md-12">
				<select class="form-control" name="CIA_progress" id="progressSelect">
					<option value="0">Not Started</option>
					<option value="1">In Progress</option>
					<option value="2">Completed</option>
				</select>
			</div>
		</div>
		<div class="form-group">';
		 	// if($user_id == 34){
		   		echo '<div class="col-md-6">
					<label>Estimated Time (minutes)</label>
					<input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required />
				</div>';
			// } 
		   	echo '<div class="col-md-6">
				<label>Due Date</label>
				<input class="form-control" type="date" name="CAI_Action_due_date" value="' . $today . '" required />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<label>Assign to</label>
			</div>
			<div class="col-md-12">
				<select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
					<option value="NULL">---Select---</option>';
					$queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = ? AND status = 1 ORDER BY first_name ASC";
					$stmtAssignto = mysqli_prepare($conn, $queryAssignto);
					mysqli_stmt_bind_param($stmtAssignto, "i", $user_id);
					mysqli_stmt_execute($stmtAssignto);
					$resultAssignto = mysqli_stmt_get_result($stmtAssignto);

					while ($rowAssignto = mysqli_fetch_array($resultAssignto)) {
						echo '<option value="' . $rowAssignto['ID'] . '" ';
						echo $portal_user == $rowAssignto['ID'] ? 'selected' : '';
						echo '>' . $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name'] . '</option>';
					}

					$queryQuest = "SELECT * FROM tbl_user WHERE ID = ?";
					$stmtQuest = mysqli_prepare($conn, $queryQuest);
					mysqli_stmt_bind_param($stmtQuest, "i", $user_id);
					mysqli_stmt_execute($stmtQuest);
					$resultQuest = mysqli_stmt_get_result($stmtQuest);

					while ($rowQuest = mysqli_fetch_array($resultQuest)) {
						echo '<option value="' . $rowQuest['ID'] . '">' . $rowQuest['first_name'] . '</option>';
					}

					echo '<option value="0">Others</option> 
				</select>
			</div>
		</div>';
	}
}

function loadTask($conn){
	$base_url = "https://interlinkiq.com/";
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	$current_task_assign = $rowUser['employee_id'];
	
	$view_id = $_POST['id'];
	$response = '';
	$query = "SELECT * 
	FROM tbl_MyProject_Services_Childs_action_Items
	LEFT JOIN tbl_user ON tbl_MyProject_Services_Childs_action_Items.CAI_Assign_to = tbl_user.employee_id
	WHERE tbl_MyProject_Services_Childs_action_Items.Services_History_PK = '$view_id' AND tbl_MyProject_Services_Childs_action_Items.is_deleted=0 ORDER BY tbl_MyProject_Services_Childs_action_Items.CIA_progress=2 ASC";
	$result = mysqli_query($conn, $query);
	while ($row1 = mysqli_fetch_array($result)) {
		$owner = $row1['CAI_Assign_to'];
		if($owner == NULL){
			$initials = "N/A";
			$profilePicture="";
			$tooltip = "Empty";
		}else{
			$query1 = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result1 = mysqli_query($conn, $query1);
			while ($profile = mysqli_fetch_array($result1)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$profile['ID']."'");

				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($profile['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($profile['last_name'], 0, 1));
			}
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
			$initials = $firstNameInitial . $lastNameInitial;
			$tooltip = '' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '';
		}
		$actionDate = date('m/d', strtotime($row1['CAI_Action_date']));
		$actionDueDate = date('m/d', strtotime($row1['CAI_Action_due_date']));
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		if ($row1['CIA_progress'] == 0) {
			$status = "Not Started";
			$colorStatusSub = "label-danger";
		} else if ($row1['CIA_progress'] == 1) {
			$status = "In Progress";
			$colorStatusSub = "label-primary";
		} else if ($row1['CIA_progress'] == 2) {
			$status = "Completed";
			$colorStatusSub = "label-success";
		}
		$title = $row1['CAI_filename'];
		$max_length = 26;
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}


		$docs_id = $row1["CAI_id"];
		// $selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $id" );
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_myproject_services_documents WHERE history_id = $docs_id" );
		// mysqli_num_rows($selectData) > 0;


		// $query1_docs = "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = '.$row1["CAI_id"].'";
		// $result1_docs = mysqli_query($conn, "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = $row1["CAI_id"]");
		// $row1_docs = mysqli_fetch_array($result1_docs);
		
		$labelforAccounts = ($current_client == 1) ? ' <span class="label label-sm ' . $colorStatusSub . '">' .$status. '</span> ' : '<span class="label label-sm ' . $colorStatusSub . '">' . $row1["CAI_Accounts"] . '</span>';
		$disabledbutton = ($portal_user == $row1['CAI_User_PK'] || $current_task_assign == $row1['CAI_Assign_to']) ? '' : 'disabled';
		$disabledClass = ($row1['CIA_progress'] == 2) ? 'disabled' : '';
		$checkboxContent = ($row1['CIA_progress'] == 2) ? '
			<input data-view="' . $view_id . '" checked value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>' : '
			<input data-view="' . $view_id.'" value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>';
			$response .= '<li id="forCalendarrange">
			<div class="task-checkbox">' . $checkboxContent . '</div>
			<div class="task-title">
				<span style="cursor: pointer;"  class="task-title-sp"><a style="text-decoration: none;color: #717273;" href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" data-id="' . $row1['CAI_id'] . '">' . $truncated_title . '</a></span>
				'.$labelforAccounts.'               
				<span>
					<a class="'.$disabledbutton.'" data-view="' . $view_id . '" data-id="' . $row1["CAI_id"] . '" id="DeleteSelected"><i class="fa fa-trash-o"></i></a>
				</span>';

				if (mysqli_num_rows($selectData) > 0) {
					$response .= '<span><i class="icon-doc"></i>: '.mysqli_num_rows($selectData).'</span>';
				}
				
				
			$response .= '</div>
				<div class="task-config">
					<div data-id="' . $row1["CAI_id"] . '" class="task-config-btn btn-group" style="cursor:pointer;" id="input-picker">
						<span>' . $actionDueDate . '</span>
					</div>
					<div class="task-config-btn btn-group">';
									
						if (!empty($profilePicture)) {
							$response .= '<a href="#">
								<span class="photo" >
									<img src="'.$profilePicture.'" class="img-circle" alt="'.$initials.'" width="27px" height="27px">
								</span>
							</a>
							<span class="hidden task-title-sp">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
						} else {
							$response .= '<div>
								<span tooltip="'.$tooltip.'" class="photo">
									<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
								</span>
								<span class="hidden task-title-sp" style="font-size:10px;color:#838FA1;">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>
							</div>';
						}

					$response .= '<span>
						<a style="font-size:17px;padding:3px;" id="subTask" data-id="' . $row1["CAI_id"] . '"><i class="icon-arrow-right" aria-hidden="true"></i></a> 
					</span>
				</div>
			</div>
		</li>';
	}
	echo $response;
}
function loadTask_open($conn){
	$base_url = "https://interlinkiq.com/";
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	$current_task_assign = $rowUser['employee_id'];
	
	$view_id = $_POST['id'];
	$response = '';
	$query = "SELECT * 
	FROM tbl_MyProject_Services_Childs_action_Items
	LEFT JOIN tbl_user ON tbl_MyProject_Services_Childs_action_Items.CAI_Assign_to = tbl_user.employee_id
	WHERE tbl_MyProject_Services_Childs_action_Items.Services_History_PK = '$view_id' AND tbl_MyProject_Services_Childs_action_Items.is_deleted=0 ORDER BY tbl_MyProject_Services_Childs_action_Items.CIA_progress=2 ASC";
	$result = mysqli_query($conn, $query);
	while ($row1 = mysqli_fetch_array($result)) {
		$owner = $row1['CAI_Assign_to'];
		if($owner == NULL){
			$initials = "N/A";
			$profilePicture="";
			$tooltip = "Empty";
		}else{
			$query1 = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result1 = mysqli_query($conn, $query1);
			while ($profile = mysqli_fetch_array($result1)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$profile['ID']."'");

				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($profile['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($profile['last_name'], 0, 1));
			}
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
			$initials = $firstNameInitial . $lastNameInitial;
			$tooltip = '' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '';
		}
		$actionDate = date('m/d', strtotime($row1['CAI_Action_date']));
		$actionDueDate = date('m/d', strtotime($row1['CAI_Action_due_date']));
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		if ($row1['CIA_progress'] == 0) {
			$status = "Not Started";
			$colorStatusSub = "label-danger";
		} else if ($row1['CIA_progress'] == 1) {
			$status = "In Progress";
			$colorStatusSub = "label-primary";
		} else if ($row1['CIA_progress'] == 2) {
			$status = "Completed";
			$colorStatusSub = "label-success";
		}
		$title = $row1['CAI_filename'];
		$max_length = 26;
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}


		$docs_id = $row1["CAI_id"];
		// $selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $id" );
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_myproject_services_documents WHERE history_id = $docs_id" );
		// mysqli_num_rows($selectData) > 0;


		// $query1_docs = "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = '.$row1["CAI_id"].'";
		// $result1_docs = mysqli_query($conn, "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = $row1["CAI_id"]");
		// $row1_docs = mysqli_fetch_array($result1_docs);
		
		$labelforAccounts = ($current_client == 1) ? ' <span class="label label-sm ' . $colorStatusSub . '">' .$status. '</span> ' : '<span class="label label-sm ' . $colorStatusSub . '">' . $row1["CAI_Accounts"] . '</span>';
		$disabledbutton = ($portal_user == $row1['CAI_User_PK'] || $current_task_assign == $row1['CAI_Assign_to']) ? '' : 'disabled';
		$disabledClass = ($row1['CIA_progress'] == 2) ? 'disabled' : '';
		$checkboxContent = ($row1['CIA_progress'] == 2) ? '
			<input data-view="' . $view_id . '" checked value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>' : '
			<input data-view="' . $view_id.'" value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>';

		if ($row1['CIA_progress'] != 2) {
			$response .= '<li id="forCalendarrange">
				<div class="task-checkbox">' . $checkboxContent . '</div>
				<div class="task-title">
					<span style="cursor: pointer;"  class="task-title-sp"><a style="text-decoration: none;color: #717273;" href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" data-id="' . $row1['CAI_id'] . '">' . $truncated_title . '</a></span>
					'.$labelforAccounts.'               
					<span>
						<a class="'.$disabledbutton.'" data-view="' . $view_id . '" data-id="' . $row1["CAI_id"] . '" id="DeleteSelected"><i class="fa fa-trash-o"></i></a>
					</span>';

					if (mysqli_num_rows($selectData) > 0) {
						$response .= '<span><i class="icon-doc"></i>: '.mysqli_num_rows($selectData).'</span>';
					}
					
					
				$response .= '</div>
					<div class="task-config">
						<div data-id="' . $row1["CAI_id"] . '" class="task-config-btn btn-group" style="cursor:pointer;" id="input-picker">
							<span>' . $actionDueDate . '</span>
						</div>
						<div class="task-config-btn btn-group">';
										
							if (!empty($profilePicture)) {
								$response .= '<a href="#">
									<span class="photo" >
										<img src="' . $profilePicture . '" class="img-circle" alt="' . $initials . '" width="27px" height="27px">
									</span>
								</a>
								<span class="hidden task-title-sp">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
							} else {
								$response .= '<div>
									<span tooltip="'.$tooltip.'" class="photo">
										<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
									</span>
									<span class="hidden task-title-sp" style="font-size:10px;color:#838FA1;">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
							}

						$response .= '<span>
							<a style="font-size:17px;padding:3px;" id="subTask" data-id="' . $row1["CAI_id"] . '"><i class="icon-arrow-right" aria-hidden="true"></i></a> 
						</span>
					</div>
				</div>
			</li>';
		}
	}
	echo $response;
}
function loadTask_close($conn){
	$base_url = "https://interlinkiq.com/";
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	$current_task_assign = $rowUser['employee_id'];
	
	$view_id = $_POST['id'];
	$response = '';
	$query = "SELECT * 
	FROM tbl_MyProject_Services_Childs_action_Items
	LEFT JOIN tbl_user ON tbl_MyProject_Services_Childs_action_Items.CAI_Assign_to = tbl_user.employee_id
	WHERE tbl_MyProject_Services_Childs_action_Items.Services_History_PK = '$view_id' AND tbl_MyProject_Services_Childs_action_Items.is_deleted=0 ORDER BY tbl_MyProject_Services_Childs_action_Items.CIA_progress=2 ASC";
	$result = mysqli_query($conn, $query);
	while ($row1 = mysqli_fetch_array($result)) {
		$owner = $row1['CAI_Assign_to'];
		if($owner == NULL){
			$initials = "N/A";
			$profilePicture="";
			$tooltip = "Empty";
		}else{
			$query1 = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result1 = mysqli_query($conn, $query1);
			while ($profile = mysqli_fetch_array($result1)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$profile['ID']."'");

				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($profile['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($profile['last_name'], 0, 1));
			}
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
			$initials = $firstNameInitial . $lastNameInitial;
			$tooltip = '' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '';
		}
		$actionDate = date('m/d', strtotime($row1['CAI_Action_date']));
		$actionDueDate = date('m/d', strtotime($row1['CAI_Action_due_date']));
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		if ($row1['CIA_progress'] == 0) {
			$status = "Not Started";
			$colorStatusSub = "label-danger";
		} else if ($row1['CIA_progress'] == 1) {
			$status = "In Progress";
			$colorStatusSub = "label-primary";
		} else if ($row1['CIA_progress'] == 2) {
			$status = "Completed";
			$colorStatusSub = "label-success";
		}
		$title = $row1['CAI_filename'];
		$max_length = 26;
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}


		$docs_id = $row1["CAI_id"];
		// $selectData = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE ID = $id" );
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_myproject_services_documents WHERE history_id = $docs_id" );
		// mysqli_num_rows($selectData) > 0;


		// $query1_docs = "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = '.$row1["CAI_id"].'";
		// $result1_docs = mysqli_query($conn, "SELECT COUNT(*) AS counter_docs FROM tbl_myproject_services_documents WHERE history_id = $row1["CAI_id"]");
		// $row1_docs = mysqli_fetch_array($result1_docs);
		
		$labelforAccounts = ($current_client == 1) ? ' <span class="label label-sm ' . $colorStatusSub . '">' .$status. '</span> ' : '<span class="label label-sm ' . $colorStatusSub . '">' . $row1["CAI_Accounts"] . '</span>';
		$disabledbutton = ($portal_user == $row1['CAI_User_PK'] || $current_task_assign == $row1['CAI_Assign_to']) ? '' : 'disabled';
		$disabledClass = ($row1['CIA_progress'] == 2) ? 'disabled' : '';
		$checkboxContent = ($row1['CIA_progress'] == 2) ? '
			<input data-view="' . $view_id . '" checked value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>' : '
			<input data-view="' . $view_id.'" value="' . $row1['CAI_id'] . '" class="checkbox-effect checkbox-effect-5" id="get-up-' . $row1['CAI_id'] . '" type="checkbox" name="get-up-5"/>
			<label class="checkbox-label" for="get-up-' . $row1['CAI_id'] . '"></label>';

		if ($row1['CIA_progress'] == 2) {
			$response .= '<li id="forCalendarrange">
				<div class="task-checkbox">' . $checkboxContent . '</div>
				<div class="task-title">
					<span style="cursor: pointer;"  class="task-title-sp"><a style="text-decoration: none;color: #717273;" href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" data-id="' . $row1['CAI_id'] . '">' . $truncated_title . '</a></span>
					'.$labelforAccounts.'               
					<span>
						<a class="'.$disabledbutton.'" data-view="' . $view_id . '" data-id="' . $row1["CAI_id"] . '" id="DeleteSelected"><i class="fa fa-trash-o"></i></a>
					</span>';

					if (mysqli_num_rows($selectData) > 0) {
						$response .= '<span><i class="icon-doc"></i>: '.mysqli_num_rows($selectData).'</span>';
					}
					
					
				$response .= '</div>
					<div class="task-config">
						<div data-id="' . $row1["CAI_id"] . '" class="task-config-btn btn-group" style="cursor:pointer;" id="input-picker">
							<span>' . $actionDueDate . '</span>
						</div>
						<div class="task-config-btn btn-group">';
										
							if (!empty($profilePicture)) {
								$response .= '<a href="#">
									<span class="photo" >
										<img src="' . $profilePicture . '" class="img-circle" alt="' . $initials . '" width="27px" height="27px">
									</span>
								</a>
								<span class="hidden task-title-sp">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
							} else {
								$response .= '<div>
									<span tooltip="'.$tooltip.'" class="photo">
										<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
									</span>
									<span class="hidden task-title-sp" style="font-size:10px;color:#838FA1;">' . $row1['first_name'] . '&nbsp;' . $row1['last_name'] . '</span>';
							}

						$response .= '<span>
							<a style="font-size:17px;padding:3px;" id="subTask" data-id="' . $row1["CAI_id"] . '"><i class="icon-arrow-right" aria-hidden="true"></i></a> 
						</span>
					</div>
				</div>
			</li>';
		}
	}
	echo $response;
}

//  <button href="#ViewSubTaskForEdit" data-toggle="modal" id="editViewSubTask" type="button" data-id="' . $view_id . '" class="'.$disabledClass.' btn btn-outline blue"><i class="fa fa-pencil"></i></button>
function taskDataModal($conn) {
	
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	$current_task_assign = $rowUser['employee_id'];
	
	$view_id = $_POST['id'];
	$base_url = "https://interlinkiq.com/";
	$sql = $conn->prepare("SELECT *, tbl_MyProject_Services_History.user_id AS owner 
	FROM tbl_MyProject_Services_History 
	LEFT JOIN tbl_MyProject_Services_Action_Items ON tbl_MyProject_Services_History.Action_taken = tbl_MyProject_Services_Action_Items.Action_Items_id
	LEFT JOIN tbl_MyProject_Services_Childs_action_Items ON tbl_MyProject_Services_History.History_id = tbl_MyProject_Services_Childs_action_Items.Services_History_PK
	WHERE tbl_MyProject_Services_History.History_id = ?");
	$sql->bind_param("i", $view_id);
	$sql->execute();
	$result = $sql->get_result();
	$response = '';
	echo $sql->error;
	while ($row = $result->fetch_assoc()) {
		if($row['tmsh_column_status']==0){
			$history_stats = "Not Started";
			$colorStatus = "label-danger";
		} else  if ($row['tmsh_column_status'] == 1) {
			$history_stats = "In-Progress";
			$colorStatus = "label-primary";
		} else  if ($row['tmsh_column_status'] == 2) {
			$history_stats = "Completed";
			$colorStatus = "label-success";
		}
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		$currentDay = date('j');
		$disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
		// $disabledbutton = ($current_task_assign == $row['Assign_to_history']) ? '' : 'disabled';
		$response .= ' <div class="card-header">
			<p class="todo-task-modal-title todo-inline">
				<button data-id="'.$view_id.'" id="changeStatusHistory" style="color:white;" class="btn btn-circle btn-outline '.$colorStatus.'"><i class="fa fa-check-circle-o"></i>&nbsp;' . $history_stats . '</button>
				<span class="label label-sm"></span>
				<a class="pull-right" id="cloaserightpanel"><i style="font-size:20px;" class="icon-login"></i></a>
			</p>
		</div>
		<hr>
		<div class="card-header">
			<ul class="list-items">
				<li>
					<div class="col1">
						<div class="cont">
							<div class="cont-col1">
								<div class="desc">
									<span class="label label-m label-default ">Task Name</span>&nbsp; <i class="fa fa-tasks" aria-hidden="true"></i>
									<span  class="editable" id="editableText'.$view_id.'" ondblclick="makeEditable('.$view_id.')">' . $row['filename'] . '</span>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="col1">
						<div class="cont">
							<div class="cont-col1">
								<div class="desc">
									<span class="label label-m label-default ">Assignee</span>&nbsp;';
									if ($row['Assign_to_history'] == NULL) {
										$initials = "N/A";
										$profilePicture = '';
										$fullName = 'Empty';
									} else {
										$owner = $row['Assign_to_history'];
										$query = "SELECT * FROM tbl_user WHERE employee_id = '$owner'";
										$result = mysqli_query($conn, $query);
			
										while ($row1 = mysqli_fetch_array($result)) {
											$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '" . $row1['ID'] . "'");
			
											if (mysqli_num_rows($selectUserInfo) > 0) {
												$rowInfo = mysqli_fetch_assoc($selectUserInfo);
												$current_userAvatar = $rowInfo['avatar'];
											}
				
											$firstNameInitial = strtoupper(substr($row1['first_name'], 0, 1));
											$lastNameInitial = strtoupper(substr($row1['last_name'], 0, 1));
											$initials = $firstNameInitial . $lastNameInitial;
											$profilePicture = !empty($current_userAvatar) ? $base_url . 'uploads/avatar/' . $current_userAvatar : '';
											$fullName = $row1['first_name'] . '&nbsp;' . $row1['last_name'];
										}
									}
		
									if (!empty($profilePicture)) {
										$response .= '<span class="photo">
											<img src="' . $profilePicture . '" class="img-circle" tooltip="' . $initials . '" width="27px" height="27px">
										</span>
										<span class="uppercase">' . $fullName . '</span>';
									} else {
										$response .= '<span class="photo">
											<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>
										</span>
										<span class="uppercase">' . $fullName . '</span>';
									}
									$response .= '<span class="pull-right">
										<a id="changeHistoryAssignee" data-id="'.$view_id.'" class="btn btn-circle btn-outline gray">
										<i class="fa fa-exchange" aria-hidden="true"></i>
									</button>
									</a>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="col1">
						<div class="cont">
							<div class="cont-col1">
								<div class="desc">
									<span class="label label-m label-default ">Due Date</span>&nbsp;
									<input type="hidden" id="calendarHistoryDate" value="' . date("Y-m-d", strtotime($row['Action_date'])) . '">
									<span class="ui calendar" id="example9" data-id="'.$view_id.'">
									   <i class="fa fa-calendar"></i>&nbsp;' . date("Y-m-d", strtotime($row['Action_date'])) . '
									</span>
								</div>
							</div>
							<div class="cont-col2"></div>
						</div>
					</div>
				</li>
				<li>';
					if($user_id == 34){
						$response.='<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="desc">
										<span class="label label-m label-default ">Account</span>&nbsp;';
										$response .='<select disabled style="border: 1px solid #c2cad800;">
											<option active><span>' . $row['h_accounts'] . '</span></option>';
											$query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE name != ? AND is_status = 0 ORDER BY name ASC";
											$stmt_accounts = mysqli_prepare($conn, $query_accounts);
											mysqli_stmt_bind_param($stmt_accounts, "s", $row['h_accounts']); // Assuming h_accounts is a string, change "i" to "s"
											mysqli_stmt_execute($stmt_accounts);
											$result_accounts = mysqli_stmt_get_result($stmt_accounts);

											while ($row_accounts = mysqli_fetch_array($result_accounts)) {
												$response .= '<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
											}
											$stringProduct = strip_tags($row['description']);
										$response.= '</select>';
						   
									$response .='</div>
								</div>
								<div class="cont-col2"></div>
							</div>
						</div>';
					}  
				$response.='</li>
			</ul>
			<div class="row align-items-center"></div>
		</div>
		<hr>
		<h4>Task Description:</h4>
		<p id="editableTextDescription'.$view_id.'" ondblclick="makeEditableDescription('.$view_id.')" class="editableDescription todo-task-modal-bg">
			<i>'.$row["description"]. '</i>
		</p>
		<div class="portlet  tasks-widget ">
			<hr>
			<div class="portlet-title">
				<div class="caption">
					<div class="btn-group">
						<button id="getChildFormModal" data-id="' . $view_id . '" class="btn btn-circle btn-outline green">
							<i class="fa fa-plus"></i>&nbsp;
							<span class="hidden-sm hidden-xs"><i></i>Sub Tasks&nbsp;</span>
						</button>
					</div>
				</div>
				<div class="actions">
					<div class="btn-group">
					 <input type="hidden" id="subTaskIdselected" value="">
						<span id="iconsContainerOtherAction" style="display: none;">
							<div class="btn-group btn-group-circle btn-group-solid">
								<button data-id="' . $view_id . '" id="CompleteAll" class="btn btn-outline green"> <i class="fa fa-check"></i></button>
								<button type="button" data-id="' . $view_id . '" class="'.$disabledClass.' btn btn-circle btn-outline red" id="DeleteSelected"><i class="fa fa-trash"></i></button>
							</div>
						</span>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="btn-group btn-group-circle">
					<a href="#tabOpen" data-toggle="tab" class="btn btn-default btn-sm">Open</a>
					<a href="#tabClose" data-toggle="tab" class="btn btn-default btn-sm">Close</a>
					<a href="#tabAll" data-toggle="tab" class="btn btn-default btn-sm">All</a>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="tabOpen">
						<div class="task-content" style="overflow:visible;">
							<div data-always-visible="1" data-rail-visible1="1">
								<ul  class="task-list" id="task_list_open"></ul> 
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tabClose">
						<div class="task-content" style="overflow:visible;">
							<div data-always-visible="1" data-rail-visible1="1">
								<ul  class="task-list" id="task_list_close"></ul> 
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tabAll">
						<div class="task-content" style="overflow:visible;">
							<div data-always-visible="1" data-rail-visible1="1">
								<ul  class="task-list" id="task_list"></ul> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet tasks-widget ">
			<div class="portlet-title">
				<div class="caption">
					<div class="btn-group">
						<button  id="getModalDocumentForm" data-id="' . $view_id . '" type="button" class="btn btn-circle btn-outline blue">
							<i class="fa fa-plus"></i>&nbsp;
							<span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
						</button>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="task-content">
					<div data-always-visible="1" data-rail-visible1="1">
						<ul class="task-list" id="taskDocument"></ul>
					</div>
				</div>
			</div>
		</div>
		<!-- BEGIN PORTLET-->
		<div class="portlet" id="section-1">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bubble font-hide hide"></i>
					<span class="caption-subject font-hide bold uppercase">Comments</span>
				</div>
			</div>
			<div class="portlet-body" id="chats">
				<div class="scroller" style="overflow-y: auto;height: 170px;" data-always-visible="1" data-rail-visible1="1">
					<ul class="chats" id="listOfChats"></ul>
				</div>
			</div>
		</div>';
	}

	echo $response;
}
function TaskDocumentlist($conn){
		  $view_id = $_POST['id'];
		  $base_url = "https://interlinkiq.com/";
				 $sql = "SELECT * FROM tbl_myproject_services_documents 
				  LEFT JOIN  tbl_MyProject_Services_History ON tbl_myproject_services_documents.history_id = tbl_MyProject_Services_History.History_id 
				  LEFT JOIN tbl_user ON tbl_MyProject_Services_History.user_id = tbl_user.id
				  WHERE tbl_myproject_services_documents.history_id = '$view_id'";
				   $result = $conn->query($sql);
				   $response ='';
				   if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
					$filename = $row['tmsd_filename'];
					$file = $row['tmsd_files'];
					$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
					 $icon = '<i class="fa fa-file"></i>';
					switch ($fileExtension) {
					case 'docx':
					$icon = '<i style="color:#2195f9"  class="fa fa-file-word-o" aria-hidden="true"></i>';
					break;
					case 'pdf':
					$icon = '<i style="color:#e43a45"  class="fa fa-file-pdf-o" aria-hidden="true"></i>';
					break;
					case 'xls':
					$icon = '<i style="color:green" class="fa fa-file-excel-o" aria-hidden="true"></i>';
					break;
														}
											 $response .= '
														  <li>
														  <div class="task-checkbox">
																<div   class="mt-action-img">
																   '.$icon. '
																</div>
														 </div>
														  <div class="task-title">
																<div class="mt-action-details" style="width:70%;text-align:left;">
																	<span class="task-title-sp" style="font-size:11px;">' . $filename . '</span>
																</div>
														  </div>
															  <div class="task-config">
																	<div class="task-config-btn btn-group">
																		<div class="btn-group">
																			<a class="btn btn-circle btn-outline gray" href="' . $base_url . 'ForNewFunctions/resources/uploads/' . $filename . '" target="_blank">
																				<i class="fa fa-download"></i>&nbsp;
																				<span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
																			</a>
																		</div>
																	</div>
																</div>
														</li>';
																}
															} 
															echo $response;
}
function projectTask($conn) {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$view_id = $_POST['view_id'];
	$base_url = "https://interlinkiq.com/";
	$sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner
		FROM tbl_MyProject_Services_History 
		left join tbl_MyProject_Services_Action_Items on tbl_MyProject_Services_Action_Items.Action_Items_id = tbl_MyProject_Services_History.Action_taken
		where tbl_MyProject_Services_History.tmsh_column_status=0 AND tbl_MyProject_Services_History.MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0");
	//  $i = 0;
	$response = '';
	while ($data1 = $sql->fetch_array()) {
		
		$id_st = $data1['History_id'];
		$ck = 786;
		// $ck = $_COOKIE['employee_id'];
		$counter_result = 0;
		$MyTask = '';
		$h_id = '';
		$ptc = '';
		//  AND CAI_Assign_to = $ck 
		//    $view_id = $_POST['view_id'];
		$sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
		$data_MyTask = $sql__MyTask->fetch_array();
		$counter_result = $data_MyTask['taskcount'];

	 
		$sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
		while ($data_counters = $sql_counters->fetch_array()) {
			$count_result = $data_counters['counter'];
		}
		$sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
		while ($data_compliance = $sql_compliance->fetch_array()) {
			$comp = $data_compliance['compliance'];
		}
		$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
		while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
			$non = $data_none_compliance['non_comp'];
		}
		$ptc = 0;
		if (!empty($comp) && !empty($non)) {
			$percent = $comp / $counter_result;
			$ptc = number_format($percent * 100, 2) . '%';
		} elseif (empty($non) && !empty($comp)) {
			$ptc = '100%';
		} else {
			$ptc = '0%';
		}
		if($data1['Assign_to_history']==NULL){
			  $initials = "N/A";
			 $profilePicture = "";  
		}else{
			$owner  = $data1['Assign_to_history'];
		   	$query = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_array($result)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
																				
				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
				$initials = $firstNameInitial.''.$lastNameInitial;
			}
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
		}
   
		
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		 $title = $data1['filename'];
		$max_length = 15; // Maximum length of the truncated title
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}
		$currentDay = date('j');
		$disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
		 $disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
		$response .= ' <div id="' . $id_st . '" class="card" draggable="true" ondragstart="drag(event)">';
			$response .='<div class="'.$disabledbutton.' more pull-right">
				<div class="img-circle">
					<button aria-hidden="true" id="more-btn" class="more-btn">
						<span class="more-dot"></span>
						<span class="more-dot"></span>
						<span class="more-dot"></span>
					</button>
				</div>
				<div class="more-menu">
					<div class="more-menu-caret">
						<div class="more-menu-caret-outer"></div>
						<div class="more-menu-caret-inner"></div>
					</div>
					<ul class="more-menu-items" tabindex="-1" role="menu" aria-labelledby="more-btn" aria-hidden="true">
						<li class="more-menu-item" role="presentation">
							<button type="button" id="ViewHistoryForEdit" class="'.$disabledClass.' more-menu-btn" data-view="'.$view_id.'" data-id="' . $id_st . '" role="menuitem" href="#ViewHistoryForEdits" data-toggle="modal">Edit</button>
						</li>
					   	<li class="more-menu-item" role="presentation">
							<button type="button" id="DeleteHistory" data-id="' . $id_st . '" class="'.$disabledClass.' more-menu-btn" role="menuitem">Delete</button>
						</li>
					</ul>
				</div>
			</div>
			<br>';
			$response .='
			<div class="card-content"  id="cardData" data-id="' . $id_st . '">
				<div class="card-header">
					<div class="card-info">  
						<h6 class="todo-inline">
							<i class="fa fa-check-circle-o"></i>
							<span class="uppercase">' . $truncated_title. '</span>
							<div class="todo-inline pull-right">
								<span class="uppercase font-green">' . $ptc . '</span>&nbsp;<small>Compliance</small>
							</div>
						</h6>
					</div>
				</div>
				<div class="card-body">
					<div class="media d-flex">
						<div class="align-self-center">
							<p style="padding-left:2px;font-size:12px" class="card-text">';
								$stringProduct = strip_tags($data1['description']);
								if (strlen($stringProduct) > 76) {
									$stringCut = substr($stringProduct, 0, 76);
									$endPoint = strrpos($stringCut, ' ');
									$stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
									$hiddenContent = substr($stringProduct, strlen($stringCut));

									$stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;"><i style="color:black;">See more...</i></a>';

									$response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
									$response .= "<script>
										document.addEventListener('DOMContentLoaded', function() {
											var seeMoreLink = document.querySelector('.see-more');
											var hiddenContent = document.getElementById('hidden-content');
											seeMoreLink.addEventListener('click', function() {
												hiddenContent.style.display = 'block';
												seeMoreLink.style.display = 'none';
											});
										});
									</script>";
								}
								$response .= "$stringProduct";
							$response .= '</p>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<p class="card-text pull-left">';
						if (!empty($profilePicture)) {
							$response.='<a href="#">';
								$response.='<img src="' . $profilePicture . '" class="img-circle image--cover" style="margin-right:0.5rem;" alt="' . $initials . '" width="27px" height="27px">';
							$response.='</a>';
						} else {
							$response.='<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
						}
						$response.='<span tooltip="Due Date" style="font-size:1.2rem">&nbsp;' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
					</p>&nbsp;
					<div class="assigned">
						<p class="card-text pull-right">
							<a class="js-anchor-link"   style="padding-right: 20px;">
								<span class="caption-subject">'. $counter_result. '</span>
								<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
								</svg>
							</a>
							<a class="js-anchor-link"  style="padding-right: 20px;">
								<span class="caption-subject">'.$count_result. '</span>
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
								</svg>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>';
	}
	echo $response;
}

function projectTask1($conn) {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$view_id = $_POST['view_id'];
	$base_url = "https://interlinkiq.com/";
	$sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner 
		 FROM tbl_MyProject_Services_History 
		 left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
		 left join tbl_hr_employee on Assign_to_history = ID 
		 left join tbl_user on employee_id = tbl_hr_employee.ID 
		 where tbl_MyProject_Services_History.tmsh_column_status=1 AND MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0");
	//  $i = 0;
	$response = '';
	while ($data1 = $sql->fetch_array()) {
		$id_st = $data1['History_id'];
		$ck = 35;
		// $ck = $_COOKIE['employee_id'];
		$counter = 1;
		$counter_result = 0;
		$MyTask = '';
		$h_id = '';
		$ptc = '';

		$sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
		$data_MyTask = $sql__MyTask->fetch_array();
		$counter_result = $data_MyTask['taskcount'];

	 
		$sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
		while ($data_counters = $sql_counters->fetch_array()) {
			$count_result = $data_counters['counter'];
		}
		$sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
		while ($data_compliance = $sql_compliance->fetch_array()) {
			$comp = $data_compliance['compliance'];
		}
		$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
		while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
			$non = $data_none_compliance['non_comp'];
		}
		$ptc = 0;
		if (!empty($comp) && !empty($non)) {
			$percent = $comp / $counter_result;
			$ptc = number_format($percent * 100, 2) . '%';
		} elseif (empty($non) && !empty($comp)) {
			$ptc = '100%';
		} else {
			$ptc = '0%';
		}
		if($data1['Assign_to_history']==NULL){
			$initials = "N/A";
			$profilePicture = "";  
		}else{
		 	$owner  = $data1['Assign_to_history'];
		  	$query = "SELECT * FROM tbl_user where employee_id = '$owner'";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_array($result)) {
				$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
																				
				if (mysqli_num_rows($selectUserInfo) > 0) {
					$rowInfo = mysqli_fetch_assoc($selectUserInfo);
					$current_userAvatar = $rowInfo['avatar'];
				}
				$firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
				$lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
				$initials = $firstNameInitial.''.$lastNameInitial;
			}
			$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
		}
   
		
		$randomColor = '#' . substr(md5(rand()), 0, 6);
		$title = $data1['filename'];
		$max_length = 15; // Maximum length of the truncated title
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}
		 $currentDay = date('j');
		$disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
		 $disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
		$response .= ' <div id="' . $id_st . '" class="card" draggable="true" ondragstart="drag(event)">
			<div class="'.$disabledbutton.' more pull-right">
				<div class="img-circle">
					<button id="more-btn" class="more-btn">
						<span class="more-dot"></span>
						<span class="more-dot"></span>
						<span class="more-dot"></span>
					</button>
				</div>
				<div class="more-menu">
					<div class="more-menu-caret">
						<div class="more-menu-caret-outer"></div>
						<div class="more-menu-caret-inner"></div>
					</div>
					<ul class="more-menu-items" tabindex="-1" role="menu" aria-labelledby="more-btn" aria-hidden="true">
						<li class="more-menu-item" role="presentation">
							<button type="button" id="ViewHistoryForEdit" class="'.$disabledClass.' more-menu-btn" data-id="' . $id_st . '" role="menuitem" href="#ViewHistoryForEdits" data-toggle="modal">Edit</button>
						</li>
					   	<li class="more-menu-item" role="presentation">
							<button type="button" id="DeleteHistory" data-id="' . $id_st . '" class="'.$disabledClass.' more-menu-btn" role="menuitem">Delete</button>
						</li>
					</ul>
				</div>
			</div>
			<br>
			<div class="card-content"  id="cardData" data-id="' . $id_st . '">
				<div class="card-header">
					<div class="card-info">  
						<h6 class="todo-inline">
							<i class="fa fa-check-circle-o"></i>
							<span class="uppercase">' . $truncated_title. '</span>
							<div class="todo-inline pull-right">
								<span class="uppercase font-green">' . $ptc . '</span>&nbsp;<small>Compliance</small>
						  	</div>
						</h6>
					</div>
				</div>
				<div class="card-body">
					<div class="media d-flex">
						<div class="align-self-center">
							<p style="padding-left:2px;font-size:12px" class="card-text">';
								$stringProduct = strip_tags($data1['description']);
								if (strlen($stringProduct) > 76) {
									$stringCut = substr($stringProduct, 0, 76);
									$endPoint = strrpos($stringCut, ' ');
									$stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
									$hiddenContent = substr($stringProduct, strlen($stringCut)); // Store the hidden content

									$stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;"><i style="color:black;">See more...</i></a>';

									$response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
									$response .= "<script>
										document.addEventListener('DOMContentLoaded', function() {
											var seeMoreLink = document.querySelector('.see-more');
											var hiddenContent = document.getElementById('hidden-content');
											seeMoreLink.addEventListener('click', function() {
												hiddenContent.style.display = 'block';
												seeMoreLink.style.display = 'none';
											});
										});
									</script>";
								}

								$response .= "$stringProduct";
							$response .= '</p>
						</div>
					</div>
					<div class="card-footer">
						<p class="card-text pull-left">';
							if (!empty($profilePicture)) {
								$response.='<a href="#">';
									$response.='<img  src="' . $profilePicture . '" class="img-circle image--cover" style="margin-right:0.5rem;" alt="' . $initials . '" width="27px" height="27px">';
								$response.='</a>';
							} else {
								$response.='<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
							}

							$response.='<span  tooltip="Due Date" style="font-size:1.2rem">&nbsp' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
						</p>&nbsp;
						<div class="assigned">
							<p class="card-text pull-right">
								<a class="js-anchor-link"  style="padding-right: 20px;">
									<span class="caption-subject">' . $counter_result . '</span>
									<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
									</svg>
								</a>
								<span class="js-anchor-link"  style="padding-right: 20px;">
									<span class="caption-subject">' . $count_result . '</span>
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
									</svg>
								</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}
	echo $response;
}

function projectTask2($conn)
{
	 $portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$view_id = $_POST['view_id'];
	$base_url = "https://interlinkiq.com/";
	$sql = $conn->query("SELECT *,tbl_MyProject_Services_History.user_id as owner 
		FROM tbl_MyProject_Services_History 
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
		left join tbl_hr_employee on Assign_to_history = ID 
		left join tbl_user on employee_id = tbl_hr_employee.ID 
		where tbl_MyProject_Services_History.tmsh_column_status=2 AND MyPro_PK = $view_id AND tbl_MyProject_Services_History.is_deleted=0");
	//  $i = 0;
	$response = '';
	while ($data1 = $sql->fetch_array()) {
		$id_st = $data1['History_id'];
		$ck = 35;
		// $ck = $_COOKIE['employee_id'];
		$counter = 1;
		$counter_result = 0;
		$MyTask = '';
		$h_id = '';
		$ptc = '';

		$sql__MyTask = $conn->query("SELECT COUNT(*) as taskcount FROM tbl_MyProject_Services_Childs_action_Items WHERE Services_History_PK = '$id_st' AND is_deleted = 0");
		$data_MyTask = $sql__MyTask->fetch_array();
		$counter_result = $data_MyTask['taskcount'];

	 
		$sql_counters = $conn->query("SELECT COUNT(*) as counter FROM tbl_MyProject_Services_Comment where Task_ids = '$id_st'");
		while ($data_counters = $sql_counters->fetch_array()) {
			$count_result = $data_counters['counter'];
		}
		$sql_compliance = $conn->query("SELECT COUNT(*) as compliance FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress = 2 AND is_deleted = 0");
		while ($data_compliance = $sql_compliance->fetch_array()) {
			$comp = $data_compliance['compliance'];
		}
		$sql_none_compliance = $conn->query("SELECT COUNT(*) as non_comp FROM tbl_MyProject_Services_Childs_action_Items where Services_History_PK = '$id_st' and Parent_MyPro_PK = $view_id and CIA_progress != 2 AND is_deleted = 0");
		while ($data_none_compliance = $sql_none_compliance->fetch_array()) {
			$non = $data_none_compliance['non_comp'];
		}
		$ptc = 0;
		if (!empty($comp) && !empty($non)) {
			$percent = $comp / $counter_result;
			$ptc = number_format($percent * 100, 2) . '%';
		} elseif (empty($non) && !empty($comp)) {
			$ptc = '100%';
		} else {
			$ptc = '0%';
		}
		 if($data1['Assign_to_history']==NULL){
			$initials = "N/A";
			$profilePicture = "";  
		}else{
		  $owner  = $data1['Assign_to_history'];
		   $query = "SELECT * FROM tbl_user where employee_id = '$owner'";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_array($result)) {
						   $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
																						
							  if (mysqli_num_rows($selectUserInfo) > 0) {
							  $rowInfo = mysqli_fetch_assoc($selectUserInfo);
							  $current_userAvatar = $rowInfo['avatar'];
							   }
						$firstNameInitial = strtoupper(substr($row['first_name'], 0, 1));
						$lastNameInitial = strtoupper(substr($row['last_name'], 0, 1));
						$initials = $firstNameInitial.''.$lastNameInitial;
					}
					 $profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
		}
   
		
		$randomColor = '#' . substr(md5(rand()), 0, 6);
			   $title = $data1['filename'];
		$max_length = 15; // Maximum length of the truncated title
		
		if (strlen($title) > $max_length) {
			$truncated_title = substr($title, 0, $max_length) . '...';
		} else {
			$truncated_title = $title;
		}
		$currentDay = date('j');
		$disabledClass = ($currentDay <=12 && $currentDay > 15) ? 'disabled' : '';
		$disabledbutton = ($portal_user == $data1['owner']) ? '' : 'disabled';
		$response .= '
			   <div id="' . $id_st . '" class="card" draggable="true" ondragstart="drag(event)">
					<div class="'.$disabledbutton.' more pull-right" style="dispaly:block;">
							<div class="img-circle">
							<button id="more-btn" class="more-btn">
								<span class="more-dot"></span>
								<span class="more-dot"></span>
								<span class="more-dot"></span>
							</button>
							</div>
							<div class="more-menu">
								<div class="more-menu-caret">
									<div class="more-menu-caret-outer"></div>
									<div class="more-menu-caret-inner"></div>
								</div>
								<ul class="more-menu-items" tabindex="-1" role="menu" aria-labelledby="more-btn" aria-hidden="true">
									<li class="more-menu-item" role="presentation">
										<button type="button" id="ViewHistoryForEdit" class="'.$disabledClass.' more-menu-btn" data-id="' . $id_st . '" role="menuitem" href="#ViewHistoryForEdits" data-toggle="modal">Edit</button>
									</li>
									<li class="more-menu-item" role="presentation">
										<button type="button" id="DeleteHistory" data-id="' . $id_st . '" class="'.$disabledClass.' more-menu-btn" role="menuitem">Delete</button>
									</li>
								</ul>
							</div>
						</div>
						<br>
					  <div class="card-content"  id="cardData" data-id="' . $id_st . '">
						<div class="card-header">
							<div class="card-info">  
							<h6 class="todo-inline">
								  <i class="fa fa-check-circle-o"></i>
									<span class="uppercase">' .$truncated_title . '</span>
									 <div class="todo-inline pull-right">
								 <span class="uppercase font-green">' . $ptc . '</span>&nbsp;<small>Compliance</small>
							  </div>
							 </h6>
							 </div>
						</div>
							  <div class="card-body">
											 <div class="media d-flex">
														 <div class="align-self-center">
																	   <p style="padding-left:2px;font-size:12px" class="card-text">';
														$stringProduct = strip_tags($data1['description']);
														if (strlen($stringProduct) > 76) {
															$stringCut = substr($stringProduct, 0, 76);
															$endPoint = strrpos($stringCut, ' ');
															$stringProduct = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
															$hiddenContent = substr($stringProduct, strlen($stringCut)); // Store the hidden content

															$stringProduct .= '&nbsp;<a class="see-more" style="font-size:12px; cursor: pointer;">
																<i style="color:black;">See more...</i></a>';
																	$response .= "<div id='hidden-content' style='display: none;'>$hiddenContent</div>";
																	$response .= "<script>
																									document.addEventListener('DOMContentLoaded', function() {
																										var seeMoreLink = document.querySelector('.see-more');
																										var hiddenContent = document.getElementById('hidden-content');
																										seeMoreLink.addEventListener('click', function() {
																											hiddenContent.style.display = 'block';
																											seeMoreLink.style.display = 'none';
																										});
																									});
																								</script>";
																	}
																	$response .= "$stringProduct";
																	$response .= '</p>
																   </div>
																
															   </div>
																   <div class="card-footer">
																	  <p class="card-text pull-left">';
																				 if (!empty($profilePicture)) {
																			 $response.='<a href="#">';
																			 $response.='<img src="' . $profilePicture . '" class="img-circle image--cover" style="margin-right:0.5rem;" alt="' . $initials . '" width="27px" height="27px">';
																			 $response.='</a>';
																		} else {
																			 $response.='<label class="img-circle" style="color:white;padding:0.3rem;align-items: center; justify-content: center; text-align: center; width: 27px; height: 27px; background-color: ' . $randomColor . ';">' . $initials . '</label>';
																		}
																				
																			$response.='<span  tooltip="Due Date" style="font-size:1.2rem">&nbsp' . date("Y-m-d", strtotime($data1['Action_date'])) . '</span>
																		</p>
																		&nbsp;
																<div class="assigned">
																			  <p class="card-text pull-right">
																	   <a class="js-anchor-link"  style="padding-right: 20px;">
																		   <span class="caption-subject">' . $counter_result . '</span>
																		   <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																			   <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H10C10 3.46957 9.78929 2.96086 9.41421 2.58579C9.03914 2.21071 8.53043 2 8 2ZM5.354 1C6.059 0.378 6.986 0 8 0C9.014 0 9.94 0.378 10.646 1H14C14.5304 1 15.0391 1.21071 15.4142 1.58579C15.7893 1.96086 16 2.46957 16 3V18C16 18.5304 15.7893 19.0391 15.4142 19.4142C15.0391 19.7893 14.5304 20 14 20H2C1.46957 20 0.960859 19.7893 0.585786 19.4142C0.210714 19.0391 0 18.5304 0 18V3C0 2.46957 0.210714 1.96086 0.585786 1.58579C0.960859 1.21071 1.46957 1 2 1H5.354ZM4.126 3H2V18H14V3H11.874C11.956 3.32 12 3.655 12 4V5C12 5.26522 11.8946 5.51957 11.7071 5.70711C11.5196 5.89464 11.2652 6 11 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5V4C4 3.655 4.044 3.32 4.126 3ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H11C11.2652 8 11.5196 8.10536 11.7071 8.29289C11.8946 8.48043 12 8.73478 12 9C12 9.26522 11.8946 9.51957 11.7071 9.70711C11.5196 9.89464 11.2652 10 11 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM4 13C4 12.7348 4.10536 12.4804 4.29289 12.2929C4.48043 12.1054 4.73478 12 5 12H8C8.26522 12 8.51957 12.1054 8.70711 12.2929C8.89464 12.4804 9 12.7348 9 13C9 13.2652 8.89464 13.5196 8.70711 13.7071C8.51957 13.8946 8.26522 14 8 14H5C4.73478 14 4.48043 13.8946 4.29289 13.7071C4.10536 13.5196 4 13.2652 4 13Z" fill="#C2B7B7" />
																		   </svg>
																	   </a>
																	   <a class="js-anchor-link"  style="padding-right: 20px;">
																		   <span class="caption-subject">' . $count_result . '</span>
																		   <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																			   <path d="M7 20C6.73478 20 6.48043 19.8946 6.29289 19.7071C6.10536 19.5196 6 19.2652 6 19V16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H18C18.5304 0 19.0391 0.210714 19.4142 0.585786C19.7893 0.960859 20 1.46957 20 2V14C20 14.5304 19.7893 15.0391 19.4142 15.4142C19.0391 15.7893 18.5304 16 18 16H11.9L8.2 19.71C8 19.9 7.75 20 7.5 20H7ZM8 14V17.08L11.08 14H18V2H2V14H8ZM14 12H6V11C6 9.67 8.67 9 10 9C11.33 9 14 9.67 14 11V12ZM10 4C10.5304 4 11.0391 4.21071 11.4142 4.58579C11.7893 4.96086 12 5.46957 12 6C12 6.53043 11.7893 7.03914 11.4142 7.41421C11.0391 7.78929 10.5304 8 10 8C9.46957 8 8.96086 7.78929 8.58579 7.41421C8.21071 7.03914 8 6.53043 8 6C8 5.46957 8.21071 4.96086 8.58579 4.58579C8.96086 4.21071 9.46957 4 10 4Z" fill="#C2B7B7" />
																		   </svg>
																	   </a>
																   </p>
																   </div>
																   </div>
														   </div>
													   </div>
								</div> ';
	}
	echo $response;
}

function InsertParent($conn) {
	$ID = $_POST['modalNew_File'];
	$today = date('Y-m-d');
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$output = '<input class="form-control" type="hidden" name="ID" id="project_id" value="' . $ID . '" />';
	$query_proj = "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $ID";
	$result_proj = mysqli_query($conn, $query_proj);

	while ($row_proj = mysqli_fetch_array($result_proj)) {
		$output .= '<div class="form-group">
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
		</div>';
		if($user_id == 34){
			$output.='<div class="form-group">
				<div class="col-md-6">
					<label>Action Items</label>
					<select class="form-control mt-multiselect btn btn-default" type="text" name="Action_taken" required>
						<option value="">---Select---</option>';

						$queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items ORDER BY Action_Items_name ASC";
						$resultType = mysqli_query($conn, $queryType);

						while ($rowType = mysqli_fetch_array($resultType)) {
							$output .= '<option value="' . $rowType['Action_Items_id'] . '">' . $rowType['Action_Items_name'] . '</option>';
						}

						$output .= '<option value="0">Others</option>
					</select>
				</div>
				<div class="col-md-6">
					<label>Account</label>
					<select name="h_accounts" class="form-control mt-multiselect btn btn-default" type="text" required>
						<option value="">---Select---</option>';
						$output .= '<option value="' . $row_proj['Accounts_PK']. '"  selected >' . $row_proj['Accounts_PK']. '</option>';
						$query_accounts = "SELECT * FROM tbl_service_logs_accounts WHERE name != ? AND is_status = 0 ORDER BY name ASC";
						$stmt_accounts = mysqli_prepare($conn, $query_accounts);
						mysqli_stmt_bind_param($stmt_accounts, "s", $row_proj['Accounts_PK']);
						mysqli_stmt_execute($stmt_accounts);
						$result_accounts = mysqli_stmt_get_result($stmt_accounts);

						while ($row_accounts = mysqli_fetch_array($result_accounts)) {
							$output.= '<option value="' . $row_accounts['name'] . '"><span>' . $row_accounts['name'] . '</span></option>';
						}
					$output .= '</select>
				</div>
			</div>';
		}
		$output.='<div class="form-group">
			<div class="col-md-12">
				<label>Description</label>
			</div>
			<div class="col-md-12">
				<textarea class="form-control" name="description" required></textarea>
			</div>
		</div>
		<div class="form-group">';
			// if($user_id == 34){
			   $output.='<div class="col-md-6">
					<label>Estimated Time (minutes)</label>
					<input class="form-control" type="number" name="Estimated_Time" value="0" required />
				</div>';
			// }
			$output .='<div class="col-md-6">
				<label>Desired Due Date</label>
				<input class="form-control" type="date" name="Action_date" value="' . date("Y-m-d", strtotime(date("Y/m/d"))) . '" required />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label>Status</label>
				<select class="form-control" id="h_progress" name="h_progress">
					<option value="0">Not Started</option>
					<option value="1">Inprogress</option>
					<option value="2">Completed</option>
				</select>
			</div>
			<div class="col-md-6">
				<label>Priority</label>
				<select class="form-control" id="h_priority" name="h_priority">
					<option value="0">Low</option>
					<option value="1">Medium</option>
					<option value="2">High</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<label>Assign to</label>
			</div>
			<div class="col-md-12">
				<select class="form-control mt-multiselect btn btn-default" type="text" name="Assign_to_history" required>
					<option value="0">---Select---</option>';

					$queryAssignto = "SELECT * FROM tbl_hr_employee WHERE user_id = $user_id AND status = 1 ORDER BY first_name ASC";
					$resultAssignto = mysqli_query($conn, $queryAssignto);

					while ($rowAssignto = mysqli_fetch_array($resultAssignto)) {
						$output .= '<option value="' . $rowAssignto['ID'] . '">' . $rowAssignto['first_name'] . ' ' . $rowAssignto['last_name'] . '</option>';
					}
					$output .= '<option value="0">Others</option>
				</select>
			</div>
		</div>';
	}
	echo $output;
}
function SaveHistoryAndParent($conn) {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
	$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
	$rowUser = mysqli_fetch_array($selectUser);
	$current_client = $rowUser['client'];
	
	$today = date('Y-m-d');
	$ID = $_POST['ID'];
	$h_progress = $_POST['h_progress'];
	$filename = mysqli_real_escape_string($conn, $_POST['filename']);
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	if($current_client == 1){
		$h_accounts = "NULL";
		$Estimated_Time = $_POST['Estimated_Time'];
		$Action_taken = 0;
	}else{
		$h_accounts = mysqli_real_escape_string($conn, $_POST['h_accounts']);
		$Estimated_Time = $_POST['Estimated_Time'];
		$Action_taken = $_POST['Action_taken'];
	}
	if ($_POST['Assign_to_history'] == 0) {
  
	} else {
		$Assign_to_history = $_POST['Assign_to_history'];
	}
	$h_priority = $_POST['h_priority'];
	$Action_date = $_POST['Action_date'];
	$rand_id = rand(10, 1000000);

	$to_Db_files = "";
	$files = $_FILES['file']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['file']['tmp_name'];
		$files = rand(1000, 1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn, $files);
		$path = $path . $files;
		move_uploaded_file($tmp, $path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_History (user_id, MyPro_PK, files, filename, description, Estimated_Time, Action_taken, Action_date, Assign_to_history, Services_History_Status, rand_id, h_accounts, tmsh_column_status, priority_status)
	VALUES ('$portal_user', '$ID', '$to_Db_files', '$filename', '$description', '$Estimated_Time', '$Action_taken', '$Action_date', ";
	
	if ($_POST['Assign_to_history'] == 0) {
		$sql .= "NULL";
	} else {
		$sql .= "'$Assign_to_history'";
	}
	
	$sql .= ", 1, '$rand_id', '$h_accounts', '$h_progress', '$h_priority')";

	if (mysqli_query($conn, $sql)) {
		if($current_client == 1){
			// start the email here !!!
			$user = 'interlinkiq.com';
			$subject = 'Assigned to You: '.$filename;
			//  $t_fname ="Erwin James";
			//  $t = "manugasewinjames@gmail.com";
			//  $frm = "manugasewinjames@gmail.com";
			//  $frm_name = "Bob marley";
			////   from
			$cookie_frm = $_COOKIE['ID'];
			$selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
			while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; $frm_name = $rowFrom['first_name'];}
			////  to
			$cookie_to = $Assign_to_history;
			$select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
			while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
			//   Projects

			$project_id = $ID;
			$project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
			while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
			//  task
			$child_n = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services_History WHERE is_deleted=0 AND MyPro_PK = $project_id AND DATE(history_added) = '$today'");

			$added_users = [];

			while ($child_row_prj = mysqli_fetch_array($child_n)) {
				$base_url = "https://interlinkiq.com/";
				$username = $child_row_prj['Assign_to_history'];
				$user_query = mysqli_query($conn, "SELECT * FROM tbl_user WHERE employee_id = $username");
				$user_row = mysqli_fetch_array($user_query);
				
				$row_fulname = $user_row['first_name'].'&nbsp;'.$user_row['last_name'];
				$project = $child_row_prj['filename'];
				$date = $child_row_prj['history_added'];
				$task_id = $project_id;
				$subtask_id = $child_row_prj['History_id'];
				// for li
				$dateTime = new DateTime($date, new DateTimeZone('UTC'));
				$dateTime->setTimezone(new DateTimeZone('America/Chicago'));
				$formattedDateTime = $dateTime->format('M d, Y \a\t g:ia');
				// end of li
				// 
				$now = new DateTime();
				$todaydateTime = new DateTime($now->format('Y-m-d H:i:s'));
				$todaydateTime->setTimezone(new DateTimeZone('America/Chicago'));
				$todayformattedDateTime = $todaydateTime->format('M d, Y \a\t g:ia');
				// 
				$added_users[] = ['username' => $row_fulname, 'project' => $prj, 'date' => $formattedDateTime, 'project_id' => $task_id];
			}
			$body = '<!DOCTYPE html>
			<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

			<head>
				<title></title>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<meta content="width=device-width, initial-scale=1.0" name="viewport" />
				<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
				<style>
					* {
						box-sizing: border-box;
					}
					
					body {
						margin: 0;
						padding: 0;
					}
					
					a[x-apple-data-detectors] {
						color: inherit !important;
						text-decoration: inherit !important;
					}
					
					#MessageViewBody a {
						color: inherit;
						text-decoration: none;
					}
					
					p {
						line-height: inherit
					}
					
					.desktop_hide,
					.desktop_hide table {
						mso-hide: all;
						display: none;
						max-height: 0px;
						overflow: hidden;
					}
					
					.image_block img+div {
						display: none;
					}
					
					@media (max-width:560px) {
						.social_block.desktop_hide .social-table {
							display: inline-block !important;
						}
						.mobile_hide {
							display: none;
						}
						.row-content {
							width: 100% !important;
						}
						.stack .column {
							width: 100%;
							display: block;
						}
						.mobile_hide {
							min-height: 0;
							max-height: 0;
							max-width: 0;
							overflow: hidden;
							font-size: 0px;
						}
						.desktop_hide,
						.desktop_hide table {
							display: table !important;
							max-height: none !important;
						}
					}
				</style>
			</head>

			<body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
				<table cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0;table-layout:fixed;width:100%">
					<tbody>
						<tr>
							<td style="text-align:center">
								<table style="border-collapse:separate;border-spacing:0;margin-bottom:32px;margin-left:auto;margin-right:auto;margin-top:8px;table-layout:fixed;text-align:left;width:100%">
									<tbody>
										<tr>
											<td>
												<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
													<tbody>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td>
																				<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																					<tbody>
																						<tr>
																							<td style="background-color:#f8df72;border-radius:16px;line-height:16px;min-width:32px;height:32px;width:32px;text-align:center;vertical-align:middle">';
																					   			$selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$cookie_frm."'");                                                           
																							   	if (mysqli_num_rows($selectUserInfo) > 0) {
																								   $rowInfo = mysqli_fetch_assoc($selectUserInfo);
																								   $current_userAvatar = $rowInfo['avatar'];
																							   	}                            
																							   	$profilePicture = !empty($current_userAvatar) ? $base_url.'uploads/avatar/'.$current_userAvatar : '';
																								$initials = "Tt";
																								$randomColor = '#' . substr(md5(rand()), 0, 6);
																								if (!empty($profilePicture)) {
																									$body .= '<img src="' . $profilePicture . '" class="img-circle" alt="' . $initials . '" width="27px" height="27px">';
																								} else {
																									$body .= '<span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">' . $initials . '</span>';
																							 	}
																							$body.='</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																			<td style="max-width:16px;min-width:16px;width:16px">&nbsp;</td>
																			<td>
																				<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																					<tbody>
																						<tr>
																							<td>
																								<a href=""
																									style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:20px;font-weight:400;line-height:26px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$frm_name.' assigned a task to you</span></a>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="line-height:16px;max-width:0;min-width:0;height:16px;width:0;font-size:16px">&nbsp;</td>
																		</tr>
																		<tr>
																			<td style="background-color:#edeae9;height:1px;width:100%"></td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
													<tbody>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Task</span></td>
																		</tr>
																		<tr>
																			<td style="vertical-align:top">
																				<a href=""
																					style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:16px;font-weight:600;line-height:24px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$filename.'</span></a>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Assigned to</span></td>
																			<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																			<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Due date</span></td>
																		</tr>
																		<tr>
																			<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$t_fname.'</span></td>
																			<td style="max-width:48px;min-width:48px;width:48px">&nbsp;</td>
																			<td style="vertical-align:top"><span style="font-size:13px;font-weight:400;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$Action_date.'</span></td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Projects</span></td>
																		</tr>
																		<tr>
																			<td style="vertical-align:top">
																				<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																					<tbody>
																						<tr>
																							<td>
																								<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																									<tbody>
																										<tr>
																											<td style="line-height:20px">
																												<div style="display:inline-block;height:9px;width:9px;min-width:9px;border-radius:3px;background-color:#8d84e8"></div>
																											</td>
																											<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																											<td>
																												<a href=""
																													style="text-decoration:none" target="_blank" data-saferedirecturl=""><span style="font-size:13px;font-weight:400;line-height:20px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$prj.'</span></a>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
													</tbody>
												</table>
												<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0;border-color:#edeae9;border-radius:4px;border-style:solid;border-width:1px">
													<tbody>
														<tr>
															<td style="width:100%">
																<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																			<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																			<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																		</tr>
																		<tr>
																			<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																			<td style="width:100%">
																				<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																					<tbody>';
																						foreach ($added_users as $user) {
																							$body .= '<tr>
																								<td>
																									<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																										<tbody>
																											<tr>
																												<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																												<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																											   
																												<td>
																												<span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>' . $user['username'] . '</strong> added to <a href="https://interlinkiq.com/test_task_mypro.php?view_id=' . $user['project_id'] . '#' . $ID . '" >' . $user['project'] . '</a> . '.$user['date'].'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																													<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																													</span>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																							<tr>
																								<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																							</tr>';
																						}
																						$body .='<tr>
																							<td>
																								<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																									<tbody>
																										<tr>
																											<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																											<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																											<td><span style="font-size:11px;font-weight:400;line-height:16px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif"><strong>'.$t_fname.'</strong> assigned to you · '.$todayformattedDateTime.'<span style="display:inline-block;font-size:11px;line-height:11px;width:8px"> </span>
																												<span style="background-color:#4573d2;color:#ffffff;display:inline-block;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;width:fit-content;border-radius:100px;font-size:12px;font-weight:500;height:18px;line-height:18px;padding:0 8px"><span style="display:inline-block;padding-left:0;padding-right:0">New</span></span>
																												</span>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																			<td style="max-width:24px;min-width:24px;width:24px">&nbsp;</td>
																		</tr>
																		<tr>
																			<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																			<td style="line-height:24px;max-width:auto;min-width:auto;height:24px;width:auto;font-size:24px">&nbsp;</td>
																			<td style="line-height:24px;max-width:24px;min-width:24px;height:24px;width:24px;font-size:24px">&nbsp;</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
													<tbody>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
													</tbody>
												</table>
												<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
													<tbody>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="background-color:#4573d2;border-radius:4px">
																				<a href="https://interlinkiq.com/test_task_mypro.php?view_id='.$ID.'"
																					style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #4573d2;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/test_task_mypro.php?view_id='.$project_id.'">
																					<span style="font-size:13px;font-weight:600;line-height:20px;color:#ffffff;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																					View to MyPro</span>
																					</a>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
															<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
															<td>
																<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="background-color:#ffffff;border-radius:4px">
																				<a href="https://interlinkiq.com/complete_task.php?comp_mothtask_id='.$subtask_id.'&&comp_id='.$cookie_to.'"
																					style="text-decoration:none;border-radius:4px;padding:8px 16px;border:1px solid #cfcbcb;display:inline-block" target="_blank" data-saferedirecturl="https://interlinkiq.com/complete_task.php?comp_subtask_id='.$subtask_id.'">
																					<span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
																					Mark complete</span>
																				</a>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
													<tbody>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
														<tr>
															<td>
																<table cellpadding="0" cellspacing="0" style="width:100%;min-width:100%;table-layout:fixed;border-collapse:separate;border-spacing:0">
																	<tbody>
																		<tr>
																			<td style="vertical-align:bottom"><span style="font-size:13px;font-weight:600;line-height:20px;color:#6d6e6f;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Collaborators</span></td>
																		</tr>
																		<tr>
																			<td style="line-height:4px;max-width:0;min-width:0;height:4px;width:0;font-size:4px">&nbsp;</td>
																		</tr>
																		<tr>
																			<td style="vertical-align:top">
																				<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																					<tbody>
																						<tr>
																							<td>
																								<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																									<tbody>
																										<tr>';
																											 $selectData = mysqli_query($conn, "SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $ID");
																												if (mysqli_num_rows($selectData) > 0) {
																													$row = mysqli_fetch_array($selectData);
																												}
																												
																												$queryCollabs = "SELECT * FROM tbl_hr_employee WHERE status = 1 ORDER BY first_name ASC";
																												$stmt = mysqli_prepare($conn, $queryCollabs);
																												mysqli_stmt_execute($stmt);
																												$resultCollabs = mysqli_stmt_get_result($stmt);
																												
																												while ($rowCollabs = mysqli_fetch_array($resultCollabs)) {
																													$array_collab = explode(", ", $row["Collaborator_PK"]);
																														 $firstNameInitial = strtoupper(substr($rowCollabs['first_name'], 0, 1));
																														$lastNameInitial = strtoupper(substr($rowCollabs['last_name'], 0, 1));
																														$initials = $firstNameInitial . $lastNameInitial;
																													if (in_array($rowCollabs['ID'], $array_collab)) {
																													 $body.='  <td>
																												<table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse:separate;border-spacing:0">
																													<tbody>
																														<tr>
																															<td style="background-color:#f8df72;border-radius:12px;line-height:16px;min-width:24px;height:24px;width:24px;text-align:center;vertical-align:middle"><span style="font-size:11px;font-weight:400;line-height:16px;color:#1e1f21;font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">'.$initials.'</span></td>
																														</tr>
																													</tbody>
																												</table>
																											</td>
																											<td style="max-width:4px;min-width:4px;width:4px">&nbsp;</td>';
																													}
																												}
																										  
																										$body.='</tr>
																									</tbody>
																								</table>
																							</td>
																							<td style="max-width:8px;min-width:8px;width:8px">&nbsp;</td>
																							<td style="vertical-align:middle"></td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<tr>
															<td style="line-height:24px;max-width:0;min-width:0;height:24px;width:0;font-size:24px">&nbsp;</td>
														</tr>
													</tbody>
												</table>
											</td>
										  </tr>
									   </tbody>
								</table>
							</td>
						</tr>
				</tbody>
				</table>
			</body>
			</html>';

 			$mail = php_mailer($frm, $t, $user, $subject, $body);
			if($mail){
				echo "success";
			}else{
				echo "Failed";
			}
		} else {
			$last_id = mysqli_insert_id($conn);
			$sql2 = "INSERT INTO tbl_service_logs_draft (user_id,description,action,comment,account,task_date,minute) 
			VALUES ('$portal_user','$filename','Created','$description','$h_accounts','$today',2)";
			if (mysqli_query($conn, $sql2)) {
				$last_id_log = mysqli_insert_id($conn);
				echo "Sucess";
			}
		}
	} else {
		$message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		echo $message;
	}
	mysqli_close($conn);
}

function ListOfComments($conn)
{
	$view_id = $_POST['id'];
	$randomColor = '#' . substr(md5(rand()), 0, 6);
	$stmt = $conn->prepare("SELECT  * FROM tbl_MyProject_Services_Comment 
							  LEFT JOIN tbl_user ON tbl_MyProject_Services_Comment.user_id = tbl_user.id
							   WHERE tbl_MyProject_Services_Comment.Task_ids = ? ORDER BY tbl_MyProject_Services_Comment.Comment_Date ASC");
	$stmt->bind_param("i", $view_id);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row6 = $result->fetch_assoc()) {
		$firstNameInitial = strtoupper(substr($row6['first_name'], 0, 1));
		$lastNameInitial = strtoupper(substr($row6['last_name'], 0, 1));
		$initials = $firstNameInitial . $lastNameInitial;
		$profilePicture = '';
		$formattedDateTime = date("F d, Y h:i a", strtotime($row6['Comment_Date']));

		 echo '
		<li class="in">
			' . (!empty($profilePicture) ?
			'<img src="' . $profilePicture . '" class="avatar" alt="' . $initials . '" width="27px" height="27px">' :
			'<label class="avatar" style="padding:6px;font-size:20px;color:white;align-items: center; justify-content: center; text-align: center;background-color: ' . $randomColor . ';">' . $initials . '</label>'
		) . '
			<div class="message">
				<span class="arrow"></span>
				<a href="javascript:;" class="name">' . $row6['first_name'] . '&nbsp;' . $row6['last_name'] . '</a>
				<span class="datetime"> at&nbsp;' . $formattedDateTime . '</span>
				<span class="body">' . $row6['Comment_Task'] . '</span>
			</div>
		</li>';
	}
}

function ListOfCommentsSubTask($conn)
{
	$view_id = $_POST['id'];
	$randomColor = '#' . substr(md5(rand()), 0, 6);
	$stmt = $conn->prepare("SELECT  * FROM tbl_MyProject_Services_Comment 
		LEFT JOIN tbl_user ON tbl_MyProject_Services_Comment.user_id = tbl_user.id
		WHERE tbl_MyProject_Services_Comment.appendChil_id = ? ORDER BY tbl_MyProject_Services_Comment.Comment_Date DESC");
	$stmt->bind_param("i", $view_id);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row6 = $result->fetch_assoc()) {
		$firstNameInitial = strtoupper(substr($row6['first_name'], 0, 1));
		$lastNameInitial = strtoupper(substr($row6['last_name'], 0, 1));
		$initials = $firstNameInitial . $lastNameInitial;
		$profilePicture = '';
		$formattedDateTime = date("F d, Y h:i a", strtotime($row6['Comment_Date']));

		echo '<li class="in">
			' . (!empty($profilePicture) ?
				'<img src="' . $profilePicture . '" class="avatar" alt="' . $initials . '" width="27px" height="27px">' :
				'<label class="avatar" style="padding:6px;font-size:20px;color:white;align-items: center; justify-content: center; text-align: center;background-color: ' . $randomColor . ';">' . $initials . '</label>'
			) . '
			<div class="message">
				<span class="arrow"></span>
				<a href="javascript:;" class="name">' . $row6['first_name'] . '&nbsp;' . $row6['last_name'] . '</a>
				<span class="datetime"> at&nbsp;' . $formattedDateTime . '</span>
				<span class="body">' . $row6['Comment_Task'] . '</span>
			</div>
		</li>';
	}
}
function addingCommentSubTask($conn){
	$taskIds = $_POST['Task_ids'];
	$userId = $_POST['user_id'];
	$comment = $_POST['comment'];
	$taskIds = $conn->real_escape_string($taskIds);
	$userId = $conn->real_escape_string($userId);
	$comment = $conn->real_escape_string($comment);

	$query = "INSERT INTO tbl_MyProject_Services_Comment (Comment_Task, user_id, appendChil_id, Comment_Date) 
			  VALUES ('$comment', $userId, $taskIds, NOW())";

	if ($conn->query($query)) {
		if (preg_match('/@(\w+\s+\w+)/i', $comment, $matches)) {
			$mentionedName = $matches[1];
			$query1 = "SELECT email FROM tbl_user WHERE first_name = '$mentionedName'";
			$result1 = $conn->query($query1);

			if ($result1 && $result1->num_rows > 0) {
				$row1 = $result1->fetch_assoc();
				$email = $row1['email'];
				$mention = "Mentioned You In a Comment";
				$commentBody = "Hey $mentionedName,<br><br>You've been mentioned in a comment:<br><br>'$comment'.<br><br>Just thought you should know! ðŸ˜‰";
				ignore_user_abort(true);
				set_time_limit(0);
				header('Connection: close');
				header('Content-Length: ' . ob_get_length());
				ob_end_flush();
				ob_flush();
				flush();
				
				
				
				
				$selectHistory = mysqli_query( $conn,"SELECT
                    c.Task_ids AS c_Task_ids,
                    c.Comment_Task AS c_Comment_Task,
                    c.user_id AS c_user_id,
                    c.Comment_Date AS c_Comment_Date,
                    u.first_name AS u_first_name,
                    u.last_name AS u_last_name,
                    u.client AS u_client,
                    a.CAI_filename AS h_filename
                    FROM tbl_MyProject_Services_Comment AS c

                    LEFT JOIN (
                    	SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON c.user_id = u.ID
                    
                    LEFT JOIN (
                    	SELECT
                        *
                        FROM tbl_MyProject_Services_Childs_action_Items
                        WHERE is_deleted = 0
                    ) AS a
                    ON c.Task_ids = h.History_id
                    
                    WHERE c.Task_ids = $taskIds" );
                if ( mysqli_num_rows($selectHistory) > 0 ) {
                    $rowHistory = mysqli_fetch_array($selectHistory);
                    
                    $to = $row1['email'];
                    $user = $row1["first_name"].' '.$row1["last_name"];
                    $subject = 'New Comment Added: '.$rowHistory['h_filename'];
                    
                    $body = $rowHistory['h_filename'].' '.$rowHistory['h_filename'].' - '.$comment.'<br><br>';

                    if ($_COOKIE['client'] == 1) {
                        $from = 'CannOS@begreenlegal.com';
                        $name = 'BeGreenLegal';
                        $body .= 'Cann OS Team';
                    } else {
                        $from = 'services@interlinkiq.com';
                        $name = 'InterlinkIQ';
                        $body .= 'InterlinkIQ.com Team<br>
                        Consultare Inc.';
                    }

                    if ($mail_sent > 0) {
                        php_mailer_2($to, $user, $subject, $body, $from, $name);
                        $mail_sent++;
                    } else {
                        php_mailer_1($to, $user, $subject, $body, $from, $name);
                        $mail_sent++;
                    }
                }
                
                
				// $mail = new PHPMailer(true);
				// $mail->isSMTP();
			 //   //  $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
				// $mail->CharSet = 'UTF-8';
				// $mail->Host       = 'interlinkiq.com';
				// $mail->SMTPAuth   = true;
				// $mail->Username   = 'admin@interlinkiq.com';
				// $mail->Password   = 'L1873@2019new';
				// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				// $mail->Port       = 465;
				// $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
				// $mail->addAddress($email);
				// $mail->isHTML(true);
				// $mail->Subject = $mention;
				// $mail->Body = "
				// 	<!DOCTYPE html>
				// 	<html>
				// 	<head>
				// 		<style>
				// 			body {
				// 				font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				// 			}
				// 		</style>
				// 	</head>
				// 	<body>
				// 		<div class='container m-auto'>
				// 			$commentBody
				// 		</div>
				// 	</body>
				// 	</html>";
				// try {
				// 	$mail->send();
				// } catch (Exception $e) {
				// 	echo "Could not send. Mailer Error: {$mail->ErrorInfo}";
				// }
				echo 'Comment inserted successfully';
			} else {
				echo 'No user found with the mentioned name';
			}
		} else {
			echo 'Comment inserted successfully';
		}
	} else {
		echo 'Error inserting comment: ' . $conn->error;
	}
}
?>
