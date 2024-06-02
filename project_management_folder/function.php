<?php
	require '../database.php';
	// Get status only
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

// new added 2
if( isset($_POST['btnNew_added']) ) {
	
	$cookie = $_COOKIE['ID'];
	$cCollaborator = '';
	$project_name = mysqli_real_escape_string($conn,$_POST['project_name']);
 	$descriptions = mysqli_real_escape_string($conn,$_POST['descriptions']);
 	$project_date = mysqli_real_escape_string($conn,$_POST['project_date']);
 	$project_no = mysqli_real_escape_string($conn,$_POST['project_no']);
 	$start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
 	$completion_date = mysqli_real_escape_string($conn,$_POST['completion_date']);
 	$prepared_by = mysqli_real_escape_string($conn,$_POST['prepared_by']);
 	$prepared_date = mysqli_real_escape_string($conn,$_POST['prepared_date']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$approved_date = mysqli_real_escape_string($conn,$_POST['approved_date']);
 	$project_area = mysqli_real_escape_string($conn,$_POST['project_area']);
 	
 	$allocate_hour = mysqli_real_escape_string($conn,$_POST['allocate_hour']);
 	
 	$supporting_files = '';
 	$file = $_FILES['supporting_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_files']['name']));
        $rand = rand(10,1000000);
        $supporting_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_files']['tmp_name'],'../project_management_file/'.$to_File_Documents);
    }
    
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	if(!empty($_POST["collaborator_pk"]))
    {
        foreach($_POST["collaborator_pk"] as $collaborator_pk)
        {
            $cCollaborator .= $collaborator_pk.', ';
        }
         
    }
    $cCollaborator = substr($cCollaborator, 0, -2);
    $sql = "INSERT INTO tbl_project_management (project_name,descriptions,project_date,project_no,start_date,completion_date,allocate_hour,supporting_files,remarks,prepared_by,prepared_date,approved_by,approved_date,collaborator_pk,project_area,addedby,project_ownedby) 
    VALUES ('$project_name','$descriptions','$project_date','$project_no','$start_date','$completion_date','$allocate_hour','$supporting_files','$remarks','$prepared_by','$prepared_date','$approved_by','$approved_date','$cCollaborator','$project_area','$cookie','$user_id')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $cookie = $_COOKIE['ID'];
        $scope_work = implode(' | ', $_POST["scope_work"]);
        $scope_work = explode(' | ', $scope_work);
        if(!empty($scope_work))
        {
            $i = 0;
           foreach($scope_work as $val)
            {
                $action_item = mysqli_real_escape_string($conn,$_POST["action_item"][$i]);
                $assigned_to = mysqli_real_escape_string($conn,$_POST["assigned_to"][$i]);
                $completion_date = mysqli_real_escape_string($conn,$_POST["scope_completion_date"][$i]);
                $hours = mysqli_real_escape_string($conn, $_POST["hours"][$i]);
                $status_action = mysqli_real_escape_string($conn, $_POST["status_action"][$i]);
                
                $sql2 = "INSERT INTO tbl_project_management_scope(scope_work,action_item,assigned_to,completion_date,hours,status_action,addeby,ownedby,project_id) 
                VALUES('".mysqli_real_escape_string($conn, $val)."','$action_item','$assigned_to','$completion_date','$hours','$status_action','$cookie','$user_id','$last_id')";
                if(mysqli_query($conn, $sql2)){
                    $last_id_scope = mysqli_insert_id($conn);
                }
                $i++;
            }
        }
        
        $query = "SELECT *  FROM tbl_project_management where project_pk = $last_id ";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
            <tr id="row_<?= $row['project_pk']; ?>">
                <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                <td><?= $row['project_name']; ?></td>
                <td><?= $row['descriptions']; ?></td>
                <td>
                    <?php
                        $your_emp = $_COOKIE['employee_id'];
                        $project_pk = $row['project_pk'];
                        $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                        foreach($qry as $assg_row){
                            $assigned_to = $assg_row['assigned_to'];
                            $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                            foreach($emp_qry as $emp_assg){
                                echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                            }
                        }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                <td><?= $row['project_no']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                <td><?= $row['allocate_hour']; ?></td>
                <td><?= $row['project_area']; ?></td>
                <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                <td style="width:100px;">
                    <div class="btn-group btn-group-circle">
                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                        <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                    </div>
                </td>
            </tr>
        <?php }
        
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
}

