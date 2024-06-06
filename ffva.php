<?php 

    $title = "Food Fraud Vulnerability Assessment";

    $site = "ffva";

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



    #tabAssigned_2 table tbody > tr:first-child > td,

    #tabAssigned table tbody > tr:first-child > td,

    #modalSign table tbody > tr:first-child > td {

        width: 25%;

    }

    #tabAssigned_2 table tbody > tr:first-child > td:first-child,

    #tabAssigned table tbody > tr:first-child > td:first-child,

    #modalSign table tbody > tr:first-child > td:first-child {

        vertical-align: middle;

    }

    #tabAssigned table tbody > tr:first-child > td:nth-child(n+2),

    #tabAssigned_2 table tbody > tr:first-child > td:nth-child(n+2),

    #modalSign table tbody > tr:first-child > td:nth-child(n+2) {

        vertical-align: bottom;

    }



    .signature,

    .signature_img {

        width: 300px;

        height: 150px;

        border: 1px solid #ccc;

        margin: auto;

        margin-bottom: 15px;

    }



    .dt-buttons {

        margin: unset !important;

        float: left !important;

        margin-left: 15px !important;

    }

    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {

        position: relative;

    }



    table.table-bordered.dataTable thead > tr:last-child th:last-child {

        border-right: 1px solid #e7ecf1;

    }

