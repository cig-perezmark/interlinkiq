<?php 
    $title = "My Profile";
    $site = "profile";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #signature {
        width: 300px;
        height: 150px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
    }
    
    /*Countdown for hours worked*/
    .countup {
      text-align: center;
      margin-bottom:30px;
      position:relative;
      margin-top:60px;
    }
    .countup .timeel {
      display: inline-block;
      padding: 10px;
      background: #212d41;
      margin: 0;
      color: white;
      min-width: 2.6rem;
      margin-left: 13px;
      border-radius: 10px 0 0 10px !important;
    }
    .countup span[class*="timeRef"] {
      border-radius: 0 10px 10px 0 !important;
      margin-left: 0;
      background: #aebdd7;
      color: black;
    }
    .center-item-control{
       position: absolute;
       width:100%;
       border-radius:0px !Important;
       margin-bottom:20px;

    }
    .page-container-bg-solid .tabbable-line>.tab-content {
        border-top: 1px solid transparent;
    }
    
    .input-medium {
        width: 100% !important;
    }

</style>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <?php if ($current_client == 0) { ?>
                            <div class="col-md-12">
                                <!-- BEGIN PORTLET -->
                                
                                <!-- Begin Clockin -->
                                <?php
                                    $currentDateTime = new DateTime('now', new DateTimeZone('America/Chicago'));
                                    $dateToday = $currentDateTime->format('Y-m-d');
                                    $lastDayDate = $currentDateTime->modify('-1 day')->format('Y-m-d');
                                    
                                    if ($current_userEmployerID == 34) {
                                        date_default_timezone_set('America/Chicago');
                                    
                                        // Check if user has in record today
                                        $is_timein = "SELECT time_in_datetime, reset_time FROM tbl_timein WHERE DATE(time_in_datetime) = ? AND action = 'IN' AND user_id = ?";
                                        $checktimein = mysqli_prepare($conn, $is_timein);
                                        mysqli_stmt_bind_param($checktimein, 'si', $dateToday, $current_userEmployeeID);
                                        mysqli_stmt_execute($checktimein);
                                        mysqli_stmt_bind_result($checktimein, $timeInDateTime, $resetTime);
                                        mysqli_stmt_fetch($checktimein);
                                        mysqli_stmt_close($checktimein);
                                    
                                        $is_intoday = ($timeInDateTime === null) ? 'IN' : 'OUT';
                                    
                                        // Check if user has out record today
                                        $is_timeout = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = ? AND action = 'OUT' AND user_id = ?";
                                        $checktimeout = mysqli_prepare($conn, $is_timeout);
                                        mysqli_stmt_bind_param($checktimeout, 'si', $dateToday, $current_userEmployeeID);
                                        mysqli_stmt_execute($checktimeout);
                                        mysqli_stmt_bind_result($checktimeout, $timeOutDateTime);
                                        mysqli_stmt_fetch($checktimeout);
                                        mysqli_stmt_close($checktimeout);
                                    
                                        // Check if user has in record yesterday
                                        $hasin_yesterday = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = ? AND action = 'IN' AND user_id = ?";
                                        $is_in_yesterday = mysqli_prepare($conn, $hasin_yesterday);
                                        mysqli_stmt_bind_param($is_in_yesterday, 'si', $lastDayDate, $current_userEmployeeID);
                                        mysqli_stmt_execute($is_in_yesterday);
                                        mysqli_stmt_bind_result($is_in_yesterday, $is_timein_yesterday);
                                        mysqli_stmt_fetch($is_in_yesterday);
                                        mysqli_stmt_close($is_in_yesterday);
                                    
                                        // Check if user has out record yesterday
                                        $hasout_yesterday = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = ? AND action = 'OUT' AND user_id = ?";
                                        $is_out_yesterday = mysqli_prepare($conn, $hasout_yesterday);
                                        mysqli_stmt_bind_param($is_out_yesterday, 'si', $lastDayDate, $current_userEmployeeID);
                                        mysqli_stmt_execute($is_out_yesterday);
                                        mysqli_stmt_bind_result($is_out_yesterday, $is_timeout_yesterday);
                                        mysqli_stmt_fetch($is_out_yesterday);
                                        mysqli_stmt_close($is_out_yesterday);
                                    
                                        $timeToReset = (!empty($resetTime)) ? $resetTime : '0000-00-00 00:00:00';
                                        $midnightCST = clone $currentDateTime;
                                        $midnightCST->modify('+1 day');
                                        $midnightCST->setTime(0, 0, 0);
                                        $referenceTime = $midnightCST->getTimestamp();
                                        $currentTimestamp = $currentDateTime->getTimestamp();
                                        $midnightCSTTimestamp = $timeToReset;
                                        
                                        // Get user schedule
                                        $status_flag = 'Active';
                                        $is_approved = 'Yes';
                                        $scheduleSql = "SELECT time_schedule, date_from, date_to FROM tbl_employee_schedule WHERE status_flag = ? AND is_approved = ? AND userid = ?";
                                        $schedule = mysqli_prepare($conn, $scheduleSql);
                                        
                                        mysqli_stmt_bind_param($schedule, 'ssi', $status_flag, $is_approved, $current_userEmployeeID);
                                        mysqli_stmt_execute($schedule);
                                        mysqli_stmt_bind_result($schedule, $time_schedule, $from, $to);
                                        mysqli_stmt_fetch($schedule);
                                        mysqli_stmt_close($schedule);
                                        
                                        $flag = 'Active';
                                        $hr_approved = 'Yes';
                                        $checkSql = 'SELECT COUNT(*) FROM tbl_employee_schedule WHERE status_flag = ? AND is_approved = ? AND userid = ?';
                                        $checkStmt = mysqli_prepare($conn, $checkSql);
                                        
                                        if (!$checkStmt) {
                                            die('Error in preparing statement: ' . mysqli_error($conn));
                                        }
                                        
                                        mysqli_stmt_bind_param($checkStmt, 'ssi',  $flag, $hr_approved, $current_userEmployeeID);
                                        mysqli_stmt_execute($checkStmt);
                                        mysqli_stmt_bind_result($checkStmt, $count);
                                        mysqli_stmt_fetch($checkStmt);
                                        mysqli_stmt_close($checkStmt);
                                        
                                       $hasActiveTimeSchedule = (!empty($count)) ? 1 : 0; 
                                    ?>

                                    <a data-toggle="modal" href="#set-schedule" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px:hegiht:50px;font-size:20px;"><i class="icon-settings" style="margin-top: 8px;" aria-hidden="true"></i></a>
                                    <?php if(empty($hasActiveTimeSchedule)): ?>
                                        <a data-toggle="modal" href="#set-schedule" class="btn btn-circle btn-default" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</a>
                                    <?php elseif (empty($is_timeout_yesterday) && !empty($is_timein_yesterday)): ?>
                                        <button id="btn-reason" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> Start Working
                                        </button><br>
                                    <?php elseif ($midnightCSTTimestamp >= $currentTimestamp): if (!empty($timeInDateTime) && empty($timeOutDateTime)): ?>
                                        <button id="btn-stop" class="btn btn-circle btn-danger center-item-control" style="margin-bottom:50px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Stop Working</button>
                                        <input id="clockintime" type="hidden" value="<?= $timeInDateTime ?>">
                                        <input id="time_spent" type="hidden" value="">
                                        <input id="timein_current_user_id" type="hidden" value="<?= $current_userEmployeeID ?>">
                                        <input id="current_userfullname" type="hidden" value="<?= $current_userFName . ' ' . $current_userLName; ?>">
                                        <input id="trigger" type="hidden" value="<?= $is_intoday ?>">
                                        <input id="timerefout" type="hidden" value="0">
                                        <div class="countup" id="countup1">
                                            <span style="border-radius: 10px 0 0 10px;" class="timeel hours">00</span>
                                            <span class="timeel timeRefHours">hours</span>
                                            <span style="border-radius: 10px 0 0 10px;" class="timeel minutes">00</span>
                                            <span class="timeel timeRefMinutes">minutes</span>
                                            <span style="border-radius: 10px 0 0 10px;" class="timeel seconds">00</span>
                                            <span class="timeel timeRefSeconds">seconds</span>
                                        </div>
                                    <?php else: ?>
                                        <button disabled class="btn btn-circle btn-default" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button>
                                    <?php endif; else: ?>
                                        <button id="btn-start" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button><br>
                                        <input id="timein_current_user_id" type="hidden" value="<?= $current_userEmployeeID ?>">
                                        <input id="current_userfullname" type="hidden" value="<?= $current_userFName . ' ' . $current_userLName; ?>">
                                        <input id="trigger" type="hidden" value="<?= $is_intoday ?>">
                                        <input id="timeref" type="hidden" value="<?= $referenceTime ?>">
                                    <?php endif ?>
    
                                    <!-- End Clockin -->
                                    <div class="portlet light projects-widget">
                                        <div class="portlet-title">
                                            <div class="caption caption-md">
                                                <i class="icon-bar-chart theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">Time Tracking</span><br>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="project-content">
                                                <div class="mt-actions"></div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <?php 
                                                            $query = "SELECT t.date, t.IN, t.OUT
                                                                FROM ( 
                                                                    SELECT 
                                                                    DATE(time_in_datetime) AS date, 
                                                                    MIN(CASE WHEN action = 'IN' THEN time_in_datetime END) AS 'IN', 
                                                                    MAX(CASE WHEN action = 'OUT' THEN time_in_datetime END) AS 'OUT', user_id 
                                                                    FROM tbl_timein 
                                                                    WHERE (tbl_timein.time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) OR DATE(tbl_timein.time_in_datetime) = CURRENT_DATE()) AND user_id = $current_userEmployeeID
                                                                    GROUP BY DATE(time_in_datetime)
                                                                    ORDER BY DATE(time_in_datetime) DESC
                                                                ) AS t";
                                                        
                                                            $resultQuery = mysqli_query($conn, $query);
                                                        ?>
                                                        <thead>
                                                            <tr role="row">
                                                            <?php
                                                            if ($resultQuery) {
                                                                while($rowQuery = mysqli_fetch_array($resultQuery)) { ?>
                                                                    <th class="text-bold text-center bg-light" tabindex="0" aria-controls="timein_summary_table" rowspan="1" colspan="2"><?=$rowQuery['date']?></th>
                                                                <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr role="row" class="odd">
                                                                <?php 
                                                                    mysqli_data_seek($resultQuery, 0);
                                                                    while($rowQuery = mysqli_fetch_array($resultQuery)) { 
                                                                    ?>
                                                                    <td class="text-center"><span class="text-success">IN</span><br>
                                                                    <?php if(!empty($rowQuery['IN'])): ?>
                                                                    <span class="bold"><?= date('h:i A', strtotime($rowQuery['IN']))?></span>
                                                                    <?php else: ?>
                                                                    -
                                                                    <?php endif ?>
                                                                    </td>
                                                                    <td class="text-center"><span class="text-danger">OUT</span><br>
                                                                     <?php if(!empty($rowQuery['OUT'])): ?>
                                                                    <span class="bold"><?= date('h:i A', strtotime($rowQuery['OUT']))?></span>
                                                                    <?php else: ?>
                                                                    -
                                                                    <?php endif ?>
                                                                    </td>
                                                                <?php } } ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- END PORTLET -->
                            </div>
                            
                            <div class="col-md-12">
                            <?php
                                if($current_userEmployerID == 34) {
                                    if ($current_userID == 456 OR $current_userID == 34 OR $current_userID == 32) {?>
                                        <!-- BEGIN PORTLET -->
                                        <div class="portlet light tasks-widget">
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <i class="icon-bar-chart theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">For Approval</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tabbable-line">
                                                    <ul class="nav nav-tabs ">
                                                        <li class="active">
                                                            <a href="#fatl" data-toggle="tab"> For Approval Timeout Logs </a>
                                                        </li>
                                                        <li>
                                                            <a href="#schedule" data-toggle="tab" id="schedule-tab"> Schedules For Approval </a>
                                                        </li>
                                                        <li>
                                                            <a href="#atl" data-toggle="tab"> Approved Timeout Logs </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane" id="schedule">
                                                            <div id="site_activities_loading">
                                                                <span id="spinner-text" style="display:18px" class="">Fetching data </span> <img src="../assets/global/img/loading.gif" alt="loading" /> 
                                                            </div>
                                                            <table class="table table-striped table-bordered table-hover hide" id="table_schedule">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th>Name</th>
                                                                        <th>Scheduled Time</th>
                                                                        <th>Scheduled Date Span</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane active" id="fatl">
                                                            <table class="table table-striped table-bordered table-hover" id="table_fatl">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="hide"></th>
                                                                        <th>Name</th>
                                                                        <th>Date</th>
                                                                        <th>Timeout</th>
                                                                        <th>Reason</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $for_approval = "SELECT timeid, userid, employee_name, correspond_date, actual_timeout, incident_explanation, is_approved FROM tbl_time_approval WHERE is_approved = 'No' ORDER BY correspond_date DESC";
                                                                    $result = mysqli_query($conn, $for_approval);
                                                                    
                                                                    while($timout_approval = mysqli_fetch_array($result)){ ?>
                                                                        <tr role="row">
                                                                            <td class="to_userid<?=$timout_approval['timeid']?>" id="<?=$timout_approval['userid']?>" style="display:none"><?=$timout_approval['userid']?></td>
                                                                            <td class="to_emp_name<?=$timout_approval['timeid']?>" id="<?=$timout_approval['employee_name']?>"><?=$timout_approval['employee_name']?></td>
                                                                            <td class="to_date<?=$timout_approval['timeid']?>" id="<?=$timout_approval['correspond_date']?>"><?=$timout_approval['correspond_date']?></td>
                                                                            <td class="to_timeout<?=$timout_approval['timeid']?>" id="<?=$timout_approval['actual_timeout']?>"><?=$timout_approval['actual_timeout']?></td>
                                                                            <td class="to_explanation<?=$timout_approval['timeid']?>" id="<?=$timout_approval['incident_explanation']?>"><?=$timout_approval['incident_explanation']?></td>
                                                                            <td class="text-center"><button type="button" class="btn btn-primary approveTimeout" id="<?=$timout_approval['timeid']?>">Approve</button></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane" id="atl">
                                                            <table class="table table-bordered table-hover" id="table_atl">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Date</th>
                                                                        <th>Timeout</th>
                                                                        <th>Reason</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $for_approval = "SELECT timeid, userid, employee_name, correspond_date, actual_timeout, incident_explanation, is_approved FROM tbl_time_approval WHERE is_approved = 'Yes' ORDER BY correspond_date DESC";
                                                                    $result = mysqli_query($conn, $for_approval);
                                                                    
                                                                    while($timout_approval = mysqli_fetch_array($result)){ ?>
                                                                        <tr>
                                                                            <td><?=$timout_approval['employee_name']?></td>
                                                                            <td><?=$timout_approval['correspond_date']?></td>
                                                                            <td><?=$timout_approval['actual_timeout']?></td>
                                                                            <td><?=$timout_approval['incident_explanation']?></td>
                                                                            <td class="text-center"><span class="text-success">Approved</span></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--<div class="task-footer">-->
                                                <!--    <div class="btn-arrow-link text-right">-->
                                                <!--        <a data-toggle="modal" href="#modalTask">See All Tasks</a>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                            </div>
                                        </div>
                                        <!-- END PORTLET -->
                                    <?php }
                                }
                            ?>
                            </div>
                            
                        <?php } ?>
    
                        
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
        
        <!-- Start MODALS FOR Start working button confirmation -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-start-modal">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to start working?</h4>
                    <h5>If you click yes you will be tagged as present for today</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-btn-si">YES</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-btn-no">CANCEL</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-stop-modal">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to <span style="font-weight:bold;color:red;">STOP</span> working?</h4>
                    <h5>By Clicking yes you agreed to stop working</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default stopWorkingToday" id="modal-btn-stop">YES</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-btn-no">CANCEL</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="timeoutApproval">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <form method="post" class="form-horizontal" id="timeoutApprovalForm">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Time Out Approval</h4>
              </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                           <label>Date</label>
                           <input type="hidden" class="form-control" name="userid" value="<?=$current_userEmployeeID?>">
                           <input type="hidden" class="form-control" name="emp_name" value="<?=$current_userFName .' '. $current_userLName?>">
                           <input type="date" class="form-control" name="date" id="time" required>
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <label>Actual Timeout</label>
                           <input type="time" class="form-control" name="timeout" step="1" required>
                           <!--<span class="text-danger">Make sure to input CST timezone</span>-->
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Reason</label>
                           <textarea class="form-control" name="reason" rows="3" style="width: 567px; height: 196px;" required></textarea>
                       </div>
                    </div>
                   <div class="form-group">
                        
                   </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-btn-no">CANCEL</button>
                <button type="submit" class="btn btn-primary" id="sendForApproval">SUBMIT</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="set-schedule">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <form method="post" class="form-horizontal" id="setScheduleForm">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Set Schedule</h4>
              </div>
                <div class="modal-body">
                    
                   <div class="form-group">
                        <label class="control-label col-md-2">Time</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="hidden" class="form-control" name="userid" value="<?=$current_userEmployeeID?>">
                                <input type="hidden" class="form-control" name="employee_name" value="<?=$current_userFName .' '. $current_userLName?>">
                                <input type="text" class="form-control timepicker timepicker-no-seconds" name="time">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-clock-o"></i>
                                    </button>
                                </span>
                            </div>
                            <span class="help-block"> Select time </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-2">From</label>
                        <div class="col-md-10">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                <input type="text" class="form-control" readonly name="from">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <span class="help-block"> Select date </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-2">To</label>
                        <div class="col-md-10">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                <input type="text" class="form-control" readonly name="to">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block"> Select date </span>
                        </div>
                    </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-btn-no">Cancel</button>
                <button type="submit" class="btn btn green" id="setScheduleBtn">Set</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <!-- End MODALS FOR Start working button confirmation -->

        <?php include_once ('footer.php'); ?>

        <!-- MODALS FOR PROFILE SIDEBAR -->
        <script src="profileSidebar.js" type="text/javascript"></script>

        <!--[if lt IE 9]>
        <script type="text/javascript" src="assets/jSignature/flashcanvas.js"></script>
        <![endif]-->
        <script src="assets/jSignature/jSignature.min.js"></script>
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            $(document).ready(function () {
                
                function initializeDataTable(selector) {
                    return $(selector).dataTable({
                        // Your DataTable initialization options here
                        language: {
                            aria: {
                                sortAscending: ": activate to sort column ascending",
                                sortDescending: ": activate to sort column descending"
                            },
                            emptyTable: "No data available in table",
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoEmpty: "No entries found",
                            infoFiltered: "(filtered1 from _MAX_ total entries)",
                            lengthMenu: "_MENU_ entries",
                            search: "Search:",
                            zeroRecords: "No matching records found"
                        },
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green' }
                        ],
                        order: [
                            [1, 'desc']
                        ],
                        lengthMenu: [
                            [5, 10, 15, 20, -1],
                            [5, 10, 15, 20, "All"]
                        ],
                        pageLength: 10,
                        dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells.
                        // The default datatable layout setup uses scrollable div(table-scrollable) with overflow:auto
                        // to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                        // So when dropdowns used the scrollable div should be removed. 
                        // "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                        // ... additional DataTable initialization options ...
                    });
                }
                
                initializeDataTable('#table_schedule')
                initializeDataTable('#table_fatl')
                initializeDataTable('#table_atl')
                
                load_data();
                
                function load_data() {
                    if ($.fn.DataTable.isDataTable('#table_schedule')) {
                        $('#table_schedule').DataTable().destroy();
                    }
                    $.post({
                        url: "clockin_controller_function.php",
                        data: { load_schedule: true },
                        success: function(response) {
                            $('#table_schedule tbody').html(response)
                            $('#site_activities_loading, #spinner-text').addClass('hide')
                            $('#table_schedule').removeClass('hide')
                            initializeDataTable('#table_schedule')
                        }
                    })
                }
                $('#setScheduleForm').on('submit', function (e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    formData.append('add_schedule', 'add_schedule');
            
                    $.ajax({
                        url: 'clockin_controller_function.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false, 
                        success: function (response) {
                            response = JSON.parse(response);
                            $('#set-schedule').modal('hide');
                            $('#setScheduleForm')[0].reset();
                            $.bootstrapGrowl(response.message, {
                              ele: 'body',
                              type: 'success',
                              offset: {from: 'bottom', amount: 50},
                              align: 'right',
                              width: 'auto',
                              delay: 4000,
                              allow_dismiss: true,
                              stackup_spacing: 10
                            });
                            load_data();
                        },
                        error: function (error) {
                            console.log(response.message)
                            response = JSON.parse(response);
                            $.bootstrapGrowl(response.message, {
                              ele: 'body',
                              type: 'danger',
                              offset: {from: 'bottom', amount: 50},
                              align: 'right',
                              width: 'auto',
                              delay: 4000,
                              allow_dismiss: true,
                              stackup_spacing: 10
                            });
                        }
                    });
                });
                
                $(document).on('click', '.approveSchedule', function(e) {
                    e.preventDefault()
                    let id = $(this).attr('id')
                    $.post({
                        url: 'clockin_controller_function.php',
                        data: {
                            approve_schedule: true, scheduleid: id 
                        },
                        success:function(response) {
                            response = JSON.parse(response);
                            $.bootstrapGrowl(response.message, {
                              ele: 'body',
                              type: 'success',
                              offset: {from: 'bottom', amount: 50},
                              align: 'right',
                              width: 'auto',
                              delay: 4000,
                              allow_dismiss: true,
                              stackup_spacing: 10
                            });
                            load_data()
                        },
                        error: function (error) {
                            response = JSON.parse(response);
                            console.log(response.message)
                            $.bootstrapGrowl(response.message, {
                              ele: 'body',
                              type: 'danger',
                              offset: {from: 'bottom', amount: 50},
                              align: 'right',
                              width: 'auto',
                              delay: 4000,
                              allow_dismiss: true,
                              stackup_spacing: 10
                            });
                        }
                        
                    })
                })
            });
        </script>
        <script>
            
            
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                var id = '<?php echo $current_userEmployeeID; ?>';
                $.ajax({
                    url: 'function.php?profile_project='+id,
                    dataType: "html",
                    success: function(data){
                        $(".projects-widget .project-content .mt-actions").html(data);

                        var pending = $(".projects-widget .project-content .mt-actions > div").length;
                        $(".projects-widget .caption-helper").html(pending + " pending(s)");
                    }
                });
                $.ajax({
                    url: 'function.php?profile_task='+id,
                    dataType: "html",
                    success: function(data){
                        $(".tasks-widget .task-content .mt-actions").html(data);

                        var pending = $(".tasks-widget .task-content .mt-actions > div").length;
                        $(".tasks-widget .caption-helper").html(pending + " pending(s)");
                    }
                });
            });

            function widget_signature() {
                $("#signature").jSignature({
                    'background-color': 'transparent',
                    'decor-color': 'transparent',
                });
                $("canvas").attr('width','300');
                $("canvas").attr('height','150');
                $("canvas").width(300);
                $("canvas").height(150);
                btnClear();
            }
            function btnClear() {
                $('#signature').jSignature("clear");
            }
            
            function btnProjectApprove(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some remarks on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Remarks"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    // if (inputValue === "") {
                    //     swal.showInputError("You need to write something!");
                    //     return false
                    // }
                    $.ajax({
                        type: "GET",
                        url: "function.php?profile_project_approve="+id+"&profile_project_remarks="+inputValue,             
                        dataType: "html",
                        success: function(response){
                            var obj = jQuery.parseJSON(response);
                            $('.mt-actions #project_'+id).remove();
                            $('#profileSidebarProject').html(obj.profileProject);

                            var pending = $(".projects-widget .project-content .mt-actions > div").length;
                            $(".projects-widget .caption-helper").html(pending + " pending(s)");
                        }
                    });
                    swal("Nice!", "You wrote: " + inputValue, "success");
                });
            }
            function btnProjectReject(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your project will be rejected!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, reject it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?profile_project_reject="+id,             
                        dataType: "html",
                        success: function(response){
                            var obj = jQuery.parseJSON(response);
                            $('.mt-actions #project_'+id).remove();
                            $('#profileSidebarProject').html(obj.profileProject);

                            var pending = $(".projects-widget .project-content .mt-actions > div").length;
                            $(".projects-widget .caption-helper").html(pending + " pending(s)");
                        }
                    });
                    swal("Removed!", "Your project has been rejected.", "success");
                });
            }

            function btnTaskApprove(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some remarks on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Remarks"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    // if (inputValue === "") {
                    //     swal.showInputError("You need to write something!");
                    //     return false
                    // }
                    $.ajax({
                        type: "GET",
                        url: "function.php?profile_task_approve="+id+"&profile_task_remarks="+inputValue,             
                        dataType: "html",
                        success: function(response){
                            var obj = jQuery.parseJSON(response);
                            $('.mt-actions #task_'+id).remove();
                            $('#profileSidebarTask').html(obj.profileTask);

                            var pending = $(".tasks-widget .task-content .mt-actions > div").length;
                            $(".tasks-widget .caption-helper").html(pending + " pending(s)");
                        }
                    });
                    swal("Nice!", "You wrote: " + inputValue, "success");
                });
            }
            function btnTaskReject(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your task will be rejected!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, reject it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?profile_task_reject="+id,             
                        dataType: "html",
                        success: function(response){
                            var obj = jQuery.parseJSON(response);
                            $('.mt-actions #task_'+id).remove();
                            $('#profileSidebarTask').html(obj.profileTask);

                            var pending = $(".tasks-widget .task-content .mt-actions > div").length;
                            $(".tasks-widget .caption-helper").html(pending + " pending(s)");
                        }
                    });
                    swal("Removed!", "Your task has been rejected.", "success");
                });
            }

            function btnAttachedEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalAttached_Edit="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalAttachedEdit .modal-body").html(data);

                        selectMulti();
                    }
                });
            }
            $(".modalAttachedEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                //formObj = $(this).parents().parents();
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_Attached',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Attached'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('.mt-actions #task_'+obj.data_task_ID).remove();

                            var pending = $(".tasks-widget .task-content .mt-actions > div").length;
                            $(".tasks-widget .caption-helper").html(pending + " pending(s)");
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));

            // List of Training Section
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalQuiz_View="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        widget_signature();
                    }
                });
            }
            function changedQuiz(sel) {
                if (sel.value == "") {
                    $("#quizSet").html('');
                    $("#signatureContainer").hide();
                } else {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalQuiz_Set="+sel.value,
                        dataType: "html",
                        success: function(data){
                            $("#quizSet").html(data);
                        }
                    });
                    $("#signatureContainer").show();
                }
            }
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                // var sigData = $('#signature').jSignature('getData','base30');
                var sigData = $('#signature').jSignature('getData');

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_quiz',true);
                formData.append('sigData', sigData);

                var l = Ladda.create(document.querySelector('#btnUpdate_quiz'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sorry, You Failed!";

                            var obj = jQuery.parseJSON(response);

                            var str = obj.arr_incorrect;
                            var temp = new Array();
                            $('#quizSet > ol > li').removeClass('text-danger');
                            temp = str.split(", ");
                            for (a in temp ) {
                                temp[a] = parseInt(temp[a], 10);
                                $('#quizSet #'+temp[a]).addClass('text-danger');
                            }
                            
                            if (obj.record == 100) { msg = "Congratulations, You Passed!"; }
                            var result = '<td>'+obj.title+'</td>';
                            result += '<td class="text-center">'+obj.completed_date+'</td>';
                            result += '<td class="text-center">'+obj.last_modified+'</td>';
                            result += '<td>'+obj.status+'</td>';
                            result += '<td class="text-center">'+obj.certificate+'</td>';
                            result += '<td class="text-center"><a href="#modalView" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a></td>';
                            
                            $('#tableData_training tbody #tr_'+obj.ID).html(result);
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }        
                });
            }));
            
             // Start modal confirmation script from clock in function;
            var modalConfirm = function(callback){
  
              $("#btn-stop").on("click", function(){
                $("#mi-stop-modal").modal('show');
              });
              
              $("#btn-start").on("click", function(){
                $("#mi-start-modal").modal('show');
              });
              
              $("#btn-reason").on("click", function(){
                $("#timeoutApproval").modal('show');
              });
            
              $("#modal-btn-si").on("click", function(){
                 callback(true);
                $("#mi-modal").modal('hide');
              });
              
              $("#modal-btn-no").on("click", function(){
                callback(false);
                $("#mi-modal").modal('hide');
              });
            };
            
            modalConfirm(function(confirm){
              if(confirm){
                var current_user_timein = document.querySelector('#timein_current_user_id').value;
                var fullname = document.querySelector('#current_userfullname').value;
                var action = document.querySelector('#trigger').value;
                var timeref = document.querySelector('#timeref').value;
                $('#mi-start-modal').modal('hide');
           
                $.ajax({
                    url: "timein_records.php",
                    type: "POST",
                    data: {current_user_id:current_user_timein,
                           fullname_user:fullname,
                           user_action:action, reset_timeref:timeref
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            location.reload();
                        }
                    }
                    
                });
              }
            });
            // End modal confirmation script from clock in function;
            $('.stopWorkingToday').on('click', function(e){
                $('#modal-btn-stop').attr('disabled', true);
                // $('#modal-btn-stop').addClass('hide');
                $('#mi-stop-modal').modal('hide');
                var current_user_timein = document.querySelector('#timein_current_user_id').value;
                var fullname = document.querySelector('#current_userfullname').value;
                var action= document.querySelector('#trigger').value;
                var timerefout = document.querySelector('#timerefout').value;
           
                $.ajax({
                    url: "timein_records.php",
                    type: "POST",
                    data: {current_user_id:current_user_timein,
                           fullname_user:fullname,
                           user_action:action, reset_timeref:timerefout
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            location.reload();
                        }
                    }
                });
            })
            
            $('#timeoutApprovalForm').on('submit', function(e){
                e.preventDefault()
                $('#sendForApproval').text('Sending ...').attr('disabled', true);
                $('#sendForApproval').removeClass('btn-primary').attr('disabled', true);
                $('#sendForApproval').addClass('btn-default').attr('disabled', true);
                $.ajax({
                    url: "time_approval.php",
                    type: "POST",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            Swal.fire({
                              icon: 'success',
                              title: 'Approval Request Sent',
                              text: 'Kindly wait the HR approved your timeout approval request!',
                              showConfirmButton: false,
                              timer: 1500,
                              padding: '4em'
                            })
                            $("#timeoutApproval").modal('hide');
                            setTimeout(function(){
                            window.location.reload();
                            }, 1400);
                        }
                        else if(dataResult.statusCode==201){
                            alert("Error occured !");
                            console.log(dataResult);
                            location.reload();
                        }
                    }
                });
            })
            $('.approveTimeout').on('click', function(e){
                let timeid = $(this).attr('id');
                let userid = $('.to_userid'+timeid).attr('id');
                let emp_name = $('.to_emp_name'+timeid).attr('id');
                let date = $('.to_date'+timeid).attr('id');
                let timeout = $('.to_timeout'+timeid).attr('id');
                let explanation = $('.to_explanation'+timeid).attr('id');
           
                $.ajax({
                    url: "approved_time.php",
                    type: "POST",
                    data: {timeid:timeid, userid:userid, emp_name:emp_name, date:date, timeout:timeout, explanation:explanation},
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            Swal.fire({
                              icon: 'success',
                              title: 'Cheers',
                              text: emp_name + 'approval request has been Approved!',
                              showConfirmButton: false,
                              timer: 1500,
                              padding: '4em'
                            })
                            setTimeout(function(){
                            window.location.reload();
                            }, 1400);
                        }
                        else if(dataResult.statusCode==201){
                            alert("Error occured !");
                            alert(current_user_timein);
                            location.reload();
                        }
                    }
                });
            })
            
            var timein = document.getElementById('clockintime').value;
            var givenDate = new Date(timein);
            
            // Deduct 1 day and 5 hours from the given date
            // givenDate.setHours(givenDate.getHours() - 5);
            
            var updateInterval = setInterval(function() {
              var currentDate = new Date();
              var timeDiff = currentDate - givenDate;
              var secondsDiff = Math.floor(timeDiff / 1000);
              var minutesDiff = Math.floor(secondsDiff / 60);
              var hoursDiff = Math.floor(minutesDiff / 60);
              var daysDiff = Math.floor(hoursDiff / 24);
            
              // Calculate the remaining hours, minutes, and seconds
              var remainingHours = hoursDiff % 24;
              var remainingMinutes = minutesDiff % 60;
              var remainingSeconds = secondsDiff % 60;
            
              // Update the HTML elements with the new values
              document.querySelector('.timeel.hours').textContent = formatTime(remainingHours);
              document.querySelector('.timeel.minutes').textContent = formatTime(remainingMinutes);
              document.querySelector('.timeel.seconds').textContent = formatTime(remainingSeconds);
            
              // Enable the button when the counter hits 8 hours
              if (hoursDiff >= 8) {
                document.getElementById('btn-stop').disabled = false;
              } else {
                document.getElementById('btn-stop').disabled = false; 
                var is_due = document.getElementById("time_spent").value = hoursDiff
              }
            }, 1000);
            
            const timeSpentInput = document.getElementById("time_spent");
            const timeSpentValue = timeSpentInput.value;
            console.log(timeSpentValue)
            if(timeSpentValue >= 8) {
                Swal.fire({
                  title: 'Great! You Spent a total of 8 hours for todays work',
                  text: "Do you want to stop working?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes',
                  cancelButtonBtn: 'No',
                  reverseButtons: true
                }).then((result) => {
                  if (result.isConfirmed) {
                    var current_user_timein = document.querySelector('#timein_current_user_id').value;
                    var fullname = document.querySelector('#current_userfullname').value;
                    var action= document.querySelector('#trigger').value;
                    $.ajax({
                        url: "timein_records.php",
                        type: "POST",
                        data: {current_user_id:current_user_timein,
                               fullname_user:fullname,
                               user_action:action
                        },
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                location.reload();
                            }
                            else if(dataResult.statusCode==201){
                                alert("Error occured !");
                                alert(current_user_timein);
                                location.reload();
                            }
                        }
                    });
                  }
                })
            }
            function formatTime(value) {
              return value.toString().padStart(2, '0');
            }
        </script>
    </body>
</html>
