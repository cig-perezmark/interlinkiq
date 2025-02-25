<?php
include '../database.php';
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

//submit calendar
if( isset($_POST['btnSubmit_calendar']) ) {
//$user_id = $_COOKIE['ID'];
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today = $date_default_tx->format('Y-m-d');
    
    $ID = $_POST['IDs'];
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Accounts = mysqli_real_escape_string($conn,$_POST['CAI_Accounts']);
    $Action_taken = mysqli_real_escape_string($conn,$_POST['Action_taken']);
    $cai_priority_status = mysqli_real_escape_string($conn,$_POST['cai_priority_status']);
    $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
    $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    
    $CIA_progress = $_POST['CIA_progress'];
    $CAI_Completed =0;
    if($CIA_progress == 2){
        $CAI_Completed =2;
    }
    
    if(!empty($_POST['CAI_Rendered_Minutes']))
    {
        $CAI_Rendered_Minutes = $_POST['CAI_Rendered_Minutes'];
    }
    else
    {
        $CAI_Rendered_Minutes = 0;
    }
    $CAI_Assign_to = $_POST['CAI_Assign_to'];
    
    $file = $_FILES['CAI_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['CAI_files']['name']));
        $rand = rand(10,1000000);
        $CAI_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['CAI_files']['tmp_name'],'../MyPro_Folder_Files/'.$to_File_Documents);
    }
    else{
        $CAI_files  = mysqli_real_escape_string($conn,$_POST['CAI_files2']);
    }
    
    $sql = "UPDATE tbl_MyProject_Services_Childs_action_Items  SET CAI_Assign_to = '$CAI_Assign_to',CAI_filename = '$CAI_filename',CAI_files ='$CAI_files',CIA_progress = '$CIA_progress',CAI_description ='$CAI_description',CAI_Completed = '$CAI_Completed',CAI_Rendered_Minutes='$CAI_Rendered_Minutes',CAI_Accounts = '$CAI_Accounts',CAI_Action_taken='$Action_taken',cai_priority_status='$cai_priority_status',CAI_Action_date = '$CAI_Action_date',CAI_Action_due_date = '$CAI_Action_due_date',Date_Completed = '$today' where CAI_id = $ID";
 	if (mysqli_query($conn, $sql)) 
 	{
 	    $ID = $_POST['IDs'];
 		$sql = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services on MyPro_id = Parent_MyPro_PK
        left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken WHERE CAI_id = '$ID'"; 
    	$result = mysqli_query ($conn, $sql);
    
        foreach($result as $row){
            $date_start = new DateTime($row['CAI_Action_date']);
            $date_end = new DateTime($row['CAI_Action_due_date']);
        ?>
             <?php if($row['data_type'] != 1): ?>
            <div class="todo-tasklist-item todo-tasklist-item-border-blue">
                <div class="todo-tasklist-item-title">Ticket #: <?= $row['MyPro_id']; ?></div>
                <div class="todo-tasklist-item-text"><b>Project:</b> <i><?= $row['Project_Name']; ?></i></div>
                <div class="todo-tasklist-item-text"><b>Description:</b> <i><?= $row['Project_Description']; ?></i> </div>
                <div class="todo-tasklist-controls pull-left">
                    <span class="todo-tasklist-date"><i class="fa fa-calendar"></i>Start: <i><?= $date_start->format('M. d, Y').'  '; ?></i> Due: <i><?= $date_end->format('M. d, Y'); ?></i></span>
                    <span class="todo-tasklist-badge badge badge-roundless  <?php if($row['cai_priority_status'] == 1){ echo 'bg-red';}else if($row['cai_priority_status'] == 2){ echo 'bg-yellow';}else if($row['cai_priority_status'] == 3){ echo 'bg-blue';}else{echo ''; } ?>">
                        <?php 
                            if($row['cai_priority_status'] == 1){ echo 'Important and Urgent';}
                            else if($row['cai_priority_status'] == 2){ echo 'Not Important but Urgent';}
                            else if($row['cai_priority_status'] == 3){ echo 'Not Important and Not Urgent';}
                            else{echo 'Important but not Urgent'; }
                        ?>
                    </span>
                    <span class="todo-tasklist-badge badge badge-roundless <?php  if($row['CIA_progress'] == 1){ echo 'bg-yellow';}else if($row['CIA_progress'] == 2){ echo 'bg-green';}else{echo 'bg-red'; } ?>">
                        <?php 
                            if($row['CIA_progress'] == 1){ echo 'Inprogress';}
                            else if($row['CIA_progress'] == 2){ echo 'Completed';}
                            else{echo 'Not Started'; }
                        ?>
                    </span>
                    <span class="todo-tasklist-badge badge badge-roundless">
                        <?php 
                            $from = $row['CAI_User_PK']; 
                             $sql_from = "SELECT * FROM tbl_user WHERE ID = '$from'"; 
                        	 $result_from = mysqli_query ($conn, $sql_from);
                                foreach($result_from as $row_from){ echo'From: '; echo $row_from['first_name'];}
                        ?>
                    </span>
                    <span class="todo-tasklist-badge badge badge-roundless badge-outlined">
                       <?php 
                            $to = $row['CAI_Assign_to']; 
                            $sql_from = "SELECT * FROM tbl_hr_employee WHERE ID = '$to'"; 
                        	$result_from = mysqli_query ($conn, $sql_from);
                            foreach($result_from as $row_from){ echo'Assigned To: '; echo $row_from['first_name'];}
                        ?>
                    </span>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
               <div class="col-md-12">
                   <label><?php if($row['data_type'] == 1){echo 'Title ';}else{ echo'Task Name ';} ?>(<i style="font-size:12px;color:orange;">ID#. <?= $row['CAI_id']; ?></i>)</label>
                   <input type="hidden" class="form-control" name="IDs" value="<?= $row['CAI_id']; ?>">
                   <input class="form-control" name="CAI_filename" value="<?= $row['CAI_filename']; ?>">
               </div>
           </div>
            <div class="form-group">
               <div class="col-md-12">
                   <label>Description</label>
                   <textarea class="form-control" name="CAI_description" id="your_summernotes3" rows="3"><?= $row['CAI_description']; ?></textarea>
               </div>
            </div>
            <?php if($row['data_type'] != 1): ?>
            <div class="form-group">
               <div class="col-md-6">
                   <label>Account</label>
                   <select class="form-control mt-multiselect btn btn-default" name="CAI_Accounts">
                        <option value="NONE">--Select--</option>
                        <?php
                             $query_accounts = "SELECT * FROM tbl_service_logs_accounts where owner_pk = '$user_id' and  is_status = 0 order by name ASC";
                            $result_accounts = mysqli_query($conn, $query_accounts);
                            while($row_accounts = mysqli_fetch_array($result_accounts))
                            { 
                               echo '<option value="'.$row_accounts['name'].'" '; echo $row['CAI_Accounts'] == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
                            } 
                        ?>
                    </select>
               </div>
               <div class="col-md-6">
                   <label>Action Item</label>
                   <select class="form-control mt-multiselect btn btn-default" type="text" name="Action_taken">
                        <option value="">---Select---</option>
                        <?php
                        $ai = $row['CAI_Action_taken'];
                            $queryType = "SELECT * FROM tbl_MyProject_Services_Action_Items order by Action_Items_name ASC";
                        $resultType = mysqli_query($conn, $queryType);
                        while($rowType = mysqli_fetch_array($resultType))
                             {?> 
                                <option value="<?= $rowType['Action_Items_id']; ?>" <?php if($rowType['Action_Items_id'] == $ai){echo 'selected';}else{echo '';} ?>><?= $rowType['Action_Items_name']; ?></option>
                           <?php } 
                         ?>
                         <option value="0">Others</option> 
                    </select>
               </div>
            </div>
            <div class="form-group">
               <div class="col-md-6">
                   <label>Priority</label>
                   <select class="form-control" name="cai_priority_status">
                       <option>--Select--</option>
                       <option value="1" <?php if($row['cai_priority_status'] == 1){ echo 'selected';} ?>>Important and Urgent</option>
                       <option value="2" <?php if($row['cai_priority_status'] == 2){ echo 'selected';} ?>>Not Important but Urgent</option>
                       <option value="3" <?php if($row['cai_priority_status'] == 3){ echo 'selected';} ?>>Not Important and Not Urgent</option>
                       <option value="0" <?php if($row['cai_priority_status'] == 0){ echo 'selected';} ?>>Important but not Urgent</option>
                   </select>
                   
               </div>
               <div class="col-md-6">
                   <label>Rendered  Time</label>
                   <input class="form-control" type="number" name="CAI_Rendered_Minutes" value="<?= $row['CAI_Rendered_Minutes']; ?>" >
               </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                   <label>Status</label>
                   <select class="form-control" name="CIA_progress">
                       <option value="1" <?php if($row['CIA_progress'] == 1){ echo 'selected';} ?>>Inprogress</option>
                       <option value="2" <?php if($row['CIA_progress'] == 2){ echo 'selected';} ?>>Completed</option>
                       <option value="0" <?php if($row['CIA_progress'] == 0){ echo 'selected';} ?>>Not Started</option>
                   </select>
               </div>
               <div class="col-md-6">
                   <label>Supporting Files <?php if(!empty($row['CAI_files'])){ echo'<a href="MyPro_Folder_Files/'.$row['CAI_files'].'" target="_blank"><i>'.$ext = pathinfo($row['CAI_files'], PATHINFO_EXTENSION).'</i></a>';}else{ echo'<a><i>No file</i></a>';} ?></label>
                   <input type="hidden" class="form-control" name="CAI_files2" value="<?= $row['CAI_files']; ?>">
                   <input type="file" class="form-control" name="CAI_files">
               </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="col-md-6">
                   <label><?php if($row['data_type'] == 1){echo 'Start';}else{ echo'Start Date';} ?></label>
                   <input type="date" class="form-control" name="CAI_Action_date" value="<?= date('Y-m-d', strtotime($row['CAI_Action_date'])); ?>">
               </div>
               <div class="col-md-6">
                   <label><?php if($row['data_type'] == 1){echo 'End';}else{ echo'Due Date';} ?></label>
                   <input type="date" class="form-control" name="CAI_Action_due_date" value="<?= date('Y-m-d', strtotime($row['CAI_Action_due_date'])); ?>">
               </div>
            </div>
            <?php if($row['data_type'] != 1): ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Assign To</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="CAI_Assign_to">
                        <option value="0">---Select---</option>
                        <?php
                            $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                             while($rowAssignto = mysqli_fetch_array($resultAssignto))
                            { 
                               echo '<option value="'.$rowAssignto['ID'].'" '; echo $_COOKIE['employee_id'] == $rowAssignto['ID'] ? 'selected' : ''; echo'>'.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'</option>'; 
                            }
                           
                            $queryQuest = "SELECT * FROM tbl_user where ID = $user_id";
                            $resultQuest = mysqli_query($conn, $queryQuest);
                            while($rowQuest = mysqli_fetch_array($resultQuest))
                            { 
                               echo '<option value="'.$rowQuest['ID'].'" >'.$rowQuest['first_name'].' '.$rowQuest['last_name'].'</option>'; 
                            }
                        ?>
                         <option value="0">Others</option> 
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <?php if($row['data_type'] == 1): ?>
                <input type="hidden" class="form-control" name="CAI_Accounts" value="0">
                <input type="hidden" class="form-control" name="Action_taken" value="0">
                <input type="hidden" class="form-control" name="cai_priority_status" value="0">
                <input type="hidden" class="form-control" name="CIA_progress" value="0">
                <input type="hidden" class="form-control" name="CAI_Assign_to" value="0">
                <input type="hidden" class="form-control" name="CAI_files" value="0">
                <input type="hidden" class="form-control" name="CAI_files2" value="0">
            <?php endif; ?>
        <?php }
 	}
}

// add event
if(isset($_POST['btnAdd_payroll_periods'])) {
  
    $cookie = $_COOKIE['ID'];
   
    $CAI_filename = mysqli_real_escape_string($conn,$_POST['CAI_filename']);
    $CAI_description = mysqli_real_escape_string($conn,$_POST['CAI_description']);
    $CAI_Action_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_date']);
    $CAI_Action_due_date = mysqli_real_escape_string($conn,$_POST['CAI_Action_due_date']);
    
    $sql = "INSERT INTO tbl_MyProject_Services_Childs_action_Items(CAI_filename,CAI_description,CAI_Action_date,CAI_Action_due_date,data_type,user_pk) 
    VALUES('$CAI_filename','$CAI_description','$CAI_Action_date','$CAI_Action_due_date',1,'$user_id')";
    if(mysqli_query($conn, $sql)){
       echo $last_id = mysqli_insert_id($conn);
     }
}
?>
<script>
    $(document).ready(function() {
    $("#your_summernotes3").summernote({
        placeholder:'',
        height: 100
    });
    $('.dropdown-toggle').dropdown();
});
</script>
