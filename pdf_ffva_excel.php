<?php
    include_once ('database_iiq.php');
    $base_url = "https://interlinkiq.com/";
    define('UPLOAD_DIR', 'uploads/ffva_sig/');
    
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
        if (!empty($prepared_signature)) {
            $img = str_replace('data:image/png;base64,', '', $prepared_signature);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $prepared_signature = UPLOAD_DIR . uniqid() . '.png';
            $success = file_put_contents($prepared_signature, $data);
        }
        
        $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $likelihood_user_id" );
        if ( mysqli_num_rows($selectEnterprise) > 0 ) {
            $rowEnterprise = mysqli_fetch_array($selectEnterprise);
            $enterp_logo = htmlentities($rowEnterprise['BrandLogos']);
        }

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $prepared_by" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $current_userFName = htmlentities($rowUser['first_name']);
            $current_userLName = htmlentities($rowUser['last_name']);
        }

        $enterp_name = "Consultare Inc. Group";
        if(!empty($prepared_by)) {
            $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $prepared_by" );
            if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                $enterp_name = htmlentities($rowEnterprise['businessname']);
            }
        }


        $reviewed_by = employerID($row["reviewed_by"]);
        $reviewed_by = $row["reviewed_by"];
        $reviewed_by_ent = $row["reviewed_by"];
        if (!empty($reviewed_by_ent)) { $reviewed_by_ent = employerID($row["reviewed_by"]); }
        $reviewed_signature = $row["reviewed_signature"];
        $reviewed_position = htmlentities($row["reviewed_position"]);
        $reviewed_date = $row["reviewed_date"];
        if (!empty($reviewed_signature)) {
            $img = str_replace('data:image/png;base64,', '', $reviewed_signature);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $reviewed_signature = UPLOAD_DIR . uniqid() . '.png';
            $success = file_put_contents($reviewed_signature, $data);
        }

        $reviewed_enterp_name = "";
        if(!empty($reviewed_by)) {
            $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $reviewed_by_ent" );
            if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                $reviewed_enterp_name = htmlentities($rowEnterprise['businessname']);
            }
        }

        $approved_by = employerID($row["approved_by"]);
        $approved_by = $row["approved_by"];
        $approved_by_ent = $row["approved_by"];
        if (!empty($approved_by_ent)) { $approved_by_ent = employerID($row["approved_by"]); }
        $approved_signature = $row["approved_signature"];
        $approved_position = htmlentities($row["approved_position"]);
        $approved_date = $row["approved_date"];
        if (!empty($approved_signature)) {
            $img = str_replace('data:image/png;base64,', '', $approved_signature);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $approved_signature = UPLOAD_DIR . uniqid() . '.png';
            $success = file_put_contents($approved_signature, $data);
        }

        $approved_enterp_name = "";
        if(!empty($approved_by)) {
            $selectEnterprise = mysqli_query( $conn,"SELECT * from tblEnterpiseDetails WHERE users_entities = $approved_by_ent" );
            if ( mysqli_num_rows($selectEnterprise) > 0 ) {
                $rowEnterprise = mysqli_fetch_array($selectEnterprise);
                $approved_enterp_name = htmlentities($rowEnterprise['businessname']);
            }
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



    $html = '
    <p style="text-align: center;">
        <img src="https://interlinkiq.com/companyDetailsFolder/'.$enterp_logo.'" onerror="this.onerror=null;this.src=\'https://placehold.co/100x100/FFF/000\'"; height="50" style="text-align: center; margin-left: auto; margin-right: auto;" /><br>';

        if ($likelihood_type == 1) { $html .= '<b>Vulnerability Assessment for Food Fraud - Supplier</b>'; }
        else { $html .= '<b>Vulnerability Assessment for Food Fraud - Ingredients</b>'; }
        
    $html .= '</p>
    <table cellpadding="7" cellspacing="0" border="1">';

        if ($likelihood_type == 1) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Supplier Company Name</b></td>
                <td colspan="5">'.htmlentities($row["company"] ?? '').'</td>
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
                <td colspan="5">'.htmlentities($row["person"] ?? '').'</td>
            </tr>';
        } else if ($likelihood_type == 2) {
            $html .= '<tr style="background-color: #e1e5ec;">
                <td colspan="2"><b>Material Name</b></td>
                <td colspan="5">'.htmlentities($row["product"] ?? '').'</td>
            </tr>';
        }
        
        $html .= '<tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Likelihood of this material being affected by food fraud</b></td>
            <td colspan="5" class="likelihood_result">'.$result_likelihood.'</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Consequences of food fraud on this material</b></td>
            <td colspan="5" class="consequence_result">'.$result_consequence.'</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #e1e5ec;"><b>Vulnerability Risk Estimate</b></td>
            <td colspan="5" class="vulnerability_result">'.$vulnerability_result.'</td>
        </tr>
    </table>
    <br>
    <p>Food safety warning: adulteration or substitution of any ingredient means a risk to food safety</p>
    
    <table id="tableMatrix" cellpadding="7" cellspacing="0" border="0">
        <tr style="background-color: #ddeaf6; text-align: center;">
            <td style="background-color: #ddeaf6;"><b>C<br>o<br>n<br>s</b></td>
            <td colspan="6"><b>Likelihood</b></td>
        </tr>
        <tr align="center" valign="middle">
            <td style="background-color: #ddeaf6; text-align: center;"><b>e<br>q<br>u</b></td>
            <td></td>
            <td class="text-center" style="font-weight: bold;">Very<br>Unlikely</td>
            <td class="text-center" style="font-weight: bold;">Unlikely</td>
            <td class="text-center" style="font-weight: bold;">Fairly<br>Likely</td>
            <td class="text-center" style="font-weight: bold;">Likely</td>
            <td class="text-center" style="font-weight: bold;">Very<br>Likely/<br>Certain</td>
        </tr>
        <tr>
            <td style="background-color: #ddeaf6; text-align: center;"><b>e</b></td>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Negligible</td>
            <td class="text-center matrix-1-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-2" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-4" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-1-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 1 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td style="background-color: #ddeaf6; text-align: center;"><b>n</b></td>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Minor</td>
            <td class="text-center matrix-2-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-2" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-4" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-2-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 2 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td style="background-color: #ddeaf6; text-align: center;"><b>c</b></td>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Moderate</td>
            <td class="text-center matrix-3-1" style="background-color: #28a745; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-2" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-3" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-4" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-3-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 3 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td style="background-color: #ddeaf6; text-align: center;"><b>e</b></td>
            <td class="text-right" style="font-weight: bold; padding: 5px;">Significant</td>
            <td class="text-center matrix-4-1" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 1) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-2" style="background-color: #ffc107; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 2) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-3" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 3) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-4" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 4) { $html .= '<b>X</b>'; } $html .= '</td>
            <td class="text-center matrix-4-5" style="background-color: #dc3545; border: 1px solid black; text-align: center;">'; if ($plot_y == 4 && $plot_x == 5) { $html .= '<b>X</b>'; } $html .= '</td>
        </tr>
        <tr>
            <td style="background-color: #ddeaf6; text-align: center;"><b>s</b></td>
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
            <td colspan="7">
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
            <td colspan="4">Product or ingredient or raw material name</td>
            <td colspan="3" style="background-color: #ffd965;">'.htmlentities($row["product"]).'</td>
        </tr>
        <tr>
            <td colspan="4">Ingredient(s) or raw material(s) group</td>
            <td colspan="3" style="background-color: #92d050;">'.htmlentities($row["assessment"]).'</td>
        </tr>
    </table>

    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Materials names and/or codes included in this assessment</b></td>
        </tr>
    </table>
    
    <p></p>
    
    <table cellpadding="7" cellspacing="0" border="0">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Legend</b></td>
        </tr>
    </table>
    
    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
        <tr style="background-color: yellow;">
            <td style="text-align: center;"><b>1 - Very Unlikely</b></td>
            <td style="text-align: center;"><b>2 - Unlikely</b></td>
            <td colspan="3" style="text-align: center;"><b>3 - Fairly Likely</b></td>
            <td style="text-align: center;"><b>4 - Likely</b></td>
            <td style="text-align: center;"><b>5 - Very Likely/Certain</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1">
        <tr style="background-color: #fbe4d5;">
            <td colspan="7" style="text-align: center;"><b>Assessment of the consequences of food fraud</b></td>
        </tr>
        <tr style="background-color: yellow;">
            <td style="text-align: center;"><b>1 - Negligible</b></td>
            <td style="text-align: center;"><b>2 - Minor</b></td>
            <td colspan="3" style="text-align: center;"><b>3 - Moderate</b></td>
            <td style="text-align: center;"><b>4 - Significant</b></td>
            <td style="text-align: center;"><b>5 - Severe</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Assessment of likelihood that food fraud will affect this material</b></td>
        </tr>
    </table>

    <p></p>

    <table class="tableQuestionaire_1" cellpadding="7" cellspacing="0" border="1" style="background-color: #9cc2e5;">
        <tr>
            <td style="text-align: center;"><b>Element</b></td>
            <td style="text-align: center;"><b>Question</b></td>
            <td style="text-align: center;"><b>Answer</b></td>
            <td colspan="3" style="text-align: center;"><b>Comments</b></td>
            <td style="text-align: center;"><b>Rate</b></td>
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
                        $ref_content = htmlentities($rowRef["content"]);
                    }

                    if (empty($likelihood_answer_arr[$index])) { $likelihood_answer_arr[$index] = 0; }
                    if (empty($likelihood_comment_arr[$index])) { $likelihood_comment_arr[$index] = ''; }
                    if (empty($likelihood_rate_arr[$index])) { $likelihood_rate_arr[$index] = 1; }

                    $html .= '<tr>
                        <td style="vertical-align: top;">'.$likelihood_element.'</td>
                        <td style="vertical-align: top;">'.$likelihood_question.'</td>
                        <td style="vertical-align: top; text-align: center;">';
                            if ($likelihood_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                        $html .= '</td>
                        <td style="vertical-align: top;" colspan="3">'.html_entity_decode($likelihood_comment_arr[$index]).'</td>
                        <td style="vertical-align: top;">';
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
                    <td style="vertical-align: top;">'.$value.'</td>
                    <td style="vertical-align: top;">'.$likelihood_question_other[$index].'</td>
                    <td style="vertical-align: top; text-align: center;">';
                        if ($likelihood_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td style="vertical-align: top;" colspan="3">'.html_entity_decode($likelihood_comment_other[$index]).'</td>
                    <td style="vertical-align: top;">';
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
            <td style="vertical-align: top;">Likelihood (calculated)</td>
            <td style="vertical-align: top;">Very Unlikely, Unlikely, Fairly likely, Likely, Very Likely - Certain</td>
            <td></td>
            <td style="vertical-align: top;" colspan="3"></td>
            <td style="vertical-align: top;"><b>'.$result_likelihood.'</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5;">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Assessment of the consequences of food fraud</b></td>
        </tr>
    </table>

    <p></p>

    <table class="tableQuestionaire_2" cellpadding="7" cellspacing="0" border="1" style="background-color: #fbe4d5;">
        <tr>
            <td style="text-align: center;"><b>Element</b></td>
            <td style="text-align: center;"><b>Question</b></td>
            <td style="text-align: center;"><b>Answer</b></td>
            <td colspan="3" style="text-align: center;"><b>Comments</b></td>
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
                    $ref_content = htmlentities($rowRef["content"]);
                }

                $html .= '<tr>
                    <td style="vertical-align: top;">'.$consequence_element.'</td>
                    <td style="vertical-align: top;">'.$consequence_question.'</td>
                    <td style="vertical-align: top; text-align: center;">';
                        if ($consequence_answer_arr[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td style="vertical-align: top;" colspan="3">'.html_entity_decode($consequence_comment_arr[$index]).'</td>
                    <td style="vertical-align: top;">';
                        if ($consequence_rate_arr[$index] == 1) {
                            $html .= '<b>Negligible</b><br><i>'.htmlspecialchars($consequence_negligible).'</i>';
                        } else if ($consequence_rate_arr[$index] == 2) {
                            $html .= '<b>Minor</b><br><i>'.htmlspecialchars($consequence_minor).'</i>';
                        } else if ($consequence_rate_arr[$index] == 3) {
                            $html .= '<b>Moderate</b><br><i>'.htmlspecialchars($consequence_moderate).'</i>';
                        } else if ($consequence_rate_arr[$index] == 4) {
                            $html .= '<b>Significant</b><br><i>'.htmlspecialchars($consequence_significant).'</i>';
                        } else if ($consequence_rate_arr[$index] == 5) {
                            $html .= '<b>Severe</b><br><i>'.htmlspecialchars($consequence_severe).'</i>';
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
                    <td style="vertical-align: top;">'.$value.'</td>
                    <td style="vertical-align: top;">'.$consequence_question_other[$index].'</td>
                    <td style="vertical-align: top; text-align: center;">';
                        if ($consequence_answer_other[$index] == 0) { $html .= 'No'; } else { $html .= 'Yes'; }
                    $html .= '</td>
                    <td style="vertical-align: top;" colspan="3">'.html_entity_decode($consequence_comment_other[$index]).'</td>
                    <td style="vertical-align: top;">';
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
            <td style="vertical-align: top;">Consequences (severity)</td>
            <td style="vertical-align: top;">Consequences of food fraud within supply chain for this product group</td>
            <td style="vertical-align: top;"></td>
            <td style="vertical-align: top;" colspan="3"></td>
            <td style="vertical-align: top;"><b>'.$result_consequence.'</b></td>
        </tr>
    </table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="7" style="text-align: center;"><b>Prevention, Detection and Mitigation Activities</b></td>
        </tr>
    </table>
    <p></p>
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="7"><b>Prevention and Deterrence</b></td>
        </tr>';

        $selectPrevention = mysqli_query( $conn,"SELECT * FROM tbl_ffva_prevention" );
        if ( mysqli_num_rows($selectPrevention) > 0 ) {
            while($rowPrevention = mysqli_fetch_array($selectPrevention)) {
                $prevention_ID = $rowPrevention["ID"];
                $prevention_name = htmlentities($rowPrevention["name"]);

                $html .= '<tr>
                    <td style="width: 5%; text-align: center;">';

                        if (!empty($row["prevention"])) {
                            $prevention_arr = explode(', ', $row["prevention"]);

                            if (in_array($prevention_ID, $prevention_arr)) { $html .= '/'; }
                        }

                    $html .= '</td>
                    <td colspan="6" style="width: 95%;">'.$prevention_name.'</td>
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
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="7"><b>Detection</b></td>
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
                    <td colspan="6" style="width: 95%;">'.$detection_name.'</td>
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
    <table cellpadding="7" cellspacing="0" border="1" style="background-color: #a8d08d;">
        <tr>
            <td colspan="7"><b>Mitigation</b></td>
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
                    <td colspan="6" style="width: 95%;">'.$mitigation_name.'</td>
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
    <p></p>

    <table id="exTable" cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: center; vertical-align: middle;"><b>Prepared by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">';
                    if (!empty($prepared_signature)) { $html .= '<img src="'.$base_url.$prepared_signature.'" onerror="this.onerror=null;this.src=\'https://placehold.co/100x100/FFF/000\'"; height="60" border="0" style="text-align: center; margin-left: auto; margin-right: auto;"/><br>'; }

                    $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$prepared_by."'" );
                    if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                        $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                        $currentEnt_userID = $rowUserEnt['ID'];
                        $currentEnt_userFName = htmlentities($rowUserEnt['first_name']);
                        $currentEnt_userLName = htmlentities($rowUserEnt['last_name']);

                        $html .= '<b>'.$currentEnt_userFName.' '.$currentEnt_userLName.'</b>';
                    }
                $html .= '</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$prepared_date.'</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$prepared_position.'</td>
                <td colspan="4" style="text-align: center; vertical-align: middle;">'.$enterp_name.'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: center; vertical-align: middle;"><b>Prepared by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="4" style="text-align: center; vertical-align: middle;"></td>
            </tr>';
        }
    $html .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: center; vertical-align: middle;"><b>Reviewed by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">';
                    if ($signed == 1) {
                        if (!empty($reviewed_signature)) { $html .= '<img src="'.$base_url.$reviewed_signature.'" onerror="this.onerror=null;this.src=\'https://placehold.co/100x100/FFF/000\'"; height="60" border="0" style="text-align: center; margin-left: auto; margin-right: auto;"/><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$reviewed_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = htmlentities($rowUserEnt['first_name']);
                            $currentEnt_userLName = htmlentities($rowUserEnt['last_name']);

                            $html .= '<b>'.$currentEnt_userFName.' '.$currentEnt_userLName.'</b>';
                        }
                    }
                $html .= '</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$reviewed_date.'</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$reviewed_position.'</td>
                <td colspan="4" style="text-align: center; vertical-align: middle;">'.$reviewed_enterp_name.'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: left; vertical-align: middle;"><b>Reviewed by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="4" style="text-align: center; vertical-align: middle;"></td>
            </tr>';
        }
    $html .= '</table>

    <p></p>

    <table cellpadding="7" cellspacing="0" border="1" style="text-align: center;">';
        if ($signed == 1) {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: center; vertical-align: middle;"><b>Approved by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">';
                    if ($signed == 1) {
                        if (!empty($approved_signature)) { $html .= '<img src="'.$base_url.$approved_signature.'" onerror="this.onerror=null;this.src=\'https://placehold.co/100x100/FFF/000\'"; height="60" border="0" style="text-align: center; margin-left: auto; margin-right: auto;"/><br>'; }

                        $selectUserEnterprise = mysqli_query( $conn,"SELECT * from tbl_user WHERE is_verified = 1 AND is_active = 1 AND ID = '".$approved_by."'" );
                        if ( mysqli_num_rows($selectUserEnterprise) > 0 ) {
                            $rowUserEnt = mysqli_fetch_array($selectUserEnterprise);
                            $currentEnt_userID = $rowUserEnt['ID'];
                            $currentEnt_userFName = htmlentities($rowUserEnt['first_name']);
                            $currentEnt_userLName = htmlentities($rowUserEnt['last_name']);

                            $html .= '<b>'.$currentEnt_userFName.' '.$currentEnt_userLName.'</b>';
                        }
                    }
                $html .= '</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$approved_date.'</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;">'.$approved_position.'</td>
                <td colspan="4" style="text-align: center; vertical-align: middle;">'.$approved_enterp_name.'</td>
            </tr>';
        } else {
            $html .= '<tr>
                <td rowspan="2" style="background-color: #a8d08d; text-align: left; vertical-align: middle;"><b>Approved by</b></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="2" style="text-align: center; vertical-align: middle;">Date</td>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: middle;"></td>
                <td colspan="4" style="text-align: center; vertical-align: middle;"></td>
            </tr>';
        } 
    $html .= '</table>';
 
    $final_name = htmlentities($row["product"] ?? '');
    if ($likelihood_type == 1) { $final_name = htmlentities($row["company"] ?? ''); }
    $final_name = preg_replace('/[^A-Za-z0-9\- ]/', '', $final_name);
    
    header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.htmlentities($row["code"]).'-'.$final_name.'-'.$prepared_date.'.xls');
	echo $html;
?>
