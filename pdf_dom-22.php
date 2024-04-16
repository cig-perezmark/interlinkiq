<?php
    include_once ('database_iiq.php');
    
    function employerID($ID) {
        global $conn;

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }

        return $current_userEmployerID;
    }

    function ai_childView($data_ID, $sheet_id, $type_arr, $label_arr, $viewer, $form_data) {
        global $conn;
        $data = '';

        $selectDataRowChild  = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = $data_ID AND deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
        if ( mysqli_num_rows($selectDataRowChild) > 0 ) {
            while($rowDataChild = mysqli_fetch_array($selectDataRowChild)) {
                $dataChild_ID = $rowDataChild['ID'];

                $includeChild_arr = array();
                if ($rowDataChild['include'] != NULL) { $includeChild_arr = explode(" | ", $rowDataChild['include']); }

                $dataChild_arr = json_decode($rowDataChild['data'],true);

                $data .= '<tr class="child_'.$data_ID.'" id="tr_'.$dataChild_ID.'">';

                    $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
                    if ( mysqli_num_rows($selectFormat) > 0 ) {
                        while($rowFormat = mysqli_fetch_array($selectFormat)) {
                            $formatID = $rowFormat['ID'];

                            $type = $rowFormat['type'];
                            $type_arr = explode(" | ", $type);

                            $label = $rowFormat['label'];
                            $label_arr = explode(" | ", $label);

                            if ($type > 0) {
                                if ($type == 1 OR $type == 3 OR $type == 4) {
                                    if (in_array($formatID, $includeChild_arr)) {
                                        foreach($dataChild_arr as $key => $value) {
                                            if ($formatID == $value['ID']) {
                                                if (!empty($value['content'])) {
                                                    $data .= '<td>'.$value['content'].'</td>';
                                                } else {
                                                    $rowColumnData = '';
                                                    if (!empty($form_data)) {
                                                        $form_data_arr = json_decode($form_data,true);

                                                        if (in_array($dataChild_ID, array_column($form_data_arr, 'row'))) {
                                                            $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($dataChild_ID, $formatID) {
                                                                if ($item['row'] === $dataChild_ID && $item['content']['column'] === $formatID) {
                                                                    return $item['content']['data'];
                                                                }
                                                                return $carry;
                                                            });
                                                        }
                                                    }

                                                    if (!empty($rowColumnData)) {
                                                        $pattern = '/<img[^>]+>/i';
                                                        if (preg_match($pattern, $rowColumnData)) {
                                                            // $pattern_src = '/(<img[^>]+)src=[\'"](?<src>[^\'"]+)/i';
                                                            // if (preg_match($pattern_src, $rowColumnData, $matches)) {
                                                            //     $old_src = $matches['src'];
                                                            //     $new_src = '@'. preg_replace('#^data:image/[^;]+;base64,#', '', $old_src);
                                                            //     $replacement = '${1}src="' . $new_src . '';
                                                            //     $rowColumnData = preg_replace($pattern_src, $replacement, $rowColumnData);
                                                            // }
                                                        }
                                                    }
                                                    $data .= '<td>';

                                                        if ($viewer == 1 AND !empty($rowColumnData)) { $data .= $rowColumnData; }
                                                        
                                                    $data .= '</td>';
                                                }
                                            }
                                        }
                                    } else {
                                        $data .= '<td></td>';
                                    }
                                } else if ($type == 2) {
                                    $radio_arr = explode(",", $label);

                                    if (in_array($formatID, $includeChild_arr)) {
                                        $rowColumnData = '';
                                        if (!empty($form_data)) {
                                            $form_data_arr = json_decode($form_data,true);

                                            if (in_array($dataChild_ID, array_column($form_data_arr, 'row'))) {
                                                $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($dataChild_ID, $formatID) {
                                                    if ($item['row'] === $dataChild_ID && $item['content']['column'] === $formatID) {
                                                        return $item['content']['data'];
                                                    }
                                                    return $carry;
                                                });
                                            }
                                        }

                                        foreach ($radio_arr as $r) {
                                            if ($rowColumnData === $r) {
                                                $data .= '<td style="text-align: center; font-weight: 700;">O</td>';
                                            } else {
                                                $data .= '<td style="text-align: center;">-</td>';
                                            }
                                        }
                                    } else {
                                        $data .= '<td colspan="'.count($radio_arr).'"></td>';
                                    }
                                }
                            }
                        }
                    }

                $data .= '</tr>';

                $data .= ai_childView($dataChild_ID, $sheet_id, $type_arr, $label_arr, $viewer, $form_data);
            }
        }

        return $data;
    }

    $ID = $_GET['id'];
    $html = '';
    $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

    // Include autoloader 
    require_once 'dompdf/autoload.inc.php';
    
    // define("DOMPDF_ENABLE_REMOTE", false);
    // $_dompdf_show_warnings = true;
    // $_dompdf_debug = true;
    
    // Reference the Dompdf namespace 
    use Dompdf\Dompdf; 
    use Dompdf\Options;

    // Options
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('defaultFont', 'dejavusans');
    // $options->set('dpi','120');
    $options->set('enable_html5_parser',true);
     
    // Instantiate and use the dompdf class 
    $dompdf = new Dompdf($options);

    // $tmp = sys_get_temp_dir();
    // $dompdf = new Dompdf([
    //     'logOutputFile' => '',
    //     // authorize DomPdf to download fonts and other Internet assets
    //     'isRemoteEnabled' => true,
    //     // all directories must exist and not end with /
    //     'fontDir' => $tmp,
    //     'fontCache' => $tmp,
    //     'tempDir' => $tmp,
    //     'chroot' => $tmp,
    // ]);

    // $dompdf->set_option('defaultMediaType', 'all');
    // $dompdf->set_option('isFontSubsettingEnabled', true);
    
    $selectData = mysqli_query( $conn,"SELECT * FROM tbl_ia_form WHERE deleted = 0 AND ID = $ID" );
    if ( mysqli_num_rows($selectData) > 0 ) {
        $rowForm = mysqli_fetch_array($selectData);
        $form_organization = $rowForm['organization'];
        $form_audit_type = $rowForm['audit_type'];
        $form_inspected_by = $rowForm['inspected_by'];
        $form_auditee = $rowForm['auditee'];
        $form_verified_by = $rowForm['verified_by'];
        $form_audit_scope = $rowForm['audit_scope'];
        $form_file = $rowForm['file'];
        $form_data = $rowForm['data'];
        $form_data_score = $rowForm['data_score'];
        $form_label = $rowForm['label'];
        $form_description = $rowForm['description'];

        $form_date_start = $rowForm['date_start'];
        $form_date_start = new DateTime($form_date_start);
        $form_date_start = $form_date_start->format('M d, Y');
        
        $form_date_end = $rowForm['date_end'];
        $form_date_end = new DateTime($form_date_end);
        $form_date_end = $form_date_end->format('M d, Y');
        
        
        $formScoreTitle = 'Non-Conformance';
        $formScoreMeter = 0;
        $form_preliminary_audit = $rowForm['preliminary_audit'];
        $form_final_audit = $rowForm['final_audit'];
        if ($form_preliminary_audit > 0) { $formScoreMeter = $form_preliminary_audit; }
        if ($form_final_audit > 0) { $formScoreMeter = $form_final_audit; }
        if ($formScoreMeter == 100) {
            $formScoreTitle = 'Conformance';
        }
        
        $form_user_id = $rowForm['user_id'];
        $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE users_entities=$form_user_id" );
		if ( mysqli_num_rows($selectEnterprise) > 0 ) {
		    $rowEnterprise = mysqli_fetch_array($selectEnterprise);
		    $enterprise_logo = $rowEnterprise['BrandLogos'];
		}

        $form_ia_id = $rowForm['ia_id'];
        $selectFormIA = mysqli_query( $conn,"SELECT * FROM tbl_ia WHERE deleted = 0 AND ID = $form_ia_id" );
        if ( mysqli_num_rows($selectFormIA) > 0 ) {
            $rowFormIA = mysqli_fetch_array($selectFormIA);
            $form_ia_title = $rowFormIA['title'];
            $form_ia_description = $rowFormIA['description'];
            $ia_sheet_id = $rowFormIA['sheet_id'];
 

            // <img src="https://interlinkiq.com/assets/img/interlinkiq%20v3.png" height="50" /><br>
            $html .= '<html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <style>
                        * {
                            font-size: 12px;
                            font-family: "dejavusans", sans-serif;
                        }
                        @page cover {
                            size: A4 portrait;
                        }
                        .coverPage {
                            page: cover;
                            page-break-after: always;
                        }
                    </style>
                </head>
                <body>
                    <p style="text-align: center;">';
                    
                        if (!empty($form_file)) {
                            $html .= '<img src="'.rawurlencode($form_file).'" height="50" /><br>';
                        } else {
                            $html .= '<img src="'.$base_url.'/companyDetailsFolder/'.rawurlencode($enterprise_logo).'" height="50" /><br>';
                        }
                    
                        $html .= '<b>'.stripcslashes($form_ia_title).'</b><br>
                        '.stripcslashes($form_ia_description).'
                    </p>
                    <table class="coverPage" cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%">
                        <tr>
                            <td style="background-color: #e1e5ec;">Organization</td>
                            <td>'.stripcslashes($form_organization).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Audit Type</td>
                            <td>'.stripcslashes($form_audit_type).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Inspected By</td>
                            <td>'.stripcslashes($form_inspected_by).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Auditee</td>
                            <td>'.stripcslashes($form_auditee).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Verified By</td>
                            <td>'.stripcslashes($form_verified_by).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Date Start</td>
                            <td>'.stripcslashes($form_date_start).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Date End</td>
                            <td>'.stripcslashes($form_date_end).'</td>
                        </tr>

                        <tr>
                            <td style="background-color: #e1e5ec;">Operation</td>
                            <td>'.stripcslashes($rowForm['operation']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Shipper</td>
                            <td>'.stripcslashes($rowForm['shipper']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Operation Type</td>
                            <td>'.stripcslashes($rowForm['operation_type']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Audit Executive Summary</td>
                            <td>'.stripcslashes($rowForm['audit_ex']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Addendum(s) included in the audit</td>
                            <td>'.stripcslashes($rowForm['addendum']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Product(s) observed during audit</td>
                            <td>'.stripcslashes($rowForm['product_observed']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Similar product(s)/process(es) not observed</td>
                            <td>'.stripcslashes($rowForm['similar_product']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Product(s) applied for but not observed</td>
                            <td>'.stripcslashes($rowForm['product_applied']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Auditor</td>
                            <td>'.stripcslashes($rowForm['auditor']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Preliminary Audit Score</td>
                            <td>'.stripcslashes($rowForm['preliminary_audit']).'%</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Final Audit Score</td>
                            <td>'.stripcslashes($rowForm['final_audit']).'%</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Certificate Valid From</td>
                            <td>'.stripcslashes($rowForm['cert_valid']).'</td>
                        </tr>

                        <tr>
                            <td style="background-color: #e1e5ec;">Date Documentation Review Started</td>
                            <td>'.stripcslashes($rowForm['date_review_started']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Date Documentation Review Finished</td>
                            <td>'.stripcslashes($rowForm['date_review_finished']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Total Amount of Time on the Documentation Review</td>
                            <td>'.stripcslashes($rowForm['total_time_review']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Date Visual Inspection Stared</td>
                            <td>'.stripcslashes($rowForm['date_inspection_started']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Date Visual Inspection Finished</td>
                            <td>'.stripcslashes($rowForm['date_inspection_finished']).'</td>
                        </tr>
                        <tr>
                            <td style="background-color: #e1e5ec;">Total Amount of Time on Visual Inspection</td>
                            <td>'.stripcslashes($rowForm['total_time_inspection']).'</td>
                        </tr>

                        <tr>
                            <td style="background-color: #e1e5ec;">Scope</td>
                            <td>'.stripcslashes($form_audit_scope).'</td>
                        </tr>';

                        if (!empty($form_label)) {
                            $form_label_arr = explode(' | ', $form_label);
                            $form_description_arr = explode(' | ', $form_description);
                            foreach($form_label_arr as $key => $value) {
                                $html .= '<tr>
                                    <td style="background-color: #e1e5ec;">'.$value.'</td>
                                    <td>'.stripcslashes($form_description_arr[$key]).'</td>
                                </tr>';
                            }
                        }

                        $score_setting_result = $rowForm['preliminary_audit'];
                        if ($rowForm['final_audit'] > 0) { $score_setting_result = $rowForm['final_audit']; }

                        if ($rowForm['score_type'] == 1) {
                            $html .= '<tr>
                                <td style="background-color: #e1e5ec;">Score Set: Customize</td>
                                <td>';

                                    $form_score_data = array();
                                    if (!empty($rowForm['score_data'])) {
                                        $form_score_data = json_decode($rowForm['score_data'],true);
                                    }

                                    $array_data = array();
                                    foreach ($form_score_data as $key => $value) {
                                        $output = array(
                                            'score_label' => $value['score_label'],
                                            'score_rate' => $value['score_rate'],
                                            'score_color' => $value['score_color'],
                                        );
                                        array_push($array_data, $output);
                                    }

                                    $ranges = [];

                                    // sort data result
                                    usort($array_data, function($a, $b) {
                                        return $a['score_rate'] - $b['score_rate'];
                                    });

                                    // convert into json
                                    for ($i=0; $i < count($array_data); $i++) { 
                                        $lo = $i == 0 ? 0 : $array_data[$i - 1]['score_rate'] + 1;
                                        $hi = $array_data[$i]['score_rate'];
                                        $color = $array_data[$i]['score_color'];
                                        $label = $array_data[$i]['score_label'];

                                        $ranges[] = [
                                            'label' => $label,
                                            'color' => $color,
                                            'lo' => $lo,
                                            'hi' => $hi
                                        ];
                                    }

                                    // echo (json_encode($array_data));
                                    foreach ($ranges as $item) {
                                        if ($score_setting_result >= $item['lo'] && $score_setting_result <= $item['hi']) {
                                            $html .= '<b>'.$item['label'] .' ('.$score_setting_result.'%)</b>';
                                        };
                                    }

                                $html .= '</td>
                            </tr>';
                        } else {
                            $html .= '<tr>
                                <td style="background-color: #e1e5ec;">Score Set: Default (Non-Conformance / Conformance)</td>
                                <td>
                                    <table cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%">
                                        <tr>
                                            <th style="text-align: center;">Conformance</th>
                                            <th style="text-align: center;">Non-Conformance</th>
                                        </tr>
                                        <tr>';

                                            if (!empty($rowForm['score_result'])) {
                                                $score_result_arr = explode(' | ', $rowForm['score_result']);
                                                $html .= '<td style="text-align: center;">'.$score_result_arr[0].'</td>';
                                                $html .= '<td style="text-align: center;">'.$score_result_arr[1].'</td>';
                                            } else {
                                                $html .= '<td style="text-align: center;">0</td>
                                                <td style="text-align: center;">0</td>';
                                            }
                                            
                                        $html .= '</tr>
                                    </table>
                                </td>
                            </tr>';
                        }

                    $html .= '</table><br>';

                    // $dompdf->load_html($html);
                    // $dompdf->render();
                    // file_put_contents($dompdf->output(), 'pdf1.pdf');
                    // unset($dompdf);


                    // $dompdf = new DOMPDF();
                    // $dompdf->set_paper('A4', 'landscape');

                    // $pdf->writeHTML($html);
                    // $pdf->lastPage();


                    // $pdf->AddPage('L');
                    $html .= '<table cellpadding="7" cellspacing="0" border="1" nobr="true">';

                        if (!empty($ia_sheet_id)) {
                            $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
                            foreach($ia_sheet_id_arr as $sheet_id) {

                                $selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
                                if ( mysqli_num_rows($selectSheet) > 0 ) {
                                    $rowSheet = mysqli_fetch_array($selectSheet);
                                    $sheet_name = $rowSheet['name'];
                                }

                                $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
                                if ( mysqli_num_rows($selectFormat) > 0 ) {
                                    $format_count = 0;
                                    $format_header = '';
                                    while($rowFormat = mysqli_fetch_array($selectFormat)) {
                                        if ($rowFormat['type'] > 0) {
                                            if ($rowFormat['type'] == 1 OR $rowFormat['type'] == 3 OR $rowFormat['type'] == 4) {
                                                $format_header .= '<td><b>'.$rowFormat['label'].'</b></td>';
                                                $format_count++;
                                            } else if ($rowFormat['type'] == 2) {
                                                $radio_arr = explode(",", $rowFormat['label']);
                                                foreach ($radio_arr as $r) {
                                                    $format_header .= '<td style="text-align: center;"><b>'.$r.'</b></td>';
                                                    $format_count++;
                                                }
                                            }
                                        }
                                    }
                                }
                                $html .= '<tr style="background-color: #F9E491;" nobr="true">
                                    <td colspan="'.$format_count.'" style="text-align: center;"><b>'.$sheet_name.'</b></td>
                                </tr>
                                <tr style="background-color: #E1E5EC;">'.$format_header.' </tr>';

                                // $selectDataRow = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = 0 AND deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
                                // $selectDataRow = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = 0 AND deleted = 0 AND LENGTH(data) > 0 AND sheet_id = $sheet_id ORDER BY order_id ASC, ID ASC" );
                                $selectDataRow = mysqli_query( $conn,"WITH RECURSIVE cte (rowID, rowOrder, rowParent, rowInclude, rowData) AS
                                    (
                                        SELECT
                                        t1.ID AS rowID,
                                        t1.order_id AS rowOrder,
                                        t1.parent_id AS rowParent,
                                        t1.include AS rowInclude,
                                        t1.data AS rowData
                                        FROM tbl_ia_data AS t1
                                        WHERE t1.parent_id = 0 
                                        AND t1.deleted = 0 
                                        AND LENGTH(t1.data) > 0 
                                        AND t1.sheet_id = $sheet_id

                                        UNION ALL

                                        SELECT
                                        t2.ID AS rowID,
                                        t2.order_id AS rowOrder,
                                        t2.parent_id AS rowParent,
                                        t2.include AS rowInclude,
                                        t2.data AS rowData
                                        FROM tbl_ia_data AS t2
                                        JOIN cte ON cte.rowID = t2.parent_id
                                        WHERE t2.deleted = 0 
                                        AND LENGTH(t2.data) > 0 
                                        AND t2.sheet_id = $sheet_id
                                    )
                                    SELECT 
                                    rowID, rowOrder, rowParent, rowInclude, rowData
                                    FROM cte
                                    ORDER BY rowOrder ASC, rowID ASC" );
                                if ( mysqli_num_rows($selectDataRow) > 0 ) {
                                    while($rowData = mysqli_fetch_array($selectDataRow)) {
                                        $data_ID = $rowData['rowID'];

                                        $include_arr = array();
                                        if ($rowData['rowInclude'] != NULL) { $include_arr = explode(" | ", $rowData['rowInclude']); }

                                        $data_arr = json_decode($rowData['rowData'],true);

                                        $html .= '<tr id="tr_'.$data_ID.'">';

                                            $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
                                            if ( mysqli_num_rows($selectFormat) > 0 ) {
                                                while($rowFormat = mysqli_fetch_array($selectFormat)) {
                                                    $formatID = $rowFormat['ID'];

                                                    $type = $rowFormat['type'];
                                                    $type_arr = explode(" | ", $type);

                                                    $label = $rowFormat['label'];
                                                    $label_arr = explode(" | ", $label);

                                                    if ($type > 0) {
                                                        if ($type == 1 OR $type == 3 OR $type == 4) {
                                                            if (in_array($formatID, $include_arr)) {
                                                                foreach($data_arr as $key => $value) {
                                                                    if ($formatID == $value['ID']) {
                                                                        if (!empty($value['content'])) {
                                                                            $html .= '<td>'.$value['content'].'</td>';
                                                                        } else {
                                                                            $rowColumnData = '';
                                                                            if (!empty($form_data)) {
                                                                                $form_data_arr = json_decode($form_data,true);

                                                                                if (in_array($data_ID, array_column($form_data_arr, 'row'))) {
                                                                                    $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($data_ID, $formatID) {
                                                                                        if ($item['row'] === $data_ID && $item['content']['column'] === $formatID) {
                                                                                            return $item['content']['data'];
                                                                                        }
                                                                                        return $carry;
                                                                                    });
                                                                                }
                                                                            }

                                                                            if (!empty($rowColumnData)) {
                                                                                $pattern = '/<img[^>]+>/i';
                                                                                if (preg_match($pattern, $rowColumnData)) {
                                                                                    // $pattern_src = '/(<img[^>]+)src=[\'"](?<src>[^\'"]+)/i';
                                                                                    // if (preg_match($pattern_src, $rowColumnData, $matches)) {
                                                                                    //     $old_src = $matches['src'];
                                                                                    //     $new_src = '@'. preg_replace('#^data:image/[^;]+;base64,#', '', $old_src);
                                                                                    //     $replacement = '${1}src="' . $new_src . '';
                                                                                    //     $rowColumnData = preg_replace($pattern_src, $replacement, $rowColumnData);
                                                                                    // }
                                                                                }
                                                                            }
                                                                            $html .= '<td>';

                                                                                if (!empty($rowColumnData)) { $html .= $rowColumnData; }
                                                                                
                                                                            $html .= '</td>';
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                $html .= '<td></td>';
                                                            }
                                                        } else if ($type == 2) {
                                                            $radio_arr = explode(",", $label);

                                                            if (in_array($formatID, $include_arr)) {
                                                                $rowColumnData = '';
                                                                if (!empty($form_data)) {
                                                                    $form_data_arr = json_decode($form_data,true);

                                                                    if (in_array($data_ID, array_column($form_data_arr, 'row'))) {
                                                                        $rowColumnData = array_reduce($form_data_arr, function ($carry, $item) use ($data_ID, $formatID) {
                                                                            if ($item['row'] === $data_ID && $item['content']['column'] === $formatID) {
                                                                                return $item['content']['data'];
                                                                            }
                                                                            return $carry;
                                                                        });
                                                                    }
                                                                }

                                                                foreach ($radio_arr as $r) {
                                                                    if ($rowColumnData === $r) {
                                                                        $html .= '<td style="text-align: center; font-weight: 700;">O</td>';
                                                                    } else {
                                                                        $html .= '<td style="text-align: center;">-</td>';
                                                                    }
                                                                }
                                                            } else {
                                                                $html .= '<td colspan="'.count($radio_arr).'"></td>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        $html .= '</tr>';

                                        // $html .= ai_childView($data_ID, $sheet_id, $type_arr, $label_arr, 1, $form_data);
                                    }
                                }
                            }
                        }

                    $html .= '</table>
                </body>
            </html>';

        }
    }

    // Load HTML content 
    $dompdf->loadHtml($html, 'UTF-8'); 

    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF 
    $dompdf->render();

    // Pagination
    $canvas = $dompdf->getCanvas();
    $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        $text = "Page $pageNumber of $pageCount";
        $font = $fontMetrics->getFont('dejavusans');
        $pageWidth = $canvas->get_width();
        $pageHeight = $canvas->get_height();
        $size = 8;
        $width = $fontMetrics->getTextWidth($text, $font, $size);
        $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text, $font, $size);
    });

    // Output the generated PDF to Browser 
    // $dompdf->stream();
    $dompdf->stream($form_ia_title.'-'.date('Ymd'), array("Attachment" => 0));
?>