</style>



                    <div class="row">

                        <div class="col-md-12">

                            <div class="portlet light ">

                                <div class="portlet-title tabbable-line">

                                    <div class="caption">

                                        <i class="icon-doc font-dark"></i>

                                        <span class="caption-subject font-dark bold uppercase">FFVA Module</span>

                                        <?php
                                            if($current_client == 0) {
                                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $type_id = $row["type"];                                    $file_actitle = $row["file_title"];
                                                    $video_url = $row["youtube_link"];
                                                    
                                                    $file_upload = $row["file_upload"];
                                                    if (!empty($file_upload)) {
                                        	            $fileExtension = fileExtension($file_upload);
                                        				$src = $fileExtension['src'];
                                        				$embed = $fileExtension['embed'];
                                        				$type = $fileExtension['type'];
                                        				$file_extension = $fileExtension['file_extension'];
                                        	            $url = $base_url.'uploads/instruction/';
                                        
                                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                                    }
                                                    
                                                    $icon = $row["icon"];
                                                    if (!empty($icon)) { echo '<img src="'.$src.$url.rawurlencode($icon).'" style="width: 32px; height: 32px; object-fit: contain; object-position: center;" />'; }
                                                    if ($type_id == 0) {
                                                        echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'">'.$file_title.'</a>';
                                                    } else {
                                                        echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox>'.$file_title.'</a>';
                                                    }
                                                }
                                                
                                                if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                                    echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                                                }
                                            }
                                        ?>

                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tabSupplier" data-toggle="tab">Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="#tabIngredients" data-toggle="tab">Ingredients</a>
                                        </li>

                                        <?php if($FreeAccess == false): ?>
                                            <li>
                                                <a href="#tabReferences" data-toggle="tab">References</a>
                                            </li>
                                        <?php endif ?>

                                        <li>
                                            <a href="#tabKatva" data-toggle="tab">Key Activity Types</a>
                                        </li>
                                        <li>
                                            <a href="/e-forms/Forms/ffva/home?user_id=<?=$switch_user_id?>" target="_blank">Report</a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="portlet-body">

                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tabSupplier">

                                            <?php
                                                if ($current_userID == 481 || $current_userEmployeeID == 0 || isset($_COOKIE['switchAccount'])) { 
                                                    echo '<div class="btn-group btn-group-circle pull-right margin-bottom-15">
                                                        <a href="'; echo $FreeAccess == false ? '#modalNew':'#modalService';  echo '" class="btn btn-success" data-toggle="modal" onclick="btnNew(1)">Add New FFVA - Supplier</a>
                                                        <a href="'; echo $FreeAccess == false ? '#modalHistory':'#modalService';  echo '" class="btn btn-outline dark" data-toggle="modal" onclick="btnHistory(1)">History</a>
                                                        <a href="'; echo $FreeAccess == false ? '#modalArchived':'#modalService';  echo '" class="btn btn-danger" data-toggle="modal" onclick="btnArchived(1)">Archive</a>
                                                    </div>';
                                                }
                                            ?>

                                            <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                <a data-toggle="modal" data-target="#modal_video">Add Video</a>
                                            <?php endif; ?>

                                            <table class="table table-bordered table-hover" id="tableData_1">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">ID#</th>
                                                        <th rowspan="2">Supplier Name</th>

                                                        <?php
                                                            if ($current_userEmployerID == 34 OR $current_userEmployerID == 1) {
                                                                echo '<th rowspan="2" class="text-center">Int. Reviewer</th>
                                                                <th rowspan="2" class="text-center">Int. Verifier</th>';
                                                            }

                                                            if ($FreeAccess != 1) {
                                                                echo '<th rowspan="2" class="text-center">Attached File</th>';
                                                            }
                                                        ?>

                                                        <th rowspan="2" class="text-center">Vulnerability</th>
                                                        <th colspan="2" class="text-center">Validity</th>
                                                        <th rowspan="2" style="width: 90px;" class="text-center">Status</th>
                                                        <th rowspan="2" style="width: 210px;"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">From</th>
                                                        <th class="text-center">To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                        // $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE type = 1 AND updated = 0 AND user_id = $switch_user_id" );
                                                        $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE archived = 0 AND deleted = 0 AND type = 1 AND updated = 0 AND user_id = $switch_user_id" );
                                                        if ( mysqli_num_rows($resultSupplier) > 0 ) {

                                                            while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                                $supplier_user_id = $rowSupplier["user_id"];
                                                                $supplier_reviewed_by = $rowSupplier["reviewed_by"];
                                                                $supplier_approved_by = $rowSupplier["approved_by"];
                                                                $int_review_assigned_name = '';
                                                                $int_review_assigned = $rowSupplier["int_review_assigned"];
                                                                $int_review_status = $rowSupplier["int_review_status"];
                                                                $int_review_comment = $rowSupplier["int_review_comment"];

                                                                if (!empty($int_review_assigned)) {
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_review_assigned" );

                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);
                                                                        $int_review_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                    }
                                                                }

                                                                $int_verify_assigned_name = '';
                                                                $int_verify_assigned = $rowSupplier["int_verify_assigned"];
                                                                $int_verify_status = $rowSupplier["int_verify_status"];
                                                                $int_verify_comment = $rowSupplier["int_verify_comment"];

                                                                if (!empty($int_verify_assigned)) {
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_verify_assigned" );

                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);
                                                                        $int_verify_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                    }
                                                                }

                                                                $supplier_id = $rowSupplier["ID"];
                                                                $supplier_company = $rowSupplier["company"];

                                                                $status = "Drafted";
                                                                // if (empty($int_review_assigned)) { $status = 'Drafted'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1) { $status = 'Reviewed'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1 AND !empty($int_verify_assigned) AND $int_verify_status == 1) { $status = 'Approved by CIG'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1 AND !empty($int_verify_assigned) AND $int_verify_status == 1 AND !empty($rowSupplier['approved_date'])) { $status = "Approved by Client"; }

                                                                $data_last_modified = $rowSupplier['last_modified'];
                                                                $data_last_modified = new DateTime($data_last_modified);
                                                                $data_last_modified = $data_last_modified->format('M d, Y');
                                                                $due_date = date('Y-m-d', strtotime('+1 year', strtotime($data_last_modified)) );
                                                                $due_date = new DateTime($due_date);
                                                                $due_date = $due_date->format('M d, Y');
                                                                $likelihood_rate = $rowSupplier["likelihood_rate"];
                                                                $likelihood_rate_arr = explode(', ', $likelihood_rate);
                                                                $consequence_rate = $rowSupplier["consequence_rate"];
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

                                                                        if (in_array($rowSupplier["type"], $likelihood_type_arr)) {
                                                                            if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                                            else { $sum += $likelihood_rate_arr[$index]; }
                                                                           
                                                                            $index++;
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["likelihood_element_other"])) {
                                                                    $likelihood_element_other = explode(' | ', $rowSupplier["likelihood_element_other"]);
                                                                    $likelihood_rate_other = explode(', ', $rowSupplier["likelihood_rate_other"]);
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

                                                                if (!empty($rowSupplier["consequence_element_other"])) {
                                                                    $consequence_element_other = explode(' | ', $rowSupplier["consequence_element_other"]);
                                                                    $consequence_rate_other = explode(', ', $rowSupplier["consequence_rate_other"]);
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

                                                                if ($vulnerability == 1) { $vulnerability_result = '<span class="font-green-jungle bold">Low Risk</span>'; }
                                                                else if ($vulnerability == 2) { $vulnerability_result = '<span class="font-yellow-gold bold">Medium Risk</span>'; }
                                                                else if ($vulnerability == 3) { $vulnerability_result = '<span class="font-red-thunderbird bold">High Risk</span>'; }
                                                                else { $vulnerability_result = ""; }
                                                                
                                                                $file_files = $rowSupplier["files"];

                                                                if(!empty($file_files)) {
                                                                    $fileExtension = fileExtension($file_files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/ffva/';
                                                                }

                                                                echo '<tr id="tr_'.$supplier_id.'">
                                                                    <td>'.$supplier_id.'</td>
                                                                    <td>'.htmlentities($supplier_company).'</td>';

                                                                    if ($current_userEmployerID == 34 OR $current_userEmployerID == 1) {
                                                                        echo '<td class="text-center int_review_status">';
                                                                            if (!empty($int_review_assigned_name)) {  echo $int_review_assigned_name .'<br>'; }
                                                                            echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 1, 1)">View</a>';

                                                                            if($int_review_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($int_review_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.htmlentities($int_review_comment).'</i></small>'; }
                                                                        echo '</td>
                                                                        <td class="text-center int_verify_status">';
                                                                            if (!empty($int_verify_assigned_name)) {  echo $int_verify_assigned_name .'<br>'; }
                                                                            // if ($current_userEmployeeID == 0) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 2, 1)">View</a>'; }
                                                                            if ($int_review_status == 1) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 2, 1)">View</a>'; }
                                                                            
                                                                            if($int_verify_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }
                                                                            else if ($int_verify_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.htmlentities($int_verify_comment).'</i></small>'; }
                                                                        echo '</td>';
                                                                    }
                                                                    
                                                                    if ($FreeAccess != 1) {
                                                                        echo '<td class="text-center">';
                                                                            if(!empty($file_files)) { echo '<a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>'; } 

                                                                            if ($supplier_reviewed_by == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 1)">Upload</a>';
                                                                            } else if ($supplier_approved_by == $current_userID) {
                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 2)">Upload</a>';
                                                                            }
                                                                        echo '</td>';
                                                                    }

                                                                    echo '<td class="text-center">'.$vulnerability_result.'</td>
                                                                    <td class="text-center">'.$data_last_modified.'</td>
                                                                    <td class="text-center">'.$due_date.'</td>
                                                                    <td class="text-center">'.$status.'</td>
                                                                    <td class="text-center">';
                                                                        if (isset($_COOKIE['switchAccount']) || $current_userEmployeeID == 0 || $current_userID == 481) {
                                                                            echo '<div class="btn-group btn-group-circle">
                                                                                <a href="pdf_ffva?id='.$supplier_id.'&signed=1" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>
                                                                                <a href="pdf_ffva_excel?id='.$supplier_id.'&signed=1" class="btn green-jungle btn-sm" target="_blank" title="Excel"><i class="fa fa-fw fa-file-excel-o"></i></a>
                                                                                <a href="#modalView" class="btn dark btn-sm hide" data-toggle="modal" onclick="btnView('.$supplier_id.')" title="View"><i class="fa fa-fw fa-search"></i></a>
                                                                                <a href="#modalEdit" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnEdit('.$supplier_id.')" title="Edit"><i class="fa fa-fw fa-pencil"></i></a>
                                                                                <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnDelete('.$supplier_id.', 1)" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                                                <a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="btnArchive('.$supplier_id.', 1)" title="Archive"><i class="fa fa-fw fa-file-archive-o"></i></a>';

                                                                                if ($supplier_reviewed_by == $current_userID) {
                                                                                    echo '<a href="#modalSign" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnSign('.$supplier_id.', 1)"><i class="fa fa-fw fa-edit"></i></a>';
                                                                                } else if ($supplier_approved_by == $current_userID) {
                                                                                    echo '<a href="#modalSign" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnSign('.$supplier_id.', 2)"><i class="fa fa-fw fa-edit"></i></a>';
                                                                                }

                                                                            echo '</div>';
                                                                        } else {
                                                                            echo '<a href="pdf_ffva?id='.$supplier_id.'" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>';
                                                                        }
                                                                    echo '</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabIngredients">
                                            <?php
                                                if ($current_userID == 481 || $current_userEmployeeID == 0 || isset($_COOKIE['switchAccount'])) { 
                                                    echo '<div class="btn-group btn-group-circle pull-right margin-bottom-15">
                                                        <a href="'; echo $FreeAccess == false ? '#modalNew':'#modalService';  echo '" class="btn btn-success" data-toggle="modal" onclick="btnNew(2)">Add New FFVA - Ingredient</a>
                                                        <a href="'; echo $FreeAccess == false ? '#modalHistory':'#modalService';  echo '" class="btn btn-outline dark" data-toggle="modal" onclick="btnHistory(2)">History</a>
                                                        <a href="'; echo $FreeAccess == false ? '#modalArchived':'#modalService';  echo '" class="btn btn-danger" data-toggle="modal" onclick="btnArchived(2)">Archive</a>
                                                    </div>';
                                                }
                                            ?>
                                            <table class="table table-bordered table-hover" id="tableData_2">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">ID#</th>
                                                        <th rowspan="2">Ingredients Name</th>

                                                        <?php
                                                            if ($current_userEmployerID == 34 OR $current_userEmployerID == 1) {
                                                                echo '<th rowspan="2" class="text-center">Int. Reviewer</th>
                                                                <th rowspan="2" class="text-center">Int. Verifier</th>';
                                                            }

                                                            if ($FreeAccess != 1) {
                                                                echo '<th rowspan="2" class="text-center">Attached File</th>';
                                                            }
                                                        ?>
                                                        
                                                        <th rowspan="2" class="text-center">Vulnerability</th>
                                                        <th colspan="2" class="text-center">Validity</th>
                                                        <th rowspan="2" style="width: 90px;" class="text-center">Status</th>
                                                        <th rowspan="2" style="width: 210px;"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">From</th>
                                                        <th class="text-center">To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $resultSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE archived = 0 AND deleted = 0 AND type = 2 AND updated = 0 AND user_id = $switch_user_id" );
                                                        if ( mysqli_num_rows($resultSupplier) > 0 ) {
                                                            while($rowSupplier = mysqli_fetch_array($resultSupplier)) {
                                                                $supplier_user_id = $rowSupplier["user_id"];
                                                                $supplier_reviewed_by = $rowSupplier["reviewed_by"];
                                                                $supplier_approved_by = $rowSupplier["approved_by"];

                                                                $int_review_assigned_name = '';
                                                                $int_review_assigned = $rowSupplier["int_review_assigned"];
                                                                $int_review_status = $rowSupplier["int_review_status"];
                                                                $int_review_comment = $rowSupplier["int_review_comment"];

                                                                if (!empty($int_review_assigned)) {
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_review_assigned" );
                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);
                                                                        $int_review_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                    }
                                                                }

                                                                $int_verify_assigned_name = '';
                                                                $int_verify_assigned = $rowSupplier["int_verify_assigned"];
                                                                $int_verify_status = $rowSupplier["int_verify_status"];
                                                                $int_verify_comment = $rowSupplier["int_verify_comment"];

                                                                if (!empty($int_verify_assigned)) {
                                                                    $selectUser = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE ID = $int_verify_assigned" );
                                                                    if ( mysqli_num_rows($selectUser) > 0 ) {
                                                                        $rowUser = mysqli_fetch_array($selectUser);
                                                                        $int_verify_assigned_name = $rowUser["first_name"] .' '. $rowUser["last_name"];
                                                                    }
                                                                }
                                                                
                                                                $supplier_id = $rowSupplier["ID"];
                                                                $supplier_company = $rowSupplier["company"];
                                                                $supplier_product = $rowSupplier["product"];

                                                                $status = "Drafted";
                                                                // if (empty($int_review_assigned)) { $status = 'Drafted'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1) { $status = 'Reviewed'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1 AND !empty($int_verify_assigned) AND $int_verify_status == 1) { $status = 'Approved by CIG'; }
                                                                if (!empty($int_review_assigned) AND $int_review_status == 1 AND !empty($int_verify_assigned) AND $int_verify_status == 1 AND !empty($rowSupplier['approved_date'])) { $status = "Approved by Client"; }

                                                                $data_last_modified = $rowSupplier['last_modified'];
                                                                $data_last_modified = new DateTime($data_last_modified);
                                                                $data_last_modified = $data_last_modified->format('M d, Y');
                                                                                                        
                                                                $due_date = date('Y-m-d', strtotime('+1 year', strtotime($data_last_modified)) );
                                                                $due_date = new DateTime($due_date);
                                                                $due_date = $due_date->format('M d, Y');


                                                                $likelihood_rate = $rowSupplier["likelihood_rate"];
                                                                $likelihood_rate_arr = explode(', ', $likelihood_rate);

                                                                $consequence_rate = $rowSupplier["consequence_rate"];
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
                                                                        if (in_array($rowSupplier["type"], $likelihood_type_arr)) {
                                                                            if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                                                                            else { $sum += $likelihood_rate_arr[$index]; }
                                                                            
                                                                            $index++;
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }

                                                                if (!empty($rowSupplier["likelihood_element_other"])) {
                                                                    $likelihood_element_other = explode(' | ', $rowSupplier["likelihood_element_other"]);
                                                                    $likelihood_rate_other = explode(', ', $rowSupplier["likelihood_rate_other"]);
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



                                                                if (!empty($rowSupplier["consequence_element_other"])) {

                                                                    $consequence_element_other = explode(' | ', $rowSupplier["consequence_element_other"]);

                                                                    $consequence_rate_other = explode(', ', $rowSupplier["consequence_rate_other"]);



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



                                                                if ($vulnerability == 1) { $vulnerability_result = '<span class="font-green-jungle bold">Low Risk</span>'; }

                                                                else if ($vulnerability == 2) { $vulnerability_result = '<span class="font-yellow-gold bold">Medium Risk</span>'; }

                                                                else if ($vulnerability == 3) { $vulnerability_result = '<span class="font-red-thunderbird bold">High Risk</span>'; }

                                                                else { $vulnerability_result = ""; }

                                                                

                                                                $file_files = $rowSupplier["files"];

                                                                if(!empty($file_files)) {

                                                                    $fileExtension = fileExtension($file_files);

                                                                    $src = $fileExtension['src'];

                                                                    $embed = $fileExtension['embed'];

                                                                    $type = $fileExtension['type'];

                                                                    $file_extension = $fileExtension['file_extension'];

                                                                    $url = $base_url.'uploads/ffva/';

                                                                }



                                                                echo '<tr id="tr_'.$supplier_id.'">

                                                                    <td>'.$supplier_id.'</td>

                                                                    <td>'.htmlentities($supplier_product).'</td>';



                                                                    if ($current_userEmployerID == 34 OR $current_userEmployerID == 1) {

                                                                        echo '<td class="text-center int_review_status">';

                                                                            if (!empty($int_review_assigned_name)) {  echo $int_review_assigned_name .'<br>'; }

                                                                            echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 1, 2)">View</a>';



                                                                            if($int_review_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }

                                                                            else if ($int_review_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.htmlentities($int_review_comment).'</i></small>'; }

                                                                        echo '</td>

                                                                        <td class="text-center int_verify_status">';

                                                                            if (!empty($int_verify_assigned_name)) {  echo $int_verify_assigned_name .'<br>'; }

                                                                            // if ($current_userEmployeeID == 0) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 2, 2)">View</a>'; }

                                                                            if ($int_review_status == 1) { echo '<a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('.$supplier_id.', 2, 2)">View</a>'; }

                                                                            

                                                                            if($int_verify_status == 1) { echo '<span class="label label-sm label-success">Accepted</span>'; }

                                                                            else if ($int_verify_status == 2) { echo '<span class="label label-sm label-danger">Rejected</span><br><small>Reason: <i>'.htmlentities($int_verify_comment).'</i></small>'; }

                                                                        echo '</td>';

                                                                    }

                                                                    

                                                                    if ($FreeAccess != 1) {

                                                                        echo '<td class="text-center">';

                                                                            if(!empty($file_files)) { echo '<a data-src="'.$src.$url.rawurlencode($file_files).$embed.'" data-fancybox data-type="'.$type.'" class="btn btn-link btn-sm">View</a>'; } 



                                                                            if ($supplier_reviewed_by == $current_userID) {

                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 1)">Upload</a>';

                                                                            } else if ($supplier_approved_by == $current_userID) {

                                                                                echo '<a href="#modalFile" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnFile('.$supplier_id.', 2)">Upload</a>';

                                                                            }

                                                                        echo '</td>';

                                                                    }



                                                                    echo '<td class="text-center">'.$vulnerability_result.'</td>

                                                                    <td class="text-center">'.$data_last_modified.'</td>

                                                                    <td class="text-center">'.$due_date.'</td>

                                                                    <td class="text-center">'.$status.'</td>

                                                                    <td class="text-center">';

                                                                        if (isset($_COOKIE['switchAccount']) || $current_userEmployeeID == 0 || $current_userID == 481) {

                                                                            echo '<div class="btn-group btn-group-circle">

                                                                                <a href="pdf_ffva?id='.$supplier_id.'&signed=1" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>

                                                                                <a href="pdf_ffva_excel?id='.$supplier_id.'&signed=1" class="btn green-jungle btn-sm" target="_blank" title="Excel"><i class="fa fa-fw fa-file-excel-o"></i></a>

                                                                                <a href="#modalView" class="btn dark btn-sm hide" data-toggle="modal" onclick="btnView('.$supplier_id.')" title="View"><i class="fa fa-fw fa-search"></i></a>

                                                                                <a href="#modalEdit" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnEdit('.$supplier_id.')" title="Edit"><i class="fa fa-fw fa-pencil"></i></a>

                                                                                <a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnDelete('.$supplier_id.', 1)" title="Delete"><i class="fa fa-fw fa-trash"></i></a>

                                                                                <a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="btnArchive('.$supplier_id.', 1)" title="Archive"><i class="fa fa-fw fa-file-archive-o"></i></a>';



                                                                                if ($supplier_reviewed_by == $current_userID) {

                                                                                    echo '<a href="#modalSign" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnSign('.$supplier_id.', 1)"><i class="fa fa-fw fa-edit"></i></a>';

                                                                                } else if ($supplier_approved_by == $current_userID) {

                                                                                    echo '<a href="#modalSign" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnSign('.$supplier_id.', 2)"><i class="fa fa-fw fa-edit"></i></a>';

                                                                                }



                                                                            echo '</div>';

                                                                        } else {

                                                                            echo '<a href="pdf_ffva?id='.$supplier_id.'" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>';

                                                                        }

                                                                    echo '</td>

                                                                </tr>';

                                                            }

                                                        }

                                                    ?>

                                                </tbody>

                                            </table>

                                        </div>

                                        <div class="tab-pane <?php echo $FreeAccess == false ? '':'hide'; ?>" id="tabReferences">

                                            <h4><strong>Likelihood Questionnaire</strong></h4>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover" id="tableDataRef_1">

                                                    <thead>

                                                        <tr>

                                                            <th style="width: 250px;">Elements</th>

                                                            <th>References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );

                                                            if ( mysqli_num_rows($resultRefLikelihood) > 0 ) {

                                                                while($rowRefLikelihood = mysqli_fetch_array($resultRefLikelihood)) {

                                                                    $ref_likelihood_id = $rowRefLikelihood["ID"];

                                                                    $ref_likelihood_element = $rowRefLikelihood["element"];



                                                                    $content = '';

                                                                    $resultReferences = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE user_id = $switch_user_id AND type = 1 AND element = $ref_likelihood_id" );

                                                                    if ( mysqli_num_rows($resultReferences) > 0 ) {

                                                                        $rowReferences = mysqli_fetch_array($resultReferences);

                                                                        $content = $rowReferences["content"];

                                                                    }



                                                                    echo '<tr class="tr_'.$ref_likelihood_id.'">

                                                                        <td>'.$ref_likelihood_element.'</td>

                                                                        <td>'.nl2br($content).'

                                                                            <a href="#modalRef" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnRef('.$ref_likelihood_id.', 1)"><i class="fa fa-pencil"></i> [edit]</a>

                                                                        </td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br><br>



                                            <h4><strong>Consequence Questionnaire</strong></h4>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover" id="tableDataRef_2">

                                                    <thead>

                                                        <tr>

                                                            <th style="width: 250px;">Elements</th>

                                                            <th>References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );

                                                            if ( mysqli_num_rows($resultRefConsequence) > 0 ) {

                                                                while($rowRefConsequence = mysqli_fetch_array($resultRefConsequence)) {

                                                                    $ref_consequence_id = $rowRefConsequence["ID"];

                                                                    $ref_consequence_element = $rowRefConsequence["element"];



                                                                    $content = '';

                                                                    $resultReferences = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE user_id = $switch_user_id AND type = 2 AND element = $ref_consequence_id" );

                                                                    if ( mysqli_num_rows($resultReferences) > 0 ) {

                                                                        $rowReferences = mysqli_fetch_array($resultReferences);

                                                                        $content = $rowReferences["content"];

                                                                    }



                                                                    echo '<tr class="tr_'.$ref_consequence_id.'">

                                                                        <td>'.$ref_consequence_element.'</td>

                                                                        <td>'.$content.'

                                                                            <a href="#modalRef" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnRef('.$ref_consequence_id.', 2)"><i class="fa fa-pencil"></i> [edit]</a>

                                                                        </td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br><br>



                                            <h4><strong>General Reference</strong></h4>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 0" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

                                                                            }

                                                                        echo '</td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br><br>



                                            <h4><strong>Others</strong></h4>

                                            <h5><strong>I. Guidance Documents</strong></h5>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 1" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

                                                                            }

                                                                        echo '</td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br>



                                            <h5><strong>II. Self-Assessment Tools</strong></h5>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 2" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

                                                                            }

                                                                        echo '</td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br>



                                            <h5><strong>III. Alerts and Databases</strong></h5>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 3" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

                                                                            }

                                                                        echo '</td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br>



                                            <h5><strong>IV. Standards</strong></h5>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 4" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

                                                                            }

                                                                        echo '</td>

                                                                    </tr>';

                                                                }

                                                            }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </div><br>



                                            <h5><strong>V. Sources of Information and Intelligence about Emerging Risks to Supply Chain</strong></h5>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered table-hover">

                                                    <thead>

                                                        <tr>

                                                            <th>Title</th>

                                                            <th style="width: 150px;">References</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultRefGeneral = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference_general WHERE type = 5" );

                                                            if ( mysqli_num_rows($resultRefGeneral) > 0 ) {

                                                                while($rowRefGeneral = mysqli_fetch_array($resultRefGeneral)) {

                                                                    $ref_general_name = $rowRefGeneral["name"];

                                                                    $ref_general_ref = $rowRefGeneral["ref"];

                                                                    $ref_general_ref_arr = explode(' ; ', $ref_general_ref);



                                                                    echo '<tr>

                                                                        <td>'.$ref_general_name.'</td>

                                                                        <td>'; 

                                                                            foreach ($ref_general_ref_arr as $value) {

                                                                                echo '<a href="'.$value.'" target="_blank">View</a> ';

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

                                        <div class="tab-pane" id="tabKatva">

                                            <?php

                                                if ($current_userEmployeeID == 0 || $current_userID == 481 || isset($_COOKIE['switchAccount'])) {

                                                    echo '<a href="'; echo $FreeAccess == false ? '#modalNewKatva':'#modalService';  echo '" class="btn btn-success btn-circle pull-right margin-bottom-15" data-toggle="modal" onclick="btnNewKatva(1)">Add New KATVA</a>';

                                                }

                                            ?>

                                            

                                            <div class="table-scrollable" style="border: 0;">

                                                <table class="table table-bordered table-hover" id="tableDataKatva">

                                                    <thead>

                                                        <tr>

                                                            <th>ID#</th>

                                                            <th>Product</th>

                                                            <th>Facility Name</th>

                                                            <th>Address</th>

                                                            <th style="width: 90px;" class="text-center">Status</th>

                                                            <?php

                                                                if ($FreeAccess != 1) {

                                                                    echo '<th style="width: 165px;"></th>';

                                                                }

                                                            ?>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                            $resultKatva = mysqli_query( $conn,"SELECT * FROM tbl_ffva_katva WHERE deleted = 0 AND user_id = $switch_user_id" );

                                                            if ( mysqli_num_rows($resultKatva) > 0 ) {

                                                                while($rowKatva = mysqli_fetch_array($resultKatva)) {

                                                                    $katva_ID = $rowKatva["ID"];

                                                                    $katva_product = $rowKatva["product"];

                                                                    $katva_facility = $rowKatva["facility"];

                                                                    $katva_address = $rowKatva["address"];



                                                                    $status = 'Pending';

                                                                    $katva_approved_signature = $rowKatva["approved_signature"];

                                                                    if (!empty($katva_approved_signature)) { $status = 'Completed'; }



                                                                    echo '<tr id="tr_'.$katva_ID.'">

                                                                        <td>'.$katva_ID.'</td>

                                                                        <td>'.$katva_product.'</td>

                                                                        <td>'.$katva_facility.'</td>

                                                                        <td>'.$katva_address.'</td>

                                                                        <td>'.$status.'</td>';



                                                                        if ($FreeAccess != 1) {

                                                                            echo '<td class="text-center">

                                                                                <div class="btn-group btn-group-circle">

                                                                                    <a href="pdf_katva?id='.$katva_ID.'" class="btn btn-outline btn-circle dark btn-sm" target="_blank">PDF</a>

                                                                                    <a href="#modalViewKatva" class="btn btn-outline btn-success btn-sm" data-toggle="modal" onclick="btnViewKatva('.$katva_ID.')">Edit</a>

                                                                                    <a href="javascript:;" class="btn dark btn-sm" onclick="btnDeleteKatva('.$katva_ID.')">Delete</a>

                                                                                </div>

                                                                            </td>';

                                                                        }

                                                                        

                                                                   echo ' </tr>';

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

                        <div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalHistory">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA History</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalArchived" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalArchived">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA Archived</h4>

                                        </div>

                                        <div class="modal-body">

                                            <table class="table table-bordered table-hover" id="tableData_archived">

                                                <thead>

                                                    <tr>

                                                        <th>ID#</th>

                                                        <th>Name</th>

                                                        <th class="text-center">Vulnerability</th>

                                                        <th class="text-center">Date Performed</th>

                                                        <th class="text-center">Due Date</th>

                                                        <th style="width: 90px;" class="text-center">Status</th>

                                                        <th></th>

                                                    </tr>

                                                </thead>

                                                <tbody></tbody>

                                            </table>

                                        </div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalNew" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-full">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNew">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA Details</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnSave_FFVA" id="btnSave_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-full">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalEdit">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA Details</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdate_FFVA" id="btnUpdate_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

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

                                            <h4 class="modal-title">FFVA Details</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

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

                        <div class="modal fade" id="modalRef" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalRef">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA References</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnRef_FFVA" id="btnRef_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalSign" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="modalForm modalSign">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA Sign</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnSign_FFVA" id="btnSign_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalFile" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalFile">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">FFVA File</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnFile_FFVA" id="btnFile_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalNewKatva" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-full">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalNewKatva">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">Vulnerability Assessment for Food Fraud - Key Activity Types</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnSaveKatva_FFVA" id="btnSaveKatva_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="modalViewKatva" tabindex="-1" role="dialog" aria-hidden="true">

                            <div class="modal-dialog modal-full">

                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewKatva">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                            <h4 class="modal-title">Vulnerability Assessment for Food Fraud - Key Activity Types</h4>

                                        </div>

                                        <div class="modal-body"></div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                            <button type="submit" class="btn btn-success ladda-button" name="btnUpdateKatva_FFVA" id="btnUpdateKatva_FFVA" data-style="zoom-out"><span class="ladda-label">Save</span></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <!-- / END MODAL AREA -->

                        

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

                                                <?php if($switch_user_id != ''): ?>

                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">

                                                <?php else: ?>

                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $current_userEmployerID ?>">

                                                <?php endif; ?>

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

                                        <div class="modal-footer">

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

                                            <!--<video id="myVideo" width="320" height="240" controls style="width:100%;height:100%">-->

                                            <!--  <source src="" >-->

                                            <!--    Your browser does not support the video tag.-->

                                            <!--</video>-->

                                            <!--<iframe id="myVideo" class="embed-responsive-item" width="320" height="240" src="" allowfullscreen></iframe>-->

                                            <div class="embed-responsive embed-responsive-16by9">

                                                <iframe id="myVideo" class="embed-responsive-item" width="560" height="315" src="" allowfullscreen></iframe>

                                             </div>

                                        </div>

                                        <div class="modal-footer">

                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                                     

                    </div><!-- END CONTENT BODY -->



        <?php include_once ('footer.php'); ?>



        <!--[if lt IE 9]>

        <script type="text/javascript" src="assets/jSignature/flashcanvas.js"></script>

        <![endif]-->

        <script src="assets/jSignature/jSignature.min.js"></script>



        <script type="text/javascript">

            $(document).ready(function(){

                fancyBoxes();

                // $('.view_videos').click(function(){

                //     var file_name = $(this).attr('file_name')

                //     var vid = document.getElementById("myVideo");

                //     vid.src = "uploads/pages_demo/"+file_name;

                //     $("#myVideo").attr('src', file_name);

                // });



                var free_access = '<?php echo $FreeAccess; ?>';
                var v = '<?php echo isset($_GET['v']) ? $_GET['v']:''; ?>';

                if (free_access == 1) {

                    $('#tableData_1, #tableData_2, #tableDataKatva').DataTable( {

                        dom: 'C&gt;&lt;Bfrtip',

                        buttons: [

                            'csv', 'excel', 'pdf', 'print'

                        ]

                    } );

                } else {

                    // $('#tableData_1, #tableData_2, #tableDataKatva').DataTable();

                    $('#tableData_1, #tableData_2, #tableDataKatva').dataTable( {

                      "columnDefs": [

                        { "width": "auto" }

                      ]

                    } );

                }

                if (v != '') {
                    $('#modalEdit').modal('show');
                    btnEdit(v);
                }

            });

            function uploadNew(e) {

                $(e).parent().hide();

                $(e).parent().prev('.form-control').removeClass('hide');

            }

            function editSignature(e) {

                $(e).parent().hide();

                $(e).parent().prev('.signatureContainer').removeClass('hide');

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

            function btnNew_Activity(id) {

                if (id == 1) { var nameOther = 'prevention'; }

                else if (id == 2) { var nameOther = 'detection'; }

                else if (id == 3) { var nameOther = 'mitigation'; }



                var txtActivity = $("#txtActivity_"+id).val();



                if (txtActivity != "") {

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+txtActivity;

                        html += '<input type="checkbox" value="'+txtActivity+'" name="'+nameOther+'_other[]" checked />';

                        html += '<span></span>';

                    html += '</label>';

                    $('#list_activity_'+id).append(html);

                }

            }

            function btnNew_Questionaire(modal, id) {

                if (id == 1) { var nameOther = 'likelihood'; }

                else if (id == 2) { var nameOther = 'consequence'; }



                let x = Math.floor((Math.random() * 100) + 1);

                var questionaire_element = $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' .'+nameOther+'_element').val();

                var questionaire_question = $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' .'+nameOther+'_question').val();



                if (questionaire_element != "" && questionaire_question != "") {

                    var html = '<tr class="tr_other_'+x+'">';

                        html += '<td><input type="hidden" value="'+questionaire_element+'" name="'+nameOther+'_element_other[]" required />'+questionaire_element+'</td>';

                        html += '<td><input type="hidden" value="'+questionaire_question+'" name="'+nameOther+'_question_other[]" required />'+questionaire_question+'</td>';

                        html += '<td>';

                            html += '<div class="mt-radio-list">';

                                html += '<label class="mt-radio mt-radio-outline"> Yes';

                                    html += '<input type="radio" value="1" name="'+nameOther+'_answer_other_'+x+'" onclick="questionaireAnswerOther('+modal+', '+id+', '+x+', 1, this)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> No';

                                    html += '<input type="radio" value="0" name="'+nameOther+'_answer_other_'+x+'" onclick="questionaireAnswerOther('+modal+', '+id+', '+x+', 0, this)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                            html += '</div>';

                            html += '<input type="hidden" class="'+nameOther+'_answer" name="'+nameOther+'_answer_other[]" value="" />';

                        html += '</td>';

                        html += '<td>';

                            html += '<textarea class="form-control" name="'+nameOther+'_comment_other[]" placeholder="Enter comment here"></textarea>';

                            html += '<input type="file" class="form-control margin-top-15 hide" name="'+nameOther+'_file_other[]" />';

                            html += '<p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload File</button></p>';

                        html += '</td>';

                        html += '<td class="radioRate">';

                            html += '<div class="mt-radio-list">';

                                html += '<label class="mt-radio mt-radio-outline"> 1 - Very Unlikely';

                                    html += '<input type="radio" value="1" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 1)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> 2 - Unlikely';

                                    html += '<input type="radio" value="2" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 2)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> 3 - Fairly Likely';

                                    html += '<input type="radio" value="3" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 3)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> 4 - Likely';

                                    html += '<input type="radio" value="4" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 4)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> 5 - Very Likely or Certain';

                                    html += '<input type="radio" value="5" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 5)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                            html += '</div>';

                            html += '<input type="hidden" class="'+nameOther+'_rate" name="'+nameOther+'_rate_other[]" value="" />';

                        html += '</td>';

                        html += '<td class="text-center"><a href="javascript:;" class="btn btn-danger btn-circle" onclick="btnRemoveOther('+modal+', '+id+', '+x+')">Remove</a></td>';

                    html += '</tr>';

                    $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' tbody').append(html);

                }

            }

            function btnNew_Questionaire_Consequence(modal, id) {

                if (id == 1) { var nameOther = 'likelihood'; }

                else if (id == 2) { var nameOther = 'consequence'; }



                let x = Math.floor((Math.random() * 100) + 1);

                var questionaire_element = $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' .'+nameOther+'_element').val();

                var questionaire_question = $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' .'+nameOther+'_question').val();



                if (questionaire_element != "" && questionaire_question != "") {

                    var html = '<tr class="tr_other_'+x+'">';

                        html += '<td><input type="hidden" value="'+questionaire_element+'" name="'+nameOther+'_element_other[]" required />'+questionaire_element+'</td>';

                        html += '<td><input type="hidden" value="'+questionaire_question+'" name="'+nameOther+'_question_other[]" required />'+questionaire_question+'</td>';

                        html += '<td>';

                            html += '<div class="mt-radio-list">';

                                html += '<label class="mt-radio mt-radio-outline"> Yes';

                                    html += '<input type="radio" value="1" name="'+nameOther+'_answer_other_'+x+'" onclick="questionaireAnswerOther('+modal+', '+id+', '+x+', 1, this)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> No';

                                    html += '<input type="radio" value="0" name="'+nameOther+'_answer_other_'+x+'" onclick="questionaireAnswerOther('+modal+', '+id+', '+x+', 0, this)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                            html += '</div>';

                            html += '<input type="hidden" class="'+nameOther+'_answer" name="'+nameOther+'_answer_other[]" value="" />';

                        html += '</td>';

                        html += '<td>';

                            html += '<textarea class="form-control" name="'+nameOther+'_comment_other[]" placeholder="Enter comment here"></textarea>';

                            html += '<input type="file" class="form-control margin-top-15 hide" name="'+nameOther+'_file_other[]" />';

                            html += '<p style="margin: 0;"><button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload File</button></p>';

                        html += '</td>';

                        html += '<td class="radioRate">';

                            html += '<div class="mt-radio-list">';

                                html += '<label class="mt-radio mt-radio-outline"> <b>1 - Negligible</b>';

                                    html += '<input type="radio" value="1" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 1)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> <b>2 - Minor</b>';

                                    html += '<input type="radio" value="2" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 2)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> <b>3 - Moderate</b>';

                                    html += '<input type="radio" value="3" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 3)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> <b>4 - Significant</b>';

                                    html += '<input type="radio" value="4" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 4)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                                html += '<label class="mt-radio mt-radio-outline"> <b>5 - Severe</b>';

                                    html += '<input type="radio" value="5" name="'+nameOther+'_rate_other_'+x+'" onclick="questionaireRateOther('+modal+', '+id+', '+x+', 5)" required />';

                                    html += '<span></span>';

                                html += '</label>';

                            html += '</div>';

                            html += '<input type="hidden" class="'+nameOther+'_rate" name="'+nameOther+'_rate_other[]" value="" />';

                        html += '</td>';

                        html += '<td class="text-center"><a href="javascript:;" class="btn btn-danger btn-circle" onclick="btnRemoveOther('+modal+', '+id+', '+x+')">Remove</a></td>';

                    html += '</tr>';

                    $('#tabdrop_'+modal+' .tableQuestionaire_'+id+' tbody').append(html);

                }

            }

            function btnRemove(modal, table, x) {

                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_'+x).remove();

            }

            function btnRemoveOther(modal, table, x) {

                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_other_'+x).remove();

            }

            function questionaireAnswer(modal, table, id, val, e) {

                if (table == 1) { name = "likelihood"; }

                else if (table == 2) { name = "consequence"; }



                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_'+id+' .'+name+'_answer').val(val);



                $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label:first-child input').prop("checked", true);

                // if (val == 1) { $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label input').removeAttr("disabled"); }

                // else { $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label:nth-child(n+2) input').attr('disabled', 'disabled'); }



                questionaireRate(modal, table, id, 1);



                // $(e).parent().parent().parent().hide();

                // console.log(val);

                // console.log(id);

            }

            function questionaireAnswerOther(modal, table, id, val, e) {

                if (table == 1) { name = "likelihood"; }

                else if (table == 2) { name = "consequence"; }



                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_other_'+id+' .'+name+'_answer').val(val);



                $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label:first-child input').prop("checked", true);

                // if (val == 1) { $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label input').removeAttr("disabled"); }

                // else { $(e).parent().parent().parent().parent().find('.radioRate .mt-radio-list label:nth-child(n+2) input').attr('disabled', 'disabled'); }



                questionaireRateOther(modal, table, id, 1);

            }

            function questionaireRate(modal, table, id, val) {

                if (table == 1) { name = "likelihood"; }

                else if (table == 2) { name = "consequence"; }



                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_'+id+' .'+name+'_rate').val(val);

                // console.log(modal);

                // console.log(table);

                // console.log(id);

                // console.log(val);

                questionaireRateSummary(modal);

            }

            function questionaireRateOther(modal, table, id, val) {

                if (table == 1) { name = "likelihood"; }

                else if (table == 2) { name = "consequence"; }



                $('#tabdrop_'+modal+' .tableQuestionaire_'+table+' tbody .tr_other_'+id+' .'+name+'_rate').val(val);



                questionaireRateSummary(modal);

            }

            function questionaireRateSummary(modal) {

                for (var x = 1; x <= 2; x++) {

                    if (x == 1) { name = "likelihood"; }

                    else if (x == 2) { name = "consequence"; }



                    var sum = 0;

                    var total = 0;

                    var result = 'Undefine';

                    var inputs = $('#tabdrop_'+modal+' .tableQuestionaire_'+x+' .'+name+'_rate');

                    for(var i = 0; i < inputs.length; i++){

                        var number = $(inputs[i]).val();

                        if($.isNumeric(number)) {

                            sum = Math.round(sum) + Math.round(number);

                        }

                    }

                    total = sum / inputs.length;



                    if (x == 1) {

                        if (Math.round(total) == 1) { result = "1 - Very Unlikely"; }

                        else if (Math.round(total) == 2) { result = "2 - Unlikely"; }

                        else if (Math.round(total) == 3) { result = "3 - Fairly Likely"; }

                        else if (Math.round(total) == 4) { result = "4 - Likely"; }

                        else if (Math.round(total) == 5) { result = "5 - Very Likely or Certain"; }

                    } else if (x == 2) {

                        if (Math.round(total) == 1) { result = "1 - Negligible"; }

                        else if (Math.round(total) == 2) { result = "2 - Minor"; }

                        else if (Math.round(total) == 3) { result = "3 - Moderate"; }

                        else if (Math.round(total) == 4) { result = "4 - Significant"; }

                        else if (Math.round(total) == 5) { result = "5 - Severe"; }

                    }

                    $('#tabdrop_'+modal+' .tableQuestionaire_'+x+' .'+name+'_result').html(result);

                    $('#tabdrop_'+modal+' #tableMatrixData .'+name+'_result').html(result);



                    // console.log(x);

                    // console.log('modal:'+ modal);

                    // console.log('total:'+ total);

                    // console.log('sum:'+ sum);

                    // console.log('inputs.length:'+ inputs.length);

                    // console.log('name:'+ name);

                    // console.log('result:'+ result);

                }



                questionaireMatrix();

            }

            function questionaireMatrix() {

                var x = 1;

                var y = 1;



                var likelihoodRateSummary = parseInt($('#tableMatrixData .likelihood_result').text());

                var consequenceRateSummary = parseInt($('#tableMatrixData .consequence_result').text());



                if (likelihoodRateSummary > 0) { x = likelihoodRateSummary; }

                if (consequenceRateSummary > 0) { y = consequenceRateSummary; }

                plot = y+"-"+x;



                $('#tableMatrix .fa').addClass('hidden');

                $('#tableMatrix tr .matrix-'+plot+' .fa').removeClass('hidden');



                if (x == 1 && y == 1) { vulnerability = 1; }

                else if (x == 1 && y == 2) { vulnerability = 1; }

                else if (x == 1 && y == 3) { vulnerability = 1; }

                else if (x == 1 && y == 4) { vulnerability = 2; }

                else if (x == 1 && y == 5) { vulnerability = 2; }

                else if (x == 2 && y == 1) { vulnerability = 1; }

                else if (x == 2 && y == 2) { vulnerability = 1; }

                else if (x == 2 && y == 3) { vulnerability = 2; }

                else if (x == 2 && y == 4) { vulnerability = 2; }

                else if (x == 2 && y == 5) { vulnerability = 3; }

                else if (x == 3 && y == 1) { vulnerability = 2; }

                else if (x == 3 && y == 2) { vulnerability = 2; }

                else if (x == 3 && y == 3) { vulnerability = 2; }

                else if (x == 3 && y == 4) { vulnerability = 3; }

                else if (x == 3 && y == 5) { vulnerability = 3; }

                else if (x == 4 && y == 1) { vulnerability = 2; }

                else if (x == 4 && y == 2) { vulnerability = 2; }

                else if (x == 4 && y == 3) { vulnerability = 3; }

                else if (x == 4 && y == 4) { vulnerability = 3; }

                else if (x == 4 && y == 5) { vulnerability = 3; }

                else if (x == 5 && y == 1) { vulnerability = 3; }

                else if (x == 5 && y == 2) { vulnerability = 3; }

                else if (x == 5 && y == 3) { vulnerability = 3; }

                else if (x == 5 && y == 4) { vulnerability = 3; }

                else if (x == 5 && y == 5) { vulnerability = 3; }



                if (vulnerability == 1) { vulnerability_result = "Low Risk"; }

                else if (vulnerability == 2) { vulnerability_result = "Medium Risk: Action is needed with occasional monitoring to mitigate the risk."; }

                else if (vulnerability == 3) { vulnerability_result = "High Risk: Urgent action is required and regular monitoring may be needed!"; }



                $('#tableMatrixData .vulnerability_result').html(vulnerability_result);

            }



            function widget_signature() {

                $(".signature").jSignature({

                    'background-color': 'transparent',

                    'decor-color': 'transparent',

                });

                $("canvas").attr('width','300');

                $("canvas").attr('height','150');

                $("canvas").width(300);

                $("canvas").height(150);

                btnClear();

            }

            function btnClear(e) {

                if (e) {

                    $(e).next('.signature').jSignature("clear");

                } else {

                    $('.signature').jSignature("clear");

                }

            }



            function btnHistory(id) {

                $.ajax({

                    type: "GET",

                    url: "function.php?modalHistory_FFVA="+id,

                    dataType: "html",

                    success: function(data){

                        $("#modalHistory .modal-body").html(data);

                    }

                });

            }

            function btnArchived(id) {

                $.ajax({

                    type: "GET",

                    url: "function.php?modalArchived_FFVA="+id,

                    dataType: "html",

                    success: function(data){

                        $("#modalArchived .modal-body #tableData_archived tbody").html(data);

                    }

                });

            }



            function btnNew(id) {

                $.ajax({

                    type: "GET",

                    url: "function.php?modalNew_FFVA="+id,

                    dataType: "html",

                    success: function(data){

                        $("#modalNew .modal-body").html(data);



                        widget_signature();

                        selectMulti();

                        questionaireRateSummary(1);

                    }

                });

            }

            $(".modalNew").on('submit',(function(e) {

                var free_access = '<?php echo $FreeAccess; ?>';

                e.preventDefault();



                var prepared_sigData = $('#tabAssigned .prepared_signature').jSignature('getData');

                var reviewed_sigData = $('#tabAssigned .reviewed_signature').jSignature('getData');

                var approved_sigData = $('#tabAssigned .approved_signature').jSignature('getData');



                formObj = $(this);

                if (!formObj.validate().form()) return false;



                if (inputInvalid('modalNew') > 0) { return false; }

                    

                var formData = new FormData(this);

                formData.append('btnSave_FFVA',true);

                formData.append('prepared_sigData', prepared_sigData);

                formData.append('reviewed_sigData', reviewed_sigData);

                formData.append('approved_sigData', approved_sigData);



                var l = Ladda.create(document.querySelector('#btnSave_FFVA'));

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

                            var html = '<tr id="tr_'+obj.ID+'">';

                                html += '<td>'+obj.ID+'</td>';

                                html += '<td>'+obj.company+'</td>';



                                if (obj.user_id == 5) {

                                    html += '<td class="text-center int_review_status"><a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('+obj.ID+', 1, 1)">View</a></td>';

                                    html += '<td class="text-center int_verify_status"></td>';

                                }

                                

                                if (free_access != 1) {

                                    html += '<td class="text-center"></td>';

                                }

                                

                                html += '<td class="text-center">'+obj.vulnerability_result+'</td>';

                                html += '<td class="text-center">'+obj.last_modified+'</td>';

                                html += '<td class="text-center">'+obj.due_date+'</td>';

                                html += '<td class="text-center">'+obj.status+'</td>';

                                html += '<td class="text-center">';

                                    html += '<div class="btn-group btn-group-circle">';

                                        html += '<a href="pdf_ffva?id='+obj.ID+'&signed=1" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>';

                                        html += '<a href="pdf_ffva_excel?id='+obj.ID+'&signed=1" class="btn green-jungle btn-sm" target="_blank" title="Excel"><i class="fa fa-fw fa-file-excel-o"></i></a>';

                                        html += '<a href="#modalView" class="btn dark btn-sm hide" data-toggle="modal" onclick="btnView('+obj.ID+')" title="View"><i class="fa fa-fw fa-search"></i></a>';

                                        html += '<a href="#modalEdit" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+')" title="Edit"><i class="fa fa-fw fa-pencil"></i></a>';

                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnDelete('+obj.ID+', '+obj.tab+')" title="Delete"><i class="fa fa-fw fa-trash"></i></a>';

                                        html += '<a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="btnArchive('+obj.ID+', '+obj.tab+')" title="Archive"><i class="fa fa-fw fa-file-archive-o"></i></a>';

                                    html += '</div>';

                                html += '</td>';

                            html += '</tr>';

                            $('#tableData_'+obj.tab+' tbody').append(html);

                            $('#modalNew').modal('hide');

                        } else {

                            msg = "Error!"

                        }

                        l.stop();



                        bootstrapGrowl(msg);

                    }

                });

            }));

            function btnEdit(id) {

                $.ajax({

                    type: "GET",

                    url: "function.php?modalEdit_FFVA="+id,

                    dataType: "html",

                    success: function(data){

                        $("#modalEdit .modal-body").html(data);



                        widget_signature();

                        selectMulti();

                        questionaireRateSummary(2);

                    }

                });

            }

            $(".modalEdit").on('submit',(function(e) {

                var free_access = '<?php echo $FreeAccess; ?>';

                e.preventDefault();



                var prepared_sigData = $('#tabAssigned_2 .prepared_signature').jSignature('getData');

                var reviewed_sigData = $('#tabAssigned_2 .reviewed_signature').jSignature('getData');

                var approved_sigData = $('#tabAssigned_2 .approved_signature').jSignature('getData');



                formObj = $(this);

                if (!formObj.validate().form()) return false;



                if (inputInvalid('modalEdit') > 0) { return false; }

                    

                var formData = new FormData(this);

                formData.append('btnUpdate_FFVA',true);

                formData.append('prepared_sigData', prepared_sigData);

                formData.append('reviewed_sigData', reviewed_sigData);

                formData.append('approved_sigData', approved_sigData);



                var l = Ladda.create(document.querySelector('#btnUpdate_FFVA'));

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

                            var html = '<tr id="tr_'+obj.ID+'">';

                                html += '<td>'+obj.ID+'</td>';

                                html += '<td>'+obj.company+'</td>';



                                if (obj.user_id == 5) {

                                    html += '<td class="text-center int_review_status"><a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('+obj.ID+', 1, 1)">View</a></td>';

                                    html += '<td class="text-center int_verify_status"></td>';

                                }

                                

                                if (free_access != 1) {

                                    html += '<td class="text-center"></td>';

                                }

                                

                                html += '<td class="text-center">'+obj.vulnerability_result+'</td>';

                                html += '<td class="text-center">'+obj.last_modified+'</td>';

                                html += '<td class="text-center">'+obj.due_date+'</td>';

                                html += '<td class="text-center">'+obj.status+'</td>';

                                html += '<td class="text-center">';

                                    html += '<div class="btn-group btn-group-circle">';

                                        html += '<a href="pdf_ffva?id='+obj.ID+'&signed=1" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>';

                                        html += '<a href="pdf_ffva_excel?id='+obj.ID+'&signed=1" class="btn green-jungle btn-sm" target="_blank" title="Excel"><i class="fa fa-fw fa-file-excel-o"></i></a>';

                                        html += '<a href="#modalView" class="btn dark btn-sm hide" data-toggle="modal" onclick="btnView('+obj.ID+')" title="View"><i class="fa fa-fw fa-search"></i></a>';

                                        html += '<a href="#modalEdit" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+')" title="Edit"><i class="fa fa-fw fa-pencil"></i></a>';

                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnDelete('+obj.ID+', '+obj.tab+')" title="Delete"><i class="fa fa-fw fa-trash"></i></a>';

                                        html += '<a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="btnArchive('+obj.ID+', '+obj.tab+')" title="Archive"><i class="fa fa-fw fa-file-archive-o"></i></a>';

                                    html += '</div>';

                                html += '</td>';

                            html += '</tr>';

                            $('#tableData_'+obj.tab+' tbody').append(html);

                            $('#tableData_'+obj.tab+' tbody #tr_'+obj.ffva_ID).remove();

                            $('#modalEdit').modal('hide');

                        } else {

                            msg = "Error!"

                        }

                        l.stop();



                        bootstrapGrowl(msg);

                    }

                });

            }));

            function btnView(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_FFVA="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);

                        questionaireRateSummary(3);
                    }
                });
            }
            function btnDelete(id, table) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax(
                        type: "GET",
                        url: "function.php?btnDelete_FFVA="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_'+table+' tbody #tr_'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnArchive(id, table) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be archived!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnArchive_FFVA="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_'+table+' tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been achived.", "success");
                });
            }
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
                            $('#tableData_archived tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been reverted.", "success");
                });
            }
            function btnTemplate(id, tab) {
                var free_access = '<?php echo $FreeAccess; ?>';
                swal({
                    title: "Are you sure?",
                    text: "Your item will be drafted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnTemplate_FFVA="+id+"&tab="+tab,
                        dataType: "html",
                        success: function(response){
                            if ($.trim(response)) {
                                msg = "Sucessfully Save!";
                                var obj = jQuery.parseJSON(response);
                                var html = '<tr id="tr_'+obj.ID+'">';
                                    html += '<td>'+obj.ID+'</td>';
                                    html += '<td>'+obj.company+'</td>';

                                    if (obj.user_id == 5) {
                                        html += '<td class="text-center int_review_status"><a href="#modalViewInt" class="btn btn-link btn-sm" data-toggle="modal" onClick="btnInt('+obj.ID+', 1, 1)">View</a></td>';
                                        html += '<td class="text-center int_verify_status"></td>';
                                    }

                                    if (free_access != 1) {
                                        html += '<td class="text-center"></td>';
                                    }
                                    
                                    html += '<td class="text-center">'+obj.vulnerability_result+'</td>';
                                    html += '<td class="text-center">'+obj.last_modified+'</td>';
                                    html += '<td class="text-center">'+obj.due_date+'</td>';
                                    html += '<td class="text-center">'+obj.status+'</td>';
                                    html += '<td class="text-center">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="pdf_ffva?id='+obj.ID+'&signed=1" class="btn btn-outline dark btn-sm" target="_blank" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>';
                                            html += '<a href="pdf_ffva_excel?id='+obj.ID+'&signed=1" class="btn green-jungle btn-sm" target="_blank" title="Excel"><i class="fa fa-fw fa-file-excel-o"></i></a>';
                                            html += '<a href="#modalView" class="btn dark btn-sm hide" data-toggle="modal" onclick="btnView('+obj.ID+')" title="View"><i class="fa fa-fw fa-search"></i></a>';
                                            html += '<a href="#modalEdit" class="btn btn-success btn-sm" data-toggle="modal" onclick="btnEdit('+obj.ID+')" title="Edit"><i class="fa fa-fw fa-pencil"></i></a>';
                                            html += '<a href="javascript:;" class="btn btn-danger btn-sm" data-toggle="modal" onclick="btnDelete('+obj.ID+', '+obj.tab+')" title="Delete"><i class="fa fa-fw fa-trash"></i></a>';
                                            html += '<a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="btnArchive('+obj.ID+', '+obj.tab+')" title="Archive"><i class="fa fa-fw fa-file-archive-o"></i></a>';
                                        html += '</div>';
                                    html += '</td>';
                                html += '</tr>';
                                $('#tableData_'+obj.tab+' tbody').append(html);
                                $('#modalArchived').modal('hide');
                            } else {
                                msg = "Error!"
                            }

                            bootstrapGrowl(msg);
                        }
                    });
                    swal("Done!", "This item has been drafted.", "success");
                });
            }

            function btnRef(id, type) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalRef_FFVA="+id+"&type="+type,
                    dataType: "html",
                    success: function(data){
                        $("#modalRef .modal-body").html(data);
                    }
                });
            }
            $(".modalRef").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalRef') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnRef_FFVA',true);

                var l = Ladda.create(document.querySelector('#btnRef_FFVA'));
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
                            var html = '<td>';

                                html += obj.content;

                                html += '<a href="#modalRef" class="btn btn-link btn-sm" data-toggle="modal" onclick="btnRef('+obj.ID+', 1)"><i class="fa fa-pencil"></i> [edit]</a>';

                            html += '</td>';
                            $('#tableDataRef_'+obj.type+' tbody .tr_'+obj.ID+' > td:last-child').html(html);
                            $('#modalRef').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            function btnSign(id, area) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalSign_FFVA="+id+"&area="+area,
                    dataType: "html",
                    success: function(data){
                        $("#modalSign .modal-body").html(data);

                        widget_signature();
                    }
                });
            }            $(".modalSign").on('submit',(function(e) {
                e.preventDefault();

                var sigData = $('#modalSign .signature').jSignature('getData');

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSign') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSign_FFVA',true);
                formData.append('sigData', sigData);

                var l = Ladda.create(document.querySelector('#btnSign_FFVA'));
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
                            $('#modalSign').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            function btnFile(id, area) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalFile_FFVA="+id+"&area="+area,
                    dataType: "html",
                    success: function(data){
                        $("#modalFile .modal-body").html(data);
                    }
                });
            }
            $(".modalFile").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalFile') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnFile_FFVA',true);

                var l = Ladda.create(document.querySelector('#btnFile_FFVA'));
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
                            $('#tr_'+obj.ID+' td:nth-child(3)').html(obj.attached);
                            $('#modalFile').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

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
                            var obj = jQuery.parseJSON(response);
                            if (obj.type == 1) { $('#tableData_'+obj.tab+' tbody #tr_'+obj.ID+' .int_review_status').html(obj.int_column); }
                            else if (obj.type == 2) { $('#tableData_'+obj.tab+' tbody #tr_'+obj.ID+' .int_verify_status').html(obj.int_column); }
                            $('#modalViewInt').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));

            function selectType(e) {
                if (e.value == 1) {
                    $(e).parent().parent().parent().find('.sign').addClass('hide');
                    $(e).parent().parent().parent().find('.signature_sign').removeClass('hide');
                } else if (e.value == 2) {
                    $(e).parent().parent().parent().find('.sign').addClass('hide');
                    $(e).parent().parent().parent().find('.signature_upload').removeClass('hide');
                } else {
                    $(e).parent().parent().parent().find('.sign').addClass('hide');
                    $(e).parent().parent().parent().find('.signature_default').removeClass('hide');
                }
            }
            function selectVulnerability(modal, id) {
                if (id.value == 1) {
                    $(id).next('textarea').removeClass('hide');
                }
                else {
                    $(id).next('textarea').addClass('hide');
                }
            }
            function selectExplanation(modal, id) {
                if (id.value == 1) {
                    $(id).next('select').removeClass('hide');
                    $(id).parent().find('textarea').removeClass('hide');
                } else {
                    $(id).next('select').addClass('hide');
                    $(id).parent().find('textarea').addClass('hide');
                }
            }

            function btnAddKatva(modal) {
                let x = Math.floor((Math.random() * 100) + 1);
                var step = $('#tableDataKatva_'+modal+' .katva_step').val();
                var description = $('#tableDataKatva_'+modal+' .katva_description').val();
                var actionable = $('#tableDataKatva_'+modal+' .katva_actionable').val();
                var mitigation = $('#tableDataKatva_'+modal+' .katva_mitigation').val();

                var vulnerability = $('#tableDataKatva_'+modal+' .katva_vulnerability').val();
                var vulnerability_Other = $('#tableDataKatva_'+modal+' .katva_vulnerability_other').val();
                if (vulnerability == 1) { vulnerability_text = $('#tableDataKatva_'+modal+' .katva_vulnerability_other').val(); }
                else if (vulnerability == 0) { vulnerability_text = "Key Activity Types"; }

                var explanation = $('#tableDataKatva_'+modal+' .katva_explanation').val();
                var explanation_option = $('#tableDataKatva_'+modal+' .katva_explanation_option').val();
                var explanation_comment = $('#tableDataKatva_'+modal+' .katva_explanation_comment').val();

                if (explanation == 0) { explanation_text = "No"; }
                else if (explanation == 1) {
                    explanation_text = "";
                    if (explanation_option == 1) { explanation_text += "Bulk Liquid Receiving and Loading"; }
                    else if (explanation_option == 2) { explanation_text += "Liquid Storage and Handling"; }
                    else if (explanation_option == 3) { explanation_text += "Secondary Ingredient Handling"; }
                    else if (explanation_option == 4) { explanation_text += "Mixing and Similar Activities"; }
                }

                if (step != "" && description != "" && actionable != "" && mitigation != "") {
                    var html = '<tr class="tr_'+x+'">';
                        html += '<td><textarea class="form-control" placeholder="Enter process step here" name="katva_step_'+modal+'[]" required>'+step+'</textarea></td>';
                        html += '<td><textarea class="form-control" placeholder="Enter description here" name="katva_description_'+modal+'[]" require>'+description+'</textarea></td>';

                        html += '<td>';
                            html += '<select class="form-control" onchange="selectVulnerability(1, this)" name="katva_vulnerability_'+modal+'[]">';
                                html += '<option value="0" '; if (vulnerability == 0) { html += 'SELECTED'; } html += '>Key Activity Types</option>';
                                html += '<option value="1" '; if (vulnerability == 1) { html += 'SELECTED'; } html += '>Other</option>';
                            html += '</select>';
                            html += '<textarea class="form-control margin-top-15 '; if (vulnerability == 0) { html += 'hide'; } html += '" placeholder="Enter vulnerability assessment here" name="katva_vulnerability_text_'+modal+'[]">'+vulnerability_Other+'</textarea>';
                        html += '</td>';
                        html += '<td>';
                            html += '<select class="form-control" onchange="selectExplanation(1, this)" name="katva_explanation_'+modal+'[]">';
                                html += '<option value="0" '; if (explanation == 0) { html += 'SELECTED'; } html += '>No</option>';
                                html += '<option value="1" '; if (explanation == 1) { html += 'SELECTED'; } html += '>Yes</option>';
                            html += '</select>';
                            html += '<select class="form-control margin-top-15 '; if (explanation == 0) { html += 'hide'; } html += '" name="katva_explanation_option_'+modal+'[]">';
                                html += '<option value="">Select</option>';
                                html += '<option value="1" '; if (explanation_option == 1) { html += 'SELECTED'; } html += '>Bulk Liquid Receiving and Loading</option>';
                                html += '<option value="2" '; if (explanation_option == 2) { html += 'SELECTED'; } html += '>Liquid Storage and Handling</option>';
                                html += '<option value="3" '; if (explanation_option == 3) { html += 'SELECTED'; } html += '>Secondary Ingredient Handling</option>';
                                html += '<option value="4" '; if (explanation_option == 4) { html += 'SELECTED'; } html += '>Mixing and Similar Activities</option>';
                            html += '</select>';
                            html += '<textarea class="form-control margin-top-15 '; if (explanation == 0) { html += 'hide'; } html += '" placeholder="Enter explanation here" name="katva_explanation_comment_'+modal+'[]">'+explanation_comment+'</textarea>';
                        html += '</td>';

                        html += '<td><textarea class="form-control" placeholder="Enter actionable process step here" name="katva_actionable_'+modal+'[]" required>'+actionable+'</textarea></td>';
                        html += '<td><textarea class="form-control" placeholder="Enter mitigation strategies here" name="katva_mitigation_'+modal+'[]" required>'+mitigation+'</textarea></td>';
                        html += '<td class="text-center"><a href="javascript:;" class="btn btn-danger btn-circle" onclick="btnRemoveKatva('+modal+', '+x+')">Remove</a></td>';
                    html += '</tr>';
                    $('#tableDataKatva_'+modal+' tbody').append(html);
                }
            }
            function btnRemoveKatva(modal, x) {
                $('#tableDataKatva_'+modal+' tbody .tr_'+x).remove();
            }
            function btnDeleteKatva(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDeleteKatva_FFVA="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            $('#tableDataKatva tbody #tr_'+id).remove();
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnNewKatva(modal) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNewKatva_FFVA="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewKatva .modal-body").html(data);

                        widget_signature();
                        selectMulti();
                    }
                });
            }
            $(".modalNewKatva").on('submit',(function(e) {
                e.preventDefault();

                var prepared_sigData = $('#modalNewKatva .prepared_signature').jSignature('getData');
                var reviewed_sigData = $('#modalNewKatva .reviewed_signature').jSignature('getData');
                var approved_sigData = $('#modalNewKatva .approved_signature').jSignature('getData');

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalNewKatva') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSaveKatva_FFVA',true);
                formData.append('prepared_sigData', prepared_sigData);
                formData.append('reviewed_sigData', reviewed_sigData);
                formData.append('approved_sigData', approved_sigData);

                var l = Ladda.create(document.querySelector('#btnSaveKatva_FFVA'));
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
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.ID+'</td>';
                                html += '<td>'+obj.product+'</td>';
                                html += '<td>'+obj.facility+'</td>';
                                html += '<td>'+obj.address+'</td>';
                                html += '<td>'+obj.status+'</td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="pdf_katva?id='+obj.ID+'" class="btn btn-outline btn-circle dark btn-sm" target="_blank">PDF</a>';
                                        html += '<a href="#modalViewKatva" class="btn btn-outline btn-success btn-sm" data-toggle="modal" onclick="btnViewKatva('+obj.ID+')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn dark btn-sm" onclick="btnDeleteKatva('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableDataKatva tbody').append(html);

                            $('#modalNewKatva').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnViewKatva(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewKatva_FFVA="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewKatva .modal-body").html(data);

                        widget_signature();
                        selectMulti();
                    }
                });
            }
            $(".modalViewKatva").on('submit',(function(e) {
                e.preventDefault();

                var prepared_sigData = $('#modalViewKatva .prepared_signature').jSignature('getData');
                var reviewed_sigData = $('#modalViewKatva .reviewed_signature').jSignature('getData');
                var approved_sigData = $('#modalViewKatva .approved_signature').jSignature('getData');

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalViewKatva') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnUpdateKatva_FFVA',true);
                formData.append('prepared_sigData', prepared_sigData);
                formData.append('reviewed_sigData', reviewed_sigData);
                formData.append('approved_sigData', approved_sigData);

                var l = Ladda.create(document.querySelector('#btnUpdateKatva_FFVA'));
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
                           var html = '<td>'+obj.ID+'</td>';
                            html += '<td>'+obj.product+'</td>';
                            html += '<td>'+obj.facility+'</td>';
                            html += '<td>'+obj.address+'</td>';
                            html += '<td>'+obj.status+'</td>';
                            html += '<td class="text-center">';
                                html += '<div class="btn-group btn-group-circle">';
                                    html += '<a href="pdf_katva?id='+obj.ID+'" class="btn btn-outline btn-circle dark btn-sm" target="_blank">PDF</a>';
                                    html += '<a href="#modalViewKatva" class="btn btn-outline btn-success btn-sm" data-toggle="modal" onclick="btnViewKatva('+obj.ID+')">Edit</a>';
                                    html += '<a href="javascript:;" class="btn dark btn-sm" onclick="btnDeleteKatva('+obj.ID+')">Delete</a>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableDataKatva tbody #tr_'+obj.ID).html(html);

                            $('#modalViewKatva').modal('hide');
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