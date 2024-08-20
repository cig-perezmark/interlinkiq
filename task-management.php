<?php 
    $title = "Task Management";
    $site = "task-management";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

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
    #tableData_Requirement_1 tbody tr:nth-child(4n),
    #tableData_Requirement_2 tbody tr:nth-child(4n) {
        background: #e5e5e5 !important;
    }
    #tableData_Requirement_1 tbody tr:nth-child(4n+3),
    #tableData_Requirement_2 tbody tr:nth-child(4n+3) {
        background: #e5e5e5 !important;
    }

    table.table-bordered.dataTable thead > tr:last-child th:last-child {
        border-right-width: unset;
    }
</style>


                    <div class="row">
                        <div class="col-md-3 hide">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th class="hide">Pending Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Compliance Dashboard</td>
                                                    <td class="hide">13</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <button class="btn btn-success hide" id="tableDataViewAll" onclick="btnViewAll(<?php echo $switch_user_id; ?>)">View All</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Compliance Dashboard</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Title</th>
                                                <th rowspan="2" class="text-center">Description</th>
                                                <th colspan="4" class="text-center" style="width: 80px;">Files</th>
                                                <th rowspan="2" class="text-center" style="width: 130px;">Comment</th>
                                                <th rowspan="2" class="text-center" style="width: 130px;">Compliance</th>
                                                <th rowspan="2" class="text-center" style="width: 130px;">Annual review</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">1-30 Days</th>
                                                <th class="text-center">31-60 Days</th>
                                                <th class="text-center">61-90 Days</th>
                                                <th class="text-center">Expired</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $team = 1;
                                                if (!empty($_COOKIE['switchAccount'])) { $team = 2; }
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT
                                                    l_ID,
                                                    l_type,
                                                    l_name,
                                                    l_description_tmp,
                                                    f_filetype,
                                                    f_files,
                                                    f_expired30,
                                                    f_expired60,
                                                    f_expired90,
                                                    f_expired,
                                                    c_count_c,
                                                    comp_percentage,
                                                    a_percentage
                                                    FROM (
                                                        SELECT
                                                        l_ID,
                                                        l_type,
                                                        l_name,
                                                        l_description_tmp,
                                                        f_max_ID,
                                                        f_name,
                                                        f_filetype,
                                                        f_files,
                                                        f_expired30,
                                                        f_expired60,
                                                        f_expired90,
                                                        f_expired,
                                                        c_count_c,
                                                        comp_ID,
                                                        comp_library_id,
                                                        comp_last_modified,
                                                        SUM(comp_count) AS comp_sum,
                                                        SUM(comp2_count) AS comp_total,
                                                        SUM(a_count) AS a_sum,
                                                        SUM(a2_count) AS a_total,
                                                        ROUND(CASE WHEN SUM(comp_count) IS NOT NULL AND SUM(comp_count) > 0 THEN (100 / SUM(comp_count)) * SUM(comp2_count) ELSE 0 END) AS comp_percentage,
                                                        ROUND(CASE WHEN SUM(a_count) IS NOT NULL AND SUM(a_count) > 0 THEN (100 / SUM(a_count)) * SUM(a2_count) ELSE 0 END) AS a_percentage
    
                                                        FROM (
                                                            SELECT
                                                            l_ID,
                                                            l_type,
                                                            l_name,
                                                            l_description_tmp,
                                                            f_max_ID,
                                                            f_name,
                                                            f_filetype,
                                                            f_files,
                                                            f_expired30,
                                                            f_expired60,
                                                            f_expired90,
                                                            f_expired,
                                                            c.count_c AS c_count_c,
                                                            comply.comp_ID,
                                                            comp_library_id,
                                                            comp_last_modified,
                                                            comp_count,
                                                            comp2_count,
                                                            a_count,
                                                            a2_count
                                                            FROM (
                                                                SELECT 
                                                                l.ID AS l_ID,
                                                                l.type AS l_type,
                                                                l.name AS l_name,
                                                                l.description_tmp AS l_description_tmp,
                                                                f.ID AS f_max_ID,
                                                                f.name AS f_name,
                                                                f.filetype AS f_filetype,
                                                                f.files AS f_files,
                                                                CASE WHEN f.due_date > CURDATE() AND f.due_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() THEN 1 ELSE 0 END AS f_expired30,
                                                                CASE WHEN f.due_date > CURDATE() AND f.due_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 31 DAY THEN 1 ELSE 0 END AS f_expired60,
                                                                CASE WHEN f.due_date > CURDATE() AND f.due_date BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE() - INTERVAL 61 DAY THEN 1 ELSE 0 END AS f_expired90,
                                                                CASE WHEN f.due_date <= CURDATE() THEN 1 ELSE 0 END AS f_expired
    
                                                                FROM tbl_library AS l
    
                                                                LEFT JOIN (
                                                                    SELECT 
                                                                    *
                                                                    FROM tbl_library_file
                                                                    WHERE deleted = 0
                                                                    AND ID IN (
                                                                        SELECT MAX(ID) FROM tbl_library_file WHERE deleted = 0 GROUP BY library_id
                                                                    )
                                                                ) AS f
                                                                ON l.ID = f.library_id
    
                                                                WHERE l.deleted = 0
                                                                AND l.user_id = $switch_user_id
                                                                
                                                                GROUP BY l.ID
                                                            ) r
    
                                                            LEFT JOIN (
                                                                SELECT
                                                                *,
                                                                COUNT(*) AS count_c
                                                                FROM tbl_library_comment
                                                                WHERE deleted = 0
                                                                AND team = $team
                                                                AND NOT FIND_IN_SET($switch_user_id, REPLACE(seen, ' ', '')) > 0
                                                                GROUP BY library_id
                                                            ) AS c
                                                            ON r.l_ID = c.library_id
    
                                                            LEFT JOIN (
                                                                SELECT 
                                                                comp.ID AS comp_ID,
                                                                comp.library_id AS comp_library_id,
                                                                comp.parent_id AS comp_parent_id,
                                                                comp.child_id AS comp_child_id,
                                                                comp.last_modified AS comp_last_modified,
                                                                comp.frequency AS comp_frequency,
                                                                comp.schedule AS comp_schedule,
                                                                1 AS comp_count,
                                                                comp2.ID AS comp2_ID,
                                                                comp2.parent_id AS comp2_parent_id,
                                                                comp2.child_id AS comp2_child_id,
                                                                comp2.last_modified AS comp2_last_modified,
                                                                CASE 
                                                                    WHEN comp2.type = 3 AND comp2.remark = 1 AND LENGTH(comp2.last_modified) > 0 AND comp.frequency = 1 AND comp2.last_modified + INTERVAL 1 DAY > CURDATE() THEN 1
                                                                    WHEN comp2.type = 3 AND comp2.remark = 1 AND LENGTH(comp2.last_modified) > 0 AND comp.frequency = 2 AND comp2.last_modified + INTERVAL 1 WEEK > CURDATE() THEN 1
                                                                    WHEN comp2.type = 3 AND comp2.remark = 1 AND LENGTH(comp2.last_modified) > 0 AND comp.frequency = 3 AND comp2.last_modified + INTERVAL 1 MONTH > CURDATE() THEN 1
                                                                    WHEN comp2.type = 3 AND comp2.remark = 1 AND LENGTH(comp2.last_modified) > 0 AND comp.frequency = 4 AND comp2.last_modified + INTERVAL 1 YEAR > CURDATE() THEN 1
                                                                    ELSE 0
                                                                END AS comp2_count
    
                                                                FROM tbl_library_compliance AS comp
    
                                                                LEFT JOIN (
                                                                    SELECT 
                                                                    *
                                                                    FROM tbl_library_compliance 
                                                                    WHERE deleted = 0
                                                                    AND ID IN (
                                                                        SELECT MAX(ID) FROM tbl_library_compliance WHERE deleted = 0 AND parent_id > 0 GROUP BY parent_id
                                                                    )
                                                                ) AS comp2
                                                                ON FIND_IN_SET(comp2.ID, REPLACE(comp.child_id, ' ', '')) > 0
    
                                                                WHERE comp.deleted = 0
                                                                AND comp.parent_id = 0
                                                            ) AS comply
                                                            ON r.l_ID = comply.comp_library_id
    
                                                            LEFT JOIN (
                                                                SELECT
                                                                a.ID AS a_ID,
                                                                a.library_id AS a_library_id,
                                                                a.parent_id AS a_parent_id,
                                                                a.child_id AS a_child_id,
                                                                a.last_modified AS a_last_modified,
                                                                1 AS a_count,
                                                                a.remark AS a_remark,
                                                                a.remark_user AS a_remark_user,
                                                                a.type AS a_type,
                                                                a2.ID AS a2_ID,
                                                                a2.parent_id AS a2_parent_id,
                                                                a2.child_id AS a2_child_id,
                                                                a2.last_modified AS a2_last_modified,
                                                                CASE 
                                                                    WHEN a2.type = 3 AND a2.remark = 1 AND LENGTH(a2.last_modified) > 0 AND a2.last_modified + INTERVAL 1 YEAR > CURDATE() THEN 1
                                                                    ELSE 0
                                                                END AS a2_count,
                                                                a2.remark AS a2_remark,
                                                                a2.remark_user AS a2_remark_user,
                                                                a2.type AS a2_type
    
                                                                FROM tbl_library_review AS a
    
                                                                LEFT JOIN (
                                                                    SELECT 
                                                                    *
                                                                    FROM tbl_library_review 
                                                                    WHERE is_deleted = 0
                                                                    AND ID IN (
                                                                        SELECT MAX(ID) FROM tbl_library_review WHERE is_deleted = 0 AND parent_id > 0 GROUP BY parent_id
                                                                    )
                                                                ) AS a2
                                                                ON FIND_IN_SET(a2.ID, REPLACE(a.child_id, ' ', '')) > 0
    
                                                                WHERE a.is_deleted = 0
                                                                AND a.parent_id = 0
                                                            ) AS annual
                                                            ON r.l_ID = annual.a_library_id
                                                        ) r2
    
                                                        WHERE l_description_tmp LIKE '%,\"status\":\"%'
                                                        OR f_expired30 > 0
                                                        OR f_expired60 > 0
                                                        OR f_expired90 > 0
                                                        OR f_expired > 0
                                                        OR LENGTH(c_count_c) > 0
                                                        OR comp_count IS NOT NULL
                                                        OR comp_count < 100
                                                        OR a_count IS NOT NULL
                                                        OR a_count < 100
    
                                                        GROUP BY l_ID
                                                    ) r3

                                                    WHERE l_description_tmp LIKE '%,\"status\":\"%'
                                                    OR f_expired30 > 0
                                                    OR f_expired60 > 0
                                                    OR f_expired90 > 0
                                                    OR f_expired > 0
                                                    OR LENGTH(c_count_c) > 0
                                                    OR (comp_percentage < 100 AND a_percentage < 100)
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $l_ID = $rowData["l_ID"];
                                                        $l_type = $rowData["l_type"];
                                                        $compliance = $rowData["comp_percentage"];
                                                        $annual = $rowData["a_percentage"];

                                                        $l_name = htmlentities($rowData["l_name"] ?? '');
                                                        if (!empty($l_name)) {
                                                            $array_name_id = explode(", ", $l_name);

                                                            if ( count($array_name_id) == 4 AND $l_type == 0 ) {
                                                                $data_name = array();

                                                                $selectLibraryName = mysqli_query($conn,"
                                                                    SELECT name FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'
                                                                    UNION ALL
                                                                    SELECT name FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'
                                                                    UNION ALL
                                                                    SELECT name FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'
                                                                    UNION ALL
                                                                    SELECT name FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'
                                                                ");
                                                                if ( mysqli_num_rows($selectLibraryName) > 0 ) {
                                                                    while($rowLibraryName = mysqli_fetch_array($selectLibraryName)) {
                                                                        array_push($data_name, $rowLibraryName["name"]);
                                                                    }
                                                                }

                                                                $l_name = implode(" - ",$data_name);
                                                            }
                                                        }

                                                        $description = '';
                                                        $user_array_list = array(1, 464);
                                                        if (!empty($rowData["l_description_tmp"]) AND in_array($user_id, $user_array_list)) {
                                                            $arr_tmp = json_decode($rowData["l_description_tmp"],true);

                                                            $last_array = end($arr_tmp); // Assuming $your_arrays contains your list of arrays
                                                            $key_to_check = 'status';

                                                            if (isset($last_array['status'])) {
                                                                if ($last_array['status'] != 4) {
                                                                  $description = '<a href="#modalChanges" data-toggle="modal" onclick="btnChangesView('.$l_ID.')">View</a>';
                                                                }
                                                            } else {
                                                                $description = isset($arr_tmp['status']);
                                                            }
                                                        }

                                                        $files = '';
                                                        $type = 'iframe';
                                                        $target = '';
                                                        $datafancybox = 'data-fancybox';
                                                        if ($rowData["f_expired30"] > 0 OR $rowData["f_expired60"] > 0 OR $rowData["f_expired90"] > 0 OR $rowData["f_expired"] > 0) {
                                                            if (!empty($rowData["f_files"])) {
                                                                $arr_filename = explode(' | ', $rowData["f_files"]);
                                                                $arr_filetype = explode(' | ', $rowData["f_filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $str_filename;
                                                                if ($str_filetype == 1) {
                                                                    $fileExtension = fileExtension($str_filename);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $url = $base_url.'uploads/library/';

                                                                    $files = $src.$url.rawurlencode($str_filename).$embed;
                                                                } else if ($str_filetype == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $str_filename).'preview';
                                                                } else if ($str_filetype == 4) {
                                                                    $target = '_blank';
                                                                    $datafancybox = '';
                                                                }
                                                                $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                            }
                                                        }

                                                        $comment = '';
                                                        if (!empty($rowData["c_count_c"])) {
                                                            $comment = $rowData["c_count_c"].' Unread';
                                                        }

                                                        echo '<tr>
                                                            <td><a href="'.$base_url.'dashboard?d='.$l_ID.'" target="_blank">'.$l_name.'</a></td>
                                                            <td class="text-center">'.$description.'</td>
                                                            <td class="text-center">'; echo $rowData["f_expired30"] > 0 ? $files:''; echo '</td>
                                                            <td class="text-center">'; echo $rowData["f_expired60"] > 0 ? $files:''; echo '</td>
                                                            <td class="text-center">'; echo $rowData["f_expired90"] > 0 ? $files:''; echo '</td>
                                                            <td class="text-center">'; echo $rowData["f_expired"] > 0 ? $files:''; echo '</td>
                                                            <td class="text-center">'.$comment.'</td>
                                                            <td class="text-center">'.round($compliance).'%</td>
                                                            <td class="text-center">'.round($annual).'%</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Record Verification Management</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Freequency</th>
                                                <th class="text-center" style="width: 80px;">Files</th>
                                                <th>Properly Filled Out?</th>
                                                <th>Properly Signed or Initialed?</th>
                                                <th>Is Compliant?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT
                                                    *
                                                    FROM (
                                                        SELECT 
                                                        ID,
                                                        description,
                                                        files,
                                                        filetype,
                                                        files_date,
                                                        frequency,
                                                        CASE 
                                                            WHEN frequency = 0 AND files_date + INTERVAL 1 DAY < CURDATE() THEN 1
                                                            WHEN frequency = 1 AND files_date + INTERVAL 1 WEEK < CURDATE() THEN 1
                                                            WHEN frequency = 2 AND files_date + INTERVAL 1 MONTH < CURDATE() THEN 1
                                                            WHEN frequency = 3 AND files_date + INTERVAL 3 MONTH < CURDATE() THEN 1
                                                            WHEN frequency = 4 AND files_date + INTERVAL 6 MONTH < CURDATE() THEN 1
                                                            WHEN frequency = 5 AND files_date + INTERVAL 1 YEAR < CURDATE() THEN 1
                                                            ELSE 0
                                                        END AS f_expired,
                                                        assigned_to_id,
                                                        filled_out,
                                                        filled_out_reason,
                                                        signed,
                                                        signed_reason,
                                                        compliance,
                                                        compliance_reason

                                                        FROM tbl_eforms 

                                                        WHERE user_id = $switch_user_id
                                                    ) r

                                                    WHERE filled_out = 0 
                                                    OR signed = 0 
                                                    OR compliance = 0 
                                                    OR f_expired > 0
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $row_ID = $rowData["ID"];
                                                        $row_description = htmlentities($rowData["description"] ?? '');

                                                        $row_frequency = $rowData["frequency"];
                                                        $frequency_arr = array(
                                                            0 => 'Daily',
                                                            1 => 'Weekly',
                                                            2 => 'Monthly',
                                                            3 => 'Quaterly',
                                                            4 => 'Bi-annual',
                                                            5 => 'Annually',
                                                            6 => 'Other'
                                                        );

                                                        $files = '';
                                                        $type = 'iframe';
                                                        $target = '';
                                                        $datafancybox = 'data-fancybox';
                                                        if ($rowData["f_expired"]) {
                                                            if (!empty($rowData["files"])) {
                                                                $arr_filename = explode(' | ', $rowData["files"]);
                                                                $arr_filetype = explode(' | ', $rowData["filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $str_filename;
                                                                if ($str_filetype == 1) {
                                                                    $fileExtension = fileExtension($str_filename);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $url = $base_url.'uploads/eforms/';

                                                                    $files = $src.$url.rawurlencode($str_filename).$embed;
                                                                } else if ($str_filetype == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $str_filename).'preview';
                                                                } else if ($str_filetype == 4) {
                                                                    $target = '_blank';
                                                                    $datafancybox = '';
                                                                }
                                                                $files = '<a href="'.$files.'" data-src="'.$files.'" '.$datafancybox.' data-type="'.$type.'" target="'.$target.'">View</a>';
                                                            }
                                                        }

                                                        $row_filled_out_reason = '';
                                                        if ($rowData["filled_out"] == 0) {
                                                            $row_filled_out_reason = 'No';
                                                            if (!empty($rowData["filled_out_reason"])) {
                                                                $row_filled_out_reason = htmlentities($rowData["filled_out_reason"] ?? '');
                                                            }
                                                        }

                                                        $row_signed_reason = '';
                                                        if ($rowData["signed"] == 0) {
                                                            $row_signed_reason = 'No';
                                                            if (!empty($rowData["signed_reason"])) {
                                                                $row_signed_reason = htmlentities($rowData["signed_reason"] ?? '');
                                                            }
                                                        }

                                                        $row_compliance_reason = '';
                                                        if ($rowData["compliance"] == 0) {
                                                            $row_compliance_reason = 'No';
                                                            if (!empty($rowData["compliance_reason"])) {
                                                                $row_compliance_reason = htmlentities($rowData["compliance_reason"] ?? '');
                                                            }
                                                        }

                                                        echo '<tr>
                                                            <td><a href="#modalView" data-toggle="modal" onclick="btnEdit('.$row_ID.')">'.$row_description.'</a></td>
                                                            <td>'.$frequency_arr[$row_frequency].'</td>
                                                            <td class="text-center">'.$files.'</td>
                                                            <td>'.$row_filled_out_reason.'</td>
                                                            <td>'.$row_signed_reason.'</td>
                                                            <td>'.$row_compliance_reason.'</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Job Ticket</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th>Services</th>
                                                <th class="text-center" style="width: 80px;">Files</th>
                                                <th class="text-center" style="width: 130px;">Date Requested</th>
                                                <th class="text-center" style="width: 125px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql_custom = " AND user_id = $switch_user_id ";
                                                if ($current_userEmployeeID > 0) {
                                                    $sql_custom = " AND FIND_IN_SET($current_userEmployeeID, REPLACE(assigned_to_id, ' ', '')) ";
                                                }
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT 
                                                    ID,
                                                    title,
                                                    description,
                                                    files,
                                                    last_modified,
                                                    assigned_to_id 
                                                    FROM tbl_services 

                                                    WHERE deleted = 0
                                                    AND status = 0
                                                    $sql_custom
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $row_ID = $rowData["ID"];
                                                        $row_last_modified = $rowData["last_modified"];
                                                        $row_title = htmlentities($rowData["title"] ?? '');
                                                        $row_description = htmlentities($rowData["description"] ?? '');

                                                        $files = $rowData["files"];
                                                        if (!empty($files)) {
                                                            $fileExtension = fileExtension($files);
                                                            $src = $fileExtension['src'];
                                                            $embed = $fileExtension['embed'];
                                                            $type = $fileExtension['type'];
                                                            $file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'uploads/services/';

                                                            $files = '<a data-src="'.$src.$url.rawurlencode($files).$embed.'" data-fancybox data-type="'.$type.'">View</a>';
                                                        }
                                                        
                                                        echo '<tr>
                                                            <td>
                                                                <strong>'.$row_title.'</strong><br>
                                                                '.$row_description.'
                                                            </td>
                                                            <td class="text-center">'.$files.'</td>
                                                            <td class="text-center">'.$row_last_modified.'</td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-circle">
                                                                    <a href="#modalViewJT" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('.$row_ID.')">View</a>
                                                                    <a href="javascript:;" class="btn green btn-sm btnDone" onclick="btnDone('.$row_ID.')">Done</a>
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

                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-graduation font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Food Fraud Vulnerability Assessment</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabSuppliers" data-toggle="tab">Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="#tabIngredients" data-toggle="tab">Ingredients</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabSuppliers">
                                            <table class="table table-bordered table-hover tableData">
                                                <thead>
                                                    <tr>
                                                        <th>Supplier Name</th>

                                                        <?php
                                                            if ($switch_user_id == 34) {
                                                                echo '<th class="text-center">Int. Reviewer</th>
                                                                <th class="text-center">Int. Verifier</th>
                                                                <th class="text-center" style="width: 80px;">Files</th>';
                                                            }
                                                        ?>

                                                        <th class="text-center" style="width: 80px;">Status</th>
                                                        <th class="text-center" style="width: 80px;">Valid Until</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectData = mysqli_query( $conn,"
                                                            SELECT
                                                            f.ID AS f_ID,
                                                            f.company AS f_company,
                                                            f.files AS f_files,
                                                            f.prepared_by AS f_prepared_by,
                                                            f.prepared_signature AS f_prepared_signature,
                                                            f.reviewed_by AS f_reviewed_by,
                                                            f.reviewed_signature AS f_reviewed_signature,
                                                            f.approved_by AS f_approved_by,
                                                            f.approved_signature AS f_approved_signature,
                                                            f.int_review_assigned AS f_int_review_assigned,
                                                            f.int_review_status AS f_int_review_status,
                                                            f.int_review_comment AS f_int_review_comment,
                                                            CONCAT(er.first_name, ' ', er.last_name) AS er_name,
                                                            f.int_verify_assigned AS f_int_verify_assigned,
                                                            f.int_verify_status AS f_int_verify_status,
                                                            f.int_verify_comment AS f_int_verify_comment,
                                                            CONCAT(ev.first_name, ' ', ev.last_name) AS ev_name,
                                                            CASE
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 AND LENGTH(f.int_verify_assigned) > 0 AND f.int_verify_status = 1 AND LENGTH(f.approved_date) > 0 THEN 'Approved by Client'
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 AND LENGTH(f.int_verify_assigned) > 0 AND f.int_verify_status = 1 THEN 'Approved by CIG'
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 THEN 'Reviewed'
                                                                ELSE 'Drafted'
                                                            END AS f_status,
                                                            f.last_modified + INTERVAL 1 YEAR AS f_date_end
                                                            FROM tbl_ffva AS f

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_hr_employee
                                                            ) AS er
                                                            ON er.ID = f.int_review_assigned

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_hr_employee
                                                            ) AS ev
                                                            ON ev.ID = f.int_verify_assigned

                                                            WHERE f.deleted = 0
                                                            AND f.archived = 0
                                                            AND f.updated = 0
                                                            AND f.type = 1
                                                            AND f.user_id = $switch_user_id
                                                            AND (
                                                                IFNULL(f.int_review_assigned='',TRUE) OR
                                                                IFNULL(f.int_verify_assigned='',TRUE) OR
                                                                f.int_review_status != 1 OR
                                                                f.int_verify_status != 1 OR
                                                                f.last_modified + INTERVAL 1 YEAR < CURDATE()
                                                            )
                                                        " );
                                                        if ( mysqli_num_rows($selectData) > 0 ) {
                                                            while($rowData = mysqli_fetch_array($selectData)) {
                                                                $f_ID = $rowData["f_ID"];
                                                                $f_company = htmlentities($rowData["f_company"] ?? '');
                                                                $f_status = htmlentities($rowData["f_status"] ?? '');
                                                                $f_date_end = htmlentities($rowData["f_date_end"] ?? '');
                                                                
                                                                $er_name = '';
                                                                $f_int_review_assigned = $rowData["f_int_review_assigned"];
                                                                $f_int_review_status = $rowData["f_int_review_status"];
                                                                $f_int_review_comment = htmlentities($rowData["f_int_review_comment"] ?? '');
                                                                if (!empty($f_int_review_assigned)) {
                                                                    $er_name = htmlentities($rowData["er_name"] ?? '');
                                                                }
                                                                
                                                                $ev_name = '';
                                                                $f_int_verify_assigned = $rowData["f_int_verify_assigned"];
                                                                $f_int_verify_status = $rowData["f_int_verify_status"];
                                                                $f_int_verify_comment = htmlentities($rowData["f_int_verify_comment"] ?? '');
                                                                if (!empty($f_int_verify_assigned)) {
                                                                    $ev_name = htmlentities($rowData["ev_name"] ?? '');
                                                                }

                                                                $f_files = $rowData["f_files"];
                                                                if (!empty($f_files)) {
                                                                    $fileExtension = fileExtension($f_files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/ffva/';

                                                                    $f_files = '<a data-src="'.$src.$url.rawurlencode($f_files).$embed.'" data-fancybox data-type="'.$type.'">View</a>';
                                                                }

                                                                echo '<tr>
                                                                    <td><a href="'.$base_url.'ffva?v='.$f_ID.'" target="_blank">'.$f_company.'</a></td>';

                                                                    if ($switch_user_id == 34) {
                                                                        echo '<td class="text-center int_review_status">';
                                                                            if (!empty($er_name)) {  echo $er_name .'<br>'; }
                                                                            echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$f_ID.', 1, 1)">View</a>';

                                                                            if($f_int_review_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($f_int_review_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.$f_int_review_comment.'</i></small>'; }
                                                                        echo '</td>
                                                                        <td class="text-center int_verify_status">';
                                                                            if (!empty($ev_name)) {  echo $ev_name .'<br>'; }
                                                                            if ($f_int_review_status == 1) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$f_ID.', 2, 1)">View</a>'; }
                                                                            
                                                                            if($f_int_verify_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($f_int_verify_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.$f_int_verify_comment.'</i></small>'; }
                                                                        echo '</td>
                                                                        <td class="text-center">'.$f_files.'</td>';
                                                                    }

                                                                    echo '<td class="text-center">'.$f_status.'</td>
                                                                    <td class="text-center">'.$f_date_end.'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabIngredients">
                                            <table class="table table-bordered table-hover tableData">
                                                <thead>
                                                    <tr>
                                                        <th>Ingredient Name</th>

                                                        <?php
                                                            if ($switch_user_id == 34) {
                                                                echo '<th class="text-center">Int. Reviewer</th>
                                                                <th class="text-center">Int. Verifier</th>
                                                                <th class="text-center" style="width: 80px;">Files</th>';
                                                            }
                                                        ?>

                                                        <th class="text-center" style="width: 80px;">Status</th>
                                                        <th class="text-center" style="width: 80px;">Valid Until</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $selectData = mysqli_query( $conn,"
                                                            SELECT
                                                            f.ID AS f_ID,
                                                            f.company AS f_company,
                                                            f.product AS f_product,
                                                            f.files AS f_files,
                                                            f.prepared_by AS f_prepared_by,
                                                            f.prepared_signature AS f_prepared_signature,
                                                            f.reviewed_by AS f_reviewed_by,
                                                            f.reviewed_signature AS f_reviewed_signature,
                                                            f.approved_by AS f_approved_by,
                                                            f.approved_signature AS f_approved_signature,
                                                            f.int_review_assigned AS f_int_review_assigned,
                                                            f.int_review_status AS f_int_review_status,
                                                            f.int_review_comment AS f_int_review_comment,
                                                            CONCAT(er.first_name, ' ', er.last_name) AS er_name,
                                                            f.int_verify_assigned AS f_int_verify_assigned,
                                                            f.int_verify_status AS f_int_verify_status,
                                                            f.int_verify_comment AS f_int_verify_comment,
                                                            CONCAT(ev.first_name, ' ', ev.last_name) AS ev_name,
                                                            CASE
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 AND LENGTH(f.int_verify_assigned) > 0 AND f.int_verify_status = 1 AND LENGTH(f.approved_date) > 0 THEN 'Approved by Client'
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 AND LENGTH(f.int_verify_assigned) > 0 AND f.int_verify_status = 1 THEN 'Approved by CIG'
                                                                WHEN LENGTH(f.int_review_assigned) > 0 AND f.int_review_status = 1 THEN 'Reviewed'
                                                                ELSE 'Drafted'
                                                            END AS f_status,
                                                            f.last_modified + INTERVAL 1 YEAR AS f_date_end
                                                            FROM tbl_ffva AS f

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_hr_employee
                                                            ) AS er
                                                            ON er.ID = f.int_review_assigned

                                                            LEFT JOIN (
                                                                SELECT
                                                                *
                                                                FROM tbl_hr_employee
                                                            ) AS ev
                                                            ON ev.ID = f.int_verify_assigned

                                                            WHERE f.deleted = 0
                                                            AND f.archived = 0
                                                            AND f.updated = 0
                                                            AND f.type = 2
                                                            AND f.user_id = $switch_user_id
                                                            AND (
                                                                IFNULL(f.int_review_assigned = '', TRUE) OR
                                                                IFNULL(f.int_verify_assigned = '', TRUE) OR
                                                                f.int_review_status != 1 OR
                                                                f.int_verify_status != 1 OR
                                                                f.last_modified + INTERVAL 1 YEAR < CURDATE()
                                                            )
                                                        " );
                                                        if ( mysqli_num_rows($selectData) > 0 ) {
                                                            while($rowData = mysqli_fetch_array($selectData)) {
                                                                $f_ID = $rowData["f_ID"];
                                                                $f_company = htmlentities($rowData["f_company"] ?? '');
                                                                $f_product = htmlentities($rowData["f_product"] ?? '');
                                                                $f_status = htmlentities($rowData["f_status"] ?? '');
                                                                $f_date_end = htmlentities($rowData["f_date_end"] ?? '');
                                                                
                                                                $er_name = '';
                                                                $f_int_review_assigned = $rowData["f_int_review_assigned"];
                                                                $f_int_review_status = $rowData["f_int_review_status"];
                                                                $f_int_review_comment = htmlentities($rowData["f_int_review_comment"] ?? '');
                                                                if (!empty($f_int_review_assigned)) {
                                                                    $er_name = htmlentities($rowData["er_name"] ?? '');
                                                                }
                                                                
                                                                $ev_name = '';
                                                                $f_int_verify_assigned = $rowData["f_int_verify_assigned"];
                                                                $f_int_verify_status = $rowData["f_int_verify_status"];
                                                                $f_int_verify_comment = htmlentities($rowData["f_int_verify_comment"] ?? '');
                                                                if (!empty($f_int_verify_assigned)) {
                                                                    $ev_name = htmlentities($rowData["ev_name"] ?? '');
                                                                }

                                                                $f_files = $rowData["f_files"];
                                                                if (!empty($f_files)) {
                                                                    $fileExtension = fileExtension($f_files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/ffva/';

                                                                    $f_files = '<a data-src="'.$src.$url.rawurlencode($f_files).$embed.'" data-fancybox data-type="'.$type.'">View</a>';
                                                                }

                                                                echo '<tr>
                                                                    <td><a href="'.$base_url.'ffva?v='.$f_ID.'" target="_blank">'.$f_product.'</a></td>';

                                                                    if ($switch_user_id == 34) {
                                                                        echo '<td class="text-center int_review_status">';
                                                                            if (!empty($er_name)) {  echo $er_name .'<br>'; }
                                                                            echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$f_ID.', 1, 1)">View</a>';

                                                                            if($f_int_review_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($f_int_review_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.$f_int_review_comment.'</i></small>'; }
                                                                        echo '</td>
                                                                        <td class="text-center int_verify_status">';
                                                                            if (!empty($ev_name)) {  echo $ev_name .'<br>'; }
                                                                            if ($f_int_review_status == 1) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$f_ID.', 2, 1)">View</a>'; }
                                                                            
                                                                            if($f_int_verify_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($f_int_verify_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.$f_int_verify_comment.'</i></small>'; }
                                                                        echo '</td>
                                                                        <td class="text-center">'.$f_files.'</td>';
                                                                    }

                                                                    echo '<td class="text-center">'.$f_status.'</td>
                                                                    <td class="text-center">'.$f_date_end.'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Enterprise</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th style="width: 130px;">Category</th>
                                                <th>Name</th>
                                                <th class="text-center" style="width: 80px;">Files</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT
                                                    ID AS e_ID,
                                                    'Trademark' AS e_category,
                                                    trademark_name AS e_name,
                                                    files AS e_file,
                                                    last_modified AS e_date_start,
                                                    '' AS e_date_end
                                                    
                                                    FROM tblEnterpiseDetails_Trademark 
                                                    
                                                    WHERE deleted = 0
                                                    AND user_id = $switch_user_id
                                                    AND last_modified + INTERVAL 1 YEAR < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    reg_id AS e_ID,
                                                    'Certification' AS e_category,
                                                    registration_name AS e_name,
                                                    supporting_file AS e_file,
                                                    registration_date AS e_date_start,
                                                    expiry_date AS e_date_end
                                                    
                                                    FROM tblFacilityDetails_registration 
                                                    
                                                    WHERE table_entities = 3
                                                    AND ownedby = $switch_user_id
                                                    AND expiry_date < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    reg_id AS e_ID,
                                                    'Accreditation' AS e_category,
                                                    registration_name AS e_name,
                                                    supporting_file AS e_file,
                                                    registration_date AS e_date_start,
                                                    expiry_date AS e_date_end
                                                    
                                                    FROM tblFacilityDetails_registration 
                                                    
                                                    WHERE table_entities = 4
                                                    AND ownedby = $switch_user_id
                                                    AND expiry_date < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    reg_id AS e_ID,
                                                    'Regulatory' AS e_category,
                                                    registration_name AS e_name,
                                                    supporting_file AS e_file,
                                                    registration_date AS e_date_start,
                                                    expiry_date AS e_date_end
                                                    
                                                    FROM tblFacilityDetails_registration 
                                                    
                                                    WHERE table_entities = 1
                                                    AND ownedby = $switch_user_id
                                                    AND expiry_date < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    rec_id AS e_ID,
                                                    'Record' AS e_category,
                                                    DocumentTitle AS e_name,
                                                    EnterpriseRecordsFile AS e_file,
                                                    rec_date_added AS e_date_start,
                                                    DocumentDueDate AS e_date_end
                                                    
                                                    FROM tblEnterpiseDetails_Records 
                                                    
                                                    WHERE deleted = 0
                                                    AND user_cookies = $switch_user_id
                                                    AND DocumentDueDate < CURDATE()
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $e_category = $rowData["e_category"];
                                                        $e_name = htmlentities($rowData["e_name"] ?? '');
                                                        
                                                        $e_file = $rowData["e_file"];
                                                        if (!empty($e_file)) {
                                                            $fileExtension = fileExtension($e_file);
                                                            $src = $fileExtension['src'];
                                                            $embed = $fileExtension['embed'];
                                                            $type = $fileExtension['type'];
                                                            $file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'companyDetailsFolder/';
                                                            
                                                            $e_file = '<a data-src="'.$src.$url.rawurlencode($e_file).$embed.'" data-fancybox data-type="'.$type.'">View</a>';
                                                        }
                                                        
                                                        echo '<tr>
                                                            <td><a href="enterprise-info" target="_blank">'.$e_category.'</a></td>
                                                            <td>'.$e_name.'</td>
                                                            <td class="text-center">'.$e_file.'</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Facility</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th style="width: 130px;">Category</th>
                                                <th>Name</th>
                                                <th class="text-center" style="width: 80px;">Files</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT 
                                                    reg_id AS f_ID,
                                                    facility_id AS f_account,
                                                    'Regulation' AS f_category,
                                                    registration_name AS f_name,
                                                    supporting_file AS f_file,
                                                    registration_date AS f_date_start,
                                                    expiry_date AS f_date_end
                                                    
                                                    FROM tblFacilityDetails_registration 
                                                    
                                                    WHERE table_entities = 2
                                                    AND ownedby = $switch_user_id
                                                    AND expiry_date < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    Permits_id AS f_ID,
                                                    facility_entities AS f_account,
                                                    'Permit' AS f_category,
                                                    Descriptions AS f_name,
                                                    Permits AS f_file,
                                                    Issue_Date AS f_date_start,
                                                    Expiration_Date AS f_date_end
                                                    
                                                    FROM tblFacilityDetails_Permits 
                                                    
                                                    WHERE user_cookies = $switch_user_id
                                                    AND Expiration_Date < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    Accreditation_id AS f_ID,
                                                    facility_entities AS f_account,
                                                    'Accreditation' AS f_category,
                                                    Type_Accreditation AS f_name,
                                                    Accreditation AS f_file,
                                                    Issue_Date_Type_Accreditation AS f_date_start,
                                                    Expiration_Date_Type_Accreditation AS f_date_end
                                                    FROM tblFacilityDetails_Accreditation 
                                                    
                                                    WHERE user_cookies = $switch_user_id
                                                    AND Expiration_Date_Type_Accreditation < CURDATE()
                                                    
                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    Certification_id AS f_ID,
                                                    facility_entities AS f_account,
                                                    'Certification' AS f_category,
                                                    Type_Certification AS f_name,
                                                    Certification AS f_file,
                                                    Issue_Date_Certification AS f_date_start,
                                                    Expiration_Date_Certification AS f_date_end
                                                    
                                                    FROM tblFacilityDetails_Certification 
                                                    
                                                    WHERE user_cookies = $switch_user_id
                                                    AND Expiration_Date_Certification < CURDATE()
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $f_account = $rowData["f_account"];
                                                        $f_category = $rowData["f_category"];
                                                        $f_name = htmlentities($rowData["f_name"] ?? '');
                                                        
                                                        $f_file = $rowData["f_file"];
                                                        if (!empty($f_file)) {
                                                            $fileExtension = fileExtension($f_file);
                                                            $src = $fileExtension['src'];
                                                            $embed = $fileExtension['embed'];
                                                            $type = $fileExtension['type'];
                                                            $file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'facility_files_Folder/';
                                                            
                                                            $f_file = '<a data-src="'.$src.$url.rawurlencode($f_file).$embed.'" data-fancybox data-type="'.$type.'">View</a>';
                                                        }
                                                        
                                                        echo '<tr>
                                                            <td><a href="facility-info?facility_id='.$f_account.'" target="_blank">'.$f_category.'</a></td>
                                                            <td>'.$f_name.'</td>
                                                            <td class="text-center">'.$f_file.'</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Meeting Minutes</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th style="width: 130px;">Account</th>
                                                <th>Agenda</th>
                                                <th class="text-center" style="width: 80px;">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql_custom = '';
                                                if ($current_userEmployeeID > 0) {
                                                    $sql_custom = " AND a.assigned_to = $current_userEmployeeID ";
                                                }
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT 
                                                    a.action_id AS a_action_id,
                                                    a.action_meeting_id AS a_action_meeting_id,
                                                    a.action_details AS a_action_details,
                                                    a.target_due_date AS a_target_due_date,
                                                    m.account AS m_account,
                                                    m.agenda AS m_agenda
                                                    FROM tbl_meeting_minutes_action_items AS a
                                                    
                                                    LEFT JOIN (
                                                    	SELECT
                                                        id,
                                                        user_ids,
                                                        account,
                                                        agenda
                                                    	FROM tbl_meeting_minutes
                                                    ) AS m
                                                    ON a.action_meeting_id = m.id
                                                    
                                                    WHERE m.user_ids = $switch_user_id
                                                    AND a.status LIKE 'Open'
                                                    $sql_custom
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while($rowData = mysqli_fetch_array($selectData)) {
                                                        $a_action_id = $rowData["a_action_id"];
                                                        $m_account = $rowData["m_account"];
                                                        $m_agenda = htmlentities($rowData["m_agenda"] ?? '');
                                                        $a_action_details = htmlentities($rowData["a_action_details"] ?? '');
                                                        $a_target_due_date = htmlentities($rowData["a_target_due_date"] ?? '');
                                                        
                                                        echo '<tr>
                                                            <td>
                                                                <a href="#modal_update_status" data-toggle="modal" type="button" id="add_status" onclick="btnMOM('.$a_action_id.')">'.$m_account.'</a>
                                                            </td>
                                                            <td>
                                                                <strong>'.$m_agenda.'</strong></br>
                                                                '.$a_action_details.'
                                                            </td>
                                                            <td class="text-center">'.$a_target_due_date.'</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">Corrective Action and Preventive Action Management</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th>Date Created</th>
                                                <th>CAPA ID</th>

                                                <?php echo $current_client == 0 ? '<th>CAPA Reference No.</th>':''; ?>
                                                
                                                <th>Observed By</th>
                                                <th>Reported By</th>

                                                <?php echo $current_client == 1 ? '<th>Personnel Involved':''; ?>
                                                
                                                <th>Department Involved</th>
                                                <th>Description of Issue</th>
                                                <th class="text-center" style="width: 125px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectCamOpen = mysqli_query( $conn,"SELECT * FROM tbl_cam WHERE status = 0 AND user_id = $switch_user_id ORDER BY ID DESC" );
                                                if ( mysqli_num_rows($selectCamOpen) > 0 ) {
                                                    while ($rowOpen= mysqli_fetch_array($selectCamOpen)) {
                                                        $cam_ID = $rowOpen['ID'];
                                                        $cam_reference = htmlentities($rowOpen['reference'] ?? '');
                                                        $cam_date = $rowOpen['date'];
                                                        $cam_observed_by = htmlentities($rowOpen['observed_by'] ?? '');
                                                        $cam_reported_by = htmlentities($rowOpen['reported_by'] ?? '');
                                                        $cam_description = htmlentities($rowOpen['description'] ?? '');

                                                        $cam_department_id = $rowOpen['department_id'];
                                                        $cam_department_other = htmlentities($rowOpen['department_other'] ?? '');
                                                        $data_department_id = array();
                                                        if (!empty($cam_department_id)) {
                                                            $array_department_id = explode(", ", $cam_department_id);

                                                            $selectDepartment = mysqli_query( $conn,"SELECT ID, title FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                            if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                    if (in_array($rowDept["ID"], $array_department_id)) {
                                                                        array_push($data_department_id, htmlentities($rowDept["title"] ??''));
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
                                                            $selectEmployee = mysqli_query( $conn,"SELECT ID, first_name, last_name FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                            if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                    if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                        array_push($data_employee_id, htmlentities($rowEmployee["first_name"] ?? '').' '.htmlentities($rowEmployee["last_name"] ?? ''));
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $data_employee_id = implode(", ",$data_employee_id);

                                                        echo '<tr id="tr_'.$cam_ID.'">
                                                            <td>'.$cam_date.'</td>
                                                            <td>'.$cam_ID.'</td>';

                                                            if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                            
                                                            echo '<td>'.$cam_observed_by.'</td>
                                                            <td>'.$cam_reported_by.'</td>';

                                                            if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                            
                                                            echo '<td>'.$data_department_id.'</td>
                                                            <td>'.$cam_description.'</td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-circle">
                                                                    <a href="'.$base_url.'pdf_c?id='.$cam_ID.'&t=1" target="_blank" class="btn btn-info btn-sm">PDF</a>
                                                                    <a href="javascript:;" class="btn btn-danger btn-sm" onclick="btnClose('. $cam_ID .')">Close</a>
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                    }
                                                }
                                                
                                                $selectComplaintOpen = mysqli_query( $conn,"SELECT * FROM tbl_complaint_records WHERE deleted = 0 AND capam = 1 AND status = 0 AND care_ownedby = $switch_user_id ORDER BY care_id DESC" );
                                                if ( mysqli_num_rows($selectComplaintOpen) > 0 ) {
                                                    while ($rowOpen= mysqli_fetch_array($selectComplaintOpen)) {
                                                        $cam_ID = htmlentities($rowOpen['care_id'] ?? '');
                                                        $cam_reference = htmlentities($rowOpen['reference'] ?? '');
                                                        $cam_observed_by = htmlentities($rowOpen['observed_by'] ?? '');
                                                        $cam_reported_by = htmlentities($rowOpen['reported_by'] ?? '');
                                                        $cam_description = htmlentities($rowOpen['nature_complaint'] ?? '');
                                                        
                                                        $data_department_id = array();
                                                        $cam_person_handlingn = htmlentities($rowOpen['person_handling'] ?? '');
                                                        if ($cam_person_handlingn > 0) {
                                                            $selectEmp = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $cam_person_handlingn" );
                                                            if ( mysqli_num_rows($selectEmp) > 0 ) {
                                                                $rowEmp= mysqli_fetch_array($selectEmp);
                                                                $cam_department_id = $rowEmp['department_id'];
                                                                
                                                                $array_department_id = explode(", ", $cam_department_id);
                                                                $selectDepartment = mysqli_query( $conn,"SELECT ID, title FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title" );
                                                                if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                    while ($rowDept = mysqli_fetch_array($selectDepartment)) {
                                                                        if (in_array($rowDept["ID"], $array_department_id)) {
                                                                            array_push($data_department_id, htmlentities($rowDept["title"] ?? ''));
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
                                                            $selectEmployee = mysqli_query( $conn,"SELECT ID, first_name, last_name FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name" );
                                                            if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                while ($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                    if (in_array($rowEmployee["ID"], $array_employee_id)) {
                                                                        array_push($data_employee_id, htmlentities($rowEmployee["first_name"] ?? '').' '.htmlentities($rowEmployee["last_name"] ?? ''));
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $data_employee_id = implode(", ",$data_employee_id);

                                                        echo '<tr id="tr_cc_'.$cam_ID.'">
                                                            <td>'.$cam_date.'</td>
                                                            <td>'.$cam_ID.'</td>';

                                                            if ($current_client == 0) { echo '<td>'.$cam_reference.'</td>'; }
                                                            
                                                            echo '<td>'.$cam_observed_by.'</td>
                                                            <td>'.$cam_reported_by.'</td>';

                                                            if ($current_client == 1) { echo '<td>'.$data_employee_id.'</td>'; }
                                                            
                                                            echo '<td>'.$data_department_id.'</td>
                                                            <td>'.$cam_description.'</td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-circle">
                                                                    <a href="'.$base_url.'pdf_c?id='.$cam_ID.'&t=2" target="_blank" class="btn btn-info btn-sm">PDF</a>
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
                            
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-dark bold uppercase">MyPro</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover tableData">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>From</th>
                                                <th>Account</th>
                                                <th>Status</th>
                                                <th>Action Item</th>
                                                <th class="text-center">Start Date</th>
                                                <th class="text-center">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $selectData = mysqli_query( $conn,"
                                                    SELECT 
                                                    m.CAI_id AS m_ID,
                                                    m.Parent_MyPro_PK AS m_parent_id,
                                                    u.first_name AS u_first_name,
                                                    u.last_name AS u_last_name,
                                                    m.CAI_filename AS m_title,
                                                    m.CAI_description AS m_description,
                                                    m.CAI_Accounts AS m_accounts,
                                                    m.CIA_progress AS m_status,
                                                    a.Action_Items_name As a_name,
                                                    m.CAI_Action_date AS m_date_start,
                                                    m.CAI_Action_due_date AS m_date_end
                                                    
                                                    FROM tbl_MyProject_Services_Childs_action_Items AS m
                                                    
                                                    LEFT JOIN (
                                                    	SELECT
                                                        *
                                                        FROM tbl_user
                                                    ) AS u
                                                    ON m.CAI_User_PK = u.ID
                                                    
                                                    LEFT JOIN (
                                                    	SELECT
                                                        *
                                                        FROM tbl_MyProject_Services_Action_Items
                                                    ) AS a
                                                    ON m.CAI_Action_taken = a.Action_Items_id
                                                    
                                                    WHERE m.is_deleted = 0
                                                    AND m.CIA_progress < 2
                                                    AND m.CAI_Assign_to = $current_userEmployeeID
                                                " );
                                                if ( mysqli_num_rows($selectData) > 0 ) {
                                                    while ($rowData= mysqli_fetch_array($selectData)) {
                                                        $m_ID = $rowData['m_ID'];
                                                        $m_parent_id = $rowData['m_parent_id'];
                                                        $u_first_name = htmlentities($rowData['u_first_name'] ?? '');
                                                        $u_last_name = htmlentities($rowData['u_last_name'] ?? '');
                                                        $m_title = htmlentities($rowData['m_title'] ?? '');
                                                        $m_description = htmlentities($rowData['m_description'] ?? '');
                                                        $m_accounts = htmlentities($rowData['m_accounts'] ?? '');
                                                        $a_name = htmlentities($rowData['a_name'] ?? '');
                                                        
                                                        $m_status = $rowData['m_status'];
                                                        if ($m_status == 0) {
                                                            $m_status = 'Pending';
                                                        } else if ($m_status == 1) {
                                                            $m_status = 'Inprogress';
                                                        }
                                                        
                                                        $m_date_start = $rowData['m_date_start'];
                                                        $m_date_start = new DateTime($m_date_start);
                                                        $m_date_start = $m_date_start->format('Y-m-d');
                                                        
                                                        $m_date_end = $rowData['m_date_end'];
                                                        $m_date_end = new DateTime($m_date_end);
                                                        $m_date_end = $m_date_end->format('Y-m-d');
                                                        
                                                        echo '<tr>
                                                            <td>
                                                                <a href="#modalGet_child2b" data-toggle="modal" onclick="onclick_2('.$m_ID.')"><strong>'.$m_title.'</strong></a><br>
                                                                '.$m_description.'
                                                            </td>
                                                            <td>'.$u_first_name.' '.$u_last_name.'</td>
                                                            <td>'.$m_accounts.'</td>
                                                            <td>'.$m_status.'</td>
                                                            <td>'.$a_name.'</td>
                                                            <td class="text-center">'.$m_date_start.'</td>
                                                            <td class="text-center">'.$m_date_end.'</td>
                                                        </tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>

                        <!-- Compliance Dashboard Section -->
                        <div class="modal fade" id="modalChanges" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalChanges">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Description</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- RVM Section -->
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Records Verification Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_EForms" id="btnUpdate_EForms" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Job Ticket -->
                        <div class="modal fade bs-modal-lg" id="modalViewJT" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalUpdateJT">
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

                        <!-- FFVA Section -->
                        <div class="modal fade" id="modalViewInt" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewInt">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Internal Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSaveInt_FFVA" id="btnSaveInt_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!--Meeting Minutes Section-->
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
                        
                        <!--MyPro Section-->
                        <div class="modal fade" id="modalGet_child2b" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" class="form-horizontal modalForm modalGet_child2b">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New Action Item</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSubmit_2b" id="btnSubmit_2b" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('.tableData').DataTable({
                    responsive: true,
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
            });
            
            // Compliance Dashboard Section
            function btnChangesView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChanges_Area="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalChanges .modal-body").html(data);
                    }
                });
            }
            $(".modalChanges").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnComment_changes',true);

                var l = Ladda.create(document.querySelector('#btnComment_changes'));
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
                            $('#modalChanges').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // RVM Section
            function changeDepartment(id, modal) {
                if (id.value == "other") {
                    $('#department_id_other_'+modal).show();
                } else {
                    $('#department_id_other_'+modal).hide();
                }
            }
            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Eforms="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        selectMulti();
                    }
                });
            }
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_EForms',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_EForms'));
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
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Job Ticket Section
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
                            // $('#tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been moved to Completed Tab.", "success");
                });
            }
            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Services="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewJT .modal-body").html(data);
                        selectMulti();
                    }
                });
            }
            $(".modalUpdateJT").on('submit',(function(e) {
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
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            $('#modalViewJT').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // FFVA Section
            function selStatus(val) {
                if (val == 2) {
                    $('.intComment').removeClass('hide');
                    $('.intComment textarea').prop('required', true);

                    $('.intVerify').addClass('hide');
                    $('.intVerify select').prop('required', false);
                } else if (val == 1) {
                    $('.intComment').addClass('hide');
                    $('.intComment textarea').prop('required', false);

                    $('.intVerify').removeClass('hide');
                    $('.intVerify select').prop('required', true);
                } else {
                    $('.intComment').addClass('hide');
                    $('.intComment textarea').prop('required', false);

                    $('.intVerify').addClass('hide');
                    $('.intVerify select').prop('required', false);
                }
            }
            function btnInt(id, type, tab) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalInt_FFVA="+id+"&type="+type+"&tab="+tab,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewInt .modal-body").html(data);

                        selectMulti();
                    }
                });
            }
            $(".modalViewInt").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalViewInt') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSaveInt_FFVA',true);

                var l = Ladda.create(document.querySelector('#btnSaveInt_FFVA'));
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
                            $('#modalViewInt').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            
            // Meeting Minutes Section
            function btnMOM(id) {
                $.ajax({
                    type: "GET",
                    url: "meeting_minutes/fetch_minutes.php?GetAI="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modal_update_status .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
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
            
            // CAPAM and Customer Complaint Section
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
                            alert('Close');
                        }
                    });
                    swal("Done!", "This item has been moved to Close", "success");
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
                            alert('Close');
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            
            // MyPro Section
            function onclick_2(id) {
                $.ajax({
                    type: "GET",
                    url: "mypro_function/mypro_action.php?getId_2b="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGet_child2b .modal-body").html(data);
                        $(".modalForm").validate();
                        selectMulti();
                    }
                });
            }
            $(".modalGet_child2b").on('submit',(function(e) {
                e.preventDefault();
                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSubmit_2b',true);
        
                var l = Ladda.create(document.querySelector('#btnSubmit_2b'));
                l.start();
        
                $.ajax({
                    url: "mypro_function/mypro_action.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
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