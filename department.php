<?php 
    $title = "Department";
    $site = "department";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'HR';
    $target = '';
    $datafancybox = 'data-fancybox';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 1, 'Total Active Department')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Department</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-arrow-up"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success green-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 2, 'Total Inactive Department')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Department</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-arrow-down"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success red-haze"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 3, 'No. of Dept. not yet performed by employee')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>No. of Dept. not yet performed by employee</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 4, 'No. of Department with no Document')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>No. of Department with no Document</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-doc"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success purple-soft"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <span class="icon-directions font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">List of Departments</span>
                                        <?php
                                            if($current_client == 0) {
                                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $type_id = $row["type"];
                                                    $file_title = $row["file_title"];
                                                    $video_url = $row["youtube_link"];
                                                    
                                                    $file_upload = $row["file_upload"];
                                                    if (!empty($file_upload)) {
                                        	            $fileExtension = fileExtension($file_upload);
                                        				$src = $fileExtension['src'];
                                        				$embed = $fileExtension['embed'];
                                        				$type = $fileExtension['type'];
                                        				$file_extension = $fileExtension['file_extension'];
                                        	            $url = $base_url.'uploads/instruction/';
                                        
                                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                                    }
                                                    
                                                    $icon = $row["icon"];
                                                    if (!empty($icon)) { 
                                                        if ($type_id == 0) {
                                                            echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        } else {
                                                            echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                                        }
                                                    }
	                                            }
                                            }
                                        ?>
                                        <div class="actions" style="display: inline-block;" tabbable-line>
                                            <div class="btn-group">
                                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                        <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')">Add New Department</a>
                                                    </li>
                                                    <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                        <li>
                                                            <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_actions_active" data-toggle="tab">Active</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_inactive" data-toggle="tab">Inactive</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_actions_active">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableData">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px;">Nos.</th>
                                                            <th>Department Name</th>
                                                            <th>Description</th>
                                                            <!-- <th>Compliance %</th> -->
                                                            <th style="width: 100px;" class="text-center">Document</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 150px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE deleted = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY title" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $filetype = htmlentities($row['filetype'] ?? '');
                                                                    $files = htmlentities($row["files"] ?? '');
                                                                    $type = 'iframe';
                                                                    if (!empty($files)) {
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($files);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/';

                                                                            $files = $src.$url.rawurlencode($files).$embed;
                                                                        } else if ($filetype == 3) {
                                                                            $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                        } else if ($filetype == 4) {
                                                                            $file_extension = 'fa-strikethrough';
                                                                            $target = '_blank';
                                                                            $datafancybox = '';
                                                                        }
                                                                    }
                                                                    
                                                                    echo '<tr id="tr_'. $row["ID"] .'">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["title"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["description"] ?? '') .'</td>
                                                                        <td class="text-center"><p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-link" target="'.$target.'">View</a></p></td>';
        
                                                                        // $dept_id = $row["ID"];
                                                                        // $countDepartment = 0;
                                                                        // $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE department_id = $dept_id " );
                                                                        // if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        //     while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                        //         $countDepartment++;
                                                                        //     }
                                                                        // }
                                                                        // $capacityPercentage = intval( ( $countDepartment / $row["capacity"] ) * 100);
                                                                        // echo '<td>'. intval($capacityPercentage) .'% ('. $countDepartment .'/'. $row["capacity"] .')</td>';
        
                                                                        echo '<td class="text-center">';
                                                                            if ( $row["status"] == 0 ) {
                                                                                echo '<span class="label label-sm label-danger">Inactive</span>';
                                                                            } else if ( $row["status"] == 1 ) {
                                                                                echo '<span class="label label-sm label-success">Active</span>';
                                                                            } else {
                                                                                echo '<span class="label label-sm label-warning">Suspended</span>';
                                                                            }
                                                                        echo '</td>
                                                                        <td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].', '.$table_counter++.', \'modalView\')">View</a>
                                                                            <a class="btn btn-danger red" onclick="btnDelete('. $row["ID"].', this)">Delete</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="6">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_inactive">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataInactive">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px;">Nos</th>
                                                            <th>Department Name</th>
                                                            <th>Description</th>
                                                            <!-- <th>Compliance %</th> -->
                                                            <th style="width: 100px;" class="text-center">Document</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 150px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE deleted = 0 AND status = 0 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY title" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $filetype = htmlentities($row['filetype'] ?? '');
                                                                    $files = htmlentities($row["files"] ?? '');
                                                                    $type = 'iframe';
                                                                    if (!empty($files)) {
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($files);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/';

                                                                            $files = $src.$url.rawurlencode($files).$embed;
                                                                        } else if ($filetype == 3) {
                                                                            $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                        } else if ($filetype == 4) {
                                                                            $file_extension = 'fa-strikethrough';
                                                                            $target = '_blank';
                                                                            $datafancybox = '';
                                                                        }
                                                                    }
                                                                    
                                                                    echo '<tr id="tr_'. $row["ID"] .'">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["title"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["description"] ?? '') .'</td>
                                                                        <td class="text-center"><p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-link">View</a></p></td>';
        
                                                                        // $dept_id = $row["ID"];
                                                                        // $countDepartment = 0;
                                                                        // $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE department_id = $dept_id " );
                                                                        // if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        //     while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                        //         $countDepartment++;
                                                                        //     }
                                                                        // }
                                                                        // $capacityPercentage = intval( ( $countDepartment / $row["capacity"] ) * 100);
                                                                        // echo '<td>'. intval($capacityPercentage) .'% ('. $countDepartment .'/'. $row["capacity"] .')</td>';
        
                                                                        echo '<td class="text-center">';
                                                                            if ( $row["status"] == 0 ) {
                                                                                echo '<span class="label label-sm label-danger">Inactive</span>';
                                                                            } else if ( $row["status"] == 1 ) {
                                                                                echo '<span class="label label-sm label-success">Active</span>';
                                                                            } else {
                                                                                echo '<span class="label label-sm label-warning">Suspended</span>';
                                                                            }
                                                                        echo '</td>
                                                                        <td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].', '.$table_counter++.', \'modalView\')">View</a>
                                                                            <a class="btn btn-danger red" onclick="btnDelete('. $row["ID"].', this)">Delete</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="6">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalSave">
                                    <!-- <form method="post" class="form-horizontal modalSave"> -->
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Department Form</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $switch_user_id; ?>" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Department Name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="title" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="description" style="height:150px;" required ></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group <?php echo $_COOKIE['client'] == 1 ? 'hide':''; ?>">
                                                <label class="col-md-3 control-label">Document</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                        <option value="0">Select option</option>
                                                        <option value="1">Manual Upload</option>
                                                        <option value="2">Youtube URL</option>
                                                        <option value="3">Google Drive URL</option>
                                                        <option value="4">Sharepoint URL</option>
                                                    </select>
                                                    <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                    <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                </div>
                                            </div>
                                            <div class="form-group hide">
                                                <label class="col-md-3 control-label">Employee Capacity</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="capacity" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_Department" id="btnSave_HR_Department" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Department Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_Department" id="btnUpdate_HR_Department" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                        
                        <!--Emjay modal-->
                        
                        <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" action="controller.php">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Upload Demo Video</h4>
                                        </div>
                                        <div class="modal-body">
                                                <label>Video Title</label>
                                                <input type="text" id="file_title" name="file_title" class="form-control mt-2">
                                                <?php if($switch_user_id != ''): ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">
                                                <?php else: ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $current_userEmployerID ?>">
                                                <?php endif; ?>
                                                <label style="margin-top:15px">Video Link</label>
                                                <!--<input type="file" id="file" name="file" class="form-control mt-2">-->
                                                <input type="text" class="form-control" name="youtube_link">
                                                <input type="hidden" name="page" value="<?= $site ?>">

                                                <!--<label style="margin-top:15px">Privacy</label>-->
                                                <!--<select class="form-control" name="privacy" id="privacy" required>-->
                                                <!--    <option value="Private">Private</option>-->
                                                <!--    <option value="Public">Public</option>-->
                                                <!--</select>-->
                                            
                                            <div style="margin-top:15px" id="message">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success" name="save_video"><span id="save_video_text">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="view_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Demo Video</h4>
                                        </div>

                                        <div class="modal-body">
                                            <!--<video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">-->
                                            <!--  <source src="" >-->
                                            <!--    Your browser does not support the video tag.-->
                                            <!--</video>-->
                                            <!--<iframe id="myVideo" class="embed-responsive-item" width="320" height="240" src="" allowfullscreen></iframe>-->
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe id="myVideo" class="embed-responsive-item" width="560" height="315" src="" allowfullscreen></iframe>
                                             </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalSummary" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalSummary">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Summary</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;">Nos</th>
                                                        <th>Department Name</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTENT BODY --> 

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript">
            $(document).ready(function(){
                // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "department";
                var user_id = $('#switch_user_id').val();
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
    			    $.ajax({
        				method:"POST",
        				url:"controller.php",
        				data:fd,
        				processData: false, 
                        contentType: false,  
                        timeout: 6000000,
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
    			
                // Emjay script ends here
                
                var site = '<?php echo $site; ?>';
                $.ajax({
                    url: 'function.php?counterup='+site,
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
            });

            function summary(id, type, title) {
                $.ajax({
                    type: "GET",
                    url: "function.php?summary="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalSummary .modal-header .modal-title").html(title);
                        $("#modalSummary .modal-body table tbody").html(data);
                    }
                });
            }
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function btnView(id, count, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_HR_Department="+id+"&c="+count,             
                    dataType: "html",                  
                    success: function(data){                    
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            function btnDelete(id, e) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_HR_Department="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                //formObj = $(this).parents().parents();
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_Department',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_Department'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var tbl_counter = $("#tableData tbody > tr").length + 1;
                            var obj = jQuery.parseJSON(response);
                            
                            var result = '<tr id="tr_'+obj.ID+'">';
                            result += '<td>'+tbl_counter+'</td>';
                            result += '<td>'+obj.title+'</td>';
                            result += '<td>'+obj.description+'</td>';
                            // result += '<td>0% (0/'+obj.capacity+')</td>';
                            result += '<td class="text-center">'+obj.viewFile+'</td>';
                            result += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                            result += '<td class="text-center">';
                                result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', '+tbl_counter+', \'modalView\')">View</a>';
                                result += '<a class="btn btn-danger red" onclick="btnDelete('+obj.ID+', this)">Delete</a>';
                            result += '</td>';
                            result += '</tr>';

                            $('#tableData tbody').append(result);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            $('.counterup').counterUp();
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_HR_Department',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_Department'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.c+'</td>';
                            result += '<td>'+obj.title+'</td>';
                            result += '<td>'+obj.description+'</td>';
                            // result += '<td>'+obj.compliance+'</td>';

                            result += '<td class="text-center">'+obj.viewFile+'</td>';
                            result += '<td class="text-center">';
                                if ( obj.status == 1) { result += '<span class="label label-sm label-success">Active</span>'; }
                                else { result += '<span class="label label-sm label-danger">Inactive</span>'; }
                            result += '</td>';
                            result += '<td class="text-center">';
                                result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', '+obj.c+', \'modalView\')">View</a>';
                                result += '<a class="btn btn-danger red" onclick="btnDelete('+obj.ID+', this)">Delete</a>';
                            result += '</td>';

                            // Check if Active or Inactive
                            if (obj.status == 1) {

                                // Check if existing or not
                                if ($('#tableData tbody #tr_'+obj.ID).length > 0) {
                                    $('#tableData tbody #tr_'+obj.ID).html(result);
                                } else {
                                    var result2 = '<tr id="tr_'+obj.ID+'" class="content">';
                                    result2 += result;
                                    result2 += '</tr>';
                                    $('#tableData tbody').append(result2);
                                    $('#tableDataInactive tbody #tr_'+obj.ID).remove();
                                }
                            } else {

                                // Check if existing or not
                                if ($('#tableDataInactive tbody #tr_'+obj.ID).length > 0) {
                                    $('#tableDataInactive tbody #tr_'+obj.ID).html(result);
                                } else {
                                    var result2 = '<tr id="tr_'+obj.ID+'" class="content">';
                                    result2 += result;
                                    result2 += '</tr>';
                                    $('#tableDataInactive tbody').append(result2);
                                    $('#tableData tbody #tr_'+obj.ID).remove();
                                }
                            }

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusNotYetPerform) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusFiles) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNotYetPerform+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusFiles+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            $('.counterup').counterUp();
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
        </script>
    </body>
</html>