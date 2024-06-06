<?php
    $title = "Employee";
    $site = "employee";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'HR';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Employee</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-following"></i></div>
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
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Employee</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-unfollow"></i></div>
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
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small><?php echo $_COOKIE['client'] == 1 ? 'Total Suspended Employee':'Current Inactive Employee'; ?></small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-calendar"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage <?php echo $_COOKIE['client'] == 1 ? '':'for this month'; ?></small></div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>TOTAL EMPLOYEE</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
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
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">List of Employees</span>
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
                                                    if (!empty($icon)) { echo '<img src="'.$src.$url.rawurlencode($icon).'" style="width: 32px; height: 32px; object-fit: contain; object-position: center;" />'; }
                                                    if ($type_id == 0) {
                                                        echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'">'.$file_title.'</a>';
                                                    } else {
                                                        echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox>'.$file_title.'</a>';
                                                    }
	                                            }
                                                
                                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                                    echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="#modalNew" class="btn btn-circle btn-success btn-xs" data-toggle="modal" onclick="btnNew(<?php echo $switch_user_id; ?>, <?php echo $current_client; ?>, 'modalNew')">Add New Employee</a>
                                        <?php if($_COOKIE['ID'] == 456):?>
                                        <a href="#surverFormModal" class="btn btn-circle btn-success btn-xs" data-toggle="modal" onclick="btnReset('surverFormModal')">Food Safety Culture Survey</a>
                                        <?php endif;?>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a onclick="selectFilter(1)" href="#tab_actions_active" data-toggle="tab">Active</a>
                                        </li>
                                        <li>
                                            <a onclick="selectFilter(1)" href="#tab_actions_inactive" data-toggle="tab">Inactive</a>
                                        </li>
                                        <li>
                                            <a onclick="selectFilter(1)" href="#tab_actions_suspended" data-toggle="tab">Suspended</a>
                                        </li>
                                        <li>
                                            <a onclick="selectFilter(0)" href="#tab_actions_report" data-toggle="tab">Report</a>
                                        </li>
                                        <li class="<?php echo $switch_user_id == 1 OR $switch_user_id == 5 ? '':'hide'; ?>">
                                            <a onclick="selectFilter(0)" href="#tab_actions_chart" data-toggle="tab">Organizational Chart</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <select id='filterText' style='display:inline-block' onchange='filterText()'>
                                            <option disabled selected>Select</option>
                                            <option value='Consultant'>Consultant</option>
                                            <option value='Contractor'>Contractor</option>
                                            <option value='Freelance'>Freelance</option>
                                            <option value='Full-time'>Full-time</option>
                                            <option value='OJT'>OJT</option>
                                            <option value='Part-Time Apprentice'>Part-Time Apprentice</option>
                                            
                                            <?php 
                                                echo $_COOKIE['client'] == 1 ? '<option value=\'Part-Time\'>Part-Time</option><option value=\'Salaried\'>Salaried</option><option value=\'Seasonal\'>Seasonal</option>':'<option value=\'Part-Time Project\'>Part-Time Project</option>';
                                            ?>
                                            
                                            <option value='Trainee'>Trainee</option>
                                            <option value='all'>All</option>
                                        </select>
                                        <div class="tab-pane active" id="tab_actions_active">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableData">
                                                    <thead>
                                                        <tr>
                                                            <th>Nos.</th>
                                                            <th>Last Name</th>
                                                            <th>First Name</th>
                                                            <th>Position</th>
                                                            <th>Email</th>
                                                            <th style="width: 100px;" class="text-center">Date Hired</th>
                                                            <th style="width: 150px;">Employment Type</th>
                                                            <th class="hide">Employee File/s</th>
                                                            <th class="hide">Files for Follow-up</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 100px;" class="text-center">Registered</th>
                                                            <th style="width: 80px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY last_name " );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $email = $row["email"];
                                                                    if ($_COOKIE['client'] == 1) {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    } else {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time Project',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    }

                                                                    $position = array();
                                                                    $jd = $row["job_description_id"];
                                                                    if (!empty($jd)) {
                                                                        $jd_arr = explode(", ", $jd);
                                                                        foreach ($jd_arr as $value) {
                                                                            $resultJD = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID = $value" );
                                                                            if ( mysqli_num_rows($resultJD) > 0 ) {
                                                                                $rowJD = mysqli_fetch_array($resultJD);
                                                                                array_push($position, $rowJD["title"]);
                                                                            }
                                                                        }
                                                                    }
                                                                    $position = implode(', ', $position);
                                                                    
                                                                    echo '<tr id="tr_'. $row["ID"] .'" class="content">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["last_name"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["first_name"] ?? '') .'</td>
                                                                        <td>'. $position .'</td>
                                                                        <td>'. htmlentities($email ?? '') .'</td>
                                                                        <td class="text-center">'. $row["date_hired"] .'</td>
                                                                        <td>'. $employment_type[$row["type_id"]] .'</td>
                                                                        <td class="hide">0</td>
                                                                        <td class="hide">0</td>';

                                                                        if ( $row["suspended"] == 1 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                                        }
                                                                        else {
                                                                            if ( $row["status"] == 0 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                                            } else if ( $row["status"] == 1 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                                            }
                                                                        }

                                                                        echo '<td class="text-center">';
                                                                            $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE email ='".$email."'" );
                                                                            if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                echo '<span class="label label-sm label-success">Yes</span>';
                                                                            } else {
                                                                                echo '<span class="label label-sm label-danger">No</span>';
                                                                            }
                                                                        echo '</td>';
                                                                        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].', \'modalView\', '.$table_counter++.')">View</a>';
                                                                        if($switch_user_id == 34){
                                                                            echo '
                                                                             <a href="#set_details" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="set_id('. $row["ID"].')">Set</a>
                                                                            ';
                                                                        }
                                                                    echo  '</td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="9">Empty Record</td></tr>';
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
                                                            <th>Last Name</th>
                                                            <th>First Name</th>
                                                            <th>Position</th>
                                                            <th>Email</th>
                                                            <th style="width: 100px;" class="text-center">Date Hired</th>
                                                            <th style="width: 150px;">Employment Type</th>
                                                            <th class="hide">Employee File/s</th>
                                                            <th class="hide">Files for Follow-up</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 100px;" class="text-center">Registered</th>
                                                            <th style="width: 80px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 0 AND user_id = $switch_user_id ORDER BY last_name " );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $email = $row["email"];
                                                                    if ($_COOKIE['client'] == 1) {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    } else {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time Project',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    }

                                                                    $position = array();
                                                                    $jd = $row["job_description_id"];
                                                                    if (!empty($jd)) {
                                                                        $jd_arr = explode(", ", $jd);
                                                                        foreach ($jd_arr as $value) {
                                                                            $resultJD = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID = $value" );
                                                                            if ( mysqli_num_rows($resultJD) > 0 ) {
                                                                                $rowJD = mysqli_fetch_array($resultJD);
                                                                                array_push($position, $rowJD["title"]);
                                                                            }
                                                                        }
                                                                    }
                                                                    $position = implode(', ', $position);
                                                                    
                                                                    echo '<tr id="tr_'. $row["ID"] .'" class="content">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["last_name"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["first_name"] ?? '') .'</td>
                                                                        <td>'. $position .'</td>
                                                                        <td>'. htmlentities($email ?? '') .'</td>
                                                                        <td class="text-center">'. $row["date_hired"] .'</td>
                                                                        <td>'. $employment_type[$row["type_id"]] .'</td>
                                                                        <td class="hide">0</td>
                                                                        <td class="hide">0</td>';

                                                                        if ( $row["suspended"] == 1 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                                        }
                                                                        else {
                                                                            if ( $row["status"] == 0 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                                            } else if ( $row["status"] == 1 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                                            }
                                                                        }

                                                                        echo '<td class="text-center">';
                                                                            $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE email ='".$email."'" );
                                                                            if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                echo '<span class="label label-sm label-success">Yes</span>';
                                                                            } else {
                                                                                echo '<span class="label label-sm label-danger">No</span>';
                                                                            }
                                                                        echo '</td>';
                                                                        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].', \'modalView\', '.$table_counter++.')">View</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="9">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_suspended">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataSuspended">
                                                    <thead>
                                                        <tr>
                                                            <th>Nos.</th>
                                                            <th>Last Name</th>
                                                            <th>First Name</th>
                                                            <th>Position</th>
                                                            <th>Email</th>
                                                            <th style="width: 100px;" class="text-center">Date Hired</th>
                                                            <th style="width: 150px;">Employment Type</th>
                                                            <th class="hide">Employee File/s</th>
                                                            <th class="hide">Files for Follow-up</th>
                                                            <th style="width: 80px;" class="text-center">Status</th>
                                                            <th style="width: 100px;" class="text-center">Registered</th>
                                                            <th style="width: 80px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 1 AND user_id = $switch_user_id ORDER BY last_name " );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $email = $row["email"];
                                                                    if ($_COOKIE['client'] == 1) {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    } else {
                                                                        $employment_type = array(
                                                                            1 => 'Full-time',
                                                                            2 => 'Part-Time Project',
                                                                            3 => 'OJT',
                                                                            4 => 'Freelance',
                                                                            5 => 'Part-Time Apprentice',
                                                                            6 => 'Trainee',
                                                                            7 => 'Consultant',
                                                                            8 => 'Contractor',
                                                                            9 => 'Salaried',
                                                                            10 => 'Seasonal'
                                                                        );
                                                                    }

                                                                    $position = array();
                                                                    $jd = $row["job_description_id"];
                                                                    if (!empty($jd)) {
                                                                        $jd_arr = explode(", ", $jd);
                                                                        foreach ($jd_arr as $value) {
                                                                            $resultJD = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE ID = $value" );
                                                                            if ( mysqli_num_rows($resultJD) > 0 ) {
                                                                                $rowJD = mysqli_fetch_array($resultJD);
                                                                                array_push($position, $rowJD["title"]);
                                                                            }
                                                                        }
                                                                    }
                                                                    $position = implode(', ', $position);
                                                                    
                                                                    echo '<tr id="tr_'. $row["ID"] .'" class="content">
                                                                        <td>'. $table_counter .'</td>
                                                                        <td>'. htmlentities($row["last_name"] ?? '') .'</td>
                                                                        <td>'. htmlentities($row["first_name"] ?? '') .'</td>
                                                                        <td>'. $position .'</td>
                                                                        <td>'. htmlentities($email ?? '') .'</td>
                                                                        <td class="text-center">'. $row["date_hired"] .'</td>
                                                                        <td>'. $employment_type[$row["type_id"]] .'</td>
                                                                        <td class="hide">0</td>
                                                                        <td class="hide">0</td>';

                                                                        if ( $row["suspended"] == 1 ) {
                                                                            echo '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                                                                        }
                                                                        else {
                                                                            if ( $row["status"] == 0 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                                                            } else if ( $row["status"] == 1 ) {
                                                                                echo '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                                                            }
                                                                        }

                                                                        echo '<td class="text-center">';
                                                                            $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE email ='".$email."'" );
                                                                            if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                echo '<span class="label label-sm label-success">Yes</span>';
                                                                            } else {
                                                                                echo '<span class="label label-sm label-danger">No</span>';
                                                                            }
                                                                        echo '</td>';
                                                                        
                                                                        echo '<td class="text-center">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $row["ID"].', \'modalView\', '.$table_counter++.')">View</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="9">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_report">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableDataReport">
                                                    <thead>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th style="width: 100px;" class="text-center">Active</th>
                                                            <th style="width: 100px;" class="text-center">Inactive</th>
                                                            <th style="width: 100px;" class="text-center">Suspended</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            echo '<tr>
                                                                <td>Full-time</td>
                                                                <td class="text-center">';

                                                                    $selectFTA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FTA FROM tbl_hr_employee WHERE type_id = 1 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                    $rowFTA = mysqli_fetch_array($selectFTA);
                                                                    echo $rowFTA["TOTAL_FTA"];

                                                                echo '</td>
                                                                <td class="text-center">';

                                                                    $selectFTI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FTI FROM tbl_hr_employee WHERE type_id = 1 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                    $rowFTI = mysqli_fetch_array($selectFTI);
                                                                    echo $rowFTI["TOTAL_FTI"];

                                                                echo '</td>
                                                                <td class="text-center">';

                                                                    $selectFTS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FTS FROM tbl_hr_employee WHERE type_id = 1 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                    $rowFTS = mysqli_fetch_array($selectFTS);
                                                                    echo $rowFTS["TOTAL_FTS"];

                                                                echo '</td>
                                                            </tr>
                                                            <tr>';
                                                                echo $_COOKIE['client'] == 1 ? '<td>Part-Time</td>':'<td>Part-Time Project</td>';
                                                                echo '<td class="text-center">';

                                                                    $selectPTA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_PTA FROM tbl_hr_employee WHERE type_id = 2 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                    $rowPTA = mysqli_fetch_array($selectPTA);
                                                                    echo $rowPTA["TOTAL_PTA"];

                                                                echo '</td>
                                                                <td class="text-center">';

                                                                    $selectPTI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_PTI FROM tbl_hr_employee WHERE type_id = 2 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                    $rowPTI = mysqli_fetch_array($selectPTI);
                                                                    echo $rowPTI["TOTAL_PTI"];

                                                                echo '</td>
                                                                <td class="text-center">';

                                                                    $selectPTS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_PTS FROM tbl_hr_employee WHERE type_id = 2 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                    $rowPTS = mysqli_fetch_array($selectPTS);
                                                                    echo $rowPTS["TOTAL_PTS"];

                                                                echo '</td>
                                                            </tr>';

                                                            if ($current_client == 0) {
                                                                echo '<tr>
                                                                    <td>OJT</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTA FROM tbl_hr_employee WHERE type_id = 3 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowOJTA = mysqli_fetch_array($selectOJTA);
                                                                            echo $rowOJTA["TOTAL_OJTA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTI FROM tbl_hr_employee WHERE type_id = 3 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowOJTI = mysqli_fetch_array($selectOJTI);
                                                                            echo $rowOJTI["TOTAL_OJTI"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTS FROM tbl_hr_employee WHERE type_id = 3 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowOJTS = mysqli_fetch_array($selectOJTS);
                                                                            echo $rowOJTS["TOTAL_OJTS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Freelance</td>
                                                                    <td class="text-center">';

                                                                            $selectFA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FA FROM tbl_hr_employee WHERE type_id = 4 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowFA = mysqli_fetch_array($selectFA);
                                                                            echo $rowFA["TOTAL_FA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectFI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FI FROM tbl_hr_employee WHERE type_id = 4 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowFI = mysqli_fetch_array($selectFI);
                                                                            echo $rowFI["TOTAL_FI"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectFS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FS FROM tbl_hr_employee WHERE type_id = 4 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowFS = mysqli_fetch_array($selectFS);
                                                                            echo $rowFS["TOTAL_FS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Part-Time Apprentice</td>
                                                                    <td class="text-center">';

                                                                            $selectIA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IA FROM tbl_hr_employee WHERE type_id = 5 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowIA = mysqli_fetch_array($selectIA);
                                                                            echo $rowIA["TOTAL_IA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectII = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_II FROM tbl_hr_employee WHERE type_id = 5 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowII = mysqli_fetch_array($selectII);
                                                                            echo $rowII["TOTAL_II"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectIS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IS FROM tbl_hr_employee WHERE type_id = 5 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowIS = mysqli_fetch_array($selectIS);
                                                                            echo $rowIS["TOTAL_IS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Trainee</td>
                                                                    <td class="text-center">';

                                                                            $selectIA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IA FROM tbl_hr_employee WHERE type_id = 6 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowIA = mysqli_fetch_array($selectIA);
                                                                            echo $rowIA["TOTAL_IA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectII = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_II FROM tbl_hr_employee WHERE type_id = 6 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowII = mysqli_fetch_array($selectII);
                                                                            echo $rowII["TOTAL_II"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectIS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IS FROM tbl_hr_employee WHERE type_id = 6 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowIS = mysqli_fetch_array($selectIS);
                                                                            echo $rowIS["TOTAL_IS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Consultant</td>
                                                                    <td class="text-center">';

                                                                            $selectIA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IA FROM tbl_hr_employee WHERE type_id = 7 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowIA = mysqli_fetch_array($selectIA);
                                                                            echo $rowIA["TOTAL_IA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectII = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_II FROM tbl_hr_employee WHERE type_id = 7 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowII = mysqli_fetch_array($selectII);
                                                                            echo $rowII["TOTAL_II"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectIS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IS FROM tbl_hr_employee WHERE type_id = 7 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowIS = mysqli_fetch_array($selectIS);
                                                                            echo $rowIS["TOTAL_IS"];

                                                                    echo '</td>
                                                                </tr>';
                                                            } else {
                                                                echo '<tr>
                                                                    <td>Contractor</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTA FROM tbl_hr_employee WHERE type_id = 8 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowOJTA = mysqli_fetch_array($selectOJTA);
                                                                            echo $rowOJTA["TOTAL_OJTA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTI FROM tbl_hr_employee WHERE type_id = 8 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowOJTI = mysqli_fetch_array($selectOJTI);
                                                                            echo $rowOJTI["TOTAL_OJTI"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectOJTS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_OJTS FROM tbl_hr_employee WHERE type_id = 8 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowOJTS = mysqli_fetch_array($selectOJTS);
                                                                            echo $rowOJTS["TOTAL_OJTS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Salaried</td>
                                                                    <td class="text-center">';

                                                                            $selectFA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FA FROM tbl_hr_employee WHERE type_id = 9 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowFA = mysqli_fetch_array($selectFA);
                                                                            echo $rowFA["TOTAL_FA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectFI = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FI FROM tbl_hr_employee WHERE type_id = 9 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowFI = mysqli_fetch_array($selectFI);
                                                                            echo $rowFI["TOTAL_FI"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectFS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_FS FROM tbl_hr_employee WHERE type_id = 9 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowFS = mysqli_fetch_array($selectFS);
                                                                            echo $rowFS["TOTAL_FS"];

                                                                    echo '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Seasonal</td>
                                                                    <td class="text-center">';

                                                                            $selectIA = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IA FROM tbl_hr_employee WHERE type_id = 10 AND status = 1 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowIA = mysqli_fetch_array($selectIA);
                                                                            echo $rowIA["TOTAL_IA"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectII = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_II FROM tbl_hr_employee WHERE type_id = 10 AND status = 0 AND suspended = 0 AND user_id = $switch_user_id" );
                                                                            $rowII = mysqli_fetch_array($selectII);
                                                                            echo $rowII["TOTAL_II"];

                                                                    echo '</td>
                                                                    <td class="text-center">';

                                                                            $selectIS = mysqli_query( $conn,"SELECT COUNT(ID) AS TOTAL_IS FROM tbl_hr_employee WHERE type_id = 10 AND suspended = 1 AND user_id = $switch_user_id" );
                                                                            $rowIS = mysqli_fetch_array($selectIS);
                                                                            echo $rowIS["TOTAL_IS"];

                                                                    echo '</td>
                                                                </tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane <?php echo $switch_user_id == 1 OR $switch_user_id == 5 ? '':'hide'; ?>" id="tab_actions_chart">
                                            <span>* Responsible for Food Safety</span>
                                            <div id="container_chart" style="overflow: auto;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- Modal -->
                        
                        <div class="modal fade" id="surverFormModal" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg" style="width:80%;">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm surverFormModal">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Food Safety Culture Survey Form</h4>
                                        </div>
                                        <div class="modal-body"> 
                                            <input class="form-control" type="hidden" name="client" value="<?php echo $current_client; ?>" />
                                            <div class="form-group">
                                                <?php
                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id = $switch_user_id ORDER BY first_name ASC");
                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                        while($rowEmployee = mysqli_fetch_array($selectEmployee)) { ?>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" value="<?=$rowEmployee["ID"]?>"> &nbsp; <?=$rowEmployee["first_name"] .' '. $rowEmployee["last_name"]?>
                                                    </div>    
                                                <?php } } ?>    
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">Date Completed</label>
                                                    <input class="form-control" type="date" name="date_hired" id="date_hired" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">Status</label>
                                                    <select class="form-control mt-multiselect btn btn-defaultt" name="reporting_to_id">
                                                        <option value="">Select</option>
                                                        <option value="1">Completed</option>
                                                        <option value="0">Incomplete</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="submitSurveyForm" id="submitSurveyForm" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Employee Form</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_Employee" id="btnSave_HR_Employee" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Employee Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNewFile" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalNewFile">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New File</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_HR_File" id="btnSave_HR_File" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditFile" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalEditFile">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Edit File</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_HR_File" id="btnUpdate_HR_File" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employee File -->
                        <div class="modal fade bs-modal-lg" id="set_details" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdateSet">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Other Employee Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="user_id" name="user_id">
                                            <H5>Employee to Approve</H5>
                                            <div class="row" id="checklist"></div>
                                        </div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="update_employe" id="update_employe" data-style="zoom-out"><span class="ladda-label">Update</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                                            
                                            <div style="margin-top:15px" id="message"></div>
                                        </div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
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
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                         <!--Emjay modal-->
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript" src="//www.gstatic.com/charts/loader.js"></script>
        
        <script>
            $('#username').editable();
        </script>
        
        <script type="text/javascript">
            var current_client = '<?php echo $_COOKIE['client']; ?>';
            var site = '<?php echo $site; ?>';
            var switch_user_id = '<?php echo $switch_user_id; ?>';
            
            $(document).ready(function(){
                // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                    $('#save_video').attr('disabled','disabled');
                    $('#save_video_text').text("Uploading...");
                    var action_data = "employee";
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
    			
                // $('.view_videos').click(function(){
                //     var file_name = $(this).attr('file_name')
                //     var vid = document.getElementById("myVideo");
                //     vid.src = "uploads/pages_demo/"+file_name;
                //     $("#myVideo").attr('src', file_name);
                // });
    			
                // Emjay script ends here
                
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
                        var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;

                        var pct_counter3 = 0;
                        if (current_client == 1) { pct_counter3 = (parseInt(obj.statusSuspended) / parseInt(obj.statusTotal)) * 100; }
                        else { pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100; }

                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');

                        if (current_client == 1) { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusSuspended+'"></span>'); }
                        else { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>'); }
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });
                    
                widget_chart(switch_user_id);

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
            });

            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }
            function selectFilter(id) {
                if(id == 0) {
                    $('#filterText').hide();
                } else {
                    $('#filterText').show();
                }
            }
            function filterText() {  
                var rex = new RegExp($('#filterText').val());
                if(rex =="/all/"){
                    clearFilter()
                } else {
                    $('.content').hide();
                    $('.content').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                }
            }
            function clearFilter() {
                $('.filterText').val('');
                $('.content').show();
            }
            function set_id(id){
                $('#user_id').val(id);
                $.get("controller.php", 
                {
                    id: id,
                    action:"get_employee_checklist"
                },
                  function(data){
                    // Display the returned data in browser
                    $('#checklist').html(data);
                    // console.log('done : ' + data);  
                });
            }
            function btnNew(id, current_client, view) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_HR_Employee="+id+"&c="+current_client,
                    dataType: "html",                  
                    success: function(data){
                        $("#modalNew .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            function btnView(id, view, num) {
                btnClose(view);
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Employee="+id+"&num="+num,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                        selectMulti();
                        $(function(){
                            $('#modalView .modal-body .status').editable({
                                source: [
                                      {value: 0, text: 'Not Yet Started'},
                                      {value: 1, text: 'Approved'},
                                      {value: 2, text: 'For Approval'}
                                ],
                                success: function(response, newValue) {
                                    //userModel.set('username', newValue); //update backbone model
                                    if(response.status == 'error') return response.msg; //msg will be shown in editable form
                                }
                            });
                            fancyBoxes();
                        });
                    }
                });
            }
            function btnReinvite(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?resend="+id,
                    dataType: "html",
                    success: function(data){
                        msg = "Re-invite Sent!";
                        bootstrapGrowl(msg);
                    }
                });
            }
            function btnCopy(id) {
                $('#copy_'+id).select();
                document.execCommand("copy");
            }
            function widget_date() {
                $('.daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto"
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_chart(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_HR_Employee_Chart="+id,
                    dataType: "html",
                    success: function(data_chart){
                        chart_org = JSON.parse(data_chart);
                        // console.log(data_chart);

                        google.charts.load('current', {packages:["orgchart"]});
                        google.charts.setOnLoadCallback(drawChart);
                        
                        function drawChart() {
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Name');
                            data.addColumn('string', 'Manager');
                            data.addColumn('string', 'ToolTip');
                            
                            // For each orgchart box, provide the name, manager, and tooltip to show.
                            data.addRows(
                                chart_org
                            );
                            
                            // Create the chart.
                            var chart = new google.visualization.OrgChart(document.getElementById('container_chart'));

                            // selection
                            google.visualization.events.addListener(chart, 'select', function () {
                                // get the row of the node clicked
                                var selection = chart.getSelection();
                                var row = selection[0].row;
                                // get a list of all collapsed nodes
                                var collapsed = chart.getCollapsedNodes();
                                // if the node is collapsed, we want to expand it
                                // if it is not collapsed, we want to collapse it
                                var collapse = (collapsed.indexOf(row) == -1);
                                chart.collapse(row, collapse);
                                // clear the selection so the next click will work properly
                                chart.setSelection();
                            });
                            
                            // Draw the chart, setting the allowHtml option to true for the tooltips.
                            chart.draw(data, {'allowHtml':true});
                        }
                    }
                });
            }
            
            // Emjay Submit Form
            $(".modalUpdateSet").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('update_employe',true);

                var l = Ladda.create(document.querySelector('#update_employe'));
                l.start();

                $.ajax({
                    url: "controller.php",
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
                    success:function(response) {
                        msg = "Sucessfully updated!";
                        l.stop();
                        $('#set_details').modal('hide');
                        bootstrapGrowl(msg);
                    }
                });
            }));
            // Emjay Submit Form End

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_HR_Employee',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_Employee'));
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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var tbl_counter = $("#tableData tbody > tr").length + 1;

                            if (obj.exist == false) {
                                var data = '<tr id="tr_'+obj.ID+'" class="content">';
                                    data += '<td>'+tbl_counter+'</td>';
                                    data += '<td>'+obj.last_name+'</td>';
                                    data += '<td>'+obj.first_name+'</td>';
                                    data += '<td>'+obj.position+'</td>';
                                    data += '<td>'+obj.email+'</td>';
                                    data += '<td>'+obj.date_hired+'</td>';
                                    data += '<td>'+obj.employment_type+'</td>';
                                    data += '<td class="hide">0</td>';
                                    data += '<td class="hide">0</td>';

                                    if ( obj.suspended == 1) {
                                        data += '<td><span class="label label-sm label-warning">Suspended</span></td>';
                                    } else {
                                        if ( obj.status == 1) {
                                            data += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                        } else {
                                            data += '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                        }
                                    }
                                    
                                    data += '<td class="text-center">'+obj.registered+'</td>';
                                    data += '<td class="text-center">';
                                        data += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', \'modalView\', '+obj.num+')">View</a>';
                                        
                                        if (obj.ID == 34) {
                                            data += '<a href="#set_details" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="set_id('+obj.ID+')">Set</a>';
                                        }
                                    data += '</td>';
                                data += '</tr>';
                            
                                $('#tableData tbody').append(data);

                                // CounterUp Section
                                var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                                var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                                var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;

                                var pct_counter3 = 0;
                                if (current_client == 1) { pct_counter3 = (parseInt(obj.statusSuspended) / parseInt(obj.statusTotal)) * 100; }
                                else { pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100; }

                                $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                                $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                                $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                                $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                                $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                                $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                                $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                                $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                                $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');

                                if (current_client == 1) { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusSuspended+'"></span>'); }
                                else { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>'); }
                                $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                                $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');
                                
                                $('.counterup').counterUp();
                            } else {
                                msg = obj.message;
                            }
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalView").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_HR_Employee',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_Employee'));
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
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var data = '<td>'+obj.num+'</td>';
                            data += '<td>'+obj.last_name+'</td>';
                            data += '<td>'+obj.first_name+'</td>';
                            data += '<td>'+obj.position+'</td>';
                            data += '<td>'+obj.email+'</td>';
                            data += '<td>'+obj.date_hired+'</td>';
                            data += '<td>'+obj.employment_type+'</td>';
                            data += '<td class="hide">0</td>';
                            data += '<td class="hide">0</td>';

                            if ( obj.suspended == 1) {
                                data += '<td class="text-center"><span class="label label-sm label-warning">Suspended</span></td>';
                            } else {
                                if ( obj.status == 1) {
                                    data += '<td class="text-center"><span class="label label-sm label-success">Active</span></td>';
                                } else {
                                    data += '<td class="text-center"><span class="label label-sm label-danger">Inactive</span></td>';
                                }
                            }
                            
                            data += '<td class="text-center">'+obj.registered+'</td>';
                            data += '<td class="text-center">';
                                data += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+', \'modalView\', '+obj.num+')">View</a>';
                                
                                if (obj.ID == 34) {
                                    data += '<a href="#set_details" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="set_id('+obj.ID+')">Set</a>';
                                }
                            data += '</td>';
                            
                            // $('#tableData tbody #tr_'+obj.ID).html(data);
                            // Check if Active or Inactive
                            if (obj.status == 1) {

                                // Check if existing or not
                                if ($('#tableData tbody #tr_'+obj.ID).length > 0) {
                                    $('#tableData tbody #tr_'+obj.ID).html(data);
                                } else {
                                    var data2 = '<tr id="tr_'+obj.ID+'" class="content">';
                                    data2 += data;
                                    data2 += '</tr>';
                                    $('#tableData tbody').append(data2);
                                    $('#tableDataInactive tbody #tr_'+obj.ID).remove();
                                }
                            } else {

                                // Check if existing or not
                                if ($('#tableDataInactive tbody #tr_'+obj.ID).length > 0) {
                                    $('#tableDataInactive tbody #tr_'+obj.ID).html(data);
                                } else {
                                    var data2 = '<tr id="tr_'+obj.ID+'" class="content">';
                                    data2 += data;
                                    data2 += '</tr>';
                                    $('#tableDataInactive tbody').append(data2);
                                    $('#tableData tbody #tr_'+obj.ID).remove();
                                }
                            }

                            // CounterUp Section
                            var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;

                            var pct_counter3 = 0;
                            if (current_client == 1) { pct_counter3 = (parseInt(obj.statusSuspended) / parseInt(obj.statusTotal)) * 100; }
                            else { pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100; }

                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');

                            if (current_client == 1) { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusSuspended+'"></span>'); }
                            else { $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>'); }
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');
                            
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

            // File Section
            function btnNew_File(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_File="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewFile .modal-body").html(data);
                        $(".modalForm").validate();
                        widget_date();
                    }
                });
            }
            $(".modalNewFile").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_HR_File',true);

                var l = Ladda.create(document.querySelector('#btnSave_HR_File'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td >'+obj.files+'</td>';
                                html += '<td >'+obj.filename+'</td>';
                                html += '<td >'+obj.description+'</td>';
                                html += '<td >'+obj.start_date+' - '+obj.due_date+'</td>';
                                html += '<td >'+obj.uploaded_date+'</td>';
                                html += '<td >For Review</td>';
                                html += '<td >NA</td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditFile" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                   html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tabFile table tbody').prepend(html);
                            $('#modalNewFile').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalEdit_File="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditFile .modal-body").html(data);
                        $(".modalForm").validate();
                        widget_date();
                    }
                });
            }
            $(".modalEditFile").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_HR_File',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_HR_File'));
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
                            var html = '<td >'+obj.files+'</td>';
                            html += '<td >'+obj.filename+'</td>';
                            html += '<td >'+obj.description+'</td>';
                            html += '<td >'+obj.start_date+' - '+obj.due_date+'</td>';
                            html += '<td >'+obj.uploaded_date+'</td>';
                            html += '<td >For Review</td>';
                            html += '<td >NA</td>';
                            html += '<td class="text-center">';
                                html += '<div class="btn-group btn-group-circle">';
                                    html += '<a href="#modalEditFile" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    html += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnDelete('+obj.ID+')">Delete</a>';
                               html += '</div>';
                            html += '</td>';

                            $('#tabFile table tbody #tr_'+obj.ID).html(html);
                            $('#modalEditFile').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnDelete(id) {
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
                        url: "function.php?btnDelete_Files="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tabFile tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
        </script>

    </body>
</html>