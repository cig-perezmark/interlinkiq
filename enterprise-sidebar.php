
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <?php
                                            error_reporting(0);
                                            // $users = $_COOKIE['ID'];
                                            $users = $switch_user_id;
                                            $query = "SELECT * FROM tblEnterpiseDetails where users_entities = $users";
                                            $result = mysqli_query($conn, $query);     
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                $done = false;
                                                if($users == $row['users_entities']){
                                                    $done = true;
                                                    break;
                                                }                              
                                            }
                                            if($done == true){?>
                                            <?php  if ( empty($row['BrandLogos']) ) {
                                                echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive thumbnail" alt="Avatar" />';
                                            } else {
                                                echo '<img src="companyDetailsFolder/'.$row['BrandLogos'].'" class="img-responsive thumbnail" alt="Avatar" />';
                                            } ?>
                                    </div>
                                        <div class="profile-usertitle">
                                                    <div class="profile-usertitle-name"><?php echo $row['businessname']; ?></div>
                                                    <div class="profile-usertitle-job "> <u><?php echo $row['Bldg']; ?>,&nbsp;<?php echo $row['city']; ?>,&nbsp;<?php echo $row['States']; ?>,&nbsp;<?php echo $row['ZipCode']; ?></u> </div>
                                                    <i style="font-size:12px;">Address</i>
                                                    <br>
                                                    <br>
                                                </div>
                                        <?php }else{ ?>
                                        <?php  if ( empty($row['BrandLogos']) ) {
                                                    echo '<img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive thumbnail" alt="Avatar" />';
                                                } else {
                                                    echo '<img src="companyDetailsFolder/'.$row['BrandLogos'].'" class="img-responsive thumbnail" alt="Avatar" />';
                                                } ?>
                                                        
                                        </div>
                                            <div class="profile-usertitle">
                                            <div class="profile-usertitle-name">Legal Name</div>
                                            <div class="profile-usertitle-job "></div>
                                                <i style="font-size:12px;">Address</i>
                                                <br>
                                            <br>
                                        </div>
                                        <?php } ?>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    
                                    <!-- END SIDEBAR USER TITLE -->
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu hide">
                                        <ul class="nav">
                                            <li class="<?php echo $site === 'profile' ? 'active' : ''; ?>">
                                                <a href="profile">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li class="<?php echo $site === 'profile-setting' ? 'active' : ''; ?>">
                                                <a href="profile-setting">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                           
                                            <li class="hide <?php echo $site === 'profile-help' ? 'active' : ''; ?>">
                                                <a href="profile-help">
                                                    <i class="icon-info"></i> Help </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->

                                <!-- MODAL -->
                                <div class="modal fade bs-modal-lg" id="modalProject" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalProject">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Project</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                    <input class="form-control" type="hidden" name="project_id" value="" />
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Project Name</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text" name="project" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Assigned To</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple">
                                                                <?php
                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id=$current_userID" );
                                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                            if ( $rowEmployee["ID"] === $current_userID ) {
                                                                                echo '<option value="'. $rowEmployee["ID"] .'" selected>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                                                                            } else {
                                                                                echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo '<option disabled>No Available</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Due Date</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="date" name="due_date" min="<?php echo date("Y-m-d"); ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Priority</label>
                                                        <div class="col-md-8">
                                                            <input type="checkbox" class="make-switch" name="priority" data-on-text="Yes" data-off-text="No" data-on-color="success">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label"></label>
                                                        <div class="col-md-10">
                                                            <div class="portlet-body">
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover" id="tableProject">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Project</th>
                                                                                <th style="width: 130px;" class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $profileSidebarProject = 0;
                                                                                $selectProject = mysqli_query( $conn,"SELECT * FROM tbl_user_project WHERE is_removed = 0 AND user_id = $current_userID" );
                                                                                if ( mysqli_num_rows($selectProject) > 0 ) {
                                                                                    while($rowProject = mysqli_fetch_array($selectProject)) {
                                                                                        $profileSidebarProject++;

                                                                                        $data_assigned_to_id = array();
                                                                                        $array_assigned_to_id = explode(", ", $rowProject["assigned_to_id"]);

                                                                                        $resultEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
                                                                                        if ( mysqli_num_rows($resultEmployee) > 0 ) {
                                                                                            while($rowEmployee = mysqli_fetch_array($resultEmployee)) {
                                                                                                if (in_array($rowEmployee["ID"], $array_assigned_to_id)) {
                                                                                                    array_push($data_assigned_to_id, $rowEmployee["first_name"] .' '. $rowEmployee["last_name"]);
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $data_assigned_to_id = implode(", ",$data_assigned_to_id);

                                                                                        echo '<tr id="tr_'. $rowProject["ID"] .'">
                                                                                            <td class="mt-element-ribbon">';

                                                                                                if ($rowProject["priority"] == 1) {
                                                                                                    echo '<div class="ribbon ribbon-right ribbon-vertical-right ribbon-shadow ribbon-border-dash-vert ribbon-color-success uppercase">
                                                                                                        <div class="ribbon-sub ribbon-bookmark"></div>
                                                                                                        <i class="fa fa-star"></i>
                                                                                                    </div>';
                                                                                                }
                                                                                                
                                                                                                echo '<b>'. $rowProject["project"] .'</b></br>
                                                                                                <span><b>Assigned To: </b><i>'. $data_assigned_to_id .'</i></span></br>
                                                                                                <span><b>Due Date: </b><i>'. $rowProject["due_date"] .'</i></span></br>
                                                                                                <span><b>Remarks: </b><i>';

                                                                                                    if ( empty($rowProject["remarks"]) ) {

                                                                                                        if ($rowProject["is_completed"] === "0") {
                                                                                                            echo '<span class="label label-sm label-warning">Pending</span>';
                                                                                                        } else if ($rowProject["is_completed"] === "1") {
                                                                                                            echo '<span class="label label-sm label-success">Completed</span>';
                                                                                                        } else if ($rowProject["is_completed"] === "2") {
                                                                                                            echo '<span class="label label-sm label-danger">Canceled</span>';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '<span>'. $rowProject["remarks"] .'</span>';
                                                                                                    }


                                                                                                echo '</i></span>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <button type="button" class="btn btn-outline dark btn-sm btnEditProject" 
                                                                                                        data-id="'. $rowProject["ID"] .'"
                                                                                                        data-project="'. $rowProject["project"] .'"
                                                                                                        data-assigned="'. $rowProject["assigned_to_id"] .'"
                                                                                                        data-date="'. $rowProject["due_date"] .'"
                                                                                                        data-priority="'. $rowProject["priority"] .'"
                                                                                                        >Edit</button>
                                                                                                    <button type="button" class="btn btn-outline red btn-sm btnDeleteProject" data-id="'. $rowProject["ID"] .'">Delete</button>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>';
                                                                                    }
                                                                                    
                                                                                } else {
                                                                                    echo '<tr class="text-center text-default"><td colspan="2">Empty Record</td></tr>';
                                                                                }
                                                                            ?>
                                                                       </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                    <input type="reset" class="btn dark" name="btnReset_USER_Project" id="btnReset_USER_Project" value="Rreset" />
                                                    <input type="submit" class="btn green" name="btnSave_USER_Project" id="btnSave_USER_Project" value="Save" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade bs-modal-lg" id="modalTask" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalTask">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Task</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                    <input class="form-control" type="hidden" name="task_id" value="" />
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Your Task</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="task"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Assigned To</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id">
                                                                <?php
                                                                    $selectDataUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $current_userID" );
                                                                    if ( mysqli_num_rows($selectDataUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectDataUser);
                                                                        $current_userEmployeeID = $rowUser["employee_id"];
                                                                        $current_ID = $rowUser["ID"];

                                                                        if ($current_userEmployeeID != 0) {
                                                                            $selectDataEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $current_userEmployeeID" );
                                                                            if ( mysqli_num_rows($selectDataEmployee) > 0 ) {
                                                                                $rowFile = mysqli_fetch_array($selectDataEmployee);
                                                                                $current_ID = $rowFile["user_id"];
                                                                            }
                                                                        }

                                                                        $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id=$current_ID" );
                                                                        if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                            while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                                if ( $rowEmployee["ID"] === $current_userID ) {
                                                                                    echo '<option value="'. $rowEmployee["ID"] .'" selected>'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                                                                                } else {
                                                                                    echo '<option value="'. $rowEmployee["ID"] .'">'. $rowEmployee["first_name"] .' '. $rowEmployee["last_name"] .'</option>';
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo '<option disabled>No Available</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Due Date</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="date" name="due_date" min="<?php echo date("Y-m-d"); ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Priority</label>
                                                        <div class="col-md-8">
                                                            <input type="checkbox" class="make-switch" name="priority" data-on-text="Yes" data-off-text="No" data-on-color="success">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label"></label>
                                                        <div class="col-md-10">
                                                            <div class="portlet-body">
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover" id="tableTask">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Task</th>
                                                                                <th style="width: 130px;" class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $profileSidebarTask = 0;
                                                                                $selectTask = mysqli_query( $conn,"SELECT * FROM tbl_user_task WHERE is_removed = 0 AND user_id = $current_userID" );
                                                                                if ( mysqli_num_rows($selectTask) > 0 ) {
                                                                                    while($rowTask = mysqli_fetch_array($selectTask)) {
                                                                                        $profileSidebarTask++;
                                                                                                                                // $task_userID = $rowTask["user_id"];
                                                                                        $task_type = $rowTask["type"];
                                                                                        $task_target_id = $rowTask["target_id"];
                                                                                        $array_Task = explode(", ", $rowTask["assigned_to_id"]);

                                                                                        if ($task_type == 2) {
                                                                                            $selectDashboardFile = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE ID = $task_target_id" );
                                                                                            if ( mysqli_num_rows($selectDashboardFile) > 0 ) {
                                                                                                $rowDashboardFile = mysqli_fetch_array($selectDashboardFile);
                                                                                                $task_assigned_to_action = $rowDashboardFile["assigned_to_action"];

                                                                                                // $task_files = $rowDashboardFile["files"];

                                                                                                if (!empty($array_Task[$task_assigned_to_action])) {
                                                                                                    // if ($userID == $array_Task[$task_assigned_to_action]) {
                                                                                                        $userID = $array_Task[$task_assigned_to_action];
                                                                                                        $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $userID" );
                                                                                                        if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                                            while($rowUser = mysqli_fetch_array($selectUser)) {
                                                                                                                $data_assigned_to_id = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                                                            }
                                                                                                        }
                                                                                                    // }
                                                                                                } else {
                                                                                                    $data_assigned_to_id = "NA / Completed";
                                                                                                }
                                                                                            }
                                                                                        } else {
                                                                                            $data_assigned_to_id = array();
                                                                                            $array_assigned_to_id = explode(", ", $rowTask["assigned_to_id"]);

                                                                                            $resultEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee" );
                                                                                            if ( mysqli_num_rows($resultEmployee) > 0 ) {
                                                                                                while($rowEmployee = mysqli_fetch_array($resultEmployee)) {
                                                                                                    if (in_array($rowEmployee["ID"], $array_assigned_to_id)) {
                                                                                                        array_push($data_assigned_to_id, $rowEmployee["first_name"] .' '. $rowEmployee["last_name"]);
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            $data_assigned_to_id = implode(", ",$data_assigned_to_id);
                                                                                        }


                                                                                        echo '<tr id="tr_'. $rowTask["ID"] .'">
                                                                                            <td class="mt-element-ribbon">';

                                                                                                if ($rowTask["priority"] == 1) {
                                                                                                    echo '<div class="ribbon ribbon-right ribbon-vertical-right ribbon-shadow ribbon-border-dash-vert ribbon-color-success uppercase">
                                                                                                        <div class="ribbon-sub ribbon-bookmark"></div>
                                                                                                        <i class="fa fa-star"></i>
                                                                                                    </div>';
                                                                                                }
                                                                                                
                                                                                                echo '<b>'. $rowTask["task"] .'</b></br>
                                                                                                <span><b>Assigned To: </b><i>'. $data_assigned_to_id .'</i></span></br>
                                                                                                <span><b>Due Date: </b><i>'. $rowTask["due_date"] .'</i></span></br>
                                                                                                <span><b>Remarks: </b><i>';

                                                                                                    if ( empty($rowTask["remarks"]) ) {

                                                                                                        if ($rowTask["is_completed"] === "0") {
                                                                                                            echo '<span class="label label-sm label-warning">Pending</span>';
                                                                                                        } else if ($rowTask["is_completed"] === "1") {
                                                                                                            echo '<span class="label label-sm label-success">Completed</span>';
                                                                                                        } else if ($rowTask["is_completed"] === "2") {
                                                                                                            echo '<span class="label label-sm label-danger">Canceled</span>';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '<span>'. $rowTask["remarks"] .'</span>';
                                                                                                    }


                                                                                                echo '</i></span>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <div class="btn-group btn-group-circle">
                                                                                                    <button type="button" class="btn btn-outline dark btn-sm btnEditTask" 
                                                                                                        data-id="'. $rowTask["ID"] .'"
                                                                                                        data-task="'. $rowTask["task"] .'"
                                                                                                        data-assigned="'. $rowTask["assigned_to_id"] .'"
                                                                                                        data-date="'. $rowTask["due_date"] .'"
                                                                                                        data-priority="'. $rowTask["priority"] .'"
                                                                                                        >Edit</button>
                                                                                                    <button type="button" class="btn btn-outline red btn-sm btnDeleteTask" data-id="'. $rowTask["ID"] .'">Delete</button>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>';
                                                                                    }
                                                                                    
                                                                                } else {
                                                                                    echo '<tr class="text-center text-default"><td colspan="2">Empty Record</td></tr>';
                                                                                }
                                                                            ?>
                                                                       </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                    <input type="reset" class="btn dark" name="btnReset_USER_Task" id="btnReset_USER_Task" value="Rreset" />
                                                    <input type="submit" class="btn green" name="btnSave_USER_Task" id="btnSave_USER_Task" value="Save" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade bs-modal-lg" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data" class="form-horizontal modalUpload">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Upload File</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Description</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Document</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="file" name="file" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label"></label>
                                                        <div class="col-md-10">
                                                            <div class="portlet-body">
                                                                <div class="table-scrollable">
                                                                    <table class="table table-bordered table-hover" id="tableUpload">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>File(s)</th>
                                                                                <th class="text-center" style="width: 130px;">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $profileSidebarUpload = 0;
                                                                                $selectUpload = mysqli_query( $conn,"SELECT * FROM tbl_user_upload WHERE is_remove = 0 AND user_id = $current_userID" );
                                                                                if ( mysqli_num_rows($selectUpload) > 0 ) {
                                                                                    while($rowUpload = mysqli_fetch_array($selectUpload)) {
                                                                                        $profileSidebarUpload++;

                                                                                        echo '<tr id="tr_'. $rowUpload["ID"] .'">
                                                                                            <td>';
                                                                                                if ( !empty( $rowUpload["description"] ) ) {
                                                                                                    echo '<span>'. $rowUpload["description"] .'</span></br>';
                                                                                                }
                                                                                                
                                                                                                echo '<a href="uploads/'. $rowUpload["files"] .'" target="_blank">'. $rowUpload["files"] .'</a>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <a class="btn red-thunderbird btn-sm uppercase btnRemoveUpload" data-id="'. $rowUpload["ID"] .'"><i class="fa fa-times"></i> Remove</a>
                                                                                            </td>
                                                                                        </tr>';
                                                                                    }
                                                                                    
                                                                                } else {
                                                                                    echo '<tr class="text-center text-default"><td colspan="2">Empty Record</td></tr>';
                                                                                }
                                                                            ?>
                                                                       </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                                    <input type="submit" class="btn green" name="btnSave_USER_Upload" id="btnSave_USER_Upload" value="Save" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- PORTLET MAIN -->
                                <div class="portlet light hide">
                                    <!-- STAT -->
                                    <div class="row list-separated profile-stat ">
                                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="modal" href="#modalProject">
                                            <div class="uppercase profile-stat-title" id="profileSidebarProject"><?php echo $profileSidebarProject; ?></div>
                                            <div class="uppercase profile-stat-text">Projects</div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="modal" href="#modalTask">
                                            <div class="uppercase profile-stat-title" id="profileSidebarTask"><?php echo $profileSidebarTask; ?></div>
                                            <div class="uppercase profile-stat-text">Tasks</div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="modal" href="#modalUpload">
                                            <div class="uppercase profile-stat-title" id="profileSidebarUpload"><?php echo $profileSidebarUpload; ?></div>
                                            <div class="uppercase profile-stat-text">Uploads</div>
                                        </div>
                                    </div>
                                    <!-- END STAT -->
                                    <div >
                                        <h4 class="profile-desc-title">About <?php echo $current_userFName .' '. $current_userLName; ?></h4>
                                        <span class="profile-desc-text" id="profileAbout"><?php echo $current_userAbout; ?></span><br/>
                                        <span class="profile-desc-text font-grey-salt" id="profileInterest"><?php echo $current_userInterest; ?></span>
                                        <div class="margin-top-20 profile-desc-link <?php echo empty($current_userWebsite) ? "display-hide" : ""; ?>">
                                            <i class="fa fa-globe"></i>
                                            <a href="<?php echo $current_userWebsite; ?>" target="_blank" id="profileWebsite"><?php echo $current_userWebsite; ?></a>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link <?php echo empty($current_userLinkedIn) ? "display-hide" : ""; ?>">
                                            <i class="fa fa-linkedin"></i>
                                            <a href="https://linkedin.com/<?php echo $current_userLinkedIn; ?>" target="_blank" id="profileLinkedIn">@<?php echo $current_userLinkedIn; ?></a>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link <?php echo empty($current_userFacebook) ? "display-hide" : ""; ?>">
                                            <i class="fa fa-facebook"></i>
                                            <a href="https://facebook.com/<?php echo $current_userFacebook; ?>" target="_blank" id="profileFacebook"><?php echo $current_userFacebook; ?></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->