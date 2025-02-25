<?php 
     include_once ('../database.php'); 
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
if( isset($_GET['modalView']) ) {
		$id = $_GET['modalView'];
		$selectData = mysqli_query( $conn,"SELECT * FROM tbl_MyProject_Services WHERE MyPro_id = $id" );
		if ( mysqli_num_rows($selectData) > 0 ) {
            $row = mysqli_fetch_array($selectData);
        }
		echo '
		<input class="form-control" type="hidden" name="ID" value="'. $row['MyPro_id'] .'" />
         <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Project Name</label>
                </div>
                <div class="col-md-12" >
                    <input class="form-control" type="text" name="Project_Name" value="'.$row['Project_Name'].'">
                </div>
            </div>
        </div>
       <br>
       <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Accounts</label>
                    <select class="form-control mt-multiselect btn btn-default" type="text" name="Accounts_PK" required>
                    <option value="">---Select---</option>
                    ';
                        $query_accounts = "SELECT * FROM tbl_service_logs_accounts where owner_pk = '$user_id' and  is_status = 0 order by name ASC";
                        $result_accounts = mysqli_query($conn, $query_accounts);
                        while($row_accounts = mysqli_fetch_array($result_accounts))
                             { 
                               echo '<option value="'.$row_accounts['id'].'" '; echo $row['Accounts_PK'] == $row_accounts['name'] ? 'selected':''; echo'>'.$row_accounts['name'].'</option>'; 
                           } 
                     echo '
                     <option value="0">Others</option> 
                </select>
                </div>
                <div class="col-md-6" >
                    <label>Status</label>
                    <select class="form-control" name="Project_status" required>
                        <option value="0" '; echo $row['Project_status'] == 0 ? 'selected' : ''; echo'>Not Started</option>
                        <option value="1" '; echo $row['Project_status'] == 1 ? 'selected' : ''; echo'>Inprogress</option>
                        <option value="2" '; echo $row['Project_status'] == 2 ? 'selected' : ''; echo'>Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
       <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Image/file <i style="color:#1746A2;font-size:12px;"> ( Sample/Supporting files )</i></label>
                    <a href="MyPro_Folder_Files/'.$row['Sample_Documents'].'" target="_blank"><input class="form-control" type="text" name="" value="'.$row['Sample_Documents'].'" readonly></a>
                </div>
                <div class="col-md-6" >
                <label>...</label>
                    <input class="form-control" type="file" name="Sample_Documents">
                    <input class="form-control" type="hidden" name="Sample_Documents2" value="'.$row['Sample_Documents'].'">
                </div>
            </div>
        </div>
       <br>
        <div class="row">
            <div class="form-group">
                 <div class="col-md-12">
                    <label>Descriptions</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" type="text" name="Project_Description" rows="4">'.$row['Project_Description'].'</textarea>
                </div>
            </div>
        </div>
       
        <br>
       <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input class="form-control" type="date" name="Start_Date" value="'.date("Y-m-d", strtotime($row['Start_Date'])).'">
                </div>
                <div class="col-md-6" >
                    <label>Desired Deliver Date</label>
                    <input class="form-control" type="date" name="Desired_Deliver_Date" value="'.date("Y-m-d", strtotime($row['Desired_Deliver_Date'])).'">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h4>Collaborator</h4>
            </div>
            <hr>
            <div class="col-md-12">
                
                <div class="form-group">
                    ';
                        
                        $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                        $resultCollab = mysqli_query($conn, $queryCollab);
                                                    
                        while($rowCollab = mysqli_fetch_array($resultCollab))
                        {
                            $array_collab = explode(", ", $row["Collaborator_PK"]); 
                            if(in_array($rowCollab['ID'],$array_collab))
                            echo '
                                <div class="col-md-3">
                                    <label>'.$rowCollab['first_name'].' '.$rowCollab['last_name'].'<label>
                                </div>
                            ';
                        }
                        
                        $queryQuest = "SELECT * FROM tbl_user where ID = $user_id";
                        $resultQuest = mysqli_query($conn, $queryQuest);
                        while($rowQuest = mysqli_fetch_array($resultQuest))
                             { 
                                 if(in_array($rowQuest['ID'],$array_collab))
                               echo '
                                    <div class="col-md-3">
                                        <label>'.$rowQuest['first_name'].' '.$rowQuest['last_name'].'<label>
                                    </div>
                                ';
                           }
                    echo '
                </div>
            </div>
        </div>
         <hr>
        <div class="row">
            <div class="col-md-12">
            <label>Add Collaborator</label>
                <div class="form-group">
                <select class="form-control mt-multiselect btn btn-default" type="text" name="Collaborator[]" multiple required>
                    <option value="">---Select---</option>
                    ';
                        
                        $queryCollab = "SELECT *  FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                        $resultCollab = mysqli_query($conn, $queryCollab);
                                                    
                        while($rowCollab = mysqli_fetch_array($resultCollab))
                        {
                            $array_busi = explode(", ", $row["Collaborator_PK"]); 
                        echo '<option value="'.$rowCollab['ID'].'" '; echo in_array($rowCollab['ID'], $array_busi) ? 'selected': ''; echo'>'.$rowCollab['first_name'].' '.$rowCollab['last_name'].'</option>';
                        }
                        // ID = 155 or ID = 308 or
                        $array_us = explode(", ", $row["Collaborator_PK"]); 
                        $queryQuest = "SELECT * FROM tbl_user where  ID = $user_id";
                        $resultQuest = mysqli_query($conn, $queryQuest);
                        while($rowQuest = mysqli_fetch_array($resultQuest))
                             { 
                                 
                               echo '<option value="'.$rowQuest['ID'].'" '; echo in_array($rowQuest['ID'], $array_us) ? 'selected': ''; echo'>'.$rowQuest['first_name'].' '.$rowQuest['last_name'].'</option>'; 
                           }
                    echo '
                     </select>
                </div>
            </div>
        </div>
        
        ';

        mysqli_close($conn);
	}

?>
