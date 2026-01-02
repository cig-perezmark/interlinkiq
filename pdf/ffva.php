<?php
	require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');
    ini_set('pcre.backtrack_limit', 1000000000000000000);
    // pcre.backtrack_limit 1,000,000
    
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
    if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
        if (round($total_likelihood) == 1 || round($total_likelihood) == 2) { $result_likelihood = "Unlikely"; }
        else if (round($total_likelihood) == 3) { $result_likelihood = "Likely"; }
        else if (round($total_likelihood) == 4 || round($total_likelihood) == 5) { $result_likelihood = "Certain"; }
    } else {
        if (round($total_likelihood) == 1) { $result_likelihood = "Very Unlikely"; }
        else if (round($total_likelihood) == 2) { $result_likelihood = "Unlikely"; }
        else if (round($total_likelihood) == 3) { $result_likelihood = "Fairly Likely"; }
        else if (round($total_likelihood) == 4) { $result_likelihood = "Likely"; }
        else if (round($total_likelihood) == 5) { $result_likelihood = "Very Likely or Certain"; }
    }


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
    if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
        if (round($total_consequence) == 1 || round($total_consequence) == 2) { $result_consequence = "Low Risk"; }
        else if (round($total_consequence) == 3) { $result_consequence = "Medium Risk"; }
        else if (round($total_consequence) == 4 || round($total_consequence) == 5) { $result_consequence = "High Risk"; }
    } else {
        if (round($total_consequence) == 1) { $result_consequence = "Negligible"; }
        else if (round($total_consequence) == 2) { $result_consequence = "Minor"; }
        else if (round($total_consequence) == 3) { $result_consequence = "Moderate"; }
        else if (round($total_consequence) == 4) { $result_consequence = "Significant"; }
        else if (round($total_consequence) == 5) { $result_consequence = "Severe"; }
    }


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
    	    <title>FFVA</title>
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
    
    <p style="color: red;">Food safety warning: adulteration or substitution of any ingredient means a risk to food safety</p>';
    
    if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
        $html .= '<table id="tableMatrix" cellpadding="7" cellspacing="0" border="0">
            <tr style="background-color: #ddeaf6; text-align: center;">
                <td rowspan="7" style="background-color: #ddeaf6;"><h3>C<br>o<br>n<br>s<br>e<br>q<br>u<br>e<br>n<br>c<br>e<br>s</h3></td>
                <td colspan="6"><h3>Likelihood</h3></td>
            </tr>
            <tr align="center" valign="middle">
                <td></td>
                <td class="text-center" style="font-weight: bold;">Unlikely</td>
                <td class="text-center" style="font-weight: bold;">Likely</td>
                <td class="text-center" style="font-weight: bold;">Certain</td>
            </tr>
            <tr>
                <td class="text-right" style="font-weight: bold; padding: 5px;">Low Risk</td>
                <td class="text-center matrix-1-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-1-3" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-1-5" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
            </tr>
            <tr>
                <td class="text-right" style="font-weight: bold; padding: 5px;">Medium Risk</td>
                <td class="text-center matrix-3-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-3-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-3-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
            </tr>
            <tr>
                <td class="text-right" style="font-weight: bold; padding: 5px;">High Risk</td>
                <td class="text-center matrix-5-1" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-5-3" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
                <td class="text-center matrix-5-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 5 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
            </tr>
        </table>';
    } else {
        $html .= '<table id="tableMatrix" cellpadding="7" cellspacing="0" border="0">
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
        </table>';
    }
    
    $html .= '<p></p>
    
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
    
    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%;">
        <tr>
            <td style="text-align: center;"><b>Materials names and/or codes included in this assessment</b></td>
        </tr>
    </table>
    
    <p style="text-align: center;"><b>Legend</b></p>';
    
    if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
        $html .= '<table cellpadding="7" cellspacing="0" border="1" style="width: 100%;" nobr="true">
            <tr style="background-color: #9cc2e5;">
                <td style="text-align: center;" colspan="3"><b>Assessment of likelihood that food fraud will affect this material</b></td>
            </tr>
            <tr style="background-color: yellow;">
                <td style="text-align: center;"><b>1 - Unlikely</b></td>
                <td style="text-align: center;"><b>2 - Likely</b></td>
                <td style="text-align: center;"><b>3 - Certain</b></td>
            </tr>
        </table>';
    } else {
        $html .= '<table cellpadding="7" cellspacing="0" border="1" style="width: 100%;" nobr="true">
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
        </table>';
    }

    $html .= '<p></p>';
    
    if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
        $html .= '<table cellpadding="7" cellspacing="0" border="1" style="width: 100%;" nobr="true">
            <tr style="background-color: #fbe4d5;">
                <td style="text-align: center;" colspan="3"><b>Assessment of the consequences of food fraud</b></td>
            </tr>
            <tr style="background-color: yellow;">
                <td style="text-align: center;"><b>1 - Low Risk</b></td>
                <td style="text-align: center;"><b>2 - Medium Risk</b></td>
                <td style="text-align: center;"><b>3 - High Risk</b></td>
            </tr>
        </table>';
    } else {
        $html .= '<table cellpadding="7" cellspacing="0" border="1" style="width: 100%;" nobr="true">
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
        </table>';
    }

    $html .= '<p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%;">
        <tr>
            <td style="text-align: center;"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
    </table>
    <p></p>
    <table class="tableQuestionaire_1" cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5; width: 100%; overflow:wrap;" nobr="true">
        <tr>
            <td style="text-align: center; width: 15%;"><b>Element</b></td>
            <td style="text-align: center; width: 35%;"><b>Question</b></td>
            <td style="text-align: center;"><b>Answer</b></td>
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
                    $likelihood_low_risk = htmlentities($rowLikelihood["low_risk"] ?? '');
                    $likelihood_medium_risk = htmlentities($rowLikelihood["medium_risk"] ?? '');
                    $likelihood_high_risk = htmlentities($rowLikelihood["high_risk"] ?? '');
                    $likelihood_guideline = '';
                    $likelihood_example = '';
                    $likelihood_reference = '';
                    $likelihood_rate_arr_val = 1;

                    if ($likelihood_user_id == 1211 AND $likelihood_type == 2) {
                        if ($likelihood_ID == 22) {
                            $likelihood_question = 'Has this ingredient previously been involved in fraud cases?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Use databases like Food Fraud Advisors (<a href="www.foodfraudadvisors.com" target="_blank">www.foodfraudadvisors.com</a>) or RASFF. Describe any prior fraud incidents.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Honey adulterated with sugar syrups in China and India.</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>EU RASFF Window (<a href="https://webgate.ec.europa.eu/rasff-window/screen/search" target="_blank">https://webgate.ec.europa.eu/rasff-window/screen/search</a>)</li><li>USFDA Import Alerts (<a href="https://www.fda.gov/industry/import-alerts/search-import-alerts" target="_blank">https://www.fda.gov/industry/import-alerts/search-import-alerts</a>)</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 23) {
                            $likelihood_question = 'Are there current alerts or recent fraud trends for this ingredient?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Monitor OPSON, RASFF, USDA, GAIN, and other alert sources for recent fraud signals or disruptions.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Ashwagandha root diluted with starch</li><li>Whey protein spiked with non-protein nitrogen</li><li>Synthetic vitamins mislabeled as natural</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>EUROPOL OPSON (<a href="https://www.europol.europa.eu/operations-services-and-innovation/operations/operation-opson" target="_blank">https://www.europol.europa.eu/operations-services-and-innovation/operations/operation-opson</a>)</li><li>USDA GAIN (<a href="https://gain.fas.usda.gov/" target="_blank">https://gain.fas.usda.gov/</a>)</li><li>EU RASFF Window (<a href="https://webgate.ec.europa.eu/rasff-window/screen/search" target="_blank">https://webgate.ec.europa.eu/rasff-window/screen/search</a>)</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 7) {
                            $likelihood_question = 'Is this material considered high-cost?';
                            $likelihood_very_unlikely = 'Less than $19';
                            $likelihood_unlikely = '$19-$374';
                            $likelihood_fairly_likely = '$375';
                            $likelihood_likely = '$376 -$750';
                            $likelihood_very_likely = 'More than $750';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Use supplier quotes or pricing databases. Higher cost materials are more vulnerable to dilution or substitution. For the Likelihood determination, enter the actual price in the comment box and determine the range it best fits in the determination column.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Astaxanthin, beta-glucan, CoQ10, L-carnitine, adaptogens</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>Company\'s own price list</li><li><a href="https://www.selinawamucii.com/insights/prices/united-states-of-america/" target="_blank">https://www.selinawamucii.com/insights/prices/united-states-of-america/</a></li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 24) {
                            $likelihood_element = 'Price Fluctuations (Over two years)';
                            $likelihood_question = 'Does the ingredient experience frequent or large price changes?';
                            $likelihood_very_unlikely = '<5% fluctuation';
                            $likelihood_unlikely = 'Fluctuates 1-2 times with 10% total chang';
                            $likelihood_fairly_likely = 'Fluctuates 2-3 times with 10-30% total change';
                            $likelihood_likely = 'Fluctuates 4+ times with >30% total change';
                            $likelihood_very_likely = '>50% change likely';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Review 24 months of supplier invoices or market reports. Spikes may indicate substitution or counterfeit risk.';
                            $likelihood_example = '<br><strong>Examples(To be included in the comment box)</strong><ul><li>Elderberry extract prices doubled during COVID-19 demand surges.</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>Tridge - Global Food Sourcing & Data Hub (<a href="https://www.tridge.com/" target="_blank">https://www.tridge.com/</a>)</li><li>FAO Food Price Index (<a href="https://www.fao.org/worldfoodsituation/foodpricesindex/en/" target="_blank">https://www.fao.org/worldfoodsituation/foodpricesindex/en/</a>)</li><li>Food Price Outlook (FPO) (<a href="https://www.ers.usda.gov/data-products/food-price-outlook/summary-findings" target="_blank">https://www.ers.usda.gov/data-products/food-price-outlook/summary-findings</a>)</li><li>Trade pricing platforms (e.g., IndexBox, Statista)</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 25) {
                            $likelihood_question = 'Is the ingredient sourced from high-risk countries or regions?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Check region via Transparency Intl CPI or import alerts. Poor regulatory oversight = higher fraud risk.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Turmeric and black pepper from India (risk of adulterants like lead chromate)</li><li>Herbal extracts from China with authenticity issues</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>Global Food Safety Security Index (<a href="http://foodsecurityindex.eiu.com/" target="_blank">http://foodsecurityindex.eiu.com/</a>)</li><li>EFSA Risk Reports</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 11) {
                            $likelihood_question = 'Are there multiple vulnerable steps in the supply chain (e.g., blending, repacking)?';
                            $likelihood_very_unlikely = 'Very limited accessibility';
                            $likelihood_unlikely = 'Limited accessibility';
                            $likelihood_fairly_likely = 'Average accessibility';
                            $likelihood_likely = 'High accessibility';
                            $likelihood_very_likely = 'Very high accessibility';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Evaluate blending, encapsulation, repacking, shipping, and 3PL storage points. More exposure = higher vulnerability. Domestic supplied materials has less points of entry for fraudulent material. Materials that are supplied overseas are more risky.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Powdered botanicals repacked by distributors</li><li>Fermented amino acids subject to cutting or substitution</li></ul>';
                            
                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example;
                        } else if ($likelihood_ID == 26) {
                            $likelihood_question = 'Are suppliers audited by your company or third parties?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Detail scope of audits (CoA checks, identity testing, mass balance, traceability). Absence of audits = increased fraud risk.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>FSSC Certififed (2023-2025) ; ISO 22000 Certified (2021-2024)</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>Audit Reports and Certificates.</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 13) {
                            $likelihood_question = 'Is this ingredient widely used or traded in high volumes globally?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Validate with trade statistics (UN Comtrade, Statista). Higher demand + limited supply = common fraud target.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Whey protein isolate—global market over $10B; vulnerable to dilution with non-protein nitrogen</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>UN Comtrade (<a href="https://comtradeplus.un.org/" target="_blank">https://comtradeplus.un.org/</a>)</li><li>Statistica</li><li><a href="https://www.grandviewresearch.com/" target="_blank">https://www.grandviewresearch.com/</a></li><li><a href="https://www.fao.org/faostat" target="_blank">https://www.fao.org/faostat</a></li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 14) {
                            $likelihood_question = 'Is the ingredient seasonal in its harvest or availability?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Check if this material is seasonal. Indicate the season. Seasonal products often face adulteration during off-season (e.g., botanical substitution or synthetic replacement).';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Ginkgo biloba leaves harvested once a year.</li><li>Saffron are harvested once a year during autumn.</li></ul>';
                            
                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example;
                        } else if ($likelihood_ID == 15) {
                            $likelihood_question = 'Is this material routinely tested for authenticity and contaminants?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>List testing type, frequency, and lab accreditation. Routine testing deters fraud.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Curcumin standardized extract tested for synthetic curcumin and lead. COA for each batch is available.</li><li>Annual testing results provided</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example;
                        } else if ($likelihood_ID == 27) {
                            $likelihood_question = 'Has the material or similar ingredients appeared on FDA Import Alert 45-02?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Check FDA Import Alert database and annotate any ingredient listings. FDA flags = increased risk.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Chili powder flagged for Sudan dyes</li><li>Spirulina with undeclared synthetic colorants</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>FDA 21 CFR Part 73/74</li><li>Import Alert #45-02</li><li>OASIS Code: UNSAFE COL</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 28) {
                            $likelihood_question = 'Is the organic certification for this ingredient verified and up-to-date?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Review documentation from certifying bodies (e.g., USDA, EU Organic). Confirm current status and expiration of the certification. Expired or unverifiable certification = increased risk.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Certificate expired in 2023 – not renewed.</li><li>Certificate is up to date (Validity: 2025-2026)</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>USDA Organic Integrity Database</li><li>National Organic Program (NOP) Guidelines</li><li>Certifier Accreditation Lists</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 29) {
                            $likelihood_question = 'Do the labels on the ingredient accurately reflect its organic status?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Compare labeling claims with certification documents. Verify if the term "organic" is appropriately used based on ingredient percentage and certification status. Mislabeling = increased risk.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Product labeled "100% Organic" but only 70% of ingredients certified.</li><li>No certifying agency listed on packaging.</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>USDA Labeling Organic Products Guide</li><li>21 CFR §205 Subpart D — Labels, Labeling, and Market Information</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        } else if ($likelihood_ID == 30) {
                            $likelihood_question = 'Are there substantial price discrepancies between organic and non-organic versions of this ingredient that might encourage fraud?';
                            $likelihood_guideline = '<br><br><strong>Answering Guidelines</strong><br>Compare market prices from verified sources. Flag if organic pricing is unusually low or if the non-organic version is being passed off as organic. Unusual price gaps = increased risk of adulteration or fraud.';
                            $likelihood_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Organic turmeric priced 60% below market average.</li><li>Organic ginger same price as conventional in bulk purchase.</li></ul>';
                            $likelihood_reference = '<strong>Regulatory References</strong><ul><li>USDA AMS Market News</li><li>Fraud Prevention Tools – National Organic Program</li><li>Industry price benchmarking reports</li></ul>';

                            $likelihood_question = $likelihood_question.$likelihood_guideline.$likelihood_example.$likelihood_reference;
                        }
                    } else if ($likelihood_user_id == 256) {
                        if ($likelihood_ID == 7) {
                            $likelihood_very_unlikely = 'Up to 5% of $34 (< $2)';
                            $likelihood_unlikely = 'In between 5%-100% of $34 ($2 to $33)';
                            $likelihood_fairly_likely = '$34';
                            $likelihood_likely = 'More than $34 ($35 to $65)';
                            $likelihood_very_likely = 'More than 200% of $34 (> $66)';
                        }
                    }

                    $ref_content = '';
                    $resultRef = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE type = 1 AND element = $likelihood_ID" );
                    if ( mysqli_num_rows($resultRef) > 0 ) {
                        $rowRef = mysqli_fetch_array($resultRef);
                        $ref_content = $rowRef["content"];
                    }

                    if (empty($likelihood_answer_arr[$index])) { $likelihood_answer_arr[$index] = 0; }
                    if (empty($likelihood_comment_arr[$index])) { $likelihood_comment_arr[$index] = ''; }
                    // if (empty($likelihood_rate_arr[$index])) { $likelihood_rate_arr[$index] = 1; }
                    if (!empty($likelihood_rate_arr[$index])) { $likelihood_rate_arr_val = $likelihood_rate_arr[$index]; }

                    $html .= '<tr>
                        <td style="width: 15%; word-break: break-word;">'.$likelihood_element.'</td>
                        <td style="width: 35%; word-break: break-word;">'.$likelihood_question.'</td>
                        <td style="width: 80px; text-align: center;">';
                            if ($likelihood_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                        $html .= '</td>
                        <td style="width: 30%; word-break: break-word;">'.html_entity_decode($likelihood_comment_arr[$index]).'</td>
                        <td style="width: 15%; word-break: break-word;">';
                        
                            if (!empty($likelihood_low_risk) AND $likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
                                if ($likelihood_rate_arr_val == 1 OR $likelihood_rate_arr_val == 2) {
                                    $html .= '<b>Unlikely</b><br><i>'.htmlspecialchars($likelihood_low_risk).'</i>';
                                } else if ($likelihood_rate_arr_val == 3) {
                                    $html .= '<b>Likely</b><br><i>'.htmlspecialchars($likelihood_medium_risk).'</i>';
                                } else if ($likelihood_rate_arr_val == 4 OR $likelihood_rate_arr_val == 5) {
                                    $html .= '<b>Certain</b><br><i>'.htmlspecialchars($likelihood_high_risk).'</i>';
                                }
                            } else {
                                if ($likelihood_rate_arr_val == 1) {
                                    $html .= '<b>Very Unlikely</b><br><i>'.htmlspecialchars($likelihood_very_unlikely).'</i>';
                                } else if ($likelihood_rate_arr_val == 2) {
                                    $html .= '<b>Unlikely</b><br><i>'.htmlspecialchars($likelihood_unlikely).'</i>';
                                } else if ($likelihood_rate_arr_val == 3) {
                                    $html .= '<b>Fairly Likely</b><br><i>'.htmlspecialchars($likelihood_fairly_likely).'</i>';
                                } else if ($likelihood_rate_arr_val == 4) {
                                    $html .= '<b>Likely</b><br><i>'.htmlspecialchars($likelihood_likely).'</i>';
                                } else if ($likelihood_rate_arr_val == 5) {
                                    $html .= '<b>Very Likely or Certain</b><br><i>'.htmlspecialchars($likelihood_very_likely).'</i>';
                                }
                            }
                            
                        $html .= '</td>
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
                $likelihood_rate_other_val = 1;
                if (!empty($likelihood_rate_other[$index])) { $likelihood_rate_other_val = $likelihood_rate_other[$index]; }

                $html .= '<tr>
                    <td style="width: 15%; word-break: break-word;">'.$value.'</td>
                    <td style="width: 35%; word-break: break-word;">'.$likelihood_question_other[$index].'</td>
                    <td style="width: 80px; text-align: center;">';
                        if ($likelihood_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td style="width: 30%; word-break: break-all;">'.html_entity_decode($likelihood_comment_other[$index]).'</td>
                    <td style="width: 15%; word-break: break-word;">';
                    
                        if (!empty($likelihood_low_risk) AND $likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
                            if ($likelihood_rate_other_val == 1 OR $likelihood_rate_other_val == 2) {
                                $html .= '<b>Unlikely</b>';
                            } else if ($likelihood_rate_other_val == 3) {
                                $html .= '<b>Likely</b>';
                            } else if ($likelihood_rate_other_val == 4 OR $likelihood_rate_other_val == 5) {
                                $html .= '<b>Certain</b>';
                            }
                        } else {
                            if ($likelihood_rate_other_val == 1) {
                                $html .= '<b>Very Unlikely</b>';
                            } else if ($likelihood_rate_other_val == 2) {
                                $html .= '<b>Unlikely</b>';
                            } else if ($likelihood_rate_other_val == 3) {
                                $html .= '<b>Fairly Likely</b>';
                            } else if ($likelihood_rate_other_val == 4) {
                                $html .= '<b>Likely</b>';
                            } else if ($likelihood_rate_other_val == 5) {
                                $html .= '<b>Very Likely or Certain</b>';
                            }
                        }
                        
                    $html .= '</td>
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
        $sql_include = '';
        if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
            $sql_include = " OR FIND_IN_SET($likelihood_user_id, REPLACE(include, ' ', '')) ";
        }
        $selectConsequence = mysqli_query( $conn,"SELECT * FROM tbl_ffva_consequence WHERE include IS NULL OR include = '' $sql_include" );
        if ( mysqli_num_rows($selectConsequence) > 0 ) {
            while($rowConsequence = mysqli_fetch_array($selectConsequence)) {
                $consequence_ID = $rowConsequence["ID"];
                $consequence_element = htmlentities($rowConsequence["element"] ?? '');
                $consequence_question = htmlentities($rowConsequence["question"] ?? '');
                $consequence_negligible = $rowConsequence["negligible"];
                $consequence_minor = $rowConsequence["minor"];
                $consequence_moderate = $rowConsequence["moderate"];
                $consequence_significant = $rowConsequence["significant"];
                $consequence_severe = $rowConsequence["severe"];
                $consequence_low_risk = htmlentities($rowConsequence["low_risk"] ?? '');
                $consequence_medium_risk = htmlentities($rowConsequence["medium_risk"] ?? '');
                $consequence_high_risk = htmlentities($rowConsequence["high_risk"] ?? '');
                $consequence_guideline = '';
                $consequence_example = '';
                $consequence_reference = '';

                if ($likelihood_user_id == 1211 AND $likelihood_type == 2) {
                    if ($consequence_ID == 2) {
                        $consequence_guideline = '<br><br><strong>Answering Guidelines</strong><br>Check for allergen-free claims or ingredient cross-contact risks. Mislabeling = major compliance and health consequences.';
                        $consequence_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Oat fiber in "gluten-free" functional bars</li><li>Soy lecithin in "soy-free" beverages</li></ul>';
                        $consequence_reference = '<strong>Regulatory References</strong><ul><li>FDA: Food Allergen Labeling and Consumer Protection Act (FALCPA)</li><li>EU Regulation 1169/2011 (Annex II – Allergen list)</li><li>Codex: CCFH Guidelines for Allergen Management (CXG 80-2020)</li></ul>';

                        $consequence_question = $consequence_question.$consequence_guideline.$consequence_example.$consequence_reference;
                    } else if ($consequence_ID == 3) {
                        $consequence_guideline = '<br><br><strong>Answering Guidelines</strong><br>Evaluate impact on brand trust, regulatory status, export bans, contracts, recalls, or litigation. High-impact products = higher consequence risk.';
                        $consequence_example = '<br><br><strong>Examples(To be included in the comment box)</strong><ul><li>Omega-3 capsules with substituted fish oil: may result in consumer loss, lawsuits, or import bans.</li><li>Mislabeled gluten-free flour containing wheat: poses allergen risk and may result in costly recalls.</li><li>Imported turmeric contaminated with lead chromate: potential for class-action lawsuits and national bans.</li></ul>';
                        
                        $consequence_question = $consequence_question.$consequence_guideline.$consequence_example;
                    }
                }

                $ref_content = '';
                $resultRef = mysqli_query( $conn,"SELECT * FROM tbl_ffva_reference WHERE type = 2 AND element = $consequence_ID" );
                if ( mysqli_num_rows($resultRef) > 0 ) {
                    $rowRef = mysqli_fetch_array($resultRef);
                    $ref_content = $rowRef["content"];
                }
                
                $consequence_rate_arr_val = 1;
                if (!empty($consequence_rate_arr[$index])) { $consequence_rate_arr_val = $consequence_rate_arr[$index]; }

                $html .= '<tr>
                    <td>'.$consequence_element.'</td>
                    <td>'.$consequence_question.'</td>
                    <td style="text-align: center;">';
                        if ($consequence_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td>'.html_entity_decode($consequence_comment_arr[$index]).'</td>
                    <td>';
                        
                        if (!empty($consequence_low_risk) AND $likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
                            if ($consequence_rate_arr_val == 1 OR $consequence_rate_arr_val == 2) {
                                $html .= '<b>Low Risk</b><br><i>'.htmlspecialchars($consequence_low_risk).'</i>';
                            } else if ($consequence_rate_arr_val == 3) {
                                $html .= '<b>Medium Risk</b><br><i>'.htmlspecialchars($consequence_medium_risk).'</i>';
                            } else if ($consequence_rate_arr_val == 4 OR $consequence_rate_arr_val == 5) {
                                $html .= '<b>High Risk</b><br><i>'.htmlspecialchars($consequence_high_risk).'</i>';
                            }
                        } else {
                            if ($consequence_rate_arr_val == 1) {
                                $html .= '<b>Negligible</b><br><i>'.htmlentities($consequence_negligible).'</i>';
                            } else if ($consequence_rate_arr_val == 2) {
                                $html .= '<b>Minor</b><br><i>'.htmlentities($consequence_minor).'</i>';
                            } else if ($consequence_rate_arr_val == 3) {
                                $html .= '<b>Moderate</b><br><i>'.htmlentities($consequence_moderate).'</i>';
                            } else if ($consequence_rate_arr_val == 4) {
                                $html .= '<b>Significant</b><br><i>'.htmlentities($consequence_significant).'</i>';
                            } else if ($consequence_rate_arr_val == 5) {
                                $html .= '<b>Severe</b><br><i>'.htmlentities($consequence_severe).'</i>';
                            }
                        }
                        
                    $html .= '</td>
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
                $consequence_rate_other_val = 1;
                if (!empty($consequence_rate_other[$index])) { $consequence_rate_other_val = $consequence_rate_other[$index]; }

                echo '<tr>
                    <td>'.$value.'</td>
                    <td>'.$consequence_question_other[$index].'</td>
                    <td style="text-align: center;">';
                        if ($consequence_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td>'.html_entity_decode($consequence_comment_other[$index]).'</td>
                    <td>';
                    
                        if (!empty($consequence_low_risk) AND $likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
                            if ($consequence_rate_other_val == 1 OR $consequence_rate_other_val == 2) {
                                $html .= '<b>Low Risk</b>';
                            } else if ($consequence_rate_other_val == 3) {
                                $html .= '<b>Medium Risk</b>';
                            } else if ($consequence_rate_other_val == 4 OR $consequence_rate_other_val == 5) {
                                $html .= '<b>High Risk</b>';
                            }
                        } else {
                            if ($consequence_rate_other_val == 1) {
                                $html .= '<b>Negligible</b>';
                            } else if ($consequence_rate_other_val == 2) {
                                $html .= '<b>Minor</b>';
                            } else if ($consequence_rate_other_val == 3) {
                                $html .= '<b>Moderate</b>';
                            } else if ($consequence_rate_other_val == 4) {
                                $html .= '<b>Significant</b>';
                            } else if ($consequence_rate_other_val == 5) {
                                $html .= '<b>Severe</b>';
                            }
                        }
                        
                    $html .= '</td>
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
            <td style="text-align: center;"><b>Prevention and Deterrence Controls</b></td>
        </tr>
    </table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
        <tr>
            <td colspan="2"><b>Prevention</b></td>
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
        
                            if (in_array($prevention_ID, $prevention_arr)) { $html .= '/'; }
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
                    <td>/</td>
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
        
                            if (in_array($detection_ID, $detection_arr)) { $html .= '/'; }
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
                    <td>/</td>
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
        
                            if (in_array($mitigation_ID, $mitigation_arr)) { $html .= '/'; }
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
                    <td>/</td>
                    <td>'.$value.'</td>
                </tr>';
            }
        }
    $html .= '</table>
    <p></p>';
    
    // if ($likelihood_type == 2 AND ($likelihood_user_id == 1 OR $likelihood_user_id == 1211)) {
    //     $html .= '<div>
    //         <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
    //             <tr>
    //                 <td colspan="2"><b>Is there an approved supplier program and verification process (e.g., COA, country of origin)?</b></td>
    //             </tr>';
        
    //             $selectActApproved = mysqli_query( $conn,"SELECT * FROM tbl_ffva_approved" );
    //             if ( mysqli_num_rows($selectActApproved) > 0 ) {
    //                 while($rowApproved = mysqli_fetch_array($selectActApproved)) {
    //                     $approved_ID = $rowApproved["ID"];
    //                     $approved_name = $rowApproved["name"];
        
    //                     $html .= '<tr>
    //                         <td style="width: 5%; text-align: center;">';
        
    //                             if (!empty($row["act_approved"])) {
    //                                 $approved_arr = explode(', ', $row["act_approved"]);
                
    //                                 if (in_array($approved_ID, $approved_arr)) { $html .= '/'; }
    //                             }
        
    //                         $html .= '</td>
    //                         <td style="width: 95%;">'.$approved_name.'</td>
    //                     </tr>';
    //                 }
    //             }
        
    //         $html .= '</table>
    //         <p></p>
    //         <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
    //             <tr>
    //                 <td colspan="2"><b>Is routine lab testing for authenticity and contaminants conducted on this material?</b></td>
    //             </tr>';
        
    //             $selectActRoutine = mysqli_query( $conn,"SELECT * FROM tbl_ffva_routine" );
    //             if ( mysqli_num_rows($selectActRoutine) > 0 ) {
    //                 while($rowRoutine = mysqli_fetch_array($selectActRoutine)) {
    //                     $routine_ID = $rowRoutine["ID"];
    //                     $routine_name = $rowRoutine["name"];
        
    //                     $html .= '<tr>
    //                         <td style="width: 5%; text-align: center;">';
        
    //                             if (!empty($row["act_routine"])) {
    //                                 $routine_arr = explode(', ', $row["act_routine"]);
                
    //                                 if (in_array($routine_ID, $routine_arr)) { $html .= '/'; }
    //                             }
        
    //                         $html .= '</td>
    //                         <td style="width: 95%;">'.$routine_name.'</td>
    //                     </tr>';
    //                 }
    //             }
        
    //         $html .= '</table>
    //         <p></p>
    //         <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d; width: 100%;">
    //             <tr>
    //                 <td colspan="2"><b>Are supplier audits conducted regularly and documented?</b></td>
    //             </tr>';
        
    //             $selectActSupplier = mysqli_query( $conn,"SELECT * FROM tbl_ffva_supplier" );
    //             if ( mysqli_num_rows($selectActSupplier) > 0 ) {
    //                 while($rowSupplier = mysqli_fetch_array($selectActSupplier)) {
    //                     $supplier_ID = $rowSupplier["ID"];
    //                     $supplier_name = $rowSupplier["name"];
        
    //                     $html .= '<tr>
    //                         <td style="width: 5%; text-align: center;">';
        
    //                             if (!empty($row["act_supplier"])) {
    //                                 $supplier_arr = explode(', ', $row["act_supplier"]);
                
    //                                 if (in_array($supplier_ID, $supplier_arr)) { $html .= '/'; }
    //                             }
        
    //                         $html .= '</td>
    //                         <td style="width: 95%;">'.$supplier_name.'</td>
    //                     </tr>';
    //                 }
    //             }
        
    //         $html .= '</table>
    //         <p></p>
    //     </div>';
    // }

    $html2 = '<table cellpadding="7" cellspacing="0" border="1" style="text-align: center; width: 100%;">';
        if ($signed == 1) {
            $html2 .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; width: 20%;"><b>Prepared by</b></td>
                <td>';
                    // if (!empty($prepared_signature)) { $html2 .= '<img src="' . preg_replace('#^data:image/[^;]+;base64,#', 'data:image/jpg;base64,', $prepared_signature) . '" height="60" border="0" /><br>'; }
                    // if (!empty($prepared_signature)) { $html2 .= '<img src="' . preg_replace('#^data:image/png;base64,#', 'data:image/jpg;base64,', $prepared_signature) . '" height="60" border="0" /><br>'; }
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
                        // if (!empty($reviewed_signature)) { $html2 .= '<img src="' . preg_replace('#^data:image/png;base64,#', 'data:image/jpg;base64,', $reviewed_signature) . '" height="60" border="0" /><br>'; }
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
                        // if (!empty($approved_signature)) { $html2 .= '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $approved_signature) . '" height="60" border="0" /><br>'; }
                        // if (!empty($approved_signature)) { $html2 .= '<img src="' . preg_replace('#^data:image/[^;]+;base64,#', 'data:image/jpg;base64,', $approved_signature) . '" height="60" border="0" /><br>'; }
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
    
    // echo $html;
    // echo $html2;
    
    $final_name = htmlentities($row["product"] ?? '');
    if ($likelihood_type == 1) { $final_name = htmlentities($row["company"] ?? ''); }
    $final_name = preg_replace('/[^A-Za-z0-9\- ]/', '', $final_name);
    
	$mpdf->WriteHTML($html);
	$mpdf->WriteHTML($html2);
	$mpdf->showImageErrors = true;
	$mpdf->Output(htmlentities($row["code"]).'-'.$final_name.'-'.$prepared_date.'.pdf', 'I');
?>