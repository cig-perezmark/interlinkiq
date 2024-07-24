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
    // include_once ('task_service_log2/private/connection.php');

    $con = $conn;
?>
<link rel="stylesheet" href="modules/Init.style.css">
<style>
#service_logs_table * {
    box-sizing: border-box;
}
</style>
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
                    <li class="activex hide">
                        <a href="#SERVICES" data-toggle="tab">Services</a>
                    </li>
                    <li class="dropdown active">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <span>Services</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" style="min-width: auto;">

                            <li>
                                <a data-toggle="modal" href="#addServiceLogModal">
                                    <i class="icon-plus"></i> Add new </a>
                            </li>
                            <li class="divider"></li>
                            <li title="Service logs from the last 30 days" class="active">
                                <a href="#SERVICES" data-toggle="tab">
                                    <i class="icon-clock"></i> My Services </a>
                            </li>
                            <li title="Overtime logs pending for manager's approval">
                                <a href="javascript:;" data-target="#pending_logs_tab" data-toggle="tab">
                                    <i class="icon-question"></i> Pending </a>
                            </li>
                            <li title="Disapproved Logs">
                                <a href="javascript:;" data-target="#invalid_logs_tab" data-toggle="tab">
                                    <i class="icon-dislike"></i> Invalid </a>
                            </li>
                        </ul>
                    </li>

                    <?php if($_COOKIE['ID'] == 43){ ?>
                    <li>
                        <a href="#filter_logs_data" data-toggle="tab">Filter</a>
                    </li>
                    <?php } ?>

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

                    <li title="Overtime service logs from the department members">
                        <a href="#Overtime_fa" data-toggle="tab">For Approvals</a>
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
                        <div style="margin-bottom: 2rem;">
                            <h3> Records from the last 30 days </h3>
                            <div class="alert alert-success alert-dismissable" id="advSearchAlert" style="display: none; margin-top:1rem;">
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
                        <a data-toggle="modal" href="#addServiceLogModal" id="addNewTaskBtn" style="display: none;" title="Add new log(s)">
                            <i class="fa fa-plus icon-margin-right"></i>
                            Add New
                        </a>
                        <a href="javascript:;" id="refreshServiceLogsTableBtn" style="display: none;" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="service_logs_table">
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
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tabbable tabbable-tabdrop hide">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_service_log" data-toggle="tab">Service Logs</a>
                                </li>
                                <li>
                                    <a href="#tab_log_approval" data-toggle="tab">For Approval Logs</a>
                                </li>
                                <li>
                                    <a href="#tab_disapprove" data-toggle="tab">Disapproved Logs</a>
                                </li>
                            </ul>
                            <div class="tab-content margin-top-20">
                                <div class="tab-pane active" id="tab_service_log">

                                </div>

                            </div>
                        </div>

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
                            <div class="col-md-12" style="margin-bottom: 2rem;">
                                <h3 style="margin: 0 0 1rem 0;">Employees' Overtime Service Logs</h3>
                                <h5 class="font-grey-cascade">
                                    Waiting for your approval.
                                    <a href="#">(refresh)</a>
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div style="padding:15px" class="hide">
                                    <label><input type="checkbox" id="checkAll" onclick="checkAll()"> Check All</label>
                                </div>
                                <table class="table table-bordered" id="for_approval_logs_table">
                                    <thead>
                                        <tr>
                                            <th style="max-width: 3rem;" title="Select all item(s)">
                                                <input type="checkbox" id="checkAll" onclick="checkAll()">
                                            </th>
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
                                    <tbody></tbody>
                                </table>
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
                            <div class="col-md-12">
                                <div class="">
                                    <h3 style="margin: 0 0 1rem 0;">
                                        Performance Summary
                                    </h3>
                                    <h5 class="font-grey-cascade">Last render date:
                                        <span data-performance="current_date"></span>
                                        <a href="#">(refresh)</a>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p>
                                        <strong>Reminder!</strong>
                                        Don't forget to log your tasks! It is important for your compensation and company's
                                        sales.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row  hide">
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
                        <div id="filter_data_range">

                        </div>


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

                    <div class="tab-pane" id="pending_logs_tab">
                        <div class="row">
                            <div class="col-md-9">
                                <h3 style="margin: 0 0 1rem 0;">Service logs Overtime for approval</h3>
                            </div>
                            <br><br>
                            <div class="col-md-12">
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
                    <div class="tab-pane" id="invalid_logs_tab">
                        <div class="row">
                            <div class="col-md-9">
                                <h3 style="margin: 0 0 1rem 0;">Service logs Overtime for approval</h3>
                            </div>
                            <br><br>
                            <div class="col-md-12">
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


                    <?php if(false): ?>
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
                            <a href="task_service_log2/SERVICES_LOG_TEMPLATE_UTF8.csv" class="btn green">
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
                    <?php endif; ?>
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

<script src="modules/js/init.js"></script>
<script src="task_service_log2/js/init.js"></script>
<script src="task_service_log2/js/script.js"></script>
<script src="task_service_log2/js/service_logs_modal.js"></script>

<?php include_once "service_log_index2_scripts.php"; ?>

<script src='task_service_log2/script.js'></script>
<script src='task_service_log2/va_summ_script.js'></script>

</body>

</html>