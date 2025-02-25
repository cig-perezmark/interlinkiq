<?php
include '../database.php';
$base_url = "https://interlinkiq.com/";
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
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
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Sample_Documents,Collaborator_PK,user_cookies,Project_status) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$Sample_Documents','$cCollaborator','$userID',0)";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../MyPro";</script>';
        }
    }else{
        $userID = $_COOKIE['ID'];
        $cCollaborator = '';
        $Project_Name = mysqli_real_escape_string($conn,$_POST['Project_Name']);
        $Project_Description = mysqli_real_escape_string($conn,$_POST['Project_Description']);
        $Start_Date = mysqli_real_escape_string($conn,$_POST['Start_Date']);
        $Desired_Deliver_Date = mysqli_real_escape_string($conn,$_POST['Desired_Deliver_Date']);
        if(!empty($_POST["Collaborator"]))
            {
                foreach($_POST["Collaborator"] as $Collaborator)
                {
                    $cCollaborator .= $Collaborator.', ';
                }
                 
            }
            $cCollaborator = substr($cCollaborator, 0, -2);
        $sql = "INSERT INTO tbl_MyProject_Services (Project_Name,Project_Description,Start_Date,Desired_Deliver_Date,Collaborator_PK,user_cookies,Project_status) VALUES ('$Project_Name','$Project_Description','$Start_Date','$Desired_Deliver_Date','$cCollaborator','$userID',0)";
        if(mysqli_query($conn, $sql)){
            echo '<script> window.location.href = "../MyPro";</script>';
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
            echo '<script> window.location.href = "../MyPro";</script>';
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
              echo '<script> window.location.href = "../MyPro";</script>';
        }
        else{
		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
    }
}

// Assign Projects
if (isset($_POST['btnAssign_Project'])) { 
        $userID = $_COOKIE['ID'];
        $User_Assign_PK = mysqli_real_escape_string($conn,$_POST['User_Assign_PK']);
        $MyPro_PK = mysqli_real_escape_string($conn,$_POST['ID']);
        
        $sqlAssign = "INSERT INTO tbl_MyProject_Services_Assigned (User_Assign_PK,MyPro_PK,user_cookies,Assigned_Status) VALUES ('$User_Assign_PK','$MyPro_PK','$userID',1)";
        if(mysqli_query($conn, $sqlAssign)){
            echo '<script> window.location.href = "../MyPro_Customer_Services#tab_Internal";</script>';
        }
}

