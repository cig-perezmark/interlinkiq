<?php 
    $title = "Food Fraud Vulnerability Assessment Library";
    $site = "ffva-library";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .dt-buttons {
        margin: unset !important;
        float: left !important;
        margin-left: 15px !important;
    }
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-doc font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">FFVA Library</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabSupplier" data-toggle="tab">Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="#tabIngredients" data-toggle="tab">Ingredients</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabSupplier">
                                            <table class="table table-bordered table-hover" id="tableData_1">
                                                <thead>
                                                    <tr>
                                                        <th>ID#</th>
                                                        <th>Supplier Name</th>

                                                        <?php
                                                            if ($FreeAccess != 1) {
                                                                echo '<th class="text-center">Attached File</th>';
                                                            }
                                                        ?>
                                                        
                                                        <th class="text-center">Vulnerability</th>
                                                        <th class="text-center">Date Performed</th>
                                                        <th class="text-center">Due Date</th>
                                                        <th style="width: 90px;" class="text-center">Status</th>
                                                        <th style="width: 85px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE deleted = 0 AND type = 1 AND updated = 0 AND user_id = $switch_user_id" );
                                                        // if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                        //     while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                        //         $supplier_user_id = htmlentities($rowSupplier["user_id"] ?? '');
                                                        //         $supplier_reviewed_by = htmlentities($rowSupplier["reviewed_by"] ?? '');
                                                        //         $supplier_approved_by = htmlentities($rowSupplier["approved_by"] ?? '');

                                                        //         $int_review_assigned_name = '';
                                                        //         $int_review_assigned = htmlentities($rowSupplier["int_review_assigned"] ?? '');
                                                        //         $int_review_status = htmlentities($rowSupplier["int_review_status"] ?? '');
                                                        //         $int_review_comment = htmlentities($rowSupplier["int_review_comment"] ?? '');

                                                        //         if (!empty($int_review_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_review_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_review_assigned_name = htmlentities($rowUser["first_name"] ?? '') .' '. htmlentities($rowUser["last_name"] ?? '');
                                                        //             }
                                                        //         }

                                                        //         $int_verify_assigned_name = '';
                                                        //         $int_verify_assigned = htmlentities($rowSupplier["int_verify_assigned"] ?? '');
                                                        //         $int_verify_status = htmlentities($rowSupplier["int_verify_status"] ?? '');
                                                        //         $int_verify_comment = htmlentities($rowSupplier["int_verify_comment"] ?? '');

                                                        //         if (!empty($int_verify_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_verify_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_verify_assigned_name = htmlentities($rowUser["first_name"] ?? '') .' '. htmlentities($rowUser["last_name"] ?? '');
                                                        //             }
                                                        //         }

                                                        //         $supplier_id = htmlentities($rowSupplier["ID"] ?? '');
                                                        //         $supplier_company = htmlentities($rowSupplier["company"] ?? '');

                                                        //         // $data_status = $rowSupplier['status'];
                                                        //         // $status = "Pending";
                                                        //         // if ($data_status == 1) { $status = "Completed"; }

                                                        //         $status = "Pending";
                                                        //         if (!empty($rowSupplier['approved_date'])) { $status = "Completed"; }

                                                        //         $data_last_modified = $rowSupplier['last_modified'];
                                                        //         $data_last_modified = new DateTime($data_last_modified);
                                                        //         $data_last_modified = $data_last_modified->format('M d, Y');
                                                                                                        
                                                        //         $due_date = date('Y-m-d', strtotime('+1 year', strtotime($data_last_modified)) );
                                                        //         $due_date = new DateTime($due_date);
                                                        //         $due_date = $due_date->format('M d, Y');


                                                        //         $likelihood_rate = $rowSupplier["likelihood_rate"];
                                                        //         $likelihood_rate_arr = explode(', ', $likelihood_rate);

                                                        //         $consequence_rate = $rowSupplier["consequence_rate"];
                                                        //         $consequence_rate_arr = explode(', ', $consequence_rate);


                                                        //         // Likelihood
                                                        //         $index = 0;
                                                        //         $count = 0;
                                                        //         $sum = 0;
                                                        //         $total_likelihood = 0;
                                                        //         $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
                                                        //         if ( mysqli_num_rows($selectLikelihood) > 0 ) {
                                                        //             while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
                                                        //                 $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
                                                        //                 if (in_array($rowSupplier["type"], $likelihood_type_arr)) {
                                                        //                     if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                        //                     else { $sum += $likelihood_rate_arr[$index]; }
                                                                            
                                                        //                     $index++;
                                                        //                     $count++;
                                                        //                 }
                                                        //             }
                                                        //         }

                                                        //         if (!empty($rowSupplier["likelihood_element_other"])) {
                                                        //             $likelihood_element_other = explode(' | ', $rowSupplier["likelihood_element_other"]);
                                                        //             $likelihood_rate_other = explode(', ', $rowSupplier["likelihood_rate_other"]);

                                                        //             $index = 0;
                                                        //             foreach ($likelihood_element_other as $value) {
                                                        //                 $sum += $likelihood_rate_other[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         $total_likelihood = $sum / $count;


                                                        //         // Consequence
                                                        //         $index = 0;
                                                        //         $count = 0;
                                                        //         $sum = 0;
                                                        //         $total_consequence = 0;
                                                        //         $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
                                                        //         if ( mysqli_num_rows($selectConsequence) > 0 ) {
                                                        //             while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                                                        //                 $sum += $consequence_rate_arr[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         if (!empty($rowSupplier["consequence_element_other"])) {
                                                        //             $consequence_element_other = explode(' | ', $rowSupplier["consequence_element_other"]);
                                                        //             $consequence_rate_other = explode(', ', $rowSupplier["consequence_rate_other"]);

                                                        //             $index = 0;
                                                        //             foreach ($consequence_element_other as $value) {
                                                        //                 $sum += $consequence_rate_other[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         $total_consequence = $sum / $count;


                                                        //         // Matrix
                                                        //         $plot_x = 1;
                                                        //         $plot_y = 1;

                                                        //         if (round($total_likelihood) > 0) { $plot_x = round($total_likelihood); }
                                                        //         if (round($total_consequence) > 0) { $plot_y = round($total_consequence); }

                                                        //         if ($plot_x == 1 && $plot_y == 1) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 2) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 3) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 4) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 1 && $plot_y == 5) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 1) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 2 && $plot_y == 2) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 2 && $plot_y == 3) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 4) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 3 && $plot_y == 1) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 2) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 3) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 3 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 1) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 4 && $plot_y == 2) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 4 && $plot_y == 3) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 1) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 2) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 3) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else { $vulnerability = 0; }

                                                        //         if ($vulnerability == 1) { $vulnerability_result = "Low Risk"; }
                                                        //         else if ($vulnerability == 2) { $vulnerability_result = "Medium Risk"; }
                                                        //         else if ($vulnerability == 3) { $vulnerability_result = "High Risk"; }
                                                        //         else { $vulnerability_result = ""; }
                                                                
                                                        //         $file_files = $rowSupplier["files"];
                                                        //         if(!empty($file_files)) {
                                                        //             $fileExtension = fileExtension($file_files);
                                                        //             $src = $fileExtension['src'];
                                                        //             $embed = $fileExtension['embed'];
                                                        //             $type = $fileExtension['type'];
                                                        //             $file_extension = $fileExtension['file_extension'];
                                                        //             $url = $base_url.'uploads/ffva/';
                                                        //         }

                                                        //         echo '<tr id="tr_'.$supplier_id.'">
                                                        //             <td>'.$supplier_id.'</td>
                                                        //             <td>'.$supplier_company.'</td>';

                                                        //             if ($FreeAccess != 1) {
                                                        //                 echo '<td class="text-center">';
                                                        //                     if(!empty($file_files)) { echo '<a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>'; } 

                                                        //                     if ($supplier_reviewed_by == $current_userID) {
                                                        //                         echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 1)">Upload</a>';
                                                        //                     } else if ($supplier_approved_by == $current_userID) {
                                                        //                         echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 2)">Upload</a>';
                                                        //                     }
                                                        //                 echo '</td>';
                                                        //             }

                                                        //             echo '<td class="text-center">'.$vulnerability_result.'</td>
                                                        //             <td class="text-center">'.$data_last_modified.'</td>
                                                        //             <td class="text-center">'.$due_date.'</td>
                                                        //             <td class="text-center">'.$status.'</td>
                                                        //             <td class="text-center">
                                                        //                 <div class="btn-group btn-group-circle">
                                                        //                     <a href="pdf_ffva?id='.$supplier_id.'&signed=0" class="btn btn-outline dark btn-sm" target="_blank">PDF</a>
                                                        //                     <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnRevert('.$supplier_id.', 1)">Revert</a>
                                                        //                 </div>
                                                        //             </td>
                                                        //         </tr>';
                                                        //     }
                                                        // }
                                                        
                                                        $sql_custom = " AND f.user_id = $switch_user_id ";
                                                        if ($switch_user_id == 1 OR $switch_user_id == 34 OR $switch_user_id == 464 OR $switch_user_id == 163) {
                                                            $sql_custom = '';
                                                        }
                                                        $resultSupplier = mysqli_query( $conn,"
                                                            SELECT
                                                            *
                                                            FROM (
                                                                SELECT
                                                                f.ID AS f_ID,
                                                                f.type AS f_type,
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
                                                                f.last_modified AS f_date_start,
                                                                f.last_modified + INTERVAL 1 YEAR AS f_date_end,
                                                                f.likelihood_rate AS f_likelihood_rate,
                                                                f.likelihood_element_other AS f_likelihood_element_other,
                                                                f.likelihood_rate_other AS f_likelihood_rate_other,
                                                                f.consequence_rate AS f_consequence_rate,
                                                                f.consequence_element_other AS f_consequence_element_other,
                                                                f.consequence_rate_other AS f_consequence_rate_other
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
                                                                AND LENGTH(f.int_review_assigned) > 0 
                                                                AND f.int_review_status = 1 
                                                                AND LENGTH(f.int_review_status) > 0
                                                                AND f.int_verify_status = 1 
                                                                
                                                                $sql_custom
                                                            ) r

                                                            WHERE f_status = 'Approved by CIG'
                                                            OR f_status = 'Approved by Client'
                                                        " );
                                                        if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                            while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                                $f_ID = $rowSupplier["f_ID"];
                                                                $f_company = htmlentities($rowSupplier["f_company"] ?? '');
                                                                $f_status = htmlentities($rowSupplier["f_status"] ?? '');

                                                                $f_files = $rowSupplier["f_files"];
                                                                if(!empty($file_files)) {
                                                                    $fileExtension = fileExtension($f_files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/ffva/';

                                                                    $f_files = '<a data-src="'.$src.$url.rawurlencode($f_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>';
                                                                }

                                                                $f_date_start = $rowSupplier['f_date_start'];
                                                                $f_date_start = new DateTime($f_date_start);
                                                                $f_date_start = $f_date_start->format('M d, Y');
                                                                                                        
                                                                $f_date_end = date('Y-m-d', strtotime('+1 year', strtotime($f_date_start)) );
                                                                $f_date_end = new DateTime($f_date_end);
                                                                $f_date_end = $f_date_end->format('M d, Y');

                                                                $likelihood_rate = $rowSupplier["f_likelihood_rate"];
                                                                $likelihood_rate_arr = explode(', ', $likelihood_rate);

                                                                $consequence_rate = $rowSupplier["f_consequence_rate"];
                                                                $consequence_rate_arr = explode(', ', $consequence_rate);

                                                                // Likelihood
                                                                $index = 0;
                                                                $count = 0;
                                                                $sum = 0;
                                                                $total_likelihood = 0;
                                                                $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
                                                                if ( mysqli_num_rows($selectLikelihood) > 0 ) {
                                                                    while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
                                                                        $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
                                                                        if (in_array($rowSupplier["f_type"], $likelihood_type_arr)) {
                                                                            if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                                            else { $sum += $likelihood_rate_arr[$index]; }
                                                                            
                                                                            $index++;
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["f_likelihood_element_other"])) {
                                                                    $likelihood_element_other = explode(' | ', $rowSupplier["f_likelihood_element_other"]);
                                                                    $likelihood_rate_other = explode(', ', $rowSupplier["f_likelihood_rate_other"]);

                                                                    $index = 0;
                                                                    foreach ($likelihood_element_other as $value) {
                                                                        $sum += $likelihood_rate_other[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                $total_likelihood = $sum / $count;

                                                                // Consequence
                                                                $index = 0;
                                                                $count = 0;
                                                                $sum = 0;
                                                                $total_consequence = 0;
                                                                $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
                                                                if ( mysqli_num_rows($selectConsequence) > 0 ) {
                                                                    while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                                                                        $sum += $consequence_rate_arr[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["f_consequence_element_other"])) {
                                                                    $consequence_element_other = explode(' | ', $rowSupplier["f_consequence_element_other"]);
                                                                    $consequence_rate_other = explode(', ', $rowSupplier["f_consequence_rate_other"]);

                                                                    $index = 0;
                                                                    foreach ($consequence_element_other as $value) {
                                                                        $sum += $consequence_rate_other[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                $total_consequence = $sum / $count;

                                                                // Matrix
                                                                $plot_x = 1;
                                                                $plot_y = 1;

                                                                if (round($total_likelihood) > 0) { $plot_x = round($total_likelihood); }
                                                                if (round($total_consequence) > 0) { $plot_y = round($total_consequence); }

                                                                if ($plot_x == 1 && $plot_y == 1) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 2) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 3) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 4) { $vulnerability = 2; }
                                                                else if ($plot_x == 1 && $plot_y == 5) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 1) { $vulnerability = 1; }
                                                                else if ($plot_x == 2 && $plot_y == 2) { $vulnerability = 1; }
                                                                else if ($plot_x == 2 && $plot_y == 3) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 4) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 3 && $plot_y == 1) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 2) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 3) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 3 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 1) { $vulnerability = 2; }
                                                                else if ($plot_x == 4 && $plot_y == 2) { $vulnerability = 2; }
                                                                else if ($plot_x == 4 && $plot_y == 3) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 1) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 2) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 3) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 5) { $vulnerability = 3; }
                                                                else { $vulnerability = 0; }

                                                                if ($vulnerability == 1) { $vulnerability_result = "Low Risk"; }
                                                                else if ($vulnerability == 2) { $vulnerability_result = "Medium Risk"; }
                                                                else if ($vulnerability == 3) { $vulnerability_result = "High Risk"; }
                                                                else { $vulnerability_result = ""; }
                                                    
                                                                echo '<tr id="tr_'.$f_ID.'">
                                                                    <td>'.$f_ID.'</td>
                                                                    <td>'.$f_company.'</td>';

                                                                    if ($FreeAccess != 1) {
                                                                        echo '<td class="text-center">';
                                                                            if(!empty($f_files)) { echo $f_files; } 

                                                                            if ($rowSupplier["f_reviewed_by"] == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$f_ID.', 1)">Upload</a>';
                                                                            } else if ($rowSupplier["f_approved_by"] == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$f_ID.', 2)">Upload</a>';
                                                                            }
                                                                        echo '</td>';
                                                                    }

                                                                    echo '<td class="text-center">'.$vulnerability_result.'</td>
                                                                    <td class="text-center">'.$f_date_start.'</td>
                                                                    <td class="text-center">'.$f_date_end.'</td>
                                                                    <td class="text-center">'.$f_status.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="pdf_ffva?id='.$f_ID.'&signed=0" class="btn btn-outline dark btn-sm" target="_blank">PDF</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnRevert('.$f_ID.', 1)">Revert</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabIngredients">
                                            <table class="table table-bordered table-hover" id="tableData_2">
                                                <thead>
                                                    <tr>
                                                        <th>ID#</th>
                                                        <th>Ingredients Name</th>

                                                        <?php
                                                            if ($FreeAccess != 1) {
                                                                echo '<th class="text-center">Attached File</th>';
                                                            }
                                                        ?>

                                                        <th class="text-center">Vulnerability</th>
                                                        <th class="text-center">Date Performed</th>
                                                        <th class="text-center">Due Date</th>
                                                        <th style="width: 90px;" class="text-center">Status</th>
                                                        <th style="width: 85px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE deleted = 0 AND type = 2 AND updated = 0 AND user_id = $switch_user_id" );
                                                        // if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                        //     while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                        //         $supplier_user_id = htmlentities($rowSupplier["user_id"] ?? '');
                                                        //         $supplier_reviewed_by = htmlentities($rowSupplier["reviewed_by"] ?? '');
                                                        //         $supplier_approved_by = htmlentities($rowSupplier["approved_by"] ?? '');

                                                        //         $int_review_assigned_name = '';
                                                        //         $int_review_assigned = htmlentities($rowSupplier["int_review_assigned"] ?? '');
                                                        //         $int_review_status = htmlentities($rowSupplier["int_review_status"] ?? '');
                                                        //         $int_review_comment = htmlentities($rowSupplier["int_review_comment"] ?? '');

                                                        //         if (!empty($int_review_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_review_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_review_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                        //             }
                                                        //         }

                                                        //         $int_verify_assigned_name = '';
                                                        //         $int_verify_assigned = htmlentities($rowSupplier["int_verify_assigned"] ?? '');
                                                        //         $int_verify_status = htmlentities($rowSupplier["int_verify_status"] ?? '');
                                                        //         $int_verify_comment = htmlentities($rowSupplier["int_verify_comment"] ?? '');

                                                        //         if (!empty($int_verify_assigned)) {
                                                        //             $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_verify_assigned" );
                                                        //             if ( mysqli_num_rows($selectUser) > 0 ) {
                                                        //                 $rowUser = mysqli_fetch_array($selectUser);
                                                        //                 $int_verify_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                        //             }
                                                        //         }

                                                        //         $supplier_id = htmlentities($rowSupplier["ID"] ?? '');
                                                        //         $supplier_company = htmlentities($rowSupplier["company"] ?? '');
                                                        //         $supplier_product = htmlentities($rowSupplier["product"] ?? '');

                                                        //         // $data_status = $rowSupplier['status'];
                                                        //         // $status = "Pending";
                                                        //         // if ($data_status == 1) { $status = "Completed"; }

                                                        //         $status = "Pending";
                                                        //         if (!empty($rowSupplier['approved_date'])) { $status = "Completed"; }

                                                        //         $data_last_modified = $rowSupplier['last_modified'];
                                                        //         $data_last_modified = new DateTime($data_last_modified);
                                                        //         $data_last_modified = $data_last_modified->format('M d, Y');
                                                                                                        
                                                        //         $due_date = date('Y-m-d', strtotime('+1 year', strtotime($data_last_modified)) );
                                                        //         $due_date = new DateTime($due_date);
                                                        //         $due_date = $due_date->format('M d, Y');


                                                        //         $likelihood_rate = $rowSupplier["likelihood_rate"];
                                                        //         $likelihood_rate_arr = explode(', ', $likelihood_rate);

                                                        //         $consequence_rate = $rowSupplier["consequence_rate"];
                                                        //         $consequence_rate_arr = explode(', ', $consequence_rate);


                                                        //         // Likelihood
                                                        //         $index = 0;
                                                        //         $count = 0;
                                                        //         $sum = 0;
                                                        //         $total_likelihood = 0;
                                                        //         $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
                                                        //         if ( mysqli_num_rows($selectLikelihood) > 0 ) {
                                                        //             while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
                                                        //                 $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
                                                        //                 if (in_array($rowSupplier["type"], $likelihood_type_arr)) {
                                                        //                     if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                        //                     else { $sum += $likelihood_rate_arr[$index]; }

                                                        //                     $index++;
                                                        //                     $count++;
                                                        //                 }
                                                        //             }
                                                        //         }

                                                        //         if (!empty($rowSupplier["likelihood_element_other"])) {
                                                        //             $likelihood_element_other = explode(' | ', $rowSupplier["likelihood_element_other"]);
                                                        //             $likelihood_rate_other = explode(', ', $rowSupplier["likelihood_rate_other"]);

                                                        //             $index = 0;
                                                        //             foreach ($likelihood_element_other as $value) {
                                                        //                 $sum += $likelihood_rate_other[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         $total_likelihood = $sum / $count;


                                                        //         // Consequence
                                                        //         $index = 0;
                                                        //         $count = 0;
                                                        //         $sum = 0;
                                                        //         $total_consequence = 0;
                                                        //         $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
                                                        //         if ( mysqli_num_rows($selectConsequence) > 0 ) {
                                                        //             while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                                                        //                 $sum += $consequence_rate_arr[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         if (!empty($rowSupplier["consequence_element_other"])) {
                                                        //             $consequence_element_other = explode(' | ', $rowSupplier["consequence_element_other"]);
                                                        //             $consequence_rate_other = explode(', ', $rowSupplier["consequence_rate_other"]);

                                                        //             $index = 0;
                                                        //             foreach ($consequence_element_other as $value) {
                                                        //                 $sum += $consequence_rate_other[$index];
                                                        //                 $index++;
                                                        //                 $count++;
                                                        //             }
                                                        //         }

                                                        //         $total_consequence = $sum / $count;


                                                        //         // Matrix
                                                        //         $plot_x = 1;
                                                        //         $plot_y = 1;

                                                        //         if (round($total_likelihood) > 0) { $plot_x = round($total_likelihood); }
                                                        //         if (round($total_consequence) > 0) { $plot_y = round($total_consequence); }

                                                        //         if ($plot_x == 1 && $plot_y == 1) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 2) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 3) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 1 && $plot_y == 4) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 1 && $plot_y == 5) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 1) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 2 && $plot_y == 2) { $vulnerability = 1; }
                                                        //         else if ($plot_x == 2 && $plot_y == 3) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 4) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 2 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 3 && $plot_y == 1) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 2) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 3) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 3 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 3 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 1) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 4 && $plot_y == 2) { $vulnerability = 2; }
                                                        //         else if ($plot_x == 4 && $plot_y == 3) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 4 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 1) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 2) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 3) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 4) { $vulnerability = 3; }
                                                        //         else if ($plot_x == 5 && $plot_y == 5) { $vulnerability = 3; }
                                                        //         else { $vulnerability = 0; }

                                                        //         if ($vulnerability == 1) { $vulnerability_result = "Low Risk"; }
                                                        //         else if ($vulnerability == 2) { $vulnerability_result = "Medium Risk"; }
                                                        //         else if ($vulnerability == 3) { $vulnerability_result = "High Risk"; }
                                                        //         else { $vulnerability_result = ""; }
                                                                
                                                        //         $file_files = $rowSupplier["files"];
                                                        //         if(!empty($file_files)) {
                                                        //             $fileExtension = fileExtension($file_files);
                                                        //             $src = $fileExtension['src'];
                                                        //             $embed = $fileExtension['embed'];
                                                        //             $type = $fileExtension['type'];
                                                        //             $file_extension = $fileExtension['file_extension'];
                                                        //             $url = $base_url.'uploads/ffva/';
                                                        //         }

                                                        //         echo '<tr id="tr_'.$supplier_id.'">
                                                        //             <td>'.$supplier_id.'</td>
                                                        //             <td>'.$supplier_product.'</td>';
                                                                    
                                                        //             if ($FreeAccess != 1) {
                                                        //                 echo '<td class="text-center">';
                                                        //                     if(!empty($file_files)) { echo '<a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>'; } 

                                                        //                     if ($supplier_reviewed_by == $current_userID) {
                                                        //                         echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 1)">Upload</a>';
                                                        //                     } else if ($supplier_approved_by == $current_userID) {
                                                        //                         echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 2)">Upload</a>';
                                                        //                     }
                                                        //                 echo '</td>';
                                                        //             }

                                                        //             echo '<td class="text-center">'.$vulnerability_result.'</td>
                                                        //             <td class="text-center">'.$data_last_modified.'</td>
                                                        //             <td class="text-center">'.$due_date.'</td>
                                                        //             <td class="text-center">'.$status.'</td>
                                                        //             <td class="text-center">
                                                        //                 <div class="btn-group btn-group-circle">
                                                        //                     <a href="pdf_ffva?id='.$supplier_id.'&signed=0" class="btn btn-outline dark btn-sm" target="_blank">PDF</a>
                                                        //                     <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnRevert('.$supplier_id.', 2)">Revert</a>
                                                        //                 </div>
                                                        //             </td>
                                                        //         </tr>';
                                                        //     }
                                                        // }
                                                        
                                                        $resultSupplier = mysqli_query( $conn,"
                                                            SELECT
                                                            *
                                                            FROM (
                                                                SELECT
                                                                f.ID AS f_ID,
                                                                f.type AS f_type,
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
                                                                f.last_modified AS f_date_start,
                                                                f.last_modified + INTERVAL 1 YEAR AS f_date_end,
                                                                f.likelihood_rate AS f_likelihood_rate,
                                                                f.likelihood_element_other AS f_likelihood_element_other,
                                                                f.likelihood_rate_other AS f_likelihood_rate_other,
                                                                f.consequence_rate AS f_consequence_rate,
                                                                f.consequence_element_other AS f_consequence_element_other,
                                                                f.consequence_rate_other AS f_consequence_rate_other
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
                                                                AND LENGTH(f.int_review_assigned) > 0 
                                                                AND f.int_review_status = 1 
                                                                AND LENGTH(f.int_review_status) > 0
                                                                AND f.int_verify_status = 1 
                                                                
                                                                $sql_custom
                                                            ) r

                                                            WHERE f_status = 'Approved by CIG'
                                                            OR f_status = 'Approved by Client'
                                                        " );
                                                        if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                            while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                                $f_ID = $rowSupplier["f_ID"];
                                                                $f_company = htmlentities($rowSupplier["f_company"] ?? '');
                                                                $f_product = htmlentities($rowSupplier["f_product"] ?? '');
                                                                $f_status = htmlentities($rowSupplier["f_status"] ?? '');

                                                                $f_files = $rowSupplier["f_files"];
                                                                if(!empty($file_files)) {
                                                                    $fileExtension = fileExtension($f_files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/ffva/';

                                                                    $f_files = '<a data-src="'.$src.$url.rawurlencode($f_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>';
                                                                }

                                                                $f_date_start = $rowSupplier['f_date_start'];
                                                                $f_date_start = new DateTime($f_date_start);
                                                                $f_date_start = $f_date_start->format('M d, Y');
                                                                                                        
                                                                $f_date_end = date('Y-m-d', strtotime('+1 year', strtotime($f_date_start)) );
                                                                $f_date_end = new DateTime($f_date_end);
                                                                $f_date_end = $f_date_end->format('M d, Y');

                                                                $likelihood_rate = $rowSupplier["f_likelihood_rate"];
                                                                $likelihood_rate_arr = explode(', ', $likelihood_rate);

                                                                $consequence_rate = $rowSupplier["f_consequence_rate"];
                                                                $consequence_rate_arr = explode(', ', $consequence_rate);

                                                                // Likelihood
                                                                $index = 0;
                                                                $count = 0;
                                                                $sum = 0;
                                                                $total_likelihood = 0;
                                                                $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
                                                                if ( mysqli_num_rows($selectLikelihood) > 0 ) {
                                                                    while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
                                                                        $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
                                                                        if (in_array($rowSupplier["f_type"], $likelihood_type_arr)) {
                                                                            if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                                            else { $sum += $likelihood_rate_arr[$index]; }
                                                                            
                                                                            $index++;
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["f_likelihood_element_other"])) {
                                                                    $likelihood_element_other = explode(' | ', $rowSupplier["f_likelihood_element_other"]);
                                                                    $likelihood_rate_other = explode(', ', $rowSupplier["f_likelihood_rate_other"]);

                                                                    $index = 0;
                                                                    foreach ($likelihood_element_other as $value) {
                                                                        $sum += $likelihood_rate_other[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                $total_likelihood = $sum / $count;

                                                                // Consequence
                                                                $index = 0;
                                                                $count = 0;
                                                                $sum = 0;
                                                                $total_consequence = 0;
                                                                $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
                                                                if ( mysqli_num_rows($selectConsequence) > 0 ) {
                                                                    while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                                                                        $sum += $consequence_rate_arr[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["f_consequence_element_other"])) {
                                                                    $consequence_element_other = explode(' | ', $rowSupplier["f_consequence_element_other"]);
                                                                    $consequence_rate_other = explode(', ', $rowSupplier["f_consequence_rate_other"]);

                                                                    $index = 0;
                                                                    foreach ($consequence_element_other as $value) {
                                                                        $sum += $consequence_rate_other[$index];
                                                                        $index++;
                                                                        $count++;
                                                                    }
                                                                }

                                                                $total_consequence = $sum / $count;

                                                                // Matrix
                                                                $plot_x = 1;
                                                                $plot_y = 1;

                                                                if (round($total_likelihood) > 0) { $plot_x = round($total_likelihood); }
                                                                if (round($total_consequence) > 0) { $plot_y = round($total_consequence); }

                                                                if ($plot_x == 1 && $plot_y == 1) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 2) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 3) { $vulnerability = 1; }
                                                                else if ($plot_x == 1 && $plot_y == 4) { $vulnerability = 2; }
                                                                else if ($plot_x == 1 && $plot_y == 5) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 1) { $vulnerability = 1; }
                                                                else if ($plot_x == 2 && $plot_y == 2) { $vulnerability = 1; }
                                                                else if ($plot_x == 2 && $plot_y == 3) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 4) { $vulnerability = 2; }
                                                                else if ($plot_x == 2 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 3 && $plot_y == 1) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 2) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 3) { $vulnerability = 2; }
                                                                else if ($plot_x == 3 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 3 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 1) { $vulnerability = 2; }
                                                                else if ($plot_x == 4 && $plot_y == 2) { $vulnerability = 2; }
                                                                else if ($plot_x == 4 && $plot_y == 3) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 4 && $plot_y == 5) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 1) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 2) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 3) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 4) { $vulnerability = 3; }
                                                                else if ($plot_x == 5 && $plot_y == 5) { $vulnerability = 3; }
                                                                else { $vulnerability = 0; }

                                                                if ($vulnerability == 1) { $vulnerability_result = "Low Risk"; }
                                                                else if ($vulnerability == 2) { $vulnerability_result = "Medium Risk"; }
                                                                else if ($vulnerability == 3) { $vulnerability_result = "High Risk"; }
                                                                else { $vulnerability_result = ""; }
                                                    
                                                                echo '<tr id="tr_'.$f_ID.'">
                                                                    <td>'.$f_ID.'</td>
                                                                    <td>'.$f_product.'</td>';

                                                                    if ($FreeAccess != 1) {
                                                                        echo '<td class="text-center">';
                                                                            if(!empty($f_files)) { echo $f_files; } 

                                                                            if ($rowSupplier["f_reviewed_by"] == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$f_ID.', 1)">Upload</a>';
                                                                            } else if ($rowSupplier["f_approved_by"] == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$f_ID.', 2)">Upload</a>';
                                                                            }
                                                                        echo '</td>';
                                                                    }

                                                                    echo '<td class="text-center">'.$vulnerability_result.'</td>
                                                                    <td class="text-center">'.$f_date_start.'</td>
                                                                    <td class="text-center">'.$f_date_end.'</td>
                                                                    <td class="text-center">'.$f_status.'</td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group btn-group-circle">
                                                                            <a href="pdf_ffva?id='.$f_ID.'&signed=0" class="btn btn-outline dark btn-sm" target="_blank">PDF</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnRevert('.$f_ID.', 1)">Revert</a>
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
                            </div>
                        </div>
                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <!--[if lt IE 9]>
        <script type="text/javascript" src="assets/jSignature/flashcanvas.js"></script>
        <![endif]-->
        <script src="assets/jSignature/jSignature.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#tableData_1, #tableData_2').dataTable( {
                  "columnDefs": [
                    { "width": "auto", "targets": 0 }
                  ]
                } );
            } );

            function btnRevert(id, table) {
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
                        url: "function.php?btnRevert_FFVA="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_'+table+' tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been reverted.", "success");
                });
            }
        </script>
    </body>
</html>