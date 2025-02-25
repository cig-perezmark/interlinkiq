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
       $response .= '
         <tr id="row_tblforeign'; $response .= $i;  $response .= '">
            <td><input class="form-control no-border" name="foreign_item[]" placeholder="Item"></td>
          <td><input class="form-control no-border"  name="foreign_estimated_gross[]" placeholder="$0.00"></td>
          <td><input class="form-control no-border" placeholder="$0.00" name="foreign_projected_gross[]"></td>
            <td><button type="button" name="remove" id="'; $response .= $i;  $response .= '" class="btn btn-danger float-right btn_remove_foreign_row"><i class="fa fa-close"></i></button></td>
        </tr>
       ';
        }
   exit($response);
}
?>