// update project
if( isset($_GET['postDetails2']) ) {
	$ID = $_GET['postDetails2'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_project_management where project_pk = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { ?>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <label class="control-label">Project Name:</label>
                        <input class="form-control border-bottom" type="" name="project_name" value="<?= $row_proj['project_name'];?>">
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Description:</label>
                        <textarea class="form-control border-bottom" name="descriptions" rows="6"><?= $row_proj['descriptions'];?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <label class="control-label">Date</label>
                        <input class="form-control border-bottom" type="date" name="project_date" value="<?php echo date('Y-m-d', strtotime($row_proj['project_date'])); ?>">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Project No.:</label>
                        <input class="form-control border-bottom" type="" name="project_no" value="<?= $row_proj['project_no'];?>">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Start Date:</label>
                        <input class="form-control border-bottom" type="date" name="start_date" value="<?php echo date('Y-m-d', strtotime($row_proj['start_date'])); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Target Completion Date:</label>
                        <input class="form-control border-bottom" type="date" name="completion_date" value="<?php echo date('Y-m-d', strtotime($row_proj['completion_date'])); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Allocated hour/s:</label>
                    <input class="form-control border-bottom" type="number" name="allocate_hour" value="<?= $row_proj['allocate_hour']; ?>">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Supporting Files:</label>
                    <input class="form-control border-bottom" type="file" name="supporting_files">
                    <input class="form-control border-bottom" type="hidden" name="supporting_files2" value="<?= $row_proj['supporting_files']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Involve Personnel/s:</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="collaborator_pk[]" multiple>
                        <option value="">---Select---</option>
                        
                        <?php 
                            $array_data_attd = explode(", ", $row_proj["collaborator_pk"]);
                            $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = $user_id order by first_name ASC";
                            $resultCollab = mysqli_query($conn, $queryCollab);
                                                        
                            while($rowCollab = mysqli_fetch_array($resultCollab))
                            { ?> 
                            <option value="<?php echo $rowCollab['ID']; ?>" <?php if(in_array($rowCollab['ID'],$array_data_attd)){echo 'selected';} ?>><?php echo $rowCollab['first_name']; ?> <?php echo $rowCollab['last_name']; ?></option>
                        <?php } ?>
                        
                        <?php 
                            
                            $query = "SELECT *  FROM tbl_user where ID = $user_id";
                            $result = mysqli_query($conn, $query);
                                                        
                            while($row = mysqli_fetch_array($result))
                            { ?> 
                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></option>
                        <?php } 
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Area</label>
                    <input class="form-control" name="project_area" value="<?= $row_proj['project_area']; ?>">
                </div>
            </div>
            <br>
            <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_Open1" data-toggle="tab">Open</a>
                </li>
                <li>
                    <a href="#tab_Close1" data-toggle="tab">Close</a>
                </li>
            </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_Open1">
                        <div class="table table-scrollable">
                            <table class="table table-bordered" >
                                <thead>
                                    <th>Scope of Work</th>
                                    <th>Action Items</th>
                                    <th>Assign To</th>
                                    <th>Completion Date</th>
                                    <th>Hour</th>
                                    <th>Status</th>
                                    <th width="30px"></th>
                                </thead>
                                <tbody id="data_scope">
                                    <?php
                                        $proj_pk = $row_proj['project_pk'];
                                        $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action != 'Close'");
                                        foreach($scope_query as $scope){?>
                                            <tr id="emp_<?= $scope['scope_pk']; ?>">
                                                <td><?= $scope['scope_work']; ?></td>
                                                <td><?= $scope['action_item']; ?></td>
                                                <td>
                                                    <?php 
                                                        $emp_id = $scope['assigned_to']; 
                                                        $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                                        foreach($assign_query as $row_emp){
                                                            echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $scope['completion_date']; ?></td>
                                                <td><?= $scope['hours']; ?></td>
                                                <td><?= $scope['status_action']; ?></td>
                                                <td width="30px">
                                                    <?php $owned = $_COOKIE['ID']; if($scope['addeby'] == $owned): ?>
                                                    <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn red btn-xs" onclick=""><i class="fa fa-trash"></i></a>
                                                    <a href="#modal_edit_plan" data-toggle="modal" type="button" id="edit_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn blue btn-xs" onclick=""><i class="fa fa-edit"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                    <tr>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                            <?php
                                                $proj_pk = $row_proj['project_pk'];
                                                $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action != 'Close'");
                                                foreach($scope_count as $count){
                                                    echo '<b>'.$count['count'].'</b>';
                                                }
                                            ?>
                                        </td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                    </tr>
                                </tbody>
                                <tbody id="dynamic_field2">
                                    <tr>
                                        <td><textarea class="form-control border-none" name="scope_work[]"></textarea></td>
                                        <td><textarea class="form-control border-none" name="action_item[]"></textarea></td>
                                        <td>
                                            <select class="form-control border-none" type="text" name="assigned_to[]">
                                                <option value="0">---Select---</option>
                                                <?php
                                                    $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                                                    $resultApp = mysqli_query($conn, $queryApp);
                                                    while($rowApp = mysqli_fetch_array($resultApp))
                                                    { 
                                                       echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                                                    }
                                                 ?>
                                            </select>
                                        </td>
                                        <td><input type="date" name="scope_completion_date[]" placeholder="Due Date" class="form-control border-none" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                                        <td><input type="number" name="hours[]" placeholder="" class="form-control border-none" ></td>
                                        <td>
                                            <select class="form-control border-none" type="text" name="status_action[]">
                                                <option value="Open">Open</option>
                                                <option value="Follow Up">Follow Up</option>
                                                <option value="Close">Close</option>
                                            </select>
                                        </td>
                                        <td><button type="button" name="add2" id="add2" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_Close1">
                        <div class="table table-scrollable">
                            <table class="table table-bordered" >
                                <thead>
                                    <th>Scope of Work</th>
                                    <th>Action Items</th>
                                    <th>Assign To</th>
                                    <th>Completion Date</th>
                                    <th>Hour</th>
                                    <th>Status</th>
                                    <th width="30px"></th>
                                </thead>
                                <tbody id="data_scope1">
                                    <?php
                                        $proj_pk = $row_proj['project_pk'];
                                        $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close'");
                                        foreach($scope_query as $scope){?>
                                            <tr id="emp_<?= $scope['scope_pk']; ?>">
                                                <td><?= $scope['scope_work']; ?></td>
                                                <td><?= $scope['action_item']; ?></td>
                                                <td>
                                                    <?php 
                                                        $emp_id = $scope['assigned_to']; 
                                                        $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                                        foreach($assign_query as $row_emp){
                                                            echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $scope['completion_date']; ?></td>
                                                <td><?= $scope['hours']; ?></td>
                                                <td><?= $scope['status_action']; ?></td>
                                                <td width="30px">
                                                    <?php $owned = $_COOKIE['ID']; if($scope['addeby'] == $owned): ?>
                                                    <a href="#modal_delete_plan1" data-toggle="modal" type="button" id="delete_btn1" data-id="<?= $scope['scope_pk']; ?>" class="btn red btn-xs" onclick=""><i class="fa fa-trash"></i></a>
                                                    <a href="#modal_edit_plan1" data-toggle="modal" type="button" id="edit_btn1" data-id="<?= $scope['scope_pk']; ?>" class="btn blue btn-xs" onclick=""><i class="fa fa-edit"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                    <tr>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                            <?php
                                                $proj_pk = $row_proj['project_pk'];
                                                $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close'");
                                                foreach($scope_count as $count){
                                                    echo '<b>'.$count['count'].'</b>';
                                                }
                                            ?>
                                        </td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label">Remarks:</label>
                    <textarea class="form-control border-bottom" name="remarks" rows="2"><?= $row_proj['remarks']; ?></textarea>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Prepared By</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="prepared_by">
                        <option value="0">---Select---</option>
                        <?php
                            $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                            $resultVeri = mysqli_query($conn, $queryVeri);
                            while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <option value="<?= $rowVeri['ID']; ?>" <?php if($rowVeri['ID'] == $row_proj['prepared_by']){echo 'selected'; } ?>><?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?></option>'; 
                            <?php }
                         ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Date</label>
                    <input type="date" name="prepared_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime($row_proj['prepared_date'])); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Approved By</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by">
                        <option value="0">---Select---</option>
                        <?php
                            $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                        $resultVeri = mysqli_query($conn, $queryVeri);
                        while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <option value="<?= $rowVeri['ID']; ?>" <?php if($rowVeri['ID'] == $row_proj['approved_by']){echo 'selected'; } ?>><?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?></option>'; 
                            <?php }
                         ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Date</label>
                    <input type="date" name="approved_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime($row_proj['approved_date'])); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Status</label>
                    <select class="form-control" type="text" name="is_completed">
                        <option value="0">Not Started</option>
                        <option value="5">Inprogress</option>
                        <option value="1">Completed</option>
                        <!--<option value="2">For Pay</option>-->
                    </select>
                </div>
            </div>
    <?php } 
}
if( isset($_POST['btnSave_details2']) ) {
    
    $ID = $_POST['ID'];
    $cCollaborator = '';
	$project_name = mysqli_real_escape_string($conn,$_POST['project_name']);
 	$descriptions = mysqli_real_escape_string($conn,$_POST['descriptions']);
 	$project_date = mysqli_real_escape_string($conn,$_POST['project_date']);
 	$project_no = mysqli_real_escape_string($conn,$_POST['project_no']);
 	$start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
 	$completion_date = mysqli_real_escape_string($conn,$_POST['completion_date']);
 	$prepared_by = mysqli_real_escape_string($conn,$_POST['prepared_by']);
 	$prepared_date = mysqli_real_escape_string($conn,$_POST['prepared_date']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$approved_date = mysqli_real_escape_string($conn,$_POST['approved_date']);
 	$allocate_hour = mysqli_real_escape_string($conn,$_POST['allocate_hour']);
 	$project_area = mysqli_real_escape_string($conn,$_POST['project_area']);
 	$is_completed = mysqli_real_escape_string($conn,$_POST['is_completed']);
 	$file = $_FILES['supporting_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_files']['name']));
        $rand = rand(10,1000000);
        $supporting_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_files']['tmp_name'],'../project_management_file/'.$to_File_Documents);
    }else{ $supporting_files = mysqli_real_escape_string($conn,$_POST['supporting_files2']);}
    
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	if(!empty($_POST["collaborator_pk"]))
    {
        foreach($_POST["collaborator_pk"] as $collaborator_pk)
        {
            $cCollaborator .= $collaborator_pk.', ';
        }
         
    }
    $cCollaborator = substr($cCollaborator, 0, -2);
 	$sql = "UPDATE tbl_project_management set project_name='$project_name',descriptions='$descriptions',project_date='$project_date',project_no='$project_no',start_date='$start_date',completion_date='$completion_date',allocate_hour='$allocate_hour',supporting_files='$supporting_files',remarks='$remarks',prepared_by='$prepared_by',prepared_date='$prepared_date',approved_by='$approved_by',approved_date='$approved_date',collaborator_pk='$cCollaborator',project_area='$project_area',is_completed='$is_completed' where project_pk = $ID";
    if(mysqli_query($conn, $sql)){
        
        $ID = $_POST['ID'];
        $cookie = $_COOKIE['ID'];
        
        $scope_work = implode(' | ', $_POST["scope_work"]);
        $scope_work = explode(' | ', $scope_work);
        foreach($scope_work as $arr){
            if(!empty($arr))
            {
                $i = 0;
               foreach($scope_work as $val)
                {
                    $action_item = mysqli_real_escape_string($conn,$_POST["action_item"][$i]);
                    $assigned_to = mysqli_real_escape_string($conn,$_POST["assigned_to"][$i]);
                    $completion_date = mysqli_real_escape_string($conn,$_POST["scope_completion_date"][$i]);
                    $hours = mysqli_real_escape_string($conn, $_POST["hours"][$i]);
                    $status_action = mysqli_real_escape_string($conn, $_POST["status_action"][$i]);
                    
                    $sql2 = "INSERT INTO tbl_project_management_scope(scope_work,action_item,assigned_to,completion_date,hours,status_action,addeby,ownedby,project_id) 
                    VALUES('".mysqli_real_escape_string($conn, $val)."','$action_item','$assigned_to','$completion_date','$hours','$status_action','$cookie','$user_id','$ID')";
                    if(mysqli_query($conn, $sql2)){
                        $last_id_scope = mysqli_insert_id($conn);
                    }
                    $i++;
                }
            }
        }
        
        //append
        $query = "SELECT *  FROM tbl_project_management where project_pk = $ID ";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
                <td><a href="#modal_completed_plan" data-toggle="modal" type="button" id="completed_btn" data-id="<?= $row['project_pk']; ?>" class="btn green btn-xs" onclick=""><i class="fa fa-check"></i></a></td>
                <td><?= $row['project_name']; ?></td>
                <td><?= $row['descriptions']; ?></td>
                <td>
                    <?php
                        $your_emp = $_COOKIE['employee_id'];
                        $project_pk = $row['project_pk'];
                        $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                        foreach($qry as $assg_row){
                            $assigned_to = $assg_row['assigned_to'];
                            $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                            foreach($emp_qry as $emp_assg){
                                echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                            }
                        }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                <td><?= $row['project_no']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                <td><?= $row['allocate_hour']; ?></td>
                <td><?= $row['project_area']; ?></td>
                <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                <td style="width:100px;">
                    <div class="btn-group btn-group-circle">
                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['project_pk']; ?>)">Edit</a>
                        <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                    </div>
                </td>
        <?php }
    }
}


