<?php ?>

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
</style>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">List of Subscriber</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="#modalNew" data-toggle="modal" onclick="btnReset('modalNew')">Add New Customer</a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a data-toggle="modal" href="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                            </li>
                            <li>
                                <a href="#modalReport" data-toggle="modal" onclick="btnReport(2)">Report</a>
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
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_sent">
                        <table class="table table-bordered table-hover" id="tableData_1">
                            <thead>
                                <tr>
                                    <th rowspan="2">Account Name</th>
                                    <th rowspan="2">Category</th>
                                    <th rowspan="2">Products/Services</th>
                                    <th colspan="3" class="text-center">Contact Details</th>
                                    <th rowspan="2" style="width: 155px;" class="text-center hide">Annual Review Due</th>
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
                                    $result = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count) AS
                                        (
                                            SELECT
                                            s1.ID AS s_ID,
                                            s1.name AS s_name,
                                            s1.reviewed_due AS s_reviewed_due,
                                            s1.status AS s_status,
                                            s1.material AS s_material,
                                            s1.service AS s_service,
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
                                            
                                            UNION ALL
                                            
                                            SELECT
                                            s2.ID AS s_ID,
                                            s2.name AS s_name,
                                            s2.reviewed_due AS s_reviewed_due,
                                            s2.status AS s_status,
                                            s2.material AS s_material,
                                            s2.service AS s_service,
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
                                        )
                                        SELECT
                                        s_ID,
                                        s_name,
                                        s_reviewed_due,
                                        s_status,
                                        s_material,
                                        s_service, 
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
                                            $d_compliance = $row["d_compliance"];
                                            $d_counting = $row["d_counting"];
                                            if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }

                                            $s_status = $row["s_status"];
                                            $status_type = array(
                                                0 => 'Pending',
                                                1 => 'Approved',
                                                2 => 'Non Approved',
                                                3 => 'Emergency Use Only',
                                                4 => 'Do Not Use'
                                            );

                                            if ($s_category == "3") {
                                                $material = $row["s_service"];
                                                if (!empty($material)) {
                                                    $material_result = array();
                                                    $material_arr = explode(", ", $material);
                                                    foreach ($material_arr as $value) {
                                                        // $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service WHERE ID=$value" );
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
                                                        // $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material WHERE ID=$value" );
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

                                            echo '<tr id="tr_'.$s_ID.'">
                                                <td>'.$s_name.'</td>
                                                <td>'.$c_name.'</td>
                                                <td>'.$material.'</td>
                                                <td>'.$cn_name.'</td>
                                                <td>'.$cn_address.'</td>
                                                <td class="text-center">
                                                    <ul class="list-inline">';
                                                    if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                    if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                    if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                    if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                    echo '</ul>
                                                </td>
                                                <td class="text-center hide">'.$s_reviewed_due.'</td>
                                                <td class="text-center">'.intval($compliance).'%</td>
                                                <td class="text-center">'.$status_type[$s_status].'</td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-circle">
                                                        <a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('. $s_ID .')">View</a>
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
                                    <th rowspan="2">Account Name</th>
                                    <th rowspan="2">Category</th>
                                    <th rowspan="2">Products/Services</th>
                                    <th colspan="3" class="text-center">Contact Details</th>
                                    <th rowspan="2" style="width: 155px;" class="text-center hide">Annual Review Due</th>
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
                                    $result = mysqli_query( $conn,"WITH RECURSIVE cte (s_ID, s_name, s_reviewed_due, s_status, s_material, s_service, s_category, s_contact, s_document, d_ID, d_type, d_name, d_file, d_file_due, d_status, d_count) AS
                                        (
                                            SELECT
                                            s1.ID AS s_ID,
                                            s1.name AS s_name,
                                            s1.reviewed_due AS s_reviewed_due,
                                            s1.status AS s_status,
                                            s1.material AS s_material,
                                            s1.service AS s_service,
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
                                            
                                            UNION ALL
                                            
                                            SELECT
                                            s2.ID AS s_ID,
                                            s2.name AS s_name,
                                            s2.reviewed_due AS s_reviewed_due,
                                            s2.status AS s_status,
                                            s2.material AS s_material,
                                            s2.service AS s_service,
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
                                        )
                                        SELECT
                                        s_ID,
                                        s_name,
                                        s_reviewed_due,
                                        s_status,
                                        s_material,
                                        s_service, 
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
                                            $d_compliance = $row["d_compliance"];
                                            $d_counting = $row["d_counting"];
                                            if ($d_counting > 0) { $compliance = ($d_compliance / $d_counting) * 100; }

                                            $s_status = $row["s_status"];
                                            $status_type = array(
                                                0 => 'Pending',
                                                1 => 'Approved',
                                                2 => 'Non Approved',
                                                3 => 'Emergency Use Only',
                                                4 => 'Do Not Use'
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

                                            $s_name = "Enterprise Name";
                                            echo '<tr id="tr_'.$s_ID.'">
                                                <td>'.$s_name.'</td>
                                                <td>'.$c_name.'</td>
                                                <td>'.$material.'</td>
                                                <td>'.$cn_name.'</td>
                                                <td>'.$cn_address.'</td>
                                                <td class="text-center">
                                                    <ul class="list-inline">';
                                                    if ($cn_email != "") { echo '<li><a href="mailto:'.$cn_email.'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                                    if ($cn_phone != "") { echo '<li><a href="tel:'.$cn_phone.'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                                    if ($cn_cell != "") { echo '<li><a href="tel:'.$cn_cell.'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                                    if ($cn_fax != "") { echo '<li><a href="tel:'.$cn_fax.'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                                    echo '</ul>
                                                </td>
                                                <td class="text-center hide">'.$s_reviewed_due.'</td>
                                                <td class="text-center">'.intval($compliance).'%</td>
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
                                                $name = $row["name"];

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
                </div>
            </div>
        </div>
    </div>


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
                                    if ($switch_user_id == 1 OR $switch_user_id == 5) {
                                        echo '<li><a href="#tabPortal_1" data-toggle="tab">Portal</a></li>';
                                    }
                                ?>
                                <li class="hide">
                                    <a href="#tabFSVP_1" data-toggle="tab">FSVP</a>
                                </li>
                            </ul>
                            <div class="tab-content margin-top-20">
                                <div class="tab-pane active" id="tabBasic_1">
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
                                                                echo '<option value="'.$row["ID"].'">'.$row["name"].'</option>';
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
                                                                echo '<option value="'.$row["ID"].'">'.$row["name"].'</option>';
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
                                                            echo '<option value="'.$rowCountry["iso2"].'">'.$rowCountry["name"].'</option>';
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Receive Notification?</label>
                                                <select class="form-control" name="notification">
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
                                        <div class="col-md-3 <?php echo $switch_user_id == 5 ? '':'hide'; ?>">
                                            <div class="form-group">
                                                <label class="control-label">Account Type</label>
                                                <select class="form-control" name="account_type">
                                                    <option value="0">Free Access</option>
                                                    <option value="1">Demo Account</option>
                                                    <option value="2">Paid Subscriber</option>
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
                                    <a href="#modalNewContact" data-toggle="modal" class="btn green" onclick="btnNew_Contact(<?php echo $switch_user_id; ?>, 1, 'modalNewContact')">Add New Contact</a>
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover" id="tableData_Contact_1">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Title</th>
                                                    <th>Address</th>
                                                    <th class="text-center" style="width: 145px;">Contact Details</th>
                                                    <th class="text-center hide" style="width: 145px;">Emergency Person</th>
                                                    <th class="text-center" style="width: 140px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabDocuments_1">
                                    <div class="mt-checkbox-list"></div>
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
                                                    <input type="text" class="form-control daterange_audit daterange_audit_empty" name="reviewed_validity" value="" />
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
                                                            <input type="text" class="form-control daterange_audit daterange_audit_empty" name="audit_report_validity" value="" />
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
                                <?php if ($switch_user_id == 1 OR $switch_user_id == 5) { ?>
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
                                                                    $dept_title = $rowDepartment["title"];

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
                                                                    $emp_name = $rowEmployee["first_name"] .' '. $rowEmployee["last_name"];
                                                                    $emp_email = $rowEmployee["email"];

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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
</div>
