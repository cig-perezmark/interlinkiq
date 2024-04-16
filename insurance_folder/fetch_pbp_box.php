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
         <tr id="row_tblpbp<?= $i; ?>">
            <td><input class="form-control no-border" name="plant_name[]" placeholder=""></td>
            <td><input class="form-control no-border" name="daily_output[]" placeholder=""></td>
            <td><input class="form-control no-border" name="daily_revenue[]" placeholder=""></td>
            <td><input class="form-control no-border" name="no_production_lines[]" placeholder=""></td>
            <td><input class="form-control no-border" name="no_of_shifts[]" placeholder=""></td>
            <td><input class="form-control no-border" name="ptc_of_total_capacity[]" placeholder=""></td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_pbp_row"><i class="fa fa-close"></i></button></td>
        </tr>
      <?php  }
      else if($_POST['key'] == 'get_by_plant'){
           $query = mysqli_query($conn, "select * from tblEnterpiseDetails_product_by_plant where by_plant_enterprise_id = $user_id");
            foreach($query as $row){?>
                <tr id="row_by_plant<?=$row['by_plant_id']; ?>">
                    <td><?=$row['plant_name']; ?></td>
                    <td><?= $row['daily_output']; ?></td>
                    <td><?= $row['daily_revenue']; ?></td>
                    <td><?=$row['no_production_lines']; ?></td>
                    <td><?= $row['no_of_shifts']; ?></td>
                    <td><?= $row['ptc_of_total_capacity']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_by_plant" data-toggle="modal" type="button" id="update_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_by_plant" data-toggle="modal" type="button" id="delete_by_plant" data-id="<?= $row['by_plant_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
     }
}
?>
