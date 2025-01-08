<?php 
    $title = "Service Log";
    $site = "service_log";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once 'alt-setup/setup.php';
    include_once ('header.php'); 
    // include_once ('task_service_log/private/connection.php');

    $con = $conn;
?>
<style>
    table.table-bordered.dataTable thead > tr:last-child th:last-child {
		border-right-width: unset;
	}
	#tableData_category tfoot input {
	    border: 1px solid #ccc;
	    padding: 1rem;
	    width: 100%;
	}
</style>

<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Service Time Logs</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#SERVICES" data-toggle="tab">Services</a>
                    </li>

                    <?php if($_COOKIE['ID'] == 43){ ?>
                    <li>
                        <a href="#filter_logs_data" data-toggle="tab">Filter</a>
                    </li>
                    <?php } ?>
                    <!-- if ($current_userEmployerID == 34 || $_COOKIE['ID'] == 34) -->
                    <?php if($_COOKIE['ID'] == 108 || $_COOKIE['ID'] == 43 || $_COOKIE['ID'] == 344 || $_COOKIE['ID'] == 100){ ?>
                    <li>
                        <a href="#MASS_UPLOAD" data-toggle="tab">Mass Upload</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#PERFORMANCE" data-toggle="tab">Performance</a>
                    </li>
                    <?php if($_COOKIE['ID'] == 38 || $_COOKIE['ID'] == 387 || $_COOKIE['ID'] == 32 || $_COOKIE['ID'] == 43): ?>
                    <li>
                        <a href="#Weekly" data-toggle="tab" onclick="weekly_report();">Weekly Reports</a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="#VA_SUMMARY" data-toggle="tab">VA Summary</a>
                    </li>
                    <?php //if($_COOKIE['ID'] == 38 || $_COOKIE['ID'] == 387 ||  $_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 108 || $_COOKIE['ID'] == 3 || $_COOKIE['ID'] == 32 || $_COOKIE['ID'] == 41 || $_COOKIE['ID'] == 43 || $_COOKIE['ID'] == 100 || $_COOKIE['ID'] == 40 || $_COOKIE['ID'] == 55 || $_COOKIE['ID'] == 42){ ?>
                    <li>
                        <a href="#Overtime_fa" data-toggle="tab">Overtime for Approval</a>
                    </li>
                    <?php if($_COOKIE['ID'] == 387 || $_COOKIE['ID'] == 456 || $_COOKIE['ID'] == 66  || $_COOKIE['ID'] == 100 || $_COOKIE['ID'] == 3 || $_COOKIE['ID'] == 43 || $_COOKIE['ID'] == 34 || $_COOKIE['ID'] == 54): ?>
                    <li>
                        <a href="#time_in" data-toggle="tab">Clockin Tracker</a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="SERVICES">

                        <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_service_log" data-toggle="tab">Service Logs</a>
                                </li>
                                <li>
                                    <a href="#tab_log_approval" data-toggle="tab">For Approval Logs</a>
                                </li>
                                <li>
                                    <a href="#tab_disapprove" data-toggle="tab">Disapproved Logs (1)</a>
                                </li>
                            </ul>
                            <div class="tab-content margin-top-20">
                                <div class="tab-pane active" id="tab_service_log">
                                    <div class="">
                                        <h3 style="margin: 0 0 1rem 0;"> Total records for one month period </h3>
                                        <div class="alert alert-success alert-dismissable" id="advSearchAlert" style="display: none;">
                                            <button type="button" class="close" aria-hidden="true"></button>
                                            <strong>
                                                <i class="fa fa-info-circle" style="margin-right: .2rem; border-right: 1px solid inherit; font-size: 1.5rem; align-self: center;"></i>
                                                Advance searching
                                            </strong>
                                            <br>
                                            <span style="font-size: .9em; margin-top: .5rem;">
                                                <span class="_stmt"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between" style="margin: 0 0 2rem 0; gap: 1rem;">
                                        <a data-toggle="modal" href="#newTask" class="btn blue">
                                            <i class="fa fa-plus"></i>
                                            New Task
                                        </a>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-bordered" id="tblServiceLog">
                                            <thead>
                                                <tr>
                                                    <th>Task ID</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                    <th>Comment</th>
                                                    <th>Account</th>
                                                    <th>Task Date</th>
                                                    <th>Minutes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            $last_month = date('Y-m-d', strtotime('-30 days'));
                                            $overtime_query = mysqli_query($conn, "select * from tbl_service_logs where deleted = 0 AND not_approved = 1 and minute > 0 and user_id = {$_COOKIE['ID']} 
                                            AND task_date >= '$last_month' ORDER BY task_date DESC");
                                            foreach($overtime_query as $ot_row){?>
                                                <tr id="scope_<?= $ot_row['task_id']; ?>" style="background-color:#F5F3C1;">
                                                    <td><?= $ot_row['task_id']; ?></td>
                                                    <td>
                                                        <?php 
                                                            $uuser = $ot_row['user_id'];
                                                            $query_user = mysqli_query($conn, "select * from tbl_user where ID = '$uuser'");
                                                            foreach($query_user as $uuser_row){
                                                                echo $uuser_row['first_name'].' '.$uuser_row['last_name'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $ot_row['description']; ?></td>
                                                    <td><?= $ot_row['action']; ?></td>
                                                    <td><?= $ot_row['comment']; ?></td>
                                                    <td><?= $ot_row['account']; ?></td>
                                                    <td><?= $ot_row['task_date']; ?></td>
                                                    <td><?= $ot_row['minute']; ?></td>
                                                </tr>
                                                <?php }
                                        ?>
                                                <?php
                                            $last_month1 = date('Y-m-d', strtotime('-30 days'));
                                            $overtime_query1 = mysqli_query($conn, "select * from tbl_service_logs where deleted = 0 AND not_approved = 0 and minute > 0 and user_id = {$_COOKIE['ID']} 
                                            AND task_date >= '$last_month1' ORDER BY task_date DESC");
                                            foreach($overtime_query1 as $ot_row){?>
                                                <tr id="scope1_<?= $ot_row['task_id']; ?>">
                                                    <td><?= $ot_row['task_id']; ?></td>
                                                    <td>
                                                        <?php 
                                                            $uuser = $ot_row['user_id'];
                                                            $query_user = mysqli_query($conn, "select * from tbl_user where ID = '$uuser'");
                                                            foreach($query_user as $uuser_row){
                                                                echo $uuser_row['first_name'].' '.$uuser_row['last_name'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $ot_row['description']; ?></td>
                                                    <td><?= $ot_row['action']; ?></td>
                                                    <td><?= $ot_row['comment']; ?></td>
                                                    <td><?= $ot_row['account']; ?></td>
                                                    <td><?= $ot_row['task_date']; ?></td>
                                                    <td><?= $ot_row['minute']; ?></td>
                                                </tr>
                                                <?php }
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_log_approval">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h3 style="margin: 0 0 1rem 0;">Service logs Overtime for approval</h3>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="table-scrollable">

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Task ID</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                            <th>Comment</th>
                                                            <th>Account</th>
                                                            <th>Task Date</th>
                                                            <th>Minutes</th>
                                                            <th width="50px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                $overtime_query1 = mysqli_query($conn, "select * from tbl_service_logs where not_approved = 3 and user_id = '".$_COOKIE['ID']."' ");
                                                foreach($overtime_query1 as $ot_row){?>

                                                        <tr id="scope_<?= $ot_row['task_id']; ?>">

                                                            <td><?= $ot_row['task_id']; ?></td>
                                                            <td>
                                                                <?php 
                                                                $uuser = $ot_row['user_id'];
                                                                $query_user = mysqli_query($conn, "select * from tbl_user where ID = '$uuser'");
                                                                foreach($query_user as $uuser_row){
                                                                    echo $uuser_row['first_name'].' '.$uuser_row['last_name'];
                                                                }
                                                            ?>
                                                            </td>
                                                            <td><?= $ot_row['description']; ?></td>
                                                            <td><?= $ot_row['action']; ?></td>
                                                            <td><?= $ot_row['comment']; ?></td>
                                                            <td><?= $ot_row['account']; ?></td>
                                                            <td>
                                                                <a href="#modal_update_status" data-toggle="modal" type="button" id="add_status" data-id="<?php echo $ot_row['task_id']; ?>"><?= $ot_row['task_date']; ?></a>
                                                            </td>
                                                            <td><?= $ot_row['minute']; ?></td>
                                                            <td>
                                                                <input type="checkbox" name="send_update_id[]" class="send_appr" value="<?= $ot_row['task_id']; ?>" />
                                                            </td>

                                                        </tr>
                                                        <?php }
                                            ?>
                                                        <tr style="border:none;">
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td class="noborder" style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">
                                                                <button type="button" name="btn_send_appr" id="btn_send_appr" class="btn btn-success btn-xs">Send for Approval</button>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_disapprove">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h3 style="margin: 0 0 1rem 0;">Service logs Overtime for approval</h3>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="table-scrollable">

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Task ID</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                            <th>Account</th>
                                                            <th>Task Date</th>
                                                            <th>Minutes</th>
                                                            <th>Approver Comment</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                $overtime_query1 = mysqli_query($conn, "select * from tbl_service_logs where not_approved = 4 and user_id = '".$_COOKIE['ID']."' ");
                                                foreach($overtime_query1 as $ot_row){?>

                                                        <tr id="scope_<?= $ot_row['task_id']; ?>">

                                                            <td><?= $ot_row['task_id']; ?></td>
                                                            <td>
                                                                <?php 
                                                                $uuser = $ot_row['user_id'];
                                                                $query_user = mysqli_query($conn, "select * from tbl_user where ID = '$uuser'");
                                                                foreach($query_user as $uuser_row){
                                                                    echo $uuser_row['first_name'].' '.$uuser_row['last_name'];
                                                                }
                                                            ?>
                                                            </td>
                                                            <td><?= $ot_row['description']; ?></td>
                                                            <td><?= $ot_row['comment']; ?></td>
                                                            <td><?= $ot_row['account']; ?></td>

                                                            <td>
                                                                <a href="#modal_update_status" data-toggle="modal" type="button" id="add_status" data-id="<?php echo $ot_row['task_id']; ?>"><?= $ot_row['task_date']; ?></a>
                                                            </td>
                                                            <td><?= $ot_row['minute']; ?></td>
                                                            <td><?= $ot_row['reasons']; ?></td>
                                                            <td><label style="color:red">Disapprove</label></td>
                                                        </tr>
                                                        <?php }
                                            ?>
                                                        <tr style="border:none;">
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td style="border:none;"></td>
                                                            <td class="noborder" style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="MASS_UPLOAD">
                        <div class="">
                            <h3 style="margin: 0 0 1rem 0;"> Upload service log </h3>
                            <p class="default"> Supports multiple services/logs to be uploaded at once. Use the
                                provided template document file to breakdown
                                task details.
                            </p>
                        </div>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Note:</strong>
                            <p> Not using the template will cause problem on your service
                                time </p>
                        </div>
                        <div class="d-flex align-items-start justify-content-between">
                            <a href="task_service_log/SERVICES_LOG_TEMPLATE_UTF8.csv" class="btn green">
                                <i class="fa fa-download"></i>
                                Download template
                            </a>
                        </div>
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light">
                            <div class="portlet-title" style="border: none; margin-bottom: 0;">
                                <div class="caption font-grey-cascade" style="padding-bottom: 0;">
                                    <i class="fa fa-tasks font-grey-cascade"></i>
                                    <span class="caption-subject bold uppercase"> Tasks Table</span>
                                    <span class="caption-helper">(click cell to edit)</span>
                                </div>
                                <div class="actions" style="padding-bottom: 0;">
                                    <button type="button" id="massUploadCSVFileForm" class="btn btn-circle btn-outline green btn-sm">
                                        <input type="file" accept=".csv" style="display: none;" id="massUploadCSVFileInput">
                                        <i class="fa fa-upload"></i> Upload CSV file
                                    </button>
                                    <button type="button" id="massUploadImportBtn" disabled class="btn btn-circle blue btn-sm">
                                        <i class="fa fa-save"></i> Save/Import
                                    </button>
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="csv_file_data"></div>
                            </div>
                        </div>
                        <!-- END Portlet PORTLET-->
                    </div>
                    <div class="tab-pane" id="Weekly">
                        <div class="row">
                            <div class="col-md-9">
                                <h3 style="margin: 0 0 1rem 0;">Weekly Summary</h3>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control data_users_search" placeholder="Search">
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <div class="table-scrollable">
                                    <table class="table table-bordered table-hover" id="weekly_data_tr">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Total Tasks</th>
                                                <th>Total Hour/s Rendered</th>
                                            </tr>
                                        </thead>
                                        <tbody id="weekly_data">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="Overtime_fa">
                        <div class="row">
                            <div class="col-md-9">
                                <h3 style="margin: 0 0 1rem 0;">Service logs Overtime for approval</h3>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <div class="table-scrollable">
                                    <div style="padding:15px">
                                        <label><input type="checkbox" id="checkAll" onclick="checkAll()"> Check All</label>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Task ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                                <th>Comment</th>
                                                <th>Account</th>
                                                <th>Task Date</th>
                                                <th>Minutes</th>
                                                <th width="50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                        $checker = mysqli_query($conn,"SELECT * FROM others_employee_details WHERE employee_id='$current_userEmployeeID'");
                                        $check_result = mysqli_fetch_array($checker);
                                        
                                        if (!empty($check_result)) {
                                            $new_check_result = explode(",",$check_result['pto_to_approved']);
                                            foreach($new_check_result as $explode_values) {
                                                $overtime_query = mysqli_query($conn, "select * from tbl_service_logs INNER JOIN tbl_user ON tbl_service_logs.user_id =  tbl_user.ID where tbl_service_logs.not_approved = 1 AND tbl_service_logs.user_id = '$explode_values' ");
                                                foreach($overtime_query as $ot_row) {
                                                    echo '<tr id="scope_'.$ot_row['task_id'].'" >
                                                   
                                                        <td><input type="checkbox" name="scope_update_id[]" class="update_scope" value="'.$ot_row['task_id'].'" /> '.$ot_row['task_id'].'</td>
                                                        <td>'.$ot_row['first_name'].' '.$ot_row['last_name'].'</td>
                                                        <td>'.$ot_row['description'].'</td>
                                                        <td>'.$ot_row['action'].'</td>
                                                        <td>'.$ot_row['comment'].'</td>
                                                        <td>'.$ot_row['account'].'</td>
                                                        <td><a href="#modal_update_status" data-toggle="modal" type="button" id="add_status" data-id="'.$ot_row['task_id'].'" >'.$ot_row['task_date'].'</a></td>
                                                        <td>'.$ot_row['minute'].'</td>
                                                        <td><button type="button" data-id="'.$ot_row['task_id'].'" id="disapprove_btn" data-toggle="modal" data-target="#modal_comment" class="btn btn-danger btn-xs">Disapprove</button></td>
                                                    </tr>';
                                                }
                                            }
                                        }
                                    ?>
                                            <tr style="border:none;">
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td style="border:none;"></td>
                                                <td class="noborder" style="border:solid transparent 1px !important;border-bottom:solid #ccc 1px !important;">

                                                    <button type="button" name="btn_appr_update" id="btn_appr_update" class="btn btn-success btn-xs">Approved</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="time_in">
                        <div class="row">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="widget-thumb-icon font-green-jungle icon-clock"></i>
                                        <span class="caption-subject bold uppercase">Clockin Tracker</span>
                                    </div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="#ft" data-toggle="tab"> Fulltime </a>
                                            </li>
                                            <li>
                                                <a href="#ojt" data-toggle="tab"> Part-Time Apprentice </a>
                                            </li>
                                            <li>
                                                <a href="#fl" data-toggle="tab"> Part-Time Project </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="ft">
                                                <table class="table table-striped table-bordered table-hover" id="timein_ft">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="text-bold text-center bg-light" aria-controls="timein_summary_table" width="10%">Name</th>
                                                            <?php
                                                            $query = "SELECT DISTINCT DATE(tbl_timein.time_in_datetime) AS date 
                                                                        FROM tbl_timein 
                                                                        LEFT JOIN tbl_hr_employee 
                                                                        ON tbl_hr_employee.ID = tbl_timein.user_id 
                                                                        WHERE (tbl_timein.time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) 
                                                                        OR DATE(tbl_timein.time_in_datetime) = CURRENT_DATE()) 
                                                                        AND tbl_hr_employee.type_id = 1 
                                                                        AND tbl_hr_employee.suspended = 0 
                                                                        AND tbl_hr_employee.status = 1 
                                                                        ORDER BY tbl_timein.time_in_datetime DESC";
                                                
                                                            $resultQuery = mysqli_query($conn, $query);
                                                            while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                echo '<th class="text-bold text-center bg-light" aria-controls="timein_summary_table">' . date('Y-m-d', strtotime($rowQuery['date'])) . '</th>';
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query2 = "SELECT * FROM `tbl_hr_employee` WHERE `user_id` = {$switch_user_id} AND `type_id` = 1 AND `suspended` = 0 AND `status` = 1 AND `first_name` != 'Admin' AND `first_name` != 'Arnel'";
                                                        $resultQuery2 = mysqli_query($conn, $query2);
                                                        while ($rowQuery2 = mysqli_fetch_array($resultQuery2)) {
                                                            echo '<tr width="10%" role="row" class="odd">';
                                                            echo '<td class="text-center">' . $rowQuery2['last_name'] . ' ' . $rowQuery2['first_name'] . '</td>';
                                                
                                                            mysqli_data_seek($resultQuery, 0);
                                                            while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                $date = date('Y-m-d', strtotime($rowQuery['date']));
                                                                $query3 = "SELECT MIN(CASE WHEN tbl_timein.action = 'IN' THEN tbl_timein.time_in_datetime END) AS timein,
                                                                                    MAX(CASE WHEN tbl_timein.action = 'OUT' THEN tbl_timein.time_in_datetime END) AS timeout 
                                                                            FROM tbl_timein 
                                                                            WHERE user_id = {$rowQuery2['ID']} AND DATE(tbl_timein.time_in_datetime) = '{$date}'";
                                                                $resultQuery3 = mysqli_query($conn, $query3);
                                                                $rowQuery3 = mysqli_fetch_array($resultQuery3);
                                                                
                                                                echo '<td class="text-center">';
                                                                if ($rowQuery3) {
                                                                    if (!empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                        echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span></a>';
                                                                    } elseif(!empty($rowQuery3['timein']) && empty($rowQuery3['timeout'])) {
                                                                        echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">-</span></a>';
                                                                    }elseif(empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                        echo '<span class="bold text-success">-</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span>';
                                                                    } else {
                                                                        echo '<span class="bold text-warning">-</span>';
                                                                    }
                                                                } else {
                                                                    echo '<span class="bold text-warning">-</span>';
                                                                }
                                                                echo '</td>';
                                                            }
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="ojt">
                                                <table class="table table-striped table-bordered table-hover" id="timein_ojt">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="text-bold text-center bg-light" aria-controls="timein_summary_table" width="10%">Name</th>
                                                            <?php
                                                                $query = "SELECT DISTINCT DATE(tbl_timein.time_in_datetime) AS date 
                                                                            FROM tbl_timein 
                                                                            LEFT JOIN tbl_hr_employee 
                                                                            ON tbl_hr_employee.ID = tbl_timein.user_id 
                                                                            WHERE (tbl_timein.time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) 
                                                                            OR DATE(tbl_timein.time_in_datetime) = CURRENT_DATE()) 
                                                                            AND tbl_hr_employee.type_id = 1 
                                                                            AND tbl_hr_employee.suspended = 0 
                                                                            AND tbl_hr_employee.status = 1 
                                                                            ORDER BY tbl_timein.time_in_datetime DESC";
                                                    
                                                                $resultQuery = mysqli_query($conn, $query);
                                                                while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                    echo '<th class="text-bold text-center bg-light" aria-controls="timein_summary_table">' . date('Y-m-d', strtotime($rowQuery['date'])) . '</th>';
                                                                }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $query2 = "SELECT * FROM `tbl_hr_employee` WHERE `user_id` = {$switch_user_id} AND `type_id` = 5 AND `suspended` = 0 AND `status` = 1";
                                                            $resultQuery2 = mysqli_query($conn, $query2);
                                                            while ($rowQuery2 = mysqli_fetch_array($resultQuery2)) {
                                                                echo '<tr width="10%" role="row" class="odd">';
                                                                echo '<td class="text-center">' . $rowQuery2['last_name'] . ' ' . $rowQuery2['first_name'] . '</td>';
                                                    
                                                                mysqli_data_seek($resultQuery, 0);
                                                                while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                    $date = date('Y-m-d', strtotime($rowQuery['date']));
                                                                    $query3 = "SELECT MIN(CASE WHEN tbl_timein.action = 'IN' THEN tbl_timein.time_in_datetime END) AS timein,
                                                                                        MAX(CASE WHEN tbl_timein.action = 'OUT' THEN tbl_timein.time_in_datetime END) AS timeout 
                                                                                FROM tbl_timein 
                                                                                WHERE user_id = {$rowQuery2['ID']} AND DATE(tbl_timein.time_in_datetime) = '{$date}'";
                                                                    $resultQuery3 = mysqli_query($conn, $query3);
                                                                    $rowQuery3 = mysqli_fetch_array($resultQuery3);
                                                                    
                                                                    echo '<td class="text-center">';
                                                                    if ($rowQuery3) {
                                                                        if (!empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                            echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span></a>';
                                                                        } elseif(!empty($rowQuery3['timein']) && empty($rowQuery3['timeout'])) {
                                                                            echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">-</span></a>';
                                                                        }elseif(empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                            echo '<span class="bold text-success">-</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span>';
                                                                        } else {
                                                                            echo '<span class="bold text-warning">-</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="bold text-warning">-</span>';
                                                                    }
                                                                    echo '</td>';
                                                                }
                                                                echo '</tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="fl">
                                                <table class="table table-striped table-bordered table-hover" id="timein_fl">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="text-bold text-center bg-light" aria-controls="timein_summary_table" width="10%">Name</th>
                                                            <?php
                                                                $query = "SELECT DISTINCT DATE(tbl_timein.time_in_datetime) AS date 
                                                                            FROM tbl_timein 
                                                                            LEFT JOIN tbl_hr_employee 
                                                                            ON tbl_hr_employee.ID = tbl_timein.user_id 
                                                                            WHERE (tbl_timein.time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) 
                                                                            OR DATE(tbl_timein.time_in_datetime) = CURRENT_DATE()) 
                                                                            AND tbl_hr_employee.type_id = 1 
                                                                            AND tbl_hr_employee.suspended = 0 
                                                                            AND tbl_hr_employee.status = 1 
                                                                            ORDER BY tbl_timein.time_in_datetime DESC";
                                                    
                                                                $resultQuery = mysqli_query($conn, $query);
                                                                while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                    echo '<th class="text-bold text-center bg-light" aria-controls="timein_summary_table">' . date('Y-m-d', strtotime($rowQuery['date'])) . '</th>';
                                                                }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $query2 = "SELECT * FROM `tbl_hr_employee` WHERE `user_id` = {$switch_user_id} AND `type_id` = 2 AND `suspended` = 0 AND `status` = 1";
                                                            $resultQuery2 = mysqli_query($conn, $query2);
                                                            while ($rowQuery2 = mysqli_fetch_array($resultQuery2)) {
                                                                echo '<tr width="10%" role="row" class="odd">';
                                                                echo '<td class="text-center">' . $rowQuery2['last_name'] . ' ' . $rowQuery2['first_name'] . '</td>';
                                                    
                                                                mysqli_data_seek($resultQuery, 0);
                                                                while ($rowQuery = mysqli_fetch_array($resultQuery)) {
                                                                    $date = date('Y-m-d', strtotime($rowQuery['date']));
                                                                    $query3 = "SELECT MIN(CASE WHEN tbl_timein.action = 'IN' THEN tbl_timein.time_in_datetime END) AS timein,
                                                                                        MAX(CASE WHEN tbl_timein.action = 'OUT' THEN tbl_timein.time_in_datetime END) AS timeout 
                                                                                FROM tbl_timein 
                                                                                WHERE user_id = {$rowQuery2['ID']} AND DATE(tbl_timein.time_in_datetime) = '{$date}'";
                                                                    $resultQuery3 = mysqli_query($conn, $query3);
                                                                    $rowQuery3 = mysqli_fetch_array($resultQuery3);
                                                                    
                                                                    echo '<td class="text-center">';
                                                                    if ($rowQuery3) {
                                                                        if (!empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                            echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span></a>';
                                                                        } elseif(!empty($rowQuery3['timein']) && empty($rowQuery3['timeout'])) {
                                                                            echo '<a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="' . $rowQuery2['ID'] . '" data-date="' . $date . '"><span class="bold text-success">' . date('h:i A', strtotime($rowQuery3['timein'])) . '</span> | <span class="bold text-danger">-</span></a>';
                                                                        }elseif(empty($rowQuery3['timein']) && !empty($rowQuery3['timeout'])) {
                                                                            echo '<span class="bold text-success">-</span> | <span class="bold text-danger">' . date('h:i A', strtotime($rowQuery3['timeout'])) . '</span>';
                                                                        } else {
                                                                            echo '<span class="bold text-warning">-</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="bold text-warning">-</span>';
                                                                    }
                                                                    echo '</td>';
                                                                }
                                                                echo '</tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--filter_logs_data-->
                    <div class="tab-pane" id="filter_logs_data">
                        <div class="row">
                            <div class="input-daterange">
                                <div class="col-md-4">
                                    <input type="text" name="start_date_filter" id="start_date_filter" class="form-control" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="end_date_filter" id="end_date_filter" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="button" name="search_date" id="search_date" value="Search" class="btn btn-info" />
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="filter_data" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> ID</th>
                                        <th>Name</th>
                                        <th>Total Hour/s Rendered</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="PERFORMANCE">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="">
                                    <h3 style="margin: 0 0 1rem 0;">
                                        Performance Summary
                                    </h3>
                                    <h5 class="font-grey-cascade">Last render date: <span data-performance="current_date"></span></h5>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Reminder!</strong>
                                    <p>
                                        Don't forget to log your tasks! It is important for your compensation and company's
                                        sales.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-daterange">
                                <div class="col-md-1">
                                    <label>From:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="start_date_filter1" id="start_date_filter1" class="form-control" />
                                </div>
                                <div class="col-md-1">
                                    <label>To:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="end_date_filter1" id="end_date_filter1" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="button" name="search_date1" id="search_date1" value="Search" class="btn btn-info" />
                            </div>
                        </div>
                        <br>
                        <div id="filter_data_range"></div>
                        <div class="m-grid">
                            <div class="row">
                                <div class="col-lg-7 col-xs-12 col-sm-12">
                                    <div class="dashboard-stat dashboard-stat-v2 grey-cararra">
                                        <div class="visual">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number" data-performance="overall_time">0</div>
                                            <div class="desc"> Overall Time Spent </div>
                                        </div>
                                    </div>
                                    <div class="row widget-row">
                                        <div class="col-md-6">
                                            <!-- BEGIN WIDGET THUMB -->
                                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                                <h4 class="widget-thumb-heading">Completed Tasks</h4>
                                                <div class="widget-thumb-wrap">
                                                    <i class="widget-thumb-icon font-green-jungle icon-check"></i>
                                                    <div class="widget-thumb-body">
                                                        <span class="widget-thumb-subtitle">total</span>
                                                        <span class="widget-thumb-body-stat" data-performance="total_completed_tasks">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END WIDGET THUMB -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- BEGIN WIDGET THUMB -->
                                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                                <h4 class="widget-thumb-heading">Days Worked</h4>
                                                <div class="widget-thumb-wrap">
                                                    <i class="widget-thumb-icon font-blue-dark icon-calendar"></i>
                                                    <div class="widget-thumb-body">
                                                        <span class="widget-thumb-subtitle">total</span>
                                                        <span class="widget-thumb-body-stat" data-performance="total_days_worked">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END WIDGET THUMB -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- BEGIN WIDGET THUMB -->
                                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                                <h4 class="widget-thumb-heading">Average Hours/Day</h4>
                                                <div class="widget-thumb-wrap">
                                                    <i class="widget-thumb-icon font-blue-madison icon-clock">
                                                    </i>
                                                    <div class="widget-thumb-body">
                                                        <span class="widget-thumb-subtitle">time</span>
                                                        <span class="widget-thumb-body-stat" data-performance="avg_hours_day">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END WIDGET THUMB -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- BEGIN WIDGET THUMB -->
                                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                                <h4 class="widget-thumb-heading">Average hours/week</h4>
                                                <div class="widget-thumb-wrap">
                                                    <i class="widget-thumb-icon font-blue-dark icon-bar-chart"></i>
                                                    <div class="widget-thumb-body">
                                                        <span class="widget-thumb-subtitle">time</span>
                                                        <span class="widget-thumb-body-stat" data-performance="avg_hours_week">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END WIDGET THUMB -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-xs-12 col-sm-12">
                                    <div class="portlet light blue-steel font-white">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-cursor font-white "></i>
                                                <span class="caption-subject font-white bold uppercase">
                                                    daily Report
                                                </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="easy-pie-chart">
                                                        <div class="number" data-performance="daily_time" style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                                            0
                                                        </div>
                                                        <div class="title font-white" style="font-size: .9em">
                                                            Time Rendered
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margin-bottom-10 visible-sm"> </div>
                                                <div class="col-md-6">
                                                    <div class="easy-pie-chart">
                                                        <div class="number" data-performance="daily_tasks" style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                                            0
                                                        </div>
                                                        <div class="title font-white" style="font-size: .9em">
                                                            Tasks Completed
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet light bordered" style="background-color:;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-calendar font-dark"></i>
                                                <span class="caption-subject font-dark bold uppercase">
                                                    Weekly reports
                                                </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="easy-pie-chart">
                                                        <div class="number" data-performance="weekly_time" style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                                            0
                                                        </div>
                                                        <div class="title font-dark" style="font-size: .9em">
                                                            Total Time Rendered
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margin-bottom-10 visible-sm"> </div>
                                                <div class="col-md-6">
                                                    <div class="easy-pie-chart">
                                                        <div class="number" data-performance="weekly_tasks" style="width: 100%; height: 50px; font-weight: 600; font-size: 1.5em !important;">
                                                            0
                                                        </div>
                                                        <div class="title font-dark" style="font-size: .9em">
                                                            Total Tasks Completed
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="VA_SUMMARY">
                        <div class="">
                            <h3 style="margin: 0 0 1rem 0;"> Employee List</h3>
                            <p class="default">
                                Service logs summary of your employees.
                            </p>
                        </div>
                        <div class="portlet light" style="padding-left:0; padding-right: 0;">
                            <div class="portlet-title" style="border: none; margin-bottom: 0;">
                                <div class="btn-group">
                                    <a class="btn grey-cascade" href="javascript:;" data-toggle="dropdown">
                                        <span class="hidden-xs"> Export </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" id="vasummary_table_actions">
                                        <li>
                                            <a href="javascript:;" data-action="0" class="tool-action">
                                                <i class="icon-cloud-upload"></i> CSV</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" data-action="1" class="tool-action">
                                                <i class="icon-paper-clip"></i> Excel</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="actions" style="padding-bottom: 0;">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table id="va_summary_table" class="table table-bordered table-hover order-column dataTable no-footer">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_update_status" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_status">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Service log Details</h4>
                </div>
                <div class="modal-body">

                </div>
            </form>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<?php if($_COOKIE['ID'] == 34 || $_COOKIE['ID'] == 189 || $_COOKIE['ID'] == 387 || $_COOKIE['ID'] == 38): ?>
<!--  -->
<div class="modal fade in" id="VAServiceLogsViewModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">VA Services Logs View</h4>
            </div>
            <div class="modal-body">
                <div class="VAInfoDisplay" style="margin: 1rem 0 3rem 0;"></div>
                <table id="VAServiceLogsViewDatatable" class="table table-striped table-bordered order-column dataTable no-footer">
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green closeModal" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="button" class="btn blue downloadLogs">Download CSV File</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php endif; ?>
<!-- advance search modal -->
<div class="modal fade bs-modal-sm" id="advSearchModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <form role="form" style="border-radius: 0;" class="modal-content" id="advSearchForm">
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Advanced Search</h4>
            </div>
            <div class="modal-body" style="padding-top: 0; padding-bottom: 0;">
                <div class="form-body">
                    <div class="font-grey-cascade" style="font-size: .9em; margin: 0 0 .5rem 0;">Filter by:</div>
                    <div class="form-group">
                        <label for="">Keyword</label>
                        <div class="input-icon right">
                            <i class="fa fa-search tooltips" data-original-title="Please enter a keyword" data-container="body"></i>
                            <input type="text" class="form-control" name="keyword" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Account</label>
                        <div>
                            <select class="mt-multiselect btn btn-default" id="ASAccountMS" name="accounts[]" multiple="multiple"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Action</label>
                        <div>
                            <select class="mt-multiselect btn btn-default" name="actions[]" id="ASActionMS" multiple="multiple"></select>
                        </div>
                    </div>
                    <div class="font-grey-cascade" style="font-size: .9em; margin: 0 0 .5rem 0;">
                        Filter by date range:
                    </div>
                    <div class="advDateRangeSearch">
                        <div class="form-group">
                            <label for="startDateADVS">Start date</label>
                            <input type="date" id="startDateADVS" class="form-control " name="startDate">
                        </div>
                        <div class="form-group">
                            <label for="endDateADVS">End date</label>
                            <input type="date" id="endDateADVS" class="form-control" name="endDate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="submit" class="btn green">Search</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- new task modal -->
<div class="modal fade in" id="newTask" tabindex="-1" role="newTask" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Task</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="task_form">
                    <div class="form-body">
                        <input type="hidden" name="_token" value="<?= isset($_COOKIE['ID']) ? $_COOKIE['ID'] : 'none' ?>">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            Please provide the complete information of the task.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Data submitted successfuly!
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Task Owner</label>
                            <div class="col-md-8">
                                <p class="form-control-static" style="font-weight: 600;">
                                    <?php
                                        $i = 1;
                                        $result = mysqli_query($conn, "SELECT * from tbl_user where ID = $current_userID ");
                                        $row = mysqli_fetch_array($result);
                                        echo htmlentities($row['first_name'] ?? '') .' '. htmlentities($row['last_name'] ?? '');
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task_description" class="col-md-3 control-label">Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="description" id="task_description" rows="3" placeholder="Describe your task"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task_action" class="col-md-3 control-label">Action</label>
                            <div class="col-md-8">
                                <select class="form-control mt-multiselect" name="action" id="task_action">
                                    <?php
                                        $actions = $con->query("SELECT name FROM tbl_service_logs_actions WHERE deleted = 0 ORDER BY name");
                                        if(mysqli_num_rows($actions) > 0) {
                                            while($row = $actions->fetch_assoc()) {
                                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                                            }
                                        } else {
                                            echo "<option><i>No items found.</i></option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task_comment" class="col-md-3 control-label">Comment</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="comment" id="task_comment" placeholder="Add comment" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task_account" class="col-md-3 control-label">Account</label>
                            <div class="col-md-8">
                                <select class="form-control mt-multiselect" name="account" id="task_account">
                                    <?php
                                        $accounts = $con->query("SELECT * FROM tbl_service_logs_accounts WHERE owner_pk = $switch_user_id order by name ASC");
                                        if(mysqli_num_rows($accounts) > 0) {
                                            while($row = $accounts->fetch_assoc()) {
                                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                                            }
                                        } else {
                                            echo "<option><i>No items found.</i></option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="taskdate" class="col-md-3 control-label">Task Date</label>
                            <div class="col-md-8">
                                <input class="form-control" type="date" name="task_date" id="taskdate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task_minute" class="col-md-3 control-label">Minute</label>
                            <div class="col-md-8">
                                <input class="form-control" name="minute" id="task_minute" type="number" min="0.1" step="0.1">
                            </div>
                        </div>
                        <button type="submit" id="task_submit_btn" style="display: none;"></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <?php if(!empty($_COOKIE['ID'])){ ?>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="$('#task_submit_btn').trigger('click')" class="btn green">Save Task</button>
                <?php }else{ ?>
                    <i>Your Cookies has expired please relogin. Thank you</i>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Update Details -->
<?php
    $user_pk = $_COOKIE['ID'];
    $total_minute =0;
     $total = 0;
    $overall = 0;
    $tasktdate = date('Y-m-d');
    $ot_query = mysqli_query($conn, "select * from tbl_service_logs where user_id = '$user_pk' and week(task_date) = week(now()) AND not_approved = 0 and minute > 0 order by task_date desc");
    foreach($ot_query as $ot_row){
        $taskid = $ot_row['task_id'];
        $ddescription = $ot_row['description'];
        $ccomment = $ot_row['comment'];
        $mminute = $ot_row['minute'];
        $tasktdate = $ot_row['task_date'];
        $rreasons = $ot_row['reasons'];
        $total_minute += $ot_row['minute'];
    }
    
    $task_date = date('Y-m-d', strtotime($tasktdate));
    $ttoday = date('Y-m-d');
    $overall = $total_minute;
    if($overall < 438 && empty($rreasons) && $task_date != $ttoday):
?>
        <div class="modal fade" id="modalGet_details_logs" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" class="form-horizontal modalForm modalGet_details_logs">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <i class="form-control" style="background-color:#93BFCF;color:#fff;height:60px;">Your time logs is not complete ( <i style="color:red;">Must be 7.3% or 438 minutes and above</i> ) please put the reason below or add logs if you're not done yet. thank you</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <b>Description: </b><br>
                                    <i><?= $ddescription; ?></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <b>Comments: </b><br>
                                    <i><?= $ccomment; ?></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <b>Rendered Time: </b>
                                    <i><?= $mminute.' minutes'; ?></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label><b>Reason</b></label>
                                    <input type="hidden" name="task_id" value="<?= $taskid; ?>">
                                    <textarea class="form-control" rows="5" name="reasons"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-info" type="submit" name="btnSave_reference" id="btnSave_reference" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    endif;
?>
<!-- END CONTENT BODY -->

<!-- Modal -->
<div class="modal fade" id="modal_comment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Comment</label>
                        <input type="text" id="task_id" style="display:none">
                        <textarea id="comment" class="form-control" style="height:70px"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="btn_disapprove_update" id="btn_disapprove_update" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="timeinRecord">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Clock in & out Records</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center table-hover table-striped" id="clockin_records_table">
                    <thead class="text-center bg-info">
                        <th class="text-center">Batch</th>
                        <th class="text-center">IN</th>
                        <th class="text-center">OUT</th>
                        <th class="text-center">MINUTES</th>
                        <th class="text-center">NOTES</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="bold">Total rendered minutes</span></td>
                            <td colspan="1" class="bold text-success" style="border-right: 1px solid transparent;"><span id="totalMinutes"></span></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-btn-no">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include_once ('footer.php'); ?>
<script src='assets/global/plugins/jquery-validation/js/jquery.validate.min.js' type='text/javascript'></script>
<script src='assets/global/plugins/jquery-validation/js/additional-methods.min.js' type='text/javascript'></script>

<!-- TOASTR SCRIPT PLUGINS -->
<script src='assets/global/plugins/bootstrap-toastr/toastr.min.js'></script>
<script src='assets/pages/scripts/ui-toastr.min.js'></script>

<!-- SWEETALERT SCRIPT -->
<script src='assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js' type='text/javascript'></script>
<!--<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>-->
<!-- ADVANCE SEARCH FIELD TYPEAHEAD -->
<script src='assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
<script src='assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="clockin/process.js" type="text/javascript"></script>

<!-- CUSTOM SCRIPT -->

<script>
    function checkAll() {
        // Get the checkbox that represents "Check All"
        var checkAllCheckbox = document.getElementById("checkAll");
    
        // Get all checkboxes with the class "checkbox-item"
        var checkboxes = document.getElementsByClassName("update_scope");
    
        // Loop through each checkbox and set its checked property
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = checkAllCheckbox.checked;
        }
    }
    var TableDatatablesRowreorderTimeIn = function() {
        var initTable1 = function() {
            var table = $('#timein_ft');
    
            var oTable = table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ entries",
                    "search": "Search:",
                    "zeroRecords": "No matching records found"
                },
    
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},
    
                // setup buttons extentension: http://datatables.net/extensions/buttons/
                buttons: [{
                        extend: 'print',
                        className: 'btn default'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn red'
                    },
                    {
                        extend: 'csv',
                        className: 'btn green '
                    }
                ],
    
                // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
                // rowReorder: {
    
                // },
    
                "order": [
                    [0, 'asc']
                ],
    
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
    
                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }
    
        var initTable2 = function() {
            var table = $('#timein_fl');
    
            var oTable = table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ entries",
                    "search": "Search:",
                    "zeroRecords": "No matching records found"
                },
    
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},
    
                buttons: [{
                        extend: 'print',
                        className: 'btn default'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn red'
                    },
                    {
                        extend: 'csv',
                        className: 'btn green '
                    }
                ],
    
                // setup colreorder extension: http://datatables.net/extensions/colreorder/
                // colReorder: {
                //     reorderCallback: function () {
                //         console.log( 'callback' );
                //     }
                // },
    
                // // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
                // rowReorder: {
    
                // },
    
                "order": [
                    [0, 'asc']
                ],
    
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
    
                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }
    
        var initTable3 = function() {
            var table = $('#timein_ojt');
    
            var oTable = table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ entries",
                    "search": "Search:",
                    "zeroRecords": "No matching records found"
                },
    
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},
    
                // setup buttons extentension: http://datatables.net/extensions/buttons/
                buttons: [{
                        extend: 'print',
                        className: 'btn default'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn red'
                    },
                    {
                        extend: 'csv',
                        className: 'btn green '
                    }
                ],
    
                // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
                // rowReorder: {
    
                // },
    
                "order": [
                    [0, 'asc']
                ],
    
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
    
                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }
    
        return {
    
            //main function to initiate the module
            init: function() {
    
                if (!jQuery().dataTable) {
                    return;
                }
    
                initTable1();
                initTable2();
                initTable3();
            }
    
        };
    
    }();
    
    jQuery(document).ready(function() {
        TableDatatablesRowreorderTimeIn.init();
    });
</script>
<script>
    var TableDatatablesManaged = function() {
    
        var initTable1_2 = function() {
    
            var table = $('#sample_1_2');
    
            // begin first table
            table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "infoEmpty": "No records found",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "Search:",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
    
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    
                "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
    
                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
    
                // set the initial value
                "pageLength": 5,
                "pagingType": "bootstrap_full_number",
                "columnDefs": [{ // set default column settings
                        'orderable': false,
                        'targets': [0]
                    },
                    {
                        "searchable": false,
                        "targets": [0]
                    },
                    {
                        "className": "dt-right",
                        //"targets": [2]
                    }
                ],
    
                "order": [
                    [1, "asc"]
                ], // set first column as a default sort by asc
    
                initComplete: function() {
    
                    // username column
                    this.api().column(1).every(function() {
                        var column = this;
                        var select = $('<select class="form-control input-sm"><option value="">Select</option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
    
                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
    
                }
            });
    
            var tableWrapper = jQuery('#sample_1_2_wrapper');
    
            table.find('.group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    if (checked) {
                        $(this).prop("checked", true);
                        $(this).parents('tr').addClass("active");
                    } else {
                        $(this).prop("checked", false);
                        $(this).parents('tr').removeClass("active");
                    }
                });
            });
    
            table.on('change', 'tbody tr .checkboxes', function() {
                $(this).parents('tr').toggleClass("active");
            });
        }
    
        var initTable2 = function() {
    
            var table = $('#sample_2');
    
            table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "infoEmpty": "No records found",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "Search:",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                "pagingType": "bootstrap_extended",
    
                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 5,
                "columnDefs": [{ // set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            });
    
            var tableWrapper = jQuery('#sample_2_wrapper');
    
            table.find('.group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    if (checked) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });
        }
    
        var initTable3 = function() {
    
            var table = $('#sample_3');
    
            // begin: third table
            table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "infoEmpty": "No records found",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "Search:",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
    
                "lengthMenu": [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 6,
                "columnDefs": [{ // set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            });
    
            var tableWrapper = jQuery('#sample_3_wrapper');
    
            table.find('.group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    if (checked) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });
        }
    
        var initTable4 = function() {
    
            var table = $('#sample_4');
    
            // begin: third table
            table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "infoEmpty": "No records found",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "Search:",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
    
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
    
                "lengthMenu": [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 6,
                "columnDefs": [{ // set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            });
    
            var tableWrapper = jQuery('#sample_4_wrapper');
    
            table.find('.group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    if (checked) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });
        }
    
        var initTable5 = function() {
    
            var table = $('#sample_5');
    
            // begin: third table
            table.dataTable({
    
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                    "infoEmpty": "No records found",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "Search:",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
    
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
    
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
    
                    // Total over all pages
                    total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
    
                    // Total over this page
                    pageTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
    
                    // Update footer
                    $(api.column(3).footer()).html(
                        '$' + pageTotal + ' ( $' + total + ' total)'
                    );
                },
    
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
    
                "lengthMenu": [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 6,
                "columnDefs": [{ // set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            });
    
            var tableWrapper = jQuery('#sample_5_wrapper');
    
            table.find('.group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    if (checked) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });
        }
        
        $('#tblServiceLog').DataTable({
	        dom: 'lBfrtip',
	        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        buttons: [
	            {
	                extend: 'print',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'pdf',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'csv',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'excel',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            'colvis'
	        ]
	    });
    
        return {
    
            //main function to initiate the module
            init: function() {
                if (!jQuery().dataTable) {
                    return;
                }
    
                initTable1_2();
                initTable2();
                initTable3();
                initTable4();
                initTable5();
            }
    
        };
    
    }();
    
    if (App.isAngularJsApp() === false) {
        jQuery(document).ready(function() {
            TableDatatablesManaged.init();
        });
    }
    
    $(document).on('click', '#add_status', function() {
        $('#tableData_12').DataTable();
        var ids = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "task_service_log/filter_task.php?GetAI=" + ids,
            dataType: "html",
            success: function(data) {
                $("#modal_update_status .modal-body").html(data);
                $(".modalForm").validate();
                selectMulti();
            }
        });
    });
    
    $(document).ready(function() {
    
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: "yyyy-mm-dd",
            autoclose: true
        });
    
        $('#search_date1').click(function() {
            var start_date_filter1 = $('#start_date_filter1').val();
            var end_date_filter1 = $('#end_date_filter1').val();
            if (start_date_filter1 != '' && end_date_filter1 != '') {
                $.ajax({
                    url: 'task_service_log/filter_task.php',
                    method: 'POST',
                    data: {
                        start_date_filter1: start_date_filter1,
                        end_date_filter1: end_date_filter1
                    },
                    success: function(data) {
                        alert(data);
                        $("#filter_data_range").empty();
                        $("#filter_data_range").html(data);
                    }
                });
            } else {
                alert("Both Date is Required");
            }
        });
    
    });
    
    $(document).on('click', '#btn_appr_update', function() {
    
        var scope_update_id = [];
    
        $('.update_scope:checked').each(function(i) {
            scope_update_id[i] = $(this).val();
        });
    
        if (scope_update_id.length === 0) //tell you if the array is empty
        {
            alert("Please Select atleast one checkbox");
        } else {
            $.ajax({
                url: 'task_service_log/action_approved.php',
                method: 'POST',
                data: {
                    scope_update_id: scope_update_id
                },
                success: function() {
                    for (var i = 0; i < scope_update_id.length; i++) {
                        $('tr#scope_' + scope_update_id[i] + '').css('background-color', '#ccc');
                        $('tr#scope_' + scope_update_id[i] + '').fadeOut('slow');
                    }
                }
            });
        }
    });
    
    $(document).on('click', '#disapprove_btn', function() {
        var task_id = $(this).attr('data-id');
        $('#task_id').val(task_id);
    });
    
    $(document).on('click', '#btn_disapprove_update', function() {
    
        var task_id = $('#task_id').val();
        var comment = $('#comment').val();
    
        if (comment != '') {
            $.ajax({
                url: 'task_service_log/action_approved.php',
                method: 'POST',
                data: {
                    task_id: task_id,
                    comment: comment,
                    action: "disapprove"
    
                },
                success: function(response) {
                    $('tr#scope_' + task_id).css('background-color', '#ccc');
                    $('tr#scope_' + task_id).fadeOut('slow');
                }
            });
        } else {
            alert("Please input comment")
        }
    });
    
    $(document).on('click', '#btn_d_update', function() {
    
        var scope_update_id = [];
    
        $('.update_scope:checked').each(function(i) {
            scope_update_id[i] = $(this).val();
        });
    
        if (scope_update_id.length === 0) //tell you if the array is empty
        {
            alert("Please Select atleast one checkbox");
        } else {
            $.ajax({
                url: 'task_service_log/action_approved.php',
                method: 'POST',
                data: {
                    scope_update_id: scope_update_id
                },
                success: function() {
                    for (var i = 0; i < scope_update_id.length; i++) {
                        $('tr#scope_' + scope_update_id[i] + '').css('background-color', '#ccc');
                        $('tr#scope_' + scope_update_id[i] + '').fadeOut('slow');
                    }
                }
            });
        }
    });
    
    $(document).on('click', '#btn_send_appr', function() {
    
        var send_update_id = [];
    
        $('.send_appr:checked').each(function(i) {
            send_update_id[i] = $(this).val();
        });
    
        if (send_update_id.length === 0) //tell you if the array is empty
        {
            alert("Please Select atleast one checkbox");
        } else {
            $.ajax({
                url: 'task_service_log/action_approved.php',
                method: 'POST',
                data: {
                    send_update_id: send_update_id
                },
                success: function() {
                    for (var i = 0; i < send_update_id.length; i++) {
                        $('tr#scope_' + send_update_id[i] + '').css('background-color', '#ccc');
                        $('tr#scope_' + send_update_id[i] + '').fadeOut('slow');
                    }
                }
            });
        }
    });
    
    $(".modalGet_details_logs").on('submit', (function(e) {
        e.preventDefault();
        //  var details_id = $("#details_id").val();
        formObj = $(this);
        if (!formObj.validate().form()) return false;
    
        var formData = new FormData(this);
        formData.append('btnSave_reference', true);
    
        var l = Ladda.create(document.querySelector('#btnSave_reference'));
        l.start();
    
        $.ajax({
            url: "task_service_log/actions.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if ($.trim(response)) {
                    msg = "Sucessfully Save!";
                    $('#modalGet_details_logs').modal('hide');
                } else {
                    msg = "Error!"
                }
                l.stop();
    
                bootstrapGrowl(msg);
            }
        });
    }));
    //----------------------
    $(document).ready(function() {
        //fetch data
        $('#modalGet_details_logs').modal('show');
        get_all_report('get_wreport');
    });
    
    function get_all_report(key) {
        $.ajax({
            url: 'task_service_log/weekly_report.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: key
            },
            success: function(response) {
                if (key == 'get_wreport') {
                    $('#weekly_data').append(response);
                }
            }
        });
    }
    
    //jobs search
    $(document).ready(function() {
        $('.data_users_search').keyup(function() {
            search_table($(this).val());
        });
    
        function search_table(value) {
            $('#weekly_data_tr tr').each(function() {
                var found = 'false';
                $(this).each(function() {
                    if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                        found = 'true';
                    }
                });
                if (found == 'true') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
</script>
<script src='task_service_log/script.js'></script>
<script src='task_service_log/va_summ_script.js'></script>

</body>

</html>