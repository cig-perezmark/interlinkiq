<?php
include '../database.php';
$base_url = "https://interlinkiq.com/";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
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
// add Projects
if (isset($_POST['btnCreate_Project'])) { 
    if(!empty($_FILES['Sample_Documents']['name'])){
        $userID = $_COOKIE['ID'];
        $cCollaborator = '';
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        $h_accounts = mysqli_real_escape_string($conn,$_POST['h_accounts']);
        
       
        
        $file = $_FILES['Sample_Documents']['name'];
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['Sample_Documents']['name']));
        $rand = rand(10,1000000);
        $Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
         if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
        $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Sample_Documents,Collaborator_PK,user_cookies,Project_status,Accounts_PK) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$Sample_Documents','$cCollaborator','$userID',0,'$h_accounts')";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../MyPro#tab_Dashboard";</script>';
        }
    }else{
        $userID = $_COOKIE['ID'];
        $cCollaborator = '';
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        $h_accounts = mysqli_real_escape_string($conn,$_POST['h_accounts']);
        if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
            $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Collaborator_PK,user_cookies,Project_status,Accounts_PK) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$cCollaborator','$userID',0,'$h_accounts')";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../MyPro#tab_Dashboard";</script>';
        }
    }
}
// Update Projects
if (isset($_POST['update_Project'])) { 
    if(!empty($_FILES['Sample_Documents']['name'])){
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
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['Sample_Documents']['name']));
        $rand = rand(10,1000000);
        $Sample_Documents =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['Sample_Documents']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
        
        if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
        $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "UPDATE tbl_MyProject_Services set Project_Name = '$Project_Name',Project_Description='$Project_Description',Start_Date='$Start_Date',Desired_Deliver_Date='$Desired_Deliver_Date',Sample_Documents ='$Sample_Documents',Collaborator_PK = '$cCollaborator',Project_status='$Project_status',Accounts_PK='$Accounts' where MyPro_id = $MyPro_id";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../mypro_task.php?view_id='.$MyPro_id.'";</script>';
        }
        else{
		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
    }else{
        $userID = $_COOKIE['ID'];
        $MyPro_id = $_POST['ID'];
        $cCollaborator = '';
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        $Project_status = mysqli_real_escape_string($conn,$_POST['Project_status']);
        $Accounts = mysqli_real_escape_string($conn,$_POST['Accounts_PK']);
        
        if(!empty($_POST["Collaborator"]))
        {
            foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
        }
         $cCollaborator = substr($cCollaborator, 0, -2);
      $sql = "UPDATE tbl_MyProject_Services set Project_Name = '$Project_Name',Project_Description='$Project_Description',Start_Date='$Start_Date',Desired_Deliver_Date='$Desired_Deliver_Date',Collaborator_PK = '$cCollaborator',Project_status='$Project_status',Accounts_PK='$Accounts' where MyPro_id = $MyPro_id";
        if(mysqli_query($conn, $sql)){
              echo '<script> window.location.href = "../mypro_task.php?view_id='.$MyPro_id.'";</script>';
        }
        else{
		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
    }
}
// modalAddHistory add new child
if( isset($_GET['modalAddHistory_Child']) ) {
	$ID = $_GET['modalAddHistory_Child'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
        	';
                        $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="'.$rowType['Parent_MyPro_PK'].'" >';
                           echo '<input type="hidden" class="form-control" name="Services_History_PK" value="'.$rowType['Services_History_PK'].'" >'; 
                       } 
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
                </div>
                
        <div class="form-group">
            <div class="col-md-12">
                <label>Action Types</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<option value="'.$rowType['Action_Items_id'].'" >'.$rowType['Action_Items_name'].'</option>'; 
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time"  value="0" required />
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = $user_id";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
    }
    
if( isset($_POST['btnSave_AddChildItem_layer']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$CIA_Indent_Id = $_POST['ID'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$Services_History_PK = $_POST['Services_History_PK'];

	$files = $_FILES['CAI_files']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['CAI_files']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn,$files);
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_date,CAI_Assign_to,CAI_Status,CIA_progress,Parent_MyPro_PK,CAI_Rendered_Minutes)
	VALUES ('$user_id','$Services_History_PK','$CIA_Indent_Id', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$Parent_MyPro_PK',0)";
	
	if (mysqli_query($conn, $sql)) {
	    $ID = $_POST['ID'];
	    //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	echo json_encode($output);
}

// modalAddHistory
if( isset($_GET['modalAddHistory']) ) {
	$ID = $_GET['modalAddHistory'];
	$today = date('Y-m-d');
    
	echo '<input class="form-control" type="hidden" name="ID" id="parent_id" value="'. $ID .'" />
	    
        	';
                        $queryType_h = "SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services on MyPro_id = MyPro_PK where History_id =$ID";
                    $resultType_h = mysqli_query($conn, $queryType_h);
                    while($rowType_h = mysqli_fetch_array($resultType_h))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="'.$rowType_h['MyPro_id'].'" >'; 
                           echo '<input type="hidden" class="form-control" name="rand_id_pk" value="'.$rowType_h['rand_id'].'" >';
                        
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
                </div>
                
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Types</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<option value="'.$rowType['Action_Items_id'].'" >'.$rowType['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
                <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                            $query_accounts = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                            $result_accounts = mysqli_query($conn, $query_accounts);
                            while($row_accounts = mysqli_fetch_array($result_accounts))
                                 { 
                                   echo '<option value="'.$row_accounts['name'].'" '; echo $rowType_h['Accounts_PK'] == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
                               } 
                        }
                        else if($user_id == 247){ echo '<option value="SFI">SFI</option>';} 
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required />
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_due_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = $user_id";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
    }
}
    
if( isset($_POST['btnSave_AddChildItem']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$CAI_Accounts = $_POST['CAI_Accounts'];
	$CAI_Action_due_date = $_POST['CAI_Action_due_date'];
	$rand_id_pk = rand(1000,1000000);
	$today = date('Y-m-d');
    
    $to_Db_files = '';
	$files = $_FILES['CAI_files']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['CAI_files']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn,$files);
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,Parent_MyPro_PK,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_date,CAI_Assign_to,CAI_Status,CIA_progress,CIA_Indent_Id,CAI_Rendered_Minutes,rand_id_pk,CAI_Accounts,CAI_Action_due_date)
	VALUES ('$user_id','$ID','$Parent_MyPro_PK', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$today','$CAI_Assign_to',1,'$CIA_progress','$ID','0','$rand_id_pk','$CAI_Accounts','$CAI_Action_due_date')";
	
	if (mysqli_query($conn, $sql)) {
	    
	    $last_id = mysqli_insert_id($conn);
		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
         left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $last_id .'" ORDER BY CAI_id LIMIT 1' );
		if ( mysqli_num_rows($selectData) > 0 )
		{
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['CAI_id'];
			$data_filename = $rowData['CAI_filename'];
			$data_description = $rowData['CAI_description'];
			$to_name = $rowData['first_name'];
			$parent_ID = $rowData['Services_History_PK'];
			$data_files = $rowData['CAI_files'];
			
			
            $fileExtension = fileExtension($data_files);
			$src = $fileExtension['src'];
			$embed = $fileExtension['embed'];
			$type = $fileExtension['type'];
			$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
			
			
    	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
    	   {
    	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$rowData['CAI_id'].')">Add logs</a>';
    	   }
    	   else
    	   {
    	       $add_log = '';
        	    if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
    	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
        	   }
    	   }
    	   
    	   //progress status
            if($rowData['CIA_progress']==2){
        	        $completed = '100%';
        	 }
        	 else{
        	     $completed = '';
        	 }
            
            $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$rowData['CAI_id'].')">Add</a>';
            $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$rowData['CAI_id'].')">Edit</a>';

            echo '
                        <tr id="sub_two_'.$rowData['CAI_id'].'" style="border:solid yellow 1px;">
                            <td class="child_border">'.$data_ID.'</td>
                            <td class="child_2">From: ';
                                $owner  = $rowData['CAI_User_PK'];
                                $query = "SELECT * FROM tbl_user where ID = $owner";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){ 
                                   echo $owner_name = $row['first_name'];
                                }
                                echo '
                            </td>
                            <td class="child_2">'.$data_filename.'</td>
                            <td class="child_2">
                            	';
        				    $stringProduct = strip_tags($data_description); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
                   </td>
                            
                            <td class="child_2">'.$rowData['CAI_Accounts'].'</td>
                            <td class="child_2">'.$rowData['Action_Items_name'].'</td>
                            <td class="child_2">Assign to: '.$to_name.'</td>
                            <td class="child_2">';
                                if($rowData['CIA_progress']== 1){ echo 'Inprogress'; }
                                else if($rowData['CIA_progress']== 2){ echo 'Completed';}
                                else{ echo 'Not Started';}
                            echo'</td>
                            <td class="child_2">'.$rowData['CAI_Rendered_Minutes'].$add_log.$completed.'</td>
                            <td class="child_2">Start: '.date("Y-m-d", strtotime($rowData['CAI_Action_date'])).'</td>
                            <td class="child_2">Due: '.date("Y-m-d", strtotime($rowData['CAI_Action_due_date'])).'</td>
                            <td class="child_2">
                                ';
                                    if (!empty($data_files))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			     echo '
                            </td>
                            <td class="child_2">
                                <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:#DC3535;margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> 0 </span>
                                </a>
                            </td>
                            <td class="child_2">'.$add_btn.$edit_btn.'</td>
                        </tr>
            ';
		}
		else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
            
        }
	    
	    //fro email
	    $ID = $_POST['ID'];
	     //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    $message;
	}
	mysqli_close($conn);
}

