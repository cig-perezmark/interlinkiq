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

    $selectData = mysqli_query( $conn,"SELECT 
        f.*,
        i.title AS i_title,
        i.sheet_id AS i_sheet_id,
        s.timestamp_id AS s_timestamp_id
        FROM tbl_ia_form AS f

        LEFT JOIN (
            SELECT
            *
            FROM tbl_ia
            WHERE deleted = 0
        ) AS i
        ON i.ID = f.ia_id

        INNER JOIN (
            SELECT
            *
            FROM tbl_ia_sheet
            WHERE deleted = 0
            AND LENGTH(timestamp_id) > 0
        ) AS s
        ON FIND_IN_SET(s.ID, REPLACE(REPLACE(i.sheet_id, ' ', ''), '|',','  )  ) > 0

        WHERE f.deleted = 0 
        AND f.ID = $ID

        GROUP BY f.ID" );
    if ( mysqli_num_rows($selectData) > 0 ) {
        $rowForm = mysqli_fetch_array($selectData);
        $form_data = $rowForm['data'];
        $ia_sheet_id = $rowForm['i_sheet_id'];
        $s_timestamp_id = $rowForm['s_timestamp_id'];

        $form_date_start = $rowForm['date_start'];
        $form_date_start = new DateTime($form_date_start);
        $form_date_start = $form_date_start->format('M d, Y');
        
        $form_date_end = $rowForm['date_end'];
        $form_date_end = new DateTime($form_date_end);
        $form_date_end = $form_date_end->format('M d, Y');
        
        $form_user_id = $rowForm['user_id'];
        $selectEnterprise = mysqli_query( $conn,"SELECT * FROM tblEnterpiseDetails WHERE users_entities=$form_user_id" );
		if ( mysqli_num_rows($selectEnterprise) > 0 ) {
		    $rowEnterprise = mysqli_fetch_array($selectEnterprise);
		    $enterprise_logo = $rowEnterprise['BrandLogos'];
		}

        $type_arr = array();
        $label_arr = array();
        $label_name_arr = array();
        $sub_header = '';
        $colspan = 0;
        $selectFormat = mysqli_query( $conn,"SELECT * FROM tbl_ia_format WHERE deleted = 0 AND timestamp_id = $s_timestamp_id ORDER BY order_id" );
        if ( mysqli_num_rows($selectFormat) > 0 ) {
            while($rowFormat = mysqli_fetch_array($selectFormat)) {
                if ($rowFormat['type'] > 0) {
                    if ($rowFormat['type'] == 1 OR $rowFormat['type'] == 3 OR $rowFormat['type'] == 4) {
                        $sub_header .= '<td style="text-align: center;"><b>'.$rowFormat['label'].'</b></td>';
                        $colspan++;
                    } else if ($rowFormat['type'] == 2) {
                        $radio_arr = explode(",", $rowFormat['label']);
                        foreach ($radio_arr as $r) {
                            $sub_header .= '<td style="text-align: center;"><b>'.$r.'</b></td>';
                            $colspan++;
                        }
                    }
                    
                    array_push($type_arr, $rowFormat['type']);
                    array_push($label_arr, $rowFormat['ID']);
                    array_push($label_name_arr, $rowFormat['label']);
                }
            }
        }
        $type = implode(' | ', $type_arr);
        $label = implode(' | ', $label_arr);
        $label_name = implode(' | ', $label_name_arr);

        $html .= '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>PDF</title>
                <style>
                    * {
                        font-size: 12px;
                        font-family: "dejavusans", sans-serif;
                    }
                    @page {
                        size: landscape;
                    }
                    @page cover {
                        size: portrait;
                    }
                    .coverPage {
                        page: cover;
                        page-break-after: always;
                    }
                </style>
            </head>
            <body>
                <p style="text-align: center;">';
                
                    if (!empty($rowForm['file'])) {
                        $html .= '<img src="'.rawurlencode($rowForm['file']).'" height="50" /><br>';
                    } else {
                        $html .= '<img src="'.$base_url.'/companyDetailsFolder/'.rawurlencode($enterprise_logo).'" height="50" /><br>';
                    }
                
                    $html .= '<b>'.stripcslashes($rowForm['i_title']).'</b><br>
                    '.stripcslashes($rowForm['organization']).'
                </p>
                <table style="page: cover; page-break-after: always;" cellpadding="7" cellspacing="0" border="1" nobr="true" width="100%" >
                    <tr>
                        <td style="background-color: #e1e5ec;">Organization</td>
                        <td>'.stripcslashes($rowForm['organization']).'</td>
                    </tr>
                    <tr>
                        <td style="background-color: #e1e5ec;">Audit Type</td>
                        <td>'.stripcslashes($rowForm['audit_type']).'</td>
                    </tr>
                    <tr>
                        <td style="background-color: #e1e5ec;">Inspected By</td>
                        <td>'.stripcslashes($rowForm['inspected_by']).'</td>
                    </tr>
                    <tr>
                        <td style="background-color: #e1e5ec;">Auditee</td>
                        <td>'.stripcslashes($rowForm['auditee']).'</td>
                    </tr>
                    <tr>
                        <td style="background-color: #e1e5ec;">Verified By</td>
                        <td>'.stripcslashes($rowForm['verified_by']).'</td>
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
                        <td>'.stripcslashes($rowForm['audit_scope']).'</td>
                    </tr>';

                    if (!empty($rowForm['label'])) {
                        $form_label_arr = explode(' | ', $rowForm['label']);
                        $form_description_arr = explode(' | ', $rowForm['description']);
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

                $html .= '</table><br>
                <table cellpadding="7" cellspacing="0" border="1" nobr="true" style="width: 100%;">';

                    if (!empty($ia_sheet_id)) {
                        $ia_sheet_id_arr = explode(' | ', $ia_sheet_id);
                        foreach($ia_sheet_id_arr as $sheet_id) {

                            $selectSheet = mysqli_query( $conn,"SELECT * FROM tbl_ia_sheet WHERE deleted = 0 AND ID = $sheet_id" );
                            if ( mysqli_num_rows($selectSheet) > 0 ) {
                                $rowSheet = mysqli_fetch_array($selectSheet);
                                $sheet_name = $rowSheet['name'];
                            }

                            $html .= '<tr style="background-color: #F9E491;" nobr="true">
                                <td colspan="'.$colspan.'" style="text-align: center;"><b>'.$sheet_name.'</b></td>
                            </tr>
                            <tr style="background-color: #E1E5EC;">'.$sub_header.'</tr>';

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
                                        $type_arr = explode(" | ", $type);
                                        $label_arr = explode(" | ", $label);
                                        $label_name_arr = explode(" | ", $label_name);
                                        
                                        $i = 0;
                                        foreach ($type_arr as $value) {
                                            if ($value > 0) {
                                                if ($value == 1 OR $value == 3 OR $value == 4) {
                                                    if (in_array($label_arr[$i], $include_arr)) {
                                                        $html .= '<td>';
                                                            foreach($data_arr as $key => $val) {
                                                                if ($label_arr[$i] == $val['ID']) {
                                                                    if (!empty($val['content'])) {
                                                                        $html .= $val['content'];
                                                                    } else {
                                                                        $formatID = $label_arr[$i];
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

                                                                            // Reformat the result with images
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

                                                                            $html .= $rowColumnData;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        $html .= '</td>';
                                                    } else {
                                                        $html .= '<td></td>';
                                                    }
                                                } else if ($value == 2) {
                                                    $radio_arr = explode(",", $label_name_arr[$i]);

                                                    if (in_array($label_arr[$i], $include_arr)) {
                                                        $formatID = $label_arr[$i];
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
                                                                $html .= '<td style="text-align: center; ">-</td>';
                                                            }
                                                        }
                                                    } else {
                                                        $html .= '<td colspan="'.count($radio_arr).'"></td>';
                                                    }
                                                }
                                                $i++;
                                            }
                                        }
                                    $html .= '</tr>';
                                }
                            }
                        }
                    }

                $html .= '</table>
            </body>
        </html>';
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
    $dompdf->stream('PDF -'.date('Ymd'), array("Attachment" => 0));
?>