<?php 
    $title = "Job Description";
    $site = "job-description";
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
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 1, 'Total Active Job desc.')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Job desc.</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-note"></i></div>
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
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 2, 'Total Inactive Job Desc.')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Job Desc.</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-folder"></i></div>
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
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 3, 'No. of Job Desc. w/no Employee')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>No. of Job Desc. w/no Employee</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-book-open"></i></div>
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
                        <div class="col-md-3" onclick="summary(<?php echo $switch_user_id; ?>, 4, 'Total Job Desc. w/no training')" href="#modalSummary" data-toggle="modal">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>Total Job Desc. w/no training</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-list"></i></div>
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
                        <div class="col-md-3">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Department</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT ID, title FROM tbl_hr_department WHERE deleted = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY title" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            while($row = mysqli_fetch_array($result)) {

                                                                echo '<tr id="tr_'.$row["ID"].'" onclick="btnViewType('.$row["ID"].')">
                                                                    <td>'.htmlentities($row["title"] ?? '').'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <span class="icon-notebook font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">List of Job Descriptions</span>
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
                                        <div class="actions" style="display: inline-block;">
                                            <div class="btn-group">
                                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                        <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')">Add New Job Description</a>
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
                                                            <th>Nos.</th>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>No. of Trainings Required</th>
                                                            <th style="width: 100px;" class="text-center">Document</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 150px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT
                                                                j.ID AS j_ID,
                                                                j.user_id AS j_user_id,
                                                                j.title AS j_title,
                                                                j.description AS j_description,
                                                                j.files AS j_files,
                                                                j.filetype AS j_filetype,
                                                                j.status AS j_status,
        
                                                                -- t.ID AS t_ID,
                                                                COUNT(t.job_description_id) AS t_job_description_id
        
                                                                FROM tbl_hr_job_description AS j
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    ID, 
                                                                    user_id,
                                                                    job_description_id
                                                                    FROM tbl_hr_trainings
                                                                    WHERE status = 1
                                                                    AND user_id = $switch_user_id
                                                                    AND facility_switch = $facility_switch_user_id
                                                                    AND deleted = 0
                                                                ) AS t 
                                                                ON FIND_IN_SET(j.ID, REPLACE(t.job_description_id, ' ', ''))
                                                                WHERE j.status = 1
                                                                AND j.user_id = $switch_user_id
                                                                AND j.facility_switch = $facility_switch_user_id
                                                                GROUP BY j.ID

                                                                ORDER BY j.title" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $filetype = htmlentities($row['j_filetype'] ?? '');
                                                                    $files = htmlentities($row["j_files"] ?? '');
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
                                                                    
                                                                    echo '<tr id="tr_'. $row["j_ID"] .'">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["j_title"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["j_description"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["t_job_description_id"] ?? '') .'</td>
                                                                        <td class="text-center"><p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-link" target="'.$target.'">View</a></p></td>';
        
                                                                        if ( $row["j_status"] == 0 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                                        } else if ( $row["j_status"] == 1 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                                        } else {
                                                                            echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                                        }
        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["j_ID"].', '.$table_counter++.', \'modalView\')">View</a>
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
                                                            <th>Nos.</th>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>No. of Trainings Required</th>
                                                            <th style="width: 100px;" class="text-center">Document</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 150px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT
                                                                j.ID AS j_ID,
                                                                j.user_id AS j_user_id,
                                                                j.title AS j_title,
                                                                j.description AS j_description,
                                                                j.files AS j_files,
                                                                j.filetype AS j_filetype,
                                                                j.status AS j_status,
        
                                                                -- t.ID AS t_ID,
                                                                COUNT(t.job_description_id) AS t_job_description_id
        
                                                                FROM tbl_hr_job_description AS j
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    ID, 
                                                                    user_id,
                                                                    job_description_id
                                                                    FROM tbl_hr_trainings
                                                                    WHERE status = 1
                                                                    AND user_id = $switch_user_id
                                                                    AND facility_switch = $facility_switch_user_id
                                                                    AND deleted = 0
                                                                ) AS t 
                                                                ON FIND_IN_SET(j.ID, REPLACE(t.job_description_id, ' ', ''))
                                                                WHERE j.status = 0
                                                                AND j.user_id = $switch_user_id
                                                                AND j.facility_switch = $facility_switch_user_id
                                                                GROUP BY j.ID

                                                                ORDER BY j.title" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $filetype = htmlentities($row['j_filetype'] ?? '');
                                                                    $files = htmlentities($row["j_files"] ?? '');
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
                                                                    
                                                                    echo '<tr id="tr_'. $row["j_ID"] .'">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["j_title"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["j_description"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["t_job_description_id"] ?? '') .'</td>
                                                                        <td class="text-center"><p class="'; echo !empty($files) ? '':'hide'; echo '" style="margin: 0;"><a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-link" target="'.$target.'">View</a></p></td>';
        
                                                                        if ( $row["j_status"] == 0 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                                        } else if ( $row["j_status"] == 1 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                                        } else {
                                                                            echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                                        }
        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["j_ID"].', '.$table_counter++.', \'modalView\')">View</a>
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
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Job Description Form</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <input class="form-control" type="hidden" name="ID" value="<?php echo $switch_user_id; ?>" />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Title</label>
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
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Department</label>
                                                <div class="col-md-8">
                                                    <select class="form-control mt-multiselect btn btn-default" name="department_id[]" multiple="multiple" required>
                                                        <option value="">Select</option>

                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT ID, title FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    echo '<option value="'. $row["ID"] .'">'. htmlentities($row["title"] ?? '') .'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
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
                                        </div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_Job_Description" id="btnSave_HR_Job_Description" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
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
                                            <h4 class="modal-title">Job Description Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_Job_Description" id="btnUpdate_HR_Job_Description" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-modal-lg" id="modalViewTraining" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdateTraining">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Training Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
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
                                                        <th>Title</th>
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
                var action_data = "job-description";
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
                        var pct_counter3 = (parseInt(obj.statusNoEmployee) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusNoTraining) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoEmployee+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoTraining+'"></span>');
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
                    url: "function.php?summary_JD="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalSummary .modal-header .modal-title").html(title);
                        $("#modalSummary .modal-body table tbody").html(data);
                    }
                });
            }

            function uiBlock() {
                $('#tableData').block({
                    message: '<div class="loading-message loading-message-boxed bg-white"><img src="assets/global/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;LOADING...</span></div>', 
                    css: { border: '0', width: 'auto' } 
                });
            }
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function btnViewType(id) {
                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Job_Description_Type="+id+"&status=1",
                    dataType: "html",
                    success: function(data){
                        $("#tableData tbody").html(data);
                        $('#tableData').unblock();
                    }
                });

                uiBlock();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Job_Description_Type="+id+"&status=0",
                    dataType: "html",
                    success: function(data2){
                        $("#tableDataInactive tbody").html(data2);
                        $('#tableDataInactive').unblock();
                    }
                });
            }
            function btnView(id, count, view) {
                btnClose(view);
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Job_Description="+id+"&c="+count,             
                    dataType: "html",                  
                    success: function(data){                    
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                        selectMulti();
                    }
                });
            }
            function btnViewTraining(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_HR_Job_Description_Training="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewTraining .modal-body").html(data);
                        repeaterForm();
                    }
                });
            }
            function repeaterForm() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }

            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_Job_Description',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_Job_Description'));
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
                                result += '<td>'+obj.countTraining+'</td>';
                                result += '<td class="text-center">'+obj.viewFile+'</td>';
                                result += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                result += '<td class="text-center">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', '+tbl_counter+', \'modalView\')">View</a>';
                                    // result += '<a class="btn btn-danger red" onclick="btnDelete('+obj.ID+', this)">Delete</a>';
                                result += '</td>';
                            result += '</tr>';

                            $('#tableData tbody').append(result);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(obj.statusNoEmployee) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusNoTraining) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoEmployee+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoTraining+'"></span>');
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
                formData.append('btnUpdate_HR_Job_Description',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_Job_Description'));
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
                            var tbl_counter = $("#tableData tbody > tr").length + 1;
                            var result = '<td>'+obj.c+'</td>';
                            result += '<td>'+obj.title+'</td>';
                            result += '<td>'+obj.description+'</td>';
                            result += '<td>'+obj.countTraining+'</td>';
                            result += '<td class="text-center">'+obj.viewFile+'</td>';

                            if ( obj.status == 1) {
                                result += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                            } else {
                                result += '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                            }
                            
                            result += '<td class="text-center">';
                                result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', '+obj.c+', \'modalView\')">View</a>';
                                // result += '<a class="btn btn-danger red" onclick="btnDelete('+obj.ID+', this)">Delete</a>';
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
                            var pct_counter3 = (parseInt(obj.statusNoEmployee) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusNoTraining) / parseInt(obj.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoEmployee+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusNoTraining+'"></span>');
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