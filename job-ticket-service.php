<?php 
    $title = "Service";
    $site = "job-ticket-service";
    $breadcrumbs = '';
    $sub_breadcrumbs = 'Job Ticket Tracker';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /* DataTable*/
    .dt-buttons {
        margin: unset !important;
        float: left !important;
        margin-left: 15px !important;
    }
    div.dt-button-collection .dt-button.active:after {
        position: absolute;
        top: 50%;
        margin-top: -10px;
        right: 1em;
        display: inline-block;
        content: "✓";
        color: inherit;
    }
    .table {
        width: 100% !important;
    }
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
    .table thead tr th {
        vertical-align: middle;
    }

    .custom-file-upload {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .upload-icon {
        background-color: #f1f1f1;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 18px;
        color: #333;
        transition: background-color 0.3s;
    }

    .upload-icon:hover {
        background-color: #e0e0e0;
    }

    .hidden-input {
        display: none !important;
    }

    .file-count-label {
        font-weight: 500;
        color: #555;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-earphones-alt font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Services</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_actions_assigned" data-toggle="tab">List</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_completed" data-toggle="tab" onclick="btnTabComplete()">Completed</a>
                                        </li>
                                        
                                        <?php
                                            if ($current_userID == 35 OR $current_userID == 54 OR $current_userID == 55 OR $current_userID == 42 OR $current_userID == 178 OR $current_userID == 40 OR $current_userID == 153 OR $current_userID == 43) {
                                                echo '<li>
                                                    <a href="#tab_actions_report" data-toggle="tab">Report</a>
                                                </li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_actions_assigned">
                                            <div class="table-scrollablex">
                                                <table class="table table-bordered table-hover" id="tableDataServicesAssigned">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 24px;">ID#</th>
                                                            <th style="width: 60px;">Category</th>
                                                            <th>Service</th>
                                                            <th>Contact Info</th>
                                                            <th class="text-center" style="width: 80px;">Date Requested</th>
                                                            <th class="text-center" style="width: 80px;">Desire Due Date</th>
                                                            <th class="text-center" style="width: 50px;">Status</th>
                                                            <th class="text-center" style="width: 135px;">Assigned</th>
                                                            <th style="width: 80px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="word-break: break-all;">
                                                        <?php
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id = $current_userID AND (assigned_to_id IS NOT NULL OR assigned_to_id != '')" );
                                                            // if ($current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 17 OR $current_userID == 185) { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0" ); }
                                                            // else { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', ''))" ); }
                                                            
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id = $current_userID" );
                                                            
                                                            // $sql_custom = '';
                                                            // if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                            //     $sql_custom = " AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', '')) ";
                                                            // }
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 0 AND deleted = 0 AND user_id != $current_userID $sql_custom " );
                                                            
                                                            $counter = 1;
                                                            $sql_custom = '';
                                                            if ($switch_user_id != 34) {
                                                                $sql_custom .= ' AND r.switch_user_id = '.$switch_user_id;
                                                            }
                                                            if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                                $sql_custom .= " AND FIND_IN_SET($current_userEmployeeID, REPLACE(r.s_assigned_to_id, ' ', '')) ";
                                                            }
                                                            $result = mysqli_query( $conn,"
                                                                SELECT
                                                                s_ID,
                                                                s_category,
                                                                s_title,
                                                                s_description,
                                                                s_contact,
                                                                s_email,
                                                                s_files,
                                                                s_due_date,
                                                                s_last_modified,
                                                                s_type,
                                                                u_ID,
                                                                u_employee_id,
                                                                u_first_name,
                                                                e_user_id,
                                                                s_assigned_to_id,
                                                                switch_user_id,
                                                                GROUP_CONCAT(CONCAT(ee.first_name,' ', ee.last_name) ORDER BY ee.first_name ASC SEPARATOR ', ') AS ee_assigned_to
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.category AS s_category,
                                                                    s.title AS s_title,
                                                                    s.description AS s_description,
                                                                    s.contact AS s_contact,
                                                                    s.email AS s_email,
                                                                    s.files AS s_files,
                                                                    s.due_date AS s_due_date,
                                                                    s.last_modified AS s_last_modified,
                                                                    s.assigned_to_id AS s_assigned_to_id,
                                                                    s.type AS s_type,
                                                                    u.ID AS u_ID,
                                                                    u.employee_id AS u_employee_id,
                                                                    u.first_name AS u_first_name,
                                                                    e.user_id AS e_user_id,
                                                                    CASE WHEN LENGTH(e.user_id) > 0 THEN e.user_id ELSE u.ID END AS switch_user_id

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.status = 0 
                                                                    AND s.deleted = 0
                                                                ) r

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS ee
                                                                ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                WHERE r.u_ID != $current_userID
                                                                $sql_custom

                                                                GROUP BY s_ID

                                                                ORDER BY s_ID
                                                            " );
                                                            
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $category_id = $row["s_category"];
                                                                    $category = array(
                                                                        0 => 'Others',
                                                                        1 => 'IT Services',
                                                                        2 => 'Technical Services',
                                                                        3 => 'Sales',
                                                                        4 => 'Request Demo',
                                                                        5 => 'Suggestion',
                                                                        6 => 'Problem',
                                                                        7 => 'Praise'
                                                                    );

                                                                    $status_id = $row["s_type"];
                                                                    $status = array(
                                                                        0 => '<span class="label label-sm label-info">Assigned</span>',
                                                                        1 => '<span class="label label-sm label-primary">On Queue</span>',
                                                                        2 => '<span class="label label-sm label-warning">On Going</span>',
                                                                        3 => '<span class="label label-sm label-success">Fixed</span>',
                                                                        4 => '<span class="label label-sm label-danger">Unresolved</span>'
                                                                    );

                                                                    $jt_file = '';
                                                                    $file_files = $row["s_files"];
                                                                    if (!empty($file_files)) {

                                                                        $files_arr = explode(" | ", $file_files);
                                                                        if (count($files_arr) > 1) {

                                                                            foreach ($files_arr as $f) {

                                                                                $fileExtension = fileExtension($f);
                                                                                $src = $fileExtension['src'];
                                                                                $embed = $fileExtension['embed'];
                                                                                $type = $fileExtension['type'];
                                                                                $file_extension = $fileExtension['file_extension'];
                                                                                $url = $base_url.'uploads/services/';

                                                                                $jt_file .= '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($f).$embed.'" data-caption="&lt;a href=&quot;'.$url.rawurlencode($f).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; " data-fancybox="fancybox_'.$row["s_ID"].'" data-fancybox data-type="'.$type.'">View</a></p>';
                                                                            }
                                                                        } else {
                                                                            $fileExtension = fileExtension($file_files);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/services/';

                                                                            $jt_file = '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-caption="&lt;a href=&quot;'.$url.rawurlencode($file_files).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; " data-fancybox data-type="'.$type.'">View</a></p>';
                                                                        }
                                                                    }
                                                                    
                                                                    $date_start = $row["s_last_modified"];
                                                                    $date_start = new DateTime($date_start);
                                                                    $date_start = $date_start->format('Y-m-d');
                                                                    
                                                                    $date_end = $row["s_due_date"];
                                                                    $date_end = new DateTime($date_end);
                                                                    $date_end = $date_end->format('Y-m-d');

                                                                    echo '<tr id="tr_'.$row["s_ID"].'">
                                                                        <td>'.$counter++.'</td>
                                                                        <td>'.$category[$category_id].'</td>
                                                                        <td>
                                                                            <p style="margin: 0;"><b>'.htmlentities($row["s_title"] ?? '').'</b></p>
                                                                            <p style="margin: 0;">'.htmlentities($row["s_description"] ?? '').'</p>'.$jt_file.'
                                                                        </td>
                                                                        <td>
                                                                            <p style="margin: 0;">'.htmlentities($row["s_contact"] ?? '').'</p>
                                                                            <p style="margin: 0;"><a href="mailto:'.htmlentities($row["s_email"] ?? '').'" target="_blank">'.htmlentities($row["s_email"] ?? '').'</a></p>
                                                                        </td>
                                                                        <td class="text-center">'.$date_start.'</td>
                                                                        <td class="text-center">'.$date_end.'</td>
                                                                        <td class="text-center">'; echo empty($row["s_assigned_to_id"]) ? 'Pending':$status[$status_id]; echo '</td>
                                                                        <td class="text-center">'.$row["ee_assigned_to"].'</td>
                                                                        <td class="text-center">
                                                                            <div class="btn-group btn-group-circle">
                                                                                <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-id="'.$row["s_ID"].'" data-toggle="modal" onclick="btnView('.$row["s_ID"].')">View</a>
                                                                                <a href="javascript:;" class="btn btn-outlinex green btn-sm btnDone" data-id="'.$row["s_ID"].'" onclick="btnDone('.$row["s_ID"].')">Done</a>
                                                                            </div>
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
                                        <div class="tab-pane" id="tab_actions_completed">
                                            <div class="table-scrollablex">
                                                <table class="table table-bordered table-hover" id="tableDataServicesComplete">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 24px;">ID#</th>
                                                            <th style="width: 60px;">Category</th>
                                                            <th>Service</th>
                                                            <th>Contact Info</th>
                                                            <th class="text-center" style="width: 80px;">Desire Due Date</th>
                                                            <th class="text-center" style="width: 135px;">Assigned</th>
                                                            <th class="text-center" style="width: 80px;">Completed</th>
                                                            <th style="width: 80px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="word-break: break-all;">
                                                        <?php
                                                            // if ($current_userID == 1 OR $current_userID == 2 OR $current_userID == 19 OR $current_userID == 17 OR $current_userID == 185) { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0" ); }
                                                            // else { $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0 AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', ''))" ); }
                                                            
                                                            // $sql_custom = '';
                                                            // if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                            //     $sql_custom = " AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', '')) ";
                                                            // }
                                                            // $result = mysqli_query( $conn,"SELECT * FROM tbl_services WHERE status = 1 AND deleted = 0 AND user_id != $current_userID $sql_custom " );
                                                            
                                                            $counter = 1;
                                                            $sql_custom = '';
                                                            if ($switch_user_id != 34) {
                                                                $sql_custom .= ' AND r.switch_user_id = '.$switch_user_id;
                                                            }
                                                            if ( !empty(menu('job-ticket', $current_userEmployerID, $current_userEmployeeID)) ) {
                                                                $sql_custom .= " AND FIND_IN_SET($current_userEmployeeID, REPLACE(r.s_assigned_to_id, ' ', '')) ";
                                                            }
                                                            $result = mysqli_query( $conn,"
                                                                SELECT
                                                                s_ID,
                                                                s_category,
                                                                s_title,
                                                                s_description,
                                                                s_contact,
                                                                s_email,
                                                                s_files,
                                                                s_due_date,
                                                                s_last_modified,
                                                                s_type,
                                                                u_ID,
                                                                u_employee_id,
                                                                u_first_name,
                                                                e_user_id,
                                                                s_assigned_to_id,
                                                                switch_user_id,
                                                                GROUP_CONCAT(CONCAT(ee.first_name,' ', ee.last_name) ORDER BY ee.first_name ASC SEPARATOR ', ') AS ee_assigned_to
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.category AS s_category,
                                                                    s.title AS s_title,
                                                                    s.description AS s_description,
                                                                    s.contact AS s_contact,
                                                                    s.email AS s_email,
                                                                    s.files AS s_files,
                                                                    s.due_date AS s_due_date,
                                                                    s.last_modified AS s_last_modified,
                                                                    s.assigned_to_id AS s_assigned_to_id,
                                                                    s.type AS s_type,
                                                                    u.ID AS u_ID,
                                                                    u.employee_id AS u_employee_id,
                                                                    u.first_name AS u_first_name,
                                                                    e.user_id AS e_user_id,
                                                                    CASE WHEN LENGTH(e.user_id) > 0 THEN e.user_id ELSE u.ID END AS switch_user_id

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.status = 1
                                                                    AND s.deleted = 0
                                                                ) r

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS ee
                                                                ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                WHERE r.u_ID != $current_userID
                                                                $sql_custom

                                                                GROUP BY s_ID

                                                                ORDER BY s_ID
                                                            " );
                                                            
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $category_id = $row["s_category"];
                                                                    $category = array(
                                                                        0 => 'Others',
                                                                        1 => 'IT Services',
                                                                        2 => 'Technical Services',
                                                                        3 => 'Sales',
                                                                        4 => 'Request Demo',
                                                                        5 => 'Suggestion',
                                                                        6 => 'Problem',
                                                                        7 => 'Praise'
                                                                    );

                                                                    $jt_file = '';
                                                                    $file_files = $row["s_files"];
                                                                    if (!empty($file_files)) {

                                                                        $files_arr = explode(" | ", $file_files);
                                                                        if (count($files_arr) > 1) {

                                                                            foreach ($files_arr as $f) {

                                                                                $fileExtension = fileExtension($f);
                                                                                $src = $fileExtension['src'];
                                                                                $embed = $fileExtension['embed'];
                                                                                $type = $fileExtension['type'];
                                                                                $file_extension = $fileExtension['file_extension'];
                                                                                $url = $base_url.'uploads/services/';

                                                                                $jt_file .= '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($f).$embed.'" data-caption="&lt;a href=&quot;'.$url.rawurlencode($f).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; " data-fancybox="fancybox_'.$row["s_ID"].'" data-fancybox data-type="'.$type.'">View</a></p>';
                                                                            }
                                                                        } else {
                                                                            $fileExtension = fileExtension($file_files);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/services/';

                                                                            $jt_file = '<p style="margin: 0;">File: <a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-caption="&lt;a href=&quot;'.$url.rawurlencode($file_files).'&quot; target=&quot;_blank&quot; &gt; Download &lt;/a&gt; " data-fancybox data-type="'.$type.'">View</a></p>';
                                                                        }
                                                                    }
                                                                    
                                                                    $date_start = $row["s_last_modified"];
                                                                    $date_start = new DateTime($date_start);
                                                                    $date_start = $date_start->format('Y-m-d');
                                                                    
                                                                    $date_end = $row["s_due_date"];
                                                                    $date_end = new DateTime($date_end);
                                                                    $date_end = $date_end->format('Y-m-d');

                                                                    echo '<tr id="tr_'.$row["s_ID"].'">
                                                                        <td>'.$row["s_ID"].'</td>
                                                                        <td>'.$category[$category_id].'</td>
                                                                        <td>
                                                                            <p style="margin: 0;"><b>'.htmlentities($row["s_title"] ?? '').'</b></p>
                                                                            <p style="margin: 0;">'.htmlentities($row["s_description"] ?? '').'</p>'.$jt_file.'
                                                                        </td>
                                                                        <td>
                                                                            <p style="margin: 0;">'.htmlentities($row["s_contact"] ?? '').'</p>
                                                                            <p style="margin: 0;"><a href="mailto:'.htmlentities($row["s_email"] ?? '').'" target="_blank">'.htmlentities($row["s_email"] ?? '').'</a></p>
                                                                        </td>
                                                                        <td class="text-center">'.$date_end.'</td>
                                                                        <td class="text-center">'.$row["ee_assigned_to"].'</td>
                                                                        <td class="text-center">'.$date_start.'</td>
                                                                        <td class="text-center">
                                                                            <a href="#modalView2" class="btn btn-circle btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView2('.$row["s_ID"].')">View</a>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr class="text-center text-default"><td colspan="7">Empty Record</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_report">
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                    <?php
                                                        $selectTotalStatus = mysqli_query( $conn,"
                                                            SELECT
                                                            SUM(pending) AS un_assigned,
                                                            SUM(assigned) AS assigned,
                                                            SUM(on_queue) AS on_queue,
                                                            SUM(on_going) AS on_going,
                                                            SUM(fixed) AS fixed,
                                                            SUM(unresolve) AS unresolve
                                                            FROM (
                                                                SELECT
                                                                CASE WHEN type = 0 AND assigned_to_id IS NULL AND assigned_to_id = '' THEN 1 ELSE 0 END AS pending,
                                                                CASE WHEN type = 0 AND assigned_to_id IS NOT NULL AND assigned_to_id != '' THEN 1 ELSE 0 END AS assigned,
                                                                CASE WHEN type = 1 THEN 1 ELSE 0 END AS on_queue,
                                                                CASE WHEN type = 2 THEN 1 ELSE 0 END AS on_going,
                                                                CASE WHEN type = 3 THEN 1 ELSE 0 END AS fixed,
                                                                CASE WHEN type = 4 THEN 1 ELSE 0 END AS unresolve
                                                                FROM tbl_services

                                                                WHERE deleted = 0
                                                                AND status = 0
                                                            ) r
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalStatus) > 0 ) {
                                                            while($rowTotalStatus = mysqli_fetch_array($selectTotalStatus)) {
                                                                echo ' <tr>
                                                                    <td colspan="2" class="bg-default "><h5 class="bold">Total Status</h5></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pending</td>
                                                                    <td>'.$rowTotalStatus["un_assigned"].'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Assigned</td>
                                                                    <td>'.$rowTotalStatus["assigned"].'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>On Queue</td>
                                                                    <td>'.$rowTotalStatus["on_queue"].'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>On Going</td>
                                                                    <td>'.$rowTotalStatus["on_going"].'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fixed</td>
                                                                    <td>'.$rowTotalStatus["fixed"].'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Unresolved</td>
                                                                    <td>'.$rowTotalStatus["unresolve"].'</td>
                                                                </tr>';
                                                            }
                                                        }



                                                        $ticket_open = 0;
                                                        $ticket_close = 0;
                                                        $selectOpenClose = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(s_status) AS s_total,
                                                            SUM(s_status) AS s_close,
                                                            COUNT(s_status) - SUM(s_status) AS s_open
                                                            FROM (
                                                                SELECT
                                                                s_status
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.assigned_to_id AS s_assigned_to_id,
                                                                    s.status AS s_status

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.deleted = 0
                                                                ) r

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS ee
                                                                ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                GROUP BY s_ID

                                                                ORDER BY s_ID
                                                            ) r
                                                        " );
                                                        if ( mysqli_num_rows($selectOpenClose) > 0 ) {
                                                            $rowOpenClose = mysqli_fetch_array($selectOpenClose);
                                                            $ticket_open = $rowOpenClose["s_open"];
                                                            $ticket_close = $rowOpenClose["s_close"];
                                                        }
                                                        echo '<tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Open and Close Tickets</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Open</td>
                                                            <td>'.$ticket_open.'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Close</td>
                                                            <td>'.$ticket_close.'</td>
                                                        </tr>';



                                                        $ticket_completed_today = 0;
                                                        $selectCompletedToday = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(s_ID) AS completed_today
                                                            FROM (
                                                                SELECT
                                                                s_ID,
                                                                s_last_modified
                                                                FROM (
                                                                    SELECT 
                                                                    s.ID AS s_ID,
                                                                    s.last_modified AS s_last_modified,
                                                                    s.assigned_to_id AS s_assigned_to_id

                                                                    FROM tbl_services AS s

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_user
                                                                    ) AS u
                                                                    ON s.user_id = u.ID

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_hr_employee
                                                                    ) AS e
                                                                    ON u.employee_id = e.ID

                                                                    WHERE s.status = 1 
                                                                    AND s.deleted = 0
                                                                ) r

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS ee
                                                                ON FIND_IN_SET(ee.ID, REPLACE(REPLACE(r.s_assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                WHERE DATE(s_last_modified) = CURDATE()

                                                                GROUP BY s_ID

                                                                ORDER BY s_ID
                                                            ) t
                                                        " );
                                                        if ( mysqli_num_rows($selectCompletedToday) > 0 ) {
                                                            $rowCompletedToday = mysqli_fetch_array($selectCompletedToday);
                                                            $ticket_completed_today = $rowCompletedToday["completed_today"];
                                                        }
                                                        echo '<tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Completed Tickets Today</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Completed</td>
                                                            <td>'.$ticket_completed_today.'</td>
                                                        </tr>';
                                                        
                                                        

                                                        echo ' <tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Assigned Tickets</h5></td>
                                                        </tr>';
                                                        $selectTotalAssigned = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(e_ID) AS e_total,
                                                            e_first_name,
                                                            e_last_name
                                                            FROM (
                                                                SELECT
                                                                e.ID AS e_ID,
                                                                e.first_name AS e_first_name,
                                                                e.last_name AS e_last_name
                                                                FROM tbl_services AS s

                                                                RIGHT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS e
                                                                ON FIND_IN_SET(e.ID, REPLACE(REPLACE(s.assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                WHERE s.deleted = 0
                                                                AND s.status = 0
                                                                AND s.assigned_to_id IS NOT NULL
                                                                AND s.assigned_to_id != ''
                                                            ) r

                                                            GROUP BY e_ID
                                                            ORDER BY e_first_name
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalAssigned) > 0 ) {
                                                            while($rowTotalAssigned = mysqli_fetch_array($selectTotalAssigned)) {
                                                                echo '<tr>
                                                                    <td>'.htmlentities($rowTotalAssigned["e_first_name"] ?? '').' '.htmlentities($rowTotalAssigned["e_last_name"] ?? '').'</td>
                                                                    <td>'.$rowTotalAssigned["e_total"].'</td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo ' <tr>
                                                                <td colspan="2">No available record</td>
                                                            </tr>';
                                                        }
                                                        
                                                        

                                                        echo ' <tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Closed Ticket by Assigned VA Today</h5></td>
                                                        </tr>';
                                                        $selectTotalAssignedClose = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(e_ID) AS e_total,
                                                            e_first_name,
                                                            e_last_name
                                                            FROM (
                                                                SELECT
                                                                e.ID AS e_ID,
                                                                e.first_name AS e_first_name,
                                                                e.last_name AS e_last_name
                                                                FROM tbl_services AS s

                                                                RIGHT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_hr_employee
                                                                ) AS e
                                                                ON FIND_IN_SET(e.ID, REPLACE(REPLACE(s.assigned_to_id, ' ', ''), '|',','  )  ) > 0

                                                                WHERE s.deleted = 0
                                                                AND s.status = 1
                                                                AND s.assigned_to_id IS NOT NULL
                                                                AND s.assigned_to_id != ''
                                                                AND DATE(s.last_modified) = CURDATE()
                                                            ) r

                                                            GROUP BY e_ID
                                                            ORDER BY e_first_name
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalAssignedClose) > 0 ) {
                                                            while($rowTotalAssignedClose = mysqli_fetch_array($selectTotalAssignedClose)) {
                                                                echo '<tr>
                                                                    <td>'.htmlentities($rowTotalAssignedClose["e_first_name"] ?? '').' '.htmlentities($rowTotalAssignedClose["e_last_name"] ?? '').'</td>
                                                                    <td>'.$rowTotalAssignedClose["e_total"].'</td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo ' <tr>
                                                                <td colspan="2">No available record</td>
                                                            </tr>';
                                                        }
                                                        
                                                        

                                                        echo ' <tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Due</h5></td>
                                                        </tr>';
                                                        $selectTotalDue = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(ID) AS total_due
                                                            FROM tbl_services
                                                            WHERE deleted = 0
                                                            AND status = 0
                                                            AND DATE(due_date) <= CURDATE()
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalDue) > 0 ) {
                                                            while($rowTotalDue = mysqli_fetch_array($selectTotalDue)) {
                                                                echo '<tr>
                                                                    <td>Past Due</td>
                                                                    <td>'.$rowTotalDue["total_due"].'</td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo ' <tr>
                                                                <td colspan="2">No available record</td>
                                                            </tr>';
                                                        }
                                                        
                                                        

                                                        echo ' <tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Ticket Recieved Today</h5></td>
                                                        </tr>';
                                                        $selectTotalReceivedToday = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(ID) AS received_today
                                                            FROM tbl_services
                                                            WHERE deleted = 0
                                                            AND status = 0
                                                            AND DATE(date_added) = CURDATE()
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalReceivedToday) > 0 ) {
                                                            $rowTotalReceivedToday = mysqli_fetch_array($selectTotalReceivedToday);
                                                            echo '<tr>
                                                                <td>Received</td>
                                                                <td>'.$rowTotalReceivedToday["received_today"].'</td>
                                                            </tr>';
                                                        } else {
                                                            echo ' <tr>
                                                                <td colspan="2">No available record</td>
                                                            </tr>';
                                                        }



                                                        $selectTotalPerCategory = mysqli_query( $conn,"
                                                            SELECT
                                                            SUM(it_services) AS it_services,
                                                            SUM(technical_services) AS technical_services,
                                                            SUM(sales) AS sales,
                                                            SUM(request_demo) AS request_demo,
                                                            SUM(suggestion) AS suggestion,
                                                            SUM(problem) AS problem,
                                                            SUM(praise) AS praise,
                                                            SUM(others) AS others
                                                            FROM (
                                                                SELECT
                                                                CASE WHEN category = 1 THEN 1 ELSE 0 END AS it_services,
                                                                CASE WHEN category = 2 THEN 1 ELSE 0 END AS technical_services,
                                                                CASE WHEN category = 3 THEN 1 ELSE 0 END AS sales,
                                                                CASE WHEN category = 4 THEN 1 ELSE 0 END AS request_demo,
                                                                CASE WHEN category = 5 THEN 1 ELSE 0 END AS suggestion,
                                                                CASE WHEN category = 6 THEN 1 ELSE 0 END AS problem,
                                                                CASE WHEN category = 7 THEN 1 ELSE 0 END AS praise,
                                                                CASE WHEN category = 0 THEN 1 ELSE 0 END AS others
                                                                FROM tbl_services

                                                                WHERE deleted = 0
                                                                AND status = 0
                                                            ) r
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalPerCategory) > 0 ) {
                                                            $rowTotalPerCategory = mysqli_fetch_array($selectTotalPerCategory);
                                                            echo '<tr>
                                                                <td colspan="2" class="bg-default "><h5 class="bold">Total Ticket Per Category</h5></td>
                                                            </tr>
                                                            <tr>
                                                                <td>IT Services</td>
                                                                <td>'.$rowTotalPerCategory["it_services"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Technical Services</td>
                                                                <td>'.$rowTotalPerCategory["technical_services"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sales</td>
                                                                <td>'.$rowTotalPerCategory["sales"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Request Demo</td>
                                                                <td>'.$rowTotalPerCategory["request_demo"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Suggestion</td>
                                                                <td>'.$rowTotalPerCategory["suggestion"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Problem</td>
                                                                <td>'.$rowTotalPerCategory["problem"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Praise</td>
                                                                <td>'.$rowTotalPerCategory["praise"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Others</td>
                                                                <td>'.$rowTotalPerCategory["others"].'</td>
                                                            </tr>';
                                                        }



                                                        echo '<tr>
                                                            <td colspan="2" class="bg-default "><h5 class="bold">Total Tickets requested by the VA</h5></td>
                                                        </tr>';
                                                        $selectTotalRequested = mysqli_query( $conn,"
                                                            SELECT
                                                            COUNT(name) AS total_name,
                                                            name
                                                            FROM tbl_services
                                                            WHERE deleted = 0
                                                            AND name IS NOT NULL
                                                            AND name != ''

                                                            GROUP BY name
                                                            ORDER BY name
                                                        " );
                                                        if ( mysqli_num_rows($selectTotalRequested) > 0 ) {
                                                            while($rowTotalRequested = mysqli_fetch_array($selectTotalRequested)) {
                                                                echo '<tr>
                                                                    <td>'.$rowTotalRequested["name"].'</td>
                                                                    <td>'.$rowTotalRequested["total_name"].'</td>
                                                                </tr>';
                                                            }
                                                        } else {
                                                            echo ' <tr>
                                                                <td colspan="2">No available record</td>
                                                            </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_Service" id="btnUpdate_Service" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bs-modal-lg" id="modalView2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Service Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script type="text/javascript">
            $(document).ready(function(){
                var i = '<?php echo isset($_GET['i']) ? $_GET['i']:''; ?>';
                if (i != '') {
                    $('#modalView').modal('show');
                    btnView(i);
                }
                document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
                    el.addEventListener('shown.bs.tab', () => {
                        DataTable.tables({ visible: true, api: true }).columns.adjust();
                    });
                });
                
                $('#tableDataServicesAssigned').DataTable({
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
                    ],
                    columnDefs: [
                        {width: '24px', targets: 0},
                        {width: '60px', targets: 1},
                        {width: '135px', targets: 3},
                        {width: '80px', targets: 4},
                        {width: '80px', targets: 5},
                        {width: '50px', targets: 6},
                        {width: '135px', targets: 7},
                        {width: '90px', targets: 8}
                    ]
                });
                $('#tableDataServicesComplete').DataTable({
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
                    ],
                    columnDefs: [
                        {width: '24px', targets: 0},
                        {width: '60px', targets: 1},
                        {width: '135px', targets: 3},
                        {width: '80px', targets: 4},
                        {width: '135px', targets: 5},
                        {width: '80px', targets: 6}
                    ]
                });
            });
            
            function btnExportFiles(id) {
                window.location.href = 'export/function.php?modalDLJT='+id;
            }
            function btnTabComplete() {
                // $("#tableDataServicesComplete").DataTable().columns.adjust().draw();
                // alert('sd');
            }
            function btnDone(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will move to Completed Tab!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDone="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id).remove();
                            
                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.ID+'</td>';
                                result += '<td>'+obj.category+'</td>';
                                result += '<td>';
                                    result += '<p style="margin: 0;">'+obj.title+'</p>';
                                    result += '<p style="margin: 0;">'+obj.description+'</p>';

                                    if (obj.files != "") {
                                        result += '<p style="margin: 0;">'+obj.files+'</p>';
                                    }

                                result += '</td>';
                                result += '<td>';
                                    result += '<p style="margin: 0;">'+obj.contact+'</p>';
                                    result += '<p style="margin: 0;"><a href="mailto:'+obj.email+'" target="_blank">'+obj.email+'</a></p>';
                                result += '</td>';
                                result += '<td class="text-center">'+obj.due_date+'</td>';
                                result += '<td class="text-center">'+obj.last_modified+'</td>';
                            result += '</tr>';

                            $('#tab_actions_completed #tableDataServicesComplete tbody').append(result);
                        }
                    });
                    swal("Done!", "This item has been moved to Completed Tab.", "success");
                });
            }

            function comment_file(e){
                const count = e.files.length;
                const label = count > 0 ? count + ' file(s) selected':'No files selected';
                $('.file-count-label').html(label);
            }
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Services="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);

                        selectMulti();
                    }
                });
            }
            function btnView2(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Services2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView2 .modal-body").html(data);

                        selectMulti();
                    }
                });
            }
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Service'));
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
                            if (obj.assigned_to_id != '') {
                                
                                var obj = jQuery.parseJSON(response);
                                var html = '<td>'+obj.ID+'</td>';
                                html += '<td>'+obj.category+'</td>';
                                html += '<td>';
                                    html += '<p style="margin: 0;"><b>'+obj.title+'</b></p>';
                                    html += '<p style="margin: 0;">'+obj.description+'</p>';

                                    if (obj.files != "") { html += '<p style="margin: 0;">'+obj.files+'</p>'; }

                                html += '</td>';
                                html += '<td>';
                                    html += '<p style="margin: 0;">'+obj.contact+'</p>';
                                    html += '<p style="margin: 0;"><a href="mailto:'+obj.email+'" target="_blank">'+obj.email+'</a></p>';
                                html += '</td>';
                                html += '<td class="text-center">'+obj.last_modified+'</td>';
                                html += '<td class="text-center">'+obj.due_date+'</td>';
                                html += '<td class="text-center">'+obj.status+'</td>';
                                html += '<td class="text-center"></td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-id="'+obj.ID+'" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex green btn-sm btnDone" data-id="'+obj.ID+'" onclick="btnDone('+obj.ID+')">Done</a>';
                                    html += '</div>';
                                html += '</td>';

                                $('#tab_actions_assigned #tableDataServicesAssigned tbody #tr_'+obj.ID).html(html);
                            }
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
