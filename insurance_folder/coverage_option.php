<?php 
include "../database.php";

// user identifier
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

//crm data
if(isset($_POST["key"])) {
    $i = 1;
    if ($_POST['key'] == 'ids') {
        $i++;
        ?>
        <tr>
            <tr id="row_tbl_coverage<?= $i; ?>">
                <td><input class="form-control no-border" name="options[]" placeholder=""></td>
                <td><input class="form-control no-border" name="limits[]" placeholder=""></td>
                <td><input class="form-control no-border" name="retention[]" placeholder=""></td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_coverage_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php }
    else if($_POST['key'] == 'get_coverage'){
        $query = mysqli_query( $conn,"SELECT * FROM tblEnterpise_coverage WHERE coverage_enterprise_id = $user_id" );
        foreach($query as $row){?>
            <tr id="row_coverage<?=$row['coverage_id']; ?>">
                    <td><?=$row['options']; ?></td>
                    <td><?= $row['limits']; ?></td>
                    <td><?= $row['retention']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_coverage" data-toggle="modal" type="button" id="update_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_coverage" data-toggle="modal" type="button" id="delete_coverage" data-id="<?= $row['coverage_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
     <?php    }
        
    }
}
?>
