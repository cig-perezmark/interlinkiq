<?php 
    $title = "Supplier";
    $site = "supplier";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php');
    
    $g_d = 0;
	$g_u = 0;
	$g_f = 0;
	$encoded_d = '';
	$encoded_u = '';
	$encoded_f = '';
	
	if (isset($_GET['d'])) { $encoded_d = urlencode($_GET['d']); }
	if (isset($_GET['u'])) { $encoded_u = urlencode($_GET['u']); }
	if (isset($_GET['f'])) { $encoded_f = urlencode($_GET['f']); }
    
    if (!empty($encoded_d) AND !empty($encoded_u) AND !empty($encoded_f)) {
        $selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
        if ( mysqli_num_rows($selectAPI) > 0 ) {
            $rowAPI = mysqli_fetch_array($selectAPI);
            $api_key = $rowAPI["ID"]; // 32 chars for AES-256
        }
        
        $decoded_d = base64_decode(urldecode($encoded_d));
        $decoded_u = base64_decode(urldecode($encoded_u));
        $decoded_f = base64_decode(urldecode($encoded_f));

        // Extract IV (first 16 bytes) and ciphertext
        $api_iv_d = substr($decoded_d, 0, 16);
        $api_iv_u = substr($decoded_u, 0, 16);
        $api_iv_f = substr($decoded_f, 0, 16);
        
        $api_ciphertext_d = substr($decoded_d, 16);
        $api_ciphertext_u = substr($decoded_u, 16);
        $api_ciphertext_f = substr($decoded_f, 16);

        $g_d = openssl_decrypt($api_ciphertext_d, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv_d);
        $g_u = openssl_decrypt($api_ciphertext_u, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv_u);
        $g_f = openssl_decrypt($api_ciphertext_f, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv_f);
    }
    
    $selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
    if ( mysqli_num_rows($selectAPI) > 0 ) {
        $rowAPI = mysqli_fetch_array($selectAPI);
        $api_key = $rowAPI["ID"]; // 32 chars for AES-256
        $api_iv = openssl_random_pseudo_bytes(16);
    }
