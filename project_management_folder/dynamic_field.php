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
         <tr id="row<?= $i; ?>">
            <td><textarea class="form-control border-none" name="scope_work[]"></textarea></td>
            <td><textarea class="form-control border-none" name="action_item[]"></textarea></td>
            <td>
                <select class="form-control border-none" type="text" name="assigned_to[]">
                    <option value="0">---Select---</option>
                    <?php
                        $queryApp = "SELECT * FROM tbl_hr_employee where user_id = $user_id and status = 1 order by first_name ASC";
                    $resultApp = mysqli_query($conn, $queryApp);
                    while($rowApp = mysqli_fetch_array($resultApp))
                         { 
                           echo '<option value="'.$rowApp['ID'].'">'.$rowApp['first_name'].' '.$rowApp['last_name'].'</option>'; 
                       }
                     ?>
                </select>
            </td>
            <td><input type="date" name="scope_completion_date[]" placeholder="Due Date" class="form-control border-none" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
            <td><input type="number" name="hours[]" placeholder="" class="form-control border-none" ></td>
            <td>
                <select class="form-control border-none" type="text" name="status_action[]">
                    <option value="Open">Open</option>
                    <option value="Follow Up">Follow Up</option>
                    <option value="Close">Close</option>
                </select>
            </td>
            <td>
                <button type="button" name="remove" id="<?= $i; ?>" class="btn btn-xs btn-danger btn_remove"><i class="fa fa-close"></i></button>
            </td>
        </tr>
       ';
       <?php }
}
?>
