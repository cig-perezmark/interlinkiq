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
    if ($_POST['key'] == 'ids') {
        $i++;
        ?>
         <tr id="row_tbl_no_emp<?= $i; ?>">
            <td><input class="form-control no-border" name="emp_total[]" placeholder=""></td>
            <td><input class="form-control no-border" name="emp_usa_canada[]" placeholder=""></td>
            <td><input class="form-control no-border" name="emp_european_union[]" placeholder=""></td>
            <td><input class="form-control no-border" name="emp_rest_of_world[]" placeholder=""></td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_no_emp_row"><i class="fa fa-close"></i></button></td>
        </tr>
    <?php } else if($_POST['key'] == 'get_no_employee'){
        $select = mysqli_query( $conn,"SELECT * FROM tblEnterpise_no_employee WHERE emp_enterprise_id = $user_id" );
        foreach($select as $row){ ?>
            <tr id="row_no_emp<?=$row['no_emp_id']; ?>">
                <td><?=$row['emp_total']; ?></td>
                <td><?= $row['emp_usa_canada']; ?></td>
                <td><?= $row['emp_european_union']; ?></td>
                <td><?= $row['emp_rest_of_world']; ?></td>
                <td>
                    <div class="btn-group btn-group-circle">
                        <a  href="#modal_update_no_emp" data-toggle="modal" type="button" id="update_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
	                    <a href="#modal_delete_no_emp" data-toggle="modal" type="button" id="delete_emp" data-id="<?= $row['no_emp_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                    </div>
                </td>
            </tr>
      <?php  }
     }
}
?>