// modal update child 2 Item
if( isset($_GET['getId_2']) ) {
$ID = $_GET['getId_2'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                        if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                        echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Rendered Time (minutes)</label>
                </div>
                <div class="col-md-12">
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_2']) ) {
//$user_id = $_COOKIE['ID'];
    if($_POST['CIA_progress'] == 2)
    {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $CIA_progress = $_POST['CIA_progress'];
        $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
        
        if(!empty($_POST['CAI_Rendered_Minutes']))
        {
            $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
        }
        else
        {
            $CAI_Rendered_Minutes = 0;
        }
        $CAI_Assign_to = $_POST['CAI_Assign_to'];
        
        $files = $_FILES['CAI_files']['name'];
        if (!empty($files)) {
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['CAI_files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
        	echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$rowData['CAI_id'].')">Edit</a>';
                        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else
        {
            $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today'  where CAI_id = $ID";
         	if (mysqli_query($conn, $sql))
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$rowData['CAI_id'].')">Edit</a>';
                        
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
         	}
        }
    }
    else
    {
        $ID = $_POST['ID'];
    	$CIA_progress = $_POST['CIA_progress'];
    	$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    	if(!empty($_POST['CAI_Rendered_Minutes'])){
    	    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    	}
    	else{
    	    $CAI_Rendered_Minutes = 0;
    	}
    	//$Action_date = $_POST['CAI_Action_date'];
    	$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    	$files = $_FILES['CAI_files']['name'];
    		if (!empty($files))
    		{
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
    		}
    		else
    		{
    		    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
         		
    		}
    }
}

// modal update child 2 Item >
if( isset($_GET['getId_shortcut']) ) {
$ID = $_GET['getId_shortcut'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                    if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                        { ?>
                            <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                        <?php } 
                    }
                    else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                    else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                    else if($user_id == 256){ echo '<option value="KAV">KAV</option>';}
                    else if($user_id == 250){ echo '<option value="SPI">SPI</option>';}
                    else if($user_id == 337){ echo '<option value="HT">HT</option>';}
                    else if($user_id == 308){ echo '<option value="FWCC">FWCC</option>';}
                    else if($user_id == 457){ echo '<option value="PF">PF</option>';}
                    else if($user_id == 253){ echo '<option value="AFIA">AFIA</option>';}
                    else if($user_id == 254){ echo '<option value="JMC">JMC</option>';}
                    echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Rendered Time (minutes)</label>
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
                <div class="col-md-6">
                    <label>Assign to</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_shortcut'])){
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d');
    
    $ID = $_POST['ID'];
    $CIA_progress = $_POST['CIA_progress'];
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
    $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
    $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    
    if(!empty($_POST['CAI_Rendered_Minutes']))
    { $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];}
    else{ $CAI_Rendered_Minutes = 0; }
    
    $CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    //if file is empty
    $to_Db_files = "";
    $files = $_FILES['CAI_files']['name'];
    if (!empty($files)) {
    	$path = '../MyPro_Folder_Files/';
    	$tmp = $_FILES['CAI_files']['tmp_name'];
    	$files = rand(1000,1000000) . ' - ' . $files;
    	$to_Db_files = mysqli_real_escape_string($conn,$files);
    	$path = $path.$files;
    	move_uploaded_file($tmp,$path);
    }
    
    //if task complete
    $CAI_Completed = 0; 
    if($_POST['CIA_progress'] == 2){ $CAI_Completed = 1; }
    
	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today',CAI_Completed = '$CAI_Completed' where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)) 
 	{
 	    $ID = $_POST['ID'];
 	    //$last_id = mysqli_insert_id($conn);
		$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
		left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
         left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
		if ( mysqli_num_rows($selectData) > 0 )
		{
			$rowData = mysqli_fetch_array($selectData);
			$data_ID = $rowData['CAI_id'];
			$data_filename = $rowData['CAI_filename'];
			$data_description = $rowData['CAI_description'];
			$to_name = $rowData['first_name'];
			$Action_Items_name = $rowData['Action_Items_name'];
			
			
			$fileExtension = fileExtension($data_files);
			$src = $fileExtension['src'];
			$embed = $fileExtension['embed'];
			$type = $fileExtension['type'];
			$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
			$data_files = $rowData['CAI_files'];
			if (!empty($data_files))
			{
	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                    <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
	            </a>';
			}
			else
			{
			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
    	            </a>';
			}
			
			$owner  = $rowData['CAI_User_PK'];
            $query = "SELECT * FROM tbl_user where ID = $owner";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result)){ 
                $owner_name = $row['first_name'];
            }
            
            if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
            else{ $sts = 'Not Started';}
            
        if($rowData['CIA_progress']==2){ $completed = '100%'; }else{ $completed = '';}
			$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
	        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
	        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
            $result_comment = mysqli_query($conn, $query_comment);
            while($row_comment = mysqli_fetch_array($result_comment)){
                if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
		        $comments = '<a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$rowData['CAI_id'].')">
                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                </a>';
            }
            $acc = $rowData['CAI_Accounts'];
            $edit_btn = '<a style="color:#fff;" href="#modalGet_shortcut" data-toggle="modal" class="btn red btn-xs" onclick="onclick_shortcut('.$rowData['CAI_id'].')">Edit</a>';
            
			$output = array(
				"CAI_id" => $data_ID,
				"CAI_User_PK" => $owner_name,
				"CAI_filename" => $data_filename,
				"CAI_description" => $data_description,
				"CAI_files" => $files,
				"CAI_Accounts" => $acc,
				"Action_Items_name" => $Action_Items_name,
				"CAI_Assign_to" => $to_name,
				"CIA_progress" => $sts,
				"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
				"CAI_Action_date" => $Start,
				"CAI_Action_due_date" => $Due,
				"comment" => $comments,
				"action_btn" => $edit_btn
			);
			echo json_encode($output);
		}
		else { $message = "Error: " . $sql . "<br>" . mysqli_error($conn); }
	
 	}
}

