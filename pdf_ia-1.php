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
                                                            $pattern_src = '/(<img[^>]+)src=[\'"](?<src>[^\'"]+)/i';
                                                            if (preg_match($pattern_src, $rowColumnData, $matches)) {
                                                                $old_src = $matches['src'];
                                                                $new_src = '@'. preg_replace('#^data:image/[^;]+;base64,#', '', $old_src);
                                                                $replacement = '${1}src="' . $new_src . '';
                                                                $rowColumnData = preg_replace($pattern_src, $replacement, $rowColumnData);
                                                            }
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
                                                $data .= '<td><span style="font-size: 15px;">✔</span></td>';
                                            } else {
                                                $data .= '<td>—</td>';
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

    //============================================================+
    // File name   : example_006.php
    // Begin       : 2008-03-04
    // Last Update : 2013-05-14
    //
    // Description : Example 006 for TCPDF class
    //               WriteHTML and RTL support
    //
    // Author: Nicola Asuni
    //
    // (c) Copyright:
    //               Nicola Asuni
    //               Tecnick.com LTD
    //               www.tecnick.com
    //               info@tecnick.com
    //============================================================+

    /**
     * Creates an example PDF TEST document using TCPDF
     * @package com.tecnick.tcpdf
     * @abstract TCPDF - Example: WriteHTML and RTL support
     * @author Nicola Asuni
     * @since 2008-03-04
     */

    // Include the main TCPDF library (search for installation path).
    require_once('TCPDF/tcpdf.php');

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('InterlinkIQ.com');
    $pdf->SetTitle('InterlinkIQ.com');
    $pdf->SetSubject('InterlinkIQ.com');
    $pdf->SetKeywords('InterlinkIQ.com');

    // set default header data
    // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // remove default header/footer
    $pdf->setPrintHeader(false);
    // $pdf->setPrintFooter(false);
    // $pdf->setHeaderMargin(0);
    // $pdf->setMargins(0, 0, 0, true);
    // $pdf->setPageOrientation('', false, 0);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 9);

    // add a page
    $pdf->AddPage();

    // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
    // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

    // create some HTML content

    // $img_base64_encoded = str_replace("image/;base64,", "", $img_base64_encoded);

    // // Image from data stream ('PHP rules')
    // $imgLogo = base64_decode($img_base64_encoded);

    // $imgLogo = setImageScale(7);
    // $imgLogo = Image('@'.$imgLogo);

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

            $html .= '<p style="text-align: center;">';
                
                if (!empty($form_file)) {
                    $html .= '<img src="@'.preg_replace('#^data:image/[^;]+;base64,#', '', $form_file).'" height="50" /><br>';
                } else {
                    $html .= '<img src="/companyDetailsFolder/'.$enterprise_logo.'" height="50" /><br>';
                }
		        
                $html .= '<b>'.stripcslashes($form_ia_title).'</b><br>
                '.stripcslashes($form_ia_description).'
            </p>
            <table cellpadding="7" cellspacing="0" border="1" nobr="false">
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
                    <td>'.stripcslashes($rowForm['preliminary_audit']).'</td>
                </tr>
                <tr>
                    <td style="background-color: #e1e5ec;">Final Audit Score</td>
                    <td>'.stripcslashes($rowForm['final_audit']).'</td>
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
                
            $html .= '</table>';

            $pdf->writeHTML($html);
            $pdf->lastPage();


            $pdf->AddPage('L');
            $html = '<table cellpadding="7" cellspacing="0" border="1" nobr="true">';

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
                                            $format_header .= '<td><b>'.$r.'</b></td>';
                                            $format_count++;
                                        }
                                    }
                                }
                            }
                        }
                        $html .= '<tr style="background-color: #F9E491;">
                            <td colspan="'.$format_count.'" style="text-align: center;"><b>'.$sheet_name.'</b></td>
                        </tr>
                        <tr style="background-color: #E1E5EC;">'.$format_header.' </tr>';

                        $selectDataRow = mysqli_query( $conn,"SELECT * FROM tbl_ia_data WHERE parent_id = 0 AND deleted = 0 AND sheet_id = $sheet_id ORDER BY order_id" );
                        if ( mysqli_num_rows($selectDataRow) > 0 ) {
                            while($rowData = mysqli_fetch_array($selectDataRow)) {
                                $data_ID = $rowData['ID'];

                                $include_arr = array();
                                if ($rowData['include'] != NULL) { $include_arr = explode(" | ", $rowData['include']); }

                                $data_arr = json_decode($rowData['data'],true);

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
                                                                            $pattern_src = '/(<img[^>]+)src=[\'"](?<src>[^\'"]+)/i';
                                                                            if (preg_match($pattern_src, $rowColumnData, $matches)) {
                                                                                $old_src = $matches['src'];
                                                                                $new_src = '@'. preg_replace('#^data:image/[^;]+;base64,#', '', $old_src);
                                                                                $replacement = '${1}src="' . $new_src . '';
                                                                                $rowColumnData = preg_replace($pattern_src, $replacement, $rowColumnData);
                                                                            }
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
                                                                $html .= '<td>✔</td>';
                                                            } else {
                                                                $html .= '<td>—</td>';
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

                                $html .= ai_childView($data_ID, $sheet_id, $type_arr, $label_arr, 1, $form_data);
                            }
                        }
                    }
                }

            $html .= '</table>';

        }
    }
    // output the HTML content
    // $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTML($html);

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    // $pdf->Output($row["code"].'-'.$row["company"].'-'.date('Ymd'), 'I');
    $pdf->Output($form_ia_title.'-'.date('Ymd').'.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+
