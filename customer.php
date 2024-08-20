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
        column-count: 5;
        column-gap: 40px;
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
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" onclick="btnReset('modalNew')">Add New Customer</a>
                                                </li>
                                                <?php if($switch_user_id == 185 OR $switch_user_id == 1  OR $switch_user_id == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                                <li class="pictogram-align-between">
                                                    <a href="#modalReport" data-toggle="modal" onclick="btnReport(2)">Report</a>
                                                    
                                                    <?php
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
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_actions_sent" data-toggle="tab">Sent</a>
                                        </li>
                                        <li>
                                            <a href="#tab_actions_received" data-toggle="tab">Received</a>
                                        </li>
                                        <?php
                                            if ($current_client == 0) {
                                                echo '<li>
                                                    <a href="#tab_actions_template" data-toggle="tab">Template</a>
                                                </li>';
                                            }
                                        ?>
                                       <li>
											<a href="#tab_customer_analytics" data-toggle="tab">Analytics</a>
									   </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
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
                                                <tbody>
                                                    <?php
                                                        $sql_s1 = '';
                                                        $sql_s2 = '';
                                                        if ($current_userEmployerID != 34) {
                                                            $sql_s1 = ' AND s1.facility = 0 ';
                                                            $sql_s2 = ' AND s2.facility = 0 ';
                                                        }
                                                        $result = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count) AS
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
                                                                CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count

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
                                                                WHERE s1.page = 2
                                                                AND s1.is_deleted = 0 
                                                                AND s1.user_id = $switch_user_id
                                                                $sql_s1
                                                                
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
                                                                CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count

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
                                                                AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0
                                                                WHERE s2.page = 2
                                                                AND s2.is_deleted = 0 
                                                                AND s2.user_id = $switch_user_id
                                                                $sql_s2
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
                                                                SUM(d_count) AS d_counting
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

                                                            ORDER BY s_name" );
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
                                                                $d_compliance = $row["d_compliance"];
                                                                $d_counting = $row["d_counting"];
                                                                if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }

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
                                                                            $selectMaterial = mysqli_query( $conn,"SELECT
                                                                                c.service_category AS c_service_category
                                                                                FROM tbl_supplier_service AS s

                                                                                LEFT JOIN (
                                                                                    SELECT
                                                                                    *
                                                                                    FROM tbl_service_category
                                                                                ) AS c
                                                                                ON s.service_name = c.id
                                                                                WHERE s.ID = $value" );
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
                                                                            $selectMaterial = mysqli_query( $conn,"SELECT
                                                                                p.name AS p_name
                                                                                FROM tbl_supplier_material  AS m

                                                                                LEFT JOIN (
                                                                                    SELECT 
                                                                                    * 
                                                                                    FROM tbl_products
                                                                                ) AS p
                                                                                ON m.material_name = p.ID
                                                                                WHERE m.ID = $value" );
                                                                            $rowMaterial = mysqli_fetch_array($selectMaterial);
                                                                            array_push($material_result, $rowMaterial['p_name']);
                                                                        }
                                                                        $material = implode(', ', $material_result);
                                                                    }
                                                                }
                                                                
                                                                $address_array = array();
                                                                $address = $row["s_address"];
                                                                $address_arr = explode(" | ", $address);
                                                                if (COUNT($address_arr) < 5) {
                                                                    $address_arr = explode(", ", $address);
                                                                }
                                                                array_push($address_array, htmlentities($address_arr[1]));
                                                                array_push($address_array, htmlentities($address_arr[2]));
                                                                array_push($address_array, htmlentities($address_arr[3]));
                                                                array_push($address_array, $address_arr[0]);
                                                                array_push($address_array, $address_arr[4]);
                                                                $address_arr = implode(", ", $address_array);

                                                                echo '<tr id="tr_'.$s_ID.'">';
                                                                    // <td class="hide">'.$s_ID.'</td>
                                                                    echo '<td>'.htmlentities($s_name ?? '').'</td>
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
                                                                    echo '<td class="text-center">'.intval($compliance).'%</td>
                                                                    <td class="text-center">'.$status_type[$s_status].'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>
                                                                            <a href="#modalChart" class="btn btn-info btn-sm btnChart" data-toggle="modal" data-id="'. $s_ID .'">
																			<i class="fas fa-chart-line"></i> </a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('. $s_ID .')">Delete</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
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
                                                <tbody>
                                                    <?php
                                                        $result = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_user_id, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count) AS
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
															    CASE WHEN d1.ID > 0 THEN 1 ELSE 0 END AS d_count

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
															    WHERE s1.page = 1
															    AND s1.is_deleted = 0 
															    AND s1.email = '".$current_userEmail."'
															    $sql_s1
															    
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
															    CASE WHEN d2.ID > 0 THEN 1 ELSE 0 END AS d_count

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
															    AND FIND_IN_SET(d2.name, REPLACE(s2.document_other, ' | ', ',')  )   > 0
															    WHERE s2.page = 1
															    AND s2.is_deleted = 0 
															    AND s2.email = '".$current_userEmail."'
															    $sql_s2
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
															    SUM(d_count) AS d_counting
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

															ORDER BY s_name" );
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
                                                                $d_compliance = $row["d_compliance"];
                                                                $d_counting = $row["d_counting"];
                                                                if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }

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
                                                                $address = $row["s_address"];
                                                                $address_arr = explode(" | ", $address);
                                                                if (COUNT($address_arr) < 5) {
                                                                    $address_arr = explode(", ", $address);
                                                                }
                                                                array_push($address_array, htmlentities($address_arr[1]));
                                                                array_push($address_array, htmlentities($address_arr[2]));
                                                                array_push($address_array, htmlentities($address_arr[3]));
                                                                array_push($address_array, $address_arr[0]);
                                                                array_push($address_array, $address_arr[4]);
                                                                $address_arr = implode(", ", $address_array);

                                                                echo '<tr id="tr_'.$s_ID.'">';
                                                                    // <td class="hide">'.$s_ID.'</td>
                                                                    echo '<td>'.htmlentities($s_name ?? '').'</td>
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
                                                                    echo '<td class="text-center">'.intval($compliance).'%</td>
                                                                    <td class="text-center">'.$status_type[$s_status].'</td>
                                                                    <td class="text-center">
                                                                        <a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab_actions_template">
                                            <?php
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
                                            ?>
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover" id="tableData_3">
                                                    <thead>
                                                        <tr>
                                                            <th>Template Name</th>
                                                            <th class="text-center" style="width: 185px;">File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row["ID"];
                                                                    $name = htmlentities($row["name"] ?? '');
    
                                                                    echo '<tr id="tr_'.$ID.'">
                                                                        <td>'.$name.'</td>
                                                                        <td class="text-center">';
    
                                                                            $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE user_id = $switch_user_id AND LENGTH(file) > 0 AND requirement_id = $ID" );
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
    
                                                                                echo '<p style="margin: 0;">
                                                                                    <a href="'.$temp_file.'" data-src="'.$temp_file.'" data-fancybox data-type="'.$type.'" class="btn btn-xs btn-info"><i class="fa fa-search"></i></a>
                                                                                    <a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('.$ID.', '.$temp_ID.')"><i class="fa fa-cloud-upload"></i></a>
                                                                                    <a href="javascript:;" data-type="'.$type.'" class="btn btn-xs btn-danger" onclick="btnTemplate_delete('.$ID.', '.$temp_ID.')"><i class="fa fa-trash"></i></a>
                                                                                </p>';
                                                                            } else {
                                                                                echo '<a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('.$ID.', 0)"><i class="fa fa-cloud-upload"></i></a>';
                                                                            }
                                                                        echo '</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

									    <!-- Nelmar Customer Analytics -->
                                        <div class="tab-pane" id="tab_customer_analytics">                       
												<div class="row widget-row">   																																	
													<div class="col-md-6">                                     
														<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
															<h3 class="d-flex justify-content-center">Send</h3>   
																<div class="widget-thumb-wrap">                                       
																	<div id="waterfallChart1" style="width: 100%; height: 500px;">																		
																	</div>                                        
																</div>
															</div>     
														</div>  
													<div class="col-md-6">                                     
														<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
															<h3 class="d-flex justify-content-center">Received</h3>   
																<div class="widget-thumb-wrap">                                       
																	<div id="receivedchartdiv" style="width: 100%; height: 500px;">																		
																	</div>                                        
																</div>
															</div>     
														</div>  													
													<div class="col-md-6">                                     
														<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">   
															<h3 class="d-flex justify-content-center">Requirements</h3>   
																<div class="widget-thumb-wrap">                                       
																	<div id="requirementchartdiv1" style="width: 100%; height: 500px;">																		
																	</div>                                        
																</div>
															</div>     
														</div> 
												    <div class="col-md-6"> 
													    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">                                         
														    <h3 class="d-flex justify-content-center">Frequency</h3>
															    <div class="widget-thumb-wrap">
																    <div id="donutChart2" style="width: 90%; height: 400px;">
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
                            <!-- END BORDERED TABLE PORTLET-->
                    </div>

                        <!-- MODAL AREA-->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
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
                                                        <a href="#tabDocuments_1" data-toggle="tab">Requirements</a>
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
                                                                    <select class="form-control" name="category" onchange="changedCategory(this)" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $selectCategory = mysqli_query( $conn,"SELECT * FROM tbl_supplier_category WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectCategory) > 0 ) {
                                                                                while($row = mysqli_fetch_array($selectCategory)) {
                                                                                    echo '<option value="'.$row["ID"].'">'.htmlentities($row["name"] ?? '').'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Industry</label>
                                                                    <select class="form-control" name="industry" onchange="changeIndustry(this.value, 1)" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $selectIndustry = mysqli_query( $conn,"SELECT * FROM tbl_supplier_industry WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
                                                                            if ( mysqli_num_rows($selectIndustry) > 0 ) {
                                                                                while($row = mysqli_fetch_array($selectIndustry)) {
                                                                                    echo '<option value="'.$row["ID"].'">'.htmlentities($row["name"] ?? '').'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
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
                                                                $selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement ORDER BY name" );
                                                                if ( mysqli_num_rows($selectRequirement2) > 0 ) {
                                                                    while($row = mysqli_fetch_array($selectRequirement2)) {
                                                                        echo '<label class="mt-checkbox mt-checkbox-outline"> '.htmlentities($row["name"] ?? '').'
                                                                            <input type="checkbox" value="'.$row["ID"].'" name="document[]"  onchange="checked_Requirement(this, 2, 0, 0)" />
                                                                            <span></span>
                                                                        </label>';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $current_client == 0 ? 'Other':'Add Requirement'; ?></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="inputRequirementOther" id="inputRequirementOther_1" placeholder="Specify">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-success" type="button" onclick="btnNew_Requirement(1)">Add</button>
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
                                                                        <th style="width: 250px;" class="text-center">Document Validity Period</th>
                                                                        <th style="width: 165px;" class="text-center <?php echo $current_client == 0 ? '':'hide'; ?>">Template</th>
                                                                        <th style="width: 165px;" class="text-center">Compliance</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
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
                                                    <?php if ($current_userEmployeeID == 0 AND $current_userID <> 115) { ?>
                                                            <div class="tab-pane" id="tabPortal_1">
                                                                <h4><strong>Portal</strong></h4>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Department</label>
                                                                            <select class="form-control mt-multiselect department_id" name="department_id[]" onchange="changeDepartment(this, 1)" multiple="multiple">
                                                                                <?php
                                                                                    $selectDepartment = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE status = 1 AND user_id = $switch_user_id ORDER BY title");
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
                                                                                    $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND user_id = $switch_user_id ORDER BY first_name");
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Customer" id="btnSave_Customer" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Customer Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer" id="btnUpdate_Customer" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Contact" id="btnUpdate_Supplier_Contact" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer_Product" id="btnUpdate_Customer_Product" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Customer_Service" id="btnUpdate_Customer_Service" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template" id="btnSave_Supplier_Template" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Template2" id="btnSave_Supplier_Template2" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                                        <th style="width: 200px;">Customer Name</th>
                                                        <th>Users</th>
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
                    <!-- / END MODAL AREA -->                                    
                </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>

        
        <?php if($switch_user_id == 464) { ?>
            <script src="AnalyticsIQ/customer_chart.js"></script>
        <?php } ?>	
        
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
            $(document).ready(function(){
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

            function changedCategory(sel) {
                if (sel.value == 3) {
                    $('.tabProducts').addClass('hide');
                    $('.tabService').removeClass('hide');
                } else {
                    $('.tabProducts').removeClass('hide');
                    $('.tabService').addClass('hide');
                }
            }
            function changeIndustry(id, modal) {
				var client = '<?php echo $current_client; ?>';

				if (client == 0) {
                    var country = $('#tabBasic_'+modal+' select[name="countries"]').val();
                    if (id == 13 || id == 22 || id == 25) { id = id; }
                    else { id = 0; }
                    $.ajax({
                        type: "GET",
                        url: "function.php?modalView_Customer_Industry="+id+"&c="+country,
                        dataType: "html",                  
                        success: function(data){       
                            $('#tabDocuments_'+modal+' .mt-checkbox-list').html(data);
                            $('#tableData_Requirement_'+modal+' tbody').html('');
                        }
                    });
				}
            }
            function changeCountry(modal) {
                var industry = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                changeIndustry(industry, modal);
            }
            function changeFile(e, val) {
                // if (val != '') {
                //     $(e).parent().parent().find('td .document_filename').attr("required", true);
                //     $(e).parent().parent().find('td .daterange').attr("required", true);
                // } else {
                //     $(e).parent().parent().find('td .document_filename').attr("required", false);
                //     $(e).parent().parent().find('td .daterange').attr("required", false);
                // }
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

            function btnView(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Customer="+id,
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
            function widget_date_other(id, modal) {
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
            function widget_date_clears(e) {
                $(e).parent().prev('.daterange').val('');
            }
            function widget_date_clear(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').val('');
            }
            function widget_date_clear_other(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').val('');
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
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
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
                                    html += '<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                } else {
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
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
            function btnNew_Requirement(modal) {
                var requirement_other = $("#inputRequirementOther_"+modal).val();
                var switch_user_id = '<?php echo $switch_user_id; ?>';

                if (requirement_other != "") {
                    let x = Math.floor((Math.random() * 100) + 1);

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+requirement_other;
                        html += '<input type="checkbox" value="'+requirement_other+'" name="document_other[]" data-id="'+x+'" onchange="checked_RequirementOther(this, '+modal+')" checked />';
                        html += '<span></span>';
                    html += '</label>';
                    $('#tabDocuments_'+modal+' .mt-checkbox-list').append(html);

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
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" style="display: none;" placeholder="https://" />';
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

                        if (current_client == 0) {
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                                data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+x+', 0, '+modal+')">Upload</a>';
                            data += '</td>';
                        }
                        
                        data += '<td rowspan="2" class="text-center">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 5) {
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
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
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
                var switch_user_id = '<?php echo $switch_user_id; ?>';

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
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" style="display: none;" placeholder="https://" />';
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

                        if (current_client == 0) {
							data += '<td rowspan="2" class="text-center">';
								data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
								data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+id+', 0, '+modal+')">Upload </a>';
							data += '</td>';
                        }
                        
                        data += '<td rowspan="2" class="text-center">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 5) {
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
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+x).remove();
                }
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
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1, \'modalEditContact\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
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
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1, \'modalEditContact\')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
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
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
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
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
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
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
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
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
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

            //Template Section
            function btnTemplate(id, temp) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template="+id+"&temp="+temp,
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
                            $dataTemp = '<a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('+id+', '+temp+')"><i class="fa fa-cloud-upload"></i></a>';
                            $('#tableData_3 tbody #tr_'+id+' > td:last-child').html($dataTemp);
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
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnTemplate2(id, temp, modal) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Template2="+id+"&temp="+temp+"&modal="+modal,
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
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first-child > td:nth-last-child(2)').html(obj.view2);
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate2').modal('hide');
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