// update project 1
if( isset($_GET['postDetails1']) ) {
	$ID = $_GET['postDetails1'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="row_id1" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_project_management where project_pk = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { ?>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <label class="control-label">Project Name:</label>
                        <input class="form-control border-bottom" type="" name="project_name" value="<?= $row_proj['project_name'];?>">
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Description:</label>
                        <textarea class="form-control border-bottom" name="descriptions" rows="6"><?= $row_proj['descriptions'];?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <label class="control-label">Date</label>
                        <input class="form-control border-bottom" type="date" name="project_date" value="<?php echo date('Y-m-d', strtotime($row_proj['project_date'])); ?>">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Project No.:</label>
                        <input class="form-control border-bottom" type="" name="project_no" value="<?= $row_proj['project_no'];?>">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Start Date:</label>
                        <input class="form-control border-bottom" type="date" name="start_date" value="<?php echo date('Y-m-d', strtotime($row_proj['start_date'])); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Target Completion Date:</label>
                        <input class="form-control border-bottom" type="date" name="completion_date" value="<?php echo date('Y-m-d', strtotime($row_proj['completion_date'])); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Allocated hour/s:</label>
                    <input class="form-control border-bottom" type="number" name="allocate_hour" value="<?= $row_proj['allocate_hour']; ?>">
                </div>
                <div class="col-md-6">
                    <label>Area</label>
                    <input class="form-control border-bottom" name="project_area" value="<?= $row_proj['project_area']; ?>">
                </div>
            </div>
            <br>
            <div class="tabbable tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_Unpaid1" data-toggle="tab">For Pay</a>
                    </li>
                    <li>
                        <a href="#tab_Paid1" data-toggle="tab">Paid</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_Unpaid1">
                        <div class="table table-scrollable">
                            <table class="table table-bordered" >
                                <thead>
                                    <th>Scope of Work</th>
                                    <th>Action Items</th>
                                    <th>Assign To</th>
                                    <th>Completion Date</th>
                                    <th>Hour</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th width="5px">
                                        <!--<input type="checkbox" id="checkAll">-->
                                    </th>
                                </thead>
                                <tbody id="data_scope">
                                    <?php
                                        $proj_pk = $row_proj['project_pk'];
                                        $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close' and is_paid = 0");
                                        foreach($scope_query as $scope){?>
                                            <tr id="scope_<?= $scope['scope_pk']; ?>">
                                                <td><?= $scope['scope_work']; ?></td>
                                                <td><?= $scope['action_item']; ?></td>
                                                <td>
                                                    <?php 
                                                        $emp_id = $scope['assigned_to']; 
                                                        $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                                        foreach($assign_query as $row_emp){
                                                            echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $scope['completion_date']; ?></td>
                                                <td><?= $scope['hours']; ?></td>
                                                <td><?= $scope['status_action']; ?></td>
                                                <td>
                                                    <?php 
                                                        if($scope['is_paid'] == 0){ echo 'Unpaid'; }
                                                        else if($scope['is_paid'] == 1){ echo 'Paid'; }
                                                    ?>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="scope_update_id[]" class="update_scope" value="<?= $scope['scope_pk']; ?>" />
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                    <tr>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                            <?php
                                                $proj_pk = $row_proj['project_pk'];
                                                $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close' and is_paid = 0");
                                                foreach($scope_count as $count){
                                                    echo '<b>'.$count['count'].'</b>';
                                                }
                                            ?>
                                        </td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                            <button type="button" name="btn_paid_update" id="btn_paid_update" class="btn btn-success">Paid</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_Paid1">
                        <div class="table table-scrollable">
                            <table class="table table-bordered" >
                                <thead>
                                    <th>Scope of Work</th>
                                    <th>Action Items</th>
                                    <th>Assign To</th>
                                    <th>Completion Date</th>
                                    <th>Hour</th>
                                    <th>Status</th>
                                    <th></th>
                                </thead>
                                <tbody id="data_scope">
                                    <?php
                                        $proj_pk = $row_proj['project_pk'];
                                        $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close' and is_paid = 1");
                                        foreach($scope_query as $scope){?>
                                            <tr id="emp_<?= $scope['scope_pk']; ?>">
                                                <td><?= $scope['scope_work']; ?></td>
                                                <td><?= $scope['action_item']; ?></td>
                                                <td>
                                                    <?php 
                                                        $emp_id = $scope['assigned_to']; 
                                                        $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                                        foreach($assign_query as $row_emp){
                                                            echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $scope['completion_date']; ?></td>
                                                <td><?= $scope['hours']; ?></td>
                                                <td><?= $scope['status_action']; ?></td>
                                                <td>
                                                    <?php 
                                                        if($scope['is_paid'] == 0){ echo 'Unpaid'; }
                                                        else if($scope['is_paid'] == 1){ echo 'Paid'; }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                    <tr>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                            <?php
                                                $proj_pk = $row_proj['project_pk'];
                                                $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close' and is_paid = 1");
                                                foreach($scope_count as $count){
                                                    echo '<b>'.$count['count'].'</b>';
                                                }
                                            ?>
                                        </td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                        <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label">Remarks:</label>
                    <textarea class="form-control border-bottom" name="remarks" rows="2"><?= $row_proj['remarks']; ?></textarea>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Prepared By</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="prepared_by">
                        <option value="0">---Select---</option>
                        <?php
                            $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                            $resultVeri = mysqli_query($conn, $queryVeri);
                            while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <option value="<?= $rowVeri['ID']; ?>" <?php if($rowVeri['ID'] == $row_proj['prepared_by']){echo 'selected'; } ?>><?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?></option>'; 
                            <?php }
                         ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Date</label>
                    <input type="date" name="prepared_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime($row_proj['prepared_date'])); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Approved By</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by">
                        <option value="0">---Select---</option>
                        <?php
                            $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                        $resultVeri = mysqli_query($conn, $queryVeri);
                        while($rowVeri = mysqli_fetch_array($resultVeri))
                            { ?>
                               <option value="<?= $rowVeri['ID']; ?>" <?php if($rowVeri['ID'] == $row_proj['approved_by']){echo 'selected'; } ?>><?= $rowVeri['first_name']; ?> <?= $rowVeri['last_name']; ?></option>'; 
                            <?php }
                         ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Date</label>
                    <input type="date" name="approved_date" placeholder="" class="form-control" value="<?= date('Y-m-d', strtotime($row_proj['approved_date'])); ?>">
                </div>
            </div>
            <!--<div class="form-group">-->
            <!--    <div class="col-md-6">-->
            <!--        <label>Status</label>-->
            <!--        <select class="form-control" type="text" name="is_completed">-->
            <!--            <option value="2" <?php //if($row_proj['is_completed']==2){ echo 'selected'; } ?>>Upaid</option>-->
            <!--            <option value="3" <?php //if($row_proj['is_completed']==3){ echo 'selected'; } ?>>Paid</option>-->
            <!--        </select>-->
            <!--    </div>-->
            <!--</div>-->
    <?php } 
}
if( isset($_POST['btnSave_details1']) ) {
    
    $ID = $_POST['ID'];
    $cCollaborator = '';
	$project_name = mysqli_real_escape_string($conn,$_POST['project_name']);
 	$descriptions = mysqli_real_escape_string($conn,$_POST['descriptions']);
 	$project_date = mysqli_real_escape_string($conn,$_POST['project_date']);
 	$project_no = mysqli_real_escape_string($conn,$_POST['project_no']);
 	$start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
 	$completion_date = mysqli_real_escape_string($conn,$_POST['completion_date']);
 	$prepared_by = mysqli_real_escape_string($conn,$_POST['prepared_by']);
 	$prepared_date = mysqli_real_escape_string($conn,$_POST['prepared_date']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$approved_date = mysqli_real_escape_string($conn,$_POST['approved_date']);
 	$allocate_hour = mysqli_real_escape_string($conn,$_POST['allocate_hour']);
 	$project_area = mysqli_real_escape_string($conn,$_POST['project_area']);
 	$is_completed = mysqli_real_escape_string($conn,$_POST['is_completed']);
 	
 	$file = $_FILES['supporting_files']['name'];
    if(!empty($file)){
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = end(explode(".", $_FILES['supporting_files']['name']));
        $rand = rand(10,1000000);
        $supporting_files =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
        $to_File_Documents = $rand." - ".$filename.".".$extension;
        move_uploaded_file($_FILES['supporting_files']['tmp_name'],'../project_management_file/'.$to_File_Documents);
    }else{ $supporting_files = mysqli_real_escape_string($conn,$_POST['supporting_files2']);}
    
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	if(!empty($_POST["collaborator_pk"]))
    {
        foreach($_POST["collaborator_pk"] as $collaborator_pk)
        {
            $cCollaborator .= $collaborator_pk.', ';
        }
         
    }
    $cCollaborator = substr($cCollaborator, 0, -2);
 	$sql = "UPDATE tbl_project_management set project_name='$project_name',descriptions='$descriptions',project_date='$project_date',project_no='$project_no',start_date='$start_date',completion_date='$completion_date',allocate_hour='$allocate_hour',supporting_files='$supporting_files',remarks='$remarks',prepared_by='$prepared_by',prepared_date='$prepared_date',approved_by='$approved_by',approved_date='$approved_date',collaborator_pk='$cCollaborator',project_area='$project_area',is_completed='$is_completed' where project_pk = $ID";
    if(mysqli_query($conn, $sql)){
        
        $ID = $_POST['ID'];
        $cookie = $_COOKIE['ID'];
        
        $scope_work = implode(' | ', $_POST["scope_work"]);
        $scope_work = explode(' | ', $scope_work);
        foreach($scope_work as $arr){
            if(!empty($arr))
            {
                $i = 0;
               foreach($scope_work as $val)
                {
                    $action_item = mysqli_real_escape_string($conn,$_POST["action_item"][$i]);
                    $assigned_to = mysqli_real_escape_string($conn,$_POST["assigned_to"][$i]);
                    $completion_date = mysqli_real_escape_string($conn,$_POST["scope_completion_date"][$i]);
                    $hours = mysqli_real_escape_string($conn, $_POST["hours"][$i]);
                    $status_action = mysqli_real_escape_string($conn, $_POST["status_action"][$i]);
                    
                    $sql2 = "INSERT INTO tbl_project_management_scope(scope_work,action_item,assigned_to,completion_date,hours,status_action,addeby,ownedby,project_id) 
                    VALUES('".mysqli_real_escape_string($conn, $val)."','$action_item','$assigned_to','$completion_date','$hours','$status_action','$cookie','$user_id','$ID')";
                    if(mysqli_query($conn, $sql2)){
                        $last_id_scope = mysqli_insert_id($conn);
                    }
                    $i++;
                }
            }
        }
        
        //append
        $query = "SELECT *  FROM tbl_project_management where project_pk = $ID ";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {?>
                <td><?= $row['project_name']; ?></td>
                <td><?= $row['descriptions']; ?></td>
                <td>
                    <?php
                        $your_emp = $_COOKIE['employee_id'];
                        $project_pk = $row['project_pk'];
                        $qry = mysqli_query($conn, "select DISTINCT(assigned_to),project_id from tbl_project_management_scope where project_id = '$project_pk' and is_deleted = 0");
                        foreach($qry as $assg_row){
                            $assigned_to = $assg_row['assigned_to'];
                            $emp_qry = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$assigned_to'");
                            foreach($emp_qry as $emp_assg){
                                echo $emp_assg['first_name'].' '.$emp_assg['last_name'].'<br>';
                            }
                        }
                    ?>
                </td>
                <td><?= date('Y-m-d', strtotime($row['project_date'])); ?></td>
                <td><?= $row['project_no']; ?></td>
                <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                <td><?= date('Y-m-d', strtotime($row['completion_date'])); ?></td>
                <td><?= $row['allocate_hour']; ?></td>
                <td><?= $row['project_area']; ?></td>
                <td><a href="project_management_file/<?= $row['supporting_files']; ?>" target="_blank"><?= $row['supporting_files']; ?></a></td>
                <td style="width:100px;">
                    <div class="btn-group btn-group-circle">
                       <a href="#modalGet_details1" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details1(<?php echo  $row['project_pk']; ?>)">Edit</a>
                        <a class="btn red btn-sm" type="button" id="print_btn" data-id="<?php echo  $row['project_pk']; ?>">PDF</a>
                    </div>
                </td>
        <?php }
    }
}

//Completed project
if( isset($_GET['complete_id']) ) {
	$ID = $_GET['complete_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="row_id" value="'.$ID.'" />
	    ';
	        $query = "SELECT * FROM tbl_project_management where project_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Project Name </b></label>
                        <br>
                        <i><?= $row['project_name']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Description </b></label>
                        <br>
                        <i><?= $row['descriptions']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnCompleted_plan']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tbl_project_management set is_completed = 1  where project_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

//delete action
if( isset($_GET['delete_id']) ) {
	$ID = $_GET['delete_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="emp_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_project_management_scope where scope_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Scope work </b></label>
                        <br>
                        <i><?= $row['scope_work']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Action Item </b></label>
                        <br>
                        <i><?= $row['action_item']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnDelete_plan']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tbl_project_management_scope set is_deleted = 1  where scope_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

//delete action
if( isset($_GET['delete_id1']) ) {
	$ID = $_GET['delete_id1'];

	echo '<input class="form-control" type="hidden" name="ID" id="emp_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_project_management_scope where scope_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><b>Scope work </b></label>
                        <br>
                        <i><?= $row['scope_work']; ?></i>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label"><b>Action Item </b></label>
                        <br>
                        <i><?= $row['action_item']; ?></i>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnDelete_plan1']) ) {
  $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
	$sql = "UPDATE tbl_project_management_scope set is_deleted = 1  where scope_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          echo $IDs;
          
    }
}

//edit action open
if( isset($_GET['edit_id']) ) {
	$ID = $_GET['edit_id'];

	echo '<input class="form-control" type="hidden" name="ID" id="emp_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_project_management_scope where scope_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Scope work</label>
                        <input class="form-control" type="hidden" name="project_id" value="<?= $row['project_id']; ?>">
                        <textarea class="form-control" name="scope_work"><?= $row['scope_work']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Action Item</label>
                        <textarea class="form-control" name="action_item"><?= $row['action_item']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Assign To</label>
                        <select class="form-control" type="text" name="assigned_to">
                            <option value="0">---Select---</option>
                            <?php
                                $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                            $resultApp = mysqli_query($conn, $queryApp);
                            while($rowApp = mysqli_fetch_array($resultApp))
                                { ?>
                                   <option value="<?= $rowApp['ID']; ?>" <?php if($rowApp['ID'] == $row['assigned_to']){ echo 'selected'; } ?>><?= $rowApp['first_name']; ?> <?= $rowApp['last_name']; ?></option>'; 
                                <?php }
                             ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Hour</label>
                        <input class="form-control" type="number" name="hours" value="<?= $row['hours']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Completion Date</label>
                        <input class="form-control" type="date" name="completion_date" value="<?= date('Y-m-d', strtotime($row['completion_date'])); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Status</label>
                        <select class="form-control" type="text" name="status_action">
                            <option value="Open" <?php if($row['status_action'] == 'Open'){ echo 'selected'; } ?>>Open</option>
                            <option value="Follow Up" <?php if($row['status_action'] == 'Follow Up'){ echo 'selected'; } ?>>Follow Up</option>
                            <option value="Close" <?php if($row['status_action'] =='Close'){ echo 'selected'; } ?>>Close</option>
                        </select>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnEdit_plan']) ) {
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $project_id = $_POST['project_id'];
    $scope_work = mysqli_real_escape_string($conn,$_POST['scope_work']);
    $action_item = mysqli_real_escape_string($conn,$_POST['action_item']);
    $assigned_to = mysqli_real_escape_string($conn,$_POST['assigned_to']);
    $hours = mysqli_real_escape_string($conn,$_POST['hours']);
    $completion_date = mysqli_real_escape_string($conn,$_POST['completion_date']);
    $status_action = mysqli_real_escape_string($conn,$_POST['status_action']);
    
	$sql = "UPDATE tbl_project_management_scope set scope_work = '$scope_work',action_item = '$action_item', assigned_to ='$assigned_to', hours = '$hours', completion_date = '$completion_date', status_action = '$status_action'   where scope_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          ?>
          <?php
                $project_id = $_POST['project_id'];
                $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$project_id' and is_deleted = 0 and status_action != 'Close'");
                foreach($scope_query as $scope){?>
                    <tr id="emp_<?= $scope['scope_pk']; ?>">
                        <td><?= $scope['scope_work']; ?></td>
                        <td><?= $scope['action_item']; ?></td>
                        <td>
                            <?php 
                                $emp_id = $scope['assigned_to']; 
                                $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                foreach($assign_query as $row_emp){
                                    echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                }
                            ?>
                        </td>
                        <td><?= $scope['completion_date']; ?></td>
                        <td><?= $scope['hours']; ?></td>
                        <td><?= $scope['status_action']; ?></td>
                        <td>
                           <?php $owned = $_COOKIE['ID']; if($scope['addeby'] == $owned): ?>
                            <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn red btn-xs" onclick=""><i class="fa fa-trash"></i></a>
                            <a href="#modal_edit_plan" data-toggle="modal" type="button" id="edit_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn blue btn-xs" onclick=""><i class="fa fa-edit"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php }
            ?>
            <tr>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                    <?php
                        $proj_pk = $_POST['project_id'];
                        $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action != 'Close'");
                        foreach($scope_count as $count){
                            echo '<b>'.$count['count'].'</b>';
                        }
                    ?>
                </td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
            </tr>
          
    <?php }
}

//edit action open
if( isset($_GET['edit_id1']) ) {
	$ID = $_GET['edit_id1'];

	echo '<input class="form-control" type="hidden" name="ID" id="emp_id1" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_project_management_scope where scope_pk = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Scope work</label>
                        <input class="form-control" type="hidden" name="project_id" value="<?= $row['project_id']; ?>">
                        <textarea class="form-control" name="scope_work"><?= $row['scope_work']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Action Item</label>
                        <textarea class="form-control" name="action_item"><?= $row['action_item']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Assign To</label>
                        <select class="form-control" type="text" name="assigned_to">
                            <option value="0">---Select---</option>
                            <?php
                                $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                            $resultApp = mysqli_query($conn, $queryApp);
                            while($rowApp = mysqli_fetch_array($resultApp))
                                { ?>
                                   <option value="<?= $rowApp['ID']; ?>" <?php if($rowApp['ID'] == $row['assigned_to']){ echo 'selected'; } ?>><?= $rowApp['first_name']; ?> <?= $rowApp['last_name']; ?></option>'; 
                                <?php }
                             ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Hour</label>
                        <input class="form-control" type="number" name="hours" value="<?= $row['hours']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label">Completion Date</label>
                        <input class="form-control" type="date" name="completion_date" value="<?= date('Y-m-d', strtotime($row['completion_date'])); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Status</label>
                        <select class="form-control" type="text" name="status_action">
                            <option value="Open" <?php if($row['status_action'] == 'Open'){ echo 'selected'; } ?>>Open</option>
                            <option value="Follow Up" <?php if($row['status_action'] == 'Follow Up'){ echo 'selected'; } ?>>Follow Up</option>
                            <option value="Close" <?php if($row['status_action'] =='Close'){ echo 'selected'; } ?>>Close</option>
                        </select>
                    </div>
                </div>
    <?php } 
}
if( isset($_POST['btnEdit_plan1']) ) {
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $project_id = $_POST['project_id'];
    $scope_work = mysqli_real_escape_string($conn,$_POST['scope_work']);
    $action_item = mysqli_real_escape_string($conn,$_POST['action_item']);
    $assigned_to = mysqli_real_escape_string($conn,$_POST['assigned_to']);
    $hours = mysqli_real_escape_string($conn,$_POST['hours']);
    $completion_date = mysqli_real_escape_string($conn,$_POST['completion_date']);
    $status_action = mysqli_real_escape_string($conn,$_POST['status_action']);
    
	$sql = "UPDATE tbl_project_management_scope set scope_work = '$scope_work',action_item = '$action_item', assigned_to ='$assigned_to', hours = '$hours', completion_date = '$completion_date', status_action = '$status_action'   where scope_pk = $IDs";
    if(mysqli_query($conn, $sql)){
          ?>
          <?php
                $project_id = $_POST['project_id'];
                $scope_query = mysqli_query($conn, "select * from tbl_project_management_scope where project_id =  '$project_id' and is_deleted = 0 and status_action = 'Close'");
                foreach($scope_query as $scope){?>
                    <tr id="emp_<?= $scope['scope_pk']; ?>">
                        <td><?= $scope['scope_work']; ?></td>
                        <td><?= $scope['action_item']; ?></td>
                        <td>
                            <?php 
                                $emp_id = $scope['assigned_to']; 
                                $assign_query = mysqli_query($conn, "select * from tbl_hr_employee where ID = '$emp_id'");
                                foreach($assign_query as $row_emp){
                                    echo $row_emp['first_name'].' '.$row_emp['last_name'];
                                }
                            ?>
                        </td>
                        <td><?= $scope['completion_date']; ?></td>
                        <td><?= $scope['hours']; ?></td>
                        <td><?= $scope['status_action']; ?></td>
                        <td>
                           <?php $owned = $_COOKIE['ID']; if($scope['addeby'] == $owned): ?>
                            <a href="#modal_delete_plan" data-toggle="modal" type="button" id="delete_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn red btn-xs" onclick=""><i class="fa fa-trash"></i></a>
                            <a href="#modal_edit_plan" data-toggle="modal" type="button" id="edit_btn" data-id="<?= $scope['scope_pk']; ?>" class="btn blue btn-xs" onclick=""><i class="fa fa-edit"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php }
            ?>
            <tr>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"><b>Total Hours</b></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                    <?php
                        $proj_pk = $_POST['project_id'];
                        $scope_count = mysqli_query($conn, "select sum(hours) as count from tbl_project_management_scope where project_id =  '$proj_pk' and is_deleted = 0 and status_action = 'Close'");
                        foreach($scope_count as $count){
                            echo '<b>'.$count['count'].'</b>';
                        }
                    ?>
                </td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
                <td style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;"></td>
            </tr>
          
    <?php }
}
?>