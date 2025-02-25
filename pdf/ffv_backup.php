<?php
    // $name = 'https://interlinkiq.com/pdf/ffva_print?id=3203&signed=1';
    // //file_get_contents is standard function
    // $content = file_get_contents($name);
    // header('Content-Type: application/pdf');
    // header('Content-Length: '.strlen( $content ));
    // header('Content-disposition: inline; filename="hide.pdf"');
    // header('Cache-Control: public, must-revalidate, max-age=0');
    // header('Pragma: public');
    // header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    // header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    // echo $content;
    
    
    // $filename = './pdf/jobs/pdffile.pdf';

    // $fileinfo = pathinfo($filename);
    // $sendname = $fileinfo['filename'] . '.' . strtoupper($fileinfo['extension']);

    // header('Content-Type: application/pdf');
    // header("Content-Disposition: attachment; filename=\"$sendname\"");
    // header('Content-Length: ' . filesize($filename));
    // readfile($filename);
?>


<?php
	require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');
    
	$mpdf = new \Mpdf\Mpdf();
    $base_url = "../";
    
    
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
        $likelihood_user_id = $row["user_id"];
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

    $sql_organic = ' WHERE organic = 0 ';
    if ($likelihood_user_id == 256) { $sql_organic = ''; }
    
    $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood $sql_organic ORDER BY ordering" );
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

    $html = '<html>
    	<head>
        	<style>
            </style>
    	</head>
    	<body id="body">
    <p style="text-align: center;">
        <img src="companyDetailsFolder/'.$reviewed_enterp_logo.'" height="50" style="display: none;" /><br>';

        if ($likelihood_type == 1) { $html .= '<b>Vulnerability Assessment for Food Fraud - Supplier</b>'; }
        else { $html .= '<b>Vulnerability Assessment for Food Fraud - Ingredients</b>'; }
        
    $html .= '</p>
    <table cellpadding="7" cellspacing="0" border="1" style="width: 100%;">';

        if ($likelihood_type == 1) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Supplier Company Name</b></td>
                <td colspan="2">'.htmlentities($row["company"] ?? '').'</td>
            </tr>
            <tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Website</b></td>
                <td colspan="2"><a href="'.htmlentities($row["website"] ?? '').'" target="_blank">'.htmlentities($row["website"] ?? '').'</a></td>
            </tr>
            <tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Headquarters</b></td>
                <td colspan="2">'.htmlentities($row["headquarters"] ?? '').'</td>
            </tr>
            <tr style="background-color: #e1e5ec;">
                <td style="text-align: center;"><b>Tel. No.</b></td>
                <td style="text-align: center;"><b>Email</b></td>
                <td style="text-align: center;">T: <a href="tel:'.htmlentities($row["telephone"] ?? '').'">'.htmlentities($row["telephone"] ?? '').'</a></td>
                <td style="text-align: center;"><a href="mailto:'.htmlentities($row["email"] ?? '').'">'.htmlentities($row["email"] ?? '').'</a></td>
            </tr>
            <tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Contact Person</b></td>
                <td colspan="2">'.htmlentities($row["person"] ?? '').'</td>
            </tr>';
        } else if ($likelihood_type == 2) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Material Name</b></td>
                <td colspan="2">'.htmlentities($row["product"] ?? '').'</td>
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
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #d8d8d8; width: 100%;">
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
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%;">
        <tr>
            <td style="text-align: center;"><b>Materials names and/or codes included in this assessment</b></td>
        </tr>
    </table>

    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="width: 100%;">
        <tr>
            <td colspan="2">Product or ingredient or raw material name</td>
            <td colspan="2" style="background-color: #ffd965;">'.htmlentities($row["product"]).'</td>
        </tr>
        <tr>
            <td colspan="2">Ingredient(s) or raw material(s) group</td>
            <td colspan="2" style="background-color: #92d050;">'.htmlentities($row["assessment"]).'</td>
        </tr>
    </table>
    
    <p style="text-align: center;"><b>Legend</b></p>

    <table cellpadding="7" cellspacing="0" border="1" style="width: 100%;">
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

    <table cellpadding="7" cellspacing="0" border="1" style="width: 100%;">
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
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%;">
        <tr>
            <td style="text-align: center;"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
    </table>
    <p></p>
    <table class="tableQuestionaire_1" cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%;" nobr="true">
        <tr>
            <td style="text-align: center; width: 15%;"><b>Element</b></td>
            <td style="text-align: center; width: 35%;"><b>Question</b></td>
            <td style="text-align: center; width: 5%;"><b>Answer</b></td>
            <td style="text-align: center; width: 30%;"><b>Comments</b></td>
            <td style="text-align: center; width: 15%;"><b>Rate</b></td>
        </tr>';
        
        $index = 0;
        $selectLikelihood = mysqli_query( $conn,"SELECT * FROM tbl_ffva_likelihood $sql_organic ORDER BY ordering" );
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

                    if ($likelihood_user_id == 1211 AND $likelihood_ID == 7) {
                        $likelihood_very_unlikely = 'Up to 5% of $375';
                        $likelihood_unlikely = 'In between 5-100% of $375';
                        $likelihood_fairly_likely = '$375';
                        $likelihood_likely = 'More than $375';
                        $likelihood_very_likely = 'More than 200% of $375';
                    }

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
                        <td style="width: 15%; word-break: break-word;">'.$likelihood_element.'</td>
                        <td style="width: 35%; word-break: break-word;">'.$likelihood_question.'</td>
                        <td style="width: 5%; word-break: break-word; text-align: center;">';
                            if ($likelihood_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                        $html .= '</td>
                        <td style="width: 30%; word-break: break-word;">'.html_entity_decode($likelihood_comment_arr[$index]).'</td>
                        <td style="width: 15%; word-break: break-word;">';
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
                    <td style="width: 15%; word-break: break-word;">'.$value.'</td>
                    <td style="width: 35%; word-break: break-word;">'.$likelihood_question_other[$index].'</td>
                    <td style="width: 5%; word-break: break-word; text-align: center;">';
                        if ($likelihood_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td style="width: 30%; word-break: break-word;">'.html_entity_decode($likelihood_comment_other[$index]).'</td>
                    <td style="width: 15%; word-break: break-word;">';
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

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5; width: 100%;" nobr="true">
        <tr>
            <td style="text-align: center;"><b>Assessment of the consequences of food fraud</b></td>
        </tr>
    </table>
    <p></p>
    <table class="tableQuestionaire_2" cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5; width: 100%;">
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
                    <td>'.html_entity_decode($consequence_comment_arr[$index]).'</td>
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
                    <td>'.html_entity_decode($consequence_comment_other[$index]).'</td>
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

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
        <tr>
            <td style="text-align: center;"><b>Prevention, Detection and Mitigation Activities</b></td>
        </tr>
    </table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
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
                $html .= '<tr>
                    <td>✔</td>
                    <td>'.$value.'</td>
                </tr>';
            }
        }
    $html .= '</table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
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
                $html .= '<tr>
                    <td>✔</td>
                    <td>'.$value.'</td>
                </tr>';
            }
        }
    $html .= '</table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
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
                $html .= '<tr>
                    <td>✔</td>
                    <td>'.$value.'</td>
                </tr>';
            }
        }
    $html .= '</table>
    <p></p>';

    $html2 = '<table cellpadding="7" cellspacing="0" border="1" style="text-align: center; width: 100%;">';
        if ($signed == 1) {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Prepared by</b></td>
                <td>';
                    // if (!empty($prepared_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $prepared_signature) . '" height="60" border="0" /><br>'; }
                    if (!empty($prepared_signature)) { $html2 .= '<img src="'.$prepared_signature. '" height="60" border="0" /><br>'; }

                    $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$prepared_by."'" );
                    if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                        $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                        $currentEnt_userID = $rowUserEnt['ID'];
                        $currentEnt_userFName = $rowUserEnt['first_name'];
                        $currentEnt_userLName = $rowUserEnt['last_name'];

                        $html2 .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                    }
                $html2 .= '</td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%">'.$prepared_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($prepared_position).'</td>
                <td colspan="2">'.htmlentities($enterp_name).'</td>
            </tr>';
        } else {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Prepared by</b></td>
                <td></td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        }
    $html2 .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center; width: 100%;" nobr="true">';
        if ($signed == 1) {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Reviewed by</b></td>
                <td>';
                    if ($signed == 1) {
                        // if (!empty($reviewed_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/png;base64,#', '', $reviewed_signature) . '" height="60" border="0" /><br>'; }
                        if (!empty($reviewed_signature)) { $html2 .= '<img src="'.$reviewed_signature.'" height="60" border="0" /><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$reviewed_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = $rowUserEnt['first_name'];
                            $currentEnt_userLName = $rowUserEnt['last_name'];

                            $html2 .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                        }
                    }
                $html2 .= '</td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%">'.$reviewed_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($reviewed_position).'</td>
                <td colspan="2">'.htmlentities($reviewed_enterp_name).'</td>
            </tr>';
        } else {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Reviewed by</b></td>
                <td></td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        } 
    $html2 .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center; width: 100%;" nobr="true">';
        if ($signed == 1) {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Approved by</b></td>
                <td>';
                    if ($signed == 1) {
                        // if (!empty($approved_signature)) { $html .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $approved_signature) . '" height="60" border="0" /><br>'; }
                        if (!empty($approved_signature)) { $html2 .= '<img src="'.$approved_signature.'" height="60" border="0" /><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$approved_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = $rowUserEnt['first_name'];
                            $currentEnt_userLName = $rowUserEnt['last_name'];

                            $html2 .= '<b>'.htmlentities($currentEnt_userFName).' '.htmlentities($currentEnt_userLName).'</b>';
                        }
                    }
                $html2 .= '</td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%">'.$approved_date.'</td>
            </tr>
            <tr>
                <td>'.htmlentities($approved_position).'</td>
                <td colspan="2">'.htmlentities($approved_enterp_name).'</td>
            </tr>';
        } else {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Approved by</b></td>
                <td></td>
                <td style="width: 20%">Date</td>
                <td style="width: 20%"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"></td>
            </tr>';
        }
    $html2 .= '</table>
    	</body>
    </html>';
    
    $html3 = '<html>
        <head>
            <title>PDF</title>
        </head>
        <body>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.4/jspdf.plugin.autotable.min.js"></script>
            <script>
                // $(document).ready(function(){
                //     // jsPDF = window.jspdf.jsPDF;
                //     // var doc = new jsPDF();
                    
                //     // // Source HTMLElement or a string containing HTML.
                //     // var elementHTML = document.querySelector("#body");
                    
                //     // doc.html(elementHTML, {
                //     //     callback: function(doc) {
                //     //         // Save the PDF
                //     //         doc.save("FFVA-'.date("Y-m-d").'.pdf");
                //     //     },
                //     //     x: 10,
                //     //     y: 10,
                //     //     width: 190, //target width in the PDF document
                //     //     windowWidth: 675 //window width in CSS pixels
                //     // }); 
                    
                //     // windows.close();
                    
                //     // alert("sdsd");
                //     window.history.back();
                // });
                
                // window.onload = function() {
                //     window.close();
                // };
                
                window.open("ffva_print?id=3203&signed=1");
                window.close();
            </script>
            
            
        </body>
    </html>';
    
    
    
    // header("Content-type:application/pdf");

// It will be called downloaded.pdf
    // header("Content-Disposition:attachment;filename=\"downloaded.pdf\"");
    
    // The PDF source is in original.pdf
    // readfile($html.$html2);
    
    // echo $html;
    // echo $html2;
    // echo $html3;
    
    // $name = 'file.pdf';
    // //file_get_contents is standard function
    // $content = file_get_contents($html.$html2);
    // header('Content-Type: application/pdf');
    // // header('Content-Length: '.strlen( $content ));
    // header('Content-disposition: inline; filename="' . $name . '"');
    // header('Cache-Control: public, must-revalidate, max-age=0');
    // header('Pragma: public');
    // header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    // header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    // echo $content;

	$mpdf->WriteHTML($html);
// 	$mpdf->WriteHTML($html2);
	$mpdf->Output();
?>