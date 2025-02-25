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
            <div class="tabbable tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tabYourTask" data-toggle="tab">Task Details</a>
                    </li>
                    <li>
                        <a href="#tabAll" data-toggle="tab">View All</a>
                    </li>
                </ul>
                <div class="tab-content margin-top-20">
                <div class="tab-pane active" id="tabYourTask">
                   <div class="row">
                       <div class="table-scrollable">
                       <div class="col-md-12">
                           <table class="table table-bordered dt-responsive">
                               <thead class="bg-primary">
                                   <tr>
                                       <th>Ticket No.</th>
                                       <th>Description</th>
                                       <th>Project</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr>
                                       <td><?= $row['MyPro_id']; ?></td>
                                       <td><?= $row['Project_Name']; ?></td>
                                       <td><?= $row['Project_Description']; ?></td>
                                   </tr>
                               </tbody>
                            </table>
                        </div>
                       <div class="col-md-12">
                           <table class="table table-bordered dt-responsive" width="100%" id="sample_5">
                               <thead>
                                   <tr>
                                        <th>ID #.</th>
                                        <th>From</th>
                                        <th>Task name</th>
                                        <th>Description</th>
                                        <th>Account</th>
                                        <th>Action<i style="color:transparent;">_</i>Item</th>
                                        <th>Assign<i style="color:transparent;">_</i>to</th>
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
                                        <td><?= $row['CAI_filename']; ?></td>
                                        <td><?= $row['CAI_description']; ?></td>
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
                                                else{echo 'Not stared'; }
                                            ?>
                                        </td>
                                        <td><?= $row['CAI_Rendered_Minutes']; ?></td>
                                        <td>Start: <?= $date_start->format('M d, Y').'<br>'; ?> Due: <?= $date_end->format('M d, Y'); ?></td>
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
               <div class="tab-pane" id="tabAll">
                   
                        <table class="table table-bordered  dt-responsive" width="100%" >
                               <thead class="bg-primary">
                                   <tr>
                                        <th>Ticket No.</th>
                                       <th>Description</th>
                                       <th>Project</th>
                                   </tr>
                               </thead>
                               <tbody>
                                <?php 
                                    $get_id = $row['Parent_MyPro_PK'];
                                    $sql2 = "SELECT * FROM tbl_MyProject_Services
                                    WHERE MyPro_id = '$get_id'"; 
                                	$result2 = mysqli_query ($conn, $sql2);
                                
                                    foreach($result2 as $rows){
                                    ?>
                                   <tr id="">
                                       <td><?= $rows['MyPro_id']; ?></td>
                                       <td><?= $rows['Project_Name']; ?></td>
                                       <td><?= $rows['Project_Description']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                        <?php 
                            $get_id = $row['Parent_MyPro_PK'];
                            $sql2 = "SELECT * FROM tbl_MyProject_Services_History
                            WHERE MyPro_PK = '$get_id'"; 
                        	$result2 = mysqli_query ($conn, $sql2);
                        
                            foreach($result2 as $rows){
                            ?>
                            <div class="panel-group accordion " id="accordion1" style="width:100%;">
                                <div class="panel panel" >
                                    <div class="panel-heading" style="background-color:#F5F5F5;color:black;" >
                                           <div class="row">
                                                 <div class="col-md-12">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?= $rows['History_id']; ?>">
                                                        <div class="col-md-1"><?= $rows['History_id']; ?></div>
                                                        <div class="col-md-2">
                                                         <?php 
                                                            $from = $rows['user_id'];
                                                             $sql_name = mysqli_query ($conn,"SELECT * FROM tbl_user WHERE ID = '$from'");
                                                             foreach($sql_name as $name){ echo 'From: '.$name['first_name'];}
                                                           ?>   
                                                        </div>
                                                        <div class="col-md-2"><?= $rows['filename']; ?></div>
                                                        <div class="col-md-3"><?= $rows['description']; ?></div>
                                                        <div class="col-md-2">
                                                         <?php 
                                                            $from = $rows['user_id'];
                                                             $sql_name = mysqli_query ($conn,"SELECT * FROM tbl_user WHERE ID = '$from'");
                                                             foreach($sql_name as $name){ echo 'From: '.$name['first_name'];}
                                                           ?>   
                                                        </div>
                                                        <div class="col-md-2"><?= $rows['h_accounts']; ?></div>
                                                    </a>
                                                </div>
                                           </div>
                                    </div>
                                    <div id="<?= $rows['History_id']; ?>" class="panel-collapse collapse">
                                        <div class="panel-body" >
                                            <div class="table-scrollable">
                                               <!--data here-->
                                               <table class="table table-bordered table-hover dt-responsive" width="100%">
                                                   <tbody>
                                                    <?php 
                                                        $history_id = $rows['History_id'];
                                                        $get_Parentid = $row['Parent_MyPro_PK'];
                                                        $sql_child = "SELECT * FROM tbl_MyProject_Services_Childs_action_Items
                                                        WHERE Parent_MyPro_PK = '$get_Parentid' and Services_History_PK = '$history_id'"; 
                                                    	$result_child = mysqli_query ($conn, $sql_child);
                                                    
                                                        foreach($result_child as $row_child){
                                                        ?>
                                                       <tr id="">
                                                           <td><?= $row_child['CAI_id']; ?></td>
                                                           <td>
                                                               <?php 
                                                                $from = $row_child['CAI_User_PK'];
                                                                 $sql_name = mysqli_query ($conn,"SELECT * FROM tbl_user WHERE ID = '$from'");
                                                                 foreach($sql_name as $name){ echo 'From: '.$name['first_name'];}
                                                               ?>
                                                           </td>
                                                           <td><?= $row_child['CAI_filename']; ?></td>
                                                           <td><?= $row_child['CAI_description']; ?></td>
                                                           <td>
                                                               <?php 
                                                                $to = $row_child['CAI_Assign_to'];
                                                                 $sql_name = mysqli_query ($conn,"SELECT * FROM tbl_hr_employee WHERE ID = '$to'");
                                                                 foreach($sql_name as $name){ echo 'Assigned To: '.$name['first_name'];}
                                                               ?>
                                                           </td>
                                                           <td><?= $row_child['CAI_Accounts']; ?></td>
                                                           <td><?= 'Start Date: '.date('Y-m-d', strtotime($row_child['CAI_Action_date'])); ?></td>
                                                           <td><?php //date('Y-m-d', strtotime($row_child['CAI_Action_due_date'])); ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                          
                        <?php } ?>
                   </div>
               </div>
               </div>
 
        <?php 
        }
           
    }
?>
