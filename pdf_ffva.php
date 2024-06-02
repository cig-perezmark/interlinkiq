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

    $id = $_GET['id'];
    $signed = $_GET['signed'] ?? 1;
    $result = mysqli_query( $conn,"SELECT * FROM tbl_ffva WHERE ID = $id" );
    if ( mysqli_num_rows($result) > 0 ) {
        $row = mysqli_fetch_array($result);
        $likelihood_type = $row["type"];
        
        $likelihood_answer = $row["likelihood_answer"];
        $likelihood_answer_arr = explode(', ', $likelihood_answer);

        $likelihood_comment = $row["likelihood_comment"];
        $likelihood_comment_arr = explode(' | ', $likelihood_comment);

        $likelihood_rate = $row["likelihood_rate"];
        $likelihood_rate_arr = explode(', ', $likelihood_rate);

        $likelihood_file = $row["likelihood_file"];
        $likelihood_file_arr = explode(' | ', $likelihood_file);

        $consequence_answer = $row["consequence_answer"];
        $consequence_answer_arr = explode(', ', $consequence_answer);

        $consequence_comment = $row["consequence_comment"];
        $consequence_comment_arr = explode(' | ', $consequence_comment);

        $consequence_file = $row["consequence_file"];
        $consequence_file_arr = explode(' | ', $consequence_file);

        $consequence_rate = $row["consequence_rate"];
        $consequence_rate_arr = explode(', ', $consequence_rate);

        $prepared_by = $row["prepared_by"];
        $prepared_signature = $row["prepared_signature"];
        $prepared_position = $row["prepared_position"];
        $prepared_date = $row["prepared_date"];
        $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $prepared_by" );
        if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            $rowEnterprise = mysqli_fetch_array($selectEnterprise);
            $enterp_name = $rowEnterprise['businessname'];
        } else {
            $enterp_name = "Consultare Inc. Group";
        }

 
        $reviewed_by = $row["reviewed_by"];
        $reviewed_by_ent = $row["reviewed_by"];
        if (!empty($reviewed_by_ent)) { $reviewed_by_ent = employerID($row["reviewed_by"]); }
        $reviewed_signature = $row["reviewed_signature"];
        $reviewed_position = $row["reviewed_position"];
        $reviewed_date = $row["reviewed_date"];
        $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = '".$reviewed_by_ent."'" );
        if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            $rowEnterprise = mysqli_fetch_array($selectEnterprise);
		    $reviewed_enterp_logo = $rowEnterprise['BrandLogos'];
            $reviewed_enterp_name = $rowEnterprise['businessname'];
        } else {
		    $reviewed_enterp_logo = "no_images.png";
            $reviewed_enterp_name = "";
        }

        $approved_by = $row["approved_by"];
        $approved_by_ent = $row["approved_by"];
        if (!empty($approved_by_ent)) { $approved_by_ent = employerID($row["approved_by"]); }
        $approved_signature = $row["approved_signature"];
        $approved_position = $row["approved_position"];
        $approved_date = $row["approved_date"];
        $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = '".$approved_by_ent."'" );
        if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            $rowEnterprise = mysqli_fetch_array($selectEnterprise);
            $approved_enterp_name = $rowEnterprise['businessname'];
        } else {
            $approved_enterp_name = "";
        }
    }


    // Likelihood
    $index = 0;
    $count = 0;
    $sum = 0;
    $total_likelihood = 0;
    $result_likelihood = 'Undefined';
    $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
    if ( mysqli_num_rows($selectLikelihood) > 0 ) {
        while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
            $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
            if (in_array($row["type"], $likelihood_type_arr)) {
                if (empty($likelihood_rate_arr[$index])) { $sum += 1; }
                else { $sum += $likelihood_rate_arr[$index]; }
                
                $index++;
                $count++;
            }
        }
    }

    if (!empty($row["likelihood_element_other"])) {
        $likelihood_element_other = explode(' | ', $row["likelihood_element_other"]);
        $likelihood_rate_other = explode(', ', $row["likelihood_rate_other"]);

        $index = 0;
        foreach ($likelihood_element_other as $value) {
            $sum += $likelihood_rate_other[$index];
            $index++;
            $count++;
        }
    }

    $total_likelihood = $sum / $count;
    if (round($total_likelihood) == 1) { $result_likelihood = "Very Unlikely"; }
    else if (round($total_likelihood) == 2) { $result_likelihood = "Unlikely"; }
    else if (round($total_likelihood) == 3) { $result_likelihood = "Fairly Likely"; }
    else if (round($total_likelihood) == 4) { $result_likelihood = "Likely"; }
    else if (round($total_likelihood) == 5) { $result_likelihood = "Very Likely or Certain"; }


    // Consequence
    $index = 0;
    $count = 0;
    $sum = 0;
    $total_consequence = 0;
    $result_consequence = 'Undefined';
    $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
    if ( mysqli_num_rows($selectConsequence) > 0 ) {
        while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
            $sum += $consequence_rate_arr[$index];
            $index++;
            $count++;
        }
    }

    if (!empty($row["consequence_element_other"])) {
        $consequence_element_other = explode(' | ', $row["consequence_element_other"]);
        $consequence_rate_other = explode(', ', $row["consequence_rate_other"]);

        $index = 0;
        foreach ($consequence_element_other as $value) {
            $sum += $consequence_rate_other[$index];
            $index++;
            $count++;
        }
    }

    $total_consequence = $sum / $count;
    if (round($total_consequence) == 1) { $result_consequence = "Negligible"; }
    else if (round($total_consequence) == 2) { $result_consequence = "Minor"; }
    else if (round($total_consequence) == 3) { $result_consequence = "Moderate"; }
    else if (round($total_consequence) == 4) { $result_consequence = "Significant"; }
    else if (round($total_consequence) == 5) { $result_consequence = "Severe"; }


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

    if ($vulnerability == 1) { $vulnerability_result = "Low Risk"; }
    else if ($vulnerability == 2) { $vulnerability_result = "Medium Risk: Action is needed with occasional monitoring to mitigate the risk."; }
    else if ($vulnerability == 3) { $vulnerability_result = "High Risk: Urgent action is required and regular monitoring may be needed!"; }

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
    <p style="text-align: center;">
        <img src="companyDetailsFolder/'.$reviewed_enterp_logo.'" height="50" style="display: none;" /><br>';

        if ($likelihood_type == 1) { $html .= '<b>Vulnerability Assessment for Food Fraud - Supplier</b>'; }
        else { $html .= '<b>Vulnerability Assessment for Food Fraud - Ingredients</b>'; }
        
    $html .= '</p>
    <table cellpadding="7" cellspacing="0" border="1">';

        if ($likelihood_type == 1) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Supplier Company Name</b></td>
                <td colspan="2">'.htmlentities($row["company"]).'</td>
            </tr>
            <tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Contact Person</b></td>
                <td colspan="2">'.htmlentities($row["person"]).'</td>
            </tr>';
        } else if ($likelihood_type == 2) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Material Name</b></td>
                <td colspan="2">'.htmlentities($row["product"]).'</td>
            </tr>';
        }
        
        $html .= '<tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Likelihood of this material being affected by food fraud</b></td>
            <td colspan="2" class="likelihood_result">'.$result_likelihood.'</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Consequences of food fraud on this material</b></td>
            <td colspan="2" class="consequence_result">'.$result_consequence.'</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Vulnerability Risk Estimate</b></td>
            <td colspan="2" class="vulnerability_result">'.$vulnerability_result.'</td>
        </tr>
    </table>
    
    <p style="color: red;">Food safety warning: adulteration or substitution of any ingredient means a risk to food safety</p>
    
    <table id="tableMatrix" cellpadding="7" cellspacing="0" border="0">
        <tr style="background-color: #ddeaf6; text-align: center;">
            <td rowspan="7" style="background-color: #ddeaf6;"><h3>C<br>o<br>n<br>s<br>e<br>q<br>u<br>e<br>n<br>c<br>e<br>s</h3></td>
            <td colspan="6"><h3>Likelihood</h3></td>
        </tr>
        <tr align="center" valign="middle">
            <td></td>
            <td class="text-center" style="font-weight: bold;">Very<br>Unlikely</td>
            <td class="text-center" style="font-weight: bold;">Unlikely</td>
            <td class="text-center" style="font-weight: bold;">Fairly<br>Likely</td>
            <td class="text-center" style="font-weight: bold;">Likely</td>
            <td class="text-center" style="font-weight: bold;">Very<br>Likely/<br>Certain</td>
        </tr>
        <tr>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Negligible</td>
            <td class="text-center matrix-1-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-2" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-4" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Minor</td>
            <td class="text-center matrix-2-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-2" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-4" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Moderate</td>
            <td class="text-center matrix-3-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-2" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-4" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Significant</td>
            <td class="text-center matrix-4-1" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-2" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-3" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-4" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Severe</td>
            <td class="text-center matrix-5-1" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-5-2" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-5-3" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-5-4" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-5-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
    </table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #d8d8d8;">
        <tr>
            <td>
                <b>Key</b><br>
                Red Areas = high risk; urgent action is required and regular monitoring may be needed<br>
                Yellow Areas = medium risk: action is needed with occasional monitoring to mitigate the risk<br>
                Green Areas = low risk
            </td>
        </tr>
    </table>

    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1">
        <tr>
            <td colspan="2">Product or ingredient or raw material name</td>
            <td colspan="2" style="background-color: #ffd965;">'.htmlentities($row["product"]).'</td>
        </tr>
        <tr>
            <td colspan="2">Ingredient(s) or raw material(s) group</td>
            <td colspan="2" style="background-color: #92d050;">'.htmlentities($row["assessment"]).'</td>
        </tr>
    </table>
    
    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td style="text-align: center;"><b>Materials names and/or codes included in this assessment</b></td>
        </tr>
    </table>
    
    <p style="text-align: center;"><b>Legend</b></p>

    <table cellpadding="7" cellspacing="0" border="1">
        <tr style="background-color: #9cc2e5;">
            <td style="text-align: center;" colspan="5"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
        <tr style="background-color: yellow;">
            <td style="text-align: center;"><b>1 - Very Unlikely</b></td>
            <td style="text-align: center;"><b>2 - Unlikely</b></td>
            <td style="text-align: center;"><b>3 - Fairly Likely</b></td>
            <td style="text-align: center;"><b>4 - Likely</b></td>
            <td style="text-align: center;"><b>5 - Very Likely/Certain</b></td>
        </tr>
    </table>
    
    <p></p>

    <table cellpadding="7" cellspacing="0" border="1">
        <tr style="background-color: #fbe4d5;">
            <td style="text-align: center;" colspan="5"><b>Assessment of the consequences of food fraud</b></td>
        </tr>
        <tr style="background-color: yellow;">
            <td style="text-align: center;"><b>1 - Negligible</b></td>
            <td style="text-align: center;"><b>2 - Minor</b></td>
            <td style="text-align: center;"><b>3 - Moderate</b></td>
            <td style="text-align: center;"><b>4 - Significant</b></td>
            <td style="text-align: center;"><b>5 - Severe</b></td>
        </tr>
    </table>

    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td style="text-align: center;"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
    </table>
    <p></p>
    <table class="tableQuestionaire_1" cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td style="text-align: center;"><b>Element</b></td>
            <td style="text-align: center;"><b>Question</b></td>
            <td style="text-align: center;"><b>Answer</b></td>
            <td style="text-align: center;"><b>Comments</b></td>
            <td style="text-align: center;"><b>Rate</b></td>
        </tr>';
        
        $index = 0;
        $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood" );
        if ( mysqli_num_rows($selectLikelihood) > 0 ) {
            while($rowLikelihood = mysqli_fetch_array($selectLikelihood)) {
                $likelihood_type_arr = explode(', ', $rowLikelihood["type"]);
                if (in_array($row["type"], $likelihood_type_arr)) {
                    $likelihood_ID = $rowLikelihood["ID"];
                    $likelihood_element = $rowLikelihood["element"];
                    $likelihood_question = $rowLikelihood["question"];
                    $likelihood_very_unlikely = $rowLikelihood["very_unlikely"];
                    $likelihood_unlikely = $rowLikelihood["unlikely"];
                    $likelihood_fairly_likely = $rowLikelihood["fairly_likely"];
                    $likelihood_likely = $rowLikelihood["likely"];
                    $likelihood_very_likely = $rowLikelihood["very_likely"];

                    $ref_content = '';
                    $resultRef = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE type = 1 AND element = $likelihood_ID" );
                    if ( mysqli_num_rows($resultRef) > 0 ) {
                        $rowRef = mysqli_fetch_array($resultRef);
                        $ref_content = $rowRef["content"];
                    }

                    if (empty($likelihood_answer_arr[$index])) { $likelihood_answer_arr[$index] = 0; }
                    if (empty($likelihood_comment_arr[$index])) { $likelihood_comment_arr[$index] = ''; }
                    if (empty($likelihood_rate_arr[$index])) { $likelihood_rate_arr[$index] = 1; }

                    $html .= '<tr>
                        <td>'.$likelihood_element.'</td>
                        <td>'.$likelihood_question.'</td>
                        <td style="text-align: center;">';
                            if ($likelihood_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                        $html .= '</td>
                        <td>'.htmlspecialchars($likelihood_comment_arr[$index]).'</td>
                        <td>';
                            if ($likelihood_rate_arr[$index] == 1) {
                                $html .= '<b>Very Unlikely</b><br><i>'.htmlspecialchars($likelihood_very_unlikely).'</i>';
                            } else if ($likelihood_rate_arr[$index] == 2) {
                                $html .= '<b>Unlikely</b><br><i>'.htmlspecialchars($likelihood_unlikely).'</i>';
                            } else if ($likelihood_rate_arr[$index] == 3) {
                                $html .= '<b>Fairly Likely</b><br><i>'.htmlspecialchars($likelihood_fairly_likely).'</i>';
                            } else if ($likelihood_rate_arr[$index] == 4) {
                                $html .= '<b>Likely</b><br><i>'.htmlspecialchars($likelihood_likely).'</i>';
                            } else if ($likelihood_rate_arr[$index] == 5) {
                                $html .= '<b>Very Likely or Certain</b><br><i>'.htmlspecialchars($likelihood_very_likely).'</i>';
                            }
                            $html .= '<input type="hidden" class="likelihood_rate" name="likelihood_rate[]" value="'.$likelihood_rate_arr[$index].'" />
                        </td>
                    </tr>';

                    $index++;
                }
            }
        }

        if (!empty($row["likelihood_element_other"])) {
            $likelihood_element_other = explode(' | ', $row["likelihood_element_other"]);
            $likelihood_question_other = explode(' | ', $row["likelihood_question_other"]);
            $likelihood_answer_other = explode(', ', $row["likelihood_answer_other"]);
            $likelihood_comment_other = explode(' | ', $row["likelihood_comment_other"]);
            $likelihood_file_other = explode(' | ', $row["likelihood_file_other"]);
            $likelihood_rate_other = explode(', ', $row["likelihood_rate_other"]);

            $index = 0;
            foreach ($likelihood_element_other as $value) {

                $html .= '<tr>
                    <td>'.$value.'</td>
                    <td>'.$likelihood_question_other[$index].'</td>
                    <td style="text-align: center;">';
                        if ($likelihood_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td>'.$likelihood_comment_other[$index].'</td>
                    <td>';
                        if ($likelihood_rate_other[$index] == 1) {
                            $html .= '<b>Very Unlikely</b>';
                        } else if ($likelihood_rate_other[$index] == 2) {
                            $html .= '<b>Unlikely</b>';
                        } else if ($likelihood_rate_other[$index] == 3) {
                            $html .= '<b>Fairly Likely</b>';
                        } else if ($likelihood_rate_other[$index] == 4) {
                            $html .= '<b>Likely</b>';
                        } else if ($likelihood_rate_other[$index] == 5) {
                            $html .= '<b>Very Likely or Certain</b>';
                        }
                        $html .= '<input type="hidden" class="likelihood_rate" name="likelihood_rate_other[]" value="'.$likelihood_rate_other[$index].'" />
                    </td>
                </tr>';

                $index++;
            }
        }
    
        $html .= '<tr>
            <td>Likelihood (calculated)</td>
            <td>Very Unlikely, Unlikely, Fairly likely, Likely, Very Likely - Certain</td>
            <td></td>
            <td></td>
            <td><b>'.$result_likelihood.'</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5;">
        <tr>
            <td style="text-align: center;"><b>Assessment of the consequences of food fraud</b></td>
        </tr>
    </table>
    <p></p>
    <table class="tableQuestionaire_2" cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5;">
        <tr>
            <td style="text-align: center;"><b>Element</b></td>
            <td style="text-align: center;"><b>Question</b></td>
            <td style="text-align: center;"><b>Answer</b></td>
            <td style="text-align: center;"><b>Comments</b></td>
            <td style="text-align: center;"><b>Rate</b></td>
        </tr>';

        $index = 0;
        $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence" );
        if ( mysqli_num_rows($selectConsequence) > 0 ) {
            while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                $consequence_ID = $rowConsequence["ID"];
                $consequence_element = $rowConsequence["element"];
                $consequence_question = $rowConsequence["question"];
                $consequence_negligible = $rowConsequence["negligible"];
                $consequence_minor = $rowConsequence["minor"];
                $consequence_moderate = $rowConsequence["moderate"];
                $consequence_significant = $rowConsequence["significant"];
                $consequence_severe = $rowConsequence["severe"];

                $ref_content = '';
                $resultRef = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE type = 2 AND element = $consequence_ID" );
                if ( mysqli_num_rows($resultRef) > 0 ) {
                    $rowRef = mysqli_fetch_array($resultRef);
                    $ref_content = $rowRef["content"];
                }

                $html .= '<tr>
                    <td>'.htmlentities($consequence_element).'</td>
                    <td>'.htmlentities($consequence_question).'</td>
                    <td style="text-align: center;">';
                        if ($consequence_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td>'.$consequence_comment_arr[$index].'</td>
                    <td>';
                        if ($consequence_rate_arr[$index] == 1) {
                            $html .= '<b>Negligible</b><br><i>'.htmlentities($consequence_negligible).'</i>';
                        } else if ($consequence_rate_arr[$index] == 2) {
                            $html .= '<b>Minor</b><br><i>'.htmlentities($consequence_minor).'</i>';
                        } else if ($consequence_rate_arr[$index] == 3) {
                            $html .= '<b>Moderate</b><br><i>'.htmlentities($consequence_moderate).'</i>';
                        } else if ($consequence_rate_arr[$index] == 4) {
                            $html .= '<b>Significant</b><br><i>'.htmlentities($consequence_significant).'</i>';
                        } else if ($consequence_rate_arr[$index] == 5) {
                            $html .= '<b>Severe</b><br><i>'.htmlentities($consequence_severe).'</i>';
                        }
                        $html .= '<input type="hidden" class="consequence_rate" name="consequence_rate[]" value="'.$consequence_rate_arr[$index].'" />
                    </td>
                </tr>';

                $index++;
            }
        }

        if (!empty($row["consequence_element_other"])) {
            $consequence_element_other = explode(' | ', $row["consequence_element_other"]);
            $consequence_question_other = explode(' | ', $row["consequence_question_other"]);
            $consequence_answer_other = explode(', ', $row["consequence_answer_other"]);
            $consequence_comment_other = explode(' | ', $row["consequence_comment_other"]);
            $consequence_file_other = explode(' | ', $row["consequence_file_other"]);
            $consequence_rate_other = explode(', ', $row["consequence_rate_other"]);

            $index = 0;
            foreach ($consequence_element_other as $value) {

                echo '<tr>
                    <td>'.$value.'</td>
                    <td>'.$consequence_question_other[$index].'</td>
                    <td style="text-align: center;">';
                        if ($consequence_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td>'.$consequence_comment_other[$index].'</td>
                    <td>';
                        if ($consequence_rate_other[$index] == 1) {
                            $html .= '<b>Negligible</b>';
                        } else if ($consequence_rate_other[$index] == 2) {
                            $html .= '<b>Minor</b>';
                        } else if ($consequence_rate_other[$index] == 3) {
                            $html .= '<b>Moderate</b>';
                        } else if ($consequence_rate_other[$index] == 4) {
                            $html .= '<b>Significant</b>';
                        } else if ($consequence_rate_other[$index] == 5) {
                            $html .= '<b>Severe</b>';
                        }
                        $html .= '<input type="hidden" class="consequence_rate" name="consequence_rate_other[]" value="'.$consequence_rate_other[$index].'" />
                    </td>
                </tr>';

                $index++;
            }
        }

        $html .= '<tr>
            <td>Consequences (severity)</td>
            <td>Consequences of food fraud within supply chain for this product group</td>
            <td></td>
            <td></td>
            <td><b>'.$result_consequence.'</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td style="text-align: center;"><b>Prevention, Detection and Mitigation Activities</b></td>
        </tr>
    </table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="2"><b>Prevention and Deterrence</b></td>
        </tr>';

        $selectPrevention = mysqli_query( $conn,"SELECT * FROM tbl_ffva_prevention" );
        if ( mysqli_num_rows($selectPrevention) > 0 ) {
            while($rowPrevention = mysqli_fetch_array($selectPrevention)) {
                $prevention_ID = $rowPrevention["ID"];
                $prevention_name = $rowPrevention["name"];

                $html .= '<tr>
                    <td style="width: 5%; text-align: center;">';

                        if (!empty($row["prevention"])) {
                            $prevention_arr = explode(', ', $row["prevention"]);
        
                            if (in_array($prevention_ID, $prevention_arr)) { $html .= '✔'; }
                        }

                    $html .= '</td>
                    <td style="width: 95%;">'.$prevention_name.'</td>
                </tr>';
            }
        }

        if (!empty($row["prevention_other"])) {
            $prevention_other_arr = explode(', ', $row["prevention_other"]);
            foreach ($prevention_other_arr as $value) {
                $html .= '<tr><td>'.$value.'</td></tr>';
            }
        }
    $html .= '</table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="2"><b>Detection</b></td>
        </tr>';

        $selectDetection = mysqli_query( $conn,"SELECT * FROM tbl_ffva_detection" );
        if ( mysqli_num_rows($selectDetection) > 0 ) {
            while($rowDetection = mysqli_fetch_array($selectDetection)) {
                $detection_ID = $rowDetection["ID"];
                $detection_name = $rowDetection["name"];

                $html .= '<tr>
                    <td style="width: 5%; text-align: center;">';

                        if (!empty($row["detection"])) {
                            $detection_arr = explode(', ', $row["detection"]);
        
                            if (in_array($detection_ID, $detection_arr)) { $html .= '✔'; }
                        }

                    $html .= '</td>
                    <td style="width: 95%;">'.$detection_name.'</td>
                </tr>';
            }
        }

        if (!empty($row["detection_other"])) {
            $detection_other_arr = explode(', ', $row["detection_other"]);
            foreach ($detection_other_arr as $value) {
                $html .= '<tr><td>'.$value.'</td></tr>';
            }
        }
    $html .= '</table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="2"><b>Mitigation</b></td>
        </tr>';

        $selectMitigation = mysqli_query( $conn,"SELECT * FROM tbl_ffva_mitigation" );
        if ( mysqli_num_rows($selectMitigation) > 0 ) {
            while($rowMitigation = mysqli_fetch_array($selectMitigation)) {
                $mitigation_ID = $rowMitigation["ID"];
                $mitigation_name = $rowMitigation["name"];

                $html .= '<tr>
                    <td style="width: 5%; text-align: center;">';

                        if (!empty($row["mitigation"])) {
                            $mitigation_arr = explode(', ', $row["mitigation"]);
        
                            if (in_array($mitigation_ID, $mitigation_arr)) { $html .= '✔'; }
                        }

                    $html .= '</td>
                    <td style="width: 95%;">'.$mitigation_name.'</td>
                </tr>';
            }
        }

        if (!empty($row["mitigation_other"])) {
            $mitigation_other_arr = explode(', ', $row["mitigation_other"]);
            foreach ($mitigation_other_arr as $value) {
                $html .= '<tr><td>'.$value.'</td></tr>';
            }
        }
    $html .= '</table>
    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Prepared by</b></td>
                <td>';
                    if (!empty($prepared_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $prepared_signature) . '" height="60" border="0" /><br>'; }

                    $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$prepared_by."'" );
                    if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                        $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                        $currentEnt_userID = $rowUserEnt['ID'];
                        $currentEnt_userFName = $rowUserEnt['first_name'];
                        $currentEnt_userLName = $rowUserEnt['last_name'];

                        $html .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                    }
                $html .= '</td>
                <td>Date</td>
                <td>'.$prepared_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($prepared_position).'</td>
                <td colspan="2">'.htmlentities($enterp_name).'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Prepared by</b></td>
                <td></td>
                <td>Date</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        }
    $html .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Reviewed by</b></td>
                <td>';
                    if ($signed == 1) {
                        if (!empty($reviewed_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/png;base64,#', '', $reviewed_signature) . '" height="60" border="0" /><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$reviewed_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = $rowUserEnt['first_name'];
                            $currentEnt_userLName = $rowUserEnt['last_name'];

                            $html .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                        }
                    }
                $html .= '</td>
                <td>Date</td>
                <td>'.$reviewed_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($reviewed_position).'</td>
                <td colspan="2">'.htmlentities($reviewed_enterp_name).'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Reviewed by</b></td>
                <td></td>
                <td>Date</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        }
    $html .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Approved by</b></td>
                <td>';
                    if ($signed == 1) {
                        if (!empty($approved_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $approved_signature) . '" height="60" border="0" /><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$approved_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = $rowUserEnt['first_name'];
                            $currentEnt_userLName = $rowUserEnt['last_name'];

                            $html .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                        }
                    }
                $html .= '</td>
                <td>Date</td>
                <td>'.$approved_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($approved_position).'</td>
                <td colspan="2">'.htmlentities($approved_enterp_name).'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d;"><b>Approved by</b></td>
                <td></td>
                <td>Date</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        }
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output($row["code"].'-'.$row["company"].'-'.date('Ymd').'.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+