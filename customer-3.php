<?php 
    $title = "Customer";
    $site = "customer";
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
    @media only screen and (max-width: 600px) {
        .mt-checkbox-list {
            column-count: 1;
        }
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


    <?php 
        if ($current_userEmployerID != 34 AND $current_userEmployerID != 1 AND $current_userEmployerID != 464) {
            echo '.col-sop {
                display: none !important;
            }';
        }
    ?>

    #modalChecklist ul > li:hover,
    #modalChecklistSetting ul > li:hover {
        background: #f7f7f7;
    }
    #modalChecklist ul,
    #modalChecklistSetting ul {
        list-style: none;
        padding: 0;
    }
    #modalChecklist ul li,
    #modalChecklistSetting ul li {
        position: relative;
        padding: 7px 70px;
    }
    #modalChecklist ul li .bootstrap-switch,
    #modalChecklistSetting ul li .bootstrap-switch {
        position: absolute;
        left: 0;
    }
    #modalChecklist ul li .btn-checklist,
    #modalChecklistSetting ul li .btn-checklist {
        position: absolute;
        right: 0;
        top: 7px;
    }
</style>

                    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    				<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    				<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    				<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    				<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    				<script src="https://cdn.amcharts.com/lib/5/plugins/legend.js"></script>
      				<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>


                    <div class="row hide">
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_1">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-green-sharp"><span>0</span></h3>
                                        <small>Total Active Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-following"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success green-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_2">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-red-haze"><span>0</span></h3>
                                        <small>Total Inactive Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-user-unfollow"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success red-haze"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2  counterup_3">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-blue-sharp"><span>0</span></h3>
                                        <small>Current Inactive Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-calendar"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success blue-sharp"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage for this month</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-stat2 counterup_4">
                                <div class="display" style="position: relative;">
                                    <div class="number">
                                        <h3 class="font-purple-soft"><span>0</span></h3>
                                        <small>Total Customer</small>
                                    </div>
                                    <div class="icon" style="position: absolute; right: 0;"><i class="icon-users"></i></div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span class="progress-bar progress-bar-success purple-soft"></span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title">percentage</div><div class="status-number">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <span class="icon-users font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">List of Customers</span>
                                        <?php
                                            // if($current_client == 0) {
                                            //     // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $switch_user_id OR user_id = 163)");
                                            //     $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                            //     while ($row = mysqli_fetch_assoc($result)) {
                                            //         $type_id = $row["type"];
                                            //         $file_title = $row["file_title"];
                                            //         $video_url = $row["youtube_link"];
                                                    
                                            //         $file_upload = $row["file_upload"];
                                            //         if (!empty($file_upload)) {
                                        	   //         $fileExtension = fileExtension($file_upload);
                                        				// $src = $fileExtension['src'];
                                        				// $embed = $fileExtension['embed'];
                                        				// $type = $fileExtension['type'];
                                        				// $file_extension = $fileExtension['file_extension'];
                                        	   //         $url = $base_url.'uploads/instruction/';
                                        
                                            //     		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                            //         }
                                                    
                                            //         $icon = $row["icon"];
                                            //         if (!empty($icon)) { 
                                            //             if ($type_id == 0) {
                                            //                 echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             } else {
                                            //                 echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             }
                                            //         }
	                                           // }
                                            // }
                                        ?>
                                    </div>
                                    
                                    <?php
                                        if ($current_userInvited == 0 OR $current_userEmployeeID > 0) {
                                            echo '<div class="actions">';
                                            
                                                if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                    echo '<div class="btn-group">
                                                        <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a data-toggle="modal" href="#modalNew" onclick="btnReset(\'modalNew\')">Add New Customer</a>
                                                            </li>';
                                                            
                                                            if($switch_user_id == 185 OR $switch_user_id == 1  OR $switch_user_id == 163) {
                                                                echo '<li>
                                                                    <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                                </li>';
                                                            }
                                                            
                                                            echo '<li class="pictogram-align-between">
                                                                <a href="#modalReport" data-toggle="modal" onclick="btnReport(2)">Report</a>';
                                                                
                                                                $pictogram = 'cus_report';
                                                                if ($switch_user_id == 163) {
                                                                    echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                                } else {
                                                                    $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                                    if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                        $row = mysqli_fetch_array($selectPictogram);
                
                                                                        $files = '';
                                                                        $type = 'iframe';
                                                                        if (!empty($row["files"])) {
                                                                            $arr_filename = explode(' | ', $row["files"]);
                                                                            $arr_filetype = explode(' | ', $row["filetype"]);
                                                                            $str_filename = '';
                
                                                                            foreach($arr_filename as $val_filename) {
                                                                                $str_filename = $val_filename;
                                                                            }
                                                                            foreach($arr_filetype as $val_filetype) {
                                                                                $str_filetype = $val_filetype;
                                                                            }
                
                                                                            $files = $row["files"];
                                                                            if ($row["filetype"] == 1) {
                                                                                $fileExtension = fileExtension($files);
                                                                                $src = $fileExtension['src'];
                                                                                $embed = $fileExtension['embed'];
                                                                                $type = $fileExtension['type'];
                                                                                $file_extension = $fileExtension['file_extension'];
                                                                                $url = $base_url.'uploads/pictogram/';
                
                                                                                $files = $src.$url.rawurlencode($files).$embed;
                                                                            } else if ($row["filetype"] == 3) {
                                                                                $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                            }
                                                                        }
                
                                                                        if (!empty($files)) {
                                                                            echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                        }
                                                                    }
                                                                }
                                                                    
                                                            echo '</li>
                                                        </ul>
                                                    </div>';
                                                }
                                                
                                            echo '</div>
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tab_actions_sent" data-toggle="tab">Sent</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_actions_received" data-toggle="tab">Received</a>
                                                </li>';
                                                
                                                if ($current_client == 0) {
                                                    echo '<li>
                                                        <a href="#tab_actions_template" data-toggle="tab">Setting</a>
                                                    </li>';
                                                }
                                               
                                               echo '<li>
        											<a href="#tab_customer_analytics" data-toggle="tab">Analytics</a>
        									   </li>
                                            </ul>';
                                        }
                                    ?>
                                </div>
                                <div class="portlet-body">
                                    <?php
                                        $rowID = 0;
                                        if ($current_userInvited == 0 OR $current_userEmployeeID > 0) {
                                            echo '<div class="tab-content">
                                                <div class="tab-pane active" id="tab_actions_sent">
                                                    <table class="table table-bordered table-hover" id="tableData_1">
                                                        <thead>
                                                            <tr>
                                                                <!--<th rowspan="2" class="hide">ID#</th>-->
                                                                <th rowspan="2">Customer Name</th>
                                                                <th rowspan="2">Category</th>
                                                                <th rowspan="2">Products/Services</th>
                                                                <th rowspan="2">Address</th>
                                                                <th colspan="3" class="text-center">Contact Details</th>
                                                                <!--<th rowspan="2" style="width: 155px;" class="text-center hide">Annual Review Due</th>-->
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                                <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Address</th>
                                                                <th>Contact Info</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                        
                                                            $sql_s1 = '';
                                                            $sql_s2 = '';
                                                            if ($current_userEmployerID != 34) {
                                                                $sql_s1 = ' AND s1.facility = 0 ';
                                                                $sql_s2 = ' AND s2.facility = 0 ';
                                                            }
                                                            $result = mysqli_query( $conn,"
                                                                WITH RECURSIVE cte (s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, checked_percentage) AS
                                                                (
                                                                    SELECT
                                                                    s1.ID AS s_ID,
                                                                    s1.name AS s_name,
                                                                    s1.reviewed_due AS s_reviewed_due,
                                                                    s1.status AS s_status,
                                                                    s1.material AS s_material,
                                                                    s1.service AS s_service,
                                                                    s1.address AS s_address,
                                                                    s1.category AS s_category,
                                                                    s1.contact AS s_contact,
                                                                    s1.document AS s_document,
                                                                    d1.ID AS d_ID,
                                                                    d1.type AS d_type,
                                                                    d1.name AS d_name,
                                                                    d1.file AS d_file,
                                                                    d1.file_due AS d_file_due,
                                                                    CASE 
                                                                        WHEN 
                                                                            LENGTH(d1.file) > 0 
                                                                            AND (STR_TO_DATE(d1.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d1.file_due) > CURDATE())
                                                                            AND d1.reviewed_by > 0
                                                                            AND d1.approved_by > 0
                                                                        THEN 1 
                                                                        ELSE 0 
                                                                    END AS d_status,
                                                                    CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                    ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage
    
                                                                    FROM tbl_supplier AS s1
    
                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        * 
                                                                        FROM tbl_supplier_document 
                                                                        WHERE type = 0
                                                                        AND ID IN (
                                                                            SELECT
                                                                            MAX(ID)
                                                                            FROM tbl_supplier_document
                                                                            WHERE type = 0
                                                                            GROUP BY name, supplier_id
                                                                        )
                                                                    ) AS d1
                                                                    ON s1.ID = d1.supplier_ID
                                                                    AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist
                                                                        WHERE deleted = 0 
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d1.name
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d1.ID

                                                                    WHERE s1.page = 2
                                                                    AND s1.is_deleted = 0 
                                                                    AND s1.user_id = $switch_user_id
                                                                    AND s1.facility_switch = $facility_switch_user_id
                                                                    $sql_s1
    
                                                                    GROUP BY s1.ID, d1.ID
                                                                    
                                                                    UNION ALL
                                                                    
                                                                    SELECT
                                                                    s2.ID AS s_ID,
                                                                    s2.name AS s_name,
                                                                    s2.reviewed_due AS s_reviewed_due,
                                                                    s2.status AS s_status,
                                                                    s2.material AS s_material,
                                                                    s2.service AS s_service,
                                                                    s2.address AS s_address,
                                                                    s2.category AS s_category,
                                                                    s2.contact AS s_contact,
                                                                    s2.document_other AS s_document,
                                                                    d2.ID AS d_ID,
                                                                    d2.type AS d_type,
                                                                    d2.name AS d_name,
                                                                    d2.file AS d_file,
                                                                    d2.file_due AS d_file_due,
                                                                    CASE 
                                                                        WHEN 
                                                                            LENGTH(d2.file) > 0 
                                                                            AND (STR_TO_DATE(d2.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d2.file_due) > CURDATE())
                                                                            AND d2.reviewed_by > 0
                                                                            AND d2.approved_by > 0
                                                                        THEN 1 
                                                                        ELSE 0 
                                                                    END AS d_status,
                                                                    CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                    ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage
    
                                                                    FROM tbl_supplier AS s2
    
                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        * 
                                                                        FROM tbl_supplier_document 
                                                                        WHERE type = 1
                                                                        AND ID IN (
                                                                            SELECT
                                                                            MAX(ID)
                                                                            FROM tbl_supplier_document
                                                                            WHERE type = 1
                                                                            GROUP BY name, supplier_id
                                                                        )
                                                                    ) AS d2
                                                                    ON s2.ID = d2.supplier_ID
        															AND FIND_IN_SET(REPLACE(d2.name, ', ', ' / '), REPLACE(REPLACE(s2.document_other, ', ', ' / '), ' | ',','  )  ) > 0

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist
                                                                        WHERE deleted = 0 
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d2.ID
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d2.ID

                                                                    WHERE s2.page = 2
                                                                    AND s2.is_deleted = 0 
                                                                    AND s2.user_id = $switch_user_id
                                                                    AND s2.facility_switch = $facility_switch_user_id
                                                                    $sql_s2
    
                                                                    GROUP BY s2.ID, d2.ID
                                                                )
                                                                SELECT
                                                                s_ID,
                                                                s_name,
                                                                s_reviewed_due,
                                                                s_status,
                                                                s_material,
                                                                s_service, 
                                                                s_address, 
                                                                s_category,
                                                                c_name,
                                                                d_compliance,
                                                                d_counting,
                                                                d_percentage,
                                                                cn.name AS cn_name,
                                                                cn.address AS cn_address,
                                                                cn.email AS cn_email,
                                                                cn.phone AS cn_phone,
                                                                cn.cell AS cn_cell,
                                                                cn.fax AS cn_fax
                                                                FROM (
                                                                    SELECT 
                                                                    s_ID, 
                                                                    s_name, 
                                                                    s_reviewed_due, 
                                                                    s_status, 
                                                                    s_material,
                                                                    s_service, 
                                                                    s_address, 
                                                                    s_contact,
                                                                    s_category,
                                                                    c.name AS c_name,
                                                                    -- s_document, 
                                                                    -- d_ID, 
                                                                    -- d_type, 
                                                                    -- d_name, 
                                                                    -- d_file, 
                                                                    -- d_file_due, 
                                                                    -- d_status,
                                                                    -- d_count,
                                                                    SUM(d_status) AS d_compliance,
                                                                    SUM(d_count) AS d_counting,
                                                                    ROUND(CASE WHEN SUM(d_count) > 0 THEN (SUM(checked_percentage) / SUM(d_count)) * 100 ELSE 0 END) AS d_percentage
                                                                    FROM cte
    
                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_category
                                                                        WHERE deleted = 0
                                                                    ) AS c
                                                                    ON s_category = c.ID
    
                                                                    GROUP BY s_ID
                                                                ) AS r
    
                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_contact
                                                                ) AS cn
                                                                ON FIND_IN_SET(cn.ID, REPLACE(s_contact, ' ', '')) > 0
    
                                                                GROUP BY s_ID
    
                                                                ORDER BY s_name
                                                            " );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $s_ID = $row["s_ID"];
                                                                    $s_name = htmlentities($row["s_name"] ?? '');
                                                                    $s_reviewed_due = $row["s_reviewed_due"];
    
                                                                    $s_category = htmlentities($row["s_category"] ?? '');
                                                                    $c_name = htmlentities($row["c_name"] ?? '');
    
                                                                    $cn_name = htmlentities($row["cn_name"] ?? '');
                                                                    $cn_address = htmlentities($row["cn_address"] ?? '');
                                                                    $cn_email = htmlentities($row["cn_email"] ?? '');
                                                                    $cn_phone = htmlentities($row["cn_phone"] ?? '');
                                                                    $cn_cell = htmlentities($row["cn_cell"] ?? '');
                                                                    $cn_fax = htmlentities($row["cn_fax"] ?? '');
    
                                                                    $compliance = 0;
                                                                    // if ($switch_user_id == 1684) {
                                                                    //     $d_compliance = $row["d_compliance"];
                                                                    //     $d_counting = $row["d_counting"];
                                                                    //     if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }
                                                                    // } else {
                                                                        $compliance = $row["d_percentage"];
                                                                    // }
    
                                                                    $s_status = $row["s_status"];
                                                                    $status_type = array(
                                                                        0 => 'Pending',
    																	1 => 'Active',
    																	2 => 'Inactive'
                                                                    );
    
                                                                    if ($s_category == "3") {
                                                                        $material = $row["s_service"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"
                                                                                    SELECT
                                                                                    c.service_category AS c_service_category
                                                                                    FROM tbl_supplier_service AS s
    
                                                                                    LEFT JOIN (
                                                                                        SELECT
                                                                                        *
                                                                                        FROM tbl_service_category
                                                                                    ) AS c
                                                                                    ON s.service_name = c.id
                                                                                    WHERE s.ID = $value
                                                                                " );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                array_push($material_result, $rowMaterial['c_service_category']);
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    } else {
                                                                        $material = $row["s_material"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"
                                                                                    SELECT
                                                                                    p.name AS p_name
                                                                                    FROM tbl_supplier_material  AS m
    
                                                                                    LEFT JOIN (
                                                                                        SELECT 
                                                                                        * 
                                                                                        FROM tbl_products
                                                                                    ) AS p
                                                                                    ON m.material_name = p.ID
                                                                                    WHERE m.ID = $value
                                                                                " );
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                if (!is_null($rowMaterial) && isset($rowMaterial['p_name'])) {
                                                                                    array_push($material_result, $rowMaterial['p_name']);
                                                                                }
                                                                                
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    }
        																
    																$address_array = array();
    																$address_arr = htmlentities($row["s_address"] ?? '');
    																$address_arr_country = '';
    																if (!empty($address_arr)) {
    																	if (str_contains($address_arr, '|')) {
        													            	$address_arr = explode(" | ", $address_arr);
        													            	
            													            array_push($address_array, htmlentities($address_arr[1]));
            													            array_push($address_array, htmlentities($address_arr[2]));
            													            array_push($address_array, htmlentities($address_arr[3]));
            													            array_push($address_array, $address_arr[0]);
            													            array_push($address_array, $address_arr[4]);
            													            $address_arr_country = $address_arr[0];
            													            $address_arr = implode(", ", $address_array);
    																	} else if (str_contains($address_arr, ',')) {
        													                if (count(explode(", ", $address_arr)) == 5) {
        													                	$address_arr = explode(", ", $address_arr);
                													            array_push($address_array, htmlentities($address_arr[1]));
                													            array_push($address_array, htmlentities($address_arr[2]));
                													            array_push($address_array, htmlentities($address_arr[3]));
                													            array_push($address_array, $address_arr[0]);
                													            array_push($address_array, $address_arr[4]);
                													            $address_arr_country = $address_arr[0];
                													            $address_arr = implode(", ", $address_array);
        													                }
    																	}
    																}
    
                                                                    echo '<tr id="tr_'.$s_ID.'">';
                                                                        // <td class="hide">'.$s_ID.'</td>
                                                                        // echo '<td>'.htmlentities($s_name ?? '').'</td>
                                                                        echo '<td>'.htmlentities($s_name,ENT_COMPAT,'UTF-8',false).'</td>
                                                                        <td>'.htmlentities($c_name ?? '').'</td>
                                                                        <td>'.$material.'</td>
                                                                        <td>'.$address_arr.'</td>
                                                                        <td>'.htmlentities($cn_name ?? '').'</td>
                                                                        <td>'.htmlentities($cn_address ?? '').'</td>
                                                                        <td class="text-center">
                                                                            <ul class="list-inline">';
                                                                            if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                                            if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                                            if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                                            if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                                            echo '</ul>
                                                                        </td>';
                                                                        // <td class="text-center hide">'.$s_reviewed_due.'</td>
                                                                        echo '<td class="text-center">'.round($compliance).'%</td>
                                                                        <td class="text-center">'.$status_type[$s_status].'</td>
                                                                        <td class="text-center">';
                                                                        
                                                                            if (empty($current_permission_array_key) OR in_array(5, $permission)) {
                                                                                echo '<a href="#modalView" class="btn btn-outline dark btn-xs btnView" data-toggle="modal" onclick="btnView('. $s_ID .')"><i class="fa fa-fw fa-pencil"></i></a>';
                                                                            }
                                                                            
                                                                            echo '<a href="#modalChart" class="btn btn-info btn-xs btnChart" data-toggle="modal" data-id="'. $s_ID .'"><i class="fas fa-fw fa-chart-line"></i></a>';
                                                                            
                                                                            if (empty($current_permission_array_key) OR in_array(6, $permission)) {
                                                                                echo '<a href="javascript:;" class="btn btn-danger btn-xs btnDelete" onclick="btnDelete('. $s_ID .')"><i class="fa fa-fw fa-trash"></i></a>';
                                                                            }
                                                                                
                                                                        echo '</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                                
                                                        echo '</tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tab_actions_received">
                                                    <table class="table table-bordered table-hover" id="tableData_2">
                                                        <thead>
                                                            <tr>
                                                                <!--<th rowspan="2" class="hide">ID#</th>-->
                                                                <th rowspan="2">Customer Name</th>
                                                                <th rowspan="2">Category</th>
                                                                <th rowspan="2">Products/Services</th>
                                                                <th rowspan="2">Address</th>
                                                                <th colspan="3" class="text-center">Contact Details</th>
                                                                <!--<th rowspan="2" style="width: 155px;" class="text-center hide">Annual Review Due</th>-->
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                                <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Address</th>
                                                                <th>Contact Info</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                    
                                                            $result = mysqli_query( $conn,"
                                                                WITH RECURSIVE cte (s_ID, s_user_id, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, checked_percentage) AS
    															(
    															    SELECT
    															    s1.ID AS s_ID,
    															    s1.user_id AS s_user_id,
    															    s1.name AS s_name,
    															    s1.reviewed_due AS s_reviewed_due,
    															    s1.status AS s_status,
    															    s1.material AS s_material,
    															    s1.service AS s_service,
                                                                    s1.address AS s_address,
    															    s1.category AS s_category,
    															    s1.contact AS s_contact,
    															    s1.document AS s_document,
    															    d1.ID AS d_ID,
    															    d1.type AS d_type,
    															    d1.name AS d_name,
    															    d1.file AS d_file,
    															    d1.file_due AS d_file_due,
    															    CASE 
    															        WHEN 
    															            LENGTH(d1.file) > 0 
    															            AND (STR_TO_DATE(d1.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d1.file_due) > CURDATE())
    															            AND d1.reviewed_by > 0
    															            AND d1.approved_by > 0
    															        THEN 1 
    															        ELSE 0 
    															    END AS d_status,
    															    CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                    ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage
    
    															    FROM tbl_supplier AS s1
    
    															    LEFT JOIN (
    															        SELECT
    															        * 
    															        FROM tbl_supplier_document 
    															        WHERE type = 0
    															        AND ID IN (
    															            SELECT
    															            MAX(ID)
    															            FROM tbl_supplier_document
    															            WHERE type = 0
    															            GROUP BY name, supplier_id
    															        )
    															    ) AS d1
    															    ON s1.ID = d1.supplier_ID
    															    AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist
                                                                        WHERE deleted = 0 
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d1.name
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d1.ID

    															    WHERE s1.page = 1
    															    AND s1.is_deleted = 0 
    															    AND s1.email = '".$current_userEmail."'
                                                                    AND s1.facility_switch = $facility_switch_user_id
    															    $sql_s1

                                                                    GROUP BY s1.ID, d1.ID
    															    
    															    UNION ALL
    															    
    															    
    															    SELECT
    															    s2.ID AS s_ID,
    															    s2.user_id AS s_user_id,
    															    s2.name AS s_name,
    															    s2.reviewed_due AS s_reviewed_due,
    															    s2.status AS s_status,
    															    s2.material AS s_material,
    															    s2.service AS s_service,
                                                                    s2.address AS s_address,
    															    s2.category AS s_category,
    															    s2.contact AS s_contact,
    															    s2.document_other AS s_document,
    															    d2.ID AS d_ID,
    															    d2.type AS d_type,
    															    d2.name AS d_name,
    															    d2.file AS d_file,
    															    d2.file_due AS d_file_due,
    															    CASE 
    															        WHEN 
    															            LENGTH(d2.file) > 0 
    															            AND (STR_TO_DATE(d2.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d2.file_due) > CURDATE())
    															            AND d2.reviewed_by > 0
    															            AND d2.approved_by > 0
    															        THEN 1 
    															        ELSE 0 
    															    END AS d_status,
    															    CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                    ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage
    
    															    FROM tbl_supplier AS s2
    
    															    LEFT JOIN (
    															        SELECT
    															        * 
    															        FROM tbl_supplier_document 
    															        WHERE type = 1
    															        AND ID IN (
    															            SELECT
    															            MAX(ID)
    															            FROM tbl_supplier_document
    															            WHERE type = 1
    															            GROUP BY name, supplier_id
    															        )
    															    ) AS d2
    															    ON s2.ID = d2.supplier_ID
        															AND FIND_IN_SET(REPLACE(d2.name, ', ', ' / '), REPLACE(REPLACE(s2.document_other, ', ', ' / '), ' | ',','  )  ) > 0

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist
                                                                        WHERE deleted = 0 
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d2.ID
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d2.ID

    															    WHERE s2.page = 1
    															    AND s2.is_deleted = 0 
    															    AND s2.email = '".$current_userEmail."'
                                                                    AND s2.facility_switch = $facility_switch_user_id
    															    $sql_s2

                                                                    GROUP BY s2.ID, d2.ID
    															)
    															SELECT
    															s_ID,
    															s_e_name,
    															s_name,
    															s_reviewed_due,
    															s_status,
    															s_material,
    															s_service, 
    															s_address, 
    															s_category,
    															c_name,
    															d_compliance,
    															d_counting,
                                                                d_percentage,
    															cn.name AS cn_name,
    															cn.address AS cn_address,
    															cn.email AS cn_email,
    															cn.phone AS cn_phone,
    															cn.cell AS cn_cell,
    															cn.fax AS cn_fax
    															FROM (
    															    SELECT 
    															    s_ID,
    															    s_user_id,
    															    e.businessname AS s_e_name,
    															    s_name, 
    															    s_reviewed_due, 
    															    s_status, 
    																s_material,
    																s_service, 
    																s_address, 
    															    s_contact,
    															    s_category,
    															    c.name AS c_name,
    															    -- s_document, 
    															    -- d_ID, 
    															    -- d_type, 
    															    -- d_name, 
    															    -- d_file, 
    															    -- d_file_due, 
    															    -- d_status,
    															    -- d_count,
    															    SUM(d_status) AS d_compliance,
    															    SUM(d_count) AS d_counting,
                                                                    ROUND(CASE WHEN SUM(d_count) > 0 THEN (SUM(checked_percentage) / SUM(d_count)) * 100 ELSE 0 END) AS d_percentage
    															    FROM cte
    
    															    LEFT JOIN (
    															        SELECT
    															        *
    															        FROM tbl_supplier_category
    															        WHERE deleted = 0
    															    ) AS c
    															    ON s_category = c.ID
    															    
    															    LEFT JOIN (
    															        SELECT
    															        *
    															        FROM tblEnterpiseDetails
    															    ) AS e
    															    ON s_user_id = e.users_entities
    															    
    															    GROUP BY s_ID
    															) AS r
    
    															LEFT JOIN (
    															    SELECT
    															    *
    															    FROM tbl_supplier_contact
    															) AS cn
    															ON FIND_IN_SET(cn.ID, REPLACE(s_contact, ' ', '')) > 0
    
    															GROUP BY s_ID
    
    															ORDER BY s_name
    														" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $s_ID = $row["s_ID"];
                                                                    $s_name = htmlentities($row["s_e_name"] ?? '');
                                                                    $s_reviewed_due = $row["s_reviewed_due"];
    
                                                                    $s_category = htmlentities($row["s_category"] ?? '');
                                                                    $c_name = htmlentities($row["c_name"] ?? '');
    
                                                                    $cn_name = htmlentities($row["cn_name"] ?? '');
                                                                    $cn_address = htmlentities($row["cn_address"] ?? '');
                                                                    $cn_email = htmlentities($row["cn_email"] ?? '');
                                                                    $cn_phone = htmlentities($row["cn_phone"] ?? '');
                                                                    $cn_cell = htmlentities($row["cn_cell"] ?? '');
                                                                    $cn_fax = htmlentities($row["cn_fax"] ?? '');
    
                                                                    $compliance = 0;
                                                                    // if ($switch_user_id == 1684) {
                                                                    //     $d_compliance = $row["d_compliance"];
                                                                    //     $d_counting = $row["d_counting"];
                                                                    //     if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }
                                                                    // } else {
                                                                        $compliance = $row["d_percentage"];
                                                                    // }
    
                                                                    $s_status = $row["s_status"];
                                                                    $status_type = array(
                                                                        0 => 'Pending',
                                                                        1 => 'Approved',
                                                                        2 => 'Non Approved',
                                                                        3 => 'Emergency Use Only',
                                                                        4 => 'Do Not Use',
    																	5 => 'Active',
    																	6 => 'Inactive'
                                                                    );
    
                                                                    if ($s_category == "3") {
                                                                        $material = $row["s_service"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
                                                                                if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                                                                    $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                    array_push($material_result, $rowMaterial['service_name']);
                                                                                }
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    } else {
                                                                        $material = $row["s_material"];
                                                                        if (!empty($material)) {
                                                                            $material_result = array();
                                                                            $material_arr = explode(", ", $material);
                                                                            foreach ($material_arr as $value) {
                                                                                $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
                                                                                if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                                                                    $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                    array_push($material_result, $rowMaterial['material_name']);
                                                                                }
                                                                            }
                                                                            $material = implode(', ', $material_result);
                                                                        }
                                                                    }
        																
    																$address_array = array();
    																$address_arr = htmlentities($row["s_address"] ?? '');
    																$address_arr_country = '';
    																if (!empty($address_arr)) {
    																	if (str_contains($address_arr, '|')) {
        													            	$address_arr = explode(" | ", $address_arr);
        													            	
            													            array_push($address_array, htmlentities($address_arr[1]));
            													            array_push($address_array, htmlentities($address_arr[2]));
            													            array_push($address_array, htmlentities($address_arr[3]));
            													            array_push($address_array, $address_arr[0]);
            													            array_push($address_array, $address_arr[4]);
            													            $address_arr_country = $address_arr[0];
            													            $address_arr = implode(", ", $address_array);
    																	} else if (str_contains($address_arr, ',')) {
        													                if (count(explode(", ", $address_arr)) == 5) {
        													                	$address_arr = explode(", ", $address_arr); 
                													            array_push($address_array, htmlentities($address_arr[1]));
                													            array_push($address_array, htmlentities($address_arr[2]));
                													            array_push($address_array, htmlentities($address_arr[3]));
                													            array_push($address_array, $address_arr[0]);
                													            array_push($address_array, $address_arr[4]);
                													            $address_arr_country = $address_arr[0];
                													            $address_arr = implode(", ", $address_array);
        													                }
    																	}
    																}
    
                                                                    echo '<tr id="tr_'.$s_ID.'">';
                                                                        // <td class="hide">'.$s_ID.'</td>
                                                                        // echo '<td>'.htmlentities($s_name ?? '').'</td>
                                                                        echo '<td>'.htmlentities($s_name,ENT_COMPAT,'UTF-8',false).'</td>
                                                                        <td>'.htmlentities($c_name ?? '').'</td>
                                                                        <td>'.$material.'</td>
                                                                        <td>'.$address_arr.'</td>
                                                                        <td>'.htmlentities($cn_name ?? '').'</td>
                                                                        <td>'.htmlentities($cn_address ?? '').'</td>
                                                                        <td class="text-center">
                                                                            <ul class="list-inline">';
                                                                            if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                                            if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                                            if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                                            if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                                            echo '</ul>
                                                                        </td>';
                                                                        // <td class="text-center hide">'.$s_reviewed_due.'</td>
                                                                        echo '<td class="text-center">'.round($compliance).'%</td>
                                                                        <td class="text-center">'.$status_type[$s_status].'</td>
                                                                        <td class="text-center">';
                                                                        
                                                                            if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                                echo '<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>';
                                                                            }
                                                                            
                                                                        echo '</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                                
                                                        echo '</tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tab_actions_template">';
                                            
                                                    $pictogram = 'cus_template';
                                                    if ($switch_user_id == 163) {
                                                        echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                    } else {
                                                        $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                        if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                            $row = mysqli_fetch_array($selectPictogram);
    
                                                            $files = '';
                                                            $type = 'iframe';
                                                            if (!empty($row["files"])) {
                                                                $arr_filename = explode(' | ', $row["files"]);
                                                                $arr_filetype = explode(' | ', $row["filetype"]);
                                                                $str_filename = '';
    
                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }
    
                                                                $files = $row["files"];
                                                                if ($row["filetype"] == 1) {
                                                                    $fileExtension = fileExtension($files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/pictogram/';
    
                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                } else if ($row["filetype"] == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                }
                                                            }
    
                                                            if (!empty($files)) {
                                                                echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                            }
                                                        }
                                                    }

                                                    $setting_facility = '';
                                                    $setting_material = '';
                                                    $result = mysqli_query( $conn,"
                                                        SELECT
                                                        r.ID,
                                                        r.name,
                                                        r.req,
                                                        r.accounts,
                                                        r.materials,
                                                        COUNT(cl.ID) AS count_cl
                                                        FROM tbl_supplier_requirement AS r

                                                        LEFT JOIN (
                                                            SELECT ID, requirement_id, user_id FROM tbl_supplier_checklist
                                                            WHERE deleted = 0 AND type = 0
                                                        ) AS cl
                                                        ON cl.requirement_id = r.ID
                                                        AND cl.user_id = $switch_user_id

                                                        WHERE r.deleted = 0 
                                                        AND r.organic = 0 
                                                        AND (FIND_IN_SET($switch_user_id, REPLACE(r.facility , ' ', '')) OR r.facility = 0  OR r.facility = -1 OR FIND_IN_SET($switch_user_id, REPLACE(r.materials , ' ', '')) OR r.materials = 0 OR r.materials = -2 OR r.materials = -1) 

                                                        GROUP BY r.ID

                                                        ORDER BY r.name
                                                    " );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = $row["ID"];
                                                            $setting_tr = '';

                                                            $name = htmlentities($row["name"] ?? '');
                                                            if ($switch_user_id == 1486 AND !empty($row["req"])) {
                                                                $name = htmlentities($row["req"] ?? '');
                                                            }

                                                            $setting_tr .= '<tr id="tr_'.$ID.'">
                                                                <td>'.$name.'</td>
                                                                <td class="text-center">';

                                                                    $selectSOP = mysqli_query( $conn,"SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $switch_user_id AND requirement_id = $ID" );
                                                                    if ( mysqli_num_rows($selectSOP) > 0 ) {
                                                                        $rowSOP = mysqli_fetch_array($selectSOP);
                                                                        $sop_ID = $rowSOP["ID"];
                                                                        $sop_file = $rowSOP["file"];

                                                                        $type = 'iframe';
                                                                        $filetype = $rowSOP["filetype"];
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($sop_file);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/supplier/';

                                                                            $sop_file = $src.$url.rawurlencode($sop_file).$embed;
                                                                        } else {
                                                                            $sop_file = preg_replace('#[^/]*$#', '', $sop_file).'preview';
                                                                        }

                                                                        $setting_tr .= '<a href="'.$sop_file.'" data-src="'.$sop_file.'" data-fancybox data-type="'.$type.'" class="btn btn-xs btn-info"><i class="fa fa-search"></i></a>';

                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalSOP" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnSOP('.$ID.', '.$sop_ID.', '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                        if (empty($current_permission_array_key) OR in_array(6, $permission)) {
                                                                            $setting_tr .= '<a href="javascript:;" data-type="'.$type.'" class="btn btn-xs btn-danger" onclick="btnSOP_delete('.$ID.', '.$sop_ID.', this)"><i class="fa fa-trash"></i></a>';
                                                                        }
                                                                    } else {
                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalSOP" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnSOP('.$ID.', 0, '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                    }
                                                                $setting_tr .= '</td>
                                                                <td class="text-center">';

                                                                    $selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $switch_user_id AND requirement_id = $ID" );
                                                                    if ( mysqli_num_rows($selectInfo) > 0 ) {
                                                                        $rowInfo = mysqli_fetch_array($selectInfo);
                                                                        $info_ID = $rowInfo["ID"];
                                                                        $info_file = $rowInfo["file"];

                                                                        $type = 'iframe';
                                                                        $filetype = $rowInfo["filetype"];
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($info_file);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/supplier/';

                                                                            $info_file = $src.$url.rawurlencode($info_file).$embed;
                                                                        } else {
                                                                            $info_file = preg_replace('#[^/]*$#', '', $info_file).'preview';
                                                                        }

                                                                        $setting_tr .= '<a href="'.$info_file.'" data-src="'.$info_file.'" data-fancybox data-type="'.$type.'" class="btn btn-xs btn-info"><i class="fa fa-search"></i></a>';

                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalInfo" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnInfo('.$ID.', '.$info_ID.', '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                        if (empty($current_permission_array_key) OR in_array(6, $permission)) {
                                                                            $setting_tr .= '<a href="javascript:;" data-type="'.$type.'" class="btn btn-xs btn-danger" onclick="btnInfo_delete('.$ID.', '.$info_ID.', this)"><i class="fa fa-trash"></i></a>';
                                                                        }
                                                                    } else {
                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalInfo" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnInfo('.$ID.', 0, '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                    }
                                                                $setting_tr .= '</td>
                                                                <td class="text-center">';

                                                                    $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE deleted = 0 AND user_id = $switch_user_id AND requirement_id = $ID" );
                                                                    if ( mysqli_num_rows($selectTemplate) > 0 ) {
                                                                        $rowTemplate = mysqli_fetch_array($selectTemplate);
                                                                        $temp_ID = $rowTemplate["ID"];
                                                                        $temp_file = $rowTemplate["file"];

                                                                        $type = 'iframe';
                                                                        $filetype = $rowTemplate["filetype"];
                                                                        if ($filetype == 1) {
                                                                            $fileExtension = fileExtension($temp_file);
                                                                            $src = $fileExtension['src'];
                                                                            $embed = $fileExtension['embed'];
                                                                            $type = $fileExtension['type'];
                                                                            $file_extension = $fileExtension['file_extension'];
                                                                            $url = $base_url.'uploads/supplier/';

                                                                            $temp_file = $src.$url.rawurlencode($temp_file).$embed;
                                                                        } else {
                                                                            $temp_file = preg_replace('#[^/]*$#', '', $temp_file).'preview';
                                                                        }

                                                                        $setting_tr .= '<a href="'.$temp_file.'" data-src="'.$temp_file.'" data-fancybox data-type="'.$type.'" class="btn btn-xs btn-info"><i class="fa fa-search"></i></a>';

                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('.$ID.', '.$temp_ID.', '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                        if (empty($current_permission_array_key) OR in_array(6, $permission)) {
                                                                            $setting_tr .= '<a href="javascript:;" data-type="'.$type.'" class="btn btn-xs btn-danger" onclick="btnTemplate_delete('.$ID.', '.$temp_ID.', this)"><i class="fa fa-trash"></i></a>';
                                                                        }
                                                                    } else {
                                                                        if (empty($current_permission_array_key) OR in_array(2, $permission)) {
                                                                            $setting_tr .= '<a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('.$ID.', 0, '; $setting_tr .= (!empty($row["materials"]) OR $row["materials"] != '') ? 2:1; $setting_tr .= ')"><i class="fa fa-cloud-upload"></i></a>';
                                                                        }
                                                                    }
                                                                $setting_tr .= '</td>
                                                                <td class="text-center">
                                                                    <a href="#modalChecklistSetting" class="btn btn-xs '; $setting_tr .= $row["count_cl"] > 0 ? 'btn-success':'btn-outline dark'; $setting_tr .= '" data-toggle="modal" onclick="btnChecklistSetting('.$ID.', '.$switch_user_id.')"><i class="fa fa-list-ul"></i></a>
                                                                </td>
                                                            </tr>';

                                                            if (!empty($row["materials"]) OR $row["materials"] != '') {
                                                                $setting_material .= $setting_tr;
                                                            } else {
                                                                $setting_facility .= $setting_tr;
                                                            }
                                                        }
                                                    }

                                                    echo '<ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#template_1" data-toggle="tab" aria-expanded="true" style="">Facility</a>
                                                        </li>
                                                        <li class="">
                                                            <a href="#template_2" data-toggle="tab" aria-expanded="false" style="">Material</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="template_1">
                                                            <div class="table-scrollable">
                                                                <table class="table table-bordered table-hover" id="tableData_facility">
                                                                    <thead>
                                                                        <tr class="bg-primary">
                                                                            <th>Requirement</th>
                                                                            <th class="text-center" style="width: 120px;">SOP</th>
                                                                            <th class="text-center" style="width: 120px;">Info</th>
                                                                            <th class="text-center" style="width: 120px;">Template</th>
                                                                            <th class="text-center" style="width: 120px;">Checklist</th>
                                                                        </tr>
                                                                    </thead>'.$setting_facility.'</tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="template_2">
                                                            <div class="table-scrollable">
                                                                <table class="table table-bordered table-hover" id="tableData_material">
                                                                    <thead>
                                                                        <tr class="bg-primary">
                                                                            <th>Requirement</th>
                                                                            <th class="text-center" style="width: 120px;">SOP</th>
                                                                            <th class="text-center" style="width: 120px;">Info</th>
                                                                            <th class="text-center" style="width: 120px;">Template</th>
                                                                            <th class="text-center" style="width: 120px;">Checklist</th>
                                                                        </tr>
                                                                    </thead>'.$setting_material.'</tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
        									    <!-- Nelmar Customer Analytics -->
                                                <div class="tab-pane" id="tab_customer_analytics">
        											<div class="row widget-row">
        												<div class="col-md-6">
        													<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
        														<h3 class="d-flex justify-content-center">Send</h3>
        														<div class="widget-thumb-wrap">
        															<div id="waterfallChart1" style="width: 100%; height: 500px;"></div>
        														</div>
        													</div>
        												</div>
        												<div class="col-md-6">
        													<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
        														<h3 class="d-flex justify-content-center">Received</h3>
        														<div class="widget-thumb-wrap">
        															<div id="receivedchartdiv" style="width: 100%; height: 500px;"></div>
        														</div>
        													</div>
        												</div>
        												<div class="col-md-6">
        													<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
        														<h3 class="d-flex justify-content-center">Requirements</h3>
        														<div class="widget-thumb-wrap">
        															<div id="requirementchartdiv1" style="width: 100%; height: 500px;"></div>
        														</div>
        													</div>
        												</div>
                									    <div class="col-md-6"> 
                										    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                											    <h3 class="d-flex justify-content-center">Frequency</h3>
        													    <div class="widget-thumb-wrap">
        														    <div id="donutChart2" style="width: 90%; height: 400px;"></div>
        														</div>
        													</div>
        												</div>
        											</div>
        										</div>
        									</div>';
                                        } else {
                                            // $selectData = mysqli_query( $conn,"SELECT ID FROM tbl_supplier WHERE page = 1 AND facility_switch = $facility_switch_user_id AND email = '".$current_userEmail."'");
                                            $selectData = mysqli_query( $conn,"
                                                SELECT
                                                *
                                                FROM (
                                                    SELECT ID FROM tbl_supplier WHERE is_deleted = 0 AND page = 1 AND facility_switch = $facility_switch_user_id AND email = '".$current_userEmail."'

                                                    UNION ALL
                                                    
                                                    SELECT 
                                                    s.ID
                                                    FROM tbl_supplier_contact AS c

                                                    LEFT JOIN (
                                                        SELECT
                                                        *
                                                        FROM tbl_supplier
                                                        WHERE is_deleted = 0
                                                        AND page = 1 
                                                        AND facility_switch = $facility_switch_user_id
                                                    ) AS s
                                                    ON FIND_IN_SET(c.ID, REPLACE(s.contact, ' ', ''))

                                                    WHERE c.is_deleted = 0
                                                    AND c.email = '".$current_userEmail."'
                                                ) r
                                            ");
                                            if ( mysqli_num_rows($selectData) > 1 ) {
                                                echo '<table class="table table-bordered table-hover" id="tableData_2">
                                                    <thead>
                                                        <tr>
                                                            <!--<th rowspan="2" class="hide">ID#</th>-->
                                                            <th rowspan="2">Customer Name</th>
                                                            <th rowspan="2">Category</th>
                                                            <th rowspan="2">Products/Services</th>
                                                            <th rowspan="2">Address</th>
                                                            <th colspan="3" class="text-center">Contact Details</th>
                                                            <!--<th rowspan="2" style="width: 155px;" class="text-center hide">Annual Review Due</th>-->
                                                            <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                            <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                            <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Address</th>
                                                            <th>Contact Info</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                        
                                                        $sql_s1 = '';
                                                        $sql_s2 = '';
                                                        if ($current_userEmployerID != 34) {
                                                            $sql_s1 = ' AND s1.facility = 0 ';
                                                            $sql_s2 = ' AND s2.facility = 0 ';
                                                        }
                                                
                                                        $result = mysqli_query( $conn,"
                                                            WITH RECURSIVE cte (s_ID, s_user_id, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, checked_percentage) AS
															(
															    SELECT
															    s1.ID AS s_ID,
															    s1.user_id AS s_user_id,
															    s1.name AS s_name,
															    s1.reviewed_due AS s_reviewed_due,
															    s1.status AS s_status,
															    s1.material AS s_material,
															    s1.service AS s_service,
                                                                s1.address AS s_address,
															    s1.category AS s_category,
															    s1.contact AS s_contact,
															    s1.document AS s_document,
															    d1.ID AS d_ID,
															    d1.type AS d_type,
															    d1.name AS d_name,
															    d1.file AS d_file,
															    d1.file_due AS d_file_due,
															    CASE 
															        WHEN 
															            LENGTH(d1.file) > 0 
															            AND (STR_TO_DATE(d1.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d1.file_due) > CURDATE())
															            AND d1.reviewed_by > 0
															            AND d1.approved_by > 0
															        THEN 1 
															        ELSE 0 
															    END AS d_status,
															    CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage

															    FROM tbl_supplier AS s1

															    LEFT JOIN (
															        SELECT
															        * 
															        FROM tbl_supplier_document 
															        WHERE type = 0
															        AND ID IN (
															            SELECT
															            MAX(ID)
															            FROM tbl_supplier_document
															            WHERE type = 0
															            GROUP BY name, supplier_id
															        )
															    ) AS d1
															    ON s1.ID = d1.supplier_ID
															    AND FIND_IN_SET(d1.name, REPLACE(REPLACE(s1.document, ' ', ''), '|',','  )  ) > 0

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist
                                                                    WHERE deleted = 0 
                                                                ) AS cl
                                                                ON cl.requirement_id = d1.name
                                                                AND cl.user_id = $switch_user_id

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist_checked
                                                                    WHERE deleted = 0
                                                                ) AS cc
                                                                ON cc.checklist_id = cl.ID
                                                                AND cc.document_id = d1.ID

															    WHERE s1.page = 1
															    AND s1.is_deleted = 0 
															    AND s1.email = '".$current_userEmail."'
                                                                AND s1.facility_switch = $facility_switch_user_id
															    $sql_s1

                                                                GROUP BY s1.ID, d1.ID
															    
															    UNION ALL
															    
															    
															    SELECT
															    s2.ID AS s_ID,
															    s2.user_id AS s_user_id,
															    s2.name AS s_name,
															    s2.reviewed_due AS s_reviewed_due,
															    s2.status AS s_status,
															    s2.material AS s_material,
															    s2.service AS s_service,
                                                                s2.address AS s_address,
															    s2.category AS s_category,
															    s2.contact AS s_contact,
															    s2.document_other AS s_document,
															    d2.ID AS d_ID,
															    d2.type AS d_type,
															    d2.name AS d_name,
															    d2.file AS d_file,
															    d2.file_due AS d_file_due,
															    CASE 
															        WHEN 
															            LENGTH(d2.file) > 0 
															            AND (STR_TO_DATE(d2.file_due, '%m/%d/%Y') > CURDATE() OR DATE(d2.file_due) > CURDATE())
															            AND d2.reviewed_by > 0
															            AND d2.approved_by > 0
															        THEN 1 
															        ELSE 0 
															    END AS d_status,
															    CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count,
                                                                ROUND(CASE WHEN COUNT(COALESCE(cc.checked, 0)) > 0 AND ((SUM(COALESCE(cc.checked, 0)) / COUNT(COALESCE(cc.checked, 0))) * 100) = 100 THEN 1 ELSE 0 END) AS checked_percentage

															    FROM tbl_supplier AS s2

															    LEFT JOIN (
															        SELECT
															        * 
															        FROM tbl_supplier_document 
															        WHERE type = 1
															        AND ID IN (
															            SELECT
															            MAX(ID)
															            FROM tbl_supplier_document
															            WHERE type = 1
															            GROUP BY name, supplier_id
															        )
															    ) AS d2
															    ON s2.ID = d2.supplier_ID
    															AND FIND_IN_SET(REPLACE(d2.name, ', ', ' / '), REPLACE(REPLACE(s2.document_other, ', ', ' / '), ' | ',','  )  ) > 0

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist
                                                                    WHERE deleted = 0 
                                                                ) AS cl
                                                                ON cl.requirement_id = d2.ID
                                                                AND cl.user_id = $switch_user_id

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist_checked
                                                                    WHERE deleted = 0
                                                                ) AS cc
                                                                ON cc.checklist_id = cl.ID
                                                                AND cc.document_id = d2.ID

															    WHERE s2.page = 1
															    AND s2.is_deleted = 0 
															    AND s2.email = '".$current_userEmail."'
                                                                AND s2.facility_switch = $facility_switch_user_id
															    $sql_s2

                                                                GROUP BY s2.ID, d2.ID
															)
															SELECT
															s_ID,
															s_e_name,
															s_name,
															s_reviewed_due,
															s_status,
															s_material,
															s_service, 
															s_address, 
															s_category,
															c_name,
															d_compliance,
															d_counting,
                                                            d_percentage,
															cn.name AS cn_name,
															cn.address AS cn_address,
															cn.email AS cn_email,
															cn.phone AS cn_phone,
															cn.cell AS cn_cell,
															cn.fax AS cn_fax
															FROM (
															    SELECT 
															    s_ID,
															    s_user_id,
															    e.businessname AS s_e_name,
															    s_name, 
															    s_reviewed_due, 
															    s_status, 
																s_material,
																s_service, 
																s_address, 
															    s_contact,
															    s_category,
															    c.name AS c_name,
															    -- s_document, 
															    -- d_ID, 
															    -- d_type, 
															    -- d_name, 
															    -- d_file, 
															    -- d_file_due, 
															    -- d_status,
															    -- d_count,
															    SUM(d_status) AS d_compliance,
															    SUM(d_count) AS d_counting,
                                                                ROUND(CASE WHEN SUM(d_count) > 0 THEN (SUM(checked_percentage) / SUM(d_count)) * 100 ELSE 0 END) AS d_percentage
															    FROM cte

															    LEFT JOIN (
															        SELECT
															        *
															        FROM tbl_supplier_category
															        WHERE deleted = 0
															    ) AS c
															    ON s_category = c.ID
															    
															    LEFT JOIN (
															        SELECT
															        *
															        FROM tblEnterpiseDetails
															    ) AS e
															    ON s_user_id = e.users_entities
															    
															    GROUP BY s_ID
															) AS r

															LEFT JOIN (
															    SELECT
															    *
															    FROM tbl_supplier_contact
															) AS cn
															ON FIND_IN_SET(cn.ID, REPLACE(s_contact, ' ', '')) > 0

															GROUP BY s_ID

															ORDER BY s_name
														" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            $table_counter = 1;
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $s_ID = $row["s_ID"];
                                                                $s_name = htmlentities($row["s_e_name"] ?? '');
                                                                $s_reviewed_due = $row["s_reviewed_due"];

                                                                $s_category = htmlentities($row["s_category"] ?? '');
                                                                $c_name = htmlentities($row["c_name"] ?? '');

                                                                $cn_name = htmlentities($row["cn_name"] ?? '');
                                                                $cn_address = htmlentities($row["cn_address"] ?? '');
                                                                $cn_email = htmlentities($row["cn_email"] ?? '');
                                                                $cn_phone = htmlentities($row["cn_phone"] ?? '');
                                                                $cn_cell = htmlentities($row["cn_cell"] ?? '');
                                                                $cn_fax = htmlentities($row["cn_fax"] ?? '');

                                                                // $compliance = 0;
                                                                // if ($switch_user_id == 1684) {
                                                                //     $d_compliance = $row["d_compliance"];
                                                                //     $d_counting = $row["d_counting"];
                                                                //     if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }
                                                                // } else {
                                                                    $compliance = $row["d_percentage"];
                                                                // }

                                                                $s_status = $row["s_status"];
                                                                $status_type = array(
                                                                    0 => 'Pending',
                                                                    1 => 'Approved',
                                                                    2 => 'Non Approved',
                                                                    3 => 'Emergency Use Only',
                                                                    4 => 'Do Not Use',
																	5 => 'Active',
																	6 => 'Inactive'
                                                                );

                                                                if ($s_category == "3") {
                                                                    $material = $row["s_service"];
                                                                    if (!empty($material)) {
                                                                        $material_result = array();
                                                                        $material_arr = explode(", ", $material);
                                                                        foreach ($material_arr as $value) {
                                                                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
                                                                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                array_push($material_result, $rowMaterial['service_name']);
                                                                            }
                                                                        }
                                                                        $material = implode(', ', $material_result);
                                                                    }
                                                                } else {
                                                                    $material = $row["s_material"];
                                                                    if (!empty($material)) {
                                                                        $material_result = array();
                                                                        $material_arr = explode(", ", $material);
                                                                        foreach ($material_arr as $value) {
                                                                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
                                                                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                                                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                                array_push($material_result, $rowMaterial['material_name']);
                                                                            }
                                                                        }
                                                                        $material = implode(', ', $material_result);
                                                                    }
                                                                }
    																
																$address_array = array();
																$address_arr = htmlentities($row["s_address"] ?? '');
																$address_arr_country = '';
																if (!empty($address_arr)) {
																	if (str_contains($address_arr, '|')) {
    													            	$address_arr = explode(" | ", $address_arr);
    													            	
        													            array_push($address_array, htmlentities($address_arr[1]));
        													            array_push($address_array, htmlentities($address_arr[2]));
        													            array_push($address_array, htmlentities($address_arr[3]));
        													            array_push($address_array, $address_arr[0]);
        													            array_push($address_array, $address_arr[4]);
        													            $address_arr_country = $address_arr[0];
        													            $address_arr = implode(", ", $address_array);
																	} else if (str_contains($address_arr, ',')) {
    													                if (count(explode(", ", $address_arr)) == 5) {
    													                	$address_arr = explode(", ", $address_arr); 
            													            array_push($address_array, htmlentities($address_arr[1]));
            													            array_push($address_array, htmlentities($address_arr[2]));
            													            array_push($address_array, htmlentities($address_arr[3]));
            													            array_push($address_array, $address_arr[0]);
            													            array_push($address_array, $address_arr[4]);
            													            $address_arr_country = $address_arr[0];
            													            $address_arr = implode(", ", $address_array);
    													                }
																	}
																}

                                                                echo '<tr id="tr_'.$s_ID.'">';
                                                                    // <td class="hide">'.$s_ID.'</td>
                                                                    // echo '<td>'.htmlentities($s_name ?? '').'</td>
                                                                    echo '<td>'.htmlentities($s_name,ENT_COMPAT,'UTF-8',false).'</td>
                                                                    <td>'.htmlentities($c_name ?? '').'</td>
                                                                    <td>'.$material.'</td>
                                                                    <td>'.$address_arr.'</td>
                                                                    <td>'.htmlentities($cn_name ?? '').'</td>
                                                                    <td>'.htmlentities($cn_address ?? '').'</td>
                                                                    <td class="text-center">
                                                                        <ul class="list-inline">';
                                                                            if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                                            if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                                            if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                                            if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                                        echo '</ul>
                                                                    </td>';
                                                                    // <td class="text-center hide">'.$s_reviewed_due.'</td>
                                                                    echo '<td class="text-center">'.round($compliance).'%</td>
                                                                    <td class="text-center">'.$status_type[$s_status].'</td>
                                                                    <td class="text-center">';
                                                                    
                                                                        if (empty($current_permission_array_key) OR in_array(5, $permission)) {
                                                                            echo '<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>';
                                                                        }
                                                                        
                                                                    echo '</td>
                                                                </tr>';
                                                            }
                                                        }
                                                            
                                                    echo '</tbody>
                                                </table>';
                                            } else if ( mysqli_num_rows($selectData) == 1 ) {
                                                $rowData = mysqli_fetch_array($selectData);
                                                $rowID = $rowData["ID"];

                                                echo '<form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                                    <div id="singleView">No Record</div>
                                                </form>';
                                            } else {
                                                echo '<div id="singleView">No Record</div>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- END BORDERED TABLE PORTLET-->
                    </div>

                    <!-- MODAL AREA-->
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Customer Form</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input class="form-control" type="hidden" name="emergency_count" value="1" />
                                        <div class="tabbable tabbable-tabdrop">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tabBasic_1" data-toggle="tab">Details</a>
                                                </li>
                                                <li>
                                                    <a href="#tabContact_1" data-toggle="tab">Contacts</a>
                                                </li>
                                                <li>
                                                    <a href="#tabDocuments_1" data-toggle="tab">Facility Requirements</a>
                                                </li>
                                                <li class="tabProducts">
                                                    <a href="#tabProducts_1" data-toggle="tab">Products</a>
                                                </li>
                                                <li class="tabService hide">
                                                    <a href="#tabService_1" data-toggle="tab">Services</a>
                                                </li>
                                                <li>
                                                    <a href="#tabAuditReview_1" data-toggle="tab">Audit & Review</a>
                                                </li>
                                                <li>
                                                    <a href="#tabRecord_1" data-toggle="tab">Record</a>
                                                </li>
                                                <?php
                                                    if ($current_userID == 34 || $current_userID == 27) {
                                                        echo '<li><a href="#tabPortal_1" data-toggle="tab">Portal</a></li>';
                                                    }
                                                ?>
                                                <li class="hide">
                                                    <a href="#tabFSVP_1" data-toggle="tab">FSVP</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content margin-top-20">
                                                <div class="tab-pane active" id="tabBasic_1">
                                                    <?php
                                                        $pictogram = 'cus_add_basic';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Customer Name</label>
                                                                <input class="form-control" type="text" name="name" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Category</label>
                                                                <select class="form-control" name="category" onchange="changedCategory(this, 1)">
                                                                    <option value="0">Select</option>
                                                                    <?php
                                                                        // $selectCategory = mysqli_query( $conn,"SELECT * FROM tbl_supplier_category WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
                                                                        $selectCategory = mysqli_query( $conn,"SELECT ID, name FROM tbl_supplier_category WHERE deleted = 0 AND name != '' AND name IS NOT NULL GROUP BY name ORDER BY name" );
                                                                        if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                            while($row = mysqli_fetch_array($selectCategory)) {
                                                                                echo '<option value="'.$row["ID"].'">'.htmlentities($row["name"] ?? '').'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                    			<input type="text" class="form-control margin-top-15" name="supplier_category_other" id="supplier_category_other_1" placeholder="Specify others" style="display: none;" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Industry</label>
                                                                <select class="form-control" name="industry" onchange="changeIndustry(this.value, 1)">
                                                                    <option value="0">Select</option>
                                                                    <?php
                                                                        // $selectIndustry = mysqli_query( $conn,"SELECT * FROM tbl_supplier_industry WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
                                                                        $selectIndustry = mysqli_query( $conn,"SELECT ID, name FROM tbl_supplier_industry WHERE deleted = 0 AND name != '' AND name IS NOT NULL GROUP BY name ORDER BY name" );
                                                                        if ( mysqli_num_rows($selectIndustry) > 0 ) {
                                                                            while($row = mysqli_fetch_array($selectIndustry)) {
                                                                                echo '<option value="'.$row["ID"].'">'.htmlentities($row["name"] ?? '').'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                    			<input type="text" class="form-control margin-top-15" name="supplier_industry_other" id="supplier_industry_other_1" placeholder="Specify others" style="display: none;" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Country</label>
                                                                <select class="form-control" name="countries" onchange="changeCountry(1)">
                                                                    <option value="US">United States of America</option>

                                                                    <?php
                                                                        $selectCountry = mysqli_query( $conn,"SELECT * FROM countries WHERE iso2 <> 'US'" );
                                                                        while($rowCountry = mysqli_fetch_array($selectCountry)) {
                                                                            echo '<option value="'.$rowCountry["iso2"].'">'.htmlentities($rowCountry["name"] ?? '').'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Bldg No./Street</label>
                                                                <input class="form-control" type="text" name="address_street" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">City</label>
                                                                <input class="form-control" type="text" name="address_city" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">State</label>
                                                                <input class="form-control" type="text" name="address_state" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Zip Code</label>
                                                                <input class="form-control" type="text" name="address_code" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Email</label>
                                                                <input class="form-control" type="email" name="email" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Phone</label>
                                                                <input class="form-control" type="text" name="phone" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Fax</label>
                                                                <input class="form-control" type="text" name="fax" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Website</label>
                                                                <input class="form-control" type="text" name="website" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Status</label>
                                                                <select class="form-control" name="status">
                                                                    <option value="0">Pending</option>
                                                                    <option value="1">Active</option>
                                                                    <option value="2">Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Receive Notification?</label>
                                                                <select class="form-control" name="notification">
                                                                    <option value="0">No</option>
                                                                    <option value="1" SELECTED>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
														<div class="col-md-3 <?php echo $switch_user_id == 1211 ? '':'hide'; ?>">
                                                            <div class="form-group">
                                                                <label class="control-label">With NDA?</label>
                                                                <select class="form-control" name="nda">
                                                                    <option value="0">No</option>
                                                                    <option value="1">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Frequency</label>
                                                                <select class="form-control" name="supplier_frequency" onchange="changeFrequency(this.value)">
                                                                    <option value="0">Custom</option>
                                                                    <option value="1">Once Per Day</option>
                                                                    <option value="2" SELECTED>Once Per Week</option>
                                                                    <option value="3">On the 1st and 15th of the Month</option>
                                                                    <option value="4">Once Per Month</option>
																	<option value="6">Once Per Two Months (Every Other Month)</option>
																	<option value="7">Once Per Three Months (Quarterly)</option>
																	<option value="8">Once Per Six Months (Bi-Annual)</option>
                                                                    <option value="5">Once Per Year</option>
                                                                    <option value="9">Every 20 Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 <?php echo $current_userEmployerID == 34 ? '':'hide'; ?>">
                                                            <div class="form-group">
                                                                <label class="control-label">Facility User</label>
                                                                <select class="form-control" name="facility">
                                                                    <option value="0">No</option>
                                                                    <option value="1">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bg-default hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Minute</label>
                                                                <select class="form-control selectpicker" name="supplier_frequency_minute" data-live-search="true" data-size="8">
                                                                    <optgroup label="Common Settings">
                                                                        <option value="*">Once Per Minute</option>
                                                                        <option value="*/2">Once Per Two Minutes</option>
                                                                        <option value="*/5">Once Per Five Minutes</option>
                                                                        <option value="*/10">Once Per Ten Minutes</option>
                                                                        <option value="*/15">Once Per Fifteen Minutes</option>
                                                                        <option value="0/30">Once Per Thirty Minutes</option>
                                                                    </optgroup>
                                                                    <optgroup label="Minutes">
                                                                        <option value="0">:00 (At the beginning of the hour)</option>
                                                                        <?php
                                                                            for ($i=1; $i < 60; $i++) { 
                                                                                echo '<option value="'.$i.'">:'.sprintf("%02d", $i).'</option>';
                                                                            }
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 bg-default hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Hour</label>
                                                                <select class="form-control selectpicker" name="supplier_frequency_hour" data-live-search="true" data-size="8">
                                                                    <optgroup label="Common Settings">
                                                                        <option value="*">Every Hour</option>
                                                                        <option value="*/2">Every Other Hour</option>
                                                                        <option value="*/3">Every Third Hour</option>
                                                                        <option value="*/4">Every Fourth Hour</option>
                                                                        <option value="*/6">Every Sixth Hour</option>
                                                                        <option value="0,12">Every Twelve Hours</option>
                                                                    </optgroup>
                                                                    <optgroup label="Hours">
                                                                        <?php
                                                                            for ($i=1; $i < 12; $i++) { 
                                                                                echo '<option value="'.$i.'">'.date("h:i A", strtotime($i.":00")).'</option>';
                                                                            }
                                                                            echo '<option value="12">12:00 PM Noon</option>';
                                                                            for ($i=13; $i < 24; $i++) { 
                                                                                echo '<option value="'.$i.'">'.date("h:i A", strtotime($i.":00")).'</option>';
                                                                            }
                                                                        ?>
                                                                        <option value="24">12:00 AM Midnight</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 bg-default hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Day</label>
                                                                <select class="form-control selectpicker" name="supplier_frequency_day" data-live-search="true" data-size="8">
                                                                    <optgroup label="Common Settings">
                                                                        <option value="*">Every Day</option>
                                                                        <option value="*/2">Every Other Day</option>
                                                                        <option value="1,15">On the 1st and 15th of the Month</option>
                                                                    </optgroup>
                                                                    <optgroup label="Days">
                                                                        <?php
                                                                            function addOrdinalNumberSuffix($num) {
                                                                                if (!in_array(($num % 100),array(11,12,13))){
                                                                                    switch ($num % 10) {
                                                                                        // Handle 1st, 2nd, 3rd
                                                                                        case 1:  return $num.'st';
                                                                                        case 2:  return $num.'nd';
                                                                                        case 3:  return $num.'rd';
                                                                                    }
                                                                                }
                                                                                return $num.'th';
                                                                            }
                                                                            for ($i = 1; $i <= 31; $i++){
                                                                                echo '<option value="'.$i.'">'.addOrdinalNumberSuffix($i).'</option>';
                                                                            }
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 bg-default hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Month</label>
                                                                <select class="form-control selectpicker" name="supplier_frequency_month" data-live-search="true" data-size="8">
                                                                    <optgroup label="Common Settings">
                                                                        <option value="*">Every Month</option>
                                                                        <option value="*/2">Every Other Month</option>
                                                                        <option value="*/4">Every Third Month</option>
                                                                        <option value="1,7">Every Six Months</option>
                                                                    </optgroup>
                                                                    <optgroup label="Months">
                                                                        <?php
                                                                            for ($i = 1; $i <= 12; $i++){
                                                                                echo '<option value="'.$i.'">'.date("F", mktime(0, 0, 0, $i, 10)).'</option>';
                                                                            }
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bg-default hide">
                                                            <div class="form-group">
                                                                <label class="control-label">Weekday</label>
                                                                <select class="form-control selectpicker" name="supplier_frequency_weekday" data-live-search="true" data-size="8">
                                                                    <optgroup label="Common Settings">
                                                                        <option value="*">Every Day</option>
                                                                        <option value="1-5">Every Weekday</option>
                                                                        <option value="6,7">Every Weekend Day</option>
                                                                        <option value="1,3,5">Every Monday, Wednesday, and Friday</option>
                                                                        <option value="2,4">Every Tuesday and Thursday</option>
                                                                    </optgroup>
                                                                    <optgroup label="Weekdays">
                                                                        <?php
                                                                            $days = [
                                                                                1 => 'Monday',
                                                                                2 => 'Tuesday',
                                                                                3 => 'Wednesday',
                                                                                4 => 'Thursday',
                                                                                5 => 'Friday',
                                                                                6 => 'Saturday',
                                                                                7 => 'Sunday'
                                                                            ];
                                                                            for ($i = 1; $i <= 7; $i++){
                                                                                echo '<option value="'.$i.'">'.$days[$i].'</option>';
                                                                            }
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabContact_1">
                                                    <?php
                                                        $pictogram = 'cus_add_contact';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <a href="#modalNewContact" data-toggle="modal" class="btn green" onclick="btnNew_Contact(<?php echo $switch_user_id; ?>, 1, 'modalNewContact')">Add New Contact</a>
                                                    <div class="table-scrollable">
                                                        <table class="table table-bordered table-hover" id="tableData_Contact_1">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Title</th>
                                                                    <th>Address</th>
                                                                    <th class="text-center" style="width: 145px;">Contact Details</th>
                                                                    <th class="text-center" style="width: 145px;">Receive Notification?</th>
                                                                    <th class="text-center hide" style="width: 145px;">Emergency Person</th>
                                                                    <th class="text-center" style="width: 140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabDocuments_1">
                                                    <?php
                                                        $pictogram = 'cus_add_docs';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <div class="mt-checkbox-list">
                                                        <?php
                                                            $sql_supplier = '';
                                                            $checked = '';
                                                            $tblOther = 0;
                                                            $international = ' ';

                                                            // if ($switch_user_id == 1684) {
                                                            //     // if ($address_arr[0] == $c) { $international = ' international = 0 AND '; }
                                                            //     if ($switch_user_id == 1649 OR $current_client == 16) { $sql_supplier .= ' client = 16 AND '; }
                                                            //     if ($switch_user_id == 1649 OR $current_client == 125) { $sql_supplier .= ' client = 25 AND '; }
                                                            //     if ($switch_user_id == 1211 OR $user_id == 1486 OR $user_id == 1774 OR $user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) { $tblOther = 1; }
                                                            //     if ($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) { $checked = 'CHECKED'; $sql_supplier .= " required = 1 AND FIND_IN_SET($switch_user_id, REPLACE(accounts, ' ', '')) > 0 AND "; }
                                                            //     $selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE $sql_supplier international = 0 AND organic = 0 ORDER BY name" );
                                                            // } else {
                                                                $checked = 'CHECKED';
                                                                if ($user_id == 5 OR $user_id == 1211) { $tblOther = 1; }
                                                                // if ($address_arr[0] != $c) { $international = ' OR facility = -1 '; }
                                                                $selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE deleted = 0 AND organic = 0 AND (FIND_IN_SET($switch_user_id, REPLACE(facility , ' ', '')) OR facility = 0 $international) ORDER BY name" );
                                                            // }

                                                            if ( mysqli_num_rows($selectRequirement2) > 0 ) {
                                                                while($row = mysqli_fetch_array($selectRequirement2)) {
                                                                
                                                                    $name = htmlentities($row["name"] ?? '');
                                                                    if ($switch_user_id == 1486 AND !empty($row["req"])) {
                                                                        $name = htmlentities($row["req"] ?? '');
                                                                    }
                                        							if ($row["ID"] == 118 AND $switch_user_id == 1738) { $name = 'Traceability System'; }
                                                                    
                                                                    echo '<label class="mt-checkbox mt-checkbox-outline"> '.$name.'
                                                                        <input type="checkbox" value="'.$row["ID"].'" name="document[]"  onchange="checked_Requirement(this, 1, 0, 0)" '.$checked.' />
                                                                        <span></span>
                                                                    </label>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label sbold"><?php echo $current_client == 0 ? 'Other':'Add Requirement'; ?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="inputRequirementOther" id="inputRequirementOther_1" placeholder="Specify">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-success" type="button" onclick="btnNew_Requirement(1, <?php echo $tblOther; ?>)">Add</button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="table-scrollable">
                                                        <table class="table table-bordered table-hover" id="tableData_Requirement_1">
                                                            <thead class="bg-blue-ebonyclay bg-font-blue-ebonyclay">
                                                                <tr>
                                                                    <th style="width: 300px;">Requirements</th>
                                                                    <th style="width: 165px;" class="text-center">Document</th>
                                                                    <th>File Name</th>
                                                                    <th style="width: 300px;" class="text-center">Document Validity Period</th>
                                                                    <th style="width: 165px;" class="text-center col-sop">SOP</th>
                                                                    <th style="width: 165px;" class="text-center">Info</th>
                                                                    <th style="width: 165px;" class="text-center">Template</th>
                                                                    <th style="width: 165px;" class="text-center">Compliance</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
																
																<?php
																	// if ($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) {
																	// if ($switch_user_id == 1684) {
                                                                    //     $selectRequirement2Table = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE $sql_supplier international = 0 AND international = 0 AND organic = 0 ORDER BY name" );
																	// } else {
                                                                        $selectRequirement2Table = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE deleted = 0 AND organic = 0 AND (FIND_IN_SET($switch_user_id, REPLACE(facility , ' ', '')) OR facility = 0 $international) ORDER BY name" );
                                                                    // }

                                                                    if ( mysqli_num_rows($selectRequirement2Table) > 0 ) {
																		while($rowTable = mysqli_fetch_array($selectRequirement2Table)) {
																			$req_id = $rowTable["ID"];
																			
                                                                            $req_name = htmlentities($rowTable["name"] ?? '');
                                                                            if ($switch_user_id == 1486 AND !empty($rowTable["req"])) {
                                                                                $req_name = htmlentities($rowTable["req"] ?? '');
                                                                            }
                                    							            if ($req_id == 118 AND $switch_user_id == 1738) { $req_name = 'Traceability System'; }

																			echo '<tr class="tr_'.$req_id.'">
											                                    <td rowspan="2">
											                                        <input type="hidden" class="form-control" name="document_name[]" value="'.$req_id.'" required />
											                                        <b>'.$req_name.'</b>
											                                    </td>
											                                    <td class="text-center">
											                                    	<select class="form-control hide" name="document_filetype[]" onchange="changeType(this)" required>
										                                                <option value="0">Select option</option>
										                                                <option value="1">Manual Upload</option>
										                                                <option value="2">Youtube URL</option>
										                                                <option value="3">Google Drive URL</option>
										                                                <option value="4">Sharepoint URL</option>
										                                            </select>
										                                            <input class="form-control margin-top-15 fileUpload" type="file" name="document_file[]" onchange="changeFile(this, this.value)" style="display: none;" />
										                                            <input class="form-control margin-top-15 fileURL" type="url" name="document_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />
										                                            <p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>
											                                    </td>
											                                    <td>
											                                    	<input type="text" class="form-control document_filename" name="document_filename[]" placeholder="Document Name" />
											                                    </td>
											                                    <td class="text-center">
											                                        <div class="input-group">
											                                            <input type="text" class="form-control daterange daterange_empty" name="document_daterange[]" value="" />
											                                            <span class="input-group-btn">
											                                                <button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">
											                                                    <i class="fa fa-close"></i>
											                                                </button>
											                                            </span>
											                                        </div>
											                                        <input type="date" class="form-control hide" name="document_date[]" value="" />
											                                        <input type="date" class="form-control hide" name="document_due[]" value="" />
											                                    </td>
                                                                                <td rowspan="2" class="text-center col-sop">
                                                                                    <input type="file" class="form-control hide" name="document_sop[]" />';

                                                                                    $selectSOP = mysqli_query( $conn,"SELECT * FROM tbl_supplier_sop WHERE user_id = $user_id AND requirement_id = $req_id" );
                                                                                    if ( mysqli_num_rows($selectSOP) > 0 ) {
                                                                                        $rowSOP = mysqli_fetch_array($selectSOP);
                                                                                        $sop_ID = $rowSOP["ID"];
                                                                                        $sop_file = $rowSOP["file"];

                                                                                        $type = 'iframe';
                                                                                        $target = '';
                                                                                        $filetype = $rowSOP["filetype"];
                                                                                        $datafancybox = 'data-fancybox';
                                                                                        if ($filetype == 1) {
                                                                                            $fileExtension = fileExtension($sop_file);
                                                                                            $src = $fileExtension['src'];
                                                                                            $embed = $fileExtension['embed'];
                                                                                            $type = $fileExtension['type'];
                                                                                            $file_extension = $fileExtension['file_extension'];
                                                                                            $url = $base_url.'uploads/supplier/';

                                                                                            $sop_file = $src.$url.rawurlencode($sop_file).$embed;
                                                                                        } else if ($filetype == 3) {
                                                                                            $sop_file = preg_replace('#[^/]*$#', '', $sop_file).'preview';
                                                                                        } else if ($filetype == 4) {
                                                                                            $file_extension = 'fa-strikethrough';
                                                                                            $target = '_blank';
                                                                                            $datafancybox = '';
                                                                                        }

                                                                                        echo '<p style="margin: 0;">
                                                                                            <a href="'.$sop_file.'" data-src="'.$sop_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                                            <a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$req_id.', '.$sop_ID.', 1, 1)">Upload</a>
                                                                                        </p>';
                                                                                    } else {
                                                                                        echo '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$req_id.', 0, 1, 1)">Upload</a>';
                                                                                    }

                                                                                echo '</td>
                                                                                <td rowspan="2" class="text-center">
                                                                                    <input type="file" class="form-control hide" name="document_info[]" />';

                                                                                    $selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_supplier_info WHERE user_id = $user_id AND requirement_id = $req_id" );
                                                                                    if ( mysqli_num_rows($selectInfo) > 0 ) {
                                                                                        $rowInfo = mysqli_fetch_array($selectInfo);
                                                                                        $info_ID = $rowInfo["ID"];
                                                                                        $info_file = $rowInfo["file"];

                                                                                        $type = 'iframe';
                                                                                        $target = '';
                                                                                        $filetype = $rowInfo["filetype"];
                                                                                        $datafancybox = 'data-fancybox';
                                                                                        if ($filetype == 1) {
                                                                                            $fileExtension = fileExtension($info_file);
                                                                                            $src = $fileExtension['src'];
                                                                                            $embed = $fileExtension['embed'];
                                                                                            $type = $fileExtension['type'];
                                                                                            $file_extension = $fileExtension['file_extension'];
                                                                                            $url = $base_url.'uploads/supplier/';

                                                                                            $info_file = $src.$url.rawurlencode($info_file).$embed;
                                                                                        } else if ($filetype == 3) {
                                                                                            $info_file = preg_replace('#[^/]*$#', '', $info_file).'preview';
                                                                                        } else if ($filetype == 4) {
                                                                                            $file_extension = 'fa-strikethrough';
                                                                                            $target = '_blank';
                                                                                            $datafancybox = '';
                                                                                        }

                                                                                        echo '<p style="margin: 0;">
                                                                                            <a href="'.$info_file.'" data-src="'.$info_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                                            <a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$req_id.', '.$info_ID.', 1, 1)">Upload</a>
                                                                                        </p>';
                                                                                    } else {
                                                                                        echo '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$req_id.', 0, 1, 1)">Upload</a>';
                                                                                    }

                                                                                echo '</td>
											                                    <td rowspan="2" class="text-center">
											                                        <input type="file" class="form-control hide" name="document_template[]" />';

											                                        $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE user_id = $user_id AND requirement_id = $req_id" );
											                                        if ( mysqli_num_rows($selectTemplate) > 0 ) {
											                                            $rowTemplate = mysqli_fetch_array($selectTemplate);
											                                            $temp_ID = $rowTemplate["ID"];
											                                            $temp_file = $rowTemplate["file"];

											                                            $type = 'iframe';
											                                            $target = '';
											                                            $filetype = $rowTemplate["filetype"];
											                                            $datafancybox = 'data-fancybox';
											                                            if ($filetype == 1) {
											                                                $fileExtension = fileExtension($temp_file);
											                                                $src = $fileExtension['src'];
											                                                $embed = $fileExtension['embed'];
											                                                $type = $fileExtension['type'];
											                                                $file_extension = $fileExtension['file_extension'];
											                                                $url = $base_url.'uploads/supplier/';

											                                                $temp_file = $src.$url.rawurlencode($temp_file).$embed;
											                                            } else if ($filetype == 3) {
											                                                $temp_file = preg_replace('#[^/]*$#', '', $temp_file).'preview';
											                                            } else if ($filetype == 4) {
											                                                $file_extension = 'fa-strikethrough';
											                                                $target = '_blank';
											                                                $datafancybox = '';
											                                            }

											                                            echo '<p style="margin: 0;">
											                                                <a href="'.$temp_file.'" data-src="'.$temp_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
											                                                <a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$req_id.', '.$temp_ID.', 1, 1)">Upload</a>
											                                            </p>';
											                                        } else {
											                                            echo '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$req_id.', 0, 1, 1)">Upload</a>';
											                                        }

											                                    echo '</td>
											                                    <td rowspan="2" class="text-center">0%</td>
											                                </tr>
											                                <tr class="tr_'.$req_id.'">
											                                    <td colspan="3">
											                                    	<input type="text" class="form-control" name="document_comment[]" placeholder="Comment" />
											                                    	<div class="row margin-top-10">
													                                    <div class="col-md-3">
													                                        <div class="form-group">
													                                            <label class="control-label">Reviewed By</label>
													                                            <select class="form-control " name="document_reviewed[]">
													                                                <option value="0">Select</option>
													                                                <option value="'.$current_userID.'">'.htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? '').'</option>
													                                            </select>
													                                        </div>
													                                    </div>
													                                    <div class="col-md-3">
													                                        <div class="form-group">
													                                            <label class="control-label">Reviewed Date</label>
													                                            <input type="date" class="form-control" name="document_reviewed_date[]" value="">
													                                        </div>
													                                    </div>
													                                    <div class="col-md-3">
													                                        <div class="form-group">
													                                            <label class="control-label">Approved By</label>
													                                            <select class="form-control " name="document_approved[]">
													                                                <option value="0">Select</option>
													                                                <option value="'.$current_userID.'">'.htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? '').'</option>
													                                            </select>
													                                        </div>
													                                    </div>
													                                    <div class="col-md-3">
													                                        <div class="form-group">
													                                            <label class="control-label">Approved Date</label>
													                                            <input type="date" class="form-control" name="document_approved_date[]" value="">
													                                        </div>
													                                    </div>
													                                </div>
											                                    </td>
											                                </tr>';
																		}
																	}
																?>
																
															</tbody>
                                                        </table>
                                                    </div>
													<?php 
														if ($switch_user_id == 1211 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) {
															echo '<div class="table-scrollable">
																<table class="table table-bordered table-hover" id="tableData_Requirement_Other_1">
																	<thead class="bg-blue-ebonyclay bg-font-blue-ebonyclay">
																		<tr>
																			<th style="width: 300px;">Other Requirements</th>
																			<th style="width: 165px;" class="text-center">Document</th>
																			<th>File Name</th>
																			<th style="width: 300px;" class="text-center">Document Validity Period</th>
                                                                            <th style="width: 165px;" class="text-center col-sop">SOP</th>
                                                                            <th style="width: 165px;" class="text-center">Info</th>
																			<th style="width: 165px;" class="text-center">Template</th>
																			<th style="width: 165px;" class="text-center">Compliance</th>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																</table>
															</div>';
														}
													?>
                                                </div>
                                                <div class="tab-pane" id="tabProducts_1">
                                                    <?php
                                                        $pictogram = 'cus_add_product';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <a href="#modalNewProduct" data-toggle="modal" class="btn green" onclick="btnNew_Product(<?php echo $switch_user_id; ?>, 1, 'modalNewProduct')">Add New Products</a>
                                                    <div class="table-scrollable">
                                                        <table class="table table-bordered table-hover" id="tableData_Product_1">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product Name</th>
                                                                    <th>Product ID</th>
                                                                    <th>Description</th>
                                                                    <th class="text-center" style="width: 135px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabService_1">
                                                    <?php
                                                        $pictogram = 'cus_add_service';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <a href="#modalNewService" data-toggle="modal" class="btn green" onclick="btnNew_Service(<?php echo $switch_user_id; ?>, 1, 'modalNewService')">Add New Service</a>
                                                    <div class="table-scrollable">
                                                        <table class="table table-bordered table-hover" id="tableData_Service_1">
                                                            <thead>
                                                                <tr>
                                                                    <th>Service Name</th>
                                                                    <th>Service ID</th>
                                                                    <th>Description</th>
                                                                    <th class="text-center" style="width: 135px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabAuditReview_1">
                                                    <?php
                                                        $pictogram = 'cus_add_review';
                                                        if ($switch_user_id == 163) {
                                                            echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                        } else {
                                                            $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                            if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                                $row = mysqli_fetch_array($selectPictogram);
    
                                                                $files = '';
                                                                $type = 'iframe';
                                                                if (!empty($row["files"])) {
                                                                    $arr_filename = explode(' | ', $row["files"]);
                                                                    $arr_filetype = explode(' | ', $row["filetype"]);
                                                                    $str_filename = '';
    
                                                                    foreach($arr_filename as $val_filename) {
                                                                        $str_filename = $val_filename;
                                                                    }
                                                                    foreach($arr_filetype as $val_filetype) {
                                                                        $str_filetype = $val_filetype;
                                                                    }
    
                                                                    $files = $row["files"];
                                                                    if ($row["filetype"] == 1) {
                                                                        $fileExtension = fileExtension($files);
                                                                        $src = $fileExtension['src'];
                                                                        $embed = $fileExtension['embed'];
                                                                        $type = $fileExtension['type'];
                                                                        $file_extension = $fileExtension['file_extension'];
                                                                        $url = $base_url.'uploads/pictogram/';
    
                                                                        $files = $src.$url.rawurlencode($files).$embed;
                                                                    } else if ($row["filetype"] == 3) {
                                                                        $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                    }
                                                                }
    
                                                                if (!empty($files)) {
                                                                    echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <h4><strong>Audit</strong></h4>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Audit Report</label>
                                                                <input class="form-control" type="file" name="audit_report_file" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Document Validity</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control daterange_audit daterange_audit_empty" name="audit_report_validity" value="" />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default date-range-toggle" type="button" onclick="widget_date_audit_clears(this)">
                                                                            <i class="fa fa-close"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <input class="form-control hide" type="date" name="audit_report_date" />
                                                            <input class="form-control hide" type="date" name="audit_report_due" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Comments / Notes</label>
                                                                <input class="form-control" type="text" name="audit_report_note" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Audit Certificate</label>
                                                                <input class="form-control" type="file" name="audit_certificate_file" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Document Validity</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control daterange_audit daterange_audit_empty" name="audit_certificate_validity" value="" />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default date-range-toggle" type="button" onclick="widget_date_audit_clears(this)">
                                                                            <i class="fa fa-close"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <input class="form-control hide" type="date" name="audit_certificate_date" />
                                                            <input class="form-control hide" type="date" name="audit_certificate_due" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Comments / Notes</label>
                                                                <input class="form-control" type="text" name="audit_certificate_note" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Audit Corrective Action</label>
                                                                <input class="form-control" type="file" name="audit_action_file" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Document Validity</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control daterange_audit daterange_audit_empty" name="audit_action_validity" value="" />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default date-range-toggle" type="button" onclick="widget_date_audit_clears(this)">
                                                                            <i class="fa fa-close"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <input class="form-control hide" type="date" name="audit_action_due" />
                                                            <input class="form-control hide" type="date" name="audit_action_date" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Comments / Notes</label>
                                                                <input class="form-control" type="text" name="audit_action_note" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 hide">
                                                            <h4><strong>Auditing Body</strong></h4>
                                                            <div class="form-group">
                                                                <label class="control-label">Add Auditing</label>
                                                                <input type="text" class="form-control tagsinput" name="audit" data-role="tagsinput" placeholder="Specify" />
                                                                <span class="form-text text-muted">Hit enter button to add more</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4><strong>Annual Review</strong></h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Reviewed by</label>
                                                                        <input class="form-control" type="text" name="reviewed_by" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Duration of Review</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control daterange_audit daterange_audit_empty" name="reviewed_validity" value="" />
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default date-range-toggle" type="button" onclick="widget_date_audit_clears(this)">
                                                                                    <i class="fa fa-close"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <input class="form-control hide" type="date" name="reviewed_date" />
                                                                    <input class="form-control hide" type="date" name="reviewed_due" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabRecord_1">
                                                    <a href="#modalNewRecord" data-toggle="modal" class="btn green" onclick="btnNew_Record(1, 1)">Add New Record</a>
                                                    <div class="table-scrollable">
                                                        <table class="table table-bordered table-hover" id="tableData_Record_1">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Description</th>
                                                                    <th>Remark</th>
                                                                    <th class="text-center" style="width: 140px;">Supporting File</th>
                                                                    <th class="text-center" style="width: 140px;">Document Date</th>
                                                                    <th class="text-center" style="width: 140px;">Uploaded Date</th>
                                                                    <th class="text-center" style="width: 140px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php if ($current_userEmployeeID == 0 AND $current_userID <> 115) { ?>
                                                    <div class="tab-pane" id="tabPortal_1">
                                                        <h4><strong>Portal</strong></h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Department</label>
                                                                    <select class="form-control mt-multiselect department_id" name="department_id[]" onchange="changeDepartment(this, 1)" multiple="multiple">
                                                                        <?php
                                                                            $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY title");
                                                                            if ( mysqli_num_rows($selectDepartment) > 0 ) {
                                                                                while($rowDepartment = mysqli_fetch_array($selectDepartment)) {
                                                                                    $dept_ID = $rowDepartment["ID"];
                                                                                    $dept_title = htmlentities($rowDepartment["title"] ?? '');

                                                                                    echo '<option value="'.$dept_ID.'">'.$dept_title.'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Employee</label>
                                                                    <select class="form-control mt-multiselect employee_id" name="employee_id[]" multiple="multiple">
                                                                        <?php
                                                                            $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id AND facility_switch = $facility_switch_user_id ORDER BY first_name");
                                                                            if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                                while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                                    $emp_ID = $rowEmployee["ID"];
                                                                                    $emp_name = htmlentities($rowEmployee["first_name"] ?? '') .' '. htmlentities($rowEmployee["last_name"] ?? '');
                                                                                    $emp_email = htmlentities($rowEmployee["email"] ?? '');

                                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE is_verified = 1 AND is_active = 1 AND email = '".$emp_email."' ORDER BY first_name");
                                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                                        echo '<option value="'.$emp_ID.'">'.$emp_name.'</option>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <a href="javascript:;" class="btn dark btn-outline hide" onclick="btnSaveClose('modalNew', 'modalSave')" title="Close">Close</a>
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Customer" id="btnSave_Customer" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Customer Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <a href="javascript:;" class="btn dark btn-outline hide" onclick="btnSaveClose('modalView', 'modalUpdate')" title="Close">Close</a>
                                        <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer" id="btnUpdate_Customer" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalNewRecord" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalNewRecord">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Record</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Record" id="btnSave_Supplier_Record" data-style="zoom-out"><span class="ladda-label">Add Record</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditRecord" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalEditRecord">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Record Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Record" id="btnUpdate_Supplier_Record" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalNewContact" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Contact">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Contact</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Contact" id="btnSave_Supplier_Contact" data-style="zoom-out"><span class="ladda-label">Add Contact</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditContact" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Contact">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Contact Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Contact" id="btnUpdate_Supplier_Contact" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalNewProduct" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Product">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Product</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Customer_Product" id="btnSave_Customer_Product" data-style="zoom-out"><span class="ladda-label">Add Product</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Product">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Product Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer_Product" id="btnUpdate_Customer_Product" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        <div class="modal fade" id="modalEditMaterial" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Material">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Material Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Material" id="btnUpdate_Supplier_Material" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <div class="modal fade" id="modalNewService" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Service">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">New Service</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Customer_Service" id="btnSave_Customer_Service" data-style="zoom-out"><span class="ladda-label">Add Service</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditService" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Service">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Service Details</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer_Service" id="btnUpdate_Customer_Service" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalSOP" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_SOP">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">SOP File</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_SOP" id="btnSave_Supplier_SOP" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalSOP2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_SOP2">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">SOP File</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_SOP2" id="btnSave_Supplier_SOP2" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Info">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Info File</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Info" id="btnSave_Supplier_Info" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalInfo2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Info2">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Info File</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Info2" id="btnSave_Supplier_Info2" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalTemplate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Template">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Template File</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template" id="btnSave_Supplier_Template" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalTemplate2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Template2">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Template File</h4>
                                    </div>
                                    <div class="modal-body"></div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template2" id="btnSave_Supplier_Template2" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalReport">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Report</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover" id="table2excel">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 135px;">Compliance</th>
                                                    <th>Customer Name</th>
                                                    <th>Users</th>
                                                    <th class="text-center" style="width: 135px;">Required Documents</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="button" class="btn green ladda-button" name="btnExport" id="btnExport" data-style="zoom-out"><span class="ladda-label">Export</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalReportView" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="modalForm modalReportView">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Report</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalChecklist" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalChecklist">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Checklist (toggle YES if compliant)</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalChecklistSetting" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalChecklistSetting">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Checklist (toggle YES if compliant)</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalChecklistEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalChecklistEdit">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Update Checklist</h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn green ladda-button" name="btnUpdate_Checklist" id="btnUpdate_Checklist" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--Emjay modal-->
                    <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" action="controller.php">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Upload Demo Video</h4>
                                    </div>
                                    <div class="modal-body">
                                            <label>Video Title</label>
                                            <input type="text" id="file_title" name="file_title" class="form-control mt-2">
                                            <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">
                                            <label style="margin-top:15px">Video Link</label>
                                            <!--<input type="file" id="file" name="file" class="form-control mt-2">-->
                                            <input type="text" class="form-control" name="youtube_link">
                                            <input type="hidden" name="page" value="<?= $site ?>">

                                            <!--<label style="margin-top:15px">Privacy</label>-->
                                            <!--<select class="form-control" name="privacy" id="privacy" required>-->
                                            <!--    <option value="Private">Private</option>-->
                                            <!--    <option value="Public">Public</option>-->
                                            <!--</select>-->
                                        
                                        <div style="margin-top:15px" id="message">
                                        </div>
                                    </div>
									<div class="modal-footer modal-footer--sticky bg-white">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        <button type="submit" class="btn btn-success" name="save_video"><span id="save_video_text">Save</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="view_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Demo Video</h4>
                                        </div>
                
                                        <div class="modal-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe id="myVideo" class="embed-responsive-item" width="560" height="315" src="" allowfullscreen></iframe>
                                            </div>
                                        </div>
										<div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <!--Nelmar Customer Analytics Modal -->
                    <div id="modalChart" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Customer Chart</h4>
								</div>
								<div class="modal-body">
									<div class="row ">
										<div class="col-md-12">
												<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">
													<h3 class="d-flex justify-content-center">Requirements</h3>
															<div class="widget-thumb-wrap">
																<div id="requirementChartDiv" style="width: 100%; height: 500px;">
																</div>
															</div>
														</div>
													</div>
											     <div class="col-md-12">
												    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">
													    <h3 class="d-flex justify-content-center">Compliance</h3>
															<div class="widget-thumb-wrap">
																<div id="complianceChartDiv" style="width: 100%; height: 500px;">
																</div>
															</div>
														</div>
													</div>
												<div class="col-md-12"> 
												    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-1">
													    <h3 class="d-flex justify-content-center">Audit & Review</h3>
															<div class="widget-thumb-wrap">
																<div id="auditChartdiv" style="width: 100%; height: 500px;">
																</div>
															</div>
														</div> 
													</div>
												</div>
											</div>
									  	<div class="modal-footer">
									<button type="button" class="btn btn-outline dark" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
                </div>

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>

        
        <script src="AnalyticsIQ/customer_chart.js"></script>
        
        <script>
            $(document).ready(function(){
               // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "customer";
                var user_id = <?= $switch_user_id ?>;
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
    			    $.ajax({
        				method:"POST",
        				url:"controller.php",
        				data:fd,
        				processData: false, 
                        contentType: false,  
                        timeout: 6000000,
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
    			
                // $('.view_videos').click(function(){
                //     var file_name = $(this).attr('file_name')
                //  //   var vid = document.getElementById("myVideo");
                //  //   vid.src = "uploads/pages_demo/"+file_name;
                //  $("#myVideo").attr('src', file_name);
                // });
    			
                // Emjay script ends here 
            });
        </script>
        <script type="text/javascript">
            var current_client = '<?php echo $_COOKIE['client']; ?>';
            var switch_user_id = '<?php echo $switch_user_id; ?>';
            var iso = '<?php echo $enterp_iso2; ?>';
            $(document).ready(function(){

                <?php echo $rowID > 0 ? 'singleView('.$rowID.');':''; ?>
                var site = '<?php echo $site; ?>';
                
                $.ajax({
                    url: 'function.php?counterup='+site,
                    context: document.body,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        var pct_counter1 = (parseInt(obj.statusActive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter2 = (parseInt(obj.statusInactive) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter3 = (parseInt(obj.statusInactiveMonth) / parseInt(obj.statusTotal)) * 100;
                        var pct_counter4 = (parseInt(obj.statusTotal) / parseInt(obj.statusTotal)) * 100;
                        $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusActive+'"></span>');
                        $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                        $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                        $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactive+'"></span>');
                        $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                        $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                        $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusInactiveMonth+'"></span>');
                        $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                        $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                        $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+obj.statusTotal+'"></span>');
                        $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                        $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                        
                        $('.counterup').counterUp();
                    }
                });

                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
                $('#tableData_1, #tableData_2').DataTable({
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

                changeIndustry(0, 1);

                // widget_tagInput();
                widget_formRepeater();
				widget_date_audit();
                $('.selectpicker').selectpicker();
                changeFrequency(2);

                $("#btnExport").click(function(){
                    $("#table2excel").table2excel({
                        exclude:".noExl",           // exclude CSS class
                        name:"Worksheet Name",
                        filename:"Customer",        //do not include extension
                        fileext:".xlsx",             // file extension
                        exclude_img:true,
                        exclude_links:true,
                        exclude_inputs:true
                    });
                });
            });

            function btnExportFiles(id) {
                window.location.href = 'export/function.php?modalDLSC='+id;
            }
            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                $(e).parent().parent().find('td .document_filename').attr("required", false);
                $(e).parent().parent().find('td .daterange').attr("required", false);

                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3 || $(e).val() == 4) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }

                if($(e).val() > 0) {
                    $(e).parent().parent().find('td .document_filename').attr("required", true);
                    $(e).parent().parent().find('td .daterange').attr("required", true);
                }
            }
            function inputInvalid(modal) {
                var error = 0;
                $('.'+modal+' *:invalid').each(function () {
                    // Find the tab-pane that this element is inside, and get the id
                    var $closest = $(this).closest('.tab-pane');
                    var id = $closest.attr('id');

                    $(this).addClass('error');

                    // Find the link that corresponds to the pane and have it show
                    $('.'+modal+' .nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    error++;
                });

                return error;
            }

            function changedCategory(sel, modal) {
                if (sel.value == 3) {
                    $('.tabProducts').addClass('hide');
                    $('.tabService').removeClass('hide');
                } else {
                    $('.tabProducts').removeClass('hide');
                    $('.tabService').addClass('hide');
                }

                $('#supplier_category_other_'+modal).hide();
                if (sel.value == 41) { $('#supplier_category_other_'+modal).show(); }
            }
            function changeIndustry(id, modal) {
				// var client = '<?php echo $current_client; ?>';
				
                // $('#supplier_industry_other_'+modal).hide();
                // if (id == 34) { $('#supplier_industry_other_'+modal).show(); }

				// if (client == 0) {
                //     var country = $('#tabBasic_'+modal+' select[name="countries"]').val();
                //     if (id == 13 || id == 22 || id == 25) { id = id; }
                //     else { id = 0; }
                //     $.ajax({
                //         type: "GET",
                //         url: "function.php?modalView_Customer_Industry="+id+"&c="+country,
                //         dataType: "html",                  
                //         success: function(data){       
                //             $('#tabDocuments_'+modal+' .mt-checkbox-list').html(data);
                //             $('#tableData_Requirement_'+modal+' tbody').html('');
                //         }
                //     });
				// }
            }
            function changeCountry(modal) {
                // var industry = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                // changeIndustry(industry, modal);
            }
            function changeFile(evt, val) {
                // if (val != '') {
                //     $(e).parent().parent().find('td .document_filename').attr("required", true);
                //     $(e).parent().parent().find('td .daterange').attr("required", true);
                // } else {
                //     $(e).parent().parent().find('td .document_filename').attr("required", false);
                //     $(e).parent().parent().find('td .daterange').attr("required", false);
                // }
                
                
				if (val != '') {
					$(evt).hide();
					$(evt).parent().parent().find('select').addClass('hide');
					$(evt).parent().find('p').show();
					
					type = "iframe";
					previewLink = URL.createObjectURL($(evt)[0].files[0]);
				  	file = $(evt)[0].files[0];
				    if (file.type === "image/jpeg" || file.type === "image/jpg" || file.type === "image/png" || file.type === "image/gif" || file.type === "image/jiff") {
				        type = "";
				    }
					data = '<a href="'+previewLink+'" data-src="'+previewLink+'" data-fancybox="" data-type="'+type+'" class="btn btn-sm btn-info">View</a> | <button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button>';
					$(evt).parent().find('p').html(data);
				}
            }
			function changeFileURL(e, val) {
				if (val != '') {
					$(e).hide();
					$(e).parent().parent().find('select').addClass('hide');
					$(e).parent().find('p').show();

					type = "iframe";
					previewLink = val;
					data = '<a href="'+previewLink+'" data-src="'+previewLink+'" data-fancybox="" data-type="'+type+'" class="btn btn-sm btn-info">View</a> | <button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button>';
					$(e).parent().find('p').html(data);
				}
			}
            function changeDepartment(id, modal) {
                var selected = [];

                $.each($(".department_id option:selected"), function(){            
                    selected.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    data: {department_id:selected},
                    url: "function.php?modalView_Customer_Employee="+modal,
                    success: function(data){
                        $('#tabPortal_'+modal+' .employee_id').html(data);
                        changeEmployee(modal);
                        $('.employee_id').multiselect('destroy');
                        selectMulti();
                    }
                });
            }
            function changeEmployee(modal) {
                var selectEmployee = $('#tabPortal_'+modal+' .employee_id');
                selectEmployee.html(selectEmployee.find('option').sort(function(x, y) {
                    
                    // to change to descending order switch "<" for ">"
                    return $(x).text() > $(y).text() ? 1 : -1;
                }));
            }
            function changeFrequency(val) {
                if (val == 0) {
                    $('.bg-default').removeClass('hide');
                } else {
                    $('.bg-default').addClass('hide');
                }
            }

            function singleView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Customer="+id,
                    dataType: "html",
                    success: function(data){
                        $("#singleView").html(data);
                        $("#singleView").append('<button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer" id="btnUpdate_Customer" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>');

                        changeEmployee(2);
                        selectMulti();
                        widget_dates();
                        widget_date_audit();
                        $('.selectpicker').selectpicker();
                    }
                });
            }
            function btnView(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Customer="+id+"&c="+iso,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        // widget_tagInput();

                        changeEmployee(2);
                        selectMulti();
                        widget_dates();
                        widget_date_audit();
                        $('.selectpicker').selectpicker();
                    }
                });
            }
            function btnDelete(id) {
				if (confirm("Your item will be deleted!")) {
					$.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Supplier="+id,
                        dataType: "html",
                        success: function(data){
                            $('#tableData_1 tbody #tr_'+id).remove();
                            alert('This item has been deleted');
                        }
                    });
			    }
			    return false;
			    
                // swal({
                //     title: "Are you sure?",
                //     text: "Your item will be deleted!",
                //     type: "warning",
                //     showCancelButton: true,
                //     confirmButtonClass: "btn-danger",
                //     confirmButtonText: "Yes, confirm!",
                //     closeOnConfirm: false
                // }, function () {
                //     $.ajax({
                //         type: "GET",
                //         url: "function.php?btnDelete_Supplier="+id,
                //         dataType: "html",
                //         success: function(response){
                //             $('#tableData_1 tbody #tr_'+id).remove();
                //         }
                //     });
                //     swal("Done!", "This item has been deleted.", "success");
                // });
            }
            function btnReport(id) {
                $("#modalReport .modal-body table tbody").html('');
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Customer_Report="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReport .modal-body table tbody").html(data);
                    }
                });
            }
            function btnReportView(id, type) {
                $("#modalReportView .modal-body table tbody").html('');
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Customer_ReportView="+id+"&t="+type,
                    dataType: "html",
                    success: function(data){
                        var title = "List of Required Documents"
                        if (type == 2) {
                            title = "List of Materials"
                        }
                        $("#modalReportView .modal-header .modal-title").html(title);
                        $("#modalReportView .modal-body table tbody").html(data);
                    }
                });
            }
            function btnReportView(id, type) {
                $("#modalReportView .modal-body table tbody").html('');
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Customer_ReportView="+id+"&t="+type,
                    dataType: "html",
                    success: function(data){
                        var title = "List of Required Documents"
                        if (type == 2) {
                            title = "List of Materials"
                        }
                        $("#modalReportView .modal-header .modal-title").html(title);
                        $("#modalReportView .modal-body table tbody").html(data);
                    }
                });
            }
            function btnSendInvite(id) {
                swal({
                    title: "Are you sure?",
                    text: "Send an Invitation Email!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalSend_Customer="+id,
                        dataType: "html",
                        success: function(data){
                            // msg = "Sucessfully Sent!";
                            // bootstrapGrowl(msg);
                        }
                    });
                    swal("Done!", "Email has been sent.", "success");
                });
            }

            function widget_tagInput() {
                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});
            }
            function widget_formRepeater() {
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
                                            setTimeout(function() { 
                                            }, 500);
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
            function widget_dates() {
                $('#tableData_Requirement_2 tbody .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#tableData_Requirement_2 tbody .daterange_empty').val('');
            }
            function widget_date(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_date_other(id, modal, other) {
                if (other == 1) {
                    $('#tableData_Requirement_Other_'+modal+' tbody .tr_other_'+id+' .daterange').daterangepicker({
                        ranges: {
                            'Today': [moment(), moment()],
                            'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                            'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                        },
                        "autoApply": true,
                        "showDropdowns": true,
                        "linkedCalendars": false,
                        "alwaysShowCalendars": true,
                        "drops": "auto",
                        "opens": "left"
                    }, function(start, end, label) {
                        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                    });
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').daterangepicker({
                        ranges: {
                            'Today': [moment(), moment()],
                            'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                            'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                        },
                        "autoApply": true,
                        "showDropdowns": true,
                        "linkedCalendars": false,
                        "alwaysShowCalendars": true,
                        "drops": "auto",
                        "opens": "left"
                    }, function(start, end, label) {
                        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                    });
                }
            }
            function widget_date_clears(e) {
                $(e).parent().prev('.daterange').val('');
            }
            function widget_date_clear(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').val('');
            }
            function widget_date_clear_other(id, modal, other) {
                if (other == 1) {
                    $('#tableData_Requirement_Other_'+modal+' tbody .tr_other_'+id+' .daterange').val('');
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').val('');
                }
            }
            function widget_dates_product(e) {
                $('#modal'+e+'Product .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#modal'+e+'Product .daterange_empty').val('');
            }
            function widget_date_audit() {
                $('.daterange_audit').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('.daterange_audit_empty').val('');
            }
            function widget_date_audit_clears(e) {
                $(e).parent().prev('.daterange_audit').val('');
            }
            function widget_formRepeater_material(i) {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();

                                        $(this).find('.daterange').daterangepicker({
                                            ranges: {
                                                'Today': [moment(), moment()],
                                                'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                                                'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                                            },
                                            "autoApply": true,
                                            "showDropdowns": true,
                                            "linkedCalendars": false,
                                            "alwaysShowCalendars": true,
                                            "drops": "auto",
                                            "opens": "left"
                                        }, function(start, end, label) {
                                            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                                        });
                                        (this).find('.daterange_empty').val('');
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                            }, 500);
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
            function widget_dates_material(e) {
                $('#modal'+e+'Material .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'One Month': [moment(), moment().add(1, 'month').subtract(1, 'day')],
                        'One Year': [moment(), moment().add(1, 'year').subtract(1, 'day')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#modal'+e+'Material .daterange_empty').val('');
            }

            function btnSaveClose(modal, form) {
                // swal({
                //     title: "Do you want to save the changes?",
                //     type: "warning",
                //     showCancelButton: true,
                //     cancelButtonClass: "btn-danger",
                //     cancelButtonText: "Don't Save",
                //     confirmButtonClass: "btn-success",
                //     confirmButtonText: "Yes, confirm!",
                //     closeOnConfirm: false
                // }, function (inputValue) {
                //     if (inputValue == true) {
                //         $('.'+form).submit();
                //         $('#'+modal).modal('hide');
                //     } else {
                //         $('#'+modal).modal('hide');
                //     }
                // });
                
                $('#'+modal).modal('hide');
            }
            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSave') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer'));
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
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            var html = '<tr id="tr_'+obj.ID+'">';
                                // html += '<td class="hide">'+tbl_counter+'</td>';
                                html += '<td>'+obj.name+'</td>';
                                html += '<td>'+obj.category+'</td>';
                                html += '<td>'+obj.material+'</td>';
                                html += '<td>'+obj.address+'</td>';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">'+obj.contact_info+'</td>';
                                // html += '<td class="text-center hide">'+obj.reviewed_due+'</td>';
                                html += '<td class="text-center">'+obj.compliance+'%</td>';
                                html += '<td class="text-center">'+obj.status+'</td>';
                                html += '<td class="text-center">';
                                
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-xs btnView" data-toggle="modal" onclick="btnView('+obj.ID+')"><i class="fa fa-fw fa-pencil"></i></a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-danger btn-xs btnDelete" onclick="btnDelete('+obj.ID+')"><i class="fa fa-fw fa-trash"></i></a>';
                                    }
                                    
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_1 tbody').append(html);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(response.statusActive) / parseInt(response.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(response.statusInactive) / parseInt(response.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(response.statusInactiveMonth) / parseInt(response.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(response.statusTotal) / parseInt(response.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactiveMonth+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusTotal+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            
                            $('.counterup').counterUp();
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalUpdate') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer'));
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
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            // var html = '<td class="hide">'+tbl_counter+'</td>';
                            var html = '<td>'+obj.supplier_name+'</td>';
                            html += '<td>'+obj.category+'</td>';
                            html += '<td>'+obj.material+'</td>';
                            html += '<td>'+obj.address+'</td>';
                            html += '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">'+obj.contact_info+'</td>';
                            // html += '<td class="text-center hide">'+obj.reviewed_due+'</td>';
                            html += '<td class="text-center">'+obj.compliance+'%</td>';
                            html += '<td class="text-center">'+obj.status+'</td>';
                            html += '<td class="text-center">';

                                if (obj.page == 1) {
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalView" class="btn btn-outline btn-success btn-xs btnView" data-toggle="modal" onclick="btnView('+obj.ID+')"><i class="fa fa-fw fa-pencil"></i></a>';
                                    }
                                } else {
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-xs btnView" data-toggle="modal" onclick="btnView('+obj.ID+')"><i class="fa fa-fw fa-pencil"></i></a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-danger btn-xs btnDelete" onclick="btnDelete('+obj.ID+')"><i class="fa fa-fw fa-trash"></i></a>';
                                    }
                                }

                            html += '</td>';

                            $('#tableData_1 tbody #tr_'+obj.ID).html(html);

                            // CounterUp Section
                            var pct_counter1 = (parseInt(response.statusActive) / parseInt(response.statusTotal)) * 100;
                            var pct_counter2 = (parseInt(response.statusInactive) / parseInt(response.statusTotal)) * 100;
                            var pct_counter3 = (parseInt(response.statusInactiveMonth) / parseInt(response.statusTotal)) * 100;
                            var pct_counter4 = (parseInt(response.statusTotal) / parseInt(response.statusTotal)) * 100;
                            $(".counterup_1 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusActive+'"></span>');
                            $(".counterup_1 .progress-bar").width(parseInt(pct_counter1) + '%');
                            $(".counterup_1 .status-number").html(parseInt(pct_counter1) + '%');

                            $(".counterup_2 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactive+'"></span>');
                            $(".counterup_2 .progress-bar").width(parseInt(pct_counter2) + '%');
                            $(".counterup_2 .status-number").html(parseInt(pct_counter2) + '%');

                            $(".counterup_3 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusInactiveMonth+'"></span>');
                            $(".counterup_3 .progress-bar").width(parseInt(pct_counter3) + '%');
                            $(".counterup_3 .status-number").html(parseInt(pct_counter3) + '%');

                            $(".counterup_4 h3").html('<span class="counterup" data-counter="counterup" data-value="'+response.statusTotal+'"></span>');
                            $(".counterup_4 .progress-bar").width(parseInt(pct_counter4) + '%');
                            $(".counterup_4 .status-number").html(parseInt(pct_counter4) + '%');
                            
                            $('.counterup').counterUp();
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // Requirement Section
            function btnNew_Requirement(modal, other) {
                var requirement_other = $("#inputRequirementOther_"+modal).val();

                if (requirement_other != "") {
                    let x = Math.floor((Math.random() * 100) + 1);

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+requirement_other;
                        html += '<input type="checkbox" value="'+requirement_other+'" name="document_other[]" data-id="'+x+'" onchange="checked_RequirementOther(this, '+modal+', '+other+')" checked />';
                        html += '<span></span>';
                    html += '</label>';
                    $('#tabDocuments_'+modal+' .mt-checkbox-list:first').append(html);

                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+requirement_other+'" required /><b>'+requirement_other+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                                data += '<option value="4">Sharepoint URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center col-sop">';
                            data += '<input type="file" class="form-control hide" name="document_other_sop[]" />';
                            data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+x+', 0, 1, '+modal+')">Upload</a>';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_info[]" />';
                            data += '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('+x+', 0, 1, '+modal+')">Upload </a>';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                            data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+x+', 0, 1, '+modal+')">Upload</a>';
                        data += '</td>';
                        
                        data += '<td rowspan="2" class="text-center" href="#modalChecklist" data-toggle="modal" onclick="btnChecklist('+modal+', 1, '+x+', '+x+', 0, '+switch_user_id+')">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 34 || switch_user_id == 27 || switch_user_id == 1738) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal, other);
                    widget_date_clear_other(x, modal, other);
                }
            }
            function checked_Requirement(id, modal, main, checked) {
                if (id.checked == true) {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalView_Customer_Requirement="+id.value+"&modal="+modal+"&main="+main,
                        dataType: "html",                  
                        success: function(data){       
                            $('#tableData_Requirement_'+modal+' tbody').append(data);
                            widget_date(id.value, modal);

                            if (checked == 0) { widget_date_clear(id.value, modal); }
                        }
                    });
                } else {
                     $('#tableData_Requirement_'+modal+' tbody .tr_'+id.value).remove();
                }
            }
            function checked_RequirementOther(id, modal) {
                var x = $(id).attr("data-id");
				var current_userID = '<?php echo $current_userID; ?>';
				var current_userFullName = '<?php echo htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? ''); ?>';

                if (id.checked == true) {
                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+id.value+'" required /><b>'+id.value+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                                data += '<option value="4">Sharepoint URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';

                        // if (current_client == 0) {
                            data += '<td rowspan="2" class="text-center col-sop">';
                                data += '<input type="file" class="form-control hide" name="document_other_sop[]" />';
                                data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+id+', 0, 1, '+modal+')">Upload </a>';
                            data += '</td>';
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_info[]" />';
                                data += '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('+id+', 0, 1, '+modal+')">Upload </a>';
                            data += '</td>';
							data += '<td rowspan="2" class="text-center">';
								data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
								data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+id+', 0, 1, '+modal+')">Upload </a>';
							data += '</td>';
                        // }
                        
                        wholeNumber = parseInt(x.replace(/\D/g, ""), 10);
                        data += '<td rowspan="2" class="text-center" href="#modalChecklist" data-toggle="modal" onclick="btnChecklist('+modal+', 1, '+wholeNumber+', '+wholeNumber+', 0, '+switch_user_id+')">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 34 || switch_user_id == 27 || switch_user_id == 1738) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<select class="form-control " name="document_other_reviewed[]">';
                                                data += '<option value="0">Select</option>';
                                                data += '<option value="'+current_userID+'">'+current_userFullName+'</option>';
                                            data += '</select>';
                                        data += '</div>';
                                    data += '</div>';
									data += '<div class="col-md-3">';
	                                    data += '<div class="form-group">';
	                                        data += '<label class="control-label">Reviewed Date</label>';
	                                        data += '<input type="date" class="form-control" name="document_other_reviewed_date[]">';
	                                    data += '</div>';
	                                data += '</div>';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<select class="form-control " name="document_other_approved[]">';
                                                data += '<option value="0">Select</option>';
                                                data += '<option value="'+current_userID+'">'+current_userFullName+'</option>';
                                            data += '</select>';
                                        data += '</div>';
                                    data += '</div>';
									data += '<div class="col-md-3">';
	                                    data += '<div class="form-group">';
	                                        data += '<label class="control-label">Reviewed Date</label>';
	                                        data += '<input type="date" class="form-control" name="document_other_approved_date[]">';
	                                    data += '</div>';
	                                data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal, other);
                    widget_date_clear_other(x, modal, other);
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+x).remove();
                }
            }

            // Requirement Material Section
            function btnNew_Requirement_Material(modal, other) {
                var requirement_other = $("#inputRequirementOther_Material_"+modal).val();

                if (requirement_other != "") {
                    let x = Math.floor((Math.random() * 100) + 1);

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+requirement_other;
                        html += '<input type="checkbox" value="'+requirement_other+'" name="document_other[]" data-id="'+x+'" onchange="checked_RequirementOther_Material(this, '+modal+', '+other+')" checked />';
                        html += '<span></span>';
                    html += '</label>';
                    $('#tabDocuments_Material_'+modal+' .mt-checkbox-list:first').append(html);

                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+requirement_other+'" required /><b>'+requirement_other+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center col-sop">';
                            data += '<input type="file" class="form-control hide" name="document_other_sop[]" />';
                            data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+x+', 0, 2, '+modal+')">Upload </a>';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_info[]" />';
                            data += '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('+x+', 0, 2, '+modal+')">Upload </a>';
                        data += '</td>';
                        data += '<td rowspan="2" class="text-center">';
                            data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                            data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+x+', 0, 2, '+modal+')">Upload </a>';
                        data += '</td>';

                        data += '<td rowspan="2" class="text-center" href="#modalChecklist" data-toggle="modal" onclick="btnChecklist('+modal+', 1, '+x+', '+x+', 1, '+switch_user_id+')">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 1 || switch_user_id == 34 || switch_user_id == 464) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    if (other == 1) {
                        $('#tableData_Requirement_Other_'+modal+' tbody').append(data);
                    } else {
                        $('#tableData_Requirement_Material_'+modal+' tbody').append(data);
                    }

                    widget_date_other(x, modal, other);
                    widget_date_clear_other(x, modal, other);
                }
            }
            function checked_Requirement_Material(id, modal, main, checked) {
                if (id.checked == true) {
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalView_Customer_Requirement_Material="+id.value+"&modal="+modal+"&main="+main,
                        dataType: "html",                  
                        success: function(data){
                            $('#tableData_Requirement_Material_'+modal+' tbody').append(data);
                            widget_date(id.value, modal);

                            // if (checked == 0) { widget_date_clear(id.value, modal); }
                        }
                    });
                } else {
                     $('#tableData_Requirement_Material_'+modal+' tbody .tr_'+id.value).remove();
                }
            }
            function checked_RequirementOther_Material(id, modal, other) {
                var x = $(id).attr("data-id");
                var current_userID = '<?php echo $current_userID; ?>';
                var current_userFullName = '<?php echo htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? ''); ?>';

                if (id.checked == true) {
                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+id.value+'"" required /><b>'+id.value+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';

                        // if (current_client == 0) {
                            data += '<td rowspan="2" class="text-center col-sop">';
                                data += '<input type="file" class="form-control hide" name="document_other_sop[]" />';
                                data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+id+', 0, 2, '+modal+')">Upload </a>';
                            data += '</td>';
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_info[]" />';
                                data += '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('+id+', 0, 2, '+modal+')">Upload </a>';
                            data += '</td>';
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                                data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+id+', 0, 2, '+modal+')">Upload </a>';
                            data += '</td>';
                        // }

                        wholeNumber = parseInt(x.replace(/\D/g, ""), 10);
                        data += '<td rowspan="2" class="text-center" href="#modalChecklist" data-toggle="modal" onclick="btnChecklist('+modal+', 1, '+wholeNumber+', '+wholeNumber+', 1, '+switch_user_id+')">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';
                            
                            if (switch_user_id == 1 || switch_user_id == 34 || switch_user_id == 464) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<select class="form-control " name="document_other_reviewed[]">';
                                                data += '<option value="0">Select</option>';
                                                data += '<option value="'+current_userID+'">'+current_userFullName+'</option>';
                                            data += '</select>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed Date</label>';
                                            data += '<input type="date" class="form-control" name="document_other_reviewed_date[]">';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<select class="form-control " name="document_other_approved[]">';
                                                data += '<option value="0">Select</option>';
                                                data += '<option value="'+current_userID+'">'+current_userFullName+'</option>';
                                            data += '</select>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-3">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed Date</label>';
                                            data += '<input type="date" class="form-control" name="document_other_approved_date[]">';
                                        data += '</div>';
                                    data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    if (other == 1) {
                        $('#tableData_Requirement_Material_Other_'+modal+' tbody').append(data);
                    } else {
                        $('#tableData_Requirement_Material_'+modal+' tbody').append(data);
                    }
                    
                    widget_date_other(x, modal, other);
                    widget_date_clear_other(x, modal, other);
                } else {
                    if (other == 1) {
                        $('#tableData_Requirement_Material_Other_'+modal+' tbody .tr_other_'+x).remove();
                    } else {
                        $('#tableData_Requirement_Material_'+modal+' tbody .tr_other_'+x).remove();
                    }
                }
            }

            // Record
            function btnNew_Record(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Record="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewRecord .modal-body").html(data);
                        widget_dates_modal('modalNewRecord');
                    }
                });
            }
            $(".modalNewRecord").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Record',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Record'));
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
                            $('#tableData_Record_'+obj.modal+' tbody').append(obj.data);
                            $('#modalNewRecord').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Record(id, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Record="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditRecord .modal-body").html(data);
                        widget_dates_modal('modalEditRecord');
                    }
                });
            }
            $(".modalEditRecord").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Record',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Record'));
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
                            $('#tableData_Record_'+obj.modal+' tbody #tr_'+obj.ID).html(obj.data);
                            $('#modalEditRecord').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnRemove_Record(id, modal) {
                $('#tableData_Record_'+modal+' tbody #tr_'+id).remove();
            }

            // Contact Section
            $(".modalSave_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Contact'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_title+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">';
                                    html += '<ul class="list-inline">';
                                        if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                        if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                        if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                        if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                    html += '</ul>';
                                html += '</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="checkbox" name="checkedContact" value="'+obj.ID+'" onclick="btnCheck_Contact('+obj.ID+', this)" />';
                                html += '</td>';
                                html += '<td class="text-center hide">';
                                    html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                                html += '</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                    
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1, \'modalEditContact\')">Edit</a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                    }
                                    
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Contact_'+obj.modal+' tbody').append(html);
                            $('#modalNewContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Contact(id, modal, view) {
                // btnReset(view);
                $('#modalNewContact form')[0].reset();
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewContact .modal-body").html(data);
                    }
                });
            }
            $(".modalUpdate_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Contact'));
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
                            var html = '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_title+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">';
                                html += '<ul class="list-inline">';
                                    if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                    if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                    if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                    if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                html += '</ul>';
                            html += '</td>';
                            html += '<td class="text-center hide">';
                                html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                            html += '</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                    html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1, \'modalEditContact\')">Edit</a>';
                                }
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                    html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                }
                                
                            html += '</td>';

                            $('#tableData_Contact_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Contact(id, modal, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditContact .modal-body").html(data);
                    }
                });
            }
            function btnCheck_Contact(id, e) {
                var notification = e.checked;
                $.ajax({    
                    type: "GET",
                    url: "function.php?btnCheck_Supplier_Contact="+id+"&n="+notification,
                    dataType: "html",                  
                    success: function(data){       
                        // $("#modalEditContact .modal-body").html(data);
                    }
                });
            }
            function btnRemove_Contact(id, modal) {
                // $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();

                if (confirm("Your item will be remove!")) {
                    $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();
                    alert('This item has been removed. Make sure to click SAVE to save the changes.');
                }
                return false;

                // swal({
                //     title: "Are you sure?",
                //     text: "Your item will be remove!",
                //     type: "warning",
                //     showCancelButton: true,
                //     confirmButtonClass: "btn-danger",
                //     confirmButtonText: "Yes, confirm!",
                //     closeOnConfirm: false
                // }, function () {
                //     $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();
                //     swal("Done!", "This item has been removed. Make sure to click SAVE to save the changes.", "success");
                // });
            }

            // Product Section
            $(".modalSave_Product").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer_Product',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer_Product'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.material_name+'</td>';
                                html += '<td>'+obj.material_id+'</td>';
                                html += '<td>'+obj.material_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                    
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    }
                                    
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Product_'+obj.modal+' tbody').append(html);
                            $('#modalNewProduct').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Product(id, modal, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Customer_Product="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewProduct .modal-body").html(data);
                        widget_formRepeater_material('New');
                        widget_dates_product('New');
                    }
                });
            }
            $(".modalUpdate_Product").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer_Product',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer_Product'));
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
                            var html = '<td>'+obj.material_name+'</td>';
                            html += '<td>'+obj.material_id+'</td>';
                            html += '<td>'+obj.material_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                    html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                }
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                    html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                }
                                
                            html += '</td>';

                            $('#tableData_Product_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditProduct').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Product(id, modal, view) {
                btnClose(view);
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Customer_Product="+id+"&m="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditProduct .modal-body").html(data);
                        widget_formRepeater_material('Edit');
                        widget_dates_product('Edit');
                    }
                });
            }
            function btnRemove_Product(id, modal) {
                $('#tableData_Product_'+modal+' tbody #tr_'+id).remove();
            }
            function btnEdit_Material(id, modal, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Material="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditMaterial .modal-body").html(data);
                        widget_formRepeater_material('Edit');
                        widget_dates_material('Edit');

						selectMulti();
						widget_tagInput();
                    }
                });
            }
            $(".modalUpdate_Material").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Material',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Material'));
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
							var html = '<td>'+obj.material_name+'</td>';
                            html += '<td>'+obj.material_description+'</td>';
                            html += '<td class="text-center">'+obj.material_active+'</td>';
                            html += '<td class="text-center">0%</td>';
                            html += '<td class="text-center">'+obj.material_id+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                    html += '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Material" onclick="btnEdit_Material('+obj.ID+', 1, \'modalEditMaterial\', 1)">Edit</a>';
                                }
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                    html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Material" onclick="btnRemove_Material('+obj.ID+', 1)">Delete</a>';
                                }
                                
                            html += '</td>';

                            $('#tableData_Material_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditMaterial').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Service Section
            $(".modalSave_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer_Service',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer_Service'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.service_name+'</td>';
                                html += '<td>'+obj.service_id+'</td>';
                                html += '<td>'+obj.service_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                    
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    }
                                    
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Service_'+obj.modal+' tbody').append(html);
                            $('#modalNewService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Service(id, modal, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Customer_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            $(".modalUpdate_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer_Service'));
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
                            var html = '<td>'+obj.service_name+'</td>';
                            html += '<td>'+obj.service_id+'</td>';
                            html += '<td>'+obj.service_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                    html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                }
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                    html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                }
                                
                            html += '</td>';

                            $('#tableData_Service_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Service(id, modal, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Customer_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            function btnRemove_Service(id, modal) {
                $('#tableData_Service_'+modal+' tbody #tr_'+id).remove();
            }

            //SOP Section
            function btnSOP(id, temp, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Supplier_SOP="+id+"&temp="+temp+"&t="+type,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalSOP .modal-body").html(data);
                    }
                });
            }
            function btnSOP_delete(id, temp) {
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
                        url: "function.php?btnDelete_Supplier_SOP"+temp,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().find('a:not(.btn-success)').remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalSave_SOP").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_SOP',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_SOP'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(4)').html(obj.view);
                            $('#modalSOP').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnSOP2(id, temp, type, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_SOP2="+id+"&temp="+temp+"&t="+type+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalSOP2 .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_SOP2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_SOP2',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_SOP2'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(4)').html(obj.view);
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first > td:nth-last-child(4)').html(obj.view2);
                            $('#modalSOP2').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //Info Section
            function btnInfo(id, temp, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Info="+id+"&temp="+temp+"&t="+type,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalInfo .modal-body").html(data);
                    }
                });
            }
            function btnInfo_delete(id, temp) {
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
                        url: "function.php?btnDelete_Supplier_Info"+temp,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().find('a:not(.btn-success)').remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalSave_Info").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Info',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Info'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(3)').html(obj.view);
                            $('#modalInfo').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnInfo2(id, temp, type, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Info2="+id+"&temp="+temp+"&t="+type+"&modal="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalInfo2 .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_Info2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Info2',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Info2'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(3)').html(obj.view);
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first > td:nth-last-child(3)').html(obj.view2);
                            $('#modalInfo2').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            //Template Section
            function btnTemplate(id, temp, type) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template="+id+"&temp="+temp+"&t="+type,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate .modal-body").html(data);
                    }
                });
            }
            function btnTemplate_delete(id, temp) {
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
                        url: "function.php?btnDelete_Supplier_Template="+temp,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().find('a:not(.btn-success)').remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalSave_Template").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(2)').html(obj.view);
                            $('#modalTemplate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnTemplate2(id, temp, type, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template2="+id+"&temp="+temp+"&t="+type+"&modal="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate2 .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_Template2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template2',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template2'));
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
                            $('#template_'+obj.t+' tbody #tr_'+obj.ID+' > td:nth-last-child(2)').html(obj.view);
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first > td:nth-last-child(2)').html(obj.view2);
                            $('#modalTemplate2').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            // Checklist Section
            function btnChecklist(modal, type, id, doc, p, u) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Checklist="+id+"&d="+doc+"&t="+type+"&m="+modal+"&p="+p+"&u="+u,
                    dataType: "html",
                    success: function(data){
                        $("#modalChecklist .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            function btnChecklistSetting(id, u) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_ChecklistSetting="+id+"&u="+u,
                    dataType: "html",
                    success: function(data){
                        $("#modalChecklistSetting .modal-body").html(data);
                        $(".make-switch").bootstrapSwitch();
                    }
                });
            }
            function btnChecklistEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalEdit_Checklist="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalChecklistEdit .modal-body").html(data);
                    }
                });
            }
            function btnDeleteChecklist(id, e) {
                if (confirm("Your item will be deleted!")) {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_Checklist="+id,
                        dataType: "html",
                        success: function(response){
                            $(e).parent().remove();
                            alert('This item has been deleted');
                        }
                    });
                }
                return false;
            }
            function checkListing(modal, id, doc, e, p) {
                var checklist_req_id = $('#modalChecklist .modal-body input[name="ID"]').val();
                var checklist_type = $('#modalChecklist .modal-body input[name="t"]').val();
                var checklist_qty = $('#modalChecklist .modal-body input[type="checkbox"]').length;
                var checklist_checked = $('#modalChecklist .modal-body input[type="checkbox"]:checked').length;
                var percentage = 0;
                if (checklist_checked > 0) {
                    percentage = Math.round((checklist_checked / checklist_qty) * 100);
                }

                if (p == 1) {
                    if (checklist_type == 0) {
                        if (modal == 1) {
                            $('#modalNewMaterial .tr_'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                        } else if (modal == 2) {
                            $('#modalEditMaterial .tr_'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                        }
                    } else {
                        if (modal == 1) {
                            $('#modalNewMaterial .tr_other_o'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                        } else if (modal == 2) {
                            $('#modalEditMaterial .tr_other_o'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                        }
                    }
                } else {
                    if (checklist_type == 0) {
                        $('#tabDocuments_'+modal+' .tr_'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                    } else {
                        $('#tabDocuments_'+modal+' .tr_other_o'+checklist_req_id+':first > td:last-child').html(percentage+'%');
                    }
                }
                
                $.ajax({
                    type: "GET",
                    url: "function.php?modalCheck_Listing="+id+"&d="+doc+"&v="+e.checked,
                    dataType: "html",                  
                    success: function(data){
                        // alert(data);
                    }
                });
            }
            $(".modalChecklist").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Checklist',true);

                var l = Ladda.create(document.querySelector('#btnSave_Checklist'));
                l.start();
                
                $.ajax({
                    url:'function.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {

                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('#modalChecklist .modal-body ul').append(obj.data);
                            $('#modalChecklist .modal-body .input-group input').val('');
                            $('#modalChecklist .modal-body .input-group input').focus();
                            $(".make-switch").bootstrapSwitch();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            $(".modalChecklistSetting").submit(function(e){
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_ChecklistSetting',true);

                var l = Ladda.create(document.querySelector('#btnSave_ChecklistSetting'));
                l.start();
                
                $.ajax({
                    url:'function.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {

                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            $('#modalChecklistSetting .modal-body ul').append(obj.data);
                            $('#modalChecklistSetting .modal-body .input-group input').val('');
                            $('#modalChecklistSetting .modal-body .input-group input').focus();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            });
            $(".modalChecklistEdit").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Checklist',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Checklist'));
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

                            $('#modalChecklist .modal-body ul .li_'+obj.ID+' > span').html(obj.description);
                            $('#modalChecklistEdit').modal('hide');
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
