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
    $empty_signature = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAABGJJREFUeF7t1AEJAAAMAsHZv/RyPNwSyDncOQIECEQEFskpJgECBM5geQICBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAAYPlBwgQyAgYrExVghIgYLD8AAECGQGDlalKUAIEDJYfIEAgI2CwMlUJSoCAwfIDBAhkBAxWpipBCRAwWH6AAIGMgMHKVCUoAQIGyw8QIJARMFiZqgQlQMBg+QECBDICBitTlaAECBgsP0CAQEbAYGWqEpQAgQdWMQCX4yW9owAAAABJRU5ErkJggg==';
    

    $id = $_GET['id'];
    if (!empty($_COOKIE['switchAccount'])) {
        $portal_user = $_COOKIE['ID'];
        $user_id = $_COOKIE['switchAccount'];
    }
    else {
        $portal_user = $_COOKIE['ID'];
        $user_id = employerID($portal_user);
    }

    $result = mysqli_query( $conn,"SELECT * FROM tbl_ffva_katva WHERE ID = $id" );
    if ( mysqli_num_rows($result) > 0 ) {
        $row = mysqli_fetch_array($result);
        $product = $row["product"];
        $facility = $row["facility"];
        $address = $row["address"];

        $prepared_by = $row["prepared_by"];
        $prepared_signature = $row["prepared_signature"];
        $prepared_date = $row["prepared_date"];

        $reviewed_by = $row["reviewed_by"];
        $reviewed_signature = $row["reviewed_signature"];
        $reviewed_date = $row["reviewed_date"];

        $approved_by = $row["approved_by"];
        $approved_signature = $row["approved_signature"];
        $approved_date = $row["approved_date"];
    }


    

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
    // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('InterlinkIQ.com');
    $pdf->SetTitle('InterlinkIQ.com');
    $pdf->SetSubject('InterlinkIQ.com');
    $pdf->SetKeywords('InterlinkIQ.com');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // // set header and footer fonts
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setHeaderMargin(0);
    // $pdf->setMargins(0, 0, 0, true);
    // $pdf->setPageOrientation('', false, 0);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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


    $html = '
    <p style="text-align: center;"><b>Vulnerability Assessment for Food Fraud - Key Activity Types</b></p>
    
    <table cellpadding="7" cellspacing="0" border="1">
        <tr>
            <td><b>Product</b></td>
            <td>'.$product.'</td>
        </tr>
        <tr>
            <td><b>Facility Name</b></td>
            <td>'.$facility.'</td>
        </tr>
        <tr>
            <td><b>Address</b></td>
            <td>'.$address.'</td>
        </tr>
    </table><p></p>

    <table cellpadding="7" cellspacing="0" border="1">
        <tr>
            <td><b>Process Step</b></td>
            <td><b>Process Description</b></td>
            <td><b>Vulnerability Assessment Method</b></td>
            <td><b>Explanation</b></td>
            <td><b>Actionable Process Step</b></td>
            <td><b>Mitigation Strategies</b></td>
        </tr>';
        if (!empty($row["step"])) {
            $step = explode(' | ', $row["step"]);
            $description = explode(' | ', $row["description"]);
            $vulnerability_id = explode(' | ', $row["vulnerability_id"]);
            $vulnerability_text = explode(' | ', $row["vulnerability_text"]);
            $explanation_id = explode(' | ', $row["explanation_id"]);
            $explanation_option = explode(' | ', $row["explanation_option"]);
            $explanation_comment = explode(' | ', $row["explanation_comment"]);
            $actionable = explode(' | ', $row["actionable"]);
            $mitigation = explode(' | ', $row["mitigation"]);

            $index = 0;
            foreach ($step as $value) {

                $html .= '<tr class="tr_'.$index.'">
                    <td>'.$value.'</td>
                    <td>'.$description[$index].'</td>
                    <td>';
                        if ($vulnerability_id[$index] == 0) {
                            $html .= 'Key Activity Types';
                        } else {
                            $html .=$vulnerability_text[$index];
                        }
                    $html .= '</td>
                    <td>';

                        if ($explanation_id[$index] == 0) {
                         $html .= 'No';
                        } else {
                         if ($explanation_option[$index] == 1) { $html .= 'Bulk Liquid Receiving and Loading'; }
                         else if ($explanation_option[$index] == 2) { $html .= 'Liquid Storage and Handling'; }
                         else if ($explanation_option[$index] == 3) { $html .= 'Secondary Ingredient Handling'; }
                         else if ($explanation_option[$index] == 4) { $html .= 'Mixing and Similar Activities'; }

                            if (!empty($explanation_comment[$index])) {
                                $html .= '<br>- '.$explanation_comment[$index];
                            }
                        }
                    $html .= '</td>

                    <td>'.$actionable[$index].'</td>
                    <td>'.$mitigation[$index].'</td>
                </tr>';
                $index++;
            }
        }
    $html .= '</table><p></p>

    <table cellpadding="7" cellspacing="0" border="1">
        <tr style="vertical-align: middle;">
            <td style="text-align: center;">';

                if (!empty($prepared_signature)) {
                    $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $prepared_signature) . '" style="bloack; height: 50px; border: 0;" />';
                }

                $html .= '<p>Arnel Ryan - '.$prepared_date.'</p>
            </td>
            <td style="text-align: center;">';

                if (!empty($reviewed_signature)) {
                    $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $reviewed_signature) . '" style="bloack; height: 50px; border: 0;" />';
                } else {
                    $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $empty_signature) . '" style="bloack; height: 50px; border: 0;" />';
                }

                if (!empty($reviewed_by)) {
                    $selectEmployee = mysqli_query( $conn,"SELECT * from tbl_hr_employee WHERE ID = $reviewed_by" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        $rowEmployee = mysqli_fetch_array($selectEmployee);
                        $employee_id = $rowEmployee['ID'];
                        $employee_name = $rowEmployee['first_name'] .' '. $rowEmployee['last_name'];
                        
                        $html .= '<p>'.$employee_name .' - '. $reviewed_date.'</p>';
                    }
                }

            $html .= '</td>
            <td style="text-align: center;">';

                if (!empty($approved_signature)) {
                    $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $approved_signature) . '" style="bloack; height: 50px; border: 0;" />';
                } else {
                    $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $empty_signature) . '" style="bloack; height: 50px; border: 0;" />';
                }

                if (!empty($approved_by)) {
                    $selectEmployee = mysqli_query( $conn,"SELECT * from tbl_hr_employee WHERE ID = $approved_by" );
                    if ( mysqli_num_rows($selectEmployee) > 0 ) {
                        $rowEmployee = mysqli_fetch_array($selectEmployee);
                        $employee_id = $rowEmployee['ID'];
                        $employee_name = $rowEmployee['first_name'] .' '. $rowEmployee['last_name'];
                        
                        $html .= '<p>'.$employee_name .' - '. $approved_date.'</p>';
                    }
                }

            $html .= '</td>
        </tr>
        <tr>
            <td style="text-align: center;"><b>Prepared By</b></td>
            <td style="text-align: center;"><b>Reviewed By</b></td>
            <td style="text-align: center;"><b>Approved By</b></td>
        </tr>
    </table><p></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output($product.'-'.date('Ymd').'.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+
