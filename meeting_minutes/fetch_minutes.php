<?php
	require '../database.php';
	
    $facility_switch_user_id = 0;
    if (isset($_COOKIE['facilityswitchAccount'])) {
        $facility_switch_user_id = $_COOKIE['facilityswitchAccount'];
    }
    $base_url = "https://interlinkiq.com/";
    
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
    
	// Get status only
    if (!empty($_COOKIE['switchAccount'])) {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = $_COOKIE['switchAccount'];
    	$current_userEmployerID = employerID($portal_user);
    }
    else {
    	$portal_user = $_COOKIE['ID'];
    	$user_id = employerID($portal_user);
    	$current_userEmployerID = employerID($portal_user);
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
    
    $facility_switch_user_id = 0;
    if (isset($_COOKIE['facilityswitchAccount'])) {
        $facility_switch_user_id = $_COOKIE['facilityswitchAccount'];
    } else {
        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $portal_user" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];
        
        if ($current_userEmployeeID > 0) {
            $selectEmployeeFacility = mysqli_query( $conn,"SELECT facility_switch FROM tbl_hr_employee WHERE facility_switch > 0 AND ID = $current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployeeFacility) > 0 ) {
                $rowEmployeeFacility = mysqli_fetch_array($selectEmployeeFacility);
                $facility_switch_user_id = $rowEmployeeFacility["facility_switch"];
            }
        } else {
            $selectSupplierFacility = mysqli_query( $conn,"SELECT facility_switch FROM tbl_supplier WHERE facility_switch > 0 AND email = '".$current_userEmail."'" );
            if ( mysqli_num_rows($selectSupplierFacility) > 0 ) {
                $rowSupplierFacility = mysqli_fetch_array($selectSupplierFacility);
                $facility_switch_user_id = $rowSupplierFacility["facility_switch"];
            }
        }
    }
    
if( isset($_GET['GetDetails']) ) {
	$ID = $_GET['GetDetails'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="meeting_id" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_meeting_minutes where id = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { ?>
          <!-- MODAL AREA-->
                      
        <div class="tabbable tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tabOpen" data-toggle="tab">Open</a>
                    </li>
                    <li>
                        <a href="#tabFollow" data-toggle="tab">Follow Up</a>
                    </li>
                    <li>
                        <a href="#tabClose" data-toggle="tab">Close</a>
                    </li>
                </ul>
                <div class="tab-content margin-top-20">
                    <div class="tab-pane active" id="tabOpen"> 
                        <a href="#modal_add_action_item" data-toggle="modal" class="btn green btn-xs" type="button" id="add_action" data-id="<?php echo $ID; ?>">Add Action items</a>
                        <table class="table table-bordered " >
                            <thead class="bg-primary">
                                <tr>
                                    <th>Action Details</th>
                                    <th>Assigned To</th>
                                    <th>Request Date</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="meeting_action_items">
                            <?php
                                       
                                $query_open = "SELECT * FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $ID and status = 'Open' order by inserted_at ASC";
                                $result_open = mysqli_query($conn, $query_open);
                                while($row_open = mysqli_fetch_array($result_open))
                                     { ?>
                                    <tr id="statusTbl_<?php echo $row_open['action_id'];  ?>">
                                        <td><?php echo $row_open['action_details'];  ?></td>
                                        <td>
                                            <?php
                                             $array_data = explode(", ", $row_open["assigned_to"]);
                                            $queryAssignto = "SELECT * FROM tbl_hr_employee  order by first_name ASC";
                                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                                 { 
                                                    if(in_array($rowAssignto['ID'],$array_data)){
                                                        echo$rowAssignto['first_name'];
                                                        
                                                    }
                                               }
                                            ?>
                                        </td>
                                        <td><?php echo $row_open['target_request_date']; ?></td>
                                        <td><?php echo $row_open['target_start_date']; ?></td>
                                        <td><?php echo $row_open['target_due_date']; ?></td>
                                        <td><?php echo $row_open['status']; ?></td>
                                        <td width="60px">
                                            <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $row_open['action_id']; ?>">
                                                <i class="icon-speech" style="font-size:16px;"></i>
                                                    <?php
                                                        $ai_id = $row_open['action_id'];
                                                        $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                                        foreach($comment_count as  $ccout){ 
                                                        if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                                        ?>
                                                             <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                                                <?= $ccout['count']; ?>
                                                            </b></span>
                                                       <?php }
                                                    ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-circle">
                                                <a href="#modal_update_status" data-toggle="modal" class="btn btn-info btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a>
                                                <a href="javascript:;" class="btn btn-danger btn-xs" onclick="btnDeleteAction(<?php echo $row_open['action_id']; ?>, this)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tabFollow">
                        <a href="#modal_add_action_item" data-toggle="modal" class="btn green btn-xs" type="button" id="add_action" data-id="<?php echo $ID; ?>">Add Action items</a>
                        <table class="table table-bordered " >
                            <thead class="bg-primary">
                                <tr>
                                    <th>Action Details</th>
                                    <th>Assigned To</th>
                                    <th>Request Date</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                       
                                $query_Follow = "SELECT * FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $ID and status = 'Follow Up' order by inserted_at ASC";
                                $result_Follow = mysqli_query($conn, $query_Follow);
                                while($row_Follow = mysqli_fetch_array($result_Follow))
                                     { ?>
                                    <tr id="statusTbl_<?php echo $row_Follow['action_id'];  ?>">
                                        <td><?php echo $row_Follow['action_details'];  ?></td>
                                        <td>
                                            <?php
                                             $array_data = explode(", ", $row_Follow["assigned_to"]);
                                            $queryAssignto = "SELECT * FROM tbl_hr_employee  order by first_name ASC";
                                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                                 { 
                                                    if(in_array($rowAssignto['ID'],$array_data)){
                                                        echo$rowAssignto['first_name'];
                                                        
                                                    }
                                               }
                                            ?>
                                        </td>
                                        <td><?php echo $row_Follow['target_request_date']; ?></td>
                                        <td><?php echo $row_Follow['target_start_date']; ?></td>
                                        <td><?php echo $row_Follow['target_due_date']; ?></td>
                                        <td><?php echo $row_Follow['status']; ?></td>
                                        <td width="60px">
                                            <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $row_Follow['action_id']; ?>">
                                                <i class="icon-speech" style="font-size:16px;"></i>
                                                    <?php
                                                        $ai_id = $row_Follow['action_id'];
                                                        $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                                        foreach($comment_count as  $ccout){ 
                                                        if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                                        ?>
                                                             <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                                                <?= $ccout['count']; ?>
                                                            </b></span>
                                                       <?php }
                                                    ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-circle">
                                                <a href="#modal_update_status" data-toggle="modal" class="btn btn-info btn-xs" type="button" id="add_status" data-id="<?php echo $row_Follow['action_id']; ?>" >Update</a>
                                                <a href="javascript:;" class="btn btn-danger btn-xs" onclick="btnDeleteAction(<?php echo $row_open['action_id']; ?>, this)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr id="meeting_action_items"></tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="tab-pane" id="tabClose">
                        <a href="#modal_add_action_item" data-toggle="modal" class="btn green btn-xs" type="button" id="add_action" data-id="<?php echo $ID; ?>">Add Action items</a>
                        <table class="table table-bordered " >
                            <thead class="bg-primary">
                                <tr>
                                    <th>Action Details</th>
                                    <th>Assigned To</th>
                                    <th>Request Date</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                       
                                $query_Close = "SELECT * FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $ID and status = 'Close' order by inserted_at ASC";
                                $result_Close = mysqli_query($conn, $query_Close);
                                while($row_Close = mysqli_fetch_array($result_Close))
                                     { ?>
                                    <tr id="statusTbl_<?php echo $row_Close['action_id'];  ?>">
                                        <td><?php echo $row_Close['action_details'];  ?></td>
                                        <td>
                                            <?php
                                             $array_data = explode(", ", $row_Close["assigned_to"]);
                                            $queryAssignto = "SELECT * FROM tbl_hr_employee  order by first_name ASC";
                                            $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                                 { 
                                                    if(in_array($rowAssignto['ID'],$array_data)){
                                                        echo$rowAssignto['first_name'];
                                                        
                                                    }
                                               }
                                            ?>
                                        </td>
                                        <td><?php echo $row_Close['target_request_date']; ?></td>
                                        <td><?php echo $row_Close['target_start_date']; ?></td>
                                        <td><?php echo $row_Close['target_due_date']; ?></td>
                                        <td><?php echo $row_Close['status']; ?></td>
                                        <td width="60px">
                                            <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $row_Close['action_id']; ?>">
                                                <i class="icon-speech" style="font-size:16px;"></i>
                                                <?php
                                                    $ai_id = $row_Close['action_id'];
                                                    $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                                    foreach($comment_count as  $ccout){ 
                                                    if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                                    ?>
                                                         <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                                            <?= $ccout['count']; ?>
                                                        </b></span>
                                                   <?php }
                                                ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-circle">
                                                <a href="#modal_update_status" data-toggle="modal" class="btn btn-info btn-xs" type="button" id="add_status" data-id="<?php echo $row_Close['action_id']; ?>" >Update</a>
                                                <a href="javascript:;" class="btn btn-danger btn-xs" onclick="btnDeleteAction(<?php echo $row_open['action_id']; ?>, this)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr id="meeting_action_items"></tr>
                            </tbody>
                        </table>  
                    </div>
            </div>
        </div>
    <?php } 
}
// add new parent
if( isset($_GET['postDetails']) ) {
	$ID = $_GET['postDetails'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="meeting_id" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_meeting_minutes where id = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { ?>
          <!-- MODAL AREA-->
                      
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tabMeeting" data-toggle="tab">Meeting Details</a>
                </li>
                <li>
                    <a href="#tabNote" data-toggle="tab">Notes</a>
                </li>
                <li>
                    <a href="#tabAction" data-toggle="tab">Action Items</a>
                </li>
                <li>
                    <a href="#tabReferences" data-toggle="tab">References</a>
                </li>
            </ul>
            <div class="tab-content margin-top-20">
                <div class="tab-pane active" id="tabMeeting">
                    
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="control-label">Account Name</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="account" required>
                                    <option value="0">---Select---</option>
                                    <?php
                                        $queryAcc = "SELECT * FROM tbl_service_logs_accounts order by name ASC";
                                    $resultAcc = mysqli_query($conn, $queryAcc);
                                    while($rowAcc = mysqli_fetch_array($resultAcc))
                                         { 
                                          echo '<option value="'.$rowAcc['name'].'" '; echo $rowAcc['name'] == $row_proj['account'] ? 'selected' : ''; echo'>'.$rowAcc['name'].'</option>'; 
                                      }
                                     ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Date</label>
                                <input class="form-control" type="date" name="meeting_date" value="<?php echo date('Y-m-d', strtotime($row_proj['meeting_date'])); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="control-label">From</label>
                                <input class="form-control" type="time" name="duration_start" value="<?php echo date('h:i:s', strtotime($row_proj["duration_start"])); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">to</label>
                                <input class="form-control" type="time" name="duration_end" value="<?php echo date('h:i:s', strtotime($row_proj["duration_end"])) ?>" required>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Agenda</label>
                                <textarea class="form-control"  name="agenda" ><?php echo $row_proj["agenda"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Attendees</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="attendees[]" multiple required>
                                    <option value="0">---Select---</option>
                                    <?php
                                        $array_data_attd = explode(", ", $row_proj["attendees"]);
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                         { 
                                          echo '<option value="'.$rowAssignto['ID'].'" '; if(in_array($rowAssignto['ID'],$array_data_attd)){echo 'selected';}else{echo '';} echo'>'.$rowAssignto['first_name'].'</option>'; 
                                      }
                                     ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="control-label">Guest</label>
                                <input class="form-control"  name="guest" value="<?php echo $row_proj['guest']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control"  name="guest_email" value="<?php echo $row_proj['guest_email']; ?>">
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Remarks</label>
                                <textarea class="form-control" name="remarks"><?php echo $row_proj['remarks']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="control-label">Presider</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="presider" required>
                                    <option value="0">---Select---</option>
                                    <?php
                                        $queryPres = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                    $resultPres = mysqli_query($conn, $queryPres);
                                    while($rowPres = mysqli_fetch_array($resultPres))
                                         { 
                                          echo '<option value="'.$rowPres['ID'].'" '; echo $row_proj['presider'] == $rowPres['ID'] ? 'selected' : ''; echo'>'.$rowPres['first_name'].'</option>'; 
                                      }
                                     ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Note Taker</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="note_taker" required>
                                    <option value="0">---Select---</option>
                                    <?php
                                    
                                        $queryTaker = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                    $resultTaker = mysqli_query($conn, $queryTaker);
                                    while($rowTaker = mysqli_fetch_array($resultTaker))
                                         { 
                                          echo '<option value="'.$rowTaker['ID'].'" '; echo $row_proj['note_taker'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].'</option>'; 
                                      }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="control-label">Verified by</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by" required>
                                    <option value="0">---Select---</option>
                                    <?php
                                        $queryVeri = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                    $resultVeri = mysqli_query($conn, $queryVeri);
                                    while($rowVeri = mysqli_fetch_array($resultVeri))
                                         { 
                                          echo '<option value="'.$rowVeri['ID'].'" '; echo $row_proj['verified_by'] == $rowVeri['ID'] ? 'selected' : ''; echo'>'.$rowVeri['first_name'].'</option>'; 
                                      }
                                     ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Approved by</label>
                                <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by" required>
                                    <option value="0">---Select---</option>
                                    <?php
                                        $queryAppr = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                    $resultAppr = mysqli_query($conn, $queryAppr);
                                    while($rowAppr = mysqli_fetch_array($resultAppr))
                                         { 
                                           echo '<option value="'.$rowAppr['ID'].'" '; echo $row_proj['approved_by'] == $rowAppr['ID'] ? 'selected' : ''; echo'>'.$rowAppr['first_name'].'</option>'; 
                                       }
                                     ?>
                                </select>
                            </div>
                        </div>
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_details" id="btnSave_details" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
                <div class="tab-pane" id="tabNote">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea class="form-control" type="text" name="discussion_notes" id="your_summernotes" rows="3"><?php echo $row_proj['discussion_notes']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                             <div class="table-responsive">
                                <table class="table table-bordered" >
                                    <thead>
                                        <th>Action Items</th>
                                        <th>Assign to</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody id="dynamic_field2">
                                        <tr>
                                            <td><input type="text" name="action_details[]" placeholder="Action Items" class="form-control action_list" /></td>
                                            <td>
                                                <select class="form-control name_list" type="text" name="assigned_to[]">
                                                    <option value="0">---Select---</option>
                                                    <?php
                                                        $query_App = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                                    $result_App = mysqli_query($conn, $query_App);
                                                    while($row_App = mysqli_fetch_array($result_App))
                                                         { 
                                                           echo '<option value="'.$row_App['ID'].'">'.$row_App['first_name'].'</option>'; 
                                                       }
                                                     ?>
                                                </select>
                                            </td>
                                            <td><input type="date" name="target_due_date[]" placeholder="Due Date" class="form-control duedate" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                                            <td>
                                                <select class="form-control status_s" type="text" name="status[]">
                                                    <option value="Open">Open</option>
                                                    <option value="Follow Up">Follow Up</option>
                                                    <option value="Close">Close</option>
                                                </select>
                                            </td>
                                            <td><button type="button" name="update_btn" id="update_btn" class="btn btn-success">Add</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_details" id="btnSave_details" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
                <div class="tab-pane" id="tabAction">
                    <a href="#modal_add_action_item" data-toggle="modal" class="btn green btn-xs" type="button" id="add_action" data-id="<?php echo $ID; ?>">Add Action Items</a>
                    <table class="table table-bordered " >
                        <thead class="bg-primary">
                            <tr>
                                <th>Action Details</th>
                                <th>Assigned To</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                   
                            $queryA = "SELECT * FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = '$ID' order by inserted_at ASC";
                            $resultA = mysqli_query($conn, $queryA);
                            while($rowA = mysqli_fetch_array($resultA))
                                 { ?>
                                <tr id="statusTbl_<?php echo $rowA['action_id'];  ?>">
                                    <td><?php echo $rowA['action_details'];  ?></td>
                                    <td>
                                        <?php
                                         $array_data = explode(", ", $rowA["assigned_to"]);
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee order by first_name ASC";
                                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                             { 
                                                if(in_array($rowAssignto['ID'],$array_data)){
                                                    echo$rowAssignto['first_name'].',';
                                                    
                                                }
                                           }
                                        ?>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($rowA['target_due_date'])); ?></td>
                                    <td><?php echo $rowA['status']; ?></td>
                                    <td width="60px">
                                            <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $rowA['action_id']; ?>">
                                                <i class="icon-speech" style="font-size:16px;"></i>
                                                    <?php
                                                        $ai_id = $rowA['action_id'];
                                                        $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                                        foreach($comment_count as  $ccout){ 
                                                        if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                                        ?>
                                                             <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                                                <?= $ccout['count']; ?>
                                                            </b></span>
                                                       <?php }
                                                    ?>
                                            </a>
                                        </td>
                                    <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $rowA['action_id']; ?>" >Update</a></td>
                                </tr>
                            <?php } ?>
                            <tr id="meeting_action_items"></tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tabReferences">
                    <a href="#modal_add_reference" data-toggle="modal" class="btn green btn-xs" type="button" id="add_reference" data-id="<?php echo $ID; ?>">Add Reference</a>
                    <table class="table table-bordered " >
                        <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                   
                            $queryr = "SELECT * FROM tbl_meeting_minutes_ref where meeting_id = '$ID' order by title_name ASC";
                        $resultr = mysqli_query($conn, $queryr);
                        while($rowr = mysqli_fetch_array($resultr))
                             { ?>
                            <tr>
                                <td><?php echo $rowr['title_name'];  ?></td>
                                <td><a href="meeting_references/<?php echo $rowr['file_docs'];  ?>" target="_blank"><?php echo $rowr['file_docs'];  ?></a></td>
                            </tr>
                            <?php } ?>
                            <tr id="meeting_ref"></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } 
}
if( isset($_POST['btnSave_details']) ) {
	
    $user_id = $user_id;
	$ID = $_POST['ID'];
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$aassign_to = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	$guest = mysqli_real_escape_string($conn,$_POST['guest']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
 	$guest_email = mysqli_real_escape_string($conn,$_POST['guest_email']);
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    if(!empty($_POST["attendees"]))
    {
        foreach($_POST["attendees"] as $attendees)
        {
            $aattendees .= $attendees.', ';
        }
         
    }
    $aattendees = substr($aattendees, 0, -2);
    $sql = "UPDATE tbl_meeting_minutes set user_ids='$user_id',account ='$account',meeting_date='$meeting_date',agenda='$agenda',duration_start='$duration_start',duration_end='$duration_end',attendees='$aattendees',remarks='$remarks',guest='$guest',verified_by='$verified_by',approved_by='$approved_by',discussion_notes='$discussion_notes',guest_email='$guest_email',presider='$presider',note_taker='$note_taker' where id = $ID";
    if(mysqli_query($conn, $sql)){
        $ID = $_POST['ID'];
        $action_details = count($_POST["action_details"]);
        if($action_details > 1)
        {
           for($i=0; $i<$action_details; $i++)
            {
                $assigned_to = $_POST["assigned_to"][$i];
                $target_due_date = $_POST["target_due_date"][$i];
                $status = $_POST["status"][$i];
                
                $sql2 = "INSERT INTO tbl_meeting_minutes_action_items(action_details,action_meeting_id,assigned_to,target_due_date,status) 
                VALUES('".mysqli_real_escape_string($conn, $_POST["action_details"][$i])."','$ID','$assigned_to','$target_due_date','$status')";
                mysqli_query($conn, $sql2);
                
            }
        }
      $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $ID;");
      if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
    <?php } }
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}

// add new parent
if( isset($_GET['postDetails2']) ) {
	$ID = $_GET['postDetails2'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="meeting_id" value="'. $ID .'" />
	    ';
	        $query_proj = "SELECT * FROM tbl_meeting_minutes where id = $ID";
            $result_proj = mysqli_query($conn, $query_proj);
            while($row_proj = mysqli_fetch_array($result_proj))
            { ?>
        <!-- MODAL AREA-->
                      
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tabMeeting" data-toggle="tab">Meeting Details</a>
                </li>
                <li>
                    <a href="#tabNote" data-toggle="tab">Notes</a>
                </li>
                <li>
                    <a href="#tabAction" data-toggle="tab">Action Items</a>
                </li>
                <li>
                    <a href="#tabReferences" data-toggle="tab">References</a>
                </li>
            </ul>
            <div class="tab-content margin-top-20">
                <div class="tab-pane active" id="tabMeeting">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Company Name</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="account" required>
                                <option value="0">---Select---</option>
                                <?php
                                    if($user_id == 34 || $_COOKIE['ID']== 450 ) {
                                        $queryAcc = "SELECT * FROM tbl_service_logs_accounts WHERE owner_pk = $user_id ORDER BY name ASC";
                                        $resultAcc = mysqli_query($conn, $queryAcc);
                                        while($rowAcc = mysqli_fetch_array($resultAcc)) { 
                                            echo '<option value="'.$rowAcc['name'].'" '; echo $rowAcc['name'] == $row_proj['account'] ? 'selected' : ''; echo'>'.$rowAcc['name'].'</option>'; 
                                        }
                                    }
                                    else if($user_id == 1687) {
                                        $queryAcc = "SELECT name FROM tbl_supplier WHERE user_id = $user_id AND page = 1 AND is_deleted = 0 ORDER BY name";
                                        $resultAcc = mysqli_query($conn, $queryAcc);
                                        while($rowAcc = mysqli_fetch_array($resultAcc)) { 
                                            echo '<option value="'.$rowAcc['name'].'" '; echo $rowAcc['name'] == $row_proj['account'] ? 'selected' : ''; echo'>'.$rowAcc['name'].'</option>'; 
                                        }
                                    }
                                    else if($user_id == 247){echo '<option value="SFI" '; echo $row_proj['account'] == "SFI" ? 'selected' : ''; echo'>SFI</option>'; }
                                    else if($user_id == 250){echo '<option value="SPI" '; echo $row_proj['account'] == "SPI" ? 'selected' : ''; echo'>SPI</option>'; }
                                    else if($user_id == 266){echo '<option value="RFP" '; echo $row_proj['account'] == "RFP" ? 'selected' : ''; echo'>RFP</option>'; }
                                    else if($user_id == 256){echo '<option value="KAV" '; echo $row_proj['account'] == "KAV" ? 'selected' : ''; echo'>KAV</option>'; }
                                    else if($user_id == 337){echo '<option value="HT" '; echo $row_proj['account'] == "HT" ? 'selected' : ''; echo'>HT</option>'; }
                                    else if($user_id == 308){echo '<option value="FWCC" '; echo $row_proj['account'] == "FWCC" ? 'selected' : ''; echo'>FWCC</option>'; }
                                    else if($user_id == 457){echo '<option value="PF" '; echo $row_proj['account'] == "PF" ? 'selected' : ''; echo'>PF</option>'; }
                                    else if($user_id == 253){echo '<option value="AFIA" '; echo $row_proj['account'] == "AFIA" ? 'selected' : ''; echo'>AFIA</option>'; }
                                    else if($user_id == 1362){echo '<option value="Longevity Nutra Inc." '; echo $row_proj['account'] == "Longevity Nutra Inc." ? 'selected' : ''; echo'>Longevity Nutra Inc.</option>'; }
                                    else if($user_id == 1486){echo '<option value="Marukan Vinegar (U.S.A.) Inc." SELECTED>Marukan Vinegar (U.S.A.) Inc.</option>'; }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Date</label>
                            <input class="form-control" type="date" name="meeting_date" value="<?php echo date('Y-m-d', strtotime($row_proj['meeting_date'])); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">From</label>
                            <input class="form-control" type="time" name="duration_start" value="<?php echo date('h:i:s', strtotime($row_proj["duration_start"])); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">to</label>
                            <input class="form-control" type="time" name="duration_end" value="<?php echo date('h:i:s', strtotime($row_proj["duration_end"])) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Agenda</label>
                            <div class="mt-checkbox-list">
                                <?php
                                    echo '<label class="mt-checkbox mt-checkbox-outline">Select All
                                        <input type="checkbox" onclick="checkedAll(this, \'Agenda\')" />
                                        <span></span>
                                    </label>';
                                    
                                    $array_data_agendas = explode(", ", $row_proj["agendas"]);
                                    $selectAgenda = mysqli_query($conn, "SELECT * FROM tbl_meeting_minutes_agenda WHERE deleted = 0 ORDER BY name");
                                    while($rowAgendas = mysqli_fetch_array($selectAgenda)) {
                                        echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAgendas['name'].'
                                            <input type="checkbox" class="Agenda" value="'.$rowAgendas['ID'].'" name="agendas[]"  '; echo in_array($rowAgendas['ID'], $array_data_agendas) ? 'checked' : ''; echo ' />
                                            <span></span>
                                        </label>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Other Agenda (If Applicable)</label>
                            <textarea class="form-control"  name="agenda"><?php echo $row_proj["agenda"]; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Attendees</label>
                            <div class="mt-checkbox-list">
                                <?php
                                    echo '<label class="mt-checkbox mt-checkbox-outline">Select All
                                        <input type="checkbox" onclick="checkedAll(this, \'Attendee\')" />
                                        <span></span>
                                    </label>';
                                    
                                    $array_data_attd = explode(", ", $row_proj["attendees"]);
                                    
                                    $queryAssignto = "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $user_id AND facility_switch = $facility_switch_user_id ORDER BY first_name ASC";
                                    if ($user_id == 1687) {
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id ORDER BY first_name ASC";
                                    }
                                    
                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                    while($rowAssignto = mysqli_fetch_array($resultAssignto)) {
                                        echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'
                                            <input type="checkbox" class="Attendee" value="'.$rowAssignto['ID'].'" name="attendees[]"  '; echo in_array($rowAssignto['ID'], $array_data_attd) ? 'checked' : ''; echo ' />
                                            <span></span>
                                        </label>';
                                    }
                                    
                                    if($user_id == 1362){
                                        $queryAttd = "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = 34 AND ID IN (83, 71, 69, 129, 72, 80, 209) ORDER BY first_name ASC";
                                        $resultAttd = mysqli_query($conn, $queryAttd);
                                        while($rowAttd = mysqli_fetch_array($resultAttd)) {
                                            echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAttd['first_name'].' '.$rowAttd['last_name'].'
                                                <input type="checkbox" class="Attendee" value="'.$rowAttd['ID'].'" name="attendees[]"  '; echo in_array($rowAttd['ID'], $array_data_attd) ? 'checked' : ''; echo ' />
                                                <span></span>
                                            </label>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                        <div class="col-md-12">
                            <label class="control-label">Compliance Team</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="attendees_compliance[]" multiple >
                                <option value="0">---Select---</option>
                                <?php
                                    $array_data_attd = explode(", ", $row_proj["attendees_compliance"]);
                                    $queryAssignto = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                    while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                        echo '<option value="'.$rowAssignto['ID'].'" '; if(in_array($rowAssignto['ID'],$array_data_attd)){echo 'selected';}else{echo '';} echo'>'.$rowAssignto['first_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" >
                            <thead>
                                <th>Guest</th>
                                <th>Email</th>
                                <th></th>
                            </thead>
                            <tbody id="dynamic_field_guest2">
                                
                            <?php 
                            $array_guest = explode(", ", $row_proj["guest"]);
                            $array_guestmail = explode(", ", $row_proj["guest_email"]);
                            for ($x = 0; $x < count($array_guest); $x++){
                                $guest_mail = $array_guestmail[$x];
                                $guest_name = $array_guest[$x];
                            ?>
                                
                                <tr>
                                    <td>
                                        <input class="form-control"  name="guest[]" value="<?= $guest_name; ?>">
                                    </td>
                                    <td>
                                        <input type="email" class="form-control"  name="guest_email[]" value="<?= $guest_mail; ?>">
                                    </td>
                                    <td><button type="button" name="update_guest" id="update_guest" class="btn btn-success">Add</button></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Remarks (If Applicable)</label>
                            <textarea class="form-control" name="remarks"><?php echo $row_proj['remarks']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Presider</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="presider" required>
                                <option value="0">---Select---</option>
                                <?php
                                    if (isset($_COOKIE['switchAccount'])) {
                                        $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                        $resultPres = mysqli_query($conn, $queryPres);
                                        while($rowPres = mysqli_fetch_array($resultPres)) { 
                                            echo '<option value="'.$rowPres['ID'].'" '; echo $row_proj['presider'] == $rowPres['ID'] ? 'selected' : ''; echo'>'.$rowPres['first_name'].' '.$rowPres['last_name'].'</option>'; 
                                        }
                                    } else {
                                        if ($current_userEmployerID != 34) {
                                            $main_id = $row_proj['presider'];
                                            $queryPres = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND ID = $main_id" );
                                            if ( mysqli_num_rows($queryPres) > 0 ) {
                                                echo '<option value="'.$main_id.'" SELECTED>Compliance team/option>'; 
                                            }
                                        }
                                    }
                                    
                                    $queryPres = "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $user_id  AND facility_switch = $facility_switch_user_id ORDER BY first_name ASC";
                                    if ($user_id == 1687) {
                                        $queryPres = "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = 34  AND facility_switch = $facility_switch_user_id ORDER BY first_name ASC";
                                    }
                                    
                                    $resultPres = mysqli_query($conn, $queryPres);
                                    while($rowPres = mysqli_fetch_array($resultPres)) { 
                                        echo '<option value="'.$rowPres['ID'].'" '; echo $row_proj['presider'] == $rowPres['ID'] ? 'selected' : ''; echo'>'.$rowPres['first_name'].' '.$rowPres['last_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                            <label class="control-label">Presider Compliance Team</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="presider_compliance">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID or user_id = 34 order by first_name ASC";
                                    $resultPres = mysqli_query($conn, $queryPres);
                                    while($rowPres = mysqli_fetch_array($resultPres)) { 
                                        echo '<option value="'.$rowPres['ID'].'" '; echo $row_proj['presider'] == $rowPres['ID'] ? 'selected' : ''; echo'>'.$rowPres['first_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Note Taker</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="note_taker" required>
                                <option value="0">---Select---</option>
                                <?php
                                    if (isset($_COOKIE['switchAccount'])) {
                                        $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                        $resultTaker = mysqli_query($conn, $queryTaker);
                                        while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                            echo '<option value="'.$rowTaker['ID'].'" '; echo $row_proj['note_taker'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].' '.$rowTaker['last_name'].'</option>'; 
                                        }
                                    } else {
                                        if ($current_userEmployerID != 34) {
                                            $main_id = $row_proj['note_taker'];
                                            $queryPres = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND ID = $main_id" );
                                            if ( mysqli_num_rows($queryPres) > 0 ) {
                                                echo '<option value="'.$main_id.'" SELECTED>Compliance team</option>'; 
                                            }
                                        }
                                    }
                                    
                                    $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    if ($user_id == 1687) {
                                        $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    }
                                    
                                    $resultTaker = mysqli_query($conn, $queryTaker);
                                    while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                        echo '<option value="'.$rowTaker['ID'].'" '; echo $row_proj['note_taker'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].' '.$rowTaker['last_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                            <label class="control-label">Note Taker Compliance Team</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="note_taker_compliance">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                    $resultTaker = mysqli_query($conn, $queryTaker);
                                    while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                        echo '<option value="'.$rowTaker['ID'].'" '; echo $row_proj['note_taker'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Verified by</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by" required>
                                <option value="0">---Select---</option>
                                <?php
                                    if (isset($_COOKIE['switchAccount'])) {
                                        $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                        $resultVeri = mysqli_query($conn, $queryVeri);
                                        while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                            echo '<option value="'.$rowVeri['ID'].'" '; echo $row_proj['verified_by'] == $rowVeri['ID'] ? 'selected' : ''; echo'>'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                        }
                                    } else {
                                        if ($current_userEmployerID != 34) {
                                            $main_id = $row_proj['verified_by'];
                                            $queryPres = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND ID = $main_id" );
                                            if ( mysqli_num_rows($queryPres) > 0 ) {
                                                echo '<option value="'.$main_id.'" SELECTED>Compliance team</option>'; 
                                            }
                                        }
                                    }
                                    
                                    $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    if ($user_id == 1687) {
                                        $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    }
                                    
                                    $resultVeri = mysqli_query($conn, $queryVeri);
                                    while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                        echo '<option value="'.$rowVeri['ID'].'" '; echo $row_proj['verified_by'] == $rowVeri['ID'] ? 'selected' : ''; echo'>'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                            <label class="control-label">Verified by Compliance Team</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by_compliance">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                    $resultVeri = mysqli_query($conn, $queryVeri);
                                    while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                        echo '<option value="'.$rowVeri['ID'].'" '; echo $row_proj['verified_by'] == $rowVeri['ID'] ? 'selected' : ''; echo'>'.$rowVeri['first_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Approved by</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by" required>
                                <option value="0">---Select---</option>
                                <?php
                                    if (isset($_COOKIE['switchAccount'])) {
                                        $queryAppr = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                        $resultAppr = mysqli_query($conn, $queryAppr);
                                        while($rowAppr = mysqli_fetch_array($resultAppr)) { 
                                            echo '<option value="'.$rowAppr['ID'].'" '; echo $row_proj['approved_by'] == $rowAppr['ID'] ? 'selected' : ''; echo'>'.$rowAppr['first_name'].' '.$rowAppr['last_name'].'</option>'; 
                                        }
                                    } else {
                                        if ($current_userEmployerID != 34) {
                                            $main_id = $row_proj['approved_by'];
                                            $queryPres = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND ID = $main_id" );
                                            if ( mysqli_num_rows($queryPres) > 0 ) {
                                                echo '<option value="'.$main_id.'" SELECTED>Compliance team</option>'; 
                                            }
                                        }
                                    }
                                    
                                    $queryAppr = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    if ($user_id == 1687) {
                                        $queryAppr = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                    }
                                    
                                    $resultAppr = mysqli_query($conn, $queryAppr);
                                    while($rowAppr = mysqli_fetch_array($resultAppr)) { 
                                        echo '<option value="'.$rowAppr['ID'].'" '; echo $row_proj['approved_by'] == $rowAppr['ID'] ? 'selected' : ''; echo'>'.$rowAppr['first_name'].' '.$rowAppr['last_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                            <label class="control-label">Approved by Compliance Team</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by_compliance">
                                <option value="0">---Select---</option>
                                <?php
                                    $queryAppr = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                    $resultAppr = mysqli_query($conn, $queryAppr);
                                    while($rowAppr = mysqli_fetch_array($resultAppr)) { 
                                        echo '<option value="'.$rowAppr['ID'].'" '; echo $row_proj['approved_by'] == $rowAppr['ID'] ? 'selected' : ''; echo'>'.$rowAppr['first_name'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_details2" id="btnSave_details2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
                <div class="tab-pane" id="tabNote">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Notes</label>
                            <textarea class="form-control" type="text" name="discussion_notes" id="your_summernotes" rows="3"><?php echo $row_proj['discussion_notes']; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                         <div class="table-responsive">
                            <table class="table table-bordered" >
                                <tbody id="dynamic_field2">
                                    <tr>
                                        <td>
                                            <label class="control-label">Action Item</label>
                                            <input class="form-control action_list" name="action_details[]" placeholder="Action Items">
                                        </td>
                                        <td>
                                            <label class="control-label">Assigned To</label>
                                            <select class="form-control name_list" type="text" name="assigned_to[]">
                                                <option value="0">---Select---</option>
                                                <?php
                                                    $result_App = mysqli_query($conn, "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $user_id AND facility_switch = $facility_switch_user_id order by first_name ASC");
                                                    if ($user_id == 1687) {
                                                        $result_App = mysqli_query($conn, "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC");
                                                    }
                                                    
                                                    while($row_App = mysqli_fetch_array($result_App)) { 
                                                       echo '<option value="'.$row_App['ID'].'">'.$row_App['first_name'].'</option>'; 
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <label class="control-label">Status</label>
                                            <select class="form-control status_s" type="text" name="status[]">
                                                <option value="Open">Open</option>
                                                <option value="Follow Up">Follow Up</option>
                                                <option value="Close">Close</option>
                                            </select>
                                        </td>
                                        <td rowspan="2" style="text-align: center; vertical-align: middle;"><button type="button" name="update_btn" id="update_btn" class="btn btn-success">Add</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">Request Date</label>
                                            <input type="date" name="target_request_date[]" placeholder="Request Date" class="form-control requestdate" value="<?= date('Y-m-d'); ?>">
                                        </td>
                                        <td>
                                            <label class="control-label">Start Date</label>
                                            <input type="date" name="target_start_date[]" placeholder="Start Date" class="form-control startdate" value="<?= date('Y-m-d'); ?>">
                                        </td>
                                        <td>
                                            <label class="control-label">Due Date</label>
                                            <input type="date" name="target_due_date[]" placeholder="Due Date" class="form-control duedate" value="<?= date('Y-m-d'); ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_details2" id="btnSave_details2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
                <div class="tab-pane" id="tabAction">
                    <a href="#modal_add_action_item" data-toggle="modal" class="btn green btn-xs hide" type="button" id="add_action" data-id="<?php echo $ID; ?>">Add Action Items</a>
                    <table class="table table-bordered " >
                        <thead class="bg-primary">
                            <tr>
                                <th>Action Details</th>
                                <th>Assigned To</th>
                                <th>Request Date</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                   
                            $queryA = "SELECT * FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = '$ID' order by inserted_at ASC";
                            $resultA = mysqli_query($conn, $queryA);
                            while($rowA = mysqli_fetch_array($resultA)) { ?>
                                <tr id="statusTbl_<?php echo $rowA['action_id'];  ?>">
                                    <td><?php echo $rowA['action_details'];  ?></td>
                                    <td>
                                        <?php
                                         $array_data = explode(", ", $rowA["assigned_to"]);
                                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                             { 
                                                if(in_array($rowAssignto['ID'],$array_data)){
                                                    echo$rowAssignto['first_name'].',';
                                                    
                                                }
                                           }
                                        ?>
                                    </td>
                                    <td><?php echo $rowA['target_request_date']; ?></td>
                                    <td><?php echo $rowA['target_start_date']; ?></td>
                                    <td><?php echo $rowA['target_due_date']; ?></td>
                                    <td><?php echo $rowA['status']; ?></td>
                                    <td width="60px">
                                        <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $rowA['action_id']; ?>">
                                            <i class="icon-speech" style="font-size:16px;"></i>
                                                <?php
                                                    $ai_id = $rowA['action_id'];
                                                    $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                                    foreach($comment_count as  $ccout){ 
                                                    if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                                    ?>
                                                         <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                                            <?= $ccout['count']; ?>
                                                        </b></span>
                                                   <?php }
                                                ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-circle">
                                            <a href="#modal_update_status" data-toggle="modal" class="btn btn-info btn-xs" type="button" id="add_status" data-id="<?php echo $rowA['action_id']; ?>" >Update</a>
                                            <a href="javascript:;" class="btn btn-danger btn-xs" onclick="btnDeleteAction(<?php echo $rowA['action_id']; ?>, this)">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="meeting_action_items"></tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tabReferences">
                    <a href="#modal_add_reference" data-toggle="modal" class="btn green btn-xs" type="button" id="add_reference" data-id="<?php echo $ID; ?>">Add Reference</a>
                    <table class="table table-bordered " id="meeting_ref">
                        <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>Documents</th>
                                <th class="text-center" style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $resultr = mysqli_query($conn, "SELECT * FROM tbl_meeting_minutes_ref WHERE deleted = 0 AND meeting_id = '$ID' order by title_name ASC");
                                while($rowr = mysqli_fetch_array($resultr)) {
                                    // echo '<tr>
                                    //     <td>'.$rowr['title_name'].'</td>
                                    //     <td><a href="meeting_references/'.$rowr['file_docs'].'" target="_blank">'.$rowr['file_docs'].'</a></td>
                                    //     <td class="text-center"><a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('.$rowr['ref_id'].', this)">Delete</a></td>
                                    // </tr>';
                                
                                    $datafancybox = 'data-fancybox';
                                    $files = htmlentities($rowr['file_docs'] ?? '');
                                    $fileExtension = fileExtension($files);
                                    $src = $fileExtension['src'];
                                    $embed = $fileExtension['embed'];
                                    $type = $fileExtension['type'];
                                    $file_extension = $fileExtension['file_extension'];
                                    $url = $base_url.'meeting_references/';

                                    $files = $src.$url.rawurlencode($files).$embed;
                                    
                                    echo '<tr>
                                        <td>'.$rowr['title_name'].'</td>
                                        <td><a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-link">'.$rowr['file_docs'].'</a></td>
                                        <td class="text-center"><a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('.$rowr['ref_id'].', this)">Delete</a></td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } 
}
if( isset($_GET['btnDelete_Ref']) ) {
    $id = $_GET['btnDelete_Ref'];
    mysqli_query( $conn,"UPDATE tbl_meeting_minutes_ref SET deleted = 1 WHERE ref_id = $id" );
}
if( isset($_GET['btnDelete_Action']) ) {
    $id = $_GET['btnDelete_Action'];
    mysqli_query( $conn,"UPDATE tbl_meeting_minutes_action_items SET deleted = 1 WHERE action_id = $id" );
}
if( isset($_POST['btnSave_details2']) ) {
	
    $user_id = $user_id;
	$ID = $_POST['ID'];
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$attendees_compliance = '';
 	$aassign_to = '';
 	$gguest = '';
 	$gguest_email = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$presider_compliance = mysqli_real_escape_string($conn,$_POST['presider_compliance']);
 	$note_taker_compliance = mysqli_real_escape_string($conn,$_POST['note_taker_compliance']);
 	$verified_by_compliance = mysqli_real_escape_string($conn,$_POST['verified_by_compliance']);
 	$approved_by_compliance = mysqli_real_escape_string($conn,$_POST['approved_by_compliance']);
 	
    $agendas = '';
    if (!empty($_POST['agendas'])) {
        $agendas = implode(", ",$_POST['agendas']);
    }
    
    if(!empty($_POST["attendees"])) {
        foreach($_POST["attendees"] as $attendees) {
            $aattendees .= $attendees.', ';
        }
    }
    if(!empty($_POST["attendees_compliance"])) {
        foreach($_POST["attendees_compliance"] as $attendees_compliances) {
            $attendees_compliance .= $attendees_compliances.', ';
        }
    }
    if(!empty($_POST["guest"])) {
        foreach($_POST["guest"] as $guest) {
            $gguest .= $guest.', ';
        }
        foreach($_POST["guest_email"] as $guest_email) {
            $gguest_email .= $guest_email.', ';
        }
    }
    $aattendees = substr($aattendees, 0, -2);
    $attendees_compliance = substr($attendees_compliance, 0, -2);
    $gguest = substr($gguest, 0, -2);
    $gguest_email = substr($gguest_email, 0, -2);
    $sql = "UPDATE tbl_meeting_minutes set user_ids='$user_id',account ='$account',meeting_date='$meeting_date',agendas='$agendas',agenda='$agenda',duration_start='$duration_start',duration_end='$duration_end',attendees='$aattendees',attendees_compliance='$attendees_compliance',remarks='$remarks',guest='$gguest',discussion_notes='$discussion_notes',guest_email='$gguest_email',presider='$presider',note_taker='$note_taker',verified_by='$verified_by',approved_by='$approved_by',presider_compliance='$presider_compliance',note_taker_compliance='$note_taker_compliance',verified_by_compliance='$verified_by_compliance',approved_by_compliance='$approved_by_compliance' where id = $ID";
    if(mysqli_query($conn, $sql)){
        $ID = $_POST['ID'];
        $action_details = count($_POST["action_details"]);
        if($action_details > 0) {
            for($i=0; $i<$action_details; $i++) {
                $assigned_to = $_POST["assigned_to"][$i];
                $target_request_date = $_POST["target_request_date"][$i];
                $target_start_date = $_POST["target_start_date"][$i];
                $target_due_date = $_POST["target_due_date"][$i];
                $status = $_POST["status"][$i];
                
                $sql2 = "INSERT INTO tbl_meeting_minutes_action_items(action_details,action_meeting_id,assigned_to,target_request_date,target_start_date,target_due_date,status) 
                VALUES('".mysqli_real_escape_string($conn, $_POST["action_details"][$i])."','$ID','$assigned_to','$target_request_date','$target_start_date','$target_due_date','$status')";
                mysqli_query($conn, $sql2);
                
            }
        }
        $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $ID;");
        if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
    <?php } }
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}

// new added
if( isset($_POST['btnNew_details']) ) {
	
    $user_id = $user_id;
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$aassign_to = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	$guest = mysqli_real_escape_string($conn,$_POST['guest']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
 	$guest_email = mysqli_real_escape_string($conn,$_POST['guest_email']);
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    if(!empty($_POST["attendees"]))
    {
        foreach($_POST["attendees"] as $attendees)
        {
            $aattendees .= $attendees.', ';
        }
         
    }
    $aattendees = substr($aattendees, 0, -2);
    $sql = "INSERT INTO tbl_meeting_minutes (account,meeting_date,duration_start,duration_end,agenda,remarks,guest,verified_by,approved_by,discussion_notes,guest_email,presider,note_taker,attendees,user_ids) 
    VALUES ('$account','$meeting_date','$duration_start','$duration_end','$agenda','$remarks','$guest','$verified_by','$approved_by','$discussion_notes','$guest_email','$presider','$note_taker','$aattendees','$user_id')";
    if(mysqli_query($conn, $sql)){
        $last_id = mysqli_insert_id($conn);
      $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $last_id;");
      if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
        <tr>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
         </tr>
    <?php 
            $account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
    $agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
    $presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$query_Pres = "SELECT * FROM tbl_hr_employee where ID = $presider  order by first_name ASC";
    $result_Pres = mysqli_query($conn, $query_Pres);
    while($row_Pres = mysqli_fetch_array($result_Pres))
         { 
             $Pres = $row_Pres['first_name'];
             $Pres_email = $row_Pres['email'];
         }
    
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    $query_taker = "SELECT * FROM tbl_hr_employee where ID = $note_taker order by first_name ASC";
    $result_taker = mysqli_query($conn, $query_taker);
    while($row_taker = mysqli_fetch_array($result_taker))
         { 
             $taker_name = $row_taker['first_name'];
             $taker_mail = $row_taker['email'];
         }
 	
    $query_mail = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_mail = mysqli_query($conn, $query_mail);
     $user = 'interlinkiq.com';
           $from = $taker_mail;
           $to = $taker_mail;
           $subject = 'MINUTES OF THE MEETING -'.$account;
           $body = '
                    <br>
                    <b>Date: </b>
                    '.$meeting_date.'
                    <br>
                    <br>
                    <b>Start time: </b>
                    '.date('h:i:s a', strtotime($duration_start)).' / CST
                    <br>
                    <br>
                    <b>End time: </b>
                    '.date('h:i:s a', strtotime($duration_end)).' / CST
                    <br>
                    <br>
                    <b>Agenda: </b>
                    '.$agenda.'
                    <br>
                    <br>
                    <b>Lead Presider: </b>
                    '.$Pres.'
                    <br>
                    <br>
                    <b>Note taker: </b>
                    '.$taker_name.'
                    <br>
                    <br>
                    <b>Notes</b> <br>
                    '.$discussion_notes.'
        
                    <br><br><br>
                    <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
            $mail = php_mailer($from, $to, $user, $subject, $body);
    
     $array_data_mail = explode(", ", $row["attendees"]);
    $query_multi = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
    $result_multi = mysqli_query($conn, $query_multi);
    while($row__multi = mysqli_fetch_array($result_multi))
         { 
            if(in_array($row__multi['ID'],$array_data_mail)){ $attd = $row__multi['email'];
                $user = 'interlinkiq.com';
               $from = $taker_mail;
               $to = $attd;
               $subject = 'MINUTES OF THE MEETING -'.$account;
               $body = '
                        <br>
                        <b>Date: </b>
                        '.$meeting_date.'
                        <br>
                        <br>
                        <b>Start time: </b>
                        '.date('h:i:s a', strtotime($duration_start)).' / CST
                        <br>
                        <br>
                        <b>End time: </b>
                        '.date('h:i:s a', strtotime($duration_end)).' / CST
                        <br>
                        <br>
                        <b>Agenda: </b>
                        '.$agenda.'
                        <br>
                        <br>
                        <b>Lead Presider: </b>
                        '.$Pres.'
                        <br>
                        <br>
                        <b>Note taker: </b>
                        '.$taker_name.'
                        <br>
                        <br>
                        <b>Notes</b> <br>
                        '.$discussion_notes.'
            
                        <br><br><br>
                        <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
                $mail = php_mailer2($from, $to, $user, $subject, $body);
            }
       
            
         }
        } }
   
	
         
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}

// new added 2
if( isset($_POST['btnNew_added']) ) {
	
    $user_id = $user_id;
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$aassign_to = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	$agenda_mail = $_POST['agenda'];
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
 	$guest = mysqli_real_escape_string($conn,$_POST['guest']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
 	$guest_email = mysqli_real_escape_string($conn,$_POST['guest_email']);
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    if(!empty($_POST["attendees"]))
    {
        foreach($_POST["attendees"] as $attendees)
        {
            $aattendees .= $attendees.', ';
        }
         
    }
    $aattendees = substr($aattendees, 0, -2);
    $sql = "INSERT INTO tbl_meeting_minutes (account,meeting_date,duration_start,duration_end,agenda,remarks,guest,verified_by,approved_by,discussion_notes,guest_email,presider,note_taker,attendees,user_ids) 
    VALUES ('$account','$meeting_date','$duration_start','$duration_end','$agenda','$remarks','$guest','$verified_by','$approved_by','$discussion_notes','$guest_email','$presider','$note_taker','$aattendees','$user_id')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $action_details = count($_POST["action_details"]);
        if($action_details > 1)
        {
           for($i=0; $i<$action_details; $i++)
            {
                $assigned_to = $_POST["assigned_to"][$i];
                $target_due_date = $_POST["target_due_date"][$i];
                $status = $_POST["status"][$i];
                
                $sql2 = "INSERT INTO tbl_meeting_minutes_action_items(action_details,action_meeting_id,assigned_to,target_due_date,status) 
                VALUES('".mysqli_real_escape_string($conn, $_POST["action_details"][$i])."','$last_id','$assigned_to','$target_due_date','$status')";
                mysqli_query($conn, $sql2);
                
            }
        }
        
      $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $last_id;");
      if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
        <tr>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
         </tr>
    
    <?php 
    
    
    $account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
    $agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
    $agenda_mail = $_POST['agenda'];
    $presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$query_Pres = "SELECT * FROM tbl_hr_employee where ID = $presider  order by first_name ASC";
    $result_Pres = mysqli_query($conn, $query_Pres);
    while($row_Pres = mysqli_fetch_array($result_Pres))
         { 
             $Pres = $row_Pres['first_name'];
             $Pres_email = $row_Pres['email'];
         }
    
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    $query_taker = "SELECT * FROM tbl_hr_employee where ID = $note_taker order by first_name ASC";
    $result_taker = mysqli_query($conn, $query_taker);
    while($row_taker = mysqli_fetch_array($result_taker))
         { 
             $taker_name = $row_taker['first_name'];
             $taker_mail = $row_taker['email'];
         }
 	
    $query_mail = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_mail = mysqli_query($conn, $query_mail);
     $user = 'interlinkiq.com';
           $from = $taker_mail;
           $to = $taker_mail;
           $subject = 'MINUTES OF THE MEETING -'.$account;
           $body = '
                    <br>
                    <b>Date: </b>
                    '.$meeting_date.'
                    <br>
                    <br>
                    <b>Start time: </b>
                    '.date('h:i:s a', strtotime($duration_start)).' / CST
                    <br>
                    <br>
                    <b>End time: </b>
                    '.date('h:i:s a', strtotime($duration_end)).' / CST
                    <br>
                    <br>
                    <b>Agenda: </b>
                    '.$agenda_mail.'
                    <br>
                    <br>
                    <b>Lead Presider: </b>
                    '.$Pres.'
                    <br>
                    <br>
                    <b>Note taker: </b>
                    '.$taker_name.'
                    <br>
                    <br>
                    <b>Notes</b> <br>
                    '.$discussion_notes.'
        
                    <br><br><br>
                    <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
            $mail = php_mailer($from, $to, $user, $subject, $body);
    
     $array_data_mail = explode(", ", $row["attendees"]);
    $query_multi = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_multi = mysqli_query($conn, $query_multi);
    while($row__multi = mysqli_fetch_array($result_multi))
         { 
            if(in_array($row__multi['ID'],$array_data_mail)){ $attd = $row__multi['email'];
                $user = 'interlinkiq.com';
               $from = $taker_mail;
               $to = $attd;
               $subject = 'MINUTES OF THE MEETING -'.$account;
               $body = '
                        <br>
                        <b>Date: </b>
                        '.$meeting_date.'
                        <br>
                        <br>
                        <b>Start time: </b>
                        '.date('h:i:s a', strtotime($duration_start)).' / CST
                        <br>
                        <br>
                        <b>End time: </b>
                        '.date('h:i:s a', strtotime($duration_end)).' / CST
                        <br>
                        <br>
                        <b>Agenda: </b>
                        '.$agenda_mail.'
                        <br>
                        <br>
                        <b>Lead Presider: </b>
                        '.$Pres.'
                        <br>
                        <br>
                        <b>Note taker: </b>
                        '.$taker_name.'
                        <br>
                        <br>
                        <b>Notes</b> <br>
                        '.$discussion_notes.'
            
                        <br><br><br>
                        <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
                $mail = php_mailer2($from, $to, $user, $subject, $body);
            }
       
            
         }
        } }
   
	
         
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}

// new added 2
if( isset($_POST['btnNew_added2']) ) {
	
	$cookie = $_COOKIE['ID'];
    $user_id = $user_id;
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$attendees_compliance = '';
 	$gguest = '';
 	$aassign_to = '';
 	$gguest_email = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	$agenda_mail = $_POST['agenda'];
 	
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
    // $guest = mysqli_real_escape_string($conn,$_POST['guest']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	$body_email = $_POST['discussion_notes'];
 	
    // $guest_email = mysqli_real_escape_string($conn,$_POST['guest_email']);
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$presider_compliance = mysqli_real_escape_string($conn,$_POST['presider_compliance']);
 	$note_taker_compliance = mysqli_real_escape_string($conn,$_POST['note_taker_compliance']);
 	$verified_by_compliance = mysqli_real_escape_string($conn,$_POST['verified_by_compliance']);
 	$approved_by_compliance = mysqli_real_escape_string($conn,$_POST['approved_by_compliance']);
 	
    $agendas = '';
    if (!empty($_POST['agendas'])) {
        $agendas = implode(", ",$_POST['agendas']);
    }
    
    if(!empty($_POST["attendees"])) {
        foreach($_POST["attendees"] as $attendees) {
            $aattendees .= $attendees.', ';
        }
    }
    if(!empty($_POST["attendees_compliance"])) {
        foreach($_POST["attendees_compliance"] as $attendees_compliances) {
            $attendees_compliance .= $attendees_compliances.', ';
        }
    }
    if(!empty($_POST["guest"])) {
        foreach($_POST["guest"] as $guest) {
            $gguest .= $guest.', ';
        }
        foreach($_POST["guest_email"] as $guest_email) {
            $gguest_email .= $guest_email.', ';
        }
    }
    $aattendees = substr($aattendees, 0, -2);
    $attendees_compliance = substr($attendees_compliance, 0, -2);
    $gguest = substr($gguest, 0, -2);
    $gguest_email = substr($gguest_email, 0, -2);
    $sql = "INSERT INTO tbl_meeting_minutes (account,meeting_date,duration_start,duration_end,agendas,agenda,remarks,guest,discussion_notes,guest_email,presider,note_taker,verified_by,approved_by,presider_compliance,note_taker_compliance,verified_by_compliance,approved_by_compliance,attendees,attendees_compliance,user_ids,facility_switch,added_by_id) 
    VALUES ('$account','$meeting_date','$duration_start','$duration_end','$agendas','$agenda','$remarks','$gguest','$discussion_notes','$gguest_email','$presider','$note_taker','$verified_by','$approved_by','$presider_compliance','$note_taker_compliance','$verified_by_compliance','$approved_by_compliance','$aattendees','$attendees_compliance','$user_id','$facility_switch_user_id','$cookie')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $action_details = count($_POST["action_details"]);
        if($action_details > 1)
        {
           for($i=0; $i<$action_details; $i++)
            {
                $assigned_to = $_POST["assigned_to"][$i];
                $target_request_date = $_POST["target_request_date"][$i];
                $target_start_date = $_POST["target_start_date"][$i];
                $target_due_date = $_POST["target_due_date"][$i];
                $status = $_POST["status"][$i];
                
                $sql2 = "INSERT INTO tbl_meeting_minutes_action_items(action_details,action_meeting_id,assigned_to,target_request_date,target_start_date,target_due_date,status) 
                VALUES('".mysqli_real_escape_string($conn, $_POST["action_details"][$i])."','$last_id','$assigned_to','$target_request_date','$target_start_date','$target_due_date','$status')";
                mysqli_query($conn, $sql2);
            }
        }
        
      $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $last_id;");
      if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
        <tr>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
         </tr>
    
    <?php 
    
    
    $account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
    $agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
    $agenda_mail = $_POST['agenda'];
    $presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$query_Pres = "SELECT * FROM tbl_hr_employee where ID = $presider order by first_name ASC";
    $result_Pres = mysqli_query($conn, $query_Pres);
    while($row_Pres = mysqli_fetch_array($result_Pres))
         { 
             $Pres = $row_Pres['first_name'];
             $Pres_email = $row_Pres['email'];
         }
    
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    $query_taker = "SELECT * FROM tbl_hr_employee where ID = $note_taker order by first_name ASC";
    $result_taker = mysqli_query($conn, $query_taker);
    while($row_taker = mysqli_fetch_array($result_taker))
         { 
             $taker_name = $row_taker['first_name'];
             $taker_mail = $row_taker['email'];
         }
 	
    $query_mail = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_mail = mysqli_query($conn, $query_mail);
     $user = 'interlinkiq.com';
           $from = $taker_mail;
           $to = $taker_mail;
           $subject = 'MINUTES OF THE MEETING -'.$account;
           $body = '
                    <br>
                    <b>Date: </b>
                    '.$meeting_date.'
                    <br>
                    <br>
                    <b>Start time: </b>
                    '.date('h:i:s a', strtotime($duration_start)).' / CST
                    <br>
                    <br>
                    <b>End time: </b>
                    '.date('h:i:s a', strtotime($duration_end)).' / CST
                    <br>
                    <br>
                    <b>Agenda: </b>
                    '.$agenda_mail.'
                    <br>
                    <br>
                    <b>Lead Presider: </b>
                    '.$Pres.'
                    <br>
                    <br>
                    <b>Note taker: </b>
                    '.$taker_name.'
                    <br>
                    <br>
                    <b>Notes</b> <br>
                    '.$body_email.'
        
                    <br><br><br>
                    <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
            $mail = php_mailer($from, $to, $user, $subject, $body);
    
     $array_data_mail = explode(", ", $row["attendees"]);
    $query_multi = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_multi = mysqli_query($conn, $query_multi);
    while($row__multi = mysqli_fetch_array($result_multi))
         { 
            if(in_array($row__multi['ID'],$array_data_mail)){ $attd = $row__multi['email'];
                $user = 'interlinkiq.com';
               $from = $taker_mail;
               $to = $attd;
               $subject = 'MINUTES OF THE MEETING -'.$account;
               $body = '
                        <br>
                        <b>Date: </b>
                        '.$meeting_date.'
                        <br>
                        <br>
                        <b>Start time: </b>
                        '.date('h:i:s a', strtotime($duration_start)).' / CST
                        <br>
                        <br>
                        <b>End time: </b>
                        '.date('h:i:s a', strtotime($duration_end)).' / CST
                        <br>
                        <br>
                        <b>Agenda: </b>
                        '.$agenda_mail.'
                        <br>
                        <br>
                        <b>Lead Presider: </b>
                        '.$Pres.'
                        <br>
                        <br>
                        <b>Note taker: </b>
                        '.$taker_name.'
                        <br>
                        <br>
                        <b>Notes</b> <br>
                        '.$body_email.'
            
                        <br><br><br>
                        <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                        <br><br><br>
                        ';
                $mail = php_mailer2($from, $to, $user, $subject, $body);
            }
       
            
         }
        } }
   
	
         
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}


// new added 3
if( isset($_POST['btnNew_added3']) ) {
	
	$cookie = $_COOKIE['ID'];
    $user_id = $user_id;
	$account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$aattendees = '';
 	$gguest = '';
 	$aassign_to = '';
 	$gguest_email = '';
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
 	$agenda_mail = $_POST['agenda'];
 	$remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
//  	$guest = mysqli_real_escape_string($conn,$_POST['guest']);
 	$verified_by = mysqli_real_escape_string($conn,$_POST['verified_by']);
 	$approved_by = mysqli_real_escape_string($conn,$_POST['approved_by']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	$body_email = $_POST['discussion_notes'];
 	
//  	$guest_email = mysqli_real_escape_string($conn,$_POST['guest_email']);
 	$presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    if(!empty($_POST["attendees"]))
    {
        foreach($_POST["attendees"] as $attendees)
        {
            $aattendees .= $attendees.', ';
        }
         
    }
    if(!empty($_POST["guest"]))
    {
        foreach($_POST["guest"] as $guest)
        {
            $gguest .= $guest.', ';
        }
        foreach($_POST["guest_email"] as $guest_email)
        {
            $gguest_email .= $guest_email.', ';
        }
         
    }
    $aattendees = substr($aattendees, 0, -2);
    $gguest = substr($gguest, 0, -2);
    $gguest_email = substr($gguest_email, 0, -2);
    $sql = "INSERT INTO tbl_meeting_minutes (account,meeting_date,duration_start,duration_end,agenda,remarks,guest,verified_by,approved_by,discussion_notes,guest_email,presider,note_taker,attendees,user_ids,added_by_id) 
    VALUES ('$account','$meeting_date','$duration_start','$duration_end','$agenda','$remarks','$gguest','$verified_by','$approved_by','$discussion_notes','$gguest_email','$presider','$note_taker','$aattendees','$user_id','$cookie')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $action_details = count($_POST["action_details"]);
        if($action_details > 1)
        {
           for($i=0; $i<$action_details; $i++)
            {
                $assigned_to = $_POST["assigned_to"][$i];
                $target_due_date = $_POST["target_due_date"][$i];
                $status = $_POST["status"][$i];
                
                $sql2 = "INSERT INTO tbl_meeting_minutes_action_items(action_details,action_meeting_id,assigned_to,target_due_date,status) 
                VALUES('".mysqli_real_escape_string($conn, $_POST["action_details"][$i])."','$last_id','$assigned_to','$target_due_date','$status')";
                mysqli_query($conn, $sql2);
                
            }
        }
        
      $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes  where id = $last_id;");
      if(mysqli_num_rows($meetings) > 0) {
        $counter = 0;
        while($row = $meetings->fetch_assoc()) {?>
        <tr>
          <td> <?= $row['account'] ?> </td>
          <td> <?= $row['meeting_date'] ?> </td>
          <td> <?= $row['agenda'] ?> </td>
          <td>
            <?php
                 $array_data = explode(", ", $row["attendees"]);
                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
            $resultAssignto = mysqli_query($conn, $queryAssignto);
            while($rowAssignto = mysqli_fetch_array($resultAssignto))
                 { 
                    if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
               }
            ?>
          </td>
          <td>
            <?php
                $getId = $row['id'];
                $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where deleted = 0 AND action_meeting_id = $getId ";
                $resultOpen = mysqli_query($conn, $queryOpen);
                while($rowOpen = mysqli_fetch_array($resultOpen))
                { 
                    echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                }
            ?>
          </td>
          <td>
              <div class="btn-group btn-group-circle">
                   <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details(<?php echo  $row['id']; ?>)">Edit</a>
                    <a class="btn red btn-sm" type="button" id="pdf_report" data-id="<?php echo  $row['id']; ?>">PDF</a>
                </div>
              
          </td>
         </tr>
    
    <?php 
    
    
    $account = mysqli_real_escape_string($conn,$_POST['account']);
 	$meeting_date = mysqli_real_escape_string($conn,$_POST['meeting_date']);
 	$duration_start = mysqli_real_escape_string($conn,$_POST['duration_start']);
 	$duration_end = mysqli_real_escape_string($conn,$_POST['duration_end']);
 	$discussion_notes = mysqli_real_escape_string($conn,$_POST['discussion_notes']);
 	
    $agenda = mysqli_real_escape_string($conn,$_POST['agenda']);
    $agenda_mail = $_POST['agenda'];
    $presider = mysqli_real_escape_string($conn,$_POST['presider']);
 	$query_Pres = "SELECT * FROM tbl_hr_employee where ID = $presider order by first_name ASC";
    $result_Pres = mysqli_query($conn, $query_Pres);
    while($row_Pres = mysqli_fetch_array($result_Pres))
         { 
             $Pres = $row_Pres['first_name'];
             $Pres_email = $row_Pres['email'];
         }
    
 	$note_taker = mysqli_real_escape_string($conn,$_POST['note_taker']);
    $query_taker = "SELECT * FROM tbl_hr_employee where ID = $note_taker order by first_name ASC";
    $result_taker = mysqli_query($conn, $query_taker);
    while($row_taker = mysqli_fetch_array($result_taker))
         { 
             $taker_name = $row_taker['first_name'];
             $taker_mail = $row_taker['email'];
         }
 	
    $query_mail = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_mail = mysqli_query($conn, $query_mail);
            $user = 'interlinkiq.com';
           $from = $taker_mail;
           $to = $taker_mail;
           $subject = 'MINUTES OF THE MEETING -'.$account;
           $body = '
                    <br>
                    <b>Date: </b>
                    '.$meeting_date.'
                    <br>
                    <br>
                    <b>Start time: </b>
                    '.date('h:i:s a', strtotime($duration_start)).' / CST
                    <br>
                    <br>
                    <b>End time: </b>
                    '.date('h:i:s a', strtotime($duration_end)).' / CST
                    <br>
                    <br>
                    <b>Agenda: </b>
                    '.$agenda_mail.'
                    <br>
                    <br>
                    <b>Lead Presider: </b>
                    '.$Pres.'
                    <br>
                    <br>
                    <b>Note taker: </b>
                    '.$taker_name.'
                    <br>
                    <br>
                    <b>Notes</b> <br>
                    '.$body_email.'
        
                    <br><br><br>
                    <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                    <br><br><br>
                    ';
            $mail = php_mailer($from, $to, $user, $subject, $body);
    
     $array_data_mail = explode(", ", $row["attendees"]);
    $query_multi = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
    $result_multi = mysqli_query($conn, $query_multi);
    while($row__multi = mysqli_fetch_array($result_multi))
         { 
            if(in_array($row__multi['ID'],$array_data_mail)){ echo $attd = $row__multi['email'];
            //     $user = 'interlinkiq.com';
            //   $from = $taker_mail;
            //   $to = $attd;
            //     $cc = $Pres_email;
            //   $subject = 'MINUTES OF THE MEETING -'.$account;
            //   $body = '
            //             <br>
            //             <b>Date: </b>
            //             '.$meeting_date.'
            //             <br>
            //             <br>
            //             <b>Start time: </b>
            //             '.date('h:i:s a', strtotime($duration_start)).' / CST
            //             <br>
            //             <br>
            //             <b>End time: </b>
            //             '.date('h:i:s a', strtotime($duration_end)).' / CST
            //             <br>
            //             <br>
            //             <b>Agenda: </b>
            //             '.$agenda.'
            //             <br>
            //             <br>
            //             <b>Lead Presider: </b>
            //             '.$Pres.'
            //             <br>
            //             <br>
            //             <b>Note taker: </b>
            //             '.$taker_name.'
            //             <br>
            //             <br>
            //             <b>Notes</b> <br>
            //             '.$body_email.'
            
            //             <br><br><br>
            //             <a href="https://interlinkiq.com/meeting_minute.php" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
            //             <br><br><br>
            //             ';
            //     $mail = php_mailer2($from, $to,$cc, $user, $subject, $body);
            }
       
            
         }
        } }
   
	
         
    }
    else{
	    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
 
	mysqli_close($conn);
	echo json_encode($conn);
}

//add reference
if( isset($_POST['btnSave_reference']) ) {
    $user_id = $user_id;
    
    $meeting_id = mysqli_real_escape_string($conn,$_POST['meeting_id']);
    $title_name = mysqli_real_escape_string($conn,$_POST['title_name']);
    
    $file = $_FILES['file_docs']['name'];
    $filename = pathinfo($file, PATHINFO_FILENAME);
    $extension = end(explode(".", $_FILES['file_docs']['name']));
    $rand = rand(10,1000000);
    $file_docs =  mysqli_real_escape_string($conn,$rand." - ".$filename.".".$extension);
    $to_File_Documents = $rand." - ".$filename.".".$extension;
    move_uploaded_file($_FILES['file_docs']['tmp_name'],'../meeting_references/'.$to_File_Documents);
	$sql = "INSERT INTO tbl_meeting_minutes_ref (title_name,file_docs,added_by,meeting_id) VALUES ('$title_name','$to_File_Documents','$user_id','$meeting_id')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $queryr = "SELECT * FROM tbl_meeting_minutes_ref where ref_id = $last_id";
        $resultr = mysqli_query($conn, $queryr);
        while($rowr = mysqli_fetch_array($resultr)) {
            echo '<tr>
                <td>'.$rowr['title_name'].'</td>
                <td><a href="meeting_references/'.$rowr['file_docs'].'" target="_blank">'.$rowr['file_docs'].'</a></td>
            </tr>';
        }
    }
}

//add action items
if( isset($_POST['btnSave_action_item']) ) {
    
    $aassign_to = '';
    $user_id = $user_id;
    $meeting_id = mysqli_real_escape_string($conn,$_POST['meeting_ids']);
    $target_request_date = $_POST['target_request_date'];
    $target_start_date = $_POST['target_start_date'];
    $target_due_date = $_POST['target_due_date'];
    $action_details = mysqli_real_escape_string($conn,$_POST['action_details']);
    
    if(!empty($_POST["assign_to"]))
    {
        foreach($_POST["assign_to"] as $assign_to)
        {
            $aassign_to .= $assign_to.', ';
        }
         
    }
    $aassign_to = substr($aassign_to, 0, -2);
	$sql = "INSERT INTO tbl_meeting_minutes_action_items (action_details, target_request_date, target_start_date, target_due_date, assigned_to, ac_added_by, action_meeting_id, status) 
	VALUES ('$action_details', '$target_request_date', '$target_start_date', '$target_due_date', '$aassign_to', '$user_id', '$meeting_id', 'Open')";
    if(mysqli_query($conn, $sql)){
        
        $last_id = mysqli_insert_id($conn);
        $queryr = "SELECT * FROM tbl_meeting_minutes_action_items where action_id = $last_id";
        $resultr = mysqli_query($conn, $queryr);
        while($rowr = mysqli_fetch_array($resultr))
             { ?>
                <tr  id="statusTbl_<?= $rowr['action_id'];  ?>">
                    <td><?php echo $rowr['action_details'];  ?></td>
                    <td>
                        <?php
                         $array_data = explode(", ", $rowr["assigned_to"]);
                        $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                        while($rowAssignto = mysqli_fetch_array($resultAssignto))
                             { 
                                if(in_array($rowAssignto['ID'],$array_data)){
                                    echo$rowAssignto['first_name'].',';
                                    
                                }
                           }
                        ?>
                    </td>
                    <td><?php echo $rowr['target_request_date']; ?></td>
                    <td><?php echo $rowr['target_start_date']; ?></td>
                    <td><?php echo $rowr['target_due_date']; ?></td>
                    <td><?php echo $rowr['status']; ?></td>
                    <td width="60px">
                        <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $rowr['action_id']; ?>">
                            <i class="icon-speech" style="font-size:16px;"></i>
                                <?php
                                    $ai_id = $rowr['action_id'];
                                    $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                    foreach($comment_count as  $ccout){ 
                                    if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                    ?>
                                         <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                            <?= $ccout['count']; ?>
                                        </b></span>
                                   <?php }
                                ?>
                        </a>
                    </td>
                    <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $rowr['action_id']; ?>" >Update</a></td>
                </tr>
                
          <?php }
    }
    
    echo $sql;
}

//update status
if( isset($_GET['GetAI']) ) {
	$ID = $_GET['GetAI'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="meeting_id" value="'. $ID .'" />
	    ';
	        $query = "SELECT * FROM tbl_meeting_minutes_action_items where action_id = $ID";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
               
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Action Items</label>      
                    <input type="hidden" id="action_ids" name="action_ids" value="<?=$row['action_id']; ?>">
                            <input class="form-control" name="action_details" value="<?=$row['action_details']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Assign To</label>
                            <select class="form-control mt-multiselect btn btn-default" type="text" name="assigned_to" required>
                            <?php
                                $id = $row['assigned_to'];
                                
                                $assigned_to = mysqli_query($conn,"select * from tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $user_id order by first_name ASC");
                                if ($user_id == 1687) {
                                    $assigned_to = mysqli_query($conn,"select * from tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC");
                                }
                                
                                foreach($assigned_to as $emp_row){?>
                                    <option value="<?=$emp_row['ID']; ?>" <?php if($emp_row['ID']==$id){echo 'selected';}else{echo '';} ?>><?=$emp_row['first_name']; ?><?=$emp_row['last_name']; ?></option>
                                <?php }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Request Date</label>
                            <input class="form-control" type="date" name="target_request_date" value="<?= $row['target_request_date']; ?>" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Start Date</label>
                            <input class="form-control" type="date" name="target_start_date" value="<?= $row['target_start_date']; ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Due Date</label>
                            <input class="form-control" type="date" name="target_due_date" value="<?= $row['target_due_date']; ?>" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Status</label>
                            <select class="form-control" type="text" name="status" required>
                                <option value="Open"<?php if($row['status'] == 'Open'){echo 'selected';}else{echo '';} ?>>Open</option>
                                <option value="Follow Up" <?php if($row['status'] == 'Follow Up'){echo 'selected';}else{echo '';} ?>>Follow Up</option>
                                <option value="Close" <?php if($row['status'] == 'Close'){echo 'selected';}else{echo '';} ?>>Close</option>
                            </select>
                        </div>
                    </div>
    <?php } 
}
if( isset($_POST['btnSave_status']) ) {
  
    $user_id = $user_id;
    $IDs = mysqli_real_escape_string($conn,$_POST['action_ids']);
    $action_details = mysqli_real_escape_string($conn,$_POST['action_details']);
    $assigned_to = mysqli_real_escape_string($conn,$_POST['assigned_to']);
    $target_request_date = $_POST['target_request_date'];
    $target_start_date = $_POST['target_start_date'];
    $target_due_date = $_POST['target_due_date'];
    $status = mysqli_real_escape_string($conn,$_POST['status']);
   
	$sql = "UPDATE tbl_meeting_minutes_action_items set action_details='$action_details', assigned_to='$assigned_to', target_request_date='$target_request_date', target_start_date='$target_start_date', target_due_date='$target_due_date', status='$status' where action_id = $IDs";
    if(mysqli_query($conn, $sql)){
        $IDs = mysqli_real_escape_string($conn,$_POST['action_ids']);
        $queryr = "SELECT * FROM tbl_meeting_minutes_action_items where action_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($rowr = mysqli_fetch_array($resultr))
             { ?>
                <td><?php echo $rowr['action_details'];  ?></td>
                <td>
                    <?php
                     $array_data = explode(", ", $rowr["assigned_to"]);
                    $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                            if(in_array($rowAssignto['ID'],$array_data)){
                                echo$rowAssignto['first_name'];
                                
                            }
                       }
                    ?>
                </td>
                <td><?php echo $rowr['target_request_date']; ?></td>
                <td><?php echo $rowr['target_start_date']; ?></td>
                <td><?php echo $rowr['target_due_date']; ?></td>
                <td><?php echo $rowr['status']; ?></td>
                <td width="60px">
                    <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $rowr['action_id']; ?>">
                        <i class="icon-speech" style="font-size:16px;"></i>
                            <?php
                                $ai_id = $rowr['action_id'];
                                $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                foreach($comment_count as  $ccout){ 
                                if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                ?>
                                     <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                        <?= $ccout['count']; ?>
                                    </b></span>
                               <?php }
                            ?>
                    </a>
                </td>
                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $rowr['action_id']; ?>" >Update</a></td>
          <?php }
          
          
    }
}

//comment
if( isset($_GET['getAI_comment']) ) {
	$ID = $_GET['getAI_comment'];
	$today = date('Y-m-d');

	echo '<input class="form-control" type="hidden" name="ID" id="ai_id" value="'. $ID .'" />';
    $query = "SELECT * FROM tbl_meeting_minutes_action_items where action_id = $ID";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result)) {
        $comment = mysqli_query($conn,"select * from tbl_meeting_minutes_ai_comment where ai_id = $ID");
        foreach($comment as $comment_row) {
            if($comment_row['ai_commentor']== $_COOKIE['ID']) {
                echo '<div class="form-group">
                     <div class="col-md-12">
                        <p style="margin-top:-1.5rem;">'.nl2br($comment_row['ai_comment']).'<br><i style="font-size:10px;">'.date('Y-m-d h:i:s a', strtotime($comment_row['ai_added'])).'</i></p>
                    </div>
                </div>';
            } else {
                echo '<div class="form-group">
                    <div class="col-md-12">
                        <label style="font-size:10px;">';
                        
                            $cid = $comment_row['ai_commentor'];
                            $commentor = mysqli_query($conn,"select * from tbl_user where ID = $cid");
                            foreach($commentor as $cuser){ echo 'Commented by: '.$cuser['first_name']; }
                                
                            echo '<br><br>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <p style="margin-top:-1.5rem;">'.nl2br($comment_row['ai_comment']).'<br><i style="font-size:10px;">'.date('Y-m-d h:i:s a', strtotime($comment_row['ai_added'])).'</i></p>
                    </div>
                </div>';
            }
        }
    }
            
    echo'<div class="form-group">
        <div class="col-md-12">
            <textarea class="form-control" name="ai_comment"></textarea>
        </div>
        <div class="col-md-12">
            <br>
            <button type="submit" class="btn green ladda-button" name="btnComment" id="btnComment" data-style="zoom-out" style="float:right;"><span class="ladda-label">Save</span></button>
        </div>
    </div>';
}
if( isset($_POST['btnComment']) ) {
  
    $user_id = $_COOKIE['ID'];
    $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
    $ai_comment = mysqli_real_escape_string($conn,$_POST['ai_comment']);
    $content = $_POST['ai_comment'];
    
	$sql = "INSERT INTO tbl_meeting_minutes_ai_comment (ai_comment,ai_id,ai_commentor) 
	VALUES ('$ai_comment','$IDs','$user_id')";
    if(mysqli_query($conn, $sql)){
        
       $IDs = mysqli_real_escape_string($conn,$_POST['ID']);
        $queryr = "SELECT * FROM tbl_meeting_minutes_action_items where action_id = $IDs";
        $resultr = mysqli_query($conn, $queryr);
        while($rowr = mysqli_fetch_array($resultr))
             { ?>
                <td><?php echo $rowr['action_details'];  ?></td>
                <td>
                    <?php
                     $array_data = explode(", ", $rowr["assigned_to"]);
                    $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $user_id or user_id = 34 order by first_name ASC";
                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                    while($rowAssignto = mysqli_fetch_array($resultAssignto))
                         { 
                            if(in_array($rowAssignto['ID'],$array_data)){
                                echo $rowAssignto['first_name'];
                                
                                $icc = $_COOKIE['ID'];
                                $ccommentor =mysqli_query($conn,"select * from tbl_user where ID = $icc");
                                foreach($ccommentor as $com){$cfrom = $com['email'];}
                                
                                $MoM = $rowr['action_meeting_id'];
                                $mMoM =mysqli_query($conn,"select * from tbl_meeting_minutes where id = $MoM");
                                foreach($mMoM as $row_MoM){$cagenda = $row_MoM['agenda']; $aaccount = $row_MoM['account'];}
                                
                                $user = 'interlinkiq.com';
                                $from = $cfrom;
                                $to = $rowAssignto['email'];
                                $subject = 'COMMENTED ON THE MINUTES OF THE MEETING ACTION ITEMS';
                                $body = '
                                        <br>
                                        <b>Date: </b>
                                        '.date('Y-m-d').'
                                        <br>
                                        <br>
                                        <b>Account: </b>
                                        '.$aaccount.'
                                        <br>
                                        <br>
                                        <b>Agenda: </b>
                                        '.$cagenda.'
                                        <br>
                                        <br>
                                        <b>Comments</b> <br>
                                        '.$content.'
                                    
                                        <br><br><br>
                                        <a href="https://interlinkiq.com/meeting_minute.php#id_'.$rowr['action_meeting_id'].'" target="_blank" style="padding:10px;background-color:#5DA7DB;border-radius:5px;color:#fff;text-decoration:none;"><b>VIEW</b></a>
                                        <br><br><br>
                                        ';
                                $mail = php_mailer($from, $to, $user, $subject, $body);
                                
                            }
                       }
                    ?>
                </td>
                <td><?php echo $rowr['target_request_date']; ?></td>
                <td><?php echo $rowr['target_start_date']; ?></td>
                <td><?php echo $rowr['target_due_date']; ?></td>
                <td><?php echo $rowr['status']; ?></td>
                <td width="60px">
                    <a href="#modal_comment_ai" data-toggle="modal" type="button" id="comment_AI" data-id="<?php echo $rowr['action_id']; ?>">
                        <i class="icon-speech" style="font-size:16px;"></i>
                            <?php
                                $ai_id = $rowr['action_id'];
                                $comment_count = mysqli_query($conn,"select COUNT(*) as count from tbl_meeting_minutes_ai_comment where ai_id=$ai_id");
                                foreach($comment_count as  $ccout){ 
                                if($ccout['count'] != 0){$color= 'blue';}else{$color= 'red';}
                                ?>
                                     <span class="badge" style="background-color:<?=$color; ?>;margin-left:-7px;"><b style="font-size:12px;">
                                        <?= $ccout['count']; ?>
                                    </b></span>
                               <?php }
                            ?>
                    </a>
                </td>
                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $rowr['action_id']; ?>" >Update</a></td>
          <?php }
    }
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
		  //  $mail->setFrom($from, $user);
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
	
function php_mailer2($from, $to, $user, $subject, $body) {
// 		require '../PHPMailer/src/Exception.php';
// 		require '../PHPMailer/src/PHPMailer.php';
// 		require '../PHPMailer/src/SMTP.php';

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
		    $mail->clearAddresses();
		    $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
		    $mail->addAddress($to, $user);
		    $mail->addReplyTo($from, $user);
		  //  $mail->addCC($cc, $user);

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
?>
