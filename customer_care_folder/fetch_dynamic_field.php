<?php
require '../database.php';

if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = employerID($portal_user);
}
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

if(isset($_POST['key'])){
    $response = "";
    $i = 1;
    $a = 1;
    $b = 1;
    if ($_POST['key'] == 'ids') {
        $i++;
        ?>
         <tr id="row_tbl_no_emp<?= $i; ?>">
            <td><input class="form-control" type="" name="quality_member[]" ></td>
            <td>
                <input class="form-control" type="" name="qm_desc[]" >
           </td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_no_emp_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php } else if ($_POST['key'] == 'get_notify') {
        $a++;
        ?>
         <tr id="row_notify<?= $a; ?>">
            <td></td>
            <td><input class="form-control border-none" name="person_notified[]"></td>
            <td><input type="date" class="form-control border-none" name="date_notify[]"></td>
            <td><input class="form-control border-none" name="responsible_party[]"></td>
            <td><button type="button" name="remove" id="<?= $a; ?>" class="btn btn-danger float-right btn_remove_notify_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }else if ($_POST['key'] == 'get_non') {
        $b++;
        ?>
         <tr id="row_non<?= $b; ?>">
            <td></td>
            <td><input class="form-control border-none" name="non_conformance[]"></td>
            <td><input class="form-control border-none" name="responsible_party_non[]"></td>
            <td><input type="date" class="form-control border-none" name="expected_completion[]"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_non_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }else if ($_POST['key'] == 'get_capa') {
        $b++;
        ?>
         <tr id="row_capa<?= $b; ?>">
            <td></td>
            <td><textarea class="form-control border-none" name="capa_required[]" rows="3"></textarea></td>
            <td><textarea class="form-control border-none" name="capa_responsible[]" rows="3"></textarea></td>
            <td><input class="form-control border-none" name="capa_expected_completion[]" type="date"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_capa_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }
    else if ($_POST['key'] == 'get_affected') {
        $b++;
        ?>
         <tr id="row_affected<?= $b; ?>">
            <td></td>
            <td><textarea class="form-control border-none" name="list_other_products[]" rows="3"></textarea></td>
            <td><textarea class="form-control border-none" name="supplier_vendor[]" rows="3"></textarea></td>
            <td><textarea class="form-control border-none" name="plant_wide[]" rows="3"></textarea></td>
            <td><textarea class="form-control border-none" name="affected_reponsible[]" rows="3"></textarea></td>
            <td><input class="form-control border-none" name="affected_completion[]" type="date"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_affected_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }else if ($_POST['key'] == 'get_verify') {
        $b++;
        ?>
         <tr id="row_verification<?= $b; ?>">
            <td></td>
            <td><textarea class="form-control border-none" name="verification_plan[]" rows="3"></textarea></td>
            <td><textarea class="form-control border-none" name="verification_party[]" rows="3"></textarea></td>
            <td><input class="form-control border-none" name="verification_date[]" type="date"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_verification_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }
    else if ($_POST['key'] == 'get_documents') {
        $b++;
        ?>
         <tr id="row_documents<?= $b; ?>">
            <td></td>
            <td><input class="form-control border-none" name="list_document[]"></td>
            <td><input class="form-control border-none" name="list_date[]" type="date"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_documents_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }
    else if ($_POST['key'] == 'get_followup') {
        $b++;
        ?>
         <tr id="row_followup<?= $b; ?>">
            <td></td>
            <td><input class="form-control border-none" name="followup_action[]"></td>
            <td><input class="form-control border-none" name="followup_responsible[]"></td>
            <td><input class="form-control border-none" name="followup_date_performed[]" type="date"></td>
            <td><button type="button" name="remove" id="<?= $b; ?>" class="btn btn-danger float-right btn_remove_followup_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }
}
?>