?>
<style type="text/css">
    /*.bootstrap-tagsinput { min-height: 100px; }*/
    .mt-checkbox-list {
        column-count: 3;
        column-gap: 40px;
    }
    @media only screen and (max-width: 600px) {
        .mt-checkbox-list {
            column-count: 1;
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
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

	.txta {
		width: 100%;
		max-width: 500px;
		min-height: 26px;
		font-family: Arial, sans-serif;
		font-size: 16px;
		overflow: hidden;
		line-height: 1.4;
		border: 0;
		resize: none;
	}
    table.table-bordered.dataTable thead > tr:last-child th:last-child {
		border-right-width: unset;
	}
	#tableData_category tfoot input {
	    border: 1px solid #ccc;
	    padding: 1rem;
	    width: 100%;
	}

    #waterfallChart1, #donutChart2 {
        width: 100%;
        height: 500px;
    }

    @media (max-width: 768px) {
        #waterfallChart1, #donutChart2 {
            height: 300px;
        }
    }

   #supplierchartdiv, #compliancePieChartDiv, #materialDonutChartDiv {
        width: 100%;
        height: 500px;
    } 
    
    .mt-repeater .mt-repeater-item {
        border-bottom: unset;
        padding-bottom: unset;
    }

    <?php 
        if ($current_userEmployerID != 34 AND $current_userEmployerID != 1 AND $current_userEmployerID != 464) {
            echo '.col-sop {
                display: none !important;
            }';
        }
        if ($switch_user_id == 1984 OR $switch_user_id == 1986) {
            echo '.col-specification,
            .col-contact,
            .col-category  {
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
                                        <small>Total Active Supplier</small>
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
                                        <small>Total Inactive Supplier</small>
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
                                        <small>Current Inactive Supplier</small>
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
                                        <small>Total Supplier</small>
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
                                        <span class="icon-basket-loaded font-dark"></span>
                                        <span class="caption-subject font-dark bold uppercase">List of <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'FSVP / IOR Shippers':'Supplier'; ?></span>
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
            												<li class="pictogram-align-between">
            													<a data-toggle="modal" href="#modalImportPreview" onclick="btnClear_Import()">Import Supplier</a>';
            													
                                                                $pictogram = 'sup_import';
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
                                                            <li>
                                                                <a data-toggle="modal" href="#modalNew" onclick="btnReset(\'modalNew\')">Add New '; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; echo '</a>
                                                            </li>';
                                                            
                                                            if($switch_user_id == 185 OR $switch_user_id == 1  OR $switch_user_id == 163) {
                                                                echo '<li>
                                                                    <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                                </li>';
                                                            }
                                                            
                                                            echo '<li class="pictogram-align-between">
                                                                <a href="#modalReport" data-toggle="modal" onclick="btnReport(1)">Report</a>';
                                                                
                                                                $pictogram = 'sup_report';
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
                                                    <a href="#tab_actions_sent" data-toggle="tab" onclick="selectTab(0)">Sent</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_actions_received" data-toggle="tab" onclick="selectTab(0)">Received</a>
                                                </li>
        										<li>
        											<a href="#tab_actions_category" data-toggle="tab" onclick="selectTab(2)">Category</a>
        										</li>
        										<li>
        											<a href="#tab_actions_requirement" data-toggle="tab" onclick="selectTab(0)">Requirement</a>
        										</li>
                                                <li>
                                                    <a href="#tab_actions_template" data-toggle="tab" onclick="selectTab(0)">Setting</a>
                                                </li>
                                                <li>
        											<a href="#tab_supplier_analytics" data-toggle="tab" onclick="selectTab(3)">Analytics</a>
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
            										<div class="table-responsive">
            											<select class="form-control margin-bottom-15" id="filterSent">
            												<option value="">Select</option>
            												<option value="1">Foreign Supplier</option>
            												<option value="2">Local Supplier</option>
            												<option value="3">Contract Service Provider</option>
            												<option value="4">Contract Manufacturer</option>
            											</select>
                                                        <table class="table table-bordered table-hover" id="tableData_1">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper No.':'Vendor Code'; echo '</th>
                                                                    <th rowspan="2">'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper':'Vendor'; echo ' Name</th>
                                                                    <th rowspan="2" class="col-category col-type">Category</th>
                                                                    <th rowspan="2">Materials'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'/Services'; echo '</th>';
                                                                    
        															if($switch_user_id != 1211 AND $switch_user_id != 1684 AND $switch_user_id != 1984 AND $switch_user_id != 1986) {
        																echo '<th rowspan="2" class="col-specification">Specification File</th>';
        															}
            														
                                                                    echo '<th rowspan="2">'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper ':''; echo 'Address</th>
            														<th rowspan="2" class="text-center col-iso">Country</th>
                                                                    <th colspan="2" class="text-center col-contact">Contact Details</th>
                                                                    <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                                    <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                                    <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="col-contact">Name</th>
                                                                    <th class="col-contact">Contact Info</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                            
        														$sql_custom = '';
        														$sql_custom_union = '';
                                                                $req_tr = '';
        														if($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1738) { $sql_custom = ' GROUP BY s_ID '; }
        														if($switch_user_id != 1211 AND $switch_user_id != 1486 AND $switch_user_id != 1774 AND $switch_user_id != 1832 AND $switch_user_id != 1773 AND $switch_user_id != 1850) {
        														    $sql_custom_union = " 
        															    UNION ALL
        															    
        															    SELECT
        															    s2.ID AS s_ID,
        															    s2.vendor_code AS s_vendor_code,
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
        															        WHERE archived = 0 AND type = 1
        															        AND ID IN (
        															            SELECT
        															            MAX(ID)
        															            FROM tbl_supplier_document
        															            WHERE archived = 0 AND type = 1
        															            GROUP BY name, supplier_id
        															        )
        															    ) AS d2
        															    ON s2.ID = d2.supplier_ID
        															    AND FIND_IN_SET(
        															        REPLACE(
        															            REPLACE(d2.name, '–', '~'),
        															        ',','^'),
        															        
        															        REPLACE(
        															            REPLACE(
        															                REPLACE(s2.document_other, '–', '~'),
        															            ',', '^'),
        															        ' | ', ',')
        															    ) > 0

                                                                        LEFT JOIN (
                                                                            SELECT
                                                                            *
                                                                            FROM tbl_supplier_checklist
                                                                            WHERE deleted = 0 
                                                                            AND user_id = $switch_user_id
                                                                        ) AS cl
                                                                        ON cl.requirement_id = d2.ID
                                                                        AND cl.user_id = $switch_user_id

                                                                        LEFT JOIN (
                                                                            SELECT
                                                                            *
                                                                            FROM tbl_supplier_checklist_checked
                                                                            WHERE deleted = 0
                                                                            AND user_id = $switch_user_id
                                                                        ) AS cc
                                                                        ON cc.checklist_id = cl.ID
                                                                        AND cc.document_id = d2.ID

        															    WHERE s2.page = 1 
        															    AND s2.is_deleted = 0 
        															    AND s2.user_id = $switch_user_id
                                                                        AND s2.facility_switch = $facility_switch_user_id
    
                                                                        GROUP BY s2.ID, d2.ID
        														    ";
        														}
        														$result = mysqli_query( $conn,"
        														    WITH RECURSIVE cte (s_ID, s_vendor_code, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, checked_percentage) AS
        															(
        															    SELECT
        															    s1.ID AS s_ID,
        															    s1.vendor_code AS s_vendor_code,
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
        															        WHERE archived = 0 AND type = 0
        															        AND ID IN (
        															            SELECT
        															            MAX(ID)
        															            FROM tbl_supplier_document
        															            WHERE archived = 0 AND type = 0
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
                                                                            AND user_id = $switch_user_id
                                                                        ) AS cl
                                                                        ON cl.requirement_id = d1.name
                                                                        AND cl.user_id = $switch_user_id

                                                                        LEFT JOIN (
                                                                            SELECT
                                                                            *
                                                                            FROM tbl_supplier_checklist_checked
                                                                            WHERE deleted = 0
                                                                            AND user_id = $switch_user_id
                                                                        ) AS cc
                                                                        ON cc.checklist_id = cl.ID
                                                                        AND cc.document_id = d1.ID

        															    WHERE s1.page = 1 
        															    AND s1.is_deleted = 0 
        															    AND s1.user_id = $switch_user_id
                                                                        AND s1.facility_switch = $facility_switch_user_id
    
                                                                        GROUP BY s1.ID, d1.ID
                                                                        
                                                                        $sql_custom_union
        															)
        															SELECT
        															m.ID AS m_ID,
        															m.material_name AS m_material_name,
        															m.spec_file AS m_spec_file,
        															s_ID,
        															s_vendor_code,
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
        															cn_name,
        															cn_address,
        															cn_email,
        															cn_phone,
        															cn_cell,
        															cn_fax
        															FROM (
        																SELECT
        																s_ID,
        																s_vendor_code,
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
        																    s_vendor_code,
        																    s_name, 
        																    s_reviewed_due, 
        																    s_status, 
        																	s_material,
        																	s_address,
        																	s_service, 
        																    s_contact,
        																    s_category,
        																    c.name AS c_name,
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
        															) AS r2
        
        															LEFT JOIN (
        																SELECT
        																*
                                                                    	FROM tbl_supplier_material
                                                                    	WHERE facility_switch = $facility_switch_user_id
                                                                        -- AND user_id = $switch_user_id
        															) AS m
        
        															ON FIND_IN_SET(m.ID, REPLACE(r2.s_material, ' ', '')) > 0
    
    															    $sql_custom
        														" );
                                                                if ( mysqli_num_rows($result) > 0 ) {
                                                                    $table_counter = 1;
                                                                    $req_list = array();
                                                                    while($row = mysqli_fetch_array($result)) {
        																$s_ID = $row["s_ID"];
        																$s_vendor_code = htmlentities($row["s_vendor_code"] ?? '');
        																$s_name = htmlentities($row["s_name"] ?? '');
        																$s_reviewed_due = htmlentities($row["s_reviewed_due"] ?? '');
        
        																$s_category = htmlentities($row["s_category"] ?? '');
        																$c_name = htmlentities($row["c_name"] ?? '');
        
        																$cn_name = htmlentities($row["cn_name"] ?? '');
        																$cn_address = htmlentities($row["cn_address"] ?? '');
        																$cn_email = htmlentities($row["cn_email"] ?? '');
        																$cn_phone = htmlentities($row["cn_phone"] ?? '');
        																$cn_cell = htmlentities($row["cn_cell"] ?? '');
        																$cn_fax = htmlentities($row["cn_fax"] ?? '');
        																$material = '';
        																$material_spec = '';
        
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
        																	3 => 'Emergency Used Only / Spot Purchasing',
        																	4 => 'Do Not Use',
        																	5 => 'Active',
        																	6 => 'Inactive'
        																);
                                                                        
                                                                        $address_array = array();
                                                                        $address_arr = htmlentities($row["s_address"] ?? '');
                                                                        $address_arr_country = '';
                                                                        if (!empty($address_arr)) {
                                                                           // if (isset($address_arr[1])) { array_push($address_array, htmlentities($address_arr[1])); }
                                                                           // if (isset($address_arr[2])) { array_push($address_array, htmlentities($address_arr[2])); }
                                                                           // if (isset($address_arr[3])) { array_push($address_array, htmlentities($address_arr[3])); }
                                                                           // if (isset($address_arr[0])) { array_push($address_array, htmlentities($address_arr[0])); }
                                                                           // if (isset($address_arr[4])) { array_push($address_array, htmlentities($address_arr[4])); }
                                                                                
                                                                            
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
        
        																if ($s_category == "3") {
        																	$material = $row["s_service"];
        																	
        																	if (!empty($material)) {
        																		$material_result = array();
        																		$material_arr = explode(", ", $material);
        																		foreach ($material_arr as $value) {
        																			$selectMaterial = mysqli_query( $conn,"SELECT service_name FROM tbl_supplier_service WHERE ID=$value" );
                                                                                	if ( mysqli_num_rows($selectMaterial) > 0 ) {
        																				$rowMaterial = mysqli_fetch_array($selectMaterial);
        																				array_push($material_result, htmlentities($rowMaterial['service_name'] ?? ''));
        																			}
        																		}
        																		$material = implode(', ', $material_result);
        																	}
        																} else {
        																	
        																	$material = $row["s_material"];
        																	if($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1738) {
        																		if (!empty($row["s_material"])) {
        																			$material = '<a href="#modalListMaterial" data-toggle="modal" class="btn btn-link" onclick="btnList_Material('.$row["s_ID"].')">View</a>';
        																		}
        																	} else{
        																		if (!empty($row["m_material_name"])) {
                                                                                    $material = '<a href="#modalEditMaterial" data-toggle="modal" class="btnEdit_Material" onclick="btnEdit_Material('.$row["m_ID"].', 2, \'modalEditMaterial\', '; $material .= $address_arr[0] == $enterp_iso2 ? 1:0; $material .= ', '.$s_ID.')">'.htmlentities($row["m_material_name"] ?? '').'</a>';
        																		}
        																	}
        
        																	if (!empty($row["m_spec_file"])) {
        																        $spec_file = $row['m_spec_file'];
        																        $fileExtension = fileExtension($spec_file);
        																		$src = $fileExtension['src'];
        																		$embed = $fileExtension['embed'];
        																		$type = $fileExtension['type'];
        																		$file_extension = $fileExtension['file_extension'];
        																	    $url = $base_url.'uploads/supplier/';
        
        																		$material_spec = '<a href="'.$src.$url.rawurlencode($spec_file).$embed.'" data-src="'.$src.$url.rawurlencode($spec_file).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a>';
        																	}
        																}
        																	
                                                                        // Encrypt
                                                                        $api_encrypted = openssl_encrypt($s_ID, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
                                                                
                                                                        // URL-safe encoding
                                                                        $api_encoded = urlencode(base64_encode($api_iv . $api_encrypted));
        
        																echo '<tr id="tr_'.$s_ID.'">
        																	<td>'.htmlentities($s_vendor_code ?? '').'</td>
        																	<td>'.$s_name.'</td>
        																	<td class="col-category">'.htmlentities($c_name ?? '').'</td>
        																	<td class="text-center">'.$material.'</td>';
    
        																	if($switch_user_id != 1211 AND $switch_user_id != 1684 AND $switch_user_id != 1984 AND $switch_user_id != 1986) {
        																		echo '<td class="col-specification text-center">'.$material_spec.'</td>';
        																	}
        																	
        																	echo '<td>'.$address_arr.'</td>
        																	<td class="text-center">'.$address_arr_country.'</td>
        																	<td class="col-contact">'.htmlentities($cn_name ?? '').'</td>
        																	<td class="col-contact text-center">
        																		<ul class="list-inline">';
        																		if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
        																		if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
        																		if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
        																		if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
        																		echo '</ul>
        																	</td>
        																	<td class="text-center">'.round($compliance).'%</td>
        																	<td class="text-center">'.$status_type[$s_status].'</td>
        																	<td class="text-center">';
        																	
        																	    if (empty($current_permission_array_key) OR in_array(5, $permission)) {
        																			echo '<a href="#modalView" class="btn btn-outline dark btn-xs btnView" data-toggle="modal" onclick="btnView('. $s_ID .')"><i class="fa fa-fw fa-pencil"></i></a>';
        																	    }
        																	    
    																			echo '<a href="#modalChart" class="btn btn-info btn-xs btnChart" data-toggle="modal" data-id="'. $s_ID .'"><i class="fa fa-fw fa-line-chart"></i></a>
    																			<a href="pdf/supplier?i='.$api_encoded.'" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-fw fa-table"></i></a>';
    																			
        																		if (empty($current_permission_array_key) OR in_array(6, $permission)) {
        																			echo '<a href="javascript:;" class="btn btn-danger btn-xs btnDelete" onclick="btnDelete('. $s_ID .')"><i class="fa fa-fw fa-trash"></i></a>';
        																		}
        																		
        																	echo '</td>
        																</tr>';

                                                                        if (!in_array($s_ID, $req_list)) {
                                                                            array_push($req_list, $s_ID);

                                                                            $req_tr .= '<tr id="tr_'. $s_ID .'">
                                                                                <td>'. $s_name .'</td>
                                                                                <td>'.htmlentities($c_name ?? '').'</td>
                                                                                <td class="text-center">'.round($compliance).'%</td>
                                                                                <td class="text-center">';
                                                                                    
                                                                                    if (empty($current_permission_array_key) OR in_array(5, $permission)) {
                                                                                        $req_tr .= '<a href="#modalViewReq" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnViewReq('. $s_ID .')">View</a>';
                                                                                    }
                                                                                    
                                                                                    $req_tr .= '<a href="#modalViewReqReport" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnViewReqReport('. $s_ID .')">Report</a>
                                                                                </td>
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            
                                                            echo '</tbody>
                                                        </table>
                                                    </div>
            									</div>
                                                <div class="tab-pane" id="tab_actions_received">
        											<select class="form-control margin-bottom-15" id="filterReceived">
        												<option value="">Select</option>
        												<option value="1">Foreign Supplier</option>
        												<option value="2">Local Supplier</option>
        												<option value="3">Contract Service Provider</option>
        												<option value="4">Contract Manufacturer</option>
        											</select>
                                                    <table class="table table-bordered table-hover" id="tableData_2">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Vendor Name</th>
                                                                <th rowspan="2" class="col-category col-type">Category</th>
                                                                <th rowspan="2">Materials'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'/Services'; echo '</th>';
                                                                
    															if($switch_user_id != 1211 AND $switch_user_id != 1684) {
    																echo '<th rowspan="2">Specification File</th>';
    															}
        														
                                                                echo '<th rowspan="2">'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper ':''; echo 'Address</th>
        														<th rowspan="2" class="text-center col-iso">Country</th>
                                                                <th colspan="2" class="text-center">Contact Details</th>
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
                                                                <th rowspan="2" style="width: 100px;" class="text-center">Status</th>
                                                                <th rowspan="2" style="width: 135px;" class="text-center">Action</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Contact Info</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                        
    														$sql_custom = '';
    														$sql_custom_union = '';
    														if($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1738) { $sql_custom = ' GROUP BY s_ID '; }
    														if($switch_user_id != 1211 AND $switch_user_id != 1486 AND $switch_user_id != 1774 AND $switch_user_id != 1832 AND $switch_user_id != 1773 AND $switch_user_id != 1850) {
    														    $sql_custom_union = " 
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
    															        WHERE archived = 0 AND type = 1
    															        AND ID IN (
    															            SELECT
    															            MAX(ID)
    															            FROM tbl_supplier_document
    															            WHERE archived = 0 AND type = 1
    															            GROUP BY name, supplier_id
    															        )
    															    ) AS d2
    															    ON s2.ID = d2.supplier_ID
    															    AND FIND_IN_SET(
    															        REPLACE(
    															            REPLACE(d2.name, '–', '~'),
    															        ',','^'),
    															        
    															        REPLACE(
    															            REPLACE(
    															                REPLACE(s2.document_other, '–', '~'),
    															            ',', '^'),
    															        ' | ', ',')
    															    ) > 0

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist
                                                                        WHERE deleted = 0 
                                                                        AND user_id = $switch_user_id
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d2.ID
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                        AND user_id = $switch_user_id
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d2.ID

    															    WHERE s2.page = 2
    															    AND s2.is_deleted = 0 
                                                                    AND s2.facility_switch = $facility_switch_user_id
    															    AND s2.email = '".$current_userEmail."'
    
                                                                    GROUP BY s2.ID, d2.ID
    														    ";
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
    															        WHERE archived = 0 AND type = 0
    															        AND ID IN (
    															            SELECT
    															            MAX(ID)
    															            FROM tbl_supplier_document
    															            WHERE archived = 0 AND type = 0
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
                                                                        AND user_id = $switch_user_id
                                                                    ) AS cl
                                                                    ON cl.requirement_id = d1.name
                                                                    AND cl.user_id = $switch_user_id

                                                                    LEFT JOIN (
                                                                        SELECT
                                                                        *
                                                                        FROM tbl_supplier_checklist_checked
                                                                        WHERE deleted = 0
                                                                        AND user_id = $switch_user_id
                                                                    ) AS cc
                                                                    ON cc.checklist_id = cl.ID
                                                                    AND cc.document_id = d1.ID

    															    WHERE s1.page = 2
    															    AND s1.is_deleted = 0 
                                                                    AND s1.facility_switch = $facility_switch_user_id
    															    AND s1.email = '".$current_userEmail."'
    
                                                                    GROUP BY s1.ID, d1.ID
    															    
    															    $sql_custom_union
    															)
                                                                SELECT
                                                                m_ID,
                                                                m_material_name,
                                                                m_spec_file,
                                                                ent.businessname AS e_businessname,
                                                                s_ID,
                                                                s_user_id,
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
                                                                cn_name,
                                                                cn_address,
                                                                cn_email,
                                                                cn_phone,
                                                                cn_cell,
                                                                cn_fax
                                                                FROM (
        															SELECT
        															m.ID AS m_ID,
        															m.material_name AS m_material_name,
        															m.spec_file AS m_spec_file,
        															s_ID,
        															s_user_id,
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
        															cn_name,
        															cn_address,
        															cn_email,
        															cn_phone,
        															cn_cell,
        															cn_fax
        															FROM (
        																SELECT
        																s_ID,
        																s_user_id,
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
        																    s_name, 
        																    s_reviewed_due, 
        																    s_status, 
        																	s_material,
        																	s_service, 
        																	s_address, 
        																    s_contact,
        																    s_category,
        																    c.name AS c_name,
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
        															) AS r2
        
        															LEFT JOIN (
        																SELECT
        																*
        																FROM tbl_supplier_material
        															) AS m
        
        															ON FIND_IN_SET(m.ID, REPLACE(r2.s_material, ' ', '')) > 0
        
        															$sql_custom
                                                                ) en
                                                                
                                                                LEFT JOIN (
                                                                	SELECT
                                                                	businessname,
                                                                    users_entities
                                                                	FROM tblEnterpiseDetails
                                                                ) AS ent
                                                                
                                                                ON en.s_user_id = ent.users_entities
    														" );
                                                            if ( mysqli_num_rows($result) > 0 ) {
                                                                $table_counter = 1;
                                                                while($row = mysqli_fetch_array($result)) {
    																$s_ID = htmlentities($row["s_ID"] ?? '');
    																$s_name = htmlentities($row["e_businessname"] ?? '');
    																$s_reviewed_due = htmlentities($row["s_reviewed_due"] ?? '');
    
    																$s_category = htmlentities($row["s_category"] ?? '');
    																$c_name = htmlentities($row["c_name"] ?? '');
    
    																$cn_name = htmlentities($row["cn_name"] ?? '');
    																$cn_address = htmlentities($row["cn_address"] ?? '');
    																$cn_email = htmlentities($row["cn_email"] ?? '');
    																$cn_phone = htmlentities($row["cn_phone"] ?? '');
    																$cn_cell = htmlentities($row["cn_cell"] ?? '');
    																$cn_fax = htmlentities($row["cn_fax"] ?? '');
    																$material = '';
    																$material_spec = '';
    
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
    																			array_push($material_result, htmlentities($rowMaterial['c_service_category'] ?? ''));
    																		}
    																		$material = implode(', ', $material_result);
    																	}
    																} else {
    																	$material = $row["s_material"];
    																	if($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1738) {
    																		if (!empty($row["s_material"])) {
    																			$material = '<a href="#modalListMaterial" data-toggle="modal" class="btn btn-link" onclick="btnList_Material('.$row["s_ID"].')">View</a>';
    																		}
    																	} else{
    																		if (!empty($row["m_material_name"])) {
                                                                                $material = '<a href="#modalEditMaterial" data-toggle="modal" class="btnEdit_Material" onclick="btnEdit_Material('.$row["m_ID"].', 2, \'modalEditMaterial\', '; $material .= $address_arr[0] == $enterp_iso2 ? 1:0; $material .= ', '.$s_ID.')">'.htmlentities($row["m_material_name"] ?? '').'</a>';
    																		}
    																	}
    
    																	if (!empty($row["m_spec_file"])) {
    																        $spec_file = $row['m_spec_file'];
    																        $fileExtension = fileExtension($spec_file);
    																		$src = $fileExtension['src'];
    																		$embed = $fileExtension['embed'];
    																		$type = $fileExtension['type'];
    																		$file_extension = $fileExtension['file_extension'];
    																	    $url = $base_url.'uploads/supplier/';
    
    																		$material_spec = '<a href="'.$src.$url.rawurlencode($spec_file).$embed.'" data-src="'.$src.$url.rawurlencode($spec_file).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a>';
    																	}
    																}
    																
    																echo '<tr id="tr_'.$s_ID.'">
    																	<td>'.htmlentities($s_name ?? '').'</td>
    																	<td class="col-category">'.htmlentities($c_name ?? '').'</td>
    																	<td class="text-center">'.$material.'</td>';
    
    																	if($switch_user_id != 1211 AND $switch_user_id != 1684) {
    																		echo '<td class="text-center">'.$material_spec.'</td>';
    																	}
    																	
    																	echo '<td>'.$address_arr.'</td>
                                                                        <td class="text-center">'.$address_arr_country.'</td>
    																	<td>'.htmlentities($cn_name ?? '').'</td>
    																	<td class="text-center">
    																		<ul class="list-inline">';
    																		if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
    																		if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
    																		if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
    																		if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
    																		echo '</ul>
    																	</td>
    																	<td class="text-center">'.round($compliance).'%</td>
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
                                                    </table>
                                                </div>
        										<div class="tab-pane" id="tab_actions_category">';
        										
                                                    $pictogram = 'sup_category';
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
                                                
        											echo '<select class="form-control margin-bottom-15" id="filterCategory">
        												<option value="">Select</option>';
        												
    													$selectCategory = mysqli_query( $conn,"
    													    SELECT
    														c.ID AS c_ID,
    														c.name AS c_name
    
    														FROM tbl_supplier_material AS m
    
    														INNER JOIN (
    															SELECT
    														    *
    														    FROM tbl_supplier
    														    WHERE page = 1 
    															AND is_deleted = 0
                                                                AND facility_switch = $facility_switch_user_id
    														) AS s
    														ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
    
    														LEFT JOIN (
    															SELECT
    														    *
    														    FROM tbl_supplier_category
    														    WHERE deleted = 0
    														) AS c
    														ON s.category = c.ID
    
    														WHERE m.user_id = $switch_user_id
                                                            AND m.facility_switch = $facility_switch_user_id
    
    														GROUP BY c.ID
    													" );
    													if ($switch_user_id == 1211 OR $switch_user_id == 1684) {
        													$selectCategory = mysqli_query( $conn,"
        													    SELECT 
        														m.category AS c_ID,
        														pc.name AS c_name
        
        														FROM tbl_supplier_material AS m
        
        														LEFT JOIN (
        															SELECT
        														    *
        														    FROM tbl_products_category
        														) AS pc
        														ON m.category = pc.ID
        
        														INNER JOIN (
        														    SELECT
        														    *
        														    FROM tbl_supplier
        														    WHERE page = 1 
        														    AND is_deleted = 0
                                                                    AND facility_switch = $facility_switch_user_id
        														) AS s
        														ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
        
        														WHERE m.user_id = $switch_user_id
                                                                AND m.facility_switch = $facility_switch_user_id
        														AND LENGTH(pc.name) > 0
        
        														GROUP BY pc.name
        													" );
    													}
    													
    													if ( mysqli_num_rows($selectCategory) > 0 ) {
    														while($row = mysqli_fetch_array($selectCategory)) {
    															echo '<option value="'.$row["c_ID"].'">'.htmlentities($row["c_name"] ?? '').'</option>';
    														}
    													}
        													
        											echo '</select>
        											<table class="table table-bordered table-hover" id="tableData_category">
        												<thead>
        													<tr>
        														<th>Materials</th>
        														<th>Category</th>
        														<th>Allergen</th>
        														<th>Supplier</th>
        														<th class="hide">Category ID</th>
        														<th style="width: 100px;" class="text-center">Status</th>
        														<th style="width: 135px;" class="text-center">Action</th>
        													</tr>
        												</thead>
        												<tbody>';
        												
    														// Material
    														$result = mysqli_query( $conn,"
    														    SELECT
    															m.ID AS m_ID,
    															m.material_name AS m_material_name,
    															m.allergen AS m_allergen,
    															m.allergen_other AS m_allergen_other,
    															s.ID AS s_ID,
    															s.name AS s_name,
    															s.status AS s_status,
    															c.ID AS c_ID,
    															c.name AS c_name
    
    															FROM tbl_supplier_material AS m
    
    															INNER JOIN (
    																SELECT
    															    *
    															    FROM tbl_supplier
    															    WHERE page = 1 
    																AND is_deleted = 0 
                                                                    AND facility_switch = $facility_switch_user_id
    																-- AND user_id = 5 
    															) AS s
    															ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
    
    															LEFT JOIN (
    																SELECT
    															    *
    															    FROM tbl_supplier_category
    															    WHERE deleted = 0
    															) AS c
    															ON s.category = c.ID
    
    															WHERE m.user_id = $switch_user_id
                                                                AND m.facility_switch = $facility_switch_user_id
    														" );
    													    if ($switch_user_id == 1211 OR $switch_user_id == 1684) {
        														$result = mysqli_query( $conn,"
        														    SELECT 
        															m.ID AS m_ID,
        															m.material_name AS m_material_name,
        															m.allergen AS m_allergen,
        															m.allergen_other AS m_allergen_other,
        															m.category AS c_ID,
        															pc.name AS c_name,
        															s.ID AS s_ID,
        															s.name AS s_name,
        															s.status AS s_status
        
        															FROM tbl_supplier_material AS m
        
        															LEFT JOIN (
        																SELECT
        															    *
        															    FROM tbl_products_category
        															) AS pc
        															ON m.category = pc.ID
        
        															INNER JOIN (
        															    SELECT
        															    *
        															    FROM tbl_supplier
        															    WHERE page = 1 
        															    AND is_deleted = 0
                                                                        AND facility_switch = $facility_switch_user_id
        															) AS s
        															ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', ''))
        
        															WHERE m.user_id = $switch_user_id
                                                                    AND m.facility_switch = $facility_switch_user_id
        														" );
    													    }
    													    
    														if ( mysqli_num_rows($result) > 0 ) {
    															$table_counter = 1;
    															while($row = mysqli_fetch_array($result)) {
    																$m_ID = $row["m_ID"];
    																$m_material_name = htmlentities($row["m_material_name"] ?? '');
    																$s_ID = htmlentities($row["s_ID"] ?? '');
                                                                    $s_name = htmlentities($row["s_name"] ?? '');
    																$c_ID = htmlentities($row["c_ID"] ?? '');
    																$c_name = htmlentities($row["c_name"] ?? '');
    
                                                                    $allergen_arr = array(
                                                                        1 => 'Milk',
                                                                        2 => 'Egg',
                                                                        3 => 'Fish (e.g., bass, flounder, cod)',
                                                                        4 => 'Crustacean shellfish (e.g., crab, lobster, shrimp)',
                                                                        5 => 'Tree nuts (e.g., almonds, walnuts, peca)',
                                                                        6 => 'Peanuts',
                                                                        7 => 'Wheat',
                                                                        8 => 'Soybeans',
                                                                        9 => 'Sesame',
                                                                        10 => 'None'
                                                                    );
    																$m_allergen_result = array();
    																if (!empty($row["m_allergen"])) {
    																	$m_allergen_arr = explode(", ", $row["m_allergen"]);
    																	foreach ($m_allergen_arr as $value) {
    																		array_push($m_allergen_result, $allergen_arr[$value]);
    																	}
    																}
    																if (!empty($row["m_allergen_other"])) {
    																	array_push($m_allergen_result, $row["m_allergen_other"]);
    																}
    																$m_allergen = implode(', ', $m_allergen_result);
    
    																$s_status = $row["s_status"];
    																$status_type = array(
    																	0 => 'Pending',
    																	1 => 'Approved',
    																	2 => 'Non Approved',
    																	3 => 'Emergency Used Only / Spot Purchasing',
    																	4 => 'Do Not Use',
    																	5 => 'Active',
    																	6 => 'Inactive'
    																);
    
    																echo '<tr>
    																	<td>'.$m_material_name.'</td>
    																	<td>'.$c_name.'</td>
    																	<td>'.$m_allergen.'</td>
    																	<td>'.$s_name.'</td>
    																	<td class="hide">'.$c_ID.'</td>
    																	<td style="width: 100px;" class="text-center">'.$status_type[$s_status].'</td>
    																	<td style="width: 135px;" class="text-center">';
    																	
    																	    if (empty($current_permission_array_key) OR in_array(5, $permission)) {
    																		    echo '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm" onclick="btnEdit_Material('.$m_ID.', 2, \'modalEditMaterial\', 1, '.$s_ID.')">View</a>';
    																	    }
    																	    
    																	echo '</td>
    																</tr>';
    															}
    														}
        														
        												echo '</tbody>
        												<tfoot>
        													<tr>
        														<th>Materials</th>
        														<th>Category</th>
        														<th>Allergen</th>
        														<th>Supplier</th>
        														<th class="hide">Category ID</th>
        														<th style="width: 100px;" class="text-center">Status</th>
        														<th style="width: 135px;" class="text-center hide">Action</th>
        													</tr>
        												</tfoot>
        											</table>
        										</div>
        										<div class="tab-pane" id="tab_actions_requirement">';
    										
                                                    $pictogram = 'sup_req';
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
                                                    
        											echo '<table class="table table-bordered table-hover" id="tableData_req">
        												<thead>
        													<tr>
        														<th>Vendor Name</th>
        														<th>Category</th>
        														<th class="text-center" style="width: 100px;">Compliance</th>
        														<th class="text-center" style="width: 185px;">Action</th>
        													</tr>
        												</thead>
        												<tbody>'.$req_tr.'</tbody>
        											</table>
        										</div>
                                                <div class="tab-pane" id="tab_actions_template">';
                                                
                                                    $pictogram = 'sup_template';
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

                                                            if ($switch_user_id == 1774) {
                                                                if ($ID == 3 OR $ID == 4) {
                                                                    $name = htmlentities($row["name"] ?? '').' (Signed Copy from Suwerte)';
                                                                }
                                                                if ($ID == 181 OR $ID == 33) {
                                                                    $name = htmlentities($row["name"] ?? '').' (if applicable)';
                                                                }
                                                                if ($ID == 16) {
                                                                    $name = 'U.S. FDA Bioterrorism Registration Affidavit/ U.S. FDA Food Facility Registration';
                                                                }
                                                                if ($ID == 115 OR $ID == 18 OR $ID == 20 OR $ID == 71 OR $ID == 72 OR $ID == 75 OR $ID == 102 OR $ID == 193 OR $ID == 191 OR $ID == 192 OR $ID == 24) {
                                                                    $name = 'FSVP QI - '.htmlentities($row["name"] ?? '');
                                                                }
                                                                if ($ID == 156) {
                                                                    $name = htmlentities($row["name"] ?? '').' - from Suwerte’s forwarder';
                                                                }
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
        								
        										<!-- Nelmar Supplier Analytics -->
        										<div class="tab-pane" id="tab_supplier_analytics">
        											<div class="row widget-row">
        												<div class="col-md-6">
        													<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
        														<h3 class="d-flex justify-content-center">Sent</h3>
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
        															<div id="requirementchartdiv" style="width: 100%; height: 500px;"></div>
        														</div>
        													</div>
        												</div>
        												<div class="col-md-6">
        													<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
        														<h3 class="d-flex justify-content-center">Materials</h3>
        														<div class="widget-thumb-wrap">
        															<div id="materialchartdiv" style="width: 100%; height: 500px;"></div>
        														</div>
        													</div>
        												</div> 
        												<div class="col-md-12">
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
                                                        AND page = 2 
                                                        AND facility_switch = $facility_switch_user_id
                                                    ) AS s
                                                    ON FIND_IN_SET(c.ID, REPLACE(s.contact, ' ', ''))

                                                    WHERE c.is_deleted = 0
                                                    AND c.email = '".$current_userEmail."'
                                                ) r
                                            ");
                                            if ( mysqli_num_rows($selectData) > 1 ) {
                                            	echo '<select class="form-control margin-bottom-15" id="filterReceived">
													<option value="">Select</option>
													<option value="1">Foreign Supplier</option>
													<option value="2">Local Supplier</option>
													<option value="3">Contract Service Provider</option>
													<option value="4">Contract Manufacturer</option>
												</select>
												<table class="table table-bordered table-hover" id="tableData_2">
													<thead>
														<tr>
															<th rowspan="2">Vendor Name</th>
															<th rowspan="2" class="col-type">Category</th>
                                                            <th rowspan="2">Materials'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'/Services'; echo '</th>';

															if($switch_user_id != 5 AND $switch_user_id != 1684) {
																echo '<th rowspan="2">Specification File</th>';
															}

	                                                        echo '<th rowspan="2">'; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper ':''; echo 'Address</th>
															<th rowspan="2" class="text-center col-iso">Country</th>
															<th colspan="2" class="text-center">Contact Details</th>
															<th rowspan="2" style="width: 100px;" class="text-center">Compliance</th>
															<th rowspan="2" style="width: 100px;" class="text-center">Status</th>
															<th rowspan="2" style="width: 135px;" class="text-center">Action</th>
														</tr>
														<tr>
															<th>Name</th>
															<th>Contact Info</th>
														</tr>
													</thead>
													<tbody>';

														$sql_custom = '';
														$sql_custom_union = '';
														if($switch_user_id == 1211 OR $switch_user_id == 1684) { $sql_custom = ' GROUP BY s_ID '; }
														if($switch_user_id != 1211 AND $switch_user_id != 1486 AND $switch_user_id != 1774 AND $switch_user_id != 1832 AND $switch_user_id != 1773 AND $switch_user_id != 1850) {
															$sql_custom_union = " 
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
															        WHERE archived = 0 AND type = 1
															        AND ID IN (
															            SELECT
															            MAX(ID)
															            FROM tbl_supplier_document
															            WHERE archived = 0 AND type = 1
															            GROUP BY name, supplier_id
															        )
															    ) AS d2
															    ON s2.ID = d2.supplier_ID
															    AND FIND_IN_SET(
															        REPLACE(
															            REPLACE(d2.name, '–', '~'),
															        ',','^'),
															        
															        REPLACE(
															            REPLACE(
															                REPLACE(s2.document_other, '–', '~'),
															            ',', '^'),
															        ' | ', ',')
															    ) > 0

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist
                                                                    WHERE deleted = 0 
                                                                    AND user_id = $switch_user_id
                                                                ) AS cl
                                                                ON cl.requirement_id = d2.ID
                                                                AND cl.user_id = $switch_user_id

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist_checked
                                                                    WHERE deleted = 0
                                                                    AND user_id = $switch_user_id
                                                                ) AS cc
                                                                ON cc.checklist_id = cl.ID
                                                                AND cc.document_id = d2.ID

															    WHERE s2.page = 2
															    AND s2.is_deleted = 0 
                                                                AND s2.facility_switch = $facility_switch_user_id
															    AND s2.email = '".$current_userEmail."'

                                                                GROUP BY s2.ID, d2.ID
															";
														}
														$result = mysqli_query( $conn,"
															WITH RECURSIVE cte (s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_address, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count, d_percentage) AS
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
															        WHERE archived = 0 AND type = 0
															        AND ID IN (
															            SELECT
															            MAX(ID)
															            FROM tbl_supplier_document
															            WHERE archived = 0 AND type = 0
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
                                                                    AND user_id = $switch_user_id
                                                                ) AS cl
                                                                ON cl.requirement_id = d1.name
                                                                AND cl.user_id = $switch_user_id

                                                                LEFT JOIN (
                                                                    SELECT
                                                                    *
                                                                    FROM tbl_supplier_checklist_checked
                                                                    WHERE deleted = 0
                                                                    AND user_id = $switch_user_id
                                                                ) AS cc
                                                                ON cc.checklist_id = cl.ID
                                                                AND cc.document_id = d1.ID

															    WHERE s1.page = 2
															    AND s1.is_deleted = 0 
                                                                AND s1.facility_switch = $facility_switch_user_id
															    AND s1.email = '".$current_userEmail."'
    
                                                                GROUP BY s1.ID, d1.ID

															    $sql_custom_union
															)
															SELECT
															m.ID AS m_ID,
															m.material_name AS m_material_name,
															m.spec_file AS m_spec_file,
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
															cn_name,
															cn_address,
															cn_email,
															cn_phone,
															cn_cell,
															cn_fax
															FROM (
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
															) AS r2

															LEFT JOIN (
																SELECT
																*
																FROM tbl_supplier_material
															) AS m

															ON FIND_IN_SET(m.ID, REPLACE(r2.s_material, ' ', '')) > 0

															$sql_custom
														" );
														if ( mysqli_num_rows($result) > 0 ) {
															$table_counter = 1;
															while($row = mysqli_fetch_array($result)) {
																$s_ID = $row["s_ID"];
																$s_name = $row["s_name"];
																$s_reviewed_due = $row["s_reviewed_due"];

																$s_category = $row["s_category"];
																$c_name = $row["c_name"];

																$cn_name = $row["cn_name"];
																$cn_address = $row["cn_address"];
																$cn_email = $row["cn_email"];
																$cn_phone = $row["cn_phone"];
																$cn_cell = $row["cn_cell"];
																$cn_fax = $row["cn_fax"];

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
											                        3 => 'Emergency Used Only / Spot Purchasing',
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
																			// $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
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
																	// $material = $row["s_material"];
																	// if (!empty($material)) {
																	// 	$material_result = array();
																	// 	$material_arr = explode(", ", $material);
																	// 	foreach ($material_arr as $value) {
																	// 		// $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
																	// 		$selectMaterial = mysqli_query( $conn,"SELECT
																	// 			p.name AS p_name
																	// 			FROM tbl_supplier_material  AS m

																	// 			LEFT JOIN (
																	// 				SELECT 
																	// 			    * 
																	// 			    FROM tbl_products
																	// 			) AS p
																	// 			ON m.material_name = p.ID
																	// 			WHERE m.ID = $value" );
																	// 		$rowMaterial = mysqli_fetch_array($selectMaterial);
																	// 		array_push($material_result, $rowMaterial['p_name']);
																	// 	}
																	// 	$material = implode(', ', $material_result);
																	// }

																	$material = '';
																	if($switch_user_id == 1211 OR $switch_user_id == 1684) {
																		if (!empty($row["s_material"])) {
																			$material = '<a href="#modalListMaterial" data-toggle="modal" class="btn btn-link" onclick="btnList_Material('.$row["s_ID"].')">View</a>';
																		}
																	} else{
																		if (!empty($row["m_material_name"])) {
																			$material = '<a href="#modalEditMaterial" data-toggle="modal" class="btnEdit_Material" onclick="btnEdit_Material('.$row["m_ID"].', 2, \'modalEditMaterial\', 1, '.$s_ID.')">'.$row["m_material_name"].'</a>';
																		}
																	}

																	$material_spec = '';
																	if (!empty($row["m_spec_file"])) {
																        $spec_file = $row['m_spec_file'];
																        $fileExtension = fileExtension($spec_file);
																		$src = $fileExtension['src'];
																		$embed = $fileExtension['embed'];
																		$type = $fileExtension['type'];
																		$file_extension = $fileExtension['file_extension'];
																	    $url = $base_url.'uploads/supplier/';

																		$material_spec = '<a href="'.$src.$url.rawurlencode($spec_file).$embed.'" data-src="'.$src.$url.rawurlencode($spec_file).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a>';
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

																$s_name = "Enterprise Name";
																echo '<tr id="tr_'.$s_ID.'">
																	<td>'.htmlentities($s_name ?? '').'</td>
																	<td>'.htmlentities($c_name ?? '').'</td>
																	<td>'.$material.'</td>';

																	if($switch_user_id != 5 AND $switch_user_id != 1684) {
																		echo '<td class="text-center">'.$material_spec.'</td>';
																	}
																	
																	echo '<td>'.$address_arr.'</td>
                                                                    <td class="text-center">'.$address_arr_country.'</td>
																	<td>'.htmlentities($cn_name ?? '').'</td>
																	<td class="text-center">
																		<ul class="list-inline">';
																		if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
																		if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
																		if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
																		if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
																		echo '</ul>
																	</td>
																	<td class="text-center">'.round($compliance).'%</td>
																	<td class="text-center">'.$status_type[$s_status].'</td>
																	<td class="text-center">
																		<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>
																	</td>
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
                                            <h4 class="modal-title">New <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper':'Supplier'; ?> Form</h4>
                                        </div>
                                        <div class="modal-body">
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
                                                    <li class="tabMaterials">
                                                        <a href="#tabMaterials_1" data-toggle="tab"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?> Requirements</a>
                                                    </li>
                                                    <li class="tabService hide">
                                                        <a href="#tabService_1" data-toggle="tab">Services</a>
                                                    </li>
                                                    <?php
                                                        if ($switch_user_id != 1984 AND $switch_user_id != 1986) {
                                                            echo '<li>
                                                                <a href="#tabAuditReview_1" data-toggle="tab">Audit & Review</a>
                                                            </li>';
                                                        }
                                                    ?>

                                                    <li>
                                                        <a href="#tabRecord_1" data-toggle="tab">Record</a>
                                                    </li>
                                                    <li class="hide">
                                                        <a href="#tabFSVP_1" data-toggle="tab">FSVP</a>
                                                    </li>

                                                    <?php
                                                        echo '<li class=" '; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'hide'; echo '">
                                                            <a href="#tabIOR_1" data-toggle="tab">IOR</a>
                                                        </li>
                                                        <li class=" '; echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'hide'; echo '">
                                                            <a href="#tabAgent_1" data-toggle="tab">US Agent</a>
                                                        </li>';
                                                        if ($current_userID == 481) {
                                                            echo '<li>
                                                                <a href="#" data-toggle="tab">Organic</a>
                                                            </li>
                                                            <li>
                                                                <a href="https://youtu.be/rqQ_3PqP1fU" target="_blank">Trak360</a>
                                                            </li>';
                                                        }
                                                    ?>
                                                </ul>
                                                <div class="tab-content margin-top-20">
                                                    <div class="tab-pane active" id="tabBasic_1">
                                                        <?php
                                                            $pictogram = 'sup_add_basic';
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
                                                                    <label class="control-label"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper':'Vendor'; ?> Code</label>
                                                                    <input class="form-control" type="text" name="vendor_code" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper':'Vendor'; ?> Name</label>
                                                                    <input class="form-control" type="text" name="supplier_name" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'hide':''; ?>">
                                                                <div class="form-group">
                                                                    <label class="control-label">Category</label>
                                                                    <select class="form-control" name="supplier_category" onchange="changedCategory(this, 1)">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                            // $selectCategory = mysqli_query( $conn,"SELECT ID, name FROM tbl_supplier_category WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
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
                                                            <div class="col-md-3 <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'hide':''; ?>">
                                                                <div class="form-group">
                                                                    <label class="control-label">Industry</label>
                                                                    <select class="form-control" name="supplier_industry" onchange="changeIndustry(this.value, 1)">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                            // $selectIndustry = mysqli_query( $conn,"SELECT ID, name FROM tbl_supplier_industry WHERE deleted = 0 AND FIND_IN_SET($current_client, REPLACE(client, ' ', '')) ORDER BY name" );
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
                                                                    <select class="form-control" name="supplier_countries" onchange="changeCountry(1)">
                                                                        <option value="US">United States of America</option>

                                                                        <?php
                                                                            $selectCountry = mysqli_query( $conn,"SELECT * FROM countries WHERE iso2 <> 'US'" );
                                                                            while($rowCountry = mysqli_fetch_array($selectCountry)) {
                                                                                echo '<option value="'.$rowCountry["iso2"].'">'.$rowCountry["name"].'</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Bldg No./Street</label>
                                                                    <input class="form-control" type="text" name="supplier_address_street" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">City</label>
                                                                    <input class="form-control" type="text" name="supplier_address_city" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">State</label>
                                                                    <input class="form-control" type="text" name="supplier_address_state" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Zip Code</label>
                                                                    <input class="form-control" type="text" name="supplier_address_code" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="email" name="supplier_email" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="supplier_phone" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Fax</label>
                                                                    <input class="form-control" type="text" name="supplier_fax" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Website</label>
                                                                    <input class="form-control" type="text" name="supplier_website" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Status</label>
                                                                    <select class="form-control" name="supplier_status">
                                                                        <option value="0">Pending</option>
                                                                        <option value="1">Approved</option>
                                                                        <option value="2">Non-Approved</option>
                                                                        <option value="3">Emergency Used Only / Spot Purchasing</option>
                                                                        <option value="4">Do Not Use</option>
																		<option value="5">Active</option>
																		<option value="6">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label">Status Date</label>
																	<input class="form-control" type="date" name="date" />
																</div>
															</div>
															<div class="col-md-3 <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'hide':''; ?>">
																<div class="form-group">
																	<label class="control-label">Organic Supplier?</label>
																	<select class="form-control" name="organic" onchange="changeCountry(1)">
																		<option value="0">No</option>
																		<option value="1">Yes</option>
																	</select>
																</div>
															</div>
                                                            <div class="col-md-3 hide">
                                                                <div class="form-group">
                                                                    <label class="control-label">Receive Notification?</label>
                                                                    <select class="form-control" name="supplier_notification">
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes</option>
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
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label">Risk Level</label>
																	<select class="form-control" name="risk_level">
																		<option value="0">Low</option>
																		<option value="1">Medium</option>
																		<option value="3">High</option>
																	</select>
																</div>
															</div>
															<div class="col-md-3 hide">
																<div class="form-group">
																	<label class="control-label">Frequency</label>
																	<select class="form-control" name="supplier_frequency" onchange="changeFrequency(this.value)">
																		<!--<option value="0">Custom</option>-->
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
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">DUNS No.</label>
                                                                    <input class="form-control" type="text" name="duns" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? '':'hide'; ?>">
                                                                <div class="form-group">
                                                                    <label class="control-label">FDA Registration/Account Number</label>
                                                                    <input class="form-control" type="text" name="fda_reg" />
                                                                </div>
                                                            </div>
														</div>

    													<h4>
    														Regulatory License Number
    														<a href="#modalNewRegulatory" data-toggle="modal" class="btn btn-xs btn-primary" onclick="btnNew_Regulatory(1, 1)"><i class="fa fa-plus"></i> ADD</a>
    													</h4>
    
    													<table class="table table-bordered table-hover" id="tableData_Regulatory_1">
    														<thead>
    															<tr>
    																<th>Regulatory</th>
    																<th>Regulatory Number</th>
    																<th class="text-center" style="width: 140px;">Supporting File</th>
    																<th class="text-center" style="width: 140px;">Registration Date</th>
    																<th class="text-center" style="width: 140px;">Expiration Date</th>
    																<th class="text-center" style="width: 140px;">Action</th>
    															</tr>
    														</thead>
    														<tbody></tbody>
    													</table>
                                                    </div>
                                                    <div class="tab-pane" id="tabContact_1">
                                                        <?php
                                                            $pictogram = 'sup_add_contact';
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
                                                            $pictogram = 'sup_add_docs';
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

                                                            $sql_supplier = '';
															$checked = '';
															$tblOther = 0;
                                                            $default_list = '';
                                                            $fsvp_list = '';
                                                            $usda_list = '';
                                                            $international = ' ';
                                                            $usda = ' ';

                                                            $data_new = '';
                                                            $compliance = 0;
                                                            $compliance_counter = 0;
                                                            $compliance_approved = 0;

                                                            // if ($switch_user_id == 1684) {
                                                            //     // if ($address_arr[0] == $c) { $international = ' international = 0 AND '; }
															// 	if ($switch_user_id == 1649 OR $current_client == 16) { $sql_supplier .= ' client = 16 AND '; }
                                                            //     if ($switch_user_id == 1211 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $switch_user_id == 1773 OR $switch_user_id == 1850) { $tblOther = 1; }
                        									// 	if ($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $switch_user_id == 1773 OR $switch_user_id == 1850) { $checked = 'CHECKED'; $sql_supplier .= " required = 1 AND FIND_IN_SET($switch_user_id, REPLACE(accounts, ' ', '')) > 0 AND "; }
															// 	$selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE $sql_supplier international = 0 AND organic = 0 ORDER BY name" );
                                                            // } else {
                                                                $checked = 'CHECKED';
                                                                if ($user_id == 1211 OR $user_id == 1486 OR $user_id == 1774 OR $user_id == 1832 OR $user_id == 1773 OR $user_id == 1850) { $tblOther = 1; }
                                                                // if ($address_arr[0] != $c) { $international = ' OR facility = -1 '; }
                                                                if ($switch_user_id == 1984 OR $switch_user_id == 1986) { $usda = ' OR facility = -2 '; }
                                                                $selectRequirement2 = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE deleted = 0 AND organic = 0 AND (FIND_IN_SET($switch_user_id, REPLACE(facility , ' ', '')) OR facility = 0 $international $usda) ORDER BY name" );
                                                            // }

                                                            if ( mysqli_num_rows($selectRequirement2) > 0 ) {
                                                                while($row = mysqli_fetch_array($selectRequirement2)) {
                                                                    $r_ID = $row["ID"];
                                                                    $r_facility = $row["facility"];
                                                                    
							                                        $name = htmlentities($row["name"] ?? '');
							                                        if ($switch_user_id == 1486 AND !empty($row["req"])) {
							                                            $name = htmlentities($row["req"] ?? '');
							                                        }
                                    								if ($row["ID"] == 118 AND $switch_user_id == 1738) { $name = 'Traceability System'; }

                                                                    if ($switch_user_id == 1774) {
                                                                        if ($row["ID"] == 3 OR $row["ID"] == 4) {
                                                                            $name = htmlentities($row["name"] ?? '').' (Signed Copy from Suwerte)';
                                                                        }
                                                                        if ($row["ID"] == 181 OR $row["ID"] == 33) {
                                                                            $name = htmlentities($row["name"] ?? '').' (if applicable)';
                                                                        }
                                                                        if ($row["ID"] == 16) {
                                                                            $name = 'U.S. FDA Bioterrorism Registration Affidavit/ U.S. FDA Food Facility Registration';
                                                                        }
                                                                        if ($row["ID"] == 115 OR $row["ID"] == 18 OR $row["ID"] == 20 OR $row["ID"] == 71 OR $row["ID"] == 72 OR $row["ID"] == 75 OR $row["ID"] == 102 OR $row["ID"] == 193 OR $row["ID"] == 191 OR $row["ID"] == 192 OR $row["ID"] == 24) {
                                                                            $name = 'FSVP QI - '.htmlentities($row["name"] ?? '');
                                                                        }
                                                                        if ($row["ID"] == 156) {
                                                                            $name = htmlentities($row["name"] ?? '').' - from Suwerte’s forwarder';
                                                                        }
                                                                    }

                                                                    if ($r_facility == -1) {
                                                                        $fsvp_list .= '<label class="mt-checkbox mt-checkbox-outline"> '.$name.'
                                                                            <input type="checkbox" value="'.$r_ID.'" name="document[]"  onchange="checked_Requirement(this, 1, 0, 0)" checked />
                                                                            <span></span>
                                                                        </label>';
                                                                    } else if ($r_facility == -2) {
                                                                        $usda_list .= '<label class="mt-checkbox mt-checkbox-outline"> '.$name.'
                                                                            <input type="checkbox" value="'.$r_ID.'" name="document[]"  onchange="checked_Requirement(this, 1, 0, 0)" checked />
                                                                            <span></span>
                                                                        </label>';
                                                                    } else {
                                                                        $default_list .= '<label class="mt-checkbox mt-checkbox-outline"> '.$name.'
                                                                            <input type="checkbox" value="'.$r_ID.'" name="document[]"  onchange="checked_Requirement(this, 1, 0, 0)" checked />
                                                                            <span></span>
                                                                        </label>';
                                                                    }


                                                                    $data_new .= '<tr class="tr_'.$r_ID.'">
                                                                        <td rowspan="2">
                                                                            <input type="hidden" class="form-control" name="document_name[]" value="'.$r_ID.'" required />
                                                                            <b>'.$name.'</b>
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

                                                                            $selectSOP = mysqli_query( $conn,"SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id AND requirement_id = $r_ID" );
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

                                                                                $data_new .= '<p style="margin: 0;">
                                                                                    <a href="'.$sop_file.'" data-src="'.$sop_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                                    <a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$r_ID.', '.$sop_ID.', 1, 1)">Upload</a>
                                                                                </p>';
                                                                            } else {
                                                                                $data_new .= '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$r_ID.', 0, 1, 1)">Upload</a>';
                                                                            }

                                                                        $data_new .= '</td>
                                                                        <td rowspan="2" class="text-center">
                                                                            <input type="file" class="form-control hide" name="document_info[]" />';

                                                                            $selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id AND requirement_id = $r_ID" );
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

                                                                                $data_new .= '<p style="margin: 0;">
                                                                                    <a href="'.$info_file.'" data-src="'.$info_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                                    <a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$r_ID.', '.$info_ID.', 1, 1)">Upload</a>
                                                                                </p>';
                                                                            } else {
                                                                                $data_new .= '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$r_ID.', 0, 1, 1)">Upload</a>';
                                                                            }

                                                                        $data_new .= '</td>
                                                                        <td rowspan="2" class="text-center">
                                                                            <input type="file" class="form-control hide" name="document_template[]" />';

                                                                            $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE user_id = $user_id AND requirement_id = $r_ID" );
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

                                                                                $data_new .= '<p style="margin: 0;">
                                                                                    <a href="'.$temp_file.'" data-src="'.$temp_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                                    <a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$r_ID.', '.$temp_ID.', 1, 1)">Upload</a>
                                                                                </p>';
                                                                            } else {
                                                                                $data_new .= '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$r_ID.', 0, 1, 1)">Upload</a>';
                                                                            }

                                                                        $data_new .= '</td>
                                                                        <td rowspan="2" class="text-center">0%</td>
                                                                    </tr>
                                                                    <tr class="tr_'.$r_ID.'">
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

                                                            if (!empty($default_list)) {
                                                                echo '<div class="mt-checkbox-list">'.$default_list.'</div>';
                                                            }

                                                            if (!empty($fsvp_list)) {
                                                                echo '<label class="control-label sbold">FSVP Section</label>
                                                                <div class="mt-checkbox-list">'.$fsvp_list.'</div>';
                                                            }

                                                            if (!empty($usda_list)) {
                                                                echo '<label class="control-label sbold">USDA Section</label>
                                                                <div class="mt-checkbox-list">'.$usda_list.'</div>';
                                                            }
                                                        ?>
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
                                                                        echo $data_new;

                                                                        // Formated on the upper line

																		// // if ($switch_user_id == 1211 OR $switch_user_id == 1684 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $switch_user_id == 1773 OR $switch_user_id == 1850) {
                                                                        // // if ($switch_user_id == 1684) {
																		// // 	$selectRequirement2Table = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE $sql_supplier international = 0 AND organic = 0 ORDER BY name" );
																		// // } else {
                                                                        //     $selectRequirement2Table = mysqli_query( $conn,"SELECT * FROM tbl_supplier_requirement WHERE deleted = 0 AND organic = 0 AND (FIND_IN_SET($switch_user_id, REPLACE(facility , ' ', '')) OR facility = 0 $international) ORDER BY name" );
                                                                        // // }

                                                                    	// if ( mysqli_num_rows($selectRequirement2Table) > 0 ) {
																		// 	while($rowTable = mysqli_fetch_array($selectRequirement2Table)) {
																		// 		$req_id = $rowTable["ID"];
																				
        								                                //         $req_name = htmlentities($rowTable["name"] ?? '');
        								                                //         if ($switch_user_id == 1486 AND !empty($rowTable["req"])) {
        								                                //             $req_name = htmlentities($rowTable["req"] ?? '');
        								                                //         }
                                    								    //         if ($req_id == 118 AND $switch_user_id == 1738) { $req_name = 'Traceability System'; }

                                                                        //         if ($switch_user_id == 1774) {
                                                                        //             if ($req_id == 3 OR $req_id == 4) {
                                                                        //                 $req_name = htmlentities($rowTable["name"] ?? '').' (Signed Copy from Suwerte)';
                                                                        //             }
                                                                        //             if ($req_id == 181 OR $req_id == 33) {
                                                                        //                 $req_name = htmlentities($rowTable["name"] ?? '').' (if applicable)';
                                                                        //             }
                                                                        //             if ($req_id == 16) {
                                                                        //                 $req_name = 'U.S. FDA Bioterrorism Registration Affidavit/ U.S. FDA Food Facility Registration';
                                                                        //             }
                                                                        //             if ($req_id == 115 OR $req_id == 18 OR $req_id == 20 OR $req_id == 71 OR $req_id == 72 OR $req_id == 75 OR $req_id == 102 OR $req_id == 193 OR $req_id == 191 OR $req_id == 192 OR $req_id == 24) {
                                                                        //                 $req_name = 'FSVP QI - '.htmlentities($rowTable["name"] ?? '');
                                                                        //             }
                                                                        //             if ($req_id == 156) {
                                                                        //                 $req_name = htmlentities($rowTable["name"] ?? '').' - from Suwerte’s forwarder';
                                                                        //             }
                                                                        //         }

																		// 		echo '<tr class="tr_'.$req_id.'">
												                        //             <td rowspan="2">
												                        //                 <input type="hidden" class="form-control" name="document_name[]" value="'.$req_id.'" required />
												                        //                 <b>'.$req_name.'</b>
												                        //             </td>
												                        //             <td class="text-center">
												                        //             	<select class="form-control hide" name="document_filetype[]" onchange="changeType(this)" required>
											                            //                     <option value="0">Select option</option>
											                            //                     <option value="1">Manual Upload</option>
											                            //                     <option value="2">Youtube URL</option>
											                            //                     <option value="3">Google Drive URL</option>
											                            //                     <option value="4">Sharepoint URL</option>
											                            //                 </select>
											                            //                 <input class="form-control margin-top-15 fileUpload" type="file" name="document_file[]" onchange="changeFile(this, this.value)" style="display: none;" />
											                            //                 <input class="form-control margin-top-15 fileURL" type="url" name="document_fileurl[]" onchange="changeFileURL(this, this.value)" style="display: none;" placeholder="https://" />
											                            //                 <p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>
												                        //             </td>
												                        //             <td>
												                        //             	<input type="text" class="form-control document_filename" name="document_filename[]" placeholder="Document Name" />
												                        //             </td>
												                        //             <td class="text-center">
												                        //                 <div class="input-group">
												                        //                     <input type="text" class="form-control daterange daterange_empty" name="document_daterange[]" value="" />
												                        //                     <span class="input-group-btn">
												                        //                         <button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">
												                        //                             <i class="fa fa-close"></i>
												                        //                         </button>
												                        //                     </span>
												                        //                 </div>
												                        //                 <input type="date" class="form-control hide" name="document_date[]" value="" />
												                        //                 <input type="date" class="form-control hide" name="document_due[]" value="" />
												                        //             </td>
												                        //             <td rowspan="2" class="text-center col-sop">
												                        //                 <input type="file" class="form-control hide" name="document_sop[]" />';

												                        //                 $selectSOP = mysqli_query( $conn,"SELECT * FROM tbl_supplier_sop WHERE deleted = 0 AND user_id = $user_id AND requirement_id = $req_id" );
												                        //                 if ( mysqli_num_rows($selectSOP) > 0 ) {
												                        //                     $rowSOP = mysqli_fetch_array($selectSOP);
												                        //                     $sop_ID = $rowSOP["ID"];
												                        //                     $sop_file = $rowSOP["file"];

												                        //                     $type = 'iframe';
												                        //                     $target = '';
												                        //                     $filetype = $rowSOP["filetype"];
												                        //                     $datafancybox = 'data-fancybox';
												                        //                     if ($filetype == 1) {
												                        //                         $fileExtension = fileExtension($sop_file);
												                        //                         $src = $fileExtension['src'];
												                        //                         $embed = $fileExtension['embed'];
												                        //                         $type = $fileExtension['type'];
												                        //                         $file_extension = $fileExtension['file_extension'];
												                        //                         $url = $base_url.'uploads/supplier/';

												                        //                         $sop_file = $src.$url.rawurlencode($sop_file).$embed;
												                        //                     } else if ($filetype == 3) {
												                        //                         $sop_file = preg_replace('#[^/]*$#', '', $sop_file).'preview';
												                        //                     } else if ($filetype == 4) {
												                        //                         $file_extension = 'fa-strikethrough';
												                        //                         $target = '_blank';
												                        //                         $datafancybox = '';
												                        //                     }

												                        //                     echo '<p style="margin: 0;">
												                        //                         <a href="'.$sop_file.'" data-src="'.$sop_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
												                        //                         <a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$req_id.', '.$sop_ID.', 1, 1)">Upload</a>
												                        //                     </p>';
												                        //                 } else {
												                        //                     echo '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('.$req_id.', 0, 1, 1)">Upload</a>';
												                        //                 }

												                        //             echo '</td>
                                                                        //             <td rowspan="2" class="text-center">
                                                                        //                 <input type="file" class="form-control hide" name="document_info[]" />';

                                                                        //                 $selectInfo = mysqli_query( $conn,"SELECT * FROM tbl_supplier_info WHERE deleted = 0 AND user_id = $user_id AND requirement_id = $req_id" );
                                                                        //                 if ( mysqli_num_rows($selectInfo) > 0 ) {
                                                                        //                     $rowInfo = mysqli_fetch_array($selectInfo);
                                                                        //                     $info_ID = $rowInfo["ID"];
                                                                        //                     $info_file = $rowInfo["file"];

                                                                        //                     $type = 'iframe';
                                                                        //                     $target = '';
                                                                        //                     $filetype = $rowInfo["filetype"];
                                                                        //                     $datafancybox = 'data-fancybox';
                                                                        //                     if ($filetype == 1) {
                                                                        //                         $fileExtension = fileExtension($info_file);
                                                                        //                         $src = $fileExtension['src'];
                                                                        //                         $embed = $fileExtension['embed'];
                                                                        //                         $type = $fileExtension['type'];
                                                                        //                         $file_extension = $fileExtension['file_extension'];
                                                                        //                         $url = $base_url.'uploads/supplier/';

                                                                        //                         $info_file = $src.$url.rawurlencode($info_file).$embed;
                                                                        //                     } else if ($filetype == 3) {
                                                                        //                         $info_file = preg_replace('#[^/]*$#', '', $info_file).'preview';
                                                                        //                     } else if ($filetype == 4) {
                                                                        //                         $file_extension = 'fa-strikethrough';
                                                                        //                         $target = '_blank';
                                                                        //                         $datafancybox = '';
                                                                        //                     }

                                                                        //                     echo '<p style="margin: 0;">
                                                                        //                         <a href="'.$info_file.'" data-src="'.$info_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
                                                                        //                         <a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$req_id.', '.$info_ID.', 1, 1)">Upload</a>
                                                                        //                     </p>';
                                                                        //                 } else {
                                                                        //                     echo '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('.$req_id.', 0, 1, 1)">Upload</a>';
                                                                        //                 }

                                                                        //             echo '</td>
												                        //             <td rowspan="2" class="text-center">
												                        //                 <input type="file" class="form-control hide" name="document_template[]" />';

												                        //                 $selectTemplate = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE user_id = $user_id AND requirement_id = $req_id" );
												                        //                 if ( mysqli_num_rows($selectTemplate) > 0 ) {
												                        //                     $rowTemplate = mysqli_fetch_array($selectTemplate);
												                        //                     $temp_ID = $rowTemplate["ID"];
												                        //                     $temp_file = $rowTemplate["file"];

												                        //                     $type = 'iframe';
												                        //                     $target = '';
												                        //                     $filetype = $rowTemplate["filetype"];
												                        //                     $datafancybox = 'data-fancybox';
												                        //                     if ($filetype == 1) {
												                        //                         $fileExtension = fileExtension($temp_file);
												                        //                         $src = $fileExtension['src'];
												                        //                         $embed = $fileExtension['embed'];
												                        //                         $type = $fileExtension['type'];
												                        //                         $file_extension = $fileExtension['file_extension'];
												                        //                         $url = $base_url.'uploads/supplier/';

												                        //                         $temp_file = $src.$url.rawurlencode($temp_file).$embed;
												                        //                     } else if ($filetype == 3) {
												                        //                         $temp_file = preg_replace('#[^/]*$#', '', $temp_file).'preview';
												                        //                     } else if ($filetype == 4) {
												                        //                         $file_extension = 'fa-strikethrough';
												                        //                         $target = '_blank';
												                        //                         $datafancybox = '';
												                        //                     }

												                        //                     echo '<p style="margin: 0;">
												                        //                         <a href="'.$temp_file.'" data-src="'.$temp_file.'" '.$datafancybox.' data-type="'.$type.'" class="btn btn-sm btn-info" target="'.$target.'">View</a> |
												                        //                         <a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$req_id.', '.$temp_ID.', 1, 1)">Upload</a>
												                        //                     </p>';
												                        //                 } else {
												                        //                     echo '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('.$req_id.', 0, 1, 1)">Upload</a>';
												                        //                 }

												                        //             echo '</td>
												                        //             <td rowspan="2" class="text-center">0%</td>
												                        //         </tr>
												                        //         <tr class="tr_'.$req_id.'">
												                        //             <td colspan="3">
												                        //             	<input type="text" class="form-control" name="document_comment[]" placeholder="Comment" />
												                        //             	<div class="row margin-top-10">
														                //                     <div class="col-md-3">
														                //                         <div class="form-group">
														                //                             <label class="control-label">Reviewed By</label>
														                //                             <select class="form-control " name="document_reviewed[]">
														                //                                 <option value="0">Select</option>
														                //                                 <option value="'.$current_userID.'">'.htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? '').'</option>
														                //                             </select>
														                //                         </div>
														                //                     </div>
														                //                     <div class="col-md-3">
														                //                         <div class="form-group">
														                //                             <label class="control-label">Reviewed Date</label>
														                //                             <input type="date" class="form-control" name="document_reviewed_date[]" value="">
														                //                         </div>
														                //                     </div>
														                //                     <div class="col-md-3">
														                //                         <div class="form-group">
														                //                             <label class="control-label">Approved By</label>
														                //                             <select class="form-control " name="document_approved[]">
														                //                                 <option value="0">Select</option>
														                //                                 <option value="'.$current_userID.'">'.htmlentities($current_userFName ?? '') .' '. htmlentities($current_userLName ?? '').'</option>
														                //                             </select>
														                //                         </div>
														                //                     </div>
														                //                     <div class="col-md-3">
														                //                         <div class="form-group">
														                //                             <label class="control-label">Approved Date</label>
														                //                             <input type="date" class="form-control" name="document_approved_date[]" value="">
														                //                         </div>
														                //                     </div>
														                //                 </div>
												                        //             </td>
												                        //         </tr>';
																		// 	}
																		// }
																	?>
																	
																</tbody>
                                                            </table>
                                                        </div>

														<?php 
															if ($switch_user_id == 1211 OR $switch_user_id == 1486 OR $switch_user_id == 1774 OR $switch_user_id == 1832 OR $switch_user_id == 1773 OR $switch_user_id == 1850) {
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
                                                    <div class="tab-pane" id="tabMaterials_1">
                                                        <?php
                                                            $pictogram = 'sup_add_material';
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
                                                        <a href="#modalNewMaterial" data-toggle="modal" class="btn green" onclick="btnNew_Material(<?php echo $switch_user_id; ?>, 1, 'modalNewMaterial', 1, 0)">Add New <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?></a>
                                                        <div class="table-scrollable">
                                                            <table class="table table-bordered table-hover" id="tableData_Material_1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?> Name</th>
                                                                        <th>SKU</th>
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
                                                            $pictogram = 'sup_add_service';
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
                                                            $pictogram = 'sup_add_review';
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
                                                        <h4><strong>Auditing Body</strong></h4>
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
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label">Audit Score</label>
																	<input class="form-control" type="text" name="audit_score" />
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
                                                                        <th style="width: 140px;">Requirement</th>
                                                                        <th class="text-center" style="width: 140px;">Supporting File</th>
                                                                        <th class="text-center" style="width: 200px;">Document Date</th>
                                                                        <th class="text-center" style="width: 140px;">Uploaded Date</th>
                                                                        <th class="text-center" style="width: 140px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabIOR_1">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">IOR – Consultare Inc. Group</label>
                                                                    <select class="form-control" name="ior_cig">
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">IOR Name</label>
                                                                    <input class="form-control" type="text" name="ior_name"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="ior_address"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone</label>
                                                                    <input class="form-control" type="text" name="ior_phone"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="text" name="ior_email"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">DUNS No.</label>
                                                                    <input class="form-control" type="text" name="ior_duns"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabAgent_1">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">U.S./FSVP Agent – Consultare Inc. Group</label>
                                                                    <select class="form-control" name="agent_cig">
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">U.S. Agent/FSVP Agent Company Name</label>
                                                                    <input class="form-control" type="text" name="agent_company"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Contact Name</label>
                                                                    <input class="form-control" type="text" name="agent_name"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Address</label>
                                                                    <input class="form-control" type="text" name="agent_address"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone 1</label>
                                                                    <input class="form-control" type="text" name="agent_phone_1"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Phone 2</label>
                                                                    <input class="form-control" type="text" name="agent_phone_2"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input class="form-control" type="text" name="agent_email"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">DUNS No.</label>
                                                                    <input class="form-control" type="text" name="agent_duns"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="modal-footer modal-footer--sticky bg-white">
											<a href="javascript:;" class="btn dark btn-outline hide" onclick="btnSaveClose('modalNew', 'modalSave')" title="Close">Close</a>
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier" id="btnSave_Supplier" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                            <h4 class="modal-title"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipper':'Supplier'; ?> Details</h4>
                                        </div>
                                        <div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
											<a href="javascript:;" class="btn dark btn-outline hide" onclick="btnSaveClose('modalView', 'modalUpdate')" title="Close">Close</a>
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier" id="btnUpdate_Supplier" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

						<div class="modal fade" id="modalViewReq" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-full">
								<div class="modal-content">
									<form method="post" enctype="multipart/form-data" class="modalForm modalViewReq">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Supplier Requirement</h4>
										</div>
										<div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
											<input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
											<button type="submit" class="btn btn-success ladda-button" name="btnUpdate_SupplierReq" id="btnUpdate_SupplierReq" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal fade" id="modalViewReqReport" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-full">
								<div class="modal-content">
									<form method="post" enctype="multipart/form-data" class="modalForm modalViewReqReport">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Table Report</h4>
										</div>
										<div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
											<input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
											<button type="button" class="btn green ladda-button" name="btnExportReq" id="btnExportReq" data-style="zoom-out"><span class="ladda-label">Export</span></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="modal fade" id="modalNewRegulatory" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<form method="post" enctype="multipart/form-data" class="modalForm modalNewRegulatory">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">New Regulatory</h4>
										</div>
										<div class="modal-body"></div>
										<div class="modal-footer">
											<input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
											<button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Regulatory" id="btnSave_Supplier_Regulatory" data-style="zoom-out"><span class="ladda-label">Add Regulatory</span></button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal fade" id="modalEditRegulatory" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<form method="post" enctype="multipart/form-data" class="modalForm modalEditRegulatory">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Regulatory Details</h4>
										</div>
										<div class="modal-body"></div>
										<div class="modal-footer">
											<input type="button" class="btn dark btn-outline hide" data-dismiss="modal" value="Close" />
											<button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Regulatory" id="btnUpdate_Supplier_Regulatory" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
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

						<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalListMaterial" tabindex="-1" role="basic" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?> Details</h4>
									</div>
									<div class="modal-body"></div>
									<div class="modal-footer">
										<input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
									</div>
								</div>
							</div>
						</div>
                        <div class="modal fade" id="modalNewMaterial" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSave_Material">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">New <?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?></h4>
                                        </div>
                                        <div class="modal-body"></div>
										<div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Material" id="btnSave_Supplier_Material" data-style="zoom-out"><span class="ladda-label">Add Material</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEditMaterial" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-full">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Material">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title"><?php echo ($switch_user_id == 1984 OR $switch_user_id == 1986) ? 'Shipment':'Material'; ?> Details</h4>
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
                        <div class="modal fade" id="modalEditRisk" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate_Risk">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Risk Assessment</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Risk" id="btnUpdate_Risk" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
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
                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_Supplier_Service" id="btnSave_Supplier_Service" data-style="zoom-out"><span class="ladda-label">Add Service</span></button>
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
                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier_Service" id="btnUpdate_Supplier_Service" data-style="zoom-out"><span class="ladda-label">Save & Close</span></button>
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
                                            <table class="table table-bordered table-hover tableData_Report" id="table2excel">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 135px;">Compliance</th>
                                                        <th>Supplier Name</th>
                                                        <th class="text-center" style="width: 135px;">Required Documents</th>
                                                        <th class="text-center" style="width: 135px;">Materials</th>
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
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalReportView">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Report</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-hover" id="tableData_ReportView"></table>
                                        </div>
                                        <div class="modal-footer modal-footer--sticky bg-white">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="button" class="btn green ladda-button" name="btnExport" id="btnExport_ReportView" data-style="zoom-out"><span class="ladda-label">Export</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

				        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalImportPreview" tabindex="-1" role="dialog" aria-hidden="true">
				            <div class="modal-dialog modal-full">
				                <div class="modal-content">
				                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalImportPreview">
				                        <div class="modal-header">
				                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				                            <h4 class="modal-title">Import Data</h4>
				                        </div>
				                        <div class="modal-body">
				                        	<table class="table table-bordered table-hover hide" id="tableData_import_DL">
				                        		<thead>
				                        			<tr>
				                        				<th><b>Supplier Name</b></th>
				                        				<th>Bldg No./Street</th>
				                        				<th>City</th>
				                        				<th>State</th>
				                        				<th>Zip Code</th>
				                        				<th>Email</th>
				                        			</tr>
				                        		</thead>
				                        		<tbody>
				                        			<tr>
				                        				<td>Sample Name</td>
				                        				<td>Sample Bldg</td>
				                        				<td>Sample City</td>
				                        				<td>Sample State</td>
				                        				<td>1234</td>
				                        				<td>youremail@domain.com</td>
				                        			</tr>
				                        		</tbody>
				                        	</table>
				                        	<table class="table table-bordered table-hover" id="tableData_import">
				                        		<thead>
				                        			<tr>
				                        				<th>Supplier Name</th>
				                        				<th>Bldg No./Street</th>
				                        				<th>City</th>
				                        				<th>State</th>
				                        				<th>Zip Code</th>
				                        				<th>Email</th>
				                        				<th class="text-center" style="width: 135px;">Action</th>
				                        			</tr>
				                        		</thead>
				                        		<tbody></tbody>
				                        	</table>
				                        </div>
				                        <div class="modal-footer modal-footer--sticky bg-white">
				                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
				                        	<a href="javascript:;" class="btn btn-info m-0" onclick="btnTemplateDL()"><i class="fa fa-download"> Download Template</i></a>
				                        	<a href="#modalImportDL" data-toggle="modal" class="btn btn-default m-0"><i class="fa fa-upload"> Import</i></a>
				                            <button type="submit" class="btn green ladda-button" name="btnSave_ImportPreview" id="btnSave_ImportPreview" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
				                        </div>
				                    </form>
				                </div>
				            </div>
				        </div>
				        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalImportDL" tabindex="-1" role="dialog" aria-hidden="true">
				            <div class="modal-dialog">
				                <div class="modal-content">
				                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalImportDL">
				                        <div class="modal-header">
				                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				                            <h4 class="modal-title">Upload Data</h4>
				                        </div>
				                        <div class="modal-body">
				                        	<input type="file" class="form-control" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required="">
				                        </div>
				                        <div class="modal-footer modal-footer--sticky bg-white">
				                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
				                            <button type="submit" class="btn green ladda-button" name="btnSave_ImportDL" id="btnSave_ImportDL" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
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
                        
					    <!--Nelmar Supplier Analytics Modal -->
						<div id="modalChart" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Vendor Chart</h4>
									</div>
									<div class="modal-body">																			
									    <div class="row ">   
										    <div class="col-md-12">   											                                  
												<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-10">   
													<h3 class="d-flex justify-content-center">Requirements</h3>   
													<div class="widget-thumb-wrap">                                       																
														<div id="requirementChartDiv" style="width: 100%; height: 500px;">																	
														</div>
													</div>
												</div>     
											</div> 
											<div class="col-md-12">                                     
												<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-10">   
													<h3 class="d-flex justify-content-center">Compliance</h3>   
													<div class="widget-thumb-wrap">                                       																
														<div id="complianceChartDiv" style="width: 100%; height: 500px;">																	
														</div>
													</div>
												</div>     
											</div> 
											<div class="col-md-12"> 
												<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-10">                                         
													<h3 class="d-flex justify-content-center">Materials</h3>
													<div class="widget-thumb-wrap">
														<div id="materialsChartDiv" style="width: 100%; height: 500px;">																	
														</div>
													</div>                                 
												</div> 
											</div> 
											<div class="col-md-12"> 
												<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-10">                                         
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
                </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>    
        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
        <script type="text/javascript" src="exes/tableExport.js"></script>


        <?php // if($switch_user_id == 464 OR $switch_user_id == 1106) { ?>
            <script src="AnalyticsIQ/supplier_chart.js"></script>
        <?php //  } ?>		
        

        <script type="text/javascript">
            var current_client = '<?php echo $_COOKIE['client']; ?>';
            var switch_user_id = '<?php echo $switch_user_id; ?>';
            var iso = '<?php echo $enterp_iso2; ?>';
            $(document).ready(function(){

                <?php echo $rowID > 0 ? 'singleView('.$rowID.');':''; ?>
		        var site = '<?php echo $site; ?>';
		        
                // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                    $('#save_video').attr('disabled','disabled');
                    $('#save_video_text').text("Uploading...");
                    var action_data = "supplier";
                    var user_id = $('#switch_user_id').val();
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
                    // 		console.log('done : ' + data);
                    		if(data == 1){
                    		    window.location.reload();
                    		}
                    		else{
                    		    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
                    		}
                    	}
                    });
                });
    			
                // Emjay script ends here
                
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
                $('#tableData_req').DataTable({
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

				var tableData_1 = $('#tableData_1').DataTable({
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
			    
			    
                function getColumnIndexByClass(className) {
                    let index = -1;
                    $('#tableData_1 thead th').each(function(i) {
                        if ($(this).hasClass(className)) {
                            index = i;
                            return false; // break loop
                        }
                    });
                    return index;
                }
                $("#filterSent").on('change', function() {
                    // Get column indexes by class name
                    var colTypeIndex = getColumnIndexByClass('col-type'); // e.g., for column 2
                    var colIsoIndex = getColumnIndexByClass('col-iso');   // e.g., for column 6
                    
                    if (colTypeIndex === -1 || colIsoIndex === -1) {
                        console.error("Column class not found");
                        return;
                    }
                    
                    switch ($(this).val()) {
                        case '1':
                            tableData_1.column(colTypeIndex).search('').draw();
                            tableData_1.column(colIsoIndex).search('^(?!' + iso + '$).*$', true, false).draw();
                            break;
                        case '2':
                            tableData_1.column(colTypeIndex).search('').draw();
                            tableData_1.column(colIsoIndex).search(iso).draw();
                            break;
                        case '3':
                            tableData_1.column(colTypeIndex).search('Contract Service Provider').draw();
                            tableData_1.column(colIsoIndex).search('').draw();
                            break;
                        case '4':
                            tableData_1.column(colTypeIndex).search('Contract Manufacturer').draw();
                            tableData_1.column(colIsoIndex).search('').draw();
                            break;
                        default:
                            tableData_1.column(colTypeIndex).search('').draw();
                            tableData_1.column(colIsoIndex).search('').draw();
                    }
                });
				// $("#filterSent").on('change', function() {
				//     var iso = '<?php echo $enterp_iso2; ?>';
				//     //filter by selected value on second column
				//     if ($(this).val() == 1) {
				//     	tableData_1.column(2).search('').draw();
				//     	tableData_1.column(6).search('^(?!'+iso+'$).*$', true, false).draw();
				//     } else if ($(this).val() == 2) {
				//     	tableData_1.column(2).search('').draw();
				//     	tableData_1.column(6).search(iso).draw();
				//     } else if ($(this).val() == 3) {
				//     	tableData_1.column(2).search('Contract Service Provider').draw();
				//     	tableData_1.column(6).search('').draw();
				//     } else if ($(this).val() == 4) {
				//     	tableData_1.column(2).search('Contract Manufacturer').draw();
				//     	tableData_1.column(6).search('').draw();
				//     } else {
				//     	tableData_1.column(2).search('').draw();
				//     	tableData_1.column(6).search('').draw();
				//     }
				// });
				$("#tableData_1_filter.dataTables_filter").append($("#filterSent"));

				var tableData_2 = $('#tableData_2').DataTable({
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
                $("#filterReceived").on('change', function() {                    
                    // Get column indexes by class name
                    var colTypeIndex = getColumnIndexByClass('col-type'); // e.g., for column 2
                    var colIsoIndex = getColumnIndexByClass('col-iso');   // e.g., for column 6
                    
                    if (colTypeIndex === -1 || colIsoIndex === -1) {
                        console.error("Column class not found");
                        return;
                    }
                    
                    switch ($(this).val()) {
                        case '1':
                            tableData_2.column(colTypeIndex).search('').draw();
                            tableData_2.column(colIsoIndex).search('^(?!' + iso + '$).*$', true, false).draw();
                            break;
                        case '2':
                            tableData_2.column(colTypeIndex).search('').draw();
                            tableData_2.column(colIsoIndex).search(iso).draw();
                            break;
                        case '3':
                            tableData_2.column(colTypeIndex).search('Contract Service Provider').draw();
                            tableData_2.column(colIsoIndex).search('').draw();
                            break;
                        case '4':
                            tableData_2.column(colTypeIndex).search('Contract Manufacturer').draw();
                            tableData_2.column(colIsoIndex).search('').draw();
                            break;
                        default:
                            tableData_2.column(colTypeIndex).search('').draw();
                            tableData_2.column(colIsoIndex).search('').draw();
                    }
                });
				// $("#filterReceived").on('change', function() {
				//     var iso = '<?php echo $enterp_iso2; ?>';
				//     //filter by selected value on second column
				//     if ($(this).val() == 1) {
				//     	tableData_2.column(2).search('').draw();
				//     	tableData_2.column(6).search('^(?!'+iso+'$).*$', true, false).draw();
				//     } else if ($(this).val() == 2) {
				//     	tableData_2.column(2).search('').draw();
				//     	tableData_2.column(6).search(iso).draw();
				//     } else if ($(this).val() == 3) {
				//     	tableData_2.column(2).search('Contract Service Provider').draw();
				//     	tableData_2.column(6).search('').draw();
				//     } else if ($(this).val() == 4) {
				//     	tableData_2.column(2).search('Contract Manufacturer').draw();
				//     	tableData_2.column(6).search('').draw();
				//     } else {
				//     	tableData_2.column(2).search('').draw();
				//     	tableData_2.column(6).search('').draw();
				//     }
				// });
				$("#tableData_2_filter.dataTables_filter").append($("#filterReceived"));

                // changeIndustry(0, 1);

                widget_tagInput();
                widget_formRepeater();
				widget_dates_1();
				widget_date_audit();
				$('.selectpicker').selectpicker();
				changeFrequency(2);

				// var tableCategory = $('#tableData_category').DataTable();
				var tableCategory = $('#tableData_category').DataTable({
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
				$("#filterCategory").on('change', function() {
				    //filter by selected value on second column
				    tableCategory.column(4).search($(this).val()).draw();
				});
				
	            // Setup - add a text input to each footer cell
			    $('#tableData_category tfoot th').each( function () {
			        var title = $('#tableData_category thead th').eq( $(this).index() ).text();
			        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			    } );
			    
			    // Apply the search
			    tableCategory.columns().eq( 0 ).each( function ( colIdx ) {
			        $( 'input', tableCategory.column( colIdx ).footer() ).on( 'keyup change', function () {
			            tableCategory
			                .column( colIdx )
			                .search( this.value )
			                .draw();
			        } );
			    } );
				
	            $("#btnExport, #btnExportReq").click(function(){
	                $("#table2excel").table2excel({
	                    exclude:".noExl",           // exclude CSS class
	                    name:"Worksheet Name",
	                    filename:"Download",        //do not include extension
	                    fileext:".xlsx",             // file extension
	                    exclude_img:true,
	                    exclude_links:true,
	                    exclude_inputs:true
	                });
	            });
	            $("#btnExport_ReportView").click(function(){
	                $("#tableData_ReportView").table2excel({
	                    exclude:".noExl",           // exclude CSS class
	                    name:"Worksheet Name",
	                    filename:"Download",        //do not include extension
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
				widget_dates_1();
				widget_date_audit();
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
			function selectTab(tab) {
				if (tab == 2) {
					$('.portlet-title .caption').html(`
						<span class="icon-basket-loaded font-dark"></span>
						<span class="caption-subject font-dark bold uppercase">List of Materials</span>
					`);
					$('.portlet-title .caption > a').hide();
				} else if (tab == 3) {
					$('.portlet-title .caption').html(`
						<span class="fa fa-line-chart font-dark"></span>
						<span class="caption-subject font-dark bold uppercase">Analytics</span>
					`);
					$('.portlet-title .caption > a').hide();
				} else {
					$('.portlet-title .caption').html(`
						<span class="icon-basket-loaded font-dark"></span>
						<span class="caption-subject font-dark bold uppercase">List of Supplier</span>
					`);
					$('.portlet-title .caption > a').show();
				}
			}

			

			// function selectTab(tab) {
			// 	if (tab == 1) {
			// 		$('.portlet-title .caption-subject').html('List of Materials');
			// 		$('.portlet-title .caption > a').hide();
			// 	} else {
			// 		$('.portlet-title .caption-subject').html('List of Supplier');
			// 		$('.portlet-title .caption > a').show();
			// 	}
			// }

            function changedCategory(sel, modal) {
                if (sel.value == 3) {
                    $('.tabMaterials').addClass('hide');
                    $('.tabService').removeClass('hide');
                } else {
                    $('.tabMaterials').removeClass('hide');
                    $('.tabService').addClass('hide');
                }

                $('#supplier_category_other_'+modal).hide();
                if (sel.value == 41) { $('#supplier_category_other_'+modal).show(); }
            }
            function changeIndustry(id, modal, source) {
				// var client = '<?php echo $current_client; ?>';

                // $('#supplier_industry_other_'+modal).hide();
                // if (id == 34) { $('#supplier_industry_other_'+modal).show(); }
                
				// if (current_client == 0) {
				// 	var country = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
				// 	var organic = $('#tabBasic_'+modal+' select[name="organic"]').val();

				// 	if (id == 13 || id == 22 || id == 25) { id = id; }
				// 	else { id = 0; }
					
				// 	$.ajax({
				// 		type: "GET",
				// 		url: "function.php?modalView_Supplier_Industry="+id+"&c="+country+"&o="+organic+"&m="+modal+"&s="+source,
				// 		dataType: "html",
				// 		success: function(data){
				// 			$('#tabDocuments_'+modal+' .mt-checkbox-list').html(data);
				// 			$('#tableData_Requirement_'+modal+' tbody').html('');
				// 		}
				// 	});
				// }
            }
            function changeCountry(modal, source) {
                // var industry = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                // changeIndustry(industry, modal, source);
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
            function changeCost(val, type) {
                if (type === 1) {
                    var lb = 2.20462 * val;
                    var oz = 35.274 * val;

                    $('.cost_lb').val(lb.toFixed(2));
                    $('.cost_oz').val(oz.toFixed(2));
                } else if (type === 2) {
                    var kg = 0.453592 * val;
                    var oz = 16 * val;

                    $('.cost_kg').val(kg.toFixed(2));
                    $('.cost_oz').val(oz.toFixed(2));
                } else if (type == 3) {
                    var kg = 0.0283495 * val;
                    var lb = 0.0625 * val;

                    $('.cost_kg').val(kg.toFixed(2));
                    $('.cost_lb').val(lb.toFixed(2));
                }
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
                    url: "function.php?modalView_Supplier="+id+"&c="+iso,
                    dataType: "html",
                    success: function(data){
                        $("#singleView").html(data);
                        $("#singleView").append('<button type="submit" class="btn btn-success ladda-button" name="btnUpdate_Supplier" id="btnUpdate_Supplier" data-style="zoom-out"><span class="ladda-label">Save Changes</span></button>');

						widget_tagInput();
						widget_dates();
						widget_date_audit();
						$('.selectpicker').selectpicker();
						$('#tableData_Material_2').DataTable();
                    }
                });
            }
            <?php
                if (!empty($encoded_d) AND !empty($encoded_u) AND !empty($encoded_f)) {
                    if (ctype_digit($g_d) AND ctype_digit($g_u) AND ctype_digit($g_f)) {
                        $g_d = intval($g_d);
            ?>
                        
                        function btnViewG(id) {
                            $.ajax({    
                                type: "GET",
                                url: "function.php?modalView_Supplier="+id,
                                dataType: "html",                  
                                success: function(data){     
                                    
                                    $('#modalView').modal('show');
                                    
                                    $("#modalView .modal-body").html(data);
                                    
                                    widget_tagInput();
                                    widget_dates();
            						widget_date_audit();
            						$('.selectpicker').selectpicker();
            						$('#tableData_Material_2').DataTable();
                                }
                            });
                        }
            
            <?php
                        echo 'btnViewG('.$g_d.')';
                    }
                }
            ?>
            
            
            function btnView(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier="+id+"&c="+iso,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalView .modal-body").html(data);
                        
                        widget_tagInput();
                        widget_dates();
						widget_date_audit();
						$('.selectpicker').selectpicker();
						$('#tableData_Material_2').DataTable();
                    }
                });
            }
			function btnViewReq(id) {
				$.ajax({    
					type: "GET",
					url: "function.php?modalView_SupplierReq="+id+"&c="+iso,
					dataType: "html",                  
					success: function(data){       
						$("#modalViewReq .modal-body").html(data);
						widget_dates();
					}
				});
			}
			function btnViewReqReport(id) {
				$.ajax({    
					type: "GET",
					url: "function.php?modalView_SupplierReqReport="+id+"&c="+iso,
					dataType: "html",                  
					success: function(data){       
						$("#modalViewReqReport .modal-body").html(data);
						widget_dates();
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
                    // $.ajax({
                    //     type: "GET",
                    //     url: "function.php?btnDelete_Supplier="+id,
                    //     dataType: "html",
                    //     success: function(data){
                    //         // alert(data);
                    //         $('#tableData_1 tbody #tr_'+id).remove();
                    //     }
                    // });
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
                        $('.tableData_Report').DataTable().destroy();
                        $("#modalReport .modal-body table tbody").html(data);
                        $('.tableData_Report').DataTable({
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
                        $("#modalReportView .modal-body table").html(data);
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
						url: "function.php?modalSend_Supplier="+id,
						dataType: "html",
						success: function(data){
							// msg = "Sucessfully Sent!";
							// bootstrapGrowl(msg);
						}
                    });
                    swal("Done!", "Email has been sent.", "success");
                });
            }
            function btnImport(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalImport="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalImport .modal-body").html(data);
                    }
                });
            }
            function btnTemplateDL(){
                $('#tableData_import_DL').tableExport({
                    // headings: true,                     // (Boolean), display table headings (th/td elements) in the <thead>
                    // footers: true,                      // (Boolean), display table footers (th/td elements) in the <tfoot>
                    // formats: ["xls", "csv", "txt"],     // (String[]), filetype(s) for the export
                    // fileName: "id",                     // (id, String), filename for the downloaded file
                    // bootstrap: true,                    // (Boolean), style buttons using bootstrap
                    // position: "bottom",                 // (top, bottom), position of the caption element relative to table
                    // ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file
                    // ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file
                    // ignoreCSS: ".tableexport-ignore"    // (selector, selector[]), selector(s) to exclude from the exported file

                    fileName: 'template',
                    type: 'csv',
                    htmlHyperlink: 'href',
                    numbers: {
                        html: {
                            decimalMark: '.',
                            thousandsSeparator: ','
                        },
                        output: {
                            decimalMark: ',',
                            thousandsSeparator: ''
                        }
                    }
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
			function widget_dates_1() {
				$('#tableData_Requirement_1 tbody .daterange').daterangepicker({
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
				$('#tableData_Requirement_1 tbody .daterange_empty').val('');
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

				if (switch_user_id == 1211 || switch_user_id == 1486 || switch_user_id == 1774 || switch_user_id == 1832 || switch_user_id == 1773 || switch_user_id == 1850) {
					$('#tableData_Requirement_Other_2 tbody .daterange').daterangepicker({
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
					$('#tableData_Requirement_Other_2 tbody .daterange_empty').val('');
				}
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
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange_empty').val('');
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
			function widget_dates_modal(e) {
				$('#'+e+' .daterange').daterangepicker({
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
                                        // widget_dates_material(i);

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
                                        $(this).find('.daterange_empty').val('');
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
            function widget_textarea() {
				// Targets all textareas with class "txta"
				let textareas = document.querySelectorAll('.txta'),
				    hiddenDiv = document.createElement('div'),
				    content = null;

				// Adds a class to all textareas
				for (let j of textareas) {
				  j.classList.add('txtstuff');
				}

				// Build the hidden div's attributes

				// The line below is needed if you move the style lines to CSS
				// hiddenDiv.classList.add('hiddendiv');

				// Add the "txta" styles, which are common to both textarea and hiddendiv
				// If you want, you can remove those from CSS and add them via JS
				hiddenDiv.classList.add('txta');

				// Add the styles for the hidden div
				// These can be in the CSS, just remove these three lines and uncomment the CSS
				hiddenDiv.style.display = 'none';
				hiddenDiv.style.whiteSpace = 'pre-wrap';
				hiddenDiv.style.wordWrap = 'break-word';

				// Loop through all the textareas and add the event listener
				for(let i of textareas) {
				  (function(i) {
				    // Note: Use 'keyup' instead of 'input'
				    // if you want older IE support
				    i.addEventListener('input', function() {
				      
				      // Append hiddendiv to parent of textarea, so the size is correct
				      i.parentNode.appendChild(hiddenDiv);
				      
				      // Remove this if you want the user to be able to resize it in modern browsers
				      i.style.resize = 'none';
				      
				      // This removes scrollbars
				      i.style.overflow = 'hidden';

				      // Every input/change, grab the content
				      content = i.value;

				      // Add the same content to the hidden div
				      
				      // This is for old IE
				      content = content.replace(/\n/g, '<br>');
				      
				      // The <br ..> part is for old IE
				      // This also fixes the jumpy way the textarea grows if line-height isn't included
				      hiddenDiv.innerHTML = content + '<br style="line-height: 3px;">';

				      // Briefly make the hidden div block but invisible
				      // This is in order to read the height
				      hiddenDiv.style.visibility = 'hidden';
				      hiddenDiv.style.display = 'block';
				      i.style.height = hiddenDiv.offsetHeight + 'px';

				      // Make the hidden div display:none again
				      hiddenDiv.style.visibility = 'visible';
				      hiddenDiv.style.display = 'none';
				    });
				  })(i);
				}
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
                // 	if (inputValue == true) {
                // 		$('.'+form).submit();
                // 		$('#'+modal).modal('hide');
                // 	} else {
                // 		$('#'+modal).modal('hide');
                // 	}
                // });
                
                $('#'+modal).modal('hide');
            }
            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSave') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier'));
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
                                html += '<td>'+obj.supplier_code+'</td>';
                                html += '<td>'+obj.supplier_name+'</td>';
                                html += '<td class="col-category">'+obj.category+'</td>';
                                html += '<td>'+obj.material+'</td>';

								if (switch_user_id != 1211 && switch_user_id != 1684 && switch_user_id != 1984 && switch_user_id != 1986) {
									html += '<td class="col-specification"></td>';
								}
								
                                html += '<td>'+obj.address+'</td>';
                                html += '<td class="text-center">'+obj.country+'</td>';
                                html += '<td class="col-contact">'+obj.contact_name+'</td>';
                                html += '<td class="col-contact text-center">'+obj.contact_info+'</td>';
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
                formData.append('btnUpdate_Supplier',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier'));
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
                            var html = '<td>'+obj.supplier_code+'</td>';
                            html += '<td>'+obj.supplier_name+'</td>';
                            html += '<td class="col-category">'+obj.category+'</td>';
                            html += '<td>'+obj.material+'</td>';

							if (switch_user_id != 1211 && switch_user_id != 1684 && switch_user_id != 1984 && switch_user_id != 1986) {
								html += '<td class="col-specification"></td>';
							}
							
                            html += '<td>'+obj.address+'</td>';
                            html += '<td class="text-center">'+obj.country+'</td>';
                            html += '<td class="col-contact">'+obj.contact_name+'</td>';
                            html += '<td class="col-contact text-center">'+obj.contact_info+'</td>';
                            html += '<td class="text-center">'+obj.compliance+'%</td>';
                            html += '<td class="text-center">'+obj.status+'</td>';
                            html += '<td class="text-center">';

                                if (obj.page == 2) {
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
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
			$(".modalViewReq").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;

				if (inputInvalid('modalViewReq') > 0) { return false; }
					
				var formData = new FormData(this);
				formData.append('btnUpdate_SupplierReq',true);

				var l = Ladda.create(document.querySelector('#btnUpdate_SupplierReq'));
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
							var html = '<td>'+obj.supplier_name+'</td>';
							html += '<td>'+obj.category+'</td>';
							html += '<td class="text-center">'+obj.compliance+'%</td>';
							html += '<td class="text-center">';
							html += '<td class="text-center">';
								html += '<a href="#modalViewReq" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnViewReq('+obj.ID+')">View</a>';
								html += '<a href="#modalViewReqReport" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnViewReqReport('+obj.ID+')">Report</a>';
							html += '</td>';

							$('#tableData_req tbody #tr_'+obj.ID).html(html);

							// CounterUp Section
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
							$('#modalViewReq').modal('hide');
						} else {
							msg = "Error!"
						}
						l.stop();

						bootstrapGrowl(msg);
					}
				});
			}));
            $(".modalImportPreview").on('submit',(function(e) {
                e.preventDefault();

                // const selectors = document.querySelectorAll('td[contenteditable="true"][required]');

				// for (let selector of selectors) {
				//   selector.addEventListener('input', () => {
				//     if (selector.innerHTML === '') {
				//       selector.style.border = '2px solid red';
				//       selector.classList.add('content-invalid');
				//     }
				//     else {
				//       selector.style.border = 0;
				//       selector.classList.remove('content-invalid');
				//     }
				//   })
				// }

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_ImportPreview',true);

                var l = Ladda.create(document.querySelector('#btnSave_ImportPreview'));
                l.start();

                // console.log(formData);

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        // console.log(response);
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);

                            // $("#modalEdit .modal-body .tabbable .tab-content #tabSheet_"+obj.sheet_id+" table:not(#tableTemplate_"+obj.sheet_id+") tbody").html(obj.data);
                            
							$('#tableData_1 tbody').append(obj.data);
                            $('#modalImportPreview').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalImportDL").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_ImportDL',true);

                var l = Ladda.create(document.querySelector('#btnSave_ImportDL'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            // console.log(response);

                            var obj = jQuery.parseJSON(response);

                            $("#modalImportPreview .modal-body #tableData_import tbody").html(obj.data);
                            $('#modalImportDL').modal('hide');
                            widget_textarea();
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnClear_Import() {
            	$('#tableData_import tbody').html('');
            }
			function btnRemove_Import(e) {
				$(e).parent().parent().remove();
			}

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
							data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+x+', 0, 1, '+modal+')">Upload </a>';
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

					if (other == 1) {
						$('#tableData_Requirement_Other_'+modal+' tbody').append(data);
					} else {
						$('#tableData_Requirement_'+modal+' tbody').append(data);
					}

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
            function checked_RequirementOther(id, modal, other) {
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

					if (other == 1) {
						$('#tableData_Requirement_Other_'+modal+' tbody').append(data);
					} else {
						$('#tableData_Requirement_'+modal+' tbody').append(data);
					}
					
					widget_date_other(x, modal, other);
					widget_date_clear_other(x, modal, other);
                } else {
					if (other == 1) {
						$('#tableData_Requirement_Other_'+modal+' tbody .tr_other_'+x).remove();
					} else {
						$('#tableData_Requirement_'+modal+' tbody .tr_other_'+x).remove();
					}
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

                        // wholeNumber = parseInt(x.replace(/\D/g, ""), 10);
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

                    widget_date_other(x, 'Material_'+modal, other);
                    widget_date_clear_other(x, 'Material_'+modal, other);
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
                            widget_date(id.value, 'Material_'+modal);

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
                                data += '<a href="#modalSOP2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnSOP2('+id+', 0, 2 '+modal+')">Upload </a>';
                            data += '</td>';
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_info[]" />';
                                data += '<a href="#modalInfo2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnInfo2('+id+', 0, 2 '+modal+')">Upload </a>';
                            data += '</td>';
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                                data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+id+', 0, 2 '+modal+')">Upload </a>';
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
                    
                    widget_date_other(x, 'Material_'+modal, other);
                    widget_date_clear_other(x, 'Material_'+modal, other);
                } else {
                    if (other == 1) {
                        $('#tableData_Requirement_Material_Other_'+modal+' tbody .tr_other_'+x).remove();
                    } else {
                        $('#tableData_Requirement_Material_'+modal+' tbody .tr_other_'+x).remove();
                    }
                }
            }

			// Regulatory
			function btnNew_Regulatory(id, modal) {
				$.ajax({    
					type: "GET",
					url: "function.php?modalNew_Supplier_Regulatory="+id+"&m="+modal,
					dataType: "html",                  
					success: function(data){       
						$("#modalNewRegulatory .modal-body").html(data);
						widget_dates_modal('modalNewRegulatory');
					}
				});
			}
			$(".modalNewRegulatory").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btnSave_Supplier_Regulatory',true);

				var l = Ladda.create(document.querySelector('#btnSave_Supplier_Regulatory'));
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
							$('#tableData_Regulatory_'+obj.modal+' tbody').append(obj.data);
							$('#modalNewRegulatory').modal('hide');
						} else {
							msg = "Error!"
						}
						l.stop();

						bootstrapGrowl(msg);
					}
				});
			}));
			function btnEdit_Regulatory(id, modal) {
				$.ajax({    
					type: "GET",
					url: "function.php?modalView_Supplier_Regulatory="+id+"&m="+modal,
					dataType: "html",                  
					success: function(data){       
						$("#modalEditRegulatory .modal-body").html(data);
						widget_dates_modal('modalEditRegulatory');
					}
				});
			}
			$(".modalEditRegulatory").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btnUpdate_Supplier_Regulatory',true);

				var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Regulatory'));
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
							$('#tableData_Regulatory_'+obj.modal+' tbody #tr_'+obj.ID).html(obj.data);
							$('#modalEditRegulatory').modal('hide');
						} else {
							msg = "Error!"
						}
						l.stop();

						bootstrapGrowl(msg);
					}
				});
			}));
			function btnRemove_Regulatory(id, modal) {
				$('#tableData_Regulatory_'+modal+' tbody #tr_'+id).remove();
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
                btnReset(view);
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
                            html += '<td class="text-center">';
                                html += '<input type="checkbox" name="checkedContact" value="'+obj.ID+'" onclick="btnCheck_Contact('+obj.ID+', this)">';
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

            // Material Section
            $(".modalSave_Material").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Material',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Material'));
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
                                html += '<td>'+obj.material_description+'</td>';
								html += '<td class="text-center">Yes</td>';
								html += '<td class="text-center">0%</td>';
                                html += '<td class="text-center">'+obj.material_id+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                    
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("5")) {
                                        html += '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Material" onclick="btnEdit_Material('+obj.ID+', '+obj.modal+', \'modalEditMaterial\', '+obj.f+', '+obj.s+')">Edit</a>';
                                    }
                                    if (switch_user_id == 1984 || switch_user_id == 1986) {
                                        html += '<a href="#modalEditRisk" data-toggle="modal" class="btn purple-seance btn-sm" onclick="btnEdit_Risk('+obj.ID+')">Risk</a>';
                                    }
                                    if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Material" onclick="btnRemove_Material('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    }
                                    
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Material_'+obj.modal+' tbody').append(html);
                            $('#modalNewMaterial').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Material(id, modal, view, f, s) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalNew_Supplier_Material="+id+"&m="+modal+"&f="+f+"&s="+s,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewMaterial .modal-body").html(data);
                        widget_formRepeater_material('New');
                        widget_dates_material('New');

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
                                    html += '<a href="#modalEditMaterial" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Material" onclick="btnEdit_Material('+obj.ID+', '+obj.modal+', \'modalEditMaterial\', '+obj.f+', '+obj.s+')">Edit</a>';
                                }
                                if (switch_user_id == 1984 || switch_user_id == 1986) {
                                    html += '<a href="#modalEditRisk" data-toggle="modal" class="btn purple-seance btn-sm" onclick="btnEdit_Risk('+obj.ID+')">Risk</a>';
                                }
                                if (current_permission_array_key == '' || current_permission_array_key.split(',').includes("6")) {
                                    html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Material" onclick="btnRemove_Material('+obj.ID+', '+obj.modal+')">Delete</a>';
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
            function btnEdit_Material(id, modal, view, f, s) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Supplier_Material="+id+"&m="+modal+"&f="+f+"&s="+s,
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
            function btnRemove_Material(id, modal) {
                // $('#tableData_Material_'+modal+' tbody #tr_'+id).remove();

                swal({
                    title: "Are you sure?",
                    text: "Your item will be remove!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
					$('#tableData_Material_'+modal+' tbody #tr_'+id).remove();
                    swal("Done!", "This item has been removed. Make sure to click SAVE to save the changes.", "success");
                });
            }
			function btnList_Material(id) {
				$.ajax({    
					type: "GET",
					url: "function.php?modalList_Supplier_Material="+id,
					dataType: "html",                  
					success: function(data){
						$("#modalListMaterial .modal-body").html(data);
					}
				});
			}

            // Risk Assessment Section
            function btnEdit_Risk(id) {
                $.ajax({    
                    type: "GET",
                    url: "function.php?modalView_Risk="+id,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditRisk .modal-body").html(data);
                    }
                });
            }
            $(".modalUpdate_Risk").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Risk',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Risk'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        msg = "Sucessfully Save!";
                        $('#modalEditRisk').modal('hide');
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
                formData.append('btnSave_Supplier_Service',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Service'));
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
                    url: "function.php?modalNew_Supplier_Service="+id+"&m="+modal,
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
                formData.append('btnUpdate_Supplier_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Service'));
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
                    url: "function.php?modalView_Supplier_Service="+id+"&m="+modal,
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
			function btnTemplate_delete(id, temp, e) {
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