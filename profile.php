<?php 
    $title = "My Profile";
    $site = "profile";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Profile';
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style type="text/css">
    * {
        word-wrap: break-word;
    }
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

</style>

                    <div class="row">
                        <div class="col-md-12">
                            <?php include_once ('profile-sidebar.php'); ?>

                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12 hide">
                                        <!-- BEGIN PORTLET -->
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Feeds</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab"> System </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab"> Activities </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <!--BEGIN TABS-->
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_1_1">
                                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                            <ul class="feeds">
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-success">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> You have 4 pending tasks.
                                                                                    <span class="label label-sm label-info"> Take action
                                                                                        <i class="fa fa-share"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> Just now </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New version v1.4 just lunched! </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> 20 mins </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-danger">
                                                                                    <i class="fa fa-bolt"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Database server #12 overloaded. Please fix the issue. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 24 mins </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New order received and pending for process. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 30 mins </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-success">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New payment refund and pending approval. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 40 mins </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-warning">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New member registered. Pending approval. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 1.5 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-success">
                                                                                    <i class="fa fa-bell-o"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Web server hardware needs to be upgraded.
                                                                                    <span class="label label-sm label-default "> Overdue </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 2 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-default">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Prod01 database server is overloaded 90%. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 3 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-warning">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New group created. Pending manager review. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 5 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Order payment failed. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 18 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-default">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New application received. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 21 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Dev90 web server restarted. Pending overall system check. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 22 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-default">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New member registered. Pending approval </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 21 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> L45 Network failure. Schedule maintenance. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 22 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-default">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Order canceled with failed payment. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 21 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Web-A2 clound instance created. Schedule full scan. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 22 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-default">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Member canceled. Schedule account review. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 21 hours </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-info">
                                                                                    <i class="fa fa-bullhorn"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> New order received. Please take care of it. </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 22 hours </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab_1_2">
                                                        <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                            <ul class="feeds">
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New order received </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> 10 mins </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col1">
                                                                                <div class="label label-sm label-danger">
                                                                                    <i class="fa fa-bolt"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cont-col2">
                                                                                <div class="desc"> Order #24DOP4 has been rejected.
                                                                                    <span class="label label-sm label-danger "> Take action
                                                                                        <i class="fa fa-share"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col2">
                                                                        <div class="date"> 24 mins </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                                <div class="cont-col1">
                                                                                    <div class="label label-sm label-success">
                                                                                        <i class="fa fa-bell-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc"> New user registered </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date"> Just now </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--END TABS-->
                                            </div>
                                        </div>
                                        <!-- END PORTLET -->
                                    </div>
                                    <?php if ($current_client == 0) { ?>
                                        <div class="col-md-12">
                                            <!-- BEGIN PORTLET -->
                                            
                                            <!-- Begin Clockin -->
                                            <?php 
                                                $currentDateTime = new DateTime();
                                                $currentDateTime->setTimezone(new DateTimeZone('America/Chicago'));
                                                $dateToday = "'".$currentDateTime->format('Y-m-d')."'";
                                                $currentDateTime->modify('-1 day');
                                                $lastDayDate = "'".$currentDateTime->format('Y-m-d')."'";
                                                if($current_userEmployerID == 34) {
                                                    // Settting up time in cst zone 
                                                    date_default_timezone_set('America/Chicago');
                                                    // Check if user has in record today
                                                    $is_timein = "SELECT time_in_datetime, reset_time FROM tbl_timein WHERE DATE(time_in_datetime) = $dateToday AND action = 'IN' AND user_id = {$current_userEmployeeID}";
                                                    $checktimein = mysqli_query($conn, $is_timein);
                                                    $is_intoday = ($checktimein->num_rows == 0)? 'IN' : 'OUT';
                                                    if ($checktimein) {
                                                    $row = mysqli_fetch_assoc($checktimein);
                                                        if ($row) {
                                                            $timeInDateTime = $row['time_in_datetime'];
                                                            $resetTime = $row['reset_time'];
                                                        }
                                                    }
                                                    
                                                    // Check if user has out record today
                                                    $is_timeout = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = $dateToday AND action = 'OUT' AND user_id = {$current_userEmployeeID}";
                                                    $checktimeout = mysqli_query($conn, $is_timeout);
                                                    if ($checktimeout) {
                                                        $row2 = mysqli_fetch_assoc($checktimeout);
                                                        if ($row2) {
                                                            $timeOutDateTime = $row2['time_in_datetime'];
                                                        }
                                                    } 
                                                    
                                                    // Check if user has in record yesterday
                                                    $hasin_yesterday = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = $lastDayDate AND action = 'IN' AND user_id = {$current_userEmployeeID}";
                                                    $is_in_yesterday = mysqli_query($conn,$hasin_yesterday);
                                                    if($is_in_yesterday) {
                                                        $res2 = mysqli_fetch_assoc($is_in_yesterday);
                                                        if ($res2) {
                                                            $is_timein_yesterday = $res2['time_in_datetime']; 
                                                        }
                                                    }
                                                    
                                                    // Check if user has in record yesterday
                                                    $hasout_yesterday = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = $lastDayDate AND action = 'OUT' AND user_id = {$current_userEmployeeID}";
                                                    $is_out_yesterday = mysqli_query($conn,$hasout_yesterday);
                                                    if($is_out_yesterday) {
                                                        $res = mysqli_fetch_assoc($is_out_yesterday);
                                                        if ($res) {
                                                            $is_timeout_yesterday = $res['time_in_datetime']; 
                                                        }
                                                    }
                                                    $timeToReset = (!empty($resetTime)) ? $resetTime : '0000-00-00 00:00:00';
                                                    $midnightCST = clone $currentDateTime;
                                                    $midnightCST->modify('+1 day');
                                                    $midnightCST->setTime(0, 0, 0);
                                                    $referenceTime = $midnightCST->getTimestamp();
                                                    $currentTimestamp = $currentDateTime->getTimestamp();
                                                    $midnightCSTTimestamp = $timeToReset;
                                                ?>
                                                <?php if($current_userEmployeeID == 290) {
                                                    echo "Current: $currentTimestamp<br>";
                                                    echo "Midnight: $midnightCSTTimestamp<br>";
                                                }
                                                ?>
                                                
                                                <?php if(empty($is_timeout_yesterday) && !empty($is_timein_yesterday)):?>
                                                    <button id="btn-reason" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button><br>
                                                <?php elseif($midnightCSTTimestamp >= $currentTimestamp):
                                                      if(!empty($timeInDateTime) && empty($timeOutDateTime)):?>
                                                         <button id="btn-stop" class="btn btn-circle btn-danger center-item-control" style="margin-bottom:50px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Stop Working</button>
                                                        <input id="clockintime" type="hidden" value="<?=$timeInDateTime?>">
                                                        <input id="time_spent" type="hidden" value="">
                                                        <input id="timein_current_user_id" type="hidden" value="<?php echo $current_userEmployeeID ?>">
                                                        <input id="current_userfullname" type="hidden" value="<?php echo $current_userFName .' '. $current_userLName;?>">
                                                        <input id="trigger" type="hidden" value="<?= $is_intoday?>">
                                                        <input id="timerefout" type="hidden" value="0">
                                                        <div class="countup" id="countup1">
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel hours">00</span>
                                                            <span class="timeel timeRefHours">hours</span>
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel minutes">00</span>
                                                            <span class="timeel timeRefMinutes">minutes</span>
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel seconds">00</span>
                                                            <span class="timeel timeRefSeconds">seconds</span>
                                                        </div>
                                                      <?php else:?>
                                                      <button disabled class="btn btn-circle btn-default" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button>
                                                      <?php endif?>
                                                <?php else:?>
                                                    <button id="btn-start" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px:height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button><br>
                                                    <input id="timein_current_user_id" type="hidden" value="<?php echo $current_userEmployeeID ?>">
                                                    <input id="current_userfullname" type="hidden" value="<?php echo $current_userFName .' '. $current_userLName;?>">
                                                    <input id="trigger" type="hidden" value="<?= $is_intoday?>">
                                                    <input id="timeref" type="hidden" value="<?=$referenceTime?>">
                                                <?php endif?>

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
                                                if ($current_userID == 456 OR $current_userID == 34 OR $current_userID == 32 OR $current_userID == 43) {?>
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
                                                                        <a href="#atl" data-toggle="tab"> Approved Timeout Logs </a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content">
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
                                        <div class="col-md-12">
                                            <!-- BEGIN PORTLET -->
                                            <div class="portlet light tasks-widget">
                                                <div class="portlet-title">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Tasks</span>
                                                        <span class="caption-helper"></span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="task-content">
                                                        <?php if($_COOKIE['ID']== 185 || $_COOKIE['ID']== 95 || $_COOKIE['ID']== 42 || $_COOKIE['ID']== 88 || $_COOKIE['ID']== 35 || $_COOKIE['ID']== 228 || $_COOKIE['ID']== 208 || $_COOKIE['ID']== 43 || $_COOKIE['ID']== 38): ?>
                                                        <!--Marketing-->
                                                        <div class="row hide">
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_1">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            
                                                                            <h3 class="font-green-sharp"><span><?php echo 'Maintenance'; ?></span></h3>
                                                                            <small>Sent Email (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_2">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            
                                                                            <h3 class="font-red-haze"><span><?php echo 'Maintenance'; ?></span></h3>
                                                                            <small>Sent Email (Weekly)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_3">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            
                                                                            <h3 class="font-blue-sharp"><span><?php echo 'Maintenance'; ?></span></h3>
                                                                            <small>Sent Email (Montly)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_4">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                           
                                                                            <h3 class="font-purple-soft"><span><?php echo 'Maintenance'; ?></span></h3>
                                                                            <small>Sent Email (Total)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!--Category-->
                                                        <div class="row hide">
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_1">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                           
                                                                                <!--$prospect = $p + $crm-->
                                                                            <h3 class="font-green-sharp"><span><?php echo 'Maintenance'; ?></span></h3>
                                                                            <small>Prospect (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_2">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                           
                                                                            <h3 class="font-red-haze"><span><?php echo  'Maintenance'; ?></span></h3>
                                                                            <small>Contact (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_3">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                           
                                                                                <!--$Presentation = $p + $crm-->
                                                                            <h3 class="font-blue-sharp"><span><?php echo  'Maintenance';  ?></span></h3>
                                                                            <small>Presentation (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_4">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                           
                                                                                <!--$Follow_Up = $fu + $crm-->
                                                                            <h3 class="font-purple-soft"><span><?php echo  'Maintenance';  ?></span></h3>
                                                                            <small>Follow-Up (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!--Call Summary-->
                                                        <div class="row hide">
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_1">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            <?php
                                                                                
                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                $today1 = $date_default_tx->format('Y/m/d');
                                                                                
                                                                                $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                $resultSummary = mysqli_query($conn, $querySummary);
                                                                                
                                                                                $count_CS_Today = 1;
                                                                                $total_CS_Today = 0;
                                                                                while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                    $dateCS = date_create($rowSummary['notes_stamp']);
                                                                                   $date_get_cs = date_format($dateCS,"Y/m/d");echo '';
                                                                                    // $date_function = false;
                                                                                    if($today1 == $date_get_cs){
                                                                                       $total_CS_Today = $count_CS_Today++;
                                                                                       
                                                                                    }
                                                                                    
                                                                                }
                                                                                
                                                                                for ($cs = 0; $cs < $total_CS_Today; $cs++) {} 
                                                                                ?>
                                                                            <h3 class="font-green-sharp"><span><?php echo $cs; ?></span></h3>
                                                                            <small>Call Summary (Today)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_2">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            <?php
                                                                            
                                                                            $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                            $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                            $today = $date_default_tx->format('Y/m/d');
                                                                            
                                                                            $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                            $resultSummary = mysqli_query($conn, $querySummary);
                                                                            
                                                                            $count = 1;
                                                                            $total = 0;
                                                                            $total2 = 0;
                                                                            $final = 0;
                                                                            while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                               
                                                                               
                                                                               
                                                                                $date = date_create($rowSummary['notes_stamp']);
                                                                                $date_get = date_format($date,"Y/m/d");
                                                                                $startTimeStamp = strtotime($date_get);
                                                                                $endTimeStamp = strtotime($today);
                                                                                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                // and you might want to convert to integer
                                                                                 $numberDays = intval($numberDays);
                                                                                if($numberDays < 7){
                                                                                   $total = $count++;
                                                                                   
                                                                                }
                                                                                
                                                                            }
                                                                            
                                                                            for ($x = 0; $x < $total; $x++) {} 
                                                                        ?>
                                                                            <h3 class="font-red-haze"><span><?php echo $x; ?></span></h3>
                                                                            <small>Call Summary (Weekly)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_3">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                             <?php
                                                                                
                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                $today = $date_default_tx->format('Y/m/d');
                                                                                
                                                                                $querySummary = "SELECT * FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                $resultSummary = mysqli_query($conn, $querySummary);
                                                                                
                                                                                $count = 1;
                                                                                $total = 0;
                                                                                $total2 = 0;
                                                                                $final = 0;
                                                                                while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                   
                                                                                   
                                                                                   
                                                                                    $date = date_create($rowSummary['notes_date']);
                                                                                    $date_get = date_format($date,"Y/m/d");
                                                                                    $startTimeStamp = strtotime($date_get);
                                                                                    $endTimeStamp = strtotime($today);
                                                                                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                                                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                                                    // and you might want to convert to integer
                                                                                     $numberDays = intval($numberDays);
                                                                                    if($numberDays < 30){
                                                                                       $total = $count++;
                                                                                       
                                                                                    }
                                                                                    
                                                                                }
                                                                                
                                                                                for ($x = 0; $x < $total; $x++) {} 
                                                                            ?>
                                                                            <h3 class="font-blue-sharp"><span><?php echo $x; ?></span></h3>
                                                                            <small>Call Summary (Monthly)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="dashboard-stat2 counterup_4">
                                                                    <div class="display" style="position: relative;">
                                                                        <div class="number">
                                                                            <?php
                                                                                
                                                                                $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
                                                                                $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
                                                                                $today = $date_default_tx->format('Y/m/d'); 
                                                                                $querySummary = "SELECT count(*) as count  FROM tbl_Customer_Relationship_Notes where Title = 'Call Summary'";
                                                                                $resultSummary = mysqli_query($conn, $querySummary);
                                                                                                            
                                                                                while($rowSummary = mysqli_fetch_array($resultSummary)){
                                                                                ?>
                                                                                
                                                                            
                                                                            <h3 class="font-purple-soft"><span><?php echo $rowSummary['count']; ?></span></h3>
                                                                                <?php } ?>
                                                                            <small>Call Summary (Total)</small>
                                                                        </div>
                                                                        <div class="icon" style="position: absolute; right: 0;"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="mt-actions"></div>
                                                        <h4>Contacts Relationship Management</h4><br>
                                                        <table class="table table-bordered table-hover" id="sample_1_2">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>From</th>
                                                                    <th>Account</th>
                                                                    <th>Task</th>
                                                                    <th>Description</th>
                                                                    <th>Date Added</th>
                                                                    <th>Deadline</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $t=1;
                                                                    $queryPending = "SELECT * FROM tbl_Customer_Relationship_Task  where Task_Status = 1 and Assigned_to = '$current_userEmail'";
                                                                    $resultPending = mysqli_query($conn, $queryPending);
                                                                                                
                                                                    while($rowPending = mysqli_fetch_array($resultPending)){?>
                                                                <tr>
                                                                    <td><?php echo $t++; ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $getids = $rowPending['user_cookies'];
                                                                            $queryUser = "SELECT * FROM tbl_user  where ID = $getids";
                                                                            $resultUser = mysqli_query($conn, $queryUser);
                                                                                                        
                                                                            while($rowUser = mysqli_fetch_array($resultUser)){ 
                                                                                echo htmlentities($rowUser['first_name']);
                                                                                echo ' ';
                                                                                echo htmlentities($rowUser['last_name']);
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><a href="customer_details.php?view_id=<?php echo $rowPending['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowPending['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo htmlentities($rowAccount['account_name']);
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo htmlentities($rowPending['assign_task']); ?></td>
                                                                    <td><?php echo htmlentities($rowPending['Task_Description']); ?></td>
                                                                    <td><?php echo $rowPending['Task_added']; ?></td>
                                                                    <td><?php echo $rowPending['Deadline']; ?></td>
                                                                    <td><b style="color:red;">Pending</b></td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php
                                                                    $queryInprogress = "SELECT * FROM tbl_Customer_Relationship_Task  where Task_Status = 2 and Assigned_to = '$current_userEmail'";
                                                                    $resultInprogress = mysqli_query($conn, $queryInprogress);
                                                                                                
                                                                    while($rowInprogress = mysqli_fetch_array($resultInprogress)){?>
                                                                <tr>
                                                                    <td><?php echo $t++; ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $getids = $rowInprogress['user_cookies'];
                                                                            $queryUser = "SELECT * FROM tbl_user  where ID = $getids";
                                                                            $resultUser = mysqli_query($conn, $queryUser);
                                                                                                        
                                                                            while($rowUser = mysqli_fetch_array($resultUser)){ 
                                                                                echo htmlentities($rowUser['first_name']);
                                                                                echo ' ';
                                                                                echo htmlentities($rowUser['last_name']);
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><a href="customer_details.php?view_id=<?php echo $rowInprogress['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowInprogress['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo htmlentities($rowAccount['account_name']);
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo htmlentities($rowInprogress['assign_task']); ?></td>
                                                                    <td><?php echo htmlentities($rowInprogress['Task_Description']); ?></td>
                                                                    <td><?php echo $rowInprogress['Task_added']; ?></td>
                                                                    <td><?php echo $rowInprogress['Deadline']; ?></td>
                                                                    <td><b style="color:orange;">Inprogress</b></td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php
                                                                    $queryDone = "SELECT * FROM tbl_Customer_Relationship_Task  where Task_Status = 3 and Assigned_to = '$current_userEmail'";
                                                                    $resultDone = mysqli_query($conn, $queryDone);
                                                                                                
                                                                    while($rowDone = mysqli_fetch_array($resultDone)){?>
                                                                <tr>
                                                                    <td><?php echo $t++; ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $getids = $rowDone['user_cookies'];
                                                                            $queryUser = "SELECT * FROM tbl_user  where ID = $getids";
                                                                            $resultUser = mysqli_query($conn, $queryUser);
                                                                                                        
                                                                            while($rowUser = mysqli_fetch_array($resultUser)){ 
                                                                                echo htmlentities($rowUser['first_name']);
                                                                                echo ' ';
                                                                                echo htmlentities($rowUser['last_name']);
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td> <a href="customer_details.php?view_id=<?php echo $rowDone['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowDone['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo htmlentities($rowAccount['account_name']);
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo htmlentities($rowDone['assign_task']); ?></td>
                                                                    <td><?php echo htmlentities($rowDone['Task_Description']); ?></td>
                                                                    <td><?php echo $rowDone['Task_added']; ?></td>
                                                                    <td><?php echo $rowDone['Deadline']; ?></td>
                                                                    <td><b style="color:green;">Done</b></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--<div class="task-footer">-->
                                                    <!--    <div class="btn-arrow-link text-right">-->
                                                    <!--        <a data-toggle="modal" href="#modalTask">See All Tasks</a>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                            <!-- END PORTLET -->
                                        </div>
                                    <?php } ?>

                                    <?php
                                        if ($current_userEmployeeID > 0) {
                                            echo '<div class="col-md-12">
                                                <div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <span class="caption-subject font-blue-madison bold uppercase">List of Trainings</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_training">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Description</th>
                                                                        <th class="text-center" style="width: 150px;">Date Completed</th>
                                                                        <th class="text-center" style="width: 150px;">Due Date</th>
                                                                        <th style="width: 140px;">Status</th>
                                                                        <th class="text-center" style="width: 150px;">Record</th>
                                                                        <th class="text-center" style="width: 110px;">Document</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                                                            
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE employee_id = $current_userEmployeeID" ); // 83
                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);

                                                                        $selectTrainings = mysqli_query( $conn,"SELECT 
                                                                            *
                                                                            FROM (
                                                                                SELECT
                                                                                t.ID AS t_ID,
                                                                                t.title AS t_title,
                                                                                t.job_description_id AS t_job_description_id,
                                                                                replace(t.quiz_id , ' ','') AS t_quiz_id,
                                                                                t.last_modified AS t_last_modified,
                                                                                t.frequency AS t_frequency,
                                                                                q.ID AS q_ID,
                                                                                q.quiz_id AS q_quiz_id,
                                                                                q.result AS q_result,
                                                                                q.last_modified AS q_last_modified
                                                                                FROM tbl_hr_trainings AS t
                                                                                
                                                                                LEFT JOIN (
                                                                                    SELECT * 
                                                                                    FROM tbl_hr_quiz_result 
                                                                                    WHERE ID IN 
                                                                                    ( 
                                                                                    SELECT MAX(ID) 
                                                                                    FROM tbl_hr_quiz_result
                                                                                    WHERE user_id = $current_userID
                                                                                    GROUP BY quiz_id 
                                                                                    )
                                                                                ) AS q
                                                                                ON FIND_IN_SET(q.quiz_id, t.quiz_id) > 0
                                                                                
                                                                                WHERE t.status = 1
                                                                                AND t.deleted = 0
                                                                                AND t.user_id = $current_userEmployerID
                                                                            ) AS r" );
                                                                        if ( mysqli_num_rows($selectTrainings) > 0 ) {
                                                                            while($rowTraining = mysqli_fetch_array($selectTrainings)) {
                                                                                $training_ID = $rowTraining['t_ID'];
                                                                                $title = htmlentities($rowTraining['t_title']);
                                                                                $array_rowTraining = explode(", ", $rowTraining["t_job_description_id"]);

                                                                                $array_frequency = array(
                                                                                    0 => '+1 month',
                                                                                    1 => '+3 month',
                                                                                    2 => '+6 month',
                                                                                    3 => '+1 year'
                                                                                );

                                                                                $found = null;
                                                                                $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $current_userEmployeeID" );
                                                                                if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                                    $rowEmployee = mysqli_fetch_array($selectEmployee);
                                                                                    $array_row = explode(", ", $rowEmployee["job_description_id"]);
                                                                                    foreach($array_row as $emp_JD) {
                                                                                        if (in_array($emp_JD,$array_rowTraining)) {
                                                                                            $found = true;
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ( $found == true ) {
                                                                                    $trainingStatus = "Not Yet Started";
                                                                                    $trainingResult = 0;
                                                                                    $completed_date = '';
                                                                                    $due_date = '';
                                                                                    $pdf_quiz = '';
                                                                                    if (!empty($rowTraining['t_quiz_id'])) {
                                                                                        $trainingQuizID = $rowTraining['q_quiz_id'];
                                                                                        $trainingResult = $rowTraining['q_result'];
                                                                                        $pdf_quiz = $rowTraining['q_ID'];

                                                                                        if ($trainingResult == 100) {
                                                                                            $trainingStatus = "Completed";

                                                                                            $completed_date = $rowTraining['q_last_modified'];
                                                                                            $completed_date = new DateTime($completed_date);
                                                                                            $completed_date = $completed_date->format('M d, Y');

                                                                                            $due_date = date('Y-m-d', strtotime($array_frequency[$rowTraining['t_frequency']], strtotime($completed_date)) );
                                                                                            $due_date = new DateTime($due_date);
                                                                                            $due_date = $due_date->format('M d, Y');

                                                                                            if (date('Y-m-d') > date('Y-m-d', strtotime($array_frequency[$rowTraining['t_frequency']], strtotime($completed_date)) )) {
                                                                                                $trainingStatus = '<i class="text-danger sbold">Pass Due</i>';
                                                                                            }
                                                                                        }
                                                                                    }

                                                                                    echo '<tr id="tr_'.$training_ID.'">
                                                                                        <td >'. $title .'</td>
                                                                                        <td class="text-center">'; echo $trainingResult == 100 ? $completed_date:''; echo '</td>
                                                                                        <td class="text-center">'; echo $trainingResult == 100 ? $due_date:''; echo '</td>
                                                                                        <td>'.$trainingStatus.'</td>
                                                                                        <td class="text-center">'; echo $trainingResult == 100 ? '<a href="pdf?id='.$pdf_quiz.'" target="_blank" class="btn btn-circle btn-success">View</a>':''; echo '</td>
                                                                                        <td class="text-center"><a href="#modalView" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnView('.$training_ID.')">View</a></td>
                                                                                    </tr>';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                
                                                                echo '</tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>

                    <div class="modal fade bs-modal-lg" id="modalAttachedEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalAttachedEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Files</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Attached" id="btnUpdate_Attached" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalUpdate">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Comprehension Quiz</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_quiz" id="btnUpdate_quiz" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
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
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            var TableDatatablesRowreorderTimeIn = function () {
                var initTable1 = function () {
                    var table = $('#table_fatl');
            
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
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green ' }
                        ],
            
                        // setup rowreorder extension: http://datatables.net/extensions/rowreorder/
                        // rowReorder: {
            
                        // },
            
                        "order": [
                            [1, 'desc']
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
            
                var initTable2 = function () {
                    var table = $('#table_atl');
            
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
            
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green ' }
                        ],
                        
                        "order": [
                            [1, 'desc']
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
                    init: function () {
            
                        if (!jQuery().dataTable) {
                            return;
                        }
            
                        initTable1();
                        initTable2();
                    }
            
                };
            
            }();
            
            jQuery(document).ready(function() {
                TableDatatablesRowreorderTimeIn.init();
            });
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