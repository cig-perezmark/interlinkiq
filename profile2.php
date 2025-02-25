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
                                            <?php 
                                                if($current_userEmployerID == 34) {
                                                    $currentDateTime = new DateTime();
                                                    $currentDateTime->setTimezone(new DateTimeZone('America/Chicago'));
                                                    $dateToday = $currentDateTime->format('Y-m-d');
                                                    
                                                    date_default_timezone_set('America/Chicago');
                                                    
                                                    $is_timein = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = '$dateToday' AND action = 'IN' AND user_id = {$current_userEmployeeID} ORDER BY time_in_datetime DESC LIMIT 1";
                                                    $checktimein = mysqli_query($conn, $is_timein);
                                                    $timeInDateTime = ($checktimein && mysqli_num_rows($checktimein) > 0) ? mysqli_fetch_assoc($checktimein)['time_in_datetime'] : null;
                                                    
                                                    $is_timeout = "SELECT time_in_datetime FROM tbl_timein WHERE DATE(time_in_datetime) = '$dateToday' AND action = 'OUT' AND user_id = {$current_userEmployeeID} ORDER BY time_in_datetime DESC LIMIT 1";
                                                    $checktimeout = mysqli_query($conn, $is_timeout);
                                                    $timeOutDateTime = ($checktimeout && mysqli_num_rows($checktimeout) > 0) ? mysqli_fetch_assoc($checktimeout)['time_in_datetime'] : null;
                                                    
                                                    $is_intoday = is_null($timeInDateTime) || (!is_null($timeOutDateTime) && $timeOutDateTime > $timeInDateTime) ? 'IN' : 'OUT';

                                                    $has_out = "SELECT 
                                                                    DATE_FORMAT(t.date, '%m-%e-%Y') AS date,
                                                                    t.last_in_yesterday AS yesterday_in, 
                                                                    IF(t.last_in_batch = t.last_out_batch, t.last_out_yesterday, '') AS yesterday_out,
                                                                    t.user_id AS id,
                                                                    t.reset_time as reset
                                                                FROM (
                                                                    SELECT 
                                                                        DATE(time_in_datetime) AS date, 
                                                                        MAX(CASE WHEN action = 'IN' THEN time_in_datetime END) AS last_in_yesterday, 
                                                                        MAX(CASE WHEN action = 'OUT' THEN time_in_datetime END) AS last_out_yesterday,
                                                                        MAX(CASE WHEN action = 'IN' THEN batch END) AS last_in_batch,
                                                                        MAX(CASE WHEN action = 'OUT' THEN batch END) AS last_out_batch,
                                                                        user_id,
                                                                        reset_time
                                                                    FROM tbl_timein
                                                                        WHERE DATE(time_in_datetime) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                                                                        AND user_id = 290
                                                                    GROUP BY DATE(time_in_datetime), user_id
                                                                ) t
                                                                ORDER BY t.date DESC";
                                                    $has_out_check = mysqli_query($conn, $has_out);

                                                    if(!empty($has_out_check)) {
                                                        $row = mysqli_fetch_assoc($has_out_check);
                                                        $reset_time = (!empty($row['reset'])) ? $row['reset'] : '';
                                                        $last_in = (!empty($row['yesterday_in'])) ? $row['yesterday_in'] : '';
                                                        $last_out = (!empty($row['yesterday_out'])) ? $row['yesterday_out'] : '';
                                                    } else {
                                                        $reset_time = NULL;
                                                        $last_in = NULL;
                                                        $last_out = NULL;
                                                    }
                                                ?>
                                                    
                                               <?php
                                                    // echo $last_in, '<br>';
                                                    // echo $last_out, '<br>';
                                                    // if($reset_time > strtotime($dateToday)) {
                                                    //     echo 'true';
                                                    // } else {
                                                    //     echo 'false';
                                                    // }
                                                    if ( strtotime($dateToday) > $reset_time && !empty($last_in) && empty($last_out) ) {
                                                        echo '<button id="btn-reason" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px;height:50px;font-size:20px;"><i class="fa fa-clock-o"></i> Start Working</button><br>';  
                                                    } else if ($is_intoday == 'IN') {
                                                        echo '<button id="btn-start" class="btn btn-circle btn-success" style="margin-bottom:10px;width:200px;height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button><br>
                                                        <input id="timein_current_user_id" type="hidden" value="' . $current_userEmployeeID . '">
                                                        <input id="current_userfullname" type="hidden" value="' . $current_userFName . ' ' . $current_userLName . '">
                                                        <input id="trigger" type="hidden" value="' . $is_intoday . '">
                                                        <input id="timeref" type="hidden" value="' . strtotime('tomorrow', strtotime($dateToday)) . '">';
                                                    } else {
                                                        echo '<div style="display:flex; justify-content: center"><button id="btn-stop" class="btn btn-circle btn-danger center-item-control" style="margin-bottom:50px;width:100%;height:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Stop Working</button></div>
                                                        <input id="clockintime" type="hidden" value="' .$timeInDateTime. '">
                                                        <input id="time_spent" type="hidden" value="">
                                                        <input id="timein_current_user_id" type="hidden" value="'. $current_userEmployeeID .'">
                                                        <input id="current_userfullname" type="hidden" value="' .$current_userFName .' '. $current_userLName.' ">
                                                        <input id="trigger" type="hidden" value="'. $is_intoday.'">
                                                        <input id="timerefout" type="hidden" value="0">
                                                        <div class="countup" id="countup1">
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel hours">00</span>
                                                            <span class="timeel timeRefHours">hours</span>
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel minutes">00</span>
                                                            <span class="timeel timeRefMinutes">minutes</span>
                                                            <span style="border-radius: 10px 0 0 10px;" class="timeel seconds">00</span>
                                                            <span class="timeel timeRefSeconds">seconds</span>
                                                        </div>';
                                                    }
                                                ?>
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
                                                                        $query = "SELECT 
                                                                                    DATE_FORMAT(t.date, '%m-%e-%Y') AS date, 
                                                                                    DATE_FORMAT(t.date, '%Y-%m-%e') AS date2, 
                                                                                    t.latest_in AS 'IN', 
                                                                                    IF(t.latest_in_batch = t.latest_out_batch, t.latest_out, '') AS 'OUT',
                                                                                    t.user_id AS id
                                                                                FROM (
                                                                                    SELECT 
                                                                                        DATE(time_in_datetime) AS date, 
                                                                                        MAX(CASE WHEN action = 'IN' THEN time_in_datetime END) AS latest_in, 
                                                                                        MAX(CASE WHEN action = 'OUT' THEN time_in_datetime END) AS latest_out,
                                                                                        MAX(CASE WHEN action = 'IN' THEN batch END) AS latest_in_batch,
                                                                                        MAX(CASE WHEN action = 'OUT' THEN batch END) AS latest_out_batch,
                                                                                        user_id
                                                                                    FROM tbl_timein 
                                                                                    WHERE time_in_datetime >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)
                                                                                        AND user_id = 290
                                                                                    GROUP BY DATE(time_in_datetime), user_id
                                                                                ) t
                                                                                ORDER BY t.date DESC";
                                                                    
                                                                        $resultQuery = mysqli_query($conn, $query);
                                                                    ?>
                                                                    <thead>
                                                                        <tr role="row">
                                                                        <?php
                                                                        if ($resultQuery) {
                                                                            while($rowQuery = mysqli_fetch_array($resultQuery)) { ?>
                                                                                <th class="text-bold text-center bg-light" tabindex="0" aria-controls="timein_summary_table" rowspan="1" colspan="2">
                                                                                    <a style="text-decoration: none" href="#timeinRecord" data-toggle="modal" class="get_clockin_records" data-id="<?=$rowQuery['id']?>" data-date="<?=$rowQuery['date2']?>"><?=$rowQuery['date']?></a>
                                                                                </th>
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
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
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
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Are you sure you want to start working ?</h4>
                                <h5>If you click yes you will be tagged as present for today</h5>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="notes" id="timein_notes" rows="5" class="form-control" required></textarea>
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="modal-btn-si">YES</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-btn-no">CANCEL</button>
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
                                    <div class="col-md-12">
                                       <label>Actual Timein Today</label>
                                       <input type="time" class="form-control" name="timein" step="1" required>
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
        <script src="clockin/process.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            var TableDatatablesRowreorderTimeIn = function () {
                var initTable1 = function () {
                    var table = $('#table_fatl');
            
                    var oTable = table.dataTable({
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
            
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green ' }
                        ],
            
                        "order": [
                            [1, 'desc']
                        ],
                        
                        "lengthMenu": [
                            [5, 10, 15, 20, -1],
                            [5, 10, 15, 20, "All"]
                        ],
                        "pageLength": 10,
            
                        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                    });
                }
            
                var initTable2 = function () {
                    var table = $('#table_atl');
            
                    var oTable = table.dataTable({
            
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
            
                        buttons: [
                            { extend: 'print', className: 'btn default' },
                            { extend: 'pdf', className: 'btn red' },
                            { extend: 'csv', className: 'btn green ' }
                        ],
                        
                        "order": [
                            [1, 'desc']
                        ],
            
                        "lengthMenu": [
                            [5, 10, 15, 20, -1],
                            [5, 10, 15, 20, "All"] 
                        ],
                        "pageLength": 10,
            
                        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                    });
                }
                return {
            
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
                    var notes = document.querySelector('#timein_notes').value;
                    
                    if(notes === "" || notes === 0) {
                        alert("Notes is required");
                    } else { 
                        $.ajax({
                            url: "timein_records.php",
                            type: "POST",
                            data: {
                                current_user_id: current_user_timein,
                                fullname_user: fullname,
                                user_action: action,
                                reset_timeref: timeref,
                                notes: notes
                            },
                            cache: false,
                            success: function(dataResult){
                                console.log(dataResult)
                                var dataResult = JSON.parse(dataResult)
                                if(dataResult.statusCode == 200){
                                    location.reload();
                                }   
                            }
                        });
                    }
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
                    data: {
                            current_user_id:current_user_timein,
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
