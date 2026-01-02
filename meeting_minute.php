<?php 
    $date_default_tx = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date_default_tx->setTimeZone(new DateTimeZone('America/Chicago'));
    $today_tx = $date_default_tx->format('Y-m-d');
    $title = "Meeting minutes";
    $site = "meeting_minute";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
?>
<style type="text/css">
    .bootstrap-tagsinput { min-height: 100px; }
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    #tableData_Contact input,
    #tableData_Material input,
    #tableData_Service input {
        border: 0 !important;
        background: transparent;
        outline: none;
    }

    /*Start meeting minutes*/
    @media screen {
        #pdf_generate {
            display: none;
        }
    }

    @media print {
        body * {
            visibility:hidden;
        }
        #pdf_generate, #pdf_generate * {
            visibility:visible;
        }
        #pdf_generate {
            position:absolute;
            left:0;
            top:0;
        }
    }


    /*end meeting minutes*/
    /*Loader*/
    .loader {
        display: inline-block;
        width: 30px;
        height: 30px;
        position: relative;
        border: 4px solid #Fff;
        top: 50%;
        animation: loader 2s infinite ease;
    }

    .loader-inner {
        vertical-align: top;
        display: inline-block;
        width: 100%;
        background-color: #fff;
        animation: loader-inner 2s infinite ease-in;
    }

    @keyframes loader {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(180deg);
        }

        50% {
            transform: rotate(180deg);
        }

        75% {
            transform: rotate(360deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes loader-inner {
        0% {
            height: 0%;
        }

        25% {
            height: 0%;
        }

        50% {
            height: 100%;
        }

        75% {
            height: 100%;
        }

        100% {
            height: 0%;
        }
    }
</style>


        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-users font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Meeting Minutes</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <a class="btn dark btn-outline btn-circle btn-sm" href="<?php echo $FreeAccess == false ? '#modalAdd_details':'#modalService'; ?>" data-toggle="modal" class="btn btn-outline dark btn-sm"  data-close-others="true"> 
                                    Add New
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable" style="border:none;">
                            <div class="form-group">
                                <div class="col-md-10">
                                    <input class="form-control data_MoM" placeholder="Search">
                                </div>
                                <div class="col-md-2" id="all_data_item"></div>
                            </div>
                            <div class="col-md-12 margin-top-20">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table_data_tr">
                                    <thead>
                                        <tr>
                                            <th>Account</th>
                                            <th style="min-width: 10rem;">Date</th>
                                            <th>Agenda</th>
                                            <th>Attendees</th>
                                            <th class="text-center" style="min-width: 13rem !important;">Action Items</th>
                                            <th class="text-center" style="min-width: 12rem !important;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="meeting_tbl">
                                        <?php
                                            // Admin - display all
                                            // Employee - display only created and connected
                                            if ($current_userEmployeeID > 0) {
                                                if (isset($_COOKIE['switchAccount'])) {
                                                    $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes WHERE user_ids = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY inserted_at DESC");
                                                    if(mysqli_num_rows($meetings) > 0) {
                                                        $counter = 0;
                                                        while($row = $meetings->fetch_assoc()) {
                                                            $array_data = explode(", ", $row["attendees"]);
                                                            // if(in_array($cookie_employee_id,$array_data)) {
        
                                                                echo '<tr id="id_'.$row['id'].'">
                                                                    <td>'.$row['account'].'</td>
                                                                    <td>'.$row['meeting_date'].'</td>
                                                                    <td>';
                                                                        if (!empty($row['agendas'])) {
                                                                            echo '<ul style="margin-bottom: 0;">';
                                                                            
                                                                                $agendas = $row["agendas"];
                                                                                $agendas_arr = explode(", ", $agendas);
                                                                                foreach ($agendas_arr as $value) {
                                                                                    $selectAgenda = mysqli_query( $conn,"SELECT name FROM tbl_meeting_minutes_agenda WHERE ID = $value" );
                                                                                    if ( mysqli_num_rows($selectAgenda) > 0 ) {
                                                                                        $rowAgenda = mysqli_fetch_array($selectAgenda);
                                                                                        
                                                                                        echo '<li>'.$rowAgenda['name'].'</li>';
                                                                                    }
                                                                                }
                                                                            echo '</ul>';
                                                                        }
                                                                        if (!empty($row['agenda'])) {
                                                                            echo '<ul>
                                                                                <li>'.htmlentities($row["agenda"] ?? '').'</li>
                                                                            </ul>';
                                                                        }
                                                                    
                                                                    echo '</td>
                                                                    <td>';
                                                                        $array_data = explode(", ", $row["attendees"]);
                                                                        $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                                                        $resultAssignto = mysqli_query($conn, $queryAssignto);
                                                                        while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                                                            if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
                                                                        }
        
                                                                    echo '</td>
                                                                    <td class="text-center">';
        
                                                                        $getId = $row['id'];
                                                                        // $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                                                        $resultOpen = mysqli_query($conn, "
                                                                            SELECT 
                                                                            COUNT(*) AS countAction, 
                                                                            COALESCE(SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END), 0) AS countOpen, 
                                                                            COALESCE(SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END), 0) AS countFollow, 
                                                                            COALESCE(SUM(CASE WHEN status = 'Close' THEN 1 ELSE 0 END), 0) AS countClose 
                                                                            FROM tbl_meeting_minutes_action_items
                                                                            
                                                                            WHERE deleted = 0 AND action_meeting_id = $getId
                                                                        ");
                                                                        while($rowOpen = mysqli_fetch_array($resultOpen)) {
                                                                            // $btnBG = 'btn-success';
                                                                            // if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                                                            // else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }
                                                                            
                                                                            echo '<div class="btn-group btn-group-circle">
                                                                                <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm dark" type="button" onclick="btnGet_status('.$row['id'].')" title="Open">'.$rowOpen['countOpen'].'</a>
                                                                                <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-warning" type="button" onclick="btnGet_status('.$row['id'].')" title="Follow Up">'.$rowOpen['countFollow'].'</a>
                                                                                <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-success" type="button" onclick="btnGet_status('.$row['id'].')" title="Close">'.$rowOpen['countClose'].'</a>
                                                                            </div>';
                                                                        }
        
                                                                    echo '</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('.$row['id'].')">Edit</a>
                                                                            <a href="/pdf/meeting_minutes?i='.$row['id'].'" class="btn red btn-sm" type="button" target="_blank">PDF</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            // }
                                                        }
                                                    }
                                                } else {
                                                    $meetings = $conn->query("
                                                        SELECT
                                                        *
                                                        FROM (
                                                        
                                                            SELECT * FROM tbl_meeting_minutes WHERE user_ids = $switch_user_id AND facility_switch = $facility_switch_user_id AND FIND_IN_SET($current_userEmployeeID, REPLACE(attendees, ' ', '')) > 0
                                                                                                                
                                                            UNION ALL
                                                            
                                                            SELECT * FROM tbl_meeting_minutes WHERE user_ids = $switch_user_id AND facility_switch = $facility_switch_user_id AND added_by_id = $current_userID
                                                        ) r
                                                        
                                                        GROUP BY id
                                                        
                                                        ORDER BY inserted_at DESC
                                                    ");
                                                    if(mysqli_num_rows($meetings) > 0) {
                                                        while($row = $meetings->fetch_assoc()) {
                                                            echo '<tr id="id_'.$row['id'].'">
                                                                <td>'.$row['account'].'</td>
                                                                <td>'.$row['meeting_date'].'</td>
                                                                <td>';
                                                                    if (!empty($row['agendas'])) {
                                                                        echo '<ul style="margin-bottom: 0;">';
                                                                        
                                                                            $agendas = $row["agendas"];
                                                                            $agendas_arr = explode(", ", $agendas);
                                                                            foreach ($agendas_arr as $value) {
                                                                                $selectAgenda = mysqli_query( $conn,"SELECT name FROM tbl_meeting_minutes_agenda WHERE ID = $value" );
                                                                                if ( mysqli_num_rows($selectAgenda) > 0 ) {
                                                                                    $rowAgenda = mysqli_fetch_array($selectAgenda);
                                                                                    
                                                                                    echo '<li>'.$rowAgenda['name'].'</li>';
                                                                                }
                                                                            }
                                                                        echo '</ul>';
                                                                    }
                                                                    if (!empty($row['agenda'])) {
                                                                        echo '<ul>
                                                                            <li>'.htmlentities($row["agenda"] ?? '').'</li>
                                                                        </ul>';
                                                                    }
                                                                
                                                                echo '</td>
                                                                <td>';
                                                                    $array_data = explode(", ", $row["attendees"]);
                                                                    $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                                                    while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                                                        if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
                                                                    }
    
                                                                echo '</td>
                                                                <td class="text-center">';
    
                                                                    $getId = $row['id'];
                                                                    // $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                                                    $resultOpen = mysqli_query($conn, "
                                                                        SELECT 
                                                                        COUNT(*) AS countAction, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END), 0) AS countOpen, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END), 0) AS countFollow, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Close' THEN 1 ELSE 0 END), 0) AS countClose 
                                                                        FROM tbl_meeting_minutes_action_items
                                                                        
                                                                        WHERE deleted = 0 AND action_meeting_id = $getId
                                                                    ");
                                                                    while($rowOpen = mysqli_fetch_array($resultOpen)) {
                                                                        // $btnBG = 'btn-success';
                                                                        // if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                                                        // else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }
                                                                            
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm dark" type="button" onclick="btnGet_status('.$row['id'].')" title="Open">'.$rowOpen['countOpen'].'</a>
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-warning" type="button" onclick="btnGet_status('.$row['id'].')" title="Follow Up">'.$rowOpen['countFollow'].'</a>
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-success" type="button" onclick="btnGet_status('.$row['id'].')" title="Close">'.$rowOpen['countClose'].'</a>
                                                                        </div>';
                                                                    }
    
                                                                echo '</td>
                                                                <td class="text-center">
                                                                    <div class="btn-group btn-group-circle">
                                                                        <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('.$row['id'].')">Edit</a>
                                                                        <a href="/pdf/meeting_minutes?i='.$row['id'].'" class="btn red btn-sm" type="button" target="_blank">PDF</a>
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }
                                                }
                                            } else {
                                                $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes WHERE user_ids = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY inserted_at DESC;");
                                                if(mysqli_num_rows($meetings) > 0) {
                                                    $counter = 0;
                                                    while($row = $meetings->fetch_assoc()) {
                                                        $array_data = explode(", ", $row["attendees"]);
                                                        // if(in_array($cookie_employee_id,$array_data)) {
    
                                                            echo '<tr id="id_'.$row['id'].'">
                                                                <td>'.$row['account'].'</td>
                                                                <td>'.$row['meeting_date'].'</td>
                                                                <td>';
                                                                    if (!empty($row['agendas'])) {
                                                                        echo '<ul style="margin-bottom: 0;">';
                                                                        
                                                                            $agendas = $row["agendas"];
                                                                            $agendas_arr = explode(", ", $agendas);
                                                                            foreach ($agendas_arr as $value) {
                                                                                $selectAgenda = mysqli_query( $conn,"SELECT name FROM tbl_meeting_minutes_agenda WHERE ID = $value" );
                                                                                if ( mysqli_num_rows($selectAgenda) > 0 ) {
                                                                                    $rowAgenda = mysqli_fetch_array($selectAgenda);
                                                                                    
                                                                                    echo '<li>'.$rowAgenda['name'].'</li>';
                                                                                }
                                                                            }
                                                                        echo '</ul>';
                                                                    }
                                                                    if (!empty($row['agenda'])) {
                                                                        echo '<ul>
                                                                            <li>'.htmlentities($row["agenda"] ?? '').'</li>
                                                                        </ul>';
                                                                    }
                                                                
                                                                echo '</td>
                                                                <td>';
                                                                    $array_data = explode(", ", $row["attendees"]);
                                                                    $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                                                    $resultAssignto = mysqli_query($conn, $queryAssignto);
                                                                    while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                                                        if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
                                                                    }
    
                                                                echo '</td>
                                                                <td class="text-center">';
    
                                                                    $getId = $row['id'];
                                                                    // $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                                                    $resultOpen = mysqli_query($conn, "
                                                                        SELECT 
                                                                        COUNT(*) AS countAction, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END), 0) AS countOpen, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END), 0) AS countFollow, 
                                                                        COALESCE(SUM(CASE WHEN status = 'Close' THEN 1 ELSE 0 END), 0) AS countClose 
                                                                        FROM tbl_meeting_minutes_action_items
                                                                        
                                                                        WHERE deleted = 0 AND action_meeting_id = $getId
                                                                    ");
                                                                    while($rowOpen = mysqli_fetch_array($resultOpen)) {
                                                                        // $btnBG = 'btn-success';
                                                                        // if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                                                        // else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }
                                                                            
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm dark" type="button" onclick="btnGet_status('.$row['id'].')" title="Open">'.$rowOpen['countOpen'].'</a>
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-warning" type="button" onclick="btnGet_status('.$row['id'].')" title="Follow Up">'.$rowOpen['countFollow'].'</a>
                                                                            <a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm btn-success" type="button" onclick="btnGet_status('.$row['id'].')" title="Close">'.$rowOpen['countClose'].'</a>
                                                                        </div>';
                                                                    }
    
                                                                echo '</td>
                                                                <td class="text-center">
                                                                    <div class="btn-group btn-group-circle">
                                                                        <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('.$row['id'].')">Edit</a>
                                                                        <a href="/pdf/meeting_minutes?i='.$row['id'].'" class="btn red btn-sm" type="button" target="_blank">PDF</a>
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                        // }
                                                    }
                                                }
                                            }
                                            
                                        
                                        
                                        
                                        
                                            // if ($current_userEmployeeID > 0 AND !isset($_COOKIE['switchAccount'])) {
                                            //     // for attendess
                                            //     $cookie_employee_id = $_COOKIE['employee_id'];
                                            //     $meetings = $conn->query("SELECT * FROM tbl_meeting_minutes ORDER BY inserted_at DESC;");
                                            //     if(mysqli_num_rows($meetings) > 0) {
                                            //         $counter = 0;
                                            //         while($row = $meetings->fetch_assoc()) {
                                            //             $array_data = explode(", ", $row["attendees"]);
                                            //             if(in_array($cookie_employee_id,$array_data)) {
    
                                            //                 echo '<tr id="id_'.$row['id'].'">
                                            //                     <td>'.$row['account'].'</td>
                                            //                     <td>'.$row['meeting_date'].'</td>
                                            //                     <td>'.$row['agenda'].'</td>
                                            //                     <td>';
                                            //                         $array_data = explode(", ", $row["attendees"]);
                                            //                         $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                            //                         $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            //                         while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                            //                             if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
                                            //                         }
    
                                            //                     echo '</td>
                                            //                     <td>';
    
                                            //                         $getId = $row['id'];
                                            //                         $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                            //                         $resultOpen = mysqli_query($conn, $queryOpen);
                                            //                         while($rowOpen = mysqli_fetch_array($resultOpen)) {
                                            //                             $btnBG = 'btn-success';
                                            //                             if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                            //                             else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }
    
                                            //                             echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm '.$btnBG.'" type="button" onclick="btnGet_status('.$row['id'].')">'.$rowOpen['countOpen'].'</a>';
                                            //                         }
    
                                            //                     echo '</td>
                                            //                     <td>
                                            //                         <div class="btn-group btn-group-circle">
                                            //                           <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('.$row['id'].')">Edit</a>
                                            //                             <a class="btn red btn-sm" type="button" id="pdf_report" data-id="'.$row['id'].'">PDF</a>
                                            //                         </div>
                                            //                     </td>
                                            //                 </tr>';
                                            //             }
                                            //         }
                                            //     }
    
                                            //     // for action item  
                                            //     $emp_id = $_COOKIE['employee_id'];
                                            //     // $ai_query = mysqli_query($conn,"select Distinct(assigned_to),id,account,meeting_date,agenda,attendees,action_meeting_id from tbl_meeting_minutes_action_items 
                                            //     // left join tbl_meeting_minutes on id = action_meeting_id where assigned_to = $emp_id");
                                                
                                            //     $ai_query = mysqli_query($conn,"SELECT 
                                            //         Distinct(assigned_to),
                                            //         id,
                                            //         account,
                                            //         meeting_date,
                                            //         agenda,
                                            //         attendees,
                                            //         action_meeting_id 
                                                    
                                            //         FROM tbl_meeting_minutes_action_items 
                                            //         LEFT JOIN tbl_meeting_minutes 
                                            //         ON id = action_meeting_id 
                                            //         WHERE assigned_to = $emp_id 
                                            //         AND FIND_IN_SET($emp_id, REPLACE(attendees, ' ', ''))");
                                            //     foreach($ai_query as $ai_orw) {
                                            //         $array_data2 = explode(", ", $ai_orw["attendees"]);
                                            //         // if(!in_array($emp_id,$array_data2)) {
                                            //             echo '<tr id="id_'.$ai_orw['id'].'">
                                            //                 <td>'.$ai_orw['account'].'</td>
                                            //                 <td>'.$ai_orw['meeting_date'].'</td>
                                            //                 <td>'.$ai_orw['agenda'].'</td>
                                            //                 <td>';
    
                                            //                     $array_data = explode(", ", $ai_orw["attendees"]);
                                            //                     $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                            //                     $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            //                     while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                            //                         if(in_array($rowAssignto['ID'],$array_data)){echo$rowAssignto['first_name'].',';}
                                            //                     }
    
                                            //                 echo '</td>
                                            //                 <td>';
    
                                            //                     $getId = $ai_orw['id'];
                                            //                     $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                            //                     $resultOpen = mysqli_query($conn, $queryOpen);
                                            //                     while($rowOpen = mysqli_fetch_array($resultOpen)) { 
                                            //                         $btnBG = 'btn-success';
                                            //                         if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                            //                         else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }
    
                                            //                         echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm '.$btnBG.'" type="button" onclick="btnGet_status('.$ai_orw['id'].')">'.$rowOpen['countOpen'].'</a>';
                                            //                     }
    
                                            //                 echo '</td>
                                            //                 <td>
                                            //                     <div class="btn-group btn-group-circle">
                                            //                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('. $ai_orw['id'].')">Edit</a>
                                            //                         <a class="btn red btn-sm" type="button" id="pdf_report" data-id="'.$ai_orw['id'].'">PDF</a>
                                            //                     </div>
                                            //                 </td>
                                            //             </tr>';
                                            //         // }
                                            //     }
                                            // }

                                            // // Create
                                            // $cookie_user = $_COOKIE['ID'];
                                            // $emp_id1 = $_COOKIE['employee_id'];
                                            // // $ai_query1 = mysqli_query($conn,"select * from  tbl_meeting_minutes where added_by_id  = $cookie_user");
                                            // $ai_query1 = mysqli_query($conn,"SELECT * FROM  tbl_meeting_minutes WHERE added_by_id  = $current_userID");
                                            // if(isset($_COOKIE['switchAccount'])) {
                                            //     // $ai_query1 = mysqli_query($conn,"select * from  tbl_meeting_minutes where added_by_id  = '$switch_user_id'");
                                            //     $ai_query1 = mysqli_query($conn,"SELECT * FROM  tbl_meeting_minutes WHERE user_ids = $switch_user_id");
                                            // }
                                            // foreach($ai_query1 as $row_create) {
                                            //     $array_data3 = explode(", ", $row_create["attendees"]);
                                            //     $action_meeting_ids = $row_create['id'];
                                                
                                            //     $break = false;
                                            //     // if(!in_array($emp_id1,$array_data3)) {
                                            //         $acc_assign = mysqli_query($conn, "select * from tbl_meeting_minutes_action_items where action_meeting_id = $action_meeting_ids");
                                            //         if(mysqli_num_rows($acc_assign) > 0){
                                            //         } else {
                                            //             echo '<tr id="id_'.$row_create['id'].'">
                                            //                 <td>'.$row_create['account'].'</td>
                                            //                 <td>'.$row_create['meeting_date'].'</td>
                                            //                 <td>'.$row_create['agenda'].'</td>
                                            //                 <td>';

                                            //                     $array_data_attd = explode(", ", $row_create["attendees"]);
                                            //                     $queryAssignto = "SELECT * FROM tbl_hr_employee where status =1 order by first_name ASC";
                                            //                     $resultAssignto = mysqli_query($conn, $queryAssignto);
                                            //                     while($rowAssignto = mysqli_fetch_array($resultAssignto))
                                            //                     { 
                                            //                         if(in_array($rowAssignto['ID'],$array_data_attd)){ echo $rowAssignto['first_name'].',';}
                                            //                     }

                                            //                 echo '</td>
                                            //                 <td>';
                                            //                     $getId = $row_create['id'];
                                            //                     $queryOpen = "SELECT COUNT(*) AS countOpen, SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) AS countStatus, SUM(CASE WHEN status = 'Follow Up' THEN 1 ELSE 0 END) AS countFollow FROM tbl_meeting_minutes_action_items WHERE action_meeting_id = $getId ";
                                            //                     $resultOpen = mysqli_query($conn, $queryOpen);
                                            //                     while($rowOpen = mysqli_fetch_array($resultOpen)) { 
                                            //                         $btnBG = 'btn-success';
                                            //                         if ($rowOpen['countStatus'] > 0) { $btnBG = 'dark'; }
                                            //                         else { if ($rowOpen['countFollow'] > 0) { $btnBG = 'btn-warning'; } }

                                            //                         echo '<a href="#modalGet_sStatus" data-toggle="modal" class="btn btn-outline btn-sm '.$btnBG.'" type="button" onclick="btnGet_status('.$row_create['id'].')">'.$rowOpen['countOpen'].'</a>';
                                            //                     }

                                            //                 echo '</td>
                                            //                 <td>
                                            //                     <div class="btn-group btn-group-circle">
                                            //                       <a href="#modalGet_details" data-toggle="modal" class="btn btn-outline dark btn-sm" type="button" onclick="btnUpdate_meeting_details('.$row_create['id'].')">Edit</a>
                                            //                         <a class="btn red btn-sm" type="button" id="pdf_report" data-id="'.$row_create['id'].'">PDF</a>
                                            //                     </div>
                                            //                 </td>
                                            //             </tr>';
                                            //         }
                                            //     // }
                                            // }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                </div>
                <!-- END BORDERED TABLE PORTLET-->
            </div>

            <!-- MODAL AREA -->
            <!-- new task modal -->
            <!-- Get status -->
            <div class="modal fade" id="modalGet_sStatus" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg" >
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_sStatus">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Action Items</h4>
                            </div>
                            <div class="modal-body"></div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Get status -->
            <div class="modal fade" id="modalGet_all_action_items" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full" >
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_all_action_items">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Action Items</h4>
                            </div>
                            <div class="modal-body"></div>
                           
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Details -->
            <div class="modal fade" id="modalGet_details" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full" >
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalGet_details">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Meeting Minutes</h4>
                            </div>
                            <div class="modal-body">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--add reference-->
            <div class="modal fade" id="modal_add_reference" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modal_add_reference">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Reference</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="details_id" name="meeting_id">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Name</label>
                                        <input class="form-control" name="title_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Document</label>
                                        <input type="file" name="file_docs" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input class="btn btn-info" type="submit" name="btnSave_reference" id="btnSave_reference" value="Add" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--add action items-->
            <div class="modal fade" id="modal_add_action_item" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modal_add_action_item">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Action Item</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="details_ids" name="meeting_ids">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Action Item</label>
                                        <input class="form-control" name="action_details" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Assign To</label>
                                        <select class="form-control mt-multiselect btn btn-default" type="text" name="assign_to[]" required>
                                            <?php
                                                // $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id or user_id = 34 order by first_name ASC";
                                                $queryAssignto = "SELECT * FROM tbl_hr_employee where user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                $resultAssignto = mysqli_query($conn, $queryAssignto);
                                                while($rowAssignto = mysqli_fetch_array($resultAssignto)) { 
                                                   echo '<option value="'.$rowAssignto['ID'].'">'.$rowAssignto['first_name'].' '.$rowAssignto['last_name'].'</option>'; 
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Request Date</label>
                                        <input class="form-control" type="date" name="target_request_date" value="<? echo date('Y-m-d'); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Start Date</label>
                                        <input class="form-control" type="date" name="target_start_date" value="<? echo date('Y-m-d'); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Due Date</label>
                                        <input class="form-control" type="date" name="target_due_date" value="<? echo date('Y-m-d'); ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input class="btn btn-info" type="submit" name="btnSave_action_item" id="btnSave_action_item" value="Add" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Update Status-->
            <div class="modal fade" id="modal_update_status" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modal_update_status">
                            <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Action Items Details</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                               <input class="btn btn-info" type="submit" name="btnSave_status" id="btnSave_status" value="Save" >
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Get Comment -->
            <div class="modal fade" id="modal_comment_ai" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg" >
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modal_comment_ai">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Comment</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="ai_id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

             <!-- add new -->
            <div class="modal fade" id="modalAdd_details" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full" >
                    <div class="modal-content">
                        <form method="post" class="form-horizontal modalForm modalAdd_details">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Meeting Minutes</h4>
                            </div>
                            <div class="modal-body">
                                <div class="tabbable tabbable-tabdrop">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabMeeting1" data-toggle="tab">Meeting Details</a>
                                        </li>
                                        <li>
                                            <a href="#tabNote1" data-toggle="tab">Notes</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content margin-top-20">
                                        <div class="tab-pane active" id="tabMeeting1">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label">Company Name</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="account" required>
                                                        <option value="0" >---Select---</option>
                                                        <?php 
                                                            if($switch_user_id == 34 OR $_COOKIE['ID']== 450) {
                                                                $queryAcc = "SELECT * FROM tbl_service_logs_accounts WHERE owner_pk = $switch_user_id ORDER BY name";
                                                                $resultAcc = mysqli_query($conn, $queryAcc);
                                                                while($rowAcc = mysqli_fetch_array($resultAcc)) { 
                                                                    echo '<option value="'.$rowAcc['name'].'" '; echo 'CONSULTAREINC' == $rowAcc['name'] ? 'selected' : ''; echo'>'.$rowAcc['name'].'</option>'; 
                                                                }
                                                            }
                                                            else if($switch_user_id == 1687 ) {
                                                                $queryAcc = "SELECT name FROM tbl_supplier WHERE user_id = $switch_user_id AND page = 1 AND is_deleted = 0 ORDER BY name";
                                                                $resultAcc = mysqli_query($conn, $queryAcc);
                                                                while($rowAcc = mysqli_fetch_array($resultAcc)) { 
                                                                    echo '<option value="'.$rowAcc['name'].'" '; echo 'CONSULTAREINC' == $rowAcc['name'] ? 'selected' : ''; echo'>'.$rowAcc['name'].'</option>'; 
                                                                }
                                                            }
                                                            else if($switch_user_id == 247){echo '<option value="SFI">SFI</option>'; }
                                                            else if($switch_user_id == 250){echo '<option value="SPI">SPI</option>'; }
                                                            else if($switch_user_id == 266){echo '<option value="RFP">RFP</option>'; }
                                                            else if($switch_user_id == 256){echo '<option value="KAV">KAV</option>'; }
                                                            else if($switch_user_id == 337){echo '<option value="HT">HT</option>'; }
                                                            else if($switch_user_id == 308){echo '<option value="FWCC">FWCC</option>'; }
                                                            else if($switch_user_id == 457){echo '<option value="PF">PF</option>'; }
                                                            else if($switch_user_id == 253){echo '<option value="AFIA">AFIA</option>'; }
                                                            else if($switch_user_id == 1362){echo '<option value="Longevity Nutra Inc.">Longevity Nutra Inc.</option>'; }
                                                            else if($switch_user_id == 1486){echo '<option value="Marukan Vinegar (U.S.A.) Inc." SELECTED>Marukan Vinegar (U.S.A.) Inc.</option>'; }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Date</label>
                                                    <input class="form-control" type="date" name="meeting_date" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label">Start</label>
                                                    <input class="form-control" type="time" name="duration_start" value="<?php echo date('h:i:s', strtotime(date('h:i:s'))); ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">End</label>
                                                    <input class="form-control" type="time" name="duration_end" value="<?php echo date('h:i:s', strtotime(date('h:i:s'))); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Agenda</label>
                                                    <div class="mt-checkbox-list">
                                                        <?php 
                                                            echo '<label class="mt-checkbox mt-checkbox-outline">Select All
                                                                <input type="checkbox" onclick="checkedAll(this, \'Agenda\')" />
                                                                <span></span>
                                                            </label>';
                                                            
                                                            $selectAgenda = mysqli_query($conn, "SELECT * FROM tbl_meeting_minutes_agenda WHERE deleted = 0 ORDER BY name");
                                                            while($rowAgendas = mysqli_fetch_array($selectAgenda)) { 
                                                                echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAgendas['name'].'
                                                                    <input type="checkbox" class="Agenda" value="'.$rowAgendas['ID'].'" name="agendas[]" />
                                                                    <span></span>
                                                                </label>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Other Agenda (If Applicable)</label>
                                                    <textarea class="form-control"  name="agenda"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">Attendees</label>
                                                    <div class="mt-checkbox-list">
                                                        <?php 
                                                            echo '<label class="mt-checkbox mt-checkbox-outline">Select All
                                                                <input type="checkbox" onclick="checkedAll(this, \'Attendee\')" />
                                                                <span></span>
                                                            </label>';
                                                            
                                                            $queryAttd = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            if ($switch_user_id == 1687) {
                                                                $queryAttd = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            }
                                                            
                                                            $resultAttd = mysqli_query($conn, $queryAttd);
                                                            while($rowAttd = mysqli_fetch_array($resultAttd)) { 
                                                                echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAttd['first_name'].' '.$rowAttd['last_name'].'
                                                                    <input type="checkbox" class="Attendee" value="'.$rowAttd['ID'].'" name="attendees[]" />
                                                                    <span></span>
                                                                </label>';
                                                            }
                                                            
                                                            if($switch_user_id == 1362){
                                                                $queryAttd = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND ID IN (83, 71, 69, 129, 72, 80, 209) order by first_name ASC";
                                                                $resultAttd = mysqli_query($conn, $queryAttd);
                                                                while($rowAttd = mysqli_fetch_array($resultAttd)) { 
                                                                    echo '<label class="mt-checkbox mt-checkbox-outline"> '.$rowAttd['first_name'].' '.$rowAttd['last_name'].'
                                                                        <input type="checkbox" class="Attendee" value="'.$rowAttd['ID'].'" name="attendees[]" />
                                                                        <span></span>
                                                                    </label>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                                                <div class="col-md-12">
                                                    <label class="control-label">Compliance Team</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="attendees_compliance[]" multiple>
                                                        <?php
                                                            $queryAttdComp = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                                            $resultAttdComp = mysqli_query($conn, $queryAttdComp);
                                                            while($rowAttdComp = mysqli_fetch_array($resultAttdComp)) { 
                                                                echo '<option value="'.$rowAttdComp['ID'].'">'.$rowAttdComp['first_name'].' '.$rowAttdComp['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" >
                                                    <thead>
                                                        <th>Guest</th>
                                                        <th>Email</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody id="dynamic_field_guest">
                                                        <tr>
                                                            <td>
                                                                <input class="form-control"  name="guest[]" value="">
                                                            </td>
                                                            <td>
                                                                <input type="email" class="form-control"  name="guest_email[]" value="">
                                                            </td>
                                                            <td><button type="button" name="add" id="add_guest" class="btn btn-success">Add</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Remarks (If Applicable)</label>
                                                    <textarea class="form-control" name="remarks"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label">Presider</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="presider" required>
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            if (isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) {
                                                                $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                                                $resultPres = mysqli_query($conn, $queryPres);
                                                                while($rowPres = mysqli_fetch_array($resultPres)) { 
                                                                   echo '<option value="'.$rowPres['ID'].'">'.$rowPres['first_name'].' '.$rowPres['last_name'].'</option>'; 
                                                                }
                                                            }
                                                            
                                                            $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            if ($switch_user_id == 1687) {
                                                                $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            }
                                                            
                                                            $resultPres = mysqli_query($conn, $queryPres);
                                                            while($rowPres = mysqli_fetch_array($resultPres)) { 
                                                               echo '<option value="'.$rowPres['ID'].'">'.$rowPres['first_name'].' '.$rowPres['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                                                    <label class="control-label">Presider Compliance Team</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="presider_compliance">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            $queryPres = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                                            $resultPres = mysqli_query($conn, $queryPres);
                                                            while($rowPres = mysqli_fetch_array($resultPres)) { 
                                                               echo '<option value="'.$rowPres['ID'].'">'.$rowPres['first_name'].' '.$rowPres['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Note Taker</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="note_taker" required>
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            if (isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) {
                                                                $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                                                $resultTaker = mysqli_query($conn, $queryTaker);
                                                                while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                                                   echo '<option value="'.$rowTaker['ID'].'" '; echo $_COOKIE['employee_id'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].' '.$rowTaker['last_name'].'</option>'; 
                                                                }
                                                            }
                                                            
                                                            $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            if ($switch_user_id == 1687) {
                                                                $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            }
                                                            
                                                            $resultTaker = mysqli_query($conn, $queryTaker);
                                                            while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                                               echo '<option value="'.$rowTaker['ID'].'" '; echo $_COOKIE['employee_id'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].' '.$rowTaker['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                                                    <label class="control-label">Note Taker Compliance Team</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="note_taker_compliance">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            $queryTaker = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                                            $resultTaker = mysqli_query($conn, $queryTaker);
                                                            while($rowTaker = mysqli_fetch_array($resultTaker)) { 
                                                               echo '<option value="'.$rowTaker['ID'].'" '; echo $_COOKIE['employee_id'] == $rowTaker['ID'] ? 'selected' : ''; echo'>'.$rowTaker['first_name'].' '.$rowTaker['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Verified By</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            if (isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) {
                                                                $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                                                $resultVeri = mysqli_query($conn, $queryVeri);
                                                                while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                                                   echo '<option value="'.$rowVeri['ID'].'">'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                                                }
                                                            }
                                                            
                                                            $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            if ($switch_user_id == 1687) {
                                                                $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            }
                                                            
                                                            $resultVeri = mysqli_query($conn, $queryVeri);
                                                            while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                                               echo '<option value="'.$rowVeri['ID'].'">'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                                                    <label class="control-label">Verified By Compliance Team</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="verified_by_compliance">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            $queryVeri = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                                            $resultVeri = mysqli_query($conn, $queryVeri);
                                                            while($rowVeri = mysqli_fetch_array($resultVeri)) { 
                                                               echo '<option value="'.$rowVeri['ID'].'">'.$rowVeri['first_name'].' '.$rowVeri['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Approved By</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            if (isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) {
                                                                $queryApp = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 order by first_name ASC";
                                                                $resultApp = mysqli_query($conn, $queryApp);
                                                                while($rowApp = mysqli_fetch_array($resultApp)) { 
                                                                   echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                                                                }
                                                            }
                                                            
                                                            $queryApp = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            if ($switch_user_id == 1687) {
                                                                $queryApp = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC";
                                                            }
                                                            
                                                            $resultApp = mysqli_query($conn, $queryApp);
                                                            while($rowApp = mysqli_fetch_array($resultApp)) { 
                                                               echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 hide <?php if (!isset($_COOKIE['switchAccount']) AND $current_userEmployerID == 34) { echo 'hide'; } ?>">
                                                    <label class="control-label">Approved By Compliance Team</label>
                                                    <select class="form-control mt-multiselect btn btn-default" type="text" name="approved_by_compliance">
                                                        <option value="0">---Select---</option>
                                                        <?php
                                                            $queryApp = "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $current_userEmployerID order by first_name ASC";
                                                            $resultApp = mysqli_query($conn, $queryApp);
                                                            while($rowApp = mysqli_fetch_array($resultApp)) { 
                                                               echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tabNote1">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Notes</label>
                                                    <textarea class="form-control" type="text" name="discussion_notes" id="your_summernotes" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" >
                                                        <tbody id="dynamic_field">
                                                            <tr>
                                                                <td>
                                                                    <label class="control-label">Action Item</label>
                                                                    <input class="form-control action_list" name="action_details[]" placeholder="Action Items">
                                                                </td>
                                                                <td>
                                                                    <label class="control-label">Assigned To</label>
                                                                    <select class="form-control name_list" type="text" name="assigned_to[]">
                                                                        <option value="0">---Select---</option>
                                                                        <?php
                                                                            $result_App = mysqli_query($conn, "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id order by first_name ASC");
                                                                            if ($switch_user_id == 1687) {
                                                                                $result_App = mysqli_query($conn, "SELECT * FROM tbl_hr_employee where suspended = 0 AND status = 1 AND user_id = 34 AND facility_switch = $facility_switch_user_id order by first_name ASC");
                                                                            }
                                                                            
                                                                            while($row_App = mysqli_fetch_array($result_App)) { 
                                                                               echo '<option value="'.$row_App['ID'].'">'.$row_App['first_name'].'</option>'; 
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <label class="control-label">Status</label>
                                                                    <select class="form-control status_s" type="text" name="status[]">
                                                                        <option value="Open">Open</option>
                                                                        <option value="Follow Up">Follow Up</option>
                                                                        <option value="Close">Close</option>
                                                                    </select>
                                                                </td>
                                                                <td rowspan="2" style="text-align: center; vertical-align: middle;"><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label class="control-label">Request Date</label>
                                                                    <input type="date" name="target_request_date[]" placeholder="Request Date" class="form-control requestdate" value="<?= date('Y-m-d'); ?>">
                                                                </td>
                                                                <td>
                                                                    <label class="control-label">Start Date</label>
                                                                    <input type="date" name="target_start_date[]" placeholder="Start Date" class="form-control startdate" value="<?= date('Y-m-d'); ?>">
                                                                </td>
                                                                <td>
                                                                    <label class="control-label">Due Date</label>
                                                                    <input type="date" name="target_due_date[]" placeholder="Due Date" class="form-control duedate" value="<?= date('Y-m-d'); ?>">
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
                            <div class="modal-footer">
                                <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                <button type="submit" class="btn green ladda-button" name="btnNew_added2" id="btnNew_added2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <!-- / END MODAL AREA -->
                 
        </div><!-- END CONTENT BODY -->

        <div id="pdf_generate"></div>
        <?php include_once ('footer.php'); ?>
         <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>-->

        <script>
            //fetch all action item
            $(document).ready(function(){
                //fetch data
                // get_all_report('get_data');
            });

            function get_all_report(key) {
                $.ajax({
                   url:'meeting_minutes/fetch_all_action_items.php',
                   method: 'POST',
                   dataType: 'text',
                   data: {
                       key: key
                   }, success: function (response) {
                       if (key == 'get_data'){
                           $('#all_data_item').append(response);
                       }
                   }
                });
            }

            $(document).on('click', '#get_all_actions', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_all_action_items.php?get_all_data="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_all_action_items .modal-body").html(data);
                    }
                });
            });
            //end fetch all action item

            $(document).ready(function(){
                $('.data_MoM').keyup(function(){
                    search_table($(this).val());
                });
                function search_table(value){
                    $('#table_data_tr tr').each(function(){
                        var found = 'false';
                        $(this).each(function(){
                            if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
                            {
                                found = 'true';
                            }
                        });
                        if(found =='true')
                        {
                            $(this).show();
                        }
                        else{
                            $(this).hide();
                        }
                    });
                }
            });

            // add more field
            $(document).ready(function(){
                var key = 'ids';
                $('#add').click(function(){
                    $.ajax({
                       url:'meeting_minutes/fetch_employee.php',
                       method: 'POST',
                       dataType: 'html',
                       data: {
                           key: key
                       }, success: function (response) {
                        $('#dynamic_field').append(response);
                       }
                    });
                });
                
               
                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id");
                    $('.row'+button_id+'').remove();
                });
                
                $('#add_guest').click(function(){
                    $.ajax({
                       url:'meeting_minutes/fetch_guest_box.php',
                       method: 'POST',
                       dataType: 'html',
                       data: {
                           key: key
                       }, success: function (response) {
                        $('#dynamic_field_guest').append(response);
                       }
                    });
                });
                
                $(document).on('click', '.btn_remove_guest', function(){
                    var button_id = $(this).attr("id");
                    $('#row_guest'+button_id+'').remove();
                });
            });

            $(document).on('click', '#update_btn', function(){
                var key = 'ids';
                $.ajax({
                  url:'meeting_minutes/fetch_employee.php',
                  method: 'POST',
                  dataType: 'html',
                  data: {
                      key: key
                  }, success: function (response) {
                    $('#dynamic_field2').append(response);
                  }
                });
            }); 

            $(document).on('click', '#update_guest', function(){
                var key = 'ids';
                $.ajax({
                    url:'meeting_minutes/fetch_guest_box.php',
                    method: 'POST',
                    dataType: 'html',
                    data: {
                        key: key
                    }, success: function (response) {
                        $('#dynamic_field_guest2').append(response);
                    }
                });
            }); 
            $(document).ready(function () {
                $('#tableData2').DataTable();
            });
            $(document).ready(function() {
                $("#your_summernotes").summernote({
                    placeholder:'',
                    height: 200
                });
                $('.dropdown-toggle').dropdown();
            });
            $(document).ready(function() {
                $("#your_summernotes2").summernote({
                    placeholder:'',
                    height: 200
                });
                $('.dropdown-toggle').dropdown();
            });

            // Add references
            $(document).on('click', '#pdf_report', function(){
                var post_id = $(this).attr('data-id');
                $.ajax({
                    url:'meeting_minutes/pdf_generate.php',
                    method: 'POST',
                    data: {post_id:post_id},
                    success:function(data){
                        $("#pdf_generate").html(data);
                        window.print();
                    }
                });
            }); 
            $(document).on('click', '#add_reference', function(){
                var ids = $(this).attr('data-id');
                $('#details_id').val(ids);
            });
            $(".modal_add_reference").on('submit',(function(e) {
                e.preventDefault();
                 var details_id = $("#details_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_reference',true);

                var l = Ladda.create(document.querySelector('#btnSave_reference'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            // $('#id_'+meeting_id).empty();
                            $('#meeting_ref tbody').append(response);
                            $('#modal_add_reference').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnDelete(id, e) {
                // if (confirm("Your item will be deleted!")) {
                // 	$.ajax({
                //         type: "GET",
                //         url: "meeting_minutes/fetch_minutes.php?btnDelete_Ref="+id,
                //         dataType: "html",
                //         success: function(data){
                //             $(e).parent().parent().remove();
                //             // $('#meeting_ref tbody #tr_'+id).remove();
                //             alert('This item has been deleted');
                //         }
                //     });
                // }
                // return false;
			    
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
                        url: "meeting_minutes/fetch_minutes.php?btnDelete_Ref="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnDeleteAction(id, e) {
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
                        url: "meeting_minutes/fetch_minutes.php?btnDelete_Action="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().parent().parent().remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }

            //comment
            $(document).on('click', '#comment_AI', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_minutes.php?getAI_comment="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_comment_ai .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
                // $('#ai_id').val(ids);
            });
            $(".modal_comment_ai").on('submit',(function(e) {
                e.preventDefault();
                 var ai_id = $("#ai_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnComment',true);

                var l = Ladda.create(document.querySelector('#btnComment'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#statusTbl_'+ai_id).empty();
                            $('#statusTbl_'+ai_id).append(response);
                             $('#modal_comment_ai').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            //modal_add_action_item
            $(document).on('click', '#add_action', function(){
                var ids = $(this).attr('data-id');
                $('#details_ids').val(ids);
            });
            $(".modal_add_action_item").on('submit',(function(e) {
                e.preventDefault();
                 var details_ids = $("#details_ids").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_action_item',true);

                var l = Ladda.create(document.querySelector('#btnSave_action_item'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                            // $('#id_'+meeting_id).empty();
                                $('#meeting_action_items').append(response);
                             $('#modal_add_action_item').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //update status
            $(document).on('click', '#add_status', function(){
                var ids = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_minutes.php?GetAI="+ids,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_status .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            });
            $(".modal_update_status").on('submit',(function(e) {
                e.preventDefault();
                 var action_ids = $("#action_ids").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_status',true);

                var l = Ladda.create(document.querySelector('#btnSave_status'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            console.log(response);
                            msg = "Sucessfully Save!";
                                $('#statusTbl_'+action_ids).empty();
                                $('#statusTbl_'+action_ids).append(response);
                             $('#modal_update_status').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // get action item only
            function btnGet_status(id) {
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_minutes.php?GetDetails="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_sStatus .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
    
            function summer() {
            
                $("#your_summernotes").summernote({
                    placeholder:'',
                    height: 400
                });
                $('.dropdown-toggle').dropdown();
            }
            // update meeting details
            function btnUpdate_meeting_details(id) {
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_minutes.php?postDetails2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_details .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                        summer();
                    }
                });
            }
            $(".modalGet_details").on('submit',(function(e) {
                e.preventDefault();
                var meeting_id = $("#meeting_id").val();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_details2',true);

                var l = Ladda.create(document.querySelector('#btnSave_details2'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#id_'+meeting_id).empty();
                            $('#id_'+meeting_id).append(response);
                            $('#modalGet_details').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            // new added
            $(".modalAdd_details").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnNew_added2',true);

                var l = Ladda.create(document.querySelector('#btnNew_added2'));
                l.start();

                $.ajax({
                    url: "meeting_minutes/fetch_minutes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#meeting_tbl').append(response);
                            $('#modalAdd_details').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();
                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            function selAgenda() {
                alert('ds');
                var agendaTotal = $('.agenda').length;
                var agendaChecked = $('.agenda:checked').length;
                var agendas = $('.agenda:checked').map(function(_, el) {
                    return $(el).val();
                }).get();
                alert(agendaTotal);
                alert(agendaChecked);
                alert(agendas);
                return agendas;
            }
            function checkedAll(e, name) {
                $('.'+name).not(e).prop('checked', e.checked);
            }
        </script>
    </body>
</html>