// File Section
	if( isset($_GET['modalNew_File']) ) {
		$ID = $_GET['modalNew_File'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
		
            <div class="form-group">
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
                <div class="col-md-12">
                    <label>Action Items</label>
                </div>
                <div class="col-md-12">
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="Action_taken" required>
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
                    <textarea class="form-control" name="description" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Estimated Time (minutes)</label>
                    <input class="form-control" type="number" name="Estimated_Time"  required />
                </div>
                <div class="col-md-6">
                    <label>Desired Due Date</label>
                    <input class="form-control" type="date" name="Action_date" value="'.$today.'" required />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Assign to</label>
                </div>
                <div class="col-md-12">
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="Assign_to_history" required>
                        <option value="">---Select---</option>
                        ';
                            $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                             { 
                               echo '<option value="'.$rowAssignto['ID'].'" >'.$rowAssignto['first_name'].'</option>'; 
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
        

	
	if( isset($_POST['btnSave_History']) ) {
		
        $user_id = $_COOKIE['ID'];
		$ID = $_POST['ID'];
		$filename = mysqli_real_escape_string($conn,$_POST['filename']);
		$description = mysqli_real_escape_string($conn,$_POST['description']);
		$Estimated_Time = $_POST['Estimated_Time'];
		$Assign_to_history = $_POST['Assign_to_history'];
		$Action_taken = $_POST['Action_taken'];
		$Action_date = $_POST['Action_date'];
		$rand_id = rand(10,1000000);

		$files = $_FILES['file']['name'];
		if (!empty($files)) {
			$path = '../MyPro_Folder_Files/';
			$tmp = $_FILES['file']['tmp_name'];
			$files = rand(1000,1000000) . ' - ' . $files;
			$to_Db_files = mysqli_real_escape_string($conn,$files);
			$path = $path.$files;
			move_uploaded_file($tmp,$path);
		}

		$sql = "INSERT INTO tbl_MyProject_Services_History (user_id,MyPro_PK,files, filename, description,Estimated_Time,Action_taken,Action_date,Assign_to_history,Services_History_Status,rand_id)
		VALUES ('$user_id','$ID', '$to_Db_files', '$filename', '$description','$Estimated_Time','$Action_taken','$Action_date','$Assign_to_history',1,'$rand_id')";
		
		if (mysqli_query($conn, $sql)) {
			$last_id = mysqli_insert_id($conn);

			$selectData = mysqli_query( $conn,'SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services_Action_Items on Action_Items_id = Action_taken
				                left join tbl_hr_employee on Assign_to_history = ID WHERE  History_id="'. $last_id .'" ORDER BY History_id LIMIT 1' );
			if ( mysqli_num_rows($selectData) > 0 ) {
				$rowData = mysqli_fetch_array($selectData);
				$data_ID = $rowData['History_id'];
				$data_filename = $rowData['filename'];
				$data_description = $rowData['description'];
				$Action_Items_name = $rowData['Action_Items_name'];
				$first_name = $rowData['first_name'];
				$Estimated_Time = $rowData['Estimated_Time'];

				$data_files = $rowData['files'];
				if (!empty($data_files)) {
		            $fileExtension = fileExtension($data_files);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
		            $url = $base_url.'MyPro_Folder_Files/';
		            $files = '<p style="margin: 0;"><a data-src="'.$src.$url.rawurlencode($data_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">'.$data_files.'</a></p>';
				}

				$Action_date = $rowData['Action_date'];
                $Action_date = new DateTime($Action_date);
                $Action_date = $Action_date->format('M d, Y');

				$output = array(
					"History_id" => $data_ID,
					"first_name" => $first_name,
					"filename" => $data_filename,
					"description" => $data_description,
					"Action_Items_name" => $Action_Items_name,
					"Estimated_Time" => $Estimated_Time,
					"files" => $files
				);
			}
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

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />
	        	';
                            $queryType = "SELECT * FROM tbl_MyProject_Services_History left join tbl_MyProject_Services on MyPro_id = MyPro_PK where History_id =$ID";
                        $resultType = mysqli_query($conn, $queryType);
                        while($rowType = mysqli_fetch_array($resultType))
                             { 
                               echo '<input type="hidden" class="form-control" name="Parent_MyPro_PK" value="'.$rowType['MyPro_id'].'" >'; 
                               echo '<input type="hidden" class="form-control" name="rand_id_pk" value="'.$rowType['rand_id'].'" >';
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
                    <input class="form-control" type="number" name="CAI_Estimated_Time"  required />
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
                            $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
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
		$rand_id_pk = rand(1000,1000000);

		$files = $_FILES['CAI_files']['name'];
		if (!empty($files)) {
			$path = '../MyPro_Folder_Files/';
			$tmp = $_FILES['CAI_files']['tmp_name'];
			$files = rand(1000,1000000) . ' - ' . $files;
			$to_Db_files = mysqli_real_escape_string($conn,$files);
			$path = $path.$files;
			move_uploaded_file($tmp,$path);
		}

		$sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Services_History_PK,Parent_MyPro_PK,CAI_files, CAI_filename, CAI_description,CAI_Estimated_Time,CAI_Action_taken,CAI_Action_date,CAI_Assign_to,CAI_Status,CIA_progress,CIA_Indent_Id,CAI_Rendered_Minutes,rand_id_pk)
		VALUES ('$user_id','$ID','$Parent_MyPro_PK', '$to_Db_files', '$filename', '$description','$CAI_Estimated_Time','$Action_taken','$Action_date','$CAI_Assign_to',1,'$CIA_progress','$ID','0','$rand_id_pk')";
		
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
                        <a href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
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
                    <input class="form-control" type="number" name="CAI_Estimated_Time"  required />
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
                            $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
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
                        <a href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
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
	
	
	// modal update Action Item
	if( isset($_GET['modal_update_Action_item']) ) {
		$ID = $_GET['modal_update_Action_item'];
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
                            <label>Document</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="file" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Status</label>
                        </div>
                        <div class="col-md-12">
                            <select class="form-control" name="CIA_progress" >
                                <option value="0" '; echo $rowChildTask['CIA_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                                <option value="1" '; echo $rowChildTask['CIA_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                                <option value="2" '; echo $rowChildTask['CIA_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                            </select>
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
                ';
                echo '
                <div class="form-group">
                    <div class="col-md-12">
                            <label>Assign to</label>
                    </div>
                    <div class="col-md-12">
                        <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to" readonly>
                            <option value="">---Select---</option>
                            ';
                                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                 { ?>
                                   <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                               <?php } 
                               
                                $query = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
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
        
	if( isset($_POST['btnSave_update_Action_item']) ) {
        //$user_id = $_COOKIE['ID'];
		 if($_POST['CIA_progress'] == 2){
		     $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
            $today = $date_default_tx->format('Y-m-d');
            
		     $ID = $_POST['ID'];
    		$CIA_progress = $_POST['CIA_progress'];
    		$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    		$CAI_Completed = addslashes($_POST['CAI_Completed']);
    	    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    		
    		if(!empty($_POST['CAI_Rendered_Minutes'])){
    		    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    		}
    		else{
    		    $CAI_Rendered_Minutes = 0;
    		}
    		//$Action_date = $_POST['CAI_Action_date'];
    		$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    		$files = $_FILES['CAI_files']['name'];
    		if (!empty($files)) {
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['CAI_files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',Date_Completed = '$today' where CAI_id = $ID";
         		if (mysqli_query($conn, $sql)) {
        		
         		}
    		}else{
    		    echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',Date_Completed = '$today'  where CAI_id = $ID";
         		if (mysqli_query($conn, $sql)) {
        		
         		}
    		}
    
    		
		 }
		 else{
		     $ID = $_POST['ID'];
    		$CIA_progress = $_POST['CIA_progress'];
    		$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    		$CAI_Completed = mysqli_real_escape_string($conn,$_POST['CAI_Completed']);
    	    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
        	if(!empty($_POST['CAI_Rendered_Minutes'])){
    		    $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    		}
    		else{
    		    $CAI_Rendered_Minutes = 0;
    		}
    		//$Action_date = $_POST['CAI_Action_date'];
    		$CAI_Assign_to = $_POST['CAI_Assign_to'];
    
        	$files = $_FILES['CAI_files']['name'];
        		if (!empty($files)) {
        			$path = '../MyPro_Folder_Files/';
        			$tmp = $_FILES['CAI_files']['tmp_name'];
        			$files = rand(1000,1000000) . ' - ' . $files;
        			$to_Db_files = mysqli_real_escape_string($conn,$files);
        			$path = $path.$files;
        			move_uploaded_file($tmp,$path);
        			echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$to_Db_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
             		if (mysqli_query($conn, $sql)) {
            		
             		}
        		}else{
        		    echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '1',CAI_Rendered_Minutes='$CAI_Rendered_Minutes' where CAI_id = $ID";
             		if (mysqli_query($conn, $sql)) {
            		
             		}
        		}
		 }
	}
	
	
	// modal Status Flag
	if( isset($_GET['modal_Status_flag']) ) {
		$ID = $_GET['modal_Status_flag'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	        $queryChildTask = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items where CAI_id = $ID";
            $resultChildTask = mysqli_query($conn, $queryChildTask);
            while($rowChildTask = mysqli_fetch_array($resultChildTask))
             { 
                echo'
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tabAccepted" data-toggle="tab" onclick="accept_status()">Accept</a>
                    </li>
                    <li>
                        <a href="#tabDeclined" data-toggle="tab" onclick="decline_status()">Decline</a>
                    </li>
                </ul>
                <div class="tab-content margin-top-20">
                <input class="form-control" type="hidden" name="get_status" id="get_status" value="1">
                <input class="form-control" type="hidden" name="CAI_User_PK" value="'.$rowChildTask['CAI_User_PK'].'">
                <input class="form-control" type="hidden" name=""  value="'.$_COOKIE['ID'].'">
                <input class="form-control" type="hidden" name="CAI_Assign_to" id="CAI_Assign_to" value="'.$rowChildTask['CAI_Assign_to'].'">
                <input class="form-control" type="hidden" name="Parent_MyPro_PK" value="'.$rowChildTask['Parent_MyPro_PK'].'">
                <input class="form-control" type="hidden" name="CIA_Indent_Id" value="'.$rowChildTask['CIA_Indent_Id'].'">	
                <input class="form-control" type="hidden" name="CAI_files" value="'.$rowChildTask['CAI_files'].'">
                <input class="form-control" type="hidden" name="Services_History_PK" value="'.$rowChildTask['Services_History_PK'].'">
                ';
                echo '
                    <div class="tab-pane active" id="tabAccepted">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Task Name</label>
                            </div>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Description</label>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="CAI_description" readonly>'.$rowChildTask['CAI_description'].'</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input class="form-control" type="date" name="Start_Date">
                            </div>
                            <div class="col-md-6">
                                <label>Due Date</label>
                                <input class="form-control" type="date" name="Due_Date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Estimated time (minutes)</label>
                            </div>
                            <div class="col-md-12">
                                <input class="form-control" type="number" name="estimated_id" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="tabDeclined">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Task Name</label>
                            </div>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="CAI_filename" value="'.$rowChildTask['CAI_filename'].'" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Description</label>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="CAI_description" readonly>'.$rowChildTask['CAI_description'].'</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Reason</label>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="CAI_Reason"> </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                    <label>Re-assign to</label>
                            </div>
                            <div class="col-md-12">
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="RE_Assign_to" readonly>
                                    <option value="">---Select---</option>
                                    ';
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                         { ?>
                                           <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowChildTask['CAI_Assign_to'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                                       <?php } 
                                       
                                        $query = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
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
                    </div>
                ';
                echo'
                </div>
                ';
             }
             
        }
        
	if( isset($_POST['btnSave_Status_flag']) ) {
        //$user_id = $_COOKIE['ID'];
		 if($_POST['get_status'] == 1){
		    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
            $today = $date_default_tx->format('Y-m-d');
            
		    $ID = $_POST['ID'];
    		$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    		$get_status = addslashes($_POST['get_status']);
    	    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    	    $CAI_User_PK = $_POST['CAI_User_PK'];
    	    $Start_Date = $_POST['Start_Date'];
    	    $Due_Date = $_POST['Due_Date'];
    	    $estimated_id = $_POST['estimated_id'];
    	    $CAI_Assign_to = $_POST['CAI_Assign_to'];
    	    $Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
    	    
    	    echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET Acceptance_Status = '$get_status',CAI_Action_date = '$Start_Date',CAI_Action_due_date = '$Due_Date',CAI_Estimated_Time = '$estimated_id' where CAI_id = $ID";
     		if (mysqli_query($conn, $sql)) {
     		    
    		    $cookie_frm = $CAI_Assign_to;
    		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_frm" );
    		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email'];  $frm_name = $rowFrom['first_name'];}
    		    //to
    		    $cookie_to = $CAI_User_PK;
    		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_to" );
    		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
    		     //Projects
    		    $project_id = $Parent_MyPro_PK;
    		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
    		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
    		    
    		    $user = 'interlinkiq.com';
                   $from = $frm;
                   $to = $t;
                   $subject = 'Task Accepted: '.$CAI_filename;
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
                            <b>Accepted by</b> <br>
                            '.$frm_name.'
                            <br>
                            <br>
                            <b>Start date</b> <br>
                            '.$Start_Date.'
                            <br>
                            <br>
                            <b>Desired Due date</b> <br>
                            '.$Due_Date.'
                            <br>
                            <br>
                            <b>Projects</b><br>
                            '.$prj.'
        
                            <br><br><br>
                            <a href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                            <br><br><br>
                            ';
            	    $mail = php_mailer($from, $to, $user, $subject, $body);
     		}
    	
    }
	 else{
	     $ids_user = $_COOKIE['ID'];
	     $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d');
        
	    $ID = $_POST['ID'];
		$CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
		$get_status = addslashes($_POST['get_status']);
	    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
	    
	    $CAI_User_PK = $_POST['CAI_User_PK'];
	    $Start_Date = $_POST['Start_Date'];
	    $Due_Date = $_POST['Due_Date'];
	    $estimated_id = $_POST['estimated_id'];
	    $CAI_Assign_to = $_POST['CAI_Assign_to'];
	    $Parent_MyPro_PK = $_POST['Parent_MyPro_PK'];
	    $RE_Assign_to = $_POST['RE_Assign_to'];
	    $CAI_Reason = $_POST['CAI_Reason'];
	    $CIA_Indent_Id = $_POST['CIA_Indent_Id'];
	    $Services_History_PK = $_POST['Services_History_PK'];
	    
	    if(!empty($_POST['CAI_files'])){$CAI_files = $_POST['CAI_files'];}else{$CAI_files = ' ';}
	    
	    
	    $select_assign = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $RE_Assign_to" );
		while($row_re = mysqli_fetch_array($select_assign)) {$reassign_to = $row_re['first_name']; }
	    $status_desc = $CAI_description.' - Re-assign to: '.$reassign_to;
	    
	    echo $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET Acceptance_Status = '$get_status',CAI_description = '$status_desc',CAI_Reason = '$CAI_Reason' where CAI_id = $ID";
 		if (mysqli_query($conn, $sql)) {
 		    $sql2 = "INSERT INTO tbl_MyProject_Services_Childs_action_Items (CAI_User_PK,Parent_MyPro_PK,CIA_Indent_Id,CAI_files, CAI_filename, CAI_description,CAI_Assign_to,CAI_Status,CAI_Rendered_Minutes,Services_History_PK)
    		VALUES ('$ids_user','$Parent_MyPro_PK','$CIA_Indent_Id', '$CAI_files', '$CAI_filename', '$CAI_description','$RE_Assign_to',1,0,'$Services_History_PK')";
    		if (mysqli_query($conn, $sql2)) {
    		    $cookie_frm = $CAI_Assign_to;
    		    $selectFrom = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_frm" );
    		    while($rowFrom = mysqli_fetch_array($selectFrom)) {$frm = $rowFrom['email']; $frm_name = $rowFrom['first_name']; }
    		    //to
    		    $cookie_to = $RE_Assign_to;
    		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cookie_to" );
    		    while($row_to = mysqli_fetch_array($select_to)) {$t = $row_to['email']; $t_fname = $row_to['first_name']; }
    		    
    		    //cc
    		    $cookie_cc = $CAI_User_PK;
    		    $select_to = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $cookie_cc" );
    		    while($row_to = mysqli_fetch_array($select_to)) {$cc_e = $row_to['email']; $c_fname = $row_to['first_name']; }
    		    
    		     //Projects
    		    $project_id = $Parent_MyPro_PK;
    		    $project_n = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $project_id" );
    		    while($row_prj = mysqli_fetch_array($project_n)) {$prj = $row_prj['Project_Name']; }
    		    
    		    $user = 'interlinkiq.com';
                   $from = $frm;
                   $to = $t;
                   $cc_mail = $cc_e;
                   $subject = 'Task Declined: '.$CAI_filename;
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
                            <b>Reason</b> <br>
                            '.$CAI_Reason.'
                            <br>
                            <br>
                            <b>Declined by</b> <br>
                            '.$frm_name.'
                            <br>
                            <br>
                            <b>Re-assign to</b> <br>
                            '.$t_fname.'
                            <br>
                            <br>
                            <b>Projects</b><br>
                            '.$prj.'
        
                            <br><br><br>
                            <a href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                            <br><br><br>
                            ';
            	    $mail = php_mailer2($from, $to,$cc_mail, $user, $subject, $body);
     		}
 		}
	    
	 }
	}
	
	// Comments Status Flag
	if( isset($_GET['modal_Comments']) ) {
		$ID = $_GET['modal_Comments'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
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
        
        $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
        $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
        $today = $date_default_tx->format('Y-m-d h:i:s');
        
        $sql2 = "INSERT INTO tbl_MyProject_Services_Comment (user_id,Comment_Task,Comment_Date,Task_ids)
		VALUES ('$user_i','$comment_task','$today','$ID')";
		if(mysqli_query($conn, $sql2)){
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
                            <a href="https://interlinkiq.com/MyPro_Action_Items.php?view_id='.$project_id.'#'.$ID.'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                            <br><br><br>
                            ';
            	    $mail = php_mailer($from, $to, $user, $subject, $body);
		
		}
		mysqli_close($conn);
		echo json_encode($output);
	}
	
	// add service log
	if( isset($_GET['modal_add_logs']) ) {
		$ID = $_GET['modal_add_logs'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
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
                                    
                                    $query_a = "SELECT * FROM tbl_MyProject_Services_Action_Items";
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
                                    
                                    $query_aa = "SELECT * FROM tbl_Accouts";
                                    $result_aa = mysqli_query($conn, $query_aa);
                                    while($row_aa = mysqli_fetch_array($result_aa))
                                     { ?>
                                        <option value ="<?php echo $row_aa['Account_Name']; ?>"> <?php echo $row_aa['Account_Name']; ?></option>
                                
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
     	if (mysqli_query($conn, $sql)){ }else{
		    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
		    echo $message;
		}
		mysqli_close($conn);
		echo json_encode($output);
		 

	}
	
	// modal update Action Item history
	if( isset($_GET['modal_update_Action_item_history']) ) {
		$ID = $_GET['modal_update_Action_item_history'];
		$today = date('Y-m-d');

		echo '<input class="form-control" type="hidden" name="ID" value="'. $ID .'" />';
	        $query = "SELECT * FROM tbl_MyProject_Services_History where History_id = $ID";
            $result = mysqli_query($conn, $query);
            while($rowHistory = mysqli_fetch_array($result))
             { 
                echo'
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Task Name</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="filename" value="'.$rowHistory['filename'].'">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Document</label>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="file" name="files" value="'.$rowHistory['files'].'">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Status</label>
                        </div>
                        <div class="col-md-12">
                            <select class="form-control" name="H_progress" >
                                <option value="0" '; echo $rowHistory['H_progress'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                                <option value="1" '; echo $rowHistory['H_progress'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                                <option value="2" '; echo $rowHistory['H_progress'] == 2 ? 'selected' : ''; echo'>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Description</label>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control" name="description">'.$rowHistory['description'].'</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Rendered Time (minutes)</label>
                        </div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="Rendered_Minutes" value="'.$rowHistory['Rendered_Minutes'].'">
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
                            <option value="">---Select---</option>
                            ';
                                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = 34 and status =1 order by first_name ASC";
                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                 { ?>
                                   <option value="<?php echo $rowAssignto['ID']; ?>" <?php if($rowAssignto['ID'] == $rowHistory['Assign_to_history'] ){echo 'selected';}else{echo '';} ?>><?php echo $rowAssignto['first_name']; ?></option>
                               <?php } 
                               
                                $query = "SELECT * FROM tbl_user where ID = 155 and ID = 308 and ID = 189";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result))
                                 { ?>
                                   <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $rowHistory['Assign_to_history'] ){echo 'selected';}else{echo '';} ?>><?php echo $row['first_name']; ?></option>
                               <?php } 
                             echo '
                             <option value="0">Others</option> 
                        </select>
                    </div>
                </div>
                ';
             }
             
        }
        
	if( isset($_POST['btnSave_update_Action_item_history']) ) {
        //$user_id = $_COOKIE['ID'];
		 if($_POST['H_progress'] == 2){
		     $ID = $_POST['ID'];
    		$H_progress = $_POST['H_progress'];
    		$filename = mysqli_real_escape_string($conn,$_POST['filename']);
    		$Services_History_Completed = addslashes($_POST['Services_History_Completed']);
    	    $description = mysqli_real_escape_string($conn,$_POST['description']);
    		if(!empty($_POST['Rendered_Minutes'])){
    		    $Rendered_Minutes = $_POST['Rendered_Minutes'];
    		}
    		else{
    		    $Rendered_Minutes = 0;
    		}
    		//$Action_date = $_POST['CAI_Action_date'];
    		$Assign_to_history = $_POST['Assign_to_history'];
    
    		$files = $_FILES['files']['name'];
    		if (!empty($files)) {
    			$path = '../MyPro_Folder_Files/';
    			$tmp = $_FILES['files']['tmp_name'];
    			$files = rand(1000,1000000) . ' - ' . $files;
    			$to_Db_files = mysqli_real_escape_string($conn,$files);
    			$path = $path.$files;
    			move_uploaded_file($tmp,$path);
    			echo $sql = "UPDATE tbl_MyProject_Services_History  SET Assign_to_history = '$Assign_to_history',filename = '$filename',files ='$to_Db_files',H_progress = '$H_progress',description ='$description',Services_History_Completed = '1',Rendered_Minutes='$Rendered_Minutes' where History_id = $ID";
         		if (mysqli_query($conn, $sql)) {
        		
         		}
    		}else{
    		    echo $sql = "UPDATE tbl_MyProject_Services_History  SET Assign_to_history = '$Assign_to_history',filename = '$filename',H_progress = '$H_progress',description ='$description',Services_History_Completed = '1',Rendered_Minutes='$Rendered_Minutes' where History_id = $ID";
         		if (mysqli_query($conn, $sql)) {
        		
         		}
    		}
		 }
		 else{
		     $ID = $_POST['ID'];
    		$H_progress = $_POST['H_progress'];
    		$filename = addslashes($_POST['filename']);
    		$Services_History_Completed = addslashes($_POST['Services_History_Completed']);
    	    $description = mysqli_real_escape_string($conn,$_POST['description']);
        	if(!empty($_POST['Rendered_Minutes'])){
    		    $Rendered_Minutes = $_POST['Rendered_Minutes'];
    		}
    		else{
    		    $Rendered_Minutes = 0;
    		}
    		//$Action_date = $_POST['CAI_Action_date'];
    		$Assign_to_history = $_POST['Assign_to_history'];
    
			$files = $_FILES['files']['name'];
		if (!empty($files)) {
			$path = '../MyPro_Folder_Files/';
			$tmp = $_FILES['files']['tmp_name'];
			$files = rand(1000,1000000) . ' - ' . $files;
			$to_Db_files = mysqli_real_escape_string($conn,$files);
			$path = $path.$files;
			move_uploaded_file($tmp,$path);
			echo $sql = "UPDATE tbl_MyProject_Services_History  SET Assign_to_history = '$Assign_to_history',filename = '$filename',files ='$to_Db_files',H_progress = '$H_progress',description ='$description',Services_History_Completed = '1',Rendered_Minutes='$Rendered_Minutes' where History_id = $ID";
     		if (mysqli_query($conn, $sql)) {
    		
     		}
		}else{
		    echo $sql = "UPDATE tbl_MyProject_Services_History  SET Assign_to_history = '$Assign_to_history',filename = '$filename',H_progress = '$H_progress',description ='$description',Services_History_Completed = '1',Rendered_Minutes='$Rendered_Minutes' where History_id = $ID";
     		if (mysqli_query($conn, $sql)) {
    		
     		}
		}
		 }


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
	require '../PHPMailer/src/Exception.php';    
    require '../PHPMailer/src/PHPMailer.php';    
    require '../PHPMailer/src/SMTP.php';  
    
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
		    $mail->setFrom($from, $user);
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
		    $mail->setFrom($from, $user);
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
$conn->close();
?>
