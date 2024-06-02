<?php 
    // phpinfo();
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
      display:none;
      position:relative;
      margin-top:100px;
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
                                            if($current_userEmployerID = 34) {
                                            if ($current_userID == 3 OR $current_userID == 456 OR $current_userID == 66 OR $current_userID == 387) { ?>
                                                <button id="btn-confirm" class="btn btn-circle btn-success" style="margin-bottom:50px;width:200px:hegiht:50px;font-size:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Start Working</button>
                                                <input id="clockintime" type="hidden" value="">
                                                <input id="timein_current_user_id" type="hidden" value="<?php echo $current_userID ?>">
                                                <input id="current_userfullname" type="hidden" value="<?php echo $current_userFName .' '. $current_userLName;?>">
                                                <input id="trigger" type="hidden" value="IN">
                                                <div class="countup" id="countup1">
                                                    <span style="border-radius: 10px 0 0 10px;" class="timeel years">00</span>
                                                    <span class="timeel timeRefYears">years</span>
                                                    <span style="border-radius: 10px 0 0 10px;" class="timeel days">00</span>
                                                    <span class="timeel timeRefDays">days</span>
                                                    <span style="border-radius: 10px 0 0 10px;" class="timeel hours">00</span>
                                                    <span class="timeel timeRefHours">hours</span>
                                                    <span style="border-radius: 10px 0 0 10px;" class="timeel minutes">00</span>
                                                    <span class="timeel timeRefMinutes">minutes</span>
                                                    <span style="border-radius: 10px 0 0 10px;" class="timeel seconds">00</span>
                                                    <span class="timeel timeRefSeconds">seconds</span>
                                                </div>
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
                                                                            SELECT DATE(recorded_time) AS date,
                                                                                   MIN(CASE WHEN action = 'IN' THEN TIME(recorded_time) END) AS 'IN',
                                                                                   MAX(CASE WHEN action = 'OUT' THEN TIME(recorded_time) END) AS 'OUT',
                                                                                   user_id, id 
                                                                            FROM tbl_timein
                                                                            WHERE tbl_timein.user_id = {$_COOKIE['ID']}
                                                                            GROUP BY DATE(recorded_time)
                                                                            ORDER BY recorded_time DESC
                                                                          ) AS t";
                                                                    
                                                                        $resultQuery = mysqli_query($conn, $query);
                                                                    ?>
                                                                    <thead>
                                                                        <tr role="row">
                                                                        <?php while($rowQuery = mysqli_fetch_array($resultQuery)) { ?>
                                                                            <th class="text-bold text-center bg-light" tabindex="0" aria-controls="timein_summary_table" rowspan="1" colspan="2"><?=$rowQuery['date']?></th>
                                                                        <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr role="row" class="odd">
                                                                            <?php 
                                                                                mysqli_data_seek($resultQuery, 0);
                                                                                while($rowQuery = mysqli_fetch_array($resultQuery)) { ?>
                                                                                    <td class="text-center"><span class="text-success">IN</span><br>
                                                                                    <?php if(!empty($rowQuery['IN'])): ?>
                                                                                    <span class="bold"><?=$rowQuery['IN']?></span>
                                                                                    <?php else: ?>
                                                                                    -
                                                                                    <?php endif ?>
                                                                                    </td>
                                                                                    <td class="text-center"><span class="text-danger">OUT</span><br>
                                                                                     <?php if(!empty($rowQuery['OUT'])): ?>
                                                                                    <span class="bold"><?=$rowQuery['OUT']?></span>
                                                                                    <?php else: ?>
                                                                                    -
                                                                                    <?php endif ?>
                                                                                    </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  } } ?>
                                            <!-- END PORTLET -->
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
                                                        <div class="row">
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
                                                        <div class="row">
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
                                                        <div class="row">
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
                                                        <table class="table table-bordered table-hover" id="sample_4">
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
                                                                                echo $rowUser['first_name'];
                                                                                echo ' ';
                                                                                echo $rowUser['last_name'];
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><a href="customer_relationship_View.php?view_id=<?php echo $rowPending['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowPending['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo $rowAccount['account_name'];
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo $rowPending['assign_task']; ?></td>
                                                                    <td><?php echo $rowPending['Task_Description']; ?></td>
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
                                                                                echo $rowUser['first_name'];
                                                                                echo ' ';
                                                                                echo $rowUser['last_name'];
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><a href="customer_relationship_View.php?view_id=<?php echo $rowInprogress['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowInprogress['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo $rowAccount['account_name'];
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo $rowInprogress['assign_task']; ?></td>
                                                                    <td><?php echo $rowInprogress['Task_Description']; ?></td>
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
                                                                                echo $rowUser['first_name'];
                                                                                echo ' ';
                                                                                echo $rowUser['last_name'];
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td> <a href="customer_relationship_View.php?view_id=<?php echo $rowDone['crm_ids'] ?>#tasks">
                                                                        <?php
                                                                            $crm_ids = $rowDone['crm_ids'];
                                                                            $queryAccount = "SELECT * FROM tbl_Customer_Relationship  where crm_id = $crm_ids";
                                                                            $resultAccount = mysqli_query($conn, $queryAccount);
                                                                                                        
                                                                            while($rowAccount = mysqli_fetch_array($resultAccount)){ 
                                                                                echo $rowAccount['account_name'];
                                                                            }
                                                                        ?></a>
                                                                    </td>
                                                                    <td><?php echo $rowDone['assign_task']; ?></td>
                                                                    <td><?php echo $rowDone['Task_Description']; ?></td>
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

                                                                    $selectTrainings = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE status = 1 AND deleted = 0 AND user_id = $current_userEmployerID" );
                                                                    if ( mysqli_num_rows($selectTrainings) > 0 ) {
                                                                        while($rowTraining = mysqli_fetch_array($selectTrainings)) {
                                                                            $training_ID = $rowTraining['ID'];
                                                                            $title = $rowTraining['title'];
                                                                            
                                                                            $data_last_modified = $rowTraining['last_modified'];
                                                                            $data_last_modified = new DateTime($data_last_modified);
                                                                            $data_last_modified = $data_last_modified->format('M d, Y');

                                                                            $found = null;
                                                                            $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $current_userEmployeeID" );
                                                                            if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                                $rowEmployee = mysqli_fetch_array($selectEmployee);
                                                                                $array_row = explode(", ", $rowEmployee["job_description_id"]);
                                                                                $array_rowTraining = explode(", ", $rowTraining["job_description_id"]);
                                                                                foreach($array_row as $emp_JD) {
                                                                                    if (in_array($emp_JD,$array_rowTraining)) {
                                                                                        $found = true;
                                                                                    }
                                                                                }
                                                                            }

                                                                            $trainingStatus = "Not Yet Started";
                                                                            $trainingResult = 0;
                                                                            $completed_date = '';
                                                                            $due_date = '';
                                                                            $pdf_quiz = '';
                                                                            $selectQuizResult = mysqli_query( $conn,"SELECT * FROM tbl_hr_quiz_result WHERE user_id = $current_userID " );
                                                                            if ( mysqli_num_rows($selectQuizResult) > 0 ) {
                                                                                while($rowQuizResult = mysqli_fetch_array($selectQuizResult)) {
                                                                                    $trainingResultID = $rowQuizResult['ID'];
                                                                                    $trainingQuizID = $rowQuizResult['quiz_id'];

                                                                                    if (!empty($rowTraining['quiz_id'])) {
                                                                                        $array_quiz_id = explode(', ', $rowTraining['quiz_id']);
                                                                                        if (in_array($trainingQuizID, $array_quiz_id)) {
                                                                                            $trainingResult = $rowQuizResult['result'];
                                                                                            $pdf_quiz = $trainingResultID;

                                                                                            if ($trainingResult == 100) { $trainingStatus = "Completed"; }
                                                                                            else { $trainingStatus = "Not Yet Started"; }
                                                                            
                                                                                            $completed_date = $rowQuizResult['last_modified'];
                                                                                            $completed_date = new DateTime($completed_date);
                                                                                            $completed_date = $completed_date->format('M d, Y');
                                                                            
                                                                                            $due_date = date('Y-m-d', strtotime('+1 year', strtotime($completed_date)) );
                                                                                            $due_date = new DateTime($due_date);
                                                                                            $due_date = $due_date->format('M d, Y');
                                                                                        }
                                                                                    }

                                                                                }
                                                                            }

                                                                            if ( $found == true ) {
                                                                                echo '<tr id="tr_'.$training_ID.'">
                                                                                    <td >'. $title .'</td>
                                                                                    <td class="text-center">'; echo $trainingResult == 100 ? $completed_date:''; echo '</td>
                                                                                    <td class="text-center">'; echo $trainingResult == 100 ? $due_date:''; echo '</td>
                                                                                    <td>'.$trainingStatus.'</td>
                                                                                    <td class="text-center">'; echo $trainingResult == 100 ? '<a href="pdf?id='.$pdf_quiz.'" target="_blank" class="btn btn-circle btn-success">View</a>':''; echo '</td>
                                                                                    <td class="text-center hide">'.$trainingResult.'%</td>
                                                                                    <td class="text-center"><a href="#modalView" class="btn btn-circle btn-success" data-toggle="modal" onclick="btnView('.$rowTraining["ID"].')">View</a></td>
                                                                                </tr>';
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
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div id="start-working-modal-message">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Are you sure you want to start working?</h4>
                                <h5>If you click yes you will be tagged as present for today</h5>
                            </div>
                            <div id="stop-working-modal-message" style='display:none;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Are you sure you want to <span style="font-weight:bold;color:red;">STOP</span> working?</h4>
                                <h5>If you click yes you will be tagged as present for today</h5>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="modal-btn-si">YES</button>
                            <button type="button" class="btn btn-primary" id="modal-btn-no">CANCEL</button>
                          </div>
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
  
              $("#btn-confirm").on("click", function(){
                $("#mi-modal").modal('show');
              });
              $("#btn-confirm-stopworking").on("click", function(){
                 alert("stop working"); 
              });
              
              $("#btn-stop-working").on("click", function(){
                $("#stop-modal").modal('show');
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
                  
                var currentstatus =  $('#trigger').val();
                



                
                var date = new Date();
            	var current_date = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate();
            	var current_time = date.getHours()+":"+date.getMinutes()+":"+ date.getSeconds();
            	var date_time = current_date+" "+current_time;	
            	document.querySelector('#clockintime').value = date_time;
            	
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
            // 		dataType: "json",
            		success: function(dataResult){
            			var dataResult = JSON.parse(dataResult);
            			if(dataResult.statusCode==200){
            			    alert("Record Saved!");	
            			    if(currentstatus == "OUT")
            			    {
            			        $('#trigger').val("IN");
            			        document.querySelector('#btn-confirm').innerHTML = '<i class="fa fa-clock-o" aria-hidden="true"></i> Start Working';
                                document.querySelector('#btn-confirm').classList.remove("btn-danger");
                                document.querySelector('#btn-confirm').classList.add("btn-success");
                                document.querySelector('#btn-confirm').classList.remove("center-item-control");
                                $("#stop-working-modal-message").hide();
                                $("#start-working-modal-message").show();
                                $("#countup1").hide();
                                
            			    }
            			    else{
            			        $('#trigger').val("OUT");
                			    document.querySelector('#btn-confirm').innerHTML = '<i class="fa fa-clock-o" aria-hidden="true"></i> Stop Working';
                                document.querySelector('#btn-confirm').classList.remove("btn-success");
                                document.querySelector('#btn-confirm').classList.add("btn-danger");
                                document.querySelector('#btn-confirm').classList.add("center-item-control");
                                
                                 $("#stop-working-modal-message").show();
                                 $("#start-working-modal-message").hide();
                                 
                                 
                                 $("#countup1").show();
                                // START Count time clockin / working function
             
                                  // Month Day, Year Hour:Minute:Second, id-of-element-container
                                var clockintime = document.querySelector('#clockintime').value;
                                countUpFromTime(clockintime, 'countup1'); // ****** Change this line!
                          
                                function countUpFromTime(countFrom, id) {
                                  countFrom = new Date(countFrom).getTime();
                                  var now = new Date(),
                                      countFrom = new Date(countFrom),
                                      timeDifference = (now - countFrom);
                                    
                                  var secondsInADay = 60 * 60 * 1000 * 24,
                                      secondsInAHour = 60 * 60 * 1000;
                                    
                                  days = Math.floor(timeDifference / (secondsInADay) * 1);
                                  years = Math.floor(days / 365);
                                  if (years > 1){ days = days - (years * 365) }
                                  hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
                                  mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
                                  secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);
                                
                                  var idEl = document.getElementById(id);
                                  idEl.getElementsByClassName('years')[0].innerHTML = years;
                                  idEl.getElementsByClassName('days')[0].innerHTML = days;
                                  idEl.getElementsByClassName('hours')[0].innerHTML = hours;
                                  idEl.getElementsByClassName('minutes')[0].innerHTML = mins;
                                  idEl.getElementsByClassName('seconds')[0].innerHTML = secs;
                                
                                  clearTimeout(countUpFromTime.interval);
                                  countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
                                }
                                
                                // END Count time clockin / working function
      
            			    }
            			}
            			else if(dataResult.statusCode==201){
            				alert("Error occured !");
            				alert(current_user_timein);
            			}
            			console.log(dataResult);
            		}
            		
            	});
       
              }else{
                //Action when No is Clicked
                
              }
            });
            // End modal confirmation script from clock in function;
            
        </script>
    </body>
</html>