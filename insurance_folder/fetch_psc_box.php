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
    $i = 1;
    if ($_POST['key'] == 'ids') {
        $i++;
       ?>
         <tr id="row_tblpsc<?= $i; ?>">
            <td><input class="form-control no-border" name="product_name[]" placeholder=""></td>
            <td><input class="form-control no-border" name="total_sales[]" placeholder=""></td>
            <td><input class="form-control no-border" name="average_batch[]" placeholder=""></td>
            <td><input class="form-control no-border" name="largest_batch[]" placeholder=""></td>
            <td><input class="form-control no-border" name="daily_output[]" placeholder=""></td>
            <td><button type="button" name="remove" id="<?= $i; ?>" class="btn btn-danger float-right btn_remove_psc_row"><i class="fa fa-close"></i></button></td>
        </tr>
        <?php }
    else if($_POST['key'] == 'get_specific_coverage'){
         $query = mysqli_query($conn, "select * from tblEnterpiseDetails_product_specific_coverage where specific_coverage_enterprise_id = $user_id");
            if(mysqli_fetch_row($query)){
            foreach($query as $row){?>
                <tr id="row_by_plant<?=$row['specific_coverage_id']; ?>">
                    <td><?=$row['product_name']; ?></td>
                    <td><?= $row['total_sales']; ?></td>
                    <td><?= $row['average_batch']; ?></td>
                    <td><?=$row['largest_batch']; ?></td>
                    <td><?= $row['daily_output']; ?></td>
                    <td>
                        <div class="btn-group btn-group-circle">
                            <a  href="#modal_update_by_plant" data-toggle="modal" type="button" id="update_by_plant" data-id="<?= $row['specific_coverage_id']; ?>" class="btn btn-outline dark btn-sm">Edit</a>
    	                    <a href="#modal_delete_by_plant" data-toggle="modal" type="button" id="delete_by_plant" data-id="<?= $row['specific_coverage_id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } 
            }
    }
}
?>
