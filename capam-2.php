<?php 
    $title = "Corrective Action Preventive Action Management";
    $site = "capam";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /*.dashboard-stat.active {
        position: relative;
    }*/
    .dashboard-stat.active:after {
        width: 0;
        height: 0;
        border-left: 40px solid transparent;
        border-right: 40px solid transparent;
        border-bottom: 60px solid #eef1f5;
        position: absolute;
        margin: auto;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .indeterminate + span::after {
        display: block;
        content: '';
        border-width: 0 2px 0px 0;
        transform: rotate(90deg);
    }
    .highcharts-credits {
        display: none;
    }

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
</style>


                    <div class="row tablist" role="tablist">
                        <div class="col-lg-3 col-md-3 col-sm-63 col-xs-6">
                            <a class="dashboard-stat dashboard-stat-v2 blue active" href="#tabOpen" data-toggle="tab" role="tab">
                                <div class="visual">
                                    <i class="fa fa-unlock"></i>
                                </div>
                                <div class="details statusOpen">
                                    <div class="bold number">
                                        <span data-counter="counterup" data-value="0">0</span>
                                    </div>
                                    <div class="bold desc">OPEN</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-63 col-xs-6">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="#tabClose" data-toggle="tab" role="tab">
                                <div class="visual">
                                    <i class="fa fa-check-square-o"></i>
                                </div>
                                <div class="details statusClose">
                                    <div class="bold number">
                                        <span data-counter="counterup" data-value="0">0</span>
                                    </div>
                                    <div class="bold desc">CLOSE</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-63 col-xs-6">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="#tabNew" data-toggle="tab" role="tab">
                                <div class="visual">
                                    <i class="fa fa-plus-square-o"></i>
                                </div>
                                <div class="details">
                                    <div class="bold number">
                                        <span>CREATE</span>
                                    </div>
                                    <div class="bold desc">NEW</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-63 col-xs-6">
                            <a class="dashboard-stat dashboard-stat-v2 purple" href="#tabTrend" data-toggle="tab" role="tab">
                                <div class="visual">
                                    <i class="fa fa-line-chart"></i>
                                </div>
                                <div class="details">
                                    <div class="bold number">
                                        <span>TREND</span>
                                    </div>
                                    <div class="bold desc">ANALYSIS</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabOpen">
                                    <div class="portlet light">
                                        <div class="portlet-body">
                                            <table class="table table-bordered table-hover" id="tableDataOpen">
                                                <thead>
                                                    <tr>
                                                        <th>CAPA ID</th>

                                                        <?php echo $current_client == 0 ? '<th>CAPA Reference No.</th>':''; ?>
                                                        
                                                        <th>Date Created</th>
                                                        <th>Observed By</th>
                                                        <th>Reported By</th>

                                                        <?php echo $current_client == 1 ? '<th>Personnel Involved':''; ?>
                                                        
                                                        <th>Department Involved</th>
                                                        <th>Description of Issue</th>
                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectCamOpen = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE status = 0 AND user_id = $switch_user_id ORDER BY ID DESC" );
                                                        if ( mysqli_num_rows($selectCamOpen) > 0 ) {
                                                            while ($rowOpen= mysqli_fetch_array($selectCamOpen)) {
                                                                $cam_ID = $rowOpen['ID'];
                                                                $cam_reference = $rowOpen['reference'];
                                                                $cam_date = $rowOpen['date'];
                                                                $cam_observed_by = $rowOpen['observed_by'];
                                                                $cam_reported_by = $rowOpen['reported_by'];
                                                                $cam_description = $rowOpen['description'];

                                                                $cam_department_id = $rowOpen['department_id'];
                                                                $cam_department_other = $rowOpen['department_other'];
                                                                $data_department_id = array();
                                                                if (!empty($cam_department_id)) {
                                                                    $array_department_id = explode(", ", $cam_department_id);
                                                                    // $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_cam_department WHERE deleted = 0 ORDER BY name" );
                                                                    // if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                    //     while($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                    //         if (in_array($rowDept["ID"], $array_department_id)) {
                                                                    //             array_push($data_department_id, $rowDept["name"]);
                                                                    //         }
                                                                    //     }
                                                                    // }

                                                                    $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                                    if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                        while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                            if (in_array($rowDept["ID"], $array_department_id)) {
                                                                                array_push($data_department_id, $rowDept["title"]);
                                                                            }
                                                                        }
                                                                    }

                                                                    if (in_array(0, $array_department_id)) {
                                                                        array_push($data_department_id, stripcslashes($cam_department_other));
                                                                    }
                                                                }
                                                                $data_department_id = implode(", ",$data_department_id);

                                                                $cam_employee_id = $rowOpen['employee_id'];
                                                                $data_employee_id = array();
                                                                if (!empty($cam_employee_id)) {
                                                                    $array_employee_id = explode(", ", $cam_employee_id);
                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $data_employee_id = implode(", ",$data_employee_id);

                                                                echo '<tr id="tr_'.$cam_ID.'">
                                                                    <td>'.$cam_ID.'</td>';

                                                                    if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                                    
                                                                    echo '<td>'.$cam_date.'</td>
                                                                    <td>'.$cam_observed_by.'</td>
                                                                    <td>'.$cam_reported_by.'</td>';

                                                                    if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                                    
                                                                    echo '<td>'.$data_department_id.'</td>
                                                                    <td>'.$cam_description.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="'.$base_url.'pdf_c?id='.$cam_ID.'&t=1" target="_blank" class="btn btn-info btn-sm">PDF</a>
                                                                            <a href="#modalEdit" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('. $cam_ID.')">Edit</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnClose('. $cam_ID .')">Close</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                        
                                                        $selectComplaintOpen = mysqli_query( $conn,"SELECT * FROM tbl_complaint_records WHERE deleted = 0 AND capam = 1 AND status = 0 AND care_ownedby = $switch_user_id ORDER BY care_id DESC" );
                                                        if ( mysqli_num_rows($selectComplaintOpen) > 0 ) {
                                                            while ($rowOpen= mysqli_fetch_array($selectComplaintOpen)) {
                                                                $cam_ID = $rowOpen['care_id'];
                                                                $cam_reference = $rowOpen['reference'];
                                                                $cam_observed_by = $rowOpen['observed_by'];
                                                                $cam_reported_by = $rowOpen['reported_by'];
                                                                $cam_description = $rowOpen['nature_complaint'];
                                                                
                                                                $data_department_id = array();
                                                                $cam_person_handlingn = $rowOpen['person_handling'];
                                                                if ($cam_person_handlingn > 0) {
                                                                    $selectEmp = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cam_person_handlingn" );
                                                                    if ( mysqli_num_rows($selectEmp) > 0 ) {
                                                                        $rowEmp= mysqli_fetch_array($selectEmp);
                                                                        $cam_department_id = $rowEmp['department_id'];
                                                                        
                                                                        $array_department_id = explode(", ", $cam_department_id);
                                                                        $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                                        if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                            while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                                if (in_array($rowDept["ID"], $array_department_id)) {
                                                                                    array_push($data_department_id, $rowDept["title"]);
                                                                                }
                                                                            }
                                                                        }
    
                                                                        if (in_array(0, $array_department_id)) {
                                                                            array_push($data_department_id, stripcslashes($cam_department_other));
                                                                        }
                                                                    }
                                                                }
                                                                $data_department_id = implode(", ",$data_department_id);
                                                                
                                                                $cam_date = $rowOpen['care_date'];
                                                                $cam_date = new DateTime($cam_date);
                                                                $cam_date = $cam_date->format('Y-m-d');

                                                                $cam_employee_id = $rowOpen['person_handling'];
                                                                $data_employee_id = array();
                                                                if (!empty($cam_employee_id)) {
                                                                    $array_employee_id = explode(", ", $cam_employee_id);
                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $data_employee_id = implode(", ",$data_employee_id);

                                                                echo '<tr id="tr_cc_'.$cam_ID.'">
                                                                    <td>'.$cam_ID.'</td>';

                                                                    if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                                    
                                                                    echo '<td>'.$cam_date.'</td>
                                                                    <td>'.$cam_observed_by.'</td>
                                                                    <td>'.$cam_reported_by.'</td>';

                                                                    if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                                    
                                                                    echo '<td>'.$data_department_id.'</td>
                                                                    <td>'.$cam_description.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="'.$base_url.'pdf_c?id='.$cam_ID.'&t=2" target="_blank" class="btn btn-info btn-sm">PDF</a>
                                                                            <a href="#modalEdit2" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit2('. $cam_ID.')">Edit</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnClose2('. $cam_ID .')">Close</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabClose">
                                    <div class="portlet light">
                                        <div class="portlet-body">
                                            <table class="table table-bordered table-hover" id="tableDataClose">
                                                <thead>
                                                    <tr>
                                                        <th>CAPA ID</th>

                                                        <?php echo $current_client == 0 ? '<th>CAPA Reference No.</th>':''; ?>
                                                        
                                                        <th>Date Created</th>
                                                        <th>Observed By</th>
                                                        <th>Reported By</th>

                                                        <?php echo $current_client == 1 ? '<th>Personnel Involved':''; ?>
                                                        
                                                        <th>Department Involved</th>
                                                        <th>Description of Issue</th>
                                                        <th class="text-center" style="width: 135px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectCamOpen = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE status = 1 AND user_id = $switch_user_id ORDER BY ID DESC" );
                                                        if ( mysqli_num_rows($selectCamOpen) > 0 ) {
                                                            while ($rowOpen= mysqli_fetch_array($selectCamOpen)) {
                                                                $cam_ID = $rowOpen['ID'];
                                                                $cam_reference = $rowOpen['reference'];
                                                                $cam_date = $rowOpen['date'];
                                                                $cam_observed_by = $rowOpen['observed_by'];
                                                                $cam_reported_by = $rowOpen['reported_by'];
                                                                $cam_description = $rowOpen['description'];

                                                                $cam_department_id = $rowOpen['department_id'];
                                                                $cam_department_other = $rowOpen['department_other'];
                                                                $data_department_id = array();
                                                                if (!empty($cam_department_id)) {
                                                                    $array_department_id = explode(", ", $cam_department_id);
                                                                    // $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_cam_department WHERE deleted = 0 ORDER BY name" );
                                                                    // if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                    //     while($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                    //         if (in_array($rowDept["ID"], $array_department_id)) {
                                                                    //             array_push($data_department_id, $rowDept["name"]);
                                                                    //         }
                                                                    //     }
                                                                    // }

                                                                    $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                                    if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                        while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                            if (in_array($rowDept["ID"], $array_department_id)) {
                                                                                array_push($data_department_id, $rowDept["title"]);
                                                                            }
                                                                        }
                                                                    }

                                                                    if (in_array(0, $array_department_id)) {
                                                                        array_push($data_department_id, stripcslashes($cam_department_other));
                                                                    }
                                                                }
                                                                $data_department_id = implode(", ",$data_department_id);

                                                                $cam_employee_id = $rowOpen['employee_id'];
                                                                $data_employee_id = array();
                                                                if (!empty($cam_employee_id)) {
                                                                    $array_employee_id = explode(", ", $cam_employee_id);
                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $data_employee_id = implode(", ",$data_employee_id);

                                                                echo '<tr id="tr_'.$cam_ID.'">
                                                                    <td>'.$cam_ID.'</td>';

                                                                    if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                                    
                                                                    echo '<td>'.$cam_date.'</td>
                                                                    <td>'.$cam_observed_by.'</td>
                                                                    <td>'.$cam_reported_by.'</td>';

                                                                    if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                                    
                                                                    echo '<td>'.$data_department_id.'</td>
                                                                    <td>'.$cam_description.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="'.$base_url.'pdf_c?id='.$cam_ID.'" target="_blank" class="btn btn-info btn-sm">PDF</a>
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('. $cam_ID.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-primary btn-sm" onclick="btnRevert('. $cam_ID .')">Revert</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                        
                                                        $selectComplaintOpen = mysqli_query( $conn,"SELECT * FROM tbl_complaint_records WHERE deleted = 0 AND capam = 1 AND status = 1 AND care_ownedby = $switch_user_id ORDER BY care_id DESC" );
                                                        if ( mysqli_num_rows($selectComplaintOpen) > 0 ) {
                                                            while ($rowOpen= mysqli_fetch_array($selectComplaintOpen)) {
                                                                $cam_ID = $rowOpen['care_id'];
                                                                $cam_reference = $rowOpen['reference'];
                                                                $cam_observed_by = $rowOpen['observed_by'];
                                                                $cam_reported_by = $rowOpen['reported_by'];
                                                                $cam_description = $rowOpen['nature_complaint'];
                                                                
                                                                $cam_date = $rowOpen['care_date'];
                                                                $cam_date = new DateTime($cam_date);
                                                                $cam_date = $cam_date->format('Y-m-d');

                                                                $cam_employee_id = $rowOpen['person_handling'];
                                                                $data_employee_id = array();
                                                                if (!empty($cam_employee_id)) {
                                                                    $array_employee_id = explode(", ", $cam_employee_id);
                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                        while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                            if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                                array_push($data_employee_id, $rowEmployee["first_name"].' '.$rowEmployee["last_name"]);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $data_employee_id = implode(", ",$data_employee_id);

                                                                echo '<tr id="tr_cc_'.$cam_ID.'">
                                                                    <td>'.$cam_ID.'</td>';

                                                                    if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                                    
                                                                    echo '<td>'.$cam_date.'</td>
                                                                    <td>'.$cam_observed_by.'</td>
                                                                    <td>'.$cam_reported_by.'</td>';

                                                                    if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                                    
                                                                    echo '<td>'.$data_department_id.'</td>
                                                                    <td>'.$cam_description.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="#modalView2" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView2('. $cam_ID.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-primary btn-sm" onclick="btnRevert2('. $cam_ID .')">Revert</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabNew">
                                    <form method="post" enctype="multipart/form-data" class="formNew">
                                        <div class="portlet light">
                                            <div class="portlet-body">
                                                <div class="row form-horizontal">
                                                    <div class="col-md-3">
                                                        <label class="control-label">Is this a Product related  issue?</label>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <select class="form-control margin-bottom-15" name="product_related">
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label class="control-label">Date of Issue</label>
                                                        <input type="date" class="form-control" name="date" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="control-label">Time of Issue</label>
                                                        <input type="time" class="form-control" name="time" />
                                                    </div>
                                                    <div class="col-md-2 col-md-offset-1">
                                                        <label class="control-label">Observed By</label>
                                                        <input type="text" class="form-control" name="observed_by" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="control-label">Reported By</label>
                                                        <input type="text" class="form-control" name="reported_by" />
                                                    </div>
                                                    <div class="col-md-2 col-md-offset-1 <?php echo $current_client == 1 ? 'hide':''; ?>">
                                                        <label class="control-label">CAPA Reference No.</label>
                                                        <input type="text" class="form-control" name="reference" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            if ($current_client == 1) {
                                                echo '<div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject font-dark bold">Program</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="mt-checkbox-inline">';

                                                                $selectProgram = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE type = 1 AND deleted = 0 AND user_id = $switch_user_id ORDER BY name ASC" );
                                                                if ( mysqli_num_rows($selectProgram) > 0 ) {
                                                                    while ($rowProgram = mysqli_fetch_array($selectProgram)) {
                                                                        $program_ID = $rowProgram['ID'];
                                                                        $program_name = $rowProgram['name'];

                                                                        echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                            <input type="checkbox" name="program_id[]" value="'.$program_ID.'"> '.$program_name.'
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }

                                                        echo '</div>
                                                    </div>
                                                </div>';
                                                
                                                echo '<div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject font-dark bold">Complaint Category</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="mt-checkbox-inline">';

                                                            $selectComplaint = mysqli_query( $conn,"SELECT * FROM tbl_cam_complaint_category WHERE deleted = 0 ORDER BY name" );
                                                            if ( mysqli_num_rows($selectComplaint) > 0 ) {
                                                                while ($rowComp = mysqli_fetch_array($selectComplaint)) {
                                                                    $comp_ID = $rowComp['ID'];
                                                                    $comp_name = $rowComp['name'];

                                                                    echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" name="complaint_id[]" value="'.$comp_ID.'"> '.$comp_name.'
                                                                        <span></span>
                                                                    </label>';
                                                                }
                                                            }

                                                            echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                <input type="checkbox" name="complaint_id[]" value="0" onClick="btnCategory(this)"> Other
                                                                <span></span>
                                                            </label>
                                                            <input type="text" class="form-control hide" name="complaint_other" placeholder="Specify Complaint Category" />
                                                        </div>
                                                    </div>
                                                </div>';
                                            } else {
                                                echo '<div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject font-dark bold">Category</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="mt-checkbox-inline">';

                                                                $selectCategory = mysqli_query( $conn,"SELECT * FROM tbl_cam_category WHERE deleted = 0 ORDER BY name" );
                                                                if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                    while ($rowCat = mysqli_fetch_array($selectCategory)) {
                                                                        $cat_ID = $rowCat['ID'];
                                                                        $cat_name = $rowCat['name'];

                                                                        echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                            <input type="checkbox" name="category_id[]" value="'.$cat_ID.'"> '.$cat_name.'
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }

                                                            echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                <input type="checkbox" name="category_id[]" value="0" onClick="btnCategory(this)"> Other
                                                                <span></span>
                                                            </label>
                                                            <input type="text" class="form-control hide" name="category_other" placeholder="Specify Category" />
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                        ?>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Department(s) Involved</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="mt-checkbox-inline">
                                                    <?php
                                                        $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                        if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                            while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                $dept_ID = $rowDept['ID'];
                                                                $dept_title = $rowDept['title'];

                                                                echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                    <input type="checkbox" class="department_id_1" name="department_id[]" value="'.$dept_ID.'" onclick="changeDepartment(1, '.$dept_ID.')" /> '.$dept_title.'
                                                                    <span></span>
                                                                </label>';
                                                            }
                                                        }
                                                    ?>
                                                    <label class="mt-checkbox mt-checkbox-outline hide">
                                                        <input type="checkbox" name="department_id[]" value="0"> Other
                                                        <span></span>
                                                    </label>
                                                    <input type="text" class="form-control hide" name="department_other" placeholder="Specify Department" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Involved Personnel</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <select class="form-control mt-multiselect employee_id_1" data-placeholder="Select Personnel" name="employee_id[]" multiple="multiple"></select>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Description of Issue</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <textarea class="form-control" rows="3" name="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="portlet light hide <?php echo $current_client == 0 ? '':'hide'; ?>">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Trend Category</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="mt-repeater mt-repeater-trend">
                                                    <div data-repeater-list="trend">
                                                        <div class="mt-repeater-item row" data-repeater-item>
                                                            <div class="col-xs-11">
                                                                <input class="form-control" type="text" name="trend_desc" />
                                                            </div>
                                                            <div class="col-xs-1">
                                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Observation<?php echo $current_client == 1 ? '(s)':' / Issue(s)'; ?></span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" rows="10" name="observation_desc"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-observation">
                                                            <div data-repeater-list="observation">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-lg-11">
                                                                        <input class="form-control" type="file" name="observation_file" />
                                                                    </div>
                                                                    <div class="col-lg-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Root Cause(s)</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <textarea class="form-control" rows="10" name="root_cause_desc"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-root_cause">
                                                            <div data-repeater-list="root_cause">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-lg-11">
                                                                        <input class="form-control" type="file" name="root_cause_file" />
                                                                    </div>
                                                                    <div class="col-lg-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Corrective Action(s)</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control margin-bottom-15 <?php echo $current_client == 1 ? 'hide':''; ?>" name="corrective_status">
                                                            <option value="0">--Select Status--</option>
                                                            <option value="1">Proposed</option>
                                                            <option value="2">Implemented</option>
                                                        </select>
                                                        <textarea class="form-control margin-bottom-15" rows="10" name="corrective_desc"></textarea>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="date" class="form-control margin-bottom-15" name="corrective_date" placeholder="Date" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="time" class="form-control margin-bottom-15" name="corrective_time" placeholder="Time" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control margin-bottom-15" name="corrective_by" placeholder="Corrected By" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-corrective">
                                                            <div data-repeater-list="corrective">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="corrective_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Implementation(s)</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control margin-bottom-15" name="implementation_status">
                                                            <option value="0">--Select Status--</option>
                                                            <option value="1">Proposed</option>
                                                            <option value="2">Implemented</option>
                                                        </select>
                                                        <textarea class="form-control margin-bottom-15" rows="10" name="implementation_desc"></textarea>
                                                        <div class="row form-horizontal">
                                                            <div class="col-md-4">
                                                                <label class="control-label">Effective Date of Resolution</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="date" class="form-control margin-bottom-15" name="implementation_date" placeholder="Date" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control margin-bottom-15" name="implementation_by" placeholder="Implemented By" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-implementation">
                                                            <div data-repeater-list="implementation">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="implementation_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Preventive Action(s)</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control margin-bottom-15" name="preventive_status">
                                                            <option value="0">--Select Status--</option>
                                                            <option value="1">Proposed</option>
                                                            <option value="2">Implemented</option>
                                                        </select>
                                                        <textarea class="form-control margin-bottom-15" rows="10" name="preventive_desc"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-preventive">
                                                            <div data-repeater-list="preventive">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="preventive_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Evaluation(s) and Follow Up(s)</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control margin-bottom-15" name="evaluation_status">
                                                            <option value="0">--Select Status--</option>
                                                            <option value="1">Proposed</option>
                                                            <option value="2">Implemented</option>
                                                        </select>
                                                        <textarea class="form-control margin-bottom-15" rows="10" name="evaluation_desc"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-evaluation">
                                                            <div data-repeater-list="evaluation">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="evaluation_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Comments</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <textarea class="form-control margin-bottom-15" rows="10" name="comment_desc"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-comment">
                                                            <div data-repeater-list="comment">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="comment_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">Applicable Trainings</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?php
                                                            // if ($current_client == 1) {
                                                                echo '<label>Training(s):</label>
                                                                <select class="form-control mt-multiselect training_desc_1" data-placeholder="Please Select" name="training_desc[]" multiple="multiple"></select>';
                                                            // } else {
                                                            //     echo '<textarea class="form-control" rows="10" name="training_desc"></textarea>';
                                                            // }
                                                        ?>

                                                        <div class="row margin-top-15">
                                                            <div class="col-md-4">
                                                                <input type="time" class="form-control margin-bottom-15" name="training_date" placeholder="Date" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Supporting Documents / Evidence:</label>
                                                        <div class="mt-repeater mt-repeater-training">
                                                            <div data-repeater-list="training">
                                                                <div class="mt-repeater-item row" data-repeater-item>
                                                                    <div class="col-xs-11">
                                                                        <input class="form-control" type="file" name="training_file" />
                                                                    </div>
                                                                    <div class="col-xs-1">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add"><i class="fa fa-plus"></i> Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet light">
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="investigated_by" placeholder="Investigated By" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="investigated_title" placeholder="Title" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="date" class="form-control margin-bottom-15" name="investigated_date" placeholder="text" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="time" class="form-control margin-bottom-15" name="investigated_time" placeholder="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="verified_by" placeholder="CAPA Verified By" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="verified_title" placeholder="Title" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="date" class="form-control margin-bottom-15" name="verified_date" placeholder="text" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="time" class="form-control margin-bottom-15" name="verified_time" placeholder="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="completed_by" placeholder="CAPA Completed By" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control margin-bottom-15" name="completed_title" placeholder="Title" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="date" class="form-control margin-bottom-15" name="completed_date" placeholder="text" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="time" class="form-control margin-bottom-15" name="completed_time" placeholder="text" />
                                                    </div>
                                                </div>

                                                <div class="margin-top-40">
                                                    <button type="submit" class="btn green ladda-button" name="btnSave_CAM" id="btnSave_CAM" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tabTrend">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="portlet light">
                                                <div class="portlet-body">
                                                    <div class="form-group">
                                                        <label>CAPA Status</label>
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox mt-checkbox-outline checkboxx hide">
                                                                <input type="checkbox" class="statusAll" onclick="highchart_dashboard()"> (All)
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox mt-checkbox-outline checkboxx">
                                                                <input type="checkbox" class="status" name="status" value="1" onclick="highchart_status(1)"> Closed
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox mt-checkbox-outline checkboxx">
                                                                <input type="checkbox" class="status" name="status" value="2" onclick="highchart_status(1)"> Open
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group <?php echo $current_client == 1 ? '':'hide'; ?>">
                                                        <label>Complaint Category</label>
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox mt-checkbox-outline checkboxx">
                                                                <input type="checkbox" class="complaintAll" onclick="highchart_complaint(1)"> (All)
                                                                <span></span>
                                                            </label>
                                                            <?php
                                                                $selectComplaint = mysqli_query( $conn,"SELECT * FROM tbl_cam_complaint_category WHERE deleted = 0 ORDER BY name" );
                                                                if ( mysqli_num_rows($selectComplaint) > 0 ) {
                                                                    while ($rowComp = mysqli_fetch_array($selectComplaint)) {
                                                                        $comp_ID = $rowComp['ID'];
                                                                        $comp_name = $rowComp['name'];

                                                                        echo '<label class="mt-checkbox mt-checkbox-outline">
                                                                            <input type="checkbox" class="complaint" name="complaint" value="'.$comp_ID.'" onclick="highchart_complaint(1)"> '.$comp_name.'
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group <?php echo $current_client == 1 ? '':'hide'; ?>">
                                                        <label>Department</label>
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox mt-checkbox-outline checkboxx">
                                                                <input type="checkbox" class="departmentAll" onclick="highchart_department(1)"> (All)
                                                                <span></span>
                                                            </label>
                                                            <?php
                                                                $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                                if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                    while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                        $dept_ID = $rowDept['ID'];
                                                                        $dept_title = $rowDept['title'];

                                                                        echo '<label class="mt-checkbox mt-checkbox-outline checkboxx">
                                                                            <input type="checkbox" class="department" name="department" value="'.$dept_ID.'" onclick="highchart_department(1)"> '.$dept_title.'
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Year of CAPA Date Created</label>
                                                        <div class="mt-checkbox-list navGeneral">
                                                            <label class="mt-checkbox mt-checkbox-outline hidex"> (All)
                                                                <input type="checkbox" class="yearAll" onclick="highchart_year(1)" />
                                                                <span></span>
                                                            </label>
                                                            <?php
                                                                $selectYYYY = mysqli_query( $conn,'SELECT *, YEAR(date) AS YYYY FROM tbl_cam GROUP BY YYYY' );
                                                                if ( mysqli_num_rows($selectYYYY) > 0 ) {
                                                                    while($rowYYYY = mysqli_fetch_array($selectYYYY)) {
                                                                        $data_YYYY = $rowYYYY['YYYY'];

                                                                        echo '<label class="mt-checkbox mt-checkbox-outline"> '.$data_YYYY.'
                                                                            <input type="checkbox" class="year" name="year" value="'.$data_YYYY.'" onclick="highchart_year(1)" />
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="mt-radio-list navSummary hide">
                                                            <?php
                                                                $selectYYYY = mysqli_query( $conn,'SELECT *, YEAR(date) AS YYYY FROM tbl_cam GROUP BY YYYY' );
                                                                if ( mysqli_num_rows($selectYYYY) > 0 ) {
                                                                    while($rowYYYY = mysqli_fetch_array($selectYYYY)) {
                                                                        $data_YYYY = $rowYYYY['YYYY'];

                                                                        echo '<label class="mt-radio mt-radio-outline"> '.$data_YYYY.'
                                                                            <input type="radio" class="year2" name="year2" value="'.$data_YYYY.'" onclick="highchart_year2(this.value)">
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group navGeneralx">
                                                        <label>Month of CAPA Date Created</label>
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox mt-checkbox-outline monthAllSel hidex"> (All)
                                                                <input type="checkbox" class="monthAll" onclick="highchart_month(1)" />
                                                                <span></span>
                                                            </label>
                                                            <?php
                                                                for ($m=1; $m<=12; $m++) {
                                                                    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));

                                                                    echo '<label class="mt-checkbox mt-checkbox-outline"> '.$month.'
                                                                        <input type="checkbox" class="month" name="month" value="'.sprintf("%02d", $m).'" onclick="highchart_month(1)" />
                                                                        <span></span>
                                                                    </label>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="portlet light">
                                                <div class="portlet-title tabbable-line">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tabDashboard" data-toggle="tab" onclick="navTab(1)">Dashboard</a>
                                                        </li>
                                                        <li>
                                                            <a href="#tabSummary" data-toggle="tab" onclick="navTab(2)">12 Months Summary</a>
                                                        </li>
                                                        <li class="hide">
                                                            <a href="#tabRecord" data-toggle="tab" onclick="navTab(3)">CAPA Records</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tabDashboard"></div>
                                                        <div class="tab-pane" id="tabSummary"></div>
                                                        <div class="tab-pane hide" id="tabRecord">3</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL -->
                        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEdit">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Corrective Action Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_CAM" id="btnUpdate_CAM" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEdit2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEdit2">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Corrective Action Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_CAM2" id="btnUpdate_CAM2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Corrective Action Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalView2">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Corrective Action Management</h4>
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

        <script src="//code.highcharts.com/highcharts.js"></script>
        <script src="//code.highcharts.com/modules/data.js"></script>
        <script src="//code.highcharts.com/highcharts-more.js"></script>
        <script src="//code.highcharts.com/modules/exporting.js"></script>
        <script src="//code.highcharts.com/modules/export-data.js"></script>
        <script src="//code.highcharts.com/modules/accessibility.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                widget_repeaterForm('');
                fancyBoxes();
                widget_counterup();
                highchart_refresh();
                widget_multiselect();

                $('#tableDataOpen, #tableDataClose').DataTable({
                    dom: 'Bfrtip',
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
            });
            $('.tablist a').on('click', function (e) {
                e.preventDefault()
                $(this).parent().parent().find('a').removeClass('active');
                $(this).addClass('active');
            })

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function btnCategory(e) {
                $(e).parent().next('.form-control').toggleClass('hide');
            }
            function widget_repeaterForm() {
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
            function widget_counterup() {
                $.ajax({
                    url: 'function.php?counterup_cam=1',
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);                      
                        $('.tablist .statusOpen .number').html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusOpen+'">'+obj.statusOpen+'</span>');
                        $('.tablist .statusClose .number').html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusClose+'">'+obj.statusClose+'</span>');
                        $('.counterup').counterUp();
                    }
                });

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
            }
            function widget_multiselect() {
                $('.mt-multiselect').multiselect({
                    widthSynchronizationMode: 'ifPopupIsSmaller',
                    buttonTextAlignment: 'left',
                    buttonWidth: '100%',
                    maxHeight: 200,
                    enableResetButton: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true
                });
                $('.multiselect-container .multiselect-filter', $('.mt-multiselect').parent()).css({
                    'position': 'sticky', 'top': '0px', 'z-index': 1,
                })
            }
            function btnClose(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be closed!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalStatus_CAM="+id+"&s=1",
                        dataType: "html",
                        success: function(response){
                            // var view = '<a href="javascript:;" class="btn btn-success btn-circle btn-sm" onclick="btnView('+id+')">View</a>';
                            var view = '<div class="btn-group btn-group-circle">';
                                view += '<a href="#modalView" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView('+id+')">View</a>';
                                view += '<a href="javascript:;" class="btn btn-primary btn-sm" onclick="btnRevert('+id+')">Revert</a>';
                            view += '</div>';
                            $('#tableDataOpen tbody #tr_'+id+' td').last().html(view);
                            $('#tableDataOpen tbody #tr_'+id).prependTo('#tableDataClose tbody');
                            widget_counterup();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnClose2(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be closed!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalStatus_CAM2="+id+"&s=1",
                        dataType: "html",
                        success: function(response){
                            // var view = '<a href="javascript:;" class="btn btn-success btn-circle btn-sm" onclick="btnView('+id+')">View</a>';
                            var view = '<div class="btn-group btn-group-circle">';
                                view += '<a href="#modalView2" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnView2('+id+')">View</a>';
                                view += '<a href="javascript:;" class="btn btn-primary btn-sm" onclick="btnRevert2('+id+')">Revert</a>';
                            view += '</div>';
                            $('#tableDataOpen tbody #tr_cc_'+id+' td').last().html(view);
                            $('#tableDataOpen tbody #tr_cc_'+id).prependTo('#tableDataClose tbody');
                            widget_counterup();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnRevert(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be reverted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalStatus_CAM="+id+"&s=0",
                        dataType: "html",
                        success: function(response){
                            var view = '<div class="btn-group btn-group-circle">';
                                view += '<a href="#modalEdit" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit('+id+')">Edit</a>';
                                view += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnClose('+id+')">Close</a>';
                            view += '</div>';
                            $('#tableDataClose tbody #tr_'+id+' td').last().html(view);
                            $('#tableDataClose tbody #tr_'+id).prependTo('#tableDataOpen tbody');
                            widget_counterup();
                        }
                    });
                    swal("Done!", "This item has been reverted.", "success");
                });
            }
            function btnRevert2(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be reverted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalStatus_CAM2="+id+"&s=0",
                        dataType: "html",
                        success: function(response){
                            var view = '<div class="btn-group btn-group-circle">';
                                view += '<a href="#modalEdit2" class="btn btn-outline dark btn-sm" data-toggle="modal" onclick="btnEdit2('+id+')">Edit</a>';
                                view += '<a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnClose2('+id+')">Close</a>';
                            view += '</div>';
                            $('#tableDataClose tbody #tr_cc_'+id+' td').last().html(view);
                            $('#tableDataClose tbody #tr_cc_'+id).prependTo('#tableDataOpen tbody');
                            widget_counterup();
                        }
                    });
                    swal("Done!", "This item has been reverted.", "success");
                });
            }
            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_CAM="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit .modal-body").html(data);
                        widget_repeaterForm();
                        changeDepartment(2, id);
                    }
                });
            }
            function btnEdit2(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_CAM2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalEdit2 .modal-body").html(data);
                        widget_repeaterForm();
                        changeDepartment(2, id, 2);
                    }
                });
            }
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_CAM="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        widget_repeaterForm();
                        changeDepartment(3, id);
                    }
                });
            }
            function btnView2(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_CAM2="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView2 .modal-body").html(data);
                        widget_repeaterForm();
                        changeDepartment(3, id, 2);
                    }
                });
            }
            function changeDepartment(type, id, page) {
                var department_id = $('.department_id_'+type+':checked').map(function(_, el) {
                    return $(el).val();
                }).get();

                $.ajax({
                    type: "POST",
                    data: {department_id:department_id},
                    url: "function.php?modalTrend_CAM_Dept="+id+"&p="+page,
                    success: function(data){
                        if ($.trim(data)) {
                            var obj = jQuery.parseJSON(data);
                            $('.employee_id_'+type).html(obj.employee);
                            $('.training_desc_'+type).html(obj.training);
                        } else {
                            $('.employee_id_'+type).html('');
                            $('.training_desc_'+type).html('');
                        }
                        changeSort();
                        $('.employee_id_'+type).multiselect('destroy');
                        $('.training_desc_'+type).multiselect('destroy');
                        widget_multiselect();
                    }
                });
            }
            function changeSort(type) {
                var selectEmployee = $('.employee_id_'+type);
                selectEmployee.html(selectEmployee.find('option').sort(function(x, y) {
                    // to change to descending order switch "<" for ">"
                    return $(x).text() > $(y).text() ? 1 : -1;
                }));
                
                var selectEmployee = $('.training_desc_'+type);
                selectEmployee.html(selectEmployee.find('option').sort(function(x, y) {
                    // to change to descending order switch "<" for ">"
                    return $(x).text() > $(y).text() ? 1 : -1;
                }));
            }
            $(".formNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_CAM',true);

                var l = Ladda.create(document.querySelector('#btnSave_CAM'));
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
                            $('#tableDataOpen tbody').prepend(obj.data);
                            widget_counterup();

                            $(".formNew")[0].reset();
                            $('.dashboard-stat-v2').removeClass('active');
                            $('.tablist a[href="#tabOpen"]').addClass('active');
                            $('.tablist a[href="#tabOpen"]').tab('show');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_CAM',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_CAM'));
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
                            $('#tableDataOpen tbody #tr_'+obj.ID).html(obj.data);
                            $('#modalEdit').modal('hide');
                            widget_counterup();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalEdit2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_CAM2',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_CAM2'));
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
                            $('#tableDataOpen tbody #tr_'+obj.ID).html(obj.data);
                            $('#modalEdit2').modal('hide');
                            widget_counterup();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Trend Analysis Section
            $('.statusAll').checkAll({
                  name : 'status',
                  vagueCls: 'indeterminate'
            });
            $('.yearAll').checkAll({
                name : 'year',
                vagueCls: 'indeterminate',
            });
            $('.monthAll').checkAll({
                name : 'month',
                vagueCls: 'indeterminate',
            });
            $('.departmentAll').checkAll({
                name : 'department',
                vagueCls: 'indeterminate',
            });
            $('.departmentAll').checkAll({
                name : 'department',
                vagueCls: 'indeterminate',
            });
            function checkbox(val) {
                $('.'+val+'All').checkAll({
                    name : val,
                    inverter: '.invert',
                    vagueCls: 'indeterminate',
                    onInit : function(len,count,ids,nodes,value){
                        // init callback
                        // params : len, count, length , ids, value, nodes
                        $('.statusbar').text(len+' items, checked '+count+' item');
                    },
                    onCheck: function(id,val,len,count,ids,nodes,value){
                        // checking callback
                        // params : id,val,len,count,ids,value,nodes
                        $('.statusbar').text(len+' items, checked '+count+' item');
                    },
                    onFull : function (count,ids,nodes) {
                        // all in checked callback
                        // params : count|len, length , ids, value, nodes
                        $('.statusbar').text(count+' items, checked '+count+' item');
                    },
                    onEmpty : function (len) {
                        //no checked items callback
                        // params : len
                        $('.statusbar').text(len+' items, checked 0 item');
                    }
                });
            }
            function navTab(val) {
                if (val == 2) {
                    $('.navSummary').removeClass('hide');
                    $('.navGeneral').addClass('hide');
                } else {
                    $('.navSummary').addClass('hide');
                    $('.navGeneral').removeClass('hide');
                }
            }
            function highchart_refresh() {
                var year2Checked = $('.year2:checked').length;
                if (year2Checked > 0) { year2 = $('.year2:checked').val(); }
                else { year2 = (new Date).getFullYear(); }

                highchart_dashboard();
                highchart_year2(year2);
            }
            function highchart_dashboard() {
                val = highchart_status(0);
                years = highchart_year(0);
                months = highchart_month(0);
                complaints = highchart_complaint(0);
                departments = highchart_department(0);
                // console.log(val);
                // console.log(years);
                // console.log(months);
                // console.log(complaints);
                // console.log(departments);

                Highcharts.getJSON(
                    'function.php?modalTrend_CAM='+val+'&years='+years+'&months='+months+'&complaints='+complaints+'&departments='+departments,
                    function (data) {
                        var obj = JSON.stringify(data.series);
                        var series = jQuery.parseJSON(obj);
                        // alert(data.record);
                        // console.log(data.category);
                        // console.log(data.series);
                        // alert(data);
                        // alert(obj);

                        Highcharts.chart('tabDashboard', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'CAPA Record Log'
                            },
                            subtitle: {
                                text: 'CAPA Created per '+data.category
                            },
                            xAxis: {
                                categories: data.category,
                                labels: {
                                    style: {
                                        fontSize:'12px'
                                    }
                                }
                            },
                            yAxis: {
                                allowDecimals: false,
                                min: 0,
                                title: {
                                    text: 'Total CAPA'
                                },
                                labels: {
                                    style: {
                                        fontSize:'12px'
                                    }
                                }
                            },
                            tooltip: {
                                formatter: function() {
                                    var currentPoint = this,
                                    currentSeries = currentPoint.series,
                                    chart = currentSeries.chart,
                                    stackName = this.series.userOptions.stack,
                                    stackValues = '';

                                    chart.series.forEach(function(series) {
                                        series.points.forEach(function(point) {
                                            if (currentSeries.userOptions.stack === series.userOptions.stack && currentPoint.key === point.category) {
                                                stackValues += '<span style="color:'+series.color+'">'+series.name+'</span>: ' + point.y + '<br/>'
                                            }
                                        })
                                    });

                                    return '<b>Name: </b>' + stackName + '<br/><br/>' +
                                    stackValues +
                                    '<b>Total: </b>' + this.point.stackTotal;
                                },
                                style: {
                                    fontSize:'15px'
                                }
                            },
                            legend: {
                                labelFormatter: function () {
                                    return this.userOptions.stack
                                },
                                itemStyle: {
                                    fontSize:'12px'
                                }
                            },
                            plotOptions: {
                                series: {
                                    stacking: 'normal'
                                }
                            },
                            series: series
                        });
                    }
                );
            }
            function highchart_status(id) {
                if (id == 1) {
                    highchart_refresh();
                }
                else {
                    var statusChecked = $('.status:checkbox:checked').length;
                    var statusTotal = $('.status:checkbox').length;

                    // alert("statusChecked "+statusChecked);
                    // alert("statusTotal "+statusTotal);
                    // alert("val "+val);
                    // alert("e val "+e.value);

                    if (statusChecked > 0 && statusChecked < statusTotal) {
                        var statusVal = $('.status:checkbox:checked').val();

                        if (statusVal == 1) { val = "statusClose"; }
                        else if (statusVal == 2) { val = "statusOpen"; }
                    } else {
                        val = 'statusAll';
                    }
                    return val;
                }
            }
            function highchart_complaint(id) {
                if (id == 1) {
                    highchart_refresh();
                }
                else {
                    var complaintTotal = $('.complaint').length;
                    var complaintChecked = $('.complaint:checked').length;
                    var complaints = $('.complaint:checked').map(function(_, el) {
                        return $(el).val();
                    }).get();
                    return complaints;
                }
            }
            function highchart_department(id) {
                if (id == 1) {
                    highchart_refresh();
                }
                else {
                    var departmentTotal = $('.department').length;
                    var departmentChecked = $('.department:checked').length;
                    var departments = $('.department:checked').map(function(_, el) {
                        return $(el).val();
                    }).get();
                    return departments;
                }
            }
            function highchart_month(id) {
                if (id == 1) {
                    highchart_refresh();
                }
                else {
                    var monthTotal = $('.month').length;
                    var monthChecked = $('.month:checked').length;
                    var months = $('.month:checked').map(function(_, el) {
                        return $(el).val();
                    }).get();

                    // if (monthTotal == monthChecked) { months = ''; }
                    return months;
                }
            }
            function highchart_year(id) {
                if (id == 1) {
                    highchart_refresh();
                }
                else {
                    var yearTotal = $('.year').length;
                    var yearChecked = $('.year:checked').length;
                    var years = $('.year:checked').map(function(_, el) {
                        return $(el).val();
                    }).get();

                    // if (yearTotal == yearChecked) { years = ''; }
                    return years;
                }
            }
            function highchart_year2(year) {
                val = highchart_status(0);
                months = highchart_month(0);
                complaints = highchart_complaint(0);
                departments = highchart_department(0);
                // alert(val);
                console.log(complaints);
                console.log(departments);
                Highcharts.getJSON(
                    'function.php?modalTrend_CAMSummary='+val+'&year='+year+'&months='+months+'&complaints='+complaints+'&departments='+departments,
                    function (data) {
                        console.log(data.category);
                        // alert(data);
                        // alert(data.ID);
                        // alert(data.category);
                        // alert(data.series);
                        // console.log(data.series);
                        var obj = JSON.stringify(data.series);
                        // alert(obj);
                        // console.log(obj);

                        var series = jQuery.parseJSON(obj);
                        // console.log(series);
                        // console.log(typeof series);
                        Highcharts.chart('tabSummary', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'CAPA Log Record'
                            },
                            subtitle: {
                                text: 'Complaints Created per '+data.category
                            },
                            xAxis: {
                                categories: data.category,
                                labels: {
                                    style: {
                                        fontSize:'12px'
                                    }
                                }
                            },
                            yAxis: {
                                allowDecimals: false,
                                min: 0,
                                title: {
                                    text: 'Total Complaints'
                                },
                                labels: {
                                    style: {
                                        fontSize:'12px'
                                    }
                                }
                            },
                            tooltip: {
                                formatter: function() {
                                    var currentPoint = this,
                                    currentSeries = currentPoint.series,
                                    chart = currentSeries.chart,
                                    stackName = this.series.userOptions.stack,
                                    stackValues = '';

                                    chart.series.forEach(function(series) {
                                        series.points.forEach(function(point) {
                                            if (currentSeries.userOptions.stack === series.userOptions.stack && currentPoint.key === point.category) {
                                                stackValues += '<span style="color:'+series.color+'">'+series.name+'</span>: ' + point.y + '<br/>'
                                            }
                                        })
                                    });

                                    return '<b>Name: </b>' + stackName + '<br/><br/>' +
                                    stackValues +
                                    '<b>Total: </b>' + this.point.stackTotal;
                                },
                                style: {
                                    fontSize:'15px'
                                }
                            },
                            legend: {
                                labelFormatter: function () {
                                    return this.userOptions.stack
                                },
                                itemStyle: {
                                    fontSize:'12px'
                                }
                            },
                            plotOptions: {
                                series: {
                                    stacking: 'normal'
                                }
                            },
                            series: series
                        });
                    }
                );
            }
        </script>
    </body>
</html>