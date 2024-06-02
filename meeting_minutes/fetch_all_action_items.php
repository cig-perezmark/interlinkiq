<?php
require '../database.php';

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

if(isset($_POST['key'])){
    if ($_POST['key'] == 'get_data') {
       
        $attendees = 0;
        $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes ORDER BY inserted_at DESC;");
        if(mysqli_num_rows($meetings) > 0) {
            while($row = $meetings->fetch_assoc()) {
            $array_data = explode(", ", $row["attendees"]);
            
                $action_item = 0;
                if($_COOKIE['employee_id'] > 0) {
                    // for attendess
                    $temp_id = $_COOKIE['employee_id'];
                    if(in_array($temp_id,$array_data)){
                
                        $getId = $row['id'];
                        $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId ";
                        $resultOpen = mysqli_query($conn, $queryOpen);
                        while($rowOpen = mysqli_fetch_array($resultOpen)) {
                            $attendees += $rowOpen['countOpen'];
                        }
                 
                    }
                    
                    // for action item 
                    $emp_id = $_COOKIE['employee_id'];
                    $ai_query = mysqli_query($conn,"select Distinct(assigned_to),id,account,meeting_date,agenda,attendees,action_meeting_id from tbl_meeting_minutes_action_items 
                    left join tbl_meeting_minutes on id = action_meeting_id where assigned_to = $emp_id");
                    foreach($ai_query as $ai_orw){
                        $array_data2 = explode(", ", $ai_orw["attendees"]);
                        if(!in_array($temp_id,$array_data2)){
                            $getId = $ai_orw['id'];
                            $queryOpen = "SELECT COUNT(*) as countOpen FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId ";
                            $resultOpen = mysqli_query($conn, $queryOpen);
                            while($rowOpen = mysqli_fetch_array($resultOpen)) { 
                                $action_item += $rowOpen['countOpen'];
                            }
                        } 
                    }
                }
                $total = $action_item + $attendees;
                echo '<a href="#modalGet_all_action_items" data-toggle="modal" type="button" id="get_all_actions" data-id="'.$temp_id.'"  class="btn btn-outline blue btn-sm">ALL ACTION ITEMS ('.$total.')</a>';
                // end meeting
            }
    }
    
}

if(isset($_GET['get_all_data'])){?>
    <div class="tabbable tabbable-tabdrop">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tabOpen1" data-toggle="tab">Open</a>
            </li>
            <li>
                <a href="#tabFollow1" data-toggle="tab">Follow Up</a>
            </li>
            <li>
                <a href="#tabClose1" data-toggle="tab">Close</a>
            </li>
        </ul>
        <div class="tab-content margin-top-20">
            <div class="tab-pane active" id="tabOpen1">
                <table class="table table-bordered ">
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
                        $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes ORDER BY inserted_at DESC;");
                        if(mysqli_num_rows($meetings) > 0) {
                            while($row = $meetings->fetch_assoc()) {
                            $array_data = explode(", ", $row["attendees"]);
                            
                                // for attendess
                             
                                 $temp_id = $_COOKIE['employee_id'];
                                if(in_array($temp_id,$array_data)){
                                
                                        $getId = $row['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Open' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
                                        {?> 
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                            
                                       <?php }
                                 
                                    }
                                    
                                }
                                // for action item 
                                $emp_id = $_COOKIE['employee_id'];
                                $ai_query = mysqli_query($conn,"select Distinct(assigned_to),id,account,meeting_date,agenda,attendees,action_meeting_id from tbl_meeting_minutes_action_items 
                                left join tbl_meeting_minutes on id = action_meeting_id where assigned_to = $emp_id");
                                foreach($ai_query as $ai_orw){
                                $array_data2 = explode(", ", $ai_orw["attendees"]);
                                if(!in_array($temp_id,$array_data2)){
                                
                                        $getId = $ai_orw['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Open' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                        <?php }
                                    } 
                                }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tabFollow1">
                <table class="table table-bordered ">
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
                        $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes ORDER BY inserted_at DESC;");
                        if(mysqli_num_rows($meetings) > 0) {
                            while($row = $meetings->fetch_assoc()) {
                            $array_data = explode(", ", $row["attendees"]);
                            
                                // for attendess
                             
                                 $temp_id = $_COOKIE['employee_id'];
                                if(in_array($temp_id,$array_data)){
                                
                                        $getId = $row['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Follow Up' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
                                        {?> 
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                            
                                       <?php }
                                 
                                    }
                                    
                                }
                                // for action item 
                                $emp_id = $_COOKIE['employee_id'];
                                $ai_query = mysqli_query($conn,"select Distinct(assigned_to),id,account,meeting_date,agenda,attendees,action_meeting_id from tbl_meeting_minutes_action_items 
                                left join tbl_meeting_minutes on id = action_meeting_id where assigned_to = $emp_id");
                                foreach($ai_query as $ai_orw){
                                $array_data2 = explode(", ", $ai_orw["attendees"]);
                                if(!in_array($temp_id,$array_data2)){
                                
                                        $getId = $ai_orw['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Follow Up' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                        <?php }
                                    } 
                                }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tabClose1">
                <table class="table table-bordered ">
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
                        $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes ORDER BY inserted_at DESC;");
                        if(mysqli_num_rows($meetings) > 0) {
                            while($row = $meetings->fetch_assoc()) {
                            $array_data = explode(", ", $row["attendees"]);
                            
                                // for attendess
                             
                                 $temp_id = $_COOKIE['employee_id'];
                                if(in_array($temp_id,$array_data)){
                                
                                        $getId = $row['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Close' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
                                        {?> 
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                            
                                       <?php }
                                 
                                    }
                                    
                                }
                                // for action item 
                                $emp_id = $_COOKIE['employee_id'];
                                $ai_query = mysqli_query($conn,"select Distinct(assigned_to),id,account,meeting_date,agenda,attendees,action_meeting_id from tbl_meeting_minutes_action_items 
                                left join tbl_meeting_minutes on id = action_meeting_id where assigned_to = $emp_id");
                                foreach($ai_query as $ai_orw){
                                $array_data2 = explode(", ", $ai_orw["attendees"]);
                                if(!in_array($temp_id,$array_data2)){
                                
                                        $getId = $ai_orw['id'];
                                        $queryOpen = "SELECT * FROM tbl_meeting_minutes_action_items where action_meeting_id = $getId and status = 'Close' order by inserted_at ASC";
                                        $resultOpen = mysqli_query($conn, $queryOpen);
                                        while($row_open = mysqli_fetch_array($resultOpen))
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
                                                <td><?php echo date('Y-m-d', strtotime($row_open['target_due_date'])); ?></td>
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
                                                <td><a href="#modal_update_status" data-toggle="modal" class="btn red btn-xs" type="button" id="add_status" data-id="<?php echo $row_open['action_id']; ?>" >Update</a></td>
                                            </tr>
                                        <?php }
                                    } 
                                }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php }
?>