<?php
    include '../database.php';
    
    if(isset($_GET['postId'])){
        $Ids = $_GET['postId'];
        $sql = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items left join tbl_MyProject_Services on MyPro_id = Parent_MyPro_PK
        left join tbl_MyProject_Services_Action_Items on Action_Items_id = CAI_Action_taken WHERE CAI_id = '$Ids'"; 
    	$result = mysqli_query ($conn, $sql);
    
        foreach($result as $row){
            $date_start = new DateTime($row['CAI_Action_date']);
            $date_end = new DateTime($row['CAI_Action_due_date']);
        ?>
            <div class="tabbable-line tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tabYourTask" data-toggle="tab">Task Details</a>
                    </li>
                </ul>
                <br>
                <div class="tab-pane active" id="tabYourTask">
                   <div class="row">
                       <div class="col-md-12">
                           <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                               <thead class="bg-primary">
                                   <tr>
                                       <th>Ticket No.</th>
                                       <th>Project</th>
                                       <th>Description</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr>
                                       <td><a href="my_project_details.php"><?= $row['MyPro_id']; ?></a></td>
                                       <td><a href="my_project_details.php"><?= $row['Project_Name']; ?></a></td>
                                       <td><?= $row['Project_Description']; ?></td>
                                   </tr>
                               </tbody>
                            </table>
                        </div>
                       <div class="col-md-12">
                           <div class="table-scrollable">
                               <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                               <thead>
                                   <tr>
                                        <th>ID #.</th>
                                        <th>From</th>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                        <th>Account</th>
                                        <th>Action<i style="color:transparent;">_</i>Item</th>
                                        <th>Assigned<i style="color:transparent;">_</i>To</th>
                                        <th>Status</th>
                                        <th>Rendered<i style="color:transparent;">_</i>Time</th>
                                        <th>Date</th>
                                        <th>Supporting<i style="color:transparent;">_</i>file</th>
                                        <th></th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr id="cal_<?= $row['CAI_id']; ?>">
                                        <td><?= $row['CAI_id']; ?></td>
                                        <td>
                                            <?php 
                                                $from = $row['CAI_User_PK']; 
                                                 $sql_from = "SELECT * FROM tbl_user WHERE ID = '$from'"; 
                                            	 $result_from = mysqli_query ($conn, $sql_from);
                                                    foreach($result_from as $row_from){ echo $row_from['first_name'];}
                                            ?>
                                        </td>
                                        <td class="min-width"><?= $row['CAI_filename']; ?></td>
                                        <td class="min-width"><?= $row['CAI_description']; ?></td>
                                        <td><?= $row['CAI_Accounts']; ?></td>
                                        <td><?= $row['Action_Items_name']; ?></td>
                                        <td>
                                            <?php 
                                                $to = $row['CAI_Assign_to']; 
                                                $sql_from = "SELECT * FROM tbl_hr_employee WHERE ID = '$to'"; 
                                            	$result_from = mysqli_query ($conn, $sql_from);
                                                foreach($result_from as $row_from){ echo $row_from['first_name'];}
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($row['CIA_progress'] == 1){ echo 'Inprogress';}
                                                else if($row['CIA_progress'] == 2){ echo 'Completed';}
                                                else{echo 'Not Started'; }
                                            ?>
                                        </td>
                                        <td><?= $row['CAI_Rendered_Minutes']; ?></td>
                                        <td class="min-width">Start: <?= $date_start->format('M. d, Y').'<br>'; ?> Due: <?= $date_end->format('M. d, Y'); ?></td>
                                        <td>
                                            <?php if(!empty($row['CAI_files'])){ echo'<a href="MyPro_Folder_Files/'.$row['CAI_files'].'" target="_blank">'.$ext = pathinfo($row['CAI_files'], PATHINFO_EXTENSION).'</a>';}else{ echo'No file';} ?>
                                        </td>
                                        <td><a style="color:#fff;" href="#modalGet_shortcut" data-toggle="modal" class="btn red btn-xs" onclick="onclick_shortcut(<?= $row['CAI_id']; ?>)">Edit</a></td>
                                   </tr>
                               </tbody>
                           </table>
                           </div>
                       </div>
                   </div>
               </div>
               </div>
 
        <?php 
        }
           
    }
?>