// modal update child 3 Item
if( isset($_GET['getId_3']) ) {
$ID = $_GET['getId_3'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                    if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                    }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                    else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                        echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Rendered Time (minutes)</label>
                </div>
                <div class="col-md-12">
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_3']) ) {
//$user_id = $_COOKIE['ID'];
    if($_POST['CIA_progress'] == 2)
    {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $CIA_progress = $_POST['CIA_progress'];
        $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
        
        if(!empty($_POST['CAI_Rendered_Minutes']))
        {
            $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
        }
        else
        {
            $CAI_Rendered_Minutes = 0;
        }
        $CAI_Assign_to = $_POST['CAI_Assign_to'];
        
        $files = $_FILES['CAI_files']['name'];
        if (!empty($files)) {
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['CAI_files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
        	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
         	     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else
        {
            $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today'  where CAI_id = $ID";
         	if (mysqli_query($conn, $sql))
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$rowData['CAI_id'].')">Edit</a>';
                        
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
         	}
        }
    }
    else
    {
        $ID = $_POST['ID'];
    	$CIA_progress = $_POST['CIA_progress'];
    	$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    	if(!empty($_POST['CAI_Rendered_Minutes'])){
    	    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    	}
    	else{
    	    $CAI_Rendered_Minutes = 0;
    	}
    	//$Action_date = $_POST['CAI_Action_date'];
    	$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    	$files = $_FILES['CAI_files']['name'];
    		if (!empty($files))
    		{
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
    		}
    		else
    		{
    		    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
         		
    		}
    }
}

// modal update child 4 Item
if( isset($_GET['getId_4']) ) {
$ID = $_GET['getId_4'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                    if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                    }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                    else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                        echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Rendered Time (minutes)</label>
                </div>
                <div class="col-md-12">
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_4']) ) {
//$user_id = $_COOKIE['ID'];
    if($_POST['CIA_progress'] == 2)
    {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $CIA_progress = $_POST['CIA_progress'];
        $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
        
        if(!empty($_POST['CAI_Rendered_Minutes']))
        {
            $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
        }
        else
        {
            $CAI_Rendered_Minutes = 0;
        }
        $CAI_Assign_to = $_POST['CAI_Assign_to'];
        
        $files = $_FILES['CAI_files']['name'];
        if (!empty($files)) {
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['CAI_files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
        	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$rowData['CAI_id'].')">Edit</a>';
                        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else
        {
            $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today'  where CAI_id = $ID";
         	if (mysqli_query($conn, $sql))
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$rowData['CAI_id'].')">Edit</a>';
                        
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
         	}
        }
    }
    else
    {
        $ID = $_POST['ID'];
    	$CIA_progress = $_POST['CIA_progress'];
    	$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    	if(!empty($_POST['CAI_Rendered_Minutes'])){
    	    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    	}
    	else{
    	    $CAI_Rendered_Minutes = 0;
    	}
    	//$Action_date = $_POST['CAI_Action_date'];
    	$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    	$files = $_FILES['CAI_files']['name'];
    		if (!empty($files))
    		{
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
    		}
    		else
    		{
    		    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs4" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs4('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $add_btn = '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$rowData['CAI_id'].')">Add</a>';
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $add_btn.$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
         		
    		}
    }
}

// modal update child 5 Item
if( isset($_GET['getId_5']) ) {
$ID = $_GET['getId_5'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                        if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                        echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Rendered Time (minutes)</label>
                </div>
                <div class="col-md-12">
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_5']) ) {
//$user_id = $_COOKIE['ID'];
    if($_POST['CIA_progress'] == 2)
    {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $CIA_progress = $_POST['CIA_progress'];
        $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
        
        if(!empty($_POST['CAI_Rendered_Minutes']))
        {
            $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
        }
        else
        {
            $CAI_Rendered_Minutes = 0;
        }
        $CAI_Assign_to = $_POST['CAI_Assign_to'];
        
        $files = $_FILES['CAI_files']['name'];
        if (!empty($files)) {
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['CAI_files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
        	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs5" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs5('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$rowData['CAI_id'].')">Edit</a>';
                        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else
        {
            $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today'  where CAI_id = $ID";
         	if (mysqli_query($conn, $sql))
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs5" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs5('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$rowData['CAI_id'].')">Edit</a>';
                        
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
         	}
        }
    }
    else
    {
        $ID = $_POST['ID'];
    	$CIA_progress = $_POST['CIA_progress'];
    	$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    	if(!empty($_POST['CAI_Rendered_Minutes'])){
    	    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    	}
    	else{
    	    $CAI_Rendered_Minutes = 0;
    	}
    	//$Action_date = $_POST['CAI_Action_date'];
    	$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    	$files = $_FILES['CAI_files']['name'];
    		if (!empty($files))
    		{
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs4" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs4('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
    		}
    		else
    		{
    		    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs5" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs5('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" =>$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
         		
    		}
    }
}

// modal update child 5 Item
if( isset($_GET['getId_6']) ) {
$ID = $_GET['getId_6'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
    $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $resultChildTask = mysqli_query($conn, $queryChildTask);
    while($rowChildTask = mysqli_fetch_array($resultChildTask))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Document</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control" name="CAI_Accounts">
                    ';
                        if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $rowChildTask['CAI_Accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                        echo'
                    </select>
                </div>
                <div class="col-md-6">
                <label>Status</label>
                    <select class="form-control" name="CIA_progress" >
                        <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="CAI_Action_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_date'])).'">
                </div>
                <div class="col-md-6">
                <label>Duedate</label>
                    <input class="form-control" type="date" name="CAI_Action_due_date" value="'.date("Y-m-d", strtotime($rowChildTask['CAI_Action_due_date'])).'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Rendered Time (minutes)</label>
                </div>
                <div class="col-md-12">
                    <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_6']) ) {
//$user_id = $_COOKIE['ID'];
    if($_POST['CIA_progress'] == 2)
    {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $CIA_progress = $_POST['CIA_progress'];
        $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
        
        if(!empty($_POST['CAI_Rendered_Minutes']))
        {
            $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
        }
        else
        {
            $CAI_Rendered_Minutes = 0;
        }
        $CAI_Assign_to = $_POST['CAI_Assign_to'];
        
        $files = $_FILES['CAI_files']['name'];
        if (!empty($files)) {
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['CAI_files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
        	$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$rowData['CAI_id'].')">Edit</a>';
                        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else
        {
            $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today'  where CAI_id = $ID";
         	if (mysqli_query($conn, $sql))
         	{
         	    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			     $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$rowData['CAI_id'].')">Edit</a>';
                        
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
         	}
        }
    }
    else
    {
        $ID = $_POST['ID'];
    	$CIA_progress = $_POST['CIA_progress'];
    	$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
        $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
        $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
        $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    	if(!empty($_POST['CAI_Rendered_Minutes'])){
    	    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    	}
    	else{
    	    $CAI_Rendered_Minutes = 0;
    	}
    	//$Action_date = $_POST['CAI_Action_date'];
    	$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    	$files = $_FILES['CAI_files']['name'];
    		if (!empty($files))
    		{
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			$sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		     $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" => $edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
    		}
    		else
    		{
    		    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Accounts = '$CAI_Accounts',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql))
         		{
         		    $ID = $_POST['ID'];
         		 //   $last_id = mysqli_insert_id($conn);
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_Childs_action_Items
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
                     left join tbl_hr_employee on CAI_Assign_to = ID WHERE CAI_id="'. $ID .'" ORDER BY CAI_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				$data_ID = $rowData['CAI_id'];
        				$data_filename = $rowData['CAI_filename'];
        				$data_description = $rowData['CAI_description'];
        				$to_name = $rowData['first_name'];
        				$Action_Items_name = $rowData['Action_Items_name'];
        				
        				$data_files = $rowData['CAI_files'];
            			if (!empty($data_files))
            			{
            	            $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            	            $files = '<a style="color:#fff;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">1</b> </span>
            	            </a>';
            			}
            			else
            			{
            			    $fileExtension = fileExtension($data_files);
            				$src = $fileExtension['src'];
            				$embed = $fileExtension['embed'];
            				$type = $fileExtension['type'];
            				$file_extension = $fileExtension['file_extension'];
            	            $url = $base_url.'../MyPro_Folder_Files/';
            			    $files = '<a style="color:#fff;font-size:18px;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
            	                <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"> <b style="font-size:14px;">0</b> </span>
                	            </a>';
            			}
            			
            			$owner  = $rowData['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
                        
                        if($rowData['CIA_progress']== 1){ $sts = 'Inprogress'; }
        	            else if($rowData['CIA_progress']== 2){ $sts = 'Completed';}
        	            else{ $sts = 'Not Started';}
        	            
        	           
                	   $render = $rowData['CAI_Rendered_Minutes'].' minute(s)';
                	   if($rowData['Service_log_Status'] !=1 && $rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes']))
                	   {
                	           $add_log = ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$rowData['CAI_id'].')">Add logs</a>';
                	   }
                	   else
                	   {
                	       $add_log = '';
                    	  if($rowData["CAI_Assign_to"] == $_COOKIE['employee_id'] && !empty($rowData['CAI_Rendered_Minutes'])){
                	              $add_log = '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	   }
                	   }
                        if($rowData['CIA_progress']==2){
                    	        $completed = '100%';
                    	 }
                    	 else{
                    	     $completed = '';
                    	 }
        				$Start = date("Y-m-d", strtotime($rowData['CAI_Action_date']));
				        $Due = date("Y-m-d", strtotime($rowData['CAI_Action_due_date']));
				        
				        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$data_ID'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){
                            if($row_comment['count'] == 0){ $color_code= '#DC3535';}else{$color_code = 'blue';}
    				        $comments = '<a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$rowData['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                            <span class="badge" style="background-color:'.$color_code.';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;"> <b>'.$row_comment['count'].'</b> </span>
                            </a>';
                        }
                        $acc = $rowData['CAI_Accounts'];
                        $edit_btn = '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$rowData['CAI_id'].')">Edit</a>';
        
        				$output = array(
        					"CAI_id" => $data_ID,
        					"CAI_User_PK" => $owner_name,
        					"CAI_filename" => $data_filename,
        					"CAI_description" => $data_description,
        					"CAI_files" => $files,
        					"CAI_Accounts" => $acc,
        					"Action_Items_name" => $Action_Items_name,
        					"CAI_Assign_to" => $to_name,
        					"CIA_progress" => $sts,
        					"CAI_Rendered_Minutes" => $render.' '.$add_log.' '.$completed,
        					"CAI_Action_date" => $Start,
        					"CAI_Action_due_date" => $Due,
        					"comment" => $comments,
        					"action_btn" =>$edit_btn
        				);
        				echo json_encode($output);
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        		
         		}
         		
    		}
    }
}
// modal more details parent Item
if( isset($_GET['seemoreId']) ) {
$ID = $_GET['seemoreId'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_History where History_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

// modal more details parent Item
if( isset($_GET['seemoreId2']) ) {
$ID = $_GET['seemoreId2'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

if( isset($_GET['seemore_subId2']) ) {
$ID = $_GET['seemore_subId2'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_filename'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

if( isset($_GET['seemore_subId3']) ) {
$ID = $_GET['seemore_subId3'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_filename'].'</p>
                </div>
            </div>
            ';
     }
}
if( isset($_GET['seemore_subId4']) ) {
$ID = $_GET['seemore_subId4'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_filename'].'</p>
                </div>
            </div>
            ';
     }
}

if( isset($_GET['seemore_subId5']) ) {
$ID = $_GET['seemore_subId5'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_filename'].'</p>
                </div>
            </div>
            ';
     }
}

if( isset($_GET['seemore_subId6']) ) {
$ID = $_GET['seemore_subId6'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_filename'].'</p>
                </div>
            </div>
            ';
     }
}

// modal more details parent Item
if( isset($_GET['seemoreId3']) ) {
$ID = $_GET['seemoreId3'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

// modal more details parent Item
if( isset($_GET['seemoreId4']) ) {
$ID = $_GET['seemoreId4'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

// modal more details parent Item
if( isset($_GET['seemoreId5']) ) {
$ID = $_GET['seemoreId5'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}

// modal more details parent Item
if( isset($_GET['seemoreId6']) ) {
$ID = $_GET['seemoreId6'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <p>'.$row['CAI_description'].'</p>
                </div>
            </div>
            ';
       
     }
     
}
// modal update parent Item
if( isset($_GET['getParentId_2']) ) {
$ID = $_GET['getParentId_2'];
$today = date('Y-m-d');

echo '<input class="form-control" type="hidden" name="ID" id="parent_ids" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_MyProject_Services_History where History_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
     { 
        echo'
            <div class="form-group">
                <div class="col-md-12">
                    <label>Task Name</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="filename" value="'.$row['filename'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="description">'.$row['description'].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Action</label>
                    <select class="form-control" name="Action_taken">
                    ';
                        $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                        $result_a = mysqli_query($conn, $query_a);
                        while($row_a = mysqli_fetch_array($result_a))
                             { ?>
                               <option value="<?php echo $row_a['Action_Items_id']; ?>" <?php if($row_a['Action_Items_id'] == $row['Action_taken'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_a['Action_Items_name']; ?></option>
                           <?php } 
                    
                    echo'
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Account</label>
                    <select class="form-control" name="h_accounts">
                    ';
                        if($user_id == 34){
                        $query_ac = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_ac = mysqli_query($conn, $query_ac);
                        while($row_ac = mysqli_fetch_array($result_ac))
                             { ?>
                               <option value="<?php echo $row_ac['name']; ?>" <?php if($row_ac['name'] == $row['h_accounts'] ){echo 'selected';}else{echo '';} ?>><?php echo $row_ac['name']; ?></option>
                           <?php } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
                    echo'
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Document</label>
                    <input class="form-control" type="" value="'.$row['files'].'">
                </div>
                <div class="col-md-6">
                    <label>...</label>
                    <input class="form-control" type="file" name="files" value="'.$row['files'].'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Status</label>
                </div>
                <div class="col-md-12">
                    <select class="form-control" name="H_progress" >
                        <option value="0" '; echo $row['H_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $row['H_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $row['H_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Estimated Time (minutes)</label>
                    <input type="number" class="form-control" name="Estimated_Time" value="'.$row['Estimated_Time'].'">
                </div>
                <div class="col-md-6">
                    <label>Desired Duedate</label>
                    <input class="form-control" type="date" name="Action_date" value="'.date("Y-m-d", strtotime($row['Action_date'])).'">
                </div>
            </div>
        ';
        echo '
        <div class="form-group">
            <div class="col-md-12">
                    <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="Assign_to_history" readonly>
                    <option value="0">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { ?>
                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $row['Assign_to_history'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                       <?php } 
                       
                        $query = "SELECT * FROM tbl_user where ID = $user_id";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result))
                         { ?>
                           <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowChildTask['Assign_to_history'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                       <?php } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>
        ';
     }
     
}
        
if( isset($_POST['btnSubmit_parent']) ) {
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
        $ID = $_POST['ID'];
        $H_progress = $_POST['H_progress'];
        $filename = mysqli_real_escape_string($conn,$_POST['filename']);
        $H_progress = addslashes($_POST['H_progress']);
        $description = mysqli_real_escape_string($conn,$_POST['description']);
        $Assign_to_history = $_POST['Assign_to_history'];
        $Action_taken = $_POST['Action_taken'];
        $Estimated_Time = $_POST['Estimated_Time'];
        $h_accounts = $_POST['h_accounts'];
        $Action_date = $_POST['Action_date'];
        
        if (!empty($_FILES['files']['name'])) {
            $files = $_FILES['files']['name'];
        	$path = '../MyPro_Folder_Files/';
        	$tmp = $_FILES['files']['tmp_name'];
        	$files = rand(1000,1000000) . ' - ' . $files;
        	$to_Db_files = mysqli_real_escape_string($conn,$files);
        	$path = $path.$files;
        	move_uploaded_file($tmp,$path);
            	$sql = "UPDATE tbl_MyProject_Services_History  SET  Action_date='$Action_date', h_accounts ='$h_accounts',Assign_to_history = '$Assign_to_history',filename = '$filename',files ='$to_Db_files',H_progress = '$H_progress',description ='$description',Action_taken = '$Action_taken',Estimated_Time='$Estimated_Time' where History_id = $ID";
             	if (mysqli_query($conn, $sql)) 
             	{
         	        $ID = $_POST['ID'];
        			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_History
        			left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
                     left join tbl_hr_employee on Assign_to_history = ID WHERE History_id="'. $ID .'" ORDER BY History_id LIMIT 1' );
        			if ( mysqli_num_rows($selectData) > 0 )
        			{
        				$rowData = mysqli_fetch_array($selectData);
        				
        				$data_files = $rowData['files'];
        	            $fileExtension = fileExtension($data_files);
        				$src = $fileExtension['src'];
        				$embed = $fileExtension['embed'];
        				$type = $fileExtension['type'];
        				$file_extension = $fileExtension['file_extension'];
        	            $url = $base_url.'../MyPro_Folder_Files/';
            			
            			$owner  = $rowData['user_id'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            $owner_name = $row['first_name'];
                        }
        	           
                        
                        echo '
                        
                    	<table style="table-layout: fixed; width: 100%">
                    	    <tbody>
                    	        <tr onclick="view_more('.$rowData['History_id'].')">
                					<th class="child_1" width="80px">'.$rowData['History_id'].'</th>
                					';
                					    $owner  = $rowData['user_id'];
                                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                                        $result = mysqli_query($conn, $query);
                                        while($row = mysqli_fetch_array($result)){ 
                                            echo '<th class="child_1">From: '.$row['first_name'].'</th>';
                                        }
                					echo '
                					<th class="child_1">'.$rowData['filename'].'</th>
                					<th class="child_1" style="width:20%;">
                					';
                					$stringProduct = strip_tags($rowData['description']); 
                                       if(strlen($stringProduct) > 76):
                                           $stringCut = substr($stringProduct,0,76);
                                           $endPoint = strrpos($stringCut,' ');
                                           $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                           $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$data1['History_id'].')">
                                           <i style="color:black;">See more...</i></a>';
                                       endif;
                                       echo $stringProduct;
                                       echo '</th>
                					
                					<th class="child_1">Account: '.$rowData['h_accounts'].'</th>
                					<th class="child_1">Assign to: '.$rowData['first_name'].'</th>
                					<th class="child_1">'.$rowData['Action_Items_name'].'</th>
                					<th class="child_1" width="6%">Duedate: '.date("Y-m-d", strtotime($rowData['Action_date'])).'</th>
                					<th class="child_1" width="5%">
                					    ';
                                            if (!empty($data_files))
                            			     {
                            			         echo '
                            			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                        <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                        	        </a>
                                        	    ';
                            			     }
                            			     else
                            			     {
                            			         echo '
                            			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                                	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                        <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                        	        </a>
                            			         ';
                            			     }
                            			  echo '
                					</th>
                					<th>
                					    
                					</th>
                				</tr>
                    	    </tbody>
                    	</table>
                                               
                        ';
        			}
        			else {
                        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                        
                    }
        	
         	}
        }
        else{
            $ID = $_POST['ID'];
            $sql = "UPDATE tbl_MyProject_Services_History  SET  Action_date='$Action_date', h_accounts ='$h_accounts',Assign_to_history = '$Assign_to_history',filename = '$filename',H_progress = '$H_progress',description ='$description',Action_taken = '$Action_taken',Estimated_Time='$Estimated_Time' where History_id = $ID";
         	if (mysqli_query($conn, $sql)) 
         	{
     	        $ID = $_POST['ID'];
    			$selectData = mysqli_query( $conn,'SELECT *,tbl_MyProject_Services_History.user_id as owner FROM tbl_MyProject_Services_History
    			left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
                 left join tbl_hr_employee on Assign_to_history = ID WHERE History_id="'. $ID .'" ORDER BY History_id LIMIT 1' );
    			if ( mysqli_num_rows($selectData) > 0 )
    			{
    				$rowData = mysqli_fetch_array($selectData);
    				
    				$data_files = $rowData['files'];
    	            $fileExtension = fileExtension($data_files);
    				$src = $fileExtension['src'];
    				$embed = $fileExtension['embed'];
    				$type = $fileExtension['type'];
    				$file_extension = $fileExtension['file_extension'];
    	            $url = $base_url.'../MyPro_Folder_Files/';
        			
        			$owner  = $rowData['user_id'];
                    $query = "SELECT * FROM tbl_user where ID = $owner";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result)){ 
                        $owner_name = $row['first_name'];
                    }
    	           
                    
                    echo '
                    
                	<table style="table-layout: fixed; width: 100%">
                	    <tbody>
                	        <tr onclick="view_more('.$rowData['History_id'].')">
            					<th class="child_1" width="80px">'.$rowData['History_id'].'</th>
            					';
            					    $owner  = $rowData['owner'];
                                    $query = "SELECT * FROM tbl_user where ID = '$owner'";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_array($result)){ 
                                        echo '<th class="child_1">From: '.$row['first_name'].'</th>';
                                    }
            					echo '
            					<th class="child_1">'.$rowData['filename'].'</th>
            					<th class="child_1" width="20%">';
                					$stringProduct = strip_tags($rowData['description']); 
                                       if(strlen($stringProduct) > 76):
                                           $stringCut = substr($stringProduct,0,76);
                                           $endPoint = strrpos($stringCut,' ');
                                           $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                           $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail" data-toggle="modal" onclick="get_moreDetails('.$data1['History_id'].')">
                                           <i style="color:black;">See more...</i></a>';
                                       endif;
                                       echo $stringProduct;
                                       echo '</th>
            					
            					<th class="child_1">Account: '.$rowData['h_accounts'].'</th>
            					<th class="child_1">Assign to: '.$rowData['first_name'].'</th>
            					<th class="child_1">'.$rowData['Action_Items_name'].'</th>
            					<th class="child_1">Duedate: '.date("Y-m-d", strtotime($rowData['Action_date'])).'</th>
            					<th class="child_1" width="5%">
            					    ';
                                        if (!empty($data_files))
                        			     {
                        			         echo '
                        			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                            	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                    <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                    	        </a>
                                    	    ';
                        			     }
                        			     else
                        			     {
                        			         echo '
                        			            <a style="color:;" data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                            	   <i class="icon-doc" style="font-size:18px;color:;margin-left:12px;"></i>
                                                    <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                    	        </a>
                        			         ';
                        			     }
                        			  echo '
            					</th>
            					<th>
            					    
            					</th>
            				</tr>
                	    </tbody>
                	</table>
                                           
                    ';
    			}
    			else {
                    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                    
                }
     	    }
        }
        	
}

// Comments Status Flag
	if( isset($_GET['modal_Comments']) ) {
		$ID = $_GET['modal_Comments'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_2" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and Services_History_PK = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = $owner";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                            }
        				echo '
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}

// Comments Status Flag
	if( isset($_GET['modal_Comments_filter']) ) {
		$ID = $_GET['modal_Comments_filter'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_filter_2" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments_filter']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and Services_History_PK = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = $owner";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                            }
        				echo '
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modal_get_newlogs" data-toggle="modal" class="btn red btn-xs" onclick="btnLogs('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments_filter" data-toggle="modal" onclick="btn_Comments_filter('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}

// Comments3 Status Flag
	if( isset($_GET['modal_Comments3']) ) {
		$ID = $_GET['modal_Comments3'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_3" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments3']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>
        			    <td class="child_border"></td>
        			    <td class="child_2">From: ';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = '$owner'";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo $row['first_name'];
                            }
        				echo '
        				</td>
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
        				    $stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail3" data-toggle="modal" onclick="get_moreDetails3('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
        				</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data2['CAI_id'].')">Add</a>';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}

// Comments4 Status Flag
	if( isset($_GET['modal_Comments4']) ) {
		$ID = $_GET['modal_Comments4'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_4" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments4']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_2">From: ';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = '$owner'";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo $row['first_name'];
                            }
        				echo '
        				</td>
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
        				    $stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail4" data-toggle="modal" onclick="get_moreDetails4('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
        				</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs3" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs3('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data2['CAI_id'].')">Add</a>';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}

// Comments4 Status Flag
	if( isset($_GET['modal_Comments5']) ) {
		$ID = $_GET['modal_Comments5'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_5" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments5']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_2">From: ';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = '$owner'";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo $row['first_name'];
                            }
        				echo '
        				</td>
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail5" data-toggle="modal" onclick="get_moreDetails5('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
        				</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs5" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs5('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}

// Comments4 Status Flag
	if( isset($_GET['modal_Comments6']) ) {
		$ID = $_GET['modal_Comments6'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" id="comment_6" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                 $query_comment = "SELECT * FROM tbl_MyProject_Services_Comment left join tbl_user on ID = tbl_MyProject_Services_Comment.user_id where Task_ids = $ID";
                $result_comment = mysqli_query($conn, $query_comment);
                while($row_comment = mysqli_fetch_array($result_comment))
                 { 
                     
                    if($row_comment['user_id'] != $_COOKIE['ID']){
                     echo'
                    <div class="row">
                        <div class="col-md-12">
                            <i style="float:left;padding:5px;border-radius:5px;margin-top:5px;background-color:#ccc;">'.$row_comment['Comment_Task'].'</i>
                           <i style="float:left;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['first_name'].' - '.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                        ';
                        }else {
                        echo '
                        <div class="row">
                        <div class="col-md-12">
                            <i class="bg-blue" style="float:right;padding:5px;border-radius:5px;color:#fff;margin-top:5px;">'.$row_comment['Comment_Task'].'</i>
                            <i style="float:right;padding:5px;border-radius:5px;color:;margin-bottom:-5px;font-size:10px;">'.$row_comment['Comment_Date'].'</i>
                        </div>
                    </div>
                    '; 
                        }
                 }
                    echo '
                    <br>
                    <div class="form-group"> 
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="comment_task"></textarea>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                    <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                    <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                    <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                    <input class="form-control" type="hidden" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    <input class="form-control" type="hidden" name="CAI_description" value="'.$rowChildTask['CAI_description'].'">
                    <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
                    <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                 
                
             }
             
        }
        
if( isset($_POST['btnSave_Comments6']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $comment_task = mysqli_real_escape_string($conn,$_POST['comment_task']);
    $CAI_Assign_to = mysqli_real_escape_string($conn,$_POST['CAI_Assign_to']);
    $Parent_MyPro_PK = mysqli_real_escape_string($conn,$_POST['Parent_MyPro_PK']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CIA_Indent_Id = mysqli_real_escape_string($conn,$_POST['CIA_Indent_Id']);
    
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d h:i:s');
    
    $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
	VALUES ('$user_i','$comment_task','$today','$ID')";
	if(mysqli_query($conn, $sql2)){
	    
	        $ID = $_POST['ID'];
	        $data1 = $_POST['CIA_Indent_Id'];
    	    $view_id = $_POST['Parent_MyPro_PK'];
    	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
    	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
            left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
    		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
            $result2 = mysqli_query($conn, $query2);
            while($data2 = mysqli_fetch_array($result2))
             {
                $filesL9 = $data2["CAI_files"];
                $fileExtension = fileExtension($filesL9);
        		$src = $fileExtension['src'];
        		$embed = $fileExtension['embed'];
        		$type = $fileExtension['type'];
        		$file_extension = $fileExtension['file_extension'];
                $url = $base_url.'../MyPro_Folder_Files/';
        		echo '
        			    <td class="child_border">'.$data2['CAI_id'].'</td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_border"></td>
        			    <td class="child_2">From: ';
        				    $owner  = $data2['CAI_User_PK'];
                            $query = "SELECT * FROM tbl_user where ID = '$owner'";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){ 
                                echo $row['first_name'];
                            }
        				echo '
        				</td>
        				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
        				<td class="child_2" style="width:;">
        				';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail6" data-toggle="modal" onclick="get_moreDetails6('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                            echo '
        				</td>
        				<td class="child_2">
        					';
                                
                                    if (!empty($filesL9))
                    			     {
                    			         echo '
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                                	        </a>
                                	    ';
                    			     }
                    			     else
                    			     {
                    			         echo'
                    			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                        	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                                <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                                	        </a>
                    			         ';
                    			     }
                    			  echo '   
                                
        				</td>
        				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
        				<td class="child_2">'.$data2['Action_Items_name'].'</td>
        				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
        				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
        	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
        	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
        	            //rendered time
        	            if(!empty($data2['CAI_Rendered_Minutes'])){
                	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
                	            
                	       if($data2['Service_log_Status'] !=1 && $data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	           echo ' <a style="font-weight:800;color:#fff;" href="#modalGetHistory_logs6" data-toggle="modal" class="btn red btn-xs" onclick="btnNew_History_logs6('.$data2['CAI_id'].')">Add logs</a>';
                	       }else{
                    	       if($data2["CAI_Assign_to"] == $_COOKIE['employee_id']){
                	              echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                    	        }
                	       }
                	    }
                	    if($data2['CIA_progress']==2){
                	        echo '<td class="child_2">100%</td>';
                	    }
        				echo '
        				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
        				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
        				<td class="child_2">
        				';
                            $_comment  = $data2['CAI_id'];
                            $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                            $result_comment = mysqli_query($conn, $query_comment);
                            while($row_comment = mysqli_fetch_array($result_comment)){ 
                                echo '
                                <a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$data2['CAI_id'].')">
                                <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                    <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                        <b>'.$row_comment['count'].'</b>
                                    </span>
                                </a>
                                ';
                            }
                          echo '  
                        </td>
                        <td class="child_2">';
                            echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$data2['CAI_id'].')">Edit</a>';
                            echo '
                        </td>
        		';
             }
	        
	        $cookie_frm = $user_i;
		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user  WHERE ID = $cookie_frm" );
		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
		    //to
		    $cookie_to = $CAI_Assign_to;
		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
		     //Projects
		    $project_id = $Parent_MyPro_PK;
		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
		    
		       $user = 'interlinkiq.com';
               $from = $frm;
               $to = $t;
               $subject = 'Task Commented: '.$CAI_filename;
               $body = '
                        <br>
                        <b>Task</b>
                        <br>
                        '.$CAI_filename.'
                        <br>
                        <br>
                        <b>Description</b> <br>
                        '.$CAI_description.'
                        <br>
                        <br>
                        <b>Commented by</b> <br>
                        '.$frm_name.'
                        <br>
                        <br>
                        <b>Comment</b> <br>
                        '.$comment_task.'
                        <br>
                        <br>
                        <b>Projects</b><br>
                        '.$prj.'
    
                        <br><br><br>
                        <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
        	    $mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	mysqli_close($conn);
}
// modalAddHistory add new child 2
if( isset($_GET['modalAddHistory_Child2']) ) {
	$ID = $_GET['modalAddHistory_Child2'];
	$today = date('Y-m-d');
	$last_sudId3 = '';
    $query_c = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items  where CIA_Indent_Id =$ID order by CAI_id DESC LIMIT 1";
    $result_c = mysqli_query($conn, $query_c);
    while($row_c = mysqli_fetch_array($result_c))
     {
         $last_sudId3 = $row_c['CAI_id'];
     }
     echo '<input type="hidden" class="form-control" id="last_sudId3"  value="'.$last_sudId3.'" >';
	echo '<input class="form-control" type="hidden" name="ID" id="layer_2"  value="'. $ID .'" />
        	';
                        $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK"  value="'.$rowType['Parent_MyPro_PK'].'" >';
                           echo '<input type="hidden" class="form-control" name="Services_History_PK"  value="'.$rowType['Services_History_PK'].'" >'; 
                           echo '<input type="hidden" class="form-control" name="CIA_Indent_Id"  value="'.$rowType['CIA_Indent_Id'].'" >';
                           
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
                </div>
                
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Types</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $query_item = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $result_item = mysqli_query($conn, $query_item);
                    while($row_item = mysqli_fetch_array($result_item))
                         { 
                           echo '<option value="'.$row_item['Action_Items_id'].'" >'.$row_item['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
            <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                        $query_account = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                    $result_account = mysqli_query($conn, $query_account);
                    while($row_account = mysqli_fetch_array($result_account))
                         { 
                           echo '<option value="'.$row_account['name'].'"'; echo $rowType['CAI_Accounts'] == $row_account['name'] ? 'selected' : ''; echo' >'.$row_account['name'].'</option>'; 
                       }
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required>
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
     }
    }
        
if( isset($_POST['btnSave_AddChildItem_layer2']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$CIA_Indent_Id = $_POST['ID'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$Services_History_PK = $_POST['Services_History_PK'];
	$CAI_Accounts = $_POST['CAI_Accounts'];
    $today = date('Y-m-d');
	$files = $_FILES['CAI_files']['name'];
	
	$path = '../MyPro_Folder_Files/';
	$tmp = $_FILES['CAI_files']['tmp_name'];
	$files = rand(1000,1000000) . ' - ' . $files;
	$to_Db_files = mysqli_real_escape_string($conn,$files);
	$path = $path.$files;
	move_uploaded_file($tmp,$path);

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_due_date,CAI_Assign_to,CAI_Status,CIA_progress,Parent_MyPro_PK,CAI_Rendered_Minutes,CAI_Action_date,CAI_Accounts)
	VALUES ('$user_id','$Services_History_PK','$CIA_Indent_Id', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$Parent_MyPro_PK',0,'$today','$CAI_Accounts')";
	
	if (mysqli_query($conn, $sql)) {
	    
	    $last_id = mysqli_insert_id($conn);
        $data1 = $_POST['ID'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $last_id";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '<tr id="sub_three_main'.$data2['CAI_id'].'">
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_2">From: ';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo $row['first_name'];
                        }
    				echo '
    				</td>
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				';
        				    $stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail3" data-toggle="modal" onclick="get_moreDetails3('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}

            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
                </tr>
    		';
         }
	    //emailer
	    $ID = $_POST['ID'];
	    //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    $message;
	}
	mysqli_close($conn);
}

// modalAddHistory add new child 2
if( isset($_GET['modalAddHistory_Child3']) ) {
	$ID = $_GET['modalAddHistory_Child3'];
	$today = date('Y-m-d');
	$last_sudId4 = '';
    $query_c = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items  where CIA_Indent_Id =$ID order by CAI_id DESC LIMIT 1";
    $result_c = mysqli_query($conn, $query_c);
    while($row_c = mysqli_fetch_array($result_c))
     {
         $last_sudId4 = $row_c['CAI_id'];
     }
     echo '<input type="hidden" class="form-control" id="last_sudId4"  value="'.$last_sudId4.'" >';
	echo '<input class="form-control" type="hidden" name="ID" id="layer_3"  value="'. $ID .'" />
        	';
                        $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK"  value="'.$rowType['Parent_MyPro_PK'].'" >';
                           echo '<input type="hidden" class="form-control" name="Services_History_PK"  value="'.$rowType['Services_History_PK'].'" >'; 
                           echo '<input type="hidden" class="form-control" name="CIA_Indent_Id"  value="'.$rowType['CIA_Indent_Id'].'" >';
                           
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
                </div>
                
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Types</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $query_item = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $result_item = mysqli_query($conn, $query_item);
                    while($row_item = mysqli_fetch_array($result_item))
                         { 
                           echo '<option value="'.$row_item['Action_Items_id'].'" >'.$row_item['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
            <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                        $query_account = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_account = mysqli_query($conn, $query_account);
                        while($row_account = mysqli_fetch_array($result_account))
                             { 
                               echo '<option value="'.$row_account['name'].'"'; echo $rowType['CAI_Accounts'] == $row_account['name'] ? 'selected' : ''; echo' >'.$row_account['name'].'</option>'; 
                           } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required>
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id  or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
     }
    }
        
if( isset($_POST['btnSave_AddChildItem_layer3']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$CIA_Indent_Id = $_POST['ID'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$Services_History_PK = $_POST['Services_History_PK'];
	$CAI_Accounts = $_POST['CAI_Accounts'];
    $today = date('Y-m-d');
	$files = $_FILES['CAI_files']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['CAI_files']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn,$files);
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_due_date,CAI_Assign_to,CAI_Status,CIA_progress,Parent_MyPro_PK,CAI_Rendered_Minutes,CAI_Action_date,CAI_Accounts)
	VALUES ('$user_id','$Services_History_PK','$CIA_Indent_Id', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$Parent_MyPro_PK',0,'$today','$CAI_Accounts')";
	
	if (mysqli_query($conn, $sql)) {
	    
	    $last_id = mysqli_insert_id($conn);
        $data1 = $_POST['ID'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $last_id";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '<tr id="sub_four_'.$data2['CAI_id'].'">
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_2">From: ';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo $row['first_name'];
                        }
    				echo '
    				</td>
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				';
        				    $stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail4" data-toggle="modal" onclick="get_moreDetails4('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}

            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
                </tr>
    		';
         }
	    //emailer
	    $ID = $_POST['ID'];
	    //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    $message;
	}
	mysqli_close($conn);
}

if( isset($_GET['modalAddHistory_Child4']) ) {
	$ID = $_GET['modalAddHistory_Child4'];
	$today = date('Y-m-d');
	$last_sudId5 = '';
    $query_c = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items  where CIA_Indent_Id =$ID order by CAI_id DESC LIMIT 1";
    $result_c = mysqli_query($conn, $query_c);
    while($row_c = mysqli_fetch_array($result_c))
     {
         $last_sudId5 = $row_c['CAI_id'];
     }
     echo '<input type="hidden" class="form-control" id="last_sudId5"  value="'.$last_sudId5.'" >';
	echo '<input class="form-control" type="hidden" name="ID" id="layer_4"  value="'. $ID .'" />
        	';
                        $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK"  value="'.$rowType['Parent_MyPro_PK'].'" >';
                           echo '<input type="hidden" class="form-control" name="Services_History_PK"  value="'.$rowType['Services_History_PK'].'" >'; 
                           echo '<input type="hidden" class="form-control" name="CIA_Indent_Id"  value="'.$rowType['CIA_Indent_Id'].'" >';
                           
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
                </div>
                
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Types</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $query_item = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $result_item = mysqli_query($conn, $query_item);
                    while($row_item = mysqli_fetch_array($result_item))
                         { 
                           echo '<option value="'.$row_item['Action_Items_id'].'" >'.$row_item['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
            <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                        $query_account = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_account = mysqli_query($conn, $query_account);
                        while($row_account = mysqli_fetch_array($result_account))
                             { 
                               echo '<option value="'.$row_account['name'].'"'; echo $rowType['CAI_Accounts'] == $row_account['name'] ? 'selected' : ''; echo' >'.$row_account['name'].'</option>'; 
                           } 
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required>
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
     }
    }
        
if( isset($_POST['btnSave_AddChildItem_layer4']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$CIA_Indent_Id = $_POST['ID'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$Services_History_PK = $_POST['Services_History_PK'];
	$CAI_Accounts = $_POST['CAI_Accounts'];
    $today = date('Y-m-d');
	$files = $_FILES['CAI_files']['name'];
	if (!empty($files)) {
		$path = '../MyPro_Folder_Files/';
		$tmp = $_FILES['CAI_files']['tmp_name'];
		$files = rand(1000,1000000) . ' - ' . $files;
		$to_Db_files = mysqli_real_escape_string($conn,$files);
		$path = $path.$files;
		move_uploaded_file($tmp,$path);
	}

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_due_date,CAI_Assign_to,CAI_Status,CIA_progress,Parent_MyPro_PK,CAI_Rendered_Minutes,CAI_Action_date,CAI_Accounts)
	VALUES ('$user_id','$Services_History_PK','$CIA_Indent_Id', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$Parent_MyPro_PK',0,'$today','$CAI_Accounts')";
	
	if (mysqli_query($conn, $sql)) {
	    
	    $last_id = mysqli_insert_id($conn);
        $data1 = $_POST['ID'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $last_id";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '<tr id="sub_five_'.$data2['CAI_id'].'">
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_2">From: ';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo $row['first_name'];
                        }
    				echo '
    				</td>
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				    ';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail5" data-toggle="modal" onclick="get_moreDetails5('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}

            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
                </tr>
    		';
         }
	    //emailer
	    $ID = $_POST['ID'];
	    //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    $message;
	}
	mysqli_close($conn);
}

if( isset($_GET['modalAddHistory_Child5']) ) {
	$ID = $_GET['modalAddHistory_Child5'];
	$today = date('Y-m-d');
	$last_sudId6 = '';
    $query_c = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items  where CIA_Indent_Id =$ID order by CAI_id DESC LIMIT 1";
    $result_c = mysqli_query($conn, $query_c);
    while($row_c = mysqli_fetch_array($result_c))
     {
         $last_sudId6 = $row_c['CAI_id'];
     }
     echo '<input type="hidden" class="form-control" id="last_sudId6"  value="'.$last_sudId6.'" >';
	echo '<input class="form-control" type="hidden" name="ID" id="layer_5"  value="'. $ID .'" />
        	';
                        $queryType = "SELECT * FROM  tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services_History on History_id = Services_History_PK where CAI_id =$ID";
                    $resultType = mysqli_query($conn, $queryType);
                    while($rowType = mysqli_fetch_array($resultType))
                         { 
                           echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK"  value="'.$rowType['Parent_MyPro_PK'].'" >';
                           echo '<input type="hidden" class="form-control" name="Services_History_PK"  value="'.$rowType['Services_History_PK'].'" >'; 
                           echo '<input type="hidden" class="form-control" name="CIA_Indent_Id"  value="'.$rowType['CIA_Indent_Id'].'" >';
                           
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
                </div>
                
        <div class="form-group">
            <div class="col-md-6">
                <label>Action Types</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Action_taken" required>
                    <option value="">---Select---</option>
                    ';
                        $query_item = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                    $result_item = mysqli_query($conn, $query_item);
                    while($row_item = mysqli_fetch_array($result_item))
                         { 
                           echo '<option value="'.$row_item['Action_Items_id'].'" >'.$row_item['Action_Items_name'].'</option>'; 
                       } 
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
            <div class="col-md-6">
            <label>Account</label>
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Accounts" required>
                    <option value="">---Select---</option>
                    ';
                        if($user_id == 34){
                        $query_account = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                        $result_account = mysqli_query($conn, $query_account);
                        while($row_account = mysqli_fetch_array($result_account))
                             { 
                               echo '<option value="'.$row_account['name'].'"'; echo $rowType['CAI_Accounts'] == $row_account['name'] ? 'selected' : ''; echo' >'.$row_account['name'].'</option>'; 
                           }
                        }else if($user_id == 247){ echo '<option value="SFI">SFI</option>';}
                        else if($user_id == 266){ echo '<option value="RFP">RFP</option>';}
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
                <textarea class="form-control" name="CAI_description" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Estimated Time (minutes)</label>
                <input class="form-control" type="number" name="CAI_Estimated_Time" value="0" required>
            </div>
            <div class="col-md-6">
                <label>Desired Due Date</label>
                <input class="form-control" type="date" name="CAI_Action_date" value="'.$today.'" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Status</label>
            </div>
            <div class="col-md-12">
                <select class="form-control" name="CIA_progress" >
                    <option value="0">Not Started</option>
                    <option value="1">Inprogress</option>
                    <option value="2">Completed</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Assign to</label>
            </div>
            <div class="col-md-12">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" required>
                    <option value="">---Select---</option>
                    ';
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                           echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].'</option>'; 
                       }
                       
                       $queryQuest = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                    $resultQuest = mysqli_query($conn, $queryQuest);
                    while($rowQuest = mysqli_fetch_array($resultQuest))
                         { 
                           echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].'</option>'; 
                       }
                     echo '
                     <option value="0">Others</option> 
                </select>
            </div>
        </div>';
     }
    }
        
if( isset($_POST['btnSave_AddChildItem_layer5']) ) {
	
    $user_id = $_COOKIE['ID'];
	$ID = $_POST['ID'];
	$CIA_Indent_Id = $_POST['ID'];
	$CIA_progress = $_POST['CIA_progress'];
	$filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
	$description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	$CAI_Estimated_Time = $_POST['CAI_Estimated_Time'];
	$Action_taken = $_POST['CAI_Action_taken'];
	$Action_date = $_POST['CAI_Action_date'];
	$CAI_Assign_to = $_POST['CAI_Assign_to'];
	$Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	$Services_History_PK = $_POST['Services_History_PK'];
	$CAI_Accounts = $_POST['CAI_Accounts'];
    $today = date('Y-m-d');
	$files = $_FILES['CAI_files']['name'];
	
	$path = '../MyPro_Folder_Files/';
	$tmp = $_FILES['CAI_files']['tmp_name'];
	$files = rand(1000,1000000) . ' - ' . $files;
	$to_Db_files = mysqli_real_escape_string($conn,$files);
	$path = $path.$files;
	move_uploaded_file($tmp,$path);

	$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_due_date,CAI_Assign_to,CAI_Status,CIA_progress,Parent_MyPro_PK,CAI_Rendered_Minutes,CAI_Action_date,CAI_Accounts)
	VALUES ('$user_id','$Services_History_PK','$CIA_Indent_Id', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$Parent_MyPro_PK',0,'$today','$CAI_Accounts')";
	
	if (mysqli_query($conn, $sql)) {
	    
	    $last_id = mysqli_insert_id($conn);
        $data1 = $_POST['ID'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $last_id";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '<tr id="subsub_six__five_'.$data2['CAI_id'].'">
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_2">From: ';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo $row['first_name'];
                        }
    				echo '
    				</td>
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				    ';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail6" data-toggle="modal" onclick="get_moreDetails6('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                            echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}

            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
                </tr>
    		';
         }
	    //emailer
	    $ID = $_POST['ID'];
	    //from
	    $cookie_frm = $_COOKIE['ID'];
	    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_frm" );
	    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; }
	    //to
	    $cookie_to = $CAI_Assign_to;
	    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
	    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
	     //Projects
	    $project_id = $Parent_MyPro_PK;
	    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
	    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
	    
	    $user = 'interlinkiq.com';
           $from = $frm;
           $to = $t;
           $subject = 'Assigned to You: '.$filename;
           $body = '
                    <br>
                    <b>Task</b>
                    <br>
                    '.$filename.'
                    <br>
                    <br>
                    <b>Description</b> <br>
                    '.$description.'
                    <br>
                    <br>
                    <b>Assigned to</b> <br>
                    '.$t_fname.'
                    <br>
                    <br>
                    <b>Desired Due date</b> <br>
                    '.$Action_date.'
                    <br>
                    <br>
                    <b>Projects</b><br>
                    '.$prj.'

                    <br><br><br>
                    <a href="https://interlinkiq.com/mypro_task.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
    	$mail = php_mailer($from, $to, $user, $subject, $body);
	
	}
	else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    $message;
	}
	mysqli_close($conn);
}
// add service log
if( isset($_GET['modal_add_logs']) ) {
	$ID = $_GET['modal_add_logs'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_2" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['btnSave_add_logs']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and Services_History_PK = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border">'.$data2['CAI_id'].'</td>';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
    				echo '
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

}

// add service log
if( isset($_GET['Add_logs']) ) {
	$ID = $_GET['Add_logs'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_s" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['Save_logs']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and Services_History_PK = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border">'.$data2['CAI_id'].'</td>';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = $owner";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
    				echo '
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = '$_comment'";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments" data-toggle="modal" onclick="btn_Comments('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child2" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child2('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child2" data-toggle="modal" class="btn red btn-xs" onclick="onclick_2('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

}

// add service log 3
if( isset($_GET['modal_add_logs3']) ) {
	$ID = $_GET['modal_add_logs3'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_3" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['btnSave_add_logs3']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border" width="50px">'.$data2['CAI_id'].'</td>
    			    <td class="child_border" width="80px"></td>
    			    <td class="child_2">From: ';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo $row['first_name'];
                        }
    				echo '
    				</td>
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    					';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments3" data-toggle="modal" onclick="btn_Comments3('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child3" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child3('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child3" data-toggle="modal" class="btn red btn-xs" onclick="onclick_3('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

}

// add service log 4
if( isset($_GET['modal_add_logs4']) ) {
	$ID = $_GET['modal_add_logs4'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_4" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['btnSave_add_logs4']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
    				echo '
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    					';
				    $stringProduct = strip_tags($data2['CAI_description']); 
                   if(strlen($stringProduct) > 22):
                       $stringCut = substr($stringProduct,0,22);
                       $endPoint = strrpos($stringCut,' ');
                       $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                       $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail2" data-toggle="modal" onclick="get_moreDetails2('.$data2['CAI_id'].')">
                       <i style="color:black;">See more...</i></a>';
                   endif;
                   echo $stringProduct;
                   echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments4" data-toggle="modal" onclick="btn_Comments4('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child4" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child4('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child4" data-toggle="modal" class="btn red btn-xs" onclick="onclick_4('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

}

// add service log 5
if( isset($_GET['modal_add_logs5']) ) {
	$ID = $_GET['modal_add_logs5'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_5" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['btnSave_add_logs5']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
    				echo '
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				    ';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail5" data-toggle="modal" onclick="get_moreDetails5('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                           echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments5" data-toggle="modal" onclick="btn_Comments5('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGetHistory_Child5" data-toggle="modal" class="btn blue btn-xs" onclick="btnNew_History_Child5('.$data2['CAI_id'].')">Add</a>';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child5" data-toggle="modal" class="btn red btn-xs" onclick="onclick_5('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

}

// add service log 5
if( isset($_GET['modal_add_logs6']) ) {
	$ID = $_GET['modal_add_logs6'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="logs_6" value="'. $ID .'" />';
        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
        $resultChildTask = mysqli_query($conn, $queryChildTask);
        while($rowChildTask = mysqli_fetch_array($resultChildTask))
         { 
            echo'
            
                <div class="form-group">
                    
                    <div class="col-md-12">
                        <label>Task Owner</label>
                    </div>
                    <div class="col-md-12"> 
                    ';
                        $i_user = $rowChildTask['CAI_Assign_to'];
                        
                        $queryOwner = "SELECT * FROM tbl_user where Employee_id = '$i_user'";
                        $resultO = mysqli_query($conn, $queryOwner);
                        while($row_o = mysqli_fetch_array($resultO))
                         { ?>
                            <?php echo $row_o['first_name']; ?> <?php echo $row_o['last_name']; ?>
                            <input class="form-control" type="hidden" name="owner" value="<?php echo $row_o['ID']; ?>">
                    
                       <?php  }
                        echo'
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Task Name</label>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'">
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="CAI_description">'.$rowChildTask['CAI_description'].'</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Rendered Time (minutes)</label>
                    </div>
                    <div class="col-md-12">
                        <input type="number" class="form-control" name="CAI_Rendered_Minutes" value="'.$rowChildTask['CAI_Rendered_Minutes'].'">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Action</label>
                        <select class="form-control" name="aAction">
                            ';
                                $i_action = $rowChildTask['CAI_Action_taken'];
                                
                                $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                                $result_a = mysqli_query($conn, $query_a);
                                while($row_a = mysqli_fetch_array($result_a))
                                 { ?>
                                    <option value ="<?php echo $row_a['Action_Items_name']; ?>" <?php if($row_a['Action_Items_id']==$i_action ){echo 'selected';}else{echo '';} ?>> <?php echo $row_a['Action_Items_name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <label>Account</label>
                        <select class="form-control" name="Account">
                            <option value ="CONSULTAREINC">CONSULTAREINC</option>
                            ';
                                
                                $query_aa = "SELECT * FROM tbl_Accouts order by Account_Name ASC";
                                $result_aa = mysqli_query($conn, $query_aa);
                                while($row_aa = mysqli_fetch_array($result_aa))
                                 { ?>
                                    <option value ="<?php echo $row_aa['Account_Name']; ?>" <?=  $row_aa['Account_Name'] == $rowChildTask['CAI_Accounts'] ? 'selected' : ''; ?> > <?php echo $row_aa['Account_Name']; ?></option>
                            
                               <?php  }
                                echo'
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Date Completed</label>
                    </div>
                    <div class="col-md-12">
                        <input type="date" class="form-control" name="Date_Completed" value="'.date('Y-m-d', strtotime($rowChildTask['Date_Completed'])).'">
                    </div>
                </div>
                 <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">
            ';
           
         }
         
    }
    
if( isset($_POST['btnSave_add_logs6']) ) {
    $user_i = $_COOKIE['ID'];
    $ID = $_POST['ID'];
    $owner = mysqli_real_escape_string($conn,$_POST['owner']);
    $aAction = mysqli_real_escape_string($conn,$_POST['aAction']);
    $Account = mysqli_real_escape_string($conn,$_POST['Account']);
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Rendered_Minutes = mysqli_real_escape_string($conn,$_POST['CAI_Rendered_Minutes']);
    $Date_Completed = $_POST['Date_Completed'];
    
    $sql2 = "INSERT INTO tbl_service_logs (user_id,description,comment,task_date,minute,action,account)
	VALUES ('$owner','$CAI_filename','$CAI_description','$Date_Completed','$CAI_Rendered_Minutes','$aAction','$Account')";
	
	mysqli_query($conn, $sql2);
	 $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET aAccount = '$Account',Service_log_Status = 1 where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)){
     	    $ID = $_POST['ID'];
        $data1 = $_POST['CIA_Indent_Id'];
	    $view_id = $_POST['Parent_MyPro_PK'];
	    $query2 = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
	    left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken
        left join tbl_hr_employee on CAI_Assign_to = ID left join tbl_user on employee_id = tbl_hr_employee.ID
		where Parent_MyPro_PK = $view_id and CIA_Indent_Id = $data1 and CAI_id = $ID";
        $result2 = mysqli_query($conn, $query2);
        while($data2 = mysqli_fetch_array($result2))
         {
            $filesL9 = $data2["CAI_files"];
            $fileExtension = fileExtension($filesL9);
    		$src = $fileExtension['src'];
    		$embed = $fileExtension['embed'];
    		$type = $fileExtension['type'];
    		$file_extension = $fileExtension['file_extension'];
            $url = $base_url.'../MyPro_Folder_Files/';
    		echo '
    			    <td class="child_border">'.$data2['CAI_id'].'</td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>
    			    <td class="child_border"></td>';
    				    $owner  = $data2['CAI_User_PK'];
                        $query = "SELECT * FROM tbl_user where ID = '$owner'";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_array($result)){ 
                            echo '<td class="child_2">From: '.$row['first_name'].'</td>';
                        }
    				echo '
    				<td class="child_2" style="width:;">'.$data2['CAI_filename'].'</td>
    				<td class="child_2" style="width:;">
    				    ';
        				$stringProduct = strip_tags($data2['CAI_description']); 
                           if(strlen($stringProduct) > 22):
                               $stringCut = substr($stringProduct,0,22);
                               $endPoint = strrpos($stringCut,' ');
                               $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                               $stringProduct .='&nbsp;<a style="font-size:12px;" href="#modalGet_more_detail6" data-toggle="modal" onclick="get_moreDetails6('.$data2['CAI_id'].')">
                               <i style="color:black;">See more...</i></a>';
                           endif;
                           echo $stringProduct;
                            echo '
    				</td>
    				<td class="child_2">
    					';
                            
                                if (!empty($filesL9))
                			     {
                			         echo '
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:blue;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">1</b></span>
                            	        </a>
                            	    ';
                			     }
                			     else
                			     {
                			         echo'
                			            <a style="color:#fff;" data-src="'.$src.$url.rawurlencode($filesL9).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">
                                    	   <i class="icon-doc" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                            <span class="badge" style="background-color:red;margin-left:-7px;margin-top:-25;position:;z-index:;"><b style="font-size:14px;">0</b></span>
                            	        </a>
                			         ';
                			     }
                			  echo '   
                            
    				</td>
    				<td class="child_2">'.$data2['CAI_Accounts'].'</td>
    				<td class="child_2">'.$data2['Action_Items_name'].'</td>
    				<td class="child_2">Assign to: '.$data2['first_name'].'</td>';
    				if($data2['CIA_progress']== 1){ echo '<td class="child_2"><b>Inprogress</b></td>'; }
    	            else if($data2['CIA_progress']== 2){ echo '<td class="child_2"><b>Completed</b></td>';}
    	            else{ echo '<td class="child_2"><b>Not Started</b></td>';}
    	            //rendered time
    	           
            	        echo '<td class="child_2">Rendered: '.$data2['CAI_Rendered_Minutes'].' minute(s)';
            	        echo '<a style="font-weight:800;color:#fff;" class="btn green btn-xs">Logs Added</a></td>';
                
            	    if($data2['CIA_progress']==2){
            	        echo '<td class="child_2">100%</td>';
            	    }
    				echo '
    				<td class="child_2">Start: '.date("Y-m-d", strtotime($data2['CAI_Action_date'])).'</td>
    				<td class="child_2">Due: '.date("Y-m-d", strtotime($data2['CAI_Action_due_date'])).'</td>
    				<td class="child_2">
    				';
                        $_comment  = $data2['CAI_id'];
                        $query_comment = "SELECT COUNT(*) as count FROM tbl_MyProject_Services_Comment where Task_ids = $_comment";
                        $result_comment = mysqli_query($conn, $query_comment);
                        while($row_comment = mysqli_fetch_array($result_comment)){ 
                            echo '
                            <a href="#modalGet_Comments6" data-toggle="modal" onclick="btn_Comments6('.$data2['CAI_id'].')">
                            <i class="icon-speech" style="font-size:18px;color:#fff;margin-left:12px;"></i>
                                <span class="badge" style="background-color:'; if($row_comment['count'] == 0){echo '#DC3535';}else{echo 'blue';}  echo';margin-left:-7px;margin-top:-10px;position:absolute;z-index:1;">
                                    <b>'.$row_comment['count'].'</b>
                                </span>
                            </a>
                            ';
                        }
                      echo '  
                    </td>
                    <td class="child_2">';
                        echo '<a style="font-weight:800;color:#fff;" href="#modalGet_child6" data-toggle="modal" class="btn red btn-xs" onclick="onclick_6('.$data2['CAI_id'].')">Edit</a>';
                        echo '
                    </td>
    		';
         }
 	    
 	    
 	}else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	    echo $message;
	}
	mysqli_close($conn);
	 

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
    
// PHP MAILER FUNCTION
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function php_mailer($from, $to, $user, $subject, $body) {
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';
	

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
	    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
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
	
function php_mailer2($from, $to, $cc_mail, $user, $subject, $body) {
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';
	

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
	    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
	    $mail->addAddress($to, $user);
	    $mail->addReplyTo($from, $user);
	    $mail->addCC($cc_mail, $user);

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
// $conn->close();

